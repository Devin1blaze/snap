# Hermes Oracle Integration Plan

This plan details the architecture and tasks required to package the Cisco Partner Scraper as a tool for the Hermes AI agent on your Oracle VPS, leveraging Hermes' native `execute_code` sandbox.

## Tool Interface: Native Python Execution

Since Hermes has a native sandboxed Python runtime and bundles `uv`, we will build a Python module that Hermes can seamlessly import or execute via `execute_code`.
- **Entry Point:** We'll create `hermes_cisco_tool.py`.
- **Output:** We'll use clear `print()` statements to relay concise status updates back to the LLM (e.g., `print("Success: Generated Cisco_Partners_Oman.xlsx")`).
- **Dependency Management:** We'll include a `requirements.txt` or a `uv` compatible script header so Hermes can auto-install `scrapling`, `playwright`, etc.

## Proposed Changes

### 1. Integration Wrapper
#### [NEW] `hermes_cisco_tool.py`
A Python script designed to be run by Hermes via its `execute_code` tool. It will:
- Accept parameters like `country_name`.
- Trigger the main `cisco_pipeline.py`.
- Collapse outputs into a single, concise `print()` statement to save LLM context tokens.

### 2. Notification Dispatcher
#### [NEW] `notification_sender.py`
A standalone module that Hermes can invoke after a successful scrape to dispatch the generated Excel file.
- **Telegram Module**: Utilizes the Telegram Bot API `sendDocument` endpoint to push the Excel file.
- **Email Module**: Utilizes `smtplib` to send the Excel file as an email attachment.

### 3. Pipeline Modifications
#### [MODIFY] `cisco_pipeline.py`
- Modify file paths to be absolute or cleanly resolved so they do not break inside Hermes' sandboxed execution environment.
- Ensure the scraper runs headlessly.
- Ensure sensitive variables (like Telegram tokens) are loaded securely and not leaked into the LLM context.

### 4. Deployment & Setup
#### [NEW] `deploy_to_oracle.sh`
A bash script to package the scraper scripts (`cisco_pipeline.py`, `hermes_cisco_tool.py`, `notification_sender.py`, etc.) and instructions for setting up the environment on the Oracle VPS so Hermes has access to them.
