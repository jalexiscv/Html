<?php

namespace Config;

/*
 * -----------------------------------------------------------------------------
 *  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
 *  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK]
 *  ╩ ╩╝╚╝╚═╝╚═╝╩╚═╝╩═╝╚═╝
 * -----------------------------------------------------------------------------
 * Copyright 2021 - Higgs Bigdata S.A.S., Inc. <admin@Higgs.com>
 * Este archivo es parte de Higgs Bigdata Framework 7.1
 * Para obtener información completa sobre derechos de autor y licencia, consulte
 * la LICENCIA archivo que se distribuyó con este código fuente.
 * -----------------------------------------------------------------------------
 * EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 * RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 * AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 * O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 * -----------------------------------------------------------------------------
 * @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * @link https://www.Higgs.com
 * @Version 1.5.0
 * @since PHP 7, PHP 8
 */

use App\Libraries\Authentication;
use App\Libraries\BBCode;
use App\Libraries\Bootstrap;
use App\Libraries\Dates;
use App\Libraries\Forms;
use App\Libraries\Icons;
use App\Libraries\Maps;
use App\Libraries\Numbers;
use App\Libraries\Platform;
use App\Libraries\Ratchet;
use App\Libraries\Server;
use App\Libraries\Moodle;
use App\Libraries\Smarty;
use App\Libraries\Settings;
use App\Libraries\Strings;
use Higgs\Config\Services as CoreServices;

/**
 * Archivo de configuración de servicios.
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * Los servicios son simplemente otras clases / bibliotecas que usa el sistema
 * para hacer su trabajo. Esto es utilizado por Higgs para permitir que el núcleo del
 * marco que se puede cambiar fácilmente sin afectar el uso dentro el resto de su solicitud.
 * Todas las clases principales dentro de Higgs se proporcionan como "servicios".
 * Esto simplemente significa que, en lugar de codificar un nombre de clase para cargar,
 * las clases para llamar se definen dentro de este archivo de configuración lo cual
 * es muy simple. Este archivo actúa como un tipo de fábrica para crear nuevas instancias
 * de la clase requerida.
 *
 * Este archivo contiene cualquier servicio específico de la aplicación o anulaciones de servicio
 * que pueda necesitar. Se ha incluido un ejemplo con el general
 * formato de método que debe utilizar para sus métodos de servicio. Para más ejemplos,
 * Consulte el archivo de servicios principal en system / Config / Services.php.
 * */
class Services extends CoreServices
{


    //    public static function example($getShared = true)
    //    {
    //        if ($getShared)
    //        {
    //            return static::getSharedInstance('example');
    //        }
    //
    //        return new \Higgs\Example();
    //    }
    public static function forms($attributes = array())
    {
        return new Forms($attributes);
    }

    public static function icons($attributes = array())
    {
        return new Icons();
    }

    public static function dates($getShared = true)
    {
        if ($getShared) {
            return self::getSharedInstance('dates');
        }
        return (new Dates());
    }

    public static function numbers($getShared = true)
    {
        if ($getShared) {
            return self::getSharedInstance('numbers');
        }
        return (new Numbers());
    }

    public static function strings($getShared = true)
    {
        if ($getShared) {
            return self::getSharedInstance('strings');
        }
        return (new Strings());
    }


    public static function settings($context = false, $getShared = true)
    {
        if ($getShared) {
            return self::getSharedInstance('settings');
        }
        return (new Settings($context));
    }


    public static function server($getShared = true)
    {
        if ($getShared) {
            return self::getSharedInstance('server');
        }
        return (new Server());
    }


    public static function moodle($getShared = true)
    {
        if ($getShared) {
            return self::getSharedInstance('moodle');
        }
        return (new Moodle());
    }

    public static function authentication($getShared = true)
    {
        if ($getShared) {
            return self::getSharedInstance('authentication');
        }
        return (new Authentication());
    }


    public static function platform($getShared = true)
    {
        if ($getShared) {
            return self::getSharedInstance('platform');
        }
        return (new Platform());
    }


    public static function bootstrap($getShared = true)
    {
        if ($getShared) {
            return self::getSharedInstance('bootstrap');
        }
        return (new Bootstrap());
    }

    public static function maps($getShared = true)
    {
        if ($getShared) {
            return self::getSharedInstance('maps');
        }
        return (new Maps());
    }

    public static function bbcode()
    {
        return (new BBCode());
    }


    /**
     * Este servicio permite crear las interfaces gráficas utilizando smarty
     * @param bool $getShared
     * @return Smarty|mixed
     */
    public static function smarty($getShared = true)
    {
        if ($getShared) {
            return self::getSharedInstance('smarty');
        }
        return new Smarty();
    }


}
