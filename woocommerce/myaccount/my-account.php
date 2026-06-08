<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="max-w-7xl mx-auto px-8 py-16">
    <div class="mb-10 border-b-4 border-black pb-4 flex justify-between items-end">
        <div>
            <h1 class="text-4xl font-black uppercase tracking-tighter text-black">Client Portal</h1>
            <p class="text-sm font-bold uppercase tracking-widest text-zinc-400 mt-2">Manage your procurement dashboard.</p>
        </div>
        <div class="hidden md:block">
            <span class="inline-block bg-black text-[#FBBF24] text-[10px] font-black px-4 py-2 uppercase tracking-widest">Authorized Access</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <!-- Sidebar Navigation -->
        <div class="lg:col-span-3">
            <div class="bg-zinc-50 border-2 border-black border-b-8 p-4">
                <?php
                /**
                 * My Account navigation.
                 *
                 * @since 2.6.0
                 */
                do_action( 'woocommerce_account_navigation' );
                ?>
            </div>
        </div>

        <!-- Main Dashboard Area -->
        <div class="lg:col-span-9">
            <div class="bg-white border-2 border-black border-b-8 p-8 min-h-[400px]">
                <?php
                /**
                 * My Account content.
                 *
                 * @since 2.6.0
                 */
                do_action( 'woocommerce_account_content' );
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles for My Account -->
<style>
    /* Navigation Overrides */
    .woocommerce-MyAccount-navigation ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .woocommerce-MyAccount-navigation ul li {
        border-bottom: 2px solid #e4e4e7;
    }
    .woocommerce-MyAccount-navigation ul li:last-child {
        border-bottom: none;
    }
    .woocommerce-MyAccount-navigation ul li a {
        display: block;
        padding: 1rem;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.875rem;
        color: #0A0A0A;
        transition: all 0.2s;
        border-left: 4px solid transparent;
    }
    .woocommerce-MyAccount-navigation ul li a:hover {
        background: #fff;
        border-left-color: #1A56DB;
        padding-left: 1.5rem;
    }
    .woocommerce-MyAccount-navigation ul li.is-active a {
        background: #fff;
        border-left-color: #FBBF24;
        color: #1A56DB;
    }
    
    /* Content Overrides */
    .woocommerce-MyAccount-content h2,
    .woocommerce-MyAccount-content h3 {
        font-size: 1.5rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: -0.05em;
        margin-bottom: 1.5rem;
        border-bottom: 2px solid #000;
        padding-bottom: 0.5rem;
    }
    .woocommerce-MyAccount-content table.shop_table {
        width: 100%;
        text-align: left;
        border-collapse: collapse;
        margin-bottom: 2rem;
    }
    .woocommerce-MyAccount-content table.shop_table th {
        font-size: 10px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        padding: 1rem;
        background: #000;
        color: #fff;
    }
    .woocommerce-MyAccount-content table.shop_table td {
        padding: 1rem;
        border-bottom: 1px solid #e4e4e7;
        font-weight: 600;
        font-size: 0.875rem;
    }
    .woocommerce-MyAccount-content .button {
        display: inline-block;
        background-color: #000;
        color: #fff;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        padding: 0.75rem 1.5rem;
        font-size: 0.75rem;
        border: 2px solid #000;
        cursor: pointer;
        transition: all 0.2s;
    }
    .woocommerce-MyAccount-content .button:hover {
        background-color: #FBBF24;
        color: #000;
    }
    .woocommerce-MyAccount-content form fieldset {
        border: 2px solid #e4e4e7;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    .woocommerce-MyAccount-content form fieldset legend {
        font-weight: 900;
        text-transform: uppercase;
        padding: 0 0.5rem;
    }
    .woocommerce-MyAccount-content mark {
        background-color: #FBBF24;
        color: #000;
        font-weight: 900;
        padding: 0.1rem 0.4rem;
    }
    .woocommerce-MyAccount-content .woocommerce-info,
    .woocommerce-MyAccount-content .woocommerce-message,
    .woocommerce-MyAccount-content .woocommerce-error {
        background: #f4f4f5;
        border-left: 4px solid #1A56DB;
        padding: 1rem 1.5rem;
        font-weight: 700;
        margin-bottom: 2rem;
    }
    .woocommerce-MyAccount-content .woocommerce-error {
        border-left-color: #dc2626;
    }
</style>
