---
trigger: always_on
---

# GEMINI.md - AG Kit Scraper Workspace

> This file defines how the AI behaves in this workspace.

---

## CRITICAL: AGENT & SKILL PROTOCOL (START HERE)

> **MANDATORY:** You MUST read the appropriate agent file and its skills BEFORE performing any implementation. This is the highest priority rule.

### 1. Modular Skill Loading Protocol

Agent activated → Check frontmatter "skills:" → Read SKILL.md (INDEX) → Read specific sections.

- **Selective Reading:** DO NOT read ALL files in a skill folder. Read `SKILL.md` first, then only read sections matching the user's request.
- **Rule Priority:** P0 (gemini.md) > P1 (Agent .md) > P2 (SKILL.md). All rules are binding.

### 2. Enforcement Protocol

1. **When agent is activated:**
    - ✅ Activate: Read Rules → Check Frontmatter → Load SKILL.md → Apply All.
2. **Forbidden:** Never skip reading agent rules or skill instructions. "Read → Understand → Apply" is mandatory.

---

## 📥 REQUEST CLASSIFIER (STEP 1)

**Before ANY action, classify the request:**

| Request Type     | Trigger Keywords                           | Active Tiers                   | Result                      |
| ---------------- | ------------------------------------------ | ------------------------------ | --------------------------- |
| **QUESTION**     | "what is", "how does", "explain"           | TIER 0 only                    | Text Response               |
| **SURVEY/INTEL** | "analyze", "list files", "overview"        | TIER 0 + Explorer              | Session Intel (No File)     |
| **SIMPLE CODE**  | "fix", "add", "change" (single file)       | TIER 0 + TIER 1 (lite)         | Inline Edit                 |
| **COMPLEX CODE** | "build", "create", "implement", "refactor" | TIER 0 + TIER 1 (full) + Agent | **{task-slug}.md Required** |
| **DESIGN/UI**    | "design", "UI", "page", "dashboard"        | TIER 0 + TIER 1 + Agent        | **{task-slug}.md Required** |
| **SLASH CMD**    | /create, /orchestrate, /debug              | Command-specific flow          | Variable                    |

---

## 🤖 INTELLIGENT AGENT ROUTING (STEP 2 - AUTO)

**ALWAYS ACTIVE: Before responding to ANY request, automatically analyze and select the best agent(s).**

### Auto-Selection Protocol

1. **Analyze (Silent)**: Detect domains (Frontend, Backend, Security, etc.) from user request.
2. **Select Agent(s)**: Choose the most appropriate specialist(s).
3. **Inform User**: Concisely state which expertise is being applied.
4. **Apply**: Generate response using the selected agent's persona and rules.

### Response Format (MANDATORY)

When auto-applying an agent, inform the user:

```markdown
🤖 **Applying knowledge of `@[agent-name]`...**

[Continue with specialized response]
```

### ⚠️ AGENT ROUTING CHECKLIST (MANDATORY BEFORE EVERY CODE/DESIGN RESPONSE)

**Before ANY code or design work, you MUST complete this checklist:**

| Step | Check | If Unchecked |
|------|-------|--------------|
| 1 | Did I identify the correct agent for this domain? | → STOP. Analyze request domain first. |
| 2 | Did I READ the agent's `.md` file (or recall its rules)? | → STOP. Open `.agents/agent/{agent}.md` |
| 3 | Did I announce `🤖 Applying knowledge of @[agent]...`? | → STOP. Add announcement before response. |
| 4 | Did I load required skills from agent's frontmatter? | → STOP. Check `skills:` field and read them. |

---

## TIER 0: UNIVERSAL RULES (Always Active)

### 🌐 Language Handling

When user's prompt is NOT in English:
1. **Internally translate** for better comprehension.
2. **Respond in user's language** - match their communication.
3. **Code comments/variables** remain in English.

### 🧹 Clean Code (Global Mandatory)

**ALL code MUST follow `@[skills/clean-code]` rules. No exceptions.**
- **Code**: Concise, direct, no over-engineering. Self-documenting.
- **Testing**: Mandatory. Pyramid (Unit > Int > E2E) + AAA Pattern.
- **Performance**: Measure first. Adhere to current Core Web Vitals standards.

### 📁 File Dependency Awareness

**Before modifying ANY file:**
1. Check `CODEBASE.md` → File Dependencies
2. Identify dependent files
3. Update ALL affected files together

### 🗺️ System Map & Memory Read

> 🔴 **MANDATORY:** At session start, you MUST read:
> 1. `.agents/ARCHITECTURE.md` to understand Agents, Skills, and Scripts.
> 2. `.agents/memory/MEMORY.md` to load persistent conventions, user preferences, and decisions.

---

## TIER 1: CODE RULES (When Writing Code)

### 📱 Project Type Routing

| Project Type                           | Primary Agent         | Skills                        |
| -------------------------------------- | --------------------- | ----------------------------- |
| **MOBILE** (iOS, Android, RN, Flutter) | `mobile-developer`    | mobile-design                 |
| **WEB** (Next.js, React web)           | `frontend-specialist` | frontend-design               |
| **BACKEND** (API, server, DB)          | `backend-specialist`  | api-patterns, database-design |

### 🛑 GLOBAL SOCRATIC GATE (TIER 0)

**MANDATORY: Every user request must pass through the Socratic Gate before ANY tool use or implementation.**

| Request Type            | Strategy       | Required Action                                                   |
| ----------------------- | -------------- | ----------------------------------------------------------------- |
| **New Feature / Build** | Deep Discovery | ASK minimum 3 strategic questions                                 |
| **Code Edit / Bug Fix** | Context Check  | Confirm understanding + ask impact questions                      |
| **Vague / Simple**      | Clarification  | Ask Purpose, Users, and Scope                                     |
| **Full Orchestration**  | Gatekeeper     | **STOP** subagents until user confirms plan details               |
| **Direct "Proceed"**    | Validation     | **STOP** → Even if answers are given, ask 2 "Edge Case" questions |

---

## 🔄 AUTOMATIC DOCUMENTATION UPDATE RULE (MANDATORY)

**Whenever a task is completed, code is edited, or a pipeline error/design plan changes, you MUST automatically update the corresponding markdown log files in the `MD files/` directory:**

1. **`MD files/conversation.md`**: Summarize key conversation milestones, Socratic gate questions, user decisions, and session outcomes.
2. **`MD files/tasklog.md`**: Maintain the task statuses (Pending, In Progress, Completed) with relevant dates, details, and logs.
3. **`MD files/errorlog.md`**: Record any pipeline errors, stack traces, exceptions, rate-limits, or blocks, along with the debugging resolutions.
4. **`MD files/planlog.md`**: Index and link all current and completed implementation plans in the project workspace (e.g., `cisco-kenya.md`, `brand-contact-scraper.md`, etc.).

---

## 🏁 Final Checklist Protocol

**Trigger:** When the user says "run the final checks", "final checks", "run all the tests", or similar phrases.

| Task Stage       | Command                                            | Purpose                        |
| ---------------- | -------------------------------------------------- | ------------------------------ |
| **Manual Audit** | `python .agents/scripts/checklist.py .`             | Priority-based project audit   |
| **Pre-Deploy**   | `python .agents/scripts/checklist.py . --url <URL>` | Full Suite + Performance + E2E |

**Priority Execution Order:**
1. **Security** → 2. **Lint** → 3. **Schema** → 4. **Tests** → 5. **UX** → 6. **Seo** → 7. **Lighthouse/E2E**
