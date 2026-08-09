<?php
require_once('../../../wp-load.php');

$source = ABSPATH;
$dest = WP_CONTENT_DIR . '/core-backup';

if (!file_exists($dest)) {
    mkdir($dest, 0777, true);
}

// Delegate to the OS for instantaneous copy!
shell_exec("cp -r " . ABSPATH . "wp-admin " . $dest . "/");
shell_exec("cp -r " . ABSPATH . "wp-includes " . $dest . "/");
shell_exec("cp " . ABSPATH . "*.php " . $dest . "/");

echo "SUCCESS";
?>
