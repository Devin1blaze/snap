<?php
/**
 * WooCommerce Category Template: Optimized Entrance Solutions PLP
 */
defined( 'ABSPATH' ) || exit;

get_header( 'shop' ); ?>

<div class="snap-woo-wrapper">
    <?php do_action('woocommerce_before_main_content'); ?>
    
    <main class="container mx-auto px-8 py-12">
<div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-12">
<!-- Sidebar Filters -->
<aside class="space-y-12">
<div class="bg-white border-r-2 border-[#FBBF24] pr-8 py-4">
<h3 class="text-xs font-black uppercase tracking-[0.2em] mb-8 text-[#0A0A0A]">Category Filters</h3>
<div class="space-y-4">
<label class="flex items-center gap-3 cursor-pointer group">
<input class="w-5 h-5 border-2 border-[#0A0A0A] text-[#FBBF24] focus:ring-[#FBBF24] rounded-none" type="checkbox"/>
<span class="text-xs font-bold uppercase tracking-widest text-[#0A0A0A] group-hover:text-[#1A56DB] transition-colors">Auto Door Sensor</span>
</label>
<label class="flex items-center gap-3 cursor-pointer group">
<input class="w-5 h-5 border-2 border-[#0A0A0A] text-[#FBBF24] focus:ring-[#FBBF24] rounded-none" type="checkbox"/>
<span class="text-xs font-bold uppercase tracking-widest text-[#0A0A0A] group-hover:text-[#1A56DB] transition-colors">Turnstile Gate</span>
</label>
<label class="flex items-center gap-3 cursor-pointer group">
<input class="w-5 h-5 border-2 border-[#0A0A0A] text-[#FBBF24] focus:ring-[#FBBF24] rounded-none" type="checkbox"/>
<span class="text-xs font-bold uppercase tracking-widest text-[#0A0A0A] group-hover:text-[#1A56DB] transition-colors">Foot Pedal Flush</span>
</label>
<label class="flex items-center gap-3 cursor-pointer group">
<input class="w-5 h-5 border-2 border-[#0A0A0A] text-[#FBBF24] focus:ring-[#FBBF24] rounded-none" type="checkbox"/>
<span class="text-xs font-bold uppercase tracking-widest text-[#0A0A0A] group-hover:text-[#1A56DB] transition-colors">Access Control</span>
</label>
<label class="flex items-center gap-3 cursor-pointer group">
<input class="w-5 h-5 border-2 border-[#0A0A0A] text-[#FBBF24] focus:ring-[#FBBF24] rounded-none" type="checkbox"/>
<span class="text-xs font-bold uppercase tracking-widest text-[#0A0A0A] group-hover:text-[#1A56DB] transition-colors">Industrial Foot Pedal</span>
</label>
<label class="flex items-center gap-3 cursor-pointer group">
<input class="w-5 h-5 border-2 border-[#0A0A0A] text-[#FBBF24] focus:ring-[#FBBF24] rounded-none" type="checkbox"/>
<span class="text-xs font-bold uppercase tracking-widest text-[#0A0A0A] group-hover:text-[#1A56DB] transition-colors">Panic Bar</span>
</label>
</div>
<button class="w-full mt-10 bg-[#FBBF24] text-[#0A0A0A] py-3 font-black uppercase tracking-tighter text-sm hover:bg-[#0A0A0A] hover:text-[#FBBF24] transition-all">
                    APPLY FILTERS
                </button>
</div>
<!-- Promo Card -->
<div class="bg-[#0A0A0A] p-6 text-white relative group overflow-hidden">
<div class="relative z-10">
<div class="text-[#FBBF24] mb-4">
<span class="material-symbols-outlined text-4xl">verified_user</span>
</div>
<h4 class="text-xl font-black uppercase tracking-tighter mb-2">SECURITY AUDIT</h4>
<p class="text-xs text-white/70 uppercase tracking-widest leading-relaxed mb-6">Full site vulnerability assessment for high-traffic industrial zones.</p>
<a class="inline-block text-[#FBBF24] font-bold text-[10px] uppercase tracking-[0.2em] border-b border-[#FBBF24] pb-1 hover:text-white hover:border-white transition-colors" href="#">Book Assessment</a>
</div>
<div class="absolute -right-4 -bottom-4 text-[#1A56DB] opacity-20 pointer-events-none group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-[120px]">security</span>
</div>
</div>
</aside>
<!-- Product Grid -->
<section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-1 content-start">
<!-- Product 1 -->
<div class="group bg-white flex flex-col p-6 hover:shadow-[0_20px_50px_rgba(0,0,0,0.1)] transition-all relative">
<div class="h-48 bg-[#1A56DB] flex items-center justify-center mb-6">
<span class="material-symbols-outlined text-white text-6xl" data-icon="sensors">sensors</span>
</div>
<div class="flex-grow">
<div class="text-[10px] font-black tracking-widest text-[#1A56DB] uppercase mb-1">Automation</div>
<h3 class="text-lg font-black uppercase tracking-tighter mb-4">Auto Door Sensor EF-200</h3>
<div class="space-y-1 mb-6">
<div class="text-xs font-bold uppercase tracking-widest text-[#0A0A0A]/60">High-Sensitivity</div>
<div class="text-xs font-bold uppercase tracking-widest text-[#0A0A0A]/60">5m Range</div>
</div>
</div>
<button class="w-full bg-[#FBBF24] text-[#0A0A0A] py-3 font-black uppercase tracking-tighter text-xs hover:bg-[#1A56DB] hover:text-white transition-all">ADD TO QUOTE</button>
</div>
<!-- Product 2 -->
<div class="group bg-white flex flex-col p-6 cursor-pointer transition-all">
<div class="h-48 bg-[#1A56DB] flex items-center justify-center mb-6">
<span class="material-symbols-outlined text-white text-6xl" data-icon="settings_input_component">settings_input_component</span>
</div>
<div class="flex-grow">
<div class="text-[10px] font-black tracking-widest text-[#1A56DB] uppercase mb-1">Heavy Duty</div>
<h3 class="text-lg font-black uppercase tracking-tighter mb-4">Swing Door Operator EF-100</h3>
<div class="space-y-1 mb-6">
<div class="text-xs font-bold uppercase tracking-widest text-[#0A0A0A]/60">Quiet Operation</div>
<div class="text-xs font-bold uppercase tracking-widest text-[#0A0A0A]/60">Heavy-Duty</div>
</div>
</div>
<button class="w-full bg-[#FBBF24] text-[#0A0A0A] py-3 font-black uppercase tracking-tighter text-xs hover:bg-[#1A56DB] hover:text-white transition-all">ADD TO QUOTE</button>
</div>
<!-- Product 3 -->
<div class="group bg-white flex flex-col p-6 cursor-pointer transition-all">
<div class="h-48 bg-[#1A56DB] flex items-center justify-center mb-6">
<span class="material-symbols-outlined text-white text-6xl" data-icon="gate">gate</span>
</div>
<div class="flex-grow">
<div class="text-[10px] font-black tracking-widest text-[#1A56DB] uppercase mb-1">Security</div>
<h3 class="text-lg font-black uppercase tracking-tighter mb-4">Flap Turnstile Gate</h3>
<div class="space-y-1 mb-6">
<div class="text-xs font-bold uppercase tracking-widest text-[#0A0A0A]/60">Stainless Steel 304</div>
<div class="text-xs font-bold uppercase tracking-widest text-[#0A0A0A]/60">RFID Compatible</div>
</div>
</div>
<button class="w-full bg-[#FBBF24] text-[#0A0A0A] py-3 font-black uppercase tracking-tighter text-xs hover:bg-[#1A56DB] hover:text-white transition-all">ADD TO QUOTE</button>
</div>
<!-- FEATURED SPOTLIGHT CARD (Spans full row) -->
<div class="md:col-span-2 xl:col-span-3 bg-[#1A56DB] text-white flex flex-col md:flex-row items-stretch border-l-8 border-[#FBBF24] my-1">
<div class="md:w-1/2 p-12 flex items-center justify-center bg-white/5 relative overflow-hidden group">
<span class="material-symbols-outlined text-[160px] text-white transition-transform duration-700 group-hover:scale-110" data-icon="footprint">footprint</span>
<div class="absolute top-8 left-8 bg-[#FBBF24] text-[#0A0A0A] px-4 py-1 text-xs font-black tracking-widest uppercase">HYGIENE ESSENTIAL</div>
</div>
<div class="md:w-1/2 p-12 flex flex-col justify-between">
<div>
<div class="text-xs font-black tracking-[0.3em] text-[#FBBF24] uppercase mb-2">Featured Spotlight</div>
<h2 class="text-4xl font-black uppercase tracking-tighter mb-6 leading-none">Foot Pedal Sensor Flusher</h2>
<div class="grid grid-cols-2 gap-x-8 gap-y-4 mb-8">
<div>
<div class="text-[10px] font-bold text-white/50 uppercase tracking-widest mb-1">Activation</div>
<p class="text-sm font-bold uppercase tracking-wider">Hygienic No-Touch</p>
</div>
<div>
<div class="text-[10px] font-bold text-white/50 uppercase tracking-widest mb-1">Power Source</div>
<p class="text-sm font-bold uppercase tracking-wider">Battery Powered</p>
</div>
<div>
<div class="text-[10px] font-bold text-white/50 uppercase tracking-widest mb-1">Material</div>
<p class="text-sm font-bold uppercase tracking-wider">Industrial ABS</p>
</div>
<div>
<div class="text-[10px] font-bold text-white/50 uppercase tracking-widest mb-1">Certification</div>
<p class="text-sm font-bold uppercase tracking-wider">Waterproof IPX4</p>
</div>
</div>
</div>
<button class="w-full bg-[#FBBF24] text-[#0A0A0A] py-5 font-black uppercase tracking-tighter text-lg hover:scale-[0.99] transition-all shadow-2xl">ADD TO QUOTE</button>
</div>
</div>
<!-- Product 5 -->
<div class="group bg-white flex flex-col p-6 cursor-pointer transition-all">
<div class="h-48 bg-[#1A56DB] flex items-center justify-center mb-6">
<span class="material-symbols-outlined text-white text-6xl" data-icon="water_lux">water_lux</span>
</div>
<div class="flex-grow">
<div class="text-[10px] font-black tracking-widest text-[#1A56DB] uppercase mb-1">Industrial</div>
<h3 class="text-lg font-black uppercase tracking-tighter mb-4">Industrial Foot Activated Sink</h3>
<div class="space-y-1 mb-6">
<div class="text-xs font-bold uppercase tracking-widest text-[#0A0A0A]/60">Mechanical Pedal</div>
<div class="text-xs font-bold uppercase tracking-widest text-[#0A0A0A]/60">Stainless</div>
</div>
</div>
<button class="w-full bg-[#FBBF24] text-[#0A0A0A] py-3 font-black uppercase tracking-tighter text-xs hover:bg-[#1A56DB] hover:text-white transition-all">ADD TO QUOTE</button>
</div>
<!-- Product 6 -->
<div class="group bg-white flex flex-col p-6 cursor-pointer transition-all">
<div class="h-48 bg-[#1A56DB] flex items-center justify-center mb-6">
<span class="material-symbols-outlined text-white text-6xl" data-icon="keyboard">keyboard</span>
</div>
<div class="flex-grow">
<div class="text-[10px] font-black tracking-widest text-[#1A56DB] uppercase mb-1">Access</div>
<h3 class="text-lg font-black uppercase tracking-tighter mb-4">Access Control Keypad</h3>
<div class="space-y-1 mb-6">
<div class="text-xs font-bold uppercase tracking-widest text-[#0A0A0A]/60">RFID &amp; PIN</div>
<div class="text-xs font-bold uppercase tracking-widest text-[#0A0A0A]/60">IP65 Rated</div>
</div>
</div>
<button class="w-full bg-[#FBBF24] text-[#0A0A0A] py-3 font-black uppercase tracking-tighter text-xs hover:bg-[#1A56DB] hover:text-white transition-all">ADD TO QUOTE</button>
</div>
<!-- Product 7 (Replacement: Touchless Entry Kiosk) -->
<div class="group bg-white flex flex-col p-6 cursor-pointer transition-all">
<div class="h-48 bg-[#1A56DB] flex items-center justify-center mb-6">
<span class="material-symbols-outlined text-white text-6xl" data-icon="co_present">co_present</span>
</div>
<div class="flex-grow">
<div class="text-[10px] font-black tracking-widest text-[#1A56DB] uppercase mb-1">Hygiene</div>
<h3 class="text-lg font-black uppercase tracking-tighter mb-4">Touchless Entry Kiosk</h3>
<div class="space-y-1 mb-6">
<div class="text-xs font-bold uppercase tracking-widest text-[#0A0A0A]/60">Zero-Contact</div>
<div class="text-xs font-bold uppercase tracking-widest text-[#0A0A0A]/60">Health Screening</div>
</div>
</div>
<button class="w-full bg-[#FBBF24] text-[#0A0A0A] py-3 font-black uppercase tracking-tighter text-xs hover:bg-[#1A56DB] hover:text-white transition-all">ADD TO QUOTE</button>
</div>
<!-- Product 8 (Replacement: RFID Time Attendance System) -->
<div class="group bg-white flex flex-col p-6 cursor-pointer transition-all">
<div class="h-48 bg-[#1A56DB] flex items-center justify-center mb-6">
<span class="material-symbols-outlined text-white text-6xl" data-icon="badge">badge</span>
</div>
<div class="flex-grow">
<div class="text-[10px] font-black tracking-widest text-[#1A56DB] uppercase mb-1">Enterprise</div>
<h3 class="text-lg font-black uppercase tracking-tighter mb-4">RFID Time Attendance System</h3>
<div class="space-y-1 mb-6">
<div class="text-xs font-bold uppercase tracking-widest text-[#0A0A0A]/60">Cloud Sync</div>
<div class="text-xs font-bold uppercase tracking-widest text-[#0A0A0A]/60">High-Precision</div>
</div>
</div>
<button class="w-full bg-[#FBBF24] text-[#0A0A0A] py-3 font-black uppercase tracking-tighter text-xs hover:bg-[#1A56DB] hover:text-white transition-all">ADD TO QUOTE</button>
</div>
<!-- Product 9 (Replacement: Euronics Smart Visitor Management) -->
<div class="group bg-white flex flex-col p-6 cursor-pointer transition-all">
<div class="h-48 bg-[#1A56DB] flex items-center justify-center mb-6">
<span class="material-symbols-outlined text-white text-6xl" data-icon="dashboard_customize">dashboard_customize</span>
</div>
<div class="flex-grow">
<div class="text-[10px] font-black tracking-widest text-[#1A56DB] uppercase mb-1">Management</div>
<h3 class="text-lg font-black uppercase tracking-tighter mb-4">Euronics Smart Visitor System</h3>
<div class="space-y-1 mb-6">
<div class="text-xs font-bold uppercase tracking-widest text-[#0A0A0A]/60">AI Integration</div>
<div class="text-xs font-bold uppercase tracking-widest text-[#0A0A0A]/60">Visitor Logging</div>
</div>
</div>
<button class="w-full bg-[#FBBF24] text-[#0A0A0A] py-3 font-black uppercase tracking-tighter text-xs hover:bg-[#1A56DB] hover:text-white transition-all">ADD TO QUOTE</button>
</div>
</section>
</div>
</main>
    
    <?php do_action('woocommerce_after_main_content'); ?>
</div>

<?php get_footer( 'shop' ); ?>
