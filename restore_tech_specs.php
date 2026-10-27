<?php
// restore_tech_specs.php

// Load WordPress
require_once dirname(__FILE__) . '/../../../wp-load.php';

// Check if user is logged in as admin to prevent unauthorized access
if ( ! current_user_can('manage_options') ) {
    die("Unauthorized access. Please log in as an administrator first.");
}

echo "<pre>";
echo "Starting to restore technical specifications...\n\n";

$files_to_check = [
    dirname(__FILE__) . '/old_site_products.json',
    dirname(__FILE__) . '/b2b_products.json',
    dirname(__FILE__) . '/b2c_products.json',
    dirname(__FILE__) . '/../../../old_site_products.json',
    dirname(__FILE__) . '/../../../products_consumer.json',
    dirname(__FILE__) . '/../../../products_b2b.json',
    dirname(__FILE__) . '/../../../products_seo.json'
];

$updated = 0;
$not_found = 0;

foreach ($files_to_check as $file_path) {
    if ( ! file_exists( $file_path ) ) {
        continue;
    }
    echo "Checking $file_path...\n";
    $json_data = file_get_contents($file_path);
    $products = json_decode($json_data, true);

    if ( ! $products ) {
        continue;
    }

    foreach ($products as $p) {
        if ( empty($p['title']) || empty($p['specifications']) || !is_array($p['specifications']) ) {
            continue;
        }

        $title = $p['title'];
        
        $post = get_page_by_title( $title, OBJECT, 'product' );
        
        if ( $post ) {
            $post_id = $post->ID;
            $specs = [];
            foreach ( $p['specifications'] as $name => $val ) {
                $specs[] = [
                    'name' => $name,
                    'value' => $val,
                ];
            }
            
            update_post_meta( $post_id, '_technical_specs', $specs );
            echo "Restored specs for product: $title (ID: $post_id)\n";
            $updated++;
        } else {
            // Try matching with like query if exact match fails
            global $wpdb;
            $fuzzy_post_id = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_type = 'product' AND post_title LIKE %s LIMIT 1", '%' . $wpdb->esc_like($title) . '%'));
            
            if ($fuzzy_post_id) {
                $specs = [];
                foreach ( $p['specifications'] as $name => $val ) {
                    $specs[] = [
                        'name' => $name,
                        'value' => $val,
                    ];
                }
                update_post_meta( $fuzzy_post_id, '_technical_specs', $specs );
                echo "Restored specs for product (Fuzzy Match): $title (ID: $fuzzy_post_id)\n";
                $updated++;
            } else {
                echo "Product not found: $title\n";
                $not_found++;
            }
        }
    }
}

echo "\nDone! Updated: $updated, Not Found: $not_found\n";
echo "</pre>";
