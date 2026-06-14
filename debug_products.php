<?php
require_once('../../../wp-load.php');
$args = array(
    'post_type' => 'product',
    'post_status' => 'any',
    'posts_per_page' => -1
);
$query = new WP_Query($args);
echo "Total products (any status): " . $query->found_posts . "\n";
foreach($query->posts as $post) {
    echo "ID: " . $post->ID . " - Title: " . $post->post_title . " - Status: " . $post->post_status . "\n";
}
?>