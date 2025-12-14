<?php
/*
* ----------------------------------------------------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\Identifications\Creator\form.php]
*  ╩ ╩╝╚╝╚═╝╚═╝╩╚═╝╩═╝╚═╝
* ----------------------------------------------------------------------------------------------------------------------
* Copyright 2021 - Higgs Bigdata S.A.S., Inc. <admin@Higgs.com>
* Este archivo es parte de Higgs Bigdata Framework 7.1
* Para obtener información completa sobre derechos de autor y licencia, consulte
* la LICENCIA archivo que se distribuyó con este código fuente.
* ----------------------------------------------------------------------------------------------------------------------
* EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
* IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
* APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
* LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
* RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
* AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
* O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
* ----------------------------------------------------------------------------------------------------------------------
* @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
* @link https://www.Higgs.com
* @Version 1.5.0
* @since PHP 7, PHP 8
* ----------------------------------------------------------------------------------------------------------------------
* Datos recibidos desde el controlador - @ModuleController
* ----------------------------------------------------------------------------------------------------------------------
* @Authentication
* @request
* @dates
* @view
* @oid
* @component
* @views
* @prefix
* @parent
* ----------------------------------------------------------------------------------------------------------------------
*/
$mcountries = model('App\Modules\C4isr\Models\C4isr_Countries');

$f = service("forms", array("lang" => "Identifications."));
//[Requests]------------------------------------------------------------------------------------------------------------
$r["identification"] = $f->get_Value("identification", pk());
$r["profile"] = $f->get_Value("profile", $oid);
$r["country"] = $f->get_Value("country", "CO");
$r["type"] = $f->get_Value("type", "CC");
$r["number"] = $f->get_Value("number");
$r["author"] = $f->get_Value("author", $authentication->get_User());
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");
$back = "/c4isr/profiles/edit/{$oid}";
$types = array(
    array("value" => "CC", "label" => "Cédula de ciudadanía (Colombia)"),
    array("value" => "TI", "label" => "Tarjeta de identidad (Colombia)"),
    array("value" => "RC", "label" => "Registro Civil"),
    array("value" => "PAS", "label" => "Pasaporte"),
    array("value" => "CEX", "label" => "Cédula de extranjería (Colombia)"),
    array("value" => "NIT", "label" => "Número de Identificación Tributaria (Colombia)"),
    array("value" => "DNI", "label" => "Documento Nacional de Identidad (España, Argentina, Perú)"),
    array("value" => "RUT", "label" => "Rol Único Tributario (Chile)"),
    array("value" => "CURP", "label" => "Clave Única de Registro de Población (México)"),
    array("value" => "RFC", "label" => "Registro Federal de Contribuyentes (México)"),
    array("value" => "CPF", "label" => "Cadastro de Pessoas Físicas (Brasil)"),
    array("value" => "RG", "label" => "Registro Geral (Brasil)"),
    array("value" => "SSN", "label" => "Social Security Number (Estados Unidos)"),
    array("value" => "ITIN", "label" => "Individual Taxpayer Identification Number (Estados Unidos)"),
    array("value" => "PE", "label" => "Permiso especial de permanencia"),
    array("value" => "DE", "label" => "Documento extranjero"),
    array("value" => "SV", "label" => "Salvoconducto"),
    array("value" => "PT", "label" => "Permiso por protección temporal"),
);
$countries = $mcountries->get_SelectData();
//[Fields]--------------------------------------------------------------------------------------------------------------
$f->fields["identification"] = $f->get_FieldText("identification", array("value" => $r["identification"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["profile"] = $f->get_FieldText("profile", array("value" => $r["profile"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["country"] = $f->get_FieldSelect("country", array("selected" => $r["country"], "data" => $countries, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["type"] = $f->get_FieldSelect("type", array("selected" => $r["type"], "data" => $types, "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->fields["number"] = $f->get_FieldText("number", array("value" => $r["number"], "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[Groups]--------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["identification"] . $f->fields["profile"] . $f->fields["country"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["type"] . $f->fields["number"])));
//[Buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[Build]---------------------------------------------------------------------------------------------------------------
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("type", "normal");
$smarty->assign("header", lang("Identifications.create-title"));
$smarty->assign("header_back", $back);
$smarty->assign("body", $f);
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);
echo($smarty->view('components/cards/index.tpl'));
?>
