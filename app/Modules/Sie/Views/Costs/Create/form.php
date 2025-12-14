<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-07-03 10:55:53
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Costs\Creator\form.php]
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
$b = service("bootstrap");
$f = service("forms", array("lang" => "Sie_Costs."));
$server = service("server");
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Sie\Models\Sie_Costs");
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
$r["cost"] = $f->get_Value("cost", pk());
$r["program"] = $f->get_Value("program", $oid);
$r["period"] = $f->get_Value("period", "2025B");
$r["value"] = $f->get_Value("value");
$r["currency"] = $f->get_Value("currency");
$r["valid_from"] = $f->get_Value("valid_from");
$r["valid_until"] = $f->get_Value("valid_until");
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");
$back = $f->get_Value("back", $server->get_Referer());

$periods = array(
    array("value" => "2023A", "label" => "2023A"),
    array("value" => "2023B", "label" => "2023B"),
    array("value" => "2024A", "label" => "2024A"),
    array("value" => "2024B", "label" => "2024B"),
    array("value" => "2025A", "label" => "2025A"),
    array("value" => "2025B", "label" => "2025B"),
    array("value" => "2026A", "label" => "2026A"),
    array("value" => "2026B", "label" => "2026B"),
    array("value" => "2027A", "label" => "2027A"),
    array("value" => "2027B", "label" => "2027B"),
    array("value" => "2028A", "label" => "2028A"),
    array("value" => "2028B", "label" => "2028B"),
    array("value" => "2029A", "label" => "2029A"),
    array("value" => "2029B", "label" => "2029B"),
    array("value" => "2030A", "label" => "2030A"),
    array("value" => "2030B", "label" => "2030B"),
    array("value" => "2031A", "label" => "2031A"),
    array("value" => "2031B", "label" => "2031B"),
    array("value" => "2032A", "label" => "2032A"),
    array("value" => "2032B", "label" => "2032B"),
    array("value" => "2033A", "label" => "2033A"),
    array("value" => "2033B", "label" => "2033B"),
    array("value" => "2034A", "label" => "2034A"),
    array("value" => "2034B", "label" => "2034B"),
    array("value" => "2035A", "label" => "2035A"),
    array("value" => "2035B", "label" => "2035B"),
    array("value" => "2036A", "label" => "2036A"),
    array("value" => "2036B", "label" => "2036B"),
    array("value" => "2037A", "label" => "2037A"),
    array("value" => "2037B", "label" => "2037B")
);

//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("back", $back);
$f->fields["cost"] = $f->get_FieldText("cost", array("value" => $r["cost"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["program"] = $f->get_FieldText("program", array("value" => $r["program"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["period"] = $f->get_FieldSelect("period", array("seleted" => $r["period"], "data" => $periods, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["value"] = $f->get_FieldText("value", array("value" => $r["value"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["currency"] = $f->get_FieldSelect("currency", array("selected" => $r["currency"], "data" => LIST_CURRENCIES, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["valid_from"] = $f->get_FieldDate("valid_from", array("value" => $r["valid_from"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["valid_until"] = $f->get_FieldDate("valid_until", array("value" => $r["valid_until"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["cost"] . $f->fields["program"] . $f->fields["period"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["value"] . $f->fields["currency"] . $f->fields["valid_from"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["valid_until"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card2("create", array(
    "header-title" => lang("Sie_Costs.create-title"),
    "content" => $f,
    "header-back" => $back
));
echo($card);
?>