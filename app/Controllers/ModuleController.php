<?php

namespace App\Controllers;

use Higgs\Controller;
use Higgs\HTTP\RequestInterface;
use Higgs\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\Authentication;
use App\Libraries\Dates;
use App\Libraries\Strings;

class ModuleController extends Controller
{
    protected $request;
    protected Authentication $authentication;
    protected $bootstrap;
    protected Dates $dates;
    protected Strings $strings;
    protected string $module;
    protected string $view;
    protected string $views;
    protected string $viewer;
    protected string $component;
    protected $oid;
    protected string $option;
    protected array $libraries;
    protected array $models;
    protected string $prefix;
    protected array $data;
    protected $helpers = [];
    protected $server;
    protected $parent;


    /**
     * Constructor de la clase ModuleController.
     *
     * Este método inicializa varios servicios y helpers necesarios para el funcionamiento del controlador.
     * Utiliza la función `service` para obtener instancias compartidas de los servicios.
     * También carga varios helpers para facilitar diversas operaciones dentro del controlador.
     *
     * Servicios inicializados:
     * - `authentication`: Servicio de autenticación.
     * - `bootstrap`: Servicio de bootstrap.
     * - `dates`: Servicio de manejo de fechas.
     * - `strings`: Servicio de manejo de cadenas.
     * - `request`: Servicio de manejo de solicitudes HTTP.
     * - `server`: Servicio de manejo del servidor.
     *
     * Helpers cargados:
     * - `filesystem`: Helper para operaciones de sistema de archivos.
     * - `security`: Helper para operaciones de seguridad.
     * - `form`: Helper para manejo de formularios.
     * - `App\Helpers\Application`: Helper específico de la aplicación.
     */
    public function __construct()
    {
        $this->authentication = service('authentication');
        $this->bootstrap = service('bootstrap');
        $this->dates = service('Dates');
        $this->strings = service('strings');
        $this->request = service('request');
        $this->server = service('server');
        $this->parent = $this;
        helper("filesystem");
        helper('security');
        helper("form");
        helper('App\Helpers\Application');
    }

    /**
     * Devuelve un array asociativo con las propiedades del controlador.
     *
     * Este método utiliza la función `get_object_vars` para obtener todas las propiedades
     * del objeto actual (controlador) y las devuelve como un array asociativo.
     * Las claves del array son los nombres de las propiedades y los valores son los valores de las propiedades.
     *
     * @return array Un array asociativo que contiene las propiedades del controlador.
     */
    public function get_Array(): array
    {
        return get_object_vars($this);
    }
}