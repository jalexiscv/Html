<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Views\Politics\Creator\form.php]
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
$f = service("forms", array("lang" => "Disa.institutionality-committee-upload-"));
/*
* -----------------------------------------------------------------------------
* [Requests]
* -----------------------------------------------------------------------------
*/
$r["attachment"] = $f->get_Value("attachment", pk());
$r["object"] = $f->get_Value("object", $oid);
$r["file"] = $f->get_Value("file");
$objects = array(
    array("value" => "", "label" => "Seleccione uno"),
    array("value" => "M01", "label" => "Acta de conformación del comité departamental distrital o municipal de gestión y desempeño"),
    array("value" => "M02", "label" => "Acta de conformación del comité institucional de gestión y desempeño"),
    array("value" => "M03", "label" => "Acta de conformación del comité departamental distrital o municipal de auditoria"),
    array("value" => "M04", "label" => "Acta de conformación del comité institucional de coordinación de control interno"),
    array("value" => "M05", "label" => "Acta de reunion ordinaria"),
    array("value" => "M06", "label" => "Acta de reunion extra ordinaria"),
);
/*
* -----------------------------------------------------------------------------
* [Fields]
* -----------------------------------------------------------------------------
*/
$f->fields["attachment"] = $f->get_FieldText("attachment", array("value" => $r["attachment"], "proportion" => "col-xxl-3 col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12", "readonly" => true));
$f->fields["object"] = $f->get_FieldSelect("object", array("value" => $r["object"], "data" => $objects, "proportion" => "col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));
$f->fields["file"] = $f->get_FieldFile("file", array("value" => $r["file"], "proportion" => "col-xxl-9 col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => "/disa/mipg/institutionality/home/" . lpk(), "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Upload"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
/*
* -----------------------------------------------------------------------------
* [Groups]
* -----------------------------------------------------------------------------
*/
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["object"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["attachment"] . $f->fields["file"])));
//$f->groups["g2"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["name"].$f->fields["description"])));
/*
* -----------------------------------------------------------------------------
* [Buttons]
* -----------------------------------------------------------------------------
*/
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
/** Build **/

$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("type", "uploader");
$smarty->assign("header", lang("Disa.institutionality-committee-upload-title"));
$smarty->assign("message", lang("Disa.institutionality-committee-upload-message"));
$smarty->assign("body", $f);
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);

echo($smarty->view('components/cards/index.tpl'));
?>