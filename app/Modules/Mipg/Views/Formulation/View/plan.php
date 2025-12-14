<?php
/** @var  $bootstrap */
/** @var  $model */
/** @var  $oid */

$bootstrap = service("bootstrap");
$strings = service("strings");
$numbers = service("numbers");
//[models]--------------------------------------------------------------------------------------------------------------
$mplans = model("App\Modules\Mipg\Models\Mipg_Plans");
$mcauses = model("App\Modules\Mipg\Models\Mipg_Causes");
$mwhys = model("App\Modules\Mipg\Models\Mipg_Whys");
//[vars]----------------------------------------------------------------------------------------------------------------
$plan = $mplans->getPlan($oid);
$cause = $mcauses->where("plan", $oid)->orderBy("score", "DESC")->first();
if (is_array($cause)) {
    $whys = $mwhys->where("cause", $cause["cause"])->find();
}
$back = "/mipg/plans/view/{$oid}";

$status = "";
if ($plan['status'] == "COMPLETED") {
    $status = "disabled";
}


$code = "";
//[cause]----------------------------------------------------------------------------------------------------------------
$info = $bootstrap->get_Card("card-view-service", array(
    "alert" => array(
        'type' => 'secondary',
        'title' => "Mayor causa probable",
        'message' => $cause['description'],
        'class' => 'mb-0'),
));
echo($info);
//[whys]----------------------------------------------------------------------------------------------------------------
$twhys = ("<ol style=\"font-size: 1rem;line-height: 1rem;\">");
if (isset($whys) && is_array($whys)) {
    foreach ($whys as $why) {
        $description = $strings->get_Striptags(urldecode($why["description"]));
        $twhys .= ("<li>{$description}</li>");
    }
}
$twhys .= ("</ol>");
$info = $bootstrap->get_Card("card-view-service", array(
    "alert" => array(
        'type' => 'secondary',
        'title' => "Porques asociados",
        'message' => $twhys,
        'class' => 'mb-0'),
));
echo($info);
//[formulation]---------------------------------------------------------------------------------------------------------
$plan = $mplans->getPlan($oid);
if (empty($plan['formulation'])) {
    $warnin = $bootstrap->get_Card("card-view-service", array(
        "title" => sprintf("Formulación del plan de acción %s", $numbers->pad_LeftWithZeros($plan['order'], 4)),
        "header-back" => $back,
        "alert" => array(
            'type' => 'warning',
            'title' => "Advertencia",
            'message' => "Aun no se ha formulado el plan de acción, recuerde analizar la mayor causa probable y los porques asociados, para formular acertadamente el plan de acción. Para formular el plan de acción presioné el botón editar en la parte inferior de esta vista. ",
            'class' => 'mb-0'),
        "class" => "mb-3",
        "footer-continue" => array(
            "class" => "btn btn-danger float-end {$status}",
            "icon" => "fas fa-edit",
            "text" => "Formular plan de acción",
            "href" => "/mipg/formulation/edit/{$oid}"
        ),
    ));
    echo($warnin);
} else {
    $card = $bootstrap->get_Card("card-view-service", array(
        "title" => sprintf("Formulación del plan de acción %s", $numbers->pad_LeftWithZeros($plan['order'], 4)),
        "header-back" => $back,
        "content" => $plan['formulation'],
        "footer-continue" => array(
            "class" => "btn btn-danger float-end {$status}",
            "icon" => "fas fa-edit",
            "text" => "Modificar formulación",
            "href" => "/mipg/formulation/edit/{$oid}"
        ),
    ));
    echo($card);
}
?>