"""
Gojiberry App Feature Scraper using Scrapling
Replaced Crawl4AI with Scrapling's StealthySession: a persistent stealth
browser context performs the login (page_action) and then navigates the
dashboard statefully. No LLM involved.
"""
import os
import logging

try:
    from scrapling.fetchers import StealthySession
except ImportError:
    print("scrapling not installed (>=0.4 required). Run: pip install -U scrapling")
    exit(1)

logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

EMAIL = "dasz.stone12@gmail.com"
PASSWORD = "dXHe2LqA@dFU3e9"
BASE_URL = "https://app.gojiberry.ai"
OUTPUT_DIR = "e:/gojiberry/app_analysis"

os.makedirs(OUTPUT_DIR, exist_ok=True)


def login_action(page):
    """Fill the login form and submit (Playwright page passed by Scrapling)."""
    page.wait_for_timeout(2000)
    email_input = page.query_selector("input[type='email'], input[name='email']")
    if email_input:
        email_input.fill(EMAIL)
    pass_input = page.query_selector("input[type='password']")
    if pass_input:
        pass_input.fill(PASSWORD)
    submit_btn = page.query_selector("button[type='submit']")
    if submit_btn:
        submit_btn.click()
    page.wait_for_timeout(5000)
    return page


def run():
    print("Starting Scrapling StealthySession to analyze Gojiberry dashboard...")

    # One session = one persistent browser context, so the login cookies
    # carry over to the dashboard fetch (replaces Crawl4AI's session_id).
    with StealthySession(headless=True, network_idle=True) as session:
        print("Navigating to login and performing login action...")
        result = session.fetch(f"{BASE_URL}/login", page_action=login_action)

        if result.status == 200:
            print("Login flow completed successfully.")

            screen_path = f"{OUTPUT_DIR}/post_login.html"
            with open(screen_path, "w", encoding="utf-8") as f:
                f.write(result.html_content)
            print(f"Post-login HTML saved to {screen_path}")

            # Stateful navigation: same context keeps the auth cookies
            print("Extracting dashboard data...")
            dash_result = session.fetch(f"{BASE_URL}/home")

            if dash_result.status == 200:
                print(f"Dashboard text preview:\n{dash_result.get_all_text()[:500]}...")
        else:
            print(f"Failed to load or execute login: HTTP {result.status}")


if __name__ == "__main__":
    run()
