<?php
/**
 * Google Services Integration: Google Analytics 4 (GA4) & Google Search Console
 * 
 * Features:
 * 1. Output Google Site Verification meta tag for Google Search Console (Google Websearch).
 * 2. Output asynchronous gtag.js for Google Analytics 4.
 * 3. Automatic Commercial Conversion Event Tracking (WhatsApp, Phone Call, Quote Submit, FAQ Search).
 * 4. WordPress Admin Settings Page under Settings > Google Services for painless updates.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Hook into wp_head for Verification & GA4 tag
add_action( 'wp_head', 'snap_google_output_verification_and_analytics', 1 );

// Hook into wp_footer for Custom Conversion Event Tracking
add_action( 'wp_footer', 'snap_google_output_event_tracking_script', 99 );

// Admin Settings Menu
add_action( 'admin_menu', 'snap_google_services_admin_menu' );
add_action( 'admin_init', 'snap_google_services_register_settings' );

/**
 * Retrieve GA4 Measurement ID
 */
function snap_get_ga4_measurement_id() {
    if ( defined( 'SNAP_GA4_MEASUREMENT_ID' ) && ! empty( SNAP_GA4_MEASUREMENT_ID ) ) {
        return sanitize_text_field( SNAP_GA4_MEASUREMENT_ID );
    }
    return get_option( 'snap_ga4_measurement_id', '' );
}

/**
 * Retrieve Google Search Console Verification Code
 */
function snap_get_gsc_verification_code() {
    if ( defined( 'SNAP_GSC_VERIFICATION_CODE' ) && ! empty( SNAP_GSC_VERIFICATION_CODE ) ) {
        return sanitize_text_field( SNAP_GSC_VERIFICATION_CODE );
    }
    return get_option( 'snap_gsc_verification_code', '' );
}

/**
 * Output Google Search Console Verification & GA4 gtag.js in <head>
 */
function snap_google_output_verification_and_analytics() {
    $gsc_code = snap_get_gsc_verification_code();
    $ga4_id   = snap_get_ga4_measurement_id();

    // 1. Google Search Console Verification Meta Tag
    if ( ! empty( $gsc_code ) ) {
        // Strip any wrapping html tags if user accidentally pasted full <meta ...> tag
        if ( preg_match( '/content=["\']([^"\']+)["\']/i', $gsc_code, $matches ) ) {
            $clean_code = $matches[1];
        } else {
            $clean_code = trim( strip_tags( $gsc_code ) );
        }
        echo "<!-- Google Search Console (Google Websearch) Verification -->\n";
        echo '<meta name="google-site-verification" content="' . esc_attr( $clean_code ) . '" />' . "\n";
    }

    // 2. Google Analytics 4 (gtag.js)
    if ( ! empty( $ga4_id ) ) {
        echo "<!-- Google Analytics 4 (gtag.js) -->\n";
        echo '<script async src="https://www.googletagmanager.com/gtag/js?id=' . esc_attr( $ga4_id ) . '"></script>' . "\n";
        ?>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '<?php echo esc_js( $ga4_id ); ?>', {
                'send_page_view': true,
                'cookie_flags': 'SameSite=None;Secure'
            });
        </script>
        <?php
    }
}

/**
 * Output Commercial Event Tracking in <footer>
 */
function snap_google_output_event_tracking_script() {
    ?>
    <!-- Snap Marketing GA4 Commercial Event Tracking -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Helper to safely dispatch GA4 events
        function trackEvent(eventName, params) {
            if (typeof gtag === 'function') {
                gtag('event', eventName, params || {});
            }
            if (window.dataLayer && Array.isArray(window.dataLayer)) {
                window.dataLayer.push(Object.assign({ 'event': eventName }, params || {}));
            }
        }

        // 1. Track WhatsApp Clicks (Floating widget, quote buttons, direct links)
        document.querySelectorAll('a[href*="wa.me"], a[href*="whatsapp.com"]').forEach(function(el) {
            el.addEventListener('click', function() {
                var context = el.getAttribute('aria-label') || el.innerText.trim() || 'WhatsApp Button';
                trackEvent('whatsapp_inquiry', {
                    'event_category': 'Engagement',
                    'event_label': context,
                    'page_location': window.location.href
                });
            });
        });

        // 2. Track Phone Call Clicks
        document.querySelectorAll('a[href^="tel:"]').forEach(function(el) {
            el.addEventListener('click', function() {
                trackEvent('phone_call_sales', {
                    'event_category': 'Lead',
                    'event_label': el.getAttribute('href') || '+919823012724',
                    'page_location': window.location.href
                });
            });
        });

        // 3. Track Quote Button Clicks
        document.querySelectorAll('.js-open-quote-modal, a[href*="/request-a-quote"]').forEach(function(el) {
            el.addEventListener('click', function() {
                trackEvent('quote_button_click', {
                    'event_category': 'Lead Generation',
                    'event_label': el.innerText.trim() || 'Request Quote',
                    'page_location': window.location.href
                });
            });
        });

        // 4. Track Contact Form 7 Quote Submissions
        document.addEventListener('wpcf7mailsent', function(event) {
            trackEvent('bulk_quote_submit', {
                'event_category': 'Conversion',
                'event_label': 'CF7 Form ' + event.detail.contactFormId,
                'value': 1.0
            });
        });

        // 5. Track FAQ Search Interactions
        var faqSearch = document.getElementById('faq-search-input');
        if (faqSearch) {
            var searchTimeout;
            faqSearch.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    var q = faqSearch.value.trim();
                    if (q.length >= 3) {
                        trackEvent('faq_search', {
                            'search_term': q,
                            'event_category': 'Knowledge Base'
                        });
                    }
                }, 800);
            });
        }
    });
    </script>
    <?php
}

/**
 * Register Admin Settings Menu for Google Services
 */
function snap_google_services_admin_menu() {
    add_options_page(
        __( 'Google Services Settings', 'snap-stitch-theme' ),
        __( 'Google Services', 'snap-stitch-theme' ),
        'manage_options',
        'snap-google-services',
        'snap_google_services_admin_page_html'
    );
}

/**
 * Register Settings in WordPress
 */
function snap_google_services_register_settings() {
    register_setting( 'snap_google_settings_group', 'snap_ga4_measurement_id', 'sanitize_text_field' );
    register_setting( 'snap_google_settings_group', 'snap_gsc_verification_code', 'sanitize_text_field' );
}

/**
 * Admin Settings Page HTML
 */
function snap_google_services_admin_page_html() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $current_ga4 = snap_get_ga4_measurement_id();
    $current_gsc = snap_get_gsc_verification_code();
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <p>Configure Google Search Console (Google Websearch) ownership verification and Google Analytics 4 (GA4) traffic tracking for Snap Marketing.</p>

        <form method="post" action="options.php">
            <?php
            settings_fields( 'snap_google_settings_group' );
            do_settings_sections( 'snap_google_settings_group' );
            ?>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label for="snap_gsc_verification_code">Google Search Console Verification Code</label>
                        </th>
                        <td>
                            <input name="snap_gsc_verification_code" type="text" id="snap_gsc_verification_code" value="<?php echo esc_attr( $current_gsc ); ?>" class="regular-text" placeholder="e.g. 4b8XYZ123abc..." />
                            <p class="description">
                                Paste your Google Search Console verification code or the full <code>&lt;meta name="google-site-verification" content="..."&gt;</code> tag.<br>
                                Obtain this from: <a href="https://search.google.com/search-console" target="_blank" rel="noopener">Google Search Console</a>.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="snap_ga4_measurement_id">Google Analytics 4 Measurement ID</label>
                        </th>
                        <td>
                            <input name="snap_ga4_measurement_id" type="text" id="snap_ga4_measurement_id" value="<?php echo esc_attr( $current_ga4 ); ?>" class="regular-text" placeholder="e.g. G-XXXXXXXXXX" />
                            <p class="description">
                                Enter your Google Analytics 4 (GA4) Measurement ID.<br>
                                Obtain this from: <a href="https://analytics.google.com" target="_blank" rel="noopener">Google Analytics (Admin > Data Streams > Web)</a>.
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>

            <?php submit_button( 'Save Google Settings' ); ?>
        </form>

        <hr style="margin-top: 30px;">
        <h2>Quick Verification Checklist</h2>
        <ol>
            <li><strong>XML Sitemap:</strong> Submit <code><?php echo esc_url( home_url( '/wp-sitemap.xml' ) ); ?></code> in Google Search Console under <em>Sitemaps</em>.</li>
            <li><strong>Conversion Events:</strong> Custom events for WhatsApp inquiries, phone calls, and quote requests are automatically tracked once your GA4 ID is saved.</li>
        </ol>
    </div>
    <?php
}
