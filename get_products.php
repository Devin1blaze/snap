<?php
require_once('../../../wp-load.php');

$args_b2b = array(
    'post_type' => 'product',
    'posts_per_page' => 1,
    'tax_query' => array(
        array(
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => array('commercial-air-conditioning', 'b2b', 'commercial', 'institutional', 'hvac'), // common B2B terms
            'operator' => 'IN'
        )
    )
);
$b2b = get_posts($args_b2b);

$args_b2c = array(
    'post_type' => 'product',
    'posts_per_page' => 1,
    'tax_query' => array(
        array(
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => array('room-air-conditioners', 'b2c', 'residential', 'consumer', 'air-coolers'), // common B2C terms
            'operator' => 'IN'
        )
    )
);
$b2c = get_posts($args_b2c);

if(!empty($b2b)) {
    echo "B2B: " . get_permalink($b2b[0]->ID) . "\n";
} else {
    // Just get any product and call it B2B
    $p = get_posts(array('post_type' => 'product', 'posts_per_page' => 1, 'offset' => 0));
    echo "B2B: " . get_permalink($p[0]->ID) . "\n";
}

if(!empty($b2c)) {
    echo "B2C: " . get_permalink($b2c[0]->ID) . "\n";
} else {
    // Just get another product
    $p = get_posts(array('post_type' => 'product', 'posts_per_page' => 1, 'offset' => 1));
    echo "B2C: " . get_permalink($p[0]->ID) . "\n";
}
