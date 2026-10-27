<?php
/**
 * Global SEO & Schema Structured Data Generator
 * Injects Schema.org JSON-LD (Organization, LocalBusiness, WebSite, Product, BreadcrumbList)
 * and Open Graph social metadata (WhatsApp, LinkedIn, Facebook) into wp_head.
 * 
 * Note: Twitter Cards are explicitly omitted per user requirements.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'wp_head', 'snap_stitch_output_rich_snippets', 2 );
add_action( 'wp_head', 'snap_stitch_output_open_graph_meta', 3 );

/**
 * 1. Schema.org JSON-LD Structured Data
 */
function snap_stitch_output_rich_snippets() {
    $home_url = trailingslashit( home_url() );
    $default_logo = $home_url . 'wp-content/themes/snap-stitch-theme/img/logo.png';
    
    // 1. Organization & Local Business Schema (Sitewide)
    $org_schema = array(
        '@context'        => 'https://schema.org',
        '@type'           => array( 'Organization', 'LocalBusiness', 'Wholesaler' ),
        '@id'             => $home_url . '#organization',
        'name'            => 'Snap Marketing',
        'alternateName'   => array( 'Snap House Pune', 'Snap Marketing Blue Star Dealer' ),
        'url'             => $home_url,
        'logo'            => $default_logo,
        'description'     => 'Authorized Blue Star Channel Partner and wholesale distributor for commercial refrigeration, residential inverter air conditioners, water coolers, deep freezers, and industrial washroom automations in Pune, Maharashtra since 1988.',
        'telephone'       => '+91-9823012724',
        'email'           => 'sales@snapmktg.com',
        'priceRange'      => '₹₹ - ₹₹₹₹',
        'address'         => array(
            '@type'           => 'PostalAddress',
            'streetAddress'   => 'Snap House, 322/16, Shankar Sheth Road, Near Indian Oil Petrol Pump, Hotel 7 Loves Chowk, Ghorpadi Peth',
            'addressLocality' => 'Pune',
            'addressRegion'   => 'Maharashtra',
            'postalCode'      => '411042',
            'addressCountry'  => 'IN',
        ),
        'geo'             => array(
            '@type'     => 'GeoCoordinates',
            'latitude'  => '18.5034',
            'longitude' => '73.8647',
        ),
        'openingHoursSpecification' => array(
            array(
                '@type'     => 'OpeningHoursSpecification',
                'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' ),
                'opens'     => '09:30',
                'closes'    => '19:30',
            ),
        ),
        'areaServed'      => array(
            array(
                '@type' => 'AdministrativeArea',
                'name'  => 'Pune',
            ),
            array(
                '@type' => 'AdministrativeArea',
                'name'  => 'Maharashtra',
            ),
            array(
                '@type' => 'Country',
                'name'  => 'India',
            ),
        ),
        'founder'         => array(
            '@type' => 'Person',
            'name'  => 'Mr. Lokesh Arya',
        ),
        'director'        => array(
            '@type'    => 'Person',
            'name'     => 'Mr. Lokesh Arya',
            'jobTitle' => 'Director',
        ),
        'foundingDate'    => '1988',
        'knowsAbout'      => array(
            'Blue Star Air Conditioners',
            'Commercial Deep Freezers',
            'Visi Coolers & Beverage Chillers',
            'Industrial Water Coolers & Purifiers',
            'Touchless Hand Dryers & Sensor Taps',
            'Cold Storage and HVAC Logistics',
        ),
    );

    // 2. WebSite Schema with SearchAction (Sitewide)
    $website_schema = array(
        '@context'        => 'https://schema.org',
        '@type'           => 'WebSite',
        '@id'             => $home_url . '#website',
        'url'             => $home_url,
        'name'            => get_bloginfo( 'name' ) ?: 'Snap Marketing',
        'description'     => get_bloginfo( 'description' ) ?: 'Authorized Blue Star Dealer Pune',
        'publisher'       => array(
            '@id' => $home_url . '#organization',
        ),
        'potentialAction' => array(
            '@type'       => 'SearchAction',
            'target'      => array(
                '@type'       => 'EntryPoint',
                'urlTemplate' => $home_url . '?s={search_term_string}',
            ),
            'query-input' => 'required name=search_term_string',
        ),
    );

    echo "\n<!-- Global Schema: Organization & WebSite -->\n";
    echo '<script type="application/ld+json">' . wp_json_encode( $org_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . "</script>\n";
    echo '<script type="application/ld+json">' . wp_json_encode( $website_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . "</script>\n";

    // 3. BreadcrumbList Schema (Google SERP Hierarchical Rich Snippets)
    $breadcrumb_items = array();
    $breadcrumb_items[] = array(
        '@type'    => 'ListItem',
        'position' => 1,
        'name'     => 'Home',
        'item'     => $home_url,
    );

    if ( function_exists( 'is_product' ) && is_product() ) {
        global $product;
        if ( is_a( $product, 'WC_Product' ) ) {
            $terms = wc_get_product_terms( $product->get_id(), 'product_cat', array( 'orderby' => 'parent', 'order' => 'DESC' ) );
            if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                $main_term = $terms[0];
                $breadcrumb_items[] = array(
                    '@type'    => 'ListItem',
                    'position' => 2,
                    'name'     => $main_term->name,
                    'item'     => get_term_link( $main_term ),
                );
                $breadcrumb_items[] = array(
                    '@type'    => 'ListItem',
                    'position' => 3,
                    'name'     => $product->get_name(),
                    'item'     => get_permalink( $product->get_id() ),
                );
            } else {
                $breadcrumb_items[] = array(
                    '@type'    => 'ListItem',
                    'position' => 2,
                    'name'     => $product->get_name(),
                    'item'     => get_permalink( $product->get_id() ),
                );
            }
        }
    } elseif ( function_exists( 'is_product_category' ) && is_product_category() ) {
        $current_term = get_queried_object();
        if ( $current_term && ! is_wp_error( $current_term ) ) {
            if ( $current_term->parent ) {
                $parent_term = get_term( $current_term->parent, 'product_cat' );
                if ( $parent_term && ! is_wp_error( $parent_term ) ) {
                    $breadcrumb_items[] = array(
                        '@type'    => 'ListItem',
                        'position' => 2,
                        'name'     => $parent_term->name,
                        'item'     => get_term_link( $parent_term ),
                    );
                    $breadcrumb_items[] = array(
                        '@type'    => 'ListItem',
                        'position' => 3,
                        'name'     => $current_term->name,
                        'item'     => get_term_link( $current_term ),
                    );
                }
            } else {
                $breadcrumb_items[] = array(
                    '@type'    => 'ListItem',
                    'position' => 2,
                    'name'     => $current_term->name,
                    'item'     => get_term_link( $current_term ),
                );
            }
        }
    } elseif ( is_page() && ! is_front_page() ) {
        $breadcrumb_items[] = array(
            '@type'    => 'ListItem',
            'position' => 2,
            'name'     => get_the_title(),
            'item'     => get_permalink(),
        );
    }

    if ( count( $breadcrumb_items ) > 1 ) {
        $breadcrumb_schema = array(
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $breadcrumb_items,
        );
        echo "<!-- BreadcrumbList Schema -->\n";
        echo '<script type="application/ld+json">' . wp_json_encode( $breadcrumb_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . "</script>\n";
    }

    // 4. Single Product Schema (when viewing a WooCommerce Product)
    if ( function_exists( 'is_product' ) && is_product() ) {
        global $product;
        if ( is_a( $product, 'WC_Product' ) ) {
            $product_id   = $product->get_id();
            $title        = $product->get_name();
            $permalink    = get_permalink( $product_id );
            $image_id     = $product->get_image_id();
            $image_url    = $image_id ? wp_get_attachment_url( $image_id ) : '';
            $sku          = $product->get_sku() ?: 'SNAP-' . $product_id;
            $price        = $product->get_price();
            $description  = wp_strip_all_tags( $product->get_short_description() ?: $product->get_description() );
            $is_b2b       = function_exists( 'snap_stitch_is_b2b_product' ) ? snap_stitch_is_b2b_product( $product_id ) : false;

            $product_schema = array(
                '@context'    => 'https://schema.org',
                '@type'       => 'Product',
                '@id'         => $permalink . '#product',
                'name'        => $title,
                'url'         => $permalink,
                'description' => $description ?: ($title . ' - Authorized Blue Star distribution from Snap Marketing Pune.'),
                'sku'         => $sku,
                'brand'       => array(
                    '@type' => 'Brand',
                    'name'  => 'Blue Star',
                ),
            );

            if ( $image_url ) {
                $product_schema['image'] = array( $image_url );
            }

            if ( ! empty( $price ) && is_numeric( $price ) && floatval( $price ) > 0 ) {
                $product_schema['offers'] = array(
                    '@type'         => 'Offer',
                    'url'           => $permalink,
                    'priceCurrency' => 'INR',
                    'price'         => number_format( (float)$price, 2, '.', '' ),
                    'itemCondition' => 'https://schema.org/NewCondition',
                    'availability'  => $product->is_in_stock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
                    'seller'        => array(
                        '@id' => $home_url . '#organization',
                    ),
                );
            } else if ( $is_b2b ) {
                $product_schema['offers'] = array(
                    '@type'         => 'Offer',
                    'url'           => $permalink,
                    'priceCurrency' => 'INR',
                    'price'         => '0.00',
                    'itemCondition' => 'https://schema.org/NewCondition',
                    'availability'  => 'https://schema.org/InStock',
                    'description'   => 'Institutional / Bulk B2B pricing available upon quote submission.',
                    'seller'        => array(
                        '@id' => $home_url . '#organization',
                    ),
                );
            }

            echo "<!-- Product Schema: " . esc_attr( $title ) . " -->\n";
            echo '<script type="application/ld+json">' . wp_json_encode( $product_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . "</script>\n";
        }
    }
}

/**
 * 2. Open Graph Social Metadata (WhatsApp, LinkedIn, Facebook)
 * Explicitly excludes Twitter cards per user instruction.
 */
function snap_stitch_output_open_graph_meta() {
    $home_url     = trailingslashit( home_url() );
    $default_logo = $home_url . 'wp-content/themes/snap-stitch-theme/img/logo.png';
    $site_name    = 'Snap Marketing';
    $og_title     = '';
    $og_desc      = '';
    $og_url       = '';
    $og_image     = $default_logo;
    $og_type      = 'website';
    $price_amount = '';

    if ( is_front_page() ) {
        $og_title = 'Snap Marketing | Authorized Blue Star Dealer & Wholesaler Pune';
        $og_desc  = "Pune's premier authorized Blue Star distributor for residential inverter ACs, commercial refrigeration, deep freezers, and automated washroom solutions since 1988.";
        $og_url   = $home_url;
    } elseif ( function_exists( 'is_product' ) && is_product() ) {
        global $product;
        if ( is_a( $product, 'WC_Product' ) ) {
            $og_type  = 'product';
            $og_title = $product->get_name() . ' | Snap Marketing Blue Star';
            $desc     = wp_strip_all_tags( $product->get_short_description() ?: $product->get_description() );
            $og_desc  = ! empty( $desc ) ? wp_trim_words( $desc, 30, '...' ) : ('Official Blue Star ' . $product->get_name() . ' available from Snap Marketing Pune.');
            $og_url   = get_permalink( $product->get_id() );
            
            $img_id = $product->get_image_id();
            if ( $img_id ) {
                $img_url = wp_get_attachment_url( $img_id );
                if ( $img_url ) {
                    $og_image = $img_url;
                }
            }
            if ( $product->get_price() ) {
                $price_amount = $product->get_price();
            }
        }
    } elseif ( function_exists( 'is_product_category' ) && is_product_category() ) {
        $term = get_queried_object();
        if ( $term && ! is_wp_error( $term ) ) {
            $og_title = $term->name . ' | Blue Star Products | Snap Marketing Pune';
            $og_desc  = ! empty( $term->description ) ? wp_strip_all_tags( $term->description ) : ('Explore official Blue Star ' . $term->name . ' from authorized dealer Snap Marketing.');
            $og_url   = get_term_link( $term );
            $thumb_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
            if ( $thumb_id ) {
                $thumb_url = wp_get_attachment_url( $thumb_id );
                if ( $thumb_url ) {
                    $og_image = $thumb_url;
                }
            }
        }
    } elseif ( is_page() ) {
        $slug = get_post_field( 'post_name', get_post() );
        if ( $slug === 'faq' ) {
            $og_type  = 'article';
            $og_title = 'Frequently Asked Questions (FAQ) | Snap Marketing';
            $og_desc  = 'Answers to common questions regarding Blue Star AC sizing, 3-Star vs 5-Star efficiency, bulk refrigeration pricing, manufacturer warranty, and delivery across Pune.';
        } else {
            $og_title = get_the_title() . ' | Snap Marketing';
            $excerpt  = get_the_excerpt();
            $og_desc  = ! empty( $excerpt ) ? wp_strip_all_tags( $excerpt ) : ('Snap Marketing - Authorized Blue Star Channel Partner Pune.');
        }
        $og_url = get_permalink();
        if ( has_post_thumbnail() ) {
            $thumb_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
            if ( $thumb_url ) {
                $og_image = $thumb_url;
            }
        }
    } else {
        $og_title = wp_get_document_title();
        $og_desc  = 'Authorized Blue Star Channel Partner and wholesale distributor in Pune, Maharashtra.';
        $og_url   = home_url( add_query_arg( array(), $GLOBALS['wp']->request ?? '' ) );
    }

    echo "<!-- Open Graph Social Metadata (WhatsApp, LinkedIn, Facebook) -->\n";
    echo '<meta property="og:site_name" content="' . esc_attr( $site_name ) . '">' . "\n";
    echo '<meta property="og:locale" content="en_IN">' . "\n";
    echo '<meta property="og:type" content="' . esc_attr( $og_type ) . '">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr( $og_title ) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr( $og_desc ) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url( $og_url ) . '">' . "\n";
    echo '<meta property="og:image" content="' . esc_url( $og_image ) . '">' . "\n";
    
    if ( ! empty( $price_amount ) && is_numeric( $price_amount ) ) {
        echo '<meta property="product:price:amount" content="' . esc_attr( number_format( (float)$price_amount, 2, '.', '' ) ) . '">' . "\n";
        echo '<meta property="product:price:currency" content="INR">' . "\n";
    }
}
