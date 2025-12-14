<?php
if (version_compare(PHP_VERSION, '5.4.0', '<')) {
    throw new Exception('The Facebook SDK requires PHP version 5.4 or higher.');
}
require_once __DIR__ . '/polyfills.php';
spl_autoload_register(function ($class) {
    $prefix = 'Facebook\\';
    $customBaseDir = '';
    if (defined('FACEBOOK_SDK_V4_SRC_DIR')) {
        $customBaseDir = FACEBOOK_SDK_V4_SRC_DIR;
    } elseif (defined('FACEBOOK_SDK_SRC_DIR')) {
        $customBaseDir = FACEBOOK_SDK_SRC_DIR;
    }
    $baseDir = $customBaseDir ?: __DIR__ . '/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relativeClass = substr($class, $len);
    $file = rtrim($baseDir, '/') . '/' . str_replace('\\', '/', $relativeClass) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});