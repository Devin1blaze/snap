<?php
/**
 * Template Name: Register Page
 */

get_header(); ?>

<main id="primary" class="site-main min-h-screen flex items-center justify-center bg-black py-24 relative overflow-hidden">
    <!-- Decorative background elements matching the homepage -->
    <div class="absolute inset-0 z-0 opacity-20 diagonal-band bg-primary-container scale-150 -rotate-12 translate-x-1/4"></div>
    <div class="absolute w-[80%] h-[80%] bg-primary-container rounded-full blur-[120px] opacity-10 -bottom-1/4 -left-1/4"></div>

    <div class="container mx-auto px-8 relative z-10">
        <div class="max-w-md mx-auto bg-zinc-900 border-b-4 border-secondary-container p-10 shadow-2xl">
            <div class="mb-10 text-center">
                <div class="text-secondary-container font-black text-xs uppercase tracking-widest mb-2">B2B Registration</div>
                <h1 class="text-white text-4xl font-black uppercase tracking-tight">Register</h1>
            </div>

            <?php if ( ! is_user_logged_in() ) : ?>
                <?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
                    <div class="woocommerce">
                        <form method="post" class="woocommerce-form woocommerce-form-register register space-y-6" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

                            <?php do_action( 'woocommerce_register_form_start' ); ?>

                            <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
                                <div class="space-y-2">
                                    <label for="reg_username" class="text-gray-400 font-bold uppercase text-xs tracking-widest">Username <span class="text-secondary-container">*</span></label>
                                    <input type="text" class="w-full bg-zinc-800 border-none text-white p-4 focus:ring-2 focus:ring-secondary-container transition-all" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" required /><?php // phpcs:ignore WordPress.Security.NonceVerification.Missing ?>
                                </div>
                            <?php endif; ?>

                            <div class="space-y-2">
                                <label for="reg_email" class="text-gray-400 font-bold uppercase text-xs tracking-widest">Email address <span class="text-secondary-container">*</span></label>
                                <input type="email" class="w-full bg-zinc-800 border-none text-white p-4 focus:ring-2 focus:ring-secondary-container transition-all" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" required /><?php // phpcs:ignore WordPress.Security.NonceVerification.Missing ?>
                            </div>

                            <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
                                <div class="space-y-2">
                                    <label for="reg_password" class="text-gray-400 font-bold uppercase text-xs tracking-widest">Password <span class="text-secondary-container">*</span></label>
                                    <input type="password" class="w-full bg-zinc-800 border-none text-white p-4 focus:ring-2 focus:ring-secondary-container transition-all" name="password" id="reg_password" autocomplete="new-password" required />
                                </div>
                            <?php else : ?>
                                <p class="text-gray-400 text-xs italic">A link to set a new password will be sent to your email address.</p>
                            <?php endif; ?>

                            <?php do_action( 'woocommerce_register_form' ); ?>

                            <p class="text-gray-500 text-[10px] leading-relaxed uppercase tracking-tight font-bold">
                                Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our <a href="/privacy-policy" class="text-secondary-container hover:underline">privacy policy</a>.
                            </p>

                            <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                            
                            <button type="submit" class="w-full bg-secondary-container text-black font-black py-4 px-6 uppercase tracking-widest hover:bg-yellow-500 transition-colors italic" name="register" value="Register">Join B2B Network</button>

                            <div class="pt-8 text-center border-t border-zinc-800">
                                <p class="text-gray-500 text-xs font-bold uppercase mb-4 tracking-tight">Already have an account?</p>
                                <a href="/login" class="text-white border-2 border-white px-8 py-3 font-black uppercase text-sm hover:bg-white hover:text-black transition-all inline-block">Login Here</a>
                            </div>

                            <?php do_action( 'woocommerce_register_form_end' ); ?>

                        </form>
                    </div>
                <?php else : ?>
                    <div class="text-center space-y-6">
                        <p class="text-gray-300 italic">Registration is currently closed for new B2B partners. Please contact support for assistance.</p>
                        <a href="/contact" class="bg-primary-container text-white font-black py-4 px-8 uppercase tracking-widest inline-block italic">Contact Support</a>
                    </div>
                <?php endif; ?>
            <?php else : ?>
                <div class="text-center space-y-6">
                    <p class="text-gray-300">You are already registered and logged in.</p>
                    <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="bg-secondary-container text-black font-black py-4 px-8 uppercase tracking-widest inline-block italic">Go to Dashboard</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
