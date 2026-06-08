<?php
/**
 * Auto-provision the primary menu
 */
function snap_stitch_auto_provision_menu() {
    // Only run once via a transient check or just let it run if the menu doesn't exist
    $menu_name = 'Snap Primary Menu';
    $menu_exists = wp_get_nav_menu_object($menu_name);

    if ( ! $menu_exists ) {
        $menu_id = wp_create_nav_menu($menu_name);

        $products_id = wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' =>  'Products',
            'menu-item-classes' => 'mega-menu',
            'menu-item-url' => '/shop/', 
            'menu-item-status' => 'publish'
        ));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' =>  'B2B Catalog',
            'menu-item-parent-id' => $products_id,
            'menu-item-url' => '/shop/?type=b2b', 
            'menu-item-status' => 'publish'
        ));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' =>  'B2C Retail',
            'menu-item-parent-id' => $products_id,
            'menu-item-url' => '/shop/?type=b2c', 
            'menu-item-status' => 'publish'
        ));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' =>  'About Us',
            'menu-item-url' => '/about-us/', 
            'menu-item-status' => 'publish'
        ));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' =>  'Contact Us',
            'menu-item-url' => '/contact-us/', 
            'menu-item-status' => 'publish'
        ));

        // Assign menu to location
        $locations = get_theme_mod('nav_menu_locations');
        $locations['primary'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
}
add_action('after_setup_theme', 'snap_stitch_auto_provision_menu');