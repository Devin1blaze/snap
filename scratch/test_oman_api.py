import requests
import json

def test_location(country):
    url = "https://locatr.cloudapps.cisco.com/WWChannels/LOCATR/service/api/v1/getPfLocationSuggestion"
    payload = {
        "SEARCH_PARAM": country,
        "KEYWORD_IDS": "^136561069^",
        "LANGUAGE_CD": "EN"
    }
    response = requests.post(url, json=payload)
    print(f"Location Suggestion for {country}:")
    print(json.dumps(response.json(), indent=2))
    
    data = response.json()
    try:
        keyword_id = data.get("data", [])[0].get("doclist", [])[0].get("keyword_id")
    except Exception:
        keyword_id = None
        
    if not keyword_id:
        print("No keyword_id found.")
        return

    url2 = "https://locatr.cloudapps.cisco.com/WWChannels/LOCATR/service/api/v1/getPfPartners"
    payload2 = {
        "LOCATION_IDS": f"^{keyword_id}^",
        "LANGUAGE_CD": "EN",
        "pageSize": 10,
        "pageCount": 2,
        "SORT_BY": "partner_name.sort",
        "SORT_ORDER": "asc"
    }
    res2 = requests.post(url2, json=payload2)
    print(f"\nPartners for {country} (keyword_id: {keyword_id}):")
    print(json.dumps(res2.json(), indent=2))

if __name__ == "__main__":
    test_location("oman")
