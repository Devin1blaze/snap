<?php
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "OPcache reset successful.";
} else {
    echo "OPcache is not enabled or function not found.";
}
if (function_exists('apcu_clear_cache')) {
    apcu_clear_cache();
    echo " APCu cache cleared.";
}
?>