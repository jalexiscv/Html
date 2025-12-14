<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Views\Causes\Creator\form.php]
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
 ***/

use App\Libraries\Strings;

$strings = new Strings();

$mplans = model('App\Modules\Disa\Models\Disa_Plans', true);
$plan = $mplans->find($oid);

$f = service("forms", array("lang" => "Disa.causes-"));
/*
* -----------------------------------------------------------------------------
* [Requests]
* -----------------------------------------------------------------------------
*/
$r["cause"] = $f->get_Value("cause");
$r["plan"] = $f->get_Value("plan");
$r["score"] = $f->get_Value("score");
$r["description"] = $f->get_Value("description");
$r["author"] = $f->get_Value("author", $authentication->get_User());
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");
/*
* -----------------------------------------------------------------------------
* [Fields]
* -----------------------------------------------------------------------------
*/
$r["cause"] = $f->get_Value("cause", pk());
$r["plan"] = $f->get_Value("plan", $oid);
$r["description"] = $f->get_Value("description");
$r["author"] = $f->get_Value("author", $authentication->get_User());
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");
/** fields * */
$f->fields["cause"] = $f->get_FieldText("cause", array("value" => $r["cause"], "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12", "readonly" => true));
$f->fields["plan"] = $f->get_FieldText("plan", array("value" => $r["plan"], "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12", "readonly" => true));
$f->fields["description"] = $f->get_FieldTextArea("description", array("value" => urldecode($r["description"]), "proportion" => "col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => "/disa/mipg/plans/causes/list/{$oid}", "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
/** groups * */
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["cause"] . $f->fields["plan"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["description"])));
/** buttons * */
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
/** build * */

$plan = $mplans->find($oid);
$description = $strings->get_Striptags(urldecode($plan["description"]));


$sinfo = service("smarty");
$sinfo->set_Mode("bs5x");
$sinfo->caching = 0;
$sinfo->assign("title", "Causa a analizar");
$sinfo->assign("message", $description);
$info = ($sinfo->view('alerts/inline/info.tpl'));

//+[Logger]------------------------------------------------------------------------------------------------------------
history_logger(array(
    "module" => "DISA",
    "type" => "CREATE",
    "reference" => "COMPONENT",
    "object" => "CAUSES",
    "log" => "Accedió a <b>crear causa</b> del  <b>plan de acción</b> <b>{$plan['order']}</b>",
));


/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
$card = service("smarty");
$card->set_Mode("bs5x");
$card->assign("type", "normal");
$card->assign("header", lang("Disa.causes-create-title"));
$card->assign("header_back", "/disa/mipg/plans/view/{$oid}");
$card->assign("body", $info . $f);
$card->assign("footer", null);
$card->assign("file", __FILE__);
echo($card->view('components/cards/index.tpl'));
?>
