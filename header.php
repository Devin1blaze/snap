<!-- SNAP_VERSION_1007 -->
<?php
/**
 * Header - Efferd Header 2 Style
 * Clean, elegant responsive header with scroll-based floating card transition.
 * Logo left, nav + CTAs right. Transparent default, frosted card on scroll.
 */

function snap_stitch_render_custom_menu($context = 'desktop') {
    $locations = get_nav_menu_locations();
    if (!isset($locations['primary'])) return;
    
    $menu = wp_get_nav_menu_object($locations['primary']);
    if (!$menu) return;
    
    $menu_items = wp_get_nav_menu_items($menu->term_id);
    if (!$menu_items) return;
    
    // Group items by parent
    $child_items = [];
    foreach ($menu_items as $item) {
        if ($item->menu_item_parent) {
            // We'll skip adding static children to 'Products' below if we successfully fetch dynamic categories
            $child_items[$item->menu_item_parent][] = $item;
        }
    }

    // Dynamically inject WooCommerce product categories under the "Products" menu item
    foreach ($menu_items as $item) {
        if (stripos($item->title, 'product') !== false || stripos($item->title, 'categor') !== false) {
            if (taxonomy_exists('product_cat')) {
                // Get root-level categories (parent=0)
                $root_cats = get_terms([
                    'taxonomy' => 'product_cat',
                    'hide_empty' => false,
                    'parent' => 0,
                    'orderby' => 'name',
                    'order' => 'ASC'
                ]);
                
                if (!is_wp_error($root_cats) && !empty($root_cats)) {
                    $dynamic_children = [];
                    
                    foreach ($root_cats as $root_cat) {
                        // Skip generic/utility categories
                        if (in_array(strtolower($root_cat->name), ['uncategorized'])) continue;
                        
                        // Check if this root category is a wrapper (like "B2B Products", "B2C Products")
                        // If it has children, show those children directly in the dropdown
                        $children_of_root = get_terms([
                            'taxonomy' => 'product_cat',
                            'hide_empty' => false,
                            'parent' => $root_cat->term_id,
                            'orderby' => 'name',
                            'order' => 'ASC'
                        ]);
                        
                        if (!is_wp_error($children_of_root) && !empty($children_of_root)) {
                            // This is a wrapper category (B2B/B2C) — show it as a group header
                            // and its children as the actual dropdown items
                            foreach ($children_of_root as $child_cat) {
                                $fake_child = new stdClass();
                                $fake_child->ID = 'cat_' . $child_cat->term_id;
                                $fake_child->title = $child_cat->name;
                                $fake_child->url = get_term_link($child_cat);
                                $fake_child->menu_item_parent = $item->ID;
                                $fake_child->_group_label = $root_cat->name; // store group for reference
                                $dynamic_children[] = $fake_child;
                                
                                // Get grandchildren (sub-subcategories) for flyout
                                $grandchildren = get_terms([
                                    'taxonomy' => 'product_cat',
                                    'hide_empty' => false,
                                    'parent' => $child_cat->term_id,
                                    'orderby' => 'name',
                                    'order' => 'ASC'
                                ]);
                                
                                if (!is_wp_error($grandchildren) && !empty($grandchildren)) {
                                    $dynamic_subchildren = [];
                                    foreach ($grandchildren as $grandchild) {
                                        $fake_subchild = new stdClass();
                                        $fake_subchild->ID = 'cat_' . $grandchild->term_id;
                                        $fake_subchild->title = $grandchild->name;
                                        $fake_subchild->url = get_term_link($grandchild);
                                        $fake_subchild->menu_item_parent = $fake_child->ID;
                                        $dynamic_subchildren[] = $fake_subchild;
                                    }
                                    $child_items[$fake_child->ID] = $dynamic_subchildren;
                                }
                            }
                        } else {
                            // Leaf root category (no children) — show directly
                            $fake_child = new stdClass();
                            $fake_child->ID = 'cat_' . $root_cat->term_id;
                            $fake_child->title = $root_cat->name;
                            $fake_child->url = get_term_link($root_cat);
                            $fake_child->menu_item_parent = $item->ID;
                            $dynamic_children[] = $fake_child;
                        }
                    }
                    
                    // Replace static menu children with dynamic WooCommerce categories
                    $child_items[$item->ID] = $dynamic_children;
                }
            }
        }
    }

    if ($context === 'mobile') {
        // Mobile: vertical stack
        echo '<nav class="flex flex-col gap-1">';
        foreach ($menu_items as $item) {
            if (!$item->menu_item_parent) {
                $has_children = isset($child_items[$item->ID]);
                echo '<div class="mobile-menu-group">';
                echo '<a href="' . esc_url($item->url) . '" class="flex items-center justify-between px-4 py-3 text-[15px] font-semibold text-white/80 hover:text-white hover:bg-white/5 rounded-xl transition-all">';
                echo esc_html($item->title);
                if ($has_children) {
                    echo '<span class="material-symbols-outlined text-[18px] text-white/40 mobile-chevron transition-transform">expand_more</span>';
                }
                echo '</a>';
                
                if ($has_children) {
                    echo '<div class="mobile-submenu hidden pl-4 pb-2">';
                    foreach ($child_items[$item->ID] as $child) {
                        $has_subchildren = isset($child_items[$child->ID]);
                        echo '<a href="' . esc_url($child->url) . '" class="flex items-center justify-between px-4 py-2.5 text-[13px] font-medium text-white/50 hover:text-white hover:bg-white/5 rounded-lg transition-all">';
                        echo esc_html($child->title);
                        if ($has_subchildren) {
                            echo '<span class="material-symbols-outlined text-[14px] text-white/30">chevron_right</span>';
                        }
                        echo '</a>';
                        
                        if ($has_subchildren) {
                            echo '<div class="pl-4">';
                            foreach ($child_items[$child->ID] as $subchild) {
                                echo '<a href="' . esc_url($subchild->url) . '" class="block px-4 py-2 text-[12px] font-medium text-white/40 hover:text-white/70 rounded-lg transition-all">';
                                echo esc_html($subchild->title);
                                echo '</a>';
                            }
                            echo '</div>';
                        }
                    }
                    echo '</div>';
                }
                echo '</div>';
            }
        }
        echo '</nav>';
        return;
    }

    // Desktop: horizontal inline
    echo '<ul class="flex items-center gap-1">';
    foreach ($menu_items as $item) {
        if (!$item->menu_item_parent) {
            $has_children = isset($child_items[$item->ID]);
            echo '<li class="snap-nav-item">';
            echo '<a href="' . esc_url($item->url) . '" class="snap-nav-link">';
            echo esc_html($item->title);
            if ($has_children) {
                echo '<span class="material-symbols-outlined snap-nav-caret">expand_more</span>';
            }
            echo '</a>';

            if ($has_children) {
                // Build category data for mega-menu
                $first = true;
                echo '<div class="snap-mega-wrapper">';
                echo '<div class="snap-mega-menu">';

                // LEFT SIDEBAR
                echo '<div class="snap-mega-sidebar">';
                echo '<div class="snap-mega-sidebar-header">Categories</div>';
                echo '<ul class="snap-mega-cat-list">';
                foreach ($child_items[$item->ID] as $child) {
                    $cat_key = 'megacat-' . sanitize_html_class($child->ID);
                    $active = $first ? ' snap-mega-cat-active' : '';
                    $has_sub = isset($child_items[$child->ID]);
                    echo '<li class="snap-mega-cat-item' . $active . '" data-cat="' . esc_attr($cat_key) . '">';
                    echo '<a href="' . esc_url($child->url) . '" class="snap-mega-cat-link">';
                    echo '<span>' . esc_html($child->title) . '</span>';
                    if ($has_sub) {
                        echo '<span class="material-symbols-outlined snap-mega-cat-arrow">chevron_right</span>';
                    }
                    echo '</a>';
                    echo '</li>';
                    $first = false;
                }
                echo '</ul>';
                echo '</div>'; // end sidebar

                // RIGHT CONTENT PANEL
                echo '<div class="snap-mega-content">';
                $first = true;
                foreach ($child_items[$item->ID] as $child) {
                    $cat_key = 'megacat-' . sanitize_html_class($child->ID);
                    $active = $first ? ' snap-mega-sub-active' : '';
                    $has_sub = isset($child_items[$child->ID]);
                    echo '<div class="snap-mega-sub' . $active . '" data-for="' . esc_attr($cat_key) . '">';
                    echo '<div class="snap-mega-sub-title">' . esc_html($child->title) . '</div>';
                    if ($has_sub) {
                        echo '<div class="snap-mega-sub-grid">';
                        foreach ($child_items[$child->ID] as $subchild) {
                            echo '<a href="' . esc_url($subchild->url) . '" class="snap-mega-sub-link">';
                            echo '<span class="material-symbols-outlined snap-mega-sub-icon">arrow_forward</span>';
                            echo esc_html($subchild->title);
                            echo '</a>';
                        }
                        echo '</div>';
                    } else {
                        echo '<div class="snap-mega-sub-grid">';
                        echo '<a href="' . esc_url($child->url) . '" class="snap-mega-sub-link snap-mega-sub-link-full">';
                        echo '<span class="material-symbols-outlined snap-mega-sub-icon">open_in_new</span>';
                        echo 'Browse all ' . esc_html($child->title);
                        echo '</a>';
                        echo '</div>';
                    }
                    echo '</div>'; // end snap-mega-sub
                    $first = false;
                }
                echo '</div>'; // end snap-mega-content

                echo '</div>'; // end snap-mega-menu
                echo '</div>'; // end snap-mega-wrapper
            }
            echo '</li>';
        }
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
                        "primary": "#1A56DB",
                        "secondary": "#FBBF24",
                        "surface": "#FFFFFF",
                        "on-surface": "#0A0A0A",
                        "snap-yellow": "#FBBF24",
                        "snap-black": "#0A0A0A",
                        "primary-container": "#1A56DB",
                        "secondary-container": "#FBBF24"
                    },
                    fontFamily: {
                        "headline": ["Inter", "Plus Jakarta Sans", "sans-serif"],
                        "body": ["Inter", "Plus Jakarta Sans", "sans-serif"]
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        html, body { overflow-x: hidden; width: 100%; position: relative; }
        body { font-family: 'Inter', 'Plus Jakarta Sans', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }

        /* Industrial Glow */
        .industrial-glow:hover { box-shadow: 0 0 25px rgba(251, 191, 36, 0.4); }

        /* Header scroll */
        #nav-header { transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
        #nav-header.scrolled {
            background: rgba(10, 10, 10, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-color: rgba(255,255,255,0.08);
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        }

        /* Mobile accordion */
        .mobile-submenu { max-height: 0; overflow: hidden; transition: max-height 0.3s ease; }
        .mobile-submenu.open { max-height: 500px; }

        /* ================================================
           TOP NAV LINK STYLES
        ================================================ */
        li.snap-nav-item { position: relative; list-style: none; }

        a.snap-nav-link {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            padding: 8px 12px;
            font-size: 14px;
            font-weight: 500;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            border-radius: 8px;
            transition: color 0.15s, background 0.15s;
            white-space: nowrap;
        }
        a.snap-nav-link:hover { color: #fff; background: rgba(255,255,255,0.08); }

        .snap-nav-caret {
            font-size: 16px;
            opacity: 0.5;
            transition: transform 0.2s ease;
        }
        li.snap-nav-item:hover .snap-nav-caret { transform: rotate(180deg); }

        /* ================================================
           MEGA MENU — HAVELLS STYLE, SNAP AESTHETIC
        ================================================ */

        /* Wrapper: hidden by default, shown on hover */
        .snap-mega-wrapper {
            position: absolute;
            right: 0;
            top: 100%;
            padding-top: 10px;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transform: translateY(8px);
            transition: opacity 0.22s ease, visibility 0.22s ease, transform 0.22s ease;
        }
        li.snap-nav-item:hover > .snap-mega-wrapper {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        /* Main mega container */
        .snap-mega-menu {
            display: flex;
            width: 620px;
            min-height: 340px;
            background: rgba(8, 8, 8, 0.98);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(0,0,0,0.7), 0 0 0 1px rgba(255,255,255,0.04) inset;
        }

        /* LEFT SIDEBAR */
        .snap-mega-sidebar {
            width: 210px;
            flex-shrink: 0;
            background: rgba(255,255,255,0.02);
            border-right: 1px solid rgba(255,255,255,0.06);
            display: flex;
            flex-direction: column;
        }
        .snap-mega-sidebar-header {
            padding: 14px 16px 8px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.25);
        }
        .snap-mega-cat-list {
            list-style: none;
            margin: 0;
            padding: 0 0 12px;
            overflow-y: auto;
            flex: 1;
        }
        .snap-mega-cat-list::-webkit-scrollbar { width: 3px; }
        .snap-mega-cat-list::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 3px; }

        .snap-mega-cat-item { position: relative; }
        .snap-mega-cat-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 16px;
            font-size: 13px;
            font-weight: 500;
            color: rgba(255,255,255,0.55);
            text-decoration: none;
            transition: color 0.15s, background 0.15s;
            border-left: 2px solid transparent;
        }
        .snap-mega-cat-item:hover .snap-mega-cat-link,
        .snap-mega-cat-item.snap-mega-cat-active .snap-mega-cat-link {
            color: #fff;
            background: rgba(255,255,255,0.05);
        }
        .snap-mega-cat-item.snap-mega-cat-active .snap-mega-cat-link {
            border-left-color: #FBBF24;
            color: #fff;
        }
        .snap-mega-cat-arrow {
            font-size: 14px;
            opacity: 0.35;
            flex-shrink: 0;
        }
        .snap-mega-cat-item.snap-mega-cat-active .snap-mega-cat-arrow { opacity: 0.7; color: #FBBF24; }

        /* RIGHT CONTENT PANEL */
        .snap-mega-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            position: relative;
        }
        .snap-mega-content::-webkit-scrollbar { width: 3px; }
        .snap-mega-content::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 3px; }

        /* Sub-panel: each category's sub-items */
        .snap-mega-sub {
            display: none;
            flex-direction: column;
        }
        .snap-mega-sub.snap-mega-sub-active { display: flex; }

        .snap-mega-sub-title {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.09em;
            text-transform: uppercase;
            color: #FBBF24;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }

        /* Grid of sub-links */
        .snap-mega-sub-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2px;
        }

        .snap-mega-sub-link {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 9px 10px;
            font-size: 13px;
            font-weight: 400;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            border-radius: 8px;
            transition: color 0.15s, background 0.15s;
        }
        .snap-mega-sub-link:hover {
            color: #fff;
            background: rgba(255,255,255,0.06);
        }
        .snap-mega-sub-link-full {
            grid-column: 1 / -1;
            color: rgba(251,191,36,0.8);
        }
        .snap-mega-sub-link-full:hover { color: #FBBF24; background: rgba(251,191,36,0.06); }

        .snap-mega-sub-icon {
            font-size: 13px;
            opacity: 0.4;
            flex-shrink: 0;
        }
        .snap-mega-sub-link:hover .snap-mega-sub-icon { opacity: 0.8; }
    </style>
</head>
<body <?php body_class('bg-surface text-on-surface'); ?>>
<?php wp_body_open(); ?>

<header class="relative z-50">
  <nav id="floating-nav" class="fixed top-0 left-0 right-0 w-full z-[100] transition-all duration-300">
    <div id="nav-header" class="w-full max-w-5xl mx-auto mt-3 px-4 lg:px-5 border border-transparent rounded-xl transition-all duration-500">
      <div class="flex items-center justify-between py-3 lg:py-3.5">
        
        <!-- Logo -->
        <div class="flex items-center shrink-0">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-2.5 group">
            <span class="w-8 h-8 bg-secondary-container flex items-center justify-center rounded-lg shadow-sm group-hover:shadow-[0_0_16px_rgba(251,191,36,0.3)] transition-shadow">
              <span class="material-symbols-outlined text-black text-lg" style="font-variation-settings:'FILL' 1">bolt</span>
            </span>
            <span class="text-lg font-extrabold text-white tracking-tight">Snap <span class="text-secondary-container">Marketing</span></span>
          </a>
        </div>

        <!-- Desktop: Nav Links + Actions (right-aligned) -->
        <div class="hidden lg:flex items-center gap-2">
          <?php snap_stitch_render_custom_menu('desktop'); ?>
          
          <!-- Divider -->
          <div class="w-px h-5 bg-white/10 mx-2"></div>

          <!-- Search -->
          <button id="search-trigger" class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-white/50 hover:text-white hover:bg-white/10 transition-all cursor-pointer">
            <span class="material-symbols-outlined text-[18px]">search</span>
          </button>
          
          <!-- Sign In -->
          <a id="btn-login" href="/my-account" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white/70 hover:text-white border border-white/10 hover:border-white/20 hover:bg-white/5 rounded-lg transition-all whitespace-nowrap">Login</a>
          
          <!-- Get Quote (Primary CTA) -->
          <a id="btn-quote" href="/request-a-quote" class="inline-flex items-center px-4 py-2 text-sm font-semibold bg-secondary-container text-snap-black hover:bg-yellow-400 rounded-lg transition-all shadow-sm hover:shadow-md whitespace-nowrap">Get Quote</a>
        </div>

        <!-- Mobile: Search + Hamburger -->
        <div class="flex items-center gap-2 lg:hidden">
          <button id="search-trigger-mobile" class="p-2 text-white/60 hover:text-white transition-colors">
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
        <div class="pb-6 pt-4 border-t border-white/5 bg-[#0A0A0A]/95 backdrop-blur-xl rounded-b-xl mt-1">
          <?php snap_stitch_render_custom_menu('mobile'); ?>
          <div class="flex flex-col gap-3 mt-5 px-4">
            <a href="/my-account" class="text-center text-sm font-medium text-white/70 hover:text-white border border-white/10 py-3 rounded-xl hover:bg-white/5 transition-all">Login</a>
            <a href="/request-a-quote" class="text-center text-sm font-semibold bg-secondary-container text-snap-black py-3 rounded-xl hover:bg-yellow-400 transition-all shadow-sm">Get Quote</a>
          </div>
        </div>
      </div>
    </div>
  </nav>
</header>

<!-- Search Modal -->
<div id="search-modal" class="fixed inset-0 z-[200] hidden items-center justify-center bg-black/90 backdrop-blur-xl p-4 transition-all duration-300 opacity-0 invisible">
    <div class="w-full max-w-4xl transform scale-95 transition-all duration-300">
        <button id="search-close" class="absolute -top-12 right-0 text-white/60 hover:text-white flex items-center gap-2 text-xs font-medium tracking-widest uppercase">
            Close <span class="material-symbols-outlined text-xl">close</span>
        </button>
        <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="relative">
            <input type="text" name="s" id="search-input" placeholder="Search by brand, SKU, or category..." 
                class="w-full bg-white/5 border-b-2 border-white/20 text-white text-3xl md:text-5xl font-bold py-8 px-4 focus:outline-none focus:border-secondary-container transition-colors placeholder:text-white/10">
            <input type="hidden" name="post_type" value="product">
            <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 text-secondary-container">
                <span class="material-symbols-outlined text-5xl">arrow_forward</span>
            </button>
        </form>
        <div class="mt-12">
            <h4 class="text-white/30 text-xs font-bold uppercase tracking-[0.3em] mb-6">Trending Categories</h4>
            <div class="flex flex-wrap gap-3">
                <?php
                $pop_cats = get_terms( array('taxonomy' => 'product_cat', 'number' => 5, 'orderby' => 'count', 'order' => 'DESC') );
                if (!is_wp_error($pop_cats)) {
                    foreach ($pop_cats as $cat) {
                        echo '<a href="' . get_term_link($cat) . '" class="px-5 py-2.5 bg-white/5 border border-white/10 rounded-full text-white/60 text-sm font-medium hover:bg-secondary-container hover:text-black hover:border-transparent transition-all">'. $cat->name .'</a>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
  // Header Scroll Logic — Efferd Header 2 pattern
  const navHeader = document.getElementById('nav-header');
  const btnLogin = document.getElementById('btn-login');

  let lastScrollY = 0;
  let ticking = false;

  function updateHeader() {
    const scrollY = window.scrollY;
    
    if (scrollY > 10) {
      navHeader.classList.add('scrolled');
      navHeader.classList.remove('mt-3', 'border-transparent');
      navHeader.classList.add('mt-2', 'border-white/[0.06]');
    } else {
      navHeader.classList.remove('scrolled');
      navHeader.classList.add('mt-3', 'border-transparent');
      navHeader.classList.remove('mt-2', 'border-white/[0.06]');
    }
    
    ticking = false;
  }

  window.addEventListener('scroll', function() {
    lastScrollY = window.scrollY;
    if (!ticking) {
      window.requestAnimationFrame(updateHeader);
      ticking = true;
    }
  });

  // Mobile Menu Toggle
  const navToggle = document.getElementById('nav-toggle');
  const mobileMenu = document.getElementById('mobile-menu');
  
  navToggle.addEventListener('click', function() {
    this.classList.toggle('open');
    mobileMenu.classList.toggle('hidden');
    // Add dark bg to header when mobile menu is open
    if (!mobileMenu.classList.contains('hidden')) {
      navHeader.style.background = 'rgba(10, 10, 10, 0.95)';
      navHeader.style.backdropFilter = 'blur(20px)';
    } else if (window.scrollY <= 10) {
      navHeader.style.background = '';
      navHeader.style.backdropFilter = '';
    }
  });

  // Mobile Accordion Submenus
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

  // Search Modal Logic
  const searchTrigger = document.getElementById('search-trigger');
  const searchTriggerMobile = document.getElementById('search-trigger-mobile');
  const searchModal = document.getElementById('search-modal');
  const searchClose = document.getElementById('search-close');
  const searchInput = document.getElementById('search-input');

  const openSearch = () => {
      searchModal.classList.remove('hidden', 'opacity-0', 'invisible');
      searchModal.classList.add('flex', 'opacity-100', 'visible');
      searchModal.querySelector('div').classList.remove('scale-95');
      searchModal.querySelector('div').classList.add('scale-100');
      setTimeout(() => searchInput.focus(), 300);
      document.body.style.overflow = 'hidden';
  };

  if (searchTrigger) searchTrigger.addEventListener('click', openSearch);
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
  searchModal.addEventListener('click', (e) => {
      if (e.target === searchModal) closeSearch();
  });
  window.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeSearch();
  });
  // =============================================
  // MEGA MENU — Sidebar Hover Interaction
  // =============================================
  document.querySelectorAll('.snap-mega-cat-item').forEach(function(catItem) {
    catItem.addEventListener('mouseenter', function() {
      var menu = this.closest('.snap-mega-menu');
      if (!menu) return;
      var catKey = this.getAttribute('data-cat');

      // Deactivate all sidebar items
      menu.querySelectorAll('.snap-mega-cat-item').forEach(function(el) {
        el.classList.remove('snap-mega-cat-active');
      });
      // Deactivate all right panels
      menu.querySelectorAll('.snap-mega-sub').forEach(function(el) {
        el.classList.remove('snap-mega-sub-active');
      });

      // Activate hovered sidebar item
      this.classList.add('snap-mega-cat-active');

      // Show matching right panel
      var sub = menu.querySelector('.snap-mega-sub[data-for="' + catKey + '"]');
      if (sub) sub.classList.add('snap-mega-sub-active');
    });
  });

  // Prevent mega-menu closing when moving from sidebar to content
  document.querySelectorAll('.snap-mega-menu').forEach(function(menu) {
    menu.addEventListener('mouseleave', function() {
      // Reset to first active on leave (optional, keeps state clean)
      var firstCat = menu.querySelector('.snap-mega-cat-item');
      var firstSub = menu.querySelector('.snap-mega-sub');
      if (firstCat && firstSub) {
        menu.querySelectorAll('.snap-mega-cat-item').forEach(function(el) { el.classList.remove('snap-mega-cat-active'); });
        menu.querySelectorAll('.snap-mega-sub').forEach(function(el) { el.classList.remove('snap-mega-sub-active'); });
        firstCat.classList.add('snap-mega-cat-active');
        firstSub.classList.add('snap-mega-sub-active');
      }
    });
  });
</script>
</body>
</html>