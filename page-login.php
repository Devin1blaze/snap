<?php
/**
 * Template Name: Login Page
 */

get_header(); ?>

<main id="primary" class="site-main min-h-screen flex items-center justify-center bg-black py-24 relative overflow-hidden">
    <!-- Decorative background elements matching the homepage -->
    <div class="absolute inset-0 z-0 opacity-20 diagonal-band bg-primary-container scale-150 -rotate-12 translate-x-1/4"></div>
    <div class="absolute w-[80%] h-[80%] bg-primary-container rounded-full blur-[120px] opacity-10 -bottom-1/4 -left-1/4"></div>

    <div class="container mx-auto px-8 relative z-10">
        <div class="max-w-md mx-auto bg-zinc-900 border-b-4 border-secondary-container p-10 shadow-2xl">
            <div class="mb-10 text-center">
                <div class="text-secondary-container font-black text-xs uppercase tracking-widest mb-2">B2B Portal</div>
                <h1 class="text-white text-4xl font-black uppercase tracking-tight">Login</h1>
            </div>

            <?php if ( ! is_user_logged_in() ) : ?>
                <div class="woocommerce">
                    <form class="woocommerce-form woocommerce-form-login login space-y-6" method="post">
                        
                        <?php do_action( 'woocommerce_login_form_start' ); ?>

                        <div class="space-y-2">
                            <label for="username" class="text-gray-400 font-bold uppercase text-xs tracking-widest">Username or email <span class="text-secondary-container">*</span></label>
                            <input type="text" class="w-full bg-zinc-800 border-none text-white p-4 focus:ring-2 focus:ring-secondary-container transition-all" name="username" id="username" autocomplete="username" required />
                        </div>

                        <div class="space-y-2">
                            <label for="password" class="text-gray-400 font-bold uppercase text-xs tracking-widest">Password <span class="text-secondary-container">*</span></label>
                            <input class="w-full bg-zinc-800 border-none text-white p-4 focus:ring-2 focus:ring-secondary-container transition-all" type="password" name="password" id="password" autocomplete="current-password" required />
                        </div>

                        <?php do_action( 'woocommerce_login_form' ); ?>

                        <div class="flex items-center justify-between py-2">
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input class="w-4 h-4 rounded-none bg-zinc-800 border-none text-secondary-container focus:ring-0" name="rememberme" type="checkbox" id="rememberme" value="forever" /> 
                                <span class="text-gray-400 text-xs font-bold uppercase tracking-tight group-hover:text-white transition-colors">Remember me</span>
                            </label>
                            <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="text-secondary-container text-xs font-bold uppercase tracking-tight hover:text-white transition-colors">Lost password?</a>
                        </div>

                        <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                        
                        <button type="submit" class="w-full bg-secondary-container text-black font-black py-4 px-6 uppercase tracking-widest hover:bg-yellow-500 transition-colors italic" name="login" value="Login">Access Dashboard</button>

                        <div class="pt-8 text-center border-t border-zinc-800">
                            <p class="text-gray-500 text-xs font-bold uppercase mb-4 tracking-tight">New to Snap Marketing?</p>
                            <a href="/register" class="text-white border-2 border-white px-8 py-3 font-black uppercase text-sm hover:bg-white hover:text-black transition-all inline-block">Create B2B Account</a>
                        </div>

                        <?php do_action( 'woocommerce_login_form_end' ); ?>

                    </form>
                </div>
            <?php else : ?>
                <div class="text-center space-y-6">
                    <p class="text-gray-300">You are already logged in.</p>
                    <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="bg-secondary-container text-black font-black py-4 px-8 uppercase tracking-widest inline-block italic">Go to Dashboard</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
