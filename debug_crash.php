<?php
if ( ! defined( 'ABSPATH' ) || ! function_exists( 'current_user_can' ) || ! current_user_can( 'manage_options' ) ) {
    if ( function_exists( 'wp_die' ) ) {
        wp_die( 'Unauthorized.' );
    } else {
        die( 'Unauthorized.' );
    }
}
die('Security audit: Script removed.');
