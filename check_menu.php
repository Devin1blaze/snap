<?php
/**
 * Assign unassigned categories to primary menu (ID 21, Snap Primary Menu V2)
 */

if (!defined('ABSPATH')) {
    require_once('/var/www/html/wp-load.php');
}

$target_menu_id = 21;
$menu = wp_get_nav_menu_object($target_menu_id);

if (!$menu) {
    echo "Menu ID $target_menu_id not found directly. Searching by name 'Snap Primary Menu V2'...\n";
    $menu = get_term_by('name', 'Snap Primary Menu V2', 'nav_menu');
    if ($menu) {
        $target_menu_id = $menu->term_id;
    } else {
        $menus = wp_get_nav_menus();
        echo "Available menus:\n";
        foreach ($menus as $m) {
            echo "- ID: {$m->term_id}, Name: '{$m->name}', Slug: '{$m->slug}'\n";
            if (stripos($m->name, 'Primary') !== false || stripos($m->name, 'V2') !== false) {
                $target_menu_id = $m->term_id;
                $menu = $m;
            }
        }
    }
}

if (!$menu) {
    echo "ERROR: Primary menu could not be resolved.\n";
    exit(1);
}

echo "Using Menu ID: {$target_menu_id} (Name: '{$menu->name}')\n";

// Get existing menu items
$existing_items = wp_get_nav_menu_items($target_menu_id) ?: array();
$existing_term_ids = array();
$existing_titles = array();

foreach ($existing_items as $item) {
    if ($item->type === 'taxonomy') {
        $existing_term_ids[] = (int)$item->object_id;
    }
    $existing_titles[strtolower(trim($item->title))] = true;
}

echo "Currently assigned items in menu {$target_menu_id}: " . count($existing_items) . "\n";
echo "Currently assigned taxonomy term IDs in menu {$target_menu_id}: " . count($existing_term_ids) . "\n";

// Load unassigned.txt if present
$unassigned_txt_path = '/var/www/html/unassigned.txt';
if (!file_exists($unassigned_txt_path)) {
    $unassigned_txt_path = ABSPATH . 'unassigned.txt';
}

$unassigned_names = array();
if (file_exists($unassigned_txt_path)) {
    $lines = file($unassigned_txt_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $name = trim($line);
        if ($name !== '') {
            $unassigned_names[] = $name;
        }
    }
    echo "Loaded " . count($unassigned_names) . " items from unassigned.txt\n";
} else {
    echo "unassigned.txt file not found at $unassigned_txt_path\n";
}

// Fetch all product categories & standard categories
$all_terms = get_terms(array(
    'taxonomy'   => array('product_cat', 'category'),
    'hide_empty' => false,
));

if (is_wp_error($all_terms)) {
    echo "ERROR fetching terms: " . $all_terms->get_error_message() . "\n";
    exit(1);
}

echo "Total categories found in WordPress DB: " . count($all_terms) . "\n";

$unassigned_categories = array();

foreach ($all_terms as $term) {
    // Skip if term is already in the menu by term_id
    if (in_array((int)$term->term_id, $existing_term_ids, true)) {
        continue;
    }
    
    // Skip if term title matches an existing menu item title
    if (isset($existing_titles[strtolower(trim($term->name))])) {
        continue;
    }
    
    // Skip default uncategorized
    if ($term->slug === 'uncategorized') {
        continue;
    }
    
    $unassigned_categories[$term->term_id] = $term;
}

echo "Found " . count($unassigned_categories) . " unassigned categories to add to Menu {$target_menu_id}.\n";

$assigned_count = 0;
$error_count = 0;

foreach ($unassigned_categories as $term_id => $term) {
    $menu_item_data = array(
        'menu-item-object-id' => $term->term_id,
        'menu-item-object'    => $term->taxonomy,
        'menu-item-type'      => 'taxonomy',
        'menu-item-status'    => 'publish',
        'menu-item-title'     => $term->name,
    );

    $result = wp_update_nav_menu_item($target_menu_id, 0, $menu_item_data);

    if (is_wp_error($result) || !$result) {
        $err_msg = is_wp_error($result) ? $result->get_error_message() : "Unknown error";
        echo "FAILED: Category '{$term->name}' (ID: {$term->term_id}, Tax: {$term->taxonomy}) - Error: {$err_msg}\n";
        $error_count++;
    } else {
        echo "SUCCESS: Category '{$term->name}' (ID: {$term->term_id}, Tax: {$term->taxonomy}) assigned to Menu {$target_menu_id} (Menu Item ID: {$result})\n";
        $assigned_count++;
        $existing_term_ids[] = (int)$term->term_id;
    }
}

echo "\n================ FINAL REPORT ================\n";
echo "STATUS: " . ($error_count === 0 ? "SUCCESS" : "PARTIAL_SUCCESS") . "\n";
echo "TOTAL_UNASSIGNED_CATEGORIES_FOUND: " . count($unassigned_categories) . "\n";
echo "TOTAL_CATEGORIES_ASSIGNED: {$assigned_count}\n";
echo "TOTAL_ERRORS: {$error_count}\n";
echo "FINAL_TOTAL_MENU_ITEMS: " . count(wp_get_nav_menu_items($target_menu_id)) . "\n";
