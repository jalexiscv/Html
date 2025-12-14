<?php

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


$unassigned = view('App\Modules\Disa\Views\Mipg\Recommendations\Home\tabs\unassigned');
$assigned = view('App\Modules\Disa\Views\Mipg\Recommendations\Home\tabs\assigned');


$tabs = array(
    array("id" => "general", "text" => "Pendientes", "content" => $unassigned, "active" => true),
    array("id" => "interface", "text" => "Asignadas", "content" => $assigned, "active" => false),
);


/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
$tabcard = service("smarty");
$tabcard->set_Mode("bs5x");
$tabcard->assign("type", "normal");
$tabcard->assign("header", lang("Disa.recommendations-priority-list-title"));
$tabcard->assign("header_back", "/disa/");
$tabcard->assign("body", "");
$tabcard->assign("tabs", $tabs);
$tabcard->assign("footer", null);
$tabcard->assign("file", __FILE__);
echo($tabcard->view('components/tabs/card.tpl'));

?>