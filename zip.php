<?php
$folderToZip = __DIR__ . '/backup'; // folder you want to zip
$zipFile = __DIR__ . '/backup.zip'; // output zip file

$zip = new ZipArchive();
if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
    
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($folderToZip, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($files as $file) {
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($folderToZip) + 1);

        if ($file->isDir()) {
            $zip->addEmptyDir($relativePath);
        } else {
            $zip->addFile($filePath, $relativePath);
        }
    }

    $zip->close();
    echo "✅ Folder zipped successfully: $zipFile";

} else {
    echo "❌ Failed to create zip file.";
}
?>
