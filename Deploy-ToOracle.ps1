param (
    [Parameter(Mandatory=$true)]
    [string]$Remote,

    [string]$RemoteDir = "~/cisco_scraper"
)

$Files = @(
    "cisco_pipeline.py",
    "cisco_scraper.py",
    "brand_scraper.py",
    "search_enricher.py",
    "hermes_cisco_tool.py",
    "notification_sender.py",
    "requirements.txt"
)

Write-Host "[*] Copying scraper files to $Remote:$RemoteDir" -ForegroundColor Cyan
ssh $Remote "mkdir -p $RemoteDir"

# Build scp arguments
$scpArgs = @()
foreach ($f in $Files) {
    $scpArgs += $f
}
$scpArgs += "$Remote:$RemoteDir/"

& scp $scpArgs

Write-Host "[*] Setting up Python environment (uv preferred, venv fallback)" -ForegroundColor Cyan
$setupScript = @"
set -euo pipefail
cd "$RemoteDir"
if command -v uv >/dev/null 2>&1; then
  uv venv .venv
  uv pip install --python .venv/bin/python -r requirements.txt
else
  python3 -m venv .venv
  .venv/bin/pip install -U pip
  .venv/bin/pip install -r requirements.txt
fi

.venv/bin/python -m scrapling install || echo "[!] scrapling browser install failed - stealth fallback disabled, plain fetching still works"

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
"@

# Run the setup script over SSH using bash
Invoke-Command -ScriptBlock { ssh $Remote "bash -s" } -InputObject $setupScript

Write-Host "[+] Deploy complete." -ForegroundColor Green
Write-Host "    Test:   ssh $Remote 'cd $RemoteDir && .venv/bin/python notification_sender.py --dry-run'"
Write-Host "    Hermes: cd $RemoteDir && .venv/bin/python hermes_cisco_tool.py `"Oman`" --max 5 --time-budget 10"
