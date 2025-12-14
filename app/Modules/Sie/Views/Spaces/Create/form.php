<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-07-18 06:39:24
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Spaces\Creator\form.php]
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
$f = service("forms", array("lang" => "Sie_Spaces."));
$server = service("server");
//[models]--------------------------------------------------------------------------------------------------------------
$mspaces = model("App\Modules\Sie\Models\Sie_Spaces");
$mheadquarters = model("App\Modules\Sie\Models\Sie_Headquarters");
//[vars]----------------------------------------------------------------------------------------------------------------
$r["space"] = $f->get_Value("space", pk());
$r["headquarter"] = $f->get_Value("headquarter");
$r["type"] = $f->get_Value("type");
$r["block"] = $f->get_Value("block");
$r["name"] = $f->get_Value("name");
$r["description"] = $f->get_Value("description");
$r["area"] = $f->get_Value("area");
$r["static_capacity"] = $f->get_Value("static_capacity");
$r["dynamic_capacity"] = $f->get_Value("dynamic_capacity");
$r["tv"] = $f->get_Value("tv");
$r["split_wall"] = $f->get_Value("split_wall");
$r["split_ceiling"] = $f->get_Value("split_ceiling");
$r["videobeam"] = $f->get_Value("videobeam");
$r["sound"] = $f->get_Value("sound");
$r["author"] = $f->get_Value("author", safe_get_user());
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");
$back = "/sie/spaces/list/" . lpk();
$headquarters = $mheadquarters->get_SelectData();

$types = array(
    array("value" => "", "label" => "- Seleccione un tipo"),
    array("value" => "A", "label" => "A - Aula de servicios"),
    array("value" => "B", "label" => "B - Laboratorios de servicios"),
    array("value" => "Z", "label" => "Otro"),
);

$blocks = array(
    array("value" => "", "label" => "- Seleccione un boque"),
    array("value" => "A", "label" => "A"),
    array("value" => "B3", "label" => "B3"),
    array("value" => "J", "label" => "J"),
    array("value" => "Q", "label" => "Q"),
    array("value" => "M", "label" => "M"),
    array("value" => "N", "label" => "N"),
    array("value" => "O", "label" => "O"),
    array("value" => "P", "label" => "P"),

);

$yn = array(
    array("value" => "Y", "label" => "Si"),
    array("value" => "N", "label" => "No"),
);


//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("back", $back);
$f->fields["space"] = $f->get_FieldText("space", array("value" => $r["space"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["headquarter"] = $f->get_FieldSelect("headquarter", array("selected" => $r["headquarter"], "data" => $headquarters, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["type"] = $f->get_FieldSelect("type", array("selected" => $r["type"], "data" => $types, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["block"] = $f->get_FieldSelect("block", array("selected" => $r["block"], "data" => $blocks, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["name"] = $f->get_FieldText("name", array("value" => $r["name"], "proportion" => "col-md-8 col-sm-12 col-12"));
$f->fields["description"] = $f->get_FieldTextArea("description", array("value" => $r["description"], "proportion" => "col-12"));
$f->fields["area"] = $f->get_FieldText("area", array("value" => $r["area"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["static_capacity"] = $f->get_FieldText("static_capacity", array("value" => $r["static_capacity"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["dynamic_capacity"] = $f->get_FieldText("dynamic_capacity", array("value" => $r["dynamic_capacity"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields["tv"] = $f->get_FieldSelect("tv", array("selected" => $r["tv"], "data" => $yn, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["split_wall"] = $f->get_FieldSelect("split_wall", array("selected" => $r["split_wall"], "data" => $yn, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["split_ceiling"] = $f->get_FieldSelect("split_ceiling", array("selected" => $r["split_ceiling"], "data" => $yn, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["videobeam"] = $f->get_FieldSelect("videobeam", array("selected" => $r["videobeam"], "data" => $yn, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["sound"] = $f->get_FieldSelect("sound", array("selected" => $r["sound"], "data" => $yn, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));


$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["space"] . $f->fields["headquarter"] . $f->fields["type"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["block"] . $f->fields["name"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["description"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["area"] . $f->fields["static_capacity"] . $f->fields["dynamic_capacity"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["tv"] . $f->fields["split_wall"] . $f->fields["split_ceiling"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["videobeam"] . $f->fields["sound"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card("create", array(
    "title" => lang("Sie_Spaces.create-title"),
    "content" => $f,
    "header-back" => $back
));
echo($card);
?>
