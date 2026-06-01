<?php
/**
 * The template for displaying product content within loops
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}
?>
<li <?php wc_product_class( 'group flex flex-col bg-[#0A0A0A] border-l-4 border-transparent hover-card-glow hover-card-lift cursor-pointer relative shadow-2xl', $product ); ?>>
    
    <?php
    /**
     * Hook: woocommerce_before_shop_loop_item.
     *
     * @hooked woocommerce_template_loop_product_link_open - 10
     */
    do_action( 'woocommerce_before_shop_loop_item' );
    ?>

    <div class="relative overflow-hidden aspect-square bg-white">
        <?php
        /**
         * Hook: woocommerce_before_shop_loop_item_title.
         *
         * @hooked woocommerce_show_product_loop_sale_flash - 10
         * @hooked woocommerce_template_loop_product_thumbnail - 10
         */
        do_action( 'woocommerce_before_shop_loop_item_title' );
        ?>
        <!-- Glassmorphism overlay on hover -->
        <div class="absolute inset-0 bg-[#1A56DB]/40 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none flex items-center justify-center">
            <span class="text-white font-bold tracking-widest uppercase opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-300">View Details</span>
        </div>
    </div>

    <div class="p-8 flex-grow flex flex-col justify-between bg-[#0A0A0A]">
        <div>
            <h2 class="text-2xl font-bold text-white mb-3 uppercase tracking-wide group-hover:text-[#FBBF24] transition-colors leading-tight"><?php echo get_the_title(); ?></h2>
            <div class="text-zinc-400 font-medium mb-6 text-lg">
                <?php
                /**
                 * Hook: woocommerce_after_shop_loop_item_title.
                 *
                 * @hooked woocommerce_template_loop_rating - 5
                 * @hooked woocommerce_template_loop_price - 10
                 */
                do_action( 'woocommerce_after_shop_loop_item_title' );
                ?>
            </div>
        </div>
        
        <!-- Action area -->
        <div class="mt-4 border-t border-zinc-800 pt-4">
            <?php
            /**
             * Hook: woocommerce_after_shop_loop_item.
             *
             * @hooked woocommerce_template_loop_product_link_close - 5
             * @hooked woocommerce_template_loop_add_to_cart - 10
             */
            do_action( 'woocommerce_after_shop_loop_item' );
            ?>
        </div>
    </div>
</li>
