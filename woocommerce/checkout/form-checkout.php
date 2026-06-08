<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
    echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
    return;
}
?>

<div class="max-w-7xl mx-auto px-8 py-16">
    <div class="mb-10 border-b-4 border-black pb-4">
        <h1 class="text-4xl font-black uppercase tracking-tighter text-black">Procurement Checkout</h1>
        <p class="text-sm font-bold uppercase tracking-widest text-zinc-400 mt-2">Securely finalize your industrial supply order.</p>
    </div>

    <form name="checkout" method="post" class="checkout woocommerce-checkout grid grid-cols-1 lg:grid-cols-12 gap-12" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

        <!-- Left Column: Billing & Shipping Details -->
        <div class="lg:col-span-7 space-y-8" id="customer_details">
            <?php if ( $checkout->get_checkout_fields() ) : ?>
                <div class="bg-white border-2 border-black border-b-8 p-8">
                    <?php do_action( 'woocommerce_checkout_billing' ); ?>
                </div>

                <div class="bg-white border-2 border-black border-b-8 p-8">
                    <?php do_action( 'woocommerce_checkout_shipping' ); ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Right Column: Order Summary & Payment -->
        <div class="lg:col-span-5">
            <div class="bg-zinc-50 border-2 border-black border-b-8 p-8 sticky top-8">
                <h3 id="order_review_heading" class="text-2xl font-black uppercase tracking-tighter text-black mb-6 border-b-2 border-black pb-2"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3>
                
                <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

                <div id="order_review" class="woocommerce-checkout-review-order">
                    <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                </div>

                <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
            </div>
        </div>

    </form>
</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

<!-- Custom Styles for Checkout Inputs to match Industrial Theme -->
<style>
    .woocommerce-checkout .form-row label {
        font-size: 10px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #52525b; /* zinc-600 */
        margin-bottom: 0.5rem;
        display: block;
    }
    .woocommerce-checkout .form-row input.input-text,
    .woocommerce-checkout .form-row select,
    .woocommerce-checkout .form-row textarea {
        width: 100%;
        border: 2px solid #000;
        padding: 0.75rem 1rem;
        font-weight: 700;
        outline: none;
        transition: all 0.2s;
    }
    .woocommerce-checkout .form-row input.input-text:focus,
    .woocommerce-checkout .form-row select:focus,
    .woocommerce-checkout .form-row textarea:focus {
        border-color: #1A56DB;
        box-shadow: 4px 4px 0 rgba(26, 86, 219, 0.2);
    }
    .woocommerce-checkout .select2-container--default .select2-selection--single {
        border: 2px solid #000;
        height: 48px;
        border-radius: 0;
    }
    .woocommerce-checkout .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 44px;
        font-weight: 700;
    }
    .woocommerce-checkout .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 46px;
    }
    
    /* Order Review Table overrides */
    #order_review table.shop_table {
        width: 100%;
        text-align: left;
        border-collapse: collapse;
        margin-bottom: 2rem;
    }
    #order_review table.shop_table th {
        font-size: 10px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        padding: 1rem 0;
        border-bottom: 2px solid #000;
    }
    #order_review table.shop_table td {
        padding: 1rem 0;
        border-bottom: 1px solid #e4e4e7;
        font-weight: 700;
        font-size: 0.875rem;
    }
    #order_review table.shop_table tfoot th,
    #order_review table.shop_table tfoot td {
        border-bottom: 2px solid #000;
    }
    #order_review table.shop_table .order-total th,
    #order_review table.shop_table .order-total td {
        font-size: 1.25rem;
        font-weight: 900;
        color: #1A56DB;
        border-bottom: none;
    }
    
    /* Payment Methods overrides */
    #payment {
        background: #fff;
        border: 2px solid #000;
        padding: 1.5rem;
    }
    #payment ul.payment_methods {
        list-style: none;
        padding: 0;
        margin: 0 0 1.5rem 0;
        border-bottom: 2px solid #e4e4e7;
    }
    #payment ul.payment_methods li {
        margin-bottom: 1rem;
    }
    #payment ul.payment_methods li label {
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.875rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    #payment div.payment_box {
        padding: 1rem;
        background: #f4f4f5;
        font-size: 0.875rem;
        font-weight: 600;
        color: #52525b;
        margin-top: 0.5rem;
        border-left: 4px solid #FBBF24;
    }
    #payment .place-order .button {
        width: 100%;
        background-color: #FBBF24;
        color: #0A0A0A;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        padding: 1.5rem;
        font-size: 1rem;
        border: 2px solid #000;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 4px 4px 0 #000;
    }
    #payment .place-order .button:hover {
        transform: translate(-2px, -2px);
        box-shadow: 6px 6px 0 #000;
    }
    #payment .place-order .button:active {
        transform: translate(2px, 2px);
        box-shadow: 2px 2px 0 #000;
    }
</style>
