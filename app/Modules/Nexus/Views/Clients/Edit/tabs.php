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


$fgeneral = view('App\Modules\Nexus\Views\Clients\Edit\tabs\general');
$finterface = view('App\Modules\Nexus\Views\Clients\Edit\tabs\interface');
$fmodules = view('App\Modules\Nexus\Views\Clients\Edit\tabs\modules');
$foauths = view('App\Modules\Nexus\Views\Clients\Edit\tabs\oauths');
$fimages = view('App\Modules\Nexus\Views\Clients\Edit\tabs\images');
$fdb = view('App\Modules\Nexus\Views\Clients\Edit\tabs\db');

$tabs = array(
    array("id" => "general", "text" => "General", "content" => $fgeneral, "active" => true),
    array("id" => "interface", "text" => lang("App.Interface"), "content" => $finterface, "active" => false),
    array("id" => "modules", "text" => lang("App.Modules"), "content" => $fmodules, "active" => false),
    array("id" => "oauths", "text" => lang("Oauths.Oauths"), "content" => $foauths, "active" => false),
    array("id" => "images", "text" => lang("App.Images"), "content" => $fimages, "active" => false),
    array("id" => "db", "text" => lang("App.Database"), "content" => $fdb, "active" => false),
);

$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("tabs", $tabs);
echo($smarty->view('components/tabs/index.tpl'));

?>