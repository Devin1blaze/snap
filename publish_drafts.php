<?php
require_once('../../../wp-load.php');
$args = array(
    'post_type' => 'product',
    'post_status' => 'draft',
    'posts_per_page' => -1
);
$query = new WP_Query($args);
$count = 0;
foreach($query->posts as $post) {
    wp_update_post(array(
        'ID' => $post->ID,
        'post_status' => 'publish'
    ));
    $count++;
}
echo "Published $count draft products.";
?>