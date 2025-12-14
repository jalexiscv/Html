<?php

//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication =service('authentication');
//[Models]-----------------------------------------------------------------------------
$f = service("forms",array("lang" => "Sgd_Boxes."));
$model = model("App\Modules\Sgd\Models\Sgd_Boxes");
//[Vars]-----------------------------------------------------------------------------

$d = array(
    "box" => $f->get_Value("box"),
    "shelve" => $f->get_Value("shelve"),
    "reference" => $f->get_Value("reference"),
    "name" => $f->get_Value("name"),
    "description" => $f->get_Value("description"),
    "author" => safe_get_user(),
);
$row = $model->find($d["box"]);
$l["back"]="/sgd/shelves/view/".$d["shelve"];
$l["edit"]="/sgd/boxes/edit/{$d["box"]}";
$asuccess = "sgd/boxes-create-success-message.mp3";
$aexist = "sgd/boxes-create-exist-message.mp3";
if (is_array($row)) {
    $c= $bootstrap->get_Card("duplicate", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sgd_Boxes.create-duplicate-title"),
        "text-class" => "text-center",
        "text" => lang("Sgd_Boxes.create-duplicate-message"),
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
        "title" => lang("Sgd_Boxes.create-success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Sgd_Boxes.create-success-message"),$d['box']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" =>$asuccess,
    ));
}
echo($c);
cache()->clean();
?>