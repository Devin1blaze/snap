<?php
/**
 * WooCommerce Category Template: Optimized Vending Machines & Beverages PLP
 */
defined( 'ABSPATH' ) || exit;

get_header( 'shop' ); ?>

<div class="snap-woo-wrapper">
    <?php do_action('woocommerce_before_main_content'); ?>
    
    <main class="pt-20">
<!-- Category Hero -->
<section class="bg-black relative overflow-hidden min-h-[450px] flex items-center">
<div class="absolute inset-0 industrial-diagonal bg-primary opacity-20 w-1/2 pointer-events-none"></div>
<div class="container mx-auto px-8 py-20 relative z-10">
<nav class="flex mb-6 space-x-2 text-sm font-bold uppercase tracking-widest text-secondary">
<a href="#">Industrial</a>
<span>/</span>
<a href="#">Equipment</a>
<span>/</span>
<span class="text-white/60">Vending</span>
</nav>
<h1 class="text-6xl md:text-8xl font-black text-white leading-none mb-6 tracking-tighter uppercase">
                    Vending <span class="bg-secondary text-black px-2">MACHINES</span> <br/>&amp; Beverages
                </h1>
<div class="mb-8 space-y-4">
<div class="inline-block bg-secondary text-black text-xs font-black px-4 py-2 rounded-full uppercase tracking-widest">
                        NEW 2025 MODELS AVAILABLE
                    </div>
<div class="flex flex-wrap gap-3">
<span class="bg-secondary/20 text-secondary text-[10px] font-black px-3 py-1 uppercase tracking-widest border border-secondary/30">9 Products</span>
<span class="bg-secondary/20 text-secondary text-[10px] font-black px-3 py-1 uppercase tracking-widest border border-secondary/30">4 Brands</span>
<span class="bg-secondary/20 text-secondary text-[10px] font-black px-3 py-1 uppercase tracking-widest border border-secondary/30">Free Machine Offer</span>
</div>
</div>
<div class="flex flex-col md:flex-row md:items-center gap-6">
<p class="text-xl text-white max-w-2xl font-medium leading-relaxed">
                        Coffee Vending, Sanitary Vending, Cup Dispensers &amp; Premium Beverage Premixes. Engineering reliability for high-traffic environments.
                    </p>
<div class="bg-primary px-4 py-2 flex items-center gap-3 self-start">
<span class="text-xs font-black text-white uppercase tracking-widest">Authorized Partner:</span>
<span class="text-white font-bold text-sm">NESTLÉ | TETLEY | FEMMINA</span>
</div>
</div>
</div>
<div class="absolute right-0 bottom-0 top-0 w-1/3 bg-cover bg-center opacity-30 mix-blend-multiply hidden lg:block" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBqClFqLlUwPyoLlVLNxhOtzn21OuOa6czkLaIMTkOlvKbzy9rVvgoqzxoiTJNCRVVpU5SW8j54zEZZLVqbL1rA4n7g3__4LcLpSZ9V-vDUy2CA3xTKIB1bAAj_L_pD4HTyRdFWI1nNg25pRCrHYWTD6Q7KCCds7jeLrGfCKg1MhRlBobuqXmE3fKNvL7zsKhADbSd5dmtCgcGKmANZvXeuSPdh_B34lLoqQ_I9WUjvWN0tI4RfqhVZQIGfdrAMbWdXFRY5Em3b_2k');"></div>
</section>
<!-- Main Content -->
<section class="container mx-auto px-8 py-16">
<div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
<!-- Sidebar Filters -->
<aside class="lg:col-span-1 space-y-10">
<div>
<h3 class="text-lg font-black uppercase tracking-tighter mb-6 border-b-4 border-primary inline-block">Refine Inventory</h3>
<!-- Brands -->
<div class="space-y-6 mt-8">
<h4 class="font-bold text-sm uppercase tracking-widest">Brand Authority</h4>
<div class="space-y-3">
<label class="flex items-center gap-3 cursor-pointer group">
<input class="w-5 h-5 border-2 border-black text-secondary focus:ring-secondary" type="checkbox"/>
<span class="text-sm font-medium group-hover:text-primary transition-colors">Nestlé</span>
</label>
<label class="flex items-center gap-3 cursor-pointer group">
<input class="w-5 h-5 border-2 border-black text-secondary focus:ring-secondary" type="checkbox"/>
<span class="text-sm font-medium group-hover:text-primary transition-colors">Tetley</span>
</label>
<label class="flex items-center gap-3 cursor-pointer group">
<input class="w-5 h-5 border-2 border-black text-secondary focus:ring-secondary" type="checkbox"/>
<span class="text-sm font-medium group-hover:text-primary transition-colors">Femmina</span>
</label>
<label class="flex items-center gap-3 cursor-pointer group">
<input class="w-5 h-5 border-2 border-black text-secondary focus:ring-secondary" type="checkbox"/>
<span class="text-sm font-medium group-hover:text-primary transition-colors">Generic</span>
</label>
</div>
</div>
<!-- Types -->
<div class="space-y-6 mt-10">
<h4 class="font-bold text-sm uppercase tracking-widest">Machine Category</h4>
<div class="space-y-3">
<label class="flex items-center gap-3 cursor-pointer group">
<input class="w-5 h-5 border-2 border-black text-secondary focus:ring-secondary" type="checkbox"/>
<span class="text-sm font-medium">Coffee Machine</span>
</label>
<label class="flex items-center gap-3 cursor-pointer group">
<input class="w-5 h-5 border-2 border-black text-secondary focus:ring-secondary" type="checkbox"/>
<span class="text-sm font-medium">Sanitary Vending</span>
</label>
<label class="flex items-center gap-3 cursor-pointer group">
<input class="w-5 h-5 border-2 border-black text-secondary focus:ring-secondary" type="checkbox"/>
<span class="text-sm font-medium">Tea/Milk Machine</span>
</label>
<label class="flex items-center gap-3 cursor-pointer group">
<input class="w-5 h-5 border-2 border-black text-secondary focus:ring-secondary" type="checkbox"/>
<span class="text-sm font-medium">Cup Dispenser</span>
</label>
<label class="flex items-center gap-3 cursor-pointer group">
<input class="w-5 h-5 border-2 border-black text-secondary focus:ring-secondary" type="checkbox"/>
<span class="text-sm font-medium">Premix</span>
</label>
</div>
</div>
<button class="mt-8 text-xs font-black text-secondary uppercase tracking-widest hover:underline">
                            Clear All Filters
                        </button>
</div>
<!-- Promo Card -->
<div class="bg-secondary p-8 relative overflow-hidden group shadow-xl">
<div class="absolute -right-4 -top-4 w-24 h-24 bg-black/5 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
<span class="bg-black text-white text-[10px] font-black px-2 py-1 uppercase tracking-widest inline-block mb-4">Hot Offer</span>
<h4 class="text-black text-2xl font-black leading-tight mb-4 uppercase tracking-tighter">Free machine with 6-month premix contract</h4>
<p class="text-black/70 text-sm mb-8 font-medium">Applicable for corporate hubs and manufacturing units with 100+ staff. Limited availability for 2024.</p>
<button class="w-full bg-black text-white py-4 font-black uppercase tracking-widest text-xs hover:bg-primary transition-colors flex items-center justify-center gap-2">
                            GET THIS DEAL <span class="material-symbols-outlined text-sm">arrow_forward</span>
</button>
</div>
</aside>
<!-- Product Grid Area -->
<div class="lg:col-span-3">
<div class="flex flex-col gap-6">
<!-- Spotlight Card (First Product) -->
<div class="bg-white border-4 border-secondary overflow-hidden group flex flex-col md:flex-row relative">
<div class="absolute top-0 right-0 bg-secondary text-black px-6 py-2 font-black uppercase tracking-widest text-xs z-10">
                                BEST SELLER
                            </div>
<div class="md:w-2/5 bg-black flex items-center justify-center p-12 min-h-[300px]">
<span class="material-symbols-outlined text-secondary text-[120px] opacity-90" data-weight="fill">coffee_maker</span>
<div class="absolute top-4 left-4 bg-primary px-3 py-1 text-[10px] font-black text-white uppercase tracking-widest">NESTLÉ</div>
</div>
<div class="md:w-3/5 p-10 flex flex-col justify-center">
<h3 class="text-3xl font-black uppercase tracking-tighter mb-4 group-hover:text-primary transition-colors">Premix Coffee Vending Machine</h3>
<p class="text-outline mb-6 font-medium">Our flagship industrial solution. Robust, touchless, and designed for 24/7 high-volume operation in manufacturing hubs.</p>
<ul class="grid grid-cols-2 gap-4 text-sm text-on-surface mb-8 font-bold">
<li class="flex items-center gap-2"><span class="w-2 h-2 bg-secondary"></span> 500 Cup Capacity</li>
<li class="flex items-center gap-2"><span class="w-2 h-2 bg-secondary"></span> Touchless Sensor</li>
<li class="flex items-center gap-2"><span class="w-2 h-2 bg-secondary"></span> 15-Sec Dispense</li>
<li class="flex items-center gap-2"><span class="w-2 h-2 bg-secondary"></span> Low Maintenance</li>
</ul>
<button class="bg-secondary text-black py-5 px-8 font-black uppercase tracking-widest text-sm hover:bg-black hover:text-white transition-colors self-start">
                                    ₹ Request Bulk Price
                                </button>
</div>
</div>
<!-- Regular Grid Items -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
<!-- Product Card 2 -->
<div class="bg-white border-b-4 border-transparent cursor-pointer transition-all flex flex-col group">
<div class="aspect-square bg-black relative flex items-center justify-center p-8">
<span class="material-symbols-outlined text-secondary text-8xl opacity-80" data-weight="fill">medical_services</span>
<div class="absolute top-4 left-4 bg-primary px-3 py-1 text-[10px] font-black text-white uppercase tracking-widest">FEMMINA</div>
</div>
<div class="p-6 flex-grow">
<h3 class="text-lg font-black uppercase tracking-tighter mb-2 group-hover:text-primary transition-colors">Sanitary Napkin Dispenser</h3>
<ul class="text-sm text-outline space-y-1 mb-6 font-medium">
<li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-secondary"></span> Wall-mounted Steel Shell</li>
<li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-secondary"></span> Battery Backup Inc.</li>
</ul>
<button class="w-full bg-secondary text-black py-4 font-black uppercase tracking-widest text-sm hover:bg-black hover:text-white transition-colors">
                                        ₹ Request Bulk Price
                                    </button>
</div>
</div>
<!-- Product Card 3 -->
<div class="bg-white border-b-4 border-transparent cursor-pointer transition-all flex flex-col group">
<div class="aspect-square bg-black relative flex items-center justify-center p-8">
<span class="material-symbols-outlined text-secondary text-8xl opacity-80" data-weight="fill">restaurant</span>
<div class="absolute top-4 left-4 bg-primary px-3 py-1 text-[10px] font-black text-white uppercase tracking-widest">TETLEY</div>
</div>
<div class="p-6 flex-grow">
<h3 class="text-lg font-black uppercase tracking-tighter mb-2 group-hover:text-primary transition-colors">Tea &amp; Milk Vending Machine</h3>
<ul class="text-sm text-outline space-y-1 mb-6 font-medium">
<li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-secondary"></span> Dual Tank System</li>
<li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-secondary"></span> Industrial Heating Coil</li>
</ul>
<button class="w-full bg-secondary text-black py-4 font-black uppercase tracking-widest text-sm hover:bg-black hover:text-white transition-colors">
                                        ₹ Request Bulk Price
                                    </button>
</div>
</div>
<!-- Product Card 4 -->
<div class="bg-white border-b-4 border-transparent cursor-pointer transition-all flex flex-col group">
<div class="aspect-square bg-black relative flex items-center justify-center p-8">
<span class="material-symbols-outlined text-secondary text-8xl opacity-80" data-weight="fill">local_drink</span>
<div class="absolute top-4 left-4 bg-primary px-3 py-1 text-[10px] font-black text-white uppercase tracking-widest">NESTLÉ</div>
</div>
<div class="p-6 flex-grow">
<h3 class="text-lg font-black uppercase tracking-tighter mb-2 group-hover:text-primary transition-colors">Hot Chocolate Dispenser</h3>
<ul class="text-sm text-outline space-y-1 mb-6 font-medium">
<li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-secondary"></span> Adjustable Whip Control</li>
<li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-secondary"></span> Quick-clean Valve</li>
</ul>
<button class="w-full bg-secondary text-black py-4 font-black uppercase tracking-widest text-sm hover:bg-black hover:text-white transition-colors">
                                        ₹ Request Bulk Price
                                    </button>
</div>
</div>
<!-- Product Card 5 -->
<div class="bg-white border-b-4 border-transparent cursor-pointer transition-all flex flex-col group">
<div class="aspect-square bg-black relative flex items-center justify-center p-8">
<span class="material-symbols-outlined text-secondary text-8xl opacity-80" data-weight="fill">stacked_bar_chart</span>
<div class="absolute top-4 left-4 bg-primary px-3 py-1 text-[10px] font-black text-white uppercase tracking-widest">GENERIC</div>
</div>
<div class="p-6 flex-grow">
<h3 class="text-lg font-black uppercase tracking-tighter mb-2 group-hover:text-primary transition-colors">Paper Cup Dispenser</h3>
<ul class="text-sm text-outline space-y-1 mb-6 font-medium">
<li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-secondary"></span> 500 Cup Capacity</li>
<li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-secondary"></span> Magnetic Mounting</li>
</ul>
<button class="w-full bg-secondary text-black py-4 font-black uppercase tracking-widest text-sm hover:bg-black hover:text-white transition-colors">
                                        ₹ Request Bulk Price
                                    </button>
</div>
</div>
<!-- Product Card 6 -->
<div class="bg-white border-b-4 border-transparent cursor-pointer transition-all flex flex-col group">
<div class="aspect-square bg-black relative flex items-center justify-center p-8">
<span class="material-symbols-outlined text-secondary text-8xl opacity-80" data-weight="fill">soup_kitchen</span>
<div class="absolute top-4 left-4 bg-primary px-3 py-1 text-[10px] font-black text-white uppercase tracking-widest">NESTLÉ</div>
</div>
<div class="p-6 flex-grow">
<h3 class="text-lg font-black uppercase tracking-tighter mb-2 group-hover:text-primary transition-colors">Maggi Soup Vending Machine</h3>
<ul class="text-sm text-outline space-y-1 mb-6 font-medium">
<li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-secondary"></span> 4 Soup Variants</li>
<li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-secondary"></span> Auto-Rinse Cycle</li>
</ul>
<button class="w-full bg-secondary text-black py-4 font-black uppercase tracking-widest text-sm hover:bg-black hover:text-white transition-colors">
                                        ₹ Request Bulk Price
                                    </button>
</div>
</div>
<!-- Product Card 7 -->
<div class="bg-white border-b-4 border-transparent cursor-pointer transition-all flex flex-col group">
<div class="aspect-square bg-black relative flex items-center justify-center p-8">
<span class="material-symbols-outlined text-secondary text-8xl opacity-80" data-weight="fill">payments</span>
<div class="absolute top-4 left-4 bg-primary px-3 py-1 text-[10px] font-black text-white uppercase tracking-widest">GENERIC</div>
</div>
<div class="p-6 flex-grow">
<h3 class="text-lg font-black uppercase tracking-tighter mb-2 group-hover:text-primary transition-colors">Coin-operated Multi-Vender</h3>
<ul class="text-sm text-outline space-y-1 mb-6 font-medium">
<li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-secondary"></span> Multi-Coin Validator</li>
<li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-secondary"></span> Ruggedized Front Panel</li>
</ul>
<button class="w-full bg-secondary text-black py-4 font-black uppercase tracking-widest text-sm hover:bg-black hover:text-white transition-colors">
                                        ₹ Request Bulk Price
                                    </button>
</div>
</div>
<!-- Product Card 8 -->
<div class="bg-white border-b-4 border-transparent cursor-pointer transition-all flex flex-col group">
<div class="aspect-square bg-black relative flex items-center justify-center p-8">
<span class="material-symbols-outlined text-secondary text-8xl opacity-80" data-weight="fill">shopping_basket</span>
<div class="absolute top-4 left-4 bg-primary px-3 py-1 text-[10px] font-black text-white uppercase tracking-widest">TETLEY</div>
</div>
<div class="p-6 flex-grow">
<h3 class="text-lg font-black uppercase tracking-tighter mb-2 group-hover:text-primary transition-colors">Tea Bags (Box of 100)</h3>
<ul class="text-sm text-outline space-y-1 mb-6 font-medium">
<li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-secondary"></span> Bulk Wholesale Pack</li>
<li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-secondary"></span> Sealed for Freshness</li>
</ul>
<button class="w-full bg-secondary text-black py-4 font-black uppercase tracking-widest text-sm hover:bg-black hover:text-white transition-colors">
                                        ₹ Request Bulk Price
                                    </button>
</div>
</div>
<!-- Product Card 9 -->
<div class="bg-white border-b-4 border-transparent cursor-pointer transition-all flex flex-col group">
<div class="aspect-square bg-black relative flex items-center justify-center p-8">
<span class="material-symbols-outlined text-secondary text-8xl opacity-80" data-weight="fill">inventory_2</span>
<div class="absolute top-4 left-4 bg-primary px-3 py-1 text-[10px] font-black text-white uppercase tracking-widest">NESTLÉ</div>
</div>
<div class="p-6 flex-grow">
<h3 class="text-lg font-black uppercase tracking-tighter mb-2 group-hover:text-primary transition-colors">Coffee Premix Powder (1kg)</h3>
<ul class="text-sm text-outline space-y-1 mb-6 font-medium">
<li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-secondary"></span> Nescafe Gold Grade</li>
<li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-secondary"></span> Zero Clumping Formula</li>
</ul>
<button class="w-full bg-secondary text-black py-4 font-black uppercase tracking-widest text-sm hover:bg-black hover:text-white transition-colors">
                                        ₹ Request Bulk Price
                                    </button>
</div>
</div>
</div>
</div>
<!-- New Sub-section: Beverage Bundles -->
<div class="mt-20">
<h2 class="text-2xl font-black uppercase tracking-tighter mb-8 border-l-8 border-primary pl-4">ALSO POPULAR: BEVERAGE BUNDLES</h2>
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
<div class="bg-white border-2 border-outline-variant p-8 flex items-center gap-6 group hover:border-primary transition-colors">
<div class="bg-surface-container-low p-4 rounded-xl">
<span class="material-symbols-outlined text-primary text-5xl">inventory</span>
</div>
<div class="flex-grow">
<h4 class="text-lg font-black uppercase tracking-tighter">Coffee Bundle</h4>
<p class="text-sm text-outline font-medium mb-4">Machine + 6-month Premix Supply</p>
<button class="text-xs font-black uppercase tracking-widest text-primary hover:underline">Enquire Now →</button>
</div>
</div>
<div class="bg-white border-2 border-outline-variant p-8 flex items-center gap-6 group hover:border-primary transition-colors">
<div class="bg-surface-container-low p-4 rounded-xl">
<span class="material-symbols-outlined text-primary text-5xl">package_2</span>
</div>
<div class="flex-grow">
<h4 class="text-lg font-black uppercase tracking-tighter">Tea Bundle</h4>
<p class="text-sm text-outline font-medium mb-4">Machine + Tetley Bulk Bags</p>
<button class="text-xs font-black uppercase tracking-widest text-primary hover:underline">Enquire Now →</button>
</div>
</div>
</div>
</div>
<!-- Centered Large Button replacing pagination -->
<div class="mt-16 text-center">
<button class="bg-secondary text-black px-12 py-6 font-black uppercase tracking-widest text-lg hover:bg-black hover:text-white transition-all shadow-xl">
                            VIEW ALL VENDING PRODUCTS →
                        </button>
</div>
</div>
</div>
</section>
</main>
    
    <?php do_action('woocommerce_after_main_content'); ?>
</div>

<?php get_footer( 'shop' ); ?>
