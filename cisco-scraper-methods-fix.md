# Restore Cisco Scraper API Interface Methods

## Goal Description
The `cisco_pipeline.py` script fails when run because `cisco_scraper.py` is missing several critical methods (e.g., `get_location_ids`, `fetch_partner_details`, `clean_and_verify_url`, `fetch_partners_list`). These methods appear to have been deleted or overwritten in a previous agent session. The objective of this plan is to restore these missing methods so that the scraper pipeline can successfully complete its execution.

## User Review Required
> [!IMPORTANT]
> Please review the proposed methods to be added back to `cisco_scraper.py`. Once you approve, I will apply these changes and we can re-run the `oman` test pipeline to verify.

## Open Questions
- Were these methods deliberately moved to a different class/file that I might have missed, or should I proceed with restoring them directly inside `CiscoPartnerScraper`?

## Proposed Changes

### Cisco Scraper Logic

#### [MODIFY] [cisco_scraper.py](file:///d:/projects/pro/scraper%20for%20data%20from%20brands%20and%20website/cisco_scraper.py)
I will add the following methods back to the `CiscoPartnerScraper` class:

1. **`get_location_ids(self, country: str) -> tuple`**
   - Calls `getPfLocationSuggestion` endpoint with `searchStr=country`.
   - Returns a tuple `(KEYWORD_ID, LOCATION_KEYWORD_ID)`.

2. **`fetch_partners_list(self, keyword_id: str) -> list`**
   - Calls `getPfPartners` endpoint using the `keywordId`.
   - Handles pagination to fetch and return a consolidated list of basic partner dictionaries.

3. **`fetch_partner_details(self, be_geo_id: str, loc_kw_id: str) -> dict`**
   - Calls `getPartnerOverview` endpoint.
   - Returns the detailed contact information for a specific partner.

4. **`clean_and_verify_url(self, website: str) -> str`**
   - Checks if a website URL is valid and reachable using a quick `HEAD` or `GET` request.

## Verification Plan

### Automated Tests
- Run `python cisco_pipeline.py oman --max 5` to ensure the pipeline executes end-to-end without any `AttributeError` or missing method issues.
- Run `python .agents/scripts/checklist.py .` to ensure no linting or syntax errors were introduced.

### Manual Verification
- Review the generated output `Cisco_Partners_oman.csv` to confirm the contact extraction and partner details are accurately pulled from the API.
