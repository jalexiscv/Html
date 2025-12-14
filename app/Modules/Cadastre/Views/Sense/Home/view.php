<?php
$bootstrap = service("bootstrap");

$back = "/cadastre/";
$f = service("forms", array("lang" => "Sense."));
$r["search"] = $f->get_Value("search");
$f->fields["search"] = $f->get_FieldText("search", array("value" => $r["search"], "proportion" => "col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Search"), "proportion" => "col-12"));
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["search"])));
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"]));
//[Build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => "Módulo de Catastro",
    "header-back" => $back,
    "image" => "/themes/assets/images/header/cadasre-update-profile.png",
    "content" => $f,
));
echo($card);

$aproved = $authentication->has_Permission("cadastre-approve-create");
if ($aproved) {
    echo(view('App\Modules\Cadastre\Views\Sense\Home\table'));
}
?>