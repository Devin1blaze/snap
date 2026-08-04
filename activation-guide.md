# Activation Guide: Oracle Free Tier Optimization Resources

This guide walks you through activating the 100% free services defined in the `oracle-hermes-architecture.md` plan.

---

## 1. Activate Local Postgres, Redis, and Tor (Oracle VPS)

Instead of relying on cloud databases with limits, we have created a `docker-compose.yml` file to spin up these services directly on your Oracle Ampere A1 (24GB RAM) instance.

### Prerequisites: Install Docker
If Docker isn't installed on your Oracle VPS, run this over SSH:
```bash
sudo apt-get update
sudo apt-get install -y docker.io docker-compose
sudo systemctl enable docker
sudo systemctl start docker
sudo usermod -aG docker $USER
```
*(Log out and log back in to apply the `docker` group).*

### Activation Step
1. Upload the `docker-compose.yml` file (now in your project directory) to your Oracle VPS.
2. Navigate to the folder containing the file and run:
   ```bash
   docker-compose up -d
   ```
3. **Verification**: Run `docker ps`. You should see `hermes_postgres`, `hermes_redis`, and `hermes_tor` running.

---

## 2. Activate Cloudflare Workers Proxy (100k Free IP Rotations/Day)

This creates a "proxy" where your Python script asks Cloudflare to fetch the HTML, masking the Oracle VPS IP address.

### Activation Step
1. Sign up for a free account at [Cloudflare](https://dash.cloudflare.com/).
2. On the left sidebar, click **Workers & Pages** -> **Overview**.
3. Click **Create Application** -> **Create Worker**.
4. Name your worker (e.g., `hermes-proxy`) and click **Deploy**.
5. Click **Edit Code**.
6. Replace the default code with the contents of the `cloudflare-worker.js` file (which I just created in your project directory).
7. Click **Save and Deploy**.

### How to use it in your Python Script
Instead of:
```python
response = httpx.get("https://cisco.com/target-page")
```
You will now route it through your new worker:
```python
# Pass the target URL as a query parameter
worker_url = "https://hermes-proxy.<your-username>.workers.dev/?url="
response = httpx.get(worker_url + "https://cisco.com/target-page")
```

---

## 3. Activate Tor Proxy Pool (Infinite Fallback IP Rotation)

The `docker-compose.yml` already started a Tor SOCKS5 proxy on port `9150` for you.

### How to use it in your Python Script
If Cloudflare is blocked or runs out of requests, configure Scrapling/httpx to route through the Tor container:
```python
import httpx

proxies = {
    "http://": "socks5://127.0.0.1:9150",
    "https://": "socks5://127.0.0.1:9150"
}

# The request is now masked through the Tor network
response = httpx.get("https://cisco.com/target-page", proxies=proxies)
```

---

## Next Steps
Now that the infrastructure is ready to be activated, the final step is to refactor the Python script (`cisco_pipeline.py`) to actually connect to this new Postgres database and output the strict JSON needed by Hermes.
