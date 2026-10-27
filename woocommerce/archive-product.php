<?php
/**
 * Snap Marketing - B2B Multi-Product Family Showcase & Universal Category Template
 *
 * Implements the Chai Point + Snap Marketing hybrid layout:
 * - Alternating split-block showcase for flagship/featured models
 * - Dual-tab switcher (Machine Hardware vs Touchscreen Menu UI with zoom modal)
 * - Visual beverage chip palette beneath title
 * - Salient features 4-bullet grid + expandable operational accordion
 * - 5-row quick specs table in the card
 * - Comprehensive 48-row interactive technical comparison matrix across 7 categories
 * - Multi-select floating RFQ batch drawer + CF7 quote modal injection
 * - Retains standard retail catalog grid fallback for consumer categories
 *
 * @package SnapStitchTheme
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

$term = get_queried_object();
$category_name = woocommerce_page_title( false );
$category_desc = ( $term && isset( $term->description ) ) ? $term->description : ( ( $term && isset( $term->post_content ) ) ? $term->post_content : '' );

if ( ! function_exists( 'snap_b2b_beverage_icon' ) ) {
    function snap_b2b_beverage_icon( $drink ) {
        $d = strtolower( $drink );
        $icon = 'local_cafe';
        if ( strpos( $d, 'tea' ) !== false || strpos( $d, 'chai' ) !== false ) $icon = 'emoji_food_beverage';
        elseif ( strpos( $d, 'choc' ) !== false || strpos( $d, 'milo' ) !== false ) $icon = 'restaurant';
        elseif ( strpos( $d, 'water' ) !== false ) $icon = 'water_drop';
        elseif ( strpos( $d, 'frappe' ) !== false || strpos( $d, 'cold' ) !== false || strpos( $d, 'iced' ) !== false ) $icon = 'ac_unit';
        return '<span class="material-symbols-outlined text-xs text-[#1A56DB] align-middle">' . $icon . '</span>';
    }
}

// -----------------------------------------------------------------------------
// B2B CATEGORY DETECTION ENGINE
// -----------------------------------------------------------------------------
$is_b2b_category = false;
if ( $term && ! is_wp_error( $term ) && isset( $term->slug ) ) {
    if ( $term->slug === 'b2b' || strpos( $term->slug, 'b2b' ) !== false ) {
        $is_b2b_category = true;
    }
    if ( ! $is_b2b_category && isset( $term->term_id ) ) {
        foreach ( get_ancestors( $term->term_id, 'product_cat' ) as $anc_id ) {
            $anc = get_term( $anc_id, 'product_cat' );
            if ( $anc && strpos( $anc->slug, 'b2b' ) !== false ) { $is_b2b_category = true; break; }
        }
    }
    $b2b_commercial_slugs = array(
        'commercial-refrigeration', 'b2b-commercial-refrigeration', 'refrigeration', 'refrigeration-2',
        'cold-storages', 'cold-storages-2', 'chillers', 'chillers-central-air-conditioning',
        'deep-freezers', 'deep-freezers-2', 'water-coolers', 'storage-water-coolers',
        'bottled-water-dispensers', 'bottled-water-dispensers-2', 'visi-coolers', 'visi-coolers-2',
        'washroom-automations', 'hygiene-ppe', 'entrance-solutions', 'vending-machines',
        'coffee-vending-machines', 'commercial-coffee-vending-machines', 'brewing-bots',
        'central-air-conditioning', 'ducted-systems', 'vrf-systems', 'air-coolers', 'air-coolers-2',
        'desert-air-coolers', 'desert-air-coolers-2', 'b2b-air-coolers', 'b2b-water-purifiers',
        'ice-machines', 'kitchen-refrigeration-products', 'medical-refrigeration-products',
        'supermarket-refrigeration', 'reach-in-chillers-and-freezers', 'undercounter-chillers-and-freezers',
        'vaccine-storage-products', 'b2b-room-air-conditioners'
    );
    if ( ! $is_b2b_category && in_array( $term->slug, $b2b_commercial_slugs, true ) ) {
        $is_b2b_category = true;
    }
    if ( ! $is_b2b_category && have_posts() ) {
        global $wp_query;
        if ( ! empty( $wp_query->posts ) ) {
            $sample_limit = min( 6, count( $wp_query->posts ) );
            for ( $i = 0; $i < $sample_limit; $i++ ) {
                if ( function_exists( 'snap_stitch_is_b2b_product' ) && snap_stitch_is_b2b_product( $wp_query->posts[ $i ]->ID ) ) {
                    $is_b2b_category = true; break;
                }
            }
        }
    }
}
?>

<div class="snap-woo-wrapper">
    <?php do_action( 'woocommerce_before_main_content' ); ?>

    <?php if ( $is_b2b_category ) : ?>
        <?php
        $family_args = array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => 50,
            'tax_query'      => array( array( 'taxonomy' => 'product_cat', 'field' => 'term_id', 'terms' => $term->term_id, 'include_children' => true ) ),
            'orderby'        => 'menu_order title',
            'order'          => 'ASC',
        );
        $family_query = new WP_Query( $family_args );
        $all_products = array();

        if ( $family_query->have_posts() ) {
            while ( $family_query->have_posts() ) {
                $family_query->the_post();
                global $product;
                if ( ! is_a( $product, 'WC_Product' ) ) $product = wc_get_product( get_the_ID() );
                if ( ! $product ) continue;

                $p_id = $product->get_id();
                $specs_meta = get_post_meta( $p_id, '_technical_specs', true );
                $salient_meta = get_post_meta( $p_id, '_salient_features', true );
                $bev_meta = get_post_meta( $p_id, '_beverage_menu', true ) ?: get_post_meta( $p_id, '_menu_items', true );
                $bev_array = is_array( $bev_meta ) ? $bev_meta : ( ! empty( $bev_meta ) ? array_map( 'trim', explode( ',', $bev_meta ) ) : array() );

                $all_products[] = array(
                    'id'               => $p_id,
                    'title'            => $product->get_name(),
                    'sku'              => $product->get_sku() ? $product->get_sku() : 'SNAP-' . $p_id,
                    'permalink'        => $product->get_permalink(),
                    'image_url'        => wp_get_attachment_image_url( $product->get_image_id(), 'large' ) ?: wc_placeholder_img_src(),
                    'thumb_url'        => wp_get_attachment_image_url( $product->get_image_id(), 'thumbnail' ) ?: wc_placeholder_img_src(),
                    'specs'            => is_array( $specs_meta ) ? $specs_meta : array(),
                    'salient_features' => is_array( $salient_meta ) ? $salient_meta : array(),
                    'beverage_menu'    => $bev_array,
                    'menu_image_url'   => get_post_meta( $p_id, '_menu_image_url', true ),
                    'brochure_url'     => get_post_meta( $p_id, '_brochure_url', true ),
                    'is_featured'      => $product->is_featured(),
                    'excerpt'          => wp_strip_all_tags( $product->get_short_description() ),
                );
            }
            wp_reset_postdata();
        }
        $total_models = count( $all_products );
        $is_coffee_family = ( ( $term && in_array( $term->slug, array( 'coffee-vending-machines', 'commercial-coffee-vending-machines', 'vending-machines' ), true ) ) || ( ! empty( $all_products ) && strpos( $all_products[0]['sku'], 'NESTLE' ) !== false ) );
        $theme_uri = get_template_directory_uri();
        $manifest_path = get_template_directory() . '/images/nestle-machines/download_manifest.json';
        $nestle_manifest = file_exists( $manifest_path ) ? json_decode( file_get_contents( $manifest_path ), true ) : array();
        $nestle_hardware = array(
            'premio'    => array( 'front' => $theme_uri . '/images/nestle-machines/hardware/premio-front.png', 'left' => $theme_uri . '/images/nestle-machines/hardware/premio-left.png', 'right' => $theme_uri . '/images/nestle-machines/hardware/premio-right.png', 'menu' => $theme_uri . '/images/nestle-machines/premio-menu.webp' ),
            'amigo'     => array( 'front' => $theme_uri . '/images/nestle-machines/hardware/amigo-front.png', 'left' => $theme_uri . '/images/nestle-machines/hardware/amigo-left.png', 'right' => $theme_uri . '/images/nestle-machines/hardware/amigo-right.png', 'menu' => $theme_uri . '/images/nestle-machines/amigo-menu.webp' ),
            'duo_gusto' => array( 'front' => $theme_uri . '/images/nestle-machines/hardware/duo-gusto-front.png', 'left' => $theme_uri . '/images/nestle-machines/hardware/duo-gusto-left.png', 'right' => $theme_uri . '/images/nestle-machines/hardware/duo-gusto-right.png', 'menu' => $theme_uri . '/images/nestle-machines/duo-gusto-menu.webp' ),
            'solution'  => array( 'front' => $theme_uri . '/images/nestle-machines/hardware/solution-front.webp', 'left' => $theme_uri . '/images/nestle-machines/hardware/solution-left.webp', 'right' => $theme_uri . '/images/nestle-machines/hardware/solution-right.webp', 'menu' => $theme_uri . '/images/nestle-machines/solution-menu.webp' ),
            'spectra'   => array( 'front' => $theme_uri . '/images/nestle-machines/hardware/spectra-front.png', 'left' => $theme_uri . '/images/nestle-machines/hardware/spectra-left.png', 'right' => $theme_uri . '/images/nestle-machines/hardware/spectra-right.jpg', 'menu' => $theme_uri . '/images/nestle-machines/spectra-menu.webp' ),
            'frio'      => array( 'front' => $theme_uri . '/images/nestle-machines/hardware/frio-front.webp', 'left' => $theme_uri . '/images/nestle-machines/hardware/frio-left.png', 'right' => $theme_uri . '/images/nestle-machines/hardware/frio-right.png', 'menu' => $theme_uri . '/images/nestle-machines/frio-menu.webp' ),
        );
        ?>

        <!-- 1. Architectural Solution Hero -->
        <section class="bg-[#0A0A0A] text-white relative overflow-hidden border-b-4 border-[#1A56DB] pt-32 sm:pt-36 md:pt-44 pb-12 sm:pb-16">
            <div class="absolute inset-0 industrial-diagonal bg-[#1A56DB] opacity-10 w-2/3 pointer-events-none"></div>
            <div class="container mx-auto px-4 sm:px-6 md:px-12 relative z-10">
                <nav class="flex mb-4 sm:mb-6 space-x-2 text-[10px] md:text-xs font-black uppercase tracking-widest text-[#FBBF24]">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-white transition-colors">Home</a>
                    <span class="text-white/30">/</span>
                    <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="hover:text-white transition-colors">B2B Solutions</a>
                    <span class="text-white/30">/</span>
                    <span class="text-white"><?php echo esc_html( $category_name ); ?></span>
                </nav>

                <div class="max-w-4xl">
                    <span class="inline-flex items-center gap-2 bg-[#FBBF24] text-black font-black text-[10px] sm:text-[11px] px-3.5 py-1.5 uppercase tracking-widest mb-4">
                        <span class="w-2 h-2 bg-black inline-block"></span> Enterprise Fleet &amp; Facility Procurement · Complete Series Overview
                    </span>
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight uppercase leading-[1.08] mb-5 sm:mb-6 break-words">
                        <?php echo esc_html( $category_name ); ?>
                    </h1>
                    <p class="text-sm sm:text-base md:text-lg text-zinc-300 leading-relaxed font-medium mb-6 sm:mb-8 max-w-3xl">
                        <?php echo $category_desc ? wp_kses_post( $category_desc ) : "Complete commercial brewing &amp; beverage automation fleet engineered for continuous multi-shift corporate and institutional operation. Review engineering throughput, compare specifications, and generate consolidated multi-model Request for Quotations (RFQ) with verified GST input credit."; ?>
                    </p>

                    <!-- Trust Pillars -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 pt-5 sm:pt-6 border-t border-white/10 mb-6 sm:mb-8">
                        <?php foreach ( array( array('verified','Direct OEM Supply','Tiered Volume Pricing'), array('local_shipping','Pan-India Logistics','Insured Dock Delivery'), array('engineering','Factory QA Certified','100% Pre-Dispatch Inspected'), array('receipt_long','Corporate GST Invoicing','Verified Input Tax Credit') ) as $tp ) : ?>
                            <div class="bg-zinc-900/60 p-3 border border-white/10">
                                <div class="text-[#FBBF24] font-black text-xs sm:text-sm uppercase tracking-wider flex items-center gap-1.5"><span class="material-symbols-outlined text-base"><?php echo $tp[0]; ?></span> <?php echo $tp[1]; ?></div>
                                <div class="text-zinc-400 text-[10px] sm:text-xs font-bold uppercase mt-1"><?php echo $tp[2]; ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Dual Action CTAs -->
                    <div class="flex flex-col sm:flex-row flex-wrap items-stretch sm:items-center gap-3">
                        <button class="h-[52px] w-full sm:w-auto bg-[#FBBF24] hover:bg-yellow-400 active:scale-95 text-black px-6 sm:px-7 font-black uppercase text-xs tracking-widest flex items-center justify-center gap-2 shadow-xl transition-all js-open-quote-modal" data-product="<?php echo esc_attr( $category_name ); ?>" data-sku="SERIES-ALL" data-custom-message="<?php echo esc_attr( "Bulk Price Inquiry for {$category_name} Series:\nPlease provide complete price schedule, MOQ tiers, and technical specification submittals for our facility." ); ?>"><span class="material-symbols-outlined text-lg">request_quote</span><span>Request Category Price List</span></button>
                        <a href="tel:+919823012724" class="h-[52px] w-full sm:w-auto bg-white hover:bg-zinc-100 active:scale-95 text-black px-5 sm:px-6 font-black uppercase text-xs tracking-widest flex items-center justify-center gap-2 shadow-xl transition-all"><span class="material-symbols-outlined text-lg">call</span><span>Call Technical Sales: +91 98230 12724</span></a>
                        <a href="#spec-matrix" class="h-[52px] w-full sm:w-auto border-2 border-white/40 hover:border-white hover:bg-white hover:text-black active:scale-95 text-white px-5 sm:px-6 font-black uppercase text-xs tracking-widest flex items-center justify-center gap-2 bg-black/30 backdrop-blur-sm transition-all"><span>Compare Technical Specs (<?php echo esc_html( $total_models ); ?>)</span><span class="material-symbols-outlined text-lg">arrow_downward</span></a>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. Sticky Subnav Bar -->
        <div class="sticky top-20 z-40 bg-[#0A0A0A]/95 backdrop-blur-md border-b-2 border-[#1A56DB] px-4 sm:px-6 md:px-12 py-3 shadow-xl">
            <div class="container mx-auto flex items-center justify-between gap-3">
                <div class="flex items-center gap-4 sm:gap-6 overflow-x-auto no-scrollbar text-xs font-bold uppercase tracking-wider py-1">
                    <a href="#flagship-showcase" class="text-white hover:text-[#FBBF24] transition-colors whitespace-nowrap flex items-center gap-1.5 shrink-0"><span class="w-2 h-2 bg-[#FBBF24] inline-block"></span> Flagship Series (<?php echo esc_html( min( 6, $total_models ) ); ?>)</a>
                    <a href="#spec-matrix" class="text-zinc-400 hover:text-white transition-colors whitespace-nowrap shrink-0">Spec Matrix (<?php echo esc_html( $total_models ); ?>)</a>
                    <a href="#procurement-faq" class="text-zinc-400 hover:text-white transition-colors whitespace-nowrap shrink-0 hidden md:inline">Procurement &amp; Warranty Terms</a>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <span id="sticky-counter" class="text-[#FBBF24] font-black text-[11px] uppercase tracking-wider hidden sm:inline mr-1"><span id="sticky-counter-num">0</span> Models Selected</span>
                    <a href="tel:+919823012724" class="h-[38px] border-2 border-white/30 hover:border-white hover:bg-white hover:text-black active:scale-95 text-white text-[11px] font-black uppercase px-3 flex items-center justify-center gap-1.5 transition-all"><span class="material-symbols-outlined text-sm">call</span><span class="hidden md:inline">Call Sales</span></a>
                    <button class="h-[38px] bg-[#FBBF24] hover:bg-yellow-400 active:scale-95 text-black text-[11px] font-black uppercase px-3.5 flex items-center justify-center gap-1.5 transition-all shadow-md js-open-quote-modal" data-product="<?php echo esc_attr( $category_name ); ?>" data-sku="SERIES-QUOTE"><span class="material-symbols-outlined text-sm">request_quote</span><span>Series RFQ</span></button>
                </div>
            </div>
        </div>

        <main class="container mx-auto px-4 sm:px-6 md:px-12 py-12 sm:py-16">
            <!-- 3. Flagship Alternating Split Blocks -->
            <section id="flagship-showcase" class="mb-20 sm:mb-24">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8 sm:mb-12 border-b-4 border-[#1A56DB] pb-4">
                    <div>
                        <span class="text-[#1A56DB] font-black uppercase tracking-widest text-xs flex items-center gap-1.5"><span class="w-1.5 h-1.5 bg-[#1A56DB] inline-block"></span> Flagship Commercial Fleet</span>
                        <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold uppercase tracking-tight text-[#0A0A0A] mt-1">Engineered For Continuous Multi-Shift Operation</h2>
                    </div>
                    <p class="text-zinc-600 font-medium text-xs sm:text-sm max-w-md">Review high-capacity commercial models with hardware cutouts and touchscreen menu interfaces. Select multiple items to build an institutional consolidated quote.</p>
                </div>

                <?php if ( ! empty( $all_products ) ) : ?>
                    <div class="space-y-12 sm:space-y-16">
                        <?php
                        $canonical_models = array();
                        $seen_fams = array();
                        foreach ( $all_products as $p_item ) {
                            $f_k = '';
                            foreach ( array('PREMIO'=>'premio','AMIGO'=>'amigo','DUO'=>'duo_gusto','GUSTO'=>'duo_gusto','SOL'=>'solution','SPEC'=>'spectra','FRIO'=>'frio') as $nd => $k ) {
                                if ( stripos( $p_item['sku'], $nd ) !== false || stripos( $p_item['title'], $nd ) !== false ) { $f_k = $k; break; }
                            }
                            if ( $f_k ) {
                                if ( isset( $seen_fams[ $f_k ] ) ) continue;
                                $seen_fams[ $f_k ] = true;
                            }
                            $canonical_models[] = $p_item;
                            if ( count( $canonical_models ) >= 6 ) break;
                        }
                        foreach ( $canonical_models as $idx => $item ) :
                            $is_even = ( $idx % 2 === 0 );
                            $card_uid = 'card-' . $item['id'] . '-' . $idx;
                            $m_key = '';
                            foreach ( array('PREMIO'=>'premio','AMIGO'=>'amigo','DUO'=>'duo_gusto','GUSTO'=>'duo_gusto','SOL'=>'solution','SPEC'=>'spectra','FRIO'=>'frio') as $nd => $k ) {
                                if ( stripos( $item['sku'], $nd ) !== false || stripos( $item['title'], $nd ) !== false ) { $m_key = $k; break; }
                            }
                            $m_data = ( $m_key && isset( $nestle_hardware[ $m_key ] ) ) ? $nestle_hardware[ $m_key ] : null;
                            $front_img = $m_data ? $m_data['front'] : $item['image_url'];
                            $menu_img = $m_data ? $m_data['menu'] : ( ! empty( $item['menu_image_url'] ) ? $item['menu_image_url'] : '' );
                            $has_menu_img = ! empty( $menu_img );
                            $bev_gallery = ( $m_key && ! empty( $nestle_manifest['machine_beverages_map'][ $m_key ] ) ) ? $nestle_manifest['machine_beverages_map'][ $m_key ] : array();
                            $angles = $m_data ? array( 'Front' => $m_data['front'], 'Left 45°' => $m_data['left'], 'Right 45°' => $m_data['right'] ) : array( 'Front' => $item['image_url'] );
                            if ( empty( $item['beverage_menu'] ) && ! empty( $bev_gallery ) ) {
                                $item['beverage_menu'] = array_column( $bev_gallery, 'name' );
                            }
                        ?>
                        <article class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8 lg:gap-12 items-center bg-white border-2 border-zinc-200 p-5 sm:p-8 md:p-10 relative transition-all duration-300 hover:border-black" style="box-shadow: 6px 6px 0px 0px #1A56DB;">
                            <!-- Visual Column: Dual-Tab Switcher (lg:col-span-5) -->
                            <div class="lg:col-span-5 <?php echo $is_even ? 'lg:order-1' : 'lg:order-2'; ?> flex flex-col justify-center">
                                <div class="relative bg-zinc-50 border border-zinc-200 p-4 sm:p-5 overflow-hidden group">
                                    <div class="flex items-center gap-1.5 mb-3 z-20 relative">
                                        <button type="button" class="js-card-tab-btn flex-1 py-1.5 px-2 text-[10px] sm:text-[11px] font-black uppercase tracking-wider flex items-center justify-center gap-1.5 border-2 border-black bg-[#0A0A0A] text-[#FBBF24] transition-all shadow-sm active:scale-95" data-card="<?php echo esc_attr( $card_uid ); ?>" data-tab-target="hardware"><span class="material-symbols-outlined text-xs">precision_manufacturing</span><span>Machine Hardware</span></button>
                                        <?php if ( $has_menu_img ) : ?>
                                        <button type="button" class="js-card-tab-btn flex-1 py-1.5 px-2 text-[10px] sm:text-[11px] font-black uppercase tracking-wider flex items-center justify-center gap-1.5 border-2 border-zinc-300 bg-white hover:bg-zinc-100 text-zinc-700 transition-all shadow-sm active:scale-95" data-card="<?php echo esc_attr( $card_uid ); ?>" data-tab-target="menu"><span class="material-symbols-outlined text-xs">touch_app</span><span>Touchscreen Menu UI</span></button>
                                        <?php endif; ?>
                                    </div>
                                    <!-- Tab 1: Machine Hardware Cutout + Multi-Angle Strip -->
                                    <div class="js-tab-pane flex flex-col justify-between" data-card="<?php echo esc_attr( $card_uid ); ?>" data-tab-content="hardware">
                                        <div class="relative aspect-[4/3] sm:aspect-square flex items-center justify-center overflow-hidden bg-white border border-zinc-200 p-4 sm:p-6">
                                            <span class="absolute top-0 left-0 bg-[#FBBF24] text-black font-black text-[10px] uppercase px-2 py-0.5 tracking-wider z-10">MODEL: <?php echo esc_html( $item['sku'] ); ?></span>
                                            <label class="absolute top-0 right-0 z-10 flex items-center gap-1.5 bg-[#0A0A0A] text-white text-[10px] font-black uppercase px-2.5 py-1.5 cursor-pointer border border-zinc-700 hover:border-[#FBBF24] transition-all" title="Add to batch quote">
                                                <input type="checkbox" class="b2b-sku-checkbox accent-[#FBBF24] w-4 h-4 cursor-pointer" data-id="<?php echo esc_attr( $item['id'] ); ?>" data-title="<?php echo esc_attr( $item['title'] ); ?>" data-sku="<?php echo esc_attr( $item['sku'] ); ?>">
                                                <span class="tracking-wider">Add to Batch RFQ</span>
                                            </label>
                                            <img id="main-img-<?php echo esc_attr( $card_uid ); ?>" src="<?php echo esc_url( $front_img ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>" class="w-full h-full max-h-[260px] sm:max-h-[320px] md:max-h-[360px] object-contain mix-blend-multiply transition-all duration-300 p-2 sm:p-3" loading="lazy">
                                        </div>
                                        <!-- Multi-Angle Thumbnail Strip -->
                                        <div class="mt-2.5 pt-2 border-t border-zinc-200 flex items-center justify-between gap-1.5">
                                            <span class="text-[9px] font-black uppercase tracking-wider text-zinc-500 flex items-center gap-1"><span class="w-1.5 h-1.5 bg-[#1A56DB] inline-block"></span> View Angle:</span>
                                            <div class="flex items-center gap-1">
                                                <?php foreach ( $angles as $ang_label => $ang_src ) : $is_first = ( $ang_label === 'Front' ); ?>
                                                <button type="button" class="js-angle-btn px-2 py-0.5 sm:px-2.5 sm:py-1 text-[9px] sm:text-[10px] font-black uppercase tracking-wider border transition-all flex items-center gap-1 <?php echo $is_first ? 'border-[#0A0A0A] bg-[#0A0A0A] text-[#FBBF24] shadow-sm' : 'border-zinc-300 bg-white hover:bg-zinc-100 text-zinc-700'; ?>" data-card="<?php echo esc_attr( $card_uid ); ?>" data-src="<?php echo esc_url( $ang_src ); ?>">
                                                    <span><?php echo esc_html( $ang_label ); ?></span>
                                                </button>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Tab 2: Touchscreen Menu UI + Interactive Beverage Gallery -->
                                    <?php if ( $has_menu_img ) : ?>
                                    <div class="js-tab-pane hidden flex flex-col justify-between" data-card="<?php echo esc_attr( $card_uid ); ?>" data-tab-content="menu">
                                        <div class="relative aspect-video sm:aspect-[4/3] flex items-center justify-center bg-zinc-950 p-2 overflow-hidden border border-zinc-200">
                                            <span class="absolute top-2 left-2 bg-[#1A56DB] text-white font-black text-[9px] uppercase px-2 py-0.5 tracking-wider z-10 shadow-sm">UI INTERFACE PREVIEW</span>
                                            <img src="<?php echo esc_url( $menu_img ); ?>" alt="<?php echo esc_attr( $item['title'] . ' Menu Interface' ); ?>" class="w-full h-full object-contain cursor-pointer hover:scale-105 transition-transform duration-300 js-open-zoom-modal" data-zoom-src="<?php echo esc_url( $menu_img ); ?>" data-zoom-title="<?php echo esc_attr( $item['title'] . ' — High-Definition Touchscreen Menu UI' ); ?>" loading="lazy">
                                            <button type="button" class="absolute bottom-2 left-1/2 -translate-x-1/2 bg-[#0A0A0A]/90 hover:bg-[#1A56DB] text-white text-[10px] font-black uppercase px-3 py-1.5 tracking-wider border border-white/20 shadow-lg flex items-center gap-1.5 js-open-zoom-modal transition-colors whitespace-nowrap" data-zoom-src="<?php echo esc_url( $menu_img ); ?>" data-zoom-title="<?php echo esc_attr( $item['title'] . ' — High-Definition Touchscreen Menu UI' ); ?>"><span class="material-symbols-outlined text-xs">zoom_in</span><span>Tap to Zoom Menu</span></button>
                                        </div>
                                        <?php if ( ! empty( $bev_gallery ) ) : ?>
                                        <div class="mt-2.5 pt-2 border-t border-zinc-200">
                                            <div class="flex items-center justify-between mb-1.5">
                                                <span class="text-[10px] font-black uppercase tracking-wider text-zinc-700 flex items-center gap-1.5"><span class="w-1.5 h-1.5 bg-[#FBBF24] inline-block"></span><span>Beverage Menu Gallery (<?php echo count( $bev_gallery ); ?> Recipes):</span></span>
                                                <span class="text-[9px] font-mono text-zinc-400 uppercase tracking-widest hidden sm:inline">Tap cup to inspect</span>
                                            </div>
                                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-1.5 max-h-52 overflow-y-auto pr-1">
                                                <?php foreach ( $bev_gallery as $b_item ) :
                                                    $b_name = is_array( $b_item ) ? $b_item['name'] : $b_item;
                                                    $b_img_rel = ( is_array( $b_item ) && ! empty( $b_item['image'] ) ) ? basename( $b_item['image'] ) : '';
                                                    $b_img_url = $b_img_rel ? ( $theme_uri . '/images/nestle-machines/beverages/' . $b_img_rel ) : '';
                                                ?>
                                                <div class="group bg-white hover:bg-yellow-50/50 border border-zinc-200 hover:border-[#1A56DB] p-1.5 flex flex-col items-center justify-between text-center transition-all duration-200 hover:-translate-y-0.5 hover:shadow-sm cursor-pointer js-open-zoom-modal" data-zoom-src="<?php echo esc_url( $b_img_url ?: $menu_img ); ?>" data-zoom-title="<?php echo esc_attr( $item['title'] . ' — ' . $b_name ); ?>">
                                                    <div class="w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center p-0.5 overflow-hidden">
                                                        <?php if ( $b_img_url ) : ?>
                                                            <img src="<?php echo esc_url( $b_img_url ); ?>" alt="<?php echo esc_attr( $b_name ); ?>" class="max-w-full max-h-full object-contain group-hover:scale-110 transition-transform duration-200" loading="lazy">
                                                        <?php else : ?>
                                                            <?php echo snap_b2b_beverage_icon( $b_name ); ?>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="text-[9px] sm:text-[10px] font-bold uppercase tracking-tight text-[#0A0A0A] group-hover:text-[#1A56DB] line-clamp-1 w-full mt-1"><?php echo esc_html( $b_name ); ?></div>
                                                </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Specification & Action Column (lg:col-span-7) -->
                            <div class="lg:col-span-7 <?php echo $is_even ? 'lg:order-2' : 'lg:order-1'; ?> flex flex-col justify-between">
                                <div>
                                    <div class="flex flex-wrap items-center gap-2 mb-2">
                                        <span class="bg-[#1A56DB] text-white font-black text-[9px] uppercase px-2 py-0.5 tracking-widest">Commercial Heavy Duty</span>
                                        <span class="text-zinc-500 text-[11px] font-bold uppercase tracking-wider">SKU: <?php echo esc_html( $item['sku'] ); ?></span>
                                    </div>
                                    <h3 class="text-xl sm:text-2xl md:text-3xl font-extrabold uppercase text-[#0A0A0A] tracking-tight mb-2"><?php echo esc_html( $item['title'] ); ?></h3>

                                    <!-- Visual Beverage Chip Palette Directly Beneath Title -->
                                    <?php if ( ! empty( $item['beverage_menu'] ) ) : ?>
                                    <div class="mb-4">
                                        <div class="text-[10px] font-black uppercase text-zinc-500 tracking-wider mb-1.5 flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 bg-[#1A56DB] inline-block"></span>
                                            <span>Beverage Menu Capability (<?php echo count( $item['beverage_menu'] ); ?> Selections):</span>
                                        </div>
                                        <div class="flex flex-wrap gap-1.5">
                                            <?php foreach ( $item['beverage_menu'] as $bev ) : $bev_icon = snap_b2b_beverage_icon( $bev ); ?>
                                                <span class="inline-flex items-center gap-1 bg-zinc-100 border border-zinc-300 text-[#0A0A0A] text-[10px] font-bold px-2 py-0.5 uppercase tracking-wide hover:border-black transition-colors">
                                                    <span><?php echo $bev_icon; ?></span><span><?php echo esc_html( $bev ); ?></span>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>

                                    <?php if ( ! empty( $item['excerpt'] ) ) : ?>
                                        <p class="text-zinc-600 text-xs sm:text-sm font-medium mb-4 leading-relaxed"><?php echo esc_html( $item['excerpt'] ); ?></p>
                                    <?php endif; ?>

                                    <!-- Salient Features: 4-Bullet Grid + Expandable Accordion -->
                                    <div class="mb-5 bg-zinc-50 border border-zinc-200 p-3.5 sm:p-4">
                                        <div class="text-[10px] font-black uppercase text-zinc-500 tracking-wider mb-2 flex items-center gap-1.5"><span class="w-1.5 h-1.5 bg-[#FBBF24] inline-block"></span><span>Salient Operational Features:</span></div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs font-semibold text-[#0A0A0A]">
                                            <?php 
                                            $features = ! empty( $item['salient_features'] ) ? $item['salient_features'] : array( 'Heavy-Duty Continuous 24/7 Commercial Duty Cycle', 'Full GST Input Tax Credit Invoicing (HSN 8476)', 'Factory Certified Quality Assurance & Inspection', 'Pan-India Maintenance & Direct OEM Spare Parts' );
                                            $top_features = array_slice( $features, 0, 4 );
                                            $more_features = array_slice( $features, 4 );
                                            foreach ( $top_features as $feat ) : ?>
                                                <div class="flex items-start gap-1.5"><span class="material-symbols-outlined text-sm text-[#1A56DB] shrink-0 font-bold mt-0.5">check_circle</span><span class="leading-snug"><?php echo esc_html( $feat ); ?></span></div>
                                            <?php endforeach; ?>
                                        </div>
                                        <?php if ( ! empty( $more_features ) ) : ?>
                                        <div id="features-drawer-<?php echo esc_attr( $card_uid ); ?>" class="hidden mt-3 pt-3 border-t border-zinc-200 grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs font-medium text-zinc-700">
                                            <?php foreach ( $more_features as $m_feat ) : ?>
                                                <div class="flex items-start gap-1.5"><span class="material-symbols-outlined text-sm text-[#1A56DB] shrink-0 font-bold mt-0.5">check_circle</span><span class="leading-snug"><?php echo esc_html( $m_feat ); ?></span></div>
                                            <?php endforeach; ?>
                                        </div>
                                        <button type="button" class="text-[11px] font-black uppercase text-[#1A56DB] hover:text-[#0A0A0A] flex items-center gap-1 mt-2.5 js-toggle-features transition-colors" data-target="features-drawer-<?php echo esc_attr( $card_uid ); ?>"><span>+ View Full Operational Highlights</span></button>
                                        <?php endif; ?>
                                    </div>

                                    <!-- 5-Row Quick-Specs Table with Clear Headers -->
                                    <div class="border border-zinc-200 mb-5 overflow-hidden">
                                        <table class="w-full text-left text-xs">
                                            <thead class="bg-zinc-100 text-[10px] font-black uppercase text-zinc-600 border-b border-zinc-200">
                                                <tr><th class="py-2 px-3 sm:px-3.5 border-r border-zinc-200 w-2/5 sm:w-1/3">Engineering Parameter</th><th class="py-2 px-3 sm:px-3.5">Verified Specification</th></tr>
                                            </thead>
                                            <tbody class="divide-y divide-zinc-200">
                                                <?php
                                                $quick_specs = ! empty( $item['specs'] ) ? array_slice( $item['specs'], 0, 5 ) : array(
                                                    array('name'=>'Duty Cycle','value'=>'Continuous 24/7 Heavy Duty'), array('name'=>'Power Supply','value'=>'230V AC / 50 Hz Standard'), array('name'=>'Compliance','value'=>'FSSAI & CE Industrial Standard'), array('name'=>'Invoicing','value'=>'100% GST Input Credit Verified'), array('name'=>'Warranty & AMC','value'=>'Comprehensive Pan-India AMC Available')
                                                );
                                                foreach ( $quick_specs as $spec ) : ?>
                                                    <tr class="odd:bg-zinc-50 even:bg-white"><td class="py-2 px-3 sm:px-3.5 font-bold uppercase text-zinc-500 w-2/5 sm:w-1/3 border-r border-zinc-200"><?php echo esc_html( $spec['name'] ); ?></td><td class="py-2 px-3 sm:px-3.5 font-extrabold text-[#0A0A0A]"><?php echo esc_html( $spec['value'] ); ?></td></tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Action Button Bar: Normalized 4-Button Grid (Uniform 48px Height) -->
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 sm:gap-2.5 pt-2 w-full">
                                    <button class="h-[48px] w-full bg-[#FBBF24] hover:bg-yellow-400 active:scale-95 text-black font-black uppercase text-xs tracking-wider flex items-center justify-center gap-1.5 shadow-md transition-all js-open-quote-modal" data-product="<?php echo esc_attr( $item['title'] ); ?>" data-sku="<?php echo esc_attr( $item['sku'] ); ?>" title="Request quotation"><span class="material-symbols-outlined text-base">request_quote</span><span>Quote</span></button>
                                    <a href="tel:+919823012724" class="h-[48px] w-full bg-[#0A0A0A] hover:bg-[#1A56DB] active:scale-95 text-white font-bold uppercase text-xs tracking-wider flex items-center justify-center gap-1.5 transition-all shadow-md"><span class="material-symbols-outlined text-base">call</span><span>Call</span></a>
                                    <a href="https://wa.me/919823012724?text=<?php echo rawurlencode( "Hi Snap Marketing, I would like to inquire about {$item['title']} (Model: {$item['sku']})." ); ?>" target="_blank" rel="noopener noreferrer" class="h-[48px] w-full bg-[#25D366] hover:bg-[#128C7E] active:scale-95 text-white font-bold uppercase text-xs tracking-wider flex items-center justify-center gap-1.5 transition-all shadow-md"><svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg><span>WhatsApp</span></a>
                                    <?php if ( ! empty( $item['brochure_url'] ) ) : ?>
                                        <a href="<?php echo esc_url( $item['brochure_url'] ); ?>" target="_blank" rel="noopener noreferrer" class="h-[48px] w-full border-2 border-black hover:bg-black hover:text-white active:scale-95 text-black font-bold uppercase text-xs tracking-wider flex items-center justify-center gap-1.5 transition-all shadow-md"><span class="material-symbols-outlined text-base">download</span><span>Brochure</span></a>
                                    <?php else : ?>
                                        <button class="h-[48px] w-full border-2 border-black hover:bg-black hover:text-white active:scale-95 text-black font-bold uppercase text-xs tracking-wider flex items-center justify-center gap-1.5 transition-all shadow-md js-open-quote-modal" data-product="<?php echo esc_attr( $item['title'] ); ?>" data-sku="<?php echo esc_attr( $item['sku'] ); ?>" data-custom-message="<?php echo esc_attr( "Requesting Engineering Datasheet & Price Schedule for {$item['title']} (Model: {$item['sku']})" ); ?>"><span class="material-symbols-outlined text-base">description</span><span>Datasheet</span></button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>

            <!-- 4. Exhaustive Technical Comparison Matrix (48-Row Across 7 Categories) -->
            <section id="spec-matrix" class="mb-20 sm:mb-24 pt-6 sm:pt-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6 sm:mb-8 border-b-4 border-[#1A56DB] pb-4">
                    <div>
                        <span class="text-[#1A56DB] font-black uppercase tracking-widest text-xs flex items-center gap-1.5"><span class="w-1.5 h-1.5 bg-[#1A56DB] inline-block"></span> Technical Comparison Matrix</span>
                        <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold uppercase tracking-tight text-[#0A0A0A] mt-1">Complete Family Comparison &amp; Engineering Specs</h2>
                    </div>
                    <div class="text-xs font-bold uppercase text-zinc-500">Total <?php echo esc_html( $total_models ); ?> models cataloged in this family</div>
                </div>

                <div class="lg:hidden flex items-center justify-between text-[11px] font-bold text-zinc-800 bg-yellow-50 px-3.5 py-2.5 border-2 border-b-0 border-[#0A0A0A]">
                    <div class="flex items-center gap-1.5"><span class="material-symbols-outlined text-sm text-[#1A56DB]">swipe</span><span>Swipe horizontally to compare 48 specifications across 7 categories</span></div>
                    <span class="text-[10px] uppercase font-black text-[#1A56DB] shrink-0">&larr; Scroll &rarr;</span>
                </div>

                <div class="overflow-x-auto border-2 border-[#0A0A0A] bg-white shadow-2xl">
                    <?php if ( $is_coffee_family ) : 
                        $coffee_sku_map = array('NESTLE-PREMIO-PRO'=>0, 'NESTLE-AMIGO-20'=>1, 'NESTLE-DUO-GUSTO'=>2, 'NESTLE-SOLUTION-20'=>3, 'NESTLE-SPECTRA-30'=>4, 'NESTLE-FRIO-COLD'=>5);
                        $matrix_categories = array(
                            '1. Core Brewing & Thermal Architecture' => array(
                                'Technology Type'         => array('Super-Automatic Bean-to-Cup', 'Compact Bean-to-Cup', 'Dual Hot & Cold Hybrid', 'High-Throughput Soluble', 'Compact 3-in-1 Premix', 'Flash-Chilled Cold Station'),
                                'Daily Duty Cycle'        => array('Up to 200 Cups / Day', 'Up to 200 Cups / Day', '300+ Cups / Day', '200+ Cups / Day (Burst 6/min)', '100–150 Cups / Day', 'Continuous Chilled Service'),
                                'Boiler / Heating System' => array('Dual Thermoblock Architecture', 'Dedicated High-Recovery Boiler', 'Dual Temp (88°C Hot + 4°C Cold)', 'Insulated 3000W Heavy-Duty Boiler', '1750W Rapid Recovery Tank', '1000W R134a Chiller Circuit'),
                                'Grinder Mechanism'       => array('15-Bar Conical Steel Burr', 'Conical Steel Burr Grinder', 'N/A (Multi-Canister Soluble)', 'N/A (Soluble Instant)', 'N/A (Dry Premix)', 'N/A (Cold Emulsion Impeller)'),
                                'Extraction Pressure'     => array('15 Bar High Pressure', '15 Bar High Pressure', 'Atmospheric Fast Flow', 'Atmospheric Fast Flow', 'Atmospheric Gravity Flow', 'High-Shear Emulsion Flow'),
                                'Dispense Velocity'       => array('35–45 sec / cup', '35–45 sec / cup', '15–20 sec / cup', '10–15 sec / cup (Rapid Burst)', '15–20 sec / cup', '12–18 sec / cup'),
                                'Target Deployment'       => array('Executive Suites & Boardrooms', 'Mid-Size Corporate Offices', 'Large Cafeterias & Hubs', 'High-Traffic Floor Pantries', 'Boutique Offices & Receptions', 'Summer Cafeterias & Lounges'),
                            ),
                            '2. Beverage Capabilities & Menu Cross-Check' => array(
                                'Espresso / Double Espresso'     => array('✓ Bean-to-Cup', '✓ Bean-to-Cup', '✗ (Hot Coffee Blend)', '✗ (Soluble Classic)', '✗ (Premix Coffee)', '✗'),
                                'Americano / Long Black'         => array('✓ Standard', '✓ Standard', '✓ Hot Blend', '✓ Nescafé Classic', '✗', '✗'),
                                'Cappuccino & Café Latte'        => array('✓ Fresh Real Milk', '✓ Fresh Milk Cooler', '✓ Hot Cappuccino & Latte', '✓ Cappuccino', '✗ (Premix Coffee)', '✗'),
                                'Hot Chocolate & Malt'           => array('✓ Chococcino', '✓ Hot Choc & Milo Malt', '✓ Hot Chocolate', '✓ Hot Chocolate', '✓ Premix Chocolate', '✗'),
                                'Iced Café Frappe & Cold Coffee' => array('✗', '✗', '✓ Iced Frappe & Cold Coffee', '✗', '✗', '✓ Café Frappe & Mocha'),
                                'Nestea Iced Lemon / Peach'      => array('✗', '✗', '✓ Nestea Iced Lemon', '✗', '✗', '✓ Iced Lemon & Peach'),
                                'Cardamom / Ginger / Tapri Tea'  => array('✗', '✓ Cardamom Tea', '✓ Tapri Chai', '✓ Cardamom & Ginger', '✓ Premix Cardamom', '✗'),
                                'Dedicated Hot Water Bypass'     => array('✓ Dedicated Spout', '✓ Dedicated Spout', '✓ Integrated', '✓ High-Speed Hot Water', '✓ Manual Hot Water', '✗ (Cold System)'),
                            ),
                            '3. Canister & Capacity Engineering' => array(
                                'Bean Hopper Capacity'      => array('1.5 kg Bean Hopper', '1.5 kg Bean Hopper', 'N/A', 'N/A', 'N/A', 'N/A'),
                                'Powder Canister Payload'   => array('4 Canisters (Total 3 kg)', '3 Canisters (Total 2.25 kg)', '6 Canisters (Multi-Blend)', '4 Canisters (Total 4 kg)', '3 Canisters (Total 3 kg)', '3 Canisters (Total 3 kg)'),
                                'Fresh Milk Refrigerator'   => array('External 4L Chilled Unit', 'External Chilled Cooler', 'Dual Liquid / Powder', 'Liquid Milk Capable', 'N/A (Dry Premix)', 'N/A'),
                                'Cold Chiller Tank'         => array('N/A', 'N/A', 'Integrated Chiller Tank', 'N/A', 'N/A', '8L Continuous Chiller Tank'),
                                'Grounds Waste Container'   => array('40–50 Coffee Pucks', '35-Puck Grounds Drawer', 'Zero Solid Waste', 'Zero Solid Waste', 'Zero Solid Waste', 'Zero Solid Waste'),
                                'Drip Tray Volume & Sensor' => array('1,500 ml Float Sensor', '900 ml Removable Basin', '1,200 ml Stainless Grate', '1,200 ml Plumbed Capable', '800 ml Snap-Fit Tray', '1,500 ml High-Capacity'),
                            ),
                            '4. Touchscreen UI, Payments & IoT' => array(
                                'Display Interface'          => array('7-Inch Colour Touchscreen', 'Proximity Touch Glass', '10-Inch Interactive HD', '9-Inch IR Proximity Touch', 'Tactile Push + LCD', '9-Inch Touch Glass'),
                                'Touch-Free / Proximity'     => array('Optional QR Scan', 'Proximity Capacitive', 'Dynamic QR Touchless', '✓ 100% IR Hover (2cm)', '✗ Push-Button', 'Proximity Touch'),
                                'Dynamic UPI / QR Payments'  => array('✓ BharatQR / UPI / Paytm', 'Optional Payment Box', '✓ Dynamic Screen QR', 'Optional External Reader', 'N/A (Free Vend)', 'Optional QR Interface'),
                                'RFID Employee Card Reader'  => array('Supported (Mifare / NFC)', 'Supported', 'Built-In Reader', 'External Add-On', 'N/A', 'External Add-On'),
                                'IoT Cloud Telemetry'        => array('Real-Time Level & Usage', 'Cloud Telemetry Enabled', 'Real-Time Telemetry & Ads', 'Usage Counter & Logs', 'Digital LCD Audit', 'Real-Time Diagnostics'),
                                'Video / Ad Display'         => array('Standby Video', 'N/A', '10-Inch HD Video Ads', 'N/A', 'N/A', 'N/A'),
                                'Multilingual Guidance'      => array('English + Hindi Audio/UI', 'Visual Icon Guidance', 'Audio-Visual Prompts', 'Status LED & Beeper', 'Dual-Line English LCD', 'Backlit Visual Icons'),
                            ),
                            '5. Water Supply, Plumbing & Drainage' => array(
                                'Water Supply Source'     => array('Mains Plumbing + 20L Bottle', 'Mains Plumbing + Pump', 'Direct Mains Plumbing', 'Mains Plumbing + Bottle', 'Mains + 5L Tank / Bottle', 'Mains Plumbing + 20L Bottle'),
                                'Inlet Water Pressure'    => array('0.1–0.6 MPa (1–6 bar)', '0.1–0.6 MPa (1–6 bar)', '0.15–0.6 MPa', '0.1–0.6 MPa', '0.05–0.4 MPa', '0.1–0.5 MPa'),
                                'Internal Water Buffer'   => array('4.0 Liter Buffer Tank', '3.5 Liter Buffer Tank', '6.0 Liter Dual Buffer', '5.0 Liter High-Output', '3.0 Liter Tank', '8.0 Liter Continuous'),
                                'Filtration Cartridge'    => array('3M / Brita Purity C', '3M Water Filtration', 'Dual Inline Scale Filter', 'Inline Sediment & Carbon', 'Standard Inline Cartridge', 'Multi-Stage Carbon Filter'),
                                'Waste Drain Connection'  => array('Direct Drain Hose Kit', 'Direct Drain Hose Kit', 'Direct Drain Included', 'Direct Drain Included', 'Manual Drip Empty', 'Direct Drain Included'),
                                'Descaling Reminder'      => array('Smart Flow Alert on Screen', 'Automated Descale Alert', 'Automated Descale Alert', 'Litre-Based Warning', 'LCD Service Alert', 'Sanitation Timer Alert'),
                            ),
                            '6. Electrical & Mechanical Dimensions' => array(
                                'Supply Voltage'          => array('230V AC / 50 Hz Single-Phase', '230V AC / 50 Hz Single-Phase', '230V AC / 50 Hz Single-Phase', '230V AC / 50 Hz Single-Phase', '230V AC / 50 Hz Single-Phase', '230V AC / 50 Hz Single-Phase'),
                                'Connected Load (Watts)'  => array('3000W', '3000W', '2850W (Dual Circuit)', '3000W', '1750W', '1000W'),
                                'Circuit Breaker'         => array('16A Dedicated MCB', '16A Dedicated MCB', '16A Dedicated MCB', '16A Dedicated MCB', '10A / 16A Standard', '10A Dedicated MCB'),
                                'Width × Depth (mm)'      => array('365 × 610 mm (+Fridge)', '330 × 570 mm (+Fridge)', '380 × 675 mm (+Cooler)', '330 × 570 mm (+Fridge)', '285 × 490 mm', '335 × 655 mm'),
                                'Height (mm)'             => array('760 mm', '730 mm', '645 mm', '650 mm', '600 mm', '655 mm'),
                                'Net Dry Weight'          => array('42 kg + 18 kg Fridge', '38 kg + 18 kg Fridge', '48 kg (Dual Unit)', '34 kg', '22 kg', '36 kg'),
                                'Countertop Clearance'    => array('750 mm Min Width', '700 mm Min Width', '800 mm Min Width', '650 mm Min Width', '350 mm Compact Desk', '450 mm Dedicated'),
                                'Cabinet Construction'    => array('Commercial Brushed SS', 'Matte Steel & ABS', 'Heavy-Duty Steel Chassis', 'Stainless Steel Front', 'Reinforced Polymer Shell', 'Epoxy-Coated Galvanized'),
                            ),
                            '7. Hygiene, Maintenance & Warranty' => array(
                                'CIP Automated Sanitation' => array('Steam Purge & Chemical Cycle', 'Auto-Rinse Boot & Shut', 'High-Temp Auto Flushing', 'High-Temp Self-Cleaning', 'One-Touch Hot Flush', 'Closed-Circuit Sanitizing'),
                                'Daily Maintenance Time'  => array('Under 10 Minutes', 'Under 10 Minutes', 'Under 8 Minutes', 'Under 5 Minutes', 'Under 3 Minutes', 'Under 5 Minutes'),
                                'Food Safety Compliance'  => array('FSSAI Compliant, CE, ISO 9001', 'FSSAI Compliant, CE, ISO 9001', 'FSSAI Compliant, CE, RoHS', 'FSSAI Compliant, CE', 'FSSAI Compliant, CE', 'FSSAI Compliant, CE, RoHS'),
                                'Standard OEM Warranty'   => array('1 Year Comprehensive On-Site', '1 Year Comprehensive On-Site', '1 Year Comprehensive On-Site', '1 Year Comprehensive On-Site', '1 Year Comprehensive On-Site', '1 Year Comprehensive On-Site'),
                                'Pan-India AMC SLA'       => array('4-Hour Enterprise Metro SLA', 'Pan-India Preventive AMC', 'Pan-India Preventive AMC', 'Pan-India Preventive AMC', 'Standard Annual AMC', 'Pan-India Refrigeration AMC'),
                                'GST Input Tax Credit'    => array('100% Eligible (HSN 8476)', '100% Eligible (HSN 8476)', '100% Eligible (HSN 8476)', '100% Eligible (HSN 8476)', '100% Eligible (HSN 8476)', '100% Eligible (HSN 8476)'),
                            ),
                        );
                    ?>
                        <table class="w-full text-left text-xs border-collapse min-w-[900px]">
                            <thead>
                                <tr class="bg-[#1A56DB] text-white font-black uppercase tracking-wider text-[11px]">
                                    <th class="p-3 sticky left-0 bg-[#1A56DB] z-20 w-64 min-w-[220px] border-r border-blue-600">Engineering Parameter / Model</th>
                                    <?php foreach ( $all_products as $col_prod ) : ?>
                                        <th class="p-3 border-r border-blue-600 text-center min-w-[150px]">
                                            <div class="flex flex-col items-center gap-1.5">
                                                <label class="cursor-pointer inline-flex items-center justify-center p-0.5" title="Select for batch RFQ"><input type="checkbox" class="b2b-sku-checkbox accent-[#FBBF24] w-4 h-4 cursor-pointer" data-id="<?php echo esc_attr( $col_prod['id'] ); ?>" data-title="<?php echo esc_attr( $col_prod['title'] ); ?>" data-sku="<?php echo esc_attr( $col_prod['sku'] ); ?>"></label>
                                                <img src="<?php echo esc_url( $col_prod['thumb_url'] ); ?>" alt="<?php echo esc_attr( $col_prod['title'] ); ?>" class="w-12 h-12 object-contain bg-white border border-zinc-200 p-1" loading="lazy">
                                                <span class="font-extrabold uppercase text-[10px] leading-tight text-white line-clamp-1"><?php echo esc_html( $col_prod['title'] ); ?></span>
                                                <span class="inline-block text-[9px] font-mono font-bold bg-[#FBBF24] text-black px-1.5 py-0.2"><?php echo esc_html( $col_prod['sku'] ); ?></span>
                                                <button class="h-[28px] w-full bg-[#0A0A0A] hover:bg-black active:scale-95 text-[#FBBF24] font-bold uppercase text-[9px] tracking-wider px-2 flex items-center justify-center border border-white/20 transition-colors js-open-quote-modal" data-product="<?php echo esc_attr( $col_prod['title'] ); ?>" data-sku="<?php echo esc_attr( $col_prod['sku'] ); ?>">Quote</button>
                                            </div>
                                        </th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-200">
                                <?php foreach ( $matrix_categories as $cat_title => $cat_specs ) : ?>
                                    <tr class="bg-[#0A0A0A] text-[#FBBF24] font-black text-xs uppercase tracking-wider">
                                        <td colspan="<?php echo count( $all_products ) + 1; ?>" class="py-2.5 px-4"><div class="flex items-center gap-2"><span class="w-2 h-2 bg-[#1A56DB] inline-block"></span><span><?php echo esc_html( $cat_title ); ?></span></div></td>
                                    </tr>
                                    <?php foreach ( $cat_specs as $spec_title => $spec_row ) : ?>
                                    <tr class="odd:bg-white even:bg-zinc-50 hover:bg-yellow-50/60 transition-colors">
                                        <td class="sticky left-0 bg-zinc-100 z-10 w-64 min-w-[220px] font-bold text-[11px] uppercase text-zinc-700 py-2.5 px-3.5 border-r border-b border-zinc-200 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.08)]"><?php echo esc_html( $spec_title ); ?></td>
                                        <?php foreach ( $all_products as $col_idx => $prod_col ) : 
                                            $col_sku = $prod_col['sku'];
                                            $target_idx = isset( $coffee_sku_map[ $col_sku ] ) ? $coffee_sku_map[ $col_sku ] : $col_idx;
                                            $val = isset( $spec_row[ $target_idx ] ) ? $spec_row[ $target_idx ] : 'Standard';
                                            $is_check = ( strpos( $val, '✓' ) !== false );
                                            $is_cross = ( strpos( $val, '✗' ) !== false );
                                        ?>
                                        <td class="py-2.5 px-3 border-r border-b border-zinc-200 text-xs text-center">
                                            <?php if ( $is_check ) : ?>
                                                <span class="inline-flex items-center gap-1 text-green-700 font-extrabold bg-green-50 px-2 py-0.5 border border-green-200 rounded text-[11px]"><?php echo esc_html( $val ); ?></span>
                                            <?php elseif ( $is_cross ) : ?>
                                                <span class="inline-flex items-center gap-1 text-zinc-400 font-medium text-[11px]"><?php echo esc_html( $val ); ?></span>
                                            <?php else : ?>
                                                <span class="font-extrabold text-[#0A0A0A] text-[11px]"><?php echo esc_html( $val ); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <?php endforeach; ?>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <!-- Universal Fallback Matrix for Other Commercial B2B Categories -->
                        <table class="w-full text-left text-xs border-collapse min-w-[700px]">
                            <thead><tr class="bg-[#1A56DB] text-white font-black uppercase tracking-wider text-[11px]"><th class="p-3 text-center w-14 border-r border-blue-600">RFQ [✓]</th><th class="p-3 border-r border-blue-600">Model Name &amp; SKU</th><th class="p-3 border-r border-blue-600">Throughput / Capacity</th><th class="p-3 border-r border-blue-600">Duty Cycle / Power</th><th class="p-3 border-r border-blue-600">Target Deployment</th><th class="p-3 border-r border-blue-600">Commercial Terms</th><th class="p-3 text-center w-36">Quick Actions</th></tr></thead>
                            <tbody class="divide-y divide-zinc-200">
                                <?php foreach ( $all_products as $row ) : 
                                    $spec1 = ! empty( $row['specs'][0] ) ? $row['specs'][0]['value'] : 'Industrial Grade';
                                    $spec2 = ! empty( $row['specs'][1] ) ? $row['specs'][1]['value'] : 'Standard 230V / 50Hz';
                                    $spec3 = ! empty( $row['specs'][2] ) ? $row['specs'][2]['value'] : 'Commercial Use';
                                ?>
                                <tr class="odd:bg-white even:bg-zinc-50 hover:bg-yellow-50/60 transition-colors">
                                    <td class="p-3 text-center border-r border-zinc-200"><label class="cursor-pointer inline-flex items-center justify-center p-1"><input type="checkbox" class="b2b-sku-checkbox accent-[#FBBF24] w-4 h-4 cursor-pointer" data-id="<?php echo esc_attr( $row['id'] ); ?>" data-title="<?php echo esc_attr( $row['title'] ); ?>" data-sku="<?php echo esc_attr( $row['sku'] ); ?>"></label></td>
                                    <td class="p-3 border-r border-zinc-200"><div class="flex items-center gap-3"><img src="<?php echo esc_url( $row['thumb_url'] ); ?>" alt="<?php echo esc_attr( $row['title'] ); ?>" class="w-10 h-10 object-contain bg-white border border-zinc-200 p-0.5 shrink-0" loading="lazy"><div><div class="font-black text-[#0A0A0A] uppercase leading-tight"><?php echo esc_html( $row['title'] ); ?></div><span class="inline-block text-[10px] font-mono font-bold bg-[#FBBF24] text-black px-1.5 py-0.5 mt-0.5">SKU: <?php echo esc_html( $row['sku'] ); ?></span></div></div></td>
                                    <td class="p-3 font-bold text-zinc-800 border-r border-zinc-200"><?php echo esc_html( $spec1 ); ?></td>
                                    <td class="p-3 font-medium text-zinc-600 border-r border-zinc-200"><?php echo esc_html( $spec2 ); ?></td>
                                    <td class="p-3 font-medium text-zinc-600 border-r border-zinc-200"><?php echo esc_html( $spec3 ); ?></td>
                                    <td class="p-3 border-r border-zinc-200"><span class="text-[10px] font-black uppercase text-zinc-600 tracking-wider bg-zinc-200/70 px-1.5 py-0.5">Institutional</span></td>
                                    <td class="p-3 text-center"><div class="flex items-center justify-center gap-1.5"><button class="h-[34px] flex-1 min-w-[65px] bg-[#0A0A0A] hover:bg-[#1A56DB] active:scale-95 text-white font-bold uppercase text-[10px] tracking-wider px-2.5 flex items-center justify-center transition-colors js-open-quote-modal" data-product="<?php echo esc_attr( $row['title'] ); ?>" data-sku="<?php echo esc_attr( $row['sku'] ); ?>">Quote</button><a href="tel:+919823012724" class="h-[34px] w-[34px] bg-zinc-100 hover:bg-[#FBBF24] hover:text-black text-[#0A0A0A] border border-zinc-300 transition-colors flex items-center justify-center shrink-0"><span class="material-symbols-outlined text-xs">call</span></a></div></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                    
                    <div class="p-3.5 sm:p-4 bg-zinc-50 border-t-2 border-zinc-200 text-[11px] text-zinc-600 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                        <p><strong>Engineering Note:</strong> Custom plumbing hookups, electrical breakers, water filtration, and pan-India turnkey AMC service packages provided with all corporate fleet quotes.</p>
                        <a href="tel:+919823012724" class="text-[#1A56DB] hover:underline font-bold whitespace-nowrap flex items-center gap-1"><span class="material-symbols-outlined text-sm">call</span> Speak with an Application Engineer &rarr;</a>
                    </div>
                </div>
            </section>

            <!-- 5. Procurement FAQ & Trust Section -->
            <section id="procurement-faq" class="bg-zinc-100 border-2 border-zinc-300 p-6 sm:p-8 md:p-12 mb-16">
                <div class="max-w-4xl mx-auto">
                    <span class="text-[#1A56DB] font-black uppercase tracking-widest text-xs flex items-center gap-1.5"><span class="w-1.5 h-1.5 bg-[#1A56DB] inline-block"></span> Procurement Guidelines</span>
                    <h2 class="text-2xl md:text-3xl font-extrabold uppercase text-[#0A0A0A] mt-1 mb-8">Institutional Supply, GST Compliance &amp; Support</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 text-xs text-zinc-700 mb-8">
                        <?php foreach ( array( array('verified_user','Warranty & Pan-India AMC','All commercial equipment carries 1 to 5 years manufacturer warranty backed by factory certified engineers across India. Annual Maintenance Contracts (AMC) available.'), array('payments','Invoicing & Taxes','100% compliant GST invoices issued with standard HSN codes for corporate input tax credit (ITC). Formal corporate Purchase Orders (PO) accepted for verified accounts.'), array('local_shipping','Pan-India Logistics & Offloading','Insured freight delivery directly to your facility or loading dock. Turnkey positioning and MEP hookup coordination available across major metro regions.'), array('architecture','Technical MEP Drawings & CAD Blocks','Architectural floor plan CAD blocks, water pressure requirements, and electrical single-line diagrams (SLD) provided to consulting engineers upon RFQ.') ) as $fi ) : ?>
                            <div class="bg-white p-5 border border-zinc-200">
                                <h4 class="font-black text-sm uppercase text-[#0A0A0A] mb-2 flex items-center gap-2"><span class="material-symbols-outlined text-[#1A56DB]"><?php echo $fi[0]; ?></span> <?php echo $fi[1]; ?></h4>
                                <p class="leading-relaxed"><?php echo $fi[2]; ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="bg-[#1A56DB] text-white p-6 md:p-8 flex flex-col sm:flex-row items-center justify-between gap-6">
                        <div>
                            <h3 class="text-xl font-black uppercase tracking-tight">Need A Turnkey Bill of Quantities (BOQ)?</h3>
                            <p class="text-zinc-200 text-xs mt-1">Upload your architectural drawing or equipment schedule for instant engineering appraisal and volume discount schedule.</p>
                        </div>
                        <a href="<?php echo esc_url( home_url( '/request-a-quote/' ) ); ?>" class="bg-[#FBBF24] text-black font-black uppercase text-xs tracking-widest py-3.5 px-6 hover:bg-yellow-400 shrink-0 transition-all shadow-md">Submit BOQ Schedule</a>
                    </div>
                </div>
            </section>
        </main>

        <!-- 6. Floating Multi-SKU RFQ Batch Drawer -->
        <div id="b2b-floating-rfq-bar" class="fixed bottom-3 sm:bottom-6 left-1/2 -translate-x-1/2 z-50 w-[calc(100%-1.5rem)] sm:w-[95%] max-w-4xl bg-[#0A0A0A] text-white border-2 border-[#FBBF24] p-3.5 sm:p-4 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 sm:gap-4 transition-all duration-300 transform translate-y-32 opacity-0 pointer-events-none shadow-[0_10px_40px_rgba(0,0,0,0.85)] pb-[max(0.75rem,env(safe-area-inset-bottom))]">
            <div class="flex items-center gap-3 overflow-hidden">
                <span class="w-8 h-8 bg-[#FBBF24] text-black font-black flex items-center justify-center text-sm shrink-0" id="rfq-badge-count">0</span>
                <div>
                    <div class="font-black text-xs uppercase tracking-wider text-white flex items-center gap-2">
                        <span>Consolidated Multi-Model RFQ Builder</span>
                        <span class="text-[9px] bg-[#1A56DB] text-white px-1.5 py-0.5 uppercase tracking-widest hidden sm:inline">Volume Pricing</span>
                    </div>
                    <div id="rfq-chip-container" class="flex flex-wrap gap-1.5 mt-1 text-[10px] text-zinc-300 font-mono"></div>
                </div>
            </div>
            <div class="flex items-center justify-end gap-2.5 sm:gap-3 shrink-0">
                <a href="tel:+919823012724" class="h-[44px] sm:h-[46px] hidden md:flex items-center justify-center gap-1.5 border-2 border-white/40 hover:border-white hover:bg-white hover:text-black active:scale-95 text-white font-bold uppercase text-xs px-3.5 transition-all"><span class="material-symbols-outlined text-sm">call</span><span>Call Sales</span></a>
                <button id="rfq-clear-all" class="text-zinc-400 hover:text-white text-xs uppercase font-bold underline px-2 py-1">Clear</button>
                <button id="rfq-request-batch-btn" class="h-[44px] sm:h-[46px] bg-[#FBBF24] hover:bg-yellow-400 active:scale-95 text-black font-black uppercase text-xs tracking-widest px-5 sm:px-6 flex items-center justify-center gap-2 shadow-lg transition-all js-open-quote-modal">
                    <span id="rfq-btn-text">Request Batch Quote</span>
                    <span class="material-symbols-outlined text-base">arrow_forward</span>
                </button>
            </div>
        </div>

        <!-- 7. Touchscreen Menu Zoom Modal -->
        <div id="menu-zoom-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/85 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
            <div class="relative max-w-4xl w-full bg-[#0A0A0A] border-2 border-[#1A56DB] shadow-2xl p-4 sm:p-6 overflow-hidden">
                <div class="flex items-center justify-between pb-3 border-b border-zinc-800 mb-4">
                    <div class="flex items-center gap-2"><span class="w-2 h-2 bg-[#FBBF24]"></span><h4 id="menu-zoom-title" class="text-sm sm:text-base font-extrabold uppercase text-white tracking-wide">Touchscreen Menu UI</h4></div>
                    <button id="menu-zoom-close" class="text-zinc-400 hover:text-white p-1 text-xl font-bold transition-colors">✕</button>
                </div>
                <div class="relative aspect-video max-h-[70vh] flex items-center justify-center bg-zinc-950 overflow-hidden">
                    <img id="menu-zoom-img" src="" alt="Menu UI Zoom" class="max-w-full max-h-[70vh] object-contain">
                </div>
                <div class="pt-3 text-center text-xs text-zinc-400 flex items-center justify-between">
                    <span>High-definition interface preview</span><span class="text-[11px] text-[#FBBF24] font-mono font-bold">Press ESC or click anywhere outside to close</span>
                </div>
            </div>
        </div>

        <!-- Inline Zero-Dependency Vanilla JS Engine -->
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Dual-Tab Switcher (Hardware vs Touchscreen Menu UI)
            document.querySelectorAll('.js-card-tab-btn').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    var cardId = this.getAttribute('data-card'), target = this.getAttribute('data-tab-target');
                    document.querySelectorAll('.js-card-tab-btn[data-card="' + cardId + '"]').forEach(function(b) {
                        b.className = (b.getAttribute('data-tab-target') === target)
                            ? 'js-card-tab-btn flex-1 py-1.5 px-2 text-[10px] sm:text-[11px] font-black uppercase tracking-wider flex items-center justify-center gap-1 border-2 border-black bg-[#0A0A0A] text-[#FBBF24] transition-all shadow-sm active:scale-95'
                            : 'js-card-tab-btn flex-1 py-1.5 px-2 text-[10px] sm:text-[11px] font-black uppercase tracking-wider flex items-center justify-center gap-1 border-2 border-zinc-300 bg-white hover:bg-zinc-100 text-zinc-700 transition-all shadow-sm active:scale-95';
                    });
                    document.querySelectorAll('.js-tab-pane[data-card="' + cardId + '"]').forEach(function(p) { p.classList.toggle('hidden', p.getAttribute('data-tab-content') !== target); });
                });
            });

            // 2. Multi-Angle View Switcher (Front, Left 45°, Right 45°)
            document.querySelectorAll('.js-angle-btn').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    var cId = this.getAttribute('data-card'), src = this.getAttribute('data-src'), img = document.getElementById('main-img-' + cId);
                    if (img && src) img.src = src;
                    document.querySelectorAll('.js-angle-btn[data-card="' + cId + '"]').forEach(function(b) {
                        b.className = (b === btn) ? 'js-angle-btn px-2 py-0.5 sm:px-2.5 sm:py-1 text-[9px] sm:text-[10px] font-black uppercase tracking-wider border transition-all flex items-center gap-1 border-[#0A0A0A] bg-[#0A0A0A] text-[#FBBF24] shadow-sm' : 'js-angle-btn px-2 py-0.5 sm:px-2.5 sm:py-1 text-[9px] sm:text-[10px] font-black uppercase tracking-wider border transition-all flex items-center gap-1 border-zinc-300 bg-white hover:bg-zinc-100 text-zinc-700';
                    });
                });
            });

            // 3. Salient Features Accordion Drawer Toggle
            document.querySelectorAll('.js-toggle-features').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    var drawer = document.getElementById(this.getAttribute('data-target'));
                    if (!drawer) return;
                    drawer.classList.toggle('hidden');
                    this.innerHTML = drawer.classList.contains('hidden') ? '<span>+ View Full Operational Highlights</span>' : '<span>− Hide Full Operational Highlights</span>';
                });
            });

            // 4. Touchscreen Menu & Beverage Zoom Modal
            var zoomModal = document.getElementById('menu-zoom-modal'), zoomImg = document.getElementById('menu-zoom-img'), zoomTitle = document.getElementById('menu-zoom-title'), zoomClose = document.getElementById('menu-zoom-close');
            function openZoomModal(src, title) {
                if (!zoomModal || !zoomImg) return;
                zoomImg.src = src;
                if (zoomTitle) zoomTitle.textContent = title || 'Interface & Beverage Preview';
                zoomModal.classList.remove('opacity-0', 'pointer-events-none');
                zoomModal.classList.add('opacity-100', 'pointer-events-auto');
                document.body.style.overflow = 'hidden';
            }
            function closeZoomModal() {
                if (!zoomModal) return;
                zoomModal.classList.add('opacity-0', 'pointer-events-none');
                zoomModal.classList.remove('opacity-100', 'pointer-events-auto');
                document.body.style.overflow = '';
            }
            document.querySelectorAll('.js-open-zoom-modal').forEach(function(el) {
                el.addEventListener('click', function(e) {
                    e.preventDefault();
                    var src = this.getAttribute('data-zoom-src'), title = this.getAttribute('data-zoom-title');
                    if (src) openZoomModal(src, title);
                });
            });
            if (zoomClose) zoomClose.addEventListener('click', closeZoomModal);
            if (zoomModal) zoomModal.addEventListener('click', function(e) { if (e.target === zoomModal) closeZoomModal(); });
            document.addEventListener('keydown', function(e) { if (e.key === 'Escape' && zoomModal && !zoomModal.classList.contains('pointer-events-none')) closeZoomModal(); });

            // 5. Floating Multi-SKU RFQ Drawer & Live Counter
            var selectedSKUs = [];
            var floatingBar = document.getElementById('b2b-floating-rfq-bar'), badgeCount = document.getElementById('rfq-badge-count'), chipContainer = document.getElementById('rfq-chip-container');
            var stickyCounter = document.getElementById('sticky-counter'), stickyCounterNum = document.getElementById('sticky-counter-num');
            var batchBtn = document.getElementById('rfq-request-batch-btn'), btnText = document.getElementById('rfq-btn-text'), clearBtn = document.getElementById('rfq-clear-all');
            var checkboxes = document.querySelectorAll('.b2b-sku-checkbox');

            function updateSelectionUI() {
                var count = selectedSKUs.length;
                if (badgeCount) badgeCount.textContent = count;
                if (stickyCounterNum) stickyCounterNum.textContent = count;
                if (btnText) btnText.textContent = count > 0 ? 'Request Batch Quote (' + count + (count === 1 ? ' Model' : ' Models') + ')' : 'Request Batch Quote';

                if (count > 0) {
                    floatingBar.classList.remove('translate-y-32', 'opacity-0', 'pointer-events-none');
                    floatingBar.classList.add('translate-y-0', 'opacity-100', 'pointer-events-auto');
                    if (stickyCounter) stickyCounter.classList.remove('hidden');
                    if (chipContainer) {
                        chipContainer.innerHTML = selectedSKUs.slice(0, 4).map(function(s) {
                            return '<span class="bg-zinc-800 border border-zinc-700 px-1.5 py-0.5">' + s.sku + '</span>';
                        }).join('') + (count > 4 ? '<span class="text-zinc-400">+' + (count - 4) + ' more</span>' : '');
                    }
                    var msg = "Multi-Model B2B Inquiry (<?php echo esc_js( $category_name ); ?> Series):\n";
                    selectedSKUs.forEach(function(item, i) { msg += (i + 1) + ". Model: " + item.sku + " - " + item.title + "\n"; });
                    msg += "\nPlease provide bulk price schedule, estimated lead time, and shipping details.\nDelivery Location:\nCompany Name:";
                    if (batchBtn) {
                        batchBtn.setAttribute('data-product', 'Multiple Selected Models (' + count + ')');
                        batchBtn.setAttribute('data-sku', selectedSKUs.map(function(s){ return s.sku; }).join(', '));
                        batchBtn.setAttribute('data-custom-message', msg);
                    }
                } else {
                    floatingBar.classList.add('translate-y-32', 'opacity-0', 'pointer-events-none');
                    floatingBar.classList.remove('translate-y-0', 'opacity-100', 'pointer-events-auto');
                    if (stickyCounter) stickyCounter.classList.add('hidden');
                }
            }

            checkboxes.forEach(function(cb) {
                cb.addEventListener('change', function() {
                    var id = this.dataset.id, title = this.dataset.title, sku = this.dataset.sku;
                    if (this.checked) {
                        selectedSKUs.push({ id: id, title: title, sku: sku });
                        document.querySelectorAll('.b2b-sku-checkbox[data-id="' + id + '"]').forEach(function(c) { c.checked = true; });
                    } else {
                        selectedSKUs = selectedSKUs.filter(function(s) { return s.id !== id; });
                        document.querySelectorAll('.b2b-sku-checkbox[data-id="' + id + '"]').forEach(function(c) { c.checked = false; });
                    }
                    updateSelectionUI();
                });
            });

            if (clearBtn) {
                clearBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    selectedSKUs = [];
                    checkboxes.forEach(function(cb) { cb.checked = false; });
                    updateSelectionUI();
                });
            }
        });
        </script>

    <?php else : ?>
        <!-- ===================================================================
             RETAIL CATEGORY FALLBACK (STANDARD CATALOG GRID)
             =================================================================== -->
        <section class="bg-[#0A0A0A] relative overflow-hidden flex items-center border-b-4 border-[#1A56DB] pt-36 md:pt-44 pb-16">
            <div class="absolute inset-0 industrial-diagonal bg-[#1A56DB] opacity-10 w-2/3 pointer-events-none"></div>
            <div class="container mx-auto px-6 md:px-12 relative z-10">
                <nav class="flex mb-6 space-x-2 text-[10px] md:text-xs font-black uppercase tracking-widest text-[#FBBF24]">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-white transition-colors">Home</a><span class="text-white/30">/</span><a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="hover:text-white transition-colors">Shop</a><span class="text-white/30">/</span><span class="text-white"><?php echo esc_html( $category_name ); ?></span>
                </nav>
                <h1 class="text-5xl md:text-7xl font-black text-white leading-none tracking-tighter uppercase mb-6"><?php echo esc_html( $category_name ); ?></h1>
                <?php if ( $category_desc ) : ?><p class="text-lg text-white/80 max-w-3xl font-medium leading-relaxed"><?php echo wp_kses_post( $category_desc ); ?></p><?php endif; ?>
            </div>
        </section>
        <main class="max-w-7xl mx-auto px-6 md:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 border-t border-l border-[#1A56DB]">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); global $product; if ( ! is_a( $product, 'WC_Product' ) ) $product = wc_get_product( get_the_ID() ); if ( ! $product ) continue; ?>
                <article class="bg-white p-6 flex flex-col group relative cursor-pointer border-b border-r border-[#1A56DB]">
                    <div class="relative aspect-square mb-6 bg-surface-container-low overflow-hidden"><img alt="<?php echo esc_attr( $product->get_name() ); ?>" class="w-full h-full object-contain mix-blend-multiply group-hover:scale-105 transition-transform duration-500 p-2" src="<?php echo esc_url( wp_get_attachment_image_url( $product->get_image_id(), 'large' ) ?: wc_placeholder_img_src() ); ?>"/><div class="absolute bottom-0 left-0 bg-[#FBBF24] text-[#0A0A0A] px-2 py-1 text-[10px] font-black uppercase tracking-tighter">MODEL: <?php echo esc_html( $product->get_sku() ?: 'N/A' ); ?></div></div>
                    <h3 class="text-[#0A0A0A] font-black uppercase tracking-tighter text-xl mb-4 leading-tight"><?php echo esc_html( $product->get_name() ); ?></h3>
                    <div class="mt-auto space-y-2"><div class="text-xl font-black mb-2 text-center text-[#0A0A0A]"><?php echo $product->get_price_html(); ?></div><a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="w-full bg-[#1A56DB] text-white py-3 font-black uppercase tracking-widest text-xs hover:bg-[#0A0A0A] hover:text-white transition-colors block text-center">Add to Cart</a></div>
                </article>
            <?php endwhile; else : ?><div class="p-8 col-span-full text-center"><h3 class="text-xl font-bold">No products found in this category.</h3></div><?php endif; ?>
            </div>
            <div class="mt-12 w-full flex justify-center custom-pagination"><?php woocommerce_pagination(); ?></div>
        </main>
    <?php endif; ?>

    <?php do_action( 'woocommerce_after_main_content' ); ?>
</div>

<?php get_footer( 'shop' ); ?>
