<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\Physicals\Editor\form.php]
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
//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[Models]-----------------------------------------------------------------------------
//$model = model("App\Modules\C4isr\Models\C4isr_Physicals");
//[Form]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Physicals."));
//[Values]-----------------------------------------------------------------------------
$row = $model->find($oid);
$r["physical"] = $f->get_Value("physical", $row["physical"]);
$r["profile"] = $f->get_Value("profile", $row["profile"]);
$r["height"] = $f->get_Value("height", $row["height"]);
$r["weight"] = $f->get_Value("weight", $row["weight"]);
$r["skin_color"] = $f->get_Value("skin_color", $row["skin_color"]);
$r["eye_color"] = $f->get_Value("eye_color", $row["eye_color"]);
$r["eye_shape"] = $f->get_Value("eye_shape", $row["eye_shape"]);
$r["eye_size"] = $f->get_Value("eye_size", $row["eye_size"]);
$r["hair_color"] = $f->get_Value("hair_color", $row["hair_color"]);
$r["hair_type"] = $f->get_Value("hair_type", $row["hair_type"]);
$r["hair_length"] = $f->get_Value("hair_length", $row["hair_length"]);
$r["face_shape"] = $f->get_Value("face_shape", $row["face_shape"]);
$r["nose_size_shape"] = $f->get_Value("nose_size_shape", $row["nose_size_shape"]);
$r["ear_size_shape"] = $f->get_Value("ear_size_shape", $row["ear_size_shape"]);
$r["lip_size_shape"] = $f->get_Value("lip_size_shape", $row["lip_size_shape"]);
$r["chin_size_shape"] = $f->get_Value("chin_size_shape", $row["chin_size_shape"]);
$r["facial_hair_presence_type"] = $f->get_Value("facial_hair_presence_type", $row["facial_hair_presence_type"]);
$r["eyebrow_presence_type"] = $f->get_Value("eyebrow_presence_type", $row["eyebrow_presence_type"]);
$r["moles_freckles_birthmarks_presence_location"] = $f->get_Value("moles_freckles_birthmarks_presence_location", $row["moles_freckles_birthmarks_presence_location"]);
$r["scars_presence_location"] = $f->get_Value("scars_presence_location", $row["scars_presence_location"]);
$r["tattoos_presence_location"] = $f->get_Value("tattoos_presence_location", $row["tattoos_presence_location"]);
$r["piercings_presence_location"] = $f->get_Value("piercings_presence_location", $row["piercings_presence_location"]);
$r["interpupillary_distance"] = $f->get_Value("interpupillary_distance", $row["interpupillary_distance"]);
$r["eyes_forehead_distance"] = $f->get_Value("eyes_forehead_distance", $row["eyes_forehead_distance"]);
$r["nose_mouth_distance"] = $f->get_Value("nose_mouth_distance", $row["nose_mouth_distance"]);
$r["shoulder_width"] = $f->get_Value("shoulder_width", $row["shoulder_width"]);
$r["arm_length"] = $f->get_Value("arm_length", $row["arm_length"]);
$r["hand_size_shape"] = $f->get_Value("hand_size_shape", $row["hand_size_shape"]);
$r["finger_size_shape"] = $f->get_Value("finger_size_shape", $row["finger_size_shape"]);
$r["nail_size_shape"] = $f->get_Value("nail_size_shape", $row["nail_size_shape"]);
$r["leg_length"] = $f->get_Value("leg_length", $row["leg_length"]);
$r["foot_size_shape"] = $f->get_Value("foot_size_shape", $row["foot_size_shape"]);
$r["author"] = $f->get_Value("author", $authentication->get_User());
$r["created_at"] = $f->get_Value("created_at", $row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", $row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", $row["deleted_at"]);
$back = "/c4isr/physicals/list/" . lpk();
//[Fields]-----------------------------------------------------------------------------
$f->fields["physical"] = $f->get_FieldText("physical", array("value" => $r["physical"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["profile"] = $f->get_FieldText("profile", array("value" => $r["profile"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["height"] = $f->get_FieldText("height", array("value" => $r["height"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["weight"] = $f->get_FieldText("weight", array("value" => $r["weight"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["skin_color"] = $f->get_FieldText("skin_color", array("value" => $r["skin_color"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["eye_color"] = $f->get_FieldText("eye_color", array("value" => $r["eye_color"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["eye_shape"] = $f->get_FieldText("eye_shape", array("value" => $r["eye_shape"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["eye_size"] = $f->get_FieldText("eye_size", array("value" => $r["eye_size"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["hair_color"] = $f->get_FieldText("hair_color", array("value" => $r["hair_color"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["hair_type"] = $f->get_FieldText("hair_type", array("value" => $r["hair_type"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["hair_length"] = $f->get_FieldText("hair_length", array("value" => $r["hair_length"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["face_shape"] = $f->get_FieldText("face_shape", array("value" => $r["face_shape"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["nose_size_shape"] = $f->get_FieldText("nose_size_shape", array("value" => $r["nose_size_shape"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ear_size_shape"] = $f->get_FieldText("ear_size_shape", array("value" => $r["ear_size_shape"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["lip_size_shape"] = $f->get_FieldText("lip_size_shape", array("value" => $r["lip_size_shape"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["chin_size_shape"] = $f->get_FieldText("chin_size_shape", array("value" => $r["chin_size_shape"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["facial_hair_presence_type"] = $f->get_FieldText("facial_hair_presence_type", array("value" => $r["facial_hair_presence_type"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["eyebrow_presence_type"] = $f->get_FieldText("eyebrow_presence_type", array("value" => $r["eyebrow_presence_type"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["moles_freckles_birthmarks_presence_location"] = $f->get_FieldText("moles_freckles_birthmarks_presence_location", array("value" => $r["moles_freckles_birthmarks_presence_location"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["scars_presence_location"] = $f->get_FieldText("scars_presence_location", array("value" => $r["scars_presence_location"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["tattoos_presence_location"] = $f->get_FieldText("tattoos_presence_location", array("value" => $r["tattoos_presence_location"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["piercings_presence_location"] = $f->get_FieldText("piercings_presence_location", array("value" => $r["piercings_presence_location"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["interpupillary_distance"] = $f->get_FieldText("interpupillary_distance", array("value" => $r["interpupillary_distance"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["eyes_forehead_distance"] = $f->get_FieldText("eyes_forehead_distance", array("value" => $r["eyes_forehead_distance"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["nose_mouth_distance"] = $f->get_FieldText("nose_mouth_distance", array("value" => $r["nose_mouth_distance"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["shoulder_width"] = $f->get_FieldText("shoulder_width", array("value" => $r["shoulder_width"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["arm_length"] = $f->get_FieldText("arm_length", array("value" => $r["arm_length"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["hand_size_shape"] = $f->get_FieldText("hand_size_shape", array("value" => $r["hand_size_shape"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["finger_size_shape"] = $f->get_FieldText("finger_size_shape", array("value" => $r["finger_size_shape"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["nail_size_shape"] = $f->get_FieldText("nail_size_shape", array("value" => $r["nail_size_shape"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["leg_length"] = $f->get_FieldText("leg_length", array("value" => $r["leg_length"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["foot_size_shape"] = $f->get_FieldText("foot_size_shape", array("value" => $r["foot_size_shape"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[Groups]-----------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["physical"] . $f->fields["profile"] . $f->fields["height"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["weight"] . $f->fields["skin_color"] . $f->fields["eye_color"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["eye_shape"] . $f->fields["eye_size"] . $f->fields["hair_color"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["hair_type"] . $f->fields["hair_length"] . $f->fields["face_shape"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["nose_size_shape"] . $f->fields["ear_size_shape"] . $f->fields["lip_size_shape"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["chin_size_shape"] . $f->fields["facial_hair_presence_type"] . $f->fields["eyebrow_presence_type"])));
$f->groups["g7"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["moles_freckles_birthmarks_presence_location"] . $f->fields["scars_presence_location"] . $f->fields["tattoos_presence_location"])));
$f->groups["g8"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["piercings_presence_location"] . $f->fields["interpupillary_distance"] . $f->fields["eyes_forehead_distance"])));
$f->groups["g9"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["nose_mouth_distance"] . $f->fields["shoulder_width"] . $f->fields["arm_length"])));
$f->groups["g10"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["hand_size_shape"] . $f->fields["finger_size_shape"] . $f->fields["nail_size_shape"])));
$f->groups["g11"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["leg_length"] . $f->fields["foot_size_shape"] . $f->fields["author"])));
$f->groups["g12"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["created_at"] . $f->fields["updated_at"] . $f->fields["deleted_at"])));
//[Buttons]-----------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[Build]-----------------------------------------------------------------------------

$smarty = service("smarty");
$smarty->set_Mode("bs5x");

$smarty->assign("type", "normal");
$smarty->assign("header", lang("Physicals.edit-title"));
$smarty->assign("header_back", $back);

$smarty->assign("body", $f);
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);
echo($smarty->view('components/cards/index.tpl'));
?>