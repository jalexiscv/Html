<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-01-09 06:32:18
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Orders\Editor\form.php]
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
//[services]------------------------------------------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
$f = service("forms", array("lang" => "Sie_Orders."));
//[models]--------------------------------------------------------------------------------------------------------------
$morders = model("App\Modules\Sie\Models\Sie_Orders");
$mprograms = model("App\Modules\Sie\Models\Sie_Programs");
$mproducts = model("App\Modules\Sie\Models\Sie_Products");
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
//[vars]----------------------------------------------------------------------------------------------------------------
/**
 * @var object $authentication Authentication service from the ModuleController.
 * @var object $bootstrap Instance of the Bootstrap class from the ModuleController.
 * @var string $component Complete URI to the requested component.
 * @var object $dates Date service from the ModuleController.
 * @var string $oid String representing the object received, usually an object/data to be viewed, transferred from the ModuleController.
 * @var object $parent Represents the ModuleController.
 * @var object $request Request service from the ModuleController.
 * @var object $strings String service from the ModuleController.
 * @var string $view String passed to the view defined in the viewer for evaluation.
 * @var string $viewer Complete URI to the view responsible for evaluating each requested view.
 * @var string $views Complete URI to the module views.
 **/

$registration = $mregistrations->getRegistration($oid);

$ticketnumber = $morders->getNextTicketNumber();
$period = "2026A";

$start = service("dates")::get_Date();
//$end = $dates->addDaysExact($start, 15);
$end = sie_get_setting("R-E-D");

$r["order"] = $f->get_Value("order", pk());
$r["user"] = $f->get_Value("user", $oid);
$r["ticket"] = $f->get_Value("ticket", $ticketnumber);
$r["parent"] = $f->get_Value("parent");
$r["period"] = $f->get_Value("period", $period);
$r["total"] = $f->get_Value("total");
$r["paid"] = $f->get_Value("paid");
$r["status"] = $f->get_Value("status");
$r["author"] = $f->get_Value("author", safe_get_user());
$r["type"] = $f->get_Value("type");
$r["date"] = $f->get_Value("date", $start);
$r["time"] = $f->get_Value("time", service("dates")::get_Time());
$r["expiration"] = $f->get_Value("expiration", $end);
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");
$r["description"] = $f->get_Value("description", "Matricula Financiera {$period}");
$r["program"] = $f->get_Value("program", @$registration["program"]);
$r["cycle"] = $f->get_Value("cycle", @$registration["cycle"]);
$r["moment"] = $f->get_Value("moment", @$registration["moment"]);

$back = "/sie/students/view/{$oid}#finance";

$programs = array(
    array("value" => "", "label" => "Seleccione un programa"),
);

foreach ($mprograms->get_List(100, 0) as $program) {
    $programs[] = array("value" => $program["program"], "label" => $program["name"]);
}


$cycles = array(
    array("value" => "", "label" => "Seleccione un ciclo"),
);

$cycles = array_merge($cycles, LIST_CYCLES);


$moments = array(
    array("value" => "", "label" => "Seleccione un momento"),
);

$moments = array_merge($moments, LIST_MOMENTS);

//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("back", $back);
$f->fields["order"] = $f->get_FieldText("order", array("value" => $r["order"], "proportion" => "col-md-3 col-sm-12 col-12", "readonly" => "readonly"));
$f->fields["user"] = $f->get_FieldText("user", array("value" => $r["user"], "proportion" => "col-md-3 col-sm-12 col-12", "readonly" => "readonly"));
$f->fields["ticket"] = $f->get_FieldText("ticket", array("value" => $r["ticket"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["parent"] = $f->get_FieldText("parent", array("value" => $r["parent"], "proportion" => "col-md-3 col-sm-12 col-12", "readonly" => "readonly"));
$f->fields["period"] = $f->get_FieldText("period", array("value" => $r["period"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["total"] = $f->get_FieldText("total", array("value" => $r["total"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => "readonly"));
$f->fields["paid"] = $f->get_FieldText("paid", array("value" => $r["paid"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => "readonly"));
$f->fields["status"] = $f->get_FieldText("status", array("value" => $r["status"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => "readonly"));
$f->fields["description"] = $f->get_FieldText("description", array("value" => $r["description"], "proportion" => "col-sm-12 col-12"));
$f->fields["program"] = $f->get_FieldSelect("program", array("selected" => $r["program"], "data" => $programs, "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["cycle"] = $f->get_FieldSelect("cycle", array("selected" => $r["cycle"], "data" => $cycles, "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["moment"] = $f->get_FieldSelect("moment", array("selected" => $r["moment"], "data" => $moments, "proportion" => "col-md-3 col-sm-12 col-12"));


$f->add_HiddenField("author", $r["author"]);
$f->fields["type"] = $f->get_FieldText("type", array("value" => $r["type"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => "readonly"));
$f->fields["date"] = $f->get_FieldText("date", array("value" => $r["date"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["time"] = $f->get_FieldText("time", array("value" => $r["time"], "proportion" => "col-md-3 col-sm-12 col-12", "readonly" => "readonly"));
$f->fields["expiration"] = $f->get_FieldText("expiration", array("value" => $r["expiration"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["order"] . $f->fields["user"] . $f->fields["ticket"] . $f->fields["parent"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["period"] . $f->fields["date"] . $f->fields["time"] . $f->fields["expiration"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["program"] . $f->fields["cycle"] . $f->fields["moment"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["description"])));
//$f->groups["g3"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["paid"].$f->fields["status"])));
//$f->groups["g4"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["type"].$f->fields["total"])));
//$f->groups["g4"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["total"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
//$f->groups["gy"] =$f->get_GroupSeparator();
//$f->groups["gz"] = $f->get_Buttons(array("fields"=>$f->fields["submit"].$f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("create", array(
    "header-title" => lang("Sie_Orders.create-title"),
    "header-back" => $back,
    "content" => $f,
));
echo($card);
$items = $bootstrap->get_Card2("create", array(
    "header-title" => "Productos a facturar",
    "header-add" => array("id" => "add-item", "href" => "#", "onclick" => "addItem();"),
    "header-buttons" => array(
        "btn-enrollment" => array(
            "href" => "#",
            "onclick" => "addItemsEnrollment();",
            "text" => "M",
            "class" => "btn btn-sm btn-secondary",)
    ),
    "content" => view("App\Modules\Sie\Views\Orders\Create\items", array("oid" => $oid)),
));

$discounts = $bootstrap->get_Card2("create", array(
    "header-title" => "Descuentos autorizados",
    "content" => view("App\Modules\Sie\Views\Orders\Create\discounts", array("oid" => $oid)),
));

$fid = $f->get_fid();

echo($items);
echo($discounts);
?>
<?php include("wait.php"); ?>
<?php include("javascripts.php"); ?>
