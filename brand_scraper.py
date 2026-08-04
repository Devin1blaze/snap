import os
import csv
import logging
import asyncio
import re
import time
from typing import List, Optional

try:
    from scrapling.fetchers import AsyncFetcher, StealthyFetcher
except ImportError:
    print("scrapling not installed (>=0.4 required). Run: pip install -U scrapling")
    exit(1)

logging.basicConfig(level=logging.INFO, format="%(asctime)s - %(levelname)s - %(message)s")
logger = logging.getLogger(__name__)

BLOCK_MARKERS = ("cloudflare", "captcha", "access denied", "attention required")


class BrandSpider:
    def __init__(self, urls_file="urls.txt", output_file="brand_contacts.csv",
                 concurrency: int = 10, deadline: Optional[float] = None):
        self.urls_file = urls_file
        self.output_file = output_file
        self.results_data = []
        self.concurrency = concurrency
        # Absolute epoch seconds; when passed (Hermes/Oracle time budget) the swarm
        # stops launching new fetches once the deadline is reached.
        self.deadline = deadline
        self.deadline_hit = False

        self.email_pattern = re.compile(r'[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}')
        self.phone_pattern = re.compile(r'(?:(?:\+?\d{1,3}[-.\s]?)|(?:\(\d{1,4}\)[-.\s]?))?(?:\d{1,4}[-.\s]?){2,4}\d{4}')

        if not os.path.exists(self.output_file):
            with open(self.output_file, 'w', newline='', encoding='utf-8') as f:
                writer = csv.DictWriter(f, fieldnames=["url", "company_name", "emails", "phone_numbers"])
                writer.writeheader()

    def load_urls(self):
        if not os.path.exists(self.urls_file):
            return []
        with open(self.urls_file, 'r', encoding='utf-8') as f:
            return [line.strip() for line in f if line.strip() and not line.startswith('#')]

    def _expired(self) -> bool:
        if self.deadline and time.time() >= self.deadline:
            self.deadline_hit = True
            return True
        return False

    @staticmethod
    def _looks_blocked(page) -> bool:
        if page.status in (403, 429, 503):
            return True
        try:
            title = (page.css('title::text').get() or "").lower()
        except Exception:
            title = ""
        return any(m in title for m in BLOCK_MARKERS)

    async def _fetch_page(self, target_url, encoding: str = "utf-8"):
        """Plain HTTP fetch first; fall back to a stealth browser only when blocked."""
        page = await AsyncFetcher.get(
            target_url,
            impersonate="chrome",
            stealthy_headers=True,
            follow_redirects=True,
            timeout=20,
            retries=1,
            verify=False,  # brand sites often use self-signed/expired certs
            selector_config={"encoding": encoding},
        )
        if self._looks_blocked(page):
            logger.info(f"[Stealth Fallback] {target_url} looks blocked (HTTP {page.status}), retrying with StealthyFetcher")
            page = await StealthyFetcher.async_fetch(target_url, headless=True, network_idle=True)
        return page

    async def _extract_page(self, target_url):
        """Fetch + text extraction, retrying as latin-1 when the site lies about utf-8."""
        page = await self._fetch_page(target_url)
        try:
            return page, page.get_all_text()
        except UnicodeDecodeError:
            logger.info(f"[Encoding Fallback] {target_url} is not valid utf-8, refetching as ISO-8859-1")
            page = await self._fetch_page(target_url, encoding="ISO-8859-1")
            return page, page.get_all_text()

    async def fetch_url(self, sem: asyncio.Semaphore, target_url):
        async with sem:
            if self._expired():
                return
            logger.info(f"[Scrapling] Fetching: {target_url}")
            try:
                page, clean_text = await self._extract_page(target_url)

                company_name = ""
                try:
                    og_site_name = page.css('meta[property="og:site_name"]::attr(content)').get()
                    if og_site_name:
                        company_name = og_site_name
                    if not company_name:
                        title_text = page.css('title::text').get()
                        if title_text:
                            company_name = title_text.split('|')[0].split('-')[0].strip()
                except Exception as e:
                    logger.warning(f"Failed to parse title: {e}")

                emails = list(set(self.email_pattern.findall(clean_text)))
                emails = [e for e in emails if not e.lower().endswith(('.png', '.jpg', '.jpeg', '.gif', '.webp', '.css', '.js'))]

                phone_candidates = self.phone_pattern.findall(clean_text)
                valid_phones = []
                for p in phone_candidates:
                    digits = re.sub(r'\D', '', p)
                    if 8 <= len(digits) <= 15:
                        if len(digits) in (10, 13) and digits.startswith(('15', '16', '17', '18', '19')): continue
                        if digits.startswith(('202', '203')): continue
                        valid_phones.append(p.strip())
                phones = list(set(valid_phones))

                data = {
                    "url": target_url,
                    "company_name": company_name if company_name else target_url,
                    "emails": ", ".join(emails),
                    "phone_numbers": ", ".join(phones)
                }
            except Exception as e:
                logger.error(f"[Scrapling] Error fetching {target_url}: {e}")
                data = {"url": target_url, "company_name": "Failed", "emails": "", "phone_numbers": ""}

            self.results_data.append(data)

            # Append immediately so an interrupted run keeps its progress (checkpoint-friendly)
            try:
                with open(self.output_file, 'a', newline='', encoding='utf-8') as f:
                    writer = csv.DictWriter(f, fieldnames=["url", "company_name", "emails", "phone_numbers"])
                    writer.writerow(data)
            except Exception:
                pass

    async def start(self):
        urls = self.load_urls()

        scraped_urls = set()
        if os.path.exists(self.output_file):
            try:
                with open(self.output_file, 'r', encoding='utf-8') as f:
                    for row in csv.DictReader(f):
                        u = row.get("url", "")
                        if u:
                            scraped_urls.add(u.lower())
                            scraped_urls.add(u.lower().strip("/"))
            except Exception:
                pass

        sem = asyncio.Semaphore(self.concurrency)
        tasks = []
        for url in urls:
            target_url = url if url.startswith('http') else 'https://' + url
            normalized_target = target_url.lower().strip("/")
            if normalized_target in scraped_urls or target_url.lower() in scraped_urls:
                continue
            tasks.append(self.fetch_url(sem, target_url))

        if tasks:
            await asyncio.gather(*tasks)

        if self.deadline_hit:
            logger.warning("Time budget reached — swarm stopped early. Re-run to resume remaining URLs.")

    def export_csv(self):
        logger.info(f"Results written to {self.output_file}")

if __name__ == "__main__":
    spider = BrandSpider()
    asyncio.run(spider.start())
    spider.export_csv()
