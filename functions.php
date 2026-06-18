<?php
/**
 * Snap Marketing Stitch Theme functions and definitions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Disable WooCommerce's new Coming Soon mode for store pages
update_option('woocommerce_coming_soon', 'no');
update_option('woocommerce_store_pages_only', 'no');
add_filter( 'woocommerce_is_coming_soon', '__return_false' );
add_filter( 'woocommerce_store_pages_only', '__return_false' );

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
    
    // Remove the default WooCommerce breadcrumb as we use custom hero breadcrumbs
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
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

// Auto-provision the primary menu (Disabled so user can manually build it in Appearance > Menus)
// require_once get_template_directory() . '/setup-menu.php';

// Custom Meta Box for Technical Specifications
require_once get_template_directory() . '/inc/meta-box-tech-specs.php';

/**
 * Lead Capture Logic: Capture input data for B2B quotes
 */
add_action( 'wp_ajax_snap_capture_lead', 'snap_stitch_capture_partial_quote' );
add_action( 'wp_ajax_nopriv_snap_capture_lead', 'snap_stitch_capture_partial_quote' );
function snap_stitch_capture_partial_quote() {
    // Verify nonce to prevent CSRF attacks
    if ( ! isset( $_POST['snap_lead_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['snap_lead_nonce'] ) ), 'snap_capture_lead_action' ) ) {
        wp_send_json_error( 'Security check failed.', 403 );
        return;
    }

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



/**
 * Add B2B Brochure PDF Custom Field to Product Data
 */
add_action( 'woocommerce_product_options_general_product_data', 'snap_stitch_add_b2b_brochure_field' );
function snap_stitch_add_b2b_brochure_field() {
    echo '<div class="options_group">';
    woocommerce_wp_text_input( array(
        'id'          => '_brochure_url',
        'label'       => __( 'Brochure PDF URL (B2B)', 'snap-stitch-theme' ),
        'placeholder' => 'https://...',
        'description' => __( 'Enter the URL for the product brochure PDF. This will show a "Download Brochure" button on the product page.', 'snap-stitch-theme' ),
        'desc_tip'    => true,
    ) );
    echo '</div>';
}

/**
 * Save the B2B Brochure PDF Custom Field
 */
add_action( 'woocommerce_process_product_meta', 'snap_stitch_save_b2b_brochure_field' );
function snap_stitch_save_b2b_brochure_field( $post_id ) {
    if ( isset( $_POST['_brochure_url'] ) ) {
        update_post_meta( $post_id, '_brochure_url', sanitize_url( $_POST['_brochure_url'] ) );
    }
}

/**
 * WooCommerce Customizations: Remove Downloads navigation link from My Account
 */
add_filter( 'woocommerce_account_menu_items', 'snap_stitch_custom_my_account_menu_items' );
function snap_stitch_custom_my_account_menu_items( $items ) {
    unset( $items['downloads'] );
    return $items;
}

/**
 * Validate B2C registration fields
 */
add_action( 'woocommerce_register_post', 'snap_stitch_validate_registration_fields', 10, 3 );
function snap_stitch_validate_registration_fields( $username, $email, $validation_errors ) {
    // Required billing fields check
    $required_fields = array(
        'billing_first_name' => __( 'First name', 'woocommerce' ),
        'billing_last_name'  => __( 'Last name', 'woocommerce' ),
        'billing_phone'      => __( 'Phone number', 'woocommerce' ),
        'billing_address_1'  => __( 'Street address', 'woocommerce' ),
        'billing_city'       => __( 'Town / City', 'woocommerce' ),
        'billing_state'      => __( 'State', 'woocommerce' ),
        'billing_postcode'   => __( 'Postcode / ZIP', 'woocommerce' ),
    );

    foreach ( $required_fields as $field_key => $field_label ) {
        if ( empty( $_POST[ $field_key ] ) ) {
            $validation_errors->add( $field_key . '_error', sprintf( __( '<strong>Error</strong>: %s is required.', 'woocommerce' ), $field_label ) );
        }
    }

    // Validate email confirmation
    $email_confirm = isset( $_POST['email_confirm'] ) ? sanitize_email( wp_unslash( $_POST['email_confirm'] ) ) : '';
    if ( $email !== $email_confirm ) {
        $validation_errors->add( 'email_confirm_error', __( '<strong>Error</strong>: Email addresses do not match.', 'woocommerce' ) );
    }

    // Validate password confirmation
    $password = isset( $_POST['password'] ) ? $_POST['password'] : '';
    $password_confirm = isset( $_POST['password_confirm'] ) ? $_POST['password_confirm'] : '';
    if ( $password !== $password_confirm ) {
        $validation_errors->add( 'password_confirm_error', __( '<strong>Error</strong>: Passwords do not match.', 'woocommerce' ) );
    }

    // Validate Terms of Service & Privacy Policy agreement
    if ( empty( $_POST['terms_agreement'] ) ) {
        $validation_errors->add( 'terms_agreement_error', __( '<strong>Error</strong>: You must agree to the Terms of Service & Privacy Policy.', 'woocommerce' ) );
    }
}

/**
 * Save B2C registration fields
 */
add_action( 'woocommerce_created_customer', 'snap_stitch_save_registration_fields', 10, 3 );
function snap_stitch_save_registration_fields( $customer_id, $new_customer_data = array(), $password_generated = false ) {
    // Save standard billing fields
    $billing_fields = array(
        'billing_first_name',
        'billing_last_name',
        'billing_phone',
        'billing_address_1',
        'billing_address_2',
        'billing_city',
        'billing_state',
        'billing_postcode',
        'billing_country',
    );

    foreach ( $billing_fields as $field ) {
        if ( isset( $_POST[ $field ] ) ) {
            update_user_meta( $customer_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
        }
    }

    // Save standard shipping fields (handle fallback to billing fields if shipping same as billing)
    $shipping_fields = array(
        'shipping_first_name',
        'shipping_last_name',
        'shipping_address_1',
        'shipping_address_2',
        'shipping_city',
        'shipping_state',
        'shipping_postcode',
        'shipping_country',
    );

    $ship_to_different = ! empty( $_POST['ship_to_different_address'] );

    foreach ( $shipping_fields as $field ) {
        $billing_equivalent = str_replace( 'shipping_', 'billing_', $field );
        if ( $ship_to_different && isset( $_POST[ $field ] ) ) {
            update_user_meta( $customer_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
        } elseif ( ! $ship_to_different && isset( $_POST[ $billing_equivalent ] ) ) {
            update_user_meta( $customer_id, $field, sanitize_text_field( wp_unslash( $_POST[ $billing_equivalent ] ) ) );
        }
    }

    // Save custom B2C fields to user metadata
    if ( isset( $_POST['gender'] ) ) {
        update_user_meta( $customer_id, 'gender', sanitize_text_field( wp_unslash( $_POST['gender'] ) ) );
    }
    if ( isset( $_POST['dob'] ) ) {
        update_user_meta( $customer_id, 'dob', sanitize_text_field( wp_unslash( $_POST['dob'] ) ) );
    }
    if ( isset( $_POST['hear_about_us'] ) ) {
        update_user_meta( $customer_id, 'hear_about_us', sanitize_text_field( wp_unslash( $_POST['hear_about_us'] ) ) );
    }
    update_user_meta( $customer_id, 'newsletter_opt_in', isset( $_POST['newsletter_opt_in'] ) ? 'yes' : 'no' );
    update_user_meta( $customer_id, 'terms_agreement', isset( $_POST['terms_agreement'] ) ? 'yes' : 'no' );

    // Sync to standard WordPress user profile fields (first_name, last_name, display_name, nickname)
    $first_name = isset( $_POST['billing_first_name'] ) ? sanitize_text_field( wp_unslash( $_POST['billing_first_name'] ) ) : '';
    $last_name  = isset( $_POST['billing_last_name'] ) ? sanitize_text_field( wp_unslash( $_POST['billing_last_name'] ) ) : '';

    if ( ! empty( $first_name ) ) {
        update_user_meta( $customer_id, 'first_name', $first_name );
    }
    if ( ! empty( $last_name ) ) {
        update_user_meta( $customer_id, 'last_name', $last_name );
    }

    if ( ! empty( $first_name ) || ! empty( $last_name ) ) {
        $display_name = trim( $first_name . ' ' . $last_name );
        wp_update_user( array(
            'ID'           => $customer_id,
            'display_name' => $display_name,
            'nickname'     => $display_name,
        ) );
    }
}


