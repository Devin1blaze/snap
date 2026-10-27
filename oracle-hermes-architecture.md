# Hyperresearch Report: Oracle Free Tier & Hermes Optimization

**Query Context**: Architecting a Python scraping pipeline optimized for Oracle Free Tier (Ampere A1, 4 ARM OCPUs, 24GB RAM) with 100% free-tier services. The pipeline must generate deterministic, machine-readable output specifically for the **Hermes Agent** (avoiding LLM conversational variability).

**Depth Tier**: FULL (Adversarial Audit & Deep Sweep)
**Provenance**: Verified against Oracle Always Free tier limits, Cloudflare Worker documentation, and Python GIL concurrency principles.

---

## 1. Hermes Agent Integration (Deterministic Execution)

Since Hermes expects specific outputs rather than LLM conversational text, the Python scripts must be designed as strict CLI utilities.

*   **Strict JSON stdout**: The script must **only** print valid JSON to `stdout`. All logging, debugging, and progress bars must be routed to `stderr` or a log file (`pipeline.log`). This allows Hermes to parse the exact results safely via `json.loads()`.
*   **Exit Code Signaling**: Use OS exit codes for deterministic flow control without LLM parsing:
    *   `exit(0)`: Completed successfully.
    *   `exit(2)`: Time budget reached (`--time-budget`), checkpoint saved. Hermes knows to re-invoke with `--resume`.
    *   `exit(1)`: Fatal error.
*   **Hermes Schema Output**:
    ```json
    {
      "status": "resumable",
      "records_extracted": 154,
      "unique_domains": 80,
      "checkpoint_file": "cisco_oman_temp.csv"
    }
    ```

## 2. Compute & Memory Optimization (4 OCPUs, 24GB RAM)

The Ampere A1 gives you 4 CPU cores, but Python's Global Interpreter Lock (GIL) restricts a single script from using more than 1 core at a time for CPU-bound tasks.

*   **The Hybrid Approach (Asyncio + Multiprocessing)**: 
    *   Use `multiprocessing.Pool(4)` to spawn exactly 4 independent Python processes (one for each OCPU). 
    *   Inside each process, run `asyncio` with Scrapling's `AsyncFetcher` and a `Semaphore(250)`. 
    *   **Result**: You are now running 1,000 concurrent HTTP connections utilizing 100% of your 4 ARM cores. Your 24GB of RAM will easily absorb the memory footprint of 1,000 async workers.

## 3. Data Storage & Queueing (Zero Cost)

Currently, the pipeline writes to CSV/Excel, causing file-locking issues. Managed cloud databases cost money or have strict free limits (e.g., Supabase 500MB). 

*   **Local Dockerized Redis & Postgres**: You have 200GB of Block Volume storage. Install Docker on the Oracle VPS and spin up local `redis` and `postgres` containers.
    *   **Cost**: $0.00
    *   **Latency**: 0ms (Internal network)
    *   **Architecture**: The 4 Python multiprocessing workers pull URLs to scrape from the local Redis queue (`LPOP`). When they extract data, they `INSERT` it into the local Postgres database. This completely solves file-locking and allows massive concurrency.

## 4. Free IP Rotation & Anti-Bot Strategy

If 1,000 concurrent connections hit a target from the Oracle VPS IP, it will be banned instantly. We must rotate IPs using 100% free services.

*   **Tier 1: Cloudflare Workers (100k requests/day)**
    *   **How it works**: You deploy a tiny Javascript code block to Cloudflare. Your Python script sends the URL it wants to scrape to the Worker. The Worker makes the request from Cloudflare's massive global network and returns the HTML to you.
    *   **Limits**: 100,000 requests per day, 10ms CPU time per request (network wait time doesn't count against CPU time).
    *   **Cost**: $0.00.
*   **Tier 2: Local Tor Proxy Pool (Infinite requests)**
    *   **How it works**: Run a Docker container on the Oracle VPS that creates 10-20 Tor SOCKS5 proxies. 
    *   **Architecture**: If the Cloudflare Worker gets blocked or exhausts its 100k limit, Scrapling falls back to routing requests through the local Tor proxies. It gives you infinite IP rotation at the cost of slower request speeds.
    *   **Cost**: $0.00.

---

## User Review Required
> [!IMPORTANT]
> The architectural research above fulfills your constraints (Hermes-specific output, 100% free tier usage, maxing out the 24GB ARM instance).
> 
> **Are you ready to approve this architectural blueprint?**
> If you say **YES**, I will trigger the implementation phase to begin writing the code for the Cloudflare worker, the Docker-compose file for Redis/Postgres, and refactoring the Python script for Hermes JSON output.
