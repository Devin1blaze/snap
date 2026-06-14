<?php
/**
 * Custom Walker for Tailwind CSS Menu - V3 Unique
 */

if ( ! defined( 'ABSPATH' ) ) {
        exit;
}

exit('WALKER LOADED');

class Tailwind_Nav_Walker_V3 extends Walker_Nav_Menu {
    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        // ULTRA UNIQUE CLASS TO VERIFY
        $classes[] = 'menu-depth-v3-' . $depth;

        if ($depth > 0) {
            $classes[] = 'w-full block';
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

        if ( $depth === 0 ) {
            $atts['class'] = 'nav-link font-[\'Plus Jakarta Sans\'] font-bold uppercase tracking-[0.2em] text-white/70 hover:text-secondary-container transition-all flex items-center py-6';
        } elseif ( $depth === 1 ) {
            $atts['class'] = 'font-[\'Plus Jakarta Sans\'] text-[13px] font-bold uppercase tracking-widest text-white/70 hover:text-secondary-container transition-all flex items-center justify-between px-6 py-4 hover:bg-white/10 hover:pl-8 border-b border-white/5 w-full text-left';
        } else {
            $atts['class'] = 'font-[\'Plus Jakarta Sans\'] text-[11px] font-bold uppercase tracking-widest text-white/50 hover:text-white transition-all block px-6 py-4 hover:bg-white/10 hover:pl-8 border-b border-white/5 w-full text-left';
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

        // Add dropdown arrow if has children
        if ( in_array( 'menu-item-has-children', $classes ) ) {
            $icon_class = ($depth === 0) ? 'expand_more' : 'chevron_right';
            $item_output .= ' <span class="material-symbols-outlined text-[16px] ml-1 transition-transform group-hover:rotate-180">' . $icon_class . '</span>';
        }

        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu absolute z-50 w-72 bg-[#0A0A0A] border border-white/10 rounded-xl overflow-hidden flex flex-col shadow-2xl transition-all duration-300\">\n";   
    }
}
