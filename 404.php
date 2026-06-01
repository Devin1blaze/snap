<?php
get_header(); ?>

<main class="flex-grow flex flex-col items-center justify-center px-6 py-12">
<!-- Massive 404 Centerpiece -->
<div class="relative mb-8 select-none">
<h1 class="text-[12rem] md:text-[22rem] font-[900] leading-none tracking-tighter text-secondary-container relative z-10">
                404
            </h1>
<!-- Blueprint Overlay Pattern inside the text using background clip if supported or absolute positioned mask -->
<div class="absolute inset-0 z-20 blueprint-pattern opacity-30 mix-blend-overlay"></div>
<!-- Absolute Accent Lines -->
<div class="absolute -top-4 -left-4 w-24 h-2 bg-primary-container"></div>
<div class="absolute -bottom-4 -right-4 w-24 h-2 bg-primary-container"></div>
</div>
<!-- Error Message -->
<div class="text-center max-w-2xl mb-12">
<p class="text-2xl md:text-4xl font-bold tracking-tight mb-4 uppercase">
                Oops! This page is out of stock or has been moved.
            </p>
<p class="text-gray-400 text-lg">
                The asset you are looking for is currently unavailable in our digital inventory. Use the portal below to recalibrate your search.
            </p>
</div>
<!-- Prominent Search Section -->
<div class="w-full max-w-3xl mb-16">
<div class="relative flex items-center bg-white">
<div class="pl-6 flex items-center justify-center">
<span class="material-symbols-outlined text-secondary-container text-3xl" data-icon="search">search</span>
</div>
<input class="w-full bg-transparent border-none focus:ring-0 text-black font-bold py-6 px-4 placeholder:text-gray-400 uppercase tracking-widest" placeholder="SEARCH SYSTEM INVENTORY..." type="text"/>
<button class="bg-primary-container text-white h-full px-10 font-bold uppercase tracking-tighter hover:bg-blue-800 transition-colors">
                    Execute
                </button>
</div>
</div>
<!-- Quick Links Bento-ish Layout -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full max-w-6xl px-4">
<!-- Card 1 -->
<a class="group block bg-[#161616] p-8 border-l-4 border-secondary-container hover:bg-secondary-container transition-all duration-300" href="#">
<div class="mb-6">
<span class="material-symbols-outlined text-5xl text-secondary-container group-hover:text-black" data-icon="sensor_occupied">sensor_occupied</span>
</div>
<h3 class="text-xl font-black uppercase tracking-tight group-hover:text-black">Browse Washroom Automation</h3>
<p class="mt-2 text-gray-500 text-sm uppercase tracking-widest group-hover:text-black/70">Sensors &amp; Flushers</p>
</a>
<!-- Card 2 -->
<a class="group block bg-[#161616] p-8 border-l-4 border-primary-container hover:bg-primary-container transition-all duration-300" href="#">
<div class="mb-6">
<span class="material-symbols-outlined text-5xl text-primary-container group-hover:text-white" data-icon="kitchen">kitchen</span>
</div>
<h3 class="text-xl font-black uppercase tracking-tight group-hover:text-white">View Commercial Refrigeration</h3>
<p class="mt-2 text-gray-500 text-sm uppercase tracking-widest group-hover:text-white/70">Industrial Cooling</p>
</a>
<!-- Card 3 -->
<a class="group block bg-[#161616] p-8 border-l-4 border-secondary-container hover:bg-secondary-container transition-all duration-300" href="#">
<div class="mb-6">
<span class="material-symbols-outlined text-5xl text-secondary-container group-hover:text-black" data-icon="description">description</span>
</div>
<h3 class="text-xl font-black uppercase tracking-tight group-hover:text-black">Get a Bulk Quote</h3>
<p class="mt-2 text-gray-500 text-sm uppercase tracking-widest group-hover:text-black/70">Wholesale Logistics</p>
</a>
</div>
</main>

<?php get_footer(); ?>
