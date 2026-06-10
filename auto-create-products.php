<?php
/**
 * Auto-create test products so the user doesn't have to run seeder links manually.
 */
add_action('init', 'snap_stitch_auto_create_test_products');
function snap_stitch_auto_create_test_products() {
    // Only run if WooCommerce is active
    if ( ! class_exists( 'WC_Product_Simple' ) ) {
        return;
    }

    // 1. Create B2B Test Product
    $b2b_exists = get_page_by_path( 'industrial-heavy-duty-b2b-tester', OBJECT, 'product' );
    if ( ! $b2b_exists ) {
        $product = new WC_Product_Simple();
        $product->set_name( 'Industrial Heavy Duty B2B Tester' );
        $product->set_regular_price( '99999' );
        $product->set_sku( 'TEST-B2B-001' );
        $product->set_short_description( 'This is a B2B product. It should show the "Request Bulk Quote" button, technical specs, and institutional pricing text.' );
        $product->set_status( 'publish' );
        $product_id = $product->save();
        update_post_meta( $product_id, '_product_design_type', 'b2b' );
    }

    // 2. Create B2C Test Product
    $b2c_exists = get_page_by_path( 'retail-consumer-b2c-tester', OBJECT, 'product' );
    if ( ! $b2c_exists ) {
        $product = new WC_Product_Simple();
        $product->set_name( 'Retail Consumer B2C Tester' );
        $product->set_regular_price( '499' );
        $product->set_sku( 'TEST-B2C-001' );
        $product->set_short_description( 'This is a B2C product. It should show a standard "Add to Cart" button, clean retail layout, and NO specs table.' );
        $product->set_status( 'publish' );
        $product_id = $product->save();
        update_post_meta( $product_id, '_product_design_type', 'b2c' );
    }
}
