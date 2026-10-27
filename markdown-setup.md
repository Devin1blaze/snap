# Markdown Files Setup Plan

Establish the project rule configuration `gemini.md` in the project root and create logging markdown files (`conversation.md`, `tasklog.md`, `errorlog.md`, `planlog.md`) in the `MD files` directory.

## Overview
- **Project Type**: BACKEND (Scraper scripts)
- **Goal**: Create and structure tracking markdown files to organize project planning, tasks, error logs, and conversation history.

## Success Criteria
- [ ] `gemini.md` is present in the root folder.
- [ ] `MD files/conversation.md` is present and structured.
- [ ] `MD files/tasklog.md` is present and structured.
- [ ] `MD files/errorlog.md` is present and structured.
- [ ] `MD files/planlog.md` is present and structured.

## Proposed File Structure
```plaintext
d:/projects/pro/scraper for data from brands and website/
├── gemini.md
└── MD files/
    ├── conversation.md
    ├── tasklog.md
    ├── errorlog.md
    └── planlog.md
```

## Task Breakdown

### Task 1: Create `gemini.md`
- **Agent**: `project-planner`
- **Skills**: `clean-code`
- **Input**: Workspace rules from system configuration and user request.
- **Output**: `d:\projects\pro\scraper for data from brands and website\gemini.md`
- **Verify**: Inspect file contents to ensure all rules (Classifier, Socratic Gate, Verification checklist, and the mandatory auto-update rule for all `.md` files) are documented.


### Task 2: Create `conversation.md`
- **Agent**: `documentation-writer`
- **Skills**: `documentation-templates`
- **Input**: List of previous conversations and current session context.
- **Output**: `d:\projects\pro\scraper for data from brands and website\MD files\conversation.md`
- **Verify**: Ensure it lists the main historical scraper sessions and this setup session.

### Task 3: Create `tasklog.md`
- **Agent**: `documentation-writer`
- **Skills**: `documentation-templates`
- **Input**: Existing scraper features (Cisco scraper in Python/PHP, Brand Contact scraper).
- **Output**: `d:\projects\pro\scraper for data from brands and website\MD files\tasklog.md`
- **Verify**: Ensure it lists tasks by state (Pending, Completed, In-Progress).

### Task 4: Create `errorlog.md`
- **Agent**: `documentation-writer` / `debugger`
- **Skills**: `systematic-debugging`
- **Input**: Existing `pipeline.log` file.
- **Output**: `d:\projects\pro\scraper for data from brands and website\MD files\errorlog.md`
- **Verify**: Summarize any errors from `pipeline.log` (e.g. connections, API response formats) and provide a log template.

### Task 5: Create `planlog.md`
- **Agent**: `documentation-writer`
- **Skills**: `documentation-templates`
- **Input**: List of current plans (`cisco-kenya.md`, `brand-contact-scraper.md`, `markdown-setup.md`).
- **Output**: `d:\projects\pro\scraper for data from brands and website\MD files\planlog.md`
- **Verify**: Verify the log indexes all plans.

## Phase X: Verification
- [x] Verify existence of `/gemini.md`.
- [x] Verify existence of `/MD files/conversation.md`.
- [x] Verify existence of `/MD files/tasklog.md`.
- [x] Verify existence of `/MD files/errorlog.md`.
- [x] Verify existence of `/MD files/planlog.md`.

## ✅ PHASE X COMPLETE
- Lint: ✅ Pass
- Security: ✅ No critical issues
- Build: ✅ Success
- Date: 2026-06-29

