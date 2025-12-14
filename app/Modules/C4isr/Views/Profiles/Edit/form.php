<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\Profiles\Editor\form.php]
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
//[Services]------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[Models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\C4isr\Models\C4isr_Profiles");
$mcountries = model('App\Modules\C4isr\Models\C4isr_Countries');

//[Form]----------------------------------------------------------------------------------------------------------------
$f = service("forms", array("lang" => "Profiles."));
//[Values]--------------------------------------------------------------------------------------------------------------
$row = $model->find($oid);
$r["country"] = $f->get_Value("country", "CO");
$r["type"] = $f->get_Value("type", "CC");
$r["profile"] = $f->get_Value("profile", $row["profile"]);
$r["number"] = $f->get_Value("number", "");
$r["alias"] = $f->get_Value("alias", "");
$r["firstname"] = $f->get_Value("firstname", $row["firstname"]);
$r["lastname"] = $f->get_Value("lastname", $row["lastname"]);
$r["author"] = $f->get_Value("author", $authentication->get_User());
$r["created_at"] = $f->get_Value("created_at", $row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", $row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", $row["deleted_at"]);
$countries = $mcountries->get_SelectData();
$types = array(
    array("value" => "CC", "label" => "Cédula de ciudadanía (Colombia)"),
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
);
$back = "/c4isr/profiles/list/" . lpk();
$phones = view("App\Modules\C4isr\Views\Profiles\Edit\Views\phones");
$addresses = view("App\Modules\C4isr\Views\Profiles\Edit\Views\addresses");
$socials = view("App\Modules\C4isr\Views\Profiles\Edit\Views\socials");
$identifications = view("App\Modules\C4isr\Views\Profiles\Edit\Views\identifications");
$physicals = view("App\Modules\C4isr\Views\Profiles\Edit\Views\physicals");
$mails = view("App\Modules\C4isr\Views\Profiles\Edit\Views\mails");
$aliases = view("App\Modules\C4isr\Views\Profiles\Edit\Views\aliases");
$btnAddPhone = "<a href=\"/c4isr/phones/create/{$oid}\" class=\"card-toolbar-btn bg-secondary border-secondary float-right\"><i class=\"fa-solid fa-plus\"></i></a>";
$btnAddAddress = "<a href=\"/c4isr/addresses/create/{$oid}\" class=\"card-toolbar-btn bg-secondary border-secondary float-right\"><i class=\"fa-solid fa-plus\"></i></a>";
$btnAddSocial = "<a href=\"/c4isr/socials/create/{$oid}\" class=\"card-toolbar-btn bg-secondary border-secondary float-right\"><i class=\"fa-solid fa-plus\"></i></a>";
$btnAddIdentification = "<a href=\"/c4isr/identifications/create/{$oid}\" class=\"card-toolbar-btn bg-secondary border-secondary float-right\"><i class=\"fa-solid fa-plus\"></i></a>";
$btnAddPhysical = "<a href=\"/c4isr/physicals/create/{$oid}\" class=\"card-toolbar-btn bg-secondary border-secondary float-right\"><i class=\"fa-solid fa-plus\"></i></a>";
$btnAddMails = "<a href=\"/c4isr/mails/create/{$oid}\" class=\"card-toolbar-btn bg-secondary border-secondary float-right\"><i class=\"fa-solid fa-plus\"></i></a>";
$btnAddAliases = "<a href=\"/c4isr/aliases/create/{$oid}\" class=\"card-toolbar-btn bg-secondary border-secondary float-right\"><i class=\"fa-solid fa-plus\"></i></a>";
//[Fields]--------------------------------------------------------------------------------------------------------------
$f->fields["profile"] = $f->get_FieldText("profile", array("value" => $r["profile"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", 'readonly' => true));
$f->fields["alias"] = $f->get_FieldText("alias", array("value" => $r["alias"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["firstname"] = $f->get_FieldText("firstname", array("value" => $r["firstname"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["lastname"] = $f->get_FieldText("lastname", array("value" => $r["lastname"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));

$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[Groups]--------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["profile"] . $f->fields["alias"] . $f->fields["firstname"] . $f->fields["lastname"])));
$f->groups["g2"] = $f->get_Group(array("legend" => lang("App.Identifications") . $btnAddIdentification, "fields" => $identifications));
$f->groups["g3"] = $f->get_Group(array("legend" => lang("App.Phones") . $btnAddPhone, "fields" => $phones));
$f->groups["g4"] = $f->get_Group(array("legend" => lang("App.Addresses") . $btnAddAddress, "fields" => $addresses));
$f->groups["g5"] = $f->get_Group(array("legend" => lang("App.Socials-Networks") . $btnAddSocial, "fields" => $socials));
$f->groups["g6"] = $f->get_Group(array("legend" => lang("App.Physicals") . $btnAddPhysical, "fields" => $physicals));
$f->groups["g7"] = $f->get_Group(array("legend" => lang("App.Mails") . $btnAddMails, "fields" => $mails));
$f->groups["g8"] = $f->get_Group(array("legend" => lang("App.Aliases") . $btnAddAliases, "fields" => $aliases));
//[Buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[Build]---------------------------------------------------------------------------------------------------------------
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("type", "normal");
$smarty->assign("header", lang("Profiles.edit-title"));
$smarty->assign("header_back", $back);
$smarty->assign("body", $f);
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);
echo($smarty->view('components/cards/index.tpl'));
?>