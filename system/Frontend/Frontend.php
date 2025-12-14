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

namespace Higgs\Frontend;

use Higgs\Frontend\BuilderInterface;

/**
 * Class Frontend.
 *   La existencia de esta clase implica:
 *   1). La modificación el archivo system/Common.php: Este archivo contiene funciones de ayuda globales. Se agrego una
 *       función helper para la clase Html: if (!function_exists('html')){function html(){return new \Higgs\Html\Html();}}
 *   2). La modificación de system/bootstrap.php: para la clase se cargue automáticamente al iniciar el sistema, se agrego
 *       esta línea al final del archivo: require_once SYSTEM_PATH . 'Html/Html.php';
 *
 */
class Frontend
{

    /**
     * @var string
     */
    protected $framework;

    /**
     * @var string
     */
    protected $version;


    /**
     * Frontend constructor.
     * @param $framework
     * @param $version
     */

    protected $builder;

    public function __construct($frontend = 'bootstrap', $version = '5.3.3')
    {
        $sp = SYSTEMPATH;
        $ds = DIRECTORY_SEPARATOR;
        $frontend = ucfirst($frontend);
        $version = str_replace('.', '_', $version);
        $builderClass = "\\Higgs\\Frontend\\Bootstrap\\Builder_5_3_3";
        $this->builder = new $builderClass();
    }

    /**
     * Este metodo retorna el buider por defecto a
     */
    public function get_Builder()
    {
        return $this->builder;
    }

}

?>