<?php
/**
 * Template Name: Login Page
 */

get_header(); ?>

<main id="primary" class="site-main min-h-screen flex items-center justify-center bg-zinc-50 py-24 relative overflow-hidden">
    

    <div class="container mx-auto px-8 relative z-10">
        <div class="max-w-md mx-auto bg-white border border-zinc-200 p-10 shadow-xl">
            <div class="mb-10 text-center">
                <div class="text-secondary font-black text-xs uppercase tracking-widest mb-2">Customer Portal</div>
                <h1 class="text-zinc-900 text-4xl font-black uppercase tracking-tight">Login</h1>
            </div>

            <?php if ( ! is_user_logged_in() ) : ?>
                <div class="woocommerce">
                    <form class="woocommerce-form woocommerce-form-login login space-y-6" method="post">
                        
                        <?php do_action( 'woocommerce_login_form_start' ); ?>

                        <div class="space-y-2">
                            <label for="username" class="text-zinc-600 font-bold uppercase text-xs tracking-widest">Username or email <span class="text-secondary">*</span></label>
                            <input type="text" class="w-full bg-zinc-50 border border-zinc-200 text-zinc-900 p-4 focus:ring-2 focus:ring-secondary transition-all" name="username" id="username" autocomplete="username" required />
                        </div>

                        <div class="space-y-2">
                            <label for="password" class="text-zinc-600 font-bold uppercase text-xs tracking-widest">Password <span class="text-secondary">*</span></label>
                            <input class="w-full bg-zinc-50 border border-zinc-200 text-zinc-900 p-4 focus:ring-2 focus:ring-secondary transition-all" type="password" name="password" id="password" autocomplete="current-password" required />
                        </div>

                        <?php do_action( 'woocommerce_login_form' ); ?>

                        <div class="flex items-center justify-between py-2">
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input class="w-4 h-4 rounded-none bg-zinc-50 border border-zinc-200 text-secondary focus:ring-0" name="rememberme" type="checkbox" id="rememberme" value="forever" /> 
                                <span class="text-zinc-600 text-xs font-bold uppercase tracking-tight group-hover:text-zinc-900 transition-colors">Remember me</span>
                            </label>
                            <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="text-secondary text-xs font-bold uppercase tracking-tight hover:text-zinc-900 transition-colors">Lost password?</a>
                        </div>

                        <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                        
                        <button type="submit" class="w-full bg-[#FBBF24] text-zinc-900 font-black py-4 px-6 uppercase tracking-widest hover:bg-yellow-500 transition-colors italic" name="login" value="Login">Log In</button>

                        <div class="pt-8 text-center border-t border-zinc-200">
                            <p class="text-zinc-500 text-xs font-bold uppercase mb-4 tracking-tight">New to Snap Marketing?</p>
                            <a href="/register" class="w-full block bg-[#1A56DB] text-white font-black py-4 px-6 uppercase tracking-widest hover:bg-blue-800 transition-colors italic text-center">Create Account</a>
                        </div>

                        <?php do_action( 'woocommerce_login_form_end' ); ?>

                    </form>
                </div>
            <?php else : ?>
                <div class="text-center space-y-6">
                    <p class="text-zinc-600">You are already logged in.</p>
                    <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="bg-secondary text-black font-black py-4 px-8 uppercase tracking-widest inline-block italic">Go to Dashboard</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
