"""
Full diagnostic: compare what Cisco API returns for Zambia
against what the website shows.
"""
import requests
import json

SUGGEST_URL = "https://locatr.cloudapps.cisco.com/WWChannels/LOCATR/service/api/v1/getPfLocationSuggestion"
PARTNERS_URL = "https://locatr.cloudapps.cisco.com/WWChannels/LOCATR/service/api/v1/getPfPartners"
OVERVIEW_URL = "https://locatr.cloudapps.cisco.com/WWChannels/LOCATR/service/api/v1/getPartnerOverview"

headers = {
    "Content-Type": "application/json",
    "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36",
    "Origin": "https://locatr.cloudapps.cisco.com",
    "Referer": "https://locatr.cloudapps.cisco.com/WWChannels/LOCATR/pf/index.jsp"
}

# ---- Step 1: Resolve Zambia location ----
print("=" * 60)
print("STEP 1: Location Resolution for 'Zambia'")
print("=" * 60)

# Test with KEYWORD_IDS="" (like test_sort.py reference)
payload_empty_kw = {
    "SEARCH_PARAM": "Zambia",
    "KEYWORD_IDS": "",
    "LANGUAGE_CD": "EN"
}
r1 = requests.post(SUGGEST_URL, json=payload_empty_kw, headers=headers)
data1 = r1.json()
doclist1 = data1.get("data", [{}])[0].get("doclist", [])
print(f"\nWith KEYWORD_IDS='' -> {len(doclist1)} suggestions:")
for d in doclist1:
    print(f"  - {d.get('keyword_display_name')} | id={d.get('keyword_id')} | category={d.get('parent_category_desc')}")

# Test with KEYWORD_IDS="^136561069^" (like current cisco_scraper.py)
payload_with_kw = {
    "SEARCH_PARAM": "Zambia",
    "KEYWORD_IDS": "^136561069^",
    "LANGUAGE_CD": "EN"
}
r2 = requests.post(SUGGEST_URL, json=payload_with_kw, headers=headers)
data2 = r2.json()
doclist2 = data2.get("data", [{}])[0].get("doclist", [])
print(f"\nWith KEYWORD_IDS='^136561069^' -> {len(doclist2)} suggestions:")
for d in doclist2:
    print(f"  - {d.get('keyword_display_name')} | id={d.get('keyword_id')} | category={d.get('parent_category_desc')}")

# Pick the Zambia country-level keyword
keyword_id = None
for doc in doclist1:
    name = (doc.get("keyword_display_name") or "").strip().upper()
    cat = doc.get("parent_category_desc", "")
    if name == "ZAMBIA" and cat == "LOCATION":
        keyword_id = doc.get("keyword_id")
        break
if not keyword_id:
    for doc in doclist2:
        name = (doc.get("keyword_display_name") or "").strip().upper()
        if name == "ZAMBIA":
            keyword_id = doc.get("keyword_id")
            break

print(f"\nSelected keyword_id for Zambia: {keyword_id}")

# ---- Step 2: Fetch partners with FULL payload (like test_sort.py) ----
print("\n" + "=" * 60)
print("STEP 2: Fetch Partners (full payload vs minimal payload)")
print("=" * 60)

# Full payload (like test_sort.py / what the website sends)
full_payload = {
    "LOCATION_IDS": keyword_id,
    "CITY_STATE_IDS": "",
    "GLOBAL_STATUS_IDS": "",
    "PORTFOLIO_IDS": "",
    "PARTNER_TYPE_IDS": "",
    "COMPETENCY_IDS": "",
    "CISCO_POWERED_SERVICE_IDS": "",
    "TECHNOLOGY_IDS": "",
    "SPECIALIZATION_IDS": "",
    "PARTNER_KEYWORD_IDS": "",
    "PARTNER_DESIGNATION_IDS": "",
    "INDUSTRY_IDS": "",
    "COMPANYSIZE_IDS": "",
    "pageSize": 50,
    "pageCount": 1,
    "SORT_BY": "partner_name.sort",
    "SORT_ORDER": "asc",
    "LANGUAGE_CD": "EN"
}
r_full = requests.post(PARTNERS_URL, json=full_payload, headers=headers)
full_data = r_full.json()
full_partners = full_data.get("data", [])
full_matches = full_data.get("matches", 0)
print(f"\nFull payload -> matches={full_matches}, page1 count={len(full_partners)}")
print("First 5 partners:")
for p in full_partners[:5]:
    print(f"  - {p.get('partner_name')} | be_geo_id={p.get('be_geo_id')} | site_name={p.get('site_name')}")

# Minimal payload (what our current cisco_scraper.py sends)
minimal_payload = {
    "LOCATION_IDS": keyword_id if "^" in str(keyword_id) else f"^{keyword_id}^",
    "LANGUAGE_CD": "EN",
    "pageCount": 1,
    "pageSize": 50,
    "SORT_BY": "partner_name.sort",
    "SORT_ORDER": "asc"
}
r_min = requests.post(PARTNERS_URL, json=minimal_payload, headers=headers)
min_data = r_min.json()
min_partners = min_data.get("data", [])
min_matches = min_data.get("matches", 0)
print(f"\nMinimal payload -> matches={min_matches}, page1 count={len(min_partners)}")
print("First 5 partners:")
for p in min_partners[:5]:
    print(f"  - {p.get('partner_name')} | be_geo_id={p.get('be_geo_id')} | site_name={p.get('site_name')}")

# ---- Step 3: Fetch details for first partner, check country ----
print("\n" + "=" * 60)
print("STEP 3: Partner Details Country Check")
print("=" * 60)

for p in full_partners[:5]:
    be_geo_id = p.get("be_geo_id")
    name = p.get("partner_name")
    payload_detail = {
        "BE_GEO_ID": str(be_geo_id),
        "LOCATION_KEYWORD_ID": str(keyword_id).replace("^", ""),
        "LANGUAGE_CD": "EN"
    }
    r_det = requests.post(OVERVIEW_URL, json=payload_detail, headers=headers)
    det_data = r_det.json().get("data", [{}])
    if det_data:
        d = det_data[0]
        site_country = d.get("site_country", "???")
        site_city = d.get("site_city", "???")
        site_phone = d.get("site_phone", "???")
        additional = d.get("additionalLocations", [])
        zambia_loc = None
        for loc in additional:
            if loc.get("site_country", "").strip().upper() == "ZAMBIA":
                zambia_loc = loc
                break
        print(f"\n  {name}")
        print(f"    HQ: {site_country}, {site_city} | phone: {site_phone}")
        print(f"    additionalLocations: {len(additional)} entries")
        if zambia_loc:
            print(f"    ZAMBIA branch: {zambia_loc.get('site_city')}, phone={zambia_loc.get('site_phone')}")
        elif site_country.strip().upper() == "ZAMBIA":
            print(f"    ✅ Already ZAMBIA in primary location")
        else:
            print(f"    ⚠️  NO Zambia branch found in additionalLocations!")
