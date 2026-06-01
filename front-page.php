<?php
/*
Template Name: Front Page
*/
?>
<!DOCTYPE html>

<html class="scroll-smooth" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Snap Marketing | Industrial B2B Equipment Wholesaler</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800;900&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .diagonal-band {
            clip-path: polygon(25% 0%, 100% 0%, 75% 100%, 0% 100%);
        }
        .industrial-glow:hover {
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
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee {
            display: flex;
            width: 200%;
            animation: marquee 30s linear infinite;
        }
        .animate-marquee:hover {
            animation-play-state: paused;
        }
    </style>
<script id="tailwind-config">
        tailwind.config = {
          darkMode: "class",
          theme: {
            extend: {
              colors: {
                "on-tertiary-container": "#e0dcdc",
                "tertiary": "#4a4949",
                "inverse-primary": "#b5c4ff",
                "surface": "#fcf8f8",
                "tertiary-container": "#626161",
                "on-surface-variant": "#434654",
                "on-error": "#ffffff",
                "on-error-container": "#93000a",
                "on-tertiary-fixed": "#1c1b1b",
                "surface-container-highest": "#e5e2e1",
                "error-container": "#ffdad6",
                "surface-container-high": "#ebe7e7",
                "surface-container": "#f0edec",
                "error": "#ba1a1a",
                "tertiary-fixed-dim": "#c9c6c5",
                "on-tertiary-fixed-variant": "#474646",
                "on-primary-fixed-variant": "#003dab",
                "outline-variant": "#c3c5d7",
                "on-secondary-fixed": "#261a00",
                "surface-tint": "#1353d8",
                "on-tertiary": "#ffffff",
                "on-secondary-container": "#6f5100",
                "inverse-surface": "#313030",
                "secondary-container": "#FBBF24",
                "surface-variant": "#e5e2e1",
                "on-primary": "#ffffff",
                "primary-fixed-dim": "#b5c4ff",
                "surface-bright": "#fcf8f8",
                "surface-container-low": "#f6f3f2",
                "secondary": "#795900",
                "on-surface": "#1c1b1b",
                "primary-fixed": "#dbe1ff",
                "surface-dim": "#dcd9d9",
                "on-primary-container": "#d4dcff",
                "outline": "#737686",
                "on-primary-fixed": "#00174d",
                "on-background": "#1c1b1b",
                "primary-container": "#1A56DB",
                "on-secondary": "#ffffff",
                "inverse-on-surface": "#f3f0ef",
                "background": "#fcf8f8",
                "surface-container-lowest": "#ffffff",
                "secondary-fixed-dim": "#f9bd22",
                "secondary-fixed": "#ffdf9f",
                "primary": "#1A56DB",
                "on-secondary-fixed-variant": "#5c4300",
                "tertiary-fixed": "#e5e2e1"
              },
              fontFamily: {
                "headline": ["Inter"],
                "body": ["Inter"],
                "label": ["Inter"]
              },
              borderRadius: {"DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "full": "0.75rem"},
            },
          },
        }
    </script>
</head>
<body class="bg-surface text-on-surface">

<!-- Section: TopNavBar -->
<nav class="fixed top-0 w-full z-50 bg-primary-container flex justify-between items-center px-8 py-4 shadow-none">
    <div class="text-2xl font-black text-white italic tracking-tighter">Snap Marketing</div>
    <div class="hidden md:flex gap-8 items-center">
        <a class="font-bold uppercase tracking-tight text-white hover:text-secondary-container transition-colors" href="/shop">Shop</a>
        <a class="font-bold uppercase tracking-tight text-white hover:text-secondary-container transition-colors" href="/request-a-quote">Bulk Quote</a>
        <a class="font-bold uppercase tracking-tight text-white hover:text-secondary-container transition-colors" href="/order-tracking">Tracking</a>
        <a class="font-bold uppercase tracking-tight text-white hover:text-secondary-container transition-colors" href="/about-us">About</a>
        <a class="font-bold uppercase tracking-tight text-white hover:text-secondary-container transition-colors" href="/contact-us">Support</a>
    </div>
    <div class="flex items-center gap-4">
        <a href="/request-a-quote" class="bg-secondary-container text-black font-bold py-2 px-6 uppercase text-sm tracking-widest hover:scale-95 duration-150">Get Quote</a>
        <a href="/my-account" class="text-white font-bold uppercase text-sm border-b-2 border-transparent hover:border-secondary-container transition-all">Login</a>
    </div>
</nav>

<!-- Section 1: HERO -->
<header class="relative min-h-screen pt-20 flex items-center overflow-hidden bg-black">
    <div class="absolute inset-0 z-0 opacity-40 diagonal-band bg-primary-container scale-150 -rotate-12 translate-x-1/4"></div>
    <div class="container mx-auto px-8 grid grid-cols-1 md:grid-cols-2 gap-12 relative z-10">
        <div class="flex flex-col justify-center space-y-8">
            <div>
                <span class="inline-block bg-secondary-container text-black font-black text-sm px-4 py-1.5 mb-6 tracking-widest uppercase">NEW CATALOG 2025</span>
                <h1 class="text-white text-6xl md:text-[80px] font-black leading-[1.05] tracking-tight mb-8">
                    Precision Equipment. <br/>
                    <span class="yellow-underline text-white">Bulk Pricing.</span>
                </h1>
                <div class="flex flex-wrap gap-4 mb-8">
                    <a href="/shop" class="bg-secondary-container text-black px-10 py-5 font-black uppercase text-xl flex items-center gap-2 hover:bg-yellow-500 transition-colors">
                        Browse Products <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                    <a href="/request-a-quote" class="border-2 border-white text-white px-10 py-5 font-black uppercase text-xl hover:bg-white hover:text-black transition-all">
                        Request Bulk Quote
                    </a>
                </div>
                <p class="text-gray-300 text-lg md:text-xl max-w-lg leading-relaxed">
                    Supplying washroom automations, commercial refrigeration, and hygiene solutions to 500+ enterprises pan-India.
                </p>
            </div>
        </div>
        <div class="flex items-center justify-center relative">
            <div class="absolute w-[120%] h-[120%] bg-primary-container rounded-full blur-[120px] opacity-20"></div>
            <img alt="Sensor Tap" class="relative z-10 w-full max-w-md drop-shadow-2xl" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDE4MzqiH8Hzcnme1hwaU5h6AYhAx0i3dIbjNKElAvN-0dI3VHfR3Hexm1SxwZhUH3xTH7PTh005QytdXaS-e67Dqta7QxYnSPk81X26hEeR5PdRThP6ErVqR07iP3sQV6oQ9-qQFmuiIguK9lVu2XsU8oeL2RI3HoXXTAf2dymX9WJBcHcbXI5k_7Rz8aKCs8Q7HD0BtKxTOrOgI4PZHNKR2CkNxynLuWg39Nl8irWfVMFFPTiMf0ZQI2MjQBTVuKOdEGB6lwHW2o"/>
        </div>
    </div>
</header>

<!-- Stat Counters Strip -->
<div class="bg-secondary-container w-full py-12 relative z-20">
    <div class="container mx-auto px-8 grid grid-cols-2 md:grid-cols-4 gap-8">
        <div class="text-center md:text-left border-r border-black/10 last:border-none">
            <div class="text-black text-5xl font-black">500+</div>
            <div class="text-black/70 text-sm uppercase font-bold tracking-widest">Active Clients</div>
        </div>
        <div class="text-center md:text-left border-r border-black/10 last:border-none">
            <div class="text-black text-5xl font-black">40+</div>
            <div class="text-black/70 text-sm uppercase font-bold tracking-widest">Global Brands</div>
        </div>
        <div class="text-center md:text-left border-r border-black/10 last:border-none">
            <div class="text-black text-5xl font-black">25</div>
            <div class="text-black/70 text-sm uppercase font-bold tracking-widest">Years Legacy</div>
        </div>
        <div class="text-center md:text-left border-r border-black/10 last:border-none">
            <div class="text-black text-5xl font-black italic">ISO</div>
            <div class="text-black/70 text-sm uppercase font-bold tracking-widest">9001:2015</div>
        </div>
    </div>
</div>

<!-- Section: Global Brand Connections (Marquee) -->
<section class="bg-white py-12 overflow-hidden border-b-8 border-secondary-container">
    <div class="animate-marquee">
        <div class="flex items-center gap-24 px-4">
            <span class="text-primary-container/20 text-5xl font-black uppercase italic tracking-widest">BLUE STAR</span>
            <span class="text-primary-container/20 text-5xl font-black uppercase italic tracking-widest">EURONICS</span>
            <span class="text-primary-container/20 text-5xl font-black uppercase italic tracking-widest">AQUAGUARD</span>
            <span class="text-primary-container/20 text-5xl font-black uppercase italic tracking-widest">KIMBERLY CLARK</span>
            <span class="text-primary-container/20 text-5xl font-black uppercase italic tracking-widest">HP</span>
            <span class="text-primary-container/20 text-5xl font-black uppercase italic tracking-widest">CANON</span>
            <span class="text-primary-container/20 text-5xl font-black uppercase italic tracking-widest">EPSON</span>
        </div>
        <div class="flex items-center gap-24 px-4">
            <span class="text-primary-container/20 text-5xl font-black uppercase italic tracking-widest">BLUE STAR</span>
            <span class="text-primary-container/20 text-5xl font-black uppercase italic tracking-widest">EURONICS</span>
            <span class="text-primary-container/20 text-5xl font-black uppercase italic tracking-widest">AQUAGUARD</span>
            <span class="text-primary-container/20 text-5xl font-black uppercase italic tracking-widest">KIMBERLY CLARK</span>
            <span class="text-primary-container/20 text-5xl font-black uppercase italic tracking-widest">HP</span>
            <span class="text-primary-container/20 text-5xl font-black uppercase italic tracking-widest">CANON</span>
            <span class="text-primary-container/20 text-5xl font-black uppercase italic tracking-widest">EPSON</span>
        </div>
    </div>
</section>

<!-- Section 2: Shop by Category -->
<section class="bg-primary-container py-24">
    <div class="container mx-auto px-8">
        <h2 class="text-white text-4xl font-black mb-16 uppercase tracking-tight">Shop by Category</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-1">
            <a class="group bg-blue-800/50 p-12 h-[500px] flex flex-col justify-between industrial-glow border border-transparent hover:border-yellow-400 transition-all" href="/product-category/washroom-automations/">
                <span class="material-symbols-outlined text-white text-6xl">sanitizer</span>
                <div>
                    <div class="flex justify-between items-end mb-2">
                        <span class="text-secondary-container font-bold text-xs uppercase block">Automated</span>
                        <span class="text-secondary-container font-bold text-xs">45 Products</span>
                    </div>
                    <h3 class="text-white text-3xl font-black">Washroom Automations</h3>
                </div>
            </a>
            <a class="group bg-blue-800/80 p-12 h-[500px] flex flex-col justify-between industrial-glow border border-transparent hover:border-yellow-400 transition-all" href="/product-category/commercial-refrigeration/">
                <span class="material-symbols-outlined text-white text-6xl">ac_unit</span>
                <div>
                    <div class="flex justify-between items-end mb-2">
                        <span class="text-secondary-container font-bold text-xs uppercase block">Commercial</span>
                        <span class="text-secondary-container font-bold text-xs">38 Products</span>
                    </div>
                    <h3 class="text-white text-3xl font-black">Commercial Refrigeration</h3>
                </div>
            </a>
            <a class="group bg-blue-900/50 p-12 h-[500px] flex flex-col justify-between industrial-glow border border-transparent hover:border-yellow-400 transition-all" href="/product-category/water-purifiers/">
                <span class="material-symbols-outlined text-white text-6xl">water_drop</span>
                <div>
                    <div class="flex justify-between items-end mb-2">
                        <span class="text-secondary-container font-bold text-xs uppercase block">Pure</span>
                        <span class="text-secondary-container font-bold text-xs">22 Products</span>
                    </div>
                    <h3 class="text-white text-3xl font-black">Water Purifiers</h3>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- Section: What We Do (B2B Imaging Solutions) -->
<section class="bg-black py-32 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/blueprint.png')]"></div>
    <div class="container mx-auto px-8 grid grid-cols-1 md:grid-cols-2 gap-20 relative z-10">
        <div>
            <h2 class="text-white text-6xl md:text-7xl font-black leading-none mb-10 uppercase tracking-tighter">
                What We <br><span class="yellow-underline text-white">Do.</span>
            </h2>
            <p class="text-gray-400 text-2xl font-medium leading-relaxed max-w-xl">
                Providing high-scale <span class="text-secondary-container">B2B Imaging Solutions</span> and enterprise-grade hardware distribution across the Indian subcontinent.
            </p>
        </div>
        <div class="grid grid-cols-1 gap-8">
            <div class="bg-zinc-900 p-8 border-l-4 border-secondary-container">
                <h4 class="text-white font-black text-xl uppercase mb-2">High-Fidelity Imaging</h4>
                <p class="text-gray-500">Advanced diagnostic and commercial imaging equipment for medical and industrial sectors.</p>
            </div>
            <div class="bg-zinc-900 p-8 border-l-4 border-secondary-container">
                <h4 class="text-white font-black text-xl uppercase mb-2">Scale Distribution</h4>
                <p class="text-gray-500">Infrastructure to handle 10,000+ unit deployments with real-time tracking.</p>
            </div>
            <div class="bg-zinc-900 p-8 border-l-4 border-secondary-container">
                <h4 class="text-white font-black text-xl uppercase mb-2">Tech Integration</h4>
                <p class="text-gray-500">Seamlessly connecting global manufacturers with localized Indian enterprise requirements.</p>
            </div>
        </div>
    </div>
</section>

<!-- Section 3: Featured Products -->
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
                        <a href="/request-a-quote" class="block w-full bg-secondary-container text-black font-black py-3 px-4 uppercase text-sm hover:bg-yellow-500 transition-colors italic text-center">₹ Request Bulk Price</a>
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
                        <a href="/request-a-quote" class="block w-full bg-secondary-container text-black font-black py-3 px-4 uppercase text-sm hover:bg-yellow-500 transition-colors italic text-center">₹ Request Bulk Price</a>
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
                        <a href="/request-a-quote" class="block w-full bg-secondary-container text-black font-black py-3 px-4 uppercase text-sm hover:bg-yellow-500 transition-colors italic text-center">₹ Request Bulk Price</a>
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
                        <a href="/request-a-quote" class="block w-full bg-secondary-container text-black font-black py-3 px-4 uppercase text-sm hover:bg-yellow-500 transition-colors italic text-center">₹ Request Bulk Price</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section: Why Choose Snap Marketing? -->
<section class="bg-zinc-950 py-32 text-white">
    <div class="container mx-auto px-8">
        <h2 class="text-white text-4xl font-black mb-20 text-center uppercase tracking-tight">The Snap Advantage</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-zinc-900 p-12 border-b-4 border-secondary-container flex flex-col items-center text-center">
                <span class="material-symbols-outlined text-secondary-container text-7xl mb-6">verified</span>
                <div class="text-5xl font-black text-secondary-container mb-4">100%</div>
                <h3 class="text-2xl font-black uppercase mb-4 tracking-tight">Genuine Brands</h3>
                <p class="text-gray-300 leading-relaxed">Certified industrial equipment from leading global manufacturers only.</p>
            </div>
            <div class="bg-zinc-900 p-12 border-b-4 border-secondary-container flex flex-col items-center text-center">
                <span class="material-symbols-outlined text-secondary-container text-7xl mb-6">support_agent</span>
                <div class="text-5xl font-black text-secondary-container mb-4">24/7</div>
                <h3 class="text-2xl font-black uppercase mb-4 tracking-tight">Procurement Support</h3>
                <p class="text-gray-300 leading-relaxed">Expert account managers for seamless corporate facility management.</p>
            </div>
            <div class="bg-zinc-900 p-12 border-b-4 border-secondary-container flex flex-col items-center text-center">
                <span class="material-symbols-outlined text-secondary-container text-7xl mb-6">inventory</span>
                <div class="text-5xl font-black text-secondary-container mb-4">5000+</div>
                <h3 class="text-2xl font-black uppercase mb-4 tracking-tight">Available SKUs</h3>
                <p class="text-gray-300 leading-relaxed">The widest catalog of high-performance industrial equipment in India.</p>
            </div>
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
            <!-- Card 1 -->
            <div class="bg-white p-12 border-t-8 border-secondary-container industrial-glow transition-all shadow-xl">
                <span class="material-symbols-outlined text-secondary-container text-7xl mb-6 block" style="font-variation-settings: 'FILL' 1;">format_quote</span>
                <p class="text-black text-xl font-bold leading-relaxed mb-8 italic">"Snap Marketing transformed our facility hygiene with their automated solutions. The scale they operate at is truly impressive."</p>
                <div class="text-primary-container font-black uppercase text-sm tracking-widest border-l-4 border-primary-container pl-4">Operation Manager, Fortis Hospitals</div>
            </div>
            <!-- Card 2 -->
            <div class="bg-white p-12 border-t-8 border-secondary-container industrial-glow transition-all shadow-xl">
                <span class="material-symbols-outlined text-secondary-container text-7xl mb-6 block" style="font-variation-settings: 'FILL' 1;">format_quote</span>
                <p class="text-black text-xl font-bold leading-relaxed mb-8 italic">"The technical support during our cold-chain setup was world-class. Reliable partners for any large-scale industrial project."</p>
                <div class="text-primary-container font-black uppercase text-sm tracking-widest border-l-4 border-primary-container pl-4">Director, Amul Cold Storage</div>
            </div>
            <!-- Card 3 -->
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
        <a href="/request-a-quote" class="inline-block bg-secondary-container text-black px-12 py-6 font-black uppercase text-xl hover:scale-105 transition-transform tracking-widest shadow-[10px_10px_0px_rgba(251,191,36,0.3)]">
            GET A CUSTOM QUOTE NOW
        </a>
    </div>
</section>

<!-- Section 9: Corporate Footer -->
<footer class="bg-black text-gray-400 w-full border-t-4 border-secondary-container">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-12 px-12 py-20 max-w-full">
        <div class="space-y-6">
            <div class="text-3xl font-black text-white italic">Snap Marketing</div>
            <p class="font-medium text-lg leading-relaxed">Defining the standard in industrial B2B equipment distribution since 1999.</p>
            <div class="flex gap-4">
                <a href="#" class="w-10 h-10 bg-primary-container flex items-center justify-center hover:bg-secondary-container hover:text-black transition-colors">
                    <span class="material-symbols-outlined text-sm">link</span>
                </a>
                <a href="#" class="w-10 h-10 bg-primary-container flex items-center justify-center hover:bg-secondary-container hover:text-black transition-colors">
                    <span class="material-symbols-outlined text-sm">link</span>
                </a>
            </div>
        </div>
        <div>
            <h4 class="text-secondary-container font-black uppercase mb-8 tracking-tighter">Corporate Info</h4>
            <ul class="space-y-4">
                <li><a class="hover:text-white transition-colors block font-medium text-lg" href="/about-us">About Us</a></li>
                <li><a class="hover:text-white transition-colors block font-medium text-lg" href="/request-a-quote">Bulk Inquiries</a></li>
                <li><a class="hover:text-white transition-colors block font-medium text-lg" href="/terms-of-service">Terms of Service</a></li>
                <li><a class="hover:text-white transition-colors block font-medium text-lg" href="/privacy-policy">Privacy Policy</a></li>
            </ul>
        </div>
        <div>
            <h4 class="text-secondary-container font-black uppercase mb-8 tracking-tighter">Major Categories</h4>
            <ul class="space-y-4">
                <li><a class="hover:text-white transition-colors block font-medium text-lg" href="/product-category/commercial-refrigeration">Refrigeration</a></li>
                <li><a class="hover:text-white transition-colors block font-medium text-lg" href="/product-category/water-purifiers">Water Treatment</a></li>
                <li><a class="hover:text-white transition-colors block font-medium text-lg" href="/product-category/washroom-automations">Washroom Tech</a></li>
                <li><a class="hover:text-white transition-colors block font-medium text-lg" href="/product-category/hygiene-ppe">Safety Gear</a></li>
            </ul>
        </div>
        <div class="space-y-6">
            <h4 class="text-secondary-container font-black uppercase mb-8 tracking-tighter">Contact Us</h4>
            <div class="flex gap-4 items-start">
                <span class="material-symbols-outlined text-secondary-container">location_on</span>
                <p class="font-medium text-lg">Snap Marketing HQ, Industrial Estate, Pune, Maharashtra 411013</p>
            </div>
            <div class="flex gap-4 items-center">
                <span class="material-symbols-outlined text-secondary-container">call</span>
                <p class="font-medium text-lg">+91 (20) 2445-XXXX</p>
            </div>
            <div class="flex gap-4 items-center">
                <span class="material-symbols-outlined text-secondary-container">mail</span>
                <p class="font-medium text-lg">sales@snapmarketing.in</p>
            </div>
        </div>
    </div>
    <div class="px-12 py-8 bg-zinc-950 flex flex-col md:flex-row justify-between items-center text-sm font-bold uppercase tracking-widest text-gray-500 border-t border-white/5">
        <div>© 2024 Snap Marketing. All Rights Reserved. Pune, India.</div>
        <div class="mt-4 md:mt-0">Precision. Scale. Authority.</div>
    </div>
</footer>

<!-- Agentation Visual Feedback Tool -->
<script type="module">
  import React from 'https://esm.sh/react@18.3.1';
  import { createRoot } from 'https://esm.sh/react-dom@18.3.1/client';
  import { Agentation } from 'https://esm.sh/agentation@latest?deps=react@18.3.1';

  function initAgentation() {
    try {
      const container = document.createElement('div');
      container.id = 'agentation-root';
      document.body.appendChild(container);
      const root = createRoot(container);
      root.render(React.createElement(Agentation));
    } catch (err) {
      console.error('Agentation Failed:', err);
    }
  }

  if (document.readyState === 'complete') {
    initAgentation();
  } else {
    window.addEventListener('load', initAgentation);
  }
</script>

</body></html>