# Error Log

Tracks errors encountered during scraping pipeline execution, along with debugging resolutions.

---

## 📊 Historical Error Summary (Parsed from `pipeline.log`)
Last Parsed: 2026-06-29

| Error Message / Category | Occurrences | Root Cause | Resolution / Workaround |
|-------------------------|-------------|------------|-------------------------|
| `ERROR: No Cloudflare challenge found.` | 47 | The scraper checked for a Cloudflare challenge to bypass, but none was present on the target page. | Informational / non-blocking for pages that do not use Cloudflare protection. |
| `Page.content: Unable to retrieve content` | 1 | Playwright failed to load or retrieve the DOM content from the target URL after 3 attempts. | Verify if the URL is active, check network stability, or adjust page timeouts. |
| `[Errno 13] Permission denied: 'Cisco_Partners_qatar.csv'` | 1 | Python scraper failed to write output because the target CSV file was locked by another process (e.g., open in Microsoft Excel). | Close the Excel/CSV file before running the pipeline scraper. |
| `PermissionError: [WinError 32] The process cannot access the file ...: 'Cisco_Partners_Saudi_Arabia.csv'` | 1 | The target output file was locked by the `EXCEL.EXE` process. | Terminated the Excel process via `taskkill /F /IM excel.exe` to release the lock and clean up checkpoints. |

---

## 📝 Error Log Template (For Future Entries)

Use the following template to document new errors as they arise:

```markdown
### [YYYY-MM-DD HH:MM:SS] - [Scraper Module]
- **Error Title**: e.g., HTTP 403 Forbidden / Rate Limit
- **Stack Trace / Log Line**:
  ```log
  [Paste log line here]
  ```
- **Context**: (Which URL, brand, or API call was being processed)
- **Status**: [Active / Resolved]
- **Resolution**: (What was done to fix or mitigate the issue)
```

### [2026-07-12 09:04:00] - [cisco_pipeline.py]
- **Error Title**: AttributeError in CiscoPartnerScraper
- **Stack Trace / Log Line**:
  `log

### [2026-07-12 09:04:00] - [cisco_pipeline.py]
- **Error Title**: AttributeError in CiscoPartnerScraper
- **Stack Trace / Log Line**:
  `log
  AttributeError: 'CiscoPartnerScraper' object has no attribute 'get_location_ids'. Did you mean: 'get_location_keywords'?
  `
- **Context**: Running cisco_pipeline.py oman --max 5
- **Status**: Active
- **Resolution**: (Pending fix for missing methods in cisco_scraper.py)

- [Resolved] AttributeError in cisco_pipeline.py due to missing methods in cisco_scraper.py. Methods restored using verified V1 API endpoints.
- [Resolved] 404 API Error on getPfLocationSuggestion: Replaced with proper /service/api/v1/ endpoints.

### [2026-07-12] - [cisco_scraper.py]
- **Error Title**: Logical Error / No Partners Found for Oman
- **Stack Trace / Log Line**:
  `[STAGE 1] Partners matched: 0`
- **Context**: Running cisco_pipeline.py for Oman yielded global partners or 0 matches depending on `LOCATION_IDS` format.
- **Status**: Resolved
- **Resolution**: Intercepted correct browser traffic and refactored payload. `LOCATION_IDS` expects `^{keyword_id}^` but the extracted `keyword_id` already contained the carets, resulting in a double-escaped string (e.g. `^^136560960^^`). Updated logic to selectively format: `keyword_id if "^" in keyword_id else f"^{keyword_id}^"`. Global `KEYWORD_IDS` was correctly removed to prevent dilution of the geographical filter. Also fixed `pageCount` pagination variable indexing.

### [2026-07-17] - [cisco_scraper.py]
- **Error Title**: Wrong-country data in Zambia scrape (data corruption)
- **Stack Trace / Log Line**:
  ```log
  Cisco_Partners_Zambia.csv rows: CAPITAL INFORMATION TECHNOLOGY SA DE CV (MEXICO),
  ASCENT TECHNOLOGY LIMITED (NEW ZEALAND), BICCAMERA INC. (JAPAN), ...
  ```
- **Context**: `Cisco_Partners_Zambia.csv` contained partners from Mexico, New Zealand, Japan, and China instead of Zambia.
- **Status**: Resolved
- **Resolution**: Root cause in `get_location_ids()`: it blindly used `doclist[0]` from `getPfLocationSuggestion`, but the doclist is NOT relevance-ranked (captured `location_response.json` shows arbitrary ordering: JERSEY, CAYMAN ISLANDS, COSTA RICA...). Whatever country happened to be first won. Fixed by exact-matching `keyword_display_name` against the requested country (with startswith/substring fallback) and logging `[+] Matched location: <NAME> (<id>)` on every run. Added a Stage 2 sanity guard in `cisco_pipeline.py` that warns loudly when <50% of fetched partner rows have `site_country` equal to the requested country. Zambia deliverable must be re-scraped.

## [2026-07-31] 500 Critical Error on Live Site
- **Error**: Live site returned 500 Critical Error after uploading ZIP.
- **Root Cause**: 
  1. Tailwind_Nav_Walker was renamed to Tailwind_Nav_Walker_V2 in class-tailwind-nav-walker.php, but header.php was still instantiating the old class name.
  2. The custom hybrid mega-menu injection loop in header.php had mismatched curly braces after function existence wrappers were improperly applied.
- **Resolution**: 
  - Restored header.php to its pristine state.
  - Reverted walker class name back to Tailwind_Nav_Walker.
  - Moved the WooCommerce category injection logic entirely into unctions.php using the safer wp_nav_menu_objects filter hook, eliminating the need to modify header.php directly.
