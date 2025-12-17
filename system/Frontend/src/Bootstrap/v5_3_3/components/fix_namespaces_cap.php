<?php
$dir = __DIR__;
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php' && $file->getFilename() !== 'fix_namespaces_cap.php') {
        $content = file_get_contents($file->getPathname());
        $pattern = '/namespace Higgs\\\\Frontend\\\\Bootstrap\\\\v5_3_3\\\\components\\\\/';
        $replacement = 'namespace Higgs\\Frontend\\Bootstrap\\v5_3_3\\Components\\';

        if (preg_match($pattern, $content)) {
            $newContent = preg_replace($pattern, $replacement, $content);
            file_put_contents($file->getPathname(), $newContent);
            echo "Updated: " . $file->getFilename() . "\n";
        }
    }
}
