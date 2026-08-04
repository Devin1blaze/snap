# Add Hyperresearch Agent

## Overview
Integrate the `hyperresearch` agent into the AG Kit architecture based on the repository `jordan-gibbs/hyperresearch`. This agent will serve as a Deep Research Agent capable of utilizing a 16-step tier-adaptive research pipeline for generating adversarially-audited research reports.

## Project Type
BACKEND

## Success Criteria
- The agent file `.agents/agent/hyperresearch.md` is created with the required frontmatter and persona details.
- The `.agents/ARCHITECTURE.md` is updated to include the `hyperresearch` agent.

## Tech Stack
- Markdown (for agent persona definition)
- Python (as the tool `hyperresearch` runs in Python 3.11-3.13)

## File Structure
- `[NEW]` `.agents/agent/hyperresearch.md`
- `[MODIFY]` `.agents/ARCHITECTURE.md`

## Task Breakdown

### Task 1: Define the Hyperresearch Agent
- **Agent**: `documentation-writer`
- **Skills**: `documentation-templates`
- **Priority**: P1
- **Dependencies**: None
- **INPUT**: `hyperresearch` repository README
- **OUTPUT**: `.agents/agent/hyperresearch.md`
- **VERIFY**: File is created with correct `name`, `description`, `tools`, and `skills` frontmatter.

### Task 2: Update Architecture Document
- **Agent**: `documentation-writer`
- **Skills**: `documentation-templates`
- **Priority**: P2
- **Dependencies**: Task 1
- **INPUT**: `hyperresearch` agent metadata
- **OUTPUT**: Updated `.agents/ARCHITECTURE.md`
- **VERIFY**: Table under "Agents" reflects the new agent, incrementing total agents to 21.

## Phase X: Verification
- [ ] Run checklist validations `python .agents/scripts/checklist.py .`
