<?php

namespace Config;

use Higgs\Database\Config;


/**
 * Database Configuration
 * @package Config
 */
class Database extends Config
{
    public $queryLog = true;
    /**
     * The directory that holds the Migrations
     * and Seeds directories.
     *
     * @var string
     */
    public $filesPath = APPPATH . 'Database/';

    /**
     * Lets you choose which connection group to
     * use if no other is specified.
     *
     * @var string
     */
    public $defaultGroup = 'default';

    /**
     * The default database connection.
     *
     * @var array
     */
    public $default = [
        'DSN' => '',
        'hostname' => '127.0.0.1',
        'username' => 'jalexiscv',
        'password' => '94478998x',
        'database' => 'higgs-root',
        'DBDriver' => 'MySQLi',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug' => true,
        'cacheOn' => false,
        'cacheDir' => '',
        'charset' => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre' => '',
        'encrypt' => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port' => 3306,
    ];
    public $shema = [
        'DSN' => '',
        'hostname' => '127.0.0.1',
        'username' => 'jalexiscv',
        'password' => '94478998x',
        'database' => 'information_schema',
        'DBDriver' => 'MySQLi',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug' => (ENVIRONMENT !== 'production'),
        'queryLog' => true,
        'cacheOn' => false,
        'cacheDir' => '',
        'charset' => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre' => '',
        'encrypt' => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port' => 3306,
    ];

    public $authentication = [
        'DSN' => '',
        'hostname' => '127.0.0.1',
        'username' => 'jalexiscv',
        'password' => '94478998x',
        'database' => '',
        'DBDriver' => 'MySQLi',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug' => (ENVIRONMENT !== 'production'),
        'queryLog' => true,
        'cacheOn' => false,
        'cacheDir' => '',
        'charset' => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre' => '',
        'encrypt' => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port' => 3306,
        'save_queries' => true
    ];

    /**
     * This database connection is used when
     * running PHPUnit database tests.
     *
     * @var array
     */
    public $tests = [
        'DSN' => '',
        'hostname' => '127.0.0.1',
        'username' => 'jalexiscv',
        'password' => '94478998x',
        'database' => ':memory:',
        'DBDriver' => 'SQLite3',
        'DBPrefix' => 'db_', // Needed to ensure we're working correctly with prefixes live. DO NOT REMOVE FOR CI DEVS
        'pConnect' => false,
        'DBDebug' => (ENVIRONMENT !== 'production'),
        'queryLog' => true,
        'cacheOn' => false,
        'cacheDir' => '',
        'charset' => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre' => '',
        'encrypt' => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port' => 3306,
    ];


    public $stats = [
        'DSN' => '',
        'hostname' => '127.0.0.1',
        'username' => 'jalexiscv',
        'password' => '94478998x',
        'database' => 'higgs-stats',
        'DBDriver' => 'MySQLi',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug' => (ENVIRONMENT !== 'production'),
        'queryLog' => true,
        'cacheOn' => false,
        'cacheDir' => '',
        'charset' => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre' => '',
        'encrypt' => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port' => 3306,
    ];

    //------------------------------------------------------------------------------------------------------------------
    public function __construct()
    {
        parent::__construct();

        // Obtener el dominio actual
        $currentDomain = $_SERVER['HTTP_HOST'] ?? '';
        $mysql = "31.97.135.67";
        if (!($currentDomain== 'localhost') && !($currentDomain== '127.0.0.1')) {
            $this->default["hostname"] = $mysql;
            $this->authentication["hostname"] = $mysql;
            $this->stats["hostname"] = $mysql;
        }
        // Intentar obtener la configuración desde la caché
        $cache = \Config\Services::cache();
        $cacheKey = 'db_config_' . md5($currentDomain);
        $clientConfig = $cache->get($cacheKey);

        if (!$clientConfig) {
            // Si no está en caché, consultar la base de datos
            try {
                // Configurar la conexión por defecto para acceder a la tabla application_clients
                $defaultDB = db_connect($this->default);

                if ($defaultDB) {
                    // Buscar la configuración para el dominio actual
                    $query = $defaultDB->query("SELECT * FROM application_clients WHERE domain = ?", [$currentDomain]);
                    $clientConfig = $query->getRow();

                    if ($clientConfig) {
                        // Guardar en caché por 1 hora (3600 segundos)
                        $cache->save($cacheKey, $clientConfig, 60);
                    } else {
                        // Si no se encuentra configuración para este dominio, registrar error
                        log_message('error', "No se encontró configuración de base de datos para el dominio: {$currentDomain}");

                        // Opcionalmente, puedes guardar un valor nulo en caché para evitar consultas repetidas
                        // para dominios que no existen (con un tiempo de caché más corto)
                        $cache->save($cacheKey, null, 300); // 5 minutos
                    }
                } else {
                    log_message('error', "No se pudo conectar a la base de datos principal");
                }
            } catch (\Exception $e) {
                log_message('error', "Error al consultar la configuración de base de datos: " . $e->getMessage());
            }
        }

        // Si tenemos una configuración válida (de caché o de consulta), configurar el grupo 'authentication'
        if ($clientConfig) {
            $this->authentication['hostname'] = $clientConfig->db_host;
            $this->authentication['username'] = $clientConfig->db_user;
            $this->authentication['password'] = $clientConfig->db_password;
            $this->authentication['database'] = $clientConfig->db;
            $this->authentication['port'] = $clientConfig->db_port;
        } else {
            echo("No hay configuración de base de datos disponible para el dominio: {$currentDomain}");
        }
        //echo("<pre>");
        //echo("Dominio actual: {$currentDomain}\n");
        //print_r($this->authentication);
        //echo("</pre>");
    }


    public function sincacheconstruct()
    {
        parent::__construct();
        $currentDomain = $_SERVER['HTTP_HOST'] ?? '';
        $mysql = "31.97.135.67";
        if (!($currentDomain== 'localhost') && !($currentDomain== '127.0.0.1')) {
            $this->default["hostname"] = $mysql;
            $this->authentication["hostname"] = $mysql;
            $this->shema["hostname"] = $mysql;
            $this->stats["hostname"] = $mysql;
        }

        $defaultDB = db_connect($this->default);
        if ($defaultDB) {
            // Buscar la configuración para el dominio actual
            $query = $defaultDB->query("SELECT * FROM application_clients WHERE domain = ?", [$currentDomain]);
            $clientConfig = $query->getRow();
            if ($clientConfig) {
                // Configurar el grupo 'authentication' con los datos del cliente
                $this->authentication['hostname'] = $clientConfig->db_host;
                $this->authentication['username'] = $clientConfig->db_user;
                $this->authentication['password'] = $clientConfig->db_password;
                $this->authentication['database'] = $clientConfig->db;
                $this->authentication['port'] = $clientConfig->db_port;
            } else {
                log_message('error', "No se encontró configuración de base de datos para el dominio: {$currentDomain}");
            }
        } else {
            log_message('error', "No se pudo conectar a la base de datos principal");
        }
        //echo("<pre>");
        //print_r($currentDomain);
        //print_r($this->default);
        //print_r($this->authentication);
        //echo("</pre>");
    }


    public function xconstruct()
    {
        parent::__construct();
        $server = str_replace("www", "", strtolower($_SERVER['HTTP_HOST']));
        $dbn = preg_replace('/[^A-Za-z0-9\-]/', '', $server);
        $this->authentication["database"] = "anssible_{$dbn}";

        $mysql = "31.97.135.67";
        if (!($_SERVER['HTTP_HOST'] == 'localhost') && !($_SERVER['HTTP_HOST'] == '127.0.0.1')) {
            $this->default["hostname"] = $mysql;
            $this->authentication["hostname"] = $mysql;
            $this->shema["hostname"] = $mysql;
            $this->stats["hostname"] = $mysql;
        }
        // Ensure that we always set the database group to 'tests' if
        // we are currently running an automated test suite, so that
        // we don't overwrite live data on accident.
        if (ENVIRONMENT === 'testing') {
            $this->defaultGroup = 'tests';
            // Under Travis-CI, we can set an ENV var named 'DB_GROUP'
            // so that we can test against multiple databases.
            if ($group = getenv('DB')) {
                if (is_file(TESTPATH . 'travis/Database.php')) {
                    require TESTPATH . 'travis/Database.php';

                    if (!empty($dbconfig) && array_key_exists($group, $dbconfig)) {
                        $this->tests = $dbconfig[$group];
                    }
                }
            }
        }
    }

    //--------------------------------------------------------------------
}

?>