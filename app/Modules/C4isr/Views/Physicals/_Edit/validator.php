<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\Physicals\Editor\validator.php]
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
$f = service("forms", array("lang" => "Physicals."));
/*
* -----------------------------------------------------------------------------
* [Request]
* -----------------------------------------------------------------------------
*/
$f->set_ValidationRule("physical", "trim|required");
$f->set_ValidationRule("profile", "trim|required");
$f->set_ValidationRule("height", "trim|required");
$f->set_ValidationRule("weight", "trim|required");
$f->set_ValidationRule("skin_color", "trim|required");
$f->set_ValidationRule("eye_color", "trim|required");
$f->set_ValidationRule("eye_shape", "trim|required");
$f->set_ValidationRule("eye_size", "trim|required");
$f->set_ValidationRule("hair_color", "trim|required");
$f->set_ValidationRule("hair_type", "trim|required");
$f->set_ValidationRule("hair_length", "trim|required");
$f->set_ValidationRule("face_shape", "trim|required");
$f->set_ValidationRule("nose_size_shape", "trim|required");
$f->set_ValidationRule("ear_size_shape", "trim|required");
$f->set_ValidationRule("lip_size_shape", "trim|required");
$f->set_ValidationRule("chin_size_shape", "trim|required");
$f->set_ValidationRule("facial_hair_presence_type", "trim|required");
$f->set_ValidationRule("eyebrow_presence_type", "trim|required");
$f->set_ValidationRule("moles_freckles_birthmarks_presence_location", "trim|required");
$f->set_ValidationRule("scars_presence_location", "trim|required");
$f->set_ValidationRule("tattoos_presence_location", "trim|required");
$f->set_ValidationRule("piercings_presence_location", "trim|required");
$f->set_ValidationRule("interpupillary_distance", "trim|required");
$f->set_ValidationRule("eyes_forehead_distance", "trim|required");
$f->set_ValidationRule("nose_mouth_distance", "trim|required");
$f->set_ValidationRule("shoulder_width", "trim|required");
$f->set_ValidationRule("arm_length", "trim|required");
$f->set_ValidationRule("hand_size_shape", "trim|required");
$f->set_ValidationRule("finger_size_shape", "trim|required");
$f->set_ValidationRule("nail_size_shape", "trim|required");
$f->set_ValidationRule("leg_length", "trim|required");
$f->set_ValidationRule("foot_size_shape", "trim|required");
$f->set_ValidationRule("author", "trim|required");
$f->set_ValidationRule("created_at", "trim|required");
$f->set_ValidationRule("updated_at", "trim|required");
$f->set_ValidationRule("deleted_at", "trim|required");
/*
* -----------------------------------------------------------------------------
* [Validation]
* -----------------------------------------------------------------------------
*/
if ($f->run_Validation()) {
    $c = view($component . '\processor', $parent->get_Array());
} else {
    $errors = $f->validation->listErrors();
    $cerrors = service("smarty");
    $cerrors->set_Mode("bs5x");
    $cerrors->assign("title", lang("Physicals.edit-errors-title"));
    $cerrors->assign("message", lang("Physicals.edit-errors-message"));
    $cerrors->assign("errors", $errors);
    $cerrors->assign("continue", null);
    $cerrors->assign("voice", "c4isr/physicals-edit-errors-message.mp3");
    $c = $cerrors->view('alerts/card/errors.tpl');
    $c .= view($component . '\form', $parent->get_Array());
}
/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
echo($c);
?>
