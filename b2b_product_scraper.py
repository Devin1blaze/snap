import json
from playwright.sync_api import sync_playwright
import xml.etree.ElementTree as ET

def scrape_b2b_products():
    print("Starting B2B Product Scraper (Playwright)...")
    products = []
    
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        context = browser.new_context(user_agent="Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36")
        page = context.new_page()
        
        # 1. Get Sitemap
        print("Fetching sitemap...")
        page.goto("https://www.bluestarindia.com/sitemap.xml", wait_until="domcontentloaded")
        sitemap_content = page.content()
        
        # 2. Extract product URLs
        # The page content might be wrapped in HTML if viewed in browser, let's extract the raw text
        raw_xml = page.evaluate("() => document.body.innerText")
        if not raw_xml.strip().startswith('<?xml'):
             # fallback, just regex the page.content()
             import re
             urls = re.findall(r'<loc>(.*?)</loc>', sitemap_content)
        else:
            try:
                root = ET.fromstring(raw_xml)
                urls = [elem.text for elem in root.iter('{http://www.sitemaps.org/schemas/sitemap/0.9}loc')]
            except:
                import re
                urls = re.findall(r'<loc>(.*?)</loc>', sitemap_content)

        print(f"Found {len(urls)} total URLs in sitemap.")
        
        # Filter product URLs
        # A B2B product URL typically looks like /commercial-refrigeration/deep-freezers/hard-top
        # or /roomacs/inverter-split-acs
        # We will exclude generic pages like /about-us, /contact-us, /careers, /locations, /investors, /media
        excluded = ['about-us', 'contact-us', 'careers', 'locations', 'investors', 'media', 'customer-service', 'dealer-locator']
        product_urls = []
        for u in urls:
            if not u: continue
            if u == "https://www.bluestarindia.com/": continue
            if any(ex in u for ex in excluded): continue
            # Only deeper paths (more than 1 slash after .com/) are products
            path = u.replace("https://www.bluestarindia.com/", "")
            if "/" in path and not path.endswith('/index.html'):
                product_urls.append(u)
                
        print(f"Filtered to {len(product_urls)} potential product URLs.")
        
        # 3. Scrape each product
        for url in product_urls:
            print(f"Scraping: {url}")
            try:
                page.goto(url, wait_until="domcontentloaded", timeout=15000)
                
                # Check if it's actually a product page (has a product title)
                product_data = page.evaluate('''() => {
                    const titleEl = document.querySelector('h1, h2.product-title, .banner-title');
                    if (!titleEl) return null;
                    const title = titleEl.innerText.trim();
                    if (!title || title.toLowerCase().includes('about')) return null;
                    
                    // description
                    let desc = "";
                    const descEl = document.querySelector('.overview-text, .product-desc, p');
                    if (descEl) desc = descEl.innerText.trim();
                    
                    // images
                    const imgUrls = [];
                    document.querySelectorAll('img').forEach(img => {
                        const src = img.src;
                        if (src && !src.includes('logo') && !src.includes('icon') && src.includes('bluestarindia')) {
                            imgUrls.push(src);
                        }
                    });
                    
                    // features/specs
                    const specs = [];
                    document.querySelectorAll('.features-list li, .spec-list li, .features ul li').forEach(li => {
                        specs.push(li.innerText.trim());
                    });
                    
                    return {
                        title: title,
                        url: window.location.href,
                        description: desc,
                        images: Array.from(new Set(imgUrls)), // all unique images
                        features: specs
                    };
                }''')
                
                if product_data:
                    products.append(product_data)
                    print(f" -> Found Product: {product_data['title']}")
                else:
                    print(" -> No product data found on page.")
                    
            except Exception as e:
                print(f" -> Failed to scrape: {e}")
                
        browser.close()
        
    print(f"Finished. Total B2B products: {len(products)}")
    
    with open("b2b_products.json", "w", encoding="utf-8") as f:
        json.dump(products, f, indent=4)
        
    print("Saved to b2b_products.json")

if __name__ == "__main__":
    scrape_b2b_products()
