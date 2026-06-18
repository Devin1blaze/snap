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
        <div class="max-w-3xl mx-auto bg-zinc-900 border-b-4 border-secondary-container p-10 shadow-2xl">
            <div class="mb-10 text-center">
                <div class="text-secondary-container font-black text-xs uppercase tracking-widest mb-2">Customer Registration</div>
                <h1 class="text-white text-4xl font-black uppercase tracking-tight">Register</h1>
            </div>

            <?php if ( ! is_user_logged_in() ) : ?>
                <?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
                    <div class="woocommerce">
                        <?php wc_print_notices(); ?>
                        
                        <form method="post" class="woocommerce-form woocommerce-form-register register space-y-8" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

                            <?php do_action( 'woocommerce_register_form_start' ); ?>

                            <!-- Section 1: Account Info -->
                            <div class="space-y-6">
                                <h3 class="text-secondary-container font-black text-sm uppercase tracking-widest border-b border-zinc-800 pb-2">1. Account Info</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
                                        <div class="space-y-2">
                                            <label for="reg_username" class="text-gray-400 font-bold uppercase text-xs tracking-widest">Username <span class="text-secondary-container">*</span></label>
                                            <input type="text" class="w-full bg-zinc-800 border-none text-white p-4 focus:ring-2 focus:ring-secondary-container transition-all placeholder-zinc-500" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" required placeholder="Enter username" />
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="space-y-2 <?php echo ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) ? '' : 'md:col-span-2'; ?>">
                                        <label for="reg_email" class="text-gray-400 font-bold uppercase text-xs tracking-widest">Email address <span class="text-secondary-container">*</span></label>
                                        <input type="email" class="w-full bg-zinc-800 border-none text-white p-4 focus:ring-2 focus:ring-secondary-container transition-all placeholder-zinc-500" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" required placeholder="you@example.com" />
                                    </div>

                                    <div class="space-y-2 md:col-span-2">
                                        <label for="reg_email_confirm" class="text-gray-400 font-bold uppercase text-xs tracking-widest">Confirm Email Address <span class="text-secondary-container">*</span></label>
                                        <input type="email" class="w-full bg-zinc-800 border-none text-white p-4 focus:ring-2 focus:ring-secondary-container transition-all placeholder-zinc-500" name="email_confirm" id="reg_email_confirm" autocomplete="email" value="<?php echo ( ! empty( $_POST['email_confirm'] ) ) ? esc_attr( wp_unslash( $_POST['email_confirm'] ) ) : ''; ?>" required placeholder="Confirm your email address" />
                                    </div>

                                    <div class="space-y-2">
                                        <label for="reg_password" class="text-gray-400 font-bold uppercase text-xs tracking-widest">Password <span class="text-secondary-container">*</span></label>
                                        <input type="password" class="w-full bg-zinc-800 border-none text-white p-4 focus:ring-2 focus:ring-secondary-container transition-all placeholder-zinc-500" name="password" id="reg_password" autocomplete="new-password" required placeholder="••••••••" />
                                    </div>

                                    <div class="space-y-2">
                                        <label for="reg_password_confirm" class="text-gray-400 font-bold uppercase text-xs tracking-widest">Confirm Password <span class="text-secondary-container">*</span></label>
                                        <input type="password" class="w-full bg-zinc-800 border-none text-white p-4 focus:ring-2 focus:ring-secondary-container transition-all placeholder-zinc-500" name="password_confirm" id="reg_password_confirm" autocomplete="new-password" required placeholder="••••••••" />
                                    </div>
                                </div>
                            </div>

                            <!-- Section 2: Personal Details -->
                            <div class="space-y-6 pt-6 border-t border-zinc-800">
                                <h3 class="text-secondary-container font-black text-sm uppercase tracking-widest border-b border-zinc-800 pb-2">2. Personal Details</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label for="reg_billing_first_name" class="text-gray-400 font-bold uppercase text-xs tracking-widest">First Name <span class="text-secondary-container">*</span></label>
                                        <input type="text" class="w-full bg-zinc-800 border-none text-white p-4 focus:ring-2 focus:ring-secondary-container transition-all placeholder-zinc-500" name="billing_first_name" id="reg_billing_first_name" value="<?php echo ( ! empty( $_POST['billing_first_name'] ) ) ? esc_attr( wp_unslash( $_POST['billing_first_name'] ) ) : ''; ?>" required placeholder="John" />
                                    </div>

                                    <div class="space-y-2">
                                        <label for="reg_billing_last_name" class="text-gray-400 font-bold uppercase text-xs tracking-widest">Last Name <span class="text-secondary-container">*</span></label>
                                        <input type="text" class="w-full bg-zinc-800 border-none text-white p-4 focus:ring-2 focus:ring-secondary-container transition-all placeholder-zinc-500" name="billing_last_name" id="reg_billing_last_name" value="<?php echo ( ! empty( $_POST['billing_last_name'] ) ) ? esc_attr( wp_unslash( $_POST['billing_last_name'] ) ) : ''; ?>" required placeholder="Doe" />
                                    </div>

                                    <div class="space-y-2 md:col-span-2">
                                        <label for="reg_billing_phone" class="text-gray-400 font-bold uppercase text-xs tracking-widest">Phone Number <span class="text-secondary-container">*</span></label>
                                        <input type="tel" class="w-full bg-zinc-800 border-none text-white p-4 focus:ring-2 focus:ring-secondary-container transition-all placeholder-zinc-500" name="billing_phone" id="reg_billing_phone" value="<?php echo ( ! empty( $_POST['billing_phone'] ) ) ? esc_attr( wp_unslash( $_POST['billing_phone'] ) ) : ''; ?>" required placeholder="1234567890" />
                                    </div>

                                    <div class="space-y-2">
                                        <label for="reg_gender" class="text-gray-400 font-bold uppercase text-xs tracking-widest">Gender</label>
                                        <select class="w-full bg-zinc-800 border-none text-white p-4 focus:ring-2 focus:ring-secondary-container transition-all cursor-pointer font-bold" name="gender" id="reg_gender">
                                            <option value="" <?php selected( empty( $_POST['gender'] ), true ); ?>>Select Gender</option>
                                            <option value="male" <?php selected( ( ! empty( $_POST['gender'] ) && 'male' === $_POST['gender'] ), true ); ?>>Male</option>
                                            <option value="female" <?php selected( ( ! empty( $_POST['gender'] ) && 'female' === $_POST['gender'] ), true ); ?>>Female</option>
                                            <option value="other" <?php selected( ( ! empty( $_POST['gender'] ) && 'other' === $_POST['gender'] ), true ); ?>>Other</option>
                                            <option value="prefer_not_to_say" <?php selected( ( ! empty( $_POST['gender'] ) && 'prefer_not_to_say' === $_POST['gender'] ), true ); ?>>Prefer not to say</option>
                                        </select>
                                    </div>

                                    <div class="space-y-2">
                                        <label for="reg_dob" class="text-gray-400 font-bold uppercase text-xs tracking-widest">Date of Birth</label>
                                        <input type="date" class="w-full bg-zinc-800 border-none text-white p-4 focus:ring-2 focus:ring-secondary-container transition-all" name="dob" id="reg_dob" value="<?php echo ( ! empty( $_POST['dob'] ) ) ? esc_attr( wp_unslash( $_POST['dob'] ) ) : ''; ?>" />
                                    </div>
                                </div>
                            </div>

                            <!-- Section 3: Billing Address -->
                            <div class="space-y-6 pt-6 border-t border-zinc-800">
                                <h3 class="text-secondary-container font-black text-sm uppercase tracking-widest border-b border-zinc-800 pb-2">3. Billing Address</h3>
                                <input type="hidden" name="billing_country" value="IN" />
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2 md:col-span-2">
                                        <label for="reg_billing_address_1" class="text-gray-400 font-bold uppercase text-xs tracking-widest">Street Address <span class="text-secondary-container">*</span></label>
                                        <input type="text" class="w-full bg-zinc-800 border-none text-white p-4 focus:ring-2 focus:ring-secondary-container transition-all placeholder-zinc-500" name="billing_address_1" id="reg_billing_address_1" value="<?php echo ( ! empty( $_POST['billing_address_1'] ) ) ? esc_attr( wp_unslash( $_POST['billing_address_1'] ) ) : ''; ?>" required placeholder="House number and street name" />
                                    </div>

                                    <div class="space-y-2 md:col-span-2">
                                        <label for="reg_billing_address_2" class="text-gray-400 font-bold uppercase text-xs tracking-widest">Apartment, suite, unit, etc. (optional)</label>
                                        <input type="text" class="w-full bg-zinc-800 border-none text-white p-4 focus:ring-2 focus:ring-secondary-container transition-all placeholder-zinc-500" name="billing_address_2" id="reg_billing_address_2" value="<?php echo ( ! empty( $_POST['billing_address_2'] ) ) ? esc_attr( wp_unslash( $_POST['billing_address_2'] ) ) : ''; ?>" placeholder="Apartment, suite, unit, etc. (optional)" />
                                    </div>

                                    <div class="space-y-2">
                                        <label for="reg_billing_city" class="text-gray-400 font-bold uppercase text-xs tracking-widest">Town / City <span class="text-secondary-container">*</span></label>
                                        <input type="text" class="w-full bg-zinc-800 border-none text-white p-4 focus:ring-2 focus:ring-secondary-container transition-all placeholder-zinc-500" name="billing_city" id="reg_billing_city" value="<?php echo ( ! empty( $_POST['billing_city'] ) ) ? esc_attr( wp_unslash( $_POST['billing_city'] ) ) : ''; ?>" required placeholder="City" />
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="space-y-2">
                                            <label for="reg_billing_state" class="text-gray-400 font-bold uppercase text-xs tracking-widest">State <span class="text-secondary-container">*</span></label>
                                            <input type="text" class="w-full bg-zinc-800 border-none text-white p-4 focus:ring-2 focus:ring-secondary-container transition-all placeholder-zinc-500" name="billing_state" id="reg_billing_state" value="<?php echo ( ! empty( $_POST['billing_state'] ) ) ? esc_attr( wp_unslash( $_POST['billing_state'] ) ) : ''; ?>" required placeholder="State" />
                                        </div>

                                        <div class="space-y-2">
                                            <label for="reg_billing_postcode" class="text-gray-400 font-bold uppercase text-xs tracking-widest">PIN / ZIP <span class="text-secondary-container">*</span></label>
                                            <input type="text" class="w-full bg-zinc-800 border-none text-white p-4 focus:ring-2 focus:ring-secondary-container transition-all placeholder-zinc-500" name="billing_postcode" id="reg_billing_postcode" value="<?php echo ( ! empty( $_POST['billing_postcode'] ) ) ? esc_attr( wp_unslash( $_POST['billing_postcode'] ) ) : ''; ?>" required placeholder="123456" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 4: Shipping Address -->
                            <div class="space-y-6 pt-6 border-t border-zinc-800">
                                <h3 class="text-secondary-container font-black text-sm uppercase tracking-widest border-b border-zinc-800 pb-2">4. Shipping Address</h3>
                                
                                <div class="py-2">
                                    <label class="flex items-center space-x-3 cursor-pointer text-gray-300">
                                        <input type="hidden" name="ship_to_different_address" id="ship_to_different_address" value="<?php echo ( ! empty( $_POST['ship_to_different_address'] ) ) ? '1' : ''; ?>" />
                                        <input type="checkbox" id="shipping_same_as_billing" value="1" <?php checked( empty( $_POST ) || empty( $_POST['ship_to_different_address'] ), true ); ?> class="form-checkbox h-5 w-5 rounded-none text-black bg-zinc-800 border-none checked:bg-secondary-container checked:border-none focus:ring-2 focus:ring-secondary-container transition-all" />
                                        <span class="text-xs font-bold uppercase tracking-widest">Shipping address is the same as billing address</span>
                                    </label>
                                </div>

                                <div id="shipping_address_section" class="space-y-6 hidden">
                                    <input type="hidden" name="shipping_country" value="IN" />
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2">
                                            <label for="reg_shipping_first_name" class="text-gray-400 font-bold uppercase text-xs tracking-widest">First Name <span class="text-secondary-container">*</span></label>
                                            <input type="text" class="w-full bg-zinc-800 border-none text-white p-4 focus:ring-2 focus:ring-secondary-container transition-all placeholder-zinc-500" name="shipping_first_name" id="reg_shipping_first_name" value="<?php echo ( ! empty( $_POST['shipping_first_name'] ) ) ? esc_attr( wp_unslash( $_POST['shipping_first_name'] ) ) : ''; ?>" data-required="true" placeholder="John" />
                                        </div>

                                        <div class="space-y-2">
                                            <label for="reg_shipping_last_name" class="text-gray-400 font-bold uppercase text-xs tracking-widest">Last Name <span class="text-secondary-container">*</span></label>
                                            <input type="text" class="w-full bg-zinc-800 border-none text-white p-4 focus:ring-2 focus:ring-secondary-container transition-all placeholder-zinc-500" name="shipping_last_name" id="reg_shipping_last_name" value="<?php echo ( ! empty( $_POST['shipping_last_name'] ) ) ? esc_attr( wp_unslash( $_POST['shipping_last_name'] ) ) : ''; ?>" data-required="true" placeholder="Doe" />
                                        </div>

                                        <div class="space-y-2 md:col-span-2">
                                            <label for="reg_shipping_address_1" class="text-gray-400 font-bold uppercase text-xs tracking-widest">Street Address <span class="text-secondary-container">*</span></label>
                                            <input type="text" class="w-full bg-zinc-800 border-none text-white p-4 focus:ring-2 focus:ring-secondary-container transition-all placeholder-zinc-500" name="shipping_address_1" id="reg_shipping_shipping_address_1" value="<?php echo ( ! empty( $_POST['shipping_address_1'] ) ) ? esc_attr( wp_unslash( $_POST['shipping_address_1'] ) ) : ''; ?>" data-required="true" placeholder="House number and street name" />
                                        </div>

                                        <div class="space-y-2 md:col-span-2">
                                            <label for="reg_shipping_address_2" class="text-gray-400 font-bold uppercase text-xs tracking-widest">Apartment, suite, unit, etc. (optional)</label>
                                            <input type="text" class="w-full bg-zinc-800 border-none text-white p-4 focus:ring-2 focus:ring-secondary-container transition-all placeholder-zinc-500" name="shipping_address_2" id="reg_shipping_shipping_address_2" value="<?php echo ( ! empty( $_POST['shipping_address_2'] ) ) ? esc_attr( wp_unslash( $_POST['shipping_address_2'] ) ) : ''; ?>" placeholder="Apartment, suite, unit, etc. (optional)" />
                                        </div>

                                        <div class="space-y-2">
                                            <label for="reg_shipping_city" class="text-gray-400 font-bold uppercase text-xs tracking-widest">Town / City <span class="text-secondary-container">*</span></label>
                                            <input type="text" class="w-full bg-zinc-800 border-none text-white p-4 focus:ring-2 focus:ring-secondary-container transition-all placeholder-zinc-500" name="shipping_city" id="reg_shipping_shipping_city" value="<?php echo ( ! empty( $_POST['shipping_city'] ) ) ? esc_attr( wp_unslash( $_POST['shipping_city'] ) ) : ''; ?>" data-required="true" placeholder="City" />
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="space-y-2">
                                                <label for="reg_shipping_state" class="text-gray-400 font-bold uppercase text-xs tracking-widest">State <span class="text-secondary-container">*</span></label>
                                                <input type="text" class="w-full bg-zinc-800 border-none text-white p-4 focus:ring-2 focus:ring-secondary-container transition-all placeholder-zinc-500" name="shipping_state" id="reg_shipping_shipping_state" value="<?php echo ( ! empty( $_POST['shipping_state'] ) ) ? esc_attr( wp_unslash( $_POST['shipping_state'] ) ) : ''; ?>" data-required="true" placeholder="State" />
                                            </div>

                                            <div class="space-y-2">
                                                <label for="reg_shipping_postcode" class="text-gray-400 font-bold uppercase text-xs tracking-widest">PIN / ZIP <span class="text-secondary-container">*</span></label>
                                                <input type="text" class="w-full bg-zinc-800 border-none text-white p-4 focus:ring-2 focus:ring-secondary-container transition-all placeholder-zinc-500" name="shipping_postcode" id="reg_shipping_shipping_postcode" value="<?php echo ( ! empty( $_POST['shipping_postcode'] ) ) ? esc_attr( wp_unslash( $_POST['shipping_postcode'] ) ) : ''; ?>" data-required="true" placeholder="123456" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 5: Preferences & Agreements -->
                            <div class="space-y-6 pt-6 border-t border-zinc-800">
                                <h3 class="text-secondary-container font-black text-sm uppercase tracking-widest border-b border-zinc-800 pb-2">5. Preferences & Agreements</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2 md:col-span-2">
                                        <label for="reg_hear_about_us" class="text-gray-400 font-bold uppercase text-xs tracking-widest">How did you hear about us?</label>
                                        <select class="w-full bg-zinc-800 border-none text-white p-4 focus:ring-2 focus:ring-secondary-container transition-all cursor-pointer font-bold" name="hear_about_us" id="reg_hear_about_us">
                                            <option value="" <?php selected( empty( $_POST['hear_about_us'] ), true ); ?>>Select an Option</option>
                                            <option value="google" <?php selected( ( ! empty( $_POST['hear_about_us'] ) && 'google' === $_POST['hear_about_us'] ), true ); ?>>Google</option>
                                            <option value="social" <?php selected( ( ! empty( $_POST['hear_about_us'] ) && 'social' === $_POST['hear_about_us'] ), true ); ?>>Social Media</option>
                                            <option value="friend" <?php selected( ( ! empty( $_POST['hear_about_us'] ) && 'friend' === $_POST['hear_about_us'] ), true ); ?>>Friend / Word of Mouth</option>
                                            <option value="ad" <?php selected( ( ! empty( $_POST['hear_about_us'] ) && 'ad' === $_POST['hear_about_us'] ), true ); ?>>Advertisement</option>
                                            <option value="other" <?php selected( ( ! empty( $_POST['hear_about_us'] ) && 'other' === $_POST['hear_about_us'] ), true ); ?>>Other</option>
                                        </select>
                                    </div>

                                    <div class="space-y-4 md:col-span-2">
                                        <label class="flex items-start space-x-3 cursor-pointer text-gray-300">
                                            <input type="checkbox" name="newsletter_opt_in" id="reg_newsletter_opt_in" value="1" <?php checked( empty( $_POST ) || ! empty( $_POST['newsletter_opt_in'] ), true ); ?> class="form-checkbox h-5 w-5 rounded-none text-black bg-zinc-800 border-none checked:bg-secondary-container checked:border-none focus:ring-2 focus:ring-secondary-container transition-all mt-0.5" />
                                            <span class="text-xs font-bold uppercase tracking-widest leading-relaxed">Subscribe to our newsletter for exclusive offers and updates</span>
                                        </label>

                                        <label class="flex items-start space-x-3 cursor-pointer text-gray-300">
                                            <input type="checkbox" name="terms_agreement" id="reg_terms_agreement" value="1" <?php checked( ! empty( $_POST['terms_agreement'] ), true ); ?> required class="form-checkbox h-5 w-5 rounded-none text-black bg-zinc-800 border-none checked:bg-secondary-container checked:border-none focus:ring-2 focus:ring-secondary-container transition-all mt-0.5" />
                                            <span class="text-xs font-bold uppercase tracking-widest leading-relaxed">I agree to the <a href="/terms-and-conditions" class="text-secondary-container hover:underline" target="_blank">Terms & Conditions</a> and <a href="/privacy-policy" class="text-secondary-container hover:underline" target="_blank">Privacy Policy</a> <span class="text-secondary-container">*</span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <?php do_action( 'woocommerce_register_form' ); ?>

                            <p class="text-gray-500 text-[10px] leading-relaxed uppercase tracking-tight font-bold">
                                Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our <a href="/privacy-policy" class="text-secondary-container hover:underline">privacy policy</a>.
                            </p>

                            <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                            
                            <button type="submit" class="w-full bg-secondary-container text-black font-black py-4 px-6 uppercase tracking-widest hover:bg-yellow-500 transition-colors italic" name="register" value="Register">Register</button>

                            <div class="pt-8 text-center border-t border-zinc-800">
                                <p class="text-gray-500 text-xs font-bold uppercase mb-4 tracking-tight">Already have an account?</p>
                                <a href="/login" class="text-white border-2 border-white px-8 py-3 font-black uppercase text-sm hover:bg-white hover:text-black transition-all inline-block">Login Here</a>
                            </div>

                            <?php do_action( 'woocommerce_register_form_end' ); ?>

                        </form>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const toggleCheckbox = document.getElementById('shipping_same_as_billing');
                                const hiddenDifferentAddress = document.getElementById('ship_to_different_address');
                                const shippingSection = document.getElementById('shipping_address_section');
                                
                                function toggleShipping() {
                                    if (toggleCheckbox.checked) {
                                        shippingSection.classList.add('hidden');
                                        hiddenDifferentAddress.value = '';
                                        // Remove 'required' from shipping inputs when hidden so browser doesn't block submit
                                        shippingSection.querySelectorAll('input, select').forEach(function(input) {
                                            if (input.dataset.required === 'true') {
                                                input.removeAttribute('required');
                                            }
                                        });
                                    } else {
                                        shippingSection.classList.remove('hidden');
                                        hiddenDifferentAddress.value = '1';
                                        // Add 'required' back to required shipping inputs
                                        shippingSection.querySelectorAll('input, select').forEach(function(input) {
                                            if (input.dataset.required === 'true') {
                                                input.setAttribute('required', 'required');
                                            }
                                        });
                                    }
                                }
                                
                                if (toggleCheckbox && shippingSection) {
                                    toggleCheckbox.addEventListener('change', toggleShipping);
                                    // Run once on load to set initial state
                                    toggleShipping();
                                }
                            });
                        </script>
                    </div>
                <?php else : ?>
                    <div class="text-center space-y-6">
                        <p class="text-gray-300 italic">Registration is currently closed. Please contact support for assistance.</p>
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
