<?php
/**
 * Script to delete all WooCommerce products, attachments, and product categories.
 */

require_once('../../../wp-load.php');

// Security check


// 1. Delete all products
$products = get_posts(array(
    'post_type' => 'product',
    'posts_per_page' => -1,
    'post_status' => 'any'
));

$deleted_products = 0;
foreach ($products as $p) {
    if ( wp_delete_post($p->ID, true) ) { // Force delete bypassing trash
        $deleted_products++;
    }
}

// 2. Delete all product categories except uncategorized
$categories = get_terms(array(
    'taxonomy' => 'product_cat',
    'hide_empty' => false,
));

$deleted_categories = 0;
$kept_categories = array();
$slugs_to_keep = array('uncategorized'); // Keep default uncategorized to avoid Woo errors

foreach ($categories as $cat) {
    if ( ! in_array($cat->slug, $slugs_to_keep) ) {
        if ( wp_delete_term($cat->term_id, 'product_cat') ) {
            $deleted_categories++;
        }
    } else {
        $kept_categories[] = $cat->name . ' (' . $cat->slug . ')';
    }
}

// 3. Delete all attachments
$attachments = get_posts(array(
    'post_type' => 'attachment',
    'posts_per_page' => -1,
    'post_status' => 'any'
));

$deleted_attachments = 0;
foreach ($attachments as $a) {
    if ( wp_delete_post($a->ID, true) ) { // Force delete bypassing trash
        $deleted_attachments++;
    }
}

// Output results
echo "<h1>Deletion Complete</h1>";
echo "<p><strong>Products deleted:</strong> {$deleted_products}</p>";
echo "<p><strong>Categories deleted:</strong> {$deleted_categories}</p>";
echo "<p><strong>Attachments deleted:</strong> {$deleted_attachments}</p>";
echo "<p><strong>Categories kept:</strong> " . implode(', ', $kept_categories) . "</p>";
echo "<hr><p>You are now ready to re-upload the new products with correct info, pictures, and brochures.</p>";
