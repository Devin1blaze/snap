# Plan: Homepage UI Enhancements

## Overview
- **Random Product Display**: Randomize product display for `.lg:col-span-7` inside `#panel-medical` and all industry panels on every request.
- **Blue Star Imagery**: Integrate downloaded Blue Star category images in `.py-24 > .container` ("Shop by Category").
- **Remove Redundant Tab**: Remove `#layer1-tabs > li > .layer1-btn` ("B2B Products") and present subcategories directly in the featured carousel tab bar.

## Execution Steps
1. Modify `front-page.php` with randomized queries, updated Blue Star image mapping, and streamlined category tab structure.
2. Verify PHP syntax with `php -l`.
3. Test homepage HTTP response and carousel AJAX responses.
