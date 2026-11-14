<?php
if ( file_exists( '/var/www/html/wp-load.php' ) ) {
    require_once('/var/www/html/wp-load.php');
} elseif ( file_exists( dirname( __DIR__, 3 ) . '/wp-load.php' ) ) {
    require_once dirname( __DIR__, 3 ) . '/wp-load.php';
}

if ( ! defined( 'ABSPATH' ) || ( php_sapi_name() !== 'cli' && ! current_user_can( 'manage_options' ) ) ) {
    if ( function_exists( 'wp_die' ) ) {
        wp_die( 'Unauthorized.' );
    } else {
        die( 'Unauthorized.' );
    }
}
$menu_locations = get_nav_menu_locations();
$menu_obj = wp_get_nav_menu_object( $menu_locations['primary'] );
$items = wp_get_nav_menu_items( $menu_obj->term_id );
foreach($items as $item) { echo $item->ID . ' | ' . $item->menu_item_parent . ' | ' . $item->title . PHP_EOL; }

