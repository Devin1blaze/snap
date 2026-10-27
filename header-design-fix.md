# Header Design Restoration & Mega-Menu Fix

The complete design of the header menu was accidentally reverted to an older, mismatched version (header_old.php) in a previous session while attempting to fix a 500 Critical Error. The user dislikes the older design's fonts, edges, and width, but likes its dark background color. We need to restore the advanced "Havells-style" mega-menu design and integrate it flawlessly.

## Goal
Restore the modern, full-width header design (with correct fonts and edges) and the two-panel "Havells-style" mega-menu, while preserving the newly favored dark background color. Ensure the site remains crash-free.

## Root Cause of the Previous 500 Error
The advanced header.php defined a PHP class (Snap_Mega_Menu_Walker) directly inside the template file. If get_header() was called more than once (e.g., by a plugin or specific page template), PHP threw a fatal "Cannot redeclare class" error. This is why the site crashed originally.

## Proposed Changes

### 1. File Relocation (Crash Prevention)
- Extract Snap_Mega_Menu_Walker from the old header.php and move it into a dedicated file: wp-content/themes/snap-stitch-theme/class-snap-mega-menu-walker.php.
- Include this new file safely in unctions.php.

### 2. Header Template Restoration
- git checkout the previous version of header.php (the modern design).
- Remove the inline walker class definition from header.php.
- Ensure the header uses the dark background color (g-[#0A0A0A]) that the user liked from the temporary fallback.
- Verify fonts and full-width container classes match the user's expectations (w-full, max-w-none, etc.).

### 3. Dynamic Menu Injection Compatibility
- The wp_nav_menu_objects injection logic we added to unctions.php is robust and will work perfectly with the restored Snap_Mega_Menu_Walker. 
- We will ensure Snap_Mega_Menu_Walker properly respects the injected menu-item-has-children and group classes we just added.

## User Review Required

> [!IMPORTANT]
> The previous "Havells-style" mega menu used a very specific two-panel layout for categories. I will restore this layout and apply the dark background color you liked. 
> 
> Does this approach sound good? Once you approve, I will safely restore the design without risking any site crashes!
