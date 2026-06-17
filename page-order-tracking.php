<?php
/**
 * Template Name: Order Tracking Page
 */

get_header(); ?>

<!-- Page Hero -->
<section class="w-full bg-[#1A56DB] pt-[88px] py-24 md:py-32 px-8 border-b-4 border-black">
    <div class="max-w-7xl mx-auto">
        <div class="text-[#FBBF24] font-bold text-sm uppercase tracking-widest mb-4">
            <a href="<?php echo home_url(); ?>" class="hover:text-white transition-colors">Home</a> / Track Order
        </div>
        <h1 class="text-white text-5xl md:text-7xl font-black tracking-tighter leading-tight mb-6 max-w-4xl font-['Rubik']">
            Track Your Order.
        </h1>
        <p class="text-[#FBBF24] text-xl md:text-2xl font-bold max-w-2xl leading-relaxed font-['Nunito_Sans']">
            Enter your order details below to get real-time status updates on your purchase.
        </p>
    </div>
</section>

<!-- Main Content (Two-column) -->
<section class="bg-zinc-50 py-24 px-8 font-['Nunito_Sans']">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-16 items-start">
        
        <!-- LEFT Column: Form & Tracking Details (2/3 width) -->
        <div class="lg:col-span-2">
            <div class="bg-white p-10 md:p-14 border-2 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]">
                <?php echo do_shortcode('[woocommerce_order_tracking]'); ?>
            </div>
        </div>

        <!-- RIGHT Column: Trust Cards (1/3 width) -->
        <div class="lg:col-span-1 flex flex-col gap-8">
            <!-- Trust Card 1 -->
            <div class="bg-white p-8 border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                <div class="mb-6 flex items-center justify-between">
                    <span class="material-symbols-outlined text-[#1A56DB] text-4xl">local_shipping</span>
                    <span class="bg-[#FBBF24] text-black text-[10px] font-black uppercase tracking-widest px-3 py-1 border-2 border-black">Dispatch</span>
                </div>
                <h3 class="text-[#0A0A0A] text-xl font-black uppercase tracking-tight mb-3 font-['Rubik']">Premium B2C Dispatch</h3>
                <p class="text-gray-600 font-medium text-sm leading-relaxed">
                    All orders are packed securely and dispatched within 24 hours. Tracked transit with real-time milestones.
                </p>
            </div>

            <!-- Trust Card 2 -->
            <div class="bg-white p-8 border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                <div class="mb-6">
                    <span class="material-symbols-outlined text-[#1A56DB] text-4xl">support_agent</span>
                </div>
                <h3 class="text-[#0A0A0A] text-xl font-black uppercase tracking-tight mb-3 font-['Rubik']">Order Support</h3>
                <p class="text-gray-600 font-medium text-sm leading-relaxed mb-6">
                    Need help with your shipment? Reach our support team instantly.
                </p>
                <div class="flex flex-col gap-3">
                    <a href="https://wa.me/919823012724" target="_blank" rel="noopener noreferrer" class="group flex items-center gap-3 text-sm font-bold uppercase tracking-widest text-[#0A0A0A]">
                        <span class="material-symbols-outlined text-[#1A56DB]">chat</span>
                        <span class="border-b-2 border-transparent group-hover:border-[#FBBF24] transition-colors pb-1">+91 98230 12724</span>
                    </a>
                    <a href="mailto:sales@snapmktg.com" class="group flex items-center gap-3 text-sm font-bold uppercase tracking-widest text-[#0A0A0A]">
                        <span class="material-symbols-outlined text-[#1A56DB]">mail</span>
                        <span class="border-b-2 border-transparent group-hover:border-[#FBBF24] transition-colors pb-1">sales@snapmktg.com</span>
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Custom Styles for Order Tracking Page Inputs -->
<style>
    /* Scoped styling for Order Tracking form inputs */
    .track_order input.input-text {
        background-color: #ffffff !important;
        border: 2px solid #000000 !important;
        color: #0A0A0A !important;
        padding: 0.75rem 1rem !important;
        border-radius: 0 !important;
        font-family: 'Nunito Sans', sans-serif !important;
        font-weight: 600 !important;
        transition: all 0.2s ease !important;
    }
    .track_order input.input-text:focus {
        border-color: #1A56DB !important;
        box-shadow: 0 0 0 3px rgba(26, 86, 219, 0.2) !important;
        outline: none !important;
    }
    .track_order label {
        font-family: 'Nunito Sans', sans-serif !important;
        font-weight: 800 !important;
        text-transform: uppercase !important;
        font-size: 0.75rem !important;
        letter-spacing: 0.05em !important;
        color: #000000 !important;
        margin-bottom: 0.5rem !important;
        display: block !important;
    }
</style>

<?php get_footer(); ?>
