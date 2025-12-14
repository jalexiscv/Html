<?php

//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[Models]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Iso9001_Activities."));
$model = model("App\Modules\Iso9001\Models\Iso9001_Activities");
$d = array(
    "activity" => $f->get_Value("activity"),
    "category" => $f->get_Value("category"),
    "order" => $f->get_Value("order"),
    "criteria" => $f->get_Value("criteria"),
    "description" => $f->get_Value("description"),
    "evaluation" => $f->get_Value("evaluation"),
    "period" => $f->get_Value("period"),
    "score" => $f->get_Value("score"),
    "author" => safe_get_user(),
);
$row = $model->find($d["activity"]);
$l["back"] = "/iso9001/activities/list/{$oid}";
$l["edit"] = "/iso9001/activities/edit/{$d["activity"]}";
$asuccess = "iso9001/activities-create-success-message.mp3";
$aexist = "iso9001/activities-create-exist-message.mp3";
if (is_array($row)) {
    $c = $card = $bootstrap->get_Card("duplicate", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Iso9001_Activities.create-duplicate-title"),
        "text-class" => "text-center",
        "text" => lang("Iso9001_Activities.create-duplicate-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $aexist,
    ));
} else {
    $create = $model->insert($d);
    //echo($model->getLastQuery()->getQuery());
    $c = $card = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Iso9001_Activities.create-success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Iso9001_Activities.create-success-message"), $d['activity']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
}
echo($c);
cache()->clean();
?>