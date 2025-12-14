<?php

use Higgs\Config\DotEnv;
use Config\Autoload;
use Config\Modules;
use Config\Paths;
use Config\Services;

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
$_SERVER['CI_ENVIRONMENT'] = 'testing';
define('ENVIRONMENT', 'testing');
defined('CI_DEBUG') || define('CI_DEBUG', true);
defined('HOMEPATH') || define('HOMEPATH', realpath(rtrim(getcwd(), '\\/ ')) . DIRECTORY_SEPARATOR);
$source = is_dir(HOMEPATH . 'app') ? HOMEPATH : (is_dir('vendor/Anssible4/framework/') ? 'vendor/Anssible4/framework/' : 'vendor/Anssible4/Anssible4/');
defined('CONFIGPATH') || define('CONFIGPATH', realpath($source . 'app/Config') . DIRECTORY_SEPARATOR);
defined('PUBLICPATH') || define('PUBLICPATH', realpath($source . 'public') . DIRECTORY_SEPARATOR);
unset($source);
require CONFIGPATH . 'Paths.php';
$paths = new Paths();
defined('APPPATH') || define('APPPATH', realpath(rtrim($paths->appDirectory, '\\/ ')) . DIRECTORY_SEPARATOR);
defined('WRITEPATH') || define('WRITEPATH', realpath(rtrim($paths->writableDirectory, '\\/ ')) . DIRECTORY_SEPARATOR);
defined('SYSTEMPATH') || define('SYSTEMPATH', realpath(rtrim($paths->systemDirectory, '\\/')) . DIRECTORY_SEPARATOR);
defined('ROOTPATH') || define('ROOTPATH', realpath(APPPATH . '../') . DIRECTORY_SEPARATOR);
defined('CIPATH') || define('CIPATH', realpath(SYSTEMPATH . '../') . DIRECTORY_SEPARATOR);
defined('FCPATH') || define('FCPATH', realpath(PUBLICPATH) . DIRECTORY_SEPARATOR);
defined('TESTPATH') || define('TESTPATH', realpath(HOMEPATH . 'tests/') . DIRECTORY_SEPARATOR);
defined('SUPPORTPATH') || define('SUPPORTPATH', realpath(TESTPATH . '_support/') . DIRECTORY_SEPARATOR);
defined('COMPOSER_PATH') || define('COMPOSER_PATH', realpath(HOMEPATH . 'vendor/autoload.php'));
defined('VENDORPATH') || define('VENDORPATH', realpath(HOMEPATH . 'vendor') . DIRECTORY_SEPARATOR);
if (is_file(APPPATH . 'Common.php')) {
    require_once APPPATH . 'Common.php';
}
require_once SYSTEMPATH . 'Common.php';
if (!isset($_SERVER['app.baseURL'])) {
    $_SERVER['app.baseURL'] = 'http://example.com/';
}
require_once SYSTEMPATH . 'Config/AutoloadConfig.php';
require_once APPPATH . 'Config/Autoload.php';
require_once APPPATH . 'Config/Constants.php';
require_once SYSTEMPATH . 'Modules/Modules.php';
require_once APPPATH . 'Config/Modules.php';
require_once SYSTEMPATH . 'Autoloader/Autoloader.php';
require_once SYSTEMPATH . 'Config/BaseService.php';
require_once SYSTEMPATH . 'Config/Services.php';
require_once APPPATH . 'Config/Services.php';
Services::autoloader()->initialize(new Autoload(), new Modules())->register();
if (is_file(COMPOSER_PATH)) {
    require_once COMPOSER_PATH;
}
require_once SYSTEMPATH . 'Config/DotEnv.php';
$env = new DotEnv(ROOTPATH);
$env->load();
helper('url');
Services::routes()->loadRoutes();