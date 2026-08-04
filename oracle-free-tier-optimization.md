# Oracle Free Tier Optimization Plan

## Goal Description
Leverage the massive resources of the Oracle "Always Free" ARM Ampere A1 Compute instance (4 OCPUs, 24GB RAM, 200GB Storage, 10TB Bandwidth) and other 100% free-tier services to maximize the Python scraping pipeline's performance. 

The goal for this phase is to **learn and discuss** the best architectural approaches to use these resources without paying anything, before writing any code.

## Proposed 100% Free Optimizations

### 1. Maximize Oracle VPS Local Resources
Your Oracle instance has 4 OCPUs and 24GB of RAM, which is massive for a free tier (most free tiers give 1GB). We can fully utilize this:
* **Hyper-Concurrency**: We can increase Scrapling's `AsyncFetcher` concurrency limit from 10 up to 500 or even 1000. 24GB of RAM can easily hold thousands of open HTTP connections simultaneously without crashing.
* **True Multi-Processing**: Python's Global Interpreter Lock (GIL) limits single scripts. Because you have 4 OCPUs, we can use Python's `multiprocessing` library to run 4 parallel scraper workers at once, effectively quadrupling your CPU processing power for regex and HTML parsing.
* **RAM Disk (tmpfs)**: We can allocate 2GB-4GB of your 24GB RAM as a "virtual hard drive". Saving temporary files and HTML dumps to RAM instead of the physical disk is astronomically faster.

### 2. Free Database & Storage (No Cloud Needed)
Currently, the scraper writes to CSV files, which causes "file-locking" errors when multiple threads try to save data at once.
* **Local Postgres/Redis**: Instead of trying to use a free cloud database with limits, we can run a **PostgreSQL** database and **Redis** (for a job queue) locally on the Oracle VPS. With 200GB of storage and 24GB RAM, it will be lightning-fast (zero network latency) and 100% free forever. 

### 3. Free IP Rotation (Anti-Blocking)
If we scrape too fast using the Oracle IP, websites will block it. We can integrate 100% free IP rotation:
* **Cloudflare Workers Proxy**: We can deploy a tiny proxy script to Cloudflare Workers. Cloudflare gives you **100,000 free requests per day**. This hides the Oracle IP and makes requests look like they are coming from Cloudflare's massive global network.
* **Tor Proxy Pool**: We can install a local Tor network instance on the Oracle VPS to route requests through random global exit nodes for free, infinite IP rotation (though slower).

## User Review Required
> [!IMPORTANT]
> Please review the educational overview above. Since you want to learn and discuss before implementing anything:
> 
> **Which of these optimizations would you like me to explain deeper or prioritize for our implementation plan?**
> 1. Scaling the scraper to use all 4 OCPUs and 24GB RAM (Hyper-concurrency).
> 2. Setting up a local Database/Redis to fix CSV locking.
> 3. Setting up the Cloudflare Worker proxy for 100k free daily IP rotations.
