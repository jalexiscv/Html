<?php

/*
 * Copyright (c) 2022. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

$f = service("forms", array("lang" => "Nexus."));

$model = model("App\Modules\Nexus\Models\Nexus_Clients", true, $conexion);
$r = $model->find($oid);
$r["theme"] = $f->get_Value("theme", @$r["theme"]);
$r["theme_color"] = $f->get_Value("theme_color", @$r["theme_color"]);
$themes = array(
    array("value" => "bs5", "label" => "Generico(BS5)"),
    array("value" => "webbar", "label" => "WebBar"),
    array("value" => "fair", "label" => "Feria"),
);
$colors = array(
    array("value" => "light", "label" => "Claro (Light)"),
    array("value" => "dark", "label" => "Oscuro (Dark)"),
);
/** fields * */
$f->add_HiddenField("option", "interface");
$f->add_HiddenField("client", @$r["client"]);
$f->add_HiddenField("author", @$r["author"]);

$f->fields["theme"] = $f->get_FieldSelect("theme", array("value" => $r["theme"], "data" => $themes, "proportion" => "col-6"));
$f->fields["theme_color"] = $f->get_FieldSelect("theme_color", array("value" => $r["theme_color"], "data" => $colors, "proportion" => "col-6"));

$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => "/nexus/clients/list/" . lpk(), "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Update"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
/** groups * */
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["theme"] . $f->fields["theme_color"])));
/** buttons **/
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
/** build **/
echo($f);
?>