#!/usr/bin/env bash
# Deploy the Cisco Partner Scraper toolkit to the Oracle VPS for Hermes.
#
# Usage:
#   ./deploy_to_oracle.sh user@oracle-vps-ip [remote_dir]
#
# After deploy, Hermes invokes the tool via execute_code:
#   cd <remote_dir> && .venv/bin/python hermes_cisco_tool.py "Oman" --time-budget 15 --notify telegram,email
set -euo pipefail

REMOTE=${1:?Usage: ./deploy_to_oracle.sh user@host [remote_dir]}
REMOTE_DIR=${2:-~/cisco_scraper}

FILES=(
  cisco_pipeline.py
  cisco_scraper.py
  brand_scraper.py
  search_enricher.py
  hermes_cisco_tool.py
  notification_sender.py
  requirements.txt
)

echo "[*] Copying scraper files to $REMOTE:$REMOTE_DIR"
ssh "$REMOTE" "mkdir -p $REMOTE_DIR"
scp "${FILES[@]}" "$REMOTE:$REMOTE_DIR/"

echo "[*] Setting up Python environment (uv preferred, venv fallback)"
ssh "$REMOTE" bash -s "$REMOTE_DIR" <<'EOF'
set -euo pipefail
cd "$1"
if command -v uv >/dev/null 2>&1; then
  uv venv .venv
  uv pip install --python .venv/bin/python -r requirements.txt
else
  python3 -m venv .venv
  .venv/bin/pip install -U pip
  .venv/bin/pip install -r requirements.txt
fi

# One-time browser install for the StealthyFetcher fallback (camoufox).
# The core pipeline is browserless; this only serves blocked-site retries.
.venv/bin/python -m scrapling install || echo "[!] scrapling browser install failed - stealth fallback disabled, plain fetching still works"

# .env template for notification credentials (fill in manually, never commit)
if [ ! -f .env ]; then
  cat > .env <<'ENV'
TELEGRAM_BOT_TOKEN=
TELEGRAM_CHAT_ID=
SMTP_HOST=
SMTP_PORT=587
SMTP_USER=
SMTP_PASS=
MAIL_TO=
ENV
  chmod 600 .env
  echo "[!] Created .env template - fill in Telegram/SMTP credentials"
fi
EOF

echo "[+] Deploy complete."
echo "    Test:   ssh $REMOTE 'cd $REMOTE_DIR && .venv/bin/python notification_sender.py --dry-run'"
echo "    Hermes: cd $REMOTE_DIR && .venv/bin/python hermes_cisco_tool.py \"Oman\" --max 5 --time-budget 10"
