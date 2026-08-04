# Oracle Cloud "Always Free" Tier Complete List

Oracle Cloud Infrastructure (OCI) offers a uniquely generous "Always Free" tier that never expires. Here is the comprehensive list of resources you can use without paying a dime, provided you stay within these limits:

## 1. 🖥️ Compute (Virtual Machines)
You are allowed a mix of ARM and x86 compute instances:
- **Ampere A1 Compute (ARM)**: Up to **4 ARM OCPUs** and **24 GB of RAM**. You can use this as one massive instance (like you are doing) or split it into up to 4 smaller instances.
- **AMD Micro Compute (x86)**: Up to **2 instances** using the `VM.Standard.E2.1.Micro` shape (1/8 OCPU and 1 GB RAM each). Great for lightweight cron jobs or monitoring servers.

## 2. 💾 Storage
- **Block Volume**: Up to **200 GB total** of block storage. (You can split this among your compute instances, e.g., 50GB for each instance if you maxed out 4 VMs).
- **Object Storage**: **10 GB** of Standard Object Storage (similar to AWS S3).
- **Archive Storage**: **10 GB** of Archive Storage.
- **Outbound Data Transfer**: **10 TB per month** of free outbound bandwidth (Egress). Inbound bandwidth is 100% free.

## 3. 🗄️ Databases
You get access to Oracle's managed cloud databases:
- **Autonomous Database**: **Two (2) instances** of Oracle Autonomous Database (either Transaction Processing or Data Warehouse). Each includes **1 OCPU** and **20 GB** of storage.
- **NoSQL Database**: Up to **3 tables** with a maximum of **133 reads/sec**, **133 writes/sec**, and **25 GB** storage per table.

## 4. 🌐 Networking & Load Balancing
- **Load Balancer**: **One (1) Flexible Load Balancer** with a minimum of 10 Mbps bandwidth.
- **Virtual Cloud Networks (VCN)**: Standard networking to link your instances securely.
- **Site-to-Site VPN**: You can set up free IPsec VPNs to connect Oracle to your local home network securely.

## 5. 🛠️ Observability & Management
- **Monitoring**: 500 million ingestion points and 1 billion retrieval data points per month.
- **Application Performance Monitoring**: 1,000 trace events per hour.
- **Logging**: 10 GB per month of log data.

---

### 💡 How this helps our Hermes Scraper:
1. **10 TB Bandwidth**: Scraping uses a massive amount of data. 10 TB free means you will essentially never hit a data transfer bill.
2. **AMD Micro VMs**: You could spin up one of the free x86 1GB RAM instances to act *solely* as a remote cron-scheduler or a Grafana dashboard server to monitor the main Ampere scraping server.
3. **Object Storage (10GB)**: Instead of keeping the final `Cisco_Partners.csv` files on the server's hard drive, the Python script could upload them automatically to your 10GB free Object Storage bucket for permanent backup and easy download.
