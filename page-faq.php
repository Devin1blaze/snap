<?php
/**
 * Template Name: FAQ Page
 * Description: Dedicated FAQ and Knowledge Base template with interactive accordion search and FAQPage JSON-LD schema.
 */

get_header(); ?>

<!-- FAQ Hero Section -->
<section class="w-full bg-[#1A56DB] pt-[88px] py-20 md:py-28 px-6 md:px-8 relative overflow-hidden">
    <div class="absolute -right-20 -bottom-20 w-96 h-96 bg-[#FBBF24] opacity-10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="max-w-6xl mx-auto relative z-10">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-white/80 text-xs md:text-sm font-semibold mb-6 uppercase tracking-wider">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-[#FBBF24] transition-colors">Home</a>
            <span class="text-[#FBBF24]">/</span>
            <span class="text-white">Help & FAQ</span>
        </nav>

        <div class="inline-block bg-[#FBBF24] text-[#0A0A0A] text-xs font-black uppercase tracking-widest px-4 py-1.5 mb-6">
            Official Knowledge Base
        </div>

        <h1 class="text-white text-4xl sm:text-5xl md:text-7xl font-black tracking-tighter leading-tight mb-6 max-w-4xl">
            Frequently Asked Questions
        </h1>
        <p class="text-[#FBBF24] text-lg sm:text-xl md:text-2xl font-bold max-w-3xl mb-10 leading-relaxed">
            Everything you need to know about Blue Star products, residential AC sizing, commercial refrigeration, bulk B2B pricing, warranty, and delivery.
        </p>

        <!-- Live Instant Search Bar -->
        <div class="max-w-2xl relative">
            <div class="relative flex items-center shadow-2xl">
                <span class="material-symbols-outlined absolute left-5 text-gray-400 text-2xl pointer-events-none">search</span>
                <input 
                    type="text" 
                    id="faq-search-input" 
                    placeholder="Search any question (e.g., 'warranty', 'tonnage', '3-star', 'bulk discount')..." 
                    class="w-full pl-14 pr-12 py-4 sm:py-5 bg-white text-[#0A0A0A] font-semibold text-base sm:text-lg focus:outline-none focus:ring-4 focus:ring-[#FBBF24] transition-all border-0 shadow-lg placeholder-gray-400"
                    aria-label="Search FAQs"
                />
                <button id="faq-search-clear" class="hidden absolute right-4 text-gray-400 hover:text-[#0A0A0A] font-bold text-sm bg-gray-100 hover:bg-gray-200 px-2 py-1 rounded" title="Clear search">
                    ✕
                </button>
            </div>
            <p id="faq-search-count" class="text-white/80 text-xs font-semibold mt-2 pl-2 tracking-wide hidden"></p>
        </div>
    </div>
</section>

<!-- Category Filter Pills Bar -->
<section class="bg-[#0A0A0A] border-b border-zinc-800 sticky top-0 z-30 px-6 py-4 shadow-md">
    <div class="max-w-6xl mx-auto flex items-center gap-2 sm:gap-3 overflow-x-auto pb-1 no-scrollbar text-xs md:text-sm">
        <button class="faq-filter-btn active whitespace-nowrap px-4 py-2 font-black uppercase tracking-wider transition-all bg-[#FBBF24] text-black" data-category="all">
            All Questions
        </button>
        <button class="faq-filter-btn whitespace-nowrap px-4 py-2 font-black uppercase tracking-wider transition-all bg-zinc-900 text-gray-300 hover:bg-zinc-800 hover:text-white" data-category="general">
            Dealership & Trust
        </button>
        <button class="faq-filter-btn whitespace-nowrap px-4 py-2 font-black uppercase tracking-wider transition-all bg-zinc-900 text-gray-300 hover:bg-zinc-800 hover:text-white" data-category="residential">
            Residential ACs (B2C)
        </button>
        <button class="faq-filter-btn whitespace-nowrap px-4 py-2 font-black uppercase tracking-wider transition-all bg-zinc-900 text-gray-300 hover:bg-zinc-800 hover:text-white" data-category="commercial">
            Commercial Refrigeration (B2B)
        </button>
        <button class="faq-filter-btn whitespace-nowrap px-4 py-2 font-black uppercase tracking-wider transition-all bg-zinc-900 text-gray-300 hover:bg-zinc-800 hover:text-white" data-category="washroom">
            Hygiene & Washroom Tech
        </button>
        <button class="faq-filter-btn whitespace-nowrap px-4 py-2 font-black uppercase tracking-wider transition-all bg-zinc-900 text-gray-300 hover:bg-zinc-800 hover:text-white" data-category="orders">
            Orders, GST & Warranty
        </button>
    </div>
</section>

<!-- Main FAQ Content -->
<main class="bg-[#F4F4F5] py-16 md:py-24 px-6 md:px-8 min-h-[600px]">
    <div class="max-w-5xl mx-auto">
        
        <div id="faq-no-results" class="hidden text-center py-16 bg-white border-2 border-dashed border-gray-300 p-8">
            <span class="material-symbols-outlined text-gray-400 text-6xl mb-4">help_outline</span>
            <h3 class="text-2xl font-black text-[#0A0A0A] uppercase tracking-tight mb-2">No matching questions found</h3>
            <p class="text-gray-600 mb-6 max-w-md mx-auto">We couldn't find an exact match for your search term. Feel free to contact our support desk directly.</p>
            <a href="https://wa.me/919823012724" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 bg-[#FBBF24] text-[#0A0A0A] px-6 py-3 font-black text-sm uppercase tracking-wider hover:bg-black hover:text-[#FBBF24] transition-all">
                <span class="material-symbols-outlined text-lg">chat</span>
                Ask on WhatsApp
            </a>
        </div>

        <div id="faq-accordion-list" class="space-y-6">

            <!-- Category: General & Dealership -->
            <div class="faq-category-header" data-category="general">
                <h2 class="text-2xl font-black text-[#0A0A0A] uppercase tracking-tight flex items-center gap-3 pt-4 mb-4 border-b-2 border-[#1A56DB] pb-2">
                    <span class="w-3 h-3 bg-[#1A56DB]"></span>
                    Authorized Dealership & About Snap Marketing
                </h2>
            </div>

            <!-- Q1 -->
            <div class="faq-item bg-white border-l-4 border-[#1A56DB] shadow-md transition-all hover:shadow-lg" data-category="general">
                <button class="faq-toggle w-full text-left p-6 flex justify-between items-center gap-4 focus:outline-none focus:ring-2 focus:ring-[#1A56DB]" aria-expanded="false">
                    <span class="text-lg md:text-xl font-black text-[#0A0A0A] tracking-tight">
                        Is Snap Marketing an authorized Blue Star dealer in Pune and Maharashtra?
                    </span>
                    <span class="faq-icon-wrapper w-8 h-8 rounded-full bg-[#1A56DB]/10 text-[#1A56DB] flex items-center justify-center flex-shrink-0 transition-transform duration-300">
                        <span class="material-symbols-outlined text-2xl font-bold faq-icon">expand_more</span>
                    </span>
                </button>
                <div class="faq-content hidden px-6 pb-6 text-gray-700 font-medium leading-relaxed border-t border-gray-100 pt-4">
                    <p class="mb-3">
                        <strong>Yes, 100%.</strong> Snap Marketing (Snap House) is an <strong>authorized channel partner and master distributor for Blue Star Limited</strong>, operating in Pune, Maharashtra with continuous operations since 1988.
                    </p>
                    <p class="mb-3">
                        Every Blue Star product purchased through Snap Marketing carries genuine factory serial numbers, valid 100% manufacturer warranties, and direct on-site authorized technician installation and service privileges.
                    </p>
                    <div class="bg-blue-50 border-l-2 border-[#1A56DB] p-3 text-sm text-[#1A56DB] font-semibold">
                        Registered Office & Showroom: Snap House, 322/16, Shankar Sheth Road, Near Indian Oil Petrol Pump, Hotel 7 Loves Chowk, Ghorpadi Peth, Pune - 411042, Maharashtra, India. Phone: +91 98230 12724.
                    </div>
                </div>
            </div>

            <!-- Q2 -->
            <div class="faq-item bg-white border-l-4 border-[#1A56DB] shadow-md transition-all hover:shadow-lg" data-category="general">
                <button class="faq-toggle w-full text-left p-6 flex justify-between items-center gap-4 focus:outline-none focus:ring-2 focus:ring-[#1A56DB]" aria-expanded="false">
                    <span class="text-lg md:text-xl font-black text-[#0A0A0A] tracking-tight">
                        Do you cater to both individual homeowners (B2C) and large enterprises (B2B)?
                    </span>
                    <span class="faq-icon-wrapper w-8 h-8 rounded-full bg-[#1A56DB]/10 text-[#1A56DB] flex items-center justify-center flex-shrink-0 transition-transform duration-300">
                        <span class="material-symbols-outlined text-2xl font-bold faq-icon">expand_more</span>
                    </span>
                </button>
                <div class="faq-content hidden px-6 pb-6 text-gray-700 font-medium leading-relaxed border-t border-gray-100 pt-4">
                    <p class="mb-3">
                        <strong>Yes.</strong> We serve both customer segments with dedicated divisions:
                    </p>
                    <ul class="list-disc pl-5 space-y-2 mb-3">
                        <li><strong>Consumer Division (B2C):</strong> Individual homeowners, apartments, and villas looking for high-efficiency inverter air conditioners, water purifiers, and home cooling appliances with direct-to-door delivery.</li>
                        <li><strong>Commercial & Enterprise Division (B2B):</strong> Hospitals, IT parks, cold storages, dairy & food processing units, hotels, educational institutions, and corporate facilities needing multi-unit air conditioning, deep freezers, visi coolers, water coolers, and washroom automation solutions.</li>
                    </ul>
                </div>
            </div>

            <!-- Category: Residential ACs -->
            <div class="faq-category-header" data-category="residential">
                <h2 class="text-2xl font-black text-[#0A0A0A] uppercase tracking-tight flex items-center gap-3 pt-6 mb-4 border-b-2 border-[#1A56DB] pb-2">
                    <span class="w-3 h-3 bg-[#1A56DB]"></span>
                    Residential Air Conditioners (B2C)
                </h2>
            </div>

            <!-- Q3 -->
            <div class="faq-item bg-white border-l-4 border-[#1A56DB] shadow-md transition-all hover:shadow-lg" data-category="residential">
                <button class="faq-toggle w-full text-left p-6 flex justify-between items-center gap-4 focus:outline-none focus:ring-2 focus:ring-[#1A56DB]" aria-expanded="false">
                    <span class="text-lg md:text-xl font-black text-[#0A0A0A] tracking-tight">
                        How do I choose between a 3-Star and a 5-Star Inverter Air Conditioner?
                    </span>
                    <span class="faq-icon-wrapper w-8 h-8 rounded-full bg-[#1A56DB]/10 text-[#1A56DB] flex items-center justify-center flex-shrink-0 transition-transform duration-300">
                        <span class="material-symbols-outlined text-2xl font-bold faq-icon">expand_more</span>
                    </span>
                </button>
                <div class="faq-content hidden px-6 pb-6 text-gray-700 font-medium leading-relaxed border-t border-gray-100 pt-4">
                    <p class="mb-3">
                        The decision comes down to your expected daily run time and electricity tariff savings:
                    </p>
                    <ul class="list-disc pl-5 space-y-2 mb-4">
                        <li><strong>3-Star Inverter AC:</strong> Best if your AC usage is moderate (3 to 5 hours daily or during peak summer months). Lower initial purchase price while delivering robust inverter energy efficiency.</li>
                        <li><strong>5-Star Inverter AC:</strong> Recommended if your usage exceeds 6 to 12 hours daily (e.g., bedrooms, home offices, master suites). A 5-Star AC consumes approximately <strong>20% to 25% less electricity</strong> than a 3-Star unit, usually recouping the upfront price difference within 12–18 months through lower monthly electricity bills.</li>
                    </ul>
                    <p class="text-sm bg-gray-50 p-3 border-l-2 border-gray-300">
                        All Blue Star inverter ACs feature 100% Copper Condensers with Blue Fin anti-corrosive coating for prolonged life and maximum thermal efficiency.
                    </p>
                </div>
            </div>

            <!-- Q4 -->
            <div class="faq-item bg-white border-l-4 border-[#1A56DB] shadow-md transition-all hover:shadow-lg" data-category="residential">
                <button class="faq-toggle w-full text-left p-6 flex justify-between items-center gap-4 focus:outline-none focus:ring-2 focus:ring-[#1A56DB]" aria-expanded="false">
                    <span class="text-lg md:text-xl font-black text-[#0A0A0A] tracking-tight">
                        What AC tonnage do I need for my room size?
                    </span>
                    <span class="faq-icon-wrapper w-8 h-8 rounded-full bg-[#1A56DB]/10 text-[#1A56DB] flex items-center justify-center flex-shrink-0 transition-transform duration-300">
                        <span class="material-symbols-outlined text-2xl font-bold faq-icon">expand_more</span>
                    </span>
                </button>
                <div class="faq-content hidden px-6 pb-6 text-gray-700 font-medium leading-relaxed border-t border-gray-100 pt-4">
                    <p class="mb-3">Here is the standard thermal sizing rule of thumb for Indian residential and office spaces:</p>
                    <div class="overflow-x-auto mb-4">
                        <table class="w-full text-left border-collapse border border-gray-200 text-sm">
                            <thead class="bg-gray-100 text-[#0A0A0A] font-black uppercase text-xs">
                                <tr>
                                    <th class="p-3 border border-gray-200">Room Area (Sq. Ft.)</th>
                                    <th class="p-3 border border-gray-200">Recommended Capacity</th>
                                    <th class="p-3 border border-gray-200">Suitable For</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr>
                                    <td class="p-3 border border-gray-200 font-semibold">Up to 120 sq. ft.</td>
                                    <td class="p-3 border border-gray-200 font-bold text-[#1A56DB]">0.8 Ton to 1.0 Ton</td>
                                    <td class="p-3 border border-gray-200">Small bedroom, study, personal cabin</td>
                                </tr>
                                <tr>
                                    <td class="p-3 border border-gray-200 font-semibold">120 to 180 sq. ft.</td>
                                    <td class="p-3 border border-gray-200 font-bold text-[#1A56DB]">1.5 Ton</td>
                                    <td class="p-3 border border-gray-200">Standard master bedroom, dining room</td>
                                </tr>
                                <tr>
                                    <td class="p-3 border border-gray-200 font-semibold">180 to 260 sq. ft.</td>
                                    <td class="p-3 border border-gray-200 font-bold text-[#1A56DB]">2.0 Ton</td>
                                    <td class="p-3 border border-gray-200">Large living room, open hall, conference room</td>
                                </tr>
                                <tr>
                                    <td class="p-3 border border-gray-200 font-semibold">Above 260 sq. ft.</td>
                                    <td class="p-3 border border-gray-200 font-bold text-[#1A56DB]">Multi-Split / Cassette / Ducted</td>
                                    <td class="p-3 border border-gray-200">Commercial showrooms, restaurants, duplexes</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <p class="text-xs text-gray-500 italic">
                        *Note: If your room is on the top floor directly under the terrace, has large west-facing glass windows, or holds more than 5 occupants, step up by +0.5 Ton.
                    </p>
                </div>
            </div>

            <!-- Q5 -->
            <div class="faq-item bg-white border-l-4 border-[#1A56DB] shadow-md transition-all hover:shadow-lg" data-category="residential">
                <button class="faq-toggle w-full text-left p-6 flex justify-between items-center gap-4 focus:outline-none focus:ring-2 focus:ring-[#1A56DB]" aria-expanded="false">
                    <span class="text-lg md:text-xl font-black text-[#0A0A0A] tracking-tight">
                        Do Blue Star air conditioners use 100% copper coils?
                    </span>
                    <span class="faq-icon-wrapper w-8 h-8 rounded-full bg-[#1A56DB]/10 text-[#1A56DB] flex items-center justify-center flex-shrink-0 transition-transform duration-300">
                        <span class="material-symbols-outlined text-2xl font-bold faq-icon">expand_more</span>
                    </span>
                </button>
                <div class="faq-content hidden px-6 pb-6 text-gray-700 font-medium leading-relaxed border-t border-gray-100 pt-4">
                    <p>
                        <strong>Yes.</strong> All modern Blue Star split and inverter air conditioners supplied by Snap Marketing feature <strong>100% pure copper condenser and evaporator coils</strong> with inner-grooved tubes. This provides superior heat transfer capability, high pressure resistance, lower risk of refrigerant leakage, and straightforward repairability compared to aluminum coils.
                    </p>
                </div>
            </div>

            <!-- Category: Commercial Refrigeration -->
            <div class="faq-category-header" data-category="commercial">
                <h2 class="text-2xl font-black text-[#0A0A0A] uppercase tracking-tight flex items-center gap-3 pt-6 mb-4 border-b-2 border-[#1A56DB] pb-2">
                    <span class="w-3 h-3 bg-[#1A56DB]"></span>
                    Commercial Refrigeration & Cold Chain (B2B)
                </h2>
            </div>

            <!-- Q6 -->
            <div class="faq-item bg-white border-l-4 border-[#1A56DB] shadow-md transition-all hover:shadow-lg" data-category="commercial">
                <button class="faq-toggle w-full text-left p-6 flex justify-between items-center gap-4 focus:outline-none focus:ring-2 focus:ring-[#1A56DB]" aria-expanded="false">
                    <span class="text-lg md:text-xl font-black text-[#0A0A0A] tracking-tight">
                        What commercial refrigeration equipment is available for bulk supply?
                    </span>
                    <span class="faq-icon-wrapper w-8 h-8 rounded-full bg-[#1A56DB]/10 text-[#1A56DB] flex items-center justify-center flex-shrink-0 transition-transform duration-300">
                        <span class="material-symbols-outlined text-2xl font-bold faq-icon">expand_more</span>
                    </span>
                </button>
                <div class="faq-content hidden px-6 pb-6 text-gray-700 font-medium leading-relaxed border-t border-gray-100 pt-4">
                    <p class="mb-3">Snap Marketing supplies the comprehensive industrial cold chain portfolio:</p>
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
                        <li class="p-2 bg-gray-50 border border-gray-200"><strong>Hard Top Deep Freezers:</strong> 100L to 800L single & double door (-18°C to -24°C)</li>
                        <li class="p-2 bg-gray-50 border border-gray-200"><strong>Glass Top Display Freezers:</strong> Flat and curved glass models for ice creams & frozen retail</li>
                        <li class="p-2 bg-gray-50 border border-gray-200"><strong>Visi Coolers:</strong> Upright glass door beverage chillers (200L to 1000L)</li>
                        <li class="p-2 bg-gray-50 border border-gray-200"><strong>Stainless Steel Water Coolers:</strong> 20 LPH to 500 LPH with optional in-built RO purification</li>
                        <li class="p-2 bg-gray-50 border border-gray-200"><strong>Commercial Ice Machines:</strong> Bullet & dice ice makers for hotels & bars</li>
                        <li class="p-2 bg-gray-50 border border-gray-200"><strong>Modular Cold Rooms:</strong> Positive & negative temperature customized cold storage rooms</li>
                    </ul>
                </div>
            </div>

            <!-- Q7 -->
            <div class="faq-item bg-white border-l-4 border-[#1A56DB] shadow-md transition-all hover:shadow-lg" data-category="commercial">
                <button class="faq-toggle w-full text-left p-6 flex justify-between items-center gap-4 focus:outline-none focus:ring-2 focus:ring-[#1A56DB]" aria-expanded="false">
                    <span class="text-lg md:text-xl font-black text-[#0A0A0A] tracking-tight">
                        How do I obtain a formal B2B GST tax invoice and institutional quotation?
                    </span>
                    <span class="faq-icon-wrapper w-8 h-8 rounded-full bg-[#1A56DB]/10 text-[#1A56DB] flex items-center justify-center flex-shrink-0 transition-transform duration-300">
                        <span class="material-symbols-outlined text-2xl font-bold faq-icon">expand_more</span>
                    </span>
                </button>
                <div class="faq-content hidden px-6 pb-6 text-gray-700 font-medium leading-relaxed border-t border-gray-100 pt-4">
                    <p class="mb-3">
                        Requesting institutional pricing is streamlined:
                    </p>
                    <ol class="list-decimal pl-5 space-y-2 mb-3">
                        <li>Visit our <a href="<?php echo esc_url(home_url('/request-a-quote')); ?>" class="text-[#1A56DB] font-bold underline">Request a Quote</a> page or click "Bulk Quote" on any product page.</li>
                        <li>Submit your required product models, unit quantities, delivery location, and your company <strong>GSTIN</strong>.</li>
                        <li>Our B2B key account team generates a formal Proforma Invoice / Quotation with applicable volume discounts, payment milestones, and transport details within <strong>2 to 4 business hours</strong>.</li>
                        <li>Full 18% or 28% GST input tax credit (ITC) invoices are issued with e-Way bills upon dispatch.</li>
                    </ol>
                </div>
            </div>

            <!-- Category: Hygiene & Washroom Automation -->
            <div class="faq-category-header" data-category="washroom">
                <h2 class="text-2xl font-black text-[#0A0A0A] uppercase tracking-tight flex items-center gap-3 pt-6 mb-4 border-b-2 border-[#1A56DB] pb-2">
                    <span class="w-3 h-3 bg-[#1A56DB]"></span>
                    Hygiene, Washroom Tech & Dispensers
                </h2>
            </div>

            <!-- Q8 -->
            <div class="faq-item bg-white border-l-4 border-[#1A56DB] shadow-md transition-all hover:shadow-lg" data-category="washroom">
                <button class="faq-toggle w-full text-left p-6 flex justify-between items-center gap-4 focus:outline-none focus:ring-2 focus:ring-[#1A56DB]" aria-expanded="false">
                    <span class="text-lg md:text-xl font-black text-[#0A0A0A] tracking-tight">
                        What washroom automation and touchless hygiene products do you stock?
                    </span>
                    <span class="faq-icon-wrapper w-8 h-8 rounded-full bg-[#1A56DB]/10 text-[#1A56DB] flex items-center justify-center flex-shrink-0 transition-transform duration-300">
                        <span class="material-symbols-outlined text-2xl font-bold faq-icon">expand_more</span>
                    </span>
                </button>
                <div class="faq-content hidden px-6 pb-6 text-gray-700 font-medium leading-relaxed border-t border-gray-100 pt-4">
                    <p class="mb-3">Snap Marketing is a primary supplier for corporate facilities, hospitals, and airports with:</p>
                    <ul class="list-disc pl-5 space-y-2 mb-3">
                        <li><strong>High-Speed Jet Hand Dryers:</strong> Stainless steel 304 and ABS automatic sensor dryers (10–12 second dry time).</li>
                        <li><strong>Touchless Sensor Taps:</strong> Brass chrome finish automatic infra-red sensor faucets AC/DC battery operated.</li>
                        <li><strong>Automatic Sensor Soap & Sanitizer Dispensers:</strong> Wall-mounted 1000ml bulk-fill and cartridge-based models.</li>
                        <li><strong>Kimberly-Clark Professional Consumables:</strong> Scott & Kleenex M-fold paper towels, HRT roll towels, jumbo toilet roll systems, and foam soap refills.</li>
                        <li><strong>Air Curtains & Entrance Sanitization:</strong> Commercial 3ft to 6ft high-velocity air barriers for dust and insect control.</li>
                    </ul>
                </div>
            </div>

            <!-- Category: Orders, Warranty & Support -->
            <div class="faq-category-header" data-category="orders">
                <h2 class="text-2xl font-black text-[#0A0A0A] uppercase tracking-tight flex items-center gap-3 pt-6 mb-4 border-b-2 border-[#1A56DB] pb-2">
                    <span class="w-3 h-3 bg-[#1A56DB]"></span>
                    Orders, Delivery, Warranty & AMC Support
                </h2>
            </div>

            <!-- Q9 -->
            <div class="faq-item bg-white border-l-4 border-[#1A56DB] shadow-md transition-all hover:shadow-lg" data-category="orders">
                <button class="faq-toggle w-full text-left p-6 flex justify-between items-center gap-4 focus:outline-none focus:ring-2 focus:ring-[#1A56DB]" aria-expanded="false">
                    <span class="text-lg md:text-xl font-black text-[#0A0A0A] tracking-tight">
                        What warranty coverage comes with Blue Star products purchased from Snap?
                    </span>
                    <span class="faq-icon-wrapper w-8 h-8 rounded-full bg-[#1A56DB]/10 text-[#1A56DB] flex items-center justify-center flex-shrink-0 transition-transform duration-300">
                        <span class="material-symbols-outlined text-2xl font-bold faq-icon">expand_more</span>
                    </span>
                </button>
                <div class="faq-content hidden px-6 pb-6 text-gray-700 font-medium leading-relaxed border-t border-gray-100 pt-4">
                    <p class="mb-3">
                        All products come with <strong>Official Blue Star Manufacturer Warranty</strong> honored nationwide:
                    </p>
                    <ul class="list-disc pl-5 space-y-2 mb-3">
                        <li><strong>Residential Split / Inverter ACs:</strong> 1 Year Comprehensive on machine + 10 Years on Inverter Compressor (5 Years on fixed-speed models) + 5 Years on PCB.</li>
                        <li><strong>Commercial Deep Freezers & Visi Coolers:</strong> 1 Year Comprehensive Warranty + up to 3–4 Years extended compressor warranty (model dependent).</li>
                        <li><strong>Water Coolers & Dispensers:</strong> 1 Year Comprehensive Warranty.</li>
                    </ul>
                    <p class="text-sm text-gray-600">
                        Snap Marketing also assists with Annual Maintenance Contracts (AMC) and institutional preventative maintenance service packages for corporate fleets.
                    </p>
                </div>
            </div>

            <!-- Q10 -->
            <div class="faq-item bg-white border-l-4 border-[#1A56DB] shadow-md transition-all hover:shadow-lg" data-category="orders">
                <button class="faq-toggle w-full text-left p-6 flex justify-between items-center gap-4 focus:outline-none focus:ring-2 focus:ring-[#1A56DB]" aria-expanded="false">
                    <span class="text-lg md:text-xl font-black text-[#0A0A0A] tracking-tight">
                        What are the dispatch and delivery timelines for Pune and across Maharashtra?
                    </span>
                    <span class="faq-icon-wrapper w-8 h-8 rounded-full bg-[#1A56DB]/10 text-[#1A56DB] flex items-center justify-center flex-shrink-0 transition-transform duration-300">
                        <span class="material-symbols-outlined text-2xl font-bold faq-icon">expand_more</span>
                    </span>
                </button>
                <div class="faq-content hidden px-6 pb-6 text-gray-700 font-medium leading-relaxed border-t border-gray-100 pt-4">
                    <ul class="list-disc pl-5 space-y-2">
                        <li><strong>Pune Municipal Corporation (PMC) & PCMC Area:</strong> Same-day or next-day delivery (within 24–48 hours) from our local central warehouse at Ghorpadi Peth (Shankar Sheth Road, Pune).</li>
                        <li><strong>Rest of Maharashtra (Mumbai, Nashik, Aurangabad, Nagpur, Kolhapur, Solapur):</strong> 2 to 4 business days via insured direct freight logistics.</li>
                        <li><strong>Interstate Pan-India Bulk Shipments:</strong> 4 to 7 business days with transit insurance, tracking numbers, and dedicated delivery scheduling.</li>
                    </ul>
                </div>
            </div>

            <!-- Q11 -->
            <div class="faq-item bg-white border-l-4 border-[#1A56DB] shadow-md transition-all hover:shadow-lg" data-category="orders">
                <button class="faq-toggle w-full text-left p-6 flex justify-between items-center gap-4 focus:outline-none focus:ring-2 focus:ring-[#1A56DB]" aria-expanded="false">
                    <span class="text-lg md:text-xl font-black text-[#0A0A0A] tracking-tight">
                        How do I schedule an official Blue Star installation?
                    </span>
                    <span class="faq-icon-wrapper w-8 h-8 rounded-full bg-[#1A56DB]/10 text-[#1A56DB] flex items-center justify-center flex-shrink-0 transition-transform duration-300">
                        <span class="material-symbols-outlined text-2xl font-bold faq-icon">expand_more</span>
                    </span>
                </button>
                <div class="faq-content hidden px-6 pb-6 text-gray-700 font-medium leading-relaxed border-t border-gray-100 pt-4">
                    <p class="mb-3">
                        Once your product is delivered, you can book an installation directly via:
                    </p>
                    <ol class="list-decimal pl-5 space-y-2 mb-3">
                        <li><strong>Blue Star Central Toll-Free Helpline:</strong> 1800 209 1177 / 1860 266 6666 (Operating 24/7).</li>
                        <li><strong>Snap Customer Desk:</strong> WhatsApp us at +91 98230 12724 or email sales@snapmktg.com with your invoice number, and our coordinator will register your ticket directly in the Blue Star technician dispatch portal.</li>
                    </ol>
                    <p class="text-sm text-gray-600">
                        Technicians typically arrive within 24–48 hours of service request registration.
                    </p>
                </div>
            </div>

        </div>

        <!-- Help & Contact Desk Card -->
        <div class="mt-16 bg-[#0A0A0A] border-t-8 border-[#FBBF24] p-8 md:p-12 text-white shadow-2xl relative overflow-hidden">
            <div class="absolute right-0 top-0 w-1/2 h-full bg-[#1A56DB] opacity-10 diagonal-band pointer-events-none"></div>
            <div class="relative z-10 max-w-2xl">
                <span class="text-[#FBBF24] text-xs font-black uppercase tracking-[0.2em] block mb-2">Still Have Questions?</span>
                <h3 class="text-3xl md:text-4xl font-black uppercase tracking-tight text-white mb-4">
                    Talk Directly With Our Technical Sales Team
                </h3>
                <p class="text-gray-300 mb-8 font-medium">
                    Whether you need a custom heat-load calculation for a commercial plant or bulk institutional discounting, our senior engineers are here to assist.
                </p>
                <div class="flex flex-wrap gap-4 items-center">
                    <a href="<?php echo esc_url(home_url('/request-a-quote')); ?>" class="bg-[#FBBF24] text-[#0A0A0A] px-8 py-4 font-black uppercase text-sm tracking-wider hover:bg-white transition-all shadow-lg">
                        Request Bulk Quote
                    </a>
                    <a href="https://wa.me/919823012724" target="_blank" rel="noopener noreferrer" class="bg-[#1A56DB] text-white px-8 py-4 font-black uppercase text-sm tracking-wider hover:bg-[#FBBF24] hover:text-[#0A0A0A] transition-all flex items-center gap-2 shadow-lg">
                        <span class="material-symbols-outlined text-lg">chat</span>
                        WhatsApp Instant Chat
                    </a>
                    <a href="tel:+919823012724" class="text-gray-300 hover:text-white font-bold text-sm tracking-wider flex items-center gap-1 pl-2">
                        <span class="material-symbols-outlined text-lg text-[#FBBF24]">call</span>
                        +91 98230 12724
                    </a>
                </div>
            </div>
        </div>

    </div>
</main>

<!-- Interactive Accordion & Realtime Search Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('faq-search-input');
    const searchClear = document.getElementById('faq-search-clear');
    const searchCount = document.getElementById('faq-search-count');
    const noResults = document.getElementById('faq-no-results');
    const filterBtns = document.querySelectorAll('.faq-filter-btn');
    const faqItems = document.querySelectorAll('.faq-item');
    const categoryHeaders = document.querySelectorAll('.faq-category-header');

    // Accordion Toggle
    faqItems.forEach(item => {
        const toggle = item.querySelector('.faq-toggle');
        const content = item.querySelector('.faq-content');
        const iconWrapper = item.querySelector('.faq-icon-wrapper');

        toggle.addEventListener('click', () => {
            const isOpen = !content.classList.contains('hidden');

            // Optional: Close others (uncomment for strict single-accordion mode)
            /*
            faqItems.forEach(otherItem => {
                if (otherItem !== item) {
                    otherItem.querySelector('.faq-content').classList.add('hidden');
                    otherItem.querySelector('.faq-toggle').setAttribute('aria-expanded', 'false');
                    otherItem.querySelector('.faq-icon-wrapper').classList.remove('rotate-180', 'bg-[#FBBF24]', 'text-black');
                    otherItem.querySelector('.faq-icon-wrapper').classList.add('bg-[#1A56DB]/10', 'text-[#1A56DB]');
                }
            });
            */

            if (isOpen) {
                content.classList.add('hidden');
                toggle.setAttribute('aria-expanded', 'false');
                iconWrapper.classList.remove('rotate-180', 'bg-[#FBBF24]', 'text-black');
                iconWrapper.classList.add('bg-[#1A56DB]/10', 'text-[#1A56DB]');
            } else {
                content.classList.remove('hidden');
                toggle.setAttribute('aria-expanded', 'true');
                iconWrapper.classList.add('rotate-180', 'bg-[#FBBF24]', 'text-black');
                iconWrapper.classList.remove('bg-[#1A56DB]/10', 'text-[#1A56DB]');
            }
        });
    });

    // Category Filtering
    let activeCategory = 'all';

    function applyFilter() {
        const query = (searchInput.value || '').trim().toLowerCase();
        let visibleCount = 0;

        faqItems.forEach(item => {
            const itemCat = item.getAttribute('data-category');
            const questionText = item.querySelector('.faq-toggle span').textContent.toLowerCase();
            const answerText = item.querySelector('.faq-content').textContent.toLowerCase();

            const matchesCategory = (activeCategory === 'all' || itemCat === activeCategory);
            const matchesQuery = (!query || questionText.includes(query) || answerText.includes(query));

            if (matchesCategory && matchesQuery) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        // Toggle category header visibility
        categoryHeaders.forEach(header => {
            const headerCat = header.getAttribute('data-category');
            if (activeCategory !== 'all' && activeCategory !== headerCat) {
                header.style.display = 'none';
            } else if (query) {
                // If searching, show header only if at least one child under this cat is visible
                const hasVisible = Array.from(faqItems).some(item => 
                    item.getAttribute('data-category') === headerCat && item.style.display !== 'none'
                );
                header.style.display = hasVisible ? 'block' : 'none';
            } else {
                header.style.display = 'block';
            }
        });

        // Search count & No results indicator
        if (query) {
            searchClear.classList.remove('hidden');
            searchCount.classList.remove('hidden');
            searchCount.textContent = `Found ${visibleCount} answer${visibleCount === 1 ? '' : 's'} matching "${query}"`;
        } else {
            searchClear.classList.add('hidden');
            searchCount.classList.add('hidden');
        }

        if (visibleCount === 0) {
            noResults.classList.remove('hidden');
        } else {
            noResults.classList.add('hidden');
        }
    }

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => {
                b.classList.remove('bg-[#FBBF24]', 'text-black', 'active');
                b.classList.add('bg-zinc-900', 'text-gray-300');
            });
            btn.classList.add('bg-[#FBBF24]', 'text-black', 'active');
            btn.classList.remove('bg-zinc-900', 'text-gray-300');

            activeCategory = btn.getAttribute('data-category');
            applyFilter();
        });
    });

    searchInput.addEventListener('input', applyFilter);

    searchClear.addEventListener('click', () => {
        searchInput.value = '';
        applyFilter();
        searchInput.focus();
    });
});
</script>

<!-- Embedded Rich FAQPage JSON-LD Schema for AI & Google Search Rich Snippets -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "Is Snap Marketing an authorized Blue Star dealer in Pune and Maharashtra?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes, 100%. Snap Marketing (Snap House) is an authorized channel partner and master distributor for Blue Star Limited, operating in Pune, Maharashtra with continuous operations since 1988. Every Blue Star product purchased carries genuine factory serial numbers and valid 100% manufacturer warranties."
      }
    },
    {
      "@type": "Question",
      "name": "Do you cater to both individual homeowners (B2C) and large enterprises (B2B)?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. Snap Marketing operates two specialized divisions: a Consumer Division (B2C) offering split and inverter ACs and home cooling to homeowners, and a Commercial & Enterprise Division (B2B) supplying hospitals, IT parks, cold storages, hotels, and institutions with commercial refrigeration and washroom automation."
      }
    },
    {
      "@type": "Question",
      "name": "How do I choose between a 3-Star and a 5-Star Inverter Air Conditioner?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Choose a 3-Star Inverter AC if your usage is moderate (3 to 5 hours daily). If your usage exceeds 6 to 12 hours daily, a 5-Star Inverter AC is recommended because it consumes 20% to 25% less electricity, recovering the upfront cost difference within 12 to 18 months."
      }
    },
    {
      "@type": "Question",
      "name": "What AC tonnage do I need for my room size?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "For rooms up to 120 sq. ft., a 0.8 to 1.0 Ton AC is recommended. For 120 to 180 sq. ft., select a 1.5 Ton AC. For 180 to 260 sq. ft., choose a 2.0 Ton AC. Top floors under a direct terrace or rooms with large west-facing windows should step up capacity by 0.5 Ton."
      }
    },
    {
      "@type": "Question",
      "name": "Do Blue Star air conditioners use 100% copper coils?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. All modern Blue Star split and inverter air conditioners supplied by Snap Marketing feature 100% pure copper condenser and evaporator coils with Blue Fin anti-corrosive coating for maximum heat exchange and longevity."
      }
    },
    {
      "@type": "Question",
      "name": "What commercial refrigeration equipment is available for bulk supply?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Snap Marketing supplies hard-top deep freezers (100L to 800L), glass-top display freezers, upright visi coolers (200L to 1000L), stainless steel water coolers (20 to 500 LPH), commercial ice machines, and modular cold rooms."
      }
    },
    {
      "@type": "Question",
      "name": "How do I obtain a formal B2B GST tax invoice and institutional quotation?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Submit your product requirements and GSTIN through our Request a Quote page. Our corporate team delivers a formal quotation with institutional volume pricing within 2 to 4 business hours. Official 18% or 28% GST tax invoices are provided with all dispatches."
      }
    },
    {
      "@type": "Question",
      "name": "What washroom automation and touchless hygiene products do you stock?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "We supply stainless steel 304 jet hand dryers, touchless infrared sensor taps, automatic soap dispensers, Kimberly-Clark paper towel systems, and commercial air curtains for corporate facilities and healthcare centers."
      }
    },
    {
      "@type": "Question",
      "name": "What warranty coverage comes with Blue Star products purchased from Snap?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "All equipment carries full Blue Star factory warranties: 1 Year Comprehensive + 10 Years on Inverter Compressor for residential ACs, and 1 Year Comprehensive + up to 3 to 4 years on compressors for commercial deep freezers and visi coolers."
      }
    },
    {
      "@type": "Question",
      "name": "What are the dispatch and delivery timelines for Pune and across Maharashtra?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Deliveries within Pune and PCMC are completed within 24 to 48 hours. Other Maharashtra cities (Mumbai, Nashik, Nagpur, Aurangabad) take 2 to 4 business days. Pan-India interstate bulk freight takes 4 to 7 business days."
      }
    },
    {
      "@type": "Question",
      "name": "How do I schedule an official Blue Star installation?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Call the Blue Star toll-free helpline at 1800 209 1177 or contact Snap Marketing directly via WhatsApp at +91 98230 12724. We register your service ticket directly with the Blue Star authorized engineering dispatch portal."
      }
    }
  ]
}
</script>

<?php get_footer(); ?>
