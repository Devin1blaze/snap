import requests
import json

url = "https://locatr.cloudapps.cisco.com/WWChannels/LOCATR/service/api/v1/getPfPartners"

headers = {
    "Content-Type": "application/json",
    "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36",
    "Origin": "https://locatr.cloudapps.cisco.com",
    "Referer": "https://locatr.cloudapps.cisco.com/WWChannels/LOCATR/pf/index.jsp"
}

payload = {
  "LOCATION_IDS": "^136560941^",
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

try:
    r = requests.post(url, json=payload, headers=headers)
    print(f"Status Code: {r.status_code}")
    if r.status_code == 200:
        data = r.json()
        print("Success!")
        print(f"Matches count: {data.get('matches')}")
        print(f"Returned count: {len(data.get('data', []))}")
        
        # Save a sample of the response to see structure
        with open("sample_partners_qatar.json", "w") as f:
            json.dump(data, f, indent=2)
            
        if data.get('data'):
            for p in data['data'][:5]:
                print(f"Partner Name: {p.get('partner_name')} | Site ID: {p.get('site_id')}")
    else:
        print(r.text)
except Exception as e:
    print(f"Error: {e}")
