import argparse
import sys
import os
import csv
import time
import pandas as pd
import asyncio
from urllib.parse import urlparse
from cisco_scraper import CiscoPartnerScraper
from brand_scraper import BrandSpider

# Resolve all data files relative to this script so the pipeline behaves the
# same when invoked from Hermes' sandbox or a cron job on the Oracle VPS.
BASE_DIR = os.path.dirname(os.path.abspath(__file__))

EXIT_OK = 0
EXIT_ERROR = 1
EXIT_RESUMABLE = 2  # time budget hit; re-run with --resume to continue


def _path(name: str) -> str:
    return os.path.join(BASE_DIR, name)




def clean_domain(url_str):
    if not url_str:
        return "", ""
    try:
        p = urlparse(url_str)
        netloc = p.netloc.lower().replace("www.", "")
        path = p.path.lower().strip("/")
        return netloc, f"{netloc}/{path}".strip("/")
    except Exception:
        return "", ""


async def process_partner(idx, p, scraper, country, loc_kw_id):
    name = p.get("partner_name", "")
    be_geo_id = p.get("be_geo_id")
    site_name = p.get("site_name", "")

    details = scraper.fetch_partner_details(be_geo_id, loc_kw_id)

    api_phones = set()
    api_emails = set()

    if details:
        # Extract phones and emails from ALL locations (headquarters + branches)
        for loc in [details] + details.get("additionalLocations", []):
            if loc.get("site_phone"):
                api_phones.add(str(loc.get("site_phone")).strip())
            for email_key in ["email", "site_email", "contact_email"]:
                if loc.get(email_key):
                    api_emails.add(str(loc.get(email_key)).strip())

        # Fix for multi-country partners (e.g. Zambia returning Madagascar data)
        target_country = country.strip().upper()
        if details.get("site_country", "").strip().upper() != target_country:
            for loc in details.get("additionalLocations", []):
                if loc.get("site_country", "").strip().upper() == target_country:
                    details.update(loc)
                    break

    phone = ""
    website = ""
    address = ""

    if details:
        phone = details.get("site_phone", "")
        website = details.get("web_addr", "")
        addr_parts = [
            details.get("site_addr_1"), details.get("site_addr_2"),
            details.get("site_city"), details.get("site_state"), details.get("site_country")
        ]
        address = ", ".join([str(ap) for ap in addr_parts if ap])
    else:
        address = f"{site_name} {country}"

    verified_website = scraper.clean_and_verify_url(website)
    extracted_emails = []
    extracted_phones = []

    if not verified_website:
        search_res = await scraper.multi_engine_search(name)
        verified_website = search_res.get("verified_websites", [""])[0] if search_res.get("verified_websites") else ""
        extracted_emails = search_res.get("emails", [])
        extracted_phones = search_res.get("phone_numbers", [])

    print(f"[{idx+1}] Processed details for: {name} -> {verified_website or 'No URL'}")

    # Store search-engine extracted phones alongside Cisco's official phones
    all_phones = set(extracted_phones)
    all_phones.update(api_phones)
    
    all_emails = set(extracted_emails)
    all_emails.update(api_emails)

    return idx, {
        "partner_name": name,
        "site_name": site_name,
        "site_phone": phone,  # Keep the official one (from matched branch)
        "web_addr": verified_website if verified_website else "",
        "address": address,
        "search_extracted_emails": ", ".join(all_emails),
        "search_extracted_phones": ", ".join(all_phones),
        "_site_country": (details.get("site_country") or "") if details else "",
    }


def _flush_stage2_checkpoint(enriched_results, checkpoint_file):
    """Persist whatever Stage 2 has produced so far + refresh urls.txt."""
    done = [r for r in enriched_results if r is not None]
    if not done:
        return None
    df = pd.DataFrame(done)
    df.to_csv(checkpoint_file, index=False, encoding="utf-8")
    valid_urls = [r["web_addr"] for r in done if r["web_addr"]]
    with open(_path("urls.txt"), "w", encoding="utf-8") as f:
        for url in valid_urls:
            f.write(f"{url}\n")
    return df


async def run_pipeline(country, max_partners=None, resume=False, time_budget=None):
    deadline_epoch = time.time() + time_budget * 60 if time_budget else None

    print("=" * 65)
    print(f"[*] STARTING CISCO PARTNER EXTRACTION PIPELINE FOR: {country.upper()}")
    if deadline_epoch:
        print(f"[*] Time budget: {time_budget} minute(s). Pipeline checkpoints and exits when exceeded.")
    print("=" * 65)

    country_suffix = country.replace(" ", "_")
    checkpoint_file = _path(f"Cisco_Partners_{country_suffix}_temp.csv")

    df_partners = None

    if resume and os.path.exists(checkpoint_file) and os.path.exists(_path("urls.txt")):
        print(f"\n[+] Checkpoint found. Resuming using: {checkpoint_file} and urls.txt")
        try:
            df_partners = pd.read_csv(checkpoint_file)
            print(f"[+] Loaded {len(df_partners)} partners from checkpoint.")
        except Exception as e:
            print(f"[-] Error reading checkpoint file: {e}. Starting fresh.")
            df_partners = None

    if df_partners is None:
        print("\n[STAGE 1] Querying Cisco Partner Locator API...")
        scraper = CiscoPartnerScraper()
        keyword_id, loc_kw_id = scraper.get_location_ids(country)

        if not keyword_id or not loc_kw_id:
            print(f"[-] Could not resolve location keywords for: {country}. Exiting.")
            sys.exit(EXIT_ERROR)

        basic_partners = scraper.fetch_partners_list(keyword_id)
        if not basic_partners:
            print(f"[-] No partners found in country: {country}")
            sys.exit(EXIT_ERROR)

        if max_partners and len(basic_partners) > max_partners:
            print(f"[*] Limiting scraping queue to first {max_partners} partners (for testing).")
            basic_partners = basic_partners[:max_partners]

        print("\n[STAGE 2] Fetching Partner Overviews and Multi-Engine Searching...")

        enriched_results = [None] * len(basic_partners)

        # Run tasks concurrently but chunked to prevent overloading search engines
        # or the Cisco API. Coroutines are created lazily per chunk and a
        # checkpoint is flushed after EVERY chunk, so a budget-kill loses at
        # most one chunk of work.
        chunk_size = 10
        for i in range(0, len(basic_partners), chunk_size):
            if deadline_epoch and time.time() >= deadline_epoch:
                print(f"\n[!] Time budget reached during Stage 2 ({i}/{len(basic_partners)} partners done).")
                _flush_stage2_checkpoint(enriched_results, checkpoint_file)
                print("RESUMABLE: rerun with --resume to continue.")
                sys.exit(EXIT_RESUMABLE)

            chunk = [
                process_partner(idx, p, scraper, country, loc_kw_id)
                for idx, p in enumerate(basic_partners[i:i + chunk_size], start=i)
            ]
            results = await asyncio.gather(*chunk, return_exceptions=True)
            for res in results:
                if isinstance(res, Exception):
                    print(f"[-] Task failed: {res}")
                else:
                    idx, p_data = res
                    enriched_results[idx] = p_data

            _flush_stage2_checkpoint(enriched_results, checkpoint_file)

        df_partners = _flush_stage2_checkpoint(enriched_results, checkpoint_file)
        if df_partners is None:
            print("[-] Stage 2 produced no results. Exiting.")
            sys.exit(EXIT_ERROR)
        print(f"[+] Saved checkpoint ({len(df_partners)} partners) and verified domains to urls.txt")

    # Sanity guard: warn loudly when the scraped rows are not in the requested
    # country (protects against wrong location resolution, e.g. the Zambia bug).
    if "_site_country" in df_partners.columns:
        countries = df_partners["_site_country"].fillna("").str.strip().str.upper()
        known = countries[countries != ""]
        if len(known) > 0:
            matched = (known == country.strip().upper()).sum()
            if matched < len(known) / 2:
                print(f"\n[!] WARNING: only {matched}/{len(known)} results are in "
                      f"{country.upper()} — location resolution may be wrong! "
                      f"Top countries in results: {known.value_counts().head(3).to_dict()}")

    print("\n[STAGE 3] Launching Scrapling Swarm to extract Emails and Phones from Domains...")
    contacts_file = _path("brand_contacts.csv")
    if not resume and os.path.exists(contacts_file):
        try:
            os.remove(contacts_file)
        except Exception:
            pass

    # In-process so the shared deadline propagates into the swarm (brand_contacts.csv
    # appends per URL, so a budget-kill here keeps all finished URLs).
    spider = BrandSpider(urls_file=_path("urls.txt"), output_file=contacts_file,
                         deadline=deadline_epoch)
    await spider.start()

    if spider.deadline_hit:
        print("\n[!] Time budget reached during Stage 3 swarm.")
        print("RESUMABLE: rerun with --resume to continue.")
        sys.exit(EXIT_RESUMABLE)

    print("\n[STAGE 4] Merging results and exporting final deliverables...")
    contact_by_netloc = {}
    contact_by_full = {}

    if os.path.exists(contacts_file):
        try:
            with open(contacts_file, "r", encoding="utf-8") as f:
                reader = csv.DictReader(f)
                for row in reader:
                    u = row.get("url", "")
                    if u:
                        netloc, full = clean_domain(u)
                        val = {
                            "emails": row.get("emails", ""),
                            "phones": row.get("phone_numbers", "")
                        }
                        if full: contact_by_full[full] = val
                        if netloc: contact_by_netloc[netloc] = val
        except Exception as e:
            print(f"[-] Error reading swarm results: {e}")

    emails_list = []
    phones_list = []

    import httpx
    import urllib3
    urllib3.disable_warnings(urllib3.exceptions.InsecureRequestWarning)

    for _, row in df_partners.iterrows():
        w = row.get("web_addr", "")
        se_emails = row.get("search_extracted_emails", "")
        se_emails = str(se_emails) if pd.notna(se_emails) else ""
        se_phones = row.get("search_extracted_phones", "")
        se_phones = str(se_phones) if pd.notna(se_phones) else ""

        match = None
        if isinstance(w, str) and w:
            netloc, full = clean_domain(w)
            match = contact_by_full.get(full) or contact_by_netloc.get(netloc)
            if not match:
                try:
                    headers = {"User-Agent": "Mozilla/5.0"}
                    with httpx.Client(headers=headers, follow_redirects=True, verify=False, timeout=3.0) as client:
                        res = client.head(w)
                        r_netloc, r_full = clean_domain(str(res.url))
                        match = contact_by_full.get(r_full) or contact_by_netloc.get(r_netloc)
                except Exception:
                    pass

        final_emails = set(e.strip() for e in se_emails.split(",") if e.strip())
        final_phones = set(p.strip() for p in se_phones.split(",") if p.strip())

        if match:
            for e in match.get("emails", "").split(","):
                if e.strip(): final_emails.add(e.strip())
            for p in match.get("phones", "").split(","):
                if p.strip(): final_phones.add(p.strip())

        emails_list.append(", ".join(final_emails))
        phones_list.append(", ".join(final_phones))

    df_partners["extracted_emails"] = emails_list
    df_partners["extracted_phones"] = phones_list

    df_partners = df_partners[[
        "partner_name", "site_name", "site_phone", "web_addr",
        "extracted_emails", "extracted_phones", "address"
    ]]

    output_csv = _path(f"Cisco_Partners_{country_suffix}.csv")
    output_excel = _path(f"Cisco_Partners_{country_suffix}.xlsx")

    df_partners.to_csv(output_csv, index=False, encoding="utf-8")
    print(f"[+] Final CSV exported to: {output_csv}")

    try:
        df_partners.to_excel(output_excel, index=False)
        print(f"[+] Final Excel exported to: {output_excel}")
    except Exception:
        pass

if __name__ == "__main__":
    parser = argparse.ArgumentParser(description="Cisco Partner Full Pipeline Orchestrator")
    parser.add_argument("country", nargs="?", help="Country name to scrape (e.g., Andorra)")
    parser.add_argument("--max", type=int, help="Maximum number of partners to process", default=None)
    parser.add_argument("--resume", action="store_true", help="Resume from checkpoint")
    parser.add_argument("--time-budget", type=float, default=None,
                        help="Max runtime in minutes; pipeline checkpoints and exits with code 2 (RESUMABLE) when exceeded")
    args = parser.parse_args()

    if args.country:
        country = args.country
    else:
        country = input("Enter target country for Cisco Partner Locator: ").strip()

    asyncio.run(run_pipeline(country, args.max, args.resume, args.time_budget))
