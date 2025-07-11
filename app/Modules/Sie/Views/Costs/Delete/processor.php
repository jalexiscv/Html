<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-07-03 10:55:56
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Costs\Editor\processor.php]
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
$bootstrap = service('Bootstrap');
$f = service("forms", array("lang" => "Sie_Costs."));
//$model = model("App\Modules\Sie\Models\Sie_Costs");
$pkey= $f->get_Value("pkey");
$row = $model->withDeleted()->find($pkey);
/* Vars */
$l["back"]=$f->get_Value("back");
$l["edit"]="/sie/costs/edit/{$pkey}";
$vsuccess="sie/costs-delete-success-message.mp3";
$vnoexist="sie/costs-delete-noexist-message.mp3";
/* Build */
if (isset($row["cost"])) {
   $delete=$model->delete($pkey);
   
    $c =$bootstrap->get_Card("duplicate", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Costs.delete-success-title"),
        "text-class" => "text-center",
        "text" => lang("Sie_Costs.delete-success-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $vsuccess,
    ));
}else {
    $c =$bootstrap->get_Card("success", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Costs.delete-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Sie_Costs.delete-noexist-message"),$d['cost']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $vnoexist,
    ));
}
echo($c);
cache()->clean();
?>
