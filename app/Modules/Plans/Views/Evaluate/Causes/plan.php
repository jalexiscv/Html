<?php
/** @var  $bootstrap */
/** @var  $model */
/** @var  $oid */
$mcauses = model("App\Modules\Plans\Models\Plans_Causes");
$mscores = model("App\Modules\Plans\Models\Plans_Causes_Scores");
$bootstrap = service("bootstrap");
$plan = $model->getPlan($oid);
$back = "/plans/plans/causes/{$oid}";
$f = service("forms", array("lang" => "Plans_Causes."));
$r["author"] = $f->get_Value("author", safe_get_user());
$scores = $mscores->where("author", $r["author"])->find();
//var_dump($scores);
$data = array(
    array("label" => "0", "value" => "0.0"),
    array("label" => "1", "value" => "0.1"),
    array("label" => "2", "value" => "0.2"),
    array("label" => "3", "value" => "0.3"),
    array("label" => "4", "value" => "0.4"),
    array("label" => "5", "value" => "0.5"),
    array("label" => "6", "value" => "0.6"),
    array("label" => "7", "value" => "0.7"),
    array("label" => "8", "value" => "0.8"),
    array("label" => "9", "value" => "0.9"),
);
$code = "";
//[table]---------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("plan", $oid);
$f->add_HiddenField("author", $r["author"]);
$code .= "<table class='table table-striped table-hover table-sm'>";
$code .= "<thead>";
$code .= "<tr>";
$code .= "<th nowrap scope='col'>#</th>";
$code .= "<th nowrap scope='col'>Causa</th>";
$code .= "<th scope='col'>Descripción</th>";
$code .= "<th nowrap scope='col'>Acciones</th>";
$code .= "</tr>";
$code .= "</thead>";
$code .= "<tbody>";
$causes = $mcauses->get_List($oid, 10000, 0);
$count = 0;
foreach ($causes as $cause) {
    $count++;
    $code .= "<tr>";
    $code .= "<th scope='row'>{$count}</th>";
    $code .= "<td class=\"text-center align-middle\">{$cause['cause']}</td>";
    $code .= "<td class=\"text-start align-middle\">{$cause['description']}</td>";
    $code .= "<td class=\"text-center align-middle\" nowrap>";
    $value = "0";
    foreach ($scores as $score) {
        if ($score["cause"] == $cause["cause"]) {
            $value = $score["value"];
        }
    }
    $field = $f->get_FieldSelect("value[{$cause["cause"]}]", array("selected" => $value, "data" => $data, "label" => false, "help" => false, "proportion" => "col-12"));
    $code .= "{$field}";
    $code .= "</td>";
    $code .= "</tr>";
}
$code .= "</tbody>";
$code .= "</table>";
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => "/plans/plans/causes/{$oid}", "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Update"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
$f->add_Html($code);
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => "¡Calificando causas probables!",
    "header-back" => $back,
    "alert" => array(
        "type" => "info",
        "title" => "Análisis de causas del plan de acción",
        "message" => $plan['description'],
    ),
    "content" => $f,
));
echo($card);
//[info]----------------------------------------------------------------------------------------------------------------
$info = $bootstrap->get_Card("card-view-service", array(
    "alert" => array(
        'type' => 'secondary',
        'title' => lang("Plans_Causes.info-evaluate-title"),
        'message' => lang("Plans_Causes.info-evaluate-message"),
        'class' => 'mb-0'),
));
echo($info);
?>