<?php
/**
 * Template Name: Request a Quote
 */

get_header(); ?>

<main id="primary" class="site-main pb-12 relative overflow-hidden bg-white text-zinc-900">
    <div class="absolute inset-0 pointer-events-none opacity-10" style="background-image: linear-gradient(#1e293b 1px, transparent 1px), linear-gradient(90deg, #1e293b 1px, transparent 1px); background-size: 24px 24px;"></div>
    
    <!-- Hero Section -->
    <section class="relative px-5 pt-32 pb-12 md:px-16 md:pt-40 md:pb-24 border-b-4 border-[#FBBF24] overflow-hidden" style="background: linear-gradient(135deg, #0A0A0A 65%, #FBBF24 100%);">
        <!-- Yellow diagonal accent block (right) -->
        <div class="absolute right-0 top-0 bottom-0 w-1/3 opacity-20 pointer-events-none" style="background: #FBBF24; clip-path: polygon(30% 0%, 100% 0%, 100% 100%, 0% 100%);"></div>
        <!-- Decorative icon -->
        <div class="absolute right-[-5%] top-[-10%] opacity-10 pointer-events-none text-[#FBBF24]">
            <span class="material-symbols-outlined text-[300px] leading-none" data-icon="inventory_2" style="font-variation-settings: 'FILL' 1;">inventory_2</span>
        </div>
        <div class="relative z-10 max-w-4xl">
            <h1 class="font-black text-3xl md:text-5xl text-white uppercase leading-none tracking-tighter mb-4">
                REQUEST INDUSTRIAL QUOTE
            </h1>
            <div class="bg-[#FBBF24] inline-block px-4 py-2 border-l-4 border-[#0A0A0A]">
                <p class="font-mono text-sm tracking-widest text-[#0A0A0A] font-black uppercase">
                    High-Volume Procurement Control Center
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content Grid -->
    <div class="flex flex-col lg:grid lg:grid-cols-12 w-full border-b-4 border-zinc-950">
        <!-- Form Section -->
        <section class="lg:col-span-8 border-b-4 lg:border-b-0 lg:border-r-4 border-zinc-950 bg-white p-5 md:p-6 lg:p-16">
            <div class="cf7-quote-page-container text-zinc-900">
                <style>
                    .cf7-quote-page-container input:not([type="submit"]), 
                    .cf7-quote-page-container textarea,
                    .cf7-quote-page-container select {
                        width: 100%;
                        background: #ffffff;
                        border: 2px solid #000000;
                        color: #000000;
                        padding: 0.75rem;
                        margin-bottom: 0.75rem;
                        border-radius: 0;
                        font-size: 0.95rem;
                    }
                    .cf7-quote-page-container input:focus, 
                    .cf7-quote-page-container textarea:focus,
                    .cf7-quote-page-container select:focus {
                        border-color: #1A56DB;
                        outline: none;
                        box-shadow: 0 0 0 2px rgba(26, 86, 219, 0.1);
                    }
                    .cf7-quote-page-container input.wpcf7-submit {
                        background-color: #FBBF24 !important;
                        color: black !important;
                        font-weight: 900 !important;
                        text-transform: uppercase !important;
                        width: 100% !important;
                        padding: 1rem !important;
                        margin-top: 1rem !important;
                        border: 2px solid #000000 !important;
                        cursor: pointer !important;
                        transition: all 0.2s !important;
                        border-radius: 0 !important;
                    }
                    .cf7-quote-page-container input.wpcf7-submit:hover {
                        background-color: #ffffff !important;
                        color: black !important;
                    }
                    .cf7-quote-page-container br { display: none; }
                    .wpcf7-spinner { display: none; }
                    .wpcf7-not-valid-tip { color: #ef4444; font-size: 0.75rem; margin-top: -0.5rem; margin-bottom: 0.5rem; display: block; font-weight: 600; }
                    .wpcf7-response-output { border: 2px solid #FBBF24 !important; color: #000000 !important; font-weight: 700 !important; text-transform: uppercase !important; font-size: 0.8rem !important; margin-top: 1rem !important; padding: 1rem !important; text-align: center; }
                </style>
                <?php
                $cf7_form = get_page_by_title('Bulk Quote Form', OBJECT, 'wpcf7_contact_form');
                if ( $cf7_form ) {
                    echo do_shortcode( '[contact-form-7 id="' . esc_attr( $cf7_form->ID ) . '" title="Bulk Quote Form"]' );
                } else {
                    echo '<p class="text-zinc-500">Quote form is not configured. Please create a "Bulk Quote Form" in Contact Form 7.</p>';
                }
                ?>
            </div>
        </section>

        <!-- Trust & Contact Sidebar -->
        <aside class="lg:col-span-4 bg-zinc-50 flex flex-col">
            <!-- Image Display -->
            <div class="relative h-64 lg:h-80 border-b-4 border-zinc-950 overflow-hidden">
                <img alt="Industrial Facility" class="w-full h-full object-cover grayscale brightness-50 contrast-125" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDnAtJjJnPbbex592esXQvU54f2q349Uv5L9ZE5N7JCAOy3lrUnqkRSV8C4Ms5-DvA2MSqg1YdctjtiEiOksWF4-vzdcJTCP2goUwDwkBbSa4_R-X7p_Z9k9bM6jNVLOn4Zy6P_9c1NRB_SXC1Lipm1aB0uKQDOrRLodWo6VTl9jesIsiHu992cKU74D9lEmIb2KKTAKRMgNCifCmmPN0tUPIsZXmx1UTGXhlxH1fFLSQWpuZTSmYyZ4VbRux7-P5nRe2kPx6v-dig"/>
                <div class="absolute bottom-4 left-4 bg-primary px-3 py-1 font-mono text-xs text-white uppercase">
                    FACILITY ID: SN-IND-04
                </div>
            </div>
            <div class="p-5 md:p-6 space-y-12">
                <!-- Contact Section -->
                <div class="space-y-6">
                    <h3 class="font-mono text-sm uppercase text-secondary tracking-widest border-b border-secondary/30 pb-2">Direct Procurement Line</h3>
                    <div class="flex items-center gap-4 group cursor-pointer">
                        <div class="bg-zinc-200 p-3 border-2 border-zinc-950 group-hover:bg-primary transition-colors">
                            <span class="material-symbols-outlined text-zinc-900" data-icon="call">call</span>
                        </div>
                        <div>
                            <p class="text-2xl font-black tracking-tighter text-zinc-900">+1 (555) 900-SNAP</p>
                            <p class="font-mono text-xs text-zinc-500">AVAILABLE 24/7 FOR ENTERPRISE</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 group cursor-pointer">
                        <div class="bg-zinc-200 p-3 border-2 border-zinc-950 group-hover:bg-primary transition-colors">
                            <span class="material-symbols-outlined text-zinc-900" data-icon="mail">mail</span>
                        </div>
                        <div>
                            <p class="text-2xl font-black tracking-tighter text-zinc-900">SUPPLY@SNAPMARKETING.IND</p>
                            <p class="font-mono text-xs text-zinc-500">AVERAGE RESPONSE: 14 MINS</p>
                        </div>
                    </div>
                </div>

                <!-- Trust Badges -->
                <div class="space-y-4">
                    <h3 class="font-mono text-sm uppercase text-secondary tracking-widest border-b border-secondary/30 pb-2">Certifications &amp; Network</h3>
                    <div class="border-2 border-zinc-950 p-4 flex items-center gap-4 bg-white">
                        <span class="material-symbols-outlined text-primary text-3xl" data-icon="verified" style="font-variation-settings: 'FILL' 1;">verified</span>
                        <div>
                            <p class="font-mono text-sm font-bold uppercase">ISO 9001:2015 CERTIFIED</p>
                            <p class="font-mono text-xs text-zinc-500">Quality Management Protocol</p>
                        </div>
                    </div>
                    <div class="border-2 border-zinc-950 p-4 flex items-center gap-4 bg-white">
                        <span class="material-symbols-outlined text-primary text-3xl" data-icon="local_shipping" style="font-variation-settings: 'FILL' 1;">local_shipping</span>
                        <div>
                            <p class="font-mono text-sm font-bold uppercase">PAN-INDIA LOGISTICS</p>
                            <p class="font-mono text-xs text-zinc-500">Tier-1 Distribution Network</p>
                        </div>
                    </div>
                    <div class="border-2 border-zinc-950 p-4 flex items-center gap-4 bg-white">
                        <span class="material-symbols-outlined text-primary text-3xl" data-icon="precision_manufacturing" style="font-variation-settings: 'FILL' 1;">precision_manufacturing</span>
                        <div>
                            <p class="font-mono text-sm font-bold uppercase">AUTHORIZED ENTERPRISE PARTNER</p>
                            <p class="font-mono text-xs text-zinc-500">Direct OEM Supply Chain Access</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</main>

<?php get_footer(); ?>