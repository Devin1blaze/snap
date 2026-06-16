<?php
require 'wp-load.php';
$menu = wp_get_nav_menu_items('primary-menu');
if($menu) {
    $out = "";
    foreach($menu as $m) {
        $out .= $m->title . " (" . $m->type . ", " . $m->object . ", ID: " . $m->ID . ")\n";
    }
    file_put_contents('menu_output.txt', $out);
} else {
    file_put_contents('menu_output.txt', "No menu found");
}
