<?php
declare(strict_types=1);

use Kint\Kint;
use Kint\Utils;

if (\defined('KINT_DIR')) {
    return;
}
if (\version_compare(PHP_VERSION, '7.1') < 0) {
    throw new Exception('Kint 5 requires PHP 7.1 or higher');
}
\define('KINT_DIR', __DIR__);
\define('KINT_WIN', DIRECTORY_SEPARATOR !== '/');
\define('KINT_PHP72', \version_compare(PHP_VERSION, '7.2') >= 0);
\define('KINT_PHP73', \version_compare(PHP_VERSION, '7.3') >= 0);
\define('KINT_PHP74', \version_compare(PHP_VERSION, '7.4') >= 0);
\define('KINT_PHP80', \version_compare(PHP_VERSION, '8.0') >= 0);
\define('KINT_PHP81', \version_compare(PHP_VERSION, '8.1') >= 0);
\define('KINT_PHP82', \version_compare(PHP_VERSION, '8.2') >= 0);
\define('KINT_PHP83', \version_compare(PHP_VERSION, '8.3') >= 0);
if (false !== \ini_get('xdebug.file_link_format')) {
    Kint::$file_link_format = \ini_get('xdebug.file_link_format');
}
if (isset($_SERVER['DOCUMENT_ROOT'])) {
    Kint::$app_root_dirs = [$_SERVER['DOCUMENT_ROOT'] => '<ROOT>',];
    if (false !== @\realpath($_SERVER['DOCUMENT_ROOT'])) {
        Kint::$app_root_dirs[\realpath($_SERVER['DOCUMENT_ROOT'])] = '<ROOT>';
    }
}
Utils::composerSkipFlags();
if ((!\defined('KINT_SKIP_FACADE') || !KINT_SKIP_FACADE) && !\class_exists('Kint')) {
    \class_alias(Kint::class, 'Kint');
}
if (!\defined('KINT_SKIP_HELPERS') || !KINT_SKIP_HELPERS) {
    require_once __DIR__ . '/init_helpers.php';
}