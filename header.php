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
        #mobile-menu { display:none; }
        #mobile-menu.open { display:flex; }

        /* Style adjustments for dynamic submenus */
        .sub-menu {
            text-align: left !important;
            min-width: 280px !important;
            left: 0 !important;
        }
        .sub-menu li { width: 100% !important; }
        .sub-menu li a {
            padding: 1rem 1.5rem !important;
            display: flex !important;
            align-items: center !important;
            width: 100% !important;
            text-transform: none !important;
            font-weight: 600 !important;
            font-size: 0.95rem !important;
            border-bottom: 1px solid rgba(255,255,255,0.05) !important;
            text-align: left !important;
            justify-content: flex-start !important;
            color: white !important;
            transition: all 0.2s ease !important;
        }
        .sub-menu li:last-child a { border-bottom: none !important; }
        .sub-menu li a:hover {
            background-color: rgba(255,255,255,0.08) !important;
            padding-left: 2rem !important;
            color: #FBBF24 !important;
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
    </style>
</head>
<body <?php body_class('bg-surface text-on-surface'); ?>>
<?php wp_body_open(); ?>

<!-- Section: Top Contact Bar & Navigation -->
<header class="w-full relative z-50">
  <!-- Top Contact Bar (Scrolls away) -->
  <div class="hidden md:flex bg-[#0A0A0A] border-b border-white/5 text-white/70 py-2 px-6 sm:px-10 justify-between items-center text-xs font-semibold uppercase tracking-widest relative z-[60]">
    <div class="flex items-center gap-6">
      <a href="tel:+912024458899" class="flex items-center gap-2 hover:text-secondary-container transition-colors">
        <span class="material-symbols-outlined text-[14px]">call</span>
        +91 (20) 2445-8899
      </a>
      <a href="mailto:sales@snapmarketing.in" class="flex items-center gap-2 hover:text-secondary-container transition-colors">
        <span class="material-symbols-outlined text-[14px]">mail</span>
        sales@snapmarketing.in
      </a>
    </div>
    <div class="flex items-center gap-6">
      <a href="/about-us" class="hover:text-secondary-container transition-colors">About Us</a>
      <a href="/contact-us" class="hover:text-secondary-container transition-colors">Support</a>
    </div>
  </div>

  <!-- Sticky Floating Nav -->
  <div class="sticky top-0 z-50 w-full px-2 pt-2 pb-2 pointer-events-none">
    <nav id="nav-container" class="mx-auto max-w-screen-xl px-6 transition-all duration-300 lg:px-10 bg-black border border-transparent rounded-none pointer-events-auto">
      <div class="relative flex flex-wrap items-center justify-between py-3 lg:py-0" style="min-height:68px;">
        
        <!-- Logo (Left) -->
        <div class="flex w-full justify-between lg:w-auto items-center relative z-20">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-3 shrink-0">
            <span class="w-9 h-9 bg-secondary-container flex items-center justify-center rounded-sm">
              <span class="material-symbols-outlined text-black text-xl" style="font-variation-settings:'FILL' 1">bolt</span>
            </span>
            <span class="text-xl font-black text-white tracking-tight">Snap <span class="text-secondary-container">Marketing</span></span>
          </a>

          <!-- Hamburger -->
          <button id="nav-toggle" class="md:hidden flex flex-col gap-1.5 p-2 group" aria-label="Toggle menu">
            <span class="block w-6 h-0.5 bg-white transition-all duration-300 group-[.open]:rotate-45 group-[.open]:translate-y-2"></span>
            <span class="block w-6 h-0.5 bg-white transition-all duration-300 group-[.open]:opacity-0"></span>
            <span class="block w-6 h-0.5 bg-white transition-all duration-300 group-[.open]:-rotate-45 group-[.open]:-translate-y-2"></span>
          </button>
        </div>

        <!-- Desktop links (Absolute Center) -->
        <div class="absolute inset-0 m-auto hidden w-fit lg:flex items-center justify-center pointer-events-none">
          <div class="pointer-events-auto flex h-full items-center">
            <?php
            wp_nav_menu( array(
                'theme_location'  => 'primary',
                'container'       => false,
                'menu_class'      => 'flex items-center gap-8 h-full',
                'walker'          => new Tailwind_Nav_Walker(),
                'fallback_cb'     => false,
            ) );
            ?>
          </div>
        </div>

        <!-- CTA (Right) -->
        <div class="hidden lg:flex items-center gap-6 relative z-20">
          <a href="/login" class="text-white/80 hover:text-white font-bold text-sm uppercase tracking-widest transition-colors">Login</a>
          <a href="/request-a-quote" class="inline-flex items-center gap-2 bg-secondary-container text-black font-black text-sm uppercase px-6 py-2.5 tracking-widest hover:bg-yellow-400 hover:-translate-y-1 hover:shadow-lg active:scale-95 transition-all duration-300 rounded-sm">
            Get Quote
            <span class="material-symbols-outlined text-sm">arrow_forward</span>
          </a>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div id="mobile-menu" class="hidden w-full flex-col bg-[#0A0A0A]/95 backdrop-blur-xl border border-white/10 p-6 rounded-xl mt-4 gap-4 lg:hidden absolute top-full left-0 z-50 shadow-2xl">
          <?php
          wp_nav_menu( array(
              'theme_location'  => 'primary',
              'container'       => false,
              'menu_class'      => 'flex flex-col gap-2',
              'link_before'     => '<span class="text-white/80 hover:text-white font-bold text-base uppercase tracking-widest py-2 border-b border-white/5 block">',
              'link_after'      => '</span>',
              'fallback_cb'     => false,
          ) );
          ?>
          <div class="flex flex-col gap-3 mt-4">
            <a href="/login" class="text-center text-white hover:text-white font-bold text-sm uppercase tracking-widest border border-white/20 py-3 rounded-sm transition-colors">Login</a>
            <a href="/request-a-quote" class="inline-flex items-center gap-2 bg-secondary-container text-black font-black text-sm uppercase px-6 py-3 tracking-widest w-full justify-center rounded-sm">Get Quote</a>
          </div>
        </div>
      </div>
    </nav>
  </div>
</header>
<script>
  const navContainer = document.getElementById('nav-container');
  window.addEventListener('scroll', function() {
    if (window.scrollY > 50) {
        navContainer.classList.remove('max-w-screen-xl', 'bg-black', 'border-transparent', 'rounded-none');
        navContainer.classList.add('max-w-4xl', 'bg-black/70', 'backdrop-blur-lg', 'rounded-2xl', 'border-white/10', 'shadow-2xl');
    } else {
        navContainer.classList.add('max-w-screen-xl', 'bg-black', 'border-transparent', 'rounded-none');
        navContainer.classList.remove('max-w-4xl', 'bg-black/70', 'backdrop-blur-lg', 'rounded-2xl', 'border-white/10', 'shadow-2xl');
    }
  });

  const navToggle = document.getElementById('nav-toggle');
  const mobileMenu = document.getElementById('mobile-menu');
  navToggle.addEventListener('click', function() {
    this.classList.toggle('open');
    mobileMenu.classList.toggle('hidden');
    mobileMenu.classList.toggle('flex');
  });