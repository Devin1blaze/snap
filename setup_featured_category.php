<?php
require_once('../../../wp-load.php');

$cat_name = 'Featured Products';
$cat_slug = 'featured-products';

// Check if category exists, if not create it
$term = term_exists($cat_slug, 'product_cat');
if ($term === 0 || $term === null) {
    $term = wp_insert_term(
        $cat_name,
        'product_cat',
        array(
            'description' => 'Products featured on the homepage carousel.',
            'slug'        => $cat_slug,
        )
    );
    if (is_wp_error($term)) {
        die("Error creating category: " . $term->get_error_message());
    }
    echo "Created new category: $cat_name\n";
} else {
    echo "Category $cat_name already exists.\n";
}

$term_id = is_array($term) ? $term['term_id'] : $term;

// The test products we want to feature
$products_to_feature = array(70, 71, 101, 99, 97, 95, 93, 91);
$count = 0;

foreach ($products_to_feature as $product_id) {
    // Append the term to existing terms
    $result = wp_set_object_terms($product_id, (int)$term_id, 'product_cat', true);
    if (!is_wp_error($result)) {
        $count++;
    }
}

// Clear transients
wc_delete_product_transients();

echo "Assigned $count products to the '$cat_name' category.";
?>