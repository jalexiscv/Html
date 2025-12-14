<?php

namespace Config;

use Higgs\Config\BaseConfig;
use Higgs\Session\Handlers\BaseHandler;
use Higgs\Session\Handlers\FileHandler;

/**
 * Clase Session
 *
 * Esta clase extiende de BaseConfig y se utiliza para configurar los parámetros de la sesión
 * en el proyecto. Permite definir el controlador de sesión, el nombre de la cookie de sesión,
 * la duración de la sesión, la ruta de guardado, entre otros.
 */
class Session extends BaseConfig
{
    /**
     * Controlador de sesión.
     *
     * Define el controlador de almacenamiento de sesión a utilizar. Puede ser cualquiera de los siguientes:
     * - `Higgs\Session\Handlers\FileHandler` para almacenamiento en archivos.
     * - `Higgs\Session\Handlers\DatabaseHandler` para almacenamiento en base de datos.
     * - `Higgs\Session\Handlers\MemcachedHandler` para uso de Memcached.
     * - `Higgs\Session\Handlers\RedisHandler` para uso de Redis.
     *
     * @phpstan-var class-string<BaseHandler>
     */
    public string $driver = FileHandler::class;

    /**
     * Nombre de la cookie de sesión.
     *
     * Define el nombre de la cookie que se utilizará para la sesión. Solo puede contener caracteres [0-9a-z_-].
     */
    public string $cookieName = 'higgs_session';

    /**
     * Expiración de la sesión.
     *
     * Define el número de SEGUNDOS que la sesión deberá durar. Un valor de 0 significa que expirará
     * cuando el navegador se cierre.
     */
    public int $expiration = 315360000;

    /**
     * Ruta de guardado de la sesión.
     *
     * Define la ubicación para guardar los datos de la sesión, dependiendo del controlador utilizado.
     * Para el controlador 'files', debe ser una ruta a un directorio escribible. Solo se admiten rutas absolutas.
     */
    public string $savePath = WRITEPATH . 'session';

    /**
     * Coincidencia de IP en la sesión.
     *
     * Define si se debe hacer coincidir la dirección IP del usuario al leer los datos de la sesión.
     * Importante: Si se utiliza el controlador de base de datos, recuerda actualizar la clave primaria
     * de tu tabla de sesión al cambiar esta configuración.
     */
    public bool $matchIP = false;

    /**
     * Tiempo para actualizar la sesión.
     *
     * Define cada cuántos segundos CodeIgniter regenerará el ID de la sesión.
     */
    public int $timeToUpdate = 300;

    /**
     * Regenerar y destruir datos de sesión antiguos.
     *
     * Define si se deben destruir los datos de sesión asociados con el antiguo ID de sesión
     * cuando se regenere automáticamente el ID de la sesión. Si se establece en FALSE, los datos
     * serán eliminados posteriormente por el recolector de basura.
     */
    public bool $regenerateDestroy = false;

    /**
     * Grupo de base de datos para la sesión.
     *
     * Define el grupo de base de datos para la sesión cuando se utiliza el controlador de base de datos.
     */
    public ?string $DBGroup = null;
}

?>