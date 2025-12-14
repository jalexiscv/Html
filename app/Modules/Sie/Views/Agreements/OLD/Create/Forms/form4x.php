<?php

/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2023-12-01 23:19:27
 *  ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 *  ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 *  ** █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 *  ** █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 *  ** █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 *  ** █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 *  ** █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 *  ** █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 *  ** █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 *  ** █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 *  ** █ @link https://www.codehiggs.com
 *  ** █ @Version 1.5.0 @since PHP 7, PHP 8
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ Datos recibidos desde el controlador - @ModuleController
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */
//[services]------------------------------------------------------------------------------------------------------------
$b = service("bootstrap");
$f = service("forms", array("lang" => "Sie_Registrations."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Sie\Models\Sie_Registrations");
$mprogams = model("App\Modules\Sie\Models\Sie_Programs");

//[vars]----------------------------------------------------------------------------------------------------------------
$r["period"] = $f->get_Value("period");
$r["journey"] = $f->get_Value("journey");
$r["program"] = $f->get_Value("program");

$r["registration"] = $f->get_Value("registration", pk());
$r["identify"] = $f->get_Value("identify");
$r["graduation_certificate"] = $f->get_Value("graduation_certificate");
$r["military_id"] = $f->get_Value("military_id");
$r["diploma"] = $f->get_Value("diploma");
$r["icfes_certificate"] = $f->get_Value("icfes_certificate");
$r["utility_bill"] = $f->get_Value("utility_bill");
$r["sisben_certificate"] = $f->get_Value("sisben_certificate");
$r["address_certificate"] = $f->get_Value("address_certificate");
$r["electoral_certificate"] = $f->get_Value("electoral_certificate");
$r["photo_card"] = $f->get_Value("photo_card");


$back = (($oid == "fullscreen") ? "/sie/registrations/cancel/fullscreen" : "/sie/agreements/list/" . lpk());

$programs = array(
    array("value" => "", "label" => "Seleccione un programa"),
);
$programs = array_merge($programs, $mprogams->get_SelectData());
/**
 * graduation_certificate
 * military_id
 * diploma
 * icfes_certificate
 * utility_bill
 * sisben_certificate
 * address_certificate
 * electoral_certificate
 * photo_card
 **/
//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("step", "4");
$f->add_HiddenField("registration", $r["registration"]);
$f->fields["identify"] = $f->get_FieldFile("identify", array("value" => $r["identify"], "proportion" => "col-12"));
$f->fields["graduation_certificate"] = $f->get_FieldFile("graduation_certificate", array("value" => $r["graduation_certificate"], "proportion" => "col-12"));
$f->fields["military_id"] = $f->get_FieldFile("military_id", array("value" => $r["military_id"], "proportion" => "col-12"));
$f->fields["diploma"] = $f->get_FieldFile("diploma", array("value" => $r["diploma"], "proportion" => "col-12"));
$f->fields["icfes_certificate"] = $f->get_FieldFile("icfes_certificate", array("value" => $r["icfes_certificate"], "proportion" => "col-12"));
$f->fields["utility_bill"] = $f->get_FieldFile("utility_bill", array("value" => $r["utility_bill"], "proportion" => "col-12"));
$f->fields["sisben_certificate"] = $f->get_FieldFile("sisben_certificate", array("value" => $r["sisben_certificate"], "proportion" => "col-12"));
$f->fields["address_certificate"] = $f->get_FieldFile("address_certificate", array("value" => $r["address_certificate"], "proportion" => "col-12"));
$f->fields["electoral_certificate"] = $f->get_FieldFile("electoral_certificate", array("value" => $r["electoral_certificate"], "proportion" => "col-12"));
$f->fields["photo_card"] = $f->get_FieldFile("photo_card", array("value" => $r["photo_card"], "proportion" => "col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Continue"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g00"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["identify"])));
$f->groups["g01"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["graduation_certificate"])));
//$f->groups["g02"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["military_id"])));
$f->groups["g03"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["diploma"])));
$f->groups["g04"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["icfes_certificate"])));
$f->groups["g05"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["utility_bill"])));
$f->groups["g06"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["sisben_certificate"])));
$f->groups["g07"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["address_certificate"])));
$f->groups["g08"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["electoral_certificate"])));
$f->groups["g09"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["photo_card"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card("create", array(
    "title" => "Documentos requeridos",
    "content" => $f,
    "header-back" => $back
));
echo($card);
?>
