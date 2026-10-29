<?php
/**
 * The template for displaying the footer
 * Unified footer used across all pages
 */
?>
<!-- Section 9: Corporate Footer -->
<footer class="bg-black text-gray-400 w-full border-t-4 border-secondary-container">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-12 px-12 py-20 max-w-full">
        <div class="space-y-6">
            <div class="text-3xl font-black text-white italic"><?php bloginfo( 'name' ); ?></div>
            <p class="font-medium text-lg text-zinc-400 leading-relaxed">Pune's trusted Wholesaler & Distributor for Hygiene, Refrigeration, Vending & Washroom Automation Solutions since 1988.</p>
            <div class="flex gap-4">
                <a href="#" aria-label="LinkedIn" class="w-10 h-10 bg-[#1A56DB] flex items-center justify-center hover:bg-[#FBBF24] hover:text-black hover:-translate-y-1 text-white active:scale-95 transition-all duration-300">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                </a>
                <a href="#" aria-label="Facebook" class="w-10 h-10 bg-[#1A56DB] flex items-center justify-center hover:bg-[#FBBF24] hover:text-black hover:-translate-y-1 text-white active:scale-95 transition-all duration-300">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
                </a>
            </div>
        </div>
        <div>
            <h4 class="text-secondary-container font-black uppercase mb-8 tracking-tighter">Quick Links</h4>
            <ul class="space-y-4">
                <li><a class="text-zinc-400 hover:text-white transition-colors block font-medium text-lg" href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>">About Us</a></li>
                <li>
                    <a class="text-[#FBBF24] hover:text-white transition-colors block font-bold text-lg flex items-center gap-2 group" href="<?php echo esc_url( home_url( '/faq/' ) ); ?>">
                        <span class="material-symbols-outlined text-sm text-[#FBBF24] group-hover:translate-x-1 transition-transform">help</span>
                        Frequently Asked Questions (FAQ)
                    </a>
                </li>
                <li><a class="text-zinc-400 hover:text-white transition-colors block font-medium text-lg" href="<?php echo esc_url( home_url( '/request-a-quote/' ) ); ?>">Request Bulk Quote</a></li>
                <li><a class="text-zinc-400 hover:text-white transition-colors block font-medium text-lg" href="<?php echo esc_url( home_url( '/order-tracking/' ) ); ?>">Order Tracking</a></li>
                <li><a class="text-zinc-400 hover:text-white transition-colors block font-medium text-lg" href="<?php echo esc_url( home_url( '/registrations/' ) ); ?>">Compliance &amp; Registrations</a></li>
                <li><a class="text-zinc-400 hover:text-white transition-colors block font-medium text-lg" href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>">Contact Us</a></li>
                <li><a class="text-zinc-400 hover:text-white transition-colors block font-medium text-lg" href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy Policy</a></li>
            </ul>
        </div>
        <div>
            <h4 class="text-secondary-container font-black uppercase mb-8 tracking-tighter">Major Categories</h4>
            <ul class="space-y-4">
                <li><a class="text-zinc-400 hover:text-white transition-colors block font-medium text-lg" href="<?php echo esc_url( home_url( '/product-category/commercial-refrigeration/' ) ); ?>">Refrigeration</a></li>
                <li><a class="text-zinc-400 hover:text-white transition-colors block font-medium text-lg" href="<?php echo esc_url( home_url( '/product-category/water-coolers/' ) ); ?>">Water Coolers &amp; Dispensers</a></li>
                <li><a class="text-zinc-400 hover:text-white transition-colors block font-medium text-lg" href="<?php echo esc_url( home_url( '/product-category/washroom-automations/' ) ); ?>">Washroom Tech</a></li>
                <li><a class="text-zinc-400 hover:text-white transition-colors block font-medium text-lg" href="<?php echo esc_url( home_url( '/product-category/hygiene-ppe/' ) ); ?>">Safety Gear</a></li>
                <li><a class="text-zinc-400 hover:text-white transition-colors block font-medium text-lg" href="<?php echo esc_url( home_url( '/product-category/entrance-solutions/' ) ); ?>">Entrance Solutions</a></li>
                <li><a class="text-zinc-400 hover:text-white transition-colors block font-medium text-lg" href="<?php echo esc_url( home_url( '/product-category/vending-machines/' ) ); ?>">Vending Machines</a></li>
            </ul>
        </div>
        <div class="space-y-6">
            <h4 class="text-secondary-container font-black uppercase mb-8 tracking-tighter">Contact Us</h4>
            <div class="flex gap-4 items-start">
                <span class="material-symbols-outlined text-secondary-container">location_on</span>
                <p class="font-medium text-lg text-zinc-400">Snap House, 322/16, Shankar Sheth Road, Near Indian Oil Petrol Pump, Hotel 7 Loves Chowk, Ghorpadi Peth, Pune - 411042, Maharashtra, India</p>
            </div>
            <div class="flex gap-4 items-center">
                <span class="material-symbols-outlined text-secondary-container">call</span>
                <p class="font-medium text-lg text-zinc-400">+91 98230 12724</p>
            </div>
            <div class="flex gap-4 items-center">
                <span class="material-symbols-outlined text-secondary-container">email</span>
                <p class="font-medium text-lg text-zinc-400">sales@snapmktg.com</p>
            </div>
        </div>
    </div>
    <div class="px-12 py-8 bg-zinc-950 flex flex-col md:flex-row justify-between items-center text-sm font-bold uppercase tracking-widest text-gray-500 border-t border-white/5 gap-4">
        <div>© <?php echo date('Y'); ?> Snap Marketing Private Limited. All Rights Reserved. Pune, India.</div>
        <div class="flex flex-wrap items-center gap-6 text-xs normal-case tracking-normal">
            <a href="<?php echo esc_url( home_url( '/faq/' ) ); ?>" class="text-[#FBBF24] hover:underline font-bold flex items-center gap-1">
                <span class="material-symbols-outlined text-xs">help</span> FAQ Hub
            </a>
            <span class="text-zinc-700 hidden sm:inline">•</span>
            <a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>" class="text-zinc-400 hover:text-white transition-colors font-medium">Contact Us</a>
            <span class="text-zinc-700 hidden sm:inline">•</span>
            <a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>" class="text-zinc-400 hover:text-white transition-colors font-medium">Privacy Policy</a>
            <span class="text-zinc-700 hidden sm:inline">•</span>
            <a href="<?php echo esc_url( home_url( '/terms-of-service/' ) ); ?>" class="text-zinc-400 hover:text-white transition-colors font-medium">Terms of Service</a>
        </div>
    </div>
</footer>

<!-- Floating WhatsApp Chat Widget (Desktop & Mobile) -->
<div id="snap-floating-whatsapp" class="fixed bottom-20 md:bottom-8 right-6 z-[9990] flex items-center group">
    <a href="https://wa.me/919823012724?text=Hi%20Snap%20Marketing%2C%20I%20am%20visiting%20your%20website%20and%20would%20like%20to%20inquire%20about%20pricing%20and%20product%20details." 
       target="_blank" 
       rel="noopener noreferrer" 
       aria-label="Chat on WhatsApp with Blue Star Specialist"
       class="relative flex items-center justify-center w-14 h-14 md:w-16 md:h-16 bg-[#25D366] hover:bg-[#20bd5a] text-white rounded-full shadow-2xl hover:scale-110 active:scale-95 transition-all duration-300">
        <!-- Subtle ping ring effect -->
        <span class="absolute -inset-1 rounded-full bg-[#25D366] opacity-30 animate-ping pointer-events-none"></span>
        <!-- WhatsApp Icon SVG -->
        <svg class="w-8 h-8 md:w-9 md:h-9 fill-current relative z-10" viewBox="0 0 24 24">
            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
        </svg>
    </a>
    <!-- Tooltip badge on hover (Desktop) -->
    <span class="hidden md:group-hover:inline-block absolute right-20 bg-[#0A0A0A] text-white text-xs font-black uppercase tracking-wider py-2 px-3 shadow-xl whitespace-nowrap border-l-2 border-[#25D366] transition-opacity">
        WhatsApp Us (Instant Reply)
    </span>
</div>

<!-- Mobile Sticky Bottom Quick-Action Bar (Screens < 768px) -->
<div id="snap-mobile-action-bar" class="block md:hidden fixed bottom-0 left-0 right-0 z-[9995] bg-[#0A0A0A] border-t-2 border-[#1A56DB] shadow-[0_-5px_20px_rgba(0,0,0,0.5)] px-3 py-2.5 pb-[max(0.625rem,env(safe-area-inset-bottom))]">
    <div class="grid grid-cols-2 gap-2">
        <a href="tel:+919823012724" 
           class="flex items-center justify-center gap-2 bg-[#1A56DB] active:bg-blue-800 text-white font-black text-xs uppercase tracking-wider py-3.5 px-2 rounded-none transition-all shadow-md">
            <span class="material-symbols-outlined text-base">call</span>
            <span>Call Sales</span>
        </a>
        <a href="https://wa.me/919823012724?text=Hi%20Snap%20Marketing%2C%20I%20am%20visiting%20your%20website%20and%20would%20like%20to%20request%20a%20quote." 
           target="_blank" 
           rel="noopener noreferrer" 
           class="flex items-center justify-center gap-2 bg-[#FBBF24] active:bg-amber-400 text-[#0A0A0A] font-black text-xs uppercase tracking-wider py-3.5 px-2 rounded-none transition-all shadow-md">
            <span class="material-symbols-outlined text-base">chat</span>
            <span>WhatsApp Quote</span>
        </a>
    </div>
</div>

<style>
/* Ensure content isn't obscured by fixed mobile action bar */
@media (max-width: 767px) {
    body {
        padding-bottom: 64px !important;
    }
}
</style>

<!-- Quote Modal -->
<div id="quote-modal" class="fixed inset-0 z-[100000] hidden items-center justify-center bg-black/80 backdrop-blur-sm opacity-0 transition-opacity duration-300 p-4">
    <div class="bg-zinc-900 border-2 border-secondary-container p-6 md:p-8 max-w-lg w-full max-h-[90vh] overflow-y-auto relative transform scale-95 transition-transform duration-300 shadow-2xl custom-scrollbar">
        <button id="close-quote-modal" class="absolute top-4 right-4 text-gray-400 hover:text-white z-10 bg-zinc-900/80 rounded-full">
            <span class="material-symbols-outlined text-3xl">close</span>
        </button>
        <h3 class="text-2xl md:text-3xl font-black text-white uppercase tracking-tight mb-2 pr-8">Request Bulk Quote</h3>
        <p class="text-gray-400 mb-6 text-sm md:text-base">Fill out the details below and our industrial procurement team will contact you within 4 hours.</p>
        <div class="cf7-container text-white">
            <style>
                .custom-scrollbar::-webkit-scrollbar { width: 6px; }
                .custom-scrollbar::-webkit-scrollbar-track { background: #18181b; }
                .custom-scrollbar::-webkit-scrollbar-thumb { background: #FBBF24; border-radius: 10px; }
                .cf7-container input, .cf7-container textarea { width: 100%; background: #18181b; border: 1px solid #27272a; color: white; padding: 0.75rem; margin-bottom: 0.75rem; border-radius: 0.125rem; font-size: 0.95rem; }
                .cf7-container input:focus, .cf7-container textarea:focus { border-color: #FBBF24; outline: none; box-shadow: 0 0 0 2px rgba(251, 191, 36, 0.1); }
                .cf7-container input.wpcf7-submit { background-color: #FBBF24 !important; color: black !important; font-weight: 900 !important; text-transform: uppercase !important; width: 100% !important; padding: 1rem !important; margin-top: 1rem !important; border: none !important; cursor: pointer !important; transition: background-color 0.2s !important; }
                .cf7-container input.wpcf7-submit:hover { background-color: #eab308 !important; }
                .cf7-container br { display: none; }
                .wpcf7-spinner { display: none; }
                .wpcf7-not-valid-tip { color: #ef4444; font-size: 0.75rem; margin-top: -0.5rem; margin-bottom: 0.5rem; display: block; font-weight: 600; }
                .wpcf7-response-output { border: 2px solid #FBBF24 !important; color: #FBBF24 !important; font-weight: 700 !important; text-transform: uppercase !important; font-size: 0.8rem !important; margin-top: 1rem !important; padding: 1rem !important; text-align: center; }
            </style>
            <?php
            $cf7_form_id = get_transient('snap_bulk_quote_cf7_id');
            if ( false === $cf7_form_id ) {
                $cf7_form = get_page_by_title('Bulk Quote Form', OBJECT, 'wpcf7_contact_form');
                if ( $cf7_form ) {
                    $cf7_form_id = $cf7_form->ID;
                    set_transient('snap_bulk_quote_cf7_id', $cf7_form_id, DAY_IN_SECONDS);
                } else {
                    $cf7_form_id = -1;
                    set_transient('snap_bulk_quote_cf7_id', $cf7_form_id, HOUR_IN_SECONDS);
                }
            }
            
            if($cf7_form_id > 0) {
                echo do_shortcode('[contact-form-7 id="'.$cf7_form_id.'" title="Bulk Quote Form"]');
            } else {
                echo '<p>Form not found. Please create "Bulk Quote Form" in CF7.</p>';
            }
            ?>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('quote-modal');
    const closeBtn = document.getElementById('close-quote-modal');

    function openModal(e) {
        if(e) e.preventDefault();
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        void modal.offsetWidth;
        modal.classList.remove('opacity-0');
        modal.querySelector('.bg-zinc-900').classList.remove('scale-95');
        document.body.classList.add('modal-active');
    }

    function closeModal() {
        modal.classList.add('opacity-0');
        modal.querySelector('.bg-zinc-900').classList.add('scale-95');
        document.body.classList.remove('modal-active');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    }

    // Event delegation for all quote triggers (supports dynamic and multi-SKU prefill)
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.js-open-quote-modal');
        if (btn) {
            e.preventDefault();
            const prodName = btn.dataset.productName || btn.getAttribute('data-product') || '';
            const prodSku = btn.dataset.productSku || btn.getAttribute('data-sku') || '';
            const customMsg = btn.dataset.customMessage || '';
            const msgField = modal.querySelector('textarea[name="your-message"]');
            if (msgField) {
                if (customMsg) {
                    msgField.value = customMsg;
                } else if (prodName || prodSku) {
                    msgField.value = "Bulk Inquiry for Model:\nProduct: " + prodName + "\nModel/SKU: " + prodSku + "\nEstimated Quantity:\nDelivery City / Location:";
                }
            }
            openModal();
        }
    });

    if(closeBtn) closeBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', (e) => {
        if(e.target === modal) closeModal();
    });

    // Scroll-reveal animation (shared)
    const revealEls = document.querySelectorAll('.reveal');
    const revealObs = new IntersectionObserver((entries) => {
        entries.forEach((entry, i) => {
            if (entry.isIntersecting) {
                setTimeout(() => entry.target.classList.add('visible'), i * 80);
                revealObs.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });
    revealEls.forEach(el => revealObs.observe(el));

    // Counter Animation Logic (shared)
    const counters = document.querySelectorAll('.counter, .js-counter');
    const animationDuration = 2000;

    const animateCounter = (counter) => {
        const target = +counter.getAttribute('data-target');
        const suffix = counter.hasAttribute('data-suffix') 
            ? counter.getAttribute('data-suffix') 
            : (target > 100 ? '+' : '');
        const startTime = performance.now();
        const updateCounter = (currentTime) => {
            const elapsedTime = currentTime - startTime;
            if (elapsedTime < animationDuration) {
                const progress = elapsedTime / animationDuration;
                const easeOut = 1 - Math.pow(1 - progress, 3);
                counter.innerText = Math.ceil(easeOut * target) + suffix;
                requestAnimationFrame(updateCounter);
            } else {
                counter.innerText = target + suffix;
            }
        };
        requestAnimationFrame(updateCounter);
    };

    const counterObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(counter => counterObserver.observe(counter));

    // CF7 Submit Button Hotfix
    document.addEventListener('wpcf7init', () => {
        const submitBtn = document.querySelector('.wpcf7-submit');
        if(submitBtn) {
            submitBtn.classList.remove('hoverbg-yellow-500');
            submitBtn.classList.add('hover:bg-yellow-500');
        }
    });
});
</script>

<!-- Entry Popup -->
<div id="entry-popup" class="fixed inset-0 z-[1000000] hidden items-center justify-center bg-black/80 backdrop-blur-sm transition-opacity duration-300">
    <div class="bg-white p-8 max-w-2xl w-full mx-4 shadow-2xl relative text-center">
        <h2 class="text-3xl font-black text-[#0A0A0A] mb-2 uppercase tracking-tight">Welcome to the corporate website of Snap Marketing</h2>
        <div class="flex flex-col md:flex-row gap-4 justify-center mt-8">
            <div class="flex-1 border-2 border-gray-100 p-6 hover:border-[#1A56DB] transition-colors cursor-pointer js-select-business flex flex-col items-center">
                <span class="material-symbols-outlined text-4xl text-[#1A56DB] mb-3">domain</span>
                <h3 class="text-xl font-bold mb-2">Are you a Business?</h3>
                <p class="text-sm text-gray-500 mb-6 flex-1">Click here to stay on this site.</p>
                <button class="bg-[#FBBF24] text-black px-6 py-3 font-bold w-full uppercase tracking-wider text-sm hover:bg-yellow-500 transition-colors">Business</button>
            </div>
            <div class="flex-1 border-2 border-gray-100 p-6 hover:border-[#1A56DB] transition-colors cursor-pointer js-select-consumer flex flex-col items-center">
                <span class="material-symbols-outlined text-4xl text-[#1A56DB] mb-3">shopping_cart</span>
                <h3 class="text-xl font-bold mb-2">Are you a Consumer?</h3>
                <p class="text-sm text-gray-500 mb-6 flex-1">Click here for our e-commerce site.</p>
                <button class="bg-[#1A56DB] text-white px-6 py-3 font-bold w-full uppercase tracking-wider text-sm hover:bg-blue-700 transition-colors">Consumer</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const entryPopup = document.getElementById('entry-popup');
    const isConsumerPage = window.location.pathname.includes('/shop');
    
    if (entryPopup) {
        if (!localStorage.getItem('snap_user_type') && !localStorage.getItem('bluestar_user_type')) {
            entryPopup.classList.remove('hidden');
            entryPopup.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        const setPreference = (e, type) => {
            if (e) e.preventDefault();
            localStorage.setItem('snap_user_type', type);
            localStorage.setItem('bluestar_user_type', type);
            if (type === 'business') {
                if (isConsumerPage) {
                    window.location.href = '/'; 
                } else {
                    entryPopup.classList.add('hidden');
                    entryPopup.classList.remove('flex');
                    document.body.style.overflow = 'auto';
                }
            } else if (type === 'consumer') {
                if (!isConsumerPage) {
                    window.location.href = '/consumer/';
                } else {
                    entryPopup.classList.add('hidden');
                    entryPopup.classList.remove('flex');
                    document.body.style.overflow = 'auto';
                }
            }
        };

        document.querySelectorAll('.js-select-business').forEach(el => {
            el.addEventListener('click', (e) => setPreference(e, 'business'));
        });
        document.querySelectorAll('.js-select-consumer').forEach(el => {
            el.addEventListener('click', (e) => setPreference(e, 'consumer'));
        });
    }
});
</script>

<?php wp_footer(); ?>
</body>
</html>