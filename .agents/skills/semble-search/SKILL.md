---
name: semble-search
description: Fast and Accurate Code Search for Agents using Semble. Uses ~98% fewer tokens than grep+read.
---

# Semble Search Skill

Semble is a code search library built for agents. It returns the exact code snippets needed instantly, using ~98% fewer tokens than grep+read. 

## When to use this skill
Use Semble when you need to search a large codebase efficiently without consuming too many tokens. It is highly token-efficient and surfaces the most relevant code chunks.

## How to use Semble CLI

Semble provides a CLI for searching codebases:

### 1. Natural Language Search
Search a local or remote repository using natural language:
```bash
semble search "authentication flow" ./
```
```bash
semble search "save model to disk" https://github.com/MinishLab/model2vec
```

### 2. Limit Results
Limit the number of results returned:
```bash
semble search "authentication flow" ./ --top-k 10
```

### 3. Search Specific Content Types
By default, Semble searches code. You can tell it to search docs or config files instead:
```bash
semble search "deployment guide" ./ --content docs
```
Available options for `--content`: `code` (default), `docs`, `config`, `all`.

### 4. Find Related Code
Find code similar to a known location:
```bash
semble find-related src/auth.py 42 ./
```

## Installation
If `semble` is not installed, it can be installed or run via `uv`:
```bash
uv tool install semble
semble install
```
Or run directly without installation:
```bash
uvx --from "semble[mcp]" semble search "query" ./
```

## Ignoring Files
Semble respects `.gitignore` and `.sembleignore` files. Use `.sembleignore` to add semble-specific ignore rules.

### Include specific extensions
Prefix the extension pattern with `!` in `.sembleignore` to force-include files:
```
!*.proto
!*.cob
```

## Savings
To see how many tokens Semble has saved you, run:
```bash
semble savings
```
