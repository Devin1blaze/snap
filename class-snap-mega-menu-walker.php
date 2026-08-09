<?php
/**
 * Walker: Desktop Mega-Menu
 * Renders a two-panel mega-menu (left sidebar L1/L2, right panel L3).
 * Menu structure from WP Dashboard:
 *   - Top level items ÔåÆ horizontal nav bar
 *   - L2 items (children) ÔåÆ LEFT sidebar panel
 *   - L3 items (grandchildren) ÔåÆ RIGHT content panel
 */
class Snap_Mega_Menu_Walker extends Walker_Nav_Menu {

    private $first_l2 = true;

    public function start_lvl( &$output, $depth = 0, $args = null ) {
        if ( $depth === 0 ) {
            // Opening the L2 mega-menu container
            $this->first_l2 = true;
            $output .= '<div class="snap-mega-wrapper" role="region">';
            $output .= '<div class="snap-mega-menu">';
            // Left sidebar
            $output .= '<div class="snap-mega-sidebar">';
            $output .= '<div class="snap-mega-sidebar-header">Categories</div>';
            $output .= '<ul class="snap-mega-cat-list">';
        } elseif ( $depth === 1 ) {
            // Opening the L3 right panel sub-grid (triggered per L2 item)
            $output .= '<div class="snap-mega-sub-grid">';
        }
    }

    public function end_lvl( &$output, $depth = 0, $args = null ) {
        if ( $depth === 0 ) {
            // Close L2 sidebar list
            $output .= '</ul>';
            $output .= '</div>'; // .snap-mega-sidebar
            // Close right content panel (opened via start_el at depth 0)
            $output .= '</div>'; // .snap-mega-content
            $output .= '</div>'; // .snap-mega-menu
            $output .= '</div>'; // .snap-mega-wrapper
        } elseif ( $depth === 1 ) {
            $output .= '</div>'; // .snap-mega-sub-grid
            $output .= '</div>'; // .snap-mega-sub
        }
    }

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes   = empty( $item->classes ) ? [] : (array) $item->classes;
        $has_children = in_array( 'menu-item-has-children', $classes );
        $cat_key   = 'megacat-' . $item->ID;
        $title     = apply_filters( 'the_title', $item->title, $item->ID );
        $url       = esc_url( $item->url );
        $initial   = mb_strtoupper( mb_substr( $title, 0, 1 ) );

        if ( $depth === 0 ) {
            // Top-level nav item
            if ( $has_children ) {
                $output .= '<li class="snap-nav-item">';
                $output .= '<a href="' . $url . '" class="snap-nav-link">';
                $output .= esc_html( $title );
                $output .= '<span class="material-symbols-outlined snap-nav-caret">expand_more</span>';
                $output .= '</a>';
                // Right content panel is opened here alongside the sidebar
                // We'll inject it after the sidebar closes ÔÇö use a buffer trick via end_lvl
                // Actually: we open it in start_lvl depth=0, but we need to track opening.
                // The sidebar UL is opened in start_lvl. The right panel opens after sidebar. 
                // We inject the right panel open tag using a data attribute hack here.
                // Simple approach: append to output AFTER start_lvl opens sidebar.
                // We use a split string approach: sidebar opens in start_lvl,
                // right content panel opens after last L2 via a marker.
                // For clean architecture, we track this in end_lvl.
            } else {
                $output .= '<li class="snap-nav-item">';
                $output .= '<a href="' . $url . '" class="snap-nav-link">' . esc_html( $title ) . '</a>';
            }

        } elseif ( $depth === 1 ) {
            // L2: sidebar category item
            $active = $this->first_l2 ? ' snap-mega-cat-active' : '';
            $this->first_l2 = false;
            $output .= '<li class="snap-mega-cat-item' . $active . '" data-cat="' . esc_attr( $cat_key ) . '">';
            $output .= '<a href="' . $url . '" class="snap-mega-cat-link">';
            $output .= '<span class="snap-mega-cat-icon-wrap" aria-hidden="true">' . esc_html( $initial ) . '</span>';
            $output .= '<span class="snap-mega-cat-name">' . esc_html( $title ) . '</span>';
            if ( $has_children ) {
                $output .= '<span class="material-symbols-outlined snap-mega-cat-arrow">chevron_right</span>';
            }
            $output .= '</a>';
            // Close the <li> in end_el, but we also need to open the right panel sub-div.
            // We open it here so start_lvl (depth=1) can write into it.
            // Note: if no children, we inject a "Browse all" fallback in end_el.

        } elseif ( $depth === 2 ) {
            // L3: sub-category link inside right panel grid
            $output .= '<a href="' . $url . '" class="snap-mega-sub-link">';
            $output .= '<span class="snap-mega-sub-dot"></span>';
            $output .= esc_html( $title );
            $output .= '</a>';
        }
    }

    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        $classes      = empty( $item->classes ) ? [] : (array) $item->classes;
        $has_children = in_array( 'menu-item-has-children', $classes );
        $title        = apply_filters( 'the_title', $item->title, $item->ID );
        $url          = esc_url( $item->url );
        $cat_key      = 'megacat-' . $item->ID;

        if ( $depth === 0 ) {
            $output .= '</li>';
        } elseif ( $depth === 1 ) {
            $output .= '</li>';
        } elseif ( $depth === 2 ) {
            // Nothing extra needed; the anchor is self-closed in start_el
        }
    }
}

/**
 * Walker: Mobile Accordion Menu
 */
class Snap_Mobile_Walker extends Walker_Nav_Menu {

    public function start_lvl( &$output, $depth = 0, $args = null ) {
        if ( $depth === 0 ) {
            $output .= '<div class="mobile-submenu hidden pl-4 pb-2">';
        } elseif ( $depth === 1 ) {
            $output .= '<div class="pl-4">';
        }
    }

    public function end_lvl( &$output, $depth = 0, $args = null ) {
        $output .= '</div>';
    }

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes      = empty( $item->classes ) ? [] : (array) $item->classes;
        $has_children = in_array( 'menu-item-has-children', $classes );
        $title        = apply_filters( 'the_title', $item->title, $item->ID );
        $url          = esc_url( $item->url );

        if ( $depth === 0 ) {
            $output .= '<div class="mobile-menu-group">';
            $output .= '<a href="' . $url . '" class="flex items-center justify-between px-4 py-3 text-[15px] font-semibold text-white/80 hover:text-white hover:bg-white/5 rounded-xl transition-all">';
            $output .= esc_html( $title );
            if ( $has_children ) {
                $output .= '<span class="material-symbols-outlined text-[18px] text-white/40 mobile-chevron transition-transform">expand_more</span>';
            }
            $output .= '</a>';
        } elseif ( $depth === 1 ) {
            $output .= '<a href="' . $url . '" class="flex items-center justify-between px-4 py-2.5 text-[13px] font-medium text-white/50 hover:text-white hover:bg-white/5 rounded-lg transition-all">';
            $output .= esc_html( $title );
            if ( $has_children ) {
                $output .= '<span class="material-symbols-outlined text-[14px] text-white/30">chevron_right</span>';
            }
            $output .= '</a>';
        } else {
            $output .= '<a href="' . $url . '" class="block px-4 py-2 text-[12px] font-medium text-white/40 hover:text-white/70 rounded-lg transition-all">';
            $output .= esc_html( $title );
            $output .= '</a>';
        }
    }

    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        if ( $depth === 0 ) {
            $output .= '</div>';
        }
    }
}

/**
 * Render the desktop mega-menu using wp_nav_menu + custom Walker.
 * The Walker approach works for items the user adds in WP Dashboard.
 * However the two-panel layout (sidebar L2 + right panel L3) requires
 * injecting the right panel div between sidebar close and wrapper close.
 * We post-process the output string to do this cleanly.
 */
function snap_render_desktop_menu() {
    $locations = get_nav_menu_locations();
    if ( empty( $locations['primary'] ) ) {
        echo '<span class="text-white/40 text-sm px-3">No menu assigned</span>';
        return;
    }

    ob_start();
    wp_nav_menu([
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => 'flex items-center gap-1',
        'menu_id'        => 'snap-desktop-nav',
        'walker'         => new Snap_Mega_Menu_Walker(),
        'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        'depth'          => 3,
        'fallback_cb'    => false,
    ]);
    $html = ob_get_clean();

    // Post-process: inject the right-panel open/close around L3 items.
    // The Walker generates:
    //   .snap-mega-sidebar > .snap-mega-cat-list > li.snap-mega-cat-item [L3 subs inline via start_lvl depth=1]
    // We need L3 subs to appear in .snap-mega-content, not inside .snap-mega-sidebar.
    // The cleanest approach: render the menu using get_terms for children, 
    // but keep L1 from WP menu and fetch their children dynamically.
    // 
    // Since the Walker approach becomes complex for two separate divs,
    // we use a hybrid: WP menu for L1 items, then fetch L2/L3 from WP nav_menu_items.

    echo $html;
}

/**
 * Better approach: hybrid render.
 * L1 comes from WP primary menu. For any L1 item that has children,
 * we render the Havells two-panel mega-menu using those children/grandchildren.
 * Fully editable from WP Dashboard.
 */
function snap_stitch_render_nav( $context = 'desktop' ) {
    $locations = get_nav_menu_locations();
    if ( empty( $locations['primary'] ) ) return;

    $menu_obj = wp_get_nav_menu_object( $locations['primary'] );
    if ( ! $menu_obj ) return;

    $all_items = wp_get_nav_menu_items( $menu_obj->term_id );
    if ( ! $all_items ) return;

    // Apply standard WP filters to allow dynamic item injection (e.g., WooCommerce categories)
    $args = (object) array( 'theme_location' => $context === 'mobile' ? 'primary' : 'primary' );
    $all_items = apply_filters( 'wp_nav_menu_objects', $all_items, $args );

    // Group by parent
    $children = [];
    foreach ( $all_items as $item ) {
        $pid = (int) $item->menu_item_parent;
        if ( $pid ) {
            $children[ $pid ][] = $item;
        }
    }

    // ÔöÇÔöÇ MOBILE ÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇ
    if ( $context === 'mobile' ) {
        echo '<nav class="flex flex-col gap-1">';
        foreach ( $all_items as $item ) {
            if ( (int) $item->menu_item_parent !== 0 ) continue;
            $has_ch = ! empty( $children[ $item->ID ] );
            echo '<div class="mobile-menu-group">';
            echo '<a href="' . esc_url( $item->url ) . '" class="flex items-center justify-between px-4 py-3 text-[15px] font-semibold text-white/80 hover:text-white hover:bg-white/5 rounded-xl transition-all">';
            echo esc_html( $item->title );
            if ( $has_ch ) {
                echo '<span class="material-symbols-outlined text-[18px] text-white/40 mobile-chevron transition-transform">expand_more</span>';
            }
            echo '</a>';
            if ( $has_ch ) {
                echo '<div class="mobile-submenu hidden pl-4 pb-2">';
                foreach ( $children[ $item->ID ] as $child ) {
                    $has_sub = ! empty( $children[ $child->ID ] );
                    echo '<a href="' . esc_url( $child->url ) . '" class="flex items-center justify-between px-4 py-2.5 text-[13px] font-medium text-white/50 hover:text-white hover:bg-white/5 rounded-lg transition-all">';
                    echo esc_html( $child->title );
                    if ( $has_sub ) {
                        echo '<span class="material-symbols-outlined text-[14px] text-white/30">chevron_right</span>';
                    }
                    echo '</a>';
                    if ( $has_sub ) {
                        echo '<div class="pl-4">';
                        foreach ( $children[ $child->ID ] as $sub ) {
                            echo '<a href="' . esc_url( $sub->url ) . '" class="block px-4 py-2 text-[12px] font-medium text-white/40 hover:text-white/70 rounded-lg transition-all">';
                            echo esc_html( $sub->title );
                            echo '</a>';
                        }
                        echo '</div>';
                    }
                }
                echo '</div>';
            }
            echo '</div>';
        }
        echo '</nav>';
        return;
    }

    // ÔöÇÔöÇ DESKTOP ÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇÔöÇ
    echo '<ul class="flex items-center gap-1" id="snap-desktop-nav">';
    foreach ( $all_items as $item ) {
        if ( (int) $item->menu_item_parent !== 0 ) continue;
        $has_ch = ! empty( $children[ $item->ID ] );

        echo '<li class="snap-nav-item">';
        echo '<a href="' . esc_url( $item->url ) . '" class="snap-nav-link">';
        echo esc_html( $item->title );
        if ( $has_ch ) {
            echo '<span class="material-symbols-outlined snap-nav-caret">expand_more</span>';
        }
        echo '</a>';

        if ( $has_ch ) {
            $first_l2 = true;
            echo '<div class="snap-mega-wrapper" role="region" aria-label="' . esc_attr( $item->title ) . ' menu">';
            echo '<div class="snap-mega-menu">';

            // LEFT SIDEBAR
            echo '<div class="snap-mega-sidebar">';
            echo '<div class="snap-mega-sidebar-header">Categories</div>';
            echo '<ul class="snap-mega-cat-list">';
            foreach ( $children[ $item->ID ] as $l2 ) {
                $cat_key  = 'megacat-' . $item->ID . '-' . $l2->ID;
                $active   = $first_l2 ? ' snap-mega-cat-active' : '';
                $has_l3   = ! empty( $children[ $l2->ID ] );
                $initial  = mb_strtoupper( mb_substr( $l2->title, 0, 1 ) );
                echo '<li class="snap-mega-cat-item' . $active . '" data-cat="' . esc_attr( $cat_key ) . '">';
                echo '<a href="' . esc_url( $l2->url ) . '" class="snap-mega-cat-link">';
                echo '<span class="snap-mega-cat-icon-wrap" aria-hidden="true">' . esc_html( $initial ) . '</span>';
                echo '<span class="snap-mega-cat-name">' . esc_html( $l2->title ) . '</span>';
                if ( $has_l3 ) {
                    echo '<span class="material-symbols-outlined snap-mega-cat-arrow">chevron_right</span>';
                }
                echo '</a>';
                echo '</li>';
                $first_l2 = false;
            }
            echo '</ul>';
            echo '</div>'; // end .snap-mega-sidebar

            // RIGHT CONTENT PANEL
            echo '<div class="snap-mega-content">';
            $first_r = true;
            foreach ( $children[ $item->ID ] as $l2 ) {
                $cat_key = 'megacat-' . $item->ID . '-' . $l2->ID;
                $active  = $first_r ? ' snap-mega-sub-active' : '';
                $has_l3  = ! empty( $children[ $l2->ID ] );
                echo '<div class="snap-mega-sub' . $active . '" data-for="' . esc_attr( $cat_key ) . '">';
                echo '<div class="snap-mega-sub-title">';
                echo esc_html( $l2->title );
                echo '<a href="' . esc_url( $l2->url ) . '">View all &rarr;</a>';
                echo '</div>';
                if ( $has_l3 ) {
                    echo '<div class="snap-mega-sub-grid">';
                    foreach ( $children[ $l2->ID ] as $l3 ) {
                        echo '<a href="' . esc_url( $l3->url ) . '" class="snap-mega-sub-link">';
                        echo '<span class="snap-mega-sub-dot"></span>';
                        echo esc_html( $l3->title );
                        echo '</a>';
                    }
                    echo '</div>';
                } else {
                    echo '<div class="snap-mega-sub-grid">';
                    echo '<a href="' . esc_url( $l2->url ) . '" class="snap-mega-sub-link snap-mega-sub-link-full">';
                    echo '<span class="snap-mega-sub-dot"></span>';
                    echo 'Browse all &mdash; ' . esc_html( $l2->title );
                    echo '</a>';
                    echo '</div>';
                }
                echo '</div>'; // .snap-mega-sub
                $first_r = false;
            }
            echo '</div>'; // .snap-mega-content

            echo '</div>'; // .snap-mega-menu
            echo '</div>'; // .snap-mega-wrapper
        }

        echo '</li>';
    }
    echo '</ul>';
}


