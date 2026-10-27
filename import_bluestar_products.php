<?php
// Ensure this script is run via WP-CLI
if ( 'cli' !== php_sapi_name() ) {
    die( "This script can only be run via WP-CLI.\n" );
}

if ( ! class_exists( 'WooCommerce' ) ) {
    die( "Error: WooCommerce is not active.\n" );
}

function process_csv_file( $file_path, $category_name, $category_slug ) {
    if ( ! file_exists( $file_path ) ) {
        echo "Error: File $file_path not found.\n";
        return;
    }

    echo "Processing $file_path...\n";

    // Ensure Category exists
    $term = term_exists( $category_slug, 'product_cat' );
    if ( ! $term ) {
        $term = wp_insert_term(
            $category_name,
            'product_cat',
            array(
                'description' => $category_name,
                'slug'        => $category_slug
            )
        );
    }
    if ( is_wp_error( $term ) ) {
        echo "Error creating category: " . $term->get_error_message() . "\n";
        return;
    }
    $cat_id = is_array( $term ) ? $term['term_id'] : $term;

    $imported = 0;
    $skipped  = 0;

    if ( ( $handle = fopen( $file_path, "r" ) ) !== FALSE ) {
        $headers = fgetcsv( $handle, 10000, "," ); // skip header
        
        while ( ( $data = fgetcsv( $handle, 10000, "," ) ) !== FALSE ) {
            // Map columns (assuming: 0=Type, 1=SKU, 2=Name, 3=Published, 4=Featured, 5=Visibility, 6=Short desc, 7=Desc, 8=Tax, 9=In stock, 10=Stock, 11=Price, 12=Cat, 13=Tags, 14=Images)
            // Wait, let's look for headers by index to be safe.
            $row = array_combine( $headers, $data );
            if ( ! $row ) continue;
            
            $sku = trim($row['SKU']);
            $title = trim($row['Name']);
            $price = trim($row['Regular price']);
            $description = trim($row['Description']);
            $short_desc = trim($row['Short description']);
            $images_str = trim($row['Images']);

            if ( empty($sku) || empty($title) ) continue;

            $product_id = wc_get_product_id_by_sku( $sku );

            if ( $product_id ) {
                echo "Skipping (Already exists): $title (SKU: $sku)\n";
                $skipped++;
                continue;
            }

            // Create new product
            $product = new WC_Product_Simple();
            $product->set_name( $title );
            $product->set_sku( $sku );
            $product->set_regular_price( $price );
            $product->set_price( $price );
            $product->set_description( $description );
            $product->set_short_description( $short_desc );
            $product->set_status( 'publish' );
            $product->set_category_ids( array( $cat_id ) );

            $product->set_manage_stock( true );
            $product->set_stock_quantity( 100 );
            $product->set_stock_status( 'instock' );
            
            // Handle images
            $image_urls = explode( ', ', $images_str );
            $gallery_ids = array();
            
            foreach ( $image_urls as $index => $img_url ) {
                $img_url = trim($img_url);
                if ( empty($img_url) ) continue;
                
                // Need to require media files
                require_once( ABSPATH . 'wp-admin/includes/media.php' );
                require_once( ABSPATH . 'wp-admin/includes/file.php' );
                require_once( ABSPATH . 'wp-admin/includes/image.php' );
                
                // Use media_sideload_image to download
                $attach_id = media_sideload_image( $img_url, 0, null, 'id' );
                if ( is_wp_error( $attach_id ) ) {
                    echo "Warning: Failed to upload image $img_url - " . $attach_id->get_error_message() . "\n";
                } else {
                    if ( $index === 0 ) {
                        $product->set_image_id( $attach_id );
                    } else {
                        $gallery_ids[] = $attach_id;
                    }
                }
            }
            if ( !empty($gallery_ids) ) {
                $product->set_gallery_image_ids( $gallery_ids );
            }

            $product_id = $product->save();

            if ( $product_id ) {
                echo "Imported: $title (SKU: $sku) - ID: $product_id\n";
                $imported++;
            } else {
                echo "Error: Failed to save $title (SKU: $sku)\n";
            }
        }
        fclose( $handle );
    }

    echo "Finished $category_name! Imported: $imported, Skipped: $skipped\n\n";
}

// Ensure the files are present in the same dir
$b2c_file = __DIR__ . '/bluestar_b2c_products_import.csv';
$b2b_file = __DIR__ . '/bluestar_b2b_products_import.csv';

process_csv_file( $b2c_file, 'B2C Products', 'b2c' );
process_csv_file( $b2b_file, 'B2B Products', 'b2b' );

echo "All done!\n";
