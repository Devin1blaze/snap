<?php
/**
 * WooCommerce Universal Category Template
 * Applies the premium Stitch design to all product categories.
 */
defined( 'ABSPATH' ) || exit;

get_header( 'shop' ); 

$category_name = woocommerce_page_title(false);
$term = get_queried_object();
$category_desc = isset($term->description) ? $term->description : '';
if (!$category_desc && isset($term->post_content)) {
    $category_desc = $term->post_content;
}
?>

<div class="snap-woo-wrapper">
    <?php do_action('woocommerce_before_main_content'); ?>

    <!-- Dynamic Category Hero -->
    <section class="bg-[#0A0A0A] relative overflow-hidden flex items-center border-b-4 border-[#1A56DB]">
        <div class="absolute inset-0 industrial-diagonal bg-[#1A56DB] opacity-10 w-2/3 pointer-events-none"></div>
        <div class="container mx-auto px-8 py-16 md:py-24 relative z-10">
            <nav class="flex mb-6 space-x-2 text-[10px] md:text-xs font-black uppercase tracking-widest text-[#FBBF24]">
                <a href="<?php echo home_url(); ?>" class="hover:text-white transition-colors">Home</a>
                <span class="text-white/30">/</span>
                <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" class="hover:text-white transition-colors">Shop</a>
                <span class="text-white/30">/</span>
                <span class="text-white"><?php echo esc_html($category_name); ?></span>
            </nav>
            <h1 class="text-5xl md:text-7xl font-black text-white leading-none tracking-tighter uppercase mb-6">
                <?php echo esc_html($category_name); ?>
            </h1>
            <?php if ( $category_desc ) : ?>
            <div class="flex flex-col md:flex-row md:items-center gap-6">
                <p class="text-lg md:text-xl text-white/80 max-w-3xl font-medium leading-relaxed">
                    <?php echo wp_kses_post( $category_desc ); ?>
                </p>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-8 py-16">
<div class="flex flex-col lg:flex-row gap-12">
<!-- LEFT SIDEBAR: Filters -->
<aside class="w-full lg:w-72 shrink-0">
<div class="sticky top-24 space-y-10">
<div class="flex justify-between items-center mb-6 border-b-4 border-[#1A56DB] pb-2">
<h3 class="text-[#0A0A0A] font-black uppercase tracking-widest text-sm">
                        Filters
                    </h3>
<a class="text-[#FBBF24] font-black uppercase tracking-widest text-[10px] hover:underline" href="#">RESET</a>
</div>
<div class="space-y-8">
<!-- Brand Filter -->
<div>
<h4 class="text-[10px] font-bold uppercase tracking-widest text-[#1A56DB] mb-4">Brand</h4>
<div class="space-y-3">
<label class="flex items-center gap-3 cursor-pointer group">
<input checked="" class="w-5 h-5 border-2 border-[#1A56DB] text-[#FBBF24] focus:ring-[#FBBF24] rounded-none checked:bg-[#FBBF24]" type="checkbox"/>
<span class="text-sm font-bold uppercase text-[#1A56DB]">Blue Star</span>
</label>
<label class="flex items-center gap-3 cursor-pointer group">
<input class="w-5 h-5 border-2 border-[#1A56DB] text-[#FBBF24] focus:ring-[#FBBF24] rounded-none" type="checkbox"/>
<span class="text-sm font-bold uppercase group-hover:text-[#1A56DB]">Krysta</span>
</label>
</div>
</div>
<!-- Capacity Filter -->
<div>
<h4 class="text-[10px] font-bold uppercase tracking-widest text-[#1A56DB] mb-4">Capacity (Liters)</h4>
<input class="w-full h-1 bg-[#1A56DB] appearance-none cursor-pointer accent-[#FBBF24]" max="600" min="100" type="range"/>
<div class="flex justify-between mt-2 text-[10px] font-bold">
<span>100L</span>
<span>600L</span>
</div>
</div>
<!-- Temperature Filter -->
<div>
<h4 class="text-[10px] font-bold uppercase tracking-widest text-[#1A56DB] mb-4">Temp Range</h4>
<div class="grid grid-cols-1 gap-2">
<button class="border-2 border-[#FBBF24] bg-[#FBBF24] px-4 py-2 text-[10px] font-black uppercase transition-colors text-left">-25°C to -18°C</button>
<button class="border-2 border-[#1A56DB] px-4 py-2 text-[10px] font-black uppercase hover:bg-[#FBBF24] hover:border-[#FBBF24] transition-colors text-left">2°C to 8°C</button>
</div>
</div>
<!-- Rating -->
<div>
<h4 class="text-[10px] font-bold uppercase tracking-widest text-[#1A56DB] mb-4">Star Rating</h4>
<div class="flex gap-2">
<button class="w-8 h-8 border-2 border-[#1A56DB] flex items-center justify-center font-bold hover:bg-[#FBBF24] hover:border-[#FBBF24]">3</button>
<button class="w-8 h-8 border-2 border-[#1A56DB] flex items-center justify-center font-bold hover:bg-[#FBBF24] hover:border-[#FBBF24]">4</button>
<button class="w-8 h-8 border-2 border-[#1A56DB] flex items-center justify-center font-bold bg-[#FBBF24] border-[#FBBF24]">5</button>
</div>
</div>
<!-- Sidebar CTA -->
<div class="bg-[#0A0A0A] p-6 space-y-4 border-l-4 border-[#FBBF24]">
<h4 class="text-white font-black uppercase text-sm leading-tight">Need 50+ units? Call us directly</h4>
<button class="w-full bg-[#FBBF24] text-[#0A0A0A] py-3 font-black uppercase tracking-widest text-xs flex items-center justify-center gap-2">
<span class="material-symbols-outlined text-sm">call</span>
                            +1-800-SNAP-MKT
                        </button>
</div>
</div>
</div>
</aside>
<!-- RIGHT MAIN GRID -->
<section class="flex-1">
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-px bg-[#1A56DB] border border-[#1A56DB]">

<?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); global $product; ?>
        <?php 
        $image_url = wp_get_attachment_image_url( $product->get_image_id(), 'large' ) ?: wc_placeholder_img_src();
        $title = $product->get_name();
        $sku = $product->get_sku() ?: 'N/A';
        $permalink = $product->get_permalink();
        
        $specs = get_post_meta( $product->get_id(), '_technical_specs', true );
        $spec1_name = 'Capacity'; $spec1_value = 'Standard';
        $spec2_name = 'Rating'; $spec2_value = 'Industrial';
        
        if ( is_array($specs) && count($specs) > 0 ) {
            $spec1_name = $specs[0]['name'];
            $spec1_value = $specs[0]['value'];
            if ( count($specs) > 1 ) {
                $spec2_name = $specs[1]['name'];
                $spec2_value = $specs[1]['value'];
            }
        }
        $is_b2b = snap_stitch_is_b2b_product( $product->get_id() );
        ?>
        <article class="bg-white p-6 flex flex-col group relative cursor-pointer" onclick="window.location.href='<?php echo esc_url($permalink); ?>'">
            <?php if ($product->is_featured()) : ?>
            <div class="absolute top-0 left-0 z-10 bg-[#FBBF24] text-[#0A0A0A] px-3 py-1 text-[10px] font-black uppercase tracking-tighter">TOP SELLER</div>
            <?php endif; ?>
            <div class="relative aspect-square mb-6 bg-surface-container-low overflow-hidden">
                <img alt="<?php echo esc_attr($title); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 p-2" src="<?php echo esc_url($image_url); ?>"/>
                <div class="absolute bottom-0 left-0 bg-[#FBBF24] text-[#0A0A0A] px-2 py-1 text-[10px] font-black uppercase tracking-tighter">MODEL: <?php echo esc_html($sku); ?></div>
            </div>
            <h3 class="text-[#0A0A0A] font-black uppercase tracking-tighter text-xl mb-4 leading-tight"><?php echo esc_html($title); ?></h3>
            <div class="space-y-1 mb-8">
                <div class="flex justify-between text-[10px] font-bold uppercase text-[#1A56DB]">
                    <span><?php echo esc_html($spec1_name); ?></span>
                    <span><?php echo esc_html($spec1_value); ?></span>
                </div>
                <div class="flex justify-between text-[10px] font-bold uppercase text-[#1A56DB]">
                    <span><?php echo esc_html($spec2_name); ?></span>
                    <span><?php echo esc_html($spec2_value); ?></span>
                </div>
            </div>
            <div class="mt-auto space-y-2">
                <?php if ($is_b2b) : ?>
                    <button class="w-full bg-[#FBBF24] text-[#0A0A0A] py-3 font-black uppercase tracking-widest text-xs hover:bg-[#0A0A0A] hover:text-[#FBBF24] transition-colors js-open-quote-modal">Get Best Price</button>
                    <button class="w-full border-2 border-[#1A56DB] text-[#1A56DB] py-3 font-black uppercase tracking-widest text-xs hover:bg-[#1A56DB] hover:text-white transition-colors js-open-quote-modal">Add to Quote Cart</button>
                <?php else : ?>
                    <div class="text-xl font-black mb-2 text-center"><?php echo $product->get_price_html(); ?></div>
                    <a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="w-full bg-[#1A56DB] text-white py-3 font-black uppercase tracking-widest text-xs hover:bg-[#0A0A0A] hover:text-white transition-colors block text-center">Add to Cart</a>
                <?php endif; ?>
            </div>
        </article>
    <?php endwhile; ?>
<?php else : ?>
    <div class="p-8 col-span-full text-center">
        <h3 class="text-xl font-bold">No products found in this category.</h3>
    </div>
<?php endif; ?>

</div>
<!-- Custom Quote Banner -->
<div class="mt-8 bg-[#1A56DB] p-8 flex flex-col md:flex-row items-center justify-between gap-6">
<h2 class="text-white text-2xl md:text-3xl font-black uppercase tracking-tighter">CAN'T FIND YOUR SIZE? Request a Custom Quote →</h2>
<button class="bg-[#FBBF24] text-[#0A0A0A] px-8 py-4 font-black uppercase tracking-widest text-sm hover:scale-105 transition-transform shrink-0">GET CUSTOM QUOTE</button>
</div>

<!-- Pagination -->
<div class="mt-12 w-full flex justify-center custom-pagination">
    <style>
        .custom-pagination .woocommerce-pagination ul { display: flex; gap: 1rem; list-style: none; padding: 0; margin: 0; }
        .custom-pagination .woocommerce-pagination ul li { display: inline-block; }
        .custom-pagination .woocommerce-pagination ul li a, .custom-pagination .woocommerce-pagination ul li span.current { 
            display: flex; align-items: center; justify-content: center; width: 3rem; height: 3rem; font-weight: 900; 
            border: 2px solid #1A56DB; color: #1A56DB; transition: all 0.2s; 
        }
        .custom-pagination .woocommerce-pagination ul li span.current { background-color: #1A56DB; color: white; }
        .custom-pagination .woocommerce-pagination ul li a:hover { background-color: #1A56DB; color: white; }
    </style>
    <?php woocommerce_pagination(); ?>
</div>

</section>
</div>
</main>
    
    <?php do_action('woocommerce_after_main_content'); ?>
</div>

<?php get_footer( 'shop' ); ?>
