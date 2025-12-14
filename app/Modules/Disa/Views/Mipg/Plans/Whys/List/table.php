<?php

use App\Libraries\Strings;

/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Views\Whys\List\table.php]
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
* -----------------------------------------------------------------------------
* Datos recibidos desde el controlador - @ModuleController
* -----------------------------------------------------------------------------
* @Authentication
* @request
* @dates
* @view
* @oid
* @component
* @views
* @prefix
* @parent
* -----------------------------------------------------------------------------
*/

$strings = service("strings");

$mplans = model("App\Modules\Disa\Models\Disa_Plans");
$mcauses = model("App\Modules\Disa\Models\Disa_Causes");
$mwhys = model("App\Modules\Disa\Models\Disa_Whys");

$cause = $mcauses->find($oid);
$plan = $mplans->find($cause["plan"]);
$description = $strings->get_Striptags(urldecode($plan["description"]));

$warning = service("smarty");
$warning->set_Mode("bs5x");
$warning->caching = 0;
$warning->assign("title", "Causa a analizar");
$warning->assign("message", "{$description}");
$cw = ($warning->view('alerts/inline/warning.tpl'));

$wcause = service("smarty");
$wcause->set_Mode("bs5x");
$wcause->caching = 0;
$wcause->assign("title", "Mayor causa probable");
$wcause->assign("message", $strings->get_Striptags(urldecode($cause["description"])));
$wc = ($wcause->view('alerts/inline/warning.tpl'));

$info = service("smarty");
$info->set_Mode("bs5x");
$info->caching = 0;
$info->assign("title", "Nota");
$info->assign("message", " Al terminar de identificar los porqué diríjase a formular el plan de acción. Los porqué se trasladaran automáticamente. ");
$ci = ($warning->view('alerts/inline/info.tpl'));

$table = "<table class=\"table table-striped\">";
$table .= "<tr>";
$table .= "    <th class=\"text-center\">#</th>";
$table .= "    <th class=\"text-start\">Descripción</th>";
$table .= "    <th class=\"text-center\">Opciones</th>";
$table .= "</tr>";

$list = $mwhys->where("cause", $oid)->orderBy("why", "ASC")->findAll();

$count = 0;
foreach ($list as $item) {

    $options = "    <div class=\"btn-group\" role=\"group\">\n";
    $options .= "    <a class=\"btn btn-outline-secondary\" href=\"/disa/mipg/plans/whys/edit/{$item["why"]}\" target=\"_self\"><i class=\"icon far fa-edit\"></i> Editar</a>\n";
    $options .= "    <a class=\"btn btn-outline-secondary\" href=\"/disa/mipg/plans/whys/delete/{$item["why"]}\" target=\"_self\"><i class=\"far fa-trash\"></i> Eliminar</a>\n";
    $options .= "    </div>";

    $count++;
    $idescription = urldecode($item["description"]);
    $table .= "<tr>";
    $table .= "    <td class=\"text-center\">{$count}</td>";
    $table .= "    <td>{$idescription}</td>";
    $table .= "    <td class=\"text-center\">{$options}</td>";
    $table .= "</tr>";
}

$table .= "</table>";

$content = $cw . $wc . $table . $ci;


$menu = array(
    array("href" => "/disa/mipg/plans/whys/create/{$oid}", "text" => "<i class=\"fas fa-chevron-left\"></i> Crear"),
    array("href" => "#", "text" => "Ayuda")
);


history_logger(array(
    "module" => "DISA",
    "type" => "EDIT",
    "reference" => "COMPONENT",
    "object" => "PLAN",
    "log" => "Accedió a la <b>estrategia de los cinco porques</b> de la mayor causa probable para  <b>plan de acción</b> <b>{$plan['order']}</b>",
));


/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
$card = service('smarty');
$card->set_Mode('bs5x');
$card->assign('type', 'normal');
$card->assign('header', lang('Disa.whys-list-title'));
//$card->assign("header_menu", $menu);
$card->assign("header_add", "/disa/mipg/plans/whys/create/{$oid}");
$card->assign("header_back", "/disa/mipg/plans/causes/list/{$cause["plan"]}");
$card->assign('body', $content);
$card->assign('footer', null);
$card->assign('file', __FILE__);
echo($card->view('components/cards/index.tpl'));

?>