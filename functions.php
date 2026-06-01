<?php
/**
 * Snap Marketing Stitch Theme functions and definitions
 */

if ( ! function_exists( 'snap_stitch_theme_setup' ) ) :
    function snap_stitch_theme_setup() {
        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        /*
         * Let WordPress manage the document title.
         */
        add_theme_support( 'title-tag' );

        /*
         * Enable support for Post Thumbnails on posts and pages.
         */
        add_theme_support( 'post-thumbnails' );

        // Add support for WordPress menus
        register_nav_menu( 'primary', 'Primary Menu' );
        register_nav_menu( 'top_bar', 'Top Bar Menu' );

        // Add support for WooCommerce
        add_theme_support( 'woocommerce' );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ) );
    }
endif;
add_action( 'after_setup_theme', 'snap_stitch_theme_setup' );

/**
 * Enqueue scripts and styles.
 */
function snap_stitch_theme_scripts() {
    wp_enqueue_style( 'snap-stitch-theme-style', get_stylesheet_uri() );
    wp_enqueue_script( 'snap-stitch-animations', get_template_directory_uri() . '/js/animations.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'snap_stitch_theme_scripts' );

/**
 * Redirect non-logged in users from My Account to custom Login page
 */
function snap_stitch_redirect_my_account() {
    if ( is_account_page() && ! is_user_logged_in() && ! is_checkout() ) {
        wp_redirect( home_url( '/login' ) );
        exit;
    }
}
add_action( 'template_redirect', 'snap_stitch_redirect_my_account' );

/**
 * WooCommerce Customizations
 */
add_action( 'init', 'snap_stitch_woocommerce_customizations' );
function snap_stitch_woocommerce_customizations() {
    // Remove default loop title as we have a custom one in content-product.php
    remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
}

/**
 * Check if a product is B2B

 * Logic: Product belongs to 'B2B' category or has a 'b2b' attribute
 */
function snap_stitch_is_b2b_product( $product_id ) {
    return has_term( 'b2b', 'product_cat', $product_id ) || get_post_meta( $product_id, '_is_b2b', true ) === 'yes';
}

/**
 * Handle B2B Product UI: Hide price and change Add to Cart to Request Quote
 */
add_filter( 'woocommerce_get_price_html', 'snap_stitch_b2b_price_display', 100, 2 );
function snap_stitch_b2b_price_display( $price, $product ) {
    if ( snap_stitch_is_b2b_product( $product->get_id() ) ) {
        return '<span class="text-secondary-container font-black uppercase text-xs tracking-widest italic">Institutional Pricing Only</span>';
    }
    return $price;
}

add_filter( 'woocommerce_product_add_to_cart_text', 'snap_stitch_b2b_btn_text', 10, 2 );
function snap_stitch_b2b_btn_text( $text, $product ) {
    if ( snap_stitch_is_b2b_product( $product->get_id() ) ) {
        return __( 'Request Bulk Quote', 'snap-stitch-theme' );
    }
    return $text;
}

/**
 * Lead Capture Logic: Capture input data for B2B quotes
 */
add_action( 'wp_ajax_snap_capture_lead', 'snap_stitch_capture_partial_quote' );
add_action( 'wp_ajax_nopriv_snap_capture_lead', 'snap_stitch_capture_partial_quote' );
function snap_stitch_capture_partial_quote() {
    if ( class_exists( 'Snap_Leads_B2B_CF7_Handler' ) ) {
        $handler = new Snap_Leads_B2B_CF7_Handler();
        $handler->capture_partial_lead();
    }
    wp_send_json_success();
}

/**
 * Force CF7 Success for local testing (skips mail check)
 */
add_filter( 'wpcf7_display_message', function( $message, $status ) {
    if ( $status === 'mail_failed' && ( defined('SNAP_LEADS_TESTING') || strpos($_SERVER['HTTP_HOST'], 'localhost') !== false ) ) {
        return "Thank you for your request. Our team will contact you shortly with bulk pricing.";
    }
    return $message;
}, 10, 2 );

add_filter( 'wpcf7_ajax_json_echo', function( $items, $result ) {
    if ( $items['status'] === 'mail_failed' && ( defined('SNAP_LEADS_TESTING') || strpos($_SERVER['HTTP_HOST'], 'localhost') !== false ) ) {
        $items['status'] = 'mail_sent';
        $items['message'] = "Thank you for your request. Our team will contact you shortly with bulk pricing.";
    }
    return $items;
}, 10, 2 );

/**
 * Helper to get dynamic product category URLs with a fallback to hardcoded paths.
 */
function snap_get_category_link( $slug ) {
    $term = get_term_by( 'slug', $slug, 'product_cat' );
    if ( $term && ! is_wp_error( $term ) ) {
        $link = get_term_link( $term, 'product_cat' );
        if ( ! is_wp_error( $link ) ) {
            return esc_url( $link );
        }
    }
    return esc_url( home_url( '/product-category/' . $slug ) );
}

