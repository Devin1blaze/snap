<?php
/**
 * Nestle Professional Commercial Coffee Vending Machines Seeder
 *
 * Seeds 6 Nestlé Professional commercial vending machines into WooCommerce:
 * PREMIO, AMIGO, DUO GUSTO, SOLUTION 2.0, SPECTRA TRIPLE OPTION, FRIO.
 *
 * Path: wp-content/themes/snap-stitch-theme/import_nestle_machines.php
 * @package SnapStitchTheme
 */

if ( ! isset( $_SERVER['HTTP_HOST'] ) ) {
    $_SERVER['HTTP_HOST'] = 'localhost';
}
if ( php_sapi_name() !== 'cli' ) {
    header( 'Content-Type: text/plain; charset=utf-8' );
}

// Bootstrap WordPress
if ( file_exists( '/var/www/html/wp-load.php' ) ) {
    require_once '/var/www/html/wp-load.php';
} elseif ( file_exists( dirname( __DIR__, 3 ) . '/wp-load.php' ) ) {
    require_once dirname( __DIR__, 3 ) . '/wp-load.php';
} elseif ( file_exists( __DIR__ . '/../../../wp-load.php' ) ) {
    require_once __DIR__ . '/../../../wp-load.php';
}

if ( ! defined( 'ABSPATH' ) || ! class_exists( 'WooCommerce' ) ) {
    fwrite( STDERR, "Error: WordPress and WooCommerce must be initialized.\n" );
    exit( 1 );
}

require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

echo "=================================================================\n";
echo "   NESTLÉ PROFESSIONAL COMMERCIAL VENDING MACHINES SEEDER        \n";
echo "=================================================================\n\n";

/**
 * Import local image to WordPress Media Library.
 */
function snap_seed_attachment( $file_path, $title, $parent_id = 0 ) {
    if ( ! file_exists( $file_path ) ) {
        echo "  [WARN] Source image not found: {$file_path}\n";
        return 0;
    }
    $upload_dir = wp_upload_dir();
    if ( ! empty( $upload_dir['error'] ) ) {
        echo "  [ERROR] Upload directory error: {$upload_dir['error']}\n";
        return 0;
    }
    $filename  = basename( $file_path );
    $dest_file = $upload_dir['path'] . '/' . $filename;
    global $wpdb;

    $existing = (int) $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE post_title = %s AND post_type = 'attachment' LIMIT 1", $title ) );
    if ( $existing > 0 ) return $existing;

    $existing_meta = (int) $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_wp_attached_file' AND meta_value LIKE %s LIMIT 1", '%' . $wpdb->esc_like( $filename ) ) );
    if ( $existing_meta > 0 ) return $existing_meta;

    wp_mkdir_p( $upload_dir['path'] );
    if ( ! file_exists( $dest_file ) && ! @copy( $file_path, $dest_file ) ) {
        echo "  [ERROR] Failed copying {$filename} to uploads\n";
        return 0;
    }

    $check_type = wp_check_filetype( $filename, null );
    $mime_type  = ! empty( $check_type['type'] ) ? $check_type['type'] : 'image/webp';
    $attachment = array(
        'guid'           => $upload_dir['url'] . '/' . $filename,
        'post_mime_type' => $mime_type,
        'post_title'     => sanitize_text_field( $title ),
        'post_content'   => '',
        'post_status'    => 'inherit',
    );

    $attach_id = wp_insert_attachment( $attachment, $dest_file, $parent_id );
    if ( is_wp_error( $attach_id ) || ! $attach_id ) {
        echo "  [ERROR] Attachment failed: " . ( is_wp_error( $attach_id ) ? $attach_id->get_error_message() : 'Unknown' ) . "\n";
        return 0;
    }
    update_attached_file( $attach_id, $dest_file );
    $attach_data = wp_generate_attachment_metadata( $attach_id, $dest_file );
    if ( ! empty( $attach_data ) ) {
        wp_update_attachment_metadata( $attach_id, $attach_data );
    }
    return (int) $attach_id;
}

// 1. Ensure category 'coffee-vending-machines' exists under 'b2b'
echo "[1/2] Processing Category: Commercial Coffee Vending Machines...\n";
$b2b_term  = get_term_by( 'slug', 'b2b', 'product_cat' );
$parent_id = ( $b2b_term && ! is_wp_error( $b2b_term ) ) ? (int) $b2b_term->term_id : 0;
$cat_name  = 'Commercial Coffee Vending Machines';
$cat_slug  = 'coffee-vending-machines';
$cat_desc  = 'Commercial bean-to-cup, dual hot/cold, and high-throughput soluble beverage systems engineered for corporate offices, IT campuses, and HoReCa facilities. Compare technical specifications, review touchscreen menus, and request consolidated multi-model institutional quotations.';

$cat_term = get_term_by( 'slug', $cat_slug, 'product_cat' );
if ( ! $cat_term ) {
    $inserted = wp_insert_term( $cat_name, 'product_cat', array( 'slug' => $cat_slug, 'description' => $cat_desc, 'parent' => $parent_id ) );
    if ( is_wp_error( $inserted ) ) {
        fwrite( STDERR, "Error creating category: " . $inserted->get_error_message() . "\n" );
        exit( 1 );
    }
    $cat_id = (int) $inserted['term_id'];
    echo "  + Created category ID: {$cat_id} (Parent B2B ID: {$parent_id})\n";
} else {
    $cat_id = (int) $cat_term->term_id;
    wp_update_term( $cat_id, 'product_cat', array( 'name' => $cat_name, 'description' => $cat_desc, 'parent' => $parent_id ) );
    echo "  + Verified existing category ID: {$cat_id} (Parent B2B ID: {$parent_id})\n";
}
$product_cat_ids = array_values( array_unique( array_filter( array( $cat_id, $parent_id ) ) ) );

// 2. Machine specifications and data
echo "\n[2/2] Importing 6 Nestlé Professional Commercial Machines...\n";
$img_dir  = __DIR__ . '/images/nestle-machines';
$machines = array(
    array(
        'title'       => 'NESCAFÉ PREMIO',
        'sku'         => 'NES-PREMIO-200',
        'suitability' => '200+ Employees / Executive Suites',
        'main_img'    => $img_dir . '/premio.webp',
        'menu_img'    => $img_dir . '/premio-menu.webp',
        'short_desc'  => 'Super-Automatic Bean-to-Cup commercial coffee machine with whole roasted beans, fresh milk integration, and 7-inch touchscreen. Suitable for 200+ employees and executive suites.',
        'overview'    => 'The NESCAFÉ PREMIO is a super-automatic bean-to-cup commercial beverage system engineered for executive boardrooms, corporate headquarters, and high-footfall executive suites. Utilizing high-precision conical steel burr grinders and fresh milk integration, it prepares authentic café-quality espresso and specialty beverages on demand.',
        'features'    => array(
            'Super-Automatic Conical Steel Burr Grinder', '100% Whole Roasted Coffee Beans & Fresh Milk',
            '7-inch Capacitive Colour Touchscreen', 'IoT-Enabled QR Contactless & UPI Cashless Payments',
            'Automatic Milk-Line Steam Purge & CIP Sanitization',
        ),
        'menu'        => array( 'Espresso', 'Americano', 'Cappuccino', 'Café Latte', 'Chococcino', 'Galao', 'Flat White', 'Hot Water', '80+ Custom Recipes' ),
        'specs'       => array(
            'Suitability' => '200+ Employees / Executive Suites', 'Brewing Technology' => 'Super-Automatic Bean-to-Cup (15 Bar)',
            'Daily Output' => 'Up to 200 Cups/Day', 'Canisters & Hoppers' => '1 Bean Hopper (1.5 kg) + 4 Canisters (750 g each)',
            'Machine Dimensions' => '365 × 610 × 760 mm', 'Refrigerator Dimensions' => '260 × 430 × 475 mm (Fresh Milk Unit)',
            'Electrical Load' => '230V AC / 50 Hz / 3000W', 'Water Connection' => 'Direct Plumbing Line (1–8 Bar) / 20L Inverted Jar',
            'Drip Tray Capacity' => '1,500 ml with Level Sensor', 'Interface' => '7" Touch Screen with Web-App QR / UPI',
        ),
    ),
    array(
        'title'       => 'NESCAFÉ AMIGO',
        'sku'         => 'NES-AMIGO-200',
        'suitability' => '100–200 Employees / Mid-Size Pantries',
        'main_img'    => $img_dir . '/amigo.webp',
        'menu_img'    => $img_dir . '/amigo-menu.webp',
        'short_desc'  => 'Compact Bean-to-Cup machine with integrated whole bean grinder, proximity touch glass panel, and 330mm desktop width. Suitable for 100–200 employees and mid-size pantries.',
        'overview'    => 'The NESCAFÉ AMIGO is a space-efficient compact bean-to-cup coffee machine crafted for mid-sized corporate offices and pantries. Featuring an integrated roasted whole bean grinder and an intuitive proximity touch glass panel, it delivers rapid, consistent café favorites with minimal counter footprint.',
        'features'    => array(
            'Integrated Roasted Whole Bean Grinder', 'Proximity Touch Glass Interface with Backlit Icons',
            'Compact 330mm Desktop Width', 'Front-Loading 35-Puck Grounds Drawer', 'Fast 3000W Boiler Rapid Recovery',
        ),
        'menu'        => array( 'Espresso', 'Black Coffee', 'Cappuccino', 'Café Latte', 'Cardamom Tea', 'Hot Chocolate', 'Milo', 'Hot Water' ),
        'specs'       => array(
            'Suitability' => '100–200 Employees / Mid-Size Pantries', 'Brewing Technology' => 'Compact Bean-to-Cup (15 Bar)',
            'Daily Output' => 'Up to 200 Cups/Day', 'Canisters & Hoppers' => '1 Bean Hopper (1.5 kg) + 3 Canisters (750 g each)',
            'Machine Dimensions' => '330 × 570 × 730 mm', 'Refrigerator Dimensions' => '260 × 430 × 475 mm',
            'Electrical Load' => '230V AC / 50 Hz / 3000W', 'Water Connection' => 'Direct Plumbing Line / 20L Inverted Jar',
            'Drip Tray Capacity' => '900 ml', 'Interface' => 'Proximity Touch Glass Panel',
        ),
    ),
    array(
        'title'       => 'NESCAFÉ DUO GUSTO',
        'sku'         => 'NES-DUO-300',
        'suitability' => '300+ Employees / Co-Working Hubs & Food Courts',
        'main_img'    => $img_dir . '/duo-gusto.webp',
        'menu_img'    => $img_dir . '/duo-gusto-menu.webp',
        'short_desc'  => 'Dual Hot & Cold hybrid beverage machine with 10-inch interactive display, 6 high-capacity canisters, and UPI/RFID payments. Suitable for 300+ employees and co-working hubs.',
        'overview'    => 'The NESCAFÉ DUO GUSTO is a high-capacity hybrid vending system featuring a dual hot boiler and active chiller engine. Capable of continuous duty in busy co-working hubs and campus dining halls, it dispenses authentic hot and refreshing iced beverages through a brilliant 10-inch interactive touchscreen.',
        'features'    => array(
            'Dual Temperature Core: Hot Boiler + Active Chiller', '10-inch Interactive Touch Display with Video Playback',
            '6 High-Capacity Canisters for Multi-Blend Menus', '300+ Cups/Day Continuous Duty',
            'Dynamic UPI QR & Campus RFID Card Reader',
        ),
        'menu'        => array( 'Hot Cappuccino', 'Café Latte', 'Tapri Chai', 'Café Frappe', 'Iced Lemon Tea', 'Cold Chocolate', 'Mocha Frappe' ),
        'specs'       => array(
            'Suitability' => '300+ Employees / Co-Working Hubs & Food Courts', 'Brewing Technology' => 'Smart Dual Hot & Cold Hybrid Engine',
            'Daily Output' => '300+ Cups/Day (Peak Fleet Capacity)', 'Canisters & Hoppers' => '6 Multi-Blend High-Capacity Canisters',
            'Machine Dimensions' => '380 × 675 × 645 mm', 'Cooler Unit Dimensions' => '260 × 430 × 420 mm',
            'Electrical Load' => '230V AC / 50 Hz / Dual Power Circuit', 'Water Connection' => 'Direct Continuous Water Line',
            'Drip Tray Capacity' => '1,200 ml', 'Interface' => '10" Full Colour Touch Display + UPI / RFID',
        ),
    ),
    array(
        'title'       => 'NESCAFÉ SOLUTION 2.0',
        'sku'         => 'NES-SOL-200',
        'suitability' => '200–500 Employees / Corporate IT Pantries',
        'main_img'    => $img_dir . '/solution.webp',
        'menu_img'    => $img_dir . '/solution-menu.webp',
        'short_desc'  => 'High-throughput soluble system with 9-inch touchless IR sensor, 6 cups/min burst velocity, and 4kg payload. Suitable for 200–500 employees and corporate IT pantries.',
        'overview'    => 'The NESCAFÉ SOLUTION 2.0 is an ultra-fast commercial soluble beverage dispenser designed for corporate IT hubs and high-density campus pantries. Equipped with a 9-inch contactless infrared proximity sensor and rapid burst velocity, it serves peak-hour break times effortlessly.',
        'features'    => array(
            '9-inch IR Touchless Proximity Sensor (2cm hover dispense)', '6 Cups/Min Ultra-Fast Break Time Burst Velocity',
            '4 Large 1kg Canisters (4kg Total Soluble Payload)', 'Liquid Milk Refrigerator or Soluble Dairy Support',
            'Stainless Steel Insulated Heavy-Duty Boiler',
        ),
        'menu'        => array( 'Rapid Black Coffee', 'Corporate Cappuccino', 'Cardamom Chai', 'Ginger Tea', 'Hot Water', 'Steamed Milk' ),
        'specs'       => array(
            'Suitability' => '200–500 Employees / Corporate IT Pantries', 'Brewing Technology' => 'High-Throughput Soluble + Liquid Milk Option',
            'Daily Output' => '200+ Cups/Day (2–3 cups/min continuous, 6 burst)', 'Canisters & Hoppers' => '4 Large Canisters (1.0 kg each)',
            'Machine Dimensions' => '330 × 570 × 650 mm', 'Refrigerator Dimensions' => '260 × 430 × 475 mm',
            'Electrical Load' => '230V AC / 50 Hz / 2000–3000W', 'Water Connection' => 'Direct Plumbing Line / Pressure Pump',
            'Drip Tray Capacity' => '1,200 ml', 'Interface' => '9" Touchless Infrared Sensor Panel',
        ),
    ),
    array(
        'title'       => 'NESCAFÉ SPECTRA TRIPLE OPTION',
        'sku'         => 'NES-SPEC-150',
        'suitability' => '20–100 Employees / Small Offices & Clinics',
        'main_img'    => $img_dir . '/spectra.webp',
        'menu_img'    => $img_dir . '/spectra-menu.webp',
        'short_desc'  => 'Ultra-compact 285mm premix hot vending system with tactile push buttons, low energy draw, and zero cleaning hassle. Suitable for 20–100 employees and small offices.',
        'overview'    => 'The NESCAFÉ SPECTRA TRIPLE OPTION is an ultra-compact commercial hot beverage vending machine designed for small offices, consulting rooms, and clinics. Built on proven 3-in-1 soluble premix technology, it offers hassle-free daily operation, instant water heating, and minimal energy consumption.',
        'features'    => array(
            'Ultra-Compact 285mm Width (Smallest Fleet Footprint)', '3-in-1 Instant Soluble Premix Technology (Zero Cleaning Hassle)',
            'Tactile Push-Button Membrane with Alphanumeric LCD', '1750W Low Energy Consumption',
            'Rapid Hot Water Dispenser for Tea Bags & Infusions',
        ),
        'menu'        => array( 'NESCAFÉ Classic Coffee', 'Cardamom / Ginger Tea', 'Hot Chocolate', 'Instant Hot Water' ),
        'specs'       => array(
            'Suitability' => '20–100 Employees / Small Offices & Clinics', 'Brewing Technology' => 'Compact Premix-Based Hot Vending',
            'Daily Output' => '100–150 Cups/Day', 'Canisters & Hoppers' => '3 Canisters (1.0 kg each)',
            'Machine Dimensions' => '285 × 490 × 600 mm', 'Refrigerator Dimensions' => 'None Required (Self-Contained Unit)',
            'Electrical Load' => '230V AC / 50 Hz / 1750W', 'Water Connection' => 'Inverted 20L Bubble Jar / Direct Line',
            'Drip Tray Capacity' => '800 ml', 'Interface' => 'Push-Button Membrane Panel + LCD Display',
        ),
    ),
    array(
        'title'       => 'NESCAFÉ FRIO',
        'sku'         => 'NES-FRIO-100',
        'suitability' => 'All Campuses / Summer Breakout Zones & Cafeterias',
        'main_img'    => $img_dir . '/frio.webp',
        'menu_img'    => $img_dir . '/frio-menu.webp',
        'short_desc'  => 'Commercial flash-chilled cold beverage system with 8L continuous chiller tank, proximity glass touch, and clump-free mixing. Suitable for campus breakout zones and cafeterias.',
        'overview'    => 'The NESCAFÉ FRIO is a dedicated commercial cold beverage dispensing station engineered for breakout zones, cafeterias, and summer campus refreshment areas. Featuring an 8-liter continuous flash-chiller tank and smart clump-free dissolution, it delivers icy frappes and chilled teas at speed.',
        'features'    => array(
            'Dedicated Commercial Flash-Chiller Refrigeration System', '8-Liter Continuous Cold Tank Chiller',
            'Instant Clump-Free Dissolving of Cold Coffee & Frappes', '9-inch Proximity Glass Panel with IoT Mobile App',
            '1000W Energy-Efficient Compressor Circuit',
        ),
        'menu'        => array( 'Café Frappe', 'Nestea Iced Lemon Tea', 'Cold Chocolate', 'Frappe Mocha', 'Chilled Milk Drink' ),
        'specs'       => array(
            'Suitability' => 'All Campuses / Summer Breakout Zones & Cafeterias', 'Brewing Technology' => 'Dedicated Commercial Flash-Chilled Cold System',
            'Daily Output' => '8-Liter Continuous Chiller Tank', 'Canisters & Hoppers' => '3 Cold-Optimized Canisters (1.0 kg each)',
            'Machine Dimensions' => '335 × 655 × 655 mm', 'Refrigerator Dimensions' => 'Integrated Internal Compressor',
            'Electrical Load' => '230V AC / 50 Hz / 1000W', 'Water Connection' => 'Direct Plumbing Line with Pressure Regulator',
            'Drip Tray Capacity' => '1,500 ml', 'Interface' => '9" Proximity Glass Touch with IoT Cashless',
        ),
    ),
);

$success_count = 0;

foreach ( $machines as $index => $m ) {
    $num = $index + 1;
    echo "  [{$num}/6] Processing {$m['title']} ({$m['sku']})...\n";

    $features_li = implode( '', array_map( fn( $item ) => '<li>' . esc_html( $item ) . '</li>', $m['features'] ) );
    $menu_li     = implode( '', array_map( fn( $item ) => '<li>' . esc_html( $item ) . '</li>', $m['menu'] ) );
    $long_desc   = '<h3>' . esc_html( $m['title'] ) . '</h3>'
        . '<p>' . esc_html( $m['overview'] ) . '</p>'
        . '<h4>Salient Features</h4><ul>' . $features_li . '</ul>'
        . '<h4>Beverage Menu</h4><ol>' . $menu_li . '</ol>';

    $existing_id = wc_get_product_id_by_sku( $m['sku'] );
    if ( ! $existing_id ) {
        $page = get_page_by_title( $m['title'], OBJECT, 'product' );
        if ( $page ) $existing_id = $page->ID;
    }

    $product = $existing_id ? wc_get_product( $existing_id ) : new WC_Product_Simple();
    if ( ! is_a( $product, 'WC_Product' ) ) $product = new WC_Product_Simple();

    $product->set_name( $m['title'] );
    $product->set_sku( $m['sku'] );
    $product->set_status( 'publish' );
    $product->set_catalog_visibility( 'visible' );
    $product->set_short_description( $m['short_desc'] );
    $product->set_description( $long_desc );
    $product->set_category_ids( $product_cat_ids );

    // Attach main machine image
    $main_attach_id = snap_seed_attachment( $m['main_img'], $m['title'] );
    if ( $main_attach_id > 0 ) {
        $product->set_image_id( $main_attach_id );
        echo "    - Main image attached (ID: {$main_attach_id})\n";
    }

    // Attach menu image
    $menu_attach_id = snap_seed_attachment( $m['menu_img'], $m['title'] . ' Beverage Menu' );
    $menu_image_url = '';
    if ( $menu_attach_id > 0 ) {
        $menu_image_url = wp_get_attachment_url( $menu_attach_id );
        $product->set_gallery_image_ids( array( $menu_attach_id ) );
        echo "    - Menu image attached (ID: {$menu_attach_id})\n";
    } elseif ( file_exists( $m['menu_img'] ) ) {
        $menu_image_url = get_template_directory_uri() . '/images/nestle-machines/' . basename( $m['menu_img'] );
        echo "    - Menu fallback URL: {$menu_image_url}\n";
    }

    $product_id = $product->save();
    if ( ! $product_id ) {
        echo "    - [ERROR] Failed to save product {$m['title']}\n";
        continue;
    }

    if ( $main_attach_id > 0 ) {
        set_post_thumbnail( $product_id, $main_attach_id );
    }

    // Convert specs to [{name, value}] format expected by theme template
    $specs_meta = array();
    foreach ( $m['specs'] as $spec_k => $spec_v ) {
        $specs_meta[] = array( 'name' => $spec_k, 'value' => $spec_v );
    }

    // Save required and auxiliary metadata
    update_post_meta( $product_id, '_salient_features', $m['features'] );
    update_post_meta( $product_id, '_technical_specs', $specs_meta );
    update_post_meta( $product_id, '_beverage_menu', $m['menu'] );
    update_post_meta( $product_id, '_menu_image_url', $menu_image_url );

    if ( $menu_attach_id > 0 ) {
        update_post_meta( $product_id, '_menu_image_id', $menu_attach_id );
    }
    update_post_meta( $product_id, '_product_design_type', 'b2b' );
    update_post_meta( $product_id, '_is_b2b', 'yes' );
    update_post_meta( $product_id, '_suitability', $m['suitability'] );

    echo "    ✓ Saved {$m['title']} (Product ID: {$product_id})\n";
    $success_count++;
}

echo "\n=================================================================\n";
echo " IMPORT SUMMARY: {$success_count}/6 machines successfully processed\n";
echo " Category ID: {$cat_id} (Parent B2B ID: {$parent_id})\n";
echo "=================================================================\n";
