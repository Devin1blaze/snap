import urllib.request
import json
import time
from playwright.sync_api import sync_playwright

def scrape_b2c_products():
    print("Starting B2C Product Scraper (Shopify + Playwright for Specs)...")
    products = []
    page = 1
    limit = 250
    
    # 1. Get all products from Shopify JSON endpoint
    while True:
        url = f"https://consumer.bluestarindia.com/products.json?limit={limit}&page={page}"
        print(f"Fetching page {page}...")
        try:
            req = urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0'})
            response = urllib.request.urlopen(req)
            data = json.loads(response.read())
            
            page_products = data.get('products', [])
            if not page_products:
                break
                
            products.extend(page_products)
            print(f"Added {len(page_products)} products. Total so far: {len(products)}")
            page += 1
            time.sleep(1) # Be polite
        except Exception as e:
            print(f"Error fetching page {page}: {e}")
            break
            
    print(f"Fetched {len(products)} products from Shopify JSON. Now extracting specifications via Playwright...")
    
    # 2. Extract specifications from product pages
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        context = browser.new_context(user_agent="Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36")
        page_browser = context.new_page()
        
        for idx, product in enumerate(products):
            handle = product.get('handle')
            if not handle:
                continue
                
            product_url = f"https://consumer.bluestarindia.com/products/{handle}"
            print(f"[{idx+1}/{len(products)}] Scraping specs for: {product.get('title')}")
            
            try:
                page_browser.goto(product_url, wait_until="domcontentloaded", timeout=10000)
                
                # Extract tables
                specs = page_browser.evaluate('''() => {
                    const specifications = {};
                    document.querySelectorAll('table').forEach(table => {
                        table.querySelectorAll('tr').forEach(tr => {
                            const tds = tr.querySelectorAll('td, th');
                            if (tds.length >= 2) {
                                const key = tds[0].innerText.trim();
                                const val = tds[1].innerText.trim();
                                if (key && val) {
                                    specifications[key] = val;
                                }
                            }
                        });
                    });
                    return specifications;
                }''')
                
                product['specifications'] = specs
                
            except Exception as e:
                print(f" -> Failed to scrape specs for {handle}: {e}")
                product['specifications'] = {}
                
        browser.close()
            
    print(f"Finished adding specifications. Total B2C products: {len(products)}")
    
    with open("b2c_products.json", "w", encoding="utf-8") as f:
        json.dump(products, f, indent=4)
        
    print("Saved to b2c_products.json")

if __name__ == "__main__":
    scrape_b2c_products()
