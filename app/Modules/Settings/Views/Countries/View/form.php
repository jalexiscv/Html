<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-05-05 15:16:06
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Application\Views\Countries\Editor\form.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 * █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 * █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 * █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * █ @link https://www.higgs.com.co
 * █ @Version 1.5.1 @since PHP 8,PHP 9
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[services]------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
$server = service("server");
$f = service("forms", array("lang" => "Settings_Countries."));
//[models]--------------------------------------------------------------------------------------------------------------
//[vars]----------------------------------------------------------------------------------------------------------------
$row = $model->getCountry($oid);
$r["country"] = $row["country"];
$r["name"] = $row["name"];
$r["_iso3"] = $row["_iso3"];
$r["codigo"] = $row["codigo"];
$r["status"] = $row["status"];
$r["date"] = $row["date"];
$r["time"] = $row["time"];
$r["author"] = $row["author"];
$r["created_at"] = $row["created_at"];
$r["updated_at"] = $row["updated_at"];
$r["deleted_at"] = $row["deleted_at"];
$back = $f->get_Value("back", $server->get_Referer());
//[Fields]-----------------------------------------------------------------------------
$f->fields["country"] = $f->get_FieldView("country", array("value" => $r["country"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["name"] = $f->get_FieldView("name", array("value" => $r["name"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["_iso3"] = $f->get_FieldView("_iso3", array("value" => $r["_iso3"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["codigo"] = $f->get_FieldView("codigo", array("value" => $r["codigo"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["status"] = $f->get_FieldView("status", array("value" => $r["status"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["date"] = $f->get_FieldView("date", array("value" => $r["date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["time"] = $f->get_FieldView("time", array("value" => $r["time"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldView("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldView("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldView("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["edit"] = $f->get_Button("edit", array("href" => "/settings/countries/edit/" . $oid, "text" => lang("App.Edit"), "class" => "btn btn-secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
//[Groups]-----------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["country"] . $f->fields["name"] . $f->fields["_iso3"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["codigo"] . $f->fields["status"])));
//[Buttons]-----------------------------------------------------------------------------
//$f->groups["gy"] =$f->get_GroupSeparator();
//$f->groups["gz"] = $f->get_Buttons(array("fields"=>$f->fields["edit"].$f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card2("card-view-service", array(
    "header-title" => lang("Settings_Countries.view-title"),
    "header-back" => $back,
    "content" => $f,
));
echo($card);
?>
