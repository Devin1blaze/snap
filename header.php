<?php
/**
 * The header for our theme
 */

// Include the custom walker
require_once get_template_directory() . '/class-tailwind-nav-walker.php';

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    
    <!-- Consolidated Tailwind Configuration -->
    <script>
        window.tailwind = window.tailwind || {};
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#1A56DB",
                        "secondary": "#FBBF24",
                        "surface": "#FFFFFF",
                        "on-surface": "#0A0A0A",
                        "royal-blue": "#1A56DB",
                        "snap-yellow": "#FBBF24",
                        "snap-black": "#0A0A0A",
                        "primary-container": "#1A56DB",
                        "secondary-container": "#FBBF24",
                        "surface-container-low": "#F4F4F5"
                    },
                    fontFamily: {
                        "headline": ["Plus Jakarta Sans", "sans-serif"],
                        "body": ["Plus Jakarta Sans", "sans-serif"],
                        "label": ["Plus Jakarta Sans", "sans-serif"]
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        html, body {
            overflow-x: hidden;
            width: 100%;
            position: relative;
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .diagonal-band {
            clip-path: polygon(25% 0%, 100% 0%, 75% 100%, 0% 100%);
        }
        .industrial-glow:hover {
            box-shadow: 0 0 25px rgba(251, 191, 36, 0.4);
        }
        .yellow-underline {
            position: relative;
            display: inline-block;
        }
        .yellow-underline::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 4px;
            width: 100%;
            height: 12px;
            background-color: #FBBF24;
            z-index: -1;
            transform: skewX(-15deg);
            animation: growLine 0.6s ease-out forwards;
        }
        @keyframes growLine {
            from { width: 0; }
            to { width: 100%; }
        }
        
        /* Blueprint pattern used in industrial sections */
        .blueprint-pattern {
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.05) 1.5px, transparent 1.5px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.05) 1.5px, transparent 1.5px);
            background-size: 20px 20px;
        }

        /* Style adjustments for dynamic submenus */
        .sub-menu {
            text-align: left !important;
            min-width: 280px !important;
            left: 0 !important;
        }
        .sub-menu li {
            width: 100% !important;
        }
        .sub-menu li a {
            padding: 1rem 1.5rem !important;
            display: flex !important;
            align-items: center !important;
            width: 100% !important;
            text-transform: none !important;
            font-weight: 600 !important;
            font-size: 0.95rem !important;
            border-bottom: 1px solid rgba(255,255,255,0.05) !important;
            text-align: left !important;
            justify-content: flex-start !important;
            color: white !important;
            transition: all 0.2s ease !important;
        }
        .sub-menu li:last-child a {
            border-bottom: none !important;
        }
        .sub-menu li a:hover {
            background-color: rgba(255,255,255,0.08) !important;
            padding-left: 2rem !important;
            color: #FBBF24 !important;
        }

        /* Keyframes for Vertical Marquee */
        @keyframes marquee-vertical {
            from { transform: translateY(0); }
            to { transform: translateY(-100%); }
        }
        @keyframes marquee-vertical-reverse {
            from { transform: translateY(-100%); }
            to { transform: translateY(0); }
        }
        .animate-marquee-vertical {
            animation: marquee-vertical 40s linear infinite;
        }
        .animate-marquee-vertical-reverse {
            animation: marquee-vertical-reverse 40s linear infinite;
        }
    </style>
</head>
<body <?php body_class('bg-white text-[#0A0A0A]'); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    
    <!-- Top Contact Bar -->
    <div class="w-full bg-black text-white text-xs font-bold tracking-widest uppercase py-2 px-8 flex justify-between items-center z-50 relative border-b border-white/10 hidden md:flex">
        <div class="flex gap-6 items-center">
            <span class="flex items-center gap-2"><span class="material-symbols-outlined text-[14px] text-[#FBBF24]">call</span> +91 (20) 2445-8899</span>
            <span class="flex items-center gap-2"><span class="material-symbols-outlined text-[14px] text-[#FBBF24]">mail</span> sales@snapmarketing.in</span>
        </div>
        <div class="flex gap-4">
            <?php
            if ( has_nav_menu( 'top_bar' ) ) {
                wp_nav_menu( array(
                    'theme_location' => 'top_bar',
                    'container'      => false,
                    'menu_class'     => 'flex gap-4',
                    'fallback_cb'    => false,
                ) );
            } else {
                echo '<a href="/about" class="hover:text-[#FBBF24] transition-colors">About Us</a>';
                echo '<a href="/contact" class="hover:text-[#FBBF24] transition-colors">Support</a>';
            }
            ?>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="sticky top-0 w-full z-40 bg-black flex justify-between items-center px-8 py-0 shadow-2xl border-b-4 border-[#FBBF24]">
        <div class="text-2xl font-black text-white italic tracking-tighter">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
        </div>
        
        <div class="hidden md:flex items-center h-full">
            <?php
            if ( has_nav_menu( 'primary' ) ) {
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'flex gap-8 items-center h-full',
                    'walker'         => new Tailwind_Nav_Walker(),
                    'fallback_cb'    => false,
                ) );
            } else {
                ?>
                <ul class="flex gap-8 items-center h-full">
                    <li><a class="font-bold uppercase tracking-tight text-white hover:text-[#FBBF24] transition-colors py-6 border-b-4 border-transparent hover:border-[#FBBF24]" href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
                    <li><a class="font-bold uppercase tracking-tight text-white hover:text-[#FBBF24] transition-colors py-6 border-b-4 border-transparent hover:border-[#FBBF24]" href="/about">About Us</a></li>
                    <li class="relative group h-full">
                        <a class="font-bold uppercase tracking-tight text-white hover:text-[#FBBF24] transition-colors flex items-center py-6 border-b-4 border-transparent group-hover:border-[#FBBF24]" href="/shop">Products <span class="material-symbols-outlined text-[16px] ml-1 transition-transform group-hover:rotate-180">expand_more</span></a>
                        <ul class="sub-menu absolute left-0 top-full mt-0 w-72 bg-black shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top -translate-y-2 group-hover:translate-y-0 flex flex-col py-4 border-t-4 border-[#FBBF24]">
                            <li><a href="<?php echo snap_get_category_link('washroom-automations'); ?>">Washroom Automations</a></li>
                            <li><a href="<?php echo snap_get_category_link('commercial-refrigeration'); ?>">Commercial Refrigeration</a></li>
                            <li><a href="<?php echo snap_get_category_link('water-purifiers'); ?>">Water Purifiers</a></li>
                            <li><a href="<?php echo snap_get_category_link('vending-machines'); ?>">Vending Machines</a></li>
                            <li><a href="<?php echo snap_get_category_link('hygiene-ppe'); ?>">Hygiene & PPE</a></li>
                            <li><a href="<?php echo snap_get_category_link('entrance-solutions'); ?>">Entrance Solutions</a></li>
                        </ul>
                    </li>
                    <li><a class="font-bold uppercase tracking-tight text-white hover:text-[#FBBF24] transition-colors py-6 border-b-4 border-transparent hover:border-[#FBBF24]" href="/contact">Contact Us</a></li>
                </ul>
                <?php
            }
            ?>
        </div>

        <div class="flex items-center gap-6 ml-4">
            <a href="/request-a-quote" class="bg-[#FBBF24] text-black font-black py-3 px-6 uppercase text-sm tracking-widest hover:scale-95 transition-all duration-300 inline-block text-center hidden lg:block shadow-[5px_5px_0px_rgba(255,255,255,0.2)]">Request Quote</a>
            <a href="<?php echo is_user_logged_in() ? esc_url( wc_get_page_permalink( 'myaccount' ) ) : '/login'; ?>" class="text-white font-bold uppercase text-sm border-b-2 border-transparent hover:border-[#FBBF24] transition-all inline-block flex items-center gap-1">
                <span class="material-symbols-outlined text-[20px]">account_circle</span>
                <?php echo is_user_logged_in() ? 'Account' : 'Login'; ?>
            </a>
        </div>
    </nav>