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

class Library_HTML_Components
{
    /**
     * Dump server list in an HTML select
     *
     * @return String
     */
    public static function serverSelect($name, $selected = '', $class = '', $events = '')
    {
        # Loading ini file
        $_ini = Library_Configuration_Loader::singleton();

        # Select Name
        $serverList = '<select id="' . $name . '" ';

        # CSS Class
        $serverList .= ($class != '') ? 'class="' . $class . '"' : '';

        # Javascript Events
        $serverList .= ' ' . $events . '>';

        foreach ($_ini->get('servers') as $cluster => $servers) {
            # Cluster
            $serverList .= '<option value="' . $cluster . '" ';
            $serverList .= ($selected == $cluster) ? 'selected="selected"' : '';
            $serverList .= '>' . $cluster . ' cluster</option>';

            # Cluster server
            foreach ($servers as $name => $servers) {
                $serverList .= '<option value="' . $name . '" ';
                $serverList .= ($selected == $name) ? 'selected="selected"' : '';
                $serverList .= '>&nbsp;&nbsp;-&nbsp;' . ((strlen($name) > 38) ? substr($name, 0, 38) . ' [...]' : $name) . '</option>';
            }
        }
        return $serverList . '</select>';
    }

    /**
     * Dump cluster list in an HTML select
     *
     * @return String
     */
    public static function clusterSelect($name, $selected = '', $class = '', $events = '')
    {
        # Loading ini file
        $_ini = Library_Configuration_Loader::singleton();

        # Select Name
        $clusterList = '<select id="' . $name . '" ';

        # CSS Class
        $clusterList .= ($class != '') ? 'class="' . $class . '"' : '';

        # Javascript Events
        $clusterList .= ' ' . $events . '>';

        foreach ($_ini->get('servers') as $cluster => $servers) {
            # Option value and selected case
            $clusterList .= '<option value="' . $cluster . '" ';
            $clusterList .= ($selected == $cluster) ? 'selected="selected"' : '';
            $clusterList .= '>' . $cluster . ' cluster</option>';
        }
        return $clusterList . '</select>';
    }

    /**
     * Dump server response in proper formatting
     *
     * @param String $hostname Hostname
     * @param String $port Port
     * @param Mixed $data Data (reponse)
     *
     * @return String
     */
    public static function serverResponse($hostname, $port, $data)
    {
        $header = '<span class="red">Server ' . $hostname . ':' . $port . "</span>\r\n";
        $return = '';
        if (is_array($data)) {
            foreach ($data as $string) {
                $return .= $string . "\r\n";
            }
            return $header . htmlentities($return, ENT_NOQUOTES | 0, "UTF-8") . "\r\n";
        }
        return $header . $return . $data . "\r\n";
    }

    /**
     * Dump api list un HTML select with select name
     *
     * @param String $iniAPI API Name from ini file
     * @param String $id Select ID
     *
     * @return String
     */
    public static function apiList($iniAPI, $id)
    {
        return '<select id="' . $id . '" name="' . $id . '">
                <option value="Server" ' . self::selected('Server', $iniAPI) . '>Server API</option>
                <option value="Memcache" ' . self::selected('Memcache', $iniAPI) . '>Memcache API</option>
                <option value="Memcached" ' . self::selected('Memcached', $iniAPI) . '>Memcached API</option>
                </select>';
    }

    /**
     * Used to see if an option is selected
     *
     * @param String $actual Actual value
     * @param String $selected Selected value
     *
     * @return String
     */
    private static function selected($actual, $selected)
    {
        if ($actual == $selected) {
            return 'selected="selected"';
        }
    }
}