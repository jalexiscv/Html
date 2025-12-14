<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-11-10 06:42:31
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Cadastre\Views\Georeferences\Creator\form.php]
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
 * █ @link https://www.codehiggs.com
 * █ @Version 1.5.0 @since PHP 7, PHP 8
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ Datos recibidos desde el controlador - @ModuleController
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[services]------------------------------------------------------------------------------------------------------------
$b = service("bootstrap");
$f = service("forms", array("lang" => "Cadastre.georeferences-"));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Cadastre\Models\Cadastre_Georeferences");
//[vars]----------------------------------------------------------------------------------------------------------------
$r["georeference"] = $f->get_Value("georeference");
$r["profile"] = $f->get_Value("profile");
$r["latitud"] = $f->get_Value("latitud");
$r["latitude_degrees"] = $f->get_Value("latitude_degrees");
$r["latitude_minutes"] = $f->get_Value("latitude_minutes");
$r["latitude_seconds"] = $f->get_Value("latitude_seconds");
$r["latitude_decimal"] = $f->get_Value("latitude_decimal");
$r["longitude"] = $f->get_Value("longitude");
$r["longitude_degrees"] = $f->get_Value("longitude_degrees");
$r["longitude_minutes"] = $f->get_Value("longitude_minutes");
$r["longitude_seconds"] = $f->get_Value("longitude_seconds");
$r["longitude_decimal"] = $f->get_Value("longitude_decimal");
$r["date"] = $f->get_Value("date", service("dates")::get_Date());
$r["time"] = $f->get_Value("time", service("dates")::get_Time());
$r["author"] = $f->get_Value("author", safe_get_user());
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");
$back = "/cadastre/georeferences/list/" . lpk();
//[fields]----------------------------------------------------------------------------------------------------------------
$f->fields["georeference"] = $f->get_FieldText("georeference", array("value" => $r["georeference"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["profile"] = $f->get_FieldText("profile", array("value" => $r["profile"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["latitud"] = $f->get_FieldText("latitud", array("value" => $r["latitud"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["latitude_degrees"] = $f->get_FieldText("latitude_degrees", array("value" => $r["latitude_degrees"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["latitude_minutes"] = $f->get_FieldText("latitude_minutes", array("value" => $r["latitude_minutes"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["latitude_seconds"] = $f->get_FieldText("latitude_seconds", array("value" => $r["latitude_seconds"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["latitude_decimal"] = $f->get_FieldText("latitude_decimal", array("value" => $r["latitude_decimal"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["longitude"] = $f->get_FieldText("longitude", array("value" => $r["longitude"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["longitude_degrees"] = $f->get_FieldText("longitude_degrees", array("value" => $r["longitude_degrees"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["longitude_minutes"] = $f->get_FieldText("longitude_minutes", array("value" => $r["longitude_minutes"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["longitude_seconds"] = $f->get_FieldText("longitude_seconds", array("value" => $r["longitude_seconds"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["longitude_decimal"] = $f->get_FieldText("longitude_decimal", array("value" => $r["longitude_decimal"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["date"] = $f->get_FieldText("date", array("value" => $r["date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["time"] = $f->get_FieldText("time", array("value" => $r["time"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["georeference"] . $f->fields["profile"] . $f->fields["latitud"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["latitude_degrees"] . $f->fields["latitude_minutes"] . $f->fields["latitude_seconds"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["latitude_decimal"] . $f->fields["longitude"] . $f->fields["longitude_degrees"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["longitude_minutes"] . $f->fields["longitude_seconds"] . $f->fields["longitude_decimal"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["date"] . $f->fields["time"] .)));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ()));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card("create", array(
    "title" => lang("Cadastre.georeferences-create-title"),
    "content" => $f,
));
echo($card);
?>
