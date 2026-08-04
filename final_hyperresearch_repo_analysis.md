# Deep Research Report: `jordan-gibbs/hyperresearch`

## 1. Provenance and Scope
- **Source Budget:** 
  - `https://github.com/jordan-gibbs/hyperresearch/blob/main/README.md`
- **Scope (Depth Mode):** `full`
- **Goal:** Analyze the `hyperresearch` project architecture, benchmarking, and its 16-step tier-adaptive pipeline.

---

## 2. Executive Summary
**Hyperresearch** transforms conversational AI agents (specifically targeting Claude Code) into fully-fledged deep research agents. It is designed to act as a robust harness that executes a highly structured, 16-step research pipeline. The tool claims to top the *DeepResearch-Bench RACE leaderboard*, surpassing other deep research methodologies such as Grep Deep Research, OpenAI Deep Research, and Gemini Deep Research.

### Key Value Proposition
- **Avoid Context-Rot:** Instead of loading monolithic instructions, the entry skill acts as a thin router. It dynamically loads individual step procedures into the context window only when they are needed.
- **Tier-Adaptive Execution:** The pipeline can scale from a `light` tier (5 steps, 30-40 mins) for factual queries to a `full` tier (16 steps, 1.5-2.5 hours) for deep argumentative and adversarial analysis.
- **Surgical Patching:** The tool fundamentally adheres to a "Patch, never regenerate" philosophy. After the draft phase, subsequent refinement phases only apply surgical edit patches via tool-locked Read+Edit subagents to preserve context and formatting.

---

## 3. Loci Analysis (The 16-Step Pipeline)
The core architecture operates over 16 distinct phases (all 16 are utilized in `full` mode):

1. **Decompose:** Canonical query → atomic items + coverage matrix + tier classification.
2. **Width sweep:** Multi-perspective search plan + parallel fetcher waves.
3. **Contradiction graph (Full only):** Pair contradictions across the corpus into ranked clusters.
4. **Loci analysis (Full only):** Two parallel loci-analysts generate scored loci with source budgets.
5. **Depth investigation (Full only):** `K` parallel depth-investigators generate interim notes with committed positions.
6. **Cross-locus reconcile (Full only):** Reconcile committed positions into `comparisons.md`.
7. **Source tensions (Full only):** Extract expert disagreements into `source-tensions.json`.
8. **Corpus critic (Full only):** Asks "What source would overturn this?" + targeted gap-fill fetch.
9. **Evidence digest (Full only):** Top claims + verbatim quotes formatted into `evidence-digest.md`.
10. **Triple draft:** Per-angle source curation + parallel draft sub-orchestrators (only single draft for `light` tier).
11. **Synthesize (Full only):** Plan + outline + spawn synthesizer subagent to produce `final_report.md`.
12. **Critics (Full only):** 4 adversarial critics in parallel generate findings JSONs.
13. **Gap-fetch (Full only):** Targeted fetch wave for critic-identified vault gaps.
14. **Patcher (Full only):** Surgical Edit hunks applied to draft (tool-locked Read+Edit).
15. **Polish:** Hygiene + filler pass (tool-locked Read+Edit subagent).
16. **Readability audit:** Recommender writes JSON suggestions; orchestrator selectively applies.

---

## 4. Source Tensions & Contradiction Graph
- **Integration Constraints:** While advertised for Claude Code, the principles of Hyperresearch's tier-adaptive, context-rotating pipeline are highly applicable to other agent harnesses (such as AG Kit for Gemini).
- **Environment Support:** Python 3.11-3.13 is strictly required, excluding Python 3.14 which requires virtual environment fallbacks (`pyenv`, `uv venv`).

---

## 5. Synthesis & Audit Results
The project's architecture is highly advanced, utilizing parallel workflows and strict source budgeting to ensure high-fidelity outputs. The strategic isolation of pipeline tasks avoids context window bloat, ensuring that agents do not forget initial instructions during long-running tasks. 

**Readability Audit Passed:** The documentation successfully conveys the complexity and modular nature of the deep research pipeline.
