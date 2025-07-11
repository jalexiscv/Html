<?php

/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2023-12-01 23:19:27
 *  ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 *  ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 *  ** █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 *  ** █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 *  ** █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 *  ** █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 *  ** █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 *  ** █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 *  ** █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 *  ** █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 *  ** █ @link https://www.codehiggs.com
 *  ** █ @Version 1.5.0 @since PHP 7, PHP 8
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ Datos recibidos desde el controlador - @ModuleController
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */

class Library_Command_Factory
{
    private static $_object = array();

    # No explicit call of constructor
    private function __construct()
    {
    }

    # No explicit call of clone()
    private function __clone()
    {
    }

    /**
     * Accessor to command class instance by command type
     *
     * @param String $command Type of command
     *
     * @return void
     */
    public static function instance($command)
    {
        # Importing configuration
        $_ini = Library_Configuration_Loader::singleton();

        # Instance does not exists
        if (!isset(self::$_object[$_ini->get($command)]) || ($_ini->get($command) != 'Server')) {
            # Switching by API
            switch ($_ini->get($command)) {
                case 'Memcache':
                    # PECL Memcache API
                    require_once 'Memcache.php';
                    self::$_object['Memcache'] = new Library_Command_Memcache();
                    break;

                case 'Memcached':
                    # PECL Memcached API
                    require_once 'Memcached.php';
                    self::$_object['Memcached'] = new Library_Command_Memcached();
                    break;

                case 'Server':
                default:
                    # Server API (eg communicating directly with the memcache server)
                    require_once 'Server.php';
                    self::$_object['Server'] = new Library_Command_Server();
                    break;
            }
        }
        return self::$_object[$_ini->get($command)];
    }

    /**
     * Accessor to command class instance by type
     *
     * @param String $command Type of command
     *
     * @return void
     */
    public static function api($api)
    {
        # Instance does not exists
        if (!isset(self::$_object[$api]) || ($api != 'Server')) {
            # Switching by API
            switch ($api) {
                case 'Memcache':
                    # PECL Memcache API
                    require_once 'Memcache.php';
                    self::$_object['Memcache'] = new Library_Command_Memcache();
                    break;

                case 'Memcached':
                    # PECL Memcached API
                    require_once 'Memcached.php';
                    self::$_object['Memcached'] = new Library_Command_Memcached();
                    break;

                case 'Server':
                default:
                    # Server API (eg communicating directly with the memcache server)
                    require_once 'Server.php';
                    self::$_object['Server'] = new Library_Command_Server();
                    break;
            }
        }
        return self::$_object[$api];
    }
}