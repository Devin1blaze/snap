<?php
/**
 * Order tracking form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/form-tracking.php.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

global $post;
?>

<form action="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" method="post" class="woocommerce-form woocommerce-form-track-order track_order flex flex-col gap-6">

	<?php do_action( 'woocommerce_order_tracking_form_start' ); ?>

	<div class="mb-4">
        <h2 class="text-[#0A0A0A] text-2xl font-black uppercase tracking-tight mb-2 font-['Rubik']">Find Your Shipment</h2>
        <p class="text-gray-600 font-medium font-['Nunito_Sans']"><?php esc_html_e( 'To track your order please enter your Order ID in the box below and press the "Track" button. This was given to you on your receipt and in the confirmation email you should have received.', 'woocommerce' ); ?></p>
    </div>

	<p class="form-row form-row-first w-full m-0 flex flex-col">
        <label for="orderid" class="text-xs font-extrabold uppercase tracking-wider text-black mb-2"><?php esc_html_e( 'Order ID', 'woocommerce' ); ?></label> 
        <input class="input-text border-2 border-black rounded-none p-4 w-full bg-white text-black font-semibold focus:outline-none focus:border-[#FBBF24] focus:ring-0 transition-colors" type="text" name="orderid" id="orderid" value="<?php echo isset( $_REQUEST['orderid'] ) ? esc_attr( wp_unslash( $_REQUEST['orderid'] ) ) : ''; ?>" placeholder="<?php esc_attr_e( 'Found in your order confirmation email.', 'woocommerce' ); ?>" />
    </p>

	<p class="form-row form-row-last w-full m-0 flex flex-col">
        <label for="order_email" class="text-xs font-extrabold uppercase tracking-wider text-black mb-2"><?php esc_html_e( 'Billing email', 'woocommerce' ); ?></label> 
        <input class="input-text border-2 border-black rounded-none p-4 w-full bg-white text-black font-semibold focus:outline-none focus:border-[#FBBF24] focus:ring-0 transition-colors" type="text" name="order_email" id="order_email" value="<?php echo isset( $_REQUEST['order_email'] ) ? esc_attr( wp_unslash( $_REQUEST['order_email'] ) ) : ''; ?>" placeholder="<?php esc_attr_e( 'Email you used during checkout.', 'woocommerce' ); ?>" />
    </p>

	<div class="clear"></div>

	<?php do_action( 'woocommerce_order_tracking_form' ); ?>

	<p class="form-row m-0 mt-4">
        <button type="submit" class="bg-[#FBBF24] text-[#0A0A0A] px-10 py-4 font-black uppercase text-sm tracking-widest border-2 border-black w-full hover:-translate-y-1 hover:-translate-x-1 hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] active:translate-y-0 active:translate-x-0 active:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] transition-all duration-200" name="track" value="<?php esc_attr_e( 'Track', 'woocommerce' ); ?>"><?php esc_html_e( 'Track My Order', 'woocommerce' ); ?></button>
    </p>

	<?php wp_nonce_field( 'woocommerce-order_tracking', 'woocommerce-order-tracking-nonce' ); ?>

	<?php do_action( 'woocommerce_order_tracking_form_end' ); ?>

</form>
