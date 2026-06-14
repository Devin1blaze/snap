<?php
define('WP_USE_THEMES', false);
require_once('../../../wp-load.php');
echo "Template Directory: " . get_template_directory() . "\n";
echo "Stylesheet Directory: " . get_stylesheet_directory() . "\n";
echo "Active Theme: " . get_option('template') . "\n";
?>