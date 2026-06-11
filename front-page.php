<?php
/*
Template Name: Front Page
*/
get_header();
?>

<!-- Section 1: HERO SLIDER -->
<header id="hero-slider" class="relative min-h-screen pt-20 flex items-center overflow-hidden bg-[#172554]">
    <!-- Bottom fade for stat strip transition -->
    <div class="absolute bottom-0 left-0 w-full h-1/5 bg-gradient-to-t from-[#172554] to-transparent z-[15]"></div>

    <!-- Slides Container -->
    <div class="absolute inset-0 z-10">
      <?php
      $hero_slides = [
        [
          'badge'    => 'NEW CATALOG 2025',
          'heading'  => 'Precision Equipment. <br/><span class="text-secondary-container">Bulk Pricing.</span>',
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
          'heading'  => 'Cold Chain <br/><span class="text-secondary-container">Solutions.</span>',
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
          'heading'  => 'Automated Hygiene <br/><span class="text-secondary-container">at Scale.</span>',
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
                    <span class="hero-animate inline-block bg-secondary-container text-black font-black text-[12px] px-4 py-1.5 mb-5 tracking-[0.05em] uppercase"><?= $slide['badge'] ?></span>
                    <h1 class="hero-animate text-white text-4xl sm:text-5xl md:text-[72px] font-extrabold leading-[1.05] tracking-tight mb-6" style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800;">
                        <?= $slide['heading'] ?>
                    </h1>
                    <p class="hero-animate text-white/90 text-[18px] max-w-2xl leading-relaxed mb-8 font-medium">
                        <?= $slide['desc'] ?>
                    </p>
                    <div class="hero-animate flex flex-wrap gap-3">
                        <a href="<?= $slide['cta1_href'] ?>" class="bg-secondary-container text-black px-8 py-4 font-black uppercase text-sm tracking-widest flex items-center gap-2 hover:bg-yellow-400 hover:-translate-y-1 hover:shadow-xl active:scale-95 transition-all duration-300 rounded-none">
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
    <button id="hero-prev" class="absolute left-4 sm:left-8 top-1/2 -translate-y-1/2 z-30 w-11 h-11 bg-white/5 hover:bg-secondary-container hover:text-black text-white/60 flex items-center justify-center transition-all duration-300 active:scale-90 backdrop-blur-md border border-white/10" aria-label="Previous slide">
      <span class="material-symbols-outlined text-xl">chevron_left</span>
    </button>
    <button id="hero-next" class="absolute right-4 sm:right-8 top-1/2 -translate-y-1/2 z-30 w-11 h-11 bg-white/5 hover:bg-secondary-container hover:text-black text-white/60 flex items-center justify-center transition-all duration-300 active:scale-90 backdrop-blur-md border border-white/10" aria-label="Next slide">
      <span class="material-symbols-outlined text-xl">chevron_right</span>
    </button>

    <!-- Slider Navigation: Dots + Progress -->
    <div class="absolute bottom-8 left-8 sm:left-12 z-30 flex items-center gap-2">
      <?php for($i = 0; $i < count($hero_slides); $i++): ?>
      <button class="hero-dot group relative h-1 transition-all duration-500 overflow-hidden <?= $i === 0 ? 'w-16 bg-white/40' : 'w-8 bg-white/15' ?>" data-dot="<?= $i ?>" aria-label="Go to slide <?= $i + 1 ?>">
        <span class="hero-dot-fill absolute inset-0 bg-secondary-container origin-left scale-x-0 <?= $i === 0 ? 'animate-hero-progress' : '' ?>"></span>
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

<!-- Section: Featured Products (Carousel) -->
<section class="bg-white py-24 overflow-hidden">
    <div class="container mx-auto px-8 relative">
        <div class="mb-16 border-l-8 border-[#FBBF24] pl-6">
            <h2 class="text-black text-4xl font-black uppercase tracking-tight">Featured Products</h2>
            <p class="text-[#0F172A] font-bold mt-2 uppercase tracking-widest text-sm">Most Requested B2B Equipment This Month</p>
        </div>
        
        <!-- Carousel Wrapper -->
        <div class="relative w-full">
            <div id="featured-carousel" class="flex overflow-x-auto snap-x snap-mandatory gap-6 pb-20 no-scrollbar scroll-smooth">
                
                <!-- Product 1 -->
                <div class="snap-start shrink-0 w-full md:w-[calc(33.333%-1rem)] lg:w-[calc(25%-1.125rem)] group bg-white border-2 border-zinc-200 hover:border-[#FBBF24] transition-colors duration-300 flex flex-col cursor-pointer">
                    <div class="relative bg-primary aspect-square flex items-center justify-center p-8 lg:p-12">
                        <span class="absolute top-0 left-0 bg-[#FBBF24] text-black font-black text-[10px] px-3 py-1.5 uppercase tracking-widest">BEST SELLER</span>
                        <span class="material-symbols-outlined text-white text-6xl lg:text-8xl group-hover:scale-110 transition-transform duration-500">sensor_occupied</span>
                    </div>
                    <div class="p-4 lg:p-6 flex-grow flex flex-col">
                        <span class="inline-block bg-primary text-white text-[10px] font-black px-2 py-0.5 w-fit mb-3 uppercase tracking-widest">EURONICS</span>
                        <h4 class="text-black font-black text-lg lg:text-xl mb-6 leading-tight">Auto Sensor Flusher EF-100</h4>
                        <div class="mt-auto">
                            <a href="/request-a-quote" class="block w-full bg-primary text-white font-black py-3 lg:py-4 px-2 uppercase text-xs hover:bg-[#FBBF24] hover:text-black transition-colors duration-300 text-center">₹ Quote</a>
                        </div>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="snap-start shrink-0 w-full md:w-[calc(33.333%-1rem)] lg:w-[calc(25%-1.125rem)] group bg-white border-2 border-zinc-200 hover:border-[#FBBF24] transition-colors duration-300 flex flex-col cursor-pointer">
                    <div class="relative bg-primary aspect-square flex items-center justify-center p-8 lg:p-12 border-b-2 border-zinc-200">
                        <span class="absolute top-0 left-0 bg-[#FBBF24] text-black font-black text-[10px] px-3 py-1.5 uppercase tracking-widest">TOP PICK</span>
                        <span class="material-symbols-outlined text-white text-6xl lg:text-8xl group-hover:scale-110 transition-transform duration-500">kitchen</span>
                    </div>
                    <div class="p-4 lg:p-6 flex-grow flex flex-col">
                        <span class="inline-block bg-primary text-white text-[10px] font-black px-2 py-0.5 w-fit mb-3 uppercase tracking-widest">BLUE STAR</span>
                        <h4 class="text-black font-black text-lg lg:text-xl mb-6 leading-tight">Deep Freezer DF-300</h4>
                        <div class="mt-auto">
                            <a href="/request-a-quote" class="block w-full bg-primary text-white font-black py-3 lg:py-4 px-2 uppercase text-xs hover:bg-[#FBBF24] hover:text-black transition-colors duration-300 text-center">₹ Quote</a>
                        </div>
                    </div>
                </div>

                <!-- Product 3 -->
                <div class="snap-start shrink-0 w-full md:w-[calc(33.333%-1rem)] lg:w-[calc(25%-1.125rem)] group bg-white border-2 border-zinc-200 hover:border-[#FBBF24] transition-colors duration-300 flex flex-col cursor-pointer">
                    <div class="relative bg-primary aspect-square flex items-center justify-center p-8 lg:p-12">
                        <span class="absolute top-0 left-0 bg-[#FBBF24] text-black font-black text-[10px] px-3 py-1.5 uppercase tracking-widest">POPULAR</span>
                        <span class="material-symbols-outlined text-white text-6xl lg:text-8xl group-hover:scale-110 transition-transform duration-500">water_damage</span>
                    </div>
                    <div class="p-4 lg:p-6 flex-grow flex flex-col">
                        <span class="inline-block bg-primary text-white text-[10px] font-black px-2 py-0.5 w-fit mb-3 uppercase tracking-widest">AQUAGUARD</span>
                        <h4 class="text-black font-black text-lg lg:text-xl mb-6 leading-tight">Grand RO+UV System</h4>
                        <div class="mt-auto">
                            <a href="/request-a-quote" class="block w-full bg-primary text-white font-black py-3 lg:py-4 px-2 uppercase text-xs hover:bg-[#FBBF24] hover:text-black transition-colors duration-300 text-center">₹ Quote</a>
                        </div>
                    </div>
                </div>

                <!-- Product 4 -->
                <div class="snap-start shrink-0 w-full md:w-[calc(33.333%-1rem)] lg:w-[calc(25%-1.125rem)] group bg-white border-2 border-zinc-200 hover:border-[#FBBF24] transition-colors duration-300 flex flex-col cursor-pointer">
                    <div class="relative bg-primary aspect-square flex items-center justify-center p-8 lg:p-12 border-b-2 border-zinc-200">
                        <span class="absolute top-0 left-0 bg-[#FBBF24] text-black font-black text-[10px] px-3 py-1.5 uppercase tracking-widest">NEW</span>
                        <span class="material-symbols-outlined text-white text-6xl lg:text-8xl group-hover:scale-110 transition-transform duration-500">soap</span>
                    </div>
                    <div class="p-4 lg:p-6 flex-grow flex flex-col">
                        <span class="inline-block bg-primary text-white text-[10px] font-black px-2 py-0.5 w-fit mb-3 uppercase tracking-widest">KIMBERLY CLARK</span>
                        <h4 class="text-black font-black text-lg lg:text-xl mb-6 leading-tight">KC Soap Dispenser 1L</h4>
                        <div class="mt-auto">
                            <a href="/request-a-quote" class="block w-full bg-primary text-white font-black py-3 lg:py-4 px-2 uppercase text-xs hover:bg-[#FBBF24] hover:text-black transition-colors duration-300 text-center">₹ Quote</a>
                        </div>
                    </div>
                </div>

                <!-- Product 5 -->
                <div class="snap-start shrink-0 w-full md:w-[calc(33.333%-1rem)] lg:w-[calc(25%-1.125rem)] group bg-white border-2 border-zinc-200 hover:border-[#FBBF24] transition-colors duration-300 flex flex-col cursor-pointer">
                    <div class="relative bg-primary aspect-square flex items-center justify-center p-8 lg:p-12">
                        <span class="absolute top-0 left-0 bg-[#FBBF24] text-black font-black text-[10px] px-3 py-1.5 uppercase tracking-widest">HEAVY DUTY</span>
                        <span class="material-symbols-outlined text-white text-6xl lg:text-8xl group-hover:scale-110 transition-transform duration-500">air</span>
                    </div>
                    <div class="p-4 lg:p-6 flex-grow flex flex-col">
                        <span class="inline-block bg-primary text-white text-[10px] font-black px-2 py-0.5 w-fit mb-3 uppercase tracking-widest">EURONICS</span>
                        <h4 class="text-black font-black text-lg lg:text-xl mb-6 leading-tight">Jet Hand Dryer ES-01</h4>
                        <div class="mt-auto">
                            <a href="/request-a-quote" class="block w-full bg-primary text-white font-black py-3 lg:py-4 px-2 uppercase text-xs hover:bg-[#FBBF24] hover:text-black transition-colors duration-300 text-center">₹ Quote</a>
                        </div>
                    </div>
                </div>

                <!-- Product 6 -->
                <div class="snap-start shrink-0 w-full md:w-[calc(33.333%-1rem)] lg:w-[calc(25%-1.125rem)] group bg-white border-2 border-zinc-200 hover:border-[#FBBF24] transition-colors duration-300 flex flex-col cursor-pointer">
                    <div class="relative bg-primary aspect-square flex items-center justify-center p-8 lg:p-12 border-b-2 border-zinc-200">
                        <span class="absolute top-0 left-0 bg-[#FBBF24] text-black font-black text-[10px] px-3 py-1.5 uppercase tracking-widest">RESTOCKED</span>
                        <span class="material-symbols-outlined text-white text-6xl lg:text-8xl group-hover:scale-110 transition-transform duration-500">delete</span>
                    </div>
                    <div class="p-4 lg:p-6 flex-grow flex flex-col">
                        <span class="inline-block bg-primary text-white text-[10px] font-black px-2 py-0.5 w-fit mb-3 uppercase tracking-widest">DIVERSEY</span>
                        <h4 class="text-black font-black text-lg lg:text-xl mb-6 leading-tight">Commercial Waste Bin 60L</h4>
                        <div class="mt-auto">
                            <a href="/request-a-quote" class="block w-full bg-primary text-white font-black py-3 lg:py-4 px-2 uppercase text-xs hover:bg-[#FBBF24] hover:text-black transition-colors duration-300 text-center">₹ Quote</a>
                        </div>
                    </div>
                </div>

            </div>
            
            <!-- Carousel Navigation -->
            <div class="absolute bottom-0 right-0 flex gap-2">
                <button id="feat-prev" class="bg-primary text-white w-12 h-12 flex items-center justify-center hover:bg-[#FBBF24] hover:text-black transition-colors" aria-label="Previous">
                    <span class="material-symbols-outlined">arrow_back</span>
                </button>
                <button id="feat-next" class="bg-primary text-white w-12 h-12 flex items-center justify-center hover:bg-[#FBBF24] hover:text-black transition-colors" aria-label="Next">
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>
            </div>
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
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const carousel = document.getElementById('featured-carousel');
    const prevBtn = document.getElementById('feat-prev');
    const nextBtn = document.getElementById('feat-next');

    if(carousel && prevBtn && nextBtn) {
        const scrollAmount = () => {
            const card = carousel.querySelector('div.snap-start');
            if(!card) return 0;
            // Get the card width plus the gap (gap-6 is 1.5rem = 24px)
            const style = window.getComputedStyle(carousel);
            const gap = parseFloat(style.gap) || 24;
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
<section class="bg-white py-10 sm:py-12 lg:py-14 px-4 sm:px-8 lg:px-[7.7vw]">
  <div class="w-full mx-auto xl:max-w-[1440px]">
    <div class="text-center mb-8 sm:mb-10 lg:mb-12 reveal">
      <span class="inline-block bg-secondary-container text-black font-black text-xs px-4 py-1.5 uppercase tracking-widest mb-3">Brand Partners</span>
      <h2 class="text-2xl sm:text-4xl lg:text-5xl xl:text-6xl font-black text-on-surface mb-4 sm:mb-6">Global Brand Connections</h2>
      <p class="text-base sm:text-lg leading-relaxed text-on-surface-variant font-medium text-center px-2">Partnering with global brands to deliver premium products and enterprise solutions.</p>
    </div>
    <!-- 3D Perspective Marquee Grid (Bhakti-style tilted layout) -->
    <div class="relative reveal" style="overflow:hidden;">
      <div class="relative flex max-w-full w-full flex-row items-center justify-center overflow-hidden bg-gradient-to-br from-gray-50 to-white px-1 lg:px-2" style="height:600px;perspective:800px;">
        <!-- Single 3D-tilted wrapper for ALL columns -->
        <div class="flex flex-row items-center gap-4 sm:gap-4 lg:gap-4" style="transform:translateX(0) translateY(-1px) translateZ(-50px) rotateX(15deg) rotateY(-5deg) rotateZ(12deg);">

          <!-- Column 1 - scrolls UP -->
          <div class="marquee-col" style="display:flex;flex-direction:column;gap:16px;overflow:hidden;height:800px;flex-shrink:0;">
            <div class="animate-marquee-vertical" style="display:flex;flex-direction:column;gap:16px;">
              <?php
              $brands_col1 = [
                ['name'=>'Euronics','icon'=>'sensor_occupied','color'=>'#1A56DB'],
                ['name'=>'Blue Star','icon'=>'ac_unit','color'=>'#0369a1'],
                ['name'=>'Aquaguard','icon'=>'water_drop','color'=>'#0891b2'],
              ];
              foreach(array_merge($brands_col1,$brands_col1,$brands_col1) as $b): ?>
              <div class="group brand-card bg-white shadow-xl shadow-blue-900/5 border-2 border-transparent hover:border-[#FBBF24] flex flex-col items-center justify-center gap-6 cursor-pointer rounded-none hover:-translate-y-2 hover:shadow-2xl transition-all duration-300" style="width:200px;height:200px;flex-shrink:0;">
                <span class="material-symbols-outlined text-[64px] group-hover:scale-110 group-hover:rotate-6 transition-transform duration-300" style="color:<?= $b['color'] ?>"><?= $b['icon'] ?></span>
                <span class="text-lg font-black text-gray-800 text-center uppercase tracking-wide leading-tight"><?= $b['name'] ?></span>
              </div>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Column 2 - scrolls DOWN -->
          <div class="marquee-col" style="display:flex;flex-direction:column;gap:16px;overflow:hidden;height:800px;flex-shrink:0;">
            <div class="animate-marquee-vertical-reverse" style="display:flex;flex-direction:column;gap:16px;">
              <?php
              $brands_col2 = [
                ['name'=>'Kimberly Clark','icon'=>'soap','color'=>'#1A56DB'],
                ['name'=>'Dettol','icon'=>'sanitizer','color'=>'#dc2626'],
                ['name'=>'Somany','icon'=>'door_front','color'=>'#7c3aed'],
              ];
              foreach(array_merge($brands_col2,$brands_col2,$brands_col2) as $b): ?>
              <div class="group brand-card bg-white shadow-xl shadow-blue-900/5 border-2 border-transparent hover:border-[#FBBF24] flex flex-col items-center justify-center gap-6 cursor-pointer rounded-none hover:-translate-y-2 hover:shadow-2xl transition-all duration-300" style="width:200px;height:200px;flex-shrink:0;">
                <span class="material-symbols-outlined text-[64px] group-hover:scale-110 group-hover:rotate-6 transition-transform duration-300" style="color:<?= $b['color'] ?>"><?= $b['icon'] ?></span>
                <span class="text-lg font-black text-gray-800 text-center uppercase tracking-wide leading-tight"><?= $b['name'] ?></span>
              </div>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Column 3 - scrolls UP -->
          <div class="marquee-col" style="display:flex;flex-direction:column;gap:16px;overflow:hidden;height:800px;flex-shrink:0;">
            <div class="animate-marquee-vertical" style="display:flex;flex-direction:column;gap:16px;">
              <?php
              $brands_col3 = [
                ['name'=>'KENT','icon'=>'water_drop','color'=>'#059669'],
                ['name'=>'Godrej','icon'=>'lock','color'=>'#d97706'],
                ['name'=>'Finolex','icon'=>'electrical_services','color'=>'#dc2626'],
              ];
              foreach(array_merge($brands_col3,$brands_col3,$brands_col3) as $b): ?>
              <div class="group brand-card bg-white shadow-xl shadow-blue-900/5 border-2 border-transparent hover:border-[#FBBF24] flex flex-col items-center justify-center gap-6 cursor-pointer rounded-none hover:-translate-y-2 hover:shadow-2xl transition-all duration-300" style="width:200px;height:200px;flex-shrink:0;">
                <span class="material-symbols-outlined text-[64px] group-hover:scale-110 group-hover:rotate-6 transition-transform duration-300" style="color:<?= $b['color'] ?>"><?= $b['icon'] ?></span>
                <span class="text-lg font-black text-gray-800 text-center uppercase tracking-wide leading-tight"><?= $b['name'] ?></span>
              </div>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Column 4 - scrolls DOWN -->
          <div class="marquee-col" style="display:flex;flex-direction:column;gap:16px;overflow:hidden;height:800px;flex-shrink:0;">
            <div class="animate-marquee-vertical-reverse" style="display:flex;flex-direction:column;gap:16px;">
              <?php
              $brands_col4 = [
                ['name'=>'Astral','icon'=>'plumbing','color'=>'#1A56DB'],
                ['name'=>'Hafele','icon'=>'kitchen','color'=>'#1A56DB'],
                ['name'=>'Honeywell','icon'=>'settings_remote','color'=>'#d97706'],
              ];
              foreach(array_merge($brands_col4,$brands_col4,$brands_col4) as $b): ?>
              <div class="group brand-card bg-white shadow-xl shadow-blue-900/5 border-2 border-transparent hover:border-[#FBBF24] flex flex-col items-center justify-center gap-6 cursor-pointer rounded-none hover:-translate-y-2 hover:shadow-2xl transition-all duration-300" style="width:200px;height:200px;flex-shrink:0;">
                <span class="material-symbols-outlined text-[64px] group-hover:scale-110 group-hover:rotate-6 transition-transform duration-300" style="color:<?= $b['color'] ?>"><?= $b['icon'] ?></span>
                <span class="text-lg font-black text-gray-800 text-center uppercase tracking-wide leading-tight"><?= $b['name'] ?></span>
              </div>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Column 5 - scrolls UP -->
          <div class="marquee-col" style="display:flex;flex-direction:column;gap:16px;overflow:hidden;height:800px;flex-shrink:0;">
            <div class="animate-marquee-vertical" style="display:flex;flex-direction:column;gap:16px;">
              <?php
              $brands_col5 = [
                ['name'=>'Johnson Controls','icon'=>'hvac','color'=>'#dc2626'],
                ['name'=>'3M India','icon'=>'science','color'=>'#dc2626'],
                ['name'=>'EBCO','icon'=>'inventory','color'=>'#059669'],
              ];
              foreach(array_merge($brands_col5,$brands_col5,$brands_col5) as $b): ?>
              <div class="group brand-card bg-white shadow-xl shadow-blue-900/5 border-2 border-transparent hover:border-[#FBBF24] flex flex-col items-center justify-center gap-6 cursor-pointer rounded-none hover:-translate-y-2 hover:shadow-2xl transition-all duration-300" style="width:200px;height:200px;flex-shrink:0;">
                <span class="material-symbols-outlined text-[64px] group-hover:scale-110 group-hover:rotate-6 transition-transform duration-300" style="color:<?= $b['color'] ?>"><?= $b['icon'] ?></span>
                <span class="text-lg font-black text-gray-800 text-center uppercase tracking-wide leading-tight"><?= $b['name'] ?></span>
              </div>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Column 6 - scrolls DOWN -->
          <div class="marquee-col" style="display:flex;flex-direction:column;gap:16px;overflow:hidden;height:800px;flex-shrink:0;">
            <div class="animate-marquee-vertical-reverse" style="display:flex;flex-direction:column;gap:16px;">
              <?php
              $brands_col6 = [
                ['name'=>'Schneider','icon'=>'bolt','color'=>'#059669'],
                ['name'=>'Bosch','icon'=>'engineering','color'=>'#dc2626'],
                ['name'=>'Siemens','icon'=>'settings','color'=>'#0891b2'],
              ];
              foreach(array_merge($brands_col6,$brands_col6,$brands_col6) as $b): ?>
              <div class="group brand-card bg-white shadow-xl shadow-blue-900/5 border-2 border-transparent hover:border-[#FBBF24] flex flex-col items-center justify-center gap-6 cursor-pointer rounded-none hover:-translate-y-2 hover:shadow-2xl transition-all duration-300" style="width:200px;height:200px;flex-shrink:0;">
                <span class="material-symbols-outlined text-[64px] group-hover:scale-110 group-hover:rotate-6 transition-transform duration-300" style="color:<?= $b['color'] ?>"><?= $b['icon'] ?></span>
                <span class="text-lg font-black text-gray-800 text-center uppercase tracking-wide leading-tight"><?= $b['name'] ?></span>
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

<!-- Section: Process Management -->
<section class="bg-zinc-50 py-24 overflow-hidden border-t border-zinc-200">
    <div class="container mx-auto px-8 relative flex flex-col gap-6 xl:min-h-[2200px] w-full">
        <div class="mx-auto text-center">
            <p class="inline-block py-1.5 px-3.5 text-xs font-black uppercase tracking-widest border-2 border-primary bg-primary/10 text-primary mb-4">Process Management</p>
            <h2 class="font-black uppercase tracking-tight lg:text-5xl text-3xl text-black">Industrial-Scale Order Fulfillment</h2>
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
                <div class="w-10 h-10 lg:w-16 lg:h-16 shrink-0 bg-primary flex items-center justify-center text-white">
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
                <div class="w-10 h-10 lg:w-16 lg:h-16 shrink-0 bg-primary flex items-center justify-center text-white">
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
                <div class="w-10 h-10 lg:w-16 lg:h-16 shrink-0 bg-primary flex items-center justify-center text-white">
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
                <div class="w-10 h-10 lg:w-16 lg:h-16 shrink-0 bg-primary flex items-center justify-center text-white">
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
                <div class="w-10 h-10 lg:w-16 lg:h-16 shrink-0 bg-primary flex items-center justify-center text-white">
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
            <div class="hiw-card z-10 absolute top-[85%] md:top-[88%] xl:top-[89%] left-[35%] md:left-[30%] xl:left-[60%] flex w-[152px] sm:w-[200px] md:w-[270px] lg:w-[340px] shadow-[8px_8px_0px_#1A56DB] border-2 border-primary bg-zinc-900 p-4 lg:p-6 gap-4 transition-all duration-700 ease-[cubic-bezier(0.22,1,0.36,1)] opacity-0 translate-y-6 scale-95 blur-sm">
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

        const updatePaths = () => {
            if(!svgContainer) return;
            const rect = svgContainer.getBoundingClientRect();
            const windowHeight = window.innerHeight;
            
            let scrollPercentage = (windowHeight - rect.top) / (rect.height + windowHeight);
            scrollPercentage = Math.min(Math.max(scrollPercentage * 1.5 - 0.2, 0), 1);
            
            paths.forEach(path => {
                // Only process visible paths to avoid getTotalLength() returning 0
                if (path.closest('.svg-container').offsetParent !== null) {
                    // Fallback to explicit lengths if browser still returns 0
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
        };

        // Setup scroll-linked SVG drawing
        if(paths.length > 0 && svgContainer) {
            window.addEventListener('scroll', updatePaths, { passive: true });
            // Run once on load to set initial state
            setTimeout(updatePaths, 100);
        }

        // Setup Intersection Observer for card pop-ins
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
            threshold: 0.3, // Trigger when 30% of the card is visible
            rootMargin: "0px 0px -50px 0px"
        });

        cards.forEach(card => observer.observe(card));
    });
    </script>
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
