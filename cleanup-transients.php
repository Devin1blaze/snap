<?php
/**
 * Cleanup Transients and Orphaned Metadata
 * 
 * Run this script by visiting its URL in the browser.
 * Make sure to delete it after running!
 */

// Try to find wp-load.php relative to the theme directory
$wp_load_path = dirname(__FILE__) . '/../../../wp-load.php';

if ( file_exists( $wp_load_path ) ) {
    require_once( $wp_load_path );
} else {
    // Fallback if the path is different
    $wp_load_path = $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php';
    if ( file_exists( $wp_load_path ) ) {
        require_once( $wp_load_path );
    } else {
        die( 'Could not find wp-load.php. Please ensure this script is placed correctly or update the path.' );
    }
}

global $wpdb;

echo "<h1>Database Cleanup Process</h1>";

// Flush WordPress Object Cache if available
if ( function_exists( 'wp_cache_flush' ) ) {
    wp_cache_flush();
    echo "<p><strong>Object Cache:</strong> Flushed successfully.</p>";
}

// 1. Delete all transients from wp_options
$sql_transients = "DELETE FROM {$wpdb->options} WHERE option_name LIKE '\_transient\_%' OR option_name LIKE '\_site\_transient\_%'";
$deleted_transients = $wpdb->query( $sql_transients );
echo "<p><strong>Transients:</strong> Deleted {$deleted_transients} transient records from wp_options.</p>";

// 2. Delete WooCommerce specific sessions and transients (just in case)
$sql_wc_sessions = "DELETE FROM {$wpdb->options} WHERE option_name LIKE '\_wc\_session\_%' OR option_name LIKE '\_wc\_session\_expires\_%'";
$deleted_sessions = $wpdb->query( $sql_wc_sessions );
echo "<p><strong>WooCommerce Sessions:</strong> Deleted {$deleted_sessions} session records.</p>";

// 3. Clean up orphaned postmeta
$sql_postmeta = "DELETE pm FROM {$wpdb->postmeta} pm LEFT JOIN {$wpdb->posts} wp ON wp.ID = pm.post_id WHERE wp.ID IS NULL";
$deleted_postmeta = $wpdb->query( $sql_postmeta );
echo "<p><strong>Orphaned Postmeta:</strong> Deleted {$deleted_postmeta} orphaned post meta records.</p>";

// 4. Clean up orphaned term relationships
$sql_term_rel = "DELETE tr FROM {$wpdb->term_relationships} tr LEFT JOIN {$wpdb->posts} wp ON wp.ID = tr.object_id WHERE wp.ID IS NULL";
$deleted_term_rel = $wpdb->query( $sql_term_rel );
echo "<p><strong>Orphaned Term Relationships:</strong> Deleted {$deleted_term_rel} orphaned term relationships.</p>";

// 5. Clean up orphaned term meta
$sql_termmeta = "DELETE tm FROM {$wpdb->termmeta} tm LEFT JOIN {$wpdb->terms} t ON t.term_id = tm.term_id WHERE t.term_id IS NULL";
$deleted_termmeta = $wpdb->query( $sql_termmeta );
echo "<p><strong>Orphaned Term Meta:</strong> Deleted {$deleted_termmeta} orphaned term meta records.</p>";

echo "<h2>Cleanup Complete!</h2>";
echo "<p style='color: red;'><strong>IMPORTANT:</strong> Please delete this script from your server after use to prevent unauthorized access.</p>";
