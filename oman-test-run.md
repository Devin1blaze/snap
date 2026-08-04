# Oman Scraper Test Run

## Goal Description
The objective is to execute a test run of the Cisco Partner Scraper for the country "Oman" using the newly refactored `crawl4ai` integration. This will verify that the scraping pipeline functions correctly, produces the expected output formats, and that the new integration does not introduce any regressions.

This plan follows the STRICT 2-PHASE ORCHESTRATION protocol as requested by the `/orchestrate` command.

## User Review Required
> [!IMPORTANT]
> Please review the orchestration steps and the agents assigned to this task. Once you approve this plan, I will invoke the agents to execute the test run and verify the results.

## Open Questions
- Do you want to limit the scrape to a specific number of partners (e.g., `--max 10`) for a faster test, or should we run the full scrape for Oman?
- Are there any specific data points or anomalies from previous runs you want the `test-engineer` to focus on during verification?

## Proposed Changes / Orchestration Plan

### Phase 2: Implementation (To be executed post-approval)
We will invoke the following 3 agents to handle this task:

#### 1. `backend-specialist` (Execution)
- **Task**: Run the `cisco_pipeline.py oman` command to execute the scraper pipeline.
- **Goal**: Ensure the script runs end-to-end without unhandled exceptions or permission errors.

#### 2. `test-engineer` (Data Verification)
- **Task**: Verify the generated output files (`Cisco_Partners_oman.csv` and `Cisco_Partners_oman.xlsx`).
- **Goal**: Check for data integrity, correct column formatting, and ensure contact information (emails, phones) was successfully extracted by the Scrapling/Crawl4AI swarm.

#### 3. `security-auditor` (Pipeline Validation)
- **Task**: Run the master checklist script (`$env:PYTHONUTF8=1; python .agents/scripts/checklist.py .`).
- **Goal**: Ensure no critical security, linting, or schema errors were introduced during the recent Crawl4AI refactoring.

## Verification Plan
### Automated Tests
- `python .agents/scripts/checklist.py .`

### Manual Verification
- The `test-engineer` will read the output CSV to manually confirm row counts and data completeness.
