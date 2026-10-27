<?php
/**
 * import_missing_b2b_products.php
 * Imports B2B products not yet in the database:
 * - VRF V S - SIDE DISCHARGE VRF SYSTEM
 * - PACKAGED DUCTED SPLIT AIR CONDITIONERS
 * - PROCESS CHILLERS
 * - CENTRIFUGAL CHILLERS
 * - CONDENSING UNITS
 * - AIR COOLERS (category brochure)
 *
 * Run: http://localhost:8080/wp-content/themes/snap-stitch-theme/import_missing_b2b_products.php
 */

require_once dirname(__FILE__) . '/../../../wp-load.php';

if ( ! current_user_can('manage_options') ) {
    die("Unauthorized access. Please log in as an administrator first.");
}

echo "<pre>";
echo "Starting import of missing B2B products...\n\n";

// Products to import: title => data
$products_to_import = [
    [
        'title'        => 'VRF V S - SIDE DISCHARGE VRF SYSTEM',
        'description'  => 'THE NEW BENCHMARK FOR AESTHETICS AND SAVINGS

The Blue Star VRF V S Side Discharge VRF System sets a new benchmark for aesthetics and energy savings in variable refrigerant flow air conditioning. Engineered for large commercial spaces, this system delivers precise temperature control across multiple zones simultaneously. With its side discharge design, it offers flexible installation options even in constrained spaces. The VRF V S system incorporates advanced inverter technology that adapts compressor speed to exact cooling demand, ensuring optimal energy efficiency at all load conditions.

Key capabilities:
- Simultaneous heating and cooling across zones
- Wide capacity range for enterprise deployments
- Advanced microprocessor controls for intelligent climate management
- Eco-friendly refrigerant for reduced environmental impact
- BMS integration ready for smart building deployments',
        'brochure_url' => 'https://www.bluestarindia.com/media/342703/vrf-v-s-dec21.pdf',
        'category_ids' => [72, 79, 140, 160], // B2B, Central Air Conditioning, VRF Systems (both)
        'design_type'  => 'b2b',
        'image_url'    => 'https://www.bluestarindia.com/img/about-usBG.jpg',
    ],
    [
        'title'        => 'PACKAGED DUCTED SPLIT AIR CONDITIONERS',
        'description'  => 'NOTHING COMES CLOSE TO ITS COOLING. OR ITS WIDE RANGE.

Blue Star Packaged Ducted Split Air Conditioners deliver powerful, uniform cooling across large commercial and industrial spaces. These systems are engineered for applications where centralized cooling with duct distribution is required — from office buildings and malls to hotels and hospitals.

The ducted split systems combine a high-efficiency outdoor condensing unit with an indoor air handling unit, connected through refrigerant piping and air distribution ducts. They provide superior air quality with advanced filtration and precise temperature and humidity control.

Ideal for:
- Commercial office spaces
- Retail and hospitality environments
- Healthcare facilities
- Educational institutions
- Industrial process cooling',
        'brochure_url' => 'https://www.bluestarindia.com/media/133210/ductedsystem-new-oct21.pdf',
        'category_ids' => [72, 79, 141, 161], // B2B, Central Air Conditioning, Ducted Systems (both)
        'design_type'  => 'b2b',
        'image_url'    => 'https://www.bluestarindia.com/media/56041/products-banner.jpg',
    ],
    [
        'title'        => 'PROCESS CHILLERS',
        'description'  => 'Blue Star offers Process Chillers for medical, pharmaceutical industries and varied industrial applications like plastic mould cooling, printing and lamination processes. These chillers incorporate microprocessor based controls which offer intelligent cooling and are energy efficient apart from being extremely compact with a small footprint.

Process Chillers are the backbone of temperature-critical industrial operations. Blue Star\'s range is designed to maintain precise process temperatures across demanding environments. They feature robust construction with corrosion-resistant components, making them suitable for 24x7 continuous operation.

Applications include:
- Pharmaceutical and biotech manufacturing
- Plastic injection moulding and extrusion
- Printing and lamination
- Chemical processing
- Food and beverage production
- Medical equipment cooling

The microprocessor-based controls provide accurate temperature regulation with alarm systems for process protection.',
        'brochure_url' => 'https://www.bluestarindia.com/media/50987/process-chillers-4-9-15.pdf',
        'category_ids' => [72, 79, 142, 162], // B2B, Central Air Conditioning, Chillers (both)
        'design_type'  => 'b2b',
        'image_url'    => 'https://www.bluestarindia.com/media/56060/products-banner.jpg',
    ],
    [
        'title'        => 'CENTRIFUGAL CHILLERS',
        'description'  => 'Capacity Range: Upto 1000TR

Blue Star Centrifugal Chillers are high-capacity, energy-efficient cooling solutions for large commercial and industrial facilities. With a capacity range of up to 1000 TR (Tons of Refrigeration), they are ideal for district cooling, large campuses, airports, and industrial complexes.

Centrifugal chillers use a centrifugal compressor — the most efficient compressor technology available — to deliver outstanding part-load and full-load performance. Blue Star\'s centrifugal chillers feature:

- Magnetic bearing technology for oil-free operation and reduced maintenance
- Variable speed drives for optimal part-load efficiency
- Advanced diagnostics and remote monitoring
- Eco-friendly, low-GWP refrigerant options
- Robust heat exchanger design for long-term reliability

These chillers comply with ASHRAE energy standards and are suitable for LEED-certified green building projects.',
        'brochure_url' => 'https://www.bluestarindia.com/media/394597/centrifugal-chiller.pdf',
        'category_ids' => [72, 79, 142, 162], // B2B, Central Air Conditioning, Chillers (both)
        'design_type'  => 'b2b',
        'image_url'    => 'https://www.bluestarindia.com/img/about-usBG.jpg',
    ],
    [
        'title'        => 'CONDENSING UNITS',
        'description'  => 'SUPERIOR EFFICIENCY. SUPERIOR VALUE.

Blue Star Condensing Units are the heart of commercial and industrial refrigeration systems. Engineered for reliability and efficiency, these units serve as the outdoor component in split-type refrigeration systems, paired with evaporators in cold rooms, display cases, and process cooling applications.

Blue Star\'s condensing units are available in a wide capacity range and support multiple refrigerants including eco-friendly low-GWP options. They are built for continuous operation in harsh ambient conditions and feature:

- High-efficiency scroll and reciprocating compressors
- Tropical design for high ambient temperature operation (up to 55°C)
- Copper tube with aluminium fin heat exchangers
- Hermetically sealed design for reliability
- Wide application range: supermarkets, cold rooms, food processing

Backed by Blue Star\'s national service network for rapid on-site support.',
        'brochure_url' => 'https://www.bluestarindia.com/media/1015/condensing-unit-brochure-27-11-13.pdf',
        'category_ids' => [72, 79, 163], // B2B, Central Air Conditioning, Others
        'design_type'  => 'b2b',
        'image_url'    => 'https://www.bluestarindia.com/media/56062/products-banner.jpg',
    ],
    [
        'title'        => 'AIR COOLERS',
        'description'  => 'Cooling Simplified.

Blue Star Air Coolers provide an energy-efficient, eco-friendly alternative to conventional air conditioners for personal and light commercial spaces. Operating on the principle of evaporative cooling, they consume up to 80% less electricity than air conditioners while providing effective cooling in dry and semi-arid climates.

Blue Star\'s range of air coolers includes personal coolers, desert coolers, window coolers, and tower coolers — covering a wide capacity range from compact 10L personal units to high-capacity 140L commercial models.

Key advantages:
- Drastically lower energy consumption vs ACs
- No compressor — completely environment-friendly (no refrigerant)
- Fresh air circulation rather than recirculated air
- Low maintenance with easy-clean components
- Ideal for open areas, factories, warehouses, and outdoor events',
        'brochure_url' => 'https://www.bluestarindia.com/media/254545/bs-air-cooler_2020_r2.pdf',
        'category_ids' => [72, 74], // B2B, Air Coolers
        'design_type'  => 'b2b',
        'image_url'    => 'https://www.bluestarindia.com/media/254376/air-coolers-banner.jpg',
    ],
];

$imported = 0;
$skipped  = 0;

foreach ( $products_to_import as $p ) {
    $title = $p['title'];

    // Check if product already exists (exact or fuzzy)
    $existing = get_page_by_title( $title, OBJECT, 'product' );
    if ( ! $existing ) {
        global $wpdb;
        $existing_id = $wpdb->get_var( $wpdb->prepare(
            "SELECT ID FROM {$wpdb->posts} WHERE post_type='product' AND post_title LIKE %s LIMIT 1",
            '%' . $wpdb->esc_like( $title ) . '%'
        ) );
        if ( $existing_id ) {
            $existing = get_post( $existing_id );
        }
    }

    if ( $existing ) {
        echo "SKIPPED (already exists): {$title} (ID: {$existing->ID})\n";
        // Still update brochure URL in case it's missing
        update_post_meta( $existing->ID, '_brochure_url', esc_url_raw( $p['brochure_url'] ) );
        update_post_meta( $existing->ID, '_product_design_type', 'b2b' );
        echo "  → Brochure URL ensured.\n";
        $skipped++;
        continue;
    }

    // Create new product
    $post_id = wp_insert_post( [
        'post_title'   => $title,
        'post_content' => wpautop( $p['description'] ),
        'post_status'  => 'publish',
        'post_type'    => 'product',
    ] );

    if ( is_wp_error( $post_id ) ) {
        echo "ERROR creating: {$title} — " . $post_id->get_error_message() . "\n";
        continue;
    }

    // Set WooCommerce product type to simple
    wp_set_object_terms( $post_id, 'simple', 'product_type' );

    // Set B2B product categories using the correct term IDs
    if ( ! empty( $p['category_ids'] ) ) {
        wp_set_object_terms( $post_id, $p['category_ids'], 'product_cat' );
    } else {
        // Fallback: assign to B2B Products (ID: 72)
        wp_set_object_terms( $post_id, [72], 'product_cat' );
    }

    // Set meta
    update_post_meta( $post_id, '_product_design_type', 'b2b' );
    update_post_meta( $post_id, '_brochure_url', esc_url_raw( $p['brochure_url'] ) );
    update_post_meta( $post_id, '_visibility', 'visible' );
    update_post_meta( $post_id, '_stock_status', 'instock' );
    update_post_meta( $post_id, '_manage_stock', 'no' );
    update_post_meta( $post_id, '_sold_individually', 'no' );
    update_post_meta( $post_id, '_price', '' );
    update_post_meta( $post_id, '_regular_price', '' );

    echo "IMPORTED: {$title} (ID: {$post_id})\n";
    echo "  → Brochure: {$p['brochure_url']}\n";
    $imported++;
}

echo "\n";
echo "Done! Imported: {$imported}, Already existed (brochure ensured): {$skipped}\n";
echo "</pre>";
