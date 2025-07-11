<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-04-17 08:54:30
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Plans\Views\Actions\Creator\form.php]
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
$f = service("forms", array("lang" => "Plans_Actions."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Plans\Models\Plans_Actions");
$mactivities = model('App\Modules\Plans\Models\Plans_Activities');
$mcategories = model('App\Modules\Plans\Models\Plans_Categories');
$mcomponents = model('App\Modules\Plans\Models\Plans_Components');
$mdiagnostics = model('App\Modules\Plans\Models\Plans_Diagnostics');
$mpolitics = model('App\Modules\Plans\Models\Plans_Politics');
$mdimensions = model('App\Modules\Plans\Models\Plans_Dimensions');
$mprocesses = model('App\Modules\Plans\Models\Plans_Processes');
$msubprocesses = model('App\Modules\Plans\Models\Plans_Subprocesses');
$mpositions = model('App\Modules\Plans\Models\Plans_Positions');
$miplans = model('App\Modules\Plans\Models\Plans_Institutional_Plans');
$mplans = model('App\Modules\Plans\Models\Plans_Plans');
//[vars]----------------------------------------------------------------------------------------------------------------
$r["action"] = $f->get_Value("action", pk());
$r["plan"] = $f->get_Value("plan", $oid);
$r["variables"] = $f->get_Value("variables");
$r["alternatives"] = $f->get_Value("alternatives");
$r["implementation"] = $f->get_Value("implementation");
$r["evaluation"] = $f->get_Value("evaluation");
$r["percentage"] = $f->get_Value("percentage");
$r["start"] = $f->get_Value("start");
$r["end"] = $f->get_Value("end");
$r["owner"] = $f->get_Value("owner");
$r["author"] = $f->get_Value("author", safe_get_user());
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");
$back = "/plans/actions/home/{$oid}";
$plan = $mplans->getPlan($oid);
//$activity = $mactivities->where("activity", $plan["activity"])->first();
//$category = $mcategories->where("category", $activity["category"])->first();
//$component = $mcomponents->where("component", $category["component"])->first();
//$diagnostic = $mdiagnostics->where("diagnostic", $component["diagnostic"])->first();
//$politic = $mpolitics->where("politic", $diagnostic["politic"])->first();
//$dimension = $mdimensions->where("dimension", $politic["dimension"])->first();
//$process = $mprocesses->where("process", $dimension["process"])->first();
//[fields]----------------------------------------------------------------------------------------------------------------
$f->fields["action"] = $f->get_FieldText("action", array("value" => $r["action"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["plan"] = $f->get_FieldText("plan", array("value" => $r["plan"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["variables"] = $f->get_FieldTextArea("variables", array("value" => $r["variables"], "proportion" => "col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));
$f->fields["alternatives"] = $f->get_FieldTextArea("alternatives", array("value" => $r["alternatives"], "proportion" => "col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));
$f->fields["implementation"] = $f->get_FieldTextArea("implementation", array("value" => $r["implementation"], "proportion" => "col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));
$f->fields["evaluation"] = $f->get_FieldTextArea("evaluation", array("value" => $r["evaluation"], "proportion" => "col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));
$f->fields["percentage"] = $f->get_FieldText("percentage", array("value" => $r["percentage"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["daterange"] = $f->get_FieldDateRange("start", "end", array("start" => $plan["start"], "end" => $plan["end"], "minDate" => $plan["start"], "maxDate" => $plan["end"], "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->fields["owner"] = $f->get_FieldText("owner", array("value" => $r["owner"], "proportion" => "col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["action"] . $f->fields["plan"] . $f->fields["daterange"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["owner"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["variables"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["implementation"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["evaluation"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card("create", array(
    "title" => lang("Plans_Actions.create-title"),
    "alert" => array(
        'type' => 'info',
        'title' => lang("Plans_Actions.create-info-title"),
        'message' => sprintf(lang("Plans_Actions.create-info-message"), $plan['start'], $plan['end']),
    ),
    "content" => $f,
    "header-back" => $back
));
echo($card);
//[info]----------------------------------------------------------------------------------------------------------------
$info = $b->get_Card("card-view-service", array(
    "alert" => array('type' => 'secondary', 'title' => lang("Plans_Actions.create-definition-info-title"), 'message' => lang("Plans_Actions.create-definition-info-message"), 'class' => 'mb-0'),
));
echo($info);
?>

