<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-01-31 15:52:15
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Standards\Views\Objects\Editor\processor.php]
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
//[Services]-----------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication =service('authentication');
//[services]------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Standards\Models\Standards_Objects");
//[Process]-----------------------------------------------------------------------------
$f = service("forms",array("lang" => "Objects."));
$d = array(
    "object" => $f->get_Value("object"),
    "name" => $f->get_Value("name"),
    "category" => $f->get_Value("category"),
    "parent" => $f->get_Value("parent"),
    "weight" => $f->get_Value("weight"),
    "description" => $f->get_Value("description"),
    "value" => $f->get_Value("value"),
    "evaluation" => $f->get_Value("evaluation"),
    "type_content" => $f->get_Value("type_content"),
    "type_node" => $f->get_Value("type_node"),
    "attachments" => $f->get_Value("attachments"),
);
//[Elements]-----------------------------------------------------------------------------
$row = $model->find($d["object"]);

$container =$f->get_Value("container");

if(!empty($container)){
    $link_back="/standards/objects/list/{$container}"."?parent=" . $container;
}else{
    $link_back="/standards/objects/list/" . lpk();
}






$l["back"]=$link_back;
$l["edit"]="/standards/objects/edit/{$d["object"]}";
$asuccess = "standards/objects-edit-success-message.mp3";
$anoexist = "standards/objects-edit-noexist-message.mp3";
//[build]---------------------------------------------------------------------------------------------------------------
if (is_array($row)) {
   $edit = $model->update($d['object'],$d);
    cache()->clean();
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Standards_Objects.edit-success-title"),
        "text-class" => "text-center",
        "text" => lang("Standards_Objects.edit-success-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
} else {
    $create = $model->insert($d);
    //echo($model->getLastQuery()->getQuery());
    $c = $bootstrap->get_Card("warning", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Standards_Objects.edit-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Standards_Objects.edit-noexist-message"),$d['object']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $anoexist,
    ));
}
echo($c);
cache()->clean();
?>
