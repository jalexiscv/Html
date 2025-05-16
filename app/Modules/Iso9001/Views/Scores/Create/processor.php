<?php

//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[Models]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Iso9001_Scores."));
$model = model("App\Modules\Iso9001\Models\Iso9001_Scores");
$mactivities = model("App\Modules\Iso9001\Models\Iso9001_Activities");
$d = array(
    "score" => $f->get_Value("score"),
    "activity" => $f->get_Value("activity"),
    "value" => $f->get_Value("value"),
    "details" => $f->get_Value("details"),
    "author" => safe_get_user(),
);
$row = $model->find($d["score"]);
$l["back"] = "/iso9001/scores/home/{$oid}";
$l["edit"] = "/iso9001/scores/edit/{$d["score"]}";
$asuccess = "iso9001/scores-create-success-message.mp3";
$aexist = "iso9001/scores-create-exist-message.mp3";
if (is_array($row)) {
    $c = $card = $bootstrap->get_Card("duplicate", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Iso9001_Scores.create-duplicate-title"),
        "text-class" => "text-center",
        "text" => lang("Iso9001_Scores.create-duplicate-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $aexist,
    ));
} else {
    $create = $model->insert($d);
    $mactivities->update($d["activity"], array(
        "score" => $d["value"],
    ));
    //echo($model->getLastQuery()->getQuery());
    $c = $card = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Iso9001_Scores.create-success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Iso9001_Scores.create-success-message"), $d['score']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
}
echo($c);
cache()->clean();
?>