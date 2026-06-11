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

<main class="pb-24">
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
                <div class="relative aspect-square bg-primary flex items-center justify-center p-12 overflow-hidden">
                    <?php 
                        $image_id = $product->get_image_id();
                        if ( $image_id ) {
                            echo wp_get_attachment_image( $image_id, 'full', false, array( 'class' => 'w-full h-full object-contain mix-blend-screen opacity-90' ) );
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
                <div class="grid grid-cols-3 gap-4">
                    <?php foreach ( $attachment_ids as $attachment_id ) : ?>
                    <div class="aspect-square bg-surface-container-low flex items-center justify-center p-4 hover:bg-primary/5 transition-colors cursor-pointer">
                        <?php echo wp_get_attachment_image( $attachment_id, 'thumbnail', false, array( 'class' => 'max-h-full' ) ); ?>
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

                <?php if ( $is_b2b ) : ?>
                    <!-- Specs Table (Dynamic) -->
                    <?php 
                        $attributes = $product->get_attributes();
                        if ( $attributes ) :
                    ?>
                    <div class="mb-6 overflow-hidden border-none">
                        <table class="w-full text-left text-sm">
                            <tbody class="divide-y-0">
                                <?php 
                                $row_count = 0;
                                foreach ( $attributes as $attribute ) : 
                                    $row_count++;
                                    $bg_class = ($row_count % 2 === 0) ? 'bg-primary/5' : 'bg-white';
                                    $border_class = ($row_count % 2 !== 0) ? 'border-l-4 border-secondary' : '';
                                ?>
                                <tr class="<?php echo $bg_class; ?> <?php echo $border_class; ?>">
                                    <td class="py-3 px-4 font-black uppercase text-[10px] tracking-widest text-zinc-400 w-1/3"><?php echo wc_attribute_label( $attribute->get_name() ); ?></td>
                                    <td class="py-3 px-4 font-bold text-black">
                                        <?php
                                            if ( $attribute->is_taxonomy() ) {
                                                echo implode( ', ', wc_get_product_terms( $product_id, $attribute->get_name(), array( 'fields' => 'names' ) ) );
                                            } else {
                                                echo implode( ', ', $attribute->get_options() );
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                        <!-- Fallback Spec Table if no attributes -->
                        <div class="mb-6 p-4 bg-zinc-50 border-l-4 border-zinc-200">
                             <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Technical Data Sheet available on request.</p>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Actions -->
                <div class="space-y-4">
                    <?php if ( $is_b2b ) : ?>
                        <!-- B2B Actions -->
                        <div>
                            <a href="/request-a-quote" class="flex items-center justify-center w-full bg-secondary text-black text-xl font-black h-[64px] uppercase tracking-tighter hover:brightness-95 active:scale-95 transition-all">SEND INQUIRY</a>
                            <p class="text-center text-[10px] font-bold uppercase tracking-widest text-zinc-400 mt-2">Typically quoted within 2 hours</p>
                        </div>
                        <div class="pt-2">
                            <a href="https://wa.me/919876543210" target="_blank" class="group flex items-center justify-between w-full bg-zinc-900 text-white pl-6 pr-2 py-2 rounded-full hover:bg-black transition-all duration-300">
                                <div class="flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full bg-[#25D366] animate-pulse"></div>
                                    <span class="text-[11px] font-black uppercase tracking-[0.15em]">WhatsApp Desk Live</span>
                                </div>
                                <div class="bg-[#25D366] text-white px-4 py-2 rounded-full flex items-center gap-2 group-hover:scale-105 transition-transform">
                                    <span class="text-xs font-black uppercase tracking-widest">Chat Now</span>
                                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                </div>
                            </a>
                        </div>
                    <?php else : ?>
                        <!-- B2C Actions -->
                        <?php woocommerce_template_single_add_to_cart(); ?>
                    <?php endif; ?>
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
    </section>

</main>

<?php endwhile; // end of the loop. ?>

<?php do_action('woocommerce_after_main_content'); ?>
</div>

<?php get_footer( 'shop' ); ?>