<?php
class Mega_Menu_Walker extends Walker_Nav_Menu {
    private $current_item;
    private $custom_options;
    
    // Store items so we can render them customly
    private $menu_items = array();

    // Instead of using start_el/end_el sequentially, we can capture the items and render them at the end? 
    // No, Walker doesn't work that way easily for the whole menu. 
    // BUT we can use CSS to style the sequential output into a mega menu!

    public function start_lvl( &$output, $depth = 0, $args = null ) {
        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = str_repeat( $t, $depth );
        
        $classes = array( 'sub-menu' );
        
        if ( $depth === 0 ) {
            // This is the container for L2 items (The mega menu panel itself)
            // We make it full width, absolute, and a flex container (or grid).
            $classes[] = 'absolute left-0 top-[100%] w-full bg-[#0A0A0A] border-t border-white/10 shadow-2xl transition-all duration-300 opacity-0 invisible group-hover:opacity-100 group-hover:visible z-50 flex min-h-[400px]';
        } elseif ( $depth === 1 ) {
            // This is the container for L3 items
            // It will be positioned absolutely in the right-hand panel of the mega menu
            // Only visible when its parent L2 is hovered
            $classes[] = 'absolute left-[25%] top-0 w-[75%] h-full p-8 flex-wrap content-start gap-4 hidden group-hover/l2:flex bg-[#0A0A0A] border-l border-white/5';
        }

        $class_names = join( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $output .= "{$n}{$indent}<ul$class_names>{$n}";
        
        // If it's depth 0, we are starting the mega menu panel. The left side will just be the L2 <li>s.
        // We should wrap the L2 <li>s in a 25% width container. We can do that by making the L2 <li> elements themselves block level and 25% width, or just setting width on the ul.
        // Wait, if ul is flex, the <li>s will be flex items. 
        // Let's use standard block layout for the left column.
        if ( $depth === 0 ) {
            $output .= "<div class=\"w-1/4 bg-white/5 p-4 flex flex-col gap-2 relative z-10 border-r border-white/5\">\n";
        }
    }

    public function end_lvl( &$output, $depth = 0, $args = null ) {
        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = str_repeat( $t, $depth );
        
        if ( $depth === 0 ) {
            // close the 1/4 width left column
            $output .= "</div>\n";
        }
        
        $output .= "$indent</ul>{$n}";
    }

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        // Custom classes based on depth
        if ( $depth === 0 ) {
            $classes[] = 'group relative py-6'; // Note: NOT relative if we want full width dropdown relative to header. Wait, if it is relative, absolute child is bounded by it.
            // WE MUST REMOVE 'relative' from depth 0 if we want the child to be full width of the screen/island.
            // BUT, if we want it to be full width of the island, the island should be relative, and the li should NOT be relative.
            $classes = array_diff($classes, array('relative')); 
            $classes[] = 'px-2 lg:px-4 static group'; // 'static' ensures the child absolute anchors to the nearest relative parent (the nav island)
        } elseif ( $depth === 1 ) {
            $classes[] = 'group/l2 block w-full';
        } elseif ( $depth === 2 ) {
            $classes[] = 'block w-[calc(33.333%-1rem)] mb-4';
        }

        $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names . '>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        if ( '_blank' === $item->target && empty( $item->xfn ) ) {
            $atts['rel'] = 'noopener';
        } else {
            $atts['rel'] = $item->xfn;
        }
        $atts['href']         = ! empty( $item->url ) ? $item->url : '';
        $atts['aria-current'] = $item->current ? 'page' : '';

        // Add custom Tailwind classes to the links
        if ( $depth === 0 ) {
            $atts['class'] = 'text-white/80 hover:text-white font-bold text-sm tracking-widest uppercase transition-colors flex items-center gap-1';
        } elseif ( $depth === 1 ) {
            $atts['class'] = 'block px-4 py-3 text-sm font-semibold text-white/70 hover:text-black hover:bg-[#FBBF24] rounded-lg transition-all w-full text-left';
        } elseif ( $depth === 2 ) {
            $atts['class'] = 'block px-4 py-4 bg-white/5 hover:bg-white/10 border border-white/10 hover:border-[#FBBF24]/50 rounded-xl transition-all';
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
        $item_output .= '<a' . $attributes . '>';
        
        // Add content based on depth
        if ( $depth === 2 ) {
            $item_output .= '<span class="block text-white font-semibold text-sm mb-1">' . $args->link_before . $title . $args->link_after . '</span>';
            if ( !empty($item->description) ) {
                $item_output .= '<span class="block text-white/50 text-xs">' . esc_html($item->description) . '</span>';
            } else {
                $item_output .= '<span class="block text-white/40 text-xs mt-1 group-hover:text-[#FBBF24] transition-colors">Explore Category &rarr;</span>';
            }
        } else {
            $item_output .= $args->link_before . $title . $args->link_after;
        }

        if ( $depth === 0 && in_array( 'menu-item-has-children', $item->classes ) ) {
            $item_output .= '<span class="material-symbols-outlined text-[16px] opacity-70 group-hover:rotate-180 transition-transform">expand_more</span>';
        } elseif ( $depth === 1 && in_array( 'menu-item-has-children', $item->classes ) ) {
             $item_output .= '<span class="material-symbols-outlined text-[16px] float-right opacity-70 group-hover/l2:text-black">chevron_right</span>';
        }

        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}
