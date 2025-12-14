<?php

use App\Libraries\Bootstrap;

use App\Libraries\Strings;
use Config\Services;

$authentication = service('authentication');
$strings = service("strings");
$request = service('request');
$mplans = model("App\Modules\Disa\Models\Disa_Plans");
$mcauses = model("App\Modules\Disa\Models\Disa_Causes");
$mwhys = model("App\Modules\Disa\Models\Disa_Whys");
$plan = $mplans->find($oid);
$mcause = $mcauses->where("plan", $oid)->orderBy("score", "DESC")->first();

if (is_array($mcause)) {
    $whys = $mwhys->where("cause", $mcause["cause"])->find();
}

$f = service("forms", array("lang" => "Disa.plans_formulation_"));
/** request **/
$r["plan"] = $f->get_Value("plan", $plan["plan"]);
$r["formulation"] = $f->get_Value("formulation", $plan["formulation"]);
$f->add_HiddenField("plan", $r["plan"]);
$f->add_HiddenField("option", "formulation-update");
$f->fields["formulation"] = $f->get_FieldTextArea("formulation", array("value" => urldecode($r["formulation"]), "proportion" => "col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));

$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => "/disa/mipg/plans/view/{$oid}?time=" . time(), "text" => lang("App.Continue"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Update"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));

$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["formulation"])));
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));

$description = $strings->get_Striptags(urldecode(@$plan["description"]));
$mdescription = $strings->get_Striptags(urldecode(@$mcause["description"]));


$cw = "";

if (empty($r["formulation"])) {
    $warning = service("smarty");
    $warning->set_Mode("bs5x");
    $warning->caching = 0;
    $warning->assign("title", "Advertencia");
    $warning->assign("message", "Aun no se ha formulado el plan de acción, recuerde analizar la mayor causa probable y los porques asociados, para formular acertadamente el plan de acción. Para formular el plan de acción presioné el botón editar en la parte inferior de esta vista.");
    $cw = ($warning->view('alerts/inline/danger.tpl'));
}

$warning2 = service("smarty");
$warning2->set_Mode("bs5x");
$warning2->caching = 0;
$warning2->assign("title", "Mayor causa probable");
$warning2->assign("message", $mdescription);
$cw2 = ($warning2->view('alerts/inline/warning.tpl'));

$twhys = ("<h3 style=\"font-size: 1rem;line-height: 1rem; font-weight: bold;\">5 porqués</h3>");
$twhys .= ("<ol style=\"font-size: 1rem;line-height: 1rem;\">");

if (isset($whys) && is_array($whys)) {
    foreach ($whys as $why) {
        $description = $strings->get_Striptags(urldecode($why["description"]));
        $twhys .= ("<li>{$description}</li>");
    }
}
$twhys .= ("</ol>");

$menu = array(
    array("href" => "/disa/mipg/plans/formulation/edit/{$oid}", "text" => "<i class=\"fas fa-edit\"></i> Editar"),
    array("href" => "#", "text" => "Ayuda")
);
/** build * */
/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
$card = service("smarty");
$card->set_Mode("bs5x");
$card->assign("type", "normal");
$card->assign("header", "Formulacion del plan de acción " . $strings->get_ZeroFill($plan["order"], 4));
$card->assign("header_menu", $menu);
$card->assign("header_back", "/disa/mipg/plans/view/{$oid}");
$card->assign("alerts", $cw . $cw2);
$card->assign("body", $twhys . $f);
$card->assign("footer", null);
$card->assign("file", __FILE__);
echo($card->view('components/cards/index.tpl'));

?>