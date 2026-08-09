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
                <li><a class="text-zinc-400 hover:text-white transition-colors block font-medium text-lg" href="/about-us">About Us</a></li>
                <li><a class="text-zinc-400 hover:text-white transition-colors block font-medium text-lg" href="/request-a-quote">Request Bulk Quote</a></li>
                <li><a class="text-zinc-400 hover:text-white transition-colors block font-medium text-lg" href="/order-tracking">Order Tracking</a></li>
                <li><a class="text-zinc-400 hover:text-white transition-colors block font-medium text-lg" href="/my-account">My Account / Login</a></li>
                <li><a class="text-zinc-400 hover:text-white transition-colors block font-medium text-lg" href="/terms-of-service">Terms of Service</a></li>
                <li><a class="text-zinc-400 hover:text-white transition-colors block font-medium text-lg" href="/privacy-policy">Privacy Policy</a></li>
            </ul>
        </div>
        <div>
            <h4 class="text-secondary-container font-black uppercase mb-8 tracking-tighter">Major Categories</h4>
            <ul class="space-y-4">
                <li><a class="text-zinc-400 hover:text-white transition-colors block font-medium text-lg" href="/product-category/commercial-refrigeration/">Refrigeration</a></li>
                <li><a class="text-zinc-400 hover:text-white transition-colors block font-medium text-lg" href="/product-category/water-purifiers/">Water Treatment</a></li>
                <li><a class="text-zinc-400 hover:text-white transition-colors block font-medium text-lg" href="/product-category/washroom-automations/">Washroom Tech</a></li>
                <li><a class="text-zinc-400 hover:text-white transition-colors block font-medium text-lg" href="/product-category/hygiene-ppe/">Safety Gear</a></li>
                <li><a class="text-zinc-400 hover:text-white transition-colors block font-medium text-lg" href="/product-category/entrance-solutions/">Entrance Solutions</a></li>
                <li><a class="text-zinc-400 hover:text-white transition-colors block font-medium text-lg" href="/product-category/vending-machines/">Vending Machines</a></li>
            </ul>
        </div>
        <div class="space-y-6">
            <h4 class="text-secondary-container font-black uppercase mb-8 tracking-tighter">Contact Us</h4>
            <div class="flex gap-4 items-start">
                <span class="material-symbols-outlined text-secondary-container">location_on</span>
                <p class="font-medium text-lg text-zinc-400">Snap House, Plot No. 322/16, Ghorpade Peth, Pune, Maharashtra 411042</p>
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
    <div class="px-12 py-8 bg-zinc-950 flex flex-col md:flex-row justify-between items-center text-sm font-bold uppercase tracking-widest text-gray-500 border-t border-white/5">
        <div>© <?php echo date('Y'); ?> Snap Marketing. All Rights Reserved. Pune, India.</div>
        <div class="mt-4 md:mt-0">Precision. Scale. Authority.</div>
    </div>
</footer>

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

    // Robust selector for all quote triggers
    const quoteButtons = document.querySelectorAll('.js-open-quote-modal');
    quoteButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            openModal();
        });
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
        <h2 class="text-3xl font-black text-[#0A0A0A] mb-2 uppercase tracking-tight">Welcome to the corporate website of Blue Star Limited</h2>
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
        if (!localStorage.getItem('bluestar_user_type')) {
            entryPopup.classList.remove('hidden');
            entryPopup.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        const setPreference = (e, type) => {
            if (e) e.preventDefault();
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