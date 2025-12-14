<?php

//[Services]-----------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
//[services]------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Sie\Models\Sie_Orders");
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
);
//[Elements]-----------------------------------------------------------------------------
$row = $model->find($d["order"]);
$l["back"] = $f->get_Value("back");
$l["edit"] = "/sie/orders/edit/{$d["order"]}";
$asuccess = "sie/orders-edit-success-message.mp3";
$anoexist = "sie/orders-edit-noexist-message.mp3";
//[build]---------------------------------------------------------------------------------------------------------------
if (is_array($row)) {
    $edit = $model->update($d['order'], $d);
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
    $create = $model->insert($d);
    //echo($model->getLastQuery()->getQuery());
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
?>