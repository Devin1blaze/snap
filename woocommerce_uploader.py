import os
import csv
import logging
from woocommerce import API

logging.basicConfig(level=logging.INFO, format='%(asctime)s - %(levelname)s - %(message)s')

def setup_woocommerce_api():
    url = os.environ.get("WC_URL", "")
    key = os.environ.get("WC_KEY", "")
    secret = os.environ.get("WC_SECRET", "")
    
    if not url or not key or not secret:
        logging.error("Missing WooCommerce credentials. Please set WC_URL, WC_KEY, and WC_SECRET environment variables.")
        logging.error("Example:")
        logging.error("  Windows (PowerShell): $env:WC_URL='https://yoursite.com'; $env:WC_KEY='ck_...'; $env:WC_SECRET='cs_...'")
        logging.error("  Linux/Mac: export WC_URL='https://yoursite.com' WC_KEY='ck_...' WC_SECRET='cs_...'")
        return None

    return API(
        url=url,
        consumer_key=key,
        consumer_secret=secret,
        version="wc/v3",
        timeout=30
    )

def fetch_existing_skus(wcapi):
    logging.info("Fetching existing SKUs from WooCommerce...")
    skus = set()
    page = 1
    while True:
        try:
            response = wcapi.get("products", params={"per_page": 100, "page": page, "_fields": "sku"})
            if response.status_code != 200:
                logging.error(f"Failed to fetch products: {response.text}")
                break
            
            products = response.json()
            if not products:
                break
                
            for p in products:
                if p.get('sku'):
                    skus.add(p['sku'])
            page += 1
        except Exception as e:
            logging.error(f"Error fetching products: {e}")
            break
            
    logging.info(f"Found {len(skus)} existing products with SKUs.")
    return skus

def upload_products_from_csv(wcapi, csv_path, existing_skus):
    if not os.path.exists(csv_path):
        logging.warning(f"File {csv_path} not found. Skipping.")
        return
        
    logging.info(f"Starting upload for {csv_path}...")
    
    with open(csv_path, 'r', encoding='utf-8') as f:
        reader = csv.DictReader(f)
        
        for row in reader:
            sku = row.get('SKU')
            
            if not sku:
                logging.warning(f"Skipping product with missing SKU: {row.get('Name')}")
                continue
                
            if sku in existing_skus:
                logging.info(f"Skipping duplicate product (SKU: {sku}) - {row.get('Name')}")
                continue
                
            # Prepare image array
            images = []
            img_string = row.get('Images', '')
            if img_string:
                for img_url in img_string.split(','):
                    url = img_url.strip()
                    if url:
                        images.append({"src": url})
            
            # Prepare product payload
            data = {
                "name": row.get('Name'),
                "type": "simple",
                "regular_price": row.get('Regular price', ''),
                "sale_price": row.get('Sale price', ''),
                "description": row.get('Description', ''),
                "short_description": row.get('Short description', ''),
                "sku": sku,
                "manage_stock": True,
                "stock_quantity": row.get('Stock', 100),
                "in_stock": True if row.get('In stock?', '1') == '1' else False,
                "images": images
            }
            
            logging.info(f"Uploading: {sku} - {row.get('Name')}")
            try:
                response = wcapi.post("products", data)
                if response.status_code in [200, 201]:
                    logging.info(f"Successfully created {sku}")
                    existing_skus.add(sku)
                else:
                    logging.error(f"Failed to create {sku}: {response.text}")
            except Exception as e:
                logging.error(f"Exception creating {sku}: {e}")

def main():
    wcapi = setup_woocommerce_api()
    if not wcapi:
        return
        
    existing_skus = fetch_existing_skus(wcapi)
    
    upload_products_from_csv(wcapi, 'bluestar_b2c_products_import.csv', existing_skus)
    upload_products_from_csv(wcapi, 'bluestar_b2b_products_import.csv', existing_skus)
    
    logging.info("Upload process complete!")

if __name__ == "__main__":
    main()
