<?php
/**
 * The Template for displaying single products
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' ); ?>

<div class="snap-woo-wrapper">
<?php do_action('woocommerce_before_main_content'); ?>

<?php while ( have_posts() ) : the_post(); ?>

<?php
    global $product;
    if ( ! is_a( $product, 'WC_Product' ) ) {
        $product = wc_get_product( get_the_ID() );
    }
    $product_id = $product->get_id();
    $is_b2b = function_exists('snap_stitch_is_b2b_product') && snap_stitch_is_b2b_product($product_id);
?>

<main class="pt-32 pb-24">
    <!-- Breadcrumb -->
    <div class="max-w-7xl mx-auto px-8 py-6">
        <nav class="flex items-center gap-3 text-xs font-bold uppercase tracking-widest">
            <a class="text-zinc-500 hover:text-secondary" href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
            <span class="text-zinc-400">/</span>
            <?php 
                $terms = get_the_terms( $product_id, 'product_cat' );
                if ( $terms && ! is_wp_error( $terms ) ) {
                    $main_term = $terms[0];
                    echo '<a class="text-zinc-500 hover:text-secondary" href="' . esc_url( get_term_link( $main_term ) ) . '">' . esc_html( $main_term->name ) . '</a>';
                    echo '<span class="text-zinc-400">/</span>';
                }
            ?>
            <span class="text-secondary"><?php the_title(); ?></span>
        </nav>
    </div>

    <!-- Product Hero -->
    <section class="max-w-7xl mx-auto px-8">
        <div class="bg-surface-container-lowest grid grid-cols-1 lg:grid-cols-2 gap-0 border-none">
            <!-- Left: Visual Column -->
            <div class="flex flex-col gap-4 p-8 bg-white">
                <div class="relative aspect-square bg-zinc-50 flex items-center justify-center p-12 overflow-hidden">
                    <?php 
                        $image_id = $product->get_image_id();
                        if ( $image_id ) {
                            echo wp_get_attachment_image( $image_id, 'full', false, array( 'class' => 'w-full h-full object-contain hover:scale-105 transition-transform duration-500 mix-blend-multiply' ) );
                        } else {
                            echo '<span class="material-symbols-outlined text-white text-9xl opacity-20">inventory_2</span>';
                        }
                    ?>
                </div>
                <!-- Thumbnails -->
                <?php 
                    $attachment_ids = $product->get_gallery_image_ids();
                    if ( $attachment_ids ) : 
                ?>
                <div class="grid grid-cols-5 gap-2 mt-2">
                    <?php foreach ( $attachment_ids as $attachment_id ) : ?>
                    <div class="aspect-square border border-zinc-200 bg-white flex items-center justify-center p-2 hover:border-secondary transition-colors cursor-pointer overflow-hidden">
                        <?php echo wp_get_attachment_image( $attachment_id, 'thumbnail', false, array( 'class' => 'w-full h-full object-contain' ) ); ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Right: Content Column -->
            <div class="p-8 lg:p-12 flex flex-col bg-white">
                <div class="mb-4">
                    <div class="flex items-center gap-4 mb-4">
                        <?php if ( $is_b2b ) : ?>
                            <span class="inline-block bg-primary text-white text-[10px] font-black px-3 py-1 uppercase tracking-[0.2em]">B2B CATALOG</span>
                        <?php else : ?>
                            <span class="inline-block bg-primary text-white text-[10px] font-black px-3 py-1 uppercase tracking-[0.2em]">RETAIL</span>
                        <?php endif; ?>
                        <span class="bg-secondary text-black text-[10px] font-black px-3 py-1 uppercase tracking-widest">NEW ARRIVAL</span>
                    </div>
                    <h1 class="text-5xl lg:text-6xl font-black text-black leading-tight tracking-tighter mb-4">
                        <?php the_title(); ?>
                    </h1>
                    <div class="flex items-center gap-4">
                        <div class="flex text-secondary">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-widest text-zinc-500">4.8/5 — <?php echo $is_b2b ? 'Enterprise Verified' : '120 Reviews'; ?></span>
                    </div>
                </div>

                <div class="mb-8">
                    <?php if ( $is_b2b ) : ?>
                        <span class="text-secondary-container font-black uppercase text-xl tracking-widest italic"><?php echo $product->get_price_html(); ?></span>
                    <?php else : ?>
                        <div class="text-4xl font-black text-black"><?php echo $product->get_price_html(); ?></div>
                    <?php endif; ?>
                </div>

                <!-- Specs Table (Dynamic Custom Meta) -->
                <?php 
                    $tech_specs = get_post_meta( $product_id, '_technical_specs', true );
                    if ( !empty($tech_specs) && is_array($tech_specs) ) :
                ?>
                <div class="mb-6 overflow-hidden border-none">
                    <table class="w-full text-left text-sm">
                        <tbody class="divide-y-0">
                            <?php 
                            $row_count = 0;
                            foreach ( $tech_specs as $spec ) : 
                                $row_count++;
                                $bg_class = ($row_count % 2 === 0) ? 'bg-primary/5' : 'bg-white';
                                $border_class = ($row_count % 2 !== 0) ? 'border-l-4 border-secondary' : '';
                            ?>
                            <tr class="<?php echo $bg_class; ?> <?php echo $border_class; ?>">
                                <td class="py-3 px-4 font-black uppercase text-[10px] tracking-widest text-zinc-400 w-1/3"><?php echo esc_html( $spec['name'] ); ?></td>
                                <td class="py-3 px-4 font-bold text-black"><?php echo esc_html( $spec['value'] ); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php elseif ( $is_b2b ): ?>
                    <!-- Fallback Spec Table if B2B and no attributes -->
                    <div class="mb-6 p-4 bg-zinc-50 border-l-4 border-zinc-200">
                         <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Technical Data Sheet available on request.</p>
                    </div>
                <?php endif; ?>

                <!-- Enterprise Specs Info -->
                <?php 
                    $enterprise_info = get_post_meta( $product_id, '_enterprise_specs_info', true );
                    if ( ! empty( $enterprise_info ) && $is_b2b ) :
                ?>
                <details class="mb-10 group bg-surface-container-low/50" open="">
                    <summary class="list-none cursor-pointer p-4 bg-white border border-zinc-100 flex justify-between items-center text-secondary font-black text-xs uppercase tracking-widest">
                        WHY THESE SPECS MATTER FOR ENTERPRISE
                        <span class="material-symbols-outlined transition-transform group-open:rotate-180">expand_more</span>
                    </summary>
                    <div class="p-4 text-xs text-zinc-600 leading-relaxed border-x border-b border-zinc-100 bg-white prose prose-sm prose-zinc max-w-none prose-p:mb-2 prose-p:last:mb-0 prose-strong:text-black">
                        <?php echo wp_kses_post( wpautop( $enterprise_info ) ); ?>
                    </div>
                </details>
                <?php endif; ?>

                <!-- Actions -->
                <div class="space-y-4">
                    <?php if ( $is_b2b ) : ?>
                        <!-- B2B Actions -->
                        <div>
                            <a href="/request-a-quote" class="js-open-quote-modal flex items-center justify-center w-full bg-secondary text-black text-xl font-black h-[64px] uppercase tracking-tighter hover:brightness-95 active:scale-95 transition-all">SEND INQUIRY</a>
                            <p class="text-center text-[10px] font-bold uppercase tracking-widest text-zinc-400 mt-2">Typically quoted within 2 hours</p>
                        </div>
                        <div class="pt-4 flex flex-col sm:flex-row gap-4">
                              <a href="https://wa.me/919876543210" target="_blank" class="flex-1 flex items-center justify-center gap-2 bg-[#25D366] text-white font-bold min-h-[48px] py-2 px-3 uppercase tracking-widest hover:bg-[#128C7E] shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 text-[11px]">
                                  <svg class="w-5 h-5 text-white flex-shrink-0" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                                  <span class="text-center leading-tight">Chat With An Expert</span>
                              </a>

                            <?php
                                $brochure_url = get_post_meta( $product_id, '_brochure_url', true );
                                if ( ! empty( $brochure_url ) ) :
                            ?>
                            <a href="<?php echo esc_url( $brochure_url ); ?>" target="_blank" class="flex-1 flex items-center justify-center gap-2 border-2 border-zinc-200 text-black font-bold min-h-[48px] py-2 px-3 uppercase tracking-widest hover:border-black hover:bg-black hover:text-white transition-all text-[11px]">
                                <span class="material-symbols-outlined text-sm flex-shrink-0">download</span>
                                <span class="text-center leading-tight">DOWNLOAD BROCHURE</span>
                            </a>
                            <?php endif; ?>
                        </div>
                    <?php else : ?>
                        <!-- B2C Actions -->
                        <?php woocommerce_template_single_add_to_cart(); ?>
                    <?php endif; ?>
                </div>

                <div class="mt-12 pt-8 border-t border-zinc-100 flex flex-wrap gap-x-6 gap-y-4 opacity-60">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-sm" style="font-variation-settings: 'FILL' 1;">verified</span>
                        <span class="text-[10px] font-black uppercase tracking-widest">Genuine Product</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-sm" style="font-variation-settings: 'FILL' 1;">percent</span>
                        <span class="text-[10px] font-black uppercase tracking-widest">Bulk Discounts</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tabs Section -->
    <section class="max-w-7xl mx-auto px-8 mt-24">
        <div class="border-b-2 border-zinc-100 flex gap-12">
            <button class="pb-4 text-xs font-black uppercase tracking-widest text-primary border-b-4 border-primary">Product Description</button>
            <?php if ( $is_b2b ) : ?><button class="pb-4 text-xs font-black uppercase tracking-widest text-zinc-400 hover:text-black transition-colors">Specifications</button><?php endif; ?>
            <button class="pb-4 text-xs font-black uppercase tracking-widest text-zinc-400 hover:text-black transition-colors">Reviews</button>
        </div>
        <div class="py-12 max-w-4xl prose prose-zinc prose-lg">
            <?php the_content(); ?>
            <?php if ( empty(get_the_content()) ) : ?>
                <p class="text-zinc-600 leading-relaxed"><?php echo get_the_excerpt(); ?></p>
            <?php endif; ?>
        </div>
        
        <?php if ( $is_b2b ) : ?>
        <!-- Core Advantage / Technical Note Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-12">
            <div class="bg-surface-container p-8 border-l-4 border-primary">
                <h4 class="font-black text-xs uppercase tracking-widest mb-4">Core Advantage</h4>
                <ul class="space-y-3">
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary text-sm mt-1">check_circle</span>
                        <span class="text-sm font-bold">Intelligent Post-Flush Logic</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary text-sm mt-1">check_circle</span>
                        <span class="text-sm font-bold">Anti-Leak Valve Solenoid</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary text-sm mt-1">check_circle</span>
                        <span class="text-sm font-bold">Low Battery Indicator Light</span>
                    </li>
                </ul>
            </div>
            <div class="bg-black p-8 text-white border-l-4 border-secondary">
                <h4 class="font-black text-xs uppercase tracking-widest text-secondary mb-4">Technical Note</h4>
                <p class="text-sm leading-relaxed text-zinc-400">
                    Recommended for use in Airports, Hospitals, Corporate Offices, and High-End Hospitality venues. Compatible with standard concealed plumbing layouts.
                </p>
            </div>
        </div>
        <?php endif; ?>
    </section>

    <?php if ( $is_b2b ) : ?>
    <!-- Full Width Trust Banner -->
    <div class="w-full bg-primary text-white py-6 mt-24">
        <div class="max-w-7xl mx-auto px-8 flex flex-wrap justify-between items-center gap-6">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary">verified</span>
                <span class="font-black text-xs uppercase tracking-[0.2em]">Genuine Product</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary">monetization_on</span>
                <span class="font-black text-xs uppercase tracking-[0.2em]">Bulk Discounts</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary">security</span>
                <span class="font-black text-xs uppercase tracking-[0.2em]">2-Year Warranty</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary">local_shipping</span>
                <span class="font-black text-xs uppercase tracking-[0.2em]">Pan-India Delivery</span>
            </div>
        </div>
    </div>

    <?php endif; ?>

    <?php
        // Fetch up to 2 related products
        $related_products = wc_get_related_products( $product_id, 2 );
        if ( ! empty( $related_products ) ) :
    ?>
    <!-- Bundles / Cross Sells Section -->
    <section class="max-w-7xl mx-auto px-8 mt-24">
        <h2 class="text-3xl font-black mb-12 uppercase tracking-tighter">RECOMMENDED PRODUCTS</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <?php 
            $bundle_labels = ['SAVINGS BUNDLE', 'ECO BUNDLE'];
            $index = 0;
            foreach ( $related_products as $related_id ) : 
                $related_product = wc_get_product( $related_id );
                if ( ! $related_product ) continue;
                
                $rel_image_id = $related_product->get_image_id();
                $rel_image_url = $rel_image_id ? wp_get_attachment_image_url( $rel_image_id, 'large' ) : wc_placeholder_img_src( 'large' );
                $rel_title = $related_product->get_name();
                $rel_excerpt = wp_trim_words( $related_product->get_short_description(), 15, '...' );
                if ( empty( $rel_excerpt ) ) {
                    $rel_excerpt = "Enhance your facility's efficiency and hygiene with this recommended industrial product.";
                }
                $rel_link = $related_product->get_permalink();
                
                $terms = wc_get_product_terms( $related_id, 'product_cat', array( 'fields' => 'names' ) );
                $rel_cat = !empty($terms) ? $terms[0] : 'SUGGESTED ADD-ON';
                
                $label = isset($bundle_labels[$index]) ? $bundle_labels[$index] : 'RECOMMENDED';
            ?>
            <div class="group bg-white border border-zinc-100 flex flex-col md:flex-row hover:shadow-2xl transition-all duration-300">
                <div class="md:w-1/2 aspect-square bg-zinc-50 flex items-center justify-center p-8 relative overflow-hidden">
                    <img class="group-hover:scale-105 transition-transform duration-500 w-full h-full object-contain mix-blend-multiply" alt="<?php echo esc_attr($rel_title); ?>" src="<?php echo esc_url($rel_image_url); ?>">
                    <div class="absolute top-4 left-4 bg-primary text-white text-[10px] font-black px-3 py-1 uppercase tracking-widest"><?php echo esc_html($label); ?></div>
                </div>
                <div class="p-8 md:w-1/2 flex flex-col justify-center">
                    <span class="text-[10px] font-black text-zinc-400 uppercase tracking-widest"><?php echo esc_html($rel_cat); ?></span>
                    <h4 class="text-xl font-black text-black mt-2 leading-tight"><?php echo esc_html($rel_title); ?></h4>
                    <p class="text-xs text-zinc-500 mt-4 mb-6"><?php echo esc_html($rel_excerpt); ?></p>
                    <a href="<?php echo esc_url($rel_link); ?>" class="bg-black text-white text-center text-xs font-black py-4 uppercase tracking-widest hover:bg-primary transition-colors w-full block">VIEW DETAILS</a>
                </div>
            </div>
            <?php 
                $index++;
            endforeach; 
            ?>
        </div>
    </section>
    <?php endif; ?>

</main>

<?php endwhile; // end of the loop. ?>

<?php do_action('woocommerce_after_main_content'); ?>
</div>

<?php get_footer( 'shop' ); ?>