<?php
/**
 * Custom Walker for Tailwind CSS Menu
 */
class Tailwind_Nav_Walker extends Walker_Nav_Menu {
    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        $classes[] = 'relative group'; // Add group for dropdowns
        
        // Pass the mega-menu status to the next level
        if ( in_array( 'mega-menu', $classes ) ) {
            $item->is_mega_menu = true;
        }

        $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        // Check if we are inside a megamenu (depth > 0) or standard item
        if ( $depth === 0 ) {
            $atts['class'] = 'font-[\'Plus Jakarta Sans\'] font-bold uppercase tracking-tight text-white hover:text-secondary-container transition-colors flex items-center py-4';
        } else {
            // Mega menu child links or standard dropdown links
            $atts['class'] = 'font-[\'Plus Jakarta Sans\'] block py-2 text-gray-300 hover:text-secondary-container transition-colors';
        }

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
                $value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters( 'the_title', $item->title, $item->ID );
        $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . $title . $args->link_after;
        
        // Add dropdown arrow if has children and at top level
        if ( $depth === 0 && in_array( 'menu-item-has-children', $classes ) ) {
            $item_output .= ' <span class="material-symbols-outlined text-[16px] ml-1 transition-transform group-hover:rotate-180">expand_more</span>';
        }
        
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat("\t", $depth);
        // We can't directly access the parent item's classes here easily in standard Walker,
        // so we'll use a generic wide dropdown that acts as a megamenu for the first level.
        if ( $depth === 0 ) {
            $output .= "\n$indent<ul class=\"sub-menu absolute left-0 top-full mt-0 w-[600px] bg-[#0A0A0A] shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top -translate-y-2 group-hover:translate-y-0 grid grid-cols-2 gap-4 p-8 border-t-4 border-secondary-container\">\n";
        } else {
            $output .= "\n$indent<ul class=\"pl-4 mt-2 space-y-2\">\n";
        }
    }
}
