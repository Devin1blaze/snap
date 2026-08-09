<?php
require_once('../../../wp-load.php');

$source = ABSPATH;
$dest = WP_CONTENT_DIR . '/core-backup';

if (!file_exists($dest)) {
    mkdir($dest, 0777, true);
}

// Function to copy directory recursively
function copy_dir($src, $dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            if (is_dir($src . '/' . $file)) {
                copy_dir($src . '/' . $file, $dst . '/' . $file);
            } else {
                copy($src . '/' . $file, $dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}

// Copy wp-admin
copy_dir($source . 'wp-admin', $dest . '/wp-admin');

// Copy wp-includes
copy_dir($source . 'wp-includes', $dest . '/wp-includes');

// Copy root php files
$files = glob($source . '*.php');
foreach($files as $file){
    $file_name = basename($file);
    copy($file, $dest . '/' . $file_name);
}

// Copy other important root files
$others = ['index.php', 'wp-config.php', '.htaccess'];
foreach($others as $file) {
    if(file_exists($source . $file)){
        copy($source . $file, $dest . '/' . $file);
    }
}

echo "SUCCESS";
?>
