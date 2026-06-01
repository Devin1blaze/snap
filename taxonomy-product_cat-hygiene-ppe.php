<?php
/**
 * WooCommerce Category Template: Optimized Hygiene & PPE Solutions PLP
 */
defined( 'ABSPATH' ) || exit;

get_header( 'shop' ); ?>

<div class="snap-woo-wrapper">
    <?php do_action('woocommerce_before_main_content'); ?>
    
    <main class="max-w-7xl mx-auto py-16 px-8 flex flex-col md:flex-row gap-12">
<!-- Sidebar -->
<aside class="w-full md:w-80 flex-shrink-0">
<div class="bg-surface-container-high p-8 space-y-10">
<!-- Brand Filter -->
<div>
<h3 class="label-md font-bold uppercase tracking-widest text-secondary mb-6 text-xs">Brand Selection</h3>
<div class="space-y-4">
<label class="flex items-center gap-3 cursor-pointer group">
<input checked="" class="w-5 h-5 border-2 border-outline rounded-none text-accent-yellow focus:ring-accent-yellow" type="checkbox"/>
<span class="font-bold text-sm tracking-tight group-hover:text-primary">Kimberly Clark</span>
</label>
<label class="flex items-center gap-3 cursor-pointer group">
<input class="w-5 h-5 border-2 border-outline rounded-none text-primary focus:ring-primary" type="checkbox"/>
<span class="font-bold text-sm tracking-tight group-hover:text-primary">Generic</span>
</label>
<label class="flex items-center gap-3 cursor-pointer group">
<input class="w-5 h-5 border-2 border-outline rounded-none text-primary focus:ring-primary" type="checkbox"/>
<span class="font-bold text-sm tracking-tight group-hover:text-primary">Bulk Essentials</span>
</label>
</div>
</div>
<!-- Type Filters -->
<div>
<h3 class="label-md font-bold uppercase tracking-widest text-secondary mb-6 text-xs">Category Filter</h3>
<div class="space-y-3">
<label class="flex items-center gap-3 cursor-pointer group">
<input class="w-5 h-5 border-2 border-outline text-primary focus:ring-0 rounded-none" type="checkbox"/>
<span class="text-sm font-medium">Hand Towels</span>
</label>
<label class="flex items-center gap-3 cursor-pointer group">
<input class="w-5 h-5 border-2 border-outline text-primary focus:ring-0 rounded-none" type="checkbox"/>
<span class="text-sm font-medium">Tissue Rolls</span>
</label>
<label class="flex items-center gap-3 cursor-pointer group">
<input class="w-5 h-5 border-2 border-outline text-primary focus:ring-0 rounded-none" type="checkbox"/>
<span class="text-sm font-medium">Wet Wipes</span>
</label>
<label class="flex items-center gap-3 cursor-pointer group">
<input class="w-5 h-5 border-2 border-outline text-primary focus:ring-0 rounded-none" type="checkbox"/>
<span class="text-sm font-medium">Sanitizers</span>
</label>
<label class="flex items-center gap-3 cursor-pointer group">
<input class="w-5 h-5 border-2 border-outline text-primary focus:ring-0 rounded-none" type="checkbox"/>
<span class="text-sm font-medium">Face Masks</span>
</label>
<label class="flex items-center gap-3 cursor-pointer group">
<input class="w-5 h-5 border-2 border-outline text-primary focus:ring-0 rounded-none" type="checkbox"/>
<span class="text-sm font-medium">Gloves</span>
</label>
<label class="flex items-center gap-3 cursor-pointer group">
<input class="w-5 h-5 border-2 border-outline text-primary focus:ring-0 rounded-none" type="checkbox"/>
<span class="text-sm font-medium">Safety Gear</span>
</label>
<label class="flex items-center gap-3 cursor-pointer group">
<input class="w-5 h-5 border-2 border-outline text-primary focus:ring-0 rounded-none" type="checkbox"/>
<span class="text-sm font-medium">Dispensers</span>
</label>
</div>
</div>
<a class="inline-block text-primary font-black text-xs uppercase tracking-widest hover:underline" href="#">RESET FILTERS</a>
<!-- Bulk Card -->
<div class="bg-primary p-6 text-white">
<span class="material-symbols-outlined mb-4" data-icon="construction">construction</span>
<h4 class="font-black text-lg leading-tight mb-4 tracking-tight">Build a Hygiene Kit for your facility</h4>
<p class="text-xs text-white/80 mb-6">Optimized procurement for industrial facilities.</p>
<button class="w-full bg-accent-yellow text-[#0A0A0A] font-bold py-3 text-xs uppercase tracking-widest hover:bg-white transition-colors">Request Quote</button>
</div>
</div>
</aside>
<!-- Product Grid Container -->
<section class="flex-grow">
<!-- Featured Spotlight (Card 1) -->
<div class="mb-12 flex flex-col md:flex-row bg-white border border-outline-variant/20 shadow-xl overflow-hidden">
<div class="md:w-3/5 bg-primary p-12 flex items-center justify-center">
<div class="relative w-full aspect-video flex items-center justify-center">
<img class="max-h-full object-contain filter brightness-0 invert" data-alt="White illustration of KC Scott Hand Towels" src="https://lh3.googleusercontent.com/aida-public/AB6AXuACU5qC-BvGm-ieF3kMfDhL1JjmYchck0PQvc0G_JoOiFuwebpGP3ol6SfPglZRrhpCFRc5_BZPzOsfG58UE_t2pBaB9-NmpesGKjkvWZ1W1dfhle0z7o_qxMEpBoZxbZmauWRIFnrdj8-FERNZGj1KyPtj-iQSnC6DL4MmeEiSoQyzUNrEQrsIO8ueLWAANIa88tuWxxoyHWSaPEw0HNntAXDFHlcHQDtxFuvsbi6I2wIk7j0hxv1ywAjoTrxgnn5PZ70CFRjQbIY"/>
</div>
</div>
<div class="md:w-2/5 p-12 flex flex-col justify-center bg-white">
<span class="bg-primary text-white text-[10px] font-black px-2 py-0.5 tracking-widest uppercase mb-4 inline-block self-start">FEATURED SPOTLIGHT</span>
<h3 class="text-3xl font-black leading-tight text-[#0A0A0A] mb-4 tracking-tighter uppercase">KC Scott Hand Towels</h3>
<div class="space-y-1 mb-8">
<p class="text-sm text-secondary font-bold uppercase tracking-wider">Blue fold texture</p>
<p class="text-sm text-secondary font-bold uppercase tracking-wider">3750 sheets / case</p>
</div>
<button class="w-full bg-accent-yellow text-[#0A0A0A] font-black py-5 text-sm uppercase tracking-widest hover:bg-[#0A0A0A] hover:text-white transition-all mb-4">₹ CASE PRICE ON REQUEST</button>
<a class="text-primary font-black text-xs uppercase tracking-widest hover:underline block text-center" href="#">BULK ORDER 50+ CASES?</a>
</div>
</div>
<!-- Header Status -->
<div class="flex justify-between items-end mb-10 pb-6 border-b border-outline-variant/20">
<div class="label-md font-bold uppercase tracking-widest text-secondary text-xs">Remaining 8 Products</div>
<div class="flex items-center gap-4 text-xs font-bold uppercase tracking-widest">
<span>Sort By:</span>
<select class="bg-transparent border-none font-black focus:ring-0 text-primary uppercase p-0 cursor-pointer">
<option>Most Popular</option>
<option>Price Low-High</option>
<option>Brand A-Z</option>
</select>
</div>
</div>
<!-- Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-0.5 bg-outline-variant/20">
<!-- Card 2: KC Kleenex Facial Tissue (TOP PICK) -->
<div class="bg-surface-container-lowest p-8 flex flex-col cursor-pointer transition-colors group relative">
<div class="absolute top-4 left-4 z-10">
<span class="bg-accent-yellow text-[#0A0A0A] text-[10px] font-black px-2 py-1 tracking-widest uppercase">TOP PICK</span>
</div>
<div class="aspect-square bg-surface-container-low mb-8 overflow-hidden">
<img class="w-full h-full object-cover" data-alt="Box of Kleenex facial tissues" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCohUgRxeXxmI1VOuLmcCzXvxv7MfIyTSCKexUvllWo1Z7Daw2Zk52DpwuKvkA-T9RnOcp4no7ooLW81cdOvFHe9pLZg_BmUcT6GgTgrSO5kF6X0XNTBy9qzvh0BG9rtg4hS4C42ug1sR7fyQIe_JQTDl-UXjsEwlV7OwLKe_rmsvn-igXSAMqIUzKiGbhEZ4dKKd9ENbwHK6uUfhRJ2ZcMNlgYyOLhMaHHijPdyCU49eXBLoJTNHE130CZ6IZdY-oatQR6rzXyOMs"/>
</div>
<div class="flex-grow">
<span class="bg-primary text-white text-[10px] font-black px-2 py-0.5 tracking-widest uppercase mb-3 inline-block">Kimberly Clark</span>
<h3 class="text-lg font-black leading-tight text-on-surface mb-3 tracking-tighter">KC Kleenex Facial Tissue</h3>
<p class="text-xs text-secondary font-medium mb-1 uppercase tracking-wider">Premium Softness</p>
<p class="text-xs text-secondary font-medium uppercase tracking-wider">Box 200 sheets</p>
</div>
<button class="mt-8 w-full bg-accent-yellow text-[#0A0A0A] font-black py-4 text-xs uppercase tracking-widest group-hover:bg-primary group-hover:text-white transition-all">₹ Request Bulk Price</button>
</div>
<!-- Card 3: KC Bathroom Tissue Roll (HIGH VOLUME) -->
<div class="bg-surface-container-lowest p-8 flex flex-col cursor-pointer transition-colors group relative">
<div class="absolute top-4 left-4 z-10">
<span class="bg-accent-yellow text-[#0A0A0A] text-[10px] font-black px-2 py-1 tracking-widest uppercase">HIGH VOLUME</span>
</div>
<div class="aspect-square bg-surface-container-low mb-8 overflow-hidden">
<img class="w-full h-full object-cover" data-alt="Stack of toilet paper rolls bulk" src="https://lh3.googleusercontent.com/aida-public/AB6AXuALyYzWZe6aCwGNN20tCEpHrWqosHekuKXfPeja_jaAAdk7YhbDhmijg0naHDyxmRMpUQWlhPyLtKI7patCf71Ie0Oti5yd5kGe7MN3FBBCtKbP6iiD-y8oCavrnMEfd9OLeEiidE-5dSJAzgKF8mZdWVDim3OJcN_wbc6v4LCGtQ-2fxvUCKGEquFbOgOcs7F-CadS4p6b_abnImc2U3-Ma82iIbbDbcxlph_n99U0MJC4wmLQlla1au2p2I516_AOeFPVQzN1Fe4"/>
</div>
<div class="flex-grow">
<span class="bg-primary text-white text-[10px] font-black px-2 py-0.5 tracking-widest uppercase mb-3 inline-block">Kimberly Clark</span>
<h3 class="text-lg font-black leading-tight text-on-surface mb-3 tracking-tighter">KC Bathroom Tissue Roll</h3>
<p class="text-xs text-secondary font-medium mb-1 uppercase tracking-wider">High capacity rolls</p>
<p class="text-xs text-secondary font-medium uppercase tracking-wider">96 rolls / case</p>
</div>
<button class="mt-8 w-full bg-accent-yellow text-[#0A0A0A] font-black py-4 text-xs uppercase tracking-widest group-hover:bg-primary group-hover:text-white transition-all">₹ Request Bulk Price</button>
</div>
<!-- Card 7: Moved up (Automatic Sanitizer Dispenser) -->
<div class="bg-surface-container-lowest p-8 flex flex-col hover:bg-tertiary-fixed/10 transition-colors group">
<div class="aspect-square bg-surface-container-low mb-8 overflow-hidden">
<img class="w-full h-full object-cover" data-alt="Wall mounted touchless sanitizer dispenser" src="https://lh3.googleusercontent.com/aida-public/AB6AXuACBVLmFzMdqajN-Hx4ON-7WuojsAP5qs43-Ie5_CbI9-E6cdTJhyzCAg2VEjMmEx74NTSd8U4rM6gHnEti0PzIhPwTPFyLZXe7-9KcX_KLzTFFQSdGE8G0a_Ox836tjYlYuZQvdHvkalD7P2UF9DbvrwJwIlLQq4t9_YK4iOn2MXRwTP822hq5I-l8qbWVfYsNLoaIhsQ5kGlyG1FVfMtMOoc7oZ5nfOtH6iaVcAFlSXWHHE1osU-261qttm9yR7YID0bs3_uFYtY"/>
</div>
<div class="flex-grow">
<span class="bg-primary text-white text-[10px] font-black px-2 py-0.5 tracking-widest uppercase mb-3 inline-block">Professional</span>
<h3 class="text-lg font-black leading-tight text-on-surface mb-3 tracking-tighter">Automatic Sanitizer Dispenser</h3>
<p class="text-xs text-secondary font-medium mb-1 uppercase tracking-wider">Infrared Sensor Tech</p>
<p class="text-xs text-secondary font-medium uppercase tracking-wider">1L Touchless Capacity</p>
</div>
<button class="mt-8 w-full bg-accent-yellow text-[#0A0A0A] font-black py-4 text-xs uppercase tracking-widest group-hover:bg-primary group-hover:text-white transition-all">₹ Request Bulk Price</button>
</div>
<!-- Card 4: KC Scott Industrial Wipers -->
<div class="bg-surface-container-lowest p-8 flex flex-col hover:bg-tertiary-fixed/10 transition-colors group">
<div class="aspect-square bg-surface-container-low mb-8 overflow-hidden">
<img class="w-full h-full object-cover" data-alt="Industrial blue wiper roll" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDuXYLonZZKJ25tybaOridpJSM_tOxsUIkJtzw1JiJmc3hSkAZsifRj0Vd7zUGL9ODdNU8y1P_8l348CkYzx9iUFL7UMG7BAYroD0pfbq9Y3_V6wR_mNi0QEb60QLAXm_6eiBLbjhFpsUwsC1gkaG-b5ACaIRIWnXxJQAkhP3vB5i-3c-J9dRODdnlee42rrydCyhdheta9-5PBq-SU3cG5fugNnJRR8sOM-3EkvyHx_PodFlxkGxH8eqMECYm78Ew02SmryKRGqdk"/>
</div>
<div class="flex-grow">
<span class="bg-primary text-white text-[10px] font-black px-2 py-0.5 tracking-widest uppercase mb-3 inline-block">Kimberly Clark</span>
<h3 class="text-lg font-black leading-tight text-on-surface mb-3 tracking-tighter">KC Scott Industrial Wipers</h3>
<p class="text-xs text-secondary font-medium mb-1 uppercase tracking-wider">Heavy-duty grease removal</p>
<p class="text-xs text-secondary font-medium uppercase tracking-wider">55 sheets / roll</p>
</div>
<button class="mt-8 w-full bg-accent-yellow text-[#0A0A0A] font-black py-4 text-xs uppercase tracking-widest group-hover:bg-primary group-hover:text-white transition-all">₹ Request Bulk Price</button>
</div>
<!-- Card 5: KC Skin Care Hand Sanitizer -->
<div class="bg-surface-container-lowest p-8 flex flex-col hover:bg-tertiary-fixed/10 transition-colors group">
<div class="aspect-square bg-surface-container-low mb-8 overflow-hidden">
<img class="w-full h-full object-cover" data-alt="Hand sanitizer bottle with pump" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCpI6yvdTkNQdeJs4P5Uzzn5ksBvhmzDZ5j3n-H9_7g4bw_1StW-GfKK2rcaKVdoStIuvTHv4fEsRJZnjn175gfn_HHf3vbTSCuh5zF3JMySAtdx3xzIJWkpdg5LV8Tp4jeEsjNVWgBVOB_mCIWwr4FgpYNLqjiMMqU6sX6nxcbO0UvoWgi4oNHOJZ9aYBSj_zEnjocTR1ZU0FeFjilzQsUtQJnRmWIC6fZAT7TFro7IsgxeVpmxeLTkKu395PAsOkHYWBj3sRBqUU"/>
</div>
<div class="flex-grow">
<span class="bg-primary text-white text-[10px] font-black px-2 py-0.5 tracking-widest uppercase mb-3 inline-block">Kimberly Clark</span>
<h3 class="text-lg font-black leading-tight text-on-surface mb-3 tracking-tighter">KC Skin Care Hand Sanitizer</h3>
<p class="text-xs text-secondary font-medium mb-1 uppercase tracking-wider">Alcohol-based formula</p>
<p class="text-xs text-secondary font-medium uppercase tracking-wider">500ml / Auto-Refill</p>
</div>
<button class="mt-8 w-full bg-accent-yellow text-[#0A0A0A] font-black py-4 text-xs uppercase tracking-widest group-hover:bg-primary group-hover:text-white transition-all">₹ Request Bulk Price</button>
</div>
<!-- Card 8: Swapped from row 2 (Urinal Bio-Enzyme Block) -->
<div class="bg-surface-container-lowest p-8 flex flex-col hover:bg-tertiary-fixed/10 transition-colors group">
<div class="aspect-square bg-surface-container-low mb-8 overflow-hidden">
<img class="w-full h-full object-cover" data-alt="Urinal screen blue bio block" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBKTFsHY5-hFUORi3MbnDfW-zewssmqKVeMhr86ZAiCJbEk-Evw04qwM18YkoEog_TUTr4r1FlIcVpvNWaO5ITxkkGk7sPXGR6RFgQO6w_lGZkeagWdvKlpoqR_ctYM6aLPLvoY16FiwZIoKWPRdpQcdL9Cua8X88mJbahLj0CTtzfhHV1mKosxDtMrmU-xLeBybhHGctCf-QuOeYL9ga5p4hKJMJ9wyWDDuq1fAujq_e-o-eLWe73EhmN_rrOyZuEvH8xvhOLbeEU"/>
</div>
<div class="flex-grow">
<span class="bg-primary text-white text-[10px] font-black px-2 py-0.5 tracking-widest uppercase mb-3 inline-block">Maintenance</span>
<h3 class="text-lg font-black leading-tight text-on-surface mb-3 tracking-tighter">Urinal Bio-Enzyme Block</h3>
<p class="text-xs text-secondary font-medium mb-1 uppercase tracking-wider">Anti-Splash / Deodorizing</p>
<p class="text-xs text-secondary font-medium uppercase tracking-wider">Screen with Enzyme Core</p>
</div>
<button class="mt-8 w-full bg-accent-yellow text-[#0A0A0A] font-black py-4 text-xs uppercase tracking-widest group-hover:bg-primary group-hover:text-white transition-all">₹ Request Bulk Price</button>
</div>
</div>
<!-- Section Header -->
<div class="mt-12 mb-8 bg-primary p-4 border-l-8 border-accent-yellow">
<h2 class="text-white font-black uppercase tracking-[0.2em] text-sm">PPE &amp; Safety Equipment</h2>
</div>
<!-- Grid Final Row -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-0.5 bg-outline-variant/20">
<!-- Card 6: KC Kimtech Nitrile Gloves -->
<div class="bg-surface-container-lowest p-8 flex flex-col hover:bg-tertiary-fixed/10 transition-colors group">
<div class="aspect-square bg-surface-container-low mb-8 overflow-hidden">
<img class="w-full h-full object-cover" data-alt="Blue nitrile medical gloves" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBGkMHF7Ns-t-8oazdAqeHmQBLWmDqUL18R0F6RdYPAX5rAjfp4bgRIn0nCrL5AC2XwaKDsEa0b_mUbLkpE6dzVuq025gIphVHyJNqusvPk24rjZ_3eoi9vvBKfwJyrDU4Y-ZbrydCRbJGF3zBZcbOYpHm-wCG1f4nNYylLNLd4M3Ym701mCcwO-Z3HqdG79XfD0LZO8M5u1qSCTRmRD96-H_ELj1qIj7bglN40pPhs_00GO40dkHkMDHZezpoMzQGV1WVHUiEwwH4"/>
</div>
<div class="flex-grow">
<span class="bg-primary text-white text-[10px] font-black px-2 py-0.5 tracking-widest uppercase mb-3 inline-block">Kimberly Clark</span>
<h3 class="text-lg font-black leading-tight text-on-surface mb-3 tracking-tighter">KC Kimtech Nitrile Gloves</h3>
<p class="text-xs text-secondary font-medium mb-1 uppercase tracking-wider">Powder-free / Textured</p>
<p class="text-xs text-secondary font-medium uppercase tracking-wider">100 / box | L/XL</p>
</div>
<button class="mt-8 w-full bg-accent-yellow text-[#0A0A0A] font-black py-4 text-xs uppercase tracking-widest group-hover:bg-primary group-hover:text-white transition-all">₹ Request Bulk Price</button>
</div>
<!-- Card 9: Industrial Safety Helmet -->
<div class="bg-surface-container-lowest p-8 flex flex-col hover:bg-tertiary-fixed/10 transition-colors group">
<div class="aspect-square bg-surface-container-low mb-8 overflow-hidden">
<img class="w-full h-full object-cover" data-alt="Yellow industrial safety helmet" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCsjdXs3_F9bxNmULFT0P65YAnn9WfNHkvFLf2NZQb-l0hHygW0mbQXiGEY1MIPJ91dVu0QR_QW-fsnv3SsB-JrDxXRWr3u1xDXs0xDidknfsFiLQ6i0s5TFg_uxOG4WkEVl1wWGOqFCR8KATWi2mIskem3CpTjyuoZZfH0UlRnGpbNVhlnaiQNF_hQKPDf-6MsHi1C51t1evABtSfgZg4ee28IZKfpdFTfVMNqfriR4vpfZcRf5Z3MoGCQMeP3-qoveyY1KH660Mc"/>
</div>
<div class="flex-grow">
<span class="bg-primary text-white text-[10px] font-black px-2 py-0.5 tracking-widest uppercase mb-3 inline-block">Safety</span>
<h3 class="text-lg font-black leading-tight text-on-surface mb-3 tracking-tighter">Industrial Safety Helmet</h3>
<p class="text-xs text-secondary font-medium mb-1 uppercase tracking-wider">HDPE High Impact</p>
<p class="text-xs text-secondary font-medium uppercase tracking-wider">NPPE Certified Protection</p>
</div>
<button class="mt-8 w-full bg-accent-yellow text-[#0A0A0A] font-black py-4 text-xs uppercase tracking-widest group-hover:bg-primary group-hover:text-white transition-all">₹ Request Bulk Price</button>
</div>
<!-- Placeholder for grid symmetry if needed or extra spacing -->
<div class="hidden lg:block bg-surface-container-lowest/50"></div>
</div>
<!-- Pagination -->
<div class="mt-16 flex items-center justify-center gap-4">
<button class="w-12 h-12 flex items-center justify-center bg-surface-container-high hover:bg-primary hover:text-white transition-colors">
<span class="material-symbols-outlined">chevron_left</span>
</button>
<button class="w-12 h-12 flex items-center justify-center bg-primary text-white font-black">1</button>
<button class="w-12 h-12 flex items-center justify-center bg-surface-container-high hover:bg-primary hover:text-white transition-colors font-black">2</button>
<button class="w-12 h-12 flex items-center justify-center bg-surface-container-high hover:bg-primary hover:text-white transition-colors font-black">3</button>
<button class="w-12 h-12 flex items-center justify-center bg-surface-container-high hover:bg-primary hover:text-white transition-colors">
<span class="material-symbols-outlined">chevron_right</span>
</button>
</div>
</section>
</main>
    
    <?php do_action('woocommerce_after_main_content'); ?>
</div>

<?php get_footer( 'shop' ); ?>
