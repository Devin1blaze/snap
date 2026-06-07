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
        .brand-card:hover { transform: scale(1.05); box-shadow: 0 10px 30px rgba(0,0,0,0.12); border-color: #1A56DB; background-color: #f9fafb; }
        .why-icon-box { transition: background 0.2s cubic-bezier(0.4, 0, 0.2, 1); }
        .why-icon-box:hover { background: rgba(26,86,219,0.15); }
    </style>
</head>
<body <?php body_class('bg-surface text-on-surface'); ?>>
<?php wp_body_open(); ?>

<!-- Section: TopNavBar -->
<nav class="fixed top-0 w-full z-50 bg-black border-b border-white/10" style="backdrop-filter:blur(10px);">
  <div class="max-w-screen-xl mx-auto flex items-center justify-between px-6 sm:px-10" style="height:68px;">
    <!-- Logo -->
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-3 shrink-0">
      <span class="w-9 h-9 bg-secondary-container flex items-center justify-center">
        <span class="material-symbols-outlined text-black text-xl" style="font-variation-settings:'FILL' 1">bolt</span>
      </span>
      <span class="text-xl font-black text-white tracking-tight">Snap <span class="text-secondary-container">Marketing</span></span>
    </a>
    <!-- Desktop links -->
    <div class="hidden md:flex items-center gap-10">
      <a class="nav-link text-white/80 hover:text-white font-semibold text-sm uppercase tracking-widest transition-colors" href="/shop">Shop</a>
      <a class="nav-link text-white/80 hover:text-white font-semibold text-sm uppercase tracking-widest transition-colors" href="/about-us">About</a>
      <a class="nav-link text-white/80 hover:text-white font-semibold text-sm uppercase tracking-widest transition-colors" href="/contact-us">Contact</a>
    </div>
    <!-- CTA + Hamburger -->
    <div class="flex items-center gap-4">
      <a href="/request-a-quote" class="hidden sm:inline-flex items-center gap-2 bg-secondary-container text-black font-black text-sm uppercase px-6 py-2.5 tracking-widest hover:bg-yellow-400 hover:-translate-y-1 hover:shadow-lg active:scale-95 transition-all duration-300">
        Get Quote
        <span class="material-symbols-outlined text-sm">arrow_forward</span>
      </a>
      <!-- Hamburger -->
      <button id="nav-toggle" class="md:hidden flex flex-col gap-1.5 p-2 group" aria-label="Toggle menu">
        <span class="block w-6 h-0.5 bg-white transition-all duration-300 group-[.open]:rotate-45 group-[.open]:translate-y-2"></span>
        <span class="block w-6 h-0.5 bg-white transition-all duration-300 group-[.open]:opacity-0"></span>
        <span class="block w-6 h-0.5 bg-white transition-all duration-300 group-[.open]:-rotate-45 group-[.open]:-translate-y-2"></span>
      </button>
    </div>
  </div>
  <!-- Mobile drawer -->
  <div id="mobile-menu" class="md:hidden flex-col bg-black border-t border-white/10 px-6 pb-6 pt-4 gap-4">
    <a class="text-white/80 hover:text-white font-bold text-base uppercase tracking-widest py-2 border-b border-white/5 block" href="/shop">Shop</a>
    <a class="text-white/80 hover:text-white font-bold text-base uppercase tracking-widest py-2 border-b border-white/5 block" href="/about-us">About</a>
    <a class="text-white/80 hover:text-white font-bold text-base uppercase tracking-widest py-2 border-b border-white/5 block" href="/contact-us">Contact</a>
    <a href="/request-a-quote" class="mt-2 inline-flex items-center gap-2 bg-secondary-container text-black font-black text-sm uppercase px-6 py-3 tracking-widest w-full justify-center">Get Quote</a>
  </div>
</nav>
<script>
  document.getElementById('nav-toggle').addEventListener('click', function() {
    this.classList.toggle('open');
    document.getElementById('mobile-menu').classList.toggle('open');
  });
  // Scroll shadow
  window.addEventListener('scroll', function() {
    document.querySelector('nav').style.boxShadow = window.scrollY > 20 ? '0 4px 30px rgba(0,0,0,0.5)' : 'none';
  });
</script>