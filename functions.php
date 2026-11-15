<?php
/**
 * Snap Marketing Stitch Theme functions and definitions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Require the Mega Menu Walker
require_once get_template_directory() . '/class-snap-mega-menu-walker.php';

// Require Global SEO & Schema Structured Data Generator
require_once get_template_directory() . '/inc/seo-schema.php';

// Require Google Analytics 4 & Google Search Console Integration
require_once get_template_directory() . '/inc/google-integration.php';

// Disable WooCommerce's new Coming Soon mode for store pages
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
    
    // Lenis Smooth Scroll
    // wp_enqueue_script( 'lenis', 'https://unpkg.com/lenis@1.0.45/dist/lenis.min.js', array(), '1.0.45', true );
    // wp_enqueue_script( 'snap-stitch-lenis-init', get_template_directory_uri() . '/js/lenis-init.js', array('lenis'), '1.0.0', true );
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
    if ( ! $product_id ) {
        return false;
    }
    $meta_b2b = get_post_meta( $product_id, '_is_b2b', true );
    $meta_design = get_post_meta( $product_id, '_product_design_type', true );
    if ( $meta_b2b === 'yes' || $meta_design === 'b2b' ) {
        return true;
    }
    if ( has_term( 'b2b', 'product_cat', $product_id ) ) {
        return true;
    }
    $terms = get_the_terms( $product_id, 'product_cat' );
    if ( $terms && ! is_wp_error( $terms ) ) {
        foreach ( $terms as $t ) {
            $t_slug = (string) ( $t->slug ?? '' );
            if ( $t_slug === 'b2b' || strpos( $t_slug, 'b2b' ) !== false ) {
                return true;
            }
            $ancs = get_ancestors( $t->term_id, 'product_cat' );
            foreach ( $ancs as $anc_id ) {
                $anc = get_term( $anc_id, 'product_cat' );
                $anc_slug = ( $anc && isset( $anc->slug ) ) ? (string) $anc->slug : '';
                if ( $anc_slug !== '' && ( $anc_slug === 'b2b' || strpos( $anc_slug, 'b2b' ) !== false ) ) {
                    return true;
                }
            }
        }
    }
    return false;
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
            wp_insert_term( strtoupper( (string) $term_slug ), 'product_cat', array( 'slug' => $term_slug ) );
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
    $host = (string) ( $_SERVER['HTTP_HOST'] ?? '' );
    if ( $status === 'mail_failed' && ( defined('SNAP_LEADS_TESTING') || ( $host !== '' && strpos( $host, 'localhost' ) !== false ) ) ) {
        return "Thank you for your request. Our team will contact you shortly with bulk pricing.";
    }
    return $message;
}, 10, 2 );

add_filter( 'wpcf7_ajax_json_echo', function( $items, $result ) {
    $host = (string) ( $_SERVER['HTTP_HOST'] ?? '' );
    if ( $items['status'] === 'mail_failed' && ( defined('SNAP_LEADS_TESTING') || ( $host !== '' && strpos( $host, 'localhost' ) !== false ) ) ) {
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
        $billing_equivalent = str_replace( 'shipping_', 'billing_', (string) $field );
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
        $display_name = trim( (string) $first_name . ' ' . (string) $last_name );
        wp_update_user( array(
            'ID'           => $customer_id,
            'display_name' => $display_name,
            'nickname'     => $display_name,
        ) );
    }
}




// Ensure registration is enabled on theme switch without unconditional per-request DB writes
add_action( 'after_switch_theme', function() {
    update_option( 'woocommerce_enable_myaccount_registration', 'yes' );
} );
/**
 * Dynamic WooCommerce Categories in Navigation Menu
 */
// WooCommerce categories are now rendered directly by Tailwind_Nav_Walker::render_products_mega_menu()

/**
 * AJAX Handler for Mega Menu Products Accordion
 */
add_action( 'wp_ajax_snap_get_menu_products', 'snap_stitch_get_menu_products' );
add_action( 'wp_ajax_nopriv_snap_get_menu_products', 'snap_stitch_get_menu_products' );
function snap_stitch_get_menu_products() {
    $cat_id = isset( $_POST['cat_id'] ) ? intval( $_POST['cat_id'] ) : 0;
    
    if ( ! $cat_id ) {
        wp_send_json_error( 'Invalid category ID' );
    }

    $term = get_term( $cat_id, 'product_cat' );
    if ( ! $term || is_wp_error( $term ) ) {
        wp_send_json_error( 'Category not found' );
    }

    // Use WP_Query with include_children => true so parent terms return child products
    $args = array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => 8,
        'tax_query'      => array(
            array(
                'taxonomy'         => 'product_cat',
                'field'            => 'term_id',
                'terms'            => $cat_id,
                'include_children' => true,
            ),
        ),
    );
    
    $query = new WP_Query( $args );
    $results = array();
    
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            global $product;
            if ( ! is_a( $product, 'WC_Product' ) ) {
                $product = wc_get_product( get_the_ID() );
            }
            if ( ! $product ) continue;

            $raw_img = wp_get_attachment_image_url( $product->get_image_id(), 'medium' ) ?: '';
            $image_url = function_exists( 'snap_stitch_resolve_b2b_image' ) ? snap_stitch_resolve_b2b_image( $product->get_sku(), $raw_img ) : $raw_img;
            $image_url = $image_url ?: wc_placeholder_img_src();
            $terms = wc_get_product_terms( $product->get_id(), 'product_cat', array( 'fields' => 'names' ) );
            $brand = ! empty( $terms ) ? $terms[0] : 'BLUE STAR';
            $is_b2b = function_exists( 'snap_stitch_is_b2b_product' ) ? snap_stitch_is_b2b_product( $product->get_id() ) : false;

            $results[] = array(
                'id'    => $product->get_id(),
                'title' => $product->get_name(),
                'url'   => $product->get_permalink(),
                'image' => $image_url,
                'brand' => $brand,
                'is_b2b'=> $is_b2b,
            );
        }
        wp_reset_postdata();
    }
    
    $term_link = get_term_link( $term );
    if ( is_wp_error( $term_link ) ) {
        $term_link = home_url( '/product-category/' . $term->slug . '/' );
    }

    wp_send_json_success( array(
        'products' => $results,
        'view_all' => $term_link,
    ) );
}

// Disable admin bar on front-end to remove 46px margin
add_filter('show_admin_bar', '__return_false');

/**
 * WooCommerce Cart Fragments for AJAX Updates
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'snap_stitch_cart_count_fragments', 10, 1 );
function snap_stitch_cart_count_fragments( $fragments ) {
    ob_start();
    $cart_count = WC()->cart->get_cart_contents_count();
    ?>
    <span class="snap-cart-count absolute -top-2 -right-2 bg-secondary-container text-black text-[10px] font-black w-4 h-4 flex items-center justify-center rounded-full">
        <?php echo esc_html( $cart_count ); ?>
    </span>
    <?php
    $fragments['span.snap-cart-count'] = ob_get_clean();
    return $fragments;
}


/**
 * Custom Search AJAX endpoint for the Header Modal
 */
add_action('wp_ajax_nopriv_snap_ajax_search', 'snap_ajax_search_callback');
add_action('wp_ajax_snap_ajax_search', 'snap_ajax_search_callback');

function snap_ajax_search_callback() {
    $search_query = isset($_POST['s']) ? sanitize_text_field( (string) wp_unslash( $_POST['s'] ) ) : '';
    
    if (empty($search_query)) {
        wp_send_json_success([]);
        return;
    }

    $args = [
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => 8,
        's' => $search_query
    ];

    $query = new WP_Query($args);
    $results = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            global $product;
            if ( ! is_a( $product, 'WC_Product' ) ) {
                $product = wc_get_product( get_the_ID() );
            }
            if ( ! $product ) continue;
            
            $is_b2b = function_exists( 'snap_stitch_is_b2b_product' ) ? snap_stitch_is_b2b_product($product->get_id()) : false;
            $price_html = $is_b2b ? '<span class="text-[#FBBF24] text-[10px] uppercase font-black tracking-tighter">B2B Product</span>' : wp_kses_post( (string) $product->get_price_html() );
            
            $raw_thumb = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') ?: '';
            $resolved_thumb = function_exists( 'snap_stitch_resolve_b2b_image' ) ? snap_stitch_resolve_b2b_image( $product->get_sku(), $raw_thumb ) : $raw_thumb;
            
            $results[] = [
                'title' => esc_html( html_entity_decode( (string) get_the_title() ) ),
                'url' => esc_url( get_permalink() ),
                'image' => esc_url( $resolved_thumb ?: wc_placeholder_img_src() ),
                'price' => $price_html
            ];
        }
        wp_reset_postdata();
    }
    
    wp_send_json_success($results);
}

/**
 * Add SEO Meta Description Custom Field to Product Data
 */
add_action( 'woocommerce_product_options_general_product_data', 'snap_stitch_add_seo_meta_field' );
function snap_stitch_add_seo_meta_field() {
    echo '<div class="options_group">';
    woocommerce_wp_textarea_input( array(
        'id'          => '_seo_meta_description',
        'label'       => __( 'SEO Meta Description', 'snap-stitch-theme' ),
        'placeholder' => 'Enter SEO meta description here...',
        'description' => __( 'This description will be added to the &lt;meta name="description"&gt; tag on the frontend for search engines.', 'snap-stitch-theme' ),
        'desc_tip'    => true,
    ) );
    echo '</div>';
}

/**
 * Save the SEO Meta Description Custom Field
 */
add_action( 'woocommerce_process_product_meta', 'snap_stitch_save_seo_meta_field' );
function snap_stitch_save_seo_meta_field( $post_id ) {
    if ( isset( $_POST['_seo_meta_description'] ) ) {
        update_post_meta( $post_id, '_seo_meta_description', sanitize_textarea_field( wp_unslash( $_POST['_seo_meta_description'] ) ) );
    }
}

/**
 * Output SEO Meta Description to wp_head for single products
 */
add_action( 'wp_head', 'snap_stitch_output_seo_meta_description', 1 );
function snap_stitch_output_seo_meta_description() {
    if ( is_product() ) {
        $meta_desc = get_post_meta( get_the_ID(), '_seo_meta_description', true );
        
        // Try fallback to Yoast or RankMath keys just in case
        if ( empty( $meta_desc ) ) {
            $meta_desc = get_post_meta( get_the_ID(), '_yoast_wpseo_metadesc', true );
        }
        if ( empty( $meta_desc ) ) {
            $meta_desc = get_post_meta( get_the_ID(), 'rank_math_description', true );
        }

        if ( ! empty( $meta_desc ) ) {
            echo '<meta name="description" content="' . esc_attr( wp_strip_all_tags( $meta_desc ) ) . '">' . "\n";
        } else {
            // Fallback to excerpt if no meta description is set
            $excerpt = get_the_excerpt();
            if ( ! empty( $excerpt ) ) {
                $excerpt = wp_trim_words( $excerpt, 30, '' );
                echo '<meta name="description" content="' . esc_attr( wp_strip_all_tags( $excerpt ) ) . '">' . "\n";
            }
        }
    }
}

/**
 * Auto-Provision Essential Pages (FAQ, etc.)
 * Ensures that as soon as this theme is active on any server (local or live),
 * the /faq page is automatically created, published, and assigned page-faq.php template.
 * Eliminates the need for manual setup in WordPress Admin.
 */
function snap_stitch_auto_provision_essential_pages() {
    // 1. FAQ Page (/faq)
    $faq_page = get_page_by_path( 'faq' );
    if ( ! $faq_page ) {
        $page_id = wp_insert_post( array(
            'post_title'     => 'Frequently Asked Questions',
            'post_name'      => 'faq',
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'post_content'   => '',
            'comment_status' => 'closed',
        ) );
        if ( $page_id && ! is_wp_error( $page_id ) ) {
            update_post_meta( $page_id, '_wp_page_template', 'page-faq.php' );
        }
    } else {
        $current_tpl = get_post_meta( $faq_page->ID, '_wp_page_template', true );
        if ( 'page-faq.php' !== $current_tpl ) {
            update_post_meta( $faq_page->ID, '_wp_page_template', 'page-faq.php' );
        }
    }
}
add_action( 'init', 'snap_stitch_auto_provision_essential_pages' );


/**
 * Redirect deprecated categories and align taxonomy URLs.
 */
function snap_stitch_redirect_deprecated_categories() {
    if ( is_admin() || wp_doing_ajax() ) {
        return;
    }
    $request_uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( (string) $_SERVER['REQUEST_URI'] ) ) : '';

    // Redirect deprecated water purifier categories to B2B commercial catalog.
    if ( preg_match( '#/product-category/(?:b2b/)?(?:b2b-)?water-?purifiers/?#i', $request_uri ) ) {
        wp_safe_redirect( home_url( '/product-category/b2b/' ), 301 );
        exit;
    }

    // 301 Redirect legacy others-central-air-conditioning to canonical condensing-units
    if ( preg_match( '#/others-central-air-conditioning/?#i', $request_uri ) ) {
        wp_safe_redirect( home_url( '/product-category/b2b/blue-star-commercial/central-air-conditioning/condensing-units/' ), 301 );
        exit;
    }

    // 301 Redirect legacy duplicate concealed-split-acs to canonical concealed-splits
    if ( preg_match( '#/concealed-split-acs/?#i', $request_uri ) ) {
        wp_safe_redirect( home_url( '/product-category/b2b/blue-star-commercial/light-commercial-acs/concealed-splits/' ), 301 );
        exit;
    }

    // 301 Redirects for legacy/shorthand department category URLs
    if ( preg_match( '#^/product-category/commercial-refrigeration/?$#i', $request_uri ) ) {
        wp_safe_redirect( home_url( '/product-category/b2b/blue-star-commercial/b2b-commercial-refrigeration/' ), 301 );
        exit;
    }
    if ( preg_match( '#^/product-category/water-coolers/?$#i', $request_uri ) ) {
        wp_safe_redirect( home_url( '/product-category/b2b/blue-star-commercial/water-coolers/' ), 301 );
        exit;
    }
    if ( preg_match( '#^/product-category/washroom-automations/?$#i', $request_uri ) ) {
        wp_safe_redirect( home_url( '/product-category/b2b/euronics-commercial/' ), 301 );
        exit;
    }
    if ( preg_match( '#^/product-category/hygiene-ppe/?$#i', $request_uri ) ) {
        wp_safe_redirect( home_url( '/product-category/b2b/kimberly-clark-commercial/' ), 301 );
        exit;
    }
    if ( preg_match( '#^/product-category/entrance-solutions/?$#i', $request_uri ) ) {
        wp_safe_redirect( home_url( '/product-category/b2b/euronics-commercial/euronics-air-curtains/' ), 301 );
        exit;
    }
    if ( preg_match( '#^/product-category/vending-machines/?$#i', $request_uri ) ) {
        wp_safe_redirect( home_url( '/product-category/b2b/corporate-pantry/coffee-vending-machines/' ), 301 );
        exit;
    }
}
add_action( 'template_redirect', 'snap_stitch_redirect_deprecated_categories', 5 );

/**
 * Route B2B single product requests to the unified multi-model category showcase page.
 * Enforces single-page presentation for all models in the same category/brand.
 */
function snap_stitch_route_b2b_single_products() {
    if ( is_admin() || wp_doing_ajax() ) {
        return;
    }
    if ( ! is_singular( 'product' ) && ! is_product() ) {
        return;
    }
    $product_id = get_queried_object_id();
    if ( ! $product_id ) {
        $product_id = get_the_ID();
    }
    if ( ! $product_id || ! function_exists( 'snap_stitch_is_b2b_product' ) || ! snap_stitch_is_b2b_product( $product_id ) ) {
        return;
    }
    
    // Find the product's primary commercial category
    $terms = get_the_terms( $product_id, 'product_cat' );
    if ( ! $terms || is_wp_error( $terms ) ) {
        return;
    }
    
    $target_term = null;
    $parents = wp_list_pluck( $terms, 'parent' );
    
    // Select the deepest leaf category (not a parent of any other term in the list, and not the root 'b2b')
    $candidates = array();
    foreach ( $terms as $term ) {
        if ( $term->slug === 'b2b' ) {
            continue;
        }
        if ( ! in_array( $term->term_id, $parents, true ) ) {
            $candidates[] = $term;
        }
    }
    if ( ! empty( $candidates ) ) {
        $target_term = $candidates[0];
    } else {
        foreach ( $terms as $term ) {
            if ( $term->slug !== 'b2b' && $term->parent !== 0 ) {
                $target_term = $term;
                break;
            }
        }
    }
    if ( ! $target_term && ! empty( $terms ) ) {
        $target_term = $terms[0];
    }
    
    if ( $target_term ) {
        $cat_url = get_term_link( $target_term );
        if ( ! is_wp_error( $cat_url ) ) {
            wp_safe_redirect( $cat_url . '#model-' . $product_id, 301 );
            exit;
        }
    }
}
add_action( 'template_redirect', 'snap_stitch_route_b2b_single_products', 10 );

/**
 * Canonical B2B product image resolver
 */
if ( ! function_exists( 'snap_stitch_resolve_b2b_image' ) ) {
    function snap_stitch_resolve_b2b_image( $sku, $existing_url = '' ) {
        $theme_uri = get_template_directory_uri();
        $theme_dir = get_template_directory();
        $u_sku = strtoupper( (string) $sku );
        $has_valid_existing = ( ! empty( $existing_url ) && strpos( (string) $existing_url, 'placeholder' ) === false );

        // 1. Brewing Bots
        if ( strpos( $u_sku, 'BOT-' ) !== false || strpos( $u_sku, 'BREWING' ) !== false ) {
            if ( strpos( $u_sku, 'MCP-750' ) !== false || strpos( $u_sku, 'CAMPUS' ) !== false ) return $theme_uri . '/images/brewing-bots/personal-large.webp';
            if ( strpos( $u_sku, 'MCP-500' ) !== false || strpos( $u_sku, 'BATCH' ) !== false ) return $theme_uri . '/images/brewing-bots/personal-small.webp';
            if ( strpos( $u_sku, 'B2C-70' ) !== false || strpos( $u_sku, 'BEAN' ) !== false ) return $theme_uri . '/images/brewing-bots/bean-to-cup.webp';
            if ( strpos( $u_sku, 'L2C-50' ) !== false || strpos( $u_sku, 'LEAF' ) !== false ) return $theme_uri . '/images/brewing-bots/leaf-to-cup.webp';
            return $theme_uri . '/images/brewing-bots/personal-large.webp';
        }

        // 2. Nestlé Professional Commercial Coffee Machines
        if ( strpos( $u_sku, 'NES-' ) !== false || strpos( $u_sku, 'NESTLE' ) !== false || strpos( $u_sku, 'AMIGO' ) !== false || strpos( $u_sku, 'PREMIO' ) !== false || strpos( $u_sku, 'FRIO' ) !== false ) {
            if ( strpos( $u_sku, 'PREMIO' ) !== false ) return $theme_uri . '/images/nestle-machines/hardware/premio-front.png';
            if ( strpos( $u_sku, 'AMIGO' ) !== false ) return $theme_uri . '/images/nestle-machines/hardware/amigo-front.png';
            if ( strpos( $u_sku, 'DUO' ) !== false || strpos( $u_sku, 'GUSTO' ) !== false ) return $theme_uri . '/images/nestle-machines/hardware/duo-gusto-front.png';
            if ( strpos( $u_sku, 'SOLUTION' ) !== false || strpos( $u_sku, 'NES-SOL' ) !== false || strpos( $u_sku, 'SOL-200' ) !== false ) return $theme_uri . '/images/nestle-machines/hardware/solution-front.webp';
            if ( strpos( $u_sku, 'SPECTRA' ) !== false || strpos( $u_sku, 'NES-SPEC' ) !== false || strpos( $u_sku, 'SPEC-150' ) !== false ) return $theme_uri . '/images/nestle-machines/hardware/spectra-front.png';
            if ( strpos( $u_sku, 'FRIO' ) !== false ) return $theme_uri . '/images/nestle-machines/hardware/frio-front.webp';
            return $theme_uri . '/images/nestle-machines/hardware/premio-front.png';
        }

        // 3. Usha Water Solutions
        if ( strpos( $u_sku, 'USHA' ) !== false ) {
            if ( strpos( $u_sku, 'INSTAFRESH-CB' ) !== false || strpos( $u_sku, 'CABINET' ) !== false ) return $theme_uri . '/images/usha/usha-instafresh-cb.jpg';
            if ( strpos( $u_sku, 'INSTAFRESH-TT' ) !== false || strpos( $u_sku, 'TABLE' ) !== false ) return $theme_uri . '/images/usha/usha-instafresh-tt.png';
            if ( strpos( $u_sku, 'AQUAGENIE' ) !== false || strpos( $u_sku, 'PLUS' ) !== false ) return $theme_uri . '/images/usha/usha-aquagenie.jpg';
            if ( strpos( $u_sku, '40/80' ) !== false || strpos( $u_sku, '40-80' ) !== false ) return $theme_uri . '/images/usha/usha-swc-40-80.jpg';
            if ( strpos( $u_sku, '150/150' ) !== false || strpos( $u_sku, '150-150' ) !== false ) return $theme_uri . '/images/usha/usha-swc-150-150.jpg';
            if ( strpos( $u_sku, '300/400' ) !== false || strpos( $u_sku, '300-400' ) !== false || strpos( $u_sku, 'XXL' ) !== false ) return $theme_uri . '/images/usha/usha-swc-300-400.jpg';
            if ( strpos( $u_sku, 'INLINE' ) !== false || strpos( $u_sku, 'IC-' ) !== false ) return $theme_uri . '/images/usha/usha-inline-60.jpg';
            return $theme_uri . '/images/usha/usha-aquagenie.jpg';
        }

        // 4. Eureka Forbes Commercial
        if ( preg_match( '/(^|-)EF-/', $u_sku ) || strpos( $u_sku, 'EUREKA' ) !== false ) {
            if ( strpos( $u_sku, 'PRIMA' ) !== false || strpos( $u_sku, '50B' ) !== false ) return $theme_uri . '/images/eureka-forbes/ef-prima-50b.jpg';
            if ( strpos( $u_sku, 'COMM-200' ) !== false || strpos( $u_sku, '200' ) !== false ) return $theme_uri . '/images/eureka-forbes/ef-comm-200.png';
            if ( strpos( $u_sku, 'UV' ) !== false ) return $theme_uri . '/images/eureka-forbes/ef-comm-uv-ss.png';
            if ( strpos( $u_sku, 'PURECHILL' ) !== false || strpos( $u_sku, '80/120' ) !== false ) return $theme_uri . '/images/eureka-forbes/ef-purechill-80-120.jpg';
            if ( strpos( $u_sku, 'HOT-COLD' ) !== false || strpos( $u_sku, 'PRO-' ) !== false ) return $theme_uri . '/images/eureka-forbes/ef-pro-hot-cold.jpg';
            if ( strpos( $u_sku, 'SKID' ) !== false || strpos( $u_sku, '500' ) !== false ) return $theme_uri . '/images/eureka-forbes/ef-skid-ro-500.jpg';
            return $theme_uri . '/images/eureka-forbes/ef-prima-50b.jpg';
        }

        // 5. Blue Star Specific Models & Series
        if ( strpos( $u_sku, 'IC324DNUHC' ) !== false || strpos( $u_sku, 'DNUHC' ) !== false ) {
            return home_url( '/wp-content/uploads/2026/08/ID318DNUHC_Gallery_Images_01.png' );
        }
        if ( strpos( $u_sku, 'BWD-GA-REF-GR' ) !== false || strpos( $u_sku, 'GA-REF-GR' ) !== false ) {
            return home_url( '/wp-content/uploads/2026/08/bwd3fmrga-g_1_bwd3fmrga_grey_straight_view.png' );
        }
        if ( strpos( $u_sku, 'BWD-GA-REF-MR' ) !== false || strpos( $u_sku, 'GA-REF-MR' ) !== false ) {
            return home_url( '/wp-content/uploads/2026/08/bwd3fmrga-m_1_bwd3fmrga_maroon_straight_view.png' );
        }
        if ( strpos( $u_sku, 'BWD-GA-REF-WH' ) !== false || strpos( $u_sku, 'GA-REF-WH' ) !== false ) {
            return home_url( '/wp-content/uploads/2026/08/BWD3FMRGA-scaled.png' );
        }
        if ( strpos( $u_sku, 'BWD-GA-REF' ) !== false || strpos( $u_sku, 'BWD-GA' ) !== false ) {
            return home_url( '/wp-content/uploads/2026/08/ga.jpg' );
        }
        if ( strpos( $u_sku, 'BWD-GB' ) !== false ) {
            return home_url( '/wp-content/uploads/2026/08/gb-1.jpg' );
        }
        if ( strpos( $u_sku, 'BWD-UA' ) !== false ) {
            return home_url( '/wp-content/uploads/2026/08/ua-1.jpg' );
        }
        if ( strpos( $u_sku, 'BWD-ECO' ) !== false ) {
            return home_url( '/wp-content/uploads/2026/08/bwd-eco-series-326x220-1.png' );
        }
        if ( strpos( $u_sku, 'BWD-BOTTOM-LOAD' ) !== false || strpos( $u_sku, 'BOTTOM-LOAD' ) !== false ) {
            return home_url( '/wp-content/uploads/2026/08/bottomloadingdispensers-1.jpg' );
        }
        if ( strpos( $u_sku, 'BWD-PLATINUM' ) !== false ) {
            return home_url( '/wp-content/uploads/2026/08/storage-water-cooler-platinum-326x220-2.png' );
        }

        // Blue Star Storage Water Coolers
        if ( strpos( $u_sku, 'SWC-WARM-COLD' ) !== false ) {
            return home_url( '/wp-content/uploads/2026/08/storage-water-cooler-warm-cold-326x220-1.png' );
        }
        if ( strpos( $u_sku, 'SWC-SUPER-COOLER' ) !== false ) {
            return home_url( '/wp-content/uploads/2026/08/super-cooler-326x220-1.png' );
        }
        if ( strpos( $u_sku, 'SWC-TROPICAL' ) !== false ) {
            return home_url( '/wp-content/uploads/2026/08/water-coolers-1.png' );
        }
        if ( strpos( $u_sku, 'SDLX' ) !== false ) {
            return home_url( '/wp-content/uploads/2026/08/storage-water-cooler-sdlx-326x220-2.png' );
        }

        // 6. Blue Star Visi Coolers & Freezers
        if ( strpos( $u_sku, 'VC-TT-55' ) !== false || strpos( $u_sku, 'VC65D' ) !== false || strpos( $u_sku, 'VC-TT' ) !== false ) {
            return home_url( '/wp-content/uploads/2026/08/VC65D.png' );
        }
        if ( strpos( $u_sku, 'SC-595' ) !== false || strpos( $u_sku, 'SC600F' ) !== false ) {
            return home_url( '/wp-content/uploads/2026/08/SC600F.png' );
        }
        if ( strpos( $u_sku, 'SC-448' ) !== false || strpos( $u_sku, 'SC500F' ) !== false ) {
            return home_url( '/wp-content/uploads/2026/08/SC500F.png' );
        }
        if ( strpos( $u_sku, 'SC-358' ) !== false || strpos( $u_sku, 'SC375' ) !== false ) {
            return home_url( '/wp-content/uploads/2026/08/SC375_74b1966b-be7e-4ce5-818c-672054881d44.png' );
        }
        if ( strpos( $u_sku, 'SC-285' ) !== false || strpos( $u_sku, 'SC300F' ) !== false ) {
            return home_url( '/wp-content/uploads/2026/08/SC300F.png' );
        }
        if ( strpos( $u_sku, 'VC-A-SERIES' ) !== false ) {
            return home_url( '/wp-content/uploads/2026/08/visi-cooler-a-series-326x220-2.png' );
        }
        if ( strpos( $u_sku, 'VC-C-SERIES' ) !== false ) {
            return home_url( '/wp-content/uploads/2026/08/visi-cooler-c-series-326x220-2.png' );
        }
        if ( strpos( $u_sku, 'VC-D-SERIES' ) !== false ) {
            return home_url( '/wp-content/uploads/2026/08/visi-cooler-d-series-326x220-2.png' );
        }
        if ( strpos( $u_sku, 'VF-SERIES' ) !== false || strpos( $u_sku, 'VISIFREEZER' ) !== false || strpos( $u_sku, 'VISI-FREEZER' ) !== false ) {
            return home_url( '/wp-content/uploads/2026/08/a4_visifreezer-flyer-plate-2-3.jpg' );
        }

        // 7. Blue Star Chest Freezers (Hard Top vs Glass Top)
        if ( strpos( $u_sku, 'GT530' ) !== false ) return home_url( '/wp-content/uploads/2026/08/GalleryImage01_ea8c4ff9-1764-43ad-be5d-58084d43697d.png' );
        if ( strpos( $u_sku, 'GT421' ) !== false ) return home_url( '/wp-content/uploads/2026/08/GalleryImage01_df3f0d97-4883-48d6-b47f-efae63fd02c9.png' );
        if ( strpos( $u_sku, 'GT365' ) !== false ) return home_url( '/wp-content/uploads/2026/08/GalleryImage01_fa7f2a32-c60d-4b42-a710-a157719b39a7.png' );
        if ( strpos( $u_sku, 'GT315' ) !== false ) return home_url( '/wp-content/uploads/2026/08/GalleryImage01_fbd8dd4a-4385-402a-9773-071762fc7252.png' );
        if ( strpos( $u_sku, 'GT215' ) !== false ) return home_url( '/wp-content/uploads/2026/08/Gallery_Image_01_1fa59f45-e37b-4a1b-a8bf-e99d5c3eab39.png' );
        if ( strpos( $u_sku, 'CF-GLASS-TOP' ) !== false ) return home_url( '/wp-content/uploads/2026/08/glass-top-freezer-5.png' );

        if ( strpos( $u_sku, 'CHFDD500' ) !== false || strpos( $u_sku, 'CHFDD' ) !== false ) {
            return home_url( '/wp-content/uploads/2026/08/GalleryImages01_c798f744-ed07-47de-8074-4b3b6213d49d.png' );
        }
        if ( strpos( $u_sku, 'CHF-HARD-TOP' ) !== false || strpos( $u_sku, 'CHFSD' ) !== false ) {
            return home_url( '/wp-content/uploads/2026/08/hard-top-freezer-2-3.jpg' );
        }

        // 8. Blue Star Light Commercial ACs
        if ( strpos( $u_sku, 'OIA318' ) !== false || strpos( $u_sku, 'OIA224' ) !== false || strpos( $u_sku, 'CASS-1W' ) !== false || strpos( $u_sku, '1-WAY' ) !== false || strpos( $u_sku, 'BS-CAS-1W' ) !== false ) {
            if ( $has_valid_existing ) return $existing_url;
            return 'https://resources.bluestarindia.com/1_waycassatte_927857fc3c.png';
        }
        if ( strpos( $u_sku, 'BS-LC-VERT' ) !== false || strpos( $u_sku, 'BS-VER' ) !== false || strpos( $u_sku, 'VERTICOOL' ) !== false ) {
            return 'https://resources.bluestarindia.com/G_Series_a4341b2647.png';
        }
        if ( strpos( $u_sku, 'BS-LC-CONC' ) !== false || strpos( $u_sku, 'BS-CON' ) !== false || strpos( $u_sku, 'CONCEALED' ) !== false ) {
            return 'https://resources.bluestarindia.com/Frame_3_2_9052b81fb1.png';
        }
        if ( strpos( $u_sku, 'BS-LC-CASS' ) !== false || strpos( $u_sku, 'BS-CAS' ) !== false || strpos( $u_sku, 'CASS-4W' ) !== false ) {
            return 'https://resources.bluestarindia.com/Layer_550_96ac8b7929.png';
        }
        if ( strpos( $u_sku, 'BS-LC' ) !== false || strpos( $u_sku, 'VERT' ) !== false || strpos( $u_sku, 'CASS' ) !== false || strpos( $u_sku, 'CONC' ) !== false ) {
            if ( strpos( $u_sku, 'VERT' ) !== false ) return 'https://resources.bluestarindia.com/G_Series_a4341b2647.png';
            if ( strpos( $u_sku, 'CONC' ) !== false ) return 'https://resources.bluestarindia.com/Frame_3_2_9052b81fb1.png';
            if ( strpos( $u_sku, '1W' ) !== false ) return 'https://resources.bluestarindia.com/1_waycassatte_927857fc3c.png';
            return 'https://resources.bluestarindia.com/Layer_550_96ac8b7929.png';
        }

        // 9. Blue Star Central Air Conditioning (VRF, Ducted, Chillers, Condensing Units)
        if ( strpos( $u_sku, 'VRF' ) !== false ) {
            return 'https://resources.bluestarindia.com/Side_Disch1_1_3_075e9fbe62.jpg';
        }
        if ( strpos( $u_sku, 'DS-PACKAGED' ) !== false || strpos( $u_sku, 'PACKAGED' ) !== false || strpos( $u_sku, 'DUCTED' ) !== false ) {
            return 'https://resources.bluestarindia.com/DPA_IDU_2_Front_Indoor1_1_f1767bf22d.png';
        }
        if ( strpos( $u_sku, 'LC-SCROLL-CHILLER' ) !== false || strpos( $u_sku, 'PROCESS' ) !== false ) {
            return 'https://resources.bluestarindia.com/1_1_a5c9b854cc.png';
        }
        if ( strpos( $u_sku, 'WCC-CENTRIFUGAL' ) !== false || strpos( $u_sku, 'CENTRIFUGAL' ) !== false ) {
            return 'https://resources.bluestarindia.com/centrifugal_chiller_FRONT_OP_2_0a6ee5bf7c.png';
        }
        if ( strpos( $u_sku, 'CDU-COMMERCIAL' ) !== false || strpos( $u_sku, 'CONDENSING' ) !== false ) {
            return 'https://resources.bluestarindia.com/Fixed_Speed_Scroll_f0050c1862.jpg';
        }

        // Blue Star Cold Storages & Commercial Refrigeration Systems
        if ( strpos( $u_sku, 'RS-HERMETIC' ) !== false ) {
            return 'https://resources.bluestarindia.com/Hermetic_Series_isolation_c6f8c964c2.png';
        }
        if ( strpos( $u_sku, 'RS-SEMI-HERMETIC' ) !== false ) {
            return 'https://resources.bluestarindia.com/RUAHOS_3014_122_Grey_BG_b3e4c0703c.png';
        }
        if ( strpos( $u_sku, 'CR-MODULAR-PUF' ) !== false || strpos( $u_sku, 'B2B-838174' ) !== false || strpos( $u_sku, 'MODULAR' ) !== false ) {
            return 'https://resources.bluestarindia.com/Modular_Cold_Room_d6af2bdbf3.png';
        }
        if ( strpos( $u_sku, 'CR-RIPENING' ) !== false || strpos( $u_sku, 'B2B-689670' ) !== false || strpos( $u_sku, 'RIPENING' ) !== false || strpos( $u_sku, 'PUF-PANELS' ) !== false ) {
            return 'https://resources.bluestarindia.com/Cold_Room_01_Grey_BG_ee9731fcf1.png';
        }
        if ( strpos( $u_sku, 'MORTUARY' ) !== false || strpos( $u_sku, 'MC-' ) !== false ) {
            return 'https://resources.bluestarindia.com/Mortuary_7c68f8fc99.png';
        }
        if ( strpos( $u_sku, 'IM-COMMERCIAL' ) !== false || strpos( $u_sku, 'ICE-MACHINE' ) !== false ) {
            return home_url( '/wp-content/uploads/2026/08/ice-machines-326x220-4.png' );
        }
        if ( strpos( $u_sku, 'MR60' ) !== false || strpos( $u_sku, 'B2B-A80344' ) !== false ) {
            return home_url( '/wp-content/uploads/2026/08/mr60_black-iso-right-1-326x220-4.png' );
        }

        // 10. Euronics Commercial Washroom Automation
        if ( strpos( $u_sku, 'EUR-' ) !== false ) {
            if ( $has_valid_existing ) return $existing_url;
            if ( strpos( $u_sku, 'EAS' ) !== false || strpos( $u_sku, 'EAC' ) !== false || strpos( $u_sku, 'CURTAIN' ) !== false ) {
                return home_url( '/wp-content/uploads/2026/10/snap-b2b-euronics-air-curtains.jpg' );
            }
            if ( strpos( $u_sku, 'EP' ) !== false || strpos( $u_sku, 'LINEA' ) !== false || strpos( $u_sku, 'TRIMAX AP' ) !== false || strpos( $u_sku, 'PAPER' ) !== false ) {
                return home_url( '/wp-content/uploads/2026/10/snap-b2b-euronics-paper-dispensers.jpg' );
            }
            if ( strpos( $u_sku, 'EU' ) !== false || strpos( $u_sku, 'KUF' ) !== false || strpos( $u_sku, 'SMARTFLUSH' ) !== false || strpos( $u_sku, 'FLUSH' ) !== false ) {
                return home_url( '/wp-content/uploads/2026/10/snap-b2b-euronics-urinal-sensors.jpg' );
            }
            if ( strpos( $u_sku, 'ES' ) !== false || strpos( $u_sku, 'TRIMAX S' ) !== false || strpos( $u_sku, 'SOAP' ) !== false ) {
                return home_url( '/wp-content/uploads/2026/10/snap-b2b-euronics-soap-dispensers.jpg' );
            }
            if ( strpos( $u_sku, 'ET' ) !== false || strpos( $u_sku, 'AXEON' ) !== false || strpos( $u_sku, 'ARCTIC' ) !== false || strpos( $u_sku, 'KSDT' ) !== false || strpos( $u_sku, 'TAP' ) !== false ) {
                return home_url( '/wp-content/uploads/2026/10/snap-b2b-euronics-sensor-taps.jpg' );
            }
            if ( strpos( $u_sku, 'RHD' ) !== false || strpos( $u_sku, 'EJD' ) !== false || strpos( $u_sku, 'YZD' ) !== false || strpos( $u_sku, 'SJD' ) !== false || strpos( $u_sku, 'XJD' ) !== false || strpos( $u_sku, 'DRYER' ) !== false ) {
                return home_url( '/wp-content/uploads/2026/10/snap-b2b-euronics-hand-dryers.jpg' );
            }
            return home_url( '/wp-content/uploads/2026/10/snap-b2b-euronics-sensor-taps.jpg' );
        }

        // 11. Kimberly-Clark Professional Commercial Hygiene & Safety
        if ( strpos( $u_sku, 'KCP-' ) !== false || strpos( $u_sku, 'KIMBERLY' ) !== false || strpos( $u_sku, 'KC-' ) !== false ) {
            $kc_models = array(
                '70230', '49807', '70220', '69530', '69590', '69450', '1578', '02046', '02000', '6695',
                '11329', '69480', '6385', '12552', '30840',
                '70210', '45348', '01057', '04003', '03060', '4002',
                '6221', '8361', '1380', '6036', '03024', '60019', '94224', '41055',
                '34155', '34256', '01030', '7623',
                '38702', '53334', '97920', '97930',
                '1282', '1033', '01175'
            );
            foreach ( $kc_models as $m_num ) {
                if ( strpos( $u_sku, $m_num ) !== false ) {
                    $m_file = 'kc-' . $m_num . '.jpg';
                    if ( $m_num === '45348' ) $m_file = 'kc-45348A.jpg';
                    if ( $m_num === '4002' ) $m_file = 'kc-4002A.jpg';
                    if ( $m_num === '1380' ) $m_file = 'kc-1380A.jpg';
                    if ( file_exists( $theme_dir . '/images/kc/' . $m_file ) ) {
                        return $theme_uri . '/images/kc/' . $m_file;
                    }
                }
            }

            if ( strpos( $u_sku, 'WYPALL' ) !== false || strpos( $u_sku, 'X80' ) !== false || strpos( $u_sku, 'X70' ) !== false || strpos( $u_sku, 'X60' ) !== false || strpos( $u_sku, 'L10' ) !== false ) {
                return $theme_uri . '/images/kc/kc-wypall.jpg';
            }
            if ( strpos( $u_sku, 'KIMTECH' ) !== false || strpos( $u_sku, 'KIMWIPES' ) !== false || strpos( $u_sku, 'KIMTEX' ) !== false ) {
                return $theme_uri . '/images/kc/kc-kimtech.jpg';
            }
            if ( strpos( $u_sku, 'KLEENGUARD' ) !== false || strpos( $u_sku, 'GLOVE' ) !== false ) {
                return $theme_uri . '/images/kc/kc-kleenguard.jpg';
            }
            if ( strpos( $u_sku, 'TISSUE' ) !== false || strpos( $u_sku, 'JRT' ) !== false ) {
                return $theme_uri . '/images/kc/kc-bathroom-tissue.jpg';
            }
            if ( strpos( $u_sku, 'SOAP' ) !== false || strpos( $u_sku, 'FOAM' ) !== false || strpos( $u_sku, 'SKINCARE' ) !== false ) {
                return $theme_uri . '/images/kc/kc-skincare.jpg';
            }
            if ( strpos( $u_sku, 'FACIAL' ) !== false || strpos( $u_sku, 'CUBE' ) !== false ) {
                return $theme_uri . '/images/kc/kc-facial.jpg';
            }
            return $theme_uri . '/images/kc/kc-hand-towel.jpg';
        }

        // 12. Tetley Corporate Teas
        if ( strpos( $u_sku, 'TET-' ) !== false ) {
            if ( strpos( $u_sku, 'MASALA' ) !== false && file_exists( $theme_dir . '/images/tetley/tetley-masala.jpg' ) ) return $theme_uri . '/images/tetley/tetley-masala.jpg';
            if ( ( strpos( $u_sku, 'LEMON' ) !== false || strpos( $u_sku, 'HONEY' ) !== false ) && file_exists( $theme_dir . '/images/tetley/tetley-lemon-honey.jpg' ) ) return $theme_uri . '/images/tetley/tetley-lemon-honey.jpg';
            if ( strpos( $u_sku, 'CAMOMILE' ) !== false && file_exists( $theme_dir . '/images/tetley/tetley-camomile.jpg' ) ) return $theme_uri . '/images/tetley/tetley-camomile.jpg';
            if ( strpos( $u_sku, 'PEPPERMINT' ) !== false && file_exists( $theme_dir . '/images/tetley/tetley-peppermint.jpg' ) ) return $theme_uri . '/images/tetley/tetley-peppermint.jpg';
            if ( strpos( $u_sku, 'LONGLEAF' ) !== false && file_exists( $theme_dir . '/images/tetley/tetley-longleaf.jpg' ) ) return $theme_uri . '/images/tetley/tetley-longleaf.jpg';
            if ( strpos( $u_sku, 'ASSAM' ) !== false && file_exists( $theme_dir . '/images/tetley/tetley-assam.jpg' ) ) return $theme_uri . '/images/tetley/tetley-assam.jpg';
            if ( strpos( $u_sku, 'CLASSIC' ) !== false ) return $theme_uri . '/images/tetley/tetley-classic.jpg';
            if ( strpos( $u_sku, 'ELAICHI' ) !== false ) return $theme_uri . '/images/tetley/tetley-elaichi.png';
            if ( strpos( $u_sku, 'GINGER' ) !== false ) return $theme_uri . '/images/tetley/tetley-ginger.png';
            return $theme_uri . '/images/tetley/tetley-plain.png';
        }

        // 13. Atlantis Instant Beverage Premixes & Equipment
        if ( strpos( $u_sku, 'ATL-' ) !== false || strpos( $u_sku, 'ATLANTIS' ) !== false ) {
            if ( $has_valid_existing ) {
                return $existing_url;
            }
            if ( strpos( $u_sku, 'COLD' ) !== false ) {
                return home_url( '/wp-content/uploads/2026/10/snap-b2b-atlantis-cold-beverages.jpg' );
            }
            if ( strpos( $u_sku, 'COFF' ) !== false || strpos( $u_sku, 'COFFEE' ) !== false ) {
                return home_url( '/wp-content/uploads/2026/10/snap-b2b-atlantis-coffee-premixes.jpg' );
            }
            return home_url( '/wp-content/uploads/2026/10/snap-b2b-atlantis-tea-premixes.jpg' );
        }

        // 14. Waterlogic Commercial Firewall Dispensers
        if ( strpos( $u_sku, 'WL-' ) !== false || strpos( $u_sku, 'WATERLOGIC' ) !== false || strpos( $u_sku, 'FIREWALL' ) !== false ) {
            if ( strpos( $u_sku, 'WL-7' ) !== false || strpos( $u_sku, 'WL7' ) !== false ) return $theme_uri . '/images/waterlogic/wl7.png';
            if ( strpos( $u_sku, 'WL-3' ) !== false || strpos( $u_sku, 'WL3' ) !== false ) return $theme_uri . '/images/waterlogic/wl3.png';
            if ( strpos( $u_sku, 'WL-2' ) !== false || strpos( $u_sku, 'WL2' ) !== false ) return $theme_uri . '/images/waterlogic/wl2.png';
            if ( strpos( $u_sku, 'CUBE' ) !== false ) return $theme_uri . '/images/waterlogic/cube.png';
            return $theme_uri . '/images/waterlogic/wl7.png';
        }

        // Preserve authentic uploaded images if non-placeholder
        if ( $has_valid_existing ) {
            return $existing_url;
        }

        return wc_placeholder_img_src();
    }
}

/**
 * Universal B2B Brochure Resolution Engine (Snap Marketing Self-Hosted PDF Assets)
 *
 * Cascading Resolution:
 * Level 1: Product Specific Datasheet (matching SKU / model)
 * Level 2: Sub-Category / Series Brochure (matching category slug)
 * Level 3: Brand Master Catalog Fallback
 *
 * @param int    $product_id
 * @param string $sku
 * @param string $active_subcat_slug
 * @param string $root_brand_slug
 * @return string Dynamic internal brochure URL on snapmktg.com
 */
if ( ! function_exists( 'snap_stitch_resolve_b2b_brochure' ) ) {
    function snap_stitch_resolve_b2b_brochure( $product_id = 0, $sku = '', $active_subcat_slug = '', $root_brand_slug = '' ) {
        $theme_uri = set_url_scheme( get_template_directory_uri(), 'https' );
        $theme_dir = get_template_directory();
        $u_sku = strtoupper( (string) $sku );

        // -------------------------------------------------------------
        // Level 1: Dedicated Product / Model Specific Datasheets
        // -------------------------------------------------------------
        $model_map = array(
            // Blue Star Water Dispensers & Storage Water Coolers
            'BWD-GA'                            => 'bluestar/bottled-water-dispensers.pdf',
            'BWD-ECO'                           => 'bluestar/bottled-water-dispensers.pdf',
            'BWD-UA'                            => 'bluestar/bottled-water-dispensers.pdf',
            'BWD-GB'                            => 'bluestar/bottled-water-dispensers.pdf',
            'BWD-BOTTOM-LOAD'                   => 'bluestar/bottled-water-dispensers.pdf',
            'BWD-PLATINUM'                      => 'bluestar/storage-water-coolers.pdf',
            'SWC-WARM-COLD'                     => 'bluestar/storage-water-coolers-warm-cold.pdf',
            'SWC-SUPER-COOLER'                  => 'bluestar/storage-water-coolers.pdf',
            'SWC-TROPICAL'                      => 'bluestar/storage-water-coolers.pdf',
            'SDLX-SERIES'                       => 'bluestar/storage-water-coolers.pdf',

            // Blue Star Specialty Coolers & Freezers
            'B2B-A33518'                        => 'bluestar/chest-coolers.pdf',
            'B2B-A80344'                        => 'bluestar/mini-bars.pdf',
            'MR60'                              => 'bluestar/mini-bars.pdf',
            'VF-SERIES'                         => 'bluestar/visi-freezers.pdf',
            'CF-GLASS-TOP'                      => 'bluestar/visi-freezers.pdf',
            'GT215'                             => 'bluestar/visi-freezers.pdf',
            'GT315'                             => 'bluestar/visi-freezers.pdf',
            'GT365'                             => 'bluestar/visi-freezers.pdf',
            'GT421'                             => 'bluestar/visi-freezers.pdf',
            'GT530'                             => 'bluestar/visi-freezers.pdf',

            // Blue Star Visi Coolers
            'SC-285'                            => 'bluestar/visi-coolers.pdf',
            'SC-358'                            => 'bluestar/visi-coolers.pdf',
            'SC-448'                            => 'bluestar/visi-coolers.pdf',
            'SC-595'                            => 'bluestar/visi-coolers.pdf',
            'VC-TT-55'                          => 'bluestar/visi-coolers.pdf',
            'VC-A-SERIES'                       => 'bluestar/visi-coolers.pdf',
            'VC-C-SERIES'                       => 'bluestar/visi-coolers.pdf',
            'VC-D-SERIES'                       => 'bluestar/visi-coolers.pdf',

            // Blue Star HVAC & Commercial Kitchen
            'BS-LC-VERT'                        => 'bluestar/verticool-air-conditioners.pdf',
            'VERTICOOL'                         => 'bluestar/verticool-air-conditioners.pdf',
            'BS-LC-CONC'                        => 'bluestar/concealed-split-acs.pdf',
            'CONCEALED-SPLIT'                   => 'bluestar/concealed-split-acs.pdf',
            'BS-LC-CASS'                        => 'bluestar/cassette-air-conditioners.pdf',
            'RI-S-SERIES'                       => 'bluestar/commercial-kitchen-refrigeration.pdf',
            'RI-GP-SERIES'                      => 'bluestar/commercial-kitchen-refrigeration.pdf',
            'UC-S-SERIES'                       => 'bluestar/commercial-kitchen-refrigeration.pdf',
            'UC-GP-SERIES'                      => 'bluestar/commercial-kitchen-refrigeration.pdf',
            'BB-190-300'                        => 'bluestar/commercial-kitchen-refrigeration.pdf',
            'SS-PREP-STATION'                   => 'bluestar/commercial-kitchen-refrigeration.pdf',
            'MD-MULTIDECK'                      => 'bluestar/commercial-kitchen-refrigeration.pdf',
            'PS-SHOWCASE'                       => 'bluestar/pastry-showcase.pdf',
            'IM-COMMERCIAL'                     => 'bluestar/ice-machines.pdf',
            'WCC-CENTRIFUGAL'                   => 'bluestar/centrifugal-chillers.pdf',
            'CENTRIFUGAL'                       => 'bluestar/centrifugal-chillers.pdf',
            'LC-SCROLL-CHILLER'                 => 'bluestar/chillers.pdf',
            'CDU-COMMERCIAL'                    => 'bluestar/condensing-units.pdf',
            'CDU'                               => 'bluestar/condensing-units.pdf',
            'RS-HERMETIC'                       => 'bluestar/refrigeration-systems.pdf',
            'RS-SEMI-HERMETIC'                  => 'bluestar/refrigeration-systems.pdf',
            'VT-WHO-PQS'                        => 'bluestar/cold-rooms.pdf',
            'MC-MORGUE-BS'                      => 'bluestar/cold-rooms.pdf',
            'CR-RIPENING-ROOM'                  => 'bluestar/cold-rooms.pdf',
            'CR-MODULAR-PUF'                    => 'bluestar/cold-rooms.pdf',
            'PUF-PANELS'                        => 'bluestar/cold-rooms.pdf',
            'MF-DEEP-FREEZE-86'                 => 'bluestar/deep-freezers.pdf',
            'PR-PHARMACY-BS'                    => 'bluestar/deep-freezers.pdf',
            'ILR-VACCINE-BS'                    => 'bluestar/deep-freezers.pdf',
            'BF-BLAST-FREEZER'                  => 'bluestar/deep-freezers.pdf',
            'CHF-HARD-TOP'                      => 'bluestar/deep-freezers.pdf',
            'B2B-A64430'                        => 'bluestar/deep-freezers.pdf',

            // Atlantis Beverage Premixes
            'ATL-PREM-'                         => 'atlantis/atlantis-beverage-premixes.pdf',

            // Euronics Air Curtains
            'EUR-EAC'                           => 'euronics/euronics-air-curtains-entrance.pdf',
            'EUR-EAS'                           => 'euronics/euronics-air-curtains-entrance.pdf',
        );
        foreach ( $model_map as $mk => $m_rel ) {
            if ( strpos( $u_sku, $mk ) !== false ) {
                if ( file_exists( $theme_dir . '/brochures/' . $m_rel ) ) {
                    return $theme_uri . '/brochures/' . $m_rel;
                }
            }
        }

        // -------------------------------------------------------------
        // Level 2: Subcategory / Series Brochure Mapping (All Subcats)
        // -------------------------------------------------------------
        $series_map = array(
            // Kimberly-Clark Professional (7 Subcategories)
            'kc-hand-towel-systems'             => 'kc/kc-hand-towel-systems.pdf',
            'kc-skincare-soap-dispensers'       => 'kc/kc-skincare-soap-dispensers.pdf',
            'kc-bathroom-tissue-systems'        => 'kc/kc-bathroom-tissue-systems.pdf',
            'kc-wypall-wiping-solutions'        => 'kc/kc-wypall-wiping-solutions.pdf',
            'kc-facial-tissue-systems'          => 'kc/kc-facial-tissue-systems.pdf',
            'kc-kimtech-scientific'             => 'kc/kc-kimtech-scientific.pdf',
            'kc-kleenguard-ppe'                 => 'kc/kc-kleenguard-ppe.pdf',

            // Specific Blue Star Commercial Refrigeration
            'glass-top-freezers-b2b'            => 'bluestar/visi-freezers.pdf',
            'glass-top-freezers'                => 'bluestar/visi-freezers.pdf',
            'glass-top-2'                       => 'bluestar/visi-freezers.pdf',
            'visi-coolers-b2b'                  => 'bluestar/visi-coolers.pdf',
            'visi-coolers'                      => 'bluestar/visi-coolers.pdf',
            'floor-standing-visi-coolers'       => 'bluestar/visi-coolers.pdf',
            'table-top-visi-coolers'            => 'bluestar/visi-coolers.pdf',
            'table-top-visi'                    => 'bluestar/visi-coolers.pdf',
            'chest-coolers'                     => 'bluestar/chest-coolers.pdf',
            'storage-water-coolers-warm-cold'   => 'bluestar/storage-water-coolers-warm-cold.pdf',
            'storage-water-coolers-b2b'         => 'bluestar/storage-water-coolers.pdf',
            'storage-water-coolers'             => 'bluestar/storage-water-coolers.pdf',
            'bottled-water-dispensers-b2b'      => 'bluestar/bottled-water-dispensers.pdf',
            'bottled-water-dispensers'          => 'bluestar/bottled-water-dispensers.pdf',
            'top-loading-dispensers-b2b'        => 'bluestar/bottled-water-dispensers.pdf',
            'top-loading-dispensers'            => 'bluestar/bottled-water-dispensers.pdf',
            'kitchen-refrigeration-products-b2b'=> 'bluestar/commercial-kitchen-refrigeration.pdf',
            'kitchen-refrigeration-products'    => 'bluestar/commercial-kitchen-refrigeration.pdf',
            'reach-in-chillers-and-freezers-b2b'=> 'bluestar/commercial-kitchen-refrigeration.pdf',
            'reach-in-chillers-and-freezers'    => 'bluestar/commercial-kitchen-refrigeration.pdf',
            'undercounter-chillers-and-freezers-b2b' => 'bluestar/commercial-kitchen-refrigeration.pdf',
            'undercounter-chillers-and-freezers'    => 'bluestar/commercial-kitchen-refrigeration.pdf',
            'ice-machines-b2b'                  => 'bluestar/ice-machines.pdf',
            'ice-machines'                      => 'bluestar/ice-machines.pdf',
            'supermarket-refrigeration-b2b'     => 'bluestar/commercial-kitchen-refrigeration.pdf',
            'supermarket-refrigeration'         => 'bluestar/commercial-kitchen-refrigeration.pdf',
            'pastry-showcase'                   => 'bluestar/pastry-showcase.pdf',
            'confectionery-showcase'            => 'bluestar/pastry-showcase.pdf',
            'mini-bar-2'                        => 'bluestar/mini-bars.pdf',
            'mini-bar'                          => 'bluestar/mini-bars.pdf',
            'deep-freezers'                     => 'bluestar/deep-freezers.pdf',
            'deep-freezers-2'                   => 'bluestar/deep-freezers.pdf',
            'freezers-b2b'                      => 'bluestar/deep-freezers.pdf',
            'hard-top-2'                        => 'bluestar/deep-freezers.pdf',
            'speciality-products'               => 'bluestar/deep-freezers.pdf',
            'speciality-products-2'             => 'bluestar/deep-freezers.pdf',
            'medical-refrigeration-products-b2b'=> 'bluestar/deep-freezers.pdf',
            'medical-refrigeration-products'    => 'bluestar/deep-freezers.pdf',
            'vaccine-storage-products-b2b'      => 'bluestar/deep-freezers.pdf',
            'vaccine-storage-products'          => 'bluestar/deep-freezers.pdf',

            // Blue Star Cold Storage Solutions
            'cold-rooms-b2b'                    => 'bluestar/cold-rooms.pdf',
            'cold-rooms'                        => 'bluestar/cold-rooms.pdf',
            'cold-storages'                     => 'bluestar/cold-rooms.pdf',
            'cold-storages-2'                   => 'bluestar/cold-rooms.pdf',
            'special-application-cs'            => 'bluestar/cold-rooms.pdf',
            'refrigeration-units'               => 'bluestar/refrigeration-systems.pdf',
            'refrigeration-units-b2b'           => 'bluestar/refrigeration-systems.pdf',

            // Blue Star Central Air Conditioning
            'vrf-systems'                       => 'bluestar/vrf-systems.pdf',
            'ducted-systems'                    => 'bluestar/ducted-systems.pdf',
            'chillers'                          => 'bluestar/chillers.pdf',
            'condensing-units'                  => 'bluestar/condensing-units.pdf',
            'others-central-air-conditioning'   => 'bluestar/condensing-units.pdf',

            // Blue Star Light Commercial AC
            'verticool-air-conditioners'        => 'bluestar/verticool-air-conditioners.pdf',
            'cassette-air-conditioners'         => 'bluestar/cassette-air-conditioners.pdf',
            'concealed-split-acs'               => 'bluestar/concealed-split-acs.pdf',
            'concealed-splits'                  => 'bluestar/concealed-split-acs.pdf',
            'light-commercial-acs'              => 'bluestar/cassette-air-conditioners.pdf',

            // Blue Star Room ACs & Air Coolers
            'b2b-room-air-conditioners'         => 'bluestar/bluestar-master-catalog.pdf',
            'inverter-split'                    => 'bluestar/bluestar-master-catalog.pdf',
            'b2b-inverter-split-acs'            => 'bluestar/bluestar-master-catalog.pdf',
            'fixed-speed-split'                 => 'bluestar/bluestar-master-catalog.pdf',
            'window-ac'                         => 'bluestar/bluestar-master-catalog.pdf',
            'b2b-window-acs'                    => 'bluestar/bluestar-master-catalog.pdf',
            'smart-wi-fi-acs'                   => 'bluestar/bluestar-master-catalog.pdf',
            'hot-cold-acs-2'                    => 'bluestar/bluestar-master-catalog.pdf',
            'heavy-duty-acs-2'                  => 'bluestar/bluestar-master-catalog.pdf',
            'b2b-air-coolers'                   => 'bluestar/bluestar-master-catalog.pdf',
            'air-coolers'                       => 'bluestar/bluestar-master-catalog.pdf',
            'desert-air-coolers'                => 'bluestar/bluestar-master-catalog.pdf',
            'desert-air-coolers-2'              => 'bluestar/bluestar-master-catalog.pdf',
            'personal-air-coolers-2'            => 'bluestar/bluestar-master-catalog.pdf',
            'window-air-coolers-2'              => 'bluestar/bluestar-master-catalog.pdf',
            'b2b-air-purifiers'                 => 'bluestar/bluestar-master-catalog.pdf',

            // Corporate Pantry & Atlantis Commercial Solutions (20 Subcategories)
            'coffee-vending-machines'           => 'nestle/coffee-vending-machines.pdf',
            'commercial-coffee-vending-machines'=> 'nestle/coffee-vending-machines.pdf',
            'vending-machines'                  => 'nestle/coffee-vending-machines.pdf',
            'brewing-bots'                      => 'nestle/coffee-vending-machines.pdf',
            'tetley-teas'                       => 'tetley/tetley-corporate-teas.pdf',
            'atlantis-commercial'               => 'atlantis/atlantis-master-catalog.pdf',
            'atlantis-vending-machines'         => 'atlantis/atlantis-vending-machines.pdf',
            'atlantis-coffee-premixes'          => 'atlantis/atlantis-beverage-premixes.pdf',
            'atlantis-tea-premixes'             => 'atlantis/atlantis-beverage-premixes.pdf',
            'atlantis-sachets'                  => 'atlantis/atlantis-beverage-premixes.pdf',
            'atlantis-beverage-whiteners'       => 'atlantis/atlantis-beverage-premixes.pdf',
            'atlantis-cold-beverages'           => 'atlantis/atlantis-beverage-premixes.pdf',
            'atlantis-soups-hot-beverages'      => 'atlantis/atlantis-beverage-premixes.pdf',
            'atlantis-table-top-dispensers'     => 'atlantis/atlantis-water-dispensers.pdf',
            'atlantis-floor-standing-dispensers'=> 'atlantis/atlantis-water-dispensers.pdf',
            'atlantis-fridge-dispensers'        => 'atlantis/atlantis-water-dispensers.pdf',
            'atlantis-brew-vending'             => 'atlantis/atlantis-vending-machines.pdf',
            'atlantis-select-vending'           => 'atlantis/atlantis-vending-machines.pdf',
            'atlantis-classic-vending'          => 'atlantis/atlantis-vending-machines.pdf',
            'atlantis-neo-vending'              => 'atlantis/atlantis-vending-machines.pdf',
            'atlantis-coin-vending'             => 'atlantis/atlantis-vending-machines.pdf',
            'atlantis-compact-vending'          => 'atlantis/atlantis-vending-machines.pdf',
            'atlantis-cool-vend'                => 'atlantis/atlantis-vending-machines.pdf',
            'atlantis-capsule-machines'         => 'atlantis/atlantis-vending-machines.pdf',
            'atlantis-coffee-capsules'          => 'atlantis/atlantis-beverage-premixes.pdf',
            'atlantis-wine-coolers'             => 'atlantis/atlantis-water-dispensers.pdf',
            'atlantis-accessories'              => 'atlantis/atlantis-water-dispensers.pdf',

            // Euronics Washroom Automations (6 Subcategories)
            'euronics-commercial'               => 'euronics/euronics-washroom-automation.pdf',
            'euronics-hand-dryers'              => 'euronics/euronics-washroom-automation.pdf',
            'euronics-sensor-taps'              => 'euronics/euronics-washroom-automation.pdf',
            'euronics-soap-dispensers'          => 'euronics/euronics-washroom-automation.pdf',
            'euronics-air-curtains'             => 'euronics/euronics-air-curtains-entrance.pdf',
            'euronics-paper-dispensers'         => 'euronics/euronics-washroom-automation.pdf',
            'euronics-urinal-sensors'           => 'euronics/euronics-washroom-automation.pdf',

            // Waterlogic India (5 Subcategories)
            'waterlogic-commercial'             => 'waterlogic/waterlogic-commercial-dispensers.pdf',
            'waterlogic-countertop'             => 'waterlogic/waterlogic-commercial-dispensers.pdf',
            'waterlogic-freestanding'           => 'waterlogic/waterlogic-commercial-dispensers.pdf',
            'waterlogic-high-capacity'          => 'waterlogic/waterlogic-commercial-dispensers.pdf',
            'waterlogic-pure-dispensers'        => 'waterlogic/waterlogic-commercial-dispensers.pdf',
            'waterlogic-firewall-pou'           => 'waterlogic/waterlogic-commercial-dispensers.pdf',

            // Eureka Forbes Commercial (4 Subcategories)
            'eureka-forbes-commercial'          => 'eureka-forbes/commercial-ro-purifiers.pdf',
            'eureka-forbes-commercial-ro'       => 'eureka-forbes/commercial-ro-purifiers.pdf',
            'eureka-forbes-commercial-uv'       => 'eureka-forbes/commercial-ro-purifiers.pdf',
            'eureka-forbes-cooler-cum-purifiers'=> 'eureka-forbes/commercial-ro-purifiers.pdf',
            'eureka-forbes-industrial-ro-plants'=> 'eureka-forbes/commercial-ro-purifiers.pdf',

            // Usha Water Solutions (3 Subcategories)
            'usha-water-solutions'              => 'usha/usha-water-solutions.pdf',
            'usha-water-dispensers'             => 'usha/usha-water-solutions.pdf',
            'usha-water-coolers'                => 'usha/usha-water-solutions.pdf',
            'usha-instant-coolers'              => 'usha/usha-water-solutions.pdf',
        );

        $active_subcat_slug = (string) $active_subcat_slug;
        $root_brand_slug   = (string) $root_brand_slug;

        // Check active subcategory slug match
        if ( '' !== $active_subcat_slug && isset( $series_map[ $active_subcat_slug ] ) ) {
            $rel = $series_map[ $active_subcat_slug ];
            if ( file_exists( $theme_dir . '/brochures/' . $rel ) ) {
                return $theme_uri . '/brochures/' . $rel;
            }
        }

        // Check product categories if product_id is provided
        if ( $product_id > 0 ) {
            $terms = get_the_terms( $product_id, 'product_cat' );
            if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                // Prioritize leaf categories over intermediate/parent categories
                $parent_ids = array();
                foreach ( $terms as $t ) {
                    if ( ! empty( $t->parent ) ) {
                        $parent_ids[] = (int) $t->parent;
                    }
                }
                usort( $terms, function( $a, $b ) use ( $parent_ids ) {
                    $a_is_parent = in_array( (int) $a->term_id, $parent_ids, true ) ? 1 : 0;
                    $b_is_parent = in_array( (int) $b->term_id, $parent_ids, true ) ? 1 : 0;
                    return $a_is_parent <=> $b_is_parent;
                } );

                foreach ( $terms as $t ) {
                    $t_slug = (string) ( $t->slug ?? '' );
                    if ( $t_slug !== '' && isset( $series_map[ $t_slug ] ) ) {
                        $rel = $series_map[ $t_slug ];
                        if ( file_exists( $theme_dir . '/brochures/' . $rel ) ) {
                            return $theme_uri . '/brochures/' . $rel;
                        }
                    }
                }
            }
        }

        // SKU pattern fallback
        if ( strpos( $u_sku, 'KCP-' ) !== false || strpos( $u_sku, 'KIMBERLY' ) !== false ) {
            return $theme_uri . '/brochures/kc/kc-master-catalog.pdf';
        }
        if ( strpos( $u_sku, 'EUR-' ) !== false || strpos( $u_sku, 'EURONICS' ) !== false ) {
            return $theme_uri . '/brochures/euronics/euronics-master-catalog.pdf';
        }
        if ( strpos( $u_sku, 'NES-' ) !== false || strpos( $u_sku, 'NESTLE' ) !== false || strpos( $u_sku, 'BOT-' ) !== false ) {
            return $theme_uri . '/brochures/nestle/coffee-vending-machines.pdf';
        }
        if ( strpos( $u_sku, 'ATL-' ) !== false || strpos( $u_sku, 'ATLANTIS' ) !== false ) {
            return $theme_uri . '/brochures/atlantis/atlantis-beverage-premixes.pdf';
        }
        if ( strpos( $u_sku, 'TET-' ) !== false ) {
            return $theme_uri . '/brochures/tetley/tetley-corporate-teas.pdf';
        }
        if ( strpos( $u_sku, 'WL-' ) !== false || strpos( $u_sku, 'WATERLOGIC' ) !== false ) {
            return $theme_uri . '/brochures/waterlogic/waterlogic-commercial-dispensers.pdf';
        }
        if ( strpos( $u_sku, 'EF-' ) !== false || strpos( $u_sku, 'EUREKA' ) !== false ) {
            return $theme_uri . '/brochures/eureka-forbes/commercial-ro-purifiers.pdf';
        }
        if ( strpos( $u_sku, 'USHA' ) !== false ) {
            return $theme_uri . '/brochures/usha/usha-water-solutions.pdf';
        }

        // Brand Master Fallback
        $brand_map = array(
            'blue-star-commercial'       => 'bluestar/bluestar-master-catalog.pdf',
            'kimberly-clark-commercial'  => 'kc/kc-master-catalog.pdf',
            'kimberly-clark-professional'=> 'kc/kc-master-catalog.pdf',
            'euronics-commercial'        => 'euronics/euronics-master-catalog.pdf',
            'nestle-professional'        => 'nestle/coffee-vending-machines.pdf',
            'corporate-pantry'           => 'nestle/coffee-vending-machines.pdf',
            'atlantis-commercial'        => 'atlantis/atlantis-beverage-premixes.pdf',
            'tetley-corporate'           => 'tetley/tetley-corporate-teas.pdf',
            'waterlogic-commercial'      => 'waterlogic/waterlogic-commercial-dispensers.pdf',
            'eureka-forbes-commercial'   => 'eureka-forbes/commercial-ro-purifiers.pdf',
            'usha-water-solutions'       => 'usha/usha-water-solutions.pdf',
        );
        if ( '' !== $root_brand_slug && isset( $brand_map[ $root_brand_slug ] ) ) {
            $rel = $brand_map[ $root_brand_slug ];
            if ( file_exists( $theme_dir . '/brochures/' . $rel ) ) {
                return $theme_uri . '/brochures/' . $rel;
            }
        }

        return $theme_uri . '/brochures/bluestar/bluestar-master-catalog.pdf';
    }
}
