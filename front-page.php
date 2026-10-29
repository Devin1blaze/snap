<?php
/*
Template Name: Front Page
*/
get_header();
?>

<!-- Section 1: HERO SLIDER -->
<header id="hero-slider" class="relative min-h-screen pt-20 flex items-center overflow-hidden bg-[#1A56DB]">
    <!-- Bottom fade for stat strip transition -->
    <div class="absolute bottom-0 left-0 w-full h-1/5 bg-gradient-to-t from-[#1A56DB] to-transparent z-[15]"></div>

    <!-- Slides Container -->
    <div class="absolute inset-0 z-10">
      <?php
      $hero_slides = [
        [
          'badge'    => 'NEW CATALOG 2025',
          'heading'  => 'Precision Equipment. <br/><span class="text-[#FBBF24]">Bulk Pricing.</span>',
          'desc'     => 'Supplying washroom automations, commercial refrigeration, and hygiene solutions to 500+ enterprises pan-India.',
          'cta1_text'=> 'Browse Products',
          'cta1_href'=> '/shop',
          'cta2_text'=> 'Request Quote',
          'cta2_href'=> '/request-a-quote',
          'bg_img'   => 'https://images.unsplash.com/photo-1620626011761-996317b8d101?w=1920&q=80',
          'overlay'  => 'from-[#0A0A0A]/90 via-[#0A0A0A]/50 to-transparent',
        ],
        [
          'badge'    => 'COMMERCIAL REFRIGERATION',
          'heading'  => 'Cold Chain <br/><span class="text-[#FBBF24]">Solutions.</span>',
          'desc'     => 'Deep freezers, display coolers, and walk-in cold rooms from Blue Star, Voltas, and Western — engineered for industrial uptime.',
          'cta1_text'=> 'Explore Range',
          'cta1_href'=> '/product-category/commercial-refrigeration/',
          'cta2_text'=> 'Get Pricing',
          'cta2_href'=> '/request-a-quote',
          'bg_img'   => get_template_directory_uri() . '/images/slide2_bg.png',
          'overlay'  => 'from-[#0A0A0A]/90 via-[#0A0A0A]/60 to-[#0A0A0A]/20',
        ],
        [
          'badge'    => 'HYGIENE & PPE',
          'heading'  => 'Automated Hygiene <br/><span class="text-[#FBBF24]">at Scale.</span>',
          'desc'     => 'Touchless dispensers, sanitizer stations, and PPE kits from Kimberly Clark, Dettol, and Euronics — deployed across 500+ facilities.',
          'cta1_text'=> 'Shop Hygiene',
          'cta1_href'=> '/product-category/hygiene-ppe/',
          'cta2_text'=> 'Get Quote',
          'cta2_href'=> '/request-a-quote',
          'bg_img'   => get_template_directory_uri() . '/images/slide3_bg.png',
          'overlay'  => 'from-[#0A0A0A]/90 via-[#0A0A0A]/60 to-[#0A0A0A]/10',
        ],
      ];
      foreach($hero_slides as $i => $slide): ?>
      <div class="hero-slide absolute inset-0 flex items-center <?= $i === 0 ? 'is-active' : '' ?> overflow-hidden" data-slide="<?= $i ?>">
        <!-- Full-bleed background image with Ken Burns animation -->
        <div class="hero-bg-img absolute inset-0 bg-cover bg-center bg-no-repeat" 
             style="background-image: url('<?= $slide['bg_img'] ?>');">
        </div>
        <!-- Dark overlay gradient (heavier on left for text readability) -->
        <div class="absolute inset-0 bg-gradient-to-r <?= $slide['overlay'] ?> z-0"></div>
        
        <div class="container mx-auto px-8 md:px-16 relative z-10 w-full">
            <div class="max-w-4xl flex flex-col justify-center">
                <div class="hero-text-block">
                    <span class="hero-animate inline-block bg-[#FBBF24] text-black font-black text-[12px] px-4 py-1.5 mb-5 tracking-[0.05em] uppercase"><?= $slide['badge'] ?></span>
                    <h1 class="hero-animate text-white text-4xl sm:text-5xl md:text-[72px] font-extrabold leading-[1.05] tracking-tight mb-6" style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800;">
                        <?= $slide['heading'] ?>
                    </h1>

                    <div class="hero-animate flex flex-wrap gap-3">
                        <a href="<?= $slide['cta1_href'] ?>" class="bg-[#FBBF24] text-black px-8 py-4 font-black uppercase text-sm tracking-widest flex items-center gap-2 hover:bg-yellow-400 hover:-translate-y-1 hover:shadow-xl active:scale-95 transition-all duration-300 rounded-none">
                            <?= $slide['cta1_text'] ?> <span class="material-symbols-outlined text-lg">arrow_forward</span>
                        </a>
                        <a href="<?= $slide['cta2_href'] ?>" class="border-2 border-white/30 text-white px-8 py-4 font-black uppercase text-sm tracking-widest hover:bg-white hover:text-black hover:border-white hover:-translate-y-1 hover:shadow-xl active:scale-95 transition-all duration-300 rounded-none bg-black/20 backdrop-blur-sm">
                            <?= $slide['cta2_text'] ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Slider Navigation: Arrows -->
    <button id="hero-prev" class="absolute left-4 sm:left-8 top-1/2 -translate-y-1/2 z-30 w-11 h-11 bg-white/5 hover:bg-[#FBBF24] hover:text-black text-white/60 flex items-center justify-center transition-all duration-300 active:scale-90 backdrop-blur-md border border-white/10 rounded-none" aria-label="Previous slide">
      <span class="material-symbols-outlined text-xl">chevron_left</span>
    </button>
    <button id="hero-next" class="absolute right-4 sm:right-8 top-1/2 -translate-y-1/2 z-30 w-11 h-11 bg-white/5 hover:bg-[#FBBF24] hover:text-black text-white/60 flex items-center justify-center transition-all duration-300 active:scale-90 backdrop-blur-md border border-white/10 rounded-none" aria-label="Next slide">
      <span class="material-symbols-outlined text-xl">chevron_right</span>
    </button>

    <!-- Slider Navigation: Dots + Progress -->
    <div class="absolute bottom-8 left-8 sm:left-12 z-30 flex items-center gap-2">
      <?php for($i = 0; $i < count($hero_slides); $i++): ?>
      <button class="hero-dot group relative h-1 transition-all duration-500 overflow-hidden <?= $i === 0 ? 'w-16 bg-white/40' : 'w-8 bg-white/15' ?>" data-dot="<?= $i ?>" aria-label="Go to slide <?= $i + 1 ?>">
        <span class="hero-dot-fill absolute inset-0 bg-[#FBBF24] origin-left scale-x-0 <?= $i === 0 ? 'animate-hero-progress' : '' ?>"></span>
      </button>
      <?php endfor; ?>
    </div>
</header>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;700;800&display=swap');

  @keyframes heroProgress {
    from { transform: scaleX(0); }
    to   { transform: scaleX(1); }
  }
  .animate-hero-progress { animation: heroProgress 6s linear forwards; }
  
  .hero-slide {
    opacity: 0;
    visibility: hidden;
    transition: opacity 1s ease-in-out, visibility 1s;
  }
  .hero-slide.is-active {
    opacity: 1;
    visibility: visible;
  }
  
  /* Ken Burns Effect for background image */
  .hero-bg-img {
    transform: scale(1);
    transition: transform 6.5s linear;
  }
  .is-active .hero-bg-img {
    transform: scale(1.08);
  }

  .hero-animate {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.5s ease-out, transform 0.5s cubic-bezier(0.2, 0.8, 0.2, 1);
  }
  .is-active .hero-animate {
    opacity: 1;
    transform: translateY(0);
  }
  .is-active .hero-text-block .hero-animate:nth-child(1) { transition-delay: 0.1s; }
  .is-active .hero-text-block .hero-animate:nth-child(2) { transition-delay: 0.25s; }
  .is-active .hero-text-block .hero-animate:nth-child(3) { transition-delay: 0.4s; }
  .is-active .hero-text-block .hero-animate:nth-child(4) { transition-delay: 0.55s; }
</style>
<script>
(function(){
  const slides = document.querySelectorAll('.hero-slide');
  const dots   = document.querySelectorAll('.hero-dot');
  const total  = slides.length;
  let current  = 0;
  let timer    = null;
  const INTERVAL = 6000;

  function goTo(idx) {
    slides[current].classList.remove('is-active');
    dots[current].classList.remove('w-16','bg-white/40');
    dots[current].classList.add('w-8','bg-white/15');
    dots[current].querySelector('.hero-dot-fill').classList.remove('animate-hero-progress');

    current = ((idx % total) + total) % total;

    slides[current].classList.add('is-active');
    dots[current].classList.remove('w-8','bg-white/15');
    dots[current].classList.add('w-16','bg-white/40');

    // Reset & restart progress animation
    const fill = dots[current].querySelector('.hero-dot-fill');
    fill.classList.remove('animate-hero-progress');
    void fill.offsetWidth;
    fill.classList.add('animate-hero-progress');
  }

  function next() { goTo(current + 1); }
  function prev() { goTo(current - 1); }

  function startAuto() { timer = setInterval(next, INTERVAL); }
  function stopAuto()  { clearInterval(timer); }

  document.getElementById('hero-next').addEventListener('click', function(){ stopAuto(); next(); startAuto(); });
  document.getElementById('hero-prev').addEventListener('click', function(){ stopAuto(); prev(); startAuto(); });
  dots.forEach(function(d){
    d.addEventListener('click', function(){ stopAuto(); goTo(parseInt(this.dataset.dot)); startAuto(); });
  });

  // Pause on hover
  var heroEl = document.getElementById('hero-slider');
  heroEl.addEventListener('mouseenter', stopAuto);
  heroEl.addEventListener('mouseleave', startAuto);

  startAuto();
})();
</script>

<!-- Stat Counters Strip -->
<div class="bg-[#FBBF24] w-full py-12 relative z-20">
    <div class="container mx-auto px-8 grid grid-cols-2 md:grid-cols-4 gap-8">
        <div class="text-center md:text-left border-r border-black/10 last:border-none">
            <div class="text-black text-5xl font-black counter" data-target="500">0</div>
            <div class="text-black/70 text-sm uppercase font-bold tracking-widest">Active Clients</div>
        </div>
        <div class="text-center md:text-left border-r border-black/10 last:border-none">
            <div class="text-black text-5xl font-black counter" data-target="40">0</div>
            <div class="text-black/70 text-sm uppercase font-bold tracking-widest">Global Brands</div>
        </div>
        <div class="text-center md:text-left border-r border-black/10 last:border-none">
            <div class="text-black text-5xl font-black counter" data-target="25">0</div>
            <div class="text-black/70 text-sm uppercase font-bold tracking-widest">Years Legacy</div>
        </div>
        <div class="text-center md:text-left border-r border-black/10 last:border-none">
            <div class="text-black text-5xl font-black italic">ISO</div>
            <div class="text-black/70 text-sm uppercase font-bold tracking-widest">9001:2015</div>
        </div>
    </div>
</div>



<!-- Section: What We Do -->
<section class="w-full bg-[#FFFFFF] py-24 px-4 sm:px-8 lg:px-20 overflow-x-hidden">
  <div class="max-w-screen-xl mx-auto">
    <div class="flex flex-col lg:flex-row lg:items-start lg:gap-16">
      <!-- Left: Image -->
      <div class="reveal w-full lg:w-[45%] shrink-0 mb-10 lg:mb-0">
        <div class="overflow-hidden shadow-2xl group">
          <img
            src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=800&q=85"
            alt="Snap Marketing - Industrial Equipment Solutions"
            class="w-full object-cover transition-transform duration-500 ease-out group-hover:scale-105"
            style="aspect-ratio:2/3;"
          />
        </div>
      </div>
      <!-- Right: Content -->
      <div class="flex flex-col flex-1 gap-8">
        <div class="flex flex-col gap-4">
          <div class="reveal">
            <span class="inline-block bg-[#FBBF24] text-black font-black text-xs px-4 py-1.5 uppercase tracking-widest">What We Do</span>
          </div>
          <div class="reveal">
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black leading-tight text-[#0A0A0A]">Delivering Excellence in Industrial Solutions</h2>
          </div>
          <div class="reveal">
            <p class="text-lg leading-relaxed text-zinc-600 font-medium">Snap Marketing supplies washroom automations, commercial refrigeration, vending machines, and hygiene solutions to 500+ enterprises pan-India — reliability and scale you can count on.</p>
          </div>
        </div>
        <!-- Feature items -->
        <div class="flex flex-col gap-6">
          <div class="reveal flex gap-4 items-start">
            <div class="w-10 h-10 shrink-0 bg-[#1A56DB] flex items-center justify-center">
              <span class="material-symbols-outlined text-white text-xl">verified</span>
            </div>
            <div>
              <h3 class="font-black text-base text-[#0A0A0A] mb-1">Genuine Brand Products</h3>
              <p class="text-sm leading-relaxed text-zinc-600">Certified industrial equipment sourced directly from leading global manufacturers.</p>
            </div>
          </div>
          <div class="reveal flex gap-4 items-start">
            <div class="w-10 h-10 shrink-0 bg-[#1A56DB] flex items-center justify-center">
              <span class="material-symbols-outlined text-white text-xl">local_shipping</span>
            </div>
            <div>
              <h3 class="font-black text-base text-[#0A0A0A] mb-1">Pan-India Distribution</h3>
              <p class="text-sm leading-relaxed text-zinc-600">Serving distributors, dealers, and corporate clients across India with fast, reliable logistics.</p>
            </div>
          </div>
          <div class="reveal flex gap-4 items-start">
            <div class="w-10 h-10 shrink-0 bg-[#1A56DB] flex items-center justify-center">
              <span class="material-symbols-outlined text-white text-xl">workspace_premium</span>
            </div>
            <div>
              <h3 class="font-black text-base text-[#0A0A0A] mb-1">Quality Assurance</h3>
              <p class="text-sm leading-relaxed text-zinc-600">Every product is inspected and tested to meet our ISO 9001:2015 standards before dispatch.</p>
            </div>
          </div>
        </div>
        <div class="reveal">
          <a href="/about-us" class="inline-flex items-center gap-3 bg-[#1A56DB] text-white font-black px-8 py-4 uppercase tracking-widest text-sm hover:-translate-y-1 hover:shadow-xl active:scale-95 transition-all duration-300 rounded-none">
            Learn More About Us
            <span class="material-symbols-outlined text-base">arrow_forward</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Section: Why Choose Snap Marketing? -->
<section class="bg-[#0A0A0A] py-24 px-4 sm:px-8 lg:px-20">
  <div class="max-w-screen-xl mx-auto flex flex-col lg:flex-row lg:items-center lg:gap-16">
    <!-- Left: Visual -->
    <div class="reveal hidden lg:block w-full max-w-lg shrink-0">
      <div class="overflow-hidden shadow-2xl">
        <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=800&q=85" alt="Why Choose Snap Marketing" class="w-full object-cover" style="aspect-ratio:3/2;" />
      </div>
    </div>
    <!-- Right: Features -->
    <div class="flex flex-col gap-6 w-full">
      <div class="reveal">
        <span class="inline-block bg-[#FBBF24] text-black font-black text-xs px-4 py-1.5 uppercase tracking-widest">Why Choose Us</span>
      </div>
      <div class="reveal">
        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black leading-tight text-white">Why Choose Snap Marketing?</h2>
      </div>
      <!-- Mobile image -->
      <div class="reveal lg:hidden mb-4">
        <div class="overflow-hidden shadow-xl">
          <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=800&q=85" alt="Why Choose Snap Marketing" class="w-full object-cover" style="aspect-ratio:16/9;" />
        </div>
      </div>
      <div class="flex flex-col gap-5">
        <div class="reveal flex gap-4 items-start">
          <div class="why-icon-box w-12 h-12 shrink-0 bg-[#1A56DB] flex items-center justify-center">
            <span class="material-symbols-outlined text-white">verified</span>
          </div>
          <div>
            <div class="font-black text-lg text-white mb-1">Genuine Brand Products</div>
            <div class="text-sm leading-relaxed text-zinc-400">Certified equipment from global manufacturers. Zero counterfeits, zero compromise.</div>
          </div>
        </div>
        <div class="reveal flex gap-4 items-start">
          <div class="why-icon-box w-12 h-12 shrink-0 bg-[#1A56DB] flex items-center justify-center">
            <span class="material-symbols-outlined text-white">local_shipping</span>
          </div>
          <div>
            <div class="font-black text-lg text-white mb-1">Pan-India Fast Shipping</div>
            <div class="text-sm leading-relaxed text-zinc-400">Reliable delivery to dealers and enterprises across all major Indian cities.</div>
          </div>
        </div>
        <div class="reveal flex gap-4 items-start">
          <div class="why-icon-box w-12 h-12 shrink-0 bg-[#1A56DB] flex items-center justify-center">
            <span class="material-symbols-outlined text-white">support_agent</span>
          </div>
          <div>
            <div class="font-black text-lg text-white mb-1">24/7 Procurement Support</div>
            <div class="text-sm leading-relaxed text-zinc-400">Dedicated account managers available round the clock for bulk orders and queries.</div>
          </div>
        </div>
        <div class="reveal flex gap-4 items-start">
          <div class="why-icon-box w-12 h-12 shrink-0 bg-[#1A56DB] flex items-center justify-center">
            <span class="material-symbols-outlined text-white">currency_rupee</span>
          </div>
          <div>
            <div class="font-black text-lg text-white mb-1">Institutional Pricing</div>
            <div class="text-sm leading-relaxed text-zinc-400">Competitive bulk rates with volume discounts and flexible payment terms for corporates.</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- Section: Brand Partners Marquee -->
<section class="bg-[#FFFFFF] py-24 px-4 sm:px-8 lg:px-[7.7vw]">
  <div class="w-full mx-auto xl:max-w-[1440px]">
    <div class="text-center mb-8 sm:mb-10 lg:mb-12 reveal">
      <span class="inline-block bg-[#FBBF24] text-black font-black text-xs px-4 py-1.5 uppercase tracking-widest mb-3">Brand Partners</span>
      <h2 class="text-2xl sm:text-4xl lg:text-5xl xl:text-6xl font-black text-[#0A0A0A] mb-4 sm:mb-6">Global Brand Connections</h2>
      <p class="text-base sm:text-lg leading-relaxed text-zinc-600 font-medium text-center px-2">Partnering with global brands to deliver premium products and enterprise solutions.</p>
    </div>
    <!-- 3D Perspective Marquee Grid (Bhakti-style tilted layout) -->
    <div class="relative reveal" style="overflow:hidden;">
      <div class="relative flex max-w-full w-full flex-row items-center justify-center overflow-hidden bg-[#FFFFFF] px-1 lg:px-2" style="height:600px;perspective:800px;">
        <!-- Single 3D-tilted wrapper for ALL columns -->
        <div class="flex flex-row items-center gap-4 sm:gap-4 lg:gap-4" style="transform:translateX(0) translateY(-1px) translateZ(-50px) rotateX(15deg) rotateY(-5deg) rotateZ(12deg);">

          <!-- Column 1 - scrolls UP -->
          <div class="marquee-col" style="display:flex;flex-direction:column;gap:16px;overflow:hidden;height:800px;flex-shrink:0;">
            <div class="animate-marquee-vertical" style="display:flex;flex-direction:column;gap:16px;">
              <?php
              $brands_col1 = [
                ['name'=>'Blue Star', 'slug'=>'blue_star'],
                ['name'=>'Euronics', 'slug'=>'euronics'],
                ['name'=>'Aquaguard', 'slug'=>'aquaguard'],
                ['name'=>'Eureka Forbes', 'slug'=>'eureka_forbes'],
                ['name'=>'Voltas', 'slug'=>'voltas'],
                ['name'=>'Usha', 'slug'=>'usha'],
                ['name'=>'Haier', 'slug'=>'haier'],
              ];
              foreach(array_merge($brands_col1, $brands_col1) as $b): ?>
              <div class="group brand-card bg-white shadow-xl shadow-blue-900/5 border-2 border-slate-100 hover:border-[#FBBF24] p-4 flex items-center justify-center cursor-pointer rounded-none hover:-translate-y-2 hover:shadow-2xl transition-all duration-300" style="width:200px;height:200px;flex-shrink:0;">
                <img src="<?= esc_url( get_template_directory_uri() . '/images/brands/' . $b['slug'] . '.svg' ) ?>" 
                     alt="<?= esc_attr($b['name']) ?> Logo" 
                     title="<?= esc_attr($b['name']) ?>" 
                     loading="lazy" 
                     class="max-w-[165px] max-h-28 w-auto h-auto object-contain transition-transform duration-300 group-hover:scale-110" 
                     onerror="this.onerror=null; this.src='<?= esc_url( get_template_directory_uri() . '/images/brands/' . $b['slug'] . '.png' ) ?>';" />
              </div>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Column 2 - scrolls DOWN -->
          <div class="marquee-col" style="display:flex;flex-direction:column;gap:16px;overflow:hidden;height:800px;flex-shrink:0;">
            <div class="animate-marquee-vertical-reverse" style="display:flex;flex-direction:column;gap:16px;">
              <?php
              $brands_col2 = [
                ['name'=>'Kimberly-Clark', 'slug'=>'kimberly_clark'],
                ['name'=>'Aquarius', 'slug'=>'aquarius_kimberly_clark'],
                ['name'=>'Scott', 'slug'=>'scott'],
                ['name'=>'Kleenex', 'slug'=>'kleenex'],
                ['name'=>'WypAll', 'slug'=>'wypall'],
                ['name'=>'Kimcare', 'slug'=>'kimcare'],
                ['name'=>'Kimtech', 'slug'=>'kimtech'],
              ];
              foreach(array_merge($brands_col2, $brands_col2) as $b): ?>
              <div class="group brand-card bg-white shadow-xl shadow-blue-900/5 border-2 border-slate-100 hover:border-[#FBBF24] p-4 flex items-center justify-center cursor-pointer rounded-none hover:-translate-y-2 hover:shadow-2xl transition-all duration-300" style="width:200px;height:200px;flex-shrink:0;">
                <img src="<?= esc_url( get_template_directory_uri() . '/images/brands/' . $b['slug'] . '.svg' ) ?>" 
                     alt="<?= esc_attr($b['name']) ?> Logo" 
                     title="<?= esc_attr($b['name']) ?>" 
                     loading="lazy" 
                     class="max-w-[165px] max-h-28 w-auto h-auto object-contain transition-transform duration-300 group-hover:scale-110" 
                     onerror="this.onerror=null; this.src='<?= esc_url( get_template_directory_uri() . '/images/brands/' . $b['slug'] . '.png' ) ?>';" />
              </div>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Column 3 - scrolls UP -->
          <div class="marquee-col" style="display:flex;flex-direction:column;gap:16px;overflow:hidden;height:800px;flex-shrink:0;">
            <div class="animate-marquee-vertical" style="display:flex;flex-direction:column;gap:16px;">
              <?php
              $brands_col3 = [
                ['name'=>'Nestlé', 'slug'=>'nestle'],
                ['name'=>'Nescafé', 'slug'=>'nescafe'],
                ['name'=>'Nestea', 'slug'=>'nestea'],
                ['name'=>'Everyday', 'slug'=>'everyday'],
                ['name'=>'Tata', 'slug'=>'tata'],
                ['name'=>'Tetley', 'slug'=>'tetley'],
                ['name'=>'Nettare', 'slug'=>'nettare'],
              ];
              foreach(array_merge($brands_col3, $brands_col3) as $b): ?>
              <div class="group brand-card bg-white shadow-xl shadow-blue-900/5 border-2 border-slate-100 hover:border-[#FBBF24] p-4 flex items-center justify-center cursor-pointer rounded-none hover:-translate-y-2 hover:shadow-2xl transition-all duration-300" style="width:200px;height:200px;flex-shrink:0;">
                <img src="<?= esc_url( get_template_directory_uri() . '/images/brands/' . $b['slug'] . '.svg' ) ?>" 
                     alt="<?= esc_attr($b['name']) ?> Logo" 
                     title="<?= esc_attr($b['name']) ?>" 
                     loading="lazy" 
                     class="max-w-[165px] max-h-28 w-auto h-auto object-contain transition-transform duration-300 group-hover:scale-110" 
                     onerror="this.onerror=null; this.src='<?= esc_url( get_template_directory_uri() . '/images/brands/' . $b['slug'] . '.png' ) ?>';" />
              </div>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Column 4 - scrolls DOWN -->
          <div class="marquee-col" style="display:flex;flex-direction:column;gap:16px;overflow:hidden;height:800px;flex-shrink:0;">
            <div class="animate-marquee-vertical-reverse" style="display:flex;flex-direction:column;gap:16px;">
              <?php
              $brands_col4 = [
                ['name'=>'Prima', 'slug'=>'prima'],
                ['name'=>'Prisma', 'slug'=>'prisma'],
                ['name'=>'Femmina', 'slug'=>'femmina'],
                ['name'=>'EZ Care', 'slug'=>'ez_care'],
                ['name'=>'Jonree', 'slug'=>'jonree'],
                ['name'=>'Krysta', 'slug'=>'krysta'],
                ['name'=>'Easy Wipe', 'slug'=>'easy_wipe'],
              ];
              foreach(array_merge($brands_col4, $brands_col4) as $b): ?>
              <div class="group brand-card bg-white shadow-xl shadow-blue-900/5 border-2 border-slate-100 hover:border-[#FBBF24] p-4 flex items-center justify-center cursor-pointer rounded-none hover:-translate-y-2 hover:shadow-2xl transition-all duration-300" style="width:200px;height:200px;flex-shrink:0;">
                <img src="<?= esc_url( get_template_directory_uri() . '/images/brands/' . $b['slug'] . '.svg' ) ?>" 
                     alt="<?= esc_attr($b['name']) ?> Logo" 
                     title="<?= esc_attr($b['name']) ?>" 
                     loading="lazy" 
                     class="max-w-[165px] max-h-28 w-auto h-auto object-contain transition-transform duration-300 group-hover:scale-110" 
                     onerror="this.onerror=null; this.src='<?= esc_url( get_template_directory_uri() . '/images/brands/' . $b['slug'] . '.png' ) ?>';" />
              </div>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Column 5 - scrolls UP -->
          <div class="marquee-col" style="display:flex;flex-direction:column;gap:16px;overflow:hidden;height:800px;flex-shrink:0;">
            <div class="animate-marquee-vertical" style="display:flex;flex-direction:column;gap:16px;">
              <?php
              $brands_col5 = [
                ['name'=>'Dedakj', 'slug'=>'dedakj'],
                ['name'=>'Owgels', 'slug'=>'owgels'],
                ['name'=>'Bio Tab', 'slug'=>'bio_tab'],
                ['name'=>'Amway', 'slug'=>'amway'],
                ['name'=>'Nutrilite', 'slug'=>'nutrilite'],
                ['name'=>'Instafresh', 'slug'=>'instafresh'],
              ];
              foreach(array_merge($brands_col5, $brands_col5) as $b): ?>
              <div class="group brand-card bg-white shadow-xl shadow-blue-900/5 border-2 border-slate-100 hover:border-[#FBBF24] p-4 flex items-center justify-center cursor-pointer rounded-none hover:-translate-y-2 hover:shadow-2xl transition-all duration-300" style="width:200px;height:200px;flex-shrink:0;">
                <img src="<?= esc_url( get_template_directory_uri() . '/images/brands/' . $b['slug'] . '.svg' ) ?>" 
                     alt="<?= esc_attr($b['name']) ?> Logo" 
                     title="<?= esc_attr($b['name']) ?>" 
                     loading="lazy" 
                     class="max-w-[165px] max-h-28 w-auto h-auto object-contain transition-transform duration-300 group-hover:scale-110" 
                     onerror="this.onerror=null; this.src='<?= esc_url( get_template_directory_uri() . '/images/brands/' . $b['slug'] . '.png' ) ?>';" />
              </div>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Column 6 - scrolls DOWN -->
          <div class="marquee-col" style="display:flex;flex-direction:column;gap:16px;overflow:hidden;height:800px;flex-shrink:0;">
            <div class="animate-marquee-vertical-reverse" style="display:flex;flex-direction:column;gap:16px;">
              <?php
              $brands_col6 = [
                ['name'=>'Aquagenie', 'slug'=>'aquagenie'],
                ['name'=>'Cera', 'slug'=>'cera'],
                ['name'=>'Hindware', 'slug'=>'hindware'],
                ['name'=>'Parryware', 'slug'=>'parryware'],
                ['name'=>'Kimsoft', 'slug'=>'kimsoft'],
                ['name'=>'IndiaMART', 'slug'=>'indiamart'],
              ];
              foreach(array_merge($brands_col6, $brands_col6) as $b): ?>
              <div class="group brand-card bg-white shadow-xl shadow-blue-900/5 border-2 border-slate-100 hover:border-[#FBBF24] p-4 flex items-center justify-center cursor-pointer rounded-none hover:-translate-y-2 hover:shadow-2xl transition-all duration-300" style="width:200px;height:200px;flex-shrink:0;">
                <img src="<?= esc_url( get_template_directory_uri() . '/images/brands/' . $b['slug'] . '.svg' ) ?>" 
                     alt="<?= esc_attr($b['name']) ?> Logo" 
                     title="<?= esc_attr($b['name']) ?>" 
                     loading="lazy" 
                     class="max-w-[165px] max-h-28 w-auto h-auto object-contain transition-transform duration-300 group-hover:scale-110" 
                     onerror="this.onerror=null; this.src='<?= esc_url( get_template_directory_uri() . '/images/brands/' . $b['slug'] . '.png' ) ?>';" />
              </div>
              <?php endforeach; ?>
            </div>
          </div>

        </div>
      </div>
      <!-- 4-sided fade overlays (Bhakti-style) -->
      <div style="pointer-events:none;position:absolute;inset:0;top:-2px;height:25%;background:linear-gradient(to bottom,white,transparent);"></div>
      <div style="pointer-events:none;position:absolute;bottom:0;left:0;right:0;height:25%;background:linear-gradient(to top,white,transparent);"></div>
      <div style="pointer-events:none;position:absolute;inset:0;left:0;width:25%;background:linear-gradient(to right,white,transparent);"></div>
      <div style="pointer-events:none;position:absolute;top:0;right:0;bottom:0;width:25%;background:linear-gradient(to left,white,transparent);"></div>
    </div>
  </div>
</section>

<!-- Section 6: Industries We Serve -->
<?php
$industries = [
    [
        'id'       => 'medical',
        'label'    => 'Medical & Healthcare',
        'icon'     => 'medical_services',
        'tag'      => 'Medical',
        'cats'     => ['b2b-air-purifiers', 'b2b-commercial-refrigeration'],
        'headline' => 'Certified Equipment for Clinical Environments',
        'desc'     => 'Blue Star sterilizers, Kimberly-Clark hygiene solutions, and bulk sanitization consumables for hospitals and clinics.',
        'image'    => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=1200&q=80&auto=format&fit=crop',
    ],
    [
        'id'       => 'hospitality',
        'label'    => 'Hotels & Hospitality',
        'icon'     => 'hotel',
        'tag'      => 'Hospitality',
        'cats'     => ['b2b-room-air-conditioners', 'b2b-air-coolers'],
        'headline' => 'Scale-Ready Equipment for Hospitality Operations',
        'desc'     => 'Industrial laundry systems, housekeeping carts, and kitchen-grade appliances built for high-throughput hospitality.',
        'image'    => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1200&q=80&auto=format&fit=crop',
    ],
    [
        'id'       => 'corporate',
        'label'    => 'Corporate Offices',
        'icon'     => 'corporate_fare',
        'tag'      => 'Corporate',
        'cats'     => ['b2b-air-purifiers', 'water-coolers'],
        'headline' => 'Workplace Hygiene & Facility Management',
        'desc'     => 'Smart dispensers, air purification systems, and consumables keeping corporate environments clean and compliant.',
        'image'    => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=1200&q=80&auto=format&fit=crop',
    ],
    [
        'id'       => 'industrial',
        'label'    => 'Industrial Facilities',
        'icon'     => 'factory',
        'tag'      => 'Manufacturing',
        'cats'     => ['b2b-commercial-refrigeration', 'cold-storages'],
        'headline' => 'Heavy-Duty Equipment for Industrial Scale',
        'desc'     => 'Euronics industrial scrubbers, cold-chain equipment, and PPE for manufacturing plants and logistics facilities.',
        'image'    => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=1200&q=80&auto=format&fit=crop',
    ],
];
?>
<section class="bg-[#1A56DB] py-24">
    <div class="container mx-auto px-8 max-w-[1536px]">
        <div class="mb-12 border-l-8 border-[#FBBF24] pl-6">
            <h2 class="text-white text-4xl font-black uppercase tracking-tight">Industries We Serve</h2>
            <p class="text-[#FBBF24] font-bold mt-2 uppercase tracking-widest text-sm font-jakarta">Precision-matched equipment for every operational environment</p>
        </div>

        <!-- Horizontal Tabs Nav -->
        <div class="mb-12 border-b-2 border-white/20">
            <ul role="tablist" class="flex flex-wrap gap-2 -mb-[2px] overflow-x-auto no-scrollbar">
                <?php foreach ($industries as $index => $ind) : ?>
                    <li role="presentation">
                        <button role="tab" 
                                id="tab-<?php echo esc_attr($ind['id']); ?>"
                                aria-controls="panel-<?php echo esc_attr($ind['id']); ?>"
                                aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                                data-industry-tab="<?php echo esc_attr($ind['id']); ?>"
                                class="flex items-center gap-3 px-8 py-4 font-black text-sm uppercase tracking-wider transition-all border-b-4 duration-300 rounded-none <?php echo $index === 0 ? 'bg-[#FBBF24] text-[#0A0A0A] border-[#1A56DB]' : 'text-white border-transparent hover:bg-white/10 hover:border-[#FBBF24]' ; ?>">
                            <span class="material-symbols-outlined text-lg"><?php echo esc_html($ind['icon']); ?></span>
                            <?php echo esc_html($ind['label']); ?>
                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Tab Content Panels -->
        <div class="relative min-h-[500px]">
            <?php foreach ($industries as $index => $ind) : ?>
                <div id="panel-<?php echo esc_attr($ind['id']); ?>" 
                     role="tabpanel" 
                     aria-labelledby="tab-<?php echo esc_attr($ind['id']); ?>"
                     data-industry-panel="<?php echo esc_attr($ind['id']); ?>"
                     class="industry-panel-transition <?php echo $index === 0 ? 'grid' : 'hidden' ; ?> grid-cols-1 lg:grid-cols-12 gap-8 bg-zinc-50 p-8 lg:p-12 border-b-4 border-[#FBBF24]">
                    
                    <!-- Left: Hero Image + Info (5 Columns) -->
                    <div class="lg:col-span-5 flex flex-col gap-6">
                        <div class="relative aspect-[4/3] overflow-hidden group">
                            <img src="<?php echo esc_url($ind['image']); ?>" alt="<?php echo esc_attr($ind['label']); ?>" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500 rounded-none">
                            <span class="absolute top-4 left-4 bg-[#FBBF24] text-black font-black text-[10px] px-3 py-1.5 uppercase tracking-widest"><?php echo esc_html($ind['tag']); ?></span>
                        </div>
                        <div class="flex flex-col">
                            <h3 class="text-[#0A0A0A] text-3xl font-black uppercase mb-4 leading-tight tracking-tight"><?php echo esc_html($ind['headline']); ?></h3>
                            <p class="text-zinc-600 leading-relaxed mb-6 font-medium"><?php echo esc_html($ind['desc']); ?></p>
                            <a href="/shop" class="bg-[#1A56DB] text-white border-2 border-[#1A56DB] font-black py-4 px-8 uppercase text-sm hover:bg-[#0A0A0A] hover:border-[#0A0A0A] transition-all italic flex items-center justify-center gap-2 w-fit rounded-none">
                                Browse Industry Catalog <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                    <!-- Right: Dynamic WooCommerce Product Cards (7 Columns) -->
                    <div class="lg:col-span-7">
                        <h4 class="text-[#1A56DB] font-black text-sm uppercase tracking-widest mb-6 pb-2 border-b-2 border-[#FBBF24] flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">inventory_2</span> Recommended Equipment
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <?php
                            // Fetch randomized WooCommerce products for this industry on each page load
                            $args = [
                                'limit'    => 2,
                                'status'   => 'publish',
                                'orderby'  => 'rand',
                                'category' => $ind['cats'],
                            ];
                            $products = wc_get_products($args);

                            // Fallback if no products in target categories
                            if (empty($products)) {
                                $products = wc_get_products([
                                    'limit'      => 2,
                                    'status'     => 'publish',
                                    'orderby'    => 'rand',
                                    'visibility' => 'catalog'
                                ]);
                            }

                            if (!empty($products)) {
                                $badge_labels = ['BEST SELLER', 'TOP PICK', 'POPULAR', 'NEW'];
                                $card_idx = 0;
                                foreach ($products as $product) {
                                    $image_url = wp_get_attachment_image_url($product->get_image_id(), 'large') ?: wc_placeholder_img_src();
                                    $title = $product->get_name();
                                    $terms = wc_get_product_terms($product->get_id(), 'product_cat', ['fields' => 'names']);
                                    $brand = !empty($terms) ? $terms[0] : 'SNAP STITCH';
                                    
                                    $specs = get_post_meta($product->get_id(), '_technical_specs', true);
                                    $spec1 = 'Standard Size';
                                    $spec2 = 'Industrial Grade';
                                    if (is_array($specs) && count($specs) > 0) {
                                        $spec1 = esc_html($specs[0]['name'] . ': ' . $specs[0]['value']);
                                        if (count($specs) > 1) {
                                            $spec2 = esc_html($specs[1]['name'] . ': ' . $specs[1]['value']);
                                        }
                                    }
                                    $badge = $badge_labels[($card_idx + $index) % count($badge_labels)];
                                    $is_b2b = snap_stitch_is_b2b_product($product->get_id());
                                    ?>
                                    <div class="group bg-white flex flex-col border border-zinc-900 hover:shadow-2xl transition-all duration-300 rounded-none">
                                        <div class="relative bg-zinc-100 aspect-square flex items-center justify-center p-6 overflow-hidden rounded-none">
                                            <span class="absolute top-0 left-0 bg-[#FBBF24] text-black font-black text-[10px] px-3 py-1.5 uppercase tracking-widest z-10"><?php echo esc_html($badge); ?></span>
                                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>" class="w-2/3 h-2/3 object-contain mix-blend-multiply group-hover:scale-105 transition-transform duration-500 rounded-none" />
                                        </div>
                                        <div class="p-6 flex-grow flex flex-col">
                                            <span class="inline-block bg-[#1A56DB] text-white text-[10px] font-black px-2 py-0.5 rounded-none w-fit mb-3 uppercase tracking-widest"><?php echo esc_html($brand); ?></span>
                                            <h5 class="text-[#0A0A0A] font-black text-lg mb-3 leading-tight line-clamp-2"><?php echo esc_html($title); ?></h5>
                                            <div class="text-zinc-500 text-xs font-medium mb-6 space-y-1">
                                                <p class="truncate"><?php echo $spec1; ?></p>
                                                <p class="truncate"><?php echo $spec2; ?></p>
                                            </div>
                                            <div class="mt-auto flex gap-2">
                                                <a href="<?php echo esc_url($product->get_permalink()); ?>" class="flex-grow bg-[#FBBF24] text-black text-center font-black py-3 px-4 uppercase text-[10px] hover:bg-yellow-500 transition-colors italic flex items-center justify-center rounded-none">
                                                    <?php echo $is_b2b ? '₹ Request Bulk Price' : 'View Details'; ?>
                                                </a>
                                                <?php if (!$is_b2b && $product->is_purchasable() && $product->is_in_stock()) : ?>
                                                    <a href="?add-to-cart=<?php echo esc_attr($product->get_id()); ?>" data-quantity="1" class="bg-[#1A56DB] text-white p-3 flex items-center justify-center hover:bg-black transition-colors ajax_add_to_cart rounded-none" data-product_id="<?php echo esc_attr($product->get_id()); ?>" aria-label="Add to cart">
                                                        <span class="material-symbols-outlined text-sm">shopping_cart</span>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $card_idx++;
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Vanilla JS for smooth tab switching and transitions -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('[data-industry-tab]');
    const panels = document.querySelectorAll('[data-industry-panel]');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const target = tab.dataset.industryTab;
            
            // Deactivate all tabs
            tabs.forEach(t => {
                t.setAttribute('aria-selected', 'false');
                t.classList.remove('bg-[#FBBF24]', 'text-[#0A0A0A]', 'border-[#1A56DB]');
                t.classList.add('text-white', 'border-transparent', 'hover:bg-white/10', 'hover:border-[#FBBF24]');
            });

            // Activate current tab
            tab.setAttribute('aria-selected', 'true');
            tab.classList.remove('text-white', 'border-transparent', 'hover:bg-white/10', 'hover:border-[#FBBF24]');
            tab.classList.add('bg-[#FBBF24]', 'text-[#0A0A0A]', 'border-[#1A56DB]');

            // Fade out and hide panels, then show active one
            panels.forEach(p => {
                p.classList.add('hidden');
                p.classList.remove('grid');
            });

            const activePanel = document.getElementById(`panel-${target}`);
            if (activePanel) {
                activePanel.classList.remove('hidden');
                activePanel.classList.add('grid');
            }
        });
    });
});
</script>

<style>
/* Smooth transition style for panels */
.industry-panel-transition {
    animation: panelFadeIn 0.4s ease-out forwards;
}

@keyframes panelFadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<!-- Section: Process Management (How It Works – Industrial-Scale Order Fulfillment) -->
<section class="bg-[#FFFFFF] py-24 overflow-hidden">
    <div class="container mx-auto px-8 relative flex flex-col gap-6 xl:min-h-[2200px] w-full">
        <div class="mx-auto text-center">
            <p class="inline-block py-1.5 px-3.5 text-xs font-black uppercase tracking-widest border-2 border-[#1A56DB] bg-[#1A56DB]/10 text-[#1A56DB] mb-4">Process Management</p>
            <h2 class="font-black uppercase tracking-tight lg:text-5xl text-3xl text-black">Industrial-Scale Order Fulfillment</h2>
            <p class="text-zinc-600 font-medium max-w-2xl mx-auto mt-4 text-sm md:text-base">Experience Snap Marketing's streamlined corporate procurement process engineered for enterprise reliability, compliance, and guaranteed delivery.</p>
        </div>

        <div id="process-svg-container" class="relative w-full max-w-[320px] md:max-w-[744px] xl:max-w-[1110px] mt-16 mx-auto h-[908px] md:h-[2128px] xl:h-[1851px]">
            
            <!-- Desktop SVG -->
            <div class="svg-container h-full xl:flex hidden pointer-events-none w-full absolute top-0 left-0 justify-center items-center z-0">
                <svg data-hiw-svg="true" class="hiw-line-desktop" width="1110" height="1851" viewBox="0 0 1110 1851" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M293 245C293 245 982.532 152.487 1020 444.5C1059.34 751.135 307.651 427.758 284 736C259.284 1058.11 987.03 759.333 1037 1078.5C1096.32 1457.41 76.9361 971.376 94.4998 1354.5C111.046 1715.43 957.5 1688 957.5 1688" stroke="#1A56DB" stroke-width="8" stroke-linecap="square" style="stroke-dashoffset: 4766px; stroke-dasharray: 4766.23; transition: stroke-dashoffset 0.1s ease-out;"></path>
                </svg>
            </div>
            
            <!-- Tablet SVG -->
            <div class="svg-container h-full xl:hidden md:flex hidden pointer-events-none w-full absolute top-0 left-0 justify-center items-center z-0">
                <svg data-hiw-svg="true" class="hiw-line-tablet" width="744" height="2128" viewBox="0 0 744 2128" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M155 168.5C155 168.5 599.832 241.232 621 453.5C643.654 680.676 167.935 578.564 155 806.5C143.871 1002.6 465.793 1008.11 462.5 1204.5C459.277 1396.74 156.671 1396.74 155 1589C153.492 1762.51 399.5 1960 399.5 1960" stroke="#1A56DB" stroke-width="6" stroke-linecap="square" style="stroke-dashoffset: 2718px; stroke-dasharray: 2718.54; transition: stroke-dashoffset 0.1s ease-out;"></path>
                </svg>
            </div>
            
            <!-- Mobile SVG -->
            <div class="svg-container h-full md:hidden flex pointer-events-none w-full absolute top-0 left-0 justify-center items-center z-0">
                <svg data-hiw-svg="true" class="hiw-line-mobile" width="320" height="908" viewBox="0 0 320 908" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M60.0003 69.5C60.0003 69.5 278.851 120.833 270.5 222C262.594 317.783 56.8652 253.442 60.0003 349.5C62.4685 425.123 195.269 410.369 197.5 486C199.635 558.372 89.0992 557.236 79.5003 629C67.9425 715.41 197.5 818.5 197.5 818.5" stroke="#1A56DB" stroke-width="4" stroke-linecap="square" style="stroke-dashoffset: 1178px; stroke-dasharray: 1178.73; transition: stroke-dashoffset 0.1s ease-out;"></path>
                </svg>
            </div>

            <!-- Step 1 -->
            <div class="hiw-card z-10 absolute top-[2%] md:top-[3%] xl:top-[9%] left-[0%] md:left-[4%] xl:left-[12%] flex w-[152px] sm:w-[200px] md:w-[270px] lg:w-[340px] shadow-[8px_8px_0px_#1A56DB] border-2 border-zinc-200 bg-white p-4 lg:p-6 gap-4 transition-all duration-700 ease-[cubic-bezier(0.22,1,0.36,1)] opacity-0 translate-y-6 scale-95 blur-sm">
                <div class="w-10 h-10 lg:w-16 lg:h-16 shrink-0 bg-[#1A56DB] flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-2xl lg:text-4xl">shopping_cart</span>
                </div>
                <div class="flex flex-col w-full">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <h3 class="text-sm md:text-lg lg:text-xl font-black text-black uppercase leading-tight">Order Placed</h3>
                        <div class="h-6 w-6 lg:h-8 lg:w-8 bg-[#FBBF24] text-black font-black flex items-center justify-center text-xs lg:text-sm shrink-0">1</div>
                    </div>
                    <p class="text-xs lg:text-sm font-medium text-zinc-600 leading-relaxed">Customer submits an enquiry through our platform, providing detailed specifications and requirements.</p>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="hiw-card z-10 absolute top-[20%] md:top-[20%] xl:top-[22%] right-[0%] xl:right-[3%] flex w-[152px] sm:w-[200px] md:w-[270px] lg:w-[340px] shadow-[8px_8px_0px_#1A56DB] border-2 border-zinc-200 bg-white p-4 lg:p-6 gap-4 transition-all duration-700 ease-[cubic-bezier(0.22,1,0.36,1)] opacity-0 translate-y-6 scale-95 blur-sm">
                <div class="w-10 h-10 lg:w-16 lg:h-16 shrink-0 bg-[#1A56DB] flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-2xl lg:text-4xl">assignment</span>
                </div>
                <div class="flex flex-col w-full">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <h3 class="text-sm md:text-lg lg:text-xl font-black text-black uppercase leading-tight">Account Work</h3>
                        <div class="h-6 w-6 lg:h-8 lg:w-8 bg-[#FBBF24] text-black font-black flex items-center justify-center text-xs lg:text-sm shrink-0">2</div>
                    </div>
                    <p class="text-xs lg:text-sm font-medium text-zinc-600 leading-relaxed">Order verification and account processing to ensure accuracy and enterprise satisfaction.</p>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="hiw-card z-10 absolute top-[33%] md:top-[35%] xl:top-[38%] left-[0%] md:left-[6%] xl:left-[12%] flex w-[152px] sm:w-[200px] md:w-[270px] lg:w-[340px] shadow-[8px_8px_0px_#1A56DB] border-2 border-zinc-200 bg-white p-4 lg:p-6 gap-4 transition-all duration-700 ease-[cubic-bezier(0.22,1,0.36,1)] opacity-0 translate-y-6 scale-95 blur-sm">
                <div class="w-10 h-10 lg:w-16 lg:h-16 shrink-0 bg-[#1A56DB] flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-2xl lg:text-4xl">precision_manufacturing</span>
                </div>
                <div class="flex flex-col w-full">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <h3 class="text-sm md:text-lg lg:text-xl font-black text-black uppercase leading-tight">Processing</h3>
                        <div class="h-6 w-6 lg:h-8 lg:w-8 bg-[#FBBF24] text-black font-black flex items-center justify-center text-xs lg:text-sm shrink-0">3</div>
                    </div>
                    <p class="text-xs lg:text-sm font-medium text-zinc-600 leading-relaxed">Order preparation with strict industrial quality checks and inventory management for optimal fulfillment.</p>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="hiw-card z-10 absolute top-[50%] md:top-[54%] xl:top-[56%] right-[0%] md:right-[20%] xl:right-[3%] flex w-[152px] sm:w-[200px] md:w-[270px] lg:w-[340px] shadow-[8px_8px_0px_#1A56DB] border-2 border-zinc-200 bg-white p-4 lg:p-6 gap-4 transition-all duration-700 ease-[cubic-bezier(0.22,1,0.36,1)] opacity-0 translate-y-6 scale-95 blur-sm">
                <div class="w-10 h-10 lg:w-16 lg:h-16 shrink-0 bg-[#1A56DB] flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-2xl lg:text-4xl">inventory_2</span>
                </div>
                <div class="flex flex-col w-full">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <h3 class="text-sm md:text-lg lg:text-xl font-black text-black uppercase leading-tight">Packaging</h3>
                        <div class="h-6 w-6 lg:h-8 lg:w-8 bg-[#FBBF24] text-black font-black flex items-center justify-center text-xs lg:text-sm shrink-0">4</div>
                    </div>
                    <p class="text-xs lg:text-sm font-medium text-zinc-600 leading-relaxed">Secure bulk packing with heavy-duty protective materials ensuring safe transit.</p>
                </div>
            </div>

            <!-- Step 5 -->
            <div class="hiw-card z-10 absolute top-[65%] md:top-[70%] xl:top-[71%] left-[5%] md:left-[6%] xl:left-[3%] flex w-[152px] sm:w-[200px] md:w-[270px] lg:w-[340px] shadow-[8px_8px_0px_#1A56DB] border-2 border-zinc-200 bg-white p-4 lg:p-6 gap-4 transition-all duration-700 ease-[cubic-bezier(0.22,1,0.36,1)] opacity-0 translate-y-6 scale-95 blur-sm">
                <div class="w-10 h-10 lg:w-16 lg:h-16 shrink-0 bg-[#1A56DB] flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-2xl lg:text-4xl">local_shipping</span>
                </div>
                <div class="flex flex-col w-full">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <h3 class="text-sm md:text-lg lg:text-xl font-black text-black uppercase leading-tight">Logistics</h3>
                        <div class="h-6 w-6 lg:h-8 lg:w-8 bg-[#FBBF24] text-black font-black flex items-center justify-center text-xs lg:text-sm shrink-0">5</div>
                    </div>
                    <p class="text-xs lg:text-sm font-medium text-zinc-600 leading-relaxed">Shipping coordination with trusted B2B carriers for reliable and timely delivery.</p>
                </div>
            </div>

            <!-- Step 6 -->
            <div class="hiw-card z-10 absolute top-[85%] md:top-[88%] xl:top-[89%] left-[35%] md:left-[30%] xl:left-[60%] flex w-[152px] sm:w-[200px] md:w-[270px] lg:w-[340px] shadow-[8px_8px_0px_#1A56DB] border-2 border-[#1A56DB] bg-[#0A0A0A] p-4 lg:p-6 gap-4 transition-all duration-700 ease-[cubic-bezier(0.22,1,0.36,1)] opacity-0 translate-y-6 scale-95 blur-sm">
                <div class="w-10 h-10 lg:w-16 lg:h-16 shrink-0 bg-[#FBBF24] flex items-center justify-center text-black">
                    <span class="material-symbols-outlined text-2xl lg:text-4xl">task_alt</span>
                </div>
                <div class="flex flex-col w-full">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <h3 class="text-sm md:text-lg lg:text-xl font-black text-white uppercase leading-tight">Dispatch</h3>
                        <div class="h-6 w-6 lg:h-8 lg:w-8 bg-[#FBBF24] text-black font-black flex items-center justify-center text-xs lg:text-sm shrink-0">6</div>
                    </div>
                    <p class="text-xs lg:text-sm font-medium text-zinc-400 leading-relaxed">Delivery complete with tracking confirmation and institutional guarantee.</p>
                </div>
            </div>

        </div>
    </div>
    
    <!-- SVG & Reveal Animation Logic -->
    <script>
    document.addEventListener("DOMContentLoaded", () => {
        const svgContainer = document.getElementById('process-svg-container');
        const paths = document.querySelectorAll('.svg-container svg path');
        const cards = document.querySelectorAll('.hiw-card');

        let ticking = false;
        const updatePaths = () => {
            if(!svgContainer) return;
            const rect = svgContainer.getBoundingClientRect();
            const windowHeight = window.innerHeight;
            
            let scrollPercentage = (windowHeight - rect.top) / (rect.height + windowHeight);
            scrollPercentage = Math.min(Math.max(scrollPercentage * 1.5 - 0.2, 0), 1);
            
            paths.forEach(path => {
                if (path.closest('.svg-container').offsetParent !== null) {
                    let length = path.getTotalLength();
                    if (!length || length === 0) {
                        if (path.closest('.hiw-line-desktop')) length = 4766;
                        else if (path.closest('.hiw-line-tablet')) length = 2718;
                        else length = 1178;
                    }
                    path.style.strokeDasharray = length;
                    path.style.strokeDashoffset = length * (1 - scrollPercentage);
                }
            });
            ticking = false;
        };

        const onScroll = () => {
            if (!ticking) {
                window.requestAnimationFrame(updatePaths);
                ticking = true;
            }
        };

        if(paths.length > 0 && svgContainer) {
            window.addEventListener('scroll', onScroll, { passive: true });
            window.addEventListener('resize', onScroll, { passive: true });
            setTimeout(updatePaths, 100);
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.remove('opacity-0', 'translate-y-6', 'scale-95', 'blur-sm');
                    entry.target.classList.add('opacity-100', 'translate-y-0', 'scale-100', 'blur-0');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            root: null,
            threshold: 0.2,
            rootMargin: "0px 0px -50px 0px"
        });

        cards.forEach(card => observer.observe(card));
    });
    </script>
</section>

<!-- Section 2: Shop by Category (Dynamic) -->
<!-- Section 2: Shop by Category (Matched Blue Star Categories with Semi-Transparent Film) -->
<section class="bg-[#0A0A0A] py-24 border-b-4 border-[#FBBF24]">
    <div class="container mx-auto px-8 max-w-[1536px]">
        <div class="mb-12 border-l-8 border-[#FBBF24] pl-6">
            <h2 class="text-white text-4xl font-black uppercase tracking-tight m-0">Shop by Category</h2>
            <p class="text-[#FBBF24] font-bold mt-2 uppercase tracking-widest text-sm">Engineered Air Conditioning, Refrigeration & Pure Water Systems</p>
        </div>

        <?php
        $curated_categories = [
            [
                'title'         => 'Room Air Conditioners',
                'desc'          => 'The most technologically advanced and energy efficient air conditioning solutions for small spaces.',
                'slug'          => 'b2b-room-air-conditioners',
                'fallback_slug' => 'air-conditioners-2',
                'image'         => get_template_directory_uri() . '/images/bluestar/room-ac.jpg',
                'badge'         => 'Commercial & Home',
            ],
            [
                'title'         => 'Central Air Conditioning Products',
                'desc'          => 'End-to-end solutions with a comprehensive range of VRF systems, ducted and packaged ACs, and chillers.',
                'slug'          => 'central-air-conditioning',
                'fallback_slug' => 'central-air-conditioning',
                'image'         => get_template_directory_uri() . '/images/bluestar/central-ac.jpg',
                'badge'         => 'B2B Enterprise',
            ],
            [
                'title'         => 'Commercial Refrigeration',
                'desc'          => 'Leaders in commercial refrigeration providing freezers, display coolers, and dispensers to industries.',
                'slug'          => 'b2b-commercial-refrigeration',
                'fallback_slug' => 'refrigeration-2',
                'image'         => get_template_directory_uri() . '/images/bluestar/commercial-ref.jpg',
                'badge'         => 'Heavy Duty',
            ],
            [
                'title'         => 'Air Coolers',
                'desc'          => 'Sleek and elegant air coolers packed with smart features to provide efficient industrial and commercial cooling.',
                'slug'          => 'b2b-air-coolers',
                'fallback_slug' => 'air-coolers-2',
                'image'         => get_template_directory_uri() . '/images/bluestar/air-cooler.jpg',
                'badge'         => 'Energy Efficient',
            ],
            [
                'title'         => 'Bottled Water Dispensers',
                'desc'          => 'Premium bottom and top loading bottled water dispensers with hot, cold, and normal dispensing for commercial spaces.',
                'slug'          => 'bottled-water-dispensers-b2b',
                'fallback_slug' => 'bottled-water-dispensers-2',
                'image'         => get_template_directory_uri() . '/images/bluestar/water-coolers.png',
                'badge'         => 'Dispensers',
            ],
            [
                'title'         => 'Air Purifiers',
                'desc'          => 'An array of purifiers built with superior multi-stage technology for clean and healthy indoor air quality.',
                'slug'          => 'b2b-air-purifiers',
                'fallback_slug' => 'air-purifiers-2',
                'image'         => get_template_directory_uri() . '/images/bluestar/air-purifier.jpg',
                'badge'         => 'Clean Air',
            ],
            [
                'title'         => 'Water Coolers',
                'desc'          => 'Get fast, cool water with this range of durable, value-for-money and eco-friendly coolers for commercial spaces.',
                'slug'          => 'water-coolers',
                'fallback_slug' => 'water-coolers',
                'image'         => get_template_directory_uri() . '/images/bluestar/water-coolers.png',
                'badge'         => 'Instant Cooling',
            ],
            [
                'title'         => 'Cold Storages',
                'desc'          => 'Modular cold rooms and walk-in chillers engineered for pharmaceuticals, agriculture, and supply chain logistics.',
                'slug'          => 'cold-storages',
                'fallback_slug' => 'cold-storages-2',
                'image'         => get_template_directory_uri() . '/images/bluestar/empg-tile.jpg',
                'badge'         => 'Cold Chain',
            ],
        ];
        ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($curated_categories as $item): 
                // Resolve existing WooCommerce term
                $cat_term = get_term_by('slug', $item['slug'], 'product_cat');
                if (!$cat_term && !empty($item['fallback_slug'])) {
                    $cat_term = get_term_by('slug', $item['fallback_slug'], 'product_cat');
                }
                $cat_url = ($cat_term && !is_wp_error($cat_term)) ? get_term_link($cat_term) : '/shop';
            ?>
            <a class="group relative bg-zinc-950 aspect-[4/3] sm:aspect-square overflow-hidden border border-zinc-800 hover:border-[#FBBF24] transition-all duration-500 flex flex-col justify-end p-6 lg:p-8 rounded-none block" href="<?php echo esc_url($cat_url); ?>">
                <!-- Background Image from Blue Star -->
                <img src="<?php echo esc_url($item['image']); ?>" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="<?php echo esc_attr($item['title']); ?>" loading="lazy" />
                
                <!-- Black Semi-Transparent Film Overlay -->
                <div class="absolute inset-0 bg-black/60 group-hover:bg-black/45 transition-colors duration-300 z-[2]"></div>
                
                <!-- Gradient Film for Content Readability -->
                <div class="absolute inset-0 bg-gradient-to-t from-[#0A0A0A] via-[#0A0A0A]/60 to-transparent z-[3]"></div>
                
                <!-- Gold Accent Top-Left Bar -->
                <div class="absolute top-0 left-0 w-12 h-1 bg-[#FBBF24] z-[4]"></div>
                
                <!-- Card Content -->
                <div class="relative z-10 flex flex-col justify-end h-full">
                    <span class="inline-block bg-[#FBBF24] text-black font-black text-[10px] px-2.5 py-1 mb-2 uppercase tracking-widest w-fit rounded-none"><?php echo esc_html($item['badge']); ?></span>
                    <h3 class="text-white text-xl sm:text-2xl font-black leading-tight mb-2 group-hover:text-[#FBBF24] transition-colors"><?php echo esc_html($item['title']); ?></h3>
                    <p class="text-zinc-300 text-xs line-clamp-2 leading-relaxed mb-4 font-normal"><?php echo esc_html($item['desc']); ?></p>
                    <div class="flex items-center gap-1.5 text-[#FBBF24] font-black text-xs uppercase tracking-widest group-hover:translate-x-1 transition-transform">
                        <span>View Products</span>
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Section: Featured Products (Carousel) -->
<section class="bg-[#FFFFFF] py-24 overflow-hidden">
    <div class="container mx-auto px-8 relative max-w-[1536px]">
        <div class="mb-8 border-l-8 border-[#FBBF24] pl-6">
            <h2 class="text-[#0A0A0A] text-4xl font-black uppercase tracking-tight">This Weeks Highlights</h2>
            <p class="text-[#1A56DB] font-bold mt-2 uppercase tracking-widest text-sm">Most Requested Products This Month</p>
        </div>

        <?php
        // Fetch top-level and main B2B categories with products
        $b2b_term = get_term_by('slug', 'b2b', 'product_cat');
        $b2b_id = $b2b_term ? (int) $b2b_term->term_id : 0;

        $candidate_terms = get_terms([
            'taxonomy'   => 'product_cat',
            'hide_empty' => true,
            'parent'     => 0,
        ]);

        if ($b2b_id) {
            $b2b_children = get_terms([
                'taxonomy'   => 'product_cat',
                'hide_empty' => true,
                'parent'     => $b2b_id,
            ]);
            if (!is_wp_error($b2b_children) && !empty($b2b_children)) {
                $candidate_terms = array_merge($b2b_children, $candidate_terms);
            }
        }

        $excluded_names = [
            'uncategorized', 'b2b products', 'b2c products', 'b2b', 'b2c',
            'exclude-from-search', 'exclude-from-search-2', 'field trial', 'specifications',
            'video', '3 star', '5 star', 'star smart enabled', 'entire range acs', 'best seller',
            'season sale', 'flagship range', 'premium range', 'classic range', 'special edition ac',
            'super energy efficient acs'
        ];

        $clean_cats = [];
        $seen = [];
        if (!is_wp_error($candidate_terms)) {
            foreach ($candidate_terms as $cat) {
                $n = strtolower(trim(html_entity_decode($cat->name)));
                if (!in_array($n, $excluded_names, true) && !in_array($n, $seen, true) && $cat->count > 0) {
                    $seen[] = $n;
                    $clean_cats[] = $cat;
                }
            }
        }
        $carousel_cats = $clean_cats;
        ?>

        <!-- Category Tabs Navigation with Left/Right Scroll Arrows -->
        <div class="mb-12 relative flex items-center gap-2">
            <!-- Left Arrow Button -->
            <button id="cat-tabs-prev" class="shrink-0 w-11 h-11 bg-[#0A0A0A] hover:bg-[#FBBF24] hover:text-black text-white flex items-center justify-center transition-all shadow-md z-10 border border-zinc-800 rounded-none cursor-pointer active:scale-95" aria-label="Scroll Categories Left">
                <span class="material-symbols-outlined text-xl">chevron_left</span>
            </button>

            <!-- Scrollable Tab Container -->
            <div id="featured-cat-tabs-scroll" class="overflow-x-auto no-scrollbar scroll-smooth flex-grow">
                <ul id="featured-cat-tabs" class="flex gap-2 w-max pb-[2px]">
                    <?php foreach ($carousel_cats as $index => $cat): 
                        $is_active = ($index === 0);
                        $active_classes = $is_active ? 'text-[#0A0A0A] bg-[#FBBF24] border-[#1A56DB]' : 'text-gray-600 bg-gray-100 hover:bg-gray-200 border-transparent';
                    ?>
                    <li class="shrink-0">
                        <button data-cat-id="<?php echo esc_attr($cat->term_id); ?>" class="feat-cat-btn inline-block px-5 py-3 font-bold text-xs uppercase tracking-wider rounded-none border-b-4 transition-all <?php echo $active_classes; ?>">
                            <?php echo esc_html($cat->name); ?>
                        </button>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Right Arrow Button -->
            <button id="cat-tabs-next" class="shrink-0 w-11 h-11 bg-[#1A56DB] hover:bg-[#FBBF24] hover:text-black text-white flex items-center justify-center transition-all shadow-md z-10 border border-[#1A56DB] rounded-none cursor-pointer active:scale-95" aria-label="Scroll Categories Right">
                <span class="material-symbols-outlined text-xl">chevron_right</span>
            </button>
        </div>
        
        <!-- Loading State -->
        <div id="feat-products-loader" class="hidden flex justify-center items-center py-24">
            <span class="material-symbols-outlined animate-spin text-5xl text-[#1A56DB]">progress_activity</span>
        </div>

        <!-- Carousel Wrapper -->
        <div class="relative w-full" id="feat-products-container">
            <div id="featured-carousel" class="flex overflow-x-auto snap-x snap-mandatory gap-8 pb-8 no-scrollbar scroll-smooth">
                <!-- Products populated via AJAX -->
            </div>
            
            <!-- Custom Navigation Buttons -->
            <div class="absolute -bottom-16 right-0 flex gap-2">
                <button id="feat-prev" class="bg-[#0A0A0A] text-white w-12 h-12 flex items-center justify-center hover:bg-[#FBBF24] hover:text-black transition-colors rounded-none" aria-label="Previous">
                    <span class="material-symbols-outlined">arrow_back</span>
                </button>
                <button id="feat-next" class="bg-[#1A56DB] text-white w-12 h-12 flex items-center justify-center hover:bg-[#FBBF24] hover:text-black transition-colors rounded-none" aria-label="Next">
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>
            </div>
        </div>

        <div class="mt-24 flex justify-center">
            <a href="/shop" class="bg-[#FBBF24] text-black px-12 h-[52px] font-black uppercase text-lg hover:bg-yellow-500 transition-all flex items-center justify-center gap-3 w-full max-w-2xl rounded-none">
                VIEW ENTIRE CATALOG <span class="material-symbols-outlined">arrow_forward</span>
            </a>
        </div>
    </div>
</section>

<style>
/* Hide scrollbar for carousel */ 
.no-scrollbar::-webkit-scrollbar {
  display: none;
}
.no-scrollbar {
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
}

/* Marquee Animations */
@keyframes marquee-vertical {
  from { transform: translateY(0); }
  to { transform: translateY(-50%); }
}
@keyframes marquee-vertical-reverse {
  from { transform: translateY(-50%); }
  to { transform: translateY(0); }
}
.animate-marquee-vertical {
  animation: marquee-vertical 30s linear infinite;
}
.animate-marquee-vertical-reverse {
  animation: marquee-vertical-reverse 30s linear infinite;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const catBtns = document.querySelectorAll('.feat-cat-btn');
    const productsContainer = document.getElementById('featured-carousel');
    const loader = document.getElementById('feat-products-loader');
    const carouselWrapper = document.getElementById('feat-products-container');

    function fetchProducts(categoryId) {
        if(!categoryId || !carouselWrapper || !loader) return;
        
        // Show loader
        carouselWrapper.style.display = 'none';
        loader.style.display = 'flex';

        const formData = new FormData();
        formData.append('action', 'snap_get_menu_products');
        formData.append('cat_id', categoryId);

        fetch('/wp-admin/admin-ajax.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            loader.style.display = 'none';
            carouselWrapper.style.display = 'block';
            
            if (data.success && data.data && data.data.products && data.data.products.length > 0) {
                productsContainer.innerHTML = '';
                const badgeLabels = ['BEST SELLER', 'TOP PICK', 'POPULAR', 'NEW'];
                
                data.data.products.forEach((product, idx) => {
                    const badge = badgeLabels[idx % badgeLabels.length];
                    const bgClass = (idx % 2 === 0) ? 'bg-zinc-100' : 'bg-zinc-50';
                    const isB2B = product.is_b2b;
                    
                    const html = `
                    <div class="snap-start shrink-0 w-full sm:w-[calc(50%-1rem)] lg:w-[calc(25%-1.5rem)] group bg-white flex flex-col border border-zinc-100 hover:shadow-2xl transition-all duration-300 rounded-none">
                        <a href="${product.url}" class="relative ${bgClass} aspect-square flex items-center justify-center p-8 mb-6 overflow-hidden rounded-none block">
                            <span class="absolute top-0 left-0 bg-[#FBBF24] text-black font-black text-[10px] px-3 py-1.5 uppercase tracking-widest z-10">${badge}</span>
                            <img src="${product.image}" alt="${product.title}" class="w-full h-full object-contain mix-blend-multiply group-hover:scale-105 transition-transform duration-500 rounded-none" />
                        </a>
                        <div class="px-6 pb-6 flex-grow flex flex-col">
                            <span class="inline-block bg-[#1A56DB] text-white text-[10px] font-black px-2 py-0.5 rounded-none w-fit mb-3 uppercase tracking-widest">${product.brand || 'SNAP STITCH'}</span>
                            <a href="${product.url}" class="hover:text-[#1A56DB] transition-colors">
                                <h4 class="text-[#0A0A0A] font-black text-xl mb-3 leading-tight line-clamp-2">${product.title}</h4>
                            </a>
                            <div class="text-zinc-500 text-sm font-medium mb-6 space-y-1">
                                <p class="truncate">Standard Size</p>
                                <p class="truncate">Industrial Grade</p>
                            </div>
                            <div class="mt-auto flex gap-2">
                                <a href="${product.url}" class="flex-grow bg-[#FBBF24] text-black text-center font-black py-3 px-4 uppercase text-xs hover:bg-yellow-500 transition-colors italic flex items-center justify-center rounded-none">
                                    ${isB2B ? '₹ Request Bulk Price' : 'View Details'}
                                </a>
                                ${!isB2B ? `
                                <a href="?add-to-cart=${product.id}" class="bg-[#1A56DB] text-white p-3 flex items-center justify-center hover:bg-black transition-colors rounded-none">
                                    <span class="material-symbols-outlined">shopping_cart</span>
                                </a>` : ''}
                            </div>
                        </div>
                    </div>`;
                    productsContainer.insertAdjacentHTML('beforeend', html);
                });
            } else {
                productsContainer.innerHTML = '<div class="w-full py-12 text-center text-zinc-500 font-bold">No products found for this category.</div>';
            }
        })
        .catch(err => {
            console.error(err);
            loader.style.display = 'none';
            carouselWrapper.style.display = 'block';
            productsContainer.innerHTML = '<div class="w-full py-12 text-center text-red-500 font-bold">Failed to load products.</div>';
        });
    }

    // Category tab scrolling arrows
    const tabsScrollContainer = document.getElementById('featured-cat-tabs-scroll');
    const tabsPrevBtn = document.getElementById('cat-tabs-prev');
    const tabsNextBtn = document.getElementById('cat-tabs-next');

    if (tabsScrollContainer && tabsPrevBtn && tabsNextBtn) {
        tabsPrevBtn.addEventListener('click', () => {
            tabsScrollContainer.scrollBy({ left: -250, behavior: 'smooth' });
        });
        tabsNextBtn.addEventListener('click', () => {
            tabsScrollContainer.scrollBy({ left: 250, behavior: 'smooth' });
        });
    }

    // Initialize category tab clicks
    if (catBtns && catBtns.length > 0) {
        catBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                catBtns.forEach(b => {
                    b.classList.remove('text-[#0A0A0A]', 'bg-[#FBBF24]', 'border-[#1A56DB]');
                    b.classList.add('text-gray-600', 'bg-gray-100', 'border-transparent');
                });
                this.classList.remove('text-gray-600', 'bg-gray-100', 'border-transparent');
                this.classList.add('text-[#0A0A0A]', 'bg-[#FBBF24]', 'border-[#1A56DB]');
                
                fetchProducts(this.getAttribute('data-cat-id'));
            });
        });

        // Initialize first category tab
        catBtns[0].click();
    }

    // Carousel script
    const carousel = document.getElementById('featured-carousel');
    const prevBtn = document.getElementById('feat-prev');
    const nextBtn = document.getElementById('feat-next');

    if(carousel && prevBtn && nextBtn) {
        const scrollAmount = () => {
            const card = carousel.querySelector('div.snap-start');
            if(!card) return 0;
            const style = window.getComputedStyle(carousel);
            const gap = parseFloat(style.gap) || 32;
            return card.offsetWidth + gap; 
        };

        nextBtn.addEventListener('click', () => {
            carousel.scrollBy({ left: scrollAmount(), behavior: 'smooth' });
        });
        prevBtn.addEventListener('click', () => {
            carousel.scrollBy({ left: -scrollAmount(), behavior: 'smooth' });
        });
    }
});
</script>

<!-- Section: Trust & Scale Features -->
<section class="bg-[#1A56DB] py-24">
    <div class="container mx-auto px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <!-- Feature Box 1 -->
            <div class="bg-[#0A0A0A] p-12 border-b-4 border-[#FBBF24] flex flex-col items-center text-center industrial-glow">
                <span class="material-symbols-outlined text-[#FBBF24] text-7xl mb-6">verified_user</span>
                <div class="text-5xl font-black text-white mb-4">100%</div>
                <h3 class="text-2xl font-black uppercase mb-4 tracking-tight text-white">Genuine Brands</h3>
                <p class="text-zinc-300 leading-relaxed">Direct partnerships with Blue Star, Euronics, and Kimberly Clark ensure authentic equipment.</p>
            </div>

            <!-- Feature Box 2 -->
            <div class="bg-[#0A0A0A] p-12 border-b-4 border-[#FBBF24] flex flex-col items-center text-center industrial-glow">
                <span class="material-symbols-outlined text-[#FBBF24] text-7xl mb-6">local_shipping</span>
                <div class="text-5xl font-black text-white mb-4">24H</div>
                <h3 class="text-2xl font-black uppercase mb-4 tracking-tight text-white">Dispatch Readiness</h3>
                <p class="text-zinc-300 leading-relaxed">Strategic warehousing across India allows for rapid fulfillment of high-volume B2B orders.</p>
            </div>

            <!-- Feature Box 3 (User Requested) -->
            <div class="bg-[#0A0A0A] p-12 border-b-4 border-[#FBBF24] flex flex-col items-center text-center industrial-glow">
                <span class="material-symbols-outlined text-[#FBBF24] text-7xl mb-6">inventory</span>
                <div class="text-5xl font-black text-[#FBBF24] mb-4">5000+</div>
                <h3 class="text-2xl font-black uppercase mb-4 tracking-tight text-white">Available SKUs</h3>
                <p class="text-zinc-300 leading-relaxed">The widest catalog of high-performance industrial equipment in India.</p>
            </div>
        </div>
    </div>
</section>

<!-- Section: Testimonials (Client Reviews) -->
<section class="bg-zinc-50 py-24 px-8">
    <div class="container mx-auto">
        <h2 class="text-black text-4xl font-black mb-20 uppercase tracking-tight text-center">B2B Trust Report</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-[#FFFFFF] p-12 border-t-8 border-[#FBBF24] industrial-glow transition-all shadow-xl">
                <span class="material-symbols-outlined text-[#FBBF24] text-7xl mb-6 block" style="font-variation-settings: 'FILL' 1;">format_quote</span>
                <p class="text-black text-xl font-bold leading-relaxed mb-8 italic">"Snap Marketing transformed our facility hygiene with their automated solutions. The scale they operate at is truly impressive."</p>
                <div class="text-[#1A56DB] font-black uppercase text-sm tracking-widest border-l-4 border-[#1A56DB] pl-4">Operation Manager, Fortis Hospitals</div>
            </div>
            <div class="bg-[#FFFFFF] p-12 border-t-8 border-[#FBBF24] industrial-glow transition-all shadow-xl">
                <span class="material-symbols-outlined text-[#FBBF24] text-7xl mb-6 block" style="font-variation-settings: 'FILL' 1;">format_quote</span>
                <p class="text-black text-xl font-bold leading-relaxed mb-8 italic">"The technical support during our cold-chain setup was world-class. Reliable partners for any large-scale industrial project."</p>
                <div class="text-[#1A56DB] font-black uppercase text-sm tracking-widest border-l-4 border-[#1A56DB] pl-4">Director, Amul Cold Storage</div>
            </div>
            <div class="bg-[#FFFFFF] p-12 border-t-8 border-[#FBBF24] industrial-glow transition-all shadow-xl">
                <span class="material-symbols-outlined text-[#FBBF24] text-7xl mb-6 block" style="font-variation-settings: 'FILL' 1;">format_quote</span>
                <p class="text-black text-xl font-bold leading-relaxed mb-8 italic">"Precision and speed. Snap handles our bulk requirements with zero friction. Highly recommended for corporate procurement."</p>
                <div class="text-[#1A56DB] font-black uppercase text-sm tracking-widest border-l-4 border-[#1A56DB] pl-4">Procurement Head, Tata Motors</div>
            </div>
        </div>
    </div>
</section>

<!-- Section 7.5: Frequently Asked Questions (Homepage FAQ Section) -->
<section id="faq-section" class="bg-[#F4F4F5] py-24 px-6 md:px-8 border-t-4 border-[#1A56DB] relative overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
            
            <!-- Left Column: Title & CTA -->
            <div class="lg:col-span-5 space-y-6">
                <div class="inline-block bg-[#FBBF24] text-[#0A0A0A] text-xs font-black uppercase tracking-[0.2em] px-4 py-1.5">
                    Clear Answers & Expert Support
                </div>
                <h2 class="text-[#0A0A0A] text-4xl md:text-5xl font-black uppercase tracking-tight leading-tight">
                    Frequently Asked <span class="text-[#1A56DB]">Questions</span>
                </h2>
                <p class="text-zinc-600 text-lg font-medium leading-relaxed">
                    Have questions about authorized Blue Star dealership, AC tonnage selection, bulk institutional discounts, or warranty service? Here are quick answers to the most common inquiries.
                </p>

                <!-- Knowledge Base Promotion Card -->
                <div class="bg-white p-8 border-t-4 border-[#FBBF24] shadow-xl space-y-4">
                    <span class="text-xs font-black text-[#1A56DB] uppercase tracking-widest block">Need More Information?</span>
                    <h3 class="text-2xl font-black text-[#0A0A0A] uppercase tracking-tight">Visit Our Full Help Center</h3>
                    <p class="text-zinc-500 text-sm font-medium leading-relaxed">
                        Browse our comprehensive FAQ library covering residential split ACs, commercial refrigeration, touchless washroom automations, and corporate procurement.
                    </p>
                    <div class="pt-2">
                        <a href="<?php echo esc_url(home_url('/faq/')); ?>" class="inline-flex items-center gap-3 bg-[#0A0A0A] text-[#FBBF24] hover:bg-[#1A56DB] hover:text-white px-8 py-4 font-black uppercase text-xs tracking-widest transition-all duration-300 shadow-md">
                            <span>Explore Full FAQ Page</span>
                            <span class="material-symbols-outlined text-base">arrow_forward</span>
                        </a>
                    </div>
                </div>

                <div class="flex items-center gap-4 text-sm font-bold text-zinc-700 pt-2">
                    <span class="material-symbols-outlined text-[#1A56DB]">support_agent</span>
                    <span>Direct WhatsApp Assistance: <a href="https://wa.me/919823012724" target="_blank" rel="noopener noreferrer" class="text-[#1A56DB] hover:underline font-black">+91 98230 12724</a></span>
                </div>
            </div>

            <!-- Right Column: Accordion Items -->
            <div class="lg:col-span-7 space-y-4">
                
                <!-- Q1 -->
                <div class="home-faq-item bg-white border-l-4 border-[#1A56DB] shadow-md transition-all hover:shadow-lg">
                    <button type="button" class="home-faq-toggle w-full text-left p-6 flex justify-between items-center gap-4 focus:outline-none focus:ring-2 focus:ring-[#1A56DB]" aria-expanded="false">
                        <span class="text-lg md:text-xl font-black text-[#0A0A0A] tracking-tight">
                            Is Snap Marketing an authorized Blue Star dealer in Pune?
                        </span>
                        <span class="home-faq-icon-wrapper w-8 h-8 rounded-full bg-[#1A56DB]/10 text-[#1A56DB] flex items-center justify-center flex-shrink-0 transition-transform duration-300">
                            <span class="material-symbols-outlined text-2xl font-bold">expand_more</span>
                        </span>
                    </button>
                    <div class="home-faq-content hidden px-6 pb-6 text-gray-700 font-medium leading-relaxed border-t border-gray-100 pt-4">
                        <p>
                            <strong>Yes, absolutely.</strong> Snap Marketing is an authorized channel partner and wholesale distributor for Blue Star Limited with over 35 years of industry leadership in Pune, Maharashtra. Every residential and commercial unit carries 100% genuine manufacturer warranties, certified serial numbers, and authorized brand technician installation.
                        </p>
                    </div>
                </div>

                <!-- Q2 -->
                <div class="home-faq-item bg-white border-l-4 border-[#1A56DB] shadow-md transition-all hover:shadow-lg">
                    <button type="button" class="home-faq-toggle w-full text-left p-6 flex justify-between items-center gap-4 focus:outline-none focus:ring-2 focus:ring-[#1A56DB]" aria-expanded="false">
                        <span class="text-lg md:text-xl font-black text-[#0A0A0A] tracking-tight">
                            How do I choose the correct AC tonnage for my room?
                        </span>
                        <span class="home-faq-icon-wrapper w-8 h-8 rounded-full bg-[#1A56DB]/10 text-[#1A56DB] flex items-center justify-center flex-shrink-0 transition-transform duration-300">
                            <span class="material-symbols-outlined text-2xl font-bold">expand_more</span>
                        </span>
                    </button>
                    <div class="home-faq-content hidden px-6 pb-6 text-gray-700 font-medium leading-relaxed border-t border-gray-100 pt-4">
                        <p class="mb-2">General sizing guideline for standard 10-foot ceilings:</p>
                        <ul class="list-disc pl-5 space-y-1 text-sm mb-2">
                            <li><strong>Up to 120 sq. ft.:</strong> 0.8 Ton to 1.0 Ton AC</li>
                            <li><strong>120 to 180 sq. ft.:</strong> 1.5 Ton AC (most popular bedroom size)</li>
                            <li><strong>180 to 260 sq. ft.:</strong> 2.0 Ton AC (living rooms, conference rooms)</li>
                        </ul>
                        <p class="text-xs text-gray-500 italic">For top-floor rooms under direct terrace heat or heavy western sunlight exposure, add +0.5 Ton to guarantee quick pulldown cooling.</p>
                    </div>
                </div>

                <!-- Q3 -->
                <div class="home-faq-item bg-white border-l-4 border-[#1A56DB] shadow-md transition-all hover:shadow-lg">
                    <button type="button" class="home-faq-toggle w-full text-left p-6 flex justify-between items-center gap-4 focus:outline-none focus:ring-2 focus:ring-[#1A56DB]" aria-expanded="false">
                        <span class="text-lg md:text-xl font-black text-[#0A0A0A] tracking-tight">
                            What is the saving difference between 3-Star and 5-Star Inverter ACs?
                        </span>
                        <span class="home-faq-icon-wrapper w-8 h-8 rounded-full bg-[#1A56DB]/10 text-[#1A56DB] flex items-center justify-center flex-shrink-0 transition-transform duration-300">
                            <span class="material-symbols-outlined text-2xl font-bold">expand_more</span>
                        </span>
                    </button>
                    <div class="home-faq-content hidden px-6 pb-6 text-gray-700 font-medium leading-relaxed border-t border-gray-100 pt-4">
                        <p>
                            A <strong>5-Star Inverter AC consumes 20% to 25% less power</strong> than a comparable 3-Star unit. If you operate your air conditioner for 6 to 12 hours daily (especially in master bedrooms or offices), a 5-Star AC saves enough on monthly electric bills to fully offset its higher purchase price within 12 to 18 months.
                        </p>
                    </div>
                </div>

                <!-- Q4 -->
                <div class="home-faq-item bg-white border-l-4 border-[#1A56DB] shadow-md transition-all hover:shadow-lg">
                    <button type="button" class="home-faq-toggle w-full text-left p-6 flex justify-between items-center gap-4 focus:outline-none focus:ring-2 focus:ring-[#1A56DB]" aria-expanded="false">
                        <span class="text-lg md:text-xl font-black text-[#0A0A0A] tracking-tight">
                            How can companies request bulk B2B pricing for commercial refrigeration?
                        </span>
                        <span class="home-faq-icon-wrapper w-8 h-8 rounded-full bg-[#1A56DB]/10 text-[#1A56DB] flex items-center justify-center flex-shrink-0 transition-transform duration-300">
                            <span class="material-symbols-outlined text-2xl font-bold">expand_more</span>
                        </span>
                    </button>
                    <div class="home-faq-content hidden px-6 pb-6 text-gray-700 font-medium leading-relaxed border-t border-gray-100 pt-4">
                        <p>
                            Enterprises, hospitals, and dairy units can submit requirements via our <a href="<?php echo esc_url(home_url('/request-a-quote')); ?>" class="text-[#1A56DB] font-bold underline">Request a Quote</a> form. Our commercial procurement desk calculates tiered institutional discounts and responds with formal GST quotations and delivery timelines within <strong>2 to 4 business hours</strong>.
                        </p>
                    </div>
                </div>

                <!-- Q5 -->
                <div class="home-faq-item bg-white border-l-4 border-[#1A56DB] shadow-md transition-all hover:shadow-lg">
                    <button type="button" class="home-faq-toggle w-full text-left p-6 flex justify-between items-center gap-4 focus:outline-none focus:ring-2 focus:ring-[#1A56DB]" aria-expanded="false">
                        <span class="text-lg md:text-xl font-black text-[#0A0A0A] tracking-tight">
                            What warranty coverage is included with Blue Star appliances?
                        </span>
                        <span class="home-faq-icon-wrapper w-8 h-8 rounded-full bg-[#1A56DB]/10 text-[#1A56DB] flex items-center justify-center flex-shrink-0 transition-transform duration-300">
                            <span class="material-symbols-outlined text-2xl font-bold">expand_more</span>
                        </span>
                    </button>
                    <div class="home-faq-content hidden px-6 pb-6 text-gray-700 font-medium leading-relaxed border-t border-gray-100 pt-4">
                        <p>
                            All units include 100% manufacturer warranty: <strong>1 Year Comprehensive + up to 10 Years on Inverter Compressors</strong> for residential ACs, and 1 Year Comprehensive on commercial deep freezers, visi coolers, and water coolers, supported by Blue Star certified pan-India service centers.
                        </p>
                    </div>
                </div>

                <!-- Q6 -->
                <div class="home-faq-item bg-white border-l-4 border-[#1A56DB] shadow-md transition-all hover:shadow-lg">
                    <button type="button" class="home-faq-toggle w-full text-left p-6 flex justify-between items-center gap-4 focus:outline-none focus:ring-2 focus:ring-[#1A56DB]" aria-expanded="false">
                        <span class="text-lg md:text-xl font-black text-[#0A0A0A] tracking-tight">
                            What are the delivery and dispatch timelines?
                        </span>
                        <span class="home-faq-icon-wrapper w-8 h-8 rounded-full bg-[#1A56DB]/10 text-[#1A56DB] flex items-center justify-center flex-shrink-0 transition-transform duration-300">
                            <span class="material-symbols-outlined text-2xl font-bold">expand_more</span>
                        </span>
                    </button>
                    <div class="home-faq-content hidden px-6 pb-6 text-gray-700 font-medium leading-relaxed border-t border-gray-100 pt-4">
                        <p>
                            We dispatch directly from our central warehouse at Ghorpadi Peth (Shankar Sheth Road), Pune. Deliveries across Pune Municipal Corporation (PMC) and PCMC are completed within <strong>24 to 48 hours</strong>. Outstation deliveries across Maharashtra are completed within 2 to 4 business days with insured freight logistics.
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<!-- Homepage FAQ Vanilla JS Accordion Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const homeFaqItems = document.querySelectorAll('.home-faq-item');
    homeFaqItems.forEach(item => {
        const toggle = item.querySelector('.home-faq-toggle');
        const content = item.querySelector('.home-faq-content');
        const iconWrapper = item.querySelector('.home-faq-icon-wrapper');

        toggle.addEventListener('click', () => {
            const isOpen = !content.classList.contains('hidden');

            // Close others for clean accordion experience
            homeFaqItems.forEach(otherItem => {
                if (otherItem !== item) {
                    otherItem.querySelector('.home-faq-content').classList.add('hidden');
                    otherItem.querySelector('.home-faq-toggle').setAttribute('aria-expanded', 'false');
                    const otherIcon = otherItem.querySelector('.home-faq-icon-wrapper');
                    otherIcon.classList.remove('rotate-180', 'bg-[#FBBF24]', 'text-black');
                    otherIcon.classList.add('bg-[#1A56DB]/10', 'text-[#1A56DB]');
                }
            });

            if (isOpen) {
                content.classList.add('hidden');
                toggle.setAttribute('aria-expanded', 'false');
                iconWrapper.classList.remove('rotate-180', 'bg-[#FBBF24]', 'text-black');
                iconWrapper.classList.add('bg-[#1A56DB]/10', 'text-[#1A56DB]');
            } else {
                content.classList.remove('hidden');
                toggle.setAttribute('aria-expanded', 'true');
                iconWrapper.classList.add('rotate-180', 'bg-[#FBBF24]', 'text-black');
                iconWrapper.classList.remove('bg-[#1A56DB]/10', 'text-[#1A56DB]');
            }
        });
    });
});
</script>

<!-- Homepage Rich FAQPage JSON-LD Schema -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "Is Snap Marketing an authorized Blue Star dealer in Pune?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes, absolutely. Snap Marketing is an authorized channel partner and wholesale distributor for Blue Star Limited with over 35 years of industry leadership in Pune, Maharashtra. Every unit carries 100% genuine manufacturer warranties and certified serial numbers."
      }
    },
    {
      "@type": "Question",
      "name": "How do I choose the correct AC tonnage for my room?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "For rooms up to 120 sq. ft., select a 0.8 to 1.0 Ton AC. For 120 to 180 sq. ft., select a 1.5 Ton AC. For 180 to 260 sq. ft., choose a 2.0 Ton AC. Top-floor rooms or rooms with direct western sun exposure should add +0.5 Ton."
      }
    },
    {
      "@type": "Question",
      "name": "What is the saving difference between 3-Star and 5-Star Inverter ACs?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "A 5-Star Inverter AC consumes 20% to 25% less power than a comparable 3-Star unit. If running 6 to 12 hours daily, the 5-Star model pays for its higher upfront cost within 12 to 18 months via lower electricity bills."
      }
    },
    {
      "@type": "Question",
      "name": "How can companies request bulk B2B pricing for commercial refrigeration?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Enterprises can submit requirements via our Request a Quote form. Our commercial procurement team calculates tiered institutional discounts and issues formal GST quotations within 2 to 4 business hours."
      }
    },
    {
      "@type": "Question",
      "name": "What warranty coverage is included with Blue Star appliances?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "All appliances include 100% official manufacturer warranty: 1 Year Comprehensive plus up to 10 Years on Inverter Compressors for residential ACs, and 1 Year Comprehensive on commercial refrigeration."
      }
    },
    {
      "@type": "Question",
      "name": "What are the delivery and dispatch timelines?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Deliveries across Pune Municipal Corporation (PMC) and PCMC take 24 to 48 hours from our central warehouse at Ghorpadi Peth (Shankar Sheth Road). Outstation Maharashtra orders are delivered within 2 to 4 business days."
      }
    }
  ]
}
</script>

<!-- Section 8: Request a Quote Banner -->
<section class="bg-[#0A0A0A] py-24 relative overflow-hidden">
    <div class="absolute right-0 top-0 w-1/3 h-full bg-[#1A56DB] diagonal-band opacity-20"></div>
    <div class="container mx-auto px-8 relative z-10 text-center">
        <h2 class="text-[#FBBF24] text-5xl md:text-6xl font-black mb-6 uppercase italic">Ready to Order in Bulk?</h2>
        <p class="text-white text-xl mb-12 max-w-2xl mx-auto opacity-80 font-medium">Get exclusive institutional pricing for your enterprise today. Our dedicated account managers are ready to assist.</p>
        <a href="/request-a-quote" class="inline-block bg-[#FBBF24] text-black px-12 py-6 font-black uppercase text-xl hover:-translate-y-1 hover:shadow-2xl active:scale-95 transition-all duration-300 tracking-widest shadow-[10px_10px_0px_rgba(251,191,36,0.3)] rounded-none">
            GET A CUSTOM QUOTE NOW
        </a>
    </div>
</section>

<?php get_footer(); ?>









