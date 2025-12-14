<?php

//[Services]------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication =service('authentication');
//[Models]--------------------------------------------------------------------------------------------------------------
$f = service("forms",array("lang" => "Sgd_Units."));
$munits = model("App\Modules\Sgd\Models\Sgd_Units");
//[Vars]----------------------------------------------------------------------------------------------------------------

$d = array(
    "unit" => $f->get_Value("unit"),
    "version" => $f->get_Value("version"),
    "reference" => $f->get_Value("reference"),
    "name" => $f->get_Value("name"),
    "description" => $f->get_Value("description"),
    "author" => safe_get_user(),
    "owner" => $f->get_Value("owner"),
    "date" => safe_get_date(),
    "time" => safe_get_time(),
);
$row = $munits->get_Unit(@$d["unit"]);
//[Processor]-----------------------------------------------------------------------------------------------------------
$l["back"]="/sgd/versions/view/{$d["version"]}";
$l["edit"]="/sgd/units/edit/{$d["version"]}";
$asuccess = "sgd/units-create-success-message.mp3";
$aexist = "sgd/units-create-exist-message.mp3";
if (is_array($row)) {
    $c= $bootstrap->get_Card("duplicate", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Units.create-duplicate-title"),
        "text-class" => "text-center",
        "text" => lang("Units.create-duplicate-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $aexist,
    ));
} else {
    $create = $munits->insert($d);
    cache()->clean();
    //echo($model->getLastQuery()->getQuery());
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Units.create-success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Units.create-success-message"),$d['unit']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" =>$asuccess,
    ));
}
echo($c);
?>