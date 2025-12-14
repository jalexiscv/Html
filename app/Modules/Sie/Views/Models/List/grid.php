<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-12-12 06:42:06
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Models\List\table.php]
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
//[models]--------------------------------------------------------------------------------------------------------------
$mmodels = model('App\Modules\Sie\Models\Sie_Models');
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/sie";
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 10;
$fields = array(
    //"model" => lang("App.Model"),
    //"code" => lang("App.code"),
    //"name" => lang("App.Name"),
    //"description" => lang("App.description"),
    //"country" => lang("App.country"),
    //"regulatory_framework" => lang("App.regulatory_framework"),
    //"uses_credits" => lang("App.uses_credits"),
    //"hours_per_credit" => lang("App.hours_per_credit"),
    //"credit_calculation_formula" => lang("App.credit_calculation_formula"),
    //"requires_theoretical_hours" => lang("App.requires_theoretical_hours"),
    //"requires_practical_hours" => lang("App.requires_practical_hours"),
    //"requires_independent_hours" => lang("App.requires_independent_hours"),
    //"requires_total_hours" => lang("App.requires_total_hours"),
    //"validation_rules" => lang("App.validation_rules"),
    //"configuration" => lang("App.configuration"),
    //"is_active" => lang("App.is_active"),
    //"created_at" => lang("App.created_at"),
    //"updated_at" => lang("App.updated_at"),
    //"deleted_at" => lang("App.deleted_at"),
);
//[build]--------------------------------------------------------------------------------------------------------------
$conditions = array();
//$mmodels->clear_AllCache();
$rows = $mmodels->getCachedSearch($conditions, $limit, $offset, "model DESC");
$total = $mmodels->getCountAllResults($conditions);
//echo(safe_dump($rows['sql']));
//[build]--------------------------------------------------------------------------------------------------------------
$bgrid = $bootstrap->get_Grid();
$bgrid->set_Total($total);
$bgrid->set_Limit($limit);
$bgrid->set_Offset($offset);
$bgrid->set_Class("P-0 m-0");
$bgrid->set_Limits(array(10, 20, 40, 80, 160, 320, 640, 1200, 2400));
$bgrid->set_Headers(array(
    array("content" => "#", "class" => "text-center	align-middle"),
    array("content" => lang("App.Model"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.code"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Name"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.description"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.country"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.regulatory_framework"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.uses_credits"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.hours_per_credit"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.credit_calculation_formula"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.requires_theoretical_hours"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.requires_practical_hours"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.requires_independent_hours"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.requires_total_hours"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.validation_rules"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.configuration"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.is_active"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.created_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.updated_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.deleted_at"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center	align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$component = '/sie/models';
$count = $offset;
foreach ($rows["data"] as $row) {
    if (!empty($row["model"])) {
        $count++;
        //[links]-------------------------------------------------------------------------------------------------------
        $hrefView = "$component/view/{$row["model"]}";
        $hrefEdit = "$component/edit/{$row["model"]}";
        $hrefDelete = "$component/delete/{$row["model"]}";
        //[buttons]-----------------------------------------------------------------------------------------------------
        $btnView = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_VIEW, "title" => lang("App.View"), "href" => $hrefView, "class" => "btn-primary ml-1",));
        $btnEdit = $bootstrap->get_Link("btn-edit", array("size" => "sm", "icon" => ICON_EDIT, "title" => lang("App.Edit"), "href" => $hrefEdit, "class" => "btn-warning ml-1",));
        $btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("App.Delete"), "href" => $hrefDelete, "class" => "btn-danger ml-1",));
        $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnView . $btnEdit . $btnDelete));
        //[etc]---------------------------------------------------------------------------------------------------------
        $bgrid->add_Row(
            array(
                array("content" => $count, "class" => "text-center align-middle"),
                array("content" => $row['model'], "class" => "text-left align-middle"),
                //array("content" => $row['code'], "class" => "text-left align-middle"),
                array("content" => $row['name'], "class" => "text-left align-middle"),
                //array("content" => $row['description'], "class" => "text-left align-middle"),
                //array("content" => $row['country'], "class" => "text-left align-middle"),
                //array("content" => $row['regulatory_framework'], "class" => "text-left align-middle"),
                //array("content" => $row['uses_credits'], "class" => "text-left align-middle"),
                //array("content" => $row['hours_per_credit'], "class" => "text-left align-middle"),
                //array("content" => $row['credit_calculation_formula'], "class" => "text-left align-middle"),
                //array("content" => $row['requires_theoretical_hours'], "class" => "text-left align-middle"),
                //array("content" => $row['requires_practical_hours'], "class" => "text-left align-middle"),
                //array("content" => $row['requires_independent_hours'], "class" => "text-left align-middle"),
                //array("content" => $row['requires_total_hours'], "class" => "text-left align-middle"),
                //array("content" => $row['validation_rules'], "class" => "text-left align-middle"),
                //array("content" => $row['configuration'], "class" => "text-left align-middle"),
                //array("content" => $row['is_active'], "class" => "text-left align-middle"),
                //array("content" => $row['created_at'], "class" => "text-left align-middle"),
                //array("content" => $row['updated_at'], "class" => "text-left align-middle"),
                //array("content" => $row['deleted_at'], "class" => "text-left align-middle"),
                array("content" => $options, "class" => "text-center align-middle"),
            )
        );
    }
}
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("card-grid", array(
    "header-title" => lang('Sie_Models.list-title'),
    "header-back" => $back,
    "header-add" => "/sie/models/create/" . lpk(),
    "alert" => array("icon" => ICON_INFO, "type" => "info", "title" => lang('Sie_Models.list-title'), "message" => lang('Sie_Models.list-description')),
    "content" => $bgrid,
));
echo($card);
?>