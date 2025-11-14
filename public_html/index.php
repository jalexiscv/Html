<?php
// Option 1: Set time limit in seconds (0 means no limit)
use App\Controllers\Firewall;

set_time_limit(0);
ini_set('max_execution_time', '300'); // 5 minutes

$ip = $_SERVER['REMOTE_ADDR'];
$host = $_SERVER['SERVER_NAME'];
$allowedIPs = ['127.0.0.1', '::1'];
$allowedHosts = ['localhost', 'miotrolocalhost'];

//[firewall]------------------------------------------------------------------------------------------------------------
//include "../firewall/intercept.php";

//[/firewall]------------------------------------------------------------------------------------------------------------

if (!in_array($ip, $allowedIPs) && !in_array($host, $allowedHosts)) {
    //echo "No estás en localhost ni en un host permitido.";
    //include "waf/config.php";
    //include "waf/project-security.php";
}


// Check PHP version.
$minPhpVersion = '7.4'; // If you update this, don't forget to update `spark`.
if (version_compare(PHP_VERSION, $minPhpVersion, '<')) {
    $message = sprintf(
        'Your PHP version must be %s or higher to run Higgs. Current version: %s',
        $minPhpVersion,
        PHP_VERSION
    );
    exit($message);
}

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Ensure the current directory is pointing to the front controller's directory
chdir(FCPATH);

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 * This process sets up the path constants, loads and registers
 * our autoloader, along with Composer's, loads our constants
 * and fires up an environment-specific bootstrapping.
 */
$useKint = true;
// Load our paths config file
// This is the line that might need to be changed, depending on your folder structure.

//if (isset($_REQUEST['firewall'])) {
//    require FCPATH . '../firewall/Config/Paths.php';
//} else {
require FCPATH . '../app/Config/Paths.php';
//}

// ^^^ Change this line if you move your application folder
$paths = new Config\Paths();
// Location of the framework bootstrap file.
require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';

// Load environment settings from .env files into $_SERVER and $_ENV
require_once SYSTEMPATH . 'Config/DotEnv.php';
(new Higgs\Config\DotEnv(ROOTPATH))->load();

$app = Config\Services::Higgs();
$app->initialize();
$context = is_cli() ? 'php-cli' : 'web';
$app->setContext($context);

$controller = new Firewall();
if ($controller->intercept()) {
    header("Location: /e403.php", true, 403);
    exit();
}
$app->run();
?>