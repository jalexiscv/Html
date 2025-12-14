<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\Physicals\Creator\processor.php]
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
$f = service("forms", array("lang" => "Physicals."));
$model = model("App\Modules\C4isr\Models\C4isr_Physicals");
$d = array(
    "physical" => $f->get_Value("physical"),
    "profile" => $f->get_Value("profile"),
    "height" => $f->get_Value("height"),
    "weight" => $f->get_Value("weight"),
    "skin_color" => $f->get_Value("skin_color"),
    "eye_color" => $f->get_Value("eye_color"),
    "eye_shape" => $f->get_Value("eye_shape"),
    "eye_size" => $f->get_Value("eye_size"),
    "hair_color" => $f->get_Value("hair_color"),
    "hair_type" => $f->get_Value("hair_type"),
    "hair_length" => $f->get_Value("hair_length"),
    "face_shape" => $f->get_Value("face_shape"),
    "nose_size_shape" => $f->get_Value("nose_size_shape"),
    "ear_size_shape" => $f->get_Value("ear_size_shape"),
    "lip_size_shape" => $f->get_Value("lip_size_shape"),
    "chin_size_shape" => $f->get_Value("chin_size_shape"),
    "facial_hair_presence_type" => $f->get_Value("facial_hair_presence_type"),
    "eyebrow_presence_type" => $f->get_Value("eyebrow_presence_type"),
    "moles_freckles_birthmarks_presence_location" => $f->get_Value("moles_freckles_birthmarks_presence_location"),
    "scars_presence_location" => $f->get_Value("scars_presence_location"),
    "tattoos_presence_location" => $f->get_Value("tattoos_presence_location"),
    "piercings_presence_location" => $f->get_Value("piercings_presence_location"),
    "interpupillary_distance" => $f->get_Value("interpupillary_distance"),
    "eyes_forehead_distance" => $f->get_Value("eyes_forehead_distance"),
    "nose_mouth_distance" => $f->get_Value("nose_mouth_distance"),
    "shoulder_width" => $f->get_Value("shoulder_width"),
    "arm_length" => $f->get_Value("arm_length"),
    "hand_size_shape" => $f->get_Value("hand_size_shape"),
    "finger_size_shape" => $f->get_Value("finger_size_shape"),
    "nail_size_shape" => $f->get_Value("nail_size_shape"),
    "leg_length" => $f->get_Value("leg_length"),
    "foot_size_shape" => $f->get_Value("foot_size_shape"),
    "author" => $authentication->get_User(),
);
$row = $model->find($d["physical"]);
$l["back"] = "/c4isr/profiles/edit/{$oid}";
$l["edit"] = "/c4isr/physicals/edit/{$d["physical"]}";
if (isset($row["physical"])) {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Physicals.create-duplicate-title"));
    $smarty->assign("message", lang("Physicals.create-duplicate-message"));
    $smarty->assign("continue", $l["back"]);
    $smarty->assign("voice", "c4isr/physicals-create-duplicate-message.mp3");
    $c = $smarty->view('alerts/card/warning.tpl');
} else {
    $create = $model->insert($d);
    //cho($model->getLastQuery()->getQuery());
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Physicals.create-success-title"));
    $smarty->assign("message", sprintf(lang("Physicals.create-success-message"), $d['physical']));
    //$smarty->assign("edit", $l["edit"]);
    $smarty->assign("continue", $l["back"]);
    $smarty->assign("voice", "c4isr/physicals-create-success-message.mp3");
    $c = $smarty->view('alerts/card/success.tpl');
}
echo($c);
?>
