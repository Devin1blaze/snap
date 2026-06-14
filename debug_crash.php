<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    require_once('../../../wp-load.php');
    echo "WP Loaded.\n";

    $url = 'http://localhost/product-category/commercial-refrigeration/';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        echo "cURL Error: $error\n";
    } else {
        echo "Response length: " . strlen($response) . "\n";
        echo "Response preview: " . substr($response, 0, 1500) . "\n";
    }

} catch (Exception $e) {
    echo "Exception: " . $e->getMessage();
}
?>