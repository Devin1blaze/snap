# Implementation Plan: Front Page Background and Category Image Cleanup

This plan reverts the homepage ("What We Do" and "Shop by Category") background colors and styles from the dark/gold look to the original light and corporate blue styles, and maps all categories to actual device/equipment images instead of generic stock photos.

---

## Proposed Changes

### [MODIFY] [front-page.php](file:///D:/projects/pro/snpmarketing%20without%20divi/wp-content/themes/snap-stitch-theme/front-page.php)

#### 1. What We Do Section Styles (Lines 218–260)
- Revert the section background from solid dark `bg-[#0A0A0A]` with gold borders (`border-y-4 border-[#FBBF24]`) to solid white background (`bg-white`).
- Change the badge background from gold (`bg-[#FBBF24]`) to blue (`bg-[#1A56DB]`) and text to white.
- Revert text colors (headings, paragraphs, feature list titles, and descriptions) from white/zinc-300 to dark near-black (`text-[#0A0A0A]` or `text-zinc-600`) for high legibility.

#### 2. Shop by Category Section Background & Accents (Lines 895–900)
- Revert the section background from dark `bg-[#0A0A0A]` with gold bottom border (`border-b-4 border-[#FBBF24]`) to solid primary blue (`bg-[#1A56DB]`).
- Revert the left accent title border from gold (`border-[#FBBF24]`) to white (`border-white`).

#### 3. Category Card Image & Style Updates (Lines 941–991)
- Remove the top-left gold highlight line (`bg-[#FBBF24]`) from category cards.
- Change the badge text color within category cards from gold (`text-[#FBBF24]`) to light blue (`text-blue-200`).
- Remove card border highlights (`hover:border-[#FBBF24]`) and use white border highlights on hover (`hover:border-white`).
- Update `$image_map` array to map WooCommerce category slugs to verified, high-resolution, actual device/equipment images:
  - **Air Conditioners**: Split/Cassette AC unit (`https://cdn.shopify.com/s/files/1/0888/8297/0937/files/GalleryImages01_ca918020-7737-49e4-add9-6b02c576b8f8.png?v=1768381311`)
  - **Air Coolers**: Industrial desert air cooler (`https://cdn.shopify.com/s/files/1/0888/8297/0937/files/CA120PMHFrontView.png?v=1729565417`)
  - **Water Purifiers**: RO water purifier filtration system (`https://images.unsplash.com/photo-1585829365295-ab7cd400c167?w=800&q=80`)
  - **Water Coolers**: Bottled water dispenser unit (`https://cdn.shopify.com/s/files/1/0888/8297/0937/files/BWD3FMCGA.png?v=1728630593`)
  - **Air Purifiers**: HEPA air purifier unit (`https://cdn.shopify.com/s/files/1/0888/8297/0937/files/ap700dai_hi-resolution-image-3.png?v=1728288642`)
  - **Commercial Refrigeration**: Commercial kitchen refrigerator/visi cooler (`https://cdn.shopify.com/s/files/1/0888/8297/0937/files/SC300F.png?v=1728630185`)
  - **Cold Storages**: Industrial cold storage facility (`https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=800&q=80`)
  - **Heat Pumps**: HVAC outdoor heat pump condenser unit (`https://images.unsplash.com/photo-1605647540924-852290f6b0d5?w=800&q=80`)

---

## Verification Plan

### Automated Verification
- Verify that all newly added category image URLs return `200 OK` (completed via background task logs).

### Manual Verification
- Re-run pre-flight check and verify syntax in `front-page.php`.
- Request user to open `http://localhost:8080/` to visually inspect the homepage sections.
