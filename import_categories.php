<?php
// wp-content/themes/snap-stitch-theme/import_categories.php

// This file handles importing categories from categories.json into the WordPress taxonomy 'product_cat'
// Make sure this is only run securely.
if ( ! isset( $_GET['secret_key'] ) || $_GET['secret_key'] !== 'snap123' ) {
    die( 'Unauthorized access.' );
}

require_once( dirname( __FILE__ ) . '/../../../wp-load.php' );
require_once( ABSPATH . 'wp-admin/includes/image.php' );
require_once( ABSPATH . 'wp-admin/includes/file.php' );
require_once( ABSPATH . 'wp-admin/includes/media.php' );

$json_file = __DIR__ . '/categories_import.json';

if ( ! file_exists( $json_file ) ) {
    die( "JSON file not found at: $json_file" );
}

$json_data = file_get_contents( $json_file );
$categories = json_decode( $json_data, true );

if ( ! $categories ) {
    die( "Invalid JSON data." );
}

/**
 * Recursively insert categories
 */
function insert_category_tree( $cat_list, $parent_id, $parent_term_slug ) {
    foreach ( $cat_list as $cat_data ) {
        $name = $cat_data['name'];
        $slug = $cat_data['slug'];
        
        $term_exists = term_exists( $slug, 'product_cat' );
        
        if ( ! $term_exists ) {
            $inserted_term = wp_insert_term(
                $name,
                'product_cat',
                array(
                    'description' => '',
                    'slug'        => $slug,
                    'parent'      => $parent_id,
                )
            );
            
            if ( ! is_wp_error( $inserted_term ) ) {
                $term_id = $inserted_term['term_id'];
                echo "✅ Created category: $name ($slug) under parent ID: $parent_id<br>";
            } else {
                echo "❌ Error creating category $name: " . $inserted_term->get_error_message() . "<br>";
                continue;
            }
        } else {
            $term_id = is_array( $term_exists ) ? $term_exists['term_id'] : $term_exists;
            echo "ℹ️ Category already exists: $name ($slug)<br>";
            
            // Update parent if needed
            wp_update_term( $term_id, 'product_cat', array(
                'parent' => $parent_id
            ) );
        }
        
        // Handle children
        if ( isset( $cat_data['children'] ) && is_array( $cat_data['children'] ) ) {
            insert_category_tree( $cat_data['children'], $term_id, $slug );
        }
    }
}

// Ensure the root B2B and B2C categories exist
$roots = array(
    'b2c' => 'B2C Products',
    'b2b' => 'B2B Products'
);

foreach ( $roots as $root_slug => $root_name ) {
    $root_term = term_exists( $root_slug, 'product_cat' );
    if ( ! $root_term ) {
        $root_term = wp_insert_term(
            $root_name,
            'product_cat',
            array( 'slug' => $root_slug )
        );
        echo "✅ Created root category: $root_name<br>";
    } else {
        echo "ℹ️ Root category already exists: $root_name<br>";
    }
    
    $root_id = is_array( $root_term ) ? $root_term['term_id'] : $root_term;
    
    if ( isset( $categories[ $root_slug ] ) ) {
        echo "<h3>Importing $root_name Hierarchy...</h3>";
        insert_category_tree( $categories[ $root_slug ], $root_id, $root_slug );
    }
}

echo "<h2>Import Complete!</h2>";
?>
