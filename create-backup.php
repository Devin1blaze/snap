<?php
/**
 * Create a full database backup natively in PHP.
 */
// Load WordPress environment
require_once('../../../wp-load.php');

// Security check: Only allow logged-in administrators
if ( ! current_user_can('administrator') ) {
    die('You must be logged in as an administrator to run this script.');
}

global $wpdb;

// File path for the backup
$backup_dir = WP_CONTENT_DIR . '/backups';
if ( ! file_exists($backup_dir) ) {
    wp_mkdir_p($backup_dir);
}

$filename = 'database-backup-' . date('Y-m-d-H-i-s') . '.sql';
$filepath = $backup_dir . '/' . $filename;

$fp = fopen($filepath, 'w');
if (!$fp) {
    die('Could not create backup file. Please check folder permissions.');
}

// Add header
fwrite($fp, "-- WordPress Database Backup\n");
fwrite($fp, "-- Generated: " . date('Y-m-d H:i:s') . "\n\n");

// Get all tables
$tables = $wpdb->get_col("SHOW TABLES");

foreach ($tables as $table) {
    // Write table structure
    $create_table = $wpdb->get_row("SHOW CREATE TABLE {$table}", ARRAY_N);
    fwrite($fp, "DROP TABLE IF EXISTS {$table};\n");
    fwrite($fp, $create_table[1] . ";\n\n");

    // Write table data
    $rows = $wpdb->get_results("SELECT * FROM {$table}", ARRAY_N);
    
    if ( !empty($rows) ) {
        foreach ($rows as $row) {
            $row_data = array_map(function($val) use ($wpdb) {
                if ($val === null) return 'NULL';
                return "'" . $wpdb->_real_escape($val) . "'";
            }, $row);
            
            fwrite($fp, "INSERT INTO {$table} VALUES(" . implode(', ', $row_data) . ");\n");
        }
        fwrite($fp, "\n\n");
    }
}

fclose($fp);

echo "<h1>Backup Successful!</h1>";
echo "<p>Your database has been backed up safely to:</p>";
echo "<code>" . esc_html($filepath) . "</code>";
echo "<p>Please ensure you keep this file safe. You can now safely run the deletion script.</p>";
