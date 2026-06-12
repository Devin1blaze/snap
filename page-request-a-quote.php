<!DOCTYPE html>

<html class="dark" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Request Bulk Quote | Industrial Authority</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;800;900&amp;family=Space+Grotesk:wght@400;500;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "tertiary-container": "#576276",
                    "on-tertiary-fixed-variant": "#3c475a",
                    "on-error": "#690005",
                    "on-background": "#e5e2e1",
                    "on-secondary-container": "#5a4100",
                    "on-secondary-fixed-variant": "#5c4300",
                    "outline-variant": "#434654",
                    "on-secondary-fixed": "#261a00",
                    "surface-container-low": "#1c1b1b",
                    "on-primary-container": "#d4dcff",
                    "primary-container": "#1a56db",
                    "on-tertiary-container": "#d3def6",
                    "on-primary-fixed-variant": "#003dab",
                    "tertiary-fixed-dim": "#bcc7de",
                    "secondary-container": "#e3aa00",
                    "inverse-on-surface": "#313030",
                    "surface-tint": "#b5c4ff",
                    "secondary": "#ffc640",
                    "on-primary": "#00297a",
                    "background": "#131313",
                    "on-primary-fixed": "#00174d",
                    "on-secondary": "#402d00",
                    "surface-container-high": "#2a2a2a",
                    "surface": "#131313",
                    "inverse-surface": "#e5e2e1",
                    "on-error-container": "#ffdad6",
                    "tertiary": "#bcc7de",
                    "primary-fixed": "#dbe1ff",
                    "outline": "#8d90a0",
                    "on-tertiary-fixed": "#111c2d",
                    "inverse-primary": "#1353d8",
                    "primary-fixed-dim": "#b5c4ff",
                    "error": "#ffb4ab",
                    "surface-container-lowest": "#0e0e0e",
                    "secondary-fixed-dim": "#f9bd22",
                    "surface-container-highest": "#353534",
                    "secondary-fixed": "#ffdf9f",
                    "error-container": "#93000a",
                    "tertiary-fixed": "#d8e3fb",
                    "surface-bright": "#3a3939",
                    "surface-dim": "#131313",
                    "on-surface-variant": "#c3c5d7",
                    "primary": "#b5c4ff",
                    "on-surface": "#e5e2e1",
                    "on-tertiary": "#263143",
                    "surface-container": "#201f1f",
                    "surface-variant": "#353534"
            },
            "borderRadius": {
                    "DEFAULT": "0px",
                    "lg": "0px",
                    "xl": "0px",
                    "full": "0px"
            },
            "spacing": {
                    "margin-mobile": "20px",
                    "unit": "4px",
                    "gutter": "24px",
                    "margin-desktop": "64px",
                    "border-thin": "2px",
                    "border-thick": "4px"
            },
            "fontFamily": {
                    "body-lg": ["Inter"],
                    "mono-data": ["Space Grotesk"],
                    "display-2xl": ["Inter"],
                    "headline-md": ["Inter"],
                    "headline-lg-mobile": ["Inter"],
                    "label-tech": ["Space Grotesk"],
                    "body-md": ["Inter"],
                    "headline-lg": ["Inter"]
            },
            "fontSize": {
                    "body-lg": ["18px", {"lineHeight": "1.6", "fontWeight": "400"}],
                    "mono-data": ["12px", {"lineHeight": "1.2", "fontWeight": "400"}],
                    "display-2xl": ["72px", {"lineHeight": "1.1", "letterSpacing": "-0.04em", "fontWeight": "900"}],
                    "headline-md": ["24px", {"lineHeight": "1.4", "fontWeight": "700"}],
                    "headline-lg-mobile": ["32px", {"lineHeight": "1.2", "fontWeight": "800"}],
                    "label-tech": ["14px", {"lineHeight": "1.2", "letterSpacing": "0.05em", "fontWeight": "500"}],
                    "body-md": ["16px", {"lineHeight": "1.6", "fontWeight": "400"}],
                    "headline-lg": ["48px", {"lineHeight": "1.2", "letterSpacing": "-0.02em", "fontWeight": "800"}]
            }
          },
        },
      }
    </script>
<style>
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
<style>
    body {
      min-height: max(884px, 100dvh);
    }
  </style>
  </head>
<body class="bg-background text-on-background font-body-md selection:bg-secondary selection:text-background min-h-screen">
<!-- Top Navigation Bar -->
<header class="fixed top-0 z-50 w-full bg-background border-b-border-thick border-on-surface">
<div class="flex justify-between items-center w-full px-margin-mobile py-4 md:px-margin-desktop">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-primary text-headline-md" data-icon="factory">factory</span>
<span class="font-headline-md text-headline-md font-extrabold uppercase tracking-tighter text-primary">INDUSTRIAL AUTHORITY</span>
</div>
<div class="hidden md:flex items-center gap-gutter font-label-tech text-label-tech uppercase">
<a class="text-on-surface hover:bg-on-surface hover:text-background transition-colors duration-200 px-2 py-1" href="#">Inventory</a>
<a class="text-secondary font-bold border-2 border-on-surface px-2 py-1" href="#">Bulk Orders</a>
<a class="text-on-surface hover:bg-on-surface hover:text-background transition-colors duration-200 px-2 py-1" href="#">Technical Specs</a>
<a class="text-on-surface hover:bg-on-surface hover:text-background transition-colors duration-200 px-2 py-1" href="#">Support</a>
</div>
<button class="md:hidden">
<span class="material-symbols-outlined text-on-surface" data-icon="menu">menu</span>
</button>
</div>
</header>
<main class="pt-20 relative overflow-hidden">
<div class="absolute inset-0 industrial-grid-overlay pointer-events-none"></div>
<!-- Hero Section -->
<section class="relative bg-secondary px-margin-mobile py-12 md:px-margin-desktop md:py-24 border-b-border-thick border-on-surface overflow-hidden">
<div class="absolute right-[-10%] top-[-10%] opacity-10 pointer-events-none">
<span class="material-symbols-outlined text-[300px] leading-none" data-icon="inventory_2" style="font-variation-settings: 'FILL' 1;">inventory_2</span>
</div>
<div class="relative z-10 max-w-4xl">
<h1 class="font-headline-lg-mobile text-headline-lg-mobile md:font-headline-lg md:text-headline-lg font-black text-background uppercase leading-none tracking-tighter mb-4">
                    REQUEST INDUSTRIAL QUOTE
                </h1>
<div class="bg-background inline-block px-4 py-2 border-l-border-thick border-primary-container">
<p class="font-label-tech text-label-tech text-primary uppercase tracking-widest">
                        High-Volume Procurement Control Center
                    </p>
</div>
</div>
</section>
<!-- Main Content Grid -->
<div class="flex flex-col lg:grid lg:grid-cols-12 w-full">
<!-- Form Section -->
<section class="lg:col-span-8 border-b-border-thick lg:border-b-0 lg:border-r-border-thick border-on-surface bg-surface p-margin-mobile md:p-gutter lg:p-margin-desktop">
    <?php
    $cf7_form = get_page_by_title('Bulk Quote Form', OBJECT, 'wpcf7_contact_form');
    if ( $cf7_form ) {
        echo do_shortcode( '[contact-form-7 id="' . esc_attr( $cf7_form->ID ) . '" title="Bulk Quote Form"]' );
    } else {
        echo '<p class="text-on-surface">Quote form is not configured. Please create a "Bulk Quote Form" in Contact Form 7.</p>';
    }
    ?>
</section>
<!-- Trust & Contact Sidebar -->
<aside class="lg:col-span-4 bg-surface-container flex flex-col">
<!-- Image Display -->
<div class="relative h-64 lg:h-80 border-b-border-thick border-on-surface overflow-hidden">
<img alt="Industrial Facility" class="w-full h-full object-cover grayscale brightness-50 contrast-125" data-alt="A high-contrast cinematic shot of a modern industrial warehouse interior with massive steel beams and structured shelving. The lighting is cold and atmospheric with strong blue secondary tones and sharp yellow safety highlights reflecting off polished concrete floors. The composition is asymmetrical, emphasizing the vast, engineered scale of a high-end logistics facility for Snap Marketing." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDnAtJjJnPbbex592esXQvU54f2q349Uv5L9ZE5N7JCAOy3lrUnqkRSV8C4Ms5-DvA2MSqg1YdctjtiEiOksWF4-vzdcJTCP2goUwDwkBbSa4_R-X7p_Z9k9bM6jNVLOn4Zy6P_9c1NRB_SXC1Lipm1aB0uKQDOrRLodWo6VTl9jesIsiHu992cKU74D9lEmIb2KKTAKRMgNCifCmmPN0tUPIsZXmx1UTGXhlxH1fFLSQWpuZTSmYyZ4VbRux7-P5nRe2kPx6v-dig"/>
<div class="absolute bottom-4 left-4 bg-primary-container px-3 py-1 font-mono-data text-mono-data text-on-primary-container uppercase">
                        FACILITY ID: SN-IND-04
                    </div>
</div>
<div class="p-margin-mobile md:p-gutter space-y-12">
<!-- Contact Section -->
<div class="space-y-6">
<h3 class="font-label-tech text-label-tech uppercase text-secondary tracking-widest border-b border-secondary/30 pb-2">Direct Procurement Line</h3>
<div class="flex items-center gap-4 group cursor-pointer">
<div class="bg-on-tertiary-fixed-variant p-3 border-2 border-on-surface group-hover:bg-primary-container transition-colors">
<span class="material-symbols-outlined text-on-surface" data-icon="call">call</span>
</div>
<div>
<p class="font-headline-md text-headline-md font-black tracking-tighter text-on-surface">+1 (555) 900-SNAP</p>
<p class="font-mono-data text-mono-data text-on-surface-variant">AVAILABLE 24/7 FOR ENTERPRISE</p>
</div>
</div>
<div class="flex items-center gap-4 group cursor-pointer">
<div class="bg-on-tertiary-fixed-variant p-3 border-2 border-on-surface group-hover:bg-primary-container transition-colors">
<span class="material-symbols-outlined text-on-surface" data-icon="mail">mail</span>
</div>
<div>
<p class="font-headline-md text-headline-md font-black tracking-tighter text-on-surface">SUPPLY@SNAPMARKETING.IND</p>
<p class="font-mono-data text-mono-data text-on-surface-variant">AVERAGE RESPONSE: 14 MINS</p>
</div>
</div>
</div>
<!-- Trust Badges -->
<div class="space-y-4">
<h3 class="font-label-tech text-label-tech uppercase text-secondary tracking-widest border-b border-secondary/30 pb-2">Certifications &amp; Network</h3>
<div class="border-2 border-on-surface p-4 flex items-center gap-4 bg-background">
<span class="material-symbols-outlined text-primary text-3xl" data-icon="verified" style="font-variation-settings: 'FILL' 1;">verified</span>
<div>
<p class="font-label-tech text-label-tech font-bold uppercase">ISO 9001:2015 CERTIFIED</p>
<p class="font-mono-data text-mono-data text-on-surface-variant">Quality Management Protocol</p>
</div>
</div>
<div class="border-2 border-on-surface p-4 flex items-center gap-4 bg-background">
<span class="material-symbols-outlined text-primary text-3xl" data-icon="local_shipping" style="font-variation-settings: 'FILL' 1;">local_shipping</span>
<div>
<p class="font-label-tech text-label-tech font-bold uppercase">PAN-INDIA LOGISTICS</p>
<p class="font-mono-data text-mono-data text-on-surface-variant">Tier-1 Distribution Network</p>
</div>
</div>
<div class="border-2 border-on-surface p-4 flex items-center gap-4 bg-background">
<span class="material-symbols-outlined text-primary text-3xl" data-icon="precision_manufacturing" style="font-variation-settings: 'FILL' 1;">precision_manufacturing</span>
<div>
<p class="font-label-tech text-label-tech font-bold uppercase">AUTHORIZED ENTERPRISE PARTNER</p>
<p class="font-mono-data text-mono-data text-on-surface-variant">Direct OEM Supply Chain Access</p>
</div>
</div>
</div>
</div>
</aside>
</div>
</main>
<!-- Footer -->
<footer class="bg-surface-container-lowest border-t-border-thick border-on-surface mt-12">
<div class="w-full px-margin-mobile py-gutter md:px-margin-desktop flex flex-col md:flex-row justify-between items-center gap-6">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-primary" data-icon="factory">factory</span>
<p class="font-headline-md text-headline-md text-primary font-extrabold uppercase tracking-tighter">INDUSTRIAL AUTHORITY B2B</p>
</div>
<p class="font-mono-data text-mono-data uppercase text-on-surface-variant text-center md:text-left">
                ©2024 INDUSTRIAL AUTHORITY B2B. ALL RIGHTS RESERVED.
            </p>
<div class="flex gap-margin-mobile">
<a class="font-mono-data text-mono-data uppercase text-on-surface-variant hover:text-secondary transition-colors" href="#">Privacy Policy</a>
<a class="font-mono-data text-mono-data uppercase text-on-surface-variant hover:text-secondary transition-colors" href="#">Terms of Service</a>
<a class="font-mono-data text-mono-data uppercase text-on-surface-variant hover:text-secondary transition-colors" href="#">ISO Certification</a>
</div>
</div>
</footer>
<!-- Mobile Nav Bar (Bottom) -->
<nav class="fixed bottom-0 left-0 w-full md:hidden bg-surface border-t-border-thick border-on-surface z-50 flex justify-around p-2">
<button class="flex flex-col items-center p-2 text-on-surface-variant hover:text-on-surface">
<span class="material-symbols-outlined" data-icon="inventory_2">inventory_2</span>
<span class="text-[10px] font-label-tech uppercase">Inventory</span>
</button>
<button class="flex flex-col items-center p-2 bg-secondary text-background border-2 border-on-surface font-bold">
<span class="material-symbols-outlined" data-icon="reorder">reorder</span>
<span class="text-[10px] font-label-tech uppercase">Bulk</span>
</button>
<button class="flex flex-col items-center p-2 text-on-surface-variant hover:text-on-surface">
<span class="material-symbols-outlined" data-icon="settings_input_component">settings_input_component</span>
<span class="text-[10px] font-label-tech uppercase">Specs</span>
</button>
<button class="flex flex-col items-center p-2 text-on-surface-variant hover:text-on-surface">
<span class="material-symbols-outlined" data-icon="support_agent">support_agent</span>
<span class="text-[10px] font-label-tech uppercase">Support</span>
</button>
</nav>
</body></html>