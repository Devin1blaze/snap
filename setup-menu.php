<?php
/**
 * Auto-provision the primary menu with 3-level hierarchy
 */
function snap_stitch_auto_provision_menu() {
    $menu_name = 'Snap Primary Menu V2'; // Incrementing version to force refresh
    $menu_exists = wp_get_nav_menu_object($menu_name);

    if ( ! $menu_exists ) {
        $menu_id = wp_create_nav_menu($menu_name);

        // Top Level: Products
        $products_id = wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' =>  'Products',
            'menu-item-classes' => 'menu-item-products',
            'menu-item-url' => '#', 
            'menu-item-status' => 'publish'
        ));

        // Level 2: B2B
        $b2b_id = wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' =>  'B2B Catalog',
            'menu-item-parent-id' => $products_id,
            'menu-item-url' => '/shop/?type=b2b', 
            'menu-item-status' => 'publish'
        ));

        // Level 2: B2C
        $b2c_id = wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' =>  'B2C Retail',
            'menu-item-parent-id' => $products_id,
            'menu-item-url' => '/shop/?type=b2c', 
            'menu-item-status' => 'publish'
        ));

        $categories = array(
            'Washroom Automations' => 'washroom-automations',
            'Commercial Refrigeration' => 'commercial-refrigeration',
            'Water Purifiers' => 'water-purifiers',
            'Vending Machines' => 'vending-machines',
            'Hygiene & PPE' => 'hygiene-ppe',
            'Entrance Solutions' => 'entrance-solutions'
        );

        // Level 3: Categories under B2B
        foreach ($categories as $name => $slug) {
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title' =>  $name,
                'menu-item-parent-id' => $b2b_id,
                'menu-item-url' => '/product-category/' . $slug . '/?type=b2b', 
                'menu-item-status' => 'publish'
            ));
        }

        // Level 3: Categories under B2C
        foreach ($categories as $name => $slug) {
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title' =>  $name,
                'menu-item-parent-id' => $b2c_id,
                'menu-item-url' => '/product-category/' . $slug . '/?type=b2c', 
                'menu-item-status' => 'publish'
            ));
        }

        // Other Top Level items
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