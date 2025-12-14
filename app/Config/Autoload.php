<?php


namespace Config;


use Higgs\Config\AutoloadConfig;


/**
 * -------------------------------------------------------------------
 * AUTO-LOADER
 * -------------------------------------------------------------------
 * This file defines the namespaces and class maps so the Autoloader
 * can find the files as needed.
 * NOTE: If you use an identical key in $psr4 or $classmap, then
 * the values in this file will overwrite the framework's values.
 */
class Autoload extends AutoloadConfig
{
    /**
     * -------------------------------------------------------------------
     * Namespaces
     * -------------------------------------------------------------------
     * Esto asigna las ubicaciones de cualquier espacio de nombres en su aplicación a
     * su ubicación en el sistema de archivos. Estos son utilizados por el autocargador
     * para localizar archivos la primera vez que se han instanciado.
     * Los directorios '/ app' y '/ system' ya están asignados para usted.
     * puede cambiar el nombre del espacio de nombres 'Aplicación' si lo desea,
     * pero esto debe hacerse antes de crear clases de espacios de nombres,
     * de lo contrario, deberá modificar todas esas clases para que esto funcione.
     *
     * Nota: Si no se asignan la autocarga de un modulo como namespaces este
     * no inicializa automaticamnete la carga de traducciones del lenguaje.
     *
     * Prototype:
     *
     *   $psr4 = [
     *       'Higgs' => SYSTEMPATH,
     *       'App'           => APPPATH
     *   ];
     *
     * @var array
     */

    public $psr4 = [
        APP_NAMESPACE => APPPATH, // For custom app namespace
        'Config' => APPPATH . 'Config',
        'App\Modules' => APPPATH . 'Modules'
    ];


    /**
     * -------------------------------------------------------------------
     * Class Map
     * -------------------------------------------------------------------
     * The class map provides a map of class names and their exact
     * location on the drive. Classes loaded in this manner will have
     * slightly faster performance because they will not have to be
     * searched for within one or more directories as they would if they
     * were being autoloaded through a namespace.
     *
     * Prototype:
     *   $classmap = [
     *       'MyClass'   => '/path/to/class/file.php'
     *   ];
     * @var array
     */
    public $classmap = [
        'Icons' => APPPATH . 'Libraries/Icons.php',
        'BBCode' => APPPATH . 'Libraries/BBCode.php',
        'Strings' => APPPATH . 'Libraries/Strings.php',
        'Exceptions' => APPPATH . 'Libraries/Exceptions.php',
        'Authentication' => APPPATH . 'Libraries/Authentication.php',
        'Numbers' => APPPATH . 'Libraries/Numbers.php',
        'Firewall' => APPPATH . 'Libraries/Firewall.php',
    ];

    public $helpers = ['filesystem'];


    public function safe_dump($mixed = null, $format = true)
    {
        ob_start();
        var_dump($mixed);
        $content = ob_get_clean();
        if ($format) {
            $content = "<pre>" . htmlspecialchars($content, ENT_QUOTES | ENT_SUBSTITUTE) . "</pre>";
        }
        return $content;
    }

    public function __construct()
    {
        parent::__construct();
        $dir = new \DirectoryIterator(APPPATH . 'Modules');
        foreach ($dir as $fileinfo) {
            if ($fileinfo->isDir() && !$fileinfo->isDot()) {
                if (!strpos($fileinfo->getFilename(), '_')) {
                    $this->psr4['App\Modules\\' . $fileinfo->getFilename()] = $fileinfo->getRealPath();
                }
            }
        }


    }

    public function get_URISegment($segment = 0)
    {
        $uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        $uri = explode('?', $uri, 2)[0];
        $segments = explode('/', trim($uri, '/'));
        return isset($segments[$segment]) ? $segments[$segment] : null;
    }



}
