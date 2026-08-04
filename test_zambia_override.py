from cisco_scraper import CiscoPartnerScraper
s=CiscoPartnerScraper()
details = s.fetch_partner_details(787166, '136561002')
country='Zambia'
target_c = country.strip().upper()
cur_c = details.get('site_country', '').strip().upper()
print('Original:', cur_c)
print('Original address:', details.get('site_addr_1'))
print('Original phone:', details.get('site_phone'))
if cur_c != target_c:
    for loc in details.get('additionalLocations', []):
        if loc.get('site_country', '').strip().upper() == target_c:
            details.update(loc)
            break
print('Updated:', details.get('site_country', '').strip().upper())
print('Updated address:', details.get('site_addr_1'))
print('Updated phone:', details.get('site_phone'))
