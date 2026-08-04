"""Zambia verification script: fetches all partners from the Cisco API
and checks details for each one to verify country correctness."""

from cisco_scraper import CiscoPartnerScraper

s = CiscoPartnerScraper()

# Step 1: Resolve location
kw_id, loc_kw_id = s.get_location_ids("Zambia")
print(f"keyword_id={kw_id}, loc_kw_id={loc_kw_id}")

# Step 2: Fetch partner list
partners = s.fetch_partners_list(kw_id)
print(f"\nTotal partners from API: {len(partners)}")
print("\n--- Partner List (ASC by name from API) ---")
for i, p in enumerate(partners):
    print(f"  {i+1}. {p.get('partner_name')} | be_geo_id={p.get('be_geo_id')}")

# Step 3: For first 10 partners, fetch details and check country
print("\n--- Detail Verification (first 10) ---")
zambia_count = 0
wrong_count = 0
for i, p in enumerate(partners[:10]):
    name = p.get("partner_name")
    be_geo_id = p.get("be_geo_id")
    details = s.fetch_partner_details(be_geo_id, kw_id)

    primary_country = details.get("site_country", "UNKNOWN") if details else "NO DETAILS"
    primary_city = details.get("site_city", "") if details else ""
    primary_phone = details.get("site_phone", "") if details else ""

    # Check additionalLocations for Zambia match
    zambia_loc = None
    if details and primary_country.strip().upper() != "ZAMBIA":
        for loc in details.get("additionalLocations", []):
            if loc.get("site_country", "").strip().upper() == "ZAMBIA":
                zambia_loc = loc
                break

    if zambia_loc:
        print(f"  {i+1}. {name}")
        print(f"     PRIMARY: {primary_country} ({primary_city}) phone={primary_phone}")
        print(f"     ZAMBIA BRANCH: {zambia_loc.get('site_city')} phone={zambia_loc.get('site_phone')}")
        print(f"     -> Will use ZAMBIA branch (override)")
        zambia_count += 1
    elif primary_country.strip().upper() == "ZAMBIA":
        print(f"  {i+1}. {name}")
        print(f"     PRIMARY: ZAMBIA ({primary_city}) phone={primary_phone} ✅")
        zambia_count += 1
    else:
        print(f"  {i+1}. {name}")
        print(f"     PRIMARY: {primary_country} ({primary_city}) phone={primary_phone}")
        additional = details.get("additionalLocations", []) if details else []
        additional_countries = [l.get("site_country", "?") for l in additional]
        print(f"     additionalLocations countries: {additional_countries}")
        print(f"     ⚠️ NO ZAMBIA BRANCH FOUND")
        wrong_count += 1

print(f"\n--- Summary ---")
print(f"Zambia-matched: {zambia_count}/10")
print(f"No Zambia branch: {wrong_count}/10")
