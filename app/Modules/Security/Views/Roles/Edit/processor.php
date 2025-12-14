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
$row = $model->find($d["rol"]);
$l["back"] = "/security/roles/list/" . lpk();
$asuccess = "security/roles-edit-success-message.mp3";
$anoexist = "security/roles-edit-noexist-message.mp3";
if (isset($row["rol"])) {
    $edit = $model->update($d["rol"], $d);

    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Roles.edit-success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Roles.edit-success-message"), $d['name']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
} else {
    $create = $model->insert($d);
    //echo($model->getLastQuery()->getQuery());
    $c = $bootstrap->get_Card("warning", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Roles.edit-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Roles.edit-noexist-message"), $d['name']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $anoexist,
    ));
}
echo($c);
?>