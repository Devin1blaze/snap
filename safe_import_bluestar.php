<?php
// safe_import_bluestar.php
// Run from browser: http://localhost:<port>/wp-content/themes/snap-stitch-theme/safe_import_bluestar.php

require_once dirname(__FILE__) . '/../../../wp-load.php';

if ( ! current_user_can('manage_options') ) {
    die("Unauthorized access. Please log in as an administrator first.");
}

echo "<pre>";
echo "Starting SAFE Import/Update...\n";
echo "This script updates descriptions and prices WITHOUT deleting PDFs or Technical Specifications!\n\n";

function safe_process_csv( $file_path, $category_name, $category_slug ) {
    if ( ! file_exists( $file_path ) ) {
        echo "Error: File $file_path not found.\n";
        return;
    }

    echo "Processing $file_path...\n";

    // Ensure Category exists
    $term = term_exists( $category_slug, 'product_cat' );
    if ( ! $term ) {
        $term = wp_insert_term( $category_name, 'product_cat', ['description' => $category_name, 'slug' => $category_slug] );
    }
    $cat_id = is_array( $term ) ? $term['term_id'] : (is_object($term) ? $term->term_id : $term);

    $imported = 0;
    $updated  = 0;

    if ( ( $handle = fopen( $file_path, "r" ) ) !== FALSE ) {
        $headers = fgetcsv( $handle, 10000, "," );
        
        while ( ( $data = fgetcsv( $handle, 10000, "," ) ) !== FALSE ) {
            $row = array_combine( $headers, $data );
            if ( ! $row ) continue;
            
            $sku = trim($row['SKU']);
            $title = trim($row['Name']);
            $price = trim($row['Regular price']);
            $description = trim($row['Description']);
            $short_desc = trim($row['Short description']);

            if ( empty($sku) || empty($title) ) continue;

            $product_id = wc_get_product_id_by_sku( $sku );

            if ( $product_id ) {
                $product = wc_get_product( $product_id );
                echo "Updating existing product: $title (SKU: $sku)\n";
                $updated++;
            } else {
                $product = new WC_Product_Simple();
                $product->set_sku( $sku );
                echo "Creating new product: $title (SKU: $sku)\n";
                $imported++;
            }

            // Update basic fields - THIS DOES NOT DELETE CUSTOM META (PDFs or Specs)
            $product->set_name( $title );
            $product->set_regular_price( $price );
            $product->set_description( $description );
            $product->set_short_description( $short_desc );
            $product->set_status( 'publish' );
            $product->set_category_ids( array( $cat_id ) );

            $product->save();
        }
        fclose( $handle );
    }

    echo "Finished $category_name! Created: $imported, Updated: $updated\n\n";
}

$b2c_file = __DIR__ . '/bluestar_b2c_products_import.csv';
$b2b_file = __DIR__ . '/bluestar_b2b_products_import.csv';

safe_process_csv( $b2c_file, 'B2C Products', 'b2c' );
safe_process_csv( $b2b_file, 'B2B Products', 'b2b' );

echo "All done!\n";
echo "</pre>";
