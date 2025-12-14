<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-02-03 16:17:45
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Plans\Views\Plans\Creator\form.php]
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
 * █ @var object $parent
 * █ @var object $authentication
 * █ @var object $request
 * █ @var object $dates
 * █ @var string $component
 * █ @var string $view
 * █ @var string $oid
 * █ @var string $views
 * █ @var string $prefix
 * █ @var array $data
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[services]------------------------------------------------------------------------------------------------------------
$b = service("bootstrap");
$f = service("forms", array("lang" => "Plans_Plans."));
$request=service("request");
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Plans\Models\Plans_Plans");
$miplans = model('App\Modules\Plans\Models\Plans_Organization_Plans');
$mobjects = model('App\Modules\Standards\Models\Standards_Objects');
//[vars]----------------------------------------------------------------------------------------------------------------
$module="standards";
$score="0.0";
$reference="";
$description="";
$evaluation="";
$parent=$request->getVar("parent");
$object=$mobjects->getObject($oid);

if(!empty($module)){
    if($module=="standards"){
        $reference=$oid;
        $mobjects = model('App\Modules\Standards\Models\Standards_Objects');
        $object=$mobjects->getObject($reference);
        $score=$object["value"];
        $criteria= @$object["criteria"]." ";
        $description= @$object["description"]." ";
        $evaluation= @$object["evaluation"]." ";
        $back="/plans/plans/list/{$oid}?parent={$parent}&module=standards";
    }
}

$r["plan"] = $f->get_Value("plan", pk());
$r["reference"] = $f->get_Value("reference",$reference);
$r["plan_institutional"] = $f->get_Value("plan_institutional", "");
$r["module"] = $f->get_Value("module",$module);
$r["activity"] = $f->get_Value("activity",$request->getVar("activity"));
$r["manager"] = $f->get_Value("manager");
$r["manager_subprocess"] = $f->get_Value("manager_subprocess");
$r["manager_position"] = $f->get_Value("manager_position");
$r["order"] = $f->get_Value("order");
$r["description"] = $f->get_Value("description");
$r["formulation"] = $f->get_Value("formulation");
$r["score"] = $f->get_Value("value", $score);
$r["value"] = $f->get_Value("value", "0");
$r["start"] = $f->get_Value("start");
$r["end"] = $f->get_Value("end");
$r["evaluation"] = $f->get_Value("evaluation");
$r["author"] = $f->get_Value("author", safe_get_user());
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");

$plans = $miplans->get_SelectData();
array_push($plans, array("value" => "", "label" => "- Seleccione un plan -"));

$request = service("request");
$activity = $request->getVar("activity");

if($module=="iso9001"){
    $mactyvities = model('App\Modules\Iso9001\Models\Iso9001_Activities');
    $activity = $mactyvities->getActivity($activity);
    $score= @$activity["score"]." ";
    $criteria= @$activity["criteria"]." ";
    $description= @$activity["description"]." ";
    $evaluation= @$activity["evaluation"]." ";
    $back = "/iso9001/activities/home/" .$activity["category"];
}

$r["score"] = $f->get_Value("score", @$score);

//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("activity", $r["activity"]);
$f->add_HiddenField("author", $r["author"]);
$f->add_HiddenField("back", $back);

$mprocesses = model('App\Modules\Organization\Models\Organization_Processes');
$processes = $mprocesses->get_SelectData();

$f->fields["plan"] = $f->get_FieldText("plan", array("value" => $r["plan"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["module"] = $f->get_FieldText("module", array("value" => $r["module"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["reference"] = $f->get_FieldText("reference", array("value" => $r["reference"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["plan_institutional"] = $f->get_FieldSelect("plan_institutional", array("selected" => $r["plan_institutional"], "data" => $plans, "proportion" => "col-md-4 col-sm-12 col-12"));

$f->fields["activity"] = $f->get_FieldText("activity", array("value" => $r["activity"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["manager"] = $f->get_FieldSelect("manager", array("selected" => $r["manager"], "data" => $processes, "proportion" => "col-12"));
$f->fields["manager_subprocess"] = $f->get_FieldText("manager_subprocess", array("value" => $r["manager_subprocess"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["manager_position"] = $f->get_FieldText("manager_position", array("value" => $r["manager_position"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["order"] = $f->get_FieldText("order", array("value" => $r["order"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["description"] = $f->get_FieldTextArea("description", array("value" => $r["description"], "proportion" => "col-12"));
$f->fields["formulation"] = $f->get_FieldText("formulation", array("value" => $r["formulation"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12")); 
$f->fields["score"] = $f->get_FieldText("score", array("value" => $r["score"], "min" => $r["score"], "max" => "100", "proportion" => "col-md-4 col-sm-12 col-12","readonly"=>true));
$f->fields["value"] = $f->get_FieldNumber("value", array("value" => $r["value"], "min" => $r["value"], "max" => "100", "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["range"] = $f->get_FieldDateRange("daterange", "end", array("start" => $r["start"], "end" => $r["end"], "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["start"] = $f->get_FieldText("start", array("value" => $r["start"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["end"] = $f->get_FieldText("end", array("value" => $r["end"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["evaluation"] = $f->get_FieldText("evaluation", array("value" => $r["evaluation"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["plan"] .$f->fields["reference"].$f->fields["module"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["plan_institutional"].$f->fields["score"] . $f->fields["value"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["range"].$f->fields["manager"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["description"])));
//[buttons]-------------------------------------------------------------------------------------------------------------

if($module=="iso9001"){
    $f->groups["g5"] = $f->get_Group(array("legend" => "Criterio", "fields" => ($criteria)));
    $f->groups["g6"] = $f->get_Group(array("legend" => "Descripción", "fields" => ($description)));
    $f->groups["g7"] = $f->get_Group(array("legend" => "Evaluación", "fields" => ($evaluation)));
}

$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card2("create", array(
    "alert" => array(
        "type" => "info",
        'title' => lang("Plans.info-create-title"),
        "message" => lang("Plans_Plans.info-create-message")
    ),
    "header-title" => lang("Plans.create-title"),
    "content" => $f,
    "header-back" => $back
));
echo($card);

if(!empty($description)){
    $title="Actividad";
    $card = $b->get_Card2("create", array(
        "header-title" => $title,
        "content" =>$description,
    ));
    echo($card);
}

if(!empty($evaluation)) {
    $title = lang("Standards_Scores.create-alert-title");
    $card = $b->get_Card2("create", array(
        "header-title" => $title,
        "content" => $evaluation,
    ));
    echo($card);
}
?>