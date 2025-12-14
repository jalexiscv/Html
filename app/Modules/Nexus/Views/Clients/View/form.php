<?php

/*
 * -----------------------------------------------------------------------------
 *  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
 *  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK]
 *  ╩ ╩╝╚╝╚═╝╚═╝╩╚═╝╩═╝╚═╝
 * -----------------------------------------------------------------------------
 * Copyright 2021 - Higgs Bigdata S.A.S., Inc. <admin@Higgs.com>
 * Este archivo es parte de Higgs Bigdata Framework 7.1
 * Para obtener información completa sobre derechos de autor y licencia, consulte
 * la LICENCIA archivo que se distribuyó con este código fuente.
 * -----------------------------------------------------------------------------
 * EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 * RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 * AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 * O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 * -----------------------------------------------------------------------------
 * @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * @link https://www.Higgs.com
 * @Version 1.5.0
 * @since PHP 7, PHP 8
 * -----------------------------------------------------------------------------
 * Datos recibidos desde el controlador - @ModuleController
 * -----------------------------------------------------------------------------
 * @Authentication
 * @request
 * @dates
 * @view
 * @oid
 * @component
 * @views
 * @prefix
 * @parent
 * -----------------------------------------------------------------------------
 */

$f = service("forms", array("lang" => "Nexus."));

$model = model("App\Modules\Nexus\Models\Nexus_Clients", true, $conexion);
$r = $model->find($oid);
$r["name"] = urldecode(@$r["name"]);
$r["theme_color"] = $f->get_Value("theme_color", @$r["theme_color"]);
/** fields * */
$f->add_HiddenField("author", @$r["author"]);
$f->fields["client"] = $f->get_FieldText("client", array("value" => @$r["client"], "readonly" => true));
$f->fields["name"] = $f->get_FieldText("name", array("value" => $r["name"]));
$f->fields["domain"] = $f->get_FieldText("domain", array("value" => $r["domain"]));
$f->fields["default_url"] = $f->get_FieldText("default_url", array("value" => $r["default_url"]));
$f->fields["logo"] = $f->get_FieldFile("logo", array("value" => $r["logo"]));
$f->fields["logo_portrait"] = $f->get_FieldFile("logo_portrait", array("value" => $r["logo_portrait"]));
$f->fields["logo_landscape"] = $f->get_FieldFile("logo_landscape", array("logo_landscape" => $r["logo_landscape"]));

$f->fields["db"] = $f->get_FieldText("db", array("value" => $r["db"]));
$f->fields["db_host"] = $f->get_FieldText("db_host", array("value" => $r["db_host"]));
$f->fields["db_port"] = $f->get_FieldText("db_port", array("value" => $r["db_port"]));
$f->fields["db_user"] = $f->get_FieldText("db_user", array("value" => $r["db_user"]));
$f->fields["db_password"] = $f->get_FieldText("db_password", array("value" => $r["db_password"]));

$f->fields["fb_app_id"] = $f->get_FieldText("fb_app_id", array("value" => $r["fb_app_id"]));
$f->fields["fb_app_secret"] = $f->get_FieldText("fb_app_secret", array("value" => $r["fb_app_secret"]));
$f->fields["fb_page"] = $f->get_FieldText("fb_page", array("value" => $r["fb_page"]));

$f->fields["arc_id"] = $f->get_FieldText("arc_id", array("value" => $r["arc_id"]));
$f->fields["matomo"] = $f->get_FieldText("matomo", array("value" => $r["matomo"]));

$f->fields["theme_color"] = $f->get_FieldText("theme_color", array("value" => $r["theme_color"]));

$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => "/nexus/clients/list/" . lpk(), "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Update"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
/** groups * */
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["client"] . $f->fields["name"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["domain"] . $f->fields["default_url"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["logo"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["logo_portrait"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["logo_landscape"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["db"] . $f->fields["db_host"] . $f->fields["db_port"])));
$f->groups["g7"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["db_user"] . $f->fields["db_password"])));
$f->groups["g8"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["theme_color"])));
$f->groups["g9"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["fb_app_id"] . $f->fields["fb_app_secret"] . $f->fields["fb_page"])));
$f->groups["g10"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["arc_id"])));
$f->groups["g11"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["matomo"])));
/** buttons **/
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
/** build **/
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("type", "normal");
$smarty->assign("header", sprintf(lang("Nexus.View-Client"), $r["domain"]));
$smarty->assign("body", $f);
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);
echo($smarty->view('components/cards/index.tpl'));

?>