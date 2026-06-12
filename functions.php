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
 * Logic: Product belongs to 'B2B' category or has a 'b2b' attribute or the custom meta box is set to B2B
 */
function snap_stitch_is_b2b_product( $product_id ) {
    $meta_b2b = get_post_meta( $product_id, '_is_b2b', true );
    $meta_design = get_post_meta( $product_id, '_product_design_type', true );
    return has_term( 'b2b', 'product_cat', $product_id ) || $meta_b2b === 'yes' || $meta_design === 'b2b';
}

/**
 * Add Meta Box for Product Design Type (B2B vs B2C)
 */
add_action( 'add_meta_boxes', 'snap_stitch_add_product_design_meta_box' );
function snap_stitch_add_product_design_meta_box() {
    add_meta_box(
        'snap_product_design_type',
        __( 'Product Design Type', 'snap-stitch-theme' ),
        'snap_stitch_product_design_meta_box_html',
        'product',
        'side',
        'default'
    );
}

function snap_stitch_product_design_meta_box_html( $post ) {
    $value = get_post_meta( $post->ID, '_product_design_type', true );
    if ( empty( $value ) ) {
        $value = 'b2b'; // Default to B2B
    }
    
    wp_nonce_field( 'snap_save_product_design', 'snap_product_design_nonce' );
    ?>
    <p>Select which design layout to apply to this product page:</p>
    <label>
        <input type="radio" name="snap_product_design_type" value="b2b" <?php checked( $value, 'b2b' ); ?> />
        B2B Design (Bulk Quote, Specs)
    </label>
    <br/>
    <label>
        <input type="radio" name="snap_product_design_type" value="b2c" <?php checked( $value, 'b2c' ); ?> />
        B2C Design (Retail, Add to Cart)
    </label>

    <hr style="margin: 15px 0;" />
    
    <p><strong>Brochure PDF URL (B2B):</strong></p>
    <?php $brochure = get_post_meta( $post->ID, '_brochure_url', true ); ?>
    <input type="url" name="snap_brochure_url" value="<?php echo esc_attr( $brochure ); ?>" class="widefat" placeholder="https://..." />
    <p class="description">Adds a "Download Brochure" button if filled.</p>

    <hr style="margin: 15px 0;" />
    
    <p><strong>Why These Specs Matter (Enterprise Context):</strong></p>
    <?php 
    $enterprise_info = get_post_meta( $post->ID, '_enterprise_specs_info', true ); 
    wp_editor( $enterprise_info, 'snap_enterprise_specs_info', array(
        'textarea_name' => 'snap_enterprise_specs_info',
        'media_buttons' => false,
        'textarea_rows' => 5,
        'teeny'         => true,
    ) );
    ?>
    <p class="description">This content will be displayed in an expandable accordion under the specs table for B2B products.</p>
    <?php
}

add_action( 'save_post_product', 'snap_stitch_save_product_design_meta_box' );
function snap_stitch_save_product_design_meta_box( $post_id ) {
    if ( ! isset( $_POST['snap_product_design_nonce'] ) || ! wp_verify_nonce( $_POST['snap_product_design_nonce'], 'snap_save_product_design' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    if ( isset( $_POST['snap_product_design_type'] ) ) {
        $design_type = sanitize_text_field( $_POST['snap_product_design_type'] );
        update_post_meta( $post_id, '_product_design_type', $design_type );

        // Automatically sync category
        $term_slug = ( $design_type === 'b2b' ) ? 'b2b' : 'b2c';
        $opposite_slug = ( $design_type === 'b2b' ) ? 'b2c' : 'b2b';

        // Ensure category exists
        if ( ! term_exists( $term_slug, 'product_cat' ) ) {
            wp_insert_term( strtoupper($term_slug), 'product_cat', array( 'slug' => $term_slug ) );
        }

        // Add to correct category and remove from opposite
        wp_set_object_terms( $post_id, $term_slug, 'product_cat', true );
        wp_remove_object_terms( $post_id, $opposite_slug, 'product_cat' );
    }

    if ( isset( $_POST['snap_brochure_url'] ) ) {
        update_post_meta( $post_id, '_brochure_url', sanitize_url( $_POST['snap_brochure_url'] ) );
    }
    
    if ( isset( $_POST['snap_enterprise_specs_info'] ) ) {
        update_post_meta( $post_id, '_enterprise_specs_info', wp_kses_post( wp_unslash( $_POST['snap_enterprise_specs_info'] ) ) );
    }
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

// Auto-provision the primary menu
require_once get_template_directory() . '/setup-menu.php';

// Custom Meta Box for Technical Specifications
require_once get_template_directory() . '/inc/meta-box-tech-specs.php';

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

