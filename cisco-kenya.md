# Cisco Partner Scraper for Kenya (PHP)

## Task Description
Develop a PHP script to extract Cisco Partner data for Kenya from the Cisco Partner Locator API, replicating the logic of the existing Python scraper.

## Proposed Implementation

### 1. New PHP Script (`cisco_kenya.php`)
Create a self-contained PHP script that uses `curl` to interact with the Cisco API.

**Core Steps:**
- **Location Resolution:** POST to `getPfLocationSuggestion` with `SEARCH_PARAM` = "Kenya" to get the `KEYWORD_ID` and `LOCATION_KEYWORD_ID`.
- **Fetch Partners:** POST to `getPfPartners` with the resolved location ID, looping through pages until all partners are fetched.
- **Fetch Overview:** For each partner, POST to `getPartnerOverview` to retrieve website, phone, and address details.
- **Data Export:** Export the combined data to a CSV file (`Cisco_Partners_Kenya.csv`).

### 2. External Dependencies
- Use native PHP `curl` extensions. No external composer packages (like Guzzle) are strictly necessary unless preferred for code cleanliness.
- Standard PHP DOM/XML extensions might be used if HTML parsing is required, but the Cisco API returns JSON.

### 3. Open Questions for Implementation
- Should the script include the "Yahoo Search Fallback" to find missing URLs as done in the Python version?
- Does the PHP script need to integrate with the secondary "Scrapling Swarm" (`brand_scraper.py`) for deep contact extraction, or is the basic locator data sufficient?

## Verification
- Run `php cisco_kenya.php` in the terminal.
- Verify `Cisco_Partners_Kenya.csv` is created and contains correct data points.
