<?php
require_once('../../../wp-load.php');

$zip = new ZipArchive();
$filename = WP_CONTENT_DIR . "/full-wordpress-backup.zip";

// Ensure we don't time out
set_time_limit(0);
ini_set('memory_limit', '1024M');

if ($zip->open($filename, ZipArchive::CREATE | ZipArchive::OVERWRITE)!==TRUE) {
    exit("Cannot open <$filename>\n");
}

$dir = ABSPATH;
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($dir),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $name => $file) {
    if (!$file->isDir()) {
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($dir));
        
        if (strpos($relativePath, 'full-wordpress-backup.zip') !== false) {
            continue;
        }

        $zip->addFile($filePath, ltrim($relativePath, '/\\'));
    }
}
$zip->close();
echo "SUCCESS";
