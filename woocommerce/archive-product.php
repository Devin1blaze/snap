<?php
/**
 * Snap Marketing - B2B Multi-Product Family Showcase & Universal Category Template
 *
 * Implements the Chai Point + Snap Marketing hybrid layout:
 * - Alternating split-block showcase for flagship/featured models
 * - Comprehensive interactive technical comparison matrix for all category SKUs
 * - Multi-select floating RFQ batch drawer + individual instant quote triggers
 * - Retains standard retail catalog grid fallback for consumer categories
 *
 * @package SnapStitchTheme
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

$term = get_queried_object();
$category_name = woocommerce_page_title( false );
$category_desc = ( $term && isset( $term->description ) ) ? $term->description : '';
if ( ! $category_desc && $term && isset( $term->post_content ) ) {
    $category_desc = $term->post_content;
}

// -----------------------------------------------------------------------------
// B2B CATEGORY DETECTION ENGINE
// -----------------------------------------------------------------------------
$is_b2b_category = false;
if ( $term && ! is_wp_error( $term ) && isset( $term->slug ) ) {
    // 1. Direct slug or b2b prefix
    if ( $term->slug === 'b2b' || strpos( $term->slug, 'b2b' ) !== false ) {
        $is_b2b_category = true;
    }
    // 2. Term ancestry
    if ( ! $is_b2b_category && isset( $term->term_id ) ) {
        $ancestors = get_ancestors( $term->term_id, 'product_cat' );
        foreach ( $ancestors as $anc_id ) {
            $anc = get_term( $anc_id, 'product_cat' );
            if ( $anc && strpos( $anc->slug, 'b2b' ) !== false ) {
                $is_b2b_category = true;
                break;
            }
        }
    }
    // 3. Known commercial B2B categories
    $b2b_commercial_slugs = array(
        'commercial-refrigeration', 'b2b-commercial-refrigeration', 'refrigeration', 'refrigeration-2',
        'cold-storages', 'cold-storages-2', 'chillers', 'chillers-central-air-conditioning',
        'deep-freezers', 'deep-freezers-2', 'water-coolers', 'storage-water-coolers',
        'bottled-water-dispensers', 'bottled-water-dispensers-2', 'visi-coolers', 'visi-coolers-2',
        'washroom-automations', 'hygiene-ppe', 'entrance-solutions', 'vending-machines', 'brewing-bots',
        'central-air-conditioning', 'ducted-systems', 'vrf-systems', 'air-coolers', 'air-coolers-2',
        'desert-air-coolers', 'desert-air-coolers-2', 'b2b-air-coolers', 'b2b-water-purifiers',
        'ice-machines', 'kitchen-refrigeration-products', 'medical-refrigeration-products',
        'supermarket-refrigeration', 'reach-in-chillers-and-freezers', 'undercounter-chillers-and-freezers',
        'vaccine-storage-products', 'b2b-room-air-conditioners'
    );
    if ( ! $is_b2b_category && in_array( $term->slug, $b2b_commercial_slugs, true ) ) {
        $is_b2b_category = true;
    }
    // 4. Sample check in current query
    if ( ! $is_b2b_category && have_posts() ) {
        global $wp_query;
        if ( ! empty( $wp_query->posts ) ) {
            $sample_limit = min( 6, count( $wp_query->posts ) );
            for ( $i = 0; $i < $sample_limit; $i++ ) {
                $check_id = $wp_query->posts[ $i ]->ID;
                if ( function_exists( 'snap_stitch_is_b2b_product' ) && snap_stitch_is_b2b_product( $check_id ) ) {
                    $is_b2b_category = true;
                    break;
                }
            }
        }
    }
}
?>

<div class="snap-woo-wrapper">
    <?php do_action( 'woocommerce_before_main_content' ); ?>

    <?php if ( $is_b2b_category ) : ?>
        <!-- ===================================================================
             B2B MULTI-PRODUCT FAMILY SHOWCASE
             =================================================================== -->
        <?php
        // Fetch full family products (up to 50 SKUs) for single-page showcase
        $family_args = array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => 50,
            'tax_query'      => array(
                array(
                    'taxonomy'         => 'product_cat',
                    'field'            => 'term_id',
                    'terms'            => $term->term_id,
                    'include_children' => true,
                ),
            ),
            'orderby'        => 'menu_order title',
            'order'          => 'ASC',
        );
        $family_query = new WP_Query( $family_args );
        $all_products = array();

        if ( $family_query->have_posts() ) {
            while ( $family_query->have_posts() ) {
                $family_query->the_post();
                global $product;
                if ( ! is_a( $product, 'WC_Product' ) ) {
                    $product = wc_get_product( get_the_ID() );
                }
                if ( ! $product ) continue;

                $p_id = $product->get_id();
                $specs_meta = get_post_meta( $p_id, '_technical_specs', true );
                $specs_array = is_array( $specs_meta ) ? $specs_meta : array();

                $all_products[] = array(
                    'id'           => $p_id,
                    'title'        => $product->get_name(),
                    'sku'          => $product->get_sku() ? $product->get_sku() : 'SNAP-' . $p_id,
                    'permalink'    => $product->get_permalink(),
                    'image_url'    => wp_get_attachment_image_url( $product->get_image_id(), 'large' ) ?: wc_placeholder_img_src(),
                    'thumb_url'    => wp_get_attachment_image_url( $product->get_image_id(), 'thumbnail' ) ?: wc_placeholder_img_src(),
                    'specs'        => $specs_array,
                    'brochure_url' => get_post_meta( $p_id, '_brochure_url', true ),
                    'is_featured'  => $product->is_featured(),
                    'excerpt'      => wp_strip_all_tags( $product->get_short_description() ),
                );
            }
            wp_reset_postdata();
        }
        $total_models = count( $all_products );
        ?>

        <!-- 1. Architectural Solution Hero -->
        <section class="bg-[#0A0A0A] text-white relative overflow-hidden border-b-4 border-[#1A56DB] pt-36 md:pt-44 pb-16">
            <div class="absolute inset-0 industrial-diagonal bg-[#1A56DB] opacity-10 w-2/3 pointer-events-none"></div>
            <div class="container mx-auto px-6 md:px-12 relative z-10">
                <nav class="flex mb-6 space-x-2 text-[10px] md:text-xs font-black uppercase tracking-widest text-[#FBBF24]">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-white transition-colors">Home</a>
                    <span class="text-white/30">/</span>
                    <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="hover:text-white transition-colors">B2B Solutions</a>
                    <span class="text-white/30">/</span>
                    <span class="text-white"><?php echo esc_html( $category_name ); ?></span>
                </nav>

                <div class="max-w-4xl">
                    <span class="inline-block bg-[#FBBF24] text-black font-black text-[11px] px-3.5 py-1 uppercase tracking-widest mb-4">
                        Enterprise Solutions · Multi-Product Family Showcase
                    </span>
                    <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight uppercase leading-none mb-6">
                        <?php echo esc_html( $category_name ); ?>
                    </h1>
                    <p class="text-base sm:text-lg text-zinc-300 leading-relaxed font-medium mb-8 max-w-3xl">
                        <?php
                        if ( $category_desc ) {
                            echo wp_kses_post( $category_desc );
                        } else {
                            echo "Complete industrial range engineered for heavy continuous operation. Standardized mounting, institutional volume pricing, and dedicated MEP technical support across India.";
                        }
                        ?>
                    </p>

                    <!-- Trust Pillars -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-6 border-t border-white/10 mb-8">
                        <div>
                            <div class="text-[#FBBF24] font-black text-sm uppercase tracking-wider flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-base">verified</span> Factory Direct
                            </div>
                            <div class="text-zinc-400 text-xs font-bold uppercase mt-1">Institutional Pricing</div>
                        </div>
                        <div>
                            <div class="text-[#FBBF24] font-black text-sm uppercase tracking-wider flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-base">local_shipping</span> Pan-India
                            </div>
                            <div class="text-zinc-400 text-xs font-bold uppercase mt-1">Insured Logistics</div>
                        </div>
                        <div>
                            <div class="text-[#FBBF24] font-black text-sm uppercase tracking-wider flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-base">engineering</span> ISO 9001:2015
                            </div>
                            <div class="text-zinc-400 text-xs font-bold uppercase mt-1">Quality Tested</div>
                        </div>
                        <div>
                            <div class="text-[#FBBF24] font-black text-sm uppercase tracking-wider flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-base">receipt_long</span> 100% Compliant
                            </div>
                            <div class="text-zinc-400 text-xs font-bold uppercase mt-1">GST Input Credit</div>
                        </div>
                    </div>

                    <!-- Dual Action CTAs (Uniform 52px Height) -->
                    <div class="flex flex-wrap items-center gap-3">
                        <button class="h-[52px] bg-[#FBBF24] hover:bg-yellow-400 active:scale-95 text-black px-7 font-black uppercase text-xs md:text-sm tracking-widest flex items-center justify-center gap-2 shadow-xl transition-all js-open-quote-modal" 
                                data-product="<?php echo esc_attr( $category_name ); ?>" 
                                data-sku="CATEGORY-ALL" 
                                data-custom-message="<?php echo esc_attr( "Bulk Inquiry for {$category_name} Series:\nPlease provide complete pricing catalogue, MOQ, and technical specification sheets." ); ?>">
                            <span class="material-symbols-outlined text-lg">request_quote</span>
                            <span>Request Category RFQ</span>
                        </button>
                        <a href="tel:+919823012724" class="h-[52px] bg-white hover:bg-zinc-100 active:scale-95 text-black px-6 font-black uppercase text-xs md:text-sm tracking-widest flex items-center justify-center gap-2 shadow-xl transition-all">
                            <span class="material-symbols-outlined text-lg">call</span>
                            <span>Call +91 98230 12724</span>
                        </a>
                        <a href="#spec-matrix" class="h-[52px] border-2 border-white/40 hover:border-white hover:bg-white hover:text-black active:scale-95 text-white px-6 font-black uppercase text-xs md:text-sm tracking-widest flex items-center justify-center gap-2 bg-black/30 backdrop-blur-sm transition-all">
                            <span>Compare All Models (<?php echo esc_html( $total_models ); ?>)</span>
                            <span class="material-symbols-outlined text-lg">arrow_downward</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. Sticky Subnav Bar -->
        <div class="sticky top-20 z-40 bg-[#0A0A0A]/95 backdrop-blur-md border-b-2 border-[#1A56DB] px-6 md:px-12 py-3.5 shadow-xl">
            <div class="container mx-auto flex items-center justify-between gap-4">
                <div class="flex items-center gap-6 overflow-x-auto no-scrollbar text-xs font-bold uppercase tracking-widest">
                    <a href="#flagship-showcase" class="text-white hover:text-[#FBBF24] transition-colors whitespace-nowrap flex items-center gap-1.5">
                        <span class="w-2 h-2 bg-[#FBBF24] inline-block"></span> Featured Models
                    </a>
                    <a href="#spec-matrix" class="text-zinc-400 hover:text-white transition-colors whitespace-nowrap">
                        Technical Comparison Matrix (<?php echo esc_html( $total_models ); ?>)
                    </a>
                    <a href="#procurement-faq" class="text-zinc-400 hover:text-white transition-colors whitespace-nowrap hidden sm:inline">
                        Procurement &amp; Warranty
                    </a>
                </div>
                <div class="flex items-center gap-2.5 shrink-0">
                    <span id="sticky-counter" class="text-[#FBBF24] font-black text-xs uppercase tracking-widest hidden sm:inline mr-1">
                        <span id="sticky-counter-num">0</span> Selected
                    </span>
                    <a href="tel:+919823012724" class="h-[38px] border-2 border-white/30 hover:border-white hover:bg-white hover:text-black active:scale-95 text-white text-[11px] font-black uppercase px-3.5 flex items-center justify-center gap-1.5 transition-all">
                        <span class="material-symbols-outlined text-sm">call</span>
                        <span class="hidden sm:inline">Call Sales</span>
                    </a>
                    <button class="h-[38px] bg-[#FBBF24] hover:bg-yellow-400 active:scale-95 text-black text-[11px] font-black uppercase px-4 flex items-center justify-center gap-1.5 transition-all shadow-md js-open-quote-modal" 
                            data-product="<?php echo esc_attr( $category_name ); ?>" 
                            data-sku="SERIES-QUOTE">
                        <span class="material-symbols-outlined text-sm">request_quote</span>
                        <span>Request Quote</span>
                    </button>
                </div>
            </div>
        </div>

        <main class="container mx-auto px-6 md:px-12 py-16">
            <!-- 3. Flagship Alternating Split Blocks (Chai Point Style) -->
            <section id="flagship-showcase" class="mb-24">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-12 border-b-4 border-[#1A56DB] pb-4">
                    <div>
                        <span class="text-[#1A56DB] font-black uppercase tracking-widest text-xs">Flagship Industrial Series</span>
                        <h2 class="text-3xl md:text-4xl font-extrabold uppercase tracking-tight text-[#0A0A0A]">
                            Engineered For Continuous Operation
                        </h2>
                    </div>
                    <p class="text-zinc-500 font-medium text-xs md:text-sm max-w-md">
                        Review high-capacity models with detailed engineering specs. Select multiple items to request combined institutional pricing.
                    </p>
                </div>

                <?php if ( ! empty( $all_products ) ) : ?>
                    <div class="space-y-16">
                        <?php
                        $display_limit = min( 6, count( $all_products ) );
                        for ( $idx = 0; $idx < $display_limit; $idx++ ) :
                            $item = $all_products[ $idx ];
                            $is_even = ( $idx % 2 === 0 );
                        ?>
                        <article class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center bg-white border-2 border-zinc-200 p-6 sm:p-10 relative transition-all duration-300 hover:border-black" style="box-shadow: 6px 6px 0px 0px #1A56DB;">
                            
                            <!-- Visual Column -->
                            <div class="lg:col-span-5 <?php echo $is_even ? 'lg:order-1' : 'lg:order-2'; ?> flex flex-col justify-center">
                                <div class="relative aspect-square bg-zinc-50 border border-zinc-200 flex items-center justify-center p-8 overflow-hidden group">
                                    <span class="absolute top-3 left-3 bg-[#FBBF24] text-black font-black text-[10px] uppercase px-2.5 py-1 tracking-wider z-10">
                                        MODEL: <?php echo esc_html( $item['sku'] ); ?>
                                    </span>

                                    <!-- Quick Batch Select Checkbox -->
                                    <label class="absolute top-3 right-3 z-10 flex items-center gap-1.5 bg-[#0A0A0A] text-white text-[10px] font-black uppercase px-2.5 py-1 cursor-pointer border border-zinc-700 hover:border-[#FBBF24] transition-all">
                                        <input type="checkbox" class="b2b-sku-checkbox accent-[#FBBF24] w-3.5 h-3.5 cursor-pointer" 
                                               data-id="<?php echo esc_attr( $item['id'] ); ?>" 
                                               data-title="<?php echo esc_attr( $item['title'] ); ?>" 
                                               data-sku="<?php echo esc_attr( $item['sku'] ); ?>">
                                        <span>Select for Quote</span>
                                    </label>

                                    <img src="<?php echo esc_url( $item['image_url'] ); ?>" 
                                         alt="<?php echo esc_attr( $item['title'] ); ?>" 
                                         class="w-full h-full object-contain mix-blend-multiply group-hover:scale-105 transition-transform duration-500">
                                </div>
                            </div>

                            <!-- Specification & Action Column -->
                            <div class="lg:col-span-7 <?php echo $is_even ? 'lg:order-2' : 'lg:order-1'; ?> flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center gap-3 mb-2">
                                        <span class="bg-[#1A56DB] text-white font-black text-[9px] uppercase px-2 py-0.5 tracking-widest">B2B Heavy Duty</span>
                                        <span class="text-zinc-500 text-xs font-bold uppercase tracking-wider">Institutional Pricing Only</span>
                                    </div>
                                    <h3 class="text-2xl sm:text-3xl font-extrabold uppercase text-[#0A0A0A] tracking-tight mb-3">
                                        <?php echo esc_html( $item['title'] ); ?>
                                    </h3>
                                    <?php if ( ! empty( $item['excerpt'] ) ) : ?>
                                        <p class="text-zinc-600 text-sm font-medium mb-6 leading-relaxed">
                                            <?php echo esc_html( $item['excerpt'] ); ?>
                                        </p>
                                    <?php endif; ?>

                                    <!-- Technical Specs Table -->
                                    <div class="border border-zinc-200 mb-6 overflow-hidden">
                                        <table class="w-full text-left text-xs">
                                            <tbody class="divide-y divide-zinc-200">
                                                <?php
                                                if ( ! empty( $item['specs'] ) ) {
                                                    $spec_rows = array_slice( $item['specs'], 0, 5 );
                                                    foreach ( $spec_rows as $spec ) {
                                                        echo '<tr class="odd:bg-zinc-50 even:bg-white">';
                                                        echo '<td class="py-2.5 px-3.5 font-bold uppercase text-zinc-500 w-1/3 border-r border-zinc-200">' . esc_html( $spec['name'] ) . '</td>';
                                                        echo '<td class="py-2.5 px-3.5 font-extrabold text-[#0A0A0A]">' . esc_html( $spec['value'] ) . '</td>';
                                                        echo '</tr>';
                                                    }
                                                } else {
                                                    echo '<tr class="bg-zinc-50"><td class="py-2.5 px-3.5 font-bold text-zinc-500 w-1/3 border-r border-zinc-200">DUTY CYCLE</td><td class="py-2.5 px-3.5 font-extrabold text-[#0A0A0A]">Continuous 24/7 Heavy Duty</td></tr>';
                                                    echo '<tr class="bg-white"><td class="py-2.5 px-3.5 font-bold text-zinc-500 w-1/3 border-r border-zinc-200">WARRANTY</td><td class="py-2.5 px-3.5 font-extrabold text-[#0A0A0A]">Comprehensive Pan-India AMC Available</td></tr>';
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Action Button Bar (Equal Width & Equal 48px Height Grid) -->
                                <div class="grid grid-cols-2 <?php echo ! empty( $item['brochure_url'] ) ? 'sm:grid-cols-4' : 'sm:grid-cols-3'; ?> gap-2.5 pt-3 w-full">
                                    <button class="h-[48px] w-full bg-[#FBBF24] hover:bg-yellow-400 active:scale-95 text-black font-black uppercase text-xs tracking-wider flex items-center justify-center gap-1.5 shadow-md transition-all js-open-quote-modal"
                                            data-product="<?php echo esc_attr( $item['title'] ); ?>" 
                                            data-sku="<?php echo esc_attr( $item['sku'] ); ?>">
                                        <span class="material-symbols-outlined text-base">request_quote</span>
                                        <span>Quote</span>
                                    </button>

                                    <a href="tel:+919823012724" 
                                       class="h-[48px] w-full bg-[#0A0A0A] hover:bg-[#1A56DB] active:scale-95 text-white font-bold uppercase text-xs tracking-wider flex items-center justify-center gap-1.5 transition-all shadow-md">
                                        <span class="material-symbols-outlined text-base">call</span>
                                        <span>Call</span>
                                    </a>

                                    <a href="https://wa.me/919823012724?text=<?php echo rawurlencode( "Hi Snap Marketing, I would like to inquire about {$item['title']} (Model: {$item['sku']})." ); ?>" 
                                       target="_blank" 
                                       rel="noopener noreferrer" 
                                       class="h-[48px] w-full bg-[#25D366] hover:bg-[#128C7E] active:scale-95 text-white font-bold uppercase text-xs tracking-wider flex items-center justify-center gap-1.5 transition-all shadow-md">
                                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                                        <span>WhatsApp</span>
                                    </a>

                                    <?php if ( ! empty( $item['brochure_url'] ) ) : ?>
                                        <a href="<?php echo esc_url( $item['brochure_url'] ); ?>" target="_blank" rel="noopener noreferrer" 
                                           class="h-[48px] w-full border-2 border-black hover:bg-black hover:text-white active:scale-95 text-black font-bold uppercase text-xs tracking-wider flex items-center justify-center gap-1.5 transition-all shadow-md">
                                            <span class="material-symbols-outlined text-base">download</span>
                                            <span>Brochure</span>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </article>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
            </section>

            <!-- 4. Comprehensive Technical Comparison Matrix (All SKUs) -->
            <section id="spec-matrix" class="mb-24 pt-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8 border-b-4 border-[#1A56DB] pb-4">
                    <div>
                        <span class="text-[#1A56DB] font-black uppercase tracking-widest text-xs">Technical Comparison</span>
                        <h2 class="text-3xl md:text-4xl font-extrabold uppercase tracking-tight text-[#0A0A0A]">
                            Complete Family Comparison Matrix
                        </h2>
                    </div>
                    <div class="text-xs font-bold uppercase text-zinc-500">
                        Total <?php echo esc_html( $total_models ); ?> models cataloged in this family
                    </div>
                </div>

                <div class="overflow-x-auto border-2 border-[#0A0A0A] bg-white shadow-2xl">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-[#1A56DB] text-white font-black uppercase tracking-wider text-[11px]">
                                <th class="p-3.5 text-center w-12 border-r border-blue-600">Select</th>
                                <th class="p-3.5 border-r border-blue-600">Model &amp; SKU</th>
                                <th class="p-3.5 border-r border-blue-600">Primary Capacity</th>
                                <th class="p-3.5 border-r border-blue-600">Operating Spec</th>
                                <th class="p-3.5 border-r border-blue-600">Application</th>
                                <th class="p-3.5 border-r border-blue-600">Pricing</th>
                                <th class="p-3.5 text-center w-36">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200">
                            <?php foreach ( $all_products as $row ) : 
                                $spec1 = ! empty( $row['specs'][0] ) ? $row['specs'][0]['value'] : 'Industrial Grade';
                                $spec2 = ! empty( $row['specs'][1] ) ? $row['specs'][1]['value'] : 'Standard 230V / 50Hz';
                                $spec3 = ! empty( $row['specs'][2] ) ? $row['specs'][2]['value'] : 'Commercial Use';
                            ?>
                            <tr class="odd:bg-white even:bg-zinc-50 hover:bg-yellow-50/50 transition-colors">
                                <td class="p-3.5 text-center border-r border-zinc-200">
                                    <input type="checkbox" class="b2b-sku-checkbox accent-[#FBBF24] w-4 h-4 cursor-pointer" 
                                           data-id="<?php echo esc_attr( $row['id'] ); ?>" 
                                           data-title="<?php echo esc_attr( $row['title'] ); ?>" 
                                           data-sku="<?php echo esc_attr( $row['sku'] ); ?>">
                                </td>
                                <td class="p-3.5 border-r border-zinc-200">
                                    <div class="flex items-center gap-3">
                                        <img src="<?php echo esc_url( $row['thumb_url'] ); ?>" 
                                             alt="<?php echo esc_attr( $row['title'] ); ?>" 
                                             class="w-10 h-10 object-contain bg-white border border-zinc-200 p-0.5 shrink-0">
                                        <div>
                                            <div class="font-black text-[#0A0A0A] uppercase leading-tight"><?php echo esc_html( $row['title'] ); ?></div>
                                            <span class="inline-block text-[10px] font-mono font-bold bg-[#FBBF24] text-black px-1.5 py-0.5 mt-0.5">
                                                SKU: <?php echo esc_html( $row['sku'] ); ?>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-3.5 font-bold text-zinc-700 border-r border-zinc-200"><?php echo esc_html( $spec1 ); ?></td>
                                <td class="p-3.5 font-medium text-zinc-600 border-r border-zinc-200"><?php echo esc_html( $spec2 ); ?></td>
                                <td class="p-3.5 font-medium text-zinc-600 border-r border-zinc-200"><?php echo esc_html( $spec3 ); ?></td>
                                <td class="p-3.5 border-r border-zinc-200">
                                    <span class="text-[10px] font-black uppercase text-zinc-500 tracking-wider">Institutional</span>
                                </td>
                                <td class="p-3.5 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <button class="h-[34px] flex-1 min-w-[65px] bg-[#0A0A0A] hover:bg-[#1A56DB] active:scale-95 text-white font-bold uppercase text-[10px] tracking-wider px-2.5 flex items-center justify-center transition-colors js-open-quote-modal" 
                                                data-product="<?php echo esc_attr( $row['title'] ); ?>" 
                                                data-sku="<?php echo esc_attr( $row['sku'] ); ?>">
                                            Quote
                                        </button>
                                        <a href="tel:+919823012724" class="h-[34px] w-[34px] bg-zinc-100 hover:bg-[#FBBF24] hover:text-black text-[#0A0A0A] border border-zinc-300 transition-colors flex items-center justify-center shrink-0" title="Call Sales">
                                            <span class="material-symbols-outlined text-xs">call</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- 5. Procurement FAQ & Trust Section -->
            <section id="procurement-faq" class="bg-zinc-100 border-2 border-zinc-300 p-8 md:p-12 mb-16">
                <div class="max-w-4xl mx-auto">
                    <span class="text-[#1A56DB] font-black uppercase tracking-widest text-xs">Procurement Guidelines</span>
                    <h2 class="text-2xl md:text-3xl font-extrabold uppercase text-[#0A0A0A] mb-8">
                        Institutional Supply &amp; Technical Support
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs text-zinc-700 mb-8">
                        <div class="bg-white p-5 border border-zinc-200">
                            <h4 class="font-black text-sm uppercase text-[#0A0A0A] mb-2 flex items-center gap-2">
                                <span class="material-symbols-outlined text-[#1A56DB]">verified_user</span> Warranty &amp; AMC
                            </h4>
                            <p class="leading-relaxed">All commercial equipment carries 1 to 5 years manufacturer warranty backed by factory certified engineers pan-India. Annual Maintenance Contracts (AMC) available.</p>
                        </div>
                        <div class="bg-white p-5 border border-zinc-200">
                            <h4 class="font-black text-sm uppercase text-[#0A0A0A] mb-2 flex items-center gap-2">
                                <span class="material-symbols-outlined text-[#1A56DB]">payments</span> Invoicing &amp; Taxes
                            </h4>
                            <p class="leading-relaxed">100% compliant GST invoices issued for corporate input tax credit. Formal purchase orders (PO) accepted for verified corporate accounts.</p>
                        </div>
                    </div>

                    <div class="bg-[#1A56DB] text-white p-6 md:p-8 flex flex-col sm:flex-row items-center justify-between gap-6">
                        <div>
                            <h3 class="text-xl font-black uppercase tracking-tight">Need A Turnkey Bill of Quantities (BOQ)?</h3>
                            <p class="text-zinc-200 text-xs mt-1">Upload your architectural drawing or equipment schedule for instant engineering appraisal.</p>
                        </div>
                        <a href="<?php echo esc_url( home_url( '/request-a-quote/' ) ); ?>" class="bg-[#FBBF24] text-black font-black uppercase text-xs tracking-widest py-3.5 px-6 hover:bg-yellow-400 shrink-0 transition-all">
                            Submit BOQ Schedule
                        </a>
                    </div>
                </div>
            </section>
        </main>

        <!-- 6. Floating Multi-SKU RFQ Batch Drawer (Client-side interactive) -->
        <div id="b2b-floating-rfq-bar" class="fixed bottom-6 left-1/2 -translate-x-1/2 z-50 w-[95%] max-w-4xl bg-[#0A0A0A] text-white border-2 border-[#FBBF24] p-4 flex flex-col sm:flex-row items-center justify-between gap-4 transition-all duration-300 transform translate-y-32 opacity-0 pointer-events-none shadow-[0_10px_40px_rgba(0,0,0,0.8)]">
            <div class="flex items-center gap-3 overflow-hidden">
                <span class="w-8 h-8 bg-[#FBBF24] text-black font-black flex items-center justify-center text-sm shrink-0" id="rfq-badge-count">0</span>
                <div>
                    <div class="font-black text-xs uppercase tracking-wider text-white">Models Selected for Batch Quote</div>
                    <div id="rfq-chip-container" class="flex flex-wrap gap-1.5 mt-1 text-[10px] text-zinc-300 font-mono"></div>
                </div>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <a href="tel:+919823012724" class="h-[46px] hidden sm:flex items-center justify-center gap-1.5 border-2 border-white/40 hover:border-white hover:bg-white hover:text-black active:scale-95 text-white font-bold uppercase text-xs px-4 transition-all">
                    <span class="material-symbols-outlined text-sm">call</span>
                    <span>Call Sales</span>
                </a>
                <button id="rfq-clear-all" class="text-zinc-400 hover:text-white text-xs uppercase font-bold underline px-2 py-1">
                    Clear
                </button>
                <button id="rfq-request-batch-btn" class="h-[46px] bg-[#FBBF24] hover:bg-yellow-400 active:scale-95 text-black font-black uppercase text-xs tracking-widest px-6 flex items-center justify-center gap-2 shadow-lg transition-all js-open-quote-modal">
                    <span>Request Batch Quote</span>
                    <span class="material-symbols-outlined text-base">arrow_forward</span>
                </button>
            </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var selectedSKUs = [];
            var floatingBar = document.getElementById('b2b-floating-rfq-bar');
            var badgeCount = document.getElementById('rfq-badge-count');
            var chipContainer = document.getElementById('rfq-chip-container');
            var stickyCounter = document.getElementById('sticky-counter');
            var stickyCounterNum = document.getElementById('sticky-counter-num');
            var batchBtn = document.getElementById('rfq-request-batch-btn');
            var clearBtn = document.getElementById('rfq-clear-all');
            var checkboxes = document.querySelectorAll('.b2b-sku-checkbox');

            function updateSelectionUI() {
                var count = selectedSKUs.length;
                if (badgeCount) badgeCount.textContent = count;
                if (stickyCounterNum) stickyCounterNum.textContent = count;

                if (count > 0) {
                    floatingBar.classList.remove('translate-y-32', 'opacity-0', 'pointer-events-none');
                    floatingBar.classList.add('translate-y-0', 'opacity-100', 'pointer-events-auto');
                    if (stickyCounter) stickyCounter.classList.remove('hidden');

                    // Render selected chips
                    if (chipContainer) {
                        chipContainer.innerHTML = selectedSKUs.slice(0, 4).map(function(s) {
                            return '<span class="bg-zinc-800 border border-zinc-700 px-1.5 py-0.5">' + s.sku + '</span>';
                        }).join('') + (count > 4 ? '<span class="text-zinc-400">+' + (count - 4) + ' more</span>' : '');
                    }

                    // Format batch payload for quote modal
                    var msg = "Multi-Model B2B Inquiry (<?php echo esc_js( $category_name ); ?> Series):\n";
                    selectedSKUs.forEach(function(item, i) {
                        msg += (i + 1) + ". Model: " + item.sku + " - " + item.title + "\n";
                    });
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
                    var id = this.dataset.id;
                    var title = this.dataset.title;
                    var sku = this.dataset.sku;

                    if (this.checked) {
                        selectedSKUs.push({ id: id, title: title, sku: sku });
                        // Synchronize any matching checkboxes on the page
                        document.querySelectorAll('.b2b-sku-checkbox[data-id="' + id + '"]').forEach(function(c) {
                            c.checked = true;
                        });
                    } else {
                        selectedSKUs = selectedSKUs.filter(function(s) { return s.id !== id; });
                        document.querySelectorAll('.b2b-sku-checkbox[data-id="' + id + '"]').forEach(function(c) {
                            c.checked = false;
                        });
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
        <!-- Dynamic Category Hero -->
        <section class="bg-[#0A0A0A] relative overflow-hidden flex items-center border-b-4 border-[#1A56DB] pt-36 md:pt-44 pb-16">
            <div class="absolute inset-0 industrial-diagonal bg-[#1A56DB] opacity-10 w-2/3 pointer-events-none"></div>
            <div class="container mx-auto px-6 md:px-12 relative z-10">
                <nav class="flex mb-6 space-x-2 text-[10px] md:text-xs font-black uppercase tracking-widest text-[#FBBF24]">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-white transition-colors">Home</a>
                    <span class="text-white/30">/</span>
                    <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="hover:text-white transition-colors">Shop</a>
                    <span class="text-white/30">/</span>
                    <span class="text-white"><?php echo esc_html( $category_name ); ?></span>
                </nav>
                <h1 class="text-5xl md:text-7xl font-black text-white leading-none tracking-tighter uppercase mb-6">
                    <?php echo esc_html( $category_name ); ?>
                </h1>
                <?php if ( $category_desc ) : ?>
                    <p class="text-lg text-white/80 max-w-3xl font-medium leading-relaxed">
                        <?php echo wp_kses_post( $category_desc ); ?>
                    </p>
                <?php endif; ?>
            </div>
        </section>

        <main class="max-w-7xl mx-auto px-6 md:px-8 py-16">
            <div class="flex flex-col lg:flex-row gap-12">
                <section class="flex-1">
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 border-t border-l border-[#1A56DB]">
                    <?php if ( have_posts() ) : ?>
                        <?php while ( have_posts() ) : the_post(); 
                            global $product; 
                            if ( ! is_a( $product, 'WC_Product' ) ) {
                                $product = wc_get_product( get_the_ID() );
                            }
                            if ( ! $product ) continue;
                            $image_url = wp_get_attachment_image_url( $product->get_image_id(), 'large' ) ?: wc_placeholder_img_src();
                            $title = $product->get_name();
                            $sku = $product->get_sku() ?: 'N/A';
                            $permalink = $product->get_permalink();
                        ?>
                            <article class="bg-white p-6 flex flex-col group relative cursor-pointer border-b border-r border-[#1A56DB]">
                                <div class="relative aspect-square mb-6 bg-surface-container-low overflow-hidden">
                                    <img alt="<?php echo esc_attr( $title ); ?>" class="w-full h-full object-contain mix-blend-multiply group-hover:scale-105 transition-transform duration-500 p-2" src="<?php echo esc_url( $image_url ); ?>"/>
                                    <div class="absolute bottom-0 left-0 bg-[#FBBF24] text-[#0A0A0A] px-2 py-1 text-[10px] font-black uppercase tracking-tighter">MODEL: <?php echo esc_html( $sku ); ?></div>
                                </div>
                                <h3 class="text-[#0A0A0A] font-black uppercase tracking-tighter text-xl mb-4 leading-tight"><?php echo esc_html( $title ); ?></h3>
                                <div class="mt-auto space-y-2">
                                    <div class="text-xl font-black mb-2 text-center text-[#0A0A0A]"><?php echo $product->get_price_html(); ?></div>
                                    <a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="w-full bg-[#1A56DB] text-white py-3 font-black uppercase tracking-widest text-xs hover:bg-[#0A0A0A] hover:text-white transition-colors block text-center">Add to Cart</a>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <div class="p-8 col-span-full text-center">
                            <h3 class="text-xl font-bold">No products found in this category.</h3>
                        </div>
                    <?php endif; ?>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12 w-full flex justify-center custom-pagination">
                        <?php woocommerce_pagination(); ?>
                    </div>
                </section>
            </div>
        </main>
    <?php endif; ?>

    <?php do_action( 'woocommerce_after_main_content' ); ?>
</div>

<?php get_footer( 'shop' ); ?>
