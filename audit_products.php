<?php
// audit_products.php
// Run this script from the command line or browser to audit products for missing data.

$wp_load_path = dirname(__FILE__) . '/../../../wp-load.php';
if ( file_exists( $wp_load_path ) ) {
    require_once $wp_load_path;
} else {
    die("Error: wp-load.php not found. Please run this inside a WordPress theme directory.");
}

if ( php_sapi_name() !== 'cli' && ! current_user_can( 'manage_options' ) ) {
    die("Unauthorized access.");
}

$is_cli = (php_sapi_name() === 'cli');

if (!$is_cli) echo "<pre>";
echo "Starting WooCommerce Product Data Audit...\n";

// CSV File Setup
$csv_file = dirname(__FILE__) . '/product_audit_report.csv';
$fp = fopen($csv_file, 'w');
if (!$fp) {
    die("Error: Could not open $csv_file for writing.\n");
}

fputcsv($fp, ['Product ID', 'Product Title', 'Missing Fields', 'Edit URL']);

$args = array(
    'post_type'      => 'product',
    'posts_per_page' => -1,
    'post_status'    => 'publish', // Or 'any' if we want drafts too. Let's do 'publish'
);

$products = get_posts( $args );
$total = count($products);
echo "Found $total published products.\n";

$products_with_issues = 0;
$issues_summary = [
    'description' => 0,
    'specifications' => 0,
    'images' => 0,
    'brochure_url' => 0
];

foreach ( $products as $product ) {
    $missing = [];
    $id = $product->ID;
    $title = $product->post_title;

    // 1. Check Description
    if ( empty( trim( strip_tags( $product->post_content ) ) ) ) {
        $missing[] = 'Description';
        $issues_summary['description']++;
    }

    // 2. Check Specifications
    $specs = get_post_meta( $id, '_technical_specs', true );
    if ( empty( $specs ) ) {
        $missing[] = 'Specifications';
        $issues_summary['specifications']++;
    }

    // 3. Check Image
    $image_id = get_post_meta( $id, '_thumbnail_id', true );
    if ( empty( $image_id ) ) {
        $missing[] = 'Image';
        $issues_summary['images']++;
    }

    // 4. Check Brochure URL (checking both keys)
    $brochure_1 = get_post_meta( $id, '_brochure_url', true );
    $brochure_2 = get_post_meta( $id, 'brochure_url', true );
    if ( empty( $brochure_1 ) && empty( $brochure_2 ) ) {
        $missing[] = 'Brochure URL';
        $issues_summary['brochure_url']++;
    }

    // Log if missing anything
    if ( ! empty( $missing ) ) {
        $products_with_issues++;
        $missing_str = implode(', ', $missing);
        $edit_url = admin_url( "post.php?post={$id}&action=edit" );
        fputcsv($fp, [$id, $title, $missing_str, $edit_url]);
        
        echo "[$id] $title => Missing: $missing_str\n";
    }
}

fclose($fp);

echo "\n=========================================\n";
echo "Audit Complete!\n";
echo "Total Products Audited: $total\n";
echo "Products with Issues: $products_with_issues\n";
echo "\nBreakdown of Missing Fields:\n";
echo "- Missing Description: " . $issues_summary['description'] . "\n";
echo "- Missing Specifications: " . $issues_summary['specifications'] . "\n";
echo "- Missing Images: " . $issues_summary['images'] . "\n";
echo "- Missing Brochure URL: " . $issues_summary['brochure_url'] . "\n";
echo "=========================================\n";
echo "Full report saved to: $csv_file\n";

if (!$is_cli) echo "</pre>";
?>
