import urllib.request
import json
import time

def scrape_b2c_products():
    print("Starting B2C Product Scraper (Shopify)...")
    products = []
    page = 1
    limit = 250
    
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
            
    print(f"Finished. Total B2C products: {len(products)}")
    
    with open("b2c_products.json", "w", encoding="utf-8") as f:
        json.dump(products, f, indent=4)
        
    print("Saved to b2c_products.json")

if __name__ == "__main__":
    scrape_b2c_products()
