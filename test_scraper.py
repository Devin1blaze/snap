from cisco_scraper import CiscoPartnerScraper

scraper = CiscoPartnerScraper()
print("1. get_location_ids('Oman')")
k_id, lk_id = scraper.get_location_ids("Oman")
print(f"KEYWORD_ID: {k_id}")

if k_id:
    print("\n2. fetch_partners_list")
    partners = scraper.fetch_partners_list(k_id)
    print(f"Found {len(partners)} partners.")
    
    if partners:
        print("\n3. fetch_partner_details")
        be_geo_id = partners[0].get("be_geo_id")
        details = scraper.fetch_partner_details(be_geo_id, lk_id)
        print("Details:", details)
        
        print("\n4. clean_and_verify_url")
        url = details.get("web_addr", "")
        verified = scraper.clean_and_verify_url(url)
        print("Verified URL:", verified)
