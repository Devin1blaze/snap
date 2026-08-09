<?php
require_once('/var/www/html/wp-load.php');
$menu_locations = get_nav_menu_locations();
$menu_obj = wp_get_nav_menu_object( $menu_locations['primary'] );
$items = wp_get_nav_menu_items( $menu_obj->term_id );
foreach($items as $item) { echo $item->ID . ' | ' . $item->menu_item_parent . ' | ' . $item->title . PHP_EOL; }

