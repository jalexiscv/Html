<?php

use Config\Autoload;
use Config\Modules;
use Config\Paths;
use Config\Services;

if (!defined('APPPATH')) {
    define('APPPATH', realpath(rtrim($paths->appDirectory, '\\/ ')) . DIRECTORY_SEPARATOR);
}
if (!defined('ROOTPATH')) {
    define('ROOTPATH', realpath(APPPATH . '../') . DIRECTORY_SEPARATOR);
}
if (!defined('SYSTEMPATH')) {
    define('SYSTEMPATH', realpath(rtrim($paths->systemDirectory, '\\/ ')) . DIRECTORY_SEPARATOR);
}
if (!defined('WRITEPATH')) {
    define('WRITEPATH', realpath(rtrim($paths->writableDirectory, '\\/ ')) . DIRECTORY_SEPARATOR);
}

if (!defined('PUBLICPATH')) {
    define('PUBLICPATH', realpath(APPPATH . '../public_html/') . DIRECTORY_SEPARATOR);
}


if (!defined('TESTPATH')) {
    define('TESTPATH', realpath(rtrim($paths->testsDirectory, '\\/ ')) . DIRECTORY_SEPARATOR);
}
if (!defined('APP_NAMESPACE')) {
    require_once APPPATH . 'Config/Constants.php';
}
if (is_file(APPPATH . 'Common.php')) {
    require_once APPPATH . 'Common.php';
}
require_once SYSTEMPATH . 'Common.php';


if (!class_exists(Autoload::class, false)) {
    require_once SYSTEMPATH . 'Config/AutoloadConfig.php';
    require_once APPPATH . 'Config/Autoload.php';
    require_once SYSTEMPATH . 'Modules/Modules.php';
    require_once APPPATH . 'Config/Modules.php';
}
require_once SYSTEMPATH . 'Autoloader/Autoloader.php';
require_once SYSTEMPATH . 'Config/BaseService.php';
require_once SYSTEMPATH . 'Config/Services.php';
require_once APPPATH . 'Config/Services.php';
Services::autoloader()->initialize(new Autoload(), new Modules())->register();
Services::autoloader()->loadHelpers();
if (is_file(COMPOSER_PATH)) {
    if (!defined('VENDORPATH')) {
        define('VENDORPATH', dirname(COMPOSER_PATH) . DIRECTORY_SEPARATOR);
    }
    require_once COMPOSER_PATH;
}
/** Complements **/
require_once SYSTEMPATH . 'Html/Html.php';
require_once SYSTEMPATH . 'Frontend/Frontend.php';
