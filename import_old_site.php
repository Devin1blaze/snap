<?php
/**
 * Import Old Classic ASP Site Data
 * 
 * Usage via WP-CLI:
 * wp eval-file wp-content/themes/snap-stitch-theme/import_old_site.php
 */

require_once dirname(__FILE__) . '/../../../wp-load.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

$old_data_dir = dirname(__FILE__) . '/old_data/';

function import_local_image($file_path, $post_id = 0) {
    if (!file_exists($file_path)) return false;
    
    $upload_dir = wp_upload_dir();
    $filename = basename($file_path);
    if (wp_mkdir_p($upload_dir['path'])) {
        $file = $upload_dir['path'] . '/' . $filename;
    } else {
        $file = $upload_dir['basedir'] . '/' . $filename;
    }
    
    copy($file_path, $file);
    
    $wp_filetype = wp_check_filetype($filename, null);
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title'     => sanitize_file_name($filename),
        'post_content'   => '',
        'post_status'    => 'inherit'
    );
    
    $attach_id = wp_insert_attachment($attachment, $file, $post_id);
    $attach_data = wp_generate_attachment_metadata($attach_id, $file);
    wp_update_attachment_metadata($attach_id, $attach_data);
    
    return $attach_id;
}

echo "Starting Old Site Data Import...\n";

// 1. IMPORT PAGES
$pages_json = dirname(__FILE__) . '/old_site_pages.json';
if (file_exists($pages_json)) {
    echo "\n--- Importing Pages ---\n";
    $pages = json_decode(file_get_contents($pages_json), true);
    foreach ($pages as $p) {
        $title = $p['title'];
        if (empty($title)) continue;
        
        // Check if page exists
        $existing = get_page_by_title($title, OBJECT, 'page');
        if ($existing) {
            echo "Skipping existing page: $title\n";
            continue;
        }
        
        $content = wpautop($p['description']);
        
        $post_id = wp_insert_post([
            'post_title'   => $title,
            'post_content' => $content,
            'post_type'    => 'page',
            'post_status  ' => 'publish'
        ]);
        
        if ($post_id && !empty($p['image'])) {
            $img_path = $old_data_dir . str_replace('/', DIRECTORY_SEPARATOR, $p['image']);
            $attach_id = import_local_image($img_path, $post_id);
            if ($attach_id) {
                set_post_thumbnail($post_id, $attach_id);
            }
        }
        
        echo "Imported Page: $title\n";
    }
}

// 2. IMPORT PRODUCTS
$products_json = dirname(__FILE__) . '/old_site_products.json';
if (file_exists($products_json)) {
    echo "\n--- Importing WooCommerce Products ---\n";
    $products = json_decode(file_get_contents($products_json), true);
    foreach ($products as $p) {
        $title = $p['title'];
        if (empty($title)) continue;
        
        // Use the filename as a pseudo-sku to check existence
        $sku = 'old-site-' . str_replace('.asp', '', $p['file']);
        
        $existing_id = wc_get_product_id_by_sku($sku);
        if ($existing_id) {
            echo "Skipping existing product: $title\n";
            continue;
        }
        
        $product = new WC_Product_Simple();
        $product->set_name($title);
        $product->set_sku($sku);
        $product->set_status('publish');
        $product->set_catalog_visibility('visible');
        
        // Format description
        $desc = wpautop($p['description']);
        if (!empty($p['specifications'])) {
            $desc .= "<h3>Specifications</h3><table class='shop_attributes'>";
            foreach ($p['specifications'] as $k => $v) {
                $desc .= "<tr><th>" . esc_html($k) . "</th><td>" . esc_html($v) . "</td></tr>";
            }
            $desc .= "</table>";
        }
        $product->set_description($desc);
        
        $product_id = $product->save();
        
        if ($product_id && !empty($p['image'])) {
            $img_path = $old_data_dir . str_replace('/', DIRECTORY_SEPARATOR, $p['image']);
            $attach_id = import_local_image($img_path, $product_id);
            if ($attach_id) {
                $product->set_image_id($attach_id);
                $product->save();
            }
        }
        
        echo "Imported Product: $title\n";
    }
}

echo "\nImport Complete!\n";
