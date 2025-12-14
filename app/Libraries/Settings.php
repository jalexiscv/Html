<?php
/*
 * Copyright (c) 2023. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace App\Libraries;

use Higgs\Settings\Config\Settings as SettingsConfig;
use Higgs\Settings\Handlers\BaseHandler;
use InvalidArgumentException;
use RuntimeException;

/**
 * Allows developers a single location to store and
 * retrieve settings that were original set in config files
 * in the core application or any third-party module.
 *
 * $siteName = service('settings')->get('App.siteName');
 * service('settings')->set('App.siteName', 'My Great Site');
 * service('settings')->forget('App.siteName');
 */
class Settings
{
    protected $cache_time;
    private $config;

    private $context;

    /**
     * @var SettingsConfig
     */
    public function __construct(bool $context = false)
    {
        $this->context = $context;
        $this->cache_time = 30 * 24 * 60 * 60; // 30 días * 24 horas * 60 minutos * 60 segundos
    }

    /**
     * Método forget
     * Este método elimina un valor en caché asociado a un ID proporcionado. Si no existe en caché,
     * no realiza ninguna acción. Para eliminar el valor en caché, se genera la clave de caché utilizando
     * el ID proporcionado y se llama al método 'delete()' del objeto 'cache()' con la clave de caché.
     * @param string $id El identificador único que se utilizará para crear la clave de caché.
     * @return void
     * @author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
     * @version 1.0.0
     */
    public function forget(string $id): void
    {
        $cacheKey = $this->get_CacheKey($id);
        cache()->delete($cacheKey);
    }

    /**
     * Método get_CacheKey
     * Este método genera una clave de caché única utilizando el ID proporcionado, el nombre de la clase y la
     * constante APPNODE.
     * Mejoras:
     * - Se agregó la declaración de tipo `string` para el parámetro `$id`.
     * - Se agregó la declaración de tipo de retorno `string`.
     * - Se utilizó la función `sprintf()` para mejorar la legibilidad al componer la cadena.
     * @param string $id El identificador único que se utilizará para crear la clave de caché.
     * @return string Retorna la clave de caché generada como una cadena de texto.
     * @author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
     * @version 1.0.0
     */
    protected function get_CacheKey(string $id): string
    {
        $authentication = service('authentication');
        $context = ($this->context) ? $authentication->get_User() : "global";
        $cacheKeyTemplate = '%s_%s_%s_%s';
        $sanitizedClassName = str_replace('\\', '_', get_class($this));
        return md5(sprintf($cacheKeyTemplate, APPNODE, $context, $sanitizedClassName, $id));
    }

    /**
     * Método set
     * Este método almacena un valor en caché asociado a un ID proporcionado si no existe previamente en caché.
     * Retorna el valor almacenado en caché.
     * Mejoras:
     *  - Se ha agregado la declaración de tipo string para el parámetro $id, lo que indica explícitamente que el método acepta sólo identificadores en formato de cadena de texto.
     *  - Se ha agregado la declaración de tipo mixed para el parámetro $value, lo que indica que el método acepta cualquier tipo de valor.
     *  - Se ha agregado la declaración de tipo de retorno mixed, lo que indica que el método retorna cualquier tipo de valor.
     *  - Se ha modificado la condición para comprobar si $cachedData es igual a false, lo que indica que el valor no se encuentra en caché. Esta verificación es más estricta que la verificación original !$data.
     * Estas mejoras proporcionan una mayor claridad en el uso del método y permiten que el código sea más fácil de leer y mantener.
     * @param string $id El identificador único que se utilizará para crear la clave de caché.
     * @param mixed $value El valor que se almacenará en caché.
     * @return mixed Retorna el valor almacenado en caché.
     * @author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
     * @version 1.0.0
     */
    public function set(string $id, mixed $value): mixed
    {
        $cacheKey = $this->get_CacheKey($id);
        $cachedData = cache($cacheKey);
        if ($cachedData === false) {
            $cachedData = $value;
            cache()->save($cacheKey, $cachedData, $this->cache_time);
        }
        return ($cachedData);
    }

    /**
     * Método get
     * Este método recupera un valor en caché asociado a un ID proporcionado. Si no existe en caché,
     * retorna null.
     * @param string $id El identificador único que se utilizará para crear la clave de caché.
     * @return mixed|false Retorna el valor almacenado en caché si existe, de lo contrario retorna null.
     * @author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
     * @version 1.0.0
     */
    public function get(string $id): mixed
    {
        $cacheKey = $this->get_CacheKey($id);
        $cachedData = cache($cacheKey);
        if ($cachedData === false) {
            return (false);
        }
        return ($cachedData);
    }
}

?>