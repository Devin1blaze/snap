<?php
/**
 * The header for our theme
 */

// Include the custom walker
require_once get_template_directory() . '/class-tailwind-nav-walker.php';

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
                        "on-surface-variant": "#52525b",
                        "royal-blue": "#1A56DB",
                        "snap-yellow": "#FBBF24",
                        "snap-black": "#0A0A0A",
                        "primary-container": "#1A56DB",
                        "secondary-container": "#FBBF24",
                        "surface-container-low": "#F4F4F5",
                        "deepskyblue": "#00aeef",
                        "whitesmoke": "#f5f5f5",
                        "dimgray": "#6b7280",
                        "gray": "#1f2937"
                    },
                    fontFamily: {
                        "headline": ["Inter", "Plus Jakarta Sans", "sans-serif"],
                        "body": ["Inter", "Plus Jakarta Sans", "sans-serif"],
                        "label": ["Inter", "Plus Jakarta Sans", "sans-serif"],
                        "poppins": ["Poppins", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "full": "0.75rem"}
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        html { margin-top: 0 !important; }
        html, body {
            overflow-x: hidden;
            width: 100%;
            position: relative;
        }
        body { font-family: 'Inter', 'Plus Jakarta Sans', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .diagonal-band {
            clip-path: polygon(25% 0%, 100% 0%, 75% 100%, 0% 100%);
        }
        .industrial-glow {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .industrial-glow:hover {
            transform: translateY(-4px);
            box-shadow: 0 0 25px rgba(251, 191, 36, 0.4);
        }
        .yellow-underline {
            position: relative;
            display: inline-block;
        }
        .yellow-underline::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 4px;
            width: 100%; height: 12px;
            background-color: #FBBF24;
            z-index: -1; transform: skewX(-15deg);
            animation: growLine 0.6s ease-out forwards;
        }
        @keyframes growLine {
            from { width: 0; } to { width: 100%; }
        }

        /* Blueprint pattern used in industrial sections */
        .blueprint-pattern {
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.05) 1.5px, transparent 1.5px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.05) 1.5px, transparent 1.5px);
            background-size: 20px 20px;
        }

        /* Nav link underline animation */
        .nav-link { position:relative; }
        .nav-link::after { content:''; position:absolute; left:0; bottom:-4px; width:0; height:2px; background:#FBBF24; transition:width 0.25s ease; }
        .nav-link:hover::after { width:100%; }

        /* ── MOBILE ACCORDION ────────────────────────────────────── */
        .mobile-acc-content {
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.32s cubic-bezier(0.4, 0, 0.2, 1);
            display: block !important; /* max-height controls visibility, not display */
        }
        .mobile-acc-content.is-open {
            max-height: 1200px; /* large enough for any sub-list */
        }
        .mobile-acc-caret {
            transition: transform 0.28s ease;
            flex-shrink: 0;
        }
        .mobile-acc-toggle[aria-expanded="true"] .mobile-acc-caret {
            transform: rotate(180deg);
        }
        /* L3 accordion inside L2 */
        .mobile-l3-acc-content {
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.28s cubic-bezier(0.4, 0, 0.2, 1);
            display: block !important;
        }
        .mobile-l3-acc-content.is-open {
            max-height: 1000px;
        }
        .mobile-l3-caret {
            transition: transform 0.25s ease;
            flex-shrink: 0;
        }
        .mobile-l3-toggle[aria-expanded="true"] .mobile-l3-caret {
            transform: rotate(180deg);
        }
        /* L2 accordion inside L1 */
        .mobile-l2-acc-content {
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.28s cubic-bezier(0.4, 0, 0.2, 1);
            display: block !important;
        }
        .mobile-l2-acc-content.is-open {
            max-height: 800px;
        }
        .mobile-l2-caret {
            transition: transform 0.25s ease;
            flex-shrink: 0;
        }
        .mobile-l2-toggle[aria-expanded="true"] .mobile-l2-caret {
            transform: rotate(180deg);
        }

        /* Marquee keyframes */
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee { display: flex; width: 200%; animation: marquee 30s linear infinite; }
        .animate-marquee:hover { animation-play-state: paused; }
        @keyframes marquee-up {
            0% { transform: translateY(0); }
            100% { transform: translateY(-50%); }
        }
        @keyframes marquee-down {
            0% { transform: translateY(-50%); }
            100% { transform: translateY(0); }
        }
        .animate-marquee-vertical { animation: marquee-up 18s linear infinite; }
        .animate-marquee-vertical-reverse { animation: marquee-down 18s linear infinite; }
        .marquee-col:hover .animate-marquee-vertical,
        .marquee-col:hover .animate-marquee-vertical-reverse { animation-play-state: paused; }

        /* Scroll reveal */
        .reveal { opacity: 0; transform: translateY(28px); transition: opacity 0.7s ease, transform 0.7s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        /* Unified Hover Animation System */
        .brand-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .brand-card:hover { transform: scale(1.08); box-shadow: 0 8px 32px rgba(26,86,219,0.15); background-color: #f9fafb; }
        .why-icon-box { transition: background 0.2s cubic-bezier(0.4, 0, 0.2, 1); }
        .why-icon-box:hover { background: rgba(26,86,219,0.15); }

        /* ── MEGA MENU: NAV BAR ───────────────────────────────── */
        #snap-main-nav {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            gap: 0;
        }
        .mega-nav-item,
        .mega-nav-item-simple {
            position: static;
            list-style: none;
        }
        a.mega-top-link {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            padding: 24px 16px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 12px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.70);
            text-decoration: none;
            transition: color 0.2s ease;
            white-space: nowrap;
        }
        a.mega-top-link:hover { color: #FBBF24; }
        .mega-caret {
            font-size: 16px;
            opacity: 0.55;
            transition: transform 0.22s ease;
        }
        .mega-nav-item:hover > a.mega-top-link { color: #FBBF24; }
        .mega-nav-item:hover .mega-caret { transform: rotate(180deg); color: #FBBF24; }

        /* ── MEGA WRAPPER (full-width dropdown) ──────────────── */
        .mega-wrapper {
            position: fixed;
            left: 0;
            right: 0;
            top: var(--nav-bottom, 72px);
            margin-top: 12px;
            z-index: 999;
            visibility: hidden;
            opacity: 0;
            transform: translateY(6px);
            transition: opacity 0.22s ease, visibility 0.22s ease, transform 0.22s ease;
            pointer-events: none;
        }
        /* Invisible bridge to prevent hover loss when moving mouse to dropdown */
        .mega-wrapper::before {
            content: '';
            position: absolute;
            top: -40px;
            left: 0;
            right: 0;
            height: 40px;
            background: transparent;
        }
        .mega-nav-item:hover > .mega-wrapper {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            pointer-events: auto;
        }
        .mega-inner {
            max-width: 1280px;
            margin: 0 auto;
            background: #111111;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 24px;
            box-shadow: 0 32px 64px rgba(0,0,0,0.55);
            display: flex;
            min-height: 340px;
            overflow: hidden;
        }

        /* ── LEFT SIDEBAR ─────────────────────────────────────── */
        .mega-sidebar {
            width: 240px;
            flex-shrink: 0;
            background: #0A0A0A;
            border-right: 1px solid rgba(255,255,255,0.06);
            padding: 24px 0;
        }
        .mega-sidebar-header {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.25);
            padding: 0 20px 12px;
        }
        .mega-cat-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .mega-cat-item { list-style: none; }
        a.mega-cat-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 20px;
            text-decoration: none;
            color: rgba(255,255,255,0.55);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 600;
            border-left: 2px solid transparent;
            transition: all 0.18s ease;
        }
        .mega-cat-link:hover,
        .mega-cat-item.mega-cat-active > a.mega-cat-link {
            color: #fff;
            background: rgba(255,255,255,0.05);
            border-left-color: #FBBF24;
        }
        .mega-cat-icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: rgba(251,191,36,0.12);
            color: #FBBF24;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 13px;
            flex-shrink: 0;
        }
        .mega-cat-name { flex: 1; }
        .mega-cat-arrow { font-size: 14px; color: rgba(255,255,255,0.25); }

        /* ── RIGHT CONTENT PANEL ─────────────────────────────── */
        .mega-content {
            flex: 1;
            padding: 28px 32px;
            overflow-y: auto;
        }
        .mega-panel { display: none; }
        .mega-panel.mega-panel-active { display: block; }
        .mega-panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 14px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .mega-panel-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 17px;
            font-weight: 800;
            color: #fff;
            letter-spacing: 0.01em;
        }
        a.mega-panel-view-all {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 12px;
            font-weight: 700;
            color: #FBBF24;
            text-decoration: none;
            letter-spacing: 0.05em;
            opacity: 0.85;
            transition: opacity 0.15s;
        }
        a.mega-panel-view-all:hover { opacity: 1; }
        .mega-panel-grid {
            column-count: 4;
            column-gap: 16px;
        }
        .mega-sub-container {
            display: flex;
            flex-direction: column;
            break-inside: avoid;
            margin-bottom: 2px;
        }
        .mega-sub-caret {
            margin-left: auto;
            font-size: 16px;
            opacity: 0.5;
            transition: transform 0.2s;
        }
        .mega-sub-link.is-open .mega-sub-caret {
            transform: rotate(180deg);
        }
        .mega-accordion-content {
            display: grid;
            grid-template-rows: 0fr;
            transition: grid-template-rows 0.3s ease;
            overflow: hidden;
        }
        .mega-accordion-content.is-open {
            grid-template-rows: 1fr;
        }
        .mega-accordion-inner {
            min-height: 0;
            padding-left: 20px;
            padding-bottom: 8px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        a.mega-product-link {
            font-size: 12px;
            color: rgba(255,255,255,0.4);
            text-decoration: none;
            padding: 4px 0;
            transition: color 0.15s;
        }
        a.mega-product-link:hover {
            color: rgba(255,255,255,0.8);
        }
        .mega-loading {
            font-size: 11px;
            color: rgba(255,255,255,0.3);
            font-style: italic;
            padding: 4px 0;
        }
        a.mega-sub-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            border-radius: 99px;
            text-decoration: none;
            color: rgba(255,255,255,0.55);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.15s ease;
        }
        a.mega-sub-link:hover {
            color: #fff;
            background: rgba(255,255,255,0.06);
        }
        .mega-sub-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: rgba(251,191,36,0.5);
            flex-shrink: 0;
        }
        a.mega-sub-link:hover .mega-sub-dot { background: #FBBF24; }
        a.mega-sub-link-browse {
            grid-column: 1 / -1;
            font-style: italic;
            color: rgba(255,255,255,0.4);
        }
    </style>
</head>
<body <?php body_class('bg-surface text-on-surface'); ?>>
<?php wp_body_open(); ?>

<!-- Section: Floating Navigation Wrapper -->
<header class="relative z-50">
  <nav id="floating-nav" class="fixed top-0 left-0 w-full z-[100] px-4 pointer-events-none transition-all duration-300">
    <div id="nav-island" class="mx-auto mt-4 max-w-screen-xl px-6 transition-all duration-500 lg:px-12 bg-black/40 border border-white/5 backdrop-blur-md rounded-2xl pointer-events-auto shadow-2xl">
      <div class="relative flex flex-wrap items-center justify-between py-3 lg:py-4">
        
        <!-- Logo -->
        <div class="flex items-center relative z-20 shrink-0">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-3">
            <span class="w-9 h-9 bg-secondary-container flex items-center justify-center rounded-lg shadow-inner">
              <span class="material-symbols-outlined text-black text-xl" style="font-variation-settings:'FILL' 1">bolt</span>
            </span>
            <span class="text-xl font-black text-white tracking-tight">Snap <span class="text-secondary-container italic">Marketing</span></span>
          </a>
        </div>

        <!-- Desktop Menu -->
        <div class="hidden lg:flex flex-1 items-center justify-center relative z-20 mx-4" id="snap-nav-container">
            <?php
            wp_nav_menu( array(
                'theme_location'  => 'primary',
                'container'       => false,
                'menu_id'         => 'snap-main-nav',
                'menu_class'      => '',
                'walker'          => new Tailwind_Nav_Walker(),
                'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                'depth'           => 3,
                'fallback_cb'     => false,
            ) );
            ?>
        </div>

        <!-- Right Side: Search, Buttons & Hamburger -->
        <div class="flex items-center gap-4 relative z-20">
          
          <!-- Search Catalog Button -->
          <button id="search-trigger" class="hidden lg:flex items-center justify-center p-2 text-white/80 hover:text-white transition-colors" aria-label="Search">
            <span class="material-symbols-outlined">search</span>
          </button>

          <!-- NEW CART BUTTON DESKTOP -->
          <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="hidden lg:flex items-center relative text-white/80 hover:text-white transition-colors" title="View your shopping cart">
            <span class="material-symbols-outlined text-xl">shopping_cart</span>
            <span class="snap-cart-count absolute -top-2 -right-2 bg-secondary-container text-black text-[10px] font-black w-4 h-4 flex items-center justify-center rounded-full">
                <?php echo WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?>
            </span>
          </a>
          <!-- Button Container (Visible on Desktop) -->
          <div class="hidden lg:flex items-center gap-3">
            <?php if ( is_user_logged_in() ) : 
                $current_user = wp_get_current_user();
                $first_name = $current_user->user_firstname ? $current_user->user_firstname : 'Account';
            ?>
                <!-- Hover Dropdown for Logged In User -->
                <div class="relative group">
                    <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'dashboard' ) ); ?>" class="flex items-center gap-2 text-white/80 hover:text-white font-bold text-xs uppercase tracking-widest px-5 py-2 border border-white/10 rounded-xl hover:bg-white/5 transition-all duration-300">
                        <span class="material-symbols-outlined text-[16px]">person</span> 
                        Hi, <?php echo esc_html( $first_name ); ?>
                        <span class="material-symbols-outlined text-[14px] opacity-50 group-hover:rotate-180 transition-transform">expand_more</span>
                    </a>
                    
                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 top-full mt-2 w-48 bg-black/90 backdrop-blur-md border border-white/10 rounded-xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform translate-y-2 group-hover:translate-y-0 overflow-hidden">
                        <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'orders' ) ); ?>" class="block px-5 py-3 text-white/70 hover:text-[#FBBF24] hover:bg-white/5 text-xs font-bold tracking-widest uppercase transition-colors">Orders</a>
                        <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'edit-address' ) ); ?>" class="block px-5 py-3 text-white/70 hover:text-[#FBBF24] hover:bg-white/5 text-xs font-bold tracking-widest uppercase transition-colors">Addresses</a>
                        <div class="border-t border-white/10 my-1"></div>
                        <a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>" class="block px-5 py-3 text-white/70 hover:text-red-400 hover:bg-white/5 text-xs font-bold tracking-widest uppercase transition-colors">Logout</a>
                    </div>
                </div>
            <?php else : ?>
                <!-- Login/Signup for Logged Out User -->
                <a id="btn-login" href="/login" class="text-white/80 hover:text-white font-bold text-xs uppercase tracking-widest px-5 py-2 border border-white/10 rounded-xl hover:bg-white/5 transition-all duration-300">Login</a>
                <a id="btn-signup" href="/register" class="bg-secondary-container text-black font-black text-xs uppercase tracking-widest px-5 py-2 rounded-xl hover:bg-yellow-400 transition-all duration-300 shadow-xl">Sign Up</a>
            <?php endif; ?>

            <!-- Corporate / Consumer Toggle -->
            <?php if ( is_page('consumer') ) : ?>
                <a href="/" class="text-[#FBBF24] hover:text-white font-bold text-xs uppercase tracking-widest px-4 py-2 border border-[#FBBF24]/30 rounded-xl hover:bg-[#FBBF24]/10 transition-all duration-300 js-select-business" title="Switch to Corporate Site"><span class="material-symbols-outlined text-[14px] align-middle mr-1">domain</span>Corporate</a>
            <?php else : ?>
                <a href="/consumer/" class="text-[#1A56DB] hover:text-white font-bold text-xs uppercase tracking-widest px-4 py-2 border border-[#1A56DB]/30 rounded-xl hover:bg-[#1A56DB]/10 transition-all duration-300 js-select-consumer" title="Switch to Consumer Site"><span class="material-symbols-outlined text-[14px] align-middle mr-1">shopping_cart</span>Consumer</a>
            <?php endif; ?>
            
            <!-- Get Started: Visible ONLY when scrolled -->
            <a id="btn-scrolled-cta" href="/request-a-quote" class="hidden items-center gap-2 bg-secondary-container text-black font-black text-xs uppercase px-6 py-2 rounded-xl tracking-widest hover:bg-yellow-400 hover:-translate-y-1 hover:shadow-lg active:scale-95 transition-all duration-500 border border-black/10">
              Get Quote
              <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
            </a>
          </div>

          <!-- Mobile Search Icon -->
          <button id="search-trigger-mobile" class="lg:hidden flex items-center justify-center p-2 text-white/80 hover:text-white transition-colors" aria-label="Search">
            <span class="material-symbols-outlined">search</span>
          </button>

          <!-- NEW CART BUTTON MOBILE -->
          <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="lg:hidden flex items-center relative p-2 text-white/80 hover:text-white transition-colors" title="View your shopping cart">
            <span class="material-symbols-outlined text-xl">shopping_cart</span>
            <span class="snap-cart-count absolute top-0 right-0 bg-secondary-container text-black text-[10px] font-black w-4 h-4 flex items-center justify-center rounded-full">
                <?php echo WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?>
            </span>
          </a>

          <!-- Hamburger -->
          <button id="nav-toggle" class="lg:hidden flex flex-col gap-1.5 p-2 group" aria-label="Toggle menu">
            <span class="block w-6 h-0.5 bg-white transition-all duration-300 group-[.open]:rotate-45 group-[.open]:translate-y-2"></span>
            <span class="block w-6 h-0.5 bg-white transition-all duration-300 group-[.open]:opacity-0"></span>
            <span class="block w-6 h-0.5 bg-white transition-all duration-300 group-[.open]:-rotate-45 group-[.open]:-translate-y-2"></span>
          </button>
        </div>

        <!-- Mobile Drawer -->
        <div id="mobile-menu" class="w-full flex-col border border-white/10 p-5 rounded-3xl mt-4 gap-4 lg:hidden absolute top-full left-0 z-50 max-h-[85vh] overflow-y-auto overscroll-contain custom-scrollbar" style="background: rgba(10,10,10,0.98); backdrop-filter: blur(24px); box-shadow: 0 32px 64px -12px rgba(0,0,0,0.8); display: none;">

          <!-- Mobile Action Buttons (Inside Hamburger) -->
          <div class="w-full flex flex-col gap-3 pb-4 mb-2 border-b border-white/10">
              <div class="w-full flex items-center justify-between gap-3">
                  <?php if ( is_user_logged_in() ) : ?>
                      <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'dashboard' ) ); ?>" class="flex flex-col items-center justify-center flex-1 text-center text-white/80 hover:text-white font-bold text-[10px] uppercase tracking-widest border border-white/15 py-1.5 rounded-xl hover:bg-white/5 transition-all">
                          <span class="material-symbols-outlined text-[16px] mb-0.5">person</span> Account
                      </a>
                      <a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>" class="flex flex-col items-center justify-center flex-1 text-center text-white/80 hover:text-red-400 font-bold text-[10px] uppercase tracking-widest border border-white/15 py-1.5 rounded-xl hover:bg-white/5 transition-all">
                          <span class="material-symbols-outlined text-[16px] mb-0.5">logout</span> Logout
                      </a>
                  <?php else : ?>
                      <a href="/login" class="flex-1 text-center text-white/80 hover:text-white font-bold text-xs uppercase tracking-widest border border-white/15 py-2.5 rounded-xl hover:bg-white/5 transition-all">Login</a>
                      <a href="/request-a-quote" class="flex-1 flex items-center justify-center gap-2 bg-secondary-container text-black font-black text-xs uppercase px-4 py-2.5 tracking-widest rounded-xl shadow-xl active:scale-95 transition-all">Get Quote</a>
                  <?php endif; ?>
              </div>
              
              <!-- Corporate / Consumer Toggle Mobile -->
              <div class="w-full flex justify-center">
                  <?php if ( is_page('consumer') ) : ?>
                      <a href="/" class="w-full flex items-center justify-center text-[#FBBF24] hover:text-white font-bold text-xs uppercase tracking-widest px-4 py-2 border border-[#FBBF24]/30 rounded-xl hover:bg-[#FBBF24]/10 transition-all duration-300 js-select-business" title="Switch to Corporate Site"><span class="material-symbols-outlined text-[14px] align-middle mr-1">domain</span>Switch to Corporate</a>
                  <?php else : ?>
                      <a href="/consumer/" class="w-full flex items-center justify-center text-[#1A56DB] hover:text-white font-bold text-xs uppercase tracking-widest px-4 py-2 border border-[#1A56DB]/30 rounded-xl hover:bg-[#1A56DB]/10 transition-all duration-300 js-select-consumer" title="Switch to Consumer Site"><span class="material-symbols-outlined text-[14px] align-middle mr-1">shopping_cart</span>Switch to Consumer</a>
                  <?php endif; ?>
              </div>
          </div>


          <?php
          // ── 3-Level Mobile Nav: reads from WordPress Primary Menu ──
          $locations     = get_nav_menu_locations();
          $menu_obj      = isset( $locations['primary'] ) ? wp_get_nav_menu_object( $locations['primary'] ) : null;

          if ( $menu_obj ) {
              $all_items = wp_get_nav_menu_items( $menu_obj->term_id );

              // Build a parent→children map
              $by_parent = [];
              foreach ( $all_items as $mi ) {
                  $by_parent[ (int) $mi->menu_item_parent ][] = $mi;
              }

              // ── Render one level ──────────────────────────────────
              // $level: 1=L1, 2=L2, 3=L3
              $render_level = function( $parent_id, $level ) use ( &$render_level, &$by_parent ) {
                  if ( empty( $by_parent[ $parent_id ] ) ) return;

                  foreach ( $by_parent[ $parent_id ] as $mi ) {
                      $has_children = ! empty( $by_parent[ $mi->ID ] );
                      $url          = esc_url( $mi->url );
                      $title        = esc_html( $mi->title );

                      if ( $level === 1 ) {
                          // ── L1 item ──────────────────────────────
                          if ( $has_children ) {
                              echo '<div class="mobile-accordion">';
                              echo '<button class="mobile-acc-toggle w-full flex items-center justify-between py-4 text-white/70 hover:text-white font-bold text-sm uppercase tracking-widest transition-colors border-b border-white/8" aria-expanded="false" style="background:none; border-left:none; border-right:none; border-top:none; cursor:pointer;">';
                              echo '<span>' . $title . '</span>';
                              echo '<span class="material-symbols-outlined mobile-acc-caret" style="font-size:18px">expand_more</span>';
                              echo '</button>';
                              echo '<div class="mobile-acc-content pl-2">';
                              $render_level( $mi->ID, 2 );
                              echo '</div>';
                              echo '</div>';
                          } else {
                              echo '<a href="' . $url . '" class="block py-4 border-b border-white/8 text-white/70 hover:text-white font-bold text-sm uppercase tracking-widest transition-colors">' . $title . '</a>';
                          }

                      } elseif ( $level === 2 ) {
                          // ── L2 item ──────────────────────────────
                          if ( $has_children ) {
                              echo '<div class="mobile-l2-accordion mt-1">';
                              echo '<button class="mobile-l2-toggle w-full flex items-center justify-between py-2.5 pl-3 pr-1 text-white/55 hover:text-white/90 font-semibold text-xs uppercase tracking-wider rounded-lg hover:bg-white/5 transition-all" aria-expanded="false" style="background:none; border:none; cursor:pointer;">';
                              echo '<span>' . $title . '</span>';
                              echo '<span class="material-symbols-outlined mobile-l2-caret" style="font-size:16px">expand_more</span>';
                              echo '</button>';
                              echo '<div class="mobile-l2-acc-content pl-4">';
                              // Add a link to the main category archive
                              echo '<a href="' . $url . '" class="block py-2.5 pl-2 text-white/40 hover:text-white/90 text-xs font-semibold uppercase tracking-wider rounded-lg hover:bg-white/5 transition-all mb-1 border-b border-white/5 border-dashed"><span class="material-symbols-outlined text-[14px] align-middle mr-1">grid_view</span> Show Products</a>';
                              $render_level( $mi->ID, 3 );
                              echo '</div>';
                              echo '</div>';
                          } else {
                              echo '<a href="' . $url . '" class="block py-2.5 pl-3 text-white/55 hover:text-white/90 text-xs font-semibold uppercase tracking-wider rounded-lg hover:bg-white/5 transition-all">' . $title . '</a>';
                          }

                      } elseif ( $level === 3 ) {
                          // ── L3 item (AJAX Accordion) ─────────────
                          $cat_id = $mi->object_id;
                          echo '<div class="mobile-l3-accordion mt-1">';
                          echo '<button class="mobile-l3-toggle w-full flex items-center justify-between py-2 pl-2 text-white/40 hover:text-yellow-400 text-xs font-medium tracking-wide rounded hover:bg-white/3 transition-all js-mobile-product-toggle" data-cat="' . $cat_id . '" aria-expanded="false" style="background:none; border:none; cursor:pointer;">';
                          echo '<div class="flex items-center gap-2">';
                          echo '<span style="width:4px; height:4px; background: rgba(251,191,36,0.5); border-radius:50%; flex-shrink:0; display:inline-block;"></span>';
                          echo '<span>' . $title . '</span>';
                          echo '</div>';
                          echo '<span class="material-symbols-outlined mobile-l3-caret" style="font-size:14px">expand_more</span>';
                          echo '</button>';
                          echo '<div class="mobile-l3-acc-content pl-6 mt-1 flex-col gap-2"></div>';
                          echo '</div>';
                      }
                  }
              };

              // Render from root (parent_id = 0)
              $render_level( 0, 1 );
          }
          ?>
        </div>
      </div>
    </div>
  </nav>
</header>

<script>
  const navIsland = document.getElementById('nav-island');
  const btnLogin = document.getElementById('btn-login');
  const btnSignup = document.getElementById('btn-signup');
  const btnScrolledCta = document.getElementById('btn-scrolled-cta');

  window.addEventListener('scroll', function() {
    if (window.scrollY > 50) {
        navIsland.classList.remove('max-w-screen-xl', 'mt-4', 'lg:px-12', 'bg-black/40', 'border-white/5', 'rounded-2xl', 'rounded-none');
        navIsland.classList.add('max-w-6xl', 'mt-2', 'lg:px-10', 'bg-black/80', 'backdrop-blur-xl', 'border-white/15', 'shadow-[0_20px_50px_rgba(0,0,0,0.5)]', 'rounded-full');
        btnLogin.classList.add('lg:hidden');
        btnSignup.classList.add('lg:hidden');
        btnScrolledCta.classList.remove('hidden');
        btnScrolledCta.classList.add('flex');
    } else {
        navIsland.classList.add('max-w-screen-xl', 'mt-4', 'lg:px-12', 'bg-black/40', 'border-white/5', 'rounded-2xl');
        navIsland.classList.remove('max-w-6xl', 'mt-2', 'lg:px-10', 'bg-black/80', 'backdrop-blur-xl', 'border-white/15', 'shadow-[0_20px_50px_rgba(0,0,0,0.5)]', 'rounded-full', 'rounded-none');
        btnLogin.classList.remove('lg:hidden');
        btnSignup.classList.remove('lg:hidden');
        btnScrolledCta.classList.add('hidden');
        btnScrolledCta.classList.remove('flex');
    }
  });

  const navToggle = document.getElementById('nav-toggle');
  const mobileMenu = document.getElementById('mobile-menu');
  navToggle.addEventListener('click', function() {
    this.classList.toggle('open');
    const isHidden = mobileMenu.style.display === 'none' || mobileMenu.style.display === '';
    mobileMenu.style.display = isHidden ? 'flex' : 'none';
    mobileMenu.style.flexDirection = 'column';
  });

  // ── Mobile Accordion (L1) ────────────────────────────────────
  document.addEventListener('click', function(e) {
    const l1Btn = e.target.closest('.mobile-acc-toggle');
    if (l1Btn) {
      const content = l1Btn.nextElementSibling;
      const isOpen  = content.classList.contains('is-open');
      content.classList.toggle('is-open', !isOpen);
      l1Btn.setAttribute('aria-expanded', String(!isOpen));
      return;
    }

    // ── Mobile Accordion (L2) ──────────────────────────────────
    const l2Btn = e.target.closest('.mobile-l2-toggle');
    if (l2Btn) {
      const content = l2Btn.nextElementSibling;
      const isOpen  = content.classList.contains('is-open');
      content.classList.toggle('is-open', !isOpen);
      l2Btn.setAttribute('aria-expanded', String(!isOpen));
      return;
    }

    // ── Mobile Accordion (L3 / Products AJAX) ──────────────────
    const l3Btn = e.target.closest('.js-mobile-product-toggle');
    if (l3Btn) {
      const content = l3Btn.nextElementSibling;
      const isOpen  = content.classList.contains('is-open');
      content.classList.toggle('is-open', !isOpen);
      l3Btn.setAttribute('aria-expanded', String(!isOpen));

      if (!isOpen && !content.hasAttribute('data-loaded')) {
          content.innerHTML = '<div style="color:rgba(255,255,255,0.5); font-size:11px; padding:8px 0;">Loading products...</div>';
          content.setAttribute('data-loaded', 'true');
          
          let fd = new URLSearchParams();
          fd.append('action', 'snap_get_menu_products');
          fd.append('cat_id', l3Btn.dataset.cat);

          fetch(snap_ajax_obj.ajax_url, {
              method: 'POST',
              body: fd
          }).then(r => r.json()).then(res => {
              if (res.success && res.data.products && res.data.products.length > 0) {
                  let html = '';
                  res.data.products.forEach(p => {
                      html += '<a href="'+p.url+'" class="block py-1.5 text-white/50 hover:text-white text-[11px] font-semibold uppercase tracking-wider transition-colors">'+p.title+'</a>';
                  });
                  if(res.data.view_all) {
                      html += '<a href="'+res.data.view_all+'" class="block py-1.5 text-[#FBBF24] hover:text-white text-[11px] font-bold italic uppercase tracking-wider mt-1">View all products &rarr;</a>';
                  }
                  content.innerHTML = html;
              } else {
                  content.innerHTML = '<div style="color:#ef4444; font-size:11px; padding:4px 0;">No products found.</div>';
              }
          }).catch(err => {
              content.innerHTML = '<div style="color:#ef4444; font-size:11px; padding:4px 0;">Failed to load.</div>';
          });
      }
    }
  });

  // ── MEGA MENU: dynamic positioning + panel switching ──────────
  (function() {
    function updateNavBottom() {
      const nav = document.getElementById('floating-nav');
      if (!nav) return;
      document.documentElement.style.setProperty('--nav-bottom', nav.getBoundingClientRect().bottom + 'px');
    }
    updateNavBottom();
    window.addEventListener('scroll', updateNavBottom, { passive: true });
    window.addEventListener('resize', updateNavBottom, { passive: true });

    // Sidebar hover → switch right panel
      document.querySelectorAll('.mega-cat-item').forEach(function(catItem) {
        catItem.addEventListener('mouseenter', function() {
          const panelId = this.dataset.panel;
          const wrapper = this.closest('.mega-wrapper');
          if (!wrapper || !panelId) return;
          wrapper.querySelectorAll('.mega-cat-item').forEach(function(el) { el.classList.remove('mega-cat-active'); });
          this.classList.add('mega-cat-active');
          wrapper.querySelectorAll('.mega-panel').forEach(function(el) { el.classList.remove('mega-panel-active'); });
          const target = wrapper.querySelector('#' + panelId);
          if (target) target.classList.add('mega-panel-active');
        });
      });

      // AJAX Mega Menu Accordion
      document.querySelectorAll('.js-mega-accordion-trigger').forEach(function(link) {
        link.addEventListener('click', function(e) {
          const catId = this.dataset.catId;
          if (!catId) return; // normal navigation
          
          const content = document.getElementById('mega-acc-' + catId);
          if (!content) return;
          
          e.preventDefault();
          
          const isOpen = content.classList.contains('is-open');
          
          // Close others in same panel
          const wrapper = this.closest('.mega-panel-grid');
          if (wrapper) {
              wrapper.querySelectorAll('.mega-accordion-content.is-open').forEach(el => {
                  if(el !== content) el.classList.remove('is-open');
              });
              wrapper.querySelectorAll('.js-mega-accordion-trigger.is-open').forEach(el => {
                  if(el !== this) el.classList.remove('is-open');
              });
          }
          
          if (isOpen) {
              content.classList.remove('is-open');
              this.classList.remove('is-open');
              return;
          }
          
          content.classList.add('is-open');
          this.classList.add('is-open');
          
          if (!content.dataset.loaded) {
              content.dataset.loaded = 'true';
              const inner = content.querySelector('.mega-accordion-inner');
              
              const fd = new FormData();
              fd.append('action', 'snap_get_menu_products');
              fd.append('cat_id', catId);
              
              // use global ajaxurl if available, fallback to /wp-admin/admin-ajax.php
              const ajaxUrl = (typeof ajaxurl !== 'undefined') ? ajaxurl : '/wp-admin/admin-ajax.php';
              
              fetch(ajaxUrl, {
                  method: 'POST',
                  body: fd
              }).then(r => r.json()).then(res => {
                  if (res.success && res.data.products && res.data.products.length > 0) {
                      let html = '';
                      res.data.products.forEach(p => {
                          html += '<a href="'+p.url+'" class="mega-product-link">'+p.title+'</a>';
                      });
                      if(res.data.view_all) {
                          html += '<a href="'+res.data.view_all+'" class="mega-product-link" style="color:#FBBF24; margin-top: 4px; display: block; font-style: italic;">View all products &rarr;</a>';
                      }
                      inner.innerHTML = html;
                  } else {
                      inner.innerHTML = '<div class="mega-loading" style="color: #ef4444">No products found.</div>';
                  }
              }).catch(err => {
                  inner.innerHTML = '<div class="mega-loading" style="color: #ef4444">Failed to load.</div>';
              });
          }
        });
      });
    })();
  </script>

  <div id="snap-search-modal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-black/80 backdrop-blur-md" id="snap-search-overlay"></div>
    <div class="absolute top-24 left-1/2 -translate-x-1/2 w-full max-w-3xl px-4">
      <div class="bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col border border-white/10">
        <div class="relative flex items-center p-4 border-b border-gray-100">
          <span class="material-symbols-outlined absolute left-6 text-gray-400">search</span>
          <input type="text" id="snap-search-input" class="w-full pl-12 pr-4 py-3 text-lg font-bold text-gray-900 placeholder-gray-400 outline-none border-none focus:ring-0" placeholder="Search for products, models, or categories..." autocomplete="off">
          <button id="snap-search-close" class="absolute right-4 p-2 text-gray-400 hover:text-black transition-colors">
            <span class="material-symbols-outlined">close</span>
          </button>
        </div>
        <div id="snap-search-results" class="max-h-[60vh] overflow-y-auto bg-gray-50 hidden">
          <!-- Results will be injected here -->
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const triggerDesktop = document.getElementById('search-trigger');
      const triggerMobile = document.getElementById('search-trigger-mobile');
      const modal = document.getElementById('snap-search-modal');
      const overlay = document.getElementById('snap-search-overlay');
      const closeBtn = document.getElementById('snap-search-close');
      const input = document.getElementById('snap-search-input');
      const resultsContainer = document.getElementById('snap-search-results');
      
      let searchTimeout = null;

      function openModal() {
        modal.classList.remove('hidden');
        setTimeout(() => input.focus(), 100);
      }

      function closeModal() {
        modal.classList.add('hidden');
        input.value = '';
        resultsContainer.innerHTML = '';
        resultsContainer.classList.add('hidden');
      }

      if(triggerDesktop) triggerDesktop.addEventListener('click', openModal);
      if(triggerMobile) triggerMobile.addEventListener('click', openModal);
      if(overlay) overlay.addEventListener('click', closeModal);
      if(closeBtn) closeBtn.addEventListener('click', closeModal);

      document.addEventListener('keydown', (e) => {
        if(e.key === 'Escape' && !modal.classList.contains('hidden')) {
          closeModal();
        }
      });

      if(input) {
        input.addEventListener('input', function(e) {
          const query = e.target.value.trim();
          
          if (searchTimeout) clearTimeout(searchTimeout);
          
          if (query.length < 2) {
            resultsContainer.classList.add('hidden');
            resultsContainer.innerHTML = '';
            return;
          }

          searchTimeout = setTimeout(() => {
            resultsContainer.classList.remove('hidden');
            resultsContainer.innerHTML = '<div class="p-8 text-center text-gray-500 flex items-center justify-center gap-2"><span class="material-symbols-outlined animate-spin">progress_activity</span> Searching...</div>';
            
            const fd = new FormData();
            fd.append('action', 'snap_ajax_search');
            fd.append('s', query);

            const ajaxUrl = (typeof ajaxurl !== 'undefined') ? ajaxurl : '/wp-admin/admin-ajax.php';
            
            fetch(ajaxUrl, {
              method: 'POST',
              body: fd
            })
            .then(res => res.json())
            .then(res => {
              if (res.success && res.data.length > 0) {
                let html = '<ul class="divide-y divide-gray-100">';
                res.data.forEach(item => {
                  html += 
                    <li>
                      <a href="\" class="flex items-center gap-4 p-4 hover:bg-white transition-colors group">
                        <div class="w-16 h-16 bg-white border border-gray-100 p-1 flex-shrink-0">
                          <img src="\" class="w-full h-full object-contain mix-blend-multiply group-hover:scale-110 transition-transform">
                        </div>
                        <div class="flex-grow min-w-0">
                          <h4 class="text-sm font-bold text-gray-900 truncate group-hover:text-[#1A56DB] transition-colors">\</h4>
                        </div>
                        <div class="flex-shrink-0 text-right">
                          \
                        </div>
                      </a>
                    </li>
                  ;
                });
                html += '</ul>';
                resultsContainer.innerHTML = html;
              } else {
                resultsContainer.innerHTML = '<div class="p-8 text-center text-gray-500 font-medium">No products found matching "'+query+'"</div>';
              }
            })
            .catch(() => {
              resultsContainer.innerHTML = '<div class="p-8 text-center text-red-500 font-medium">An error occurred while searching.</div>';
            });
          }, 400);
        });
      }
    });
  </script>
  <!-- Search Modal -->
  <div id="snap-search-modal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-black/80 backdrop-blur-md" id="snap-search-overlay"></div>
    <div class="absolute top-24 left-1/2 -translate-x-1/2 w-full max-w-3xl px-4">
      <div class="bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col border border-white/10">
        <div class="relative flex items-center p-4 border-b border-gray-100">
          <span class="material-symbols-outlined absolute left-6 text-gray-400">search</span>
          <input type="text" id="snap-search-input" class="w-full pl-12 pr-4 py-3 text-lg font-bold text-gray-900 placeholder-gray-400 outline-none border-none focus:ring-0" placeholder="Search for products, models, or categories..." autocomplete="off">
          <button id="snap-search-close" class="absolute right-4 p-2 text-gray-400 hover:text-black transition-colors">
            <span class="material-symbols-outlined">close</span>
          </button>
        </div>
        <div id="snap-search-results" class="max-h-[60vh] overflow-y-auto bg-gray-50 hidden">
          <!-- Results will be injected here -->
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const triggerDesktop = document.getElementById('search-trigger');
      const triggerMobile = document.getElementById('search-trigger-mobile');
      const modal = document.getElementById('snap-search-modal');
      const overlay = document.getElementById('snap-search-overlay');
      const closeBtn = document.getElementById('snap-search-close');
      const input = document.getElementById('snap-search-input');
      const resultsContainer = document.getElementById('snap-search-results');
      
      let searchTimeout = null;

      function openModal() {
        modal.classList.remove('hidden');
        setTimeout(() => input.focus(), 100);
      }

      function closeModal() {
        modal.classList.add('hidden');
        input.value = '';
        resultsContainer.innerHTML = '';
        resultsContainer.classList.add('hidden');
      }

      if(triggerDesktop) triggerDesktop.addEventListener('click', openModal);
      if(triggerMobile) triggerMobile.addEventListener('click', openModal);
      if(overlay) overlay.addEventListener('click', closeModal);
      if(closeBtn) closeBtn.addEventListener('click', closeModal);

      document.addEventListener('keydown', (e) => {
        if(e.key === 'Escape' && !modal.classList.contains('hidden')) {
          closeModal();
        }
      });

      if(input) {
        input.addEventListener('input', function(e) {
          const query = e.target.value.trim();
          
          if (searchTimeout) clearTimeout(searchTimeout);
          
          if (query.length < 2) {
            resultsContainer.classList.add('hidden');
            resultsContainer.innerHTML = '';
            return;
          }

          searchTimeout = setTimeout(() => {
            resultsContainer.classList.remove('hidden');
            resultsContainer.innerHTML = '<div class="p-8 text-center text-gray-500 flex items-center justify-center gap-2"><span class="material-symbols-outlined animate-spin">progress_activity</span> Searching...</div>';
            
            const fd = new FormData();
            fd.append('action', 'snap_ajax_search');
            fd.append('s', query);

            const ajaxUrl = (typeof ajaxurl !== 'undefined') ? ajaxurl : '/wp-admin/admin-ajax.php';
            
            fetch(ajaxUrl, {
              method: 'POST',
              body: fd
            })
            .then(res => res.json())
            .then(res => {
              if (res.success && res.data.length > 0) {
                let html = '<ul class="divide-y divide-gray-100">';
                res.data.forEach(item => {
                  html += `
                    <li>
                      <a href="${item.url}" class="flex items-center gap-4 p-4 hover:bg-white transition-colors group">
                        <div class="w-16 h-16 bg-white border border-gray-100 p-1 flex-shrink-0">
                          <img src="${item.image}" class="w-full h-full object-contain mix-blend-multiply group-hover:scale-110 transition-transform">
                        </div>
                        <div class="flex-grow min-w-0">
                          <h4 class="text-sm font-bold text-gray-900 truncate group-hover:text-[#1A56DB] transition-colors">${item.title}</h4>
                        </div>
                        <div class="flex-shrink-0 text-right">
                          ${item.price}
                        </div>
                      </a>
                    </li>
                  `;
                });
                html += '</ul>';
                resultsContainer.innerHTML = html;
              } else {
                resultsContainer.innerHTML = '<div class="p-8 text-center text-gray-500 font-medium">No products found matching "'+query+'"</div>';
              }
            })
            .catch(() => {
              resultsContainer.innerHTML = '<div class="p-8 text-center text-red-500 font-medium">An error occurred while searching.</div>';
            });
          }, 400);
        });
      }
    });
  </script>
