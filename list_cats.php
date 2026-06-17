<?php
require_once '../../../wp-load.php';

header('Content-Type: text/plain');

echo "--- ROOT TERMS SEARCH ---\n";
$b2b_term = get_term_by('slug', 'b2b', 'product_cat');
$b2c_term = get_term_by('slug', 'b2c', 'product_cat');

echo "B2B Term: " . ($b2b_term ? "Found (ID: {$b2b_term->term_id}, Slug: {$b2b_term->slug}, Name: {$b2b_term->name})" : "Not Found") . "\n";
echo "B2C Term: " . ($b2c_term ? "Found (ID: {$b2c_term->term_id}, Slug: {$b2c_term->slug}, Name: {$b2c_term->name})" : "Not Found") . "\n";

$parent_ids = [];
if ($b2b_term) $parent_ids[] = (int) $b2b_term->term_id;
if ($b2c_term) $parent_ids[] = (int) $b2c_term->term_id;

echo "\n--- ALL CATEGORIES WITH hide_empty => false ---\n";
$all_cats_false = get_terms([
    'taxonomy' => 'product_cat',
    'hide_empty' => false,
]);
foreach ($all_cats_false as $cat) {
    $is_child = in_array((int)$cat->parent, $parent_ids, true) ? "YES (Parent ID: {$cat->parent})" : "NO (Parent ID: {$cat->parent})";
    echo "- Name: {$cat->name} | ID: {$cat->term_id} | Slug: {$cat->slug} | Count: {$cat->count} | Direct Child of B2B/B2C: {$is_child}\n";
}

echo "\n--- ALL CATEGORIES WITH hide_empty => true ---\n";
$all_cats_true = get_terms([
    'taxonomy' => 'product_cat',
    'hide_empty' => true,
]);
foreach ($all_cats_true as $cat) {
    $is_child = in_array((int)$cat->parent, $parent_ids, true) ? "YES (Parent ID: {$cat->parent})" : "NO (Parent ID: {$cat->parent})";
    echo "- Name: {$cat->name} | ID: {$cat->term_id} | Slug: {$cat->slug} | Count: {$cat->count} | Direct Child of B2B/B2C: {$is_child}\n";
}
