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

use Higgs\Config\BaseConfig;
use Higgs\Debug\Toolbar\Collectors\Events;
use Higgs\Debug\Toolbar\Collectors\Files;
use Higgs\Debug\Toolbar\Collectors\Logs;
use Higgs\Debug\Toolbar\Collectors\Routes;
use Higgs\Debug\Toolbar\Collectors\Timers;
use Higgs\Debug\Toolbar\Collectors\Views;

class Toolbar extends BaseConfig
{
    /*
    |--------------------------------------------------------------------------
    | Debug Toolbar
    |--------------------------------------------------------------------------
    | The Debug Toolbar provides a way to see information about the performance
    | and state of your application during that page display. By default it will
    | NOT be displayed under production environments, and will only display if
    | CI_DEBUG is true, since if it's not, there's not much to display anyway.
    |
    | toolbarMaxHistory = Number of history files, 0 for none or -1 for unlimited
    |
    */
    public $collectors = [
        Timers::class,
        \Higgs\Debug\Toolbar\Collectors\Database::class,
        Logs::class,
        //Views::class,
        \Higgs\Debug\Toolbar\Collectors\Caches::class,
        Files::class,
        Routes::class,
        Events::class,
    ];

    /*
    |--------------------------------------------------------------------------
    | Max History
    |--------------------------------------------------------------------------
    | The Toolbar allows you to view recent requests that have been made to
    | the application while the toolbar is active. This allows you to quickly
    | view and compare multiple requests.
    |
    | $maxHistory sets a limit on the number of past requests that are stored,
    | helping to conserve file space used to store them. You can set it to
    | 0 (zero) to not have any history stored, or -1 for unlimited history.
    |
    */
    public $maxHistory = 20;

    /*
    |--------------------------------------------------------------------------
    | Toolbar Views Path
    |--------------------------------------------------------------------------
    | The full path to the the views that are used by the toolbar.
    | MUST have a trailing slash.
    |
    */
    public $viewsPath = SYSTEMPATH . 'Debug/Toolbar/Views/';

    /*
    |--------------------------------------------------------------------------
    | Max Queries
    |--------------------------------------------------------------------------
    | If the Database Collector is enabled, it will log every query that the
    | the system generates so they can be displayed on the toolbar's timeline
    | and in the query log. This can lead to memory issues in some instances
    | with hundreds of queries.
    |
    | $maxQueries defines the maximum amount of queries that will be stored.
    |
    */
    public $maxQueries = 100;
}
