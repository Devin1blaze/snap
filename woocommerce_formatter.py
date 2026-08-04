import json
import csv
import os
import re

def clean_html(raw_html):
    if not raw_html: return ""
    cleanr = re.compile('<.*?>')
    cleantext = re.sub(cleanr, '', raw_html)
    return cleantext.strip().replace('\n', ' ')

def main():
    print("Starting WooCommerce CSV Formatter...")
    b2c_file = "b2c_products.json"
    b2b_file = "b2b_products.json"
    
    b2c_products = []
    b2b_products = []
    
    # Read B2C
    if os.path.exists(b2c_file):
        with open(b2c_file, "r", encoding="utf-8") as f:
            b2c_data = json.load(f)
            
        for item in b2c_data:
            sku = item.get('id', '')
            price = ""
            regular_price = ""
            if item.get('variants'):
                v = item['variants'][0]
                sku = v.get('sku') or sku
                price = v.get('price', '')
                regular_price = v.get('compare_at_price', price)
                
            img_urls = []
            for img in item.get('images', []):
                if 'src' in img:
                    img_urls.append(img['src'].split('?')[0])
                    
            categories = item.get('product_type', '')
            if not categories:
                # Try tags
                tags = item.get('tags', [])
                if tags:
                    categories = tags[0]
                    
            # WooCommerce fields
            product = {
                'Type': 'simple',
                'SKU': sku,
                'Name': item.get('title', ''),
                'Published': 1,
                'Is featured?': 0,
                'Visibility in catalog': 'visible',
                'Short description': '',
                'Description': item.get('body_html', ''),
                'In stock?': 1,
                'Stock': 100,
                'Regular price': regular_price,
                'Sale price': price if price != regular_price else "",
                'Categories': categories,
                'Images': ", ".join(img_urls)
            }
            b2c_products.append(product)
            
    # Read B2B
    if os.path.exists(b2b_file):
        with open(b2b_file, "r", encoding="utf-8") as f:
            b2b_data = json.load(f)
            
        for idx, item in enumerate(b2b_data):
            title = item.get('title', '')
            desc = item.get('description', '')
            features = item.get('features', [])
            if features:
                desc += "<br><br><b>Features:</b><ul>" + "".join([f"<li>{x}</li>" for x in features]) + "</ul>"
                
            # Try to infer category from url
            url = item.get('url', '')
            parts = url.split('/')
            category = ''
            if len(parts) > 3:
                category = parts[-2].replace('-', ' ').title()
                
            product = {
                'Type': 'simple',
                'SKU': f"B2B-{idx+1000}",
                'Name': title,
                'Published': 1,
                'Is featured?': 0,
                'Visibility in catalog': 'visible',
                'Short description': '',
                'Description': desc,
                'In stock?': 1,
                'Stock': 100,
                'Regular price': "", # B2B has no public price
                'Sale price': "",
                'Categories': category,
                'Images': ", ".join([url.split('?')[0] for url in item.get('images', [])])
            }
            b2b_products.append(product)
            
    # Write B2C to CSV
    if b2c_products:
        csv_file_b2c = "bluestar_b2c_products_import.csv"
        keys = b2c_products[0].keys()
        with open(csv_file_b2c, "w", newline='', encoding="utf-8") as f:
            dict_writer = csv.DictWriter(f, fieldnames=keys)
            dict_writer.writeheader()
            dict_writer.writerows(b2c_products)
        print(f"Successfully generated {csv_file_b2c} with {len(b2c_products)} products.")

    # Write B2B to CSV
    if b2b_products:
        csv_file_b2b = "bluestar_b2b_products_import.csv"
        keys = b2b_products[0].keys()
        with open(csv_file_b2b, "w", newline='', encoding="utf-8") as f:
            dict_writer = csv.DictWriter(f, fieldnames=keys)
            dict_writer.writeheader()
            dict_writer.writerows(b2b_products)
        print(f"Successfully generated {csv_file_b2b} with {len(b2b_products)} products.")

if __name__ == "__main__":
    main()
