<?php
/**
 * █ -------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                                                    2023-11-26 00:29:34
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules}\Intelligence\Controllers\Intelligence.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                                                                         consulte la LICENCIA archivo que se distribuyó con este código fuente.
 * █ -------------------------------------------------------------------------------------------------------------------
 * █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 * █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 * █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 * █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 * █ -------------------------------------------------------------------------------------------------------------------
 * █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * █ @link https://www.codehiggs.com
 * █ @Version 2.0.0 @since PHP 7, PHP 8
 * █ -------------------------------------------------------------------------------------------------------------------
 * █ Datos recibidos desde el controlador - @ModuleController
 * █ -------------------------------------------------------------------------------------------------------------------
 * █ Ninguno
 * █ -------------------------------------------------------------------------------------------------------------------
 **/

namespace App\Modules\Intelligence\Controllers;

use App\Controllers\ModuleController;
use App\Libraries\Intelligence;

class Debug extends ModuleController
{


    public function __construct()
    {
        parent::__construct();
        $this->module = 'App\Modules\Intelligence';
        helper($this->module . '\Helpers\Intelligence');
        $this->prefix = 'intelligence';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        $this->component = $this->views . '\Home';
    }

    public function index()
    {
        $url = base_url('intelligence/home/index.html');
        return (redirect()->to($url));
    }

    public function home(string $rnd = "index")
    {
        $mias = model('App\Modules\Intelligence\Models\Intelligence_Ias');
        $mmessages = model('App\Modules\Intelligence\Models\Intelligence_Messages');
        $ia = $mias->get_IaByUser(safe_get_user());
        $i = new Intelligence($ia);
        $i->setHistory($mmessages->getMessages(safe_get_user()));
        $history = $i->getHistory();
        echo("<pre>");
        print_r($history);
        echo("</pre>");
        //$i->deleteMessages();
    }

    public function instructions(string $rnd = "index")
    {
        $mias = model('App\Modules\Intelligence\Models\Intelligence_Ias');
        $mmessages = model('App\Modules\Intelligence\Models\Intelligence_Messages');
        $ia = $mias->get_IaByUser(safe_get_user());
        $i = new Intelligence($ia);
        $i->setHistory($mmessages->getMessages(safe_get_user()));
        $instructions = $i->get_SysInstruction();
        echo("<pre>");
        print_r($instructions);
        echo("</pre>");
        //$i->deleteMessages();
    }


}

?>
