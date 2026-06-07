<?php
/*
Template Name: Front Page
*/
get_header();
?>

<!-- Section 1: HERO SLIDER -->
<header id="hero-slider" class="relative min-h-screen pt-20 flex items-center overflow-hidden bg-black">
    <!-- Background decorative element -->
    <div class="absolute inset-0 z-0 opacity-40 diagonal-band bg-primary-container scale-150 -rotate-12 translate-x-1/4"></div>

    <!-- Slides Container -->
    <div class="relative w-full h-full z-10">
      <?php
      $hero_slides = [
        [
          'badge'    => 'NEW CATALOG 2025',
          'heading'  => 'Precision Equipment. <br/><span class="yellow-underline text-white">Bulk Pricing.</span>',
          'desc'     => 'Supplying washroom automations, commercial refrigeration, and hygiene solutions to 500+ enterprises pan-India.',
          'cta1_text'=> 'Browse Products',
          'cta1_href'=> '/shop',
          'cta2_text'=> 'Request Bulk Quote',
          'cta2_href'=> '/request-a-quote',
          'img'      => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDE4MzqiH8Hzcnme1hwaU5h6AYhAx0i3dIbjNKElAvN-0dI3VHfR3Hexm1SxwZhUH3xTH7PTh005QytdXaS-e67Dqta7QxYnSPk81X26hEeR5PdRThP6ErVqR07iP3sQV6oQ9-qQFmuiIguK9lVu2XsU8oeL2RI3HoXXTAf2dymX9WJBcHcbXI5k_7Rz8aKCs8Q7HD0BtKxTOrOgI4PZHNKR2CkNxynLuWg39Nl8irWfVMFFPTiMf0ZQI2MjQBTVuKOdEGB6lwHW2o',
          'img_alt'  => 'Sensor Tap',
        ],
        [
          'badge'    => 'COMMERCIAL REFRIGERATION',
          'heading'  => 'Cold Chain <br/><span class="yellow-underline text-white">Solutions.</span>',
          'desc'     => 'Deep freezers, display coolers, and walk-in cold rooms from Blue Star, Voltas, and Western — engineered for industrial uptime.',
          'cta1_text'=> 'Explore Range',
          'cta1_href'=> '/product-category/commercial-refrigeration/',
          'cta2_text'=> 'Get Bulk Pricing',
          'cta2_href'=> '/request-a-quote',
          'img'      => 'https://lh3.googleusercontent.com/aida-public/AB6AXuA6EO5K0zcbj9qmQ1pr2VNltfcLFoeebNpGYXfSInJSIZPXAqy4fH8A-LKcTBuL0lDH2uvZ9E-2ucygYRE5I1q-gEnSLXQxmuUzdkkIRV6LcKfWI7RY1GOzaiol0tqS6LQodunm23Ktq1iiVoP146n5s6pnUZSRY--ZYbHNlj0HIp76MeafAPY_ViEoTh3r0UkifABN3dmTQbDT6oURBSalugjrFsuTwDoXua1Fmb1tzIoTWid6_N8qIOXvvPLw6JemIoEr3rRjmt4',
          'img_alt'  => 'Commercial Refrigerator',
        ],
        [
          'badge'    => 'HYGIENE & PPE',
          'heading'  => 'Automated Hygiene <br/><span class="yellow-underline text-white">at Scale.</span>',
          'desc'     => 'Touchless dispensers, sanitizer stations, and PPE kits from Kimberly Clark, Dettol, and Euronics — deployed across 500+ facilities.',
          'cta1_text'=> 'Shop Hygiene',
          'cta1_href'=> '/product-category/hygiene-ppe/',
          'cta2_text'=> 'Institutional Quote',
          'cta2_href'=> '/request-a-quote',
          'img'      => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAoXkJP5BaMyzbVYVTdPzXnxlJKuuNs7X9SNfzG2RPCL5khTeZvIwalCh9XZfZSIACZg7H9LCJMZklabaIQerylTaKO3rwp0XfnHKVZIuFSt2-Oj_tkX5PGOZOkNbLPDW0sspZDyPTBFF8M3T_Wu4ElNy3F-LLZeD1vJDWuVSYMbRDHicRYaL57ngwa6JvpJkqegAz4UlQFbTfebljpmmcYwmmbQ07zUF8HKbJvKeUV-1HBWTyBbZsKMDxU0Fn_ZkKEtvGgWm3X9EQ',
          'img_alt'  => 'Hygiene Equipment',
        ],
      ];
      foreach($hero_slides as $i => $slide): ?>
      <div class="hero-slide absolute inset-0 flex items-center transition-all duration-700 ease-in-out <?= $i === 0 ? 'opacity-100 z-20' : 'opacity-0 z-10' ?>" data-slide="<?= $i ?>">
        <div class="container mx-auto px-8 grid grid-cols-1 md:grid-cols-2 gap-12 relative z-10">
            <div class="flex flex-col justify-center space-y-8">
                <div>
                    <span class="inline-block bg-secondary-container text-black font-black text-sm px-4 py-1.5 mb-6 tracking-widest uppercase"><?= $slide['badge'] ?></span>
                    <h1 class="text-white text-5xl md:text-[80px] font-black leading-[1.05] tracking-tight mb-8">
                        <?= $slide['heading'] ?>
                    </h1>
                    <div class="flex flex-wrap gap-4 mb-8">
                        <a href="<?= $slide['cta1_href'] ?>" class="bg-secondary-container text-black px-10 py-5 font-black uppercase text-xl flex items-center gap-2 hover:bg-yellow-500 hover:-translate-y-1 hover:shadow-xl active:scale-95 transition-all duration-300">
                            <?= $slide['cta1_text'] ?> <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                        <a href="<?= $slide['cta2_href'] ?>" class="border-2 border-white text-white px-10 py-5 font-black uppercase text-xl hover:bg-white hover:text-black hover:-translate-y-1 hover:shadow-xl active:scale-95 transition-all duration-300">
                            <?= $slide['cta2_text'] ?>
                        </a>
                    </div>
                    <p class="text-gray-300 text-lg md:text-xl max-w-lg leading-relaxed">
                        <?= $slide['desc'] ?>
                    </p>
                </div>
            </div>
            <div class="flex items-center justify-center relative">
                <div class="absolute w-[120%] h-[120%] bg-primary-container rounded-full blur-[120px] opacity-20"></div>
                <img alt="<?= $slide['img_alt'] ?>" class="relative z-10 w-full max-w-md drop-shadow-2xl" src="<?= $slide['img'] ?>"/>
            </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Slider Navigation: Arrows -->
    <button id="hero-prev" class="absolute left-4 sm:left-8 top-1/2 -translate-y-1/2 z-30 w-12 h-12 bg-black/40 hover:bg-secondary-container hover:text-black text-white flex items-center justify-center transition-all duration-300 active:scale-90 backdrop-blur-sm border border-white/10" aria-label="Previous slide">
      <span class="material-symbols-outlined">chevron_left</span>
    </button>
    <button id="hero-next" class="absolute right-4 sm:right-8 top-1/2 -translate-y-1/2 z-30 w-12 h-12 bg-black/40 hover:bg-secondary-container hover:text-black text-white flex items-center justify-center transition-all duration-300 active:scale-90 backdrop-blur-sm border border-white/10" aria-label="Next slide">
      <span class="material-symbols-outlined">chevron_right</span>
    </button>

    <!-- Slider Navigation: Dots + Progress -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-30 flex items-center gap-3">
      <?php for($i = 0; $i < count($hero_slides); $i++): ?>
      <button class="hero-dot group relative w-10 h-1.5 bg-white/30 transition-all duration-300 overflow-hidden <?= $i === 0 ? 'w-16 bg-white/60' : '' ?>" data-dot="<?= $i ?>" aria-label="Go to slide <?= $i + 1 ?>">
        <span class="hero-dot-fill absolute inset-0 bg-secondary-container origin-left scale-x-0 transition-transform <?= $i === 0 ? 'animate-hero-progress' : '' ?>"></span>
      </button>
      <?php endfor; ?>
    </div>
</header>
<style>
  @keyframes heroProgress {
    from { transform: scaleX(0); }
    to   { transform: scaleX(1); }
  }
  .animate-hero-progress { animation: heroProgress 6s linear forwards; }
  .hero-slide { pointer-events: none; }
  .hero-slide.opacity-100 { pointer-events: auto; }
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
    slides[current].classList.remove('opacity-100','z-20');
    slides[current].classList.add('opacity-0','z-10');
    dots[current].classList.remove('w-16','bg-white/60');
    dots[current].querySelector('.hero-dot-fill').classList.remove('animate-hero-progress');
    current = ((idx % total) + total) % total;
    slides[current].classList.remove('opacity-0','z-10');
    slides[current].classList.add('opacity-100','z-20');
    dots[current].classList.add('w-16','bg-white/60');
    // Reset & restart progress animation
    const fill = dots[current].querySelector('.hero-dot-fill');
    fill.classList.remove('animate-hero-progress');
    void fill.offsetWidth; // force reflow
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
<div class="bg-secondary-container w-full py-12 relative z-20">
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

<!-- Section 2: Shop by Category (Refactored to 4x4 Equal Boxes) -->
<section class="bg-primary-container py-24">
    <div class="container mx-auto px-8">
        <h2 class="text-white text-4xl font-black mb-16 uppercase tracking-tight">Shop by Category</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-1">
            <!-- Row 1 -->
            <a class="group bg-blue-800/50 p-12 aspect-square flex flex-col justify-between industrial-glow border border-transparent hover:border-yellow-400 transition-all" href="/product-category/washroom-automations/">
                <span class="material-symbols-outlined text-white text-6xl">sanitizer</span>
                <div>
                    <span class="text-secondary-container font-bold text-xs uppercase block mb-1">Automated</span>
                    <h3 class="text-white text-2xl font-black leading-tight">Washroom Automations</h3>
                </div>
            </a>
            <a class="group bg-blue-800/80 p-12 aspect-square flex flex-col justify-between industrial-glow border border-transparent hover:border-yellow-400 transition-all" href="/product-category/commercial-refrigeration/">
                <span class="material-symbols-outlined text-white text-6xl">ac_unit</span>
                <div>
                    <span class="text-secondary-container font-bold text-xs uppercase block mb-1">Commercial</span>
                    <h3 class="text-white text-2xl font-black leading-tight">Commercial Refrigeration</h3>
                </div>
            </a>
            <a class="group bg-blue-900/50 p-12 aspect-square flex flex-col justify-between industrial-glow border border-transparent hover:border-yellow-400 transition-all" href="/product-category/water-purifiers/">
                <span class="material-symbols-outlined text-white text-6xl">water_drop</span>
                <div>
                    <span class="text-secondary-container font-bold text-xs uppercase block mb-1">Pure</span>
                    <h3 class="text-white text-2xl font-black leading-tight">Water Purifiers</h3>
                </div>
            </a>
            <a class="group bg-blue-900/80 p-12 aspect-square flex flex-col justify-between industrial-glow border border-transparent hover:border-yellow-400 transition-all" href="/product-category/vending-machines/">
                <span class="material-symbols-outlined text-white text-6xl">coffee_maker</span>
                <div>
                    <span class="text-secondary-container font-bold text-xs uppercase block mb-1">Premium</span>
                    <h3 class="text-white text-2xl font-black leading-tight">Vending Machines</h3>
                </div>
            </a>
            <!-- Row 2 -->
            <a class="group bg-blue-900/80 p-12 aspect-square flex flex-col justify-between industrial-glow border border-transparent hover:border-yellow-400 transition-all" href="/product-category/hygiene-ppe/">
                <span class="material-symbols-outlined text-white text-6xl">masks</span>
                <div>
                    <span class="text-secondary-container font-bold text-xs uppercase block mb-1">Safety</span>
                    <h3 class="text-white text-2xl font-black leading-tight">Hygiene &amp; PPE</h3>
                </div>
            </a>
            <a class="group bg-blue-800/50 p-12 aspect-square flex flex-col justify-between industrial-glow border border-transparent hover:border-yellow-400 transition-all" href="/product-category/entrance-solutions/">
                <span class="material-symbols-outlined text-white text-6xl">door_front</span>
                <div>
                    <span class="text-secondary-container font-bold text-xs uppercase block mb-1">Security</span>
                    <h3 class="text-white text-2xl font-black leading-tight">Entrance Solutions</h3>
                </div>
            </a>
            <div class="bg-blue-800/80 p-12 aspect-square flex flex-col justify-center items-center text-center opacity-40 grayscale pointer-events-none">
                <span class="text-white text-xl font-black uppercase opacity-20 tracking-widest">More Coming Soon</span>
            </div>
            <div class="bg-blue-900/50 p-12 aspect-square flex flex-col justify-center items-center text-center opacity-40 grayscale pointer-events-none">
                <span class="text-white text-xl font-black uppercase opacity-20 tracking-widest">Global Sourcing</span>
            </div>
        </div>
    </div>
</section>

<!-- Section: Featured Products -->
<section class="bg-white py-24">
    <div class="container mx-auto px-8">
        <div class="mb-16 border-l-8 border-secondary-container pl-6">
            <h2 class="text-black text-4xl font-black uppercase tracking-tight">Featured Products</h2>
            <p class="text-primary-container font-bold mt-2 uppercase tracking-widest text-sm">Most Requested B2B Equipment This Month</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="group bg-white flex flex-col">
                <div class="relative bg-primary-container aspect-square flex items-center justify-center p-12 mb-6">
                    <span class="absolute top-0 left-0 bg-secondary-container text-black font-black text-[10px] px-3 py-1.5 uppercase">BEST SELLER</span>
                    <span class="material-symbols-outlined text-white text-8xl">sensor_occupied</span>
                </div>
                <div class="px-2 flex-grow flex flex-col">
                    <span class="inline-block bg-primary-container text-white text-[10px] font-black px-2 py-0.5 rounded-full w-fit mb-3">EURONICS</span>
                    <h4 class="text-black font-black text-xl mb-3 leading-tight">Euronics Auto Sensor Flusher EF-100</h4>
                    <div class="mt-auto">
                        <a href="/request-a-quote" class="block w-full bg-secondary-container text-black font-black py-3 px-4 uppercase text-sm hover:bg-yellow-500 hover:-translate-y-0.5 hover:shadow-md active:scale-95 transition-all duration-300 italic text-center">₹ Request Bulk Price</a>
                    </div>
                </div>
            </div>
            <div class="group bg-white flex flex-col">
                <div class="relative bg-black aspect-square flex items-center justify-center p-12 mb-6">
                    <span class="absolute top-0 left-0 bg-secondary-container text-black font-black text-[10px] px-3 py-1.5 uppercase">TOP PICK</span>
                    <span class="material-symbols-outlined text-white text-8xl">kitchen</span>
                </div>
                <div class="px-2 flex-grow flex flex-col">
                    <span class="inline-block bg-primary-container text-white text-[10px] font-black px-2 py-0.5 rounded-full w-fit mb-3">BLUE STAR</span>
                    <h4 class="text-black font-black text-xl mb-3 leading-tight">Blue Star Deep Freezer DF-300</h4>
                    <div class="mt-auto">
                        <a href="/request-a-quote" class="block w-full bg-secondary-container text-black font-black py-3 px-4 uppercase text-sm hover:bg-yellow-500 hover:-translate-y-0.5 hover:shadow-md active:scale-95 transition-all duration-300 italic text-center">₹ Request Bulk Price</a>
                    </div>
                </div>
            </div>
            <div class="group bg-white flex flex-col">
                <div class="relative bg-primary-container aspect-square flex items-center justify-center p-12 mb-6">
                    <span class="absolute top-0 left-0 bg-secondary-container text-black font-black text-[10px] px-3 py-1.5 uppercase">POPULAR</span>
                    <span class="material-symbols-outlined text-white text-8xl">water_damage</span>
                </div>
                <div class="px-2 flex-grow flex flex-col">
                    <span class="inline-block bg-primary-container text-white text-[10px] font-black px-2 py-0.5 rounded-full w-fit mb-3">AQUAGUARD</span>
                    <h4 class="text-black font-black text-xl mb-3 leading-tight">Aquaguard Grand RO+UV System</h4>
                    <div class="mt-auto">
                        <a href="/request-a-quote" class="block w-full bg-secondary-container text-black font-black py-3 px-4 uppercase text-sm hover:bg-yellow-500 hover:-translate-y-0.5 hover:shadow-md active:scale-95 transition-all duration-300 italic text-center">₹ Request Bulk Price</a>
                    </div>
                </div>
            </div>
            <div class="group bg-white flex flex-col">
                <div class="relative bg-gray-100 aspect-square flex items-center justify-center p-12 mb-6">
                    <span class="absolute top-0 left-0 bg-secondary-container text-black font-black text-[10px] px-3 py-1.5 uppercase">NEW</span>
                    <span class="material-symbols-outlined text-primary-container text-8xl">soap</span>
                </div>
                <div class="px-2 flex-grow flex flex-col">
                    <span class="inline-block bg-primary-container text-white text-[10px] font-black px-2 py-0.5 rounded-full w-fit mb-3">KIMBERLY CLARK</span>
                    <h4 class="text-black font-black text-xl mb-3 leading-tight">KC In-Sight Soap Dispenser 1L</h4>
                    <div class="mt-auto">
                        <a href="/request-a-quote" class="block w-full bg-secondary-container text-black font-black py-3 px-4 uppercase text-sm hover:bg-yellow-500 hover:-translate-y-0.5 hover:shadow-md active:scale-95 transition-all duration-300 italic text-center">₹ Request Bulk Price</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section: What We Do -->
<section class="w-full bg-white py-20 px-4 sm:px-8 lg:px-20 overflow-x-hidden">
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
            <span class="inline-block bg-secondary-container text-black font-black text-xs px-4 py-1.5 uppercase tracking-widest">What We Do</span>
          </div>
          <div class="reveal">
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black leading-tight text-on-surface">Delivering Excellence in Industrial Solutions</h2>
          </div>
          <div class="reveal">
            <p class="text-lg leading-relaxed text-on-surface-variant font-medium">Snap Marketing supplies washroom automations, commercial refrigeration, vending machines, and hygiene solutions to 500+ enterprises pan-India — reliability and scale you can count on.</p>
          </div>
        </div>
        <!-- Feature items -->
        <div class="flex flex-col gap-6">
          <div class="reveal flex gap-4 items-start">
            <div class="w-10 h-10 shrink-0 bg-primary-container flex items-center justify-center">
              <span class="material-symbols-outlined text-white text-xl">verified</span>
            </div>
            <div>
              <h3 class="font-black text-base text-on-surface mb-1">Genuine Brand Products</h3>
              <p class="text-sm leading-relaxed text-on-surface-variant">Certified industrial equipment sourced directly from leading global manufacturers.</p>
            </div>
          </div>
          <div class="reveal flex gap-4 items-start">
            <div class="w-10 h-10 shrink-0 bg-primary-container flex items-center justify-center">
              <span class="material-symbols-outlined text-white text-xl">local_shipping</span>
            </div>
            <div>
              <h3 class="font-black text-base text-on-surface mb-1">Pan-India Distribution</h3>
              <p class="text-sm leading-relaxed text-on-surface-variant">Serving distributors, dealers, and corporate clients across India with fast, reliable logistics.</p>
            </div>
          </div>
          <div class="reveal flex gap-4 items-start">
            <div class="w-10 h-10 shrink-0 bg-primary-container flex items-center justify-center">
              <span class="material-symbols-outlined text-white text-xl">workspace_premium</span>
            </div>
            <div>
              <h3 class="font-black text-base text-on-surface mb-1">Quality Assurance</h3>
              <p class="text-sm leading-relaxed text-on-surface-variant">Every product is inspected and tested to meet our ISO 9001:2015 standards before dispatch.</p>
            </div>
          </div>
        </div>
        <div class="reveal">
          <a href="/about-us" class="inline-flex items-center gap-3 bg-primary-container text-white font-black px-8 py-4 uppercase tracking-widest text-sm hover:-translate-y-1 hover:shadow-xl active:scale-95 transition-all duration-300">
            Learn More About Us
            <span class="material-symbols-outlined text-base">arrow_forward</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Section: Why Choose Snap Marketing? -->
<section class="bg-white py-20 px-4 sm:px-8 lg:px-20">
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
        <span class="inline-block bg-secondary-container text-black font-black text-xs px-4 py-1.5 uppercase tracking-widest">Why Choose Us</span>
      </div>
      <div class="reveal">
        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black leading-tight text-on-surface">Why Choose Snap Marketing?</h2>
      </div>
      <!-- Mobile image -->
      <div class="reveal lg:hidden mb-4">
        <div class="overflow-hidden shadow-xl">
          <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=800&q=85" alt="Why Choose Snap Marketing" class="w-full object-cover" style="aspect-ratio:16/9;" />
        </div>
      </div>
      <div class="flex flex-col gap-5">
        <div class="reveal flex gap-4 items-start">
          <div class="why-icon-box w-12 h-12 shrink-0 bg-primary-container flex items-center justify-center">
            <span class="material-symbols-outlined text-white">verified</span>
          </div>
          <div>
            <div class="font-black text-lg text-on-surface mb-1">Genuine Brand Products</div>
            <div class="text-sm leading-relaxed text-on-surface-variant">Certified equipment from global manufacturers. Zero counterfeits, zero compromise.</div>
          </div>
        </div>
        <div class="reveal flex gap-4 items-start">
          <div class="why-icon-box w-12 h-12 shrink-0 bg-primary-container flex items-center justify-center">
            <span class="material-symbols-outlined text-white">local_shipping</span>
          </div>
          <div>
            <div class="font-black text-lg text-on-surface mb-1">Pan-India Fast Shipping</div>
            <div class="text-sm leading-relaxed text-on-surface-variant">Reliable delivery to dealers and enterprises across all major Indian cities.</div>
          </div>
        </div>
        <div class="reveal flex gap-4 items-start">
          <div class="why-icon-box w-12 h-12 shrink-0 bg-primary-container flex items-center justify-center">
            <span class="material-symbols-outlined text-white">support_agent</span>
          </div>
          <div>
            <div class="font-black text-lg text-on-surface mb-1">24/7 Procurement Support</div>
            <div class="text-sm leading-relaxed text-on-surface-variant">Dedicated account managers available round the clock for bulk orders and queries.</div>
          </div>
        </div>
        <div class="reveal flex gap-4 items-start">
          <div class="why-icon-box w-12 h-12 shrink-0 bg-primary-container flex items-center justify-center">
            <span class="material-symbols-outlined text-white">currency_rupee</span>
          </div>
          <div>
            <div class="font-black text-lg text-on-surface mb-1">Institutional Pricing</div>
            <div class="text-sm leading-relaxed text-on-surface-variant">Competitive bulk rates with volume discounts and flexible payment terms for corporates.</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- Section: Brand Partners Marquee -->
<section class="bg-white py-14 sm:py-18 lg:py-20 px-4 sm:px-8 lg:px-[7.7vw]">
  <div class="w-full mx-auto xl:max-w-[1440px]">
    <div class="text-center mb-8 sm:mb-10 lg:mb-12 reveal">
      <span class="inline-block bg-secondary-container text-black font-black text-xs px-4 py-1.5 uppercase tracking-widest mb-3">Brand Partners</span>
      <h2 class="text-2xl sm:text-4xl lg:text-5xl xl:text-6xl font-black text-on-surface mb-4 sm:mb-6">Global Brand Connections</h2>
      <p class="text-base sm:text-lg leading-relaxed text-on-surface-variant font-medium text-center px-2">Partnering with global brands to deliver premium products and enterprise solutions.</p>
    </div>
    <!-- 3D Perspective Marquee Grid (Bhakti-style tilted layout) -->
    <div class="relative reveal" style="overflow:hidden;">
      <div class="relative flex max-w-full w-full flex-row items-center justify-center overflow-hidden bg-gradient-to-br from-gray-50 to-white px-1 lg:px-2" style="height:900px;perspective:800px;">
        <!-- Single 3D-tilted wrapper for ALL columns -->
        <div class="flex flex-row items-center gap-2 sm:gap-4" style="transform:translateX(-80px) translateY(-1px) translateZ(-100px) rotateX(15deg) rotateY(-8deg) rotateZ(18deg);">

          <!-- Column 1 - scrolls UP -->
          <div class="marquee-col" style="display:flex;flex-direction:column;gap:16px;overflow:hidden;height:900px;flex-shrink:0;">
            <div class="animate-marquee-vertical" style="display:flex;flex-direction:column;gap:16px;">
              <?php
              $brands_col1 = [
                ['name'=>'Euronics','icon'=>'sensor_occupied','color'=>'#1A56DB'],
                ['name'=>'Blue Star','icon'=>'ac_unit','color'=>'#0369a1'],
                ['name'=>'Aquaguard','icon'=>'water_drop','color'=>'#0891b2'],
              ];
              foreach(array_merge($brands_col1,$brands_col1,$brands_col1,$brands_col1) as $b): ?>
              <div class="brand-card bg-white shadow-sm flex flex-col items-center justify-center gap-3 sm:gap-4 p-5 sm:p-8 cursor-pointer rounded-lg" style="width:240px;height:240px;flex-shrink:0;">
                <span class="material-symbols-outlined text-6xl" style="color:<?= $b['color'] ?>"><?= $b['icon'] ?></span>
                <span class="text-sm font-black text-gray-700 text-center uppercase tracking-tight"><?= $b['name'] ?></span>
              </div>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Column 2 - scrolls DOWN -->
          <div class="marquee-col" style="display:flex;flex-direction:column;gap:16px;overflow:hidden;height:900px;flex-shrink:0;">
            <div class="animate-marquee-vertical-reverse" style="display:flex;flex-direction:column;gap:16px;">
              <?php
              $brands_col2 = [
                ['name'=>'Kimberly Clark','icon'=>'soap','color'=>'#1A56DB'],
                ['name'=>'Dettol','icon'=>'sanitizer','color'=>'#dc2626'],
                ['name'=>'Somany','icon'=>'door_front','color'=>'#7c3aed'],
              ];
              foreach(array_merge($brands_col2,$brands_col2,$brands_col2,$brands_col2) as $b): ?>
              <div class="brand-card bg-white shadow-sm flex flex-col items-center justify-center gap-3 sm:gap-4 p-5 sm:p-8 cursor-pointer rounded-lg" style="width:240px;height:240px;flex-shrink:0;">
                <span class="material-symbols-outlined text-6xl" style="color:<?= $b['color'] ?>"><?= $b['icon'] ?></span>
                <span class="text-sm font-black text-gray-700 text-center uppercase tracking-tight"><?= $b['name'] ?></span>
              </div>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Column 3 - scrolls UP -->
          <div class="marquee-col" style="display:flex;flex-direction:column;gap:16px;overflow:hidden;height:900px;flex-shrink:0;">
            <div class="animate-marquee-vertical" style="display:flex;flex-direction:column;gap:16px;">
              <?php
              $brands_col3 = [
                ['name'=>'KENT','icon'=>'water_drop','color'=>'#059669'],
                ['name'=>'Godrej','icon'=>'lock','color'=>'#d97706'],
                ['name'=>'Finolex','icon'=>'electrical_services','color'=>'#dc2626'],
              ];
              foreach(array_merge($brands_col3,$brands_col3,$brands_col3,$brands_col3) as $b): ?>
              <div class="brand-card bg-white shadow-sm flex flex-col items-center justify-center gap-3 sm:gap-4 p-5 sm:p-8 cursor-pointer rounded-lg" style="width:240px;height:240px;flex-shrink:0;">
                <span class="material-symbols-outlined text-6xl" style="color:<?= $b['color'] ?>"><?= $b['icon'] ?></span>
                <span class="text-sm font-black text-gray-700 text-center uppercase tracking-tight"><?= $b['name'] ?></span>
              </div>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Column 4 - scrolls DOWN -->
          <div class="marquee-col" style="display:flex;flex-direction:column;gap:16px;overflow:hidden;height:900px;flex-shrink:0;">
            <div class="animate-marquee-vertical-reverse" style="display:flex;flex-direction:column;gap:16px;">
              <?php
              $brands_col4 = [
                ['name'=>'Astral','icon'=>'plumbing','color'=>'#1A56DB'],
                ['name'=>'Hafele','icon'=>'kitchen','color'=>'#1A56DB'],
                ['name'=>'Honeywell','icon'=>'settings_remote','color'=>'#d97706'],
              ];
              foreach(array_merge($brands_col4,$brands_col4,$brands_col4,$brands_col4) as $b): ?>
              <div class="brand-card bg-white shadow-sm flex flex-col items-center justify-center gap-3 sm:gap-4 p-5 sm:p-8 cursor-pointer rounded-lg" style="width:240px;height:240px;flex-shrink:0;">
                <span class="material-symbols-outlined text-6xl" style="color:<?= $b['color'] ?>"><?= $b['icon'] ?></span>
                <span class="text-sm font-black text-gray-700 text-center uppercase tracking-tight"><?= $b['name'] ?></span>
              </div>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Column 5 - scrolls UP -->
          <div class="marquee-col" style="display:flex;flex-direction:column;gap:16px;overflow:hidden;height:900px;flex-shrink:0;">
            <div class="animate-marquee-vertical" style="display:flex;flex-direction:column;gap:16px;">
              <?php
              $brands_col5 = [
                ['name'=>'Johnson Controls','icon'=>'hvac','color'=>'#dc2626'],
                ['name'=>'3M India','icon'=>'science','color'=>'#dc2626'],
                ['name'=>'EBCO','icon'=>'inventory','color'=>'#059669'],
              ];
              foreach(array_merge($brands_col5,$brands_col5,$brands_col5,$brands_col5) as $b): ?>
              <div class="brand-card bg-white shadow-sm flex flex-col items-center justify-center gap-3 sm:gap-4 p-5 sm:p-8 cursor-pointer rounded-lg" style="width:240px;height:240px;flex-shrink:0;">
                <span class="material-symbols-outlined text-6xl" style="color:<?= $b['color'] ?>"><?= $b['icon'] ?></span>
                <span class="text-sm font-black text-gray-700 text-center uppercase tracking-tight"><?= $b['name'] ?></span>
              </div>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Column 6 - scrolls DOWN -->
          <div class="marquee-col" style="display:flex;flex-direction:column;gap:16px;overflow:hidden;height:900px;flex-shrink:0;">
            <div class="animate-marquee-vertical-reverse" style="display:flex;flex-direction:column;gap:16px;">
              <?php
              $brands_col6 = [
                ['name'=>'Schneider','icon'=>'bolt','color'=>'#059669'],
                ['name'=>'Bosch','icon'=>'engineering','color'=>'#dc2626'],
                ['name'=>'Siemens','icon'=>'settings','color'=>'#0891b2'],
              ];
              foreach(array_merge($brands_col6,$brands_col6,$brands_col6,$brands_col6) as $b): ?>
              <div class="brand-card bg-white shadow-sm flex flex-col items-center justify-center gap-2 sm:gap-3 p-4 sm:p-6 cursor-pointer rounded-lg" style="width:180px;height:180px;flex-shrink:0;">
                <span class="material-symbols-outlined text-4xl" style="color:<?= $b['color'] ?>"><?= $b['icon'] ?></span>
                <span class="text-xs font-black text-gray-700 text-center uppercase tracking-tight"><?= $b['name'] ?></span>
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
<section class="bg-primary-container py-24">
    <div class="container mx-auto px-8">
        <h2 class="text-white text-4xl font-black mb-16 uppercase tracking-tight">Industries We Serve</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="relative group h-[500px] overflow-hidden">
                <img alt="Hospital" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAoXkJP5BaMyzbVYVTdPzXnxlJKuuNs7X9SNfzG2RPCL5khTeZvIwalCh9XZfZSIACZg7H9LCJMZklabaIQerylTaKO3rwp0XfnHKVZIuFSt2-Oj_tkX5PGOZOkNbLPDW0sspZDyPTBFF8M3T_Wu4ElNy3F-LLZeD1vJDWuVSYMbRDHicRYaL57ngwa6JvpJkqegAz4UlQFbTfebljpmmcYwmmbQ07zUF8HKbJvKeUV-1HBWTyBbZsKMDxU0Fn_ZkKEtvGgWm3X9EQ">
                <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-blue-900/40 to-transparent flex flex-col justify-end p-8">
                    <span class="bg-secondary-container text-black font-black text-[10px] px-2 py-1 uppercase w-fit mb-2">Medical</span>
                    <h3 class="text-white text-2xl font-bold uppercase mb-4">Hospitals &amp; Clinics</h3>
                </div>
            </div>
            <div class="relative group h-[500px] overflow-hidden">
                <img alt="Hotel" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA6EO5K0zcbj9qmQ1pr2VNltfcLFoeebNpGYXfSInJSIZPXAqy4fH8A-LKcTBuL0lDH2uvZ9E-2ucygYRE5I1q-gEnSLXQxmuUzdkkIRV6LcKfWI7RY1GOzaiol0tqS6LQodunm23Ktq1iiVoP146n5s6pnUZSRY--ZYbHNlj0HIp76MeafAPY_ViEoTh3r0UkifABN3dmTQbDT6oURBSalugjrFsuTwDoXua1Fmb1tzIoTWid6_N8qIOXvvPLw6JemIoEr3rRjmt4">
                <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-blue-900/40 to-transparent flex flex-col justify-end p-8">
                    <span class="bg-secondary-container text-black font-black text-[10px] px-2 py-1 uppercase w-fit mb-2">Hospitality</span>
                    <h3 class="text-white text-2xl font-bold uppercase mb-4">Hotels &amp; Hospitality</h3>
                </div>
            </div>
            <div class="relative group h-[500px] overflow-hidden">
                <img alt="Office" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAX_YnU92Il1WBQ9ajQFetNtoJA85UAoEsmy_lcsj5xm8MYrOTUADxvzGNMaLF4lS_F7-gqr8Df7mjXZk4z7PBAGjUyRZZFDwJkgOz2dwy0O8Dea5uRQF8eWQKukPaNzkZYDOe6_kdEIVU46FAuM2F64bgtjqZvovIZk5ivX1QU5SPLu4TDKsddZzPyAzyJHNEe8JIuAxvWldl0RXsynCwdlk7dsnksJHCe-p0ZY0fkFRDX6yPM5_OtZv1LUYe-9nPMYCGFv4Yefkk">
                <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-blue-900/40 to-transparent flex flex-col justify-end p-8">
                    <span class="bg-secondary-container text-black font-black text-[10px] px-2 py-1 uppercase w-fit mb-2">Corporate</span>
                    <h3 class="text-white text-2xl font-bold uppercase mb-4">Corporate Offices</h3>
                </div>
            </div>
            <div class="relative group h-[500px] overflow-hidden">
                <img alt="Industrial" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDFSeFnVNTbWH0jsdGiX2tFRvXBVcweyDTRzIxvMX70TWqoacUfTCcrabju-nfEJ3j7-uXq7x_7Oehh5MSlh3_gLv4uj-XsVIF5NuuFpWIAC-zfU1MbDCVi5zu_J3WU81Krq7-z4DlN1qfwcNqQt-2Q9d9hdbjHetYnbar_N2Ron7Q1daeLG0kksmFpTcr5jUoIW8rn-o4t8KJnmopwz9_Mh13Jy-6-L-8Z1P6OQmOOijrgmpFPS5q1nmgMuuE4RX21OlCCZemcg8Y">
                <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-blue-900/40 to-transparent flex flex-col justify-end p-8">
                    <span class="bg-secondary-container text-black font-black text-[10px] px-2 py-1 uppercase w-fit mb-2">Manufacturing</span>
                    <h3 class="text-white text-2xl font-bold uppercase mb-4">Industrial Facilities</h3>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section: Testimonials (Client Reviews) -->
<section class="bg-surface-container-low py-32 px-8 border-t border-black/5">
    <div class="container mx-auto">
        <h2 class="text-black text-4xl font-black mb-20 uppercase tracking-tight text-center">B2B Trust Report</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-12 border-t-8 border-secondary-container industrial-glow transition-all shadow-xl">
                <span class="material-symbols-outlined text-secondary-container text-7xl mb-6 block" style="font-variation-settings: 'FILL' 1;">format_quote</span>
                <p class="text-black text-xl font-bold leading-relaxed mb-8 italic">"Snap Marketing transformed our facility hygiene with their automated solutions. The scale they operate at is truly impressive."</p>
                <div class="text-primary-container font-black uppercase text-sm tracking-widest border-l-4 border-primary-container pl-4">Operation Manager, Fortis Hospitals</div>
            </div>
            <div class="bg-white p-12 border-t-8 border-secondary-container industrial-glow transition-all shadow-xl">
                <span class="material-symbols-outlined text-secondary-container text-7xl mb-6 block" style="font-variation-settings: 'FILL' 1;">format_quote</span>
                <p class="text-black text-xl font-bold leading-relaxed mb-8 italic">"The technical support during our cold-chain setup was world-class. Reliable partners for any large-scale industrial project."</p>
                <div class="text-primary-container font-black uppercase text-sm tracking-widest border-l-4 border-primary-container pl-4">Director, Amul Cold Storage</div>
            </div>
            <div class="bg-white p-12 border-t-8 border-secondary-container industrial-glow transition-all shadow-xl">
                <span class="material-symbols-outlined text-secondary-container text-7xl mb-6 block" style="font-variation-settings: 'FILL' 1;">format_quote</span>
                <p class="text-black text-xl font-bold leading-relaxed mb-8 italic">"Precision and speed. Snap handles our bulk requirements with zero friction. Highly recommended for corporate procurement."</p>
                <div class="text-primary-container font-black uppercase text-sm tracking-widest border-l-4 border-primary-container pl-4">Procurement Head, Tata Motors</div>
            </div>
        </div>
    </div>
</section>

<!-- Section 8: Request a Quote Banner -->
<section class="bg-black py-24 relative overflow-hidden">
    <div class="absolute right-0 top-0 w-1/3 h-full bg-primary-container diagonal-band opacity-20"></div>
    <div class="container mx-auto px-8 relative z-10 text-center">
        <h2 class="text-secondary-container text-5xl md:text-6xl font-black mb-6 uppercase italic">Ready to Order in Bulk?</h2>
        <p class="text-white text-xl mb-12 max-w-2xl mx-auto opacity-80 font-medium">Get exclusive institutional pricing for your enterprise today. Our dedicated account managers are ready to assist.</p>
        <a href="/request-a-quote" class="inline-block bg-secondary-container text-black px-12 py-6 font-black uppercase text-xl hover:-translate-y-1 hover:shadow-2xl active:scale-95 transition-all duration-300 tracking-widest shadow-[10px_10px_0px_rgba(251,191,36,0.3)]">
            GET A CUSTOM QUOTE NOW
        </a>
    </div>
</section>


<?php get_footer(); ?>
