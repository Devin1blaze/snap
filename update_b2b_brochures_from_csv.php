<?php
// update_b2b_brochures_from_csv.php
// Run from browser: http://localhost:<port>/wp-content/themes/snap-stitch-theme/update_b2b_brochures_from_csv.php

require_once dirname(__FILE__) . '/../../../wp-load.php';

if ( ! current_user_can('manage_options') ) {
    die("Unauthorized access. Please log in as an administrator first.");
}

echo "<pre>";
echo "Starting targeted B2B Brochure PDF update from CSV...\n\n";

$csv_file = dirname(__FILE__) . '/../../bluestar_b2b_products_import.csv';

if ( ! file_exists( $csv_file ) ) {
    die("Error: bluestar_b2b_products_import.csv not found at $csv_file");
}

$updated = 0;
$not_found = 0;
$skipped = 0;

if ( ( $handle = fopen( $csv_file, "r" ) ) !== FALSE ) {
    $headers = fgetcsv( $handle, 10000, "," );
    
    // Find column indexes
    $name_idx = array_search('Name', $headers);
    $brochure_idx = array_search('Meta: _brochure_url', $headers);
    
    if ( $name_idx === false || $brochure_idx === false ) {
        die("Error: Required columns not found in CSV.");
    }
    
    while ( ( $data = fgetcsv( $handle, 10000, "," ) ) !== FALSE ) {
        if ( count($data) <= max($name_idx, $brochure_idx) ) continue;
        
        $title = trim($data[$name_idx]);
        $brochure_url = trim($data[$brochure_idx]);

        if ( empty($title) ) continue;

        if ( empty($brochure_url) ) {
            $skipped++;
            continue;
        }
        
        // Match exact title
        $post = get_page_by_title( $title, OBJECT, 'product' );
        
        if ( $post ) {
            $post_id = $post->ID;
            update_post_meta( $post_id, '_brochure_url', esc_url_raw($brochure_url) );
            echo "Updated brochure for product: $title (ID: $post_id)\n";
            $updated++;
        } else {
            // Fuzzy match
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
    fclose( $handle );
}

echo "\nDone! Updated: $updated, Not Found: $not_found, Skipped (No PDF): $skipped\n";
echo "</pre>";
