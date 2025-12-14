<?php
/*
* ----------------------------------------------------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\Socials\Creator\form.php]
*  ╩ ╩╝╚╝╚═╝╚═╝╩╚═╝╩═╝╚═╝
* ----------------------------------------------------------------------------------------------------------------------
* Copyright 2021 - Higgs Bigdata S.A.S., Inc. <admin@Higgs.com>
* Este archivo es parte de Higgs Bigdata Framework 7.1
* Para obtener información completa sobre derechos de autor y licencia, consulte
* la LICENCIA archivo que se distribuyó con este código fuente.
* ----------------------------------------------------------------------------------------------------------------------
* EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
* IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
* APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
* LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
* RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
* AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
* O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
* ----------------------------------------------------------------------------------------------------------------------
* @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
* @link https://www.Higgs.com
* @Version 1.5.0
* @since PHP 7, PHP 8
* ----------------------------------------------------------------------------------------------------------------------
* Datos recibidos desde el controlador - @ModuleController
* ----------------------------------------------------------------------------------------------------------------------
* @Authentication
* @request
* @dates
* @view
* @oid
* @component
* @views
* @prefix
* @parent
* ----------------------------------------------------------------------------------------------------------------------
*/
$f = service("forms", array("lang" => "Socials."));
//[Requests]------------------------------------------------------------------------------------------------------------
$r["social"] = $f->get_Value("social", pk());
$r["network"] = $f->get_Value("network", "FACEBOOK");
$r["profile"] = $f->get_Value("profile", $oid);
$r["sid"] = $f->get_Value("sid");
$r["alias"] = $f->get_Value("alias");
$r["firstname"] = $f->get_Value("firstname");
$r["lastname"] = $f->get_Value("lastname");
$r["married"] = $f->get_Value("married");
$r["religion"] = $f->get_Value("religion");
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");
$back = "/c4isr/profiles/edit/{$oid}";
$networks = array(
    array("label" => "Facebook", "value" => "FACEBOOK"),
    array("label" => "Twitter", "value" => "TWITTER"),
    array("label" => "Instagram", "value" => "INSTAGRAM"),
    array("label" => "LinkedIn", "value" => "LINKEDIN"),
    array("label" => "Pinterest", "value" => "PINTEREST"),
    array("label" => "Snapchat", "value" => "SNAPCHAT"),
    array("label" => "TikTok", "value" => "TIKTOK"),
    array("label" => "Reddit", "value" => "REDDIT"),
    array("label" => "YouTube", "value" => "YOUTUBE"),
    array("label" => "WhatsApp", "value" => "WHATSAPP"),
    array("label" => "Telegram", "value" => "TELEGRAM"),
    array("label" => "WeChat", "value" => "WECHAT"),
    array("label" => "Viber", "value" => "VIBER"),
    array("label" => "VKontakte (VK)", "value" => "VK"),
    array("label" => "Twitch", "value" => "TWITCH"),
    array("label" => "Tumblr", "value" => "TUMBLR"),
);
//[Fields]--------------------------------------------------------------------------------------------------------------
$f->fields["social"] = $f->get_FieldText("social", array("value" => $r["social"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["profile"] = $f->get_FieldText("profile", array("value" => $r["profile"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["network"] = $f->get_FieldSelect("network", array("selected" => $r["network"], "data" => $networks, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["sid"] = $f->get_FieldText("sid", array("value" => $r["sid"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["alias"] = $f->get_FieldText("alias", array("value" => $r["alias"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["firstname"] = $f->get_FieldText("firstname", array("value" => $r["firstname"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["lastname"] = $f->get_FieldText("lastname", array("value" => $r["lastname"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["married"] = $f->get_FieldText("married", array("value" => $r["married"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["religion"] = $f->get_FieldText("religion", array("value" => $r["religion"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[Groups]--------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["social"] . $f->fields["profile"] . $f->fields["network"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["sid"] . $f->fields["alias"] . $f->fields["firstname"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["lastname"] . $f->fields["married"] . $f->fields["religion"])));
//[Buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[Build]---------------------------------------------------------------------------------------------------------------
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("type", "normal");
$smarty->assign("header", lang("Socials.create-title"));
$smarty->assign("header_back", $back);
$smarty->assign("body", $f);
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);
echo($smarty->view('components/cards/index.tpl'));
?>