from playwright.sync_api import sync_playwright
import json

def extract_b2b_categories(page):
    print("Scraping B2B: https://www.bluestarindia.com/")
    page.goto("https://www.bluestarindia.com/", wait_until="domcontentloaded")
    
    # We execute JS in the page context to scrape the menu
    b2b_categories = page.evaluate('''() => {
        const categories = [];
        // Typically B2B Blue Star has a 'Products' menu. Let's find all top level li in nav
        const nav = document.querySelector('nav') || document.querySelector('.menu');
        if (!nav) return categories;
        
        const mainUl = nav.querySelector('ul');
        if (!mainUl) return categories;
        
        const listItems = mainUl.querySelectorAll(':scope > li');
        listItems.forEach(li => {
            const a = li.querySelector(':scope > a');
            if (!a) return;
            const name = a.innerText.trim();
            if (name.toLowerCase() === 'home' || !name) return;
            
            const subcats = [];
            const subUl = li.querySelector('ul');
            if (subUl) {
                const subLinks = subUl.querySelectorAll('a');
                subLinks.forEach(subA => {
                    const subName = subA.innerText.trim();
                    if (subName) subcats.push(subName);
                });
            }
            categories.append({ name: name, subcategories: subcats });
        });
        return categories;
    }''')
    
    # Python fix: js returning append won't work in js, use push
    # Wait, the js above has categories.append, it should be categories.push
    return b2b_categories

def extract_b2c_categories(page):
    print("Scraping B2C: https://consumer.bluestarindia.com/")
    page.goto("https://consumer.bluestarindia.com/", wait_until="domcontentloaded")
    
    b2c_categories = page.evaluate('''() => {
        const categories = [];
        const nav = document.querySelector('nav') || document.querySelector('.header__inline-menu');
        if (!nav) return categories;
        
        const listItems = nav.querySelectorAll('li');
        // A simple heuristic: find links that have dropdowns
        const topLevelLinks = nav.querySelectorAll(':scope > ul > li');
        
        topLevelLinks.forEach(li => {
            let name = "";
            let summary = li.querySelector('summary');
            if (summary) {
                name = summary.innerText.trim();
            } else {
                const a = li.querySelector('a');
                if (a) name = a.innerText.trim();
            }
            
            if (!name || name.toLowerCase() === 'home') return;
            
            const subcats = [];
            const subLinks = li.querySelectorAll('ul a');
            subLinks.forEach(a => {
                const subName = a.innerText.trim();
                if (subName) subcats.push(subName);
            });
            
            categories.push({ name: name, subcategories: subcats });
        });
        return categories;
    }''')
    
    return b2c_categories

def main():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        context = browser.new_context(user_agent="Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36")
        page = context.new_page()
        
        try:
            # Re-write the js logic properly inside evaluate
            print("Extracting B2B...")
            page.goto("https://www.bluestarindia.com/", wait_until="networkidle")
            b2b = page.evaluate('''() => {
                const categories = [];
                const nav = document.querySelector('nav') || document.querySelector('#cssmenu');
                if (!nav) return categories;
                
                const mainUl = nav.querySelector('ul');
                if (!mainUl) return categories;
                
                const listItems = mainUl.querySelectorAll(':scope > li');
                listItems.forEach(li => {
                    const a = li.querySelector(':scope > a');
                    if (!a) return;
                    const name = a.innerText.trim();
                    if (name.toLowerCase() === 'home' || !name) return;
                    
                    const subcats = [];
                    const subUl = li.querySelector('ul');
                    if (subUl) {
                        const subLinks = subUl.querySelectorAll('a');
                        subLinks.forEach(subA => {
                            const subName = subA.innerText.trim();
                            if (subName) subcats.push(subName);
                        });
                    }
                    categories.push({ name: name, subcategories: subcats });
                });
                return categories;
            }''')
            print(f"Found {len(b2b)} B2B categories.")
            
            print("Extracting B2C...")
            page.goto("https://consumer.bluestarindia.com/", wait_until="networkidle")
            b2c = page.evaluate('''() => {
                const categories = [];
                const nav = document.querySelector('nav') || document.querySelector('.header__inline-menu');
                if (!nav) return categories;
                
                const topLevelLinks = nav.querySelectorAll('ul > li');
                // The structure is often nested, let's grab the first level ul's lis
                const mainUl = nav.querySelector('ul');
                if (!mainUl) return categories;
                
                const lis = mainUl.querySelectorAll(':scope > li');
                lis.forEach(li => {
                    let name = "";
                    let summary = li.querySelector('summary');
                    if (summary) {
                        name = summary.innerText.trim();
                    } else {
                        const a = li.querySelector(':scope > a');
                        if (a) name = a.innerText.trim();
                    }
                    
                    if (!name || name.toLowerCase() === 'home') return;
                    
                    const subcats = [];
                    const subLinks = li.querySelectorAll('ul a');
                    subLinks.forEach(a => {
                        const subName = a.innerText.trim();
                        if (subName) subcats.push(subName);
                    });
                    
                    categories.push({ name: name, subcategories: subcats });
                });
                return categories;
            }''')
            print(f"Found {len(b2c)} B2C categories.")
            
            result = {
                "b2b_categories": b2b,
                "b2c_categories": b2c
            }
            
            with open("bluestar_categories.json", "w", encoding="utf-8") as f:
                json.dump(result, f, indent=4)
                
            print("Successfully saved to bluestar_categories.json")
            
        except Exception as e:
            print(f"Error: {e}")
            
        finally:
            browser.close()

if __name__ == "__main__":
    main()
