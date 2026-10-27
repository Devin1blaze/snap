# 🤖 ANTIGRAVITY AGENT PROTOCOLS 
*(These rules are absolute and override all other default behaviors)*

## 1. ORCHESTRATION & PLANNING
Plan Mode Default

-Enter plan mode for ANY non-trivial task (3+ steps or architectural decisions)

* If something goes sideways, STOP and re-plan immediately

* Use plan mode for verification steps, not just building

* Write detailed specs upfront to reduce ambiguity
- **CRITICAL**: For ANY task requiring more than 2 files to be edited, you MUST enter Planning Mode.
- **NEVER** write code for a complex feature without first writing a plan to `docs/PLAN.md` and getting explicit user approval.
- **ALWAYS** update the `task.md` artifact to mark checkboxes as `[x]` when completing a sub-task.

## 2. EXECUTION & CODE QUALITY
- **NO LAZINESS**: You MUST find and fix the root cause. NEVER implement a temporary workaround or suppress an error without user consent.
- **MINIMAL RADIUS**: ONLY modify the exact lines of code required to solve the problem. DO NOT touch unrelated formatting or logic.
- **SUBAGENTS**: Use subagents liberally to keep main context window clean

Offload research, exploration, and parallel analysis to subagents

For complex problems, throw more compute at it via subagents 

IF a task involves deep research or log analysis, you MUST spawn a subagent to keep your main context clean, One task per subagent for focused execution.

## 3. VERIFICATION (MANDATORY)
- **NEVER** assume your code works. 
- IF you write a UI component, you MUST run a build check or launch the dev server to verify it compiles.
.
- Verification Before Done

- Never mark a task complete without proving it works

Diff behavior between main and your changes when relevant

Ask yourself: "Would a staff engineer approve this?"

* Run tests, check logs, demonstrate correctness, IF you fix a bug, point out the exact logs/errors that prove it is fixed before marking the task complete

## 4. ERROR HANDLING
- IF a command fails or a script throws an error, **STOP**. Do not guess the fix. Analyze the error output, form a hypothesis, and ask clarifying questions if the path forward is ambiguous.

## 5. Self-Improvement Loop

After ANY correction from the user: update tasks/lessons.md with the pattern.

Write rules for yourself that prevent the same mistake

Ruthlessly iterate on these lessons until mistake rate drops

* Review lessons at session start for relevant project


## 6. Demand Elegance (Balanced)

For non-trivial changes: pause and ask "is there a more elegant way?"

* If a fix feels hacky: "Knowing everything I know now, implement the elegant solution"

Skip this for simple, obvious fixes -- don't over-engineer

Challenge your own work before presenting it

## 7. Autonomous Bug Fixing

-When given a bug report: just fix it. Don't ask for hand-holding

-Point at logs, errors, failing tests -- then resolve them

Zero context switching required from the user

-Go fix failing Cl tests without being told how

#Task Management

1. Plan First: Write plan to tasks/todo.md with checkable items

2. Verify Plan: Check in before starting implementation

3. Track Progress: Mark items complete as you go

4. Explain Changes: High-level summary at each step.

5. Document Results: Add review section to tasks/todo.md

6. Capture Lessons: Update tasks/lessons.md after corrections

#Core Principles

Simplicity First: Make every change as simple as possible. Impact minimal code. No Laziness: Find root causes. No temporary fixes. Senior developer standards.

Minimal Impact: Only touch what's necessary. No side effects with new bugs.