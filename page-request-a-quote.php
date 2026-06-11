<?php
/**
 * Template Name: Request Bulk Quote
 */

get_header(); ?>

<!-- Override global text/bg for this specific page to enforce Industrial Authority design -->
<style>
    /* Industrial Authority Overrides */
    body {
        background-color: #131313 !important;
        color: #e5e2e1 !important;
        font-family: 'Inter', sans-serif !important;
    }
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        display: inline-block;
        vertical-align: middle;
    }
    /* Custom Industrial Scrollbar */
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: #131313; }
    ::-webkit-scrollbar-thumb { background: #434654; border: 2px solid #131313; }
    ::-webkit-scrollbar-thumb:hover { background: #1a56db; }

    .industrial-grid-overlay {
        background-image: linear-gradient(#1e293b 1px, transparent 1px), linear-gradient(90deg, #1e293b 1px, transparent 1px);
        background-size: 24px 24px;
        opacity: 0.1;
    }
</style>

<main class="pt-24 lg:pt-32 relative overflow-hidden min-h-screen bg-[#131313]">
    <div class="absolute inset-0 industrial-grid-overlay pointer-events-none"></div>
    
    <!-- Hero Section -->
    <section class="relative bg-[#ffc640] px-6 py-12 md:px-16 md:py-24 border-b-4 border-[#e5e2e1] overflow-hidden">
        <div class="absolute right-[-10%] top-[-10%] opacity-10 pointer-events-none">
            <span class="material-symbols-outlined text-[300px] leading-none text-black" data-icon="inventory_2" style="font-variation-settings: 'FILL' 1;">inventory_2</span>
        </div>
        <div class="relative z-10 max-w-4xl">
            <h1 class="font-headline text-4xl md:text-5xl lg:text-7xl font-black text-[#131313] uppercase leading-none tracking-tighter mb-4" style="font-family: 'Inter', sans-serif;">
                REQUEST INDUSTRIAL QUOTE
            </h1>
            <div class="bg-[#131313] inline-block px-4 py-2 border-l-4 border-[#1a56db]">
                <p class="font-mono text-sm md:text-base text-[#b5c4ff] uppercase tracking-widest" style="font-family: 'Space Grotesk', sans-serif;">
                    High-Volume Procurement Control Center
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content Grid -->
    <div class="flex flex-col lg:grid lg:grid-cols-12 w-full max-w-[1920px] mx-auto">
        <!-- Form Section -->
        <section class="lg:col-span-8 border-b-4 lg:border-b-0 lg:border-r-4 border-[#e5e2e1] bg-[#131313] p-6 md:p-8 lg:p-16">
            <form id="industrial-quote-form" class="space-y-8 max-w-2xl">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Full Name -->
                    <div class="group">
                        <label class="block font-mono text-sm uppercase text-[#c3c5d7] mb-2 group-focus-within:text-[#ffc640] transition-colors">Full Name</label>
                        <input name="your-name" required class="w-full bg-[#131313] border-0 border-b-4 border-[#3c475a] focus:ring-0 focus:border-[#1a56db] text-[#e5e2e1] font-mono placeholder:text-[#c3c5d7]/30 px-0 py-3 uppercase rounded-none" placeholder="ENTER NAME" type="text"/>
                    </div>
                    <!-- Company Name -->
                    <div class="group">
                        <label class="block font-mono text-sm uppercase text-[#c3c5d7] mb-2 group-focus-within:text-[#ffc640] transition-colors">Company Name</label>
                        <input name="your-company" required class="w-full bg-[#131313] border-0 border-b-4 border-[#3c475a] focus:ring-0 focus:border-[#1a56db] text-[#e5e2e1] font-mono placeholder:text-[#c3c5d7]/30 px-0 py-3 uppercase rounded-none" placeholder="ENTER ENTITY" type="text"/>
                    </div>
                    <!-- Work Email -->
                    <div class="group">
                        <label class="block font-mono text-sm uppercase text-[#c3c5d7] mb-2 group-focus-within:text-[#ffc640] transition-colors">Work Email</label>
                        <input name="your-email" required class="w-full bg-[#131313] border-0 border-b-4 border-[#3c475a] focus:ring-0 focus:border-[#1a56db] text-[#e5e2e1] font-mono placeholder:text-[#c3c5d7]/30 px-0 py-3 uppercase rounded-none" placeholder="EMAIL@CORPORATE.IND" type="email"/>
                    </div>
                    <!-- Phone Number -->
                    <div class="group">
                        <label class="block font-mono text-sm uppercase text-[#c3c5d7] mb-2 group-focus-within:text-[#ffc640] transition-colors">Phone Number</label>
                        <input name="your-phone" required class="w-full bg-[#131313] border-0 border-b-4 border-[#3c475a] focus:ring-0 focus:border-[#1a56db] text-[#e5e2e1] font-mono placeholder:text-[#c3c5d7]/30 px-0 py-3 uppercase rounded-none" placeholder="+91 XXXXX XXXXX" type="tel"/>
                    </div>
                </div>
                <!-- Product Categories -->
                <div class="group">
                    <label class="block font-mono text-sm uppercase text-[#c3c5d7] mb-2 group-focus-within:text-[#ffc640] transition-colors">Product Categories</label>
                    <select name="product-category" required class="w-full bg-[#131313] border-0 border-b-4 border-[#3c475a] focus:ring-0 focus:border-[#1a56db] text-[#e5e2e1] font-mono px-0 py-3 uppercase appearance-none rounded-none">
                        <option value="">SELECT CATEGORY</option>
                        <option value="Commercial Refrigeration">Commercial Refrigeration</option>
                        <option value="Washroom Automation">Washroom Automation</option>
                        <option value="Hygiene & PPE">Hygiene & PPE</option>
                        <option value="Vending Systems">Vending Systems</option>
                    </select>
                </div>
                <!-- Expected Volume -->
                <div class="group">
                    <label class="block font-mono text-sm uppercase text-[#c3c5d7] mb-2 group-focus-within:text-[#ffc640] transition-colors">Expected Volume</label>
                    <select name="expected-volume" required class="w-full bg-[#131313] border-0 border-b-4 border-[#3c475a] focus:ring-0 focus:border-[#1a56db] text-[#e5e2e1] font-mono px-0 py-3 uppercase appearance-none rounded-none">
                        <option value="50-100 UNITS">50-100 UNITS</option>
                        <option value="100-500 UNITS">100-500 UNITS</option>
                        <option value="500+ UNITS">500+ UNITS</option>
                    </select>
                </div>
                <!-- Additional Requirements -->
                <div class="group">
                    <label class="block font-mono text-sm uppercase text-[#c3c5d7] mb-2 group-focus-within:text-[#ffc640] transition-colors">Additional Requirements</label>
                    <textarea name="additional-requirements" class="w-full bg-[#131313] border-0 border-b-4 border-[#3c475a] focus:ring-0 focus:border-[#1a56db] text-[#e5e2e1] font-mono placeholder:text-[#c3c5d7]/30 px-0 py-3 uppercase resize-none rounded-none" placeholder="SPECIFY TECHNICAL REQUIREMENTS OR LOGISTICS CONSTRAINTS..." rows="4"></textarea>
                </div>
                <!-- Submit Button -->
                <button id="quote-submit-btn" class="w-full bg-[#ffc640] text-[#131313] font-headline text-xl md:text-2xl font-bold uppercase py-6 hover:bg-[#e5e2e1] hover:text-[#131313] active:scale-[0.98] transition-all flex items-center justify-center gap-3 rounded-none" type="submit">
                    GENERATE QUOTE REQUEST
                    <span class="material-symbols-outlined" data-icon="arrow_forward">arrow_forward</span>
                </button>
                <div id="quote-form-message" class="hidden font-mono text-sm p-4 border-2 uppercase"></div>
            </form>
        </section>

        <!-- Trust & Contact Sidebar -->
        <aside class="lg:col-span-4 bg-[#201f1f] flex flex-col">
            <!-- Image Display -->
            <div class="relative h-64 lg:h-80 border-b-4 border-[#e5e2e1] overflow-hidden">
                <img alt="Industrial Facility" class="w-full h-full object-cover grayscale brightness-50 contrast-125" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDnAtJjJnPbbex592esXQvU54f2q349Uv5L9ZE5N7JCAOy3lrUnqkRSV8C4Ms5-DvA2MSqg1YdctjtiEiOksWF4-vzdcJTCP2goUwDwkBbSa4_R-X7p_Z9k9bM6jNVLOn4Zy6P_9c1NRB_SXC1Lipm1aB0uKQDOrRLodWo6VTl9jesIsiHu992cKU74D9lEmIb2KKTAKRMgNCifCmmPN0tUPIsZXmx1UTGXhlxH1fFLSQWpuZTSmYyZ4VbRux7-P5nRe2kPx6v-dig"/>
                <div class="absolute bottom-4 left-4 bg-[#1a56db] px-3 py-1 font-mono text-xs text-white uppercase">
                    FACILITY ID: SN-IND-04
                </div>
            </div>
            
            <div class="p-6 md:p-8 space-y-12 text-[#e5e2e1]">
                <!-- Contact Section -->
                <div class="space-y-6">
                    <h3 class="font-mono text-sm uppercase text-[#ffc640] tracking-widest border-b border-[#ffc640]/30 pb-2">Direct Procurement Line</h3>
                    
                    <div class="flex items-center gap-4 group cursor-pointer">
                        <div class="bg-[#3c475a] p-3 border-2 border-[#e5e2e1] group-hover:bg-[#1a56db] transition-colors">
                            <span class="material-symbols-outlined text-[#e5e2e1]" data-icon="call">call</span>
                        </div>
                        <div>
                            <p class="font-headline text-lg font-black tracking-tighter text-[#e5e2e1]">+1 (555) 900-SNAP</p>
                            <p class="font-mono text-xs text-[#c3c5d7]">AVAILABLE 24/7 FOR ENTERPRISE</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4 group cursor-pointer">
                        <div class="bg-[#3c475a] p-3 border-2 border-[#e5e2e1] group-hover:bg-[#1a56db] transition-colors">
                            <span class="material-symbols-outlined text-[#e5e2e1]" data-icon="mail">mail</span>
                        </div>
                        <div>
                            <p class="font-headline text-lg font-black tracking-tighter text-[#e5e2e1]">SUPPLY@SNAPMARKETING.IND</p>
                            <p class="font-mono text-xs text-[#c3c5d7]">AVERAGE RESPONSE: 14 MINS</p>
                        </div>
                    </div>
                </div>
                
                <!-- Trust Badges -->
                <div class="space-y-4">
                    <h3 class="font-mono text-sm uppercase text-[#ffc640] tracking-widest border-b border-[#ffc640]/30 pb-2">Certifications &amp; Network</h3>
                    
                    <div class="border-2 border-[#e5e2e1] p-4 flex items-center gap-4 bg-[#131313]">
                        <span class="material-symbols-outlined text-[#b5c4ff] text-3xl" data-icon="verified" style="font-variation-settings: 'FILL' 1;">verified</span>
                        <div>
                            <p class="font-mono text-sm font-bold uppercase">ISO 9001:2015 CERTIFIED</p>
                            <p class="font-mono text-xs text-[#c3c5d7]">Quality Management Protocol</p>
                        </div>
                    </div>
                    
                    <div class="border-2 border-[#e5e2e1] p-4 flex items-center gap-4 bg-[#131313]">
                        <span class="material-symbols-outlined text-[#b5c4ff] text-3xl" data-icon="local_shipping" style="font-variation-settings: 'FILL' 1;">local_shipping</span>
                        <div>
                            <p class="font-mono text-sm font-bold uppercase">PAN-INDIA LOGISTICS</p>
                            <p class="font-mono text-xs text-[#c3c5d7]">Tier-1 Distribution Network</p>
                        </div>
                    </div>
                    
                    <div class="border-2 border-[#e5e2e1] p-4 flex items-center gap-4 bg-[#131313]">
                        <span class="material-symbols-outlined text-[#b5c4ff] text-3xl" data-icon="precision_manufacturing" style="font-variation-settings: 'FILL' 1;">precision_manufacturing</span>
                        <div>
                            <p class="font-mono text-sm font-bold uppercase">AUTHORIZED ENTERPRISE PARTNER</p>
                            <p class="font-mono text-xs text-[#c3c5d7]">Direct OEM Supply Chain Access</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('industrial-quote-form');
    const btn = document.getElementById('quote-submit-btn');
    const msgBox = document.getElementById('quote-form-message');

    // Debounce function for partial capture
    let timeoutId;
    function capturePartialData() {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            const formData = new FormData(form);
            const data = {};
            formData.forEach((value, key) => (data[key] = value));
            
            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    action: 'snap_capture_lead',
                    form_data: JSON.stringify(data)
                })
            });
        }, 1000);
    }

    // Attach partial capture to all inputs
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('input', capturePartialData);
        input.addEventListener('change', capturePartialData);
    });

    // Handle final submission
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const originalText = btn.innerHTML;
        btn.innerHTML = 'PROCESSING TRANSMISSION...';
        btn.classList.add('opacity-50', 'pointer-events-none');
        
        const formData = new FormData(form);
        const data = {};
        formData.forEach((value, key) => (data[key] = value));

        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                action: 'snap_capture_final_quote',
                form_data: JSON.stringify(data)
            })
        })
        .then(response => response.json())
        .then(result => {
            btn.innerHTML = 'REQUEST TRANSMITTED';
            btn.classList.remove('bg-[#ffc640]', 'text-[#131313]');
            btn.classList.add('bg-[#1a56db]', 'text-white');
            
            msgBox.classList.remove('hidden', 'border-red-500', 'text-red-500');
            msgBox.classList.add('border-[#1a56db]', 'text-[#b5c4ff]');
            msgBox.textContent = result.data.message || 'Submission successful. We will be in touch.';
            
            form.reset();
        })
        .catch(error => {
            btn.innerHTML = originalText;
            btn.classList.remove('opacity-50', 'pointer-events-none');
            
            msgBox.classList.remove('hidden', 'border-[#1a56db]', 'text-[#b5c4ff]');
            msgBox.classList.add('border-red-500', 'text-red-500');
            msgBox.textContent = 'TRANSMISSION FAILED. PLEASE TRY AGAIN OR CALL SUPPORT.';
        });
    });
});
</script>

<?php get_footer(); ?>