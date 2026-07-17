<?php
/**
 * WooCommerce Product Importer with SEO Support
 * 
 * Usage via WP-CLI:
 * wp eval-file wp-content/themes/snap-stitch-theme/import_woo_products.php
 */

// Load WordPress
require_once dirname(__FILE__) . '/../../../wp-load.php';

echo "Starting WooCommerce Product Import...\n";

// Path to SEO optimized products JSON
$json_file = dirname(__FILE__) . '/products_seo.json';

if (!file_exists($json_file)) {
    die("Error: $json_file not found.\n");
}

$json_data = file_get_contents($json_file);
$products = json_decode($json_data, true);

if (!$products) {
    die("Error: Invalid JSON data.\n");
}

echo "Found " . count($products) . " products to import.\n";

$imported = 0;
$updated = 0;

foreach ($products as $p) {
    $title = $p['post_title'] ?? '';
    $sku = $p['sku'] ?? '';
    if (empty($title) || empty($sku)) {
        continue;
    }

    $existing_id = wc_get_product_id_by_sku($sku);

    if ($existing_id) {
        $product = wc_get_product($existing_id);
        $is_new = false;
    } else {
        $product = new WC_Product_Simple();
        $product->set_sku($sku);
        $is_new = true;
    }

    // Set basics
    $product->set_name($title);
    $product->set_status('publish');
    $product->set_catalog_visibility('visible');
    
    // Set price
    $price = $p['regular_price'] ?? '';
    if ($price) {
        $product->set_regular_price($price);
    }
    
    // Save to get an ID before setting terms/meta
    $product_id = $product->save();

    // Category
    if (!empty($p['category'])) {
        $cat_id = get_term_by('name', $p['category'], 'product_cat');
        if (!$cat_id) {
            $cat_info = wp_insert_term($p['category'], 'product_cat');
            if (!is_wp_error($cat_info)) {
                $cat_id = $cat_info['term_id'];
            }
        } else {
            $cat_id = $cat_id->term_id;
        }
        
        if ($cat_id) {
            wp_set_object_terms($product_id, [(int)$cat_id], 'product_cat');
        }
    }

    // Tags
    if (!empty($p['tags'])) {
        $tags_arr = array_map('trim', explode(',', $p['tags']));
        wp_set_object_terms($product_id, $tags_arr, 'product_tag', false);
    }

    // Set SEO Meta
    if (!empty($p['seo_title'])) {
        update_post_meta($product_id, '_yoast_wpseo_title', $p['seo_title']);
        update_post_meta($product_id, 'rank_math_title', $p['seo_title']);
    }
    
    if (!empty($p['seo_meta_description'])) {
        update_post_meta($product_id, '_yoast_wpseo_metadesc', $p['seo_meta_description']);
        update_post_meta($product_id, 'rank_math_description', $p['seo_meta_description']);
    }
    
    // Schema Markup (Store as custom meta, could be injected into head)
    if (!empty($p['seo_schema'])) {
        update_post_meta($product_id, '_custom_seo_schema', $p['seo_schema']);
    }
    
    // Note: Image upload is skipped to keep script fast and avoid downloading 200+ images repeatedly.
    // If needed, use media_sideload_image here.

    if ($is_new) {
        $imported++;
        echo "Imported: $title (SKU: $sku)\n";
    } else {
        $updated++;
        echo "Updated: $title (SKU: $sku)\n";
    }
}

echo "Complete! Imported: $imported, Updated: $updated.\n";
