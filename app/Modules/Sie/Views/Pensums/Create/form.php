<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-04-24 17:16:47
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Pensums\Creator\form.php]
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
 * █ @var object $parent Trasferido desde el controlador
 * █ @var object $authentication Trasferido desde el controlador
 * █ @var object $request Trasferido desde el controlador
 * █ @var object $dates Trasferido desde el controlador
 * █ @var string $component Trasferido desde el controlador
 * █ @var string $view Trasferido desde el controlador
 * █ @var string $oid Trasferido desde el controlador
 * █ @var string $views Trasferido desde el controlador
 * █ @var string $prefix Trasferido desde el controlador
 * █ @var array $data Trasferido desde el controlador
 * █ @var object $model Modelo de datos utilizado en la vista y trasferido desde el index
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[services]------------------------------------------------------------------------------------------------------------
$b = service("bootstrap");
$f = service("forms", array("lang" => "Sie_Pensums."));
//[models]--------------------------------------------------------------------------------------------------------------
$mpensums = model("App\Modules\Sie\Models\Sie_Pensums");
$mversions = model("App\Modules\Sie\Models\Sie_Versions");
$mmodules = model("App\Modules\Sie\Models\Sie_Modules");
//[vars]----------------------------------------------------------------------------------------------------------------
$mversions =
//[vars]----------------------------------------------------------------------------------------------------------------
$r["pensum"] = $f->get_Value("pensum", pk());
$r["version"] = $f->get_Value("version", $oid);
$r["module"] = $f->get_Value("module");
$r["cycle"] = $f->get_Value("cycle");
$r["level"] = $f->get_Value("level");
$r["moment"] = $f->get_Value("moment");
$r["credits"] = $f->get_Value("credits");
$r["weekly_hourly_intensity"] = $f->get_Value("weekly_hourly_intensity", "0");
$r["monthly_hourly_intensity"] = $f->get_Value("monthly_hourly_intensity", "0");
$r["evaluation"] = $f->get_Value("evaluation");
$r["author"] = $f->get_Value("author", safe_get_user());
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");
$cicles = array(
    array("value" => "", "label" => "Seleccione uno..."),
    array("value" => "1", "label" => "Ciclo I"),
    array("value" => "2", "label" => "Ciclo II"),
    array("value" => "3", "label" => "Ciclo III"),
    array("value" => "4", "label" => "Ciclo IV"),
    array("value" => "5", "label" => "Ciclo V"),
    array("value" => "6", "label" => "Ciclo VI"),
    array("value" => "7", "label" => "Ciclo VII"),
    array("value" => "8", "label" => "Ciclo VIII"),
    array("value" => "9", "label" => "Ciclo IX"),
    array("value" => "10", "label" => "Ciclo X"),
    array("value" => "11", "label" => "Ciclo XI"),
    array("value" => "12", "label" => "Ciclo XII"),
);

$levels = array(
    array("value" => "", "label" => "Seleccione uno..."),
    array("value" => "TP", "label" => "TP - Técnico Profesional"),
    array("value" => "TG", "label" => "TG - Tecnólogo"),
    array("value" => "UN", "label" => "UN - Universitario"),
    array("value" => "EX", "label" => "EX - Extensión"),
);

$yn = array(
    array("value" => "1", "label" => "Si"),
    array("value" => "0", "label" => "No"),
);
$moment = array(
    array("value" => "0", "label" => "Antiguo"),
    array("value" => "1", "label" => "I"),
    array("value" => "2", "label" => "II"),
    array("value" => "3", "label" => "III"),
    array("value" => "4", "label" => "IV"),
    array("value" => "5", "label" => "V"),
);

$back = "/sie/versions/view/{$oid}";
$modules = $mmodules->get_SelectData();
//[fields]----------------------------------------------------------------------------------------------------------------
$f->fields["pensum"] = $f->get_FieldText("pensum", array("value" => $r["pensum"], "proportion" => "col-md-6 col-sm-12 col-12", "readonly" => true));
$f->fields["version"] = $f->get_FieldText("version", array("value" => $r["version"], "proportion" => "col-md-6 col-sm-12 col-12", "readonly" => true));
$f->fields["module"] = $f->get_FieldSelect("module", array("selected" => $r["module"], "data" => $modules, "proportion" => "col-12"));
$f->fields["cycle"] = $f->get_FieldSelect("cycle", array("selected" => $r["cycle"], "data" => $cicles, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["level"] = $f->get_FieldSelect("level", array("selected" => $r["level"], "data" => $levels, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["moment"] = $f->get_FieldSelect("moment", array("selected" => $r["moment"], "data" => $moment, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["credits"] = $f->get_FieldNumber("credits", array("value" => $r["credits"], "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["weekly_hourly_intensity"] = $f->get_FieldNumber("weekly_hourly_intensity", array("value" => $r["weekly_hourly_intensity"], "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["monthly_hourly_intensity"] = $f->get_FieldNumber("monthly_hourly_intensity", array("value" => $r["monthly_hourly_intensity"], "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["evaluation"] = $f->get_FieldSelect("evaluation", array("selected" => $r["evaluation"], "data" => $yn, "proportion" => "col-md-6 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["pensum"] . $f->fields["version"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["module"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["cycle"] . $f->fields["level"]) . $f->fields["moment"]));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["weekly_hourly_intensity"] . $f->fields["monthly_hourly_intensity"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["credits"] . $f->fields["evaluation"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card("create", array(
    "title" => lang("Sie_Pensums.create-title"),
    "content" => $f,
    "header-back" => $back
));
echo($card);
?>