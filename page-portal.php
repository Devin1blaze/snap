<?php
/**
 * Template Name: B2B Client Portal Dashboard
 */

get_header(); ?>

<main class="ml-64 pt-24 pb-12 px-10">
<!-- Header Section -->
<section class="mb-12">
<div class="flex justify-between items-end">
<div>
<h2 class="text-4xl font-black tracking-tight text-on-surface mb-2">Welcome Back, Global Logistics Corp</h2>
<p class="text-on-surface-variant font-medium flex items-center">
<span class="material-symbols-outlined text-primary mr-2" data-icon="analytics">analytics</span>
                        Enterprise Fleet &amp; Infrastructure Management
                    </p>
</div>
<div class="bg-on-primary-fixed p-6 text-white min-w-[280px]">
<p class="text-[10px] font-bold uppercase tracking-widest text-primary-fixed-dim mb-1">Assets Under Management</p>
<p class="text-3xl font-black tabular-nums">$2,482,900.00</p>
<div class="mt-2 flex items-center text-xs text-green-400">
<span class="material-symbols-outlined text-sm mr-1" data-icon="trending_up">trending_up</span>
                        +12.4% from last quarter
                    </div>
</div>
</div>
</section>
<!-- Recent Bulk Quotes Row -->
<section class="mb-12">
<div class="flex items-center justify-between mb-6">
<h3 class="text-lg font-bold uppercase tracking-widest flex items-center">
<span class="h-6 w-1 bg-primary mr-3"></span>
                    Recent Bulk Quotes
                </h3>
<button class="text-sm font-bold text-primary hover:underline">View All Quotes</button>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
<!-- Quote Card 1 -->
<div class="bg-white p-6 border-b-4 border-tertiary-fixed-dim hard-shadow transition-transform hover:-translate-y-1">
<div class="flex justify-between items-start mb-4">
<span class="text-[10px] font-black text-on-surface-variant uppercase">QT-8829-X</span>
<span class="bg-tertiary-fixed-dim text-on-tertiary-fixed px-3 py-1 text-[10px] font-bold uppercase">Pending</span>
</div>
<h4 class="text-xl font-bold mb-1">Sanitary Automation Hub</h4>
<p class="text-xs text-on-surface-variant mb-6">Submitted: Oct 12, 2023</p>
<div class="flex items-center justify-between text-sm">
<span class="text-on-surface-variant">142 Items</span>
<span class="font-black text-primary">$42,300</span>
</div>
</div>
<!-- Quote Card 2 -->
<div class="bg-white p-6 border-b-4 border-primary hard-shadow transition-transform hover:-translate-y-1">
<div class="flex justify-between items-start mb-4">
<span class="text-[10px] font-black text-on-surface-variant uppercase">QT-8750-B</span>
<span class="bg-primary text-white px-3 py-1 text-[10px] font-bold uppercase">Approved</span>
</div>
<h4 class="text-xl font-bold mb-1">Logistics Bay Lighting</h4>
<p class="text-xs text-on-surface-variant mb-6">Submitted: Oct 08, 2023</p>
<div class="flex items-center justify-between text-sm">
<span class="text-on-surface-variant">88 Items</span>
<span class="font-black text-primary">$18,900</span>
</div>
</div>
<!-- Quote Card 3 -->
<div class="bg-white p-6 border-b-4 border-black hard-shadow cursor-pointer transition-transform">
<div class="flex justify-between items-start mb-4">
<span class="text-[10px] font-black text-on-surface-variant uppercase">QT-8612-A</span>
<span class="bg-on-surface text-white px-3 py-1 text-[10px] font-bold uppercase">Shipped</span>
</div>
<h4 class="text-xl font-bold mb-1">HVAC Control Units</h4>
<p class="text-xs text-on-surface-variant mb-6">Submitted: Sep 29, 2023</p>
<div class="flex items-center justify-between text-sm">
<span class="text-on-surface-variant">12 Items</span>
<span class="font-black text-primary">$114,200</span>
</div>
</div>
</div>
</section>
<!-- AMC Renewals & Stats -->
<section class="grid grid-cols-1 lg:grid-cols-3 gap-8">
<!-- AMC Renewals Widget (Authority: Blueprint Design) -->
<div class="lg:col-span-2 bg-white hard-shadow">
<div class="bg-on-surface text-white px-8 py-5 flex justify-between items-center">
<h3 class="text-sm font-bold uppercase tracking-[0.2em]">Upcoming Maintenance Renewals</h3>
<span class="material-symbols-outlined text-tertiary-fixed-dim" data-icon="notification_important">notification_important</span>
</div>
<div class="p-8">
<div class="space-y-6">
<!-- Item 1 -->
<div class="flex items-center justify-between group">
<div class="flex items-center space-x-6">
<div class="w-16 h-16 bg-surface-container-low flex items-center justify-center border border-transparent group-hover:border-primary-fixed transition-colors">
<span class="material-symbols-outlined text-primary text-3xl" data-icon="sensors">sensors</span>
</div>
<div>
<h4 class="font-bold text-lg text-on-surface">Euronics Sensor Flushers</h4>
<p class="text-xs text-on-surface-variant">Contract ID: #AMC-992-B • Sector: Washroom Facilities</p>
</div>
</div>
<div class="text-right flex items-center space-x-8">
<div class="text-right">
<p class="text-[10px] font-black uppercase text-error mb-1 tracking-widest">Expires In</p>
<p class="text-xl font-black text-on-surface">14 Days</p>
</div>
<button class="bg-tertiary-fixed-dim text-on-tertiary-fixed px-6 py-3 font-bold text-xs uppercase hover:bg-yellow-500 transition-colors">Renew Now</button>
</div>
</div>
<!-- Divider -->
<div class="h-[1px] bg-slate-100"></div>
<!-- Item 2 -->
<div class="flex items-center justify-between group">
<div class="flex items-center space-x-6">
<div class="w-16 h-16 bg-surface-container-low flex items-center justify-center border border-transparent group-hover:border-primary-fixed transition-colors">
<span class="material-symbols-outlined text-primary text-3xl" data-icon="sanitizer">sanitizer</span>
</div>
<div>
<h4 class="font-bold text-lg text-on-surface">KC Professional Dispensers</h4>
<p class="text-xs text-on-surface-variant">Contract ID: #AMC-104-Z • Sector: Industrial Hygiene</p>
</div>
</div>
<div class="text-right flex items-center space-x-8">
<div class="text-right">
<p class="text-[10px] font-black uppercase text-on-surface-variant mb-1 tracking-widest">Expires In</p>
<p class="text-xl font-black text-on-surface">42 Days</p>
</div>
<button class="bg-tertiary-fixed-dim text-on-tertiary-fixed px-6 py-3 font-bold text-xs uppercase hover:bg-yellow-500 transition-colors">Renew Now</button>
</div>
</div>
</div>
</div>
</div>
<!-- Side Metric Column -->
<div class="space-y-6">
<div class="bg-surface-container-highest p-8">
<h4 class="text-[10px] font-black uppercase tracking-widest text-on-surface-variant mb-6">Inventory Health</h4>
<div class="space-y-4">
<div class="flex justify-between items-center">
<span class="text-sm font-medium">Operational</span>
<span class="text-sm font-bold">98.2%</span>
</div>
<div class="w-full bg-white h-2">
<div class="bg-primary h-full w-[98%]"></div>
</div>
<div class="flex justify-between items-center pt-4">
<span class="text-sm font-medium">Maintenance Required</span>
<span class="text-sm font-bold text-error">12 Units</span>
</div>
<div class="w-full bg-white h-2">
<div class="bg-error h-full w-[12%]"></div>
</div>
</div>
</div>
<div class="bg-primary p-8 text-white relative overflow-hidden">
<div class="relative z-10">
<h4 class="text-[10px] font-bold uppercase tracking-widest text-primary-fixed mb-4">Support Direct Line</h4>
<p class="text-xl font-bold mb-6">Need bulk logistics assistance?</p>
<button class="w-full bg-white text-primary py-3 font-bold text-xs uppercase tracking-widest">Connect with Advisor</button>
</div>
<!-- Abstract Machined Pattern -->
<div class="absolute -right-4 -bottom-4 opacity-10">
<span class="material-symbols-outlined text-9xl" data-icon="precision_manufacturing">precision_manufacturing</span>
</div>
</div>
</div>
</section>
</main>

<?php get_footer(); ?>
