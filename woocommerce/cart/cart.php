<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<div class="max-w-7xl mx-auto px-8 py-16">
    <div class="mb-10 border-b-4 border-black pb-4">
        <h1 class="text-4xl font-black uppercase tracking-tighter text-black">Your Procurement Cart</h1>
        <p class="text-sm font-bold uppercase tracking-widest text-zinc-400 mt-2">Review your selected industrial equipment before quoting or checkout.</p>
    </div>

    <form class="woocommerce-cart-form grid grid-cols-1 lg:grid-cols-12 gap-12" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
        
        <!-- Left Column: Cart Items -->
        <div class="lg:col-span-8">
            <?php do_action( 'woocommerce_before_cart_table' ); ?>
            
            <div class="bg-white border-2 border-black border-b-8 mb-8">
                <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents w-full text-left" cellspacing="0">
                    <thead class="bg-black text-white">
                        <tr>
                            <th class="product-remove p-4 w-12">&nbsp;</th>
                            <th class="product-thumbnail p-4 w-24">&nbsp;</th>
                            <th class="product-name font-black uppercase text-[10px] tracking-widest p-4"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
                            <th class="product-price font-black uppercase text-[10px] tracking-widest p-4"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
                            <th class="product-quantity font-black uppercase text-[10px] tracking-widest p-4"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
                            <th class="product-subtotal font-black uppercase text-[10px] tracking-widest p-4"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-zinc-100">
                        <?php do_action( 'woocommerce_before_cart_contents' ); ?>

                        <?php
                        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                            $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                            $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                            if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                                $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                                ?>
                                <tr class="woocommerce-cart-form__cart-item hover:bg-zinc-50 transition-colors <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

                                    <td class="product-remove p-4 text-center">
                                        <?php
                                            echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                                'woocommerce_cart_item_remove_link',
                                                sprintf(
                                                    '<a href="%s" class="text-red-600 hover:text-black font-black text-xl flex items-center justify-center transition-colors" aria-label="%s" data-product_id="%s" data-product_sku="%s"><span class="material-symbols-outlined">close</span></a>',
                                                    esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                                    /* translators: %s is the product name */
                                                    esc_attr( sprintf( __( 'Remove %s from cart', 'woocommerce' ), wp_strip_all_tags( $_product->get_name() ) ) ),
                                                    esc_attr( $product_id ),
                                                    esc_attr( $_product->get_sku() )
                                                ),
                                                $cart_item_key
                                            );
                                        ?>
                                    </td>

                                    <td class="product-thumbnail p-4">
                                        <?php
                                        $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image('thumbnail', array('class' => 'w-16 h-16 object-contain border border-zinc-200 bg-white p-1')), $cart_item, $cart_item_key );

                                        if ( ! $product_permalink ) {
                                            echo $thumbnail; // PHPCS: XSS ok.
                                        } else {
                                            printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
                                        }
                                        ?>
                                    </td>

                                    <td class="product-name p-4" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
                                        <?php
                                        if ( ! $product_permalink ) {
                                            echo wp_kses_post( '<span class="font-bold text-sm uppercase">' . apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '</span>' );
                                        } else {
                                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s" class="font-bold text-sm uppercase text-black hover:text-[#1A56DB]">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                                        }

                                        do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

                                        // Meta data.
                                        echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

                                        // Backorder notification.
                                        if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification mt-2 text-[10px] font-black uppercase text-red-600 tracking-widest">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
                                        }
                                        ?>
                                    </td>

                                    <td class="product-price p-4" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
                                        <span class="font-bold text-sm">
                                            <?php
                                                echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
                                            ?>
                                        </span>
                                    </td>

                                    <td class="product-quantity p-4" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
                                        <?php
                                        if ( $_product->is_sold_individually() ) {
                                            $min_quantity = 1;
                                            $max_quantity = 1;
                                        } else {
                                            $min_quantity = 0;
                                            $max_quantity = $_product->get_max_purchase_quantity();
                                        }

                                        $product_quantity = woocommerce_quantity_input(
                                            array(
                                                'input_name'   => "cart[{$cart_item_key}][qty]",
                                                'input_value'  => $cart_item['quantity'],
                                                'max_value'    => $max_quantity,
                                                'min_value'    => $min_quantity,
                                                'product_name' => $_product->get_name(),
                                                'classes'      => apply_filters( 'woocommerce_quantity_input_classes', array( 'input-text', 'qty', 'text', 'w-16', 'text-center', 'border-2', 'border-black', 'font-bold', 'py-2', 'focus:ring-0', 'focus:border-[#1A56DB]' ), $_product ),
                                            ),
                                            $_product,
                                            false
                                        );

                                        echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
                                        ?>
                                    </td>

                                    <td class="product-subtotal p-4" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
                                        <span class="font-black text-sm text-[#1A56DB]">
                                            <?php
                                                echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
                                            ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>

                        <?php do_action( 'woocommerce_cart_contents' ); ?>

                        <tr>
                            <td colspan="6" class="actions p-6 bg-zinc-50 border-t-2 border-black">
                                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                                    <?php if ( wc_coupons_enabled() ) { ?>
                                        <div class="coupon flex items-center w-full md:w-auto">
                                            <input type="text" name="coupon_code" class="input-text border-2 border-black px-4 py-3 font-bold uppercase text-xs w-full md:w-64 focus:ring-0 focus:border-[#1A56DB]" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> 
                                            <button type="submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?> bg-black text-white px-6 py-3 font-black uppercase text-xs tracking-widest border-2 border-black hover:bg-white hover:text-black transition-colors shrink-0" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_html_e( 'Apply', 'woocommerce' ); ?></button>
                                            <?php do_action( 'woocommerce_cart_coupon' ); ?>
                                        </div>
                                    <?php } ?>

                                    <button type="submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?> bg-zinc-200 text-black px-6 py-3 font-black uppercase text-xs tracking-widest hover:bg-[#1A56DB] hover:text-white transition-colors w-full md:w-auto" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>
                                </div>
                                <?php do_action( 'woocommerce_cart_actions' ); ?>
                                <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                            </td>
                        </tr>

                        <?php do_action( 'woocommerce_after_cart_contents' ); ?>
                    </tbody>
                </table>
            </div>
            <?php do_action( 'woocommerce_after_cart_table' ); ?>
        </div>

        <!-- Right Column: Cart Totals -->
        <div class="lg:col-span-4">
            <div class="cart-collaterals bg-zinc-50 border-2 border-black border-b-8 p-8 sticky top-8">
                <?php
                    /**
                     * Cart collaterals hook.
                     *
                     * @hooked woocommerce_cross_sell_display
                     * @hooked woocommerce_cart_totals - 10
                     */
                    do_action( 'woocommerce_cart_collaterals' );
                ?>
            </div>
        </div>
    </form>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
