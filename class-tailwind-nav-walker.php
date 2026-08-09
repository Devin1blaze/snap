<?php
/**
 * Tailwind_Nav_Walker — Full-Width Two-Panel Mega Menu Walker
 *
 * Reads 100% from WordPress Dashboard → Appearance → Menus.
 * Top-level items with children get the two-panel mega menu.
 * Top-level items without children get a plain nav link.
 *
 * Structure:
 *   L1 (depth 0) → Horizontal nav bar links
 *   L2 (depth 1) → LEFT sidebar of mega menu
 *   L3 (depth 2) → RIGHT sub-links panel of mega menu
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Tailwind_Nav_Walker extends Walker_Nav_Menu {

    // State per top-level item
    private $is_mega      = false;
    private $l2_items     = [];
    private $l3_by_parent = [];
    private $current_l2   = null;
    private $first_l2     = true;

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes      = empty( $item->classes ) ? [] : (array) $item->classes;
        $has_children = in_array( 'menu-item-has-children', $classes );
        $title        = apply_filters( 'the_title', $item->title, $item->ID );
        $url          = ! empty( $item->url ) ? esc_url( $item->url ) : '#';
        $initial      = mb_strtoupper( mb_substr( $title, 0, 1 ) );

        if ( $depth === 0 ) {
            // Reset state for each top-level item
            $this->is_mega      = $has_children;
            $this->l2_items     = [];
            $this->l3_by_parent = [];
            $this->current_l2   = null;
            $this->first_l2     = true;

            $li_class = $has_children ? 'mega-nav-item' : 'mega-nav-item-simple';
            $output  .= '<li class="' . $li_class . '">';

            $output .= '<a href="' . $url . '" class="mega-top-link">';
            $output .= esc_html( $title );
            if ( $has_children ) {
                $output .= '<span class="material-symbols-outlined mega-caret">expand_more</span>';
            }
            $output .= '</a>';

        } elseif ( $depth === 1 ) {
            // Buffer L2 — rendered later in render_mega_panel()
            $this->current_l2 = $item->ID;
            $this->l2_items[ $item->ID ] = [
                'title'        => $title,
                'url'          => $url,
                'initial'      => $initial,
                'has_children' => $has_children,
            ];
            if ( ! isset( $this->l3_by_parent[ $item->ID ] ) ) {
                $this->l3_by_parent[ $item->ID ] = [];
            }

        } elseif ( $depth === 2 ) {
            // Buffer L3
            if ( $this->current_l2 ) {
                $this->l3_by_parent[ $this->current_l2 ][] = [
                    'title'  => $title,
                    'url'    => $url,
                    'cat_id' => ( $item->object === 'product_cat' ) ? (int) $item->object_id : 0,
                ];
            }
        }
    }

    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        if ( $depth === 0 ) {
            $output .= '</li>';
        }
    }

    /** Suppress WordPress default UL wrappers */
    public function start_lvl( &$output, $depth = 0, $args = null ) {}

    /** At depth=0 close, fire the mega panel render */
    public function end_lvl( &$output, $depth = 0, $args = null ) {
        if ( $depth === 0 && $this->is_mega ) {
            $output .= $this->render_mega_panel();
        }
    }

    /**
     * Renders the two-panel mega menu from buffered L2 / L3 items.
     */
    private function render_mega_panel() {
        if ( empty( $this->l2_items ) ) {
            return '';
        }

        $html  = '<div class="mega-wrapper" role="region">';
        $html .= '<div class="mega-inner">';

        // ── LEFT SIDEBAR ────────────────────────────────────────────────────
        $html .= '<div class="mega-sidebar">';
        $html .= '<div class="mega-sidebar-header">Categories</div>';
        $html .= '<ul class="mega-cat-list">';

        $first = true;
        foreach ( $this->l2_items as $id => $l2 ) {
            $panel_id = 'mega-panel-' . $id;
            $active   = $first ? ' mega-cat-active' : '';
            $has_l3   = ! empty( $this->l3_by_parent[ $id ] );

            $html .= '<li class="mega-cat-item' . $active . '" data-panel="' . esc_attr( $panel_id ) . '">';
            $html .= '<a href="' . $l2['url'] . '" class="mega-cat-link">';
            $html .= '<span class="mega-cat-icon" aria-hidden="true">' . esc_html( $l2['initial'] ) . '</span>';
            $html .= '<span class="mega-cat-name">' . esc_html( $l2['title'] ) . '</span>';
            if ( $has_l3 ) {
                $html .= '<span class="material-symbols-outlined mega-cat-arrow">chevron_right</span>';
            }
            $html .= '</a>';
            $html .= '</li>';

            $first = false;
        }

        $html .= '</ul>';
        $html .= '</div>'; // .mega-sidebar

        // ── RIGHT CONTENT PANEL ──────────────────────────────────────────────
        $html .= '<div class="mega-content">';

        $first = true;
        foreach ( $this->l2_items as $id => $l2 ) {
            $panel_id = 'mega-panel-' . $id;
            $active   = $first ? ' mega-panel-active' : '';
            $l3_items = $this->l3_by_parent[ $id ] ?? [];

            $html .= '<div class="mega-panel' . $active . '" id="' . esc_attr( $panel_id ) . '">';
            $html .= '<div class="mega-panel-header">';
            $html .= '<span class="mega-panel-title">' . esc_html( $l2['title'] ) . '</span>';
            $html .= '<a href="' . $l2['url'] . '" class="mega-panel-view-all">View all &rarr;</a>';
            $html .= '</div>';

            $html .= '<div class="mega-panel-grid">';

            if ( ! empty( $l3_items ) ) {
                foreach ( $l3_items as $l3 ) {
                    $cat_id    = ! empty( $l3['cat_id'] ) ? esc_attr( $l3['cat_id'] ) : '';
                    $data_attr = $cat_id ? ' data-cat-id="' . $cat_id . '"' : '';

                    $html .= '<div class="mega-sub-container">';
                    $html .= '<a href="' . $l3['url'] . '" class="mega-sub-link js-mega-accordion-trigger"' . $data_attr . '>';
                    $html .= '<span class="mega-sub-dot"></span>';
                    $html .= esc_html( $l3['title'] );
                    if ( $cat_id ) {
                        $html .= '<span class="material-symbols-outlined mega-sub-caret">expand_more</span>';
                    }
                    $html .= '</a>';

                    if ( $cat_id ) {
                        $html .= '<div class="mega-accordion-content" id="mega-acc-' . $cat_id . '">';
                        $html .= '<div class="mega-accordion-inner"><div class="mega-loading">Loading...</div></div>';
                        $html .= '</div>';
                    }
                    $html .= '</div>';
                }
            } else {
                // No sub-items: show a browse-all link
                $html .= '<a href="' . $l2['url'] . '" class="mega-sub-link mega-sub-link-browse">';
                $html .= '<span class="mega-sub-dot"></span>';
                $html .= 'Browse all &mdash; ' . esc_html( $l2['title'] );
                $html .= '</a>';
            }

            $html .= '</div>'; // .mega-panel-grid
            $html .= '</div>'; // .mega-panel

            $first = false;
        }

        $html .= '</div>'; // .mega-content
        $html .= '</div>'; // .mega-inner
        $html .= '</div>'; // .mega-wrapper

        return $html;
    }
}
