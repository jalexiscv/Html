<?php

$bootstrap = service("bootstrap");
$f = service("forms", array("lang" => "Roles."));
$model = model("App\Modules\Security\Models\Security_Roles");
$d = array(
    "rol" => $f->get_Value("rol"),
    "name" => $f->get_Value("name"),
    "description" => $f->get_Value("description"),
    "author" => $authentication->get_User(),
);
$l["back"] = "/security/roles/list/" . lpk();
$row = $model->find($d["rol"]);
$asuccess = "security/roles-create-success-message.mp3";
$aexist = "security/roles-create-exist-message.mp3";
if (isset($row["rol"])) {
    $c = $card = $bootstrap->get_Card("duplicate", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Roles.create-duplicate-title"),
        "text-class" => "text-center",
        "text" => lang("Roles.create-duplicate-message"),
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
        "title" => lang("Roles.create-success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Roles.create-success-message"), $d['name']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
}
echo($c);
?>