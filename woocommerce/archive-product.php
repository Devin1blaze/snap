<?php
/**
 * The Template for displaying product archives / single products
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' ); ?>

<div class="snap-woo-wrapper">
<?php do_action('woocommerce_before_main_content'); ?>
<main class="max-w-7xl mx-auto px-8 py-16 grid grid-cols-1 lg:grid-cols-12 gap-12">
<!-- Sidebar Filters -->
<aside class="lg:col-span-3 space-y-10 order-1">
<div>
<div class="flex justify-between items-end mb-6 border-b-4 border-[#0A0A0A] pb-2">
<h3 class="text-black font-black uppercase tracking-tighter text-xl">Filters</h3>
<a class="text-[#FBBF24] text-[10px] font-black uppercase tracking-widest hover:underline" href="#">Clear All Filters</a>
</div>
<!-- Brand Filter -->
<div class="mb-8">
<p class="text-[10px] font-black uppercase tracking-widest text-black/40 mb-4">Manufacturer</p>
<div class="space-y-3">
<label class="flex items-center group cursor-pointer text-[#FBBF24]">
<input checked="" class="w-5 h-5 border-2 border-[#FBBF24] bg-[#FBBF24] rounded-none text-[#0A0A0A] focus:ring-0 focus:ring-offset-0" type="checkbox"/>
<span class="ml-3 font-bold text-sm uppercase transition-colors">Euronics</span>
</label>
<label class="flex items-center group cursor-pointer">
<input class="w-5 h-5 border-2 border-black rounded-none text-[#FBBF24] focus:ring-0 focus:ring-offset-0" type="checkbox"/>
<span class="ml-3 font-bold text-sm uppercase group-hover:text-[#1A56DB] transition-colors">Sloan</span>
</label>
<label class="flex items-center group cursor-pointer">
<input class="w-5 h-5 border-2 border-black rounded-none text-[#FBBF24] focus:ring-0 focus:ring-offset-0" type="checkbox"/>
<span class="ml-3 font-bold text-sm uppercase group-hover:text-[#1A56DB] transition-colors">Roca</span>
</label>
</div>
</div>
<!-- Product Type Filter -->
<div class="mb-8">
<p class="text-[10px] font-black uppercase tracking-widest text-black/40 mb-4">Device Category</p>
<div class="space-y-3">
<label class="flex items-center group cursor-pointer">
<input class="w-5 h-5 border-2 border-black rounded-none text-[#FBBF24] focus:ring-0 focus:ring-offset-0" type="checkbox"/>
<span class="ml-3 font-bold text-sm uppercase">Sensor Flusher</span>
</label>
<label class="flex items-center group cursor-pointer">
<input class="w-5 h-5 border-2 border-black rounded-none text-[#FBBF24] focus:ring-0 focus:ring-offset-0" type="checkbox"/>
<span class="ml-3 font-bold text-sm uppercase">Auto Tap</span>
</label>
<label class="flex items-center group cursor-pointer">
<input class="w-5 h-5 border-2 border-black rounded-none text-[#FBBF24] focus:ring-0 focus:ring-offset-0" type="checkbox"/>
<span class="ml-3 font-bold text-sm uppercase">Hand Dryer</span>
</label>
<label class="flex items-center group cursor-pointer">
<input class="w-5 h-5 border-2 border-black rounded-none text-[#FBBF24] focus:ring-0 focus:ring-offset-0" type="checkbox"/>
<span class="ml-3 font-bold text-sm uppercase">Soap Dispenser</span>
</label>
</div>
</div>
<!-- Price Range -->
<div class="mb-8">
<p class="text-[10px] font-black uppercase tracking-widest text-black/40 mb-4">Budget Profile (Wholesale)</p>
<input class="w-full accent-[#FBBF24] h-2 bg-[#0A0A0A] appearance-none cursor-pointer" type="range"/>
<div class="flex justify-between mt-2 font-bold text-xs uppercase">
<span>$50</span>
<span>$2500+</span>
</div>
</div>
</div>
<!-- Blue CTA Card -->
<div class="bg-[#1A56DB] p-8 border-l-8 border-[#FBBF24]">
<p class="text-white font-black text-2xl uppercase tracking-tighter leading-none mb-6">Need a custom quote?</p>
<button class="w-full bg-[#FBBF24] text-[#0A0A0A] font-black py-4 uppercase text-xs tracking-widest hover:bg-white transition-all">Get Bulk Price</button>
</div>
</aside>
<!-- Right Main Grid -->
<section class="lg:col-span-9 order-2">
<!-- Grid Header -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
<p class="font-bold text-sm uppercase tracking-widest text-black/60">Showing 1–9 of 45 results</p>
<div class="flex items-center gap-4 bg-surface-container-low px-4 py-2">
<span class="text-[10px] font-black uppercase tracking-widest">Sort By:</span>
<select class="bg-transparent border-none font-bold text-xs uppercase focus:ring-0 cursor-pointer">
<option>Performance (High to Low)</option>
<option>Brand Authority</option>
<option>Price Ascending</option>
</select>
</div>
</div>
<!-- Featured Product Card -->
<article class="bg-white border-2 border-[#FBBF24] mb-12 flex flex-col md:flex-row relative overflow-hidden group">
<span class="absolute top-0 right-0 bg-[#FBBF24] text-[#0A0A0A] text-[10px] font-black px-6 py-2 uppercase tracking-[0.2em] transform rotate-0 z-20">Most Popular</span>
<div class="md:w-2/5 bg-surface-container-low p-10 flex items-center justify-center">
<img alt="Sensor Flusher" class="w-full h-auto object-contain mix-blend-multiply transition-transform duration-500 group-hover:scale-110" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAfujNQ5bAZunuYBgWMujmT1WCyH5vprplbJ8vCe6olYIO8ELzZLC24COAbtgaEkTJjTqSro6-M4M1diY6OsYJ41LwsgqInjDkOipc0WmVFA2LSIBZPHQ80fR5sF1HMtrSRFuSDY1jD7OO9uMeg64Ey3GyVEhOdiBrHZVJHE6s_2HSe_hLv_O_QMf56UGzR3KmQGE4IaSmovl80iwhIj19nuTyUntGBxaSCf3w7LcmcYQGZg5XnAVdfSoUhhYU15wrU_DigXBUE_ts"/>
</div>
<div class="md:w-3/5 p-8 flex flex-col md:flex-row gap-8 items-center">
<div class="flex-grow space-y-4">
<div>
<span class="text-[#1A56DB] text-[10px] font-black tracking-widest uppercase">EURONICS</span>
<h2 class="text-[#0A0A0A] font-black text-3xl uppercase tracking-tighter mt-1">Sensor Flusher EF-100</h2>
</div>
<table class="w-full text-left text-[11px] uppercase tracking-wider font-bold">
<tbody><tr class="border-b border-black/10">
<td class="py-2 text-black/40">Material</td>
<td class="py-2">304 Grade Stainless Steel</td>
</tr>
<tr class="border-b border-black/10">
<td class="py-2 text-black/40">Mechanism</td>
<td class="py-2">Infrared Sensor Driven</td>
</tr>
<tr class="border-b border-black/10">
<td class="py-2 text-black/40">Warranty</td>
<td class="py-2">5 Year Performance</td>
</tr>
</tbody></table>
</div>
<div class="w-full md:w-auto">
<button class="w-full md:w-48 bg-[#FBBF24] text-[#0A0A0A] font-black py-6 uppercase text-sm tracking-widest shadow-lg hover:shadow-xl transition-all active:scale-95">Add to Quote</button>
</div>
</div>
</article>
<!-- Product Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
<!-- Card 2 (Row 1) -->
<article class="product-card bg-white border border-outline-variant/30 flex flex-col hover:shadow-2xl transition-all duration-300 relative group">
<div class="aspect-square bg-surface-container-low relative p-8 overflow-hidden">
<img alt="Auto Tap" class="w-full h-full object-contain mix-blend-multiply" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBgZvVI8Kik23HfJKWmDpHAXlBFIesXy3sSas3H266XuKcVsdwFQAMod61Ac7_d4C94T3yDO18WRfd-4i-AYXthAyedlf4WIODnCNcONQjSqcmyjLIHsVEr8vP-W0BkL07Qsj-6IBOTQ4561GhFSl7HlVv-oy5nElKpjZdtNZcFSq78NwvjefxPoPR6lGZSaCr3CHfGUEostwUB6ShL6NhBvY3axSXjXKNLjOWdGp_0DSnFHmwFymC07zoCWurmd6g_tgKgmEKrAk4"/>
<span class="absolute top-4 left-4 bg-[#1A56DB] text-white text-[10px] font-black px-3 py-1 uppercase tracking-widest">EURONICS</span>
<span class="absolute top-4 right-4 bg-[#FBBF24] text-[#0A0A0A] text-[10px] font-black px-3 py-1 uppercase tracking-widest">NEW</span>
<!-- Hover Overlay -->
<div class="quick-view-overlay absolute inset-0 bg-[#0A0A0A]/80 opacity-0 flex flex-col items-center justify-center transition-opacity duration-300 z-10">
<button class="bg-white text-black font-black px-6 py-2 uppercase text-xs tracking-widest mb-4">Quick Specs</button>
<a class="text-[#FBBF24] font-black text-[10px] uppercase tracking-[0.2em] hover:underline" href="#">Full Details</a>
</div>
</div>
<div class="p-6 flex flex-col flex-grow">
<h2 class="text-[#0A0A0A] font-black text-xl uppercase tracking-tighter mb-2">Auto Tap AT-200</h2>
<div class="flex flex-wrap gap-2 mb-6">
<span class="bg-primary/5 text-[#1A56DB] text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest">Water Saving</span>
<span class="bg-primary/5 text-[#1A56DB] text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest">Lead Free</span>
</div>
<div class="mt-auto">
<button class="w-full bg-[#FBBF24] text-[#0A0A0A] font-black py-3 uppercase text-xs tracking-widest transition-transform active:scale-95">Add to Quote</button>
</div>
</div>
</article>
<!-- Card 3 (Row 1) -->
<article class="product-card bg-white border border-outline-variant/30 flex flex-col hover:shadow-2xl transition-all duration-300 relative group">
<div class="aspect-square bg-surface-container-low relative p-8 overflow-hidden">
<img alt="SS Grab Bar" class="w-full h-full object-contain mix-blend-multiply" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAfpwUpBu6k5zqhS1lD3oplmFNz8h3uvSbguALYaDfxU7h1IGWYuticRoz_dwUeH-fg7tHcdXkn8Sje2LDELXCPzav6N0zdEx0QAHuTkyzEQ6nkebJfgh3_uoRv6PfdP6gG_6twM92Q2CbJiv03XUAKPCGdeJe0LgsSugspR06y9x649YYF-HyhjRr5aqYW1jCieSSIYMiytOskGaeJODPfkkGcsgK1U1pp38NCoX5tPbkFESwLwXbAAywGykZZ5syYnJAqVMmT7ME"/>
<span class="absolute top-4 left-4 bg-[#1A56DB] text-white text-[10px] font-black px-3 py-1 uppercase tracking-widest">ROCA</span>
<span class="absolute top-4 right-4 bg-[#FBBF24] text-[#0A0A0A] text-[10px] font-black px-3 py-1 uppercase tracking-widest">HOT</span>
<div class="quick-view-overlay absolute inset-0 bg-[#0A0A0A]/80 opacity-0 flex flex-col items-center justify-center transition-opacity duration-300 z-10">
<button class="bg-white text-black font-black px-6 py-2 uppercase text-xs tracking-widest mb-4">Quick Specs</button>
</div>
</div>
<div class="p-6 flex flex-col flex-grow">
<h2 class="text-[#0A0A0A] font-black text-xl uppercase tracking-tighter mb-2">SS Grab Bar Heavy</h2>
<div class="flex flex-wrap gap-2 mb-6">
<span class="bg-primary/5 text-[#1A56DB] text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest">Load Tested</span>
<span class="bg-primary/5 text-[#1A56DB] text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest">Anti-Slip</span>
</div>
<div class="mt-auto">
<button class="w-full bg-[#FBBF24] text-[#0A0A0A] font-black py-3 uppercase text-xs tracking-widest transition-transform active:scale-95">Add to Quote</button>
</div>
</div>
</article>
<!-- Card 4 (Row 2 - Large) -->
<article class="product-card bg-white border border-outline-variant/30 flex flex-col hover:shadow-2xl transition-all duration-300 relative group">
<div class="aspect-square bg-surface-container-low relative p-2 overflow-hidden">
<img alt="Hand Dryer" class="w-full h-full object-contain mix-blend-multiply scale-110" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDDnOZdSGXpPzznznxxJVckoktrG1IWpa5S1kwwlptm2_pHkmAYfuAzBSwA3XbRps6FuuywotF0S1cpCeXbvKAfB49q0CjAfXwY1dneM5SFcRl8_aK2432B6jYi4lRnmcjtXYZ7gw20kppe-oLVoVH0S3_UehuS1ITR50LV-P6CYun3Nu6Ii06qArawB8sv41o1IyniDQWElZD0sGKg3oI4XNUUXzqiQGiIRWbYqBnyYt3HMI7bd-1X43TiXOQOXI0pAjQxNg2BITg"/>
<span class="absolute top-4 left-4 bg-[#1A56DB] text-white text-[10px] font-black px-3 py-1 uppercase tracking-widest">JD PANEL</span>
<div class="quick-view-overlay absolute inset-0 bg-[#0A0A0A]/80 opacity-0 flex flex-col items-center justify-center transition-opacity duration-300 z-10">
<button class="bg-white text-black font-black px-6 py-2 uppercase text-xs tracking-widest mb-4">Quick Specs</button>
</div>
</div>
<div class="p-6 flex flex-col flex-grow">
<h2 class="text-[#0A0A0A] font-black text-xl uppercase tracking-tighter mb-2">JD Panel Hand Dryer</h2>
<div class="flex flex-wrap gap-2 mb-6">
<span class="bg-primary/5 text-[#1A56DB] text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest">High Speed</span>
<span class="bg-primary/5 text-[#1A56DB] text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest">HEPA Filter</span>
</div>
<div class="mt-auto">
<button class="w-full bg-[#FBBF24] text-[#0A0A0A] font-black py-5 uppercase text-sm tracking-[0.2em] transition-transform active:scale-95">Add to Quote</button>
</div>
</div>
</article>
<!-- Card 5 (Row 2 - Large) -->
<article class="product-card bg-white border border-outline-variant/30 flex flex-col hover:shadow-2xl transition-all duration-300 relative group">
<div class="aspect-square bg-surface-container-low relative p-2 overflow-hidden">
<img alt="Soap Dispenser" class="w-full h-full object-contain mix-blend-multiply scale-110" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD5Ss8kqTuYPH1UJqC4cCnly6F2nrKrA58Y3nPD3aXDHWPuiQx_n7NcjrSP-4RPce9u2Yn-MqAlfovs1p6km6OiyUEoT2VbKB7vtLMjFz5LN8Fqbmbx_UVhDhnH00inATP8F4hPrLEfNVX2UzTnGu0jy1Htbl5WQ9Uz-L6L4f38GLpXMOiQ43BNRuqMeRlCHmZ0towtfff2TAcFULm_wmNfHzEGiwl8JClpBj-9vyRNfn-6U9digyHLcPB60M1pcGIHy6OvgDD39kY"/>
<span class="absolute top-4 left-4 bg-[#1A56DB] text-white text-[10px] font-black px-3 py-1 uppercase tracking-widest">SLOAN</span>
<div class="quick-view-overlay absolute inset-0 bg-[#0A0A0A]/80 opacity-0 flex flex-col items-center justify-center transition-opacity duration-300 z-10">
<button class="bg-white text-black font-black px-6 py-2 uppercase text-xs tracking-widest mb-4">Quick Specs</button>
</div>
</div>
<div class="p-6 flex flex-col flex-grow">
<h2 class="text-[#0A0A0A] font-black text-xl uppercase tracking-tighter mb-2">Foam Soap Dispenser</h2>
<div class="flex flex-wrap gap-2 mb-6">
<span class="bg-primary/5 text-[#1A56DB] text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest">Touchless</span>
<span class="bg-primary/5 text-[#1A56DB] text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest">Easy Refill</span>
</div>
<div class="mt-auto">
<button class="w-full bg-[#FBBF24] text-[#0A0A0A] font-black py-5 uppercase text-sm tracking-[0.2em] transition-transform active:scale-95">Add to Quote</button>
</div>
</div>
</article>
<!-- Card 6 (Row 2 - Large) -->
<article class="product-card bg-white border border-outline-variant/30 flex flex-col hover:shadow-2xl transition-all duration-300 relative group">
<div class="aspect-square bg-surface-container-low relative p-2 overflow-hidden">
<img alt="Urinal Screen" class="w-full h-full object-contain mix-blend-multiply scale-110" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB9hzpJVyaY_DHR61i_xygCdV07Vn7dpiyC07BxSuTcbDNG4xL41p-VXhqaSYm1fuuCsMPKo3xNN2nUc3I_yvdTRHHgeC_MHhIf38sf36ojno-3viFwr_P6srd1VISXrS1sfj5LE_aO8Ci12fuif1OkW1ei5lvOkE5i8uoCH1Kh2kZHYRQKEaN-pyPf5u_sbJJ4rz9PjLvivl0eq9lfZP6PeeXIekkciZ29HpmfMNtcpVnbuOIqDESJq5G80mAAmHlGyAn-G5HBgLA"/>
<span class="absolute top-4 left-4 bg-[#1A56DB] text-white text-[10px] font-black px-3 py-1 uppercase tracking-widest">SNAP BIOTECH</span>
<div class="quick-view-overlay absolute inset-0 bg-[#0A0A0A]/80 opacity-0 flex flex-col items-center justify-center transition-opacity duration-300 z-10">
<button class="bg-white text-black font-black px-6 py-2 uppercase text-xs tracking-widest mb-4">Quick Specs</button>
</div>
</div>
<div class="p-6 flex flex-col flex-grow">
<h2 class="text-[#0A0A0A] font-black text-xl uppercase tracking-tighter mb-2">Bio-Tab Urinal Screen</h2>
<div class="flex flex-wrap gap-2 mb-6">
<span class="bg-primary/5 text-[#1A56DB] text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest">Enzymatic</span>
<span class="bg-primary/5 text-[#1A56DB] text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest">30 Days</span>
</div>
<div class="mt-auto">
<button class="w-full bg-[#FBBF24] text-[#0A0A0A] font-black py-5 uppercase text-sm tracking-[0.2em] transition-transform active:scale-95">Add to Quote</button>
</div>
</div>
</article>
<!-- Additional Cards (Maintained Consistency) -->
<article class="product-card bg-white border border-outline-variant/30 flex flex-col hover:shadow-2xl transition-all duration-300 relative group">
<div class="aspect-square bg-surface-container-low relative p-8 overflow-hidden">
<img alt="Sensor Door" class="w-full h-full object-contain mix-blend-multiply" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA5cbQwEPrzlAFhAaZavkDEkomt4EOz_xb4gVLEevozA7cFZmXSW_mtzo_fouRQHFeyAEtFMlVmsZWlfnMrk8PsaqOhcniiDfOQqkB0IMbn34tYb_yMNP6KPmm7K2tR66O8dhgBXW7_beUtyz93ATc_KC1hg7nLbgHH3t5a9up1b102PPUIG2P5-L6n0BZ44Z8U5eJBUnbCEZJQyIhphE1kNzOGGqAscYQemmUWTe5GKiGZExm_9pRb99elA-ooemoTrCCnilLo_Dk"/>
<span class="absolute top-4 left-4 bg-[#1A56DB] text-white text-[10px] font-black px-3 py-1 uppercase tracking-widest">EURONICS</span>
<div class="quick-view-overlay absolute inset-0 bg-[#0A0A0A]/80 opacity-0 flex flex-col items-center justify-center transition-opacity duration-300 z-10">
<button class="bg-white text-black font-black px-6 py-2 uppercase text-xs tracking-widest">Quick View</button>
</div>
</div>
<div class="p-6 flex flex-col flex-grow">
<h2 class="text-[#0A0A0A] font-black text-xl uppercase tracking-tighter mb-2">Sensor Controlled Door</h2>
<div class="flex flex-wrap gap-2 mb-6">
<span class="bg-primary/5 text-[#1A56DB] text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest">Heavy Duty</span>
</div>
<div class="mt-auto">
<button class="w-full bg-[#FBBF24] text-[#0A0A0A] font-black py-3 uppercase text-xs tracking-widest transition-transform active:scale-95">Add to Quote</button>
</div>
</div>
</article>
<article class="product-card bg-white border border-outline-variant/30 flex flex-col hover:shadow-2xl transition-all duration-300 relative group">
<div class="aspect-square bg-surface-container-low relative p-8 overflow-hidden">
<img alt="Foot Pedal" class="w-full h-full object-contain mix-blend-multiply" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA_di0QdZ3NJ9T_GfWJYARxEEnsgiYOdbXymVpwO_jUABzD1s-9ADl3rfXMgZwDTet75ovx8RPkpH2HNsUKfSCEahujLmgKG8TE3AOh8ku1GA6hvaCHaCX-KrKmgWVYrLoCc0bDliVjMlUZFxYXGTT64nDcS_6SFbUvZ4tv8GtawMextiIYwj_leZKH4vN43VF7NQ_UqDgkGm92w1q7UDOZHNwbb7KwkwzvBqKZRw85-EtHfObN_Xjrrf1lsDZwn36wRq2iTBk3faI"/>
<span class="absolute top-4 left-4 bg-[#1A56DB] text-white text-[10px] font-black px-3 py-1 uppercase tracking-widest">ROCA</span>
<div class="quick-view-overlay absolute inset-0 bg-[#0A0A0A]/80 opacity-0 flex flex-col items-center justify-center transition-opacity duration-300 z-10">
<button class="bg-white text-black font-black px-6 py-2 uppercase text-xs tracking-widest">Quick View</button>
</div>
</div>
<div class="p-6 flex flex-col flex-grow">
<h2 class="text-[#0A0A0A] font-black text-xl uppercase tracking-tighter mb-2">Foot Pedal Flush System</h2>
<div class="flex flex-wrap gap-2 mb-6">
<span class="bg-primary/5 text-[#1A56DB] text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest">Zero Contact</span>
</div>
<div class="mt-auto">
<button class="w-full bg-[#FBBF24] text-[#0A0A0A] font-black py-3 uppercase text-xs tracking-widest transition-transform active:scale-95">Add to Quote</button>
</div>
</div>
</article>
<article class="product-card bg-white border border-outline-variant/30 flex flex-col hover:shadow-2xl transition-all duration-300 relative group">
<div class="aspect-square bg-surface-container-low relative p-8 overflow-hidden">
<img alt="Washroom Panel" class="w-full h-full object-contain mix-blend-multiply" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDexylhNQyeZhX-gQkmgmgdeKfYIp-YmlzUdCJ8NI5fGvwS5VVrLz9tLTAkLXC6LcXJdhUEmcH3D2KpYdBUEjyvZZITeorRA-1VWCyDfBAq0p3zSuDeiv8auK1S0DHsFH2BCJcWKpbgNQDRTfDRYEXWM4gIhfxIixbai0xmxxwfTsyLGxIQCK0LvNpxodTDmwi0XxWOUlocC9EXLWJbSPMinohrbbdd7WEf41Fnw1wRx5Lfdbtk-AxiQPq_qnXDPQaKot7bhCtl7eg"/>
<span class="absolute top-4 left-4 bg-[#1A56DB] text-white text-[10px] font-black px-3 py-1 uppercase tracking-widest">JD PANEL</span>
<div class="quick-view-overlay absolute inset-0 bg-[#0A0A0A]/80 opacity-0 flex flex-col items-center justify-center transition-opacity duration-300 z-10">
<button class="bg-white text-black font-black px-6 py-2 uppercase text-xs tracking-widest">Quick View</button>
</div>
</div>
<div class="p-6 flex flex-col flex-grow">
<h2 class="text-[#0A0A0A] font-black text-xl uppercase tracking-tighter mb-2">Washroom Integration Panel</h2>
<div class="flex flex-wrap gap-2 mb-6">
<span class="bg-primary/5 text-[#1A56DB] text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest">All-in-one</span>
</div>
<div class="mt-auto">
<button class="w-full bg-[#FBBF24] text-[#0A0A0A] font-black py-3 uppercase text-xs tracking-widest transition-transform active:scale-95">Add to Quote</button>
</div>
</div>
</article>
</div>
<!-- Pagination Bar -->
<div class="mt-20 bg-[#1A56DB] flex justify-between items-center px-8 py-4">
<button class="flex items-center text-white font-black uppercase text-xs tracking-widest hover:text-[#FBBF24]">
<span class="material-symbols-outlined mr-2">arrow_back</span> Previous
                </button>
<div class="flex gap-4">
<span class="text-[#FBBF24] font-black text-sm">01</span>
<span class="text-white/40 font-black text-sm hover:text-white cursor-pointer">02</span>
<span class="text-white/40 font-black text-sm hover:text-white cursor-pointer">03</span>
<span class="text-white/40 font-black text-sm">...</span>
<span class="text-white/40 font-black text-sm hover:text-white cursor-pointer">05</span>
</div>
<button class="flex items-center text-white font-black uppercase text-xs tracking-widest hover:text-[#FBBF24]">
                    Next <span class="material-symbols-outlined ml-2">arrow_forward</span>
</button>
</div>
</section>
</main>

<?php do_action('woocommerce_after_main_content'); ?>
</div>

<?php get_footer( 'shop' ); ?>
