<?php

//[Services]------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[Models]--------------------------------------------------------------------------------------------------------------
$f = service("forms", array("lang" => "Sie_Groups."));
$model = model("App\Modules\Sie\Models\Sie_Groups");
//[Vars]----------------------------------------------------------------------------------------------------------------
$d = array(
    "group" => $f->get_Value("group"),
    "institution" => $f->get_Value("institution"),
    "reference" => $f->get_Value("reference"),
    "description" => $f->get_Value("description"),
    "author" => safe_get_user(),
);
$row = $model->find($d["group"]);
$l["back"] = $f->get_Value("back");
$l["edit"] = "/sie/groups/edit/{$d["group"]}";
$asuccess = "sie/groups-create-success-message.mp3";
$aexist = "sie/groups-create-exist-message.mp3";
if (is_array($row)) {
    $c = $bootstrap->get_Card("duplicate", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Groups.create-duplicate-title"),
        "text-class" => "text-center",
        "text" => lang("Sie_Groups.create-duplicate-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $aexist,
    ));
} else {
    $create = $model->insert($d);
    //echo($model->getLastQuery()->getQuery());
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Groups.create-success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Sie_Groups.create-success-message"), $d['group']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
}
echo($c);
cache()->clean();
?>