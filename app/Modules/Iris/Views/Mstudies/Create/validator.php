<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-10-03 06:59:58
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Iris\Views\Mstudies\Creator\validator.php]
* █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
* █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
* █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
* █ ---------------------------------------------------------------------------------------------------------------------
* █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
* █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
* █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
* █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
* █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
* █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
* █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
* █ ---------------------------------------------------------------------------------------------------------------------
* █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
* █ @link https://www.higgs.com.co
* █ @Version 1.5.1 @since PHP 8,PHP 9
* █ ---------------------------------------------------------------------------------------------------------------------
**/
$bootstrap = service('bootstrap');
$f = service("forms",array("lang" => "Iris_Mstudies."));
//[Request]-----------------------------------------------------------------------------
$f->set_ValidationRule("mstudy","trim|required");
$f->set_ValidationRule("loinc_code","trim|required");
$f->set_ValidationRule("short_name","trim|required");
$f->set_ValidationRule("long_name","trim|required");
//$f->set_ValidationRule("common_name","trim|required");
//$f->set_ValidationRule("coding_system","trim|required");
//$f->set_ValidationRule("code_version","trim|required");
//$f->set_ValidationRule("category","trim|required");
//$f->set_ValidationRule("subcategory","trim|required");
//$f->set_ValidationRule("procedure_type","trim|required");
//$f->set_ValidationRule("modality","trim|required");
//$f->set_ValidationRule("cpt_code","trim|required");
//$f->set_ValidationRule("snomed_code","trim|required");
//$f->set_ValidationRule("status","trim|required");
//$f->set_ValidationRule("replaced_by","trim|required");
//$f->set_ValidationRule("patient_instructions","trim|required");
//$f->set_ValidationRule("duration_minutes","trim|required");
//$f->set_ValidationRule("requires_consent","trim|required");
//$f->set_ValidationRule("notes","trim|required");
//$f->set_ValidationRule("created_by","trim|required");
//$f->set_ValidationRule("updated_by","trim|required");
//$f->set_ValidationRule("deleted_by","trim|required");
//$f->set_ValidationRule("created_at","trim|required");
//$f->set_ValidationRule("updated_at","trim|required");
//$f->set_ValidationRule("deleted_at","trim|required");
//[Validation]-----------------------------------------------------------------------------
if ($f->run_Validation()) {
   $c=view($component.'\processor',$parent->get_Array());
}else {
$c =$bootstrap->get_Card('access-denied', array(
    'class'=>'card-danger',
    'icon'=>'fa-duotone fa-triangle-exclamation',
    'text-class' => 'text-center',
    'text' => lang('App.validator-errors-message'),
    'errors' => $f->validation->listErrors(),
    'footer-class'=>'text-center',
    'voice'=>"app/validator-errors-message.mp3",
));
   $c.=view($component.'\form',$parent->get_Array());
}
//[Build]-----------------------------------------------------------------------------
echo($c);
?>
