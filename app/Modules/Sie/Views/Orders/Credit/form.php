<?php
//[services]------------------------------------------------------------------------------------------------------------
$b = service("bootstrap");
$f = service("forms", array("lang" => "Sie_Orders."));
$request = service("request");
//[models]--------------------------------------------------------------------------------------------------------------
$morders = model("App\Modules\Sie\Models\Sie_Orders");
//[vars]----------------------------------------------------------------------------------------------------------------
$origin = !empty($request->getGet("origin")) ? $request->getGet("origin") : $f->get_Value("origin");
$order = $morders->get_Order($oid);
$r["order"] = $f->get_Value("order", $oid);
$r["installments"] = $f->get_Value("installments");
$r["ticket"] = $f->get_Value("ticket", $order['ticket']);
$r["parent"] = $f->get_Value("parent");
$r["period"] = $f->get_Value("period");
$r["total"] = $f->get_Value("total");
$r["paid"] = $f->get_Value("paid");
$r["status"] = $f->get_Value("status");
$r["author"] = $f->get_Value("author", safe_get_user());
$r["type"] = $f->get_Value("type");
$r["date"] = $f->get_Value("date", service("dates")::get_Date());
$r["time"] = $f->get_Value("time", service("dates")::get_Time());
$r["expiration"] = $f->get_Value("expiration");
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");
$back = "/sie/students/view/{$order['user']}?t=" . lpk() . "#finance";
$installments = array(
    array("value" => "", "label" => "Seleccione una opción"),
    array("value" => "2", "label" => "2"),
    array("value" => "3", "label" => "3"),
);
//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("origin", $origin);
$f->add_HiddenField("author", $r["author"]);
$f->fields["order"] = $f->get_FieldText("order", array("value" => $r["order"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["ticket"] = $f->get_FieldText("ticket", array("value" => $r["ticket"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["installments"] = $f->get_FieldSelect("installments", array("selected" => $r["installments"], "data" => $installments, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["order"] . $f->fields["ticket"] . $f->fields["installments"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card("create", array(
    "title" => "Nota de crédito",
    "content" => $f,
    "header-back" => $back,
    "alert" => array(
        'type' => 'info',
        'title' => lang("Sie_Orders.credit-alert-create-title"),
        'message' => lang("Sie_Orders.credit-alert-create-message")
    ),
));
echo($card);
?>