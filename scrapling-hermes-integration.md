# Plan: Replace Crawl4AI with Scrapling + Hermes/Oracle Integration

## Goals
1. **Remove Crawl4AI entirely** — no LLM, no heavy browser stack by default. All 7 scripts run on pure **Scrapling** (local, regex/CSS extraction only).
2. **Integrate the pipeline with Hermes** on the Oracle pay-as-you-go VPS with a **parameterized runtime budget** (`--time-budget <minutes>`) plus checkpoint/resume, so no run can exceed what Hermes allots (account cap: 1500 hrs/month).
3. Deliver results via **Telegram + Email**.

## Engine mapping (Crawl4AI → Scrapling)

| Current Crawl4AI use | Scrapling replacement |
|---|---|
| `AsyncWebCrawler.arun(url)` plain fetch | `scrapling.fetchers.AsyncFetcher.get()` (httpx-based, no browser) |
| `result.html` → `Adaptor(result.html)` | Fetcher response IS an Adaptor — parse directly, drop the extra step |
| `result.markdown` for regex text | `page.get_all_text()` (Scrapling built-in) |
| `js_code=` login sequences (Gojiberry scripts) | `StealthyFetcher` / `PlayWrightFetcher` with `page_action` callback (only these 3 scripts keep a browser, via Scrapling not Crawl4AI) |
| `magic=True` anti-bot | `StealthyFetcher` (camoufox) where a site actually blocks httpx |

## File changes

### Core pipeline (browserless — AsyncFetcher)
1. **[MODIFY] `cisco_scraper.py`** — drop crawl4ai import; `multi_engine_search()` fetches DuckDuckGo/Yahoo HTML endpoints with `AsyncFetcher`, parses links/text with the existing Adaptor CSS + regex logic (unchanged patterns).
2. **[MODIFY] `brand_scraper.py`** — swarm uses `AsyncFetcher` with a semaphore (configurable concurrency, default 10). Falls back to `StealthyFetcher` per-URL only when the plain fetch returns a block page (403/503/Cloudflare marker). Keeps per-row CSV append (checkpoint-friendly).
3. **[MODIFY] `search_enricher.py`** — same AsyncFetcher swap.
4. **[MODIFY] `cisco_pipeline.py`** —
   - Remove crawl4ai import + the misleading `OPENAI_API_KEY` warning (no LLM anywhere).
   - Add `--time-budget <minutes>` (optional; no default cap if omitted): a shared deadline object checked between chunks in Stage 2 and between URLs in Stage 3; on expiry, flush checkpoint (`_temp.csv`, `urls.txt`, `brand_contacts.csv`) and exit with code `2` + `RESUMABLE` marker line so Hermes knows to re-invoke with `--resume`.
   - Stage 2 checkpoints every chunk (currently only saves at the end — a killed run loses everything).
   - Replace `os.system("brand_scraper.py")` with an in-process call so the deadline propagates.
   - All file paths resolved relative to the script dir (sandbox-safe).

### Gojiberry one-offs (browser needed for login JS)
5. **[MODIFY] `scrape_app.py`** — Crawl4AI `js_code` login → Scrapling `StealthyFetcher.fetch(url, page_action=...)` performing the same fill+click, screenshot support kept.
6. **[MODIFY] `stealth_scraper.py`** — drop Crawl4AI; use Scrapling Spider with StealthyFetcher directly.
7. **[MODIFY] `ultimate_scraper.py`** — remove the `crawl4ai` engine option; `scrapling` engine becomes the default.

### Hermes integration (new files)
8. **[NEW] `hermes_cisco_tool.py`** — entry point for Hermes `execute_code`:
   - Args: `country`, `--max`, `--resume`, `--time-budget`, `--notify telegram,email`.
   - Runs the pipeline, prints ONE concise machine-readable summary line (status, rows, files, `RESUMABLE` flag) to keep LLM context small.
   - On success + `--notify`, calls the dispatcher.
9. **[NEW] `notification_sender.py`** — Telegram `sendDocument` + SMTP attachment. Credentials from env / `.env` (`TELEGRAM_BOT_TOKEN`, `TELEGRAM_CHAT_ID`, `SMTP_HOST/PORT/USER/PASS`, `MAIL_TO`) — never printed.
10. **[NEW] `requirements.txt`** — `scrapling`, `pandas`, `openpyxl`, `httpx`, `requests`, `python-dotenv` (no crawl4ai, no openai).
11. **[NEW] `deploy_to_oracle.sh`** — rsync/scp package, `uv venv` + install, `scrapling install` (camoufox browser fetch, one-time), `.env` template.

## Verification
- Local: `python cisco_pipeline.py oman --max 5 --time-budget 2` → confirm clean run, then kill-test: run with tiny budget, confirm `RESUMABLE` exit + `--resume` completes without redoing finished partners.
- `python hermes_cisco_tool.py oman --max 5` → single summary line.
- `notification_sender.py --dry-run` validates config without sending.
- Grep confirms zero `crawl4ai` references remain.

## Logging
- Update `planlog.md`, `tasklog.md`, `conversation.md` per workspace rules.
