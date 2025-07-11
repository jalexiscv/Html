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

class Library_Data_Version
{
    # Version file
    protected static $_file = 'latest';

    # Google Code latest version data file
    protected static $_latest = 'http://phpmemcacheadmin.googlecode.com/files/latest';

    # Time between HTTP check
    protected static $_time = 1296000; # 15 days

    /**
     * Check for the latest version, from local cache or via http
     * Return true if a newer version is available, false otherwise
     *
     * @return Boolean
     */
    public static function check()
    {
        # Loading ini file
        $_ini = Library_Configuration_Loader::singleton();

        # Version definition file path
        $path = rtrim($_ini->get('file_path'), '/') . DIRECTORY_SEPARATOR . self::$_file;

        # Checking if file was modified for less than 15 days ago
        if ((is_array($stats = @stat($path))) && (isset($stats['mtime'])) && ($stats['mtime'] > (time() - self::$_time))) {
            # Opening file and checking for latest version
            return (version_compare(CURRENT_VERSION, file_get_contents($path)) == -1);
        } else {
            # Getting last version from Google Code
            if ($latest = @file_get_contents(self::$_latest)) {
                # Saving latest version in file
                file_put_contents($path, $latest);

                # Checking for latest version
                return (version_compare(CURRENT_VERSION, $latest) == -1);
            } else {
                # To avoid error spam
                file_put_contents($path, 'Net unreachable');
                return true;
            }
        }
    }
}