<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-06-20 06:59:22
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Payments\Creator\form.php]
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
 * █ @link https://www.codehiggs.com
 * █ @Version 1.5.0 @since PHP 7, PHP 8
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ Datos recibidos desde el controlador - @ModuleController
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @var object $parent Trasferido desde el controlador
 * █ @var object $authentication Trasferido desde el controlador
 * █ @var object $request Trasferido desde el controlador
 * █ @var object $dates Trasferido desde el controlador
 * █ @var string $component Trasferido desde el controlador
 * █ @var string $view Trasferido desde el controlador
 * █ @var string $oid Trasferido desde el controlador
 * █ @var string $views Trasferido desde el controlador
 * █ @var string $prefix Trasferido desde el controlador
 * █ @var array $data Trasferido desde el controlador
 * █ @var object $model Modelo de datos utilizado en la vista y trasferido desde el index
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[services]------------------------------------------------------------------------------------------------------------
$b = service("bootstrap");
$f = service("forms", array("lang" => "Sie_Payments."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Sie\Models\Sie_Payments");
//[vars]----------------------------------------------------------------------------------------------------------------
$r["payment"] = $f->get_Value("payment", pk());
$r["record_type"] = $f->get_Value("record_type");
$r["agreement"] = $f->get_Value("agreement");
$r["id_number"] = $f->get_Value("id_number");
$r["ticket"] = $f->get_Value("ticket");
$r["value"] = $f->get_Value("value");
$r["payment_origin"] = $f->get_Value("payment_origin");
$r["payment_methods"] = $f->get_Value("payment_methods");
$r["operation_number"] = $f->get_Value("operation_number");
$r["authorization"] = $f->get_Value("authorization");
$r["financial_entity"] = $f->get_Value("financial_entity");
$r["branch"] = $f->get_Value("branch");
$r["sequence"] = $f->get_Value("sequence");
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");
$r["description"] = $f->get_Value("description");
$back = "/sie/payments/list/" . lpk();
$types = array(
    array("label" => "Seleccione uno", "value" => ""),
    array("label" => "Asobancaria", "value" => "01"),
    array("label" => "Corresponsal", "value" => "02"),
    array("label" => "PSE", "value" => "03"),
    array("label" => "Trasferencia", "value" => "04"),
    array("label" => "Consignación", "value" => "05"),
);

//[fields]----------------------------------------------------------------------------------------------------------------
$f->fields["payment"] = $f->get_FieldText("payment", array("value" => $r["payment"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => "readonly"));
$f->fields["record_type"] = $f->get_FieldText("record_type", array("value" => $r["record_type"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["agreement"] = $f->get_FieldText("agreement", array("value" => $r["agreement"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["id_number"] = $f->get_FieldText("id_number", array("value" => $r["id_number"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ticket"] = $f->get_FieldText("ticket", array("value" => $r["ticket"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["value"] = $f->get_FieldText("value", array("value" => $r["value"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["payment_origin"] = $f->get_FieldSelect("payment_origin", array("selected" => $r["payment_origin"], "data" => $types, "proportion" => "col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12"));


$f->fields["description"] = $f->get_FieldText("description", array("value" => $r["description"], "proportion" => "col-12"));

$f->fields["payment_methods"] = $f->get_FieldText("payment_methods", array("value" => $r["payment_methods"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["operation_number"] = $f->get_FieldText("operation_number", array("value" => $r["operation_number"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["authorization"] = $f->get_FieldText("authorization", array("value" => $r["authorization"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["financial_entity"] = $f->get_FieldText("financial_entity", array("value" => $r["financial_entity"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["branch"] = $f->get_FieldText("branch", array("value" => $r["branch"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["sequence"] = $f->get_FieldText("sequence", array("value" => $r["sequence"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["payment"] . $f->fields["id_number"] . $f->fields["ticket"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["value"] . $f->fields["payment_origin"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["description"])));
//$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["id_number"] . $f->fields["ticket"] . $f->fields["value"])));
//$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["payment_origin"] . $f->fields["payment_methods"] . $f->fields["operation_number"])));
//$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["authorization"] . $f->fields["financial_entity"] . $f->fields["branch"])));
//$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["sequence"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card("create", array(
    "title" => lang("Sie_Payments.create-title"),
    "content" => $f,
    "header-back" => $back
));
echo($card);
?>