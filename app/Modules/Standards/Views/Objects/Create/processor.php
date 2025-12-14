<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-01-31 15:52:13
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Standards\Views\Objects\Creator\processor.php]
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
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication =service('authentication');
//[Models]-----------------------------------------------------------------------------
$f = service("forms",array("lang" => "Objects."));
$model = model("App\Modules\Standards\Models\Standards_Objects");
//[Vars]-----------------------------------------------------------------------------

$container =$f->get_Value("parent");

if(!empty($container)){
    $link_back="/standards/objects/list/{$container}"."?parent=" . $container;
}else{
    $link_back="/standards/objects/list/" . lpk();
}

$attributes=array("object","name","category","parent","attributes");

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

$row = $model->find($d["object"]);
$l["back"]=$link_back;
$l["edit"]="/standards/objects/edit/{$d["object"]}";

$asuccess = "standards/objects-create-success-message.mp3";
$aexist = "standards/objects-create-exist-message.mp3";
if (is_array($row)) {
    $c= $bootstrap->get_Card("duplicate", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Standards_Objects.create-duplicate-title"),
        "text-class" => "text-center",
        "text" => lang("Standards_Objects.create-duplicate-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $aexist,
    ));
} else {
    $create = $model->insert($d);
    //echo($model->getLastQuery()->getQuery());
    cache()->clean();
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Standards_Objects.create-success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Standards_Objects.create-success-message"),$d['object']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" =>$asuccess,
    ));
}
echo($c);
cache()->clean();
?>