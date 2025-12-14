<?php
/*
* ----------------------------------------------------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\Physicals\Creator\form.php]
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
$f = service("forms", array("lang" => "Physicals."));
//[Requests]------------------------------------------------------------------------------------------------------------
$r["physical"] = $f->get_Value("physical", pk());
$r["profile"] = $f->get_Value("profile", $oid);
$r["height"] = $f->get_Value("height");
$r["weight"] = $f->get_Value("weight");
$r["skin_color"] = $f->get_Value("skin_color");
$r["eye_color"] = $f->get_Value("eye_color");
$r["eye_shape"] = $f->get_Value("eye_shape");
$r["eye_size"] = $f->get_Value("eye_size");
$r["hair_color"] = $f->get_Value("hair_color");
$r["hair_type"] = $f->get_Value("hair_type");
$r["hair_length"] = $f->get_Value("hair_length");
$r["face_shape"] = $f->get_Value("face_shape");
$r["nose_size_shape"] = $f->get_Value("nose_size_shape");
$r["ear_size_shape"] = $f->get_Value("ear_size_shape");
$r["lip_size_shape"] = $f->get_Value("lip_size_shape");
$r["chin_size_shape"] = $f->get_Value("chin_size_shape");
$r["facial_hair_presence_type"] = $f->get_Value("facial_hair_presence_type");
$r["eyebrow_presence_type"] = $f->get_Value("eyebrow_presence_type");
$r["moles_freckles_birthmarks_presence_location"] = $f->get_Value("moles_freckles_birthmarks_presence_location");
$r["scars_presence_location"] = $f->get_Value("scars_presence_location");
$r["tattoos_presence_location"] = $f->get_Value("tattoos_presence_location");
$r["piercings_presence_location"] = $f->get_Value("piercings_presence_location");
$r["interpupillary_distance"] = $f->get_Value("interpupillary_distance");
$r["eyes_forehead_distance"] = $f->get_Value("eyes_forehead_distance");
$r["nose_mouth_distance"] = $f->get_Value("nose_mouth_distance");
$r["shoulder_width"] = $f->get_Value("shoulder_width");
$r["arm_length"] = $f->get_Value("arm_length");
$r["hand_size_shape"] = $f->get_Value("hand_size_shape");
$r["finger_size_shape"] = $f->get_Value("finger_size_shape");
$r["nail_size_shape"] = $f->get_Value("nail_size_shape");
$r["leg_length"] = $f->get_Value("leg_length");
$r["foot_size_shape"] = $f->get_Value("foot_size_shape");
$r["author"] = $f->get_Value("author", $authentication->get_User());
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");
$back = "/c4isr/profiles/edit/{$oid}";
//[Fields]--------------------------------------------------------------------------------------------------------------
$f->fields["physical"] = $f->get_FieldText("physical", array("value" => $r["physical"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["profile"] = $f->get_FieldText("profile", array("value" => $r["profile"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["height"] = $f->get_FieldText("height", array("value" => $r["height"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["weight"] = $f->get_FieldText("weight", array("value" => $r["weight"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["skin_color"] = $f->get_FieldSelect("skin_color", array("selected" => $r["skin_color"], "data" => CONST_HUMAN_SKIN_COLORS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["eye_color"] = $f->get_FieldSelect("eye_color", array("selected" => $r["eye_color"], "data" => CONST_HUMAN_EYE_COLORS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["eye_shape"] = $f->fields["eye_shape"] = $f->get_FieldSelect("eye_shape", array("selected" => $r["eye_shape"], "data" => CONST_HUMAN_EYE_SHAPES, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["eye_size"] = $f->get_FieldSelect("eye_size", array("selected" => $r["eye_size"], "data" => CONST_HUMAN_EYE_SIZES, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["hair_color"] = $f->get_FieldSelect("hair_color", array("selected" => $r["hair_color"], "data" => CONST_HUMAN_HAIR_COLORS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["hair_type"] = $f->get_FieldSelect("hair_type", array("selected" => $r["hair_type"], "data" => CONST_HUMAN_HAIR_TYPES, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["hair_length"] = $f->get_FieldSelect("hair_length", array("selected" => $r["hair_length"], "data" => CONST_HUMAN_HAIR_LENGTHS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["face_shape"] = $f->get_FieldSelect("face_shape", array("selected" => $r["face_shape"], "data" => CONST_HUMAN_FACE_SHAPES, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["nose_size_shape"] = $f->get_FieldSelect("nose_size_shape", array("selected" => $r["nose_size_shape"], "data" => CONST_HUMAN_NOSE_SHAPES, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ear_size_shape"] = $f->get_FieldSelect("ear_size_shape", array("selected" => $r["ear_size_shape"], "data" => CONST_HUMAN_EAR_SHAPES, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["lip_size_shape"] = $f->get_FieldSelect("lip_size_shape", array("selected" => $r["lip_size_shape"], "data" => CONST_HUMAN_LIP_SHAPES, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["chin_size_shape"] = $f->get_FieldSelect("chin_size_shape", array("selected" => $r["chin_size_shape"], "data" => CONST_HUMAN_CHIN_SHAPES, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["facial_hair_presence_type"] = $f->get_FieldSelect("facial_hair_presence_type", array("selected" => $r["facial_hair_presence_type"], "data" => CONST_HUMAN_FACIAL_HAIR_TYPES, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["eyebrow_presence_type"] = $f->get_FieldSelect("eyebrow_presence_type", array("selected" => $r["eyebrow_presence_type"], "data" => CONST_HUMAN_EYEBROW_TYPES, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
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
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[Groups]--------------------------------------------------------------------------------------------------------------
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
$f->groups["g11"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["leg_length"] . $f->fields["foot_size_shape"])));
//[Buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[Build]---------------------------------------------------------------------------------------------------------------
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("type", "normal");
$smarty->assign("header", lang("Physicals.create-title"));
$smarty->assign("header_back", $back);
$smarty->assign("body", $f);
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);
echo($smarty->view('components/cards/index.tpl'));
?>
