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
            <p class="font-medium text-lg text-zinc-400 leading-relaxed">Defining the standard in industrial B2B equipment distribution since 1999.</p>
            <div class="flex gap-4">
                <a href="#" class="w-10 h-10 bg-primary-container flex items-center justify-center hover:bg-secondary-container hover:text-black hover:-translate-y-1 active:scale-95 transition-all duration-300">
                    <span class="material-symbols-outlined text-primary text-sm">link</span>
                </a>
                <a href="#" class="w-10 h-10 bg-primary-container flex items-center justify-center hover:bg-secondary-container hover:text-black hover:-translate-y-1 active:scale-95 transition-all duration-300">
                    <span class="material-symbols-outlined text-primary text-sm">link</span>
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
                <p class="font-medium text-lg text-zinc-400">Snap Marketing HQ, Industrial Estate, Pune, Maharashtra 411013</p>
            </div>
            <div class="flex gap-4 items-center">
                <span class="material-symbols-outlined text-secondary-container">call</span>
                <p class="font-medium text-lg text-zinc-400">+91 (20) 2445-8899</p>
            </div>
            <div class="flex gap-4 items-center">
                <span class="material-symbols-outlined text-secondary-container">email</span>
                <p class="font-medium text-lg text-zinc-400">sales@snapmarketing.in</p>
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
            $cf7_form = get_page_by_title('Bulk Quote Form', OBJECT, 'wpcf7_contact_form');
            if($cf7_form) {
                echo do_shortcode('[contact-form-7 id="'.$cf7_form->ID.'" title="Bulk Quote Form"]');
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

<?php if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) : ?>
<!-- Agentation Visual Feedback Tool -->
<script type="module" crossorigin="anonymous">
  import React from 'https://esm.sh/react@18.3.1';
  import { createRoot } from 'https://esm.sh/react-dom@18.3.1/client';
  import { Agentation } from 'https://esm.sh/agentation@latest?deps=react@18.3.1';

  function initAgentation() {
    try {
      const container = document.createElement('div');
      container.id = 'agentation-root';
      document.body.appendChild(container);
      const root = createRoot(container);
      root.render(React.createElement(Agentation));
    } catch (err) {
      console.error('Agentation Failed:', err);
    }
  }

  if (document.readyState === 'complete') {
    initAgentation();
  } else {
    window.addEventListener('load', initAgentation);
  }
</script>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>