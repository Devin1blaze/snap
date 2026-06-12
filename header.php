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
        <div class="hidden lg:flex flex-1 items-center justify-center relative z-20 mx-4">
            <?php
            wp_nav_menu( array(
                'theme_location'  => 'primary',
                'container'       => false,
                'menu_class'      => 'flex items-center gap-6 xl:gap-10 text-sm font-semibold uppercase tracking-[0.15em] text-white/70',
                'walker'          => new Tailwind_Nav_Walker(),
                'fallback_cb'     => false,
            ) );
            ?>
        </div>

        <!-- Right Side: Search, Buttons & Hamburger -->
        <div class="flex items-center gap-4 relative z-20">
          
          <!-- Search Catalog Button -->
          <div class="hidden lg:flex items-center bg-white/10 px-4 py-2 rounded-sm cursor-pointer hover:bg-white/20 transition-colors">
            <span class="material-symbols-outlined text-white text-sm mr-2">search</span>
            <span class="text-white/60 text-xs font-bold uppercase tracking-widest">Search Catalog</span>
          </div>
          <!-- Button Container (Visible on Desktop) -->
          <div class="hidden lg:flex items-center gap-3">
            <!-- Login/Signup: Hidden when scrolled -->
            <a id="btn-login" href="/login" class="text-white/80 hover:text-white font-bold text-xs uppercase tracking-widest px-5 py-2 border border-white/10 rounded-xl hover:bg-white/5 transition-all duration-300">Login</a>
            <a id="btn-signup" href="/register" class="bg-secondary-container text-black font-black text-xs uppercase tracking-widest px-5 py-2 rounded-xl hover:bg-yellow-400 transition-all duration-300 shadow-xl">Sign Up</a>
            
            <!-- Get Started: Visible ONLY when scrolled -->
            <a id="btn-scrolled-cta" href="/request-a-quote" class="hidden items-center gap-2 bg-secondary-container text-black font-black text-xs uppercase px-6 py-2 rounded-xl tracking-widest hover:bg-yellow-400 hover:-translate-y-1 hover:shadow-lg active:scale-95 transition-all duration-500 border border-black/10">
              Get Quote
              <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
            </a>
          </div>

          <!-- Hamburger -->
          <button id="nav-toggle" class="lg:hidden flex flex-col gap-1.5 p-2 group" aria-label="Toggle menu">
            <span class="block w-6 h-0.5 bg-white transition-all duration-300 group-[.open]:rotate-45 group-[.open]:translate-y-2"></span>
            <span class="block w-6 h-0.5 bg-white transition-all duration-300 group-[.open]:opacity-0"></span>
            <span class="block w-6 h-0.5 bg-white transition-all duration-300 group-[.open]:-rotate-45 group-[.open]:-translate-y-2"></span>
          </button>
        </div>

        <!-- Mobile Drawer -->
        <div id="mobile-menu" class="hidden w-full flex-col bg-[#0A0A0A]/98 backdrop-blur-2xl border border-white/10 p-8 rounded-[2.5rem] mt-6 gap-6 lg:hidden absolute top-full left-0 z-50 shadow-[0_32px_64px_-12px_rgba(0,0,0,0.6)]">
          <?php
          wp_nav_menu( array(
              'theme_location'  => 'primary',
              'container'       => false,
              'menu_class'      => 'flex flex-col gap-4',
              'link_before'     => '<span class="text-white/60 hover:text-white font-bold text-lg uppercase tracking-[0.2em] py-3 border-b border-white/5 block transition-all">',
              'link_after'      => '</span>',
              'fallback_cb'     => false,
          ) );
          ?>
          <div class="flex flex-col gap-4 mt-4">
            <a href="/login" class="text-center text-white/80 hover:text-white font-bold text-sm uppercase tracking-[0.2em] border border-white/10 py-4 rounded-2xl hover:bg-white/5 transition-all">Login</a>
            <a href="/request-a-quote" class="inline-flex items-center gap-2 bg-secondary-container text-black font-black text-sm uppercase px-6 py-5 tracking-[0.2em] w-full justify-center rounded-2xl shadow-xl active:scale-95 transition-all">Get Quote</a>
          </div>
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
        // Shrink the island slightly and round the corners
        navIsland.classList.remove('max-w-screen-xl', 'mt-4', 'lg:px-12', 'bg-black/40', 'border-white/5', 'rounded-2xl', 'rounded-none');
        navIsland.classList.add('max-w-6xl', 'mt-2', 'lg:px-10', 'bg-black/80', 'backdrop-blur-xl', 'border-white/15', 'shadow-[0_20px_50px_rgba(0,0,0,0.5)]', 'rounded-full');
        
        // Swap buttons
        btnLogin.classList.add('lg:hidden');
        btnSignup.classList.add('lg:hidden');
        btnScrolledCta.classList.remove('hidden');
        btnScrolledCta.classList.add('flex');
    } else {
        // Expand the island
        navIsland.classList.add('max-w-screen-xl', 'mt-4', 'lg:px-12', 'bg-black/40', 'border-white/5', 'rounded-2xl');
        navIsland.classList.remove('max-w-6xl', 'mt-2', 'lg:px-10', 'bg-black/80', 'backdrop-blur-xl', 'border-white/15', 'shadow-[0_20px_50px_rgba(0,0,0,0.5)]', 'rounded-full', 'rounded-none');
        
        // Revert buttons
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
    mobileMenu.classList.toggle('hidden');
    mobileMenu.classList.toggle('flex');
    mobileMenu.classList.toggle('animate-in');
    mobileMenu.classList.toggle('fade-in');
    mobileMenu.classList.toggle('zoom-in-95');
  });
</script>