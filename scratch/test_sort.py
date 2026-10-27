import requests
import json

suggest_url = "https://locatr.cloudapps.cisco.com/WWChannels/LOCATR/service/api/v1/getPfLocationSuggestion"
partners_url = "https://locatr.cloudapps.cisco.com/WWChannels/LOCATR/service/api/v1/getPfPartners"

headers = {
    "Content-Type": "application/json",
    "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36",
    "Origin": "https://locatr.cloudapps.cisco.com",
    "Referer": "https://locatr.cloudapps.cisco.com/WWChannels/LOCATR/pf/index.jsp"
}

# Resolve Saudi Arabia location keyword
payload_suggest = {
    "SEARCH_PARAM": "Saudi Arabia",
    "KEYWORD_IDS": "",
    "LANGUAGE_CD": "EN"
}

r = requests.post(suggest_url, json=payload_suggest, headers=headers)
data = r.json()
doclist = data.get("data", [{}])[0].get("doclist", [])
keyword_id = None
for doc in doclist:
    if doc.get("parent_category_desc") == "LOCATION" and doc.get("keyword_display_name", "").strip().upper() == "SAUDI ARABIA":
        keyword_id = doc.get("keyword_id")
        break

if not keyword_id:
    print("Could not resolve location")
    exit(1)

print(f"Keyword ID: {keyword_id}")

def fetch_page(sort_order, page_count):
    payload = {
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
        "pageSize": 10,
        "pageCount": page_count,
        "SORT_BY": "partner_name.sort",
        "SORT_ORDER": sort_order,
        "LANGUAGE_CD": "EN"
    }
    r = requests.post(partners_url, json=payload, headers=headers)
    res = r.json()
    return [p.get("partner_name") for p in res.get("data", [])], res.get("matches", 0)

print("\n--- Testing SORT_ORDER: asc ---")
asc_page1, matches = fetch_page("asc", 1)
asc_page2, _ = fetch_page("asc", 2)
print("Total matches reported:", matches)
print("Page 1 first 5:", asc_page1[:5])
print("Page 2 first 5:", asc_page2[:5])

print("\n--- Testing SORT_ORDER: random ---")
rand_page1, _ = fetch_page("random", 1)
rand_page2, _ = fetch_page("random", 2)
print("Page 1 first 5:", rand_page1[:5])
print("Page 2 first 5:", rand_page2[:5])
