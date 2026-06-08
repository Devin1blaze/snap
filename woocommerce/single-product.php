<?php
/**
 * The Template for displaying single products
 * Router to load B2B or B2C specific templates based on product meta
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product ) {
    $product = wc_get_product( get_the_ID() );
}

// Check if the product is designated as B2B
if ( function_exists( 'snap_stitch_is_b2b_product' ) && snap_stitch_is_b2b_product( $product->get_id() ) ) {
    wc_get_template_part( 'single-product-b2b' );
} else {
    wc_get_template_part( 'single-product-b2c' );
}
