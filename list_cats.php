<?php
require_once 'wp-load.php';
$terms = get_terms([
    'taxonomy' => 'product_cat',
    'hide_empty' => false,
]);
foreach ($terms as $term) {
    echo $term->name . " (ID: " . $term->term_id . ", Parent: " . $term->parent . ")\n";
}
