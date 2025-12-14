<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\Intrusions\Editor\form.php]
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
//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[Models]-----------------------------------------------------------------------------
//$model = model("App\Modules\C4isr\Models\C4isr_Intrusions");
$mintrusions = model("App\Modules\C4isr\Models\C4isr_Intrusions");
$mprofiles = model("App\Modules\C4isr\Models\C4isr_Profiles");
$mvulnerabilities = model("App\Modules\C4isr\Models\C4isr_Vulnerabilities");
//[Form]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Intrusions."));
//[Values]-----------------------------------------------------------------------------
$row = $model->find($oid);
$vulnerability = $mvulnerabilities->find($row['vulnerability']);

if (isset($vulnerability['mail']) && !empty($vulnerability['mail'])) {
    $mmails = model("App\Modules\C4isr\Models\C4isr_Mails", false);
    $mmails->setTable('c4isr_mails_' . $vulnerability['partition']);
    $mail = $mmails->find($vulnerability['mail']);
    $reference = @$mail['email'];
} elseif (isset($vulnerability['alias']) && !empty($vulnerability['alias'])) {
    $maliases = model("App\Modules\C4isr\Models\C4isr_Aliases", false);
    $maliases->setTable('c4isr_aliases_' . $vulnerability['partition']);
    $alias = $maliases->find($vulnerability['alias']);
    $reference = @$alias['user'];
} else {
    $reference = '<i class=\"fa-sharp fa-solid fa-skull-crossbones\"></i>';
}
$password = @$vulnerability['password'];

$r["intrusion"] = $f->get_Value("intrusion", $row["intrusion"]);
$r["vulnerability"] = $f->get_Value("vulnerability", $row["vulnerability"]);
$r["breach"] = $f->get_Value("breach", $row["breach"]);
$r["author"] = $f->get_Value("author", $authentication->get_User());
$r["reference"] = $f->get_Value("reference", $strings->get_URLDecode($reference));
$r["password"] = $f->get_Value("password", $strings->get_URLDecode($password));
$r["created_at"] = $f->get_Value("created_at", $row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", $row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", $row["deleted_at"]);
$back = "/c4isr/intrusions/list/{$r["breach"]}";
//[Fields]-----------------------------------------------------------------------------
$f->fields["intrusion"] = $f->get_FieldText("intrusion", array("value" => $r["intrusion"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["vulnerability"] = $f->get_FieldText("vulnerability", array("value" => $r["vulnerability"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["breach"] = $f->get_FieldText("breach", array("value" => $r["breach"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->add_HiddenField("author", $r["author"]);

$f->fields["reference"] = $f->get_FieldText("reference", array("value" => $r["reference"], "proportion" => "col-6", "readonly" => true));
$f->fields["password"] = $f->get_FieldText("password", array("value" => $r["password"], "proportion" => "col-6"));

$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[Groups]-----------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["intrusion"] . $f->fields["vulnerability"] . $f->fields["breach"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["reference"] . $f->fields["password"])));
//[Buttons]-----------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[Build]-----------------------------------------------------------------------------

$smarty = service("smarty");
$smarty->set_Mode("bs5x");

$smarty->assign("type", "normal");
$smarty->assign("header", lang("Intrusions.edit-title"));
$smarty->assign("header_back", $back);

$smarty->assign("body", $f);
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);
echo($smarty->view('components/cards/index.tpl'));
?>