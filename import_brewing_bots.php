<?php
/**
 * Import Chai Point Brewing Bots into WooCommerce
 */

// Load WordPress from docker path or relative
if ( file_exists( '/var/www/html/wp-load.php' ) ) {
    require_once '/var/www/html/wp-load.php';
} else {
    require_once dirname( __DIR__, 3 ) . '/wp-load.php';
}

if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Access denied' );
}

echo "=== IMPORTING CHAI POINT BREWING BOTS ===\n";

// 1. Ensure category 'brewing-bots' exists
$cat_name = 'Brewing Bots';
$cat_slug = 'brewing-bots';
$cat_desc = 'Powered by AI-led Intelligent Brewing Platform, Chai Point Everywhere delivers consistent, home-like chai and café-style coffee across corporate offices and institutions - fresh, seamless, and always on through our automated Brewing Bots.';

$term = get_term_by( 'slug', $cat_slug, 'product_cat' );
if ( ! $term ) {
    $inserted = wp_insert_term( $cat_name, 'product_cat', array(
        'slug'        => $cat_slug,
        'description' => $cat_desc,
    ) );
    if ( is_wp_error( $inserted ) ) {
        die( 'Error creating category: ' . $inserted->get_error_message() . "\n" );
    }
    $cat_id = $inserted['term_id'];
    echo "Created category: {$cat_name} (ID: {$cat_id})\n";
} else {
    $cat_id = $term->term_id;
    wp_update_term( $cat_id, 'product_cat', array( 'description' => $cat_desc ) );
    echo "Found existing category: {$cat_name} (ID: {$cat_id})\n";
}

// B2B category linking
$b2b_term = get_term_by( 'slug', 'b2b', 'product_cat' );
$b2b_id = $b2b_term ? $b2b_term->term_id : 0;
$cat_ids = array_filter( array( $cat_id, $b2b_id ) );

// Helper to attach local image to media library
function snap_import_local_image( $file_path, $title ) {
    if ( ! file_exists( $file_path ) ) {
        echo "Image file not found: {$file_path}\n";
        return 0;
    }

    $upload_dir = wp_upload_dir();
    $filename = basename( $file_path );
    $dest_file = $upload_dir['path'] . '/' . $filename;

    // Check if attachment already exists
    global $wpdb;
    $existing = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type = 'attachment' LIMIT 1", $title ) );
    if ( $existing ) {
        return (int) $existing;
    }

    copy( $file_path, $dest_file );

    $file_type = wp_check_filetype( $filename, null );
    $attachment = array(
        'post_mime_type' => $file_type['type'] ?: 'image/webp',
        'post_title'     => sanitize_text_field( $title ),
        'post_content'   => '',
        'post_status'    => 'inherit'
    );

    $attach_id = wp_insert_attachment( $attachment, $dest_file );
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    $attach_data = wp_generate_attachment_metadata( $attach_id, $dest_file );
    wp_update_attachment_metadata( $attach_id, $attach_data );

    return $attach_id;
}

$theme_dir = get_template_directory();
$img_dir = $theme_dir . '/images/brewing-bots';

$products_data = array(
    array(
        'title'        => 'Leaf to Cup Brewing Bot',
        'sku'          => 'BOT-L2C-50',
        'suitability'  => 'Suitable for 50+ Employees',
        'img_file'     => $img_dir . '/leaf-to-cup.webp',
        'short_desc'   => "World's first Per Cup Brewing Bot. Dispenses authentic freshly brewed chai and filter coffee with instant on-demand cup preparation. Engineered for corporate offices with 50+ employees.",
        'long_desc'    => "<h3>World's First Per-Cup Brewing Bot</h3><p>Dispenses fresh chai and coffee with lowest intervention. Easy to clean and maintain with enclosed hoppers for ingredients.</p><h4>System Features</h4><ul><li>Home-Like Freshly Brewed Chai & Authentic Filter Coffee</li><li>Instant Per-Cup brewing of Chai</li><li>Automatic Batch brewing of Filter Coffee</li><li>Hoppers for Ingredients</li><li>Lowest Intervention</li><li>Easy to Clean & Maintain</li></ul><h4>Output Products</h4><ol><li>Freshly Brewed Chai (2 sugar & milk levels)</li><li>Freshly Brewed Kadak Chai (2 sugar & milk levels)</li><li>Black Chai</li><li>Authentic Filter Coffee</li><li>Strong Filter Coffee</li><li>Black Coffee</li><li>Hot Milk</li><li>Hot Water</li></ol>",
        'specs'        => array(
            array( 'name' => 'Suitability', 'value' => '50+ Employees' ),
            array( 'name' => 'Brewing Engine', 'value' => 'World’s First Per-Cup Instant Chai & Coffee Bot' ),
            array( 'name' => 'Dispensing Mode', 'value' => 'Instant Per-Cup Chai & Auto Batch Filter Coffee' ),
            array( 'name' => 'Output Menu', 'value' => '8 Beverages (Fresh Chai, Kadak, Black, Filter Coffee, Milk)' ),
            array( 'name' => 'Sugar & Milk Levels', 'value' => '2 Precision Dispensary Levels' ),
            array( 'name' => 'Ingredient Storage', 'value' => 'Enclosed High-Capacity Modular Hoppers' ),
            array( 'name' => 'Maintenance', 'value' => 'One-Touch Automated CIP Cleaning & Flushing' ),
            array( 'name' => 'Duty Cycle', 'value' => 'Continuous 24/7 Corporate & Institutional Operation' ),
        ),
    ),
    array(
        'title'        => 'Bean to Cup Brewing Bot',
        'sku'          => 'BOT-B2C-70',
        'suitability'  => 'Suitable for 70+ Employees',
        'img_file'     => $img_dir . '/bean-to-cup.webp',
        'short_desc'   => "Café-like coffee at enterprise scale with 24+ variants. Freshly ground and brewed coffee with high-convenience twin dispensers. Suitable for 70+ employees.",
        'long_desc'    => "<h3>Café-Like Coffee at Scale</h3><p>Freshly ground and brewed coffee from optical sensor bean hoppers with high-speed twin dispensing.</p><h4>System Features</h4><ul><li>Café-like quality of beverages</li><li>Freshly Ground & Brewed Coffee</li><li>24+ Variants</li><li>Hoppers for beans</li><li>Highly Convenient - twin dispenser for faster and multiple servings</li><li>Operational ease with auto cleaning and flushing</li></ul><h4>Output Products</h4><ol><li>Cappuccino</li><li>Café Latte</li><li>Americano</li><li>Espresso</li><li>Tea (Milk + Water)</li><li>Hot Milk</li><li>Hot Water</li></ol>",
        'specs'        => array(
            array( 'name' => 'Suitability', 'value' => '70+ Employees' ),
            array( 'name' => 'Brewing Engine', 'value' => 'Freshly Ground Bean-to-Cup Espresso Grinder' ),
            array( 'name' => 'Dispenser Type', 'value' => 'High-Speed Twin Spout Dispenser for Rapid Serving' ),
            array( 'name' => 'Menu Variety', 'value' => '24+ Café-Style Espresso & Hot Beverage Variants' ),
            array( 'name' => 'Bean Storage', 'value' => 'Aroma-Sealed Optical Sensor Bean Hoppers' ),
            array( 'name' => 'Cleaning', 'value' => 'Auto Cleaning, Steam Flushing & Descaling' ),
            array( 'name' => 'Power Requirement', 'value' => '230V AC, 50Hz Standard 16A Dedicated Supply' ),
            array( 'name' => 'Duty Cycle', 'value' => 'Continuous Commercial Office & Cafeteria Service' ),
        ),
    ),
    array(
        'title'        => 'Personal - Small Batch Brewing Bot',
        'sku'          => 'BOT-MCP-500',
        'suitability'  => 'Suitable for 500+ Employees',
        'img_file'     => $img_dir . '/personal-small.webp',
        'short_desc'   => "Automatic real-boiled fresh chai for batch brewing with customizable menu and IoT consumption tracking. Suitable for 500+ employees.",
        'long_desc'    => "<h3>Automatic 'Real-Boiled' Chai for Batch Brewing</h3><p>Engineered for corporate cafeterias and large institutional floors. Real-time consumption telemetry and on-demand batch brewing.</p><h4>System Features</h4><ul><li>Fresh and real boiled Chai</li><li>Large batch brewing</li><li>Customisable Menu</li><li>Easy and Automated Cleaning</li><li>Tracking real time consumption</li><li>Optimised On-demand preparation</li></ul><h4>Output Products</h4><ol><li>Freshly Brewed Chai</li><li>Freshly Brewed Kadak Chai</li><li>Freshly Brewed Masala Chai</li><li>Black Chai</li><li>Authentic Filter Coffee</li><li>Hot Milk</li><li>Hot Water</li></ol>",
        'specs'        => array(
            array( 'name' => 'Suitability', 'value' => '500+ Employees' ),
            array( 'name' => 'Brewing Engine', 'value' => 'Automated Real-Boiled Chai Multi-Cup Technology' ),
            array( 'name' => 'Batch Capacity', 'value' => 'High-Volume On-Demand Preparation' ),
            array( 'name' => 'IoT Telemetry', 'value' => 'Real-Time Cloud Consumption & Ingredients Tracking' ),
            array( 'name' => 'Customization', 'value' => 'Fully Customizable Corporate Enterprise Menu' ),
            array( 'name' => 'Hygiene System', 'value' => 'Automated Food-Grade CIP Cleaning Cycle' ),
            array( 'name' => 'Footprint', 'value' => 'Heavy-Duty Stainless Steel Countertop Architecture' ),
            array( 'name' => 'Warranty & AMC', 'value' => 'Comprehensive On-Site Maintenance Pan-India' ),
        ),
    ),
    array(
        'title'        => 'Personal - Large Campus Brewing Bot',
        'sku'          => 'BOT-MCP-750',
        'suitability'  => 'Suitable for 750+ Employees',
        'img_file'     => $img_dir . '/personal-large.webp',
        'short_desc'   => "Heavy-duty automated batch brewing engineered for large corporate cafeterias, university dining, and university campuses. Suitable for 750+ employees.",
        'long_desc'    => "<h3>High-Volume Campus Brewing</h3><p>Ultra high-volume batch brewing for heavy institutional peak hours with AI-led cloud consumption telemetry.</p><h4>System Features</h4><ul><li>Fresh and real boiled Chai</li><li>High volume large batch brewing</li><li>Customisable Menu</li><li>Easy and Automated Cleaning</li><li>Tracking real time consumption</li><li>Optimised On-demand preparation</li></ul><h4>Output Products</h4><ol><li>Freshly Brewed Chai</li><li>Freshly Brewed Kadak Chai</li><li>Freshly Brewed Masala Chai</li><li>Black Chai</li><li>Authentic Filter Coffee</li><li>Hot Milk</li><li>Hot Water</li></ol>",
        'specs'        => array(
            array( 'name' => 'Suitability', 'value' => '750+ Employees' ),
            array( 'name' => 'Brewing Engine', 'value' => 'Dual Boiled Chai & High-Capacity Industrial Brewing' ),
            array( 'name' => 'Batch Capacity', 'value' => 'Ultra High-Volume Large Campus & Institutional Serving' ),
            array( 'name' => 'IoT Telemetry', 'value' => 'Advanced AI-Led Cloud Consumption Analytics' ),
            array( 'name' => 'Dispense Speed', 'value' => 'Continuous High-Speed Campus Peak Hour Dispense' ),
            array( 'name' => 'Cleaning', 'value' => 'Automated Multi-Phase CIP Sanitization System' ),
            array( 'name' => 'Material', 'value' => 'Heavy Gauge SS 304 Food Grade Contact Surfaces' ),
            array( 'name' => 'Warranty & Support', 'value' => '24/7 Enterprise Key Account & Engineering Support' ),
        ),
    ),
);

foreach ( $products_data as $p ) {
    // Check if product already exists by SKU
    $existing_id = wc_get_product_id_by_sku( $p['sku'] );
    if ( ! $existing_id ) {
        // Also check by title
        $page = get_page_by_title( $p['title'], OBJECT, 'product' );
        if ( $page ) {
            $existing_id = $page->ID;
        }
    }

    $product = $existing_id ? wc_get_product( $existing_id ) : new WC_Product_Simple();
    $product->set_name( $p['title'] );
    $product->set_sku( $p['sku'] );
    $product->set_short_description( $p['short_desc'] );
    $product->set_description( $p['long_desc'] );
    $product->set_status( 'publish' );
    $product->set_catalog_visibility( 'visible' );
    $product->set_category_ids( $cat_ids );

    // Import/attach image
    $attach_id = snap_import_local_image( $p['img_file'], $p['title'] );
    if ( $attach_id > 0 ) {
        $product->set_image_id( $attach_id );
    }

    $product_id = $product->save();

    // Set B2B and custom specs meta
    update_post_meta( $product_id, '_product_design_type', 'b2b' );
    update_post_meta( $product_id, '_is_b2b', 'yes' );
    update_post_meta( $product_id, '_technical_specs', $p['specs'] );
    update_post_meta( $product_id, '_suitability', $p['suitability'] );
    update_post_meta( $product_id, '_brochure_url', 'https://www.chaipoint.com/brewing-bots/' );

    echo "Saved Product: {$p['title']} (ID: {$product_id}, SKU: {$p['sku']})\n";
}

echo "=== IMPORT COMPLETE ===\n";
