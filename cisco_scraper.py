import os
import re
import urllib.parse
from typing import Dict, Any
import requests
import asyncio
import logging

try:
    from scrapling.fetchers import AsyncFetcher
except ImportError:
    print("scrapling not installed (>=0.4 required). Run: pip install -U scrapling")
    exit(1)

logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

class CiscoPartnerScraper:
    def __init__(self):
        self.api_url = "https://locatr.cloudapps.cisco.com/WWChannels/LOCATR/pf/locatrAPI.json"

        # Regex extraction patterns
        self.email_pattern = re.compile(r'[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}')
        self.phone_pattern = re.compile(r'(?:(?:\+?\d{1,3}[-.\s]?)|(?:\(\d{1,4}\)[-.\s]?))?(?:\d{1,4}[-.\s]?){2,4}\d{4}')

    def get_location_ids(self, country: str) -> tuple:
        """Resolves country/city search into geographical keywords via Cisco V1 API.

        The suggestion doclist is NOT relevance-ranked, so we must select the
        entry whose display name actually matches the requested country instead
        of blindly taking doclist[0] (which caused wrong-country scrapes).
        """
        url = "https://locatr.cloudapps.cisco.com/WWChannels/LOCATR/service/api/v1/getPfLocationSuggestion"
        payload = {
            "SEARCH_PARAM": country,
            "KEYWORD_IDS": "^136561069^",
            "LANGUAGE_CD": "EN"
        }
        response = requests.post(url, json=payload)
        if response.status_code != 200:
            return None, None
        data = response.json()

        try:
            doclist = data.get("data", [])[0].get("doclist", [])
        except IndexError:
            return None, None

        target = country.strip().upper()
        exact, partial = None, None
        for doc in doclist:
            name = (doc.get("keyword_display_name") or "").strip().upper()
            if not name:
                continue
            if name == target:
                exact = doc
                break
            if partial is None and (name.startswith(target) or target in name):
                partial = doc

        match = exact or partial
        if match:
            keyword_id = match.get("keyword_id")
            print(f"[+] Matched location: {match.get('keyword_display_name')} ({keyword_id})")
            return keyword_id, keyword_id

        print(f"[-] No location suggestion matched '{country}'. "
              f"Candidates were: {[d.get('keyword_display_name') for d in doclist[:10]]}")
        return None, None

    def fetch_partners_list(self, keyword_id: str) -> list:
        url = "https://locatr.cloudapps.cisco.com/WWChannels/LOCATR/service/api/v1/getPfPartners"
        partners = []
        page_index = 1
        page_size = 50
        while True:
            payload = {
                "LOCATION_IDS": keyword_id if "^" in keyword_id else f"^{keyword_id}^",
                "LANGUAGE_CD": "EN",
                "pageCount": page_index,
                "pageSize": page_size,
                "SORT_BY": "partner_name.sort",
                "SORT_ORDER": "asc"
            }
            print(f"[DEBUG] getPfPartners payload: {payload}")
            response = requests.post(url, json=payload)
            if response.status_code != 200:
                break
            data = response.json().get("data", [])
            if not data:
                break
            partners.extend(data)
            if len(data) < page_size:
                break
            page_index += 1
        return partners

    def fetch_partner_details(self, be_geo_id: str, loc_kw_id: str) -> dict:
        url = "https://locatr.cloudapps.cisco.com/WWChannels/LOCATR/service/api/v1/getPartnerOverview"
        payload = {
            "BE_GEO_ID": str(be_geo_id),
            "LOCATION_KEYWORD_ID": str(loc_kw_id),
            "LANGUAGE_CD": "EN"
        }
        response = requests.post(url, json=payload)
        if response.status_code != 200:
            return {}
        data = response.json().get("data", [])
        if data:
            return data[0]
        return {}

    def clean_and_verify_url(self, website: str) -> str:
        if not website:
            return ""
        if not website.startswith("http"):
            website = "https://" + website
        try:
            res = requests.head(website, timeout=5, allow_redirects=True)
            if res.status_code < 400:
                return res.url
        except Exception:
            pass
        return website

    @staticmethod
    def _unwrap_result_link(link: str) -> str:
        """Decode DuckDuckGo/Yahoo redirect wrappers to the real target URL."""
        if not link:
            return ""
        if link.startswith("//"):
            link = "https:" + link
        try:
            parsed = urllib.parse.urlparse(link)
            if "duckduckgo.com" in parsed.netloc and parsed.path.startswith("/l/"):
                qs = urllib.parse.parse_qs(parsed.query)
                return urllib.parse.unquote(qs.get("uddg", [""])[0])
            if "r.search.yahoo.com" in parsed.netloc:
                # Yahoo wraps as /RU=<encoded>/RK=...
                m = re.search(r'/RU=([^/]+)/', link)
                if m:
                    return urllib.parse.unquote(m.group(1))
        except Exception:
            pass
        return link

    async def multi_engine_search(self, company_name: str) -> Dict[str, Any]:
        """
        Uses DuckDuckGo and Yahoo search with advanced Dorking.
        Fetches via Scrapling AsyncFetcher (no browser, no LLM) and
        parses results with CSS + Regex.
        """
        engines = [
            f"https://html.duckduckgo.com/html/?q={urllib.parse.quote(f'\"{company_name}\" \"contact us\" OR \"about us\"')}",
            f"https://search.yahoo.com/search?p={urllib.parse.quote(f'\"{company_name}\" (email OR phone OR \"@\")')}"
        ]

        emails = set()
        phones = set()
        websites = set()

        for search_url in engines:
            try:
                page = await AsyncFetcher.get(
                    search_url,
                    impersonate="chrome",
                    stealthy_headers=True,
                    follow_redirects=True,
                    timeout=20,
                )
            except Exception as e:
                logger.warning(f"Search fetch failed for {search_url}: {e}")
                continue
            if page.status != 200:
                continue

            # Extract result links directly from the fetched page (Response IS a Selector)
            links = page.css("a::attr(href)").getall()
            for link in links:
                link = self._unwrap_result_link(link)
                if link and link.startswith("http"):
                    # exclude the search engine itself and common portals
                    if not any(d in link for d in ["duckduckgo.com", "yahoo.com", "linkedin", "facebook", "twitter", "microsoft"]):
                        websites.add(link)

            # Regex extraction on the visible text
            clean_text = page.get_all_text()

            for em in self.email_pattern.findall(clean_text):
                emails.add(em)

            for p in self.phone_pattern.findall(clean_text):
                digits = re.sub(r'\D', '', p)
                if 8 <= len(digits) <= 15:
                    if len(digits) in (10, 13) and digits.startswith(('15', '16', '17', '18', '19')): continue
                    if digits.startswith(('202', '203')): continue
                    phones.add(p.strip())

        return {
            "emails": list(emails),
            "phone_numbers": list(phones),
            "verified_websites": list(websites)[:3]
        }
