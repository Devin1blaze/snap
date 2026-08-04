"""
Notification Dispatcher for the Cisco Partner Scraper (Hermes / Oracle VPS).

Sends the finished CSV/XLSX deliverable via Telegram Bot API and/or SMTP email.
Credentials come from environment variables (or a .env file next to this
script) and are NEVER printed, so nothing sensitive leaks into Hermes' LLM
context.

Environment variables:
  TELEGRAM_BOT_TOKEN   Bot token from @BotFather
  TELEGRAM_CHAT_ID     Target chat/channel id
  SMTP_HOST            e.g. smtp.gmail.com
  SMTP_PORT            e.g. 587
  SMTP_USER            SMTP login / from-address
  SMTP_PASS            SMTP password or app password
  MAIL_TO              Comma-separated recipient list
"""
import os
import sys
import argparse
import mimetypes
import smtplib
from email.message import EmailMessage

import requests

# Optional .env support
try:
    from dotenv import load_dotenv
    load_dotenv(os.path.join(os.path.dirname(os.path.abspath(__file__)), ".env"))
except ImportError:
    pass


def send_telegram(file_path: str, caption: str = "") -> bool:
    token = os.getenv("TELEGRAM_BOT_TOKEN")
    chat_id = os.getenv("TELEGRAM_CHAT_ID")
    if not token or not chat_id:
        print("[-] Telegram not configured (TELEGRAM_BOT_TOKEN / TELEGRAM_CHAT_ID missing).")
        return False

    url = f"https://api.telegram.org/bot{token}/sendDocument"
    try:
        with open(file_path, "rb") as f:
            resp = requests.post(
                url,
                data={"chat_id": chat_id, "caption": caption[:1024]},
                files={"document": (os.path.basename(file_path), f)},
                timeout=120,
            )
        if resp.status_code == 200 and resp.json().get("ok"):
            print(f"[+] Telegram: sent {os.path.basename(file_path)}")
            return True
        print(f"[-] Telegram: send failed (HTTP {resp.status_code}).")
    except Exception as e:
        print(f"[-] Telegram: error sending document: {type(e).__name__}")
    return False


def send_email(file_path: str, subject: str = "", body: str = "") -> bool:
    host = os.getenv("SMTP_HOST")
    port = int(os.getenv("SMTP_PORT", "587"))
    user = os.getenv("SMTP_USER")
    password = os.getenv("SMTP_PASS")
    mail_to = os.getenv("MAIL_TO")
    if not all([host, user, password, mail_to]):
        print("[-] Email not configured (SMTP_HOST / SMTP_USER / SMTP_PASS / MAIL_TO missing).")
        return False

    msg = EmailMessage()
    msg["Subject"] = subject or f"Scraper deliverable: {os.path.basename(file_path)}"
    msg["From"] = user
    msg["To"] = mail_to
    msg.set_content(body or "Attached is the requested scraper deliverable.")

    ctype, _ = mimetypes.guess_type(file_path)
    maintype, subtype = (ctype or "application/octet-stream").split("/", 1)
    with open(file_path, "rb") as f:
        msg.add_attachment(f.read(), maintype=maintype, subtype=subtype,
                           filename=os.path.basename(file_path))

    try:
        with smtplib.SMTP(host, port, timeout=60) as server:
            server.starttls()
            server.login(user, password)
            server.send_message(msg)
        print(f"[+] Email: sent {os.path.basename(file_path)} to {mail_to}")
        return True
    except Exception as e:
        print(f"[-] Email: send failed: {type(e).__name__}")
    return False


def dispatch(file_path: str, channels, caption: str = "") -> dict:
    """Send file over the requested channels. Returns {channel: bool}."""
    results = {}
    if "telegram" in channels:
        results["telegram"] = send_telegram(file_path, caption)
    if "email" in channels:
        results["email"] = send_email(file_path, subject=caption)
    return results


def check_config() -> dict:
    """Dry-run: report which channels are configured, without sending."""
    return {
        "telegram": bool(os.getenv("TELEGRAM_BOT_TOKEN") and os.getenv("TELEGRAM_CHAT_ID")),
        "email": bool(os.getenv("SMTP_HOST") and os.getenv("SMTP_USER")
                      and os.getenv("SMTP_PASS") and os.getenv("MAIL_TO")),
    }


if __name__ == "__main__":
    parser = argparse.ArgumentParser(description="Send a scraper deliverable via Telegram/Email")
    parser.add_argument("file", nargs="?", help="File to send")
    parser.add_argument("--channels", default="telegram,email",
                        help="Comma-separated: telegram,email")
    parser.add_argument("--caption", default="", help="Caption / email subject")
    parser.add_argument("--dry-run", action="store_true",
                        help="Only validate configuration, do not send")
    args = parser.parse_args()

    if args.dry_run:
        cfg = check_config()
        for ch, ok in cfg.items():
            print(f"{ch}: {'configured' if ok else 'NOT configured'}")
        sys.exit(0 if any(cfg.values()) else 1)

    if not args.file or not os.path.exists(args.file):
        print(f"[-] File not found: {args.file}")
        sys.exit(1)

    channels = [c.strip() for c in args.channels.split(",") if c.strip()]
    results = dispatch(args.file, channels, args.caption)
    sys.exit(0 if any(results.values()) else 1)
