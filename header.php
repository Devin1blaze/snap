<?php
/**
 * Header — Snap Marketing
 * Uses native WordPress wp_nav_menu() with a custom Walker for the
 * Havells-style two-panel mega-menu. Fully editable from WP Dashboard.
 * Design tokens from DESIGN.md: #1A56DB (Royal Blue), #FBBF24 (Sunshine Yellow), #0A0A0A (Pure Black).
 */

/**
 * Walker: Desktop Mega-Menu
 * Renders a two-panel mega-menu (left sidebar L1/L2, right panel L3).
 * Menu structure from WP Dashboard:
 *   - Top level items → horizontal nav bar
 *   - L2 items (children) → LEFT sidebar panel
 *   - L3 items (grandchildren) → RIGHT content panel
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
                // We'll inject it after the sidebar closes — use a buffer trick via end_lvl
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

    // Group by parent
    $children = [];
    foreach ( $all_items as $item ) {
        $pid = (int) $item->menu_item_parent;
        if ( $pid ) {
            $children[ $pid ][] = $item;
        }
    }

    // ── MOBILE ─────────────────────────────────────────────────────────────
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

    // ── DESKTOP ─────────────────────────────────────────────────────────────
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
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        window.tailwind = window.tailwind || {};
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary":             "#1A56DB",
                        "secondary":           "#FBBF24",
                        "surface":             "#FFFFFF",
                        "on-surface":          "#0A0A0A",
                        "snap-yellow":         "#FBBF24",
                        "snap-blue":           "#1A56DB",
                        "snap-black":          "#0A0A0A",
                        "primary-container":   "#1A56DB",
                        "secondary-container": "#FBBF24"
                    },
                    fontFamily: {
                        "headline": ["Plus Jakarta Sans", "Inter", "sans-serif"],
                        "body":     ["Plus Jakarta Sans", "Inter", "sans-serif"]
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <style>
        /* ── DESIGN SYSTEM ─────────────────────────────────────
           Source: DESIGN.md — "Industrial Authority"
           Primary (Royal Blue):   #1A56DB
           Secondary (Sun Yellow): #FBBF24
           Surface/Base:           #FFFFFF / #0A0A0A
           Font: Plus Jakarta Sans (800 display, 700 headline, 500/400 body)
        ─────────────────────────────────────────────────────── */
        :root {
            --snap-blue:   #1A56DB;
            --snap-yellow: #FBBF24;
            --snap-black:  #0A0A0A;
            --snap-white:  #FFFFFF;
        }

        html, body { overflow-x: hidden; width: 100%; position: relative; }
        body { font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }

        /* ── HEADER SCROLL ──────────────────────────────────── */
        #nav-header { transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
        #nav-header.scrolled {
            background: rgba(10, 10, 10, 0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-color: rgba(26, 86, 219, 0.2);  /* Royal Blue tint border */
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.4), 0 0 0 1px rgba(26,86,219,0.1) inset;
        }

        /* ── MOBILE ACCORDION ───────────────────────────────── */
        .mobile-submenu { max-height: 0; overflow: hidden; transition: max-height 0.3s ease; }
        .mobile-submenu.open { max-height: 600px; }

        /* ── TOP NAV LINKS ──────────────────────────────────── */
        #snap-desktop-nav { list-style: none; margin: 0; padding: 0; }
        li.snap-nav-item  { position: relative; list-style: none; }

        a.snap-nav-link {
            display: inline-flex;
            align-items: center;
            gap: 2px;
            padding: 8px 13px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13.5px;
            font-weight: 600;
            color: rgba(255,255,255,0.82);
            text-decoration: none;
            border-radius: 0;                    /* Sharp — Industrial Authority */
            letter-spacing: 0.01em;
            transition: color 0.15s, background 0.15s;
            white-space: nowrap;
        }
        a.snap-nav-link:hover {
            color: #FBBF24;                      /* Sunshine Yellow on hover */
            background: rgba(251,191,36,0.06);
        }

        .snap-nav-caret {
            font-size: 16px;
            opacity: 0.55;
            transition: transform 0.2s ease;
        }
        li.snap-nav-item:hover .snap-nav-caret { transform: rotate(180deg); color: #FBBF24; }

        /* ── MEGA MENU WRAPPER ──────────────────────────────── */
        .snap-mega-wrapper {
            position: absolute;
            right: 0;
            top: 100%;
            padding-top: 8px;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transform: translateY(8px);
            transition: opacity 0.2s ease, visibility 0.2s ease, transform 0.2s ease;
            pointer-events: none;
        }
        li.snap-nav-item:hover > .snap-mega-wrapper {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            pointer-events: auto;
        }

        /* ── MEGA MENU CONTAINER ────────────────────────────── */
        .snap-mega-menu {
            display: flex;
            width: 700px;
            min-height: 380px;
            /* Base state matches unscrolled header (transparent) */
            background: rgba(10, 10, 10, 0.4); /* Slight tint for readability even when transparent */
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-top: 3px solid #1A56DB;       /* Royal Blue top accent */
            border-radius: 0;                    /* NO ROUND EDGES */
            overflow: hidden;
            box-shadow: 0 24px 60px rgba(0,0,0,0.5);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        
        /* Scrolled state matches scrolled header */
        #nav-header.scrolled .snap-mega-menu {
            background: rgba(10, 10, 10, 0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-left: 1px solid rgba(26, 86, 219, 0.2);
            border-right: 1px solid rgba(26, 86, 219, 0.2);
            border-bottom: 1px solid rgba(26, 86, 219, 0.2);
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.4), 0 0 0 1px rgba(26,86,219,0.1) inset;
        }

        /* ── LEFT SIDEBAR ───────────────────────────────────── */
        .snap-mega-sidebar {
            width: 235px;
            flex-shrink: 0;
            background: rgba(255, 255, 255, 0.03);
            border-right: 2px solid rgba(255, 255, 255, 0.05);
            display: flex;
            flex-direction: column;
        }
        .snap-mega-sidebar-header {
            padding: 14px 16px 8px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #FBBF24;                      /* Sunshine Yellow */
        }
        .snap-mega-cat-list {
            list-style: none;
            margin: 0;
            padding: 2px 0 12px;
            overflow-y: auto;
            flex: 1;
        }
        .snap-mega-cat-list::-webkit-scrollbar { width: 3px; }
        .snap-mega-cat-list::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 0; }

        /* Sidebar L2 item */
        .snap-mega-cat-item { position: relative; list-style: none; }
        .snap-mega-cat-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 16px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 600;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: color 0.12s, background 0.12s, border-color 0.12s;
        }
        .snap-mega-cat-item:hover .snap-mega-cat-link {
            color: #fff;
            background: rgba(255,255,255,0.06);
        }
        .snap-mega-cat-item.snap-mega-cat-active .snap-mega-cat-link {
            color: #0A0A0A;
            background: #FBBF24;                 /* Sunshine Yellow active indicator */
            border-left-color: #1A56DB;          /* Royal Blue accent */
            font-weight: 700;
        }

        /* Icon badge — letter initial */
        .snap-mega-cat-icon-wrap {
            width: 30px;
            height: 30px;
            border-radius: 0;                    /* No round edges */
            background: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 13px;
            font-weight: 800;
            color: #fff;
            transition: background 0.12s, color 0.12s;
        }
        .snap-mega-cat-item.snap-mega-cat-active .snap-mega-cat-icon-wrap {
            background: #0A0A0A;                 /* Black badge when active */
            color: #FBBF24;
        }
        .snap-mega-cat-item:hover .snap-mega-cat-icon-wrap {
            background: rgba(255,255,255,0.2);
        }

        .snap-mega-cat-name { flex: 1; }
        .snap-mega-cat-arrow {
            font-size: 14px;
            color: rgba(255,255,255,0.3);
            flex-shrink: 0;
        }
        .snap-mega-cat-item.snap-mega-cat-active .snap-mega-cat-arrow { color: #0A0A0A; }

        /* ── RIGHT CONTENT PANEL ────────────────────────────── */
        .snap-mega-content {
            flex: 1;
            padding: 20px 22px 18px;
            overflow-y: auto;
            background: transparent;
        }
        .snap-mega-content::-webkit-scrollbar { width: 3px; }
        .snap-mega-content::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 0; }

        /* Sub-panel (one per L2 item, hidden/shown via JS) */
        .snap-mega-sub { display: none; flex-direction: column; }
        .snap-mega-sub.snap-mega-sub-active { display: flex; }

        /* Sub-panel section header */
        .snap-mega-sub-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #1A56DB;                      /* Royal Blue label */
            margin-bottom: 12px;
            padding-bottom: 10px;
            border-bottom: 2px solid rgba(255,255,255,0.1);   /* Underline */
        }
        .snap-mega-sub-title a {
            font-size: 11px;
            font-weight: 600;
            color: #FBBF24;                      /* Sunshine yellow */
            text-decoration: none;
            margin-left: auto;
            letter-spacing: 0;
            text-transform: none;
            padding: 2px 8px;
            background: rgba(251,191,36,0.1);
            border-radius: 0;                    /* No round edges */
            transition: background 0.12s, color 0.12s;
        }
        .snap-mega-sub-title a:hover { background: #FBBF24; color: #0A0A0A; }

        /* Sub-links grid */
        .snap-mega-sub-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2px;
        }

        .snap-mega-sub-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 9px 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 500;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            border-radius: 0;                    /* Sharp — Industrial Authority */
            transition: color 0.12s, background 0.12s;
        }
        .snap-mega-sub-link:hover {
            color: #fff;
            background: rgba(255,255,255,0.06);
        }
        .snap-mega-sub-link:hover .snap-mega-sub-dot { background: #FBBF24; }

        /* Bullet dot */
        .snap-mega-sub-dot {
            width: 5px;
            height: 5px;
            border-radius: 0;                    /* Square dot! */
            background: rgba(255,255,255,0.2);
            flex-shrink: 0;
            transition: background 0.12s;
        }

        /* "Browse all" fallback — full width CTA-style */
        .snap-mega-sub-link-full {
            grid-column: 1 / -1;
            color: #FBBF24;
            font-weight: 700;
            border: 1px solid rgba(251,191,36,0.3);
            margin-top: 6px;
            padding: 10px 14px;
        }
        .snap-mega-sub-link-full:hover {
            background: #FBBF24;
            color: #0A0A0A;
            border-color: #FBBF24;
        }
        .snap-mega-sub-link-full:hover .snap-mega-sub-dot { background: #0A0A0A; }
        .snap-mega-sub-link-full .snap-mega-sub-dot { background: #FBBF24; }
    </style>
</head>
<body <?php body_class('bg-surface text-on-surface'); ?>>
<?php wp_body_open(); ?>

<header class="relative z-50">
  <nav id="floating-nav" class="fixed top-0 left-0 right-0 w-full z-[100] transition-all duration-300">
    <div id="nav-header" class="w-full max-w-[1536px] mx-auto mt-3 px-4 lg:px-6 border border-transparent rounded-none transition-all duration-500">
      <div class="flex items-center justify-between py-3 lg:py-3.5">

        <!-- Logo -->
        <div class="flex items-center shrink-0">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-3 group">
            <!-- Yellow bolt icon — Industrial Authority -->
            <span class="w-8 h-8 bg-[#FBBF24] flex items-center justify-center shadow-sm group-hover:shadow-[0_0_16px_rgba(251,191,36,0.4)] transition-shadow">
              <span class="material-symbols-outlined text-[#0A0A0A] text-lg" style="font-variation-settings:'FILL' 1">bolt</span>
            </span>
            <span class="text-lg font-extrabold text-white tracking-tight" style="font-family:'Plus Jakarta Sans',sans-serif">
              Snap <span class="text-[#FBBF24]">Marketing</span>
            </span>
          </a>
        </div>

        <!-- Desktop: Nav Links + Actions -->
        <div class="hidden lg:flex items-center gap-1">
          <?php snap_stitch_render_nav('desktop'); ?>

          <!-- Divider -->
          <div class="w-px h-5 bg-white/10 mx-3"></div>

          <!-- Search -->
          <button id="search-trigger" class="inline-flex items-center justify-center w-9 h-9 text-white/50 hover:text-[#FBBF24] hover:bg-[rgba(251,191,36,0.08)] transition-all cursor-pointer" aria-label="Search">
            <span class="material-symbols-outlined text-[18px]">search</span>
          </button>

          <!-- Login -->
          <a id="btn-login" href="/my-account" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white/70 hover:text-white border border-white/10 hover:border-[#1A56DB]/50 hover:bg-[rgba(26,86,219,0.08)] transition-all whitespace-nowrap" style="font-family:'Plus Jakarta Sans',sans-serif">Login</a>

          <!-- Get Quote — Primary CTA: Yellow fill, Black text, Sharp corners -->
          <a id="btn-quote" href="/request-a-quote" class="inline-flex items-center px-5 py-2 text-sm font-bold bg-[#FBBF24] text-[#0A0A0A] hover:bg-yellow-300 transition-all shadow-sm whitespace-nowrap" style="font-family:'Plus Jakarta Sans',sans-serif;border-radius:0;letter-spacing:0.02em">Get Quote</a>
        </div>

        <!-- Mobile: Search + Hamburger -->
        <div class="flex items-center gap-2 lg:hidden">
          <button id="search-trigger-mobile" class="p-2 text-white/60 hover:text-[#FBBF24] transition-colors" aria-label="Search">
            <span class="material-symbols-outlined text-xl">search</span>
          </button>
          <button id="nav-toggle" class="flex flex-col gap-[5px] p-2 group" aria-label="Toggle menu">
            <span class="block w-5 h-[2px] bg-white rounded-full transition-all duration-300 origin-center group-[.open]:rotate-45 group-[.open]:translate-y-[7px]"></span>
            <span class="block w-5 h-[2px] bg-white rounded-full transition-all duration-300 group-[.open]:opacity-0"></span>
            <span class="block w-5 h-[2px] bg-white rounded-full transition-all duration-300 origin-center group-[.open]:-rotate-45 group-[.open]:-translate-y-[7px]"></span>
          </button>
        </div>
      </div>

      <!-- Mobile Drawer -->
      <div id="mobile-menu" class="hidden lg:hidden overflow-hidden transition-all duration-300">
        <div class="pb-6 pt-4 border-t border-white/5 bg-[#0A0A0A]/95 backdrop-blur-xl mt-1">
          <?php snap_stitch_render_nav('mobile'); ?>
          <div class="flex flex-col gap-3 mt-5 px-4">
            <a href="/my-account" class="text-center text-sm font-semibold text-white/70 hover:text-white border border-white/10 py-3 hover:bg-[rgba(26,86,219,0.1)] transition-all" style="font-family:'Plus Jakarta Sans',sans-serif">Login</a>
            <a href="/request-a-quote" class="text-center text-sm font-bold bg-[#FBBF24] text-[#0A0A0A] py-3 hover:bg-yellow-300 transition-all shadow-sm" style="font-family:'Plus Jakarta Sans',sans-serif;letter-spacing:0.02em">Get Quote</a>
          </div>
        </div>
      </div>
    </div>
  </nav>
</header>

<!-- Search Modal -->
<div id="search-modal" class="fixed inset-0 z-[200] hidden items-center justify-center bg-[#0A0A0A]/92 backdrop-blur-xl p-4 transition-all duration-300 opacity-0 invisible">
    <div class="w-full max-w-4xl transform scale-95 transition-all duration-300">
        <button id="search-close" class="absolute -top-12 right-0 text-white/60 hover:text-[#FBBF24] flex items-center gap-2 text-xs font-bold tracking-widest uppercase" style="font-family:'Plus Jakarta Sans',sans-serif">
            Close <span class="material-symbols-outlined text-xl">close</span>
        </button>
        <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="relative">
            <input type="text" name="s" id="search-input" placeholder="Search by brand, SKU, or category..."
                class="w-full bg-white/5 border-b-2 border-white/20 text-white text-3xl md:text-5xl font-bold py-8 px-4 focus:outline-none focus:border-[#FBBF24] transition-colors placeholder:text-white/10"
                style="font-family:'Plus Jakarta Sans',sans-serif">
            <input type="hidden" name="post_type" value="product">
            <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#FBBF24]">
                <span class="material-symbols-outlined text-5xl">arrow_forward</span>
            </button>
        </form>
        <div class="mt-12">
            <h4 class="text-white/30 text-xs font-bold uppercase tracking-[0.3em] mb-6" style="font-family:'Plus Jakarta Sans',sans-serif">Trending Categories</h4>
            <div class="flex flex-wrap gap-3">
                <?php
                $pop_cats = get_terms( ['taxonomy' => 'product_cat', 'number' => 5, 'orderby' => 'count', 'order' => 'DESC', 'hide_empty' => true] );
                if ( ! is_wp_error( $pop_cats ) ) {
                    foreach ( $pop_cats as $cat ) {
                        echo '<a href="' . esc_url( get_term_link( $cat ) ) . '" class="px-5 py-2.5 bg-white/5 border border-white/10 text-white/60 text-sm font-medium hover:bg-[#FBBF24] hover:text-[#0A0A0A] hover:border-transparent transition-all" style="font-family:\'Plus Jakarta Sans\',sans-serif">' . esc_html( $cat->name ) . '</a>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
  // ── HEADER SCROLL ──────────────────────────────────────────────────
  const navHeader = document.getElementById('nav-header');
  let ticking = false;

  function updateHeader() {
    if (window.scrollY > 10) {
      navHeader.classList.add('scrolled');
      navHeader.classList.remove('mt-3', 'border-transparent');
      navHeader.classList.add('mt-0', 'border-[rgba(26,86,219,0.2)]');
    } else {
      navHeader.classList.remove('scrolled');
      navHeader.classList.add('mt-3', 'border-transparent');
      navHeader.classList.remove('mt-0', 'border-[rgba(26,86,219,0.2)]');
    }
    ticking = false;
  }
  window.addEventListener('scroll', function() {
    if (!ticking) { window.requestAnimationFrame(updateHeader); ticking = true; }
  });

  // ── MOBILE MENU TOGGLE ─────────────────────────────────────────────
  const navToggle  = document.getElementById('nav-toggle');
  const mobileMenu = document.getElementById('mobile-menu');
  navToggle.addEventListener('click', function() {
    this.classList.toggle('open');
    mobileMenu.classList.toggle('hidden');
    if (!mobileMenu.classList.contains('hidden')) {
      navHeader.style.background = 'rgba(10, 10, 10, 0.97)';
      navHeader.style.backdropFilter = 'blur(20px)';
    } else if (window.scrollY <= 10) {
      navHeader.style.background = '';
      navHeader.style.backdropFilter = '';
    }
  });

  // ── MOBILE ACCORDION ───────────────────────────────────────────────
  document.querySelectorAll('.mobile-menu-group > a').forEach(link => {
    const chevron = link.querySelector('.mobile-chevron');
    if (!chevron) return;
    link.addEventListener('click', function(e) {
      const submenu = this.nextElementSibling;
      if (submenu && submenu.classList.contains('mobile-submenu')) {
        e.preventDefault();
        submenu.classList.toggle('hidden');
        submenu.classList.toggle('open');
        chevron.style.transform = submenu.classList.contains('open') ? 'rotate(180deg)' : '';
      }
    });
  });

  // ── MEGA MENU — SIDEBAR HOVER INTERACTION ──────────────────────────
  document.querySelectorAll('.snap-mega-cat-item').forEach(function(catItem) {
    catItem.addEventListener('mouseenter', function() {
      var menu = this.closest('.snap-mega-menu');
      if (!menu) return;
      var catKey = this.getAttribute('data-cat');

      menu.querySelectorAll('.snap-mega-cat-item').forEach(el => el.classList.remove('snap-mega-cat-active'));
      menu.querySelectorAll('.snap-mega-sub').forEach(el => el.classList.remove('snap-mega-sub-active'));

      this.classList.add('snap-mega-cat-active');
      var sub = menu.querySelector('.snap-mega-sub[data-for="' + catKey + '"]');
      if (sub) sub.classList.add('snap-mega-sub-active');
    });
  });

  // Reset to first item on menu leave
  document.querySelectorAll('.snap-mega-menu').forEach(function(menu) {
    menu.addEventListener('mouseleave', function() {
      var firstCat = menu.querySelector('.snap-mega-cat-item');
      var firstSub = menu.querySelector('.snap-mega-sub');
      if (firstCat && firstSub) {
        menu.querySelectorAll('.snap-mega-cat-item').forEach(el => el.classList.remove('snap-mega-cat-active'));
        menu.querySelectorAll('.snap-mega-sub').forEach(el => el.classList.remove('snap-mega-sub-active'));
        firstCat.classList.add('snap-mega-cat-active');
        firstSub.classList.add('snap-mega-sub-active');
      }
    });
  });

  // ── SEARCH MODAL ───────────────────────────────────────────────────
  const searchTrigger       = document.getElementById('search-trigger');
  const searchTriggerMobile = document.getElementById('search-trigger-mobile');
  const searchModal         = document.getElementById('search-modal');
  const searchClose         = document.getElementById('search-close');
  const searchInput         = document.getElementById('search-input');

  const openSearch = () => {
    searchModal.classList.remove('hidden', 'opacity-0', 'invisible');
    searchModal.classList.add('flex', 'opacity-100', 'visible');
    searchModal.querySelector('div').classList.remove('scale-95');
    searchModal.querySelector('div').classList.add('scale-100');
    setTimeout(() => searchInput.focus(), 300);
    document.body.style.overflow = 'hidden';
  };
  if (searchTrigger)       searchTrigger.addEventListener('click', openSearch);
  if (searchTriggerMobile) searchTriggerMobile.addEventListener('click', openSearch);

  function closeSearch() {
    searchModal.classList.remove('opacity-100', 'visible');
    searchModal.classList.add('opacity-0', 'invisible');
    searchModal.querySelector('div').classList.remove('scale-100');
    searchModal.querySelector('div').classList.add('scale-95');
    setTimeout(() => {
      searchModal.classList.add('hidden');
      searchModal.classList.remove('flex');
      document.body.style.overflow = '';
    }, 300);
  }
  searchClose.addEventListener('click', closeSearch);
  searchModal.addEventListener('click', e => { if (e.target === searchModal) closeSearch(); });
  window.addEventListener('keydown', e => { if (e.key === 'Escape') closeSearch(); });
</script>
</body>
</html>