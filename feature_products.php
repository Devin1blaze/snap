<?php
require_once('../../../wp-load.php');

$products_to_feature = array(70, 71, 101, 99, 97, 95, 93, 91);

foreach ($products_to_feature as $product_id) {
    wp_set_object_terms($product_id, 'featured', 'product_visibility', true);
    echo "Featured product ID $product_id\n";
}

// Clear transients to make sure WooCommerce query caches are updated
wc_delete_product_transients();
echo "Featured products updated.";
?>