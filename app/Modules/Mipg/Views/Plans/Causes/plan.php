<?php
/** @var  $bootstrap */
/** @var  $model */
/** @var  $oid */

$mcauses = model("App\Modules\Mipg\Models\Mipg_Causes");
$bootstrap = service("bootstrap");
$numbers = service("numbers");

$plan = $model->getPlan($oid);
$back = "/mipg/plans/view/{$oid}";

$status = "";
if ($plan['status'] == "COMPLETED") {
    $status = "disabled";
}

$code = "";
//[table]---------------------------------------------------------------------------------------------------------------
$code .= "<table class='table table-striped table-hover table-sm'>";
$code .= "<thead>";
$code .= "<tr>";
$code .= "<th nowrap scope='col'>#</th>";
//$code .= "<th nowrap scope='col'>Causa</th>";
$code .= "<th scope='col'>Descripción</th>";
$code .= "<th nowrap scope='col' class='text-center'>Porcentaje</th>";
$code .= "<th class=\"text-center align-middle\" nowrap scope='col'>Opciones</th>";
$code .= "</tr>";
$code .= "</thead>";
$code .= "<tbody>";
$mayor = $mcauses->where("plan", $oid)->orderBy("score", "DESC")->first();
$causes = $mcauses->get_List($oid, 10000, 0);
$count = 0;
foreach ($causes as $cause) {
    $count++;
    $evaluation = (round($cause["score"], 2) * 100) . "%";
    $code .= "<tr>";
    $code .= "<th scope='row'>{$count}</th>";
    //$code .= "<td class=\"text-center align-middle\">{$cause['cause']}</td>";
    $code .= "<td class=\"text-start align-middle\">{$cause['description']}</td>";
    $code .= "<td class=\"text-center align-middle\">{$evaluation}</td>";
    $code .= "<td class=\"text-center align-middle\" nowrap=''>";
    $code .= "<div class='btn-group float-right' role='group' aria-label=''>";
    if (($mayor["score"] > 0) && ($mayor["cause"] === $cause["cause"])) {
        $code .= "    <a class=\"btn btn-sm btn-danger {$status}\" href=\"/mipg/whys/list/{$cause["cause"]}?c={$mayor["score"]}\" target=\"_self\"><i class=\"icon fas fa-bug\"></i> Mayor</a>\n";
    }
    $code .= "<a href='/mipg/causes/edit/{$cause['cause']}' class='btn btn-sm btn-warning {$status}'><i class=\"icon far fa-edit\"></i> Editar</a>";
    $code .= "<a href='/mipg/causes/delete/{$cause['cause']}' class='btn btn-sm btn-danger {$status}'><i class=\"far fa-trash\"></i> Eliminar</a>";
    $code .= "</div>";
    $code .= "</td>";
    $code .= "</tr>";
}
$code .= "</tbody>";
$code .= "</table>";


$card = $bootstrap->get_Card("card-view-service", array(
    "title" => sprintf("Análisis de causas del plan de acción %s", $numbers->pad_LeftWithZeros($plan['order'], 4)),
    "header-back" => $back,
    "header-add" => array("href" => "/mipg/causes/create/{$oid}", "class" => $status),
    "header-evaluate" => array("href" => "/mipg/evaluate/causes/{$oid}", "class" => $status),
    "alert" => array(
        "type" => "info",
        "title" => "Análisis de causas del plan de acción",
        "message" => $plan['description'],
    ),
    "content" => $code,
));
echo($card);


//[info]----------------------------------------------------------------------------------------------------------------
$info = $bootstrap->get_Card("card-view-service", array(
    "alert" => array(
        'type' => 'secondary',
        'title' => lang("Mipg_Causes.info-title"),
        'message' => lang("Mipg_Causes.info-message"),
        'class' => 'mb-0'),
));
echo($info);

?>