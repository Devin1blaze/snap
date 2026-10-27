<?php
// targeted_restore_data.php

// Load WordPress
require_once dirname(__FILE__) . '/../../../wp-load.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

if (php_sapi_name() !== 'cli') {
    die("This script must be run from the command line.");
}

echo "Starting targeted data restoration for Images and Specifications...\n";

// We will load all scraped data into a unified array mapped by product title
$scraped_data = [];

// 1. Load JSONs
$json_files = [
    dirname(__FILE__) . '/b2b_products.json',
    dirname(__FILE__) . '/b2c_products.json',
    dirname(__FILE__) . '/old_site_products.json',
    dirname(__FILE__) . '/../../../products_consumer.json',
    dirname(__FILE__) . '/../../../products_b2b.json',
    dirname(__FILE__) . '/../../../products_seo.json'
];

foreach ($json_files as $f) {
    if (file_exists($f)) {
        $data = json_decode(file_get_contents($f), true);
        if ($data) {
            foreach ($data as $item) {
                $title = isset($item['title']) ? $item['title'] : (isset($item['post_title']) ? $item['post_title'] : '');
                if (!$title) continue;
                $title = trim($title);
                
                if (!isset($scraped_data[$title])) $scraped_data[$title] = [];
                
                if (isset($item['specifications']) && is_array($item['specifications'])) {
                    $scraped_data[$title]['specifications'] = $item['specifications'];
                }
                
                // Images
                if (isset($item['images']) && is_array($item['images'])) {
                    $scraped_data[$title]['images'] = $item['images'];
                }
                if (isset($item['image_url'])) {
                    $scraped_data[$title]['images'][] = $item['image_url'];
                }
                if (isset($item['gallery_images']) && is_array($item['gallery_images'])) {
                    foreach ($item['gallery_images'] as $gi) {
                        $scraped_data[$title]['images'][] = $gi;
                    }
                }
            }
        }
    }
}

// 2. Load CSVs if they exist
$csv_files = [
    dirname(__FILE__) . '/../../../bluestar_b2b_products_import.csv',
    dirname(__FILE__) . '/../../../bluestar_b2c_products_import.csv'
];

foreach ($csv_files as $f) {
    if (file_exists($f)) {
        $handle = fopen($f, "r");
        if ($handle !== FALSE) {
            $headers = fgetcsv($handle, 10000, ",");
            while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
                $row = array_combine($headers, $data);
                $title = isset($row['Title']) ? trim($row['Title']) : '';
                if (!$title) continue;
                
                if (!isset($scraped_data[$title])) $scraped_data[$title] = [];
                
                // CSVs usually have a Tech_Specs or similar column
                if (isset($row['Tech_Specs']) && !empty($row['Tech_Specs'])) {
                    // Try to decode if it's JSON
                    $specs = json_decode($row['Tech_Specs'], true);
                    if ($specs && is_array($specs)) {
                        $scraped_data[$title]['specifications'] = $specs;
                    }
                }
                
                // Image
                if (isset($row['Image URL']) && !empty($row['Image URL'])) {
                    $scraped_data[$title]['images'][] = $row['Image URL'];
                }
            }
            fclose($handle);
        }
    }
}

$specs_restored = 0;
$images_restored = 0;

global $wpdb;

// Let's iterate through the products in WP that are missing stuff
$args = [
    'post_type' => 'product',
    'posts_per_page' => -1,
    'post_status' => 'any'
];
$query = new WP_Query($args);
if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        $post_id = get_the_ID();
        $title = trim(get_the_title());
        
        // Find matching scraped data
        $matched_data = null;
        if (isset($scraped_data[$title])) {
            $matched_data = $scraped_data[$title];
        } else {
            // Fuzzy match
            foreach ($scraped_data as $s_title => $s_data) {
                if (stripos($title, $s_title) !== false || stripos($s_title, $title) !== false) {
                    $matched_data = $s_data;
                    break;
                }
            }
        }
        
        if ($matched_data) {
            // Restore Specs
            $existing_specs = get_post_meta($post_id, '_technical_specs', true);
            if ((empty($existing_specs) || !is_array($existing_specs)) && isset($matched_data['specifications']) && is_array($matched_data['specifications'])) {
                $specs_to_save = [];
                foreach ($matched_data['specifications'] as $k => $v) {
                    $specs_to_save[] = ['name' => $k, 'value' => $v];
                }
                update_post_meta($post_id, '_technical_specs', $specs_to_save);
                echo "-> Restored specifications for: $title (ID: $post_id)\n";
                $specs_restored++;
            }
            
            // Restore Image
            if (!has_post_thumbnail($post_id) && !empty($matched_data['images'])) {
                $img_url = '';
                foreach ($matched_data['images'] as $img) {
                    if (strpos($img, 'facebook') === false && strpos($img, 'twitter') === false && strpos($img, 'instagram') === false && strpos($img, 'youtube') === false && strpos($img, 'download') === false) {
                        $img_url = $img;
                        break;
                    }
                }
                
                if (!empty($img_url)) {
                    if (strpos($img_url, 'http') !== 0) {
                        $img_url = 'https://www.bluestarindia.com' . $img_url;
                    }
                    echo "-> Sideloading image for $title: $img_url\n";
                    $thumbnail_id = media_sideload_image($img_url, $post_id, $title, 'id');
                    if (!is_wp_error($thumbnail_id)) {
                        set_post_thumbnail($post_id, $thumbnail_id);
                        echo "-> Restored image for: $title (ID: $post_id)\n";
                        $images_restored++;
                    }
                }
            }
        }
    }
}

echo "\n================================\n";
echo "Restoration Complete!\n";
echo "Specifications Restored: $specs_restored\n";
echo "Images Restored: $images_restored\n";
echo "================================\n";
