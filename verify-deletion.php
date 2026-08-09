<?php
// Load WordPress environment
$wp_load_path = dirname(dirname(dirname(dirname(__FILE__)))) . '/wp-load.php';
if (file_exists($wp_load_path)) {
    require_once($wp_load_path);
} else {
    die("wp-load.php not found at $wp_load_path");
}

global $wpdb;

echo "<h2>Deletion Verification Report</h2>\n";

// Count product posts
$products_count = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type = 'product'");
echo "<p>Remaining 'product' posts: " . intval($products_count) . "</p>\n";

// Count product_cat terms
$product_cats_count = $wpdb->get_var("
    SELECT COUNT(t.term_id) 
    FROM {$wpdb->terms} t 
    INNER JOIN {$wpdb->term_taxonomy} tt ON t.term_id = tt.term_id 
    WHERE tt.taxonomy = 'product_cat'
");
echo "<p>Remaining 'product_cat' terms: " . intval($product_cats_count) . "</p>\n";

// Count attachment posts
$attachments_count = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type = 'attachment'");
echo "<p>Remaining 'attachment' posts: " . intval($attachments_count) . "</p>\n";

echo "<p>Verification script completed.</p>\n";
