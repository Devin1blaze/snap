<!-- SNAP_VERSION_1006 -->
<?php
/**
 * The header for our theme
 */

function snap_stitch_render_custom_menu() {
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
            $child_items[$item->menu_item_parent][] = $item;
        }
    }
    
    echo '<ul class="flex items-center gap-6 xl:gap-10 text-sm font-semibold uppercase tracking-[0.15em] text-white/70">';
    foreach ($menu_items as $item) {
        if (!$item->menu_item_parent) {
            $has_children = isset($child_items[$item->ID]);
            echo '<li class="relative menu-item-depth-0 group">';
            echo '<a href="' . esc_url($item->url) . '" class="nav-link font-[\'Plus Jakarta Sans\'] font-bold uppercase tracking-[0.2em] text-white/70 hover:text-secondary-container transition-all flex items-center py-6">';
            echo esc_html($item->title);
            if ($has_children) {
                echo ' <span class="material-symbols-outlined text-[16px] ml-1 transition-transform group-hover:rotate-180">expand_more</span>';
            }
            echo '</a>';
            
            if ($has_children) {
                echo '<ul class="sub-menu absolute z-50 w-72 bg-[#0A0A0A] border border-white/10 rounded-xl overflow-hidden flex flex-col shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">';
                foreach ($child_items[$item->ID] as $child) {
                    $has_subchildren = isset($child_items[$child->ID]);
                    echo '<li class="relative menu-item-depth-1 group/lvl2">';
                    echo '<a href="' . esc_url($child->url) . '" class="font-[\'Plus Jakarta Sans\'] text-[13px] font-bold uppercase tracking-widest text-white/70 hover:text-secondary-container transition-all flex items-center justify-between px-6 py-4 hover:bg-white/10 hover:pl-8 border-b border-white/5 w-full text-left">';
                    echo esc_html($child->title);
                    if ($has_subchildren) {
                        echo ' <span class="material-symbols-outlined text-[16px] transition-transform">chevron_right</span>';
                    }
                    echo '</a>';
                    
                    if ($has_subchildren) {
                        echo '<ul class="sub-menu-lvl3 absolute left-full top-0 z-50 w-72 bg-[#0A0A0A] border border-white/10 rounded-xl overflow-hidden flex flex-col shadow-2xl opacity-0 invisible group-hover/lvl2:opacity-100 group-hover/lvl2:visible transition-all duration-300 transform translate-x-2 group-hover/lvl2:translate-x-0">';
                        foreach ($child_items[$child->ID] as $subchild) {
                            echo '<li class="menu-item-depth-2">';
                            echo '<a href="' . esc_url($subchild->url) . '" class="font-[\'Plus Jakarta Sans\'] text-[11px] font-bold uppercase tracking-widest text-white/50 hover:text-white transition-all block px-6 py-4 hover:bg-white/10 hover:pl-8 border-b border-white/5 w-full text-left">';
                            echo esc_html($subchild->title);
                            echo '</a>';
                            echo '</li>';
                        }
                        echo '</ul>';
                    }
                    echo '</li>';
                }
                echo '</ul>';
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
        
        /* Nav link underline animation */
        .nav-link { position:relative; }
        .nav-link::after { content:''; position:absolute; left:0; bottom:-4px; width:0; height:2px; background:#FBBF24; transition:width 0.25s ease; }
        .nav-link:hover::after { width:100%; }

        /* Industrial Glow for interactive elements */
        .industrial-glow:hover { box-shadow: 0 0 25px rgba(251, 191, 36, 0.4); }
    </style>
</head>
<body <?php body_class('bg-surface text-on-surface'); ?>>
<?php wp_body_open(); ?>

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
            <span class="text-xl font-black text-white tracking-tight uppercase">Snap <span class="text-secondary-container italic">Marketing</span></span>
          </a>
        </div>

        <!-- Desktop Menu -->
        <div class="hidden lg:flex flex-1 items-center justify-center relative z-20 mx-4">
            <?php snap_stitch_render_custom_menu(); ?>
        </div>

        <!-- Right Side: Search, Buttons & Hamburger -->
        <div class="flex items-center gap-4 relative z-20">
          
          <!-- Search Catalog Button -->
          <button id="search-trigger" class="hidden lg:flex items-center bg-white/10 px-4 py-2 rounded-sm cursor-pointer hover:bg-white/20 transition-colors border border-white/5 group">
            <span class="material-symbols-outlined text-white text-sm mr-2 group-hover:scale-110 transition-transform">search</span>
            <span class="text-white/60 text-xs font-bold uppercase tracking-widest">Search Catalog</span>
          </button>

          <!-- Desktop Buttons -->
          <div class="hidden lg:flex items-center gap-3">
            <a id="btn-login" href="/my-account" class="text-white/80 hover:text-white font-bold text-xs uppercase tracking-widest px-5 py-2 border border-white/10 rounded-xl hover:bg-white/5 transition-all duration-300">Login</a>
            <a id="btn-signup" href="/my-account/?action=register" class="bg-secondary-container text-black font-black text-xs uppercase tracking-widest px-5 py-2 rounded-xl hover:bg-yellow-400 transition-all duration-300 shadow-xl">Sign Up</a>
            <a id="btn-scrolled-cta" href="/request-a-quote" class="hidden items-center gap-2 bg-secondary-container text-black font-black text-xs uppercase px-6 py-2 rounded-xl tracking-widest hover:bg-yellow-400 hover:-translate-y-1 hover:shadow-lg active:scale-95 transition-all duration-500 border border-black/10">
              Get Quote
              <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
            </a>
          </div>

          <!-- Search Trigger (Mobile) -->
          <button id="search-trigger-mobile" class="lg:hidden p-2 text-white/70 hover:text-white transition-colors">
            <span class="material-symbols-outlined text-2xl">search</span>
          </button>

          <!-- Hamburger -->
          <button id="nav-toggle" class="lg:hidden flex flex-col gap-1.5 p-2 group" aria-label="Toggle menu">
            <span class="block w-6 h-0.5 bg-white transition-all duration-300 group-[.open]:rotate-45 group-[.open]:translate-y-2"></span>
            <span class="block w-6 h-0.5 bg-white transition-all duration-300 group-[.open]:opacity-0"></span>
            <span class="block w-6 h-0.5 bg-white transition-all duration-300 group-[.open]:-rotate-45 group-[.open]:-translate-y-2"></span>
          </button>
        </div>

        <!-- Mobile Drawer -->
        <div id="mobile-menu" class="hidden w-full flex-col bg-[#0A0A0A]/98 backdrop-blur-2xl border border-white/10 p-8 rounded-[2.5rem] mt-6 gap-6 lg:hidden absolute top-full left-0 z-50 shadow-[0_32px_64px_-12px_rgba(0,0,0,0.6)]">
          <?php snap_stitch_render_custom_menu(); ?>
          <div class="flex flex-col gap-4 mt-4">
            <a href="/my-account" class="text-center text-white/80 hover:text-white font-bold text-sm uppercase tracking-[0.2em] border border-white/10 py-4 rounded-2xl hover:bg-white/5 transition-all">Login</a>
            <a href="/request-a-quote" class="inline-flex items-center gap-2 bg-secondary-container text-black font-black text-sm uppercase px-6 py-5 tracking-[0.2em] w-full justify-center rounded-2xl shadow-xl active:scale-95 transition-all">Get Quote</a>
          </div>
        </div>
      </div>
    </div>
  </nav>
</header>

<!-- Search Modal -->
<div id="search-modal" class="fixed inset-0 z-[200] hidden items-center justify-center bg-black/90 backdrop-blur-xl p-4 transition-all duration-300 opacity-0 invisible">
    <div class="w-full max-w-4xl transform scale-95 transition-all duration-300">
        <button id="search-close" class="absolute -top-12 right-0 text-white/60 hover:text-white flex items-center gap-2 uppercase text-xs font-bold tracking-widest">
            Close <span class="material-symbols-outlined text-xl">close</span>
        </button>
        <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="relative">
            <input type="text" name="s" id="search-input" placeholder="Search by brand, SKU, or category..." 
                class="w-full bg-white/5 border-b-2 border-white/20 text-white text-3xl md:text-5xl font-black py-8 px-4 focus:outline-none focus:border-secondary-container transition-colors placeholder:text-white/10">
            <input type="hidden" name="post_type" value="product">
            <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 text-secondary-container">
                <span class="material-symbols-outlined text-5xl">arrow_forward</span>
            </button>
        </form>
        <div class="mt-12">
            <h4 class="text-white/30 text-xs font-black uppercase tracking-[0.3em] mb-6">Trending Categories</h4>
            <div class="flex flex-wrap gap-4">
                <?php
                $pop_cats = get_terms( array('taxonomy' => 'product_cat', 'number' => 5, 'orderby' => 'count', 'order' => 'DESC') );
                foreach ($pop_cats as $cat) {
                    echo '<a href="' . get_term_link($cat) . '" class="px-6 py-3 bg-white/5 border border-white/10 rounded-full text-white/70 text-sm font-bold hover:bg-secondary-container hover:text-black transition-all">'. $cat->name .'</a>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
  // Navigation Island Logic
  const navIsland = document.getElementById('nav-island');
  const btnLogin = document.getElementById('btn-login');
  const btnSignup = document.getElementById('btn-signup');
  const btnScrolledCta = document.getElementById('btn-scrolled-cta');

  window.addEventListener('scroll', function() {
    if (window.scrollY > 50) {
        navIsland.classList.remove('max-w-screen-xl', 'mt-4', 'lg:px-12', 'bg-black/40', 'border-white/5', 'rounded-2xl');
        navIsland.classList.add('max-w-6xl', 'mt-2', 'lg:px-10', 'bg-black/80', 'backdrop-blur-xl', 'border-white/15', 'shadow-[0_20px_50px_rgba(0,0,0,0.5)]', 'rounded-full');
        btnLogin.classList.add('lg:hidden');
        btnSignup.classList.add('lg:hidden');
        btnScrolledCta.classList.remove('hidden');
        btnScrolledCta.classList.add('flex');
    } else {
        navIsland.classList.add('max-w-screen-xl', 'mt-4', 'lg:px-12', 'bg-black/40', 'border-white/5', 'rounded-2xl');
        navIsland.classList.remove('max-w-6xl', 'mt-2', 'lg:px-10', 'bg-black/80', 'backdrop-blur-xl', 'border-white/15', 'shadow-[0_20px_50px_rgba(0,0,0,0.5)]', 'rounded-full');
        btnLogin.classList.remove('lg:hidden');
        btnSignup.classList.remove('lg:hidden');
        btnScrolledCta.classList.add('hidden');
        btnScrolledCta.classList.remove('flex');
    }
  });

  // Mobile Menu Toggle
  const navToggle = document.getElementById('nav-toggle');
  const mobileMenu = document.getElementById('mobile-menu');
  navToggle.addEventListener('click', function() {
    this.classList.toggle('open');
    mobileMenu.classList.toggle('hidden');
    mobileMenu.classList.toggle('flex');
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

  searchTrigger.addEventListener('click', openSearch);
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
</script>
</body>
</html>