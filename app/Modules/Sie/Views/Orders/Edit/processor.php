<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-01-09 06:32:18
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Orders\Editor\processor.php]
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
$authentication = service('authentication');
//[services]------------------------------------------------------------------------------------------------------------
$morders = model("App\Modules\Sie\Models\Sie_Orders");
$mitems = model('App\Modules\Sie\Models\Sie_Orders_Items');
//[Process]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Sie_Orders."));
$d = array(
    "order" => $f->get_Value("order"),
    "user" => $f->get_Value("user"),
    "ticket" => $f->get_Value("ticket"),
    "parent" => $f->get_Value("parent"),
    "period" => $f->get_Value("period"),
    "cycle" => $f->get_Value("cycle"),
    "moment" => $f->get_Value("moment"),
    "total" => $f->get_Value("total"),
    "paid" => $f->get_Value("paid"),
    "status" => $f->get_Value("status"),
    "author" => safe_get_user(),
    "type" => $f->get_Value("type"),
    "date" => $f->get_Value("date"),
    "time" => $f->get_Value("time"),
    "expiration" => $f->get_Value("expiration"),
    "description" => $f->get_Value("description"),
);
//[Elements]-----------------------------------------------------------------------------
$row = $morders->find($d["order"]);
$l["back"] = $f->get_Value("back");
$l["edit"] = "/sie/orders/edit/{$d["order"]}";
$asuccess = "sie/orders-edit-success-message.mp3";
$anoexist = "sie/orders-edit-noexist-message.mp3";
//[build]---------------------------------------------------------------------------------------------------------------
if (is_array($row)) {
    // Debemos evaluar si lo que se esta haciendo es cambiarle la fecha de vencimiento es decir actualizando
    // la fecha de vencimiento y no el registro completo
    $edit = $morders->update($d['order'], $d);


    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Orders.edit-success-title"),
        "text-class" => "text-center",
        "text" => lang("Sie_Orders.edit-success-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
} else {
    $create = $morders->insert($d);
    //echo($morders->getLastQuery()->getQuery());
    $c = $bootstrap->get_Card("warning", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Orders.edit-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Sie_Orders.edit-noexist-message"), $d['order']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $anoexist,
    ));
}
echo($c);
cache()->clean();
?>