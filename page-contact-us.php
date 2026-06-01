<?php
/**
 * Template Name: Contact Us
 */

get_header(); ?>

<!-- Page Hero -->
<section class="w-full bg-[#1A56DB] pt-[88px] py-24 md:py-32 px-8">
<div class="max-w-7xl mx-auto">
<h1 class="text-white text-5xl md:text-7xl font-black tracking-tighter leading-tight mb-6 max-w-4xl">
                Let's Build a B2B Partnership.
            </h1>
<p class="text-[#FBBF24] text-xl md:text-2xl font-bold max-w-2xl mb-10 leading-relaxed">
                Get bulk pricing, technical consultation, and direct brand access.
            </p>
<div class="flex flex-col gap-4">
<div class="flex flex-wrap gap-4 items-center">
<button class="bg-[#FBBF24] text-[#0A0A0A] px-10 h-[56px] rounded-full font-black uppercase text-sm tracking-widest hover:scale-105 transition-transform flex items-center justify-center">
                        Submit Enquiry
                    </button>
<button class="bg-[#FBBF24] text-[#0A0A0A] px-10 h-[56px] rounded-full font-black uppercase text-sm tracking-widest hover:scale-105 transition-transform flex items-center justify-center gap-2">
<span class="material-symbols-outlined text-xl">chat</span>
                        WhatsApp Us
                    </button>
</div>
<p class="text-[#FBBF24] text-xs font-bold uppercase tracking-widest pl-4">Typically responds in 2 hours</p>
</div>
</div>
</section>

<!-- Main Content (Two-column) -->
<section class="bg-white py-24 px-8">
<div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
<!-- LEFT Column: Quote Form (Layout Swap) -->
<div class="shadow-2xl border-t-[12px] border-[#1A56DB] order-1">
<div class="bg-[#1A56DB] px-10 py-3 flex items-center justify-between">
<span class="text-white text-[10px] font-black uppercase tracking-[0.2em]">Step 1 of 1 – Tell us what you need</span>
<div class="w-24 h-1.5 bg-white/20 rounded-full overflow-hidden">
<div class="w-full h-full bg-[#FBBF24]"></div>
</div>
</div>
<div class="bg-white p-10 md:p-14">
<h2 class="text-[#0A0A0A] text-3xl font-black uppercase tracking-tight mb-2">Request a Bulk Quote</h2>
<p class="text-gray-500 font-medium mb-12">Submit your industrial requirements for prioritized processing.</p>

<div class="cf7-container text-[#0A0A0A]">
            <style>
                /* Ultra-specific selectors to ensure white background on inputs */
                .cf7-container .wpcf7-form input:not([type="submit"]), 
                .cf7-container .wpcf7-form select, 
                .cf7-container .wpcf7-form textarea { 
                    width: 100% !important; 
                    background-color: #ffffff !important; 
                    background: #ffffff !important;
                    border: 0 !important; 
                    border-bottom: 2px solid #e5e7eb !important; 
                    color: #0A0A0A !important; 
                    padding: 0.75rem 0 !important; 
                    margin-bottom: 0.75rem !important; 
                    border-radius: 0 !important; 
                    font-family: 'Plus Jakarta Sans', sans-serif !important; 
                    font-size: 1.125rem !important; 
                    font-weight: 500 !important; 
                    transition: border-color 0.2s !important;
                    -webkit-appearance: none;
                }
                
                /* Autofill fix */
                .cf7-container .wpcf7-form input:-webkit-autofill,
                .cf7-container .wpcf7-form input:-webkit-autofill:hover, 
                .cf7-container .wpcf7-form input:-webkit-autofill:focus, 
                .cf7-container .wpcf7-form input:-webkit-autofill:active {
                    -webkit-box-shadow: 0 0 0 30px white inset !important;
                    -webkit-text-fill-color: #0A0A0A !important;
                }

                .cf7-container .wpcf7-form-control:focus { 
                    border-color: #FBBF24 !important; 
                    outline: none !important; 
                    box-shadow: none !important; 
                }
                
                .cf7-container input.wpcf7-submit { 
                    background-color: #FBBF24 !important; 
                    color: #0A0A0A !important; 
                    font-weight: 900 !important; 
                    text-transform: uppercase !important; 
                    width: 100% !important; 
                    padding: 1.25rem !important; 
                    margin-top: 1rem !important; 
                    border: none !important; 
                    cursor: pointer !important; 
                    transition: background-color 0.2s !important; 
                    height: 60px !important; 
                    font-size: 1.25rem !important;
                }
                
                .cf7-container input.wpcf7-submit:hover { 
                    background-color: #0A0A0A !important; 
                    color: #FBBF24 !important; 
                }
                
                .cf7-container br { display: none; }
                .wpcf7-spinner { display: none; }
                .wpcf7-not-valid-tip { color: #ef4444; font-size: 0.75rem; margin-top: -0.5rem; margin-bottom: 0.5rem; display: block; font-weight: 600; }
                .wpcf7-response-output { border: 2px solid #FBBF24 !important; color: #1A56DB !important; font-weight: 700 !important; text-transform: uppercase !important; font-size: 0.8rem !important; margin-top: 1rem !important; padding: 1rem !important; text-align: center; }
            </style>
<?php echo do_shortcode('[contact-form-7 id="30" title="Contact form"]'); ?>
</div>

</div>
</div>
<!-- RIGHT Column: Contact Info Card (Layout Swap) -->
<div class="bg-[#1A56DB] p-10 md:p-14 flex flex-col h-full space-y-12 order-2">
<button class="w-full bg-[#FBBF24] text-[#0A0A0A] py-5 font-black uppercase tracking-widest text-lg flex items-center justify-center gap-3 hover:scale-[1.02] transition-transform">
<span class="material-symbols-outlined font-black">call</span>
                    CALL US NOW
                </button>
<div>
<h2 class="text-white text-3xl font-black uppercase tracking-tight mb-12">Corporate Headquarters</h2>
<div class="space-y-10">
<div class="flex items-start gap-6">
<span class="material-symbols-outlined text-[#FBBF24] text-3xl">location_on</span>
<div>
<p class="text-white/60 font-bold text-xs uppercase tracking-widest mb-1">Office Address</p>
<p class="text-white text-lg font-medium">12 Industrial Way, Steel Quarter, SQ 500, Pune</p>
</div>
</div>
<div class="flex flex-col gap-6">
<div class="flex items-start gap-6">
<span class="material-symbols-outlined text-[#FBBF24] text-3xl">call</span>
<div>
<p class="text-white/60 font-bold text-xs uppercase tracking-widest mb-1">Business Phone</p>
<p class="text-white text-lg font-medium">+1 (555) 900-SNAP</p>
</div>
</div>
<button class="ml-[54px] w-fit flex items-center gap-2 bg-[#FBBF24] text-[#0A0A0A] px-6 py-2 rounded-full font-black uppercase text-[10px] tracking-widest hover:scale-105 transition-transform">
<span class="material-symbols-outlined text-sm">chat</span>
                                WhatsApp Support
                            </button>
</div>
<div class="flex items-start gap-6">
<span class="material-symbols-outlined text-[#FBBF24] text-3xl">mail</span>
<div>
<p class="text-white/60 font-bold text-xs uppercase tracking-widest mb-1">Direct Email</p>
<p class="text-white text-lg font-medium">sales@snapmarketing.in</p>
</div>
</div>
<div class="flex items-start gap-6">
<span class="material-symbols-outlined text-[#FBBF24] text-3xl">schedule</span>
<div>
<p class="text-white/60 font-bold text-xs uppercase tracking-widest mb-1">Working Hours</p>
<p class="text-white text-lg font-medium">Mon-Sat, 9AM - 6PM</p>
</div>
</div>
</div>
</div>
<div class="w-full h-80 border-4 border-[#FBBF24] relative overflow-hidden bg-[#1A56DB]">
<!-- Detailed Map Illustration Placeholder -->
<img alt="Detailed map of Pune Industrial Cluster" class="w-full h-full object-cover opacity-80" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD9oZ7Z4D5Xo9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9Q9X9"/>
<div class="absolute inset-0 bg-gradient-to-t from-[#1A56DB]/80 to-transparent flex items-end p-6">
<div class="bg-[#FBBF24] text-black px-4 py-2 font-black uppercase text-xs">Steel Quarter, SQ 500</div>
</div>
</div>
</div>
</div>
</section>

<!-- 3 Reasons to Buy Section (Replaces FAQ) -->
<section class="bg-[#1A56DB] py-32 px-8">
<div class="max-w-7xl mx-auto">
<h2 class="text-white text-4xl md:text-5xl font-black uppercase tracking-tighter mb-20 text-center">3 Reasons to Buy from Snap Marketing</h2>
<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
<!-- Reason 1 -->
<div class="bg-white/10 backdrop-blur-sm border border-white/20 p-12 text-center group cursor-pointer">
<div class="mb-8">
<span class="material-symbols-outlined text-[#FBBF24] text-7xl font-black transition-transform group-hover:scale-110 duration-300">verified</span>
</div>
<h3 class="text-white text-2xl font-black uppercase tracking-tight mb-4">Certified Genuineness</h3>
<p class="text-white/60 font-medium leading-relaxed">Direct manufacturer partnerships ensuring 100% authentic industrial components with full warranty coverage.</p>
</div>
<!-- Reason 2 -->
<div class="bg-white/10 backdrop-blur-sm border border-white/20 p-12 text-center group cursor-pointer">
<div class="mb-8">
<span class="material-symbols-outlined text-[#FBBF24] text-7xl font-black transition-transform group-hover:scale-110 duration-300">precision_manufacturing</span>
</div>
<h3 class="text-white text-2xl font-black uppercase tracking-tight mb-4">Bulk Engineering</h3>
<p class="text-white/60 font-medium leading-relaxed">Specialized logistics for large-scale industrial orders, maintaining structural integrity from factory to floor.</p>
</div>
<!-- Reason 3 -->
<div class="bg-white/10 backdrop-blur-sm border border-white/20 p-12 text-center group cursor-pointer">
<div class="mb-8">
<span class="material-symbols-outlined text-[#FBBF24] text-7xl font-black transition-transform group-hover:scale-110 duration-300">support_agent</span>
</div>
<h3 class="text-white text-2xl font-black uppercase tracking-tight mb-4">Technical Priority</h3>
<p class="text-white/60 font-medium leading-relaxed">Dedicated account managers providing technical consultation and priority processing for every corporate client.</p>
</div>
</div>
</div>
</section>

<?php get_footer(); ?>
