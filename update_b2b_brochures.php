<?php
// update_b2b_brochures.php
// Run from browser: http://localhost:<port>/wp-content/themes/snap-stitch-theme/update_b2b_brochures.php

require_once dirname(__FILE__) . '/../../../wp-load.php';

if ( ! current_user_can('manage_options') ) {
    die("Unauthorized access. Please log in as an administrator first.");
}

echo "<pre>";
echo "Starting targeted B2B Brochure PDF update...\n\n";

$json_file = dirname(__FILE__) . '/../../b2b_products.json';

if ( ! file_exists( $json_file ) ) {
    die("Error: b2b_products.json not found at $json_file");
}

$json_data = file_get_contents($json_file);
$products = json_decode($json_data, true);

if ( ! $products ) {
    die("Error: Could not parse JSON data.");
}

$updated = 0;
$not_found = 0;
$skipped = 0;

foreach ($products as $p) {
    if ( empty($p['title']) ) {
        continue;
    }

    if ( empty($p['brochure_url']) ) {
        $skipped++;
        continue;
    }

    $title = $p['title'];
    $brochure_url = $p['brochure_url'];
    
    // First, try exact title match
    $post = get_page_by_title( $title, OBJECT, 'product' );
    
    if ( $post ) {
        $post_id = $post->ID;
        update_post_meta( $post_id, '_brochure_url', esc_url_raw($brochure_url) );
        echo "Updated brochure for product: $title (ID: $post_id)\n";
        $updated++;
    } else {
        // Try matching with like query if exact match fails
        global $wpdb;
        $fuzzy_post_id = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_type = 'product' AND post_title LIKE %s LIMIT 1", '%' . $wpdb->esc_like($title) . '%'));
        
        if ($fuzzy_post_id) {
            update_post_meta( $fuzzy_post_id, '_brochure_url', esc_url_raw($brochure_url) );
            echo "Updated brochure for product (Fuzzy Match): $title (ID: $fuzzy_post_id)\n";
            $updated++;
        } else {
            echo "Product not found in database: $title\n";
            $not_found++;
        }
    }
}

echo "\nDone! Updated: $updated, Not Found: $not_found, Skipped (No PDF): $skipped\n";
echo "</pre>";
