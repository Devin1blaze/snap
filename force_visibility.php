<?php
require_once('../../../wp-load.php');

$products = wc_get_products(array(
    'limit' => -1,
    'status' => 'publish'
));

$count = 0;
foreach ($products as $product) {
    // Force visibility to catalog and search
    $product->set_catalog_visibility('visible');
    
    // Set them to featured so they show up on the front page
    $product->set_featured(true);
    
    $product->save();
    $count++;
}

echo "Successfully forced visibility and featured status for $count products.";
?>