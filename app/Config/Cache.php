<?php

namespace Config;

use Higgs\Cache\Handlers\DummyHandler;
use Higgs\Cache\Handlers\FileHandler;
use Higgs\Cache\Handlers\MemcachedHandler;
use Higgs\Cache\Handlers\PredisHandler;
use Higgs\Cache\Handlers\RedisHandler;
use Higgs\Cache\Handlers\WincacheHandler;
use Higgs\Config\BaseConfig;

/**
 * Clase Cache
 * Esta clase se utiliza para configurar la caché de la aplicación. Permite especificar el manejador de caché principal
 * y de respaldo, el directorio de almacenamiento de caché, si se debe tener en cuenta la cadena de consulta de la URL
 * al generar archivos de caché, y varias otras configuraciones relacionadas con la caché.
 * @package Config
 */
class Cache extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Primary Handler
     * --------------------------------------------------------------------------
     *
     * The name of the preferred handler that should be used. If for some reason
     * it is not available, the $backupHandler will be used in its place.
     */
    public string $handler = 'file';
    /**
     * -----------------------------------------------------------------------------------------------------------------
     * Manejador de Respaldo
     * -----------------------------------------------------------------------------------------------------------------
     * El nombre del manejador que se utilizará en caso de que el primero no esté
     * disponible. A menudo, se usa 'file' aquí ya que el sistema de archivos siempre está
     * disponible, aunque eso no siempre es práctico para la aplicación.
     */
    public string $backupHandler = 'dummy';
    /**
     * --------------------------------------------------------------------------
     * Cache Directory Path
     * --------------------------------------------------------------------------
     * The path to where cache files should be stored, if using a file-based
     * system.
     * @deprecated Use the driver-specific variant under $file
     */
    public string $storePath = WRITEPATH . 'cache/';

    /**
     * -----------------------------------------------------------------------------------------------------------------
     * Incluir Cadena de Consulta en Caché
     * -----------------------------------------------------------------------------------------------------------------
     * Si se debe tener en cuenta la cadena de consulta de la URL al generar
     * archivos de caché de salida. Las opciones válidas son:
     *    false      = Deshabilitado
     *    true       = Habilitado, tener en cuenta todos los parámetros de consulta.
     *                 Tenga en cuenta que esto puede resultar en numerosos archivos de caché
     *                 generados para la misma página una y otra vez.
     *    array('q') = Habilitado, pero solo tener en cuenta la lista especificada
     *                 de parámetros de consulta.
     * @var bool|string[]
     */
    public $cacheQueryString = false;

    /**
     * -----------------------------------------------------------------------------------------------------------------
     * Prefijo de clave
     * -----------------------------------------------------------------------------------------------------------------
     * Esta cadena se agrega a todos los nombres de elementos de caché para ayudar a evitar colisiones
     * si ejecuta varias aplicaciones con el mismo motor de caché.
     */
    public string $prefix = APPNODE;
    /**
     * -----------------------------------------------------------------------------------------------------------------
     * TTL predeterminado
     * -----------------------------------------------------------------------------------------------------------------
     * El número predeterminado de segundos para guardar elementos cuando no se especifica ninguno.
     * ADVERTENCIA: Esto no es utilizado por los manejadores del marco donde 60 segundos es
     * codificado en duro, pero puede ser útil para proyectos y módulos. Esto reemplazará
     * el valor codificado en duro en una futura versión.
     */
    public int $ttl = 18000;
    /**
     * --------------------------------------------------------------------------
     * Caracteres Reservados
     * --------------------------------------------------------------------------
     * Una cadena de caracteres reservados que no se permitirán en claves o etiquetas.
     * Las cadenas que violen esta restricción harán que los manejadores lancen una excepción.
     * Predeterminado: {}()/\@:
     * Nota: El conjunto predeterminado es necesario para la conformidad con PSR-6.
     */
    public string $reservedCharacters = '{}()/\@:';

    /**
     * --------------------------------------------------------------------------
     * File settings
     * --------------------------------------------------------------------------
     * Your file storage preferences can be specified below, if you are using
     * the File driver.
     * @var array<string, int|string|null>
     */
    public array $file = [
        'storePath' => WRITEPATH . 'cache/',
        'mode' => 0640,
    ];

    /**
     * -------------------------------------------------------------------------
     * Memcached settings
     * -------------------------------------------------------------------------
     * Your Memcached servers can be specified below, if you are using
     * the Memcached drivers.
     * @see https://Higgs.com/user_guide/libraries/caching.html#memcached
     * @var array<string, bool|int|string>
     */
    public array $memcached = [
        'host' => '127.0.0.1',
        'port' => 11211,
        'weight' => 1,
        'raw' => false,
    ];

    /**
     * -------------------------------------------------------------------------
     * Redis settings
     * -------------------------------------------------------------------------
     * Your Redis server can be specified below, if you are using
     * the Redis or Predis drivers.
     * @var array<string, int|string|null>
     */
    public array $redis = [
        'host' => '127.0.0.1',
        'password' => null,
        'port' => 6379,
        'timeout' => 0,
        'database' => 0,
    ];

    /**
     * --------------------------------------------------------------------------
     * Available Cache Handlers
     * --------------------------------------------------------------------------
     *
     * This is an array of cache engine alias' and class names. Only engines
     * that are listed here are allowed to be used.
     * @var array<string, string>
     */
    public array $validHandlers = [
        'dummy' => DummyHandler::class,
        'file' => FileHandler::class,
        'memcached' => MemcachedHandler::class,
        'predis' => PredisHandler::class,
        'redis' => RedisHandler::class,
        'wincache' => WincacheHandler::class,
    ];
}
