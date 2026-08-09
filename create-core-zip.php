<?php
require_once('../../../wp-load.php');

$zip = new ZipArchive();
$filename = WP_CONTENT_DIR . "/core-wordpress-backup.zip";

if ($zip->open($filename, ZipArchive::CREATE | ZipArchive::OVERWRITE)!==TRUE) {
    exit("Cannot open <$filename>\n");
}

$dir = ABSPATH;

// Only zip these directories and root files
$allowed_dirs = ['wp-admin', 'wp-includes'];

$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($dir),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $name => $file) {
    if (!$file->isDir()) {
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($dir));
        $relativePath = ltrim($relativePath, '/\\');
        
        $parts = explode(DIRECTORY_SEPARATOR, str_replace('/', DIRECTORY_SEPARATOR, $relativePath));
        $top_level = $parts[0];

        // Include root files or allowed dirs
        if (count($parts) === 1 || in_array($top_level, $allowed_dirs)) {
             $zip->addFile($filePath, $relativePath);
        }
    }
}
$zip->close();
echo "SUCCESS";
?>
