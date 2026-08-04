# Integrate Crawl4AI to Scrapers

## Overview
Refactor and enhance all existing scraper scripts in the project workspace to utilize `crawl4AI` as a fetching and extraction engine. This involves replacing or augmenting the current mechanisms (`scrapling`, `selenium`, `httpx`) with `crawl4AI`.

## Project Type
BACKEND

## Success Criteria
- All identified Python scraper files import and utilize `crawl4AI`.
- The async scraping structure is properly integrated into the scripts.
- The scrapers continue to output the expected JSON/CSV formats.

## Tech Stack
- Python (`crawl4ai`, `asyncio`)

## File Structure
- `[MODIFY]` `brand_scraper.py`
- `[MODIFY]` `stealth_scraper.py`
- `[MODIFY]` `cisco_scraper.py`
- `[MODIFY]` `cisco_pipeline.py`
- `[MODIFY]` `ultimate_scraper.py`
- `[MODIFY]` `scrape_app.py`
- `[MODIFY]` `search_enricher.py`

## Task Breakdown

### Task 1: Refactor `brand_scraper.py`
- **Agent**: `backend-specialist`
- **Skills**: `python-patterns`, `clean-code`
- **Priority**: P1
- **INPUT**: `brand_scraper.py`
- **OUTPUT**: Updated `brand_scraper.py` using `crawl4AI`
- **VERIFY**: Check that the script executes without syntax errors and correctly fetches basic URLs.

### Task 2: Refactor `stealth_scraper.py` & `cisco_scraper.py`
- **Agent**: `backend-specialist`
- **Skills**: `python-patterns`
- **Priority**: P1
- **INPUT**: `stealth_scraper.py`, `cisco_scraper.py`
- **OUTPUT**: Updated scrapers using `crawl4AI`
- **VERIFY**: Check that stealth navigation is preserved if supported by Crawl4AI, and JSON structures are extracted correctly.

### Task 3: Refactor Remaining Scrapers
- **Agent**: `backend-specialist`
- **Skills**: `python-patterns`
- **Priority**: P2
- **INPUT**: `ultimate_scraper.py`, `scrape_app.py`, `search_enricher.py`
- **OUTPUT**: Updated scripts
- **VERIFY**: Check integration of Crawl4AI pipeline in all remaining files.

### Task 4: Master Verification
- **Agent**: `test-engineer`
- **Skills**: `testing-patterns`
- **Priority**: P3
- **INPUT**: All modified files
- **OUTPUT**: Verified pipeline
- **VERIFY**: `python .agents/scripts/checklist.py .` passes without critical errors.

## Phase X: Verification
- [ ] Run `python .agents/scripts/checklist.py .`
