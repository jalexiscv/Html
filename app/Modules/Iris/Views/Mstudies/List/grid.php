<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-10-03 06:59:57
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Iris\Views\Mstudies\List\table.php]
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
$mmstudies = model('App\Modules\Iris\Models\Iris_Mstudies');
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/iris";
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 10;
$fields = array(
    //"mstudy" => lang("App.mstudy"),
    //"loinc_code" => lang("App.loinc_code"),
    //"short_name" => lang("App.short_name"),
    //"long_name" => lang("App.long_name"),
    //"common_name" => lang("App.common_name"),
    //"coding_system" => lang("App.coding_system"),
    //"code_version" => lang("App.code_version"),
    //"category" => lang("App.category"),
    //"subcategory" => lang("App.subcategory"),
    //"procedure_type" => lang("App.procedure_type"),
    //"modality" => lang("App.modality"),
    //"cpt_code" => lang("App.cpt_code"),
    //"snomed_code" => lang("App.snomed_code"),
    //"status" => lang("App.status"),
    //"replaced_by" => lang("App.replaced_by"),
    //"patient_instructions" => lang("App.patient_instructions"),
    //"duration_minutes" => lang("App.duration_minutes"),
    //"requires_consent" => lang("App.requires_consent"),
    //"notes" => lang("App.notes"),
    //"created_by" => lang("App.created_by"),
    //"updated_by" => lang("App.updated_by"),
    //"deleted_by" => lang("App.deleted_by"),
    //"created_at" => lang("App.created_at"),
    //"updated_at" => lang("App.updated_at"),
    //"deleted_at" => lang("App.deleted_at"),
);
//[build]--------------------------------------------------------------------------------------------------------------
$conditions = array();
//$mmstudies->clear_AllCache();
$rows = $mmstudies->getCachedSearch($conditions, $limit, $offset, "mstudy DESC");
$total = $mmstudies->getCountAllResults($conditions);
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
    array("content" => lang("Iris.Mstudy"), "class" => "text-center	align-middle"),
    array("content" => lang("Iris.Loinc_code"), "class" => "text-center	align-middle"),
    array("content" => lang("Iris.Short_name"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.long_name"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.common_name"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.coding_system"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.code_version"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.category"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.subcategory"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.procedure_type"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.modality"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.cpt_code"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.snomed_code"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.status"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.replaced_by"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.patient_instructions"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.duration_minutes"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.requires_consent"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.notes"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.created_by"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.updated_by"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.deleted_by"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.created_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.updated_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.deleted_at"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center	align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$component = '/iris/mstudies';
$count = $offset;
foreach ($rows["data"] as $row) {
    if (!empty($row["mstudy"])) {
        $count++;
        //[links]-------------------------------------------------------------------------------------------------------
        $hrefView = "$component/view/{$row["mstudy"]}";
        $hrefEdit = "$component/edit/{$row["mstudy"]}";
        $hrefDelete = "$component/delete/{$row["mstudy"]}";
        //[buttons]-----------------------------------------------------------------------------------------------------
        $btnView = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_VIEW, "title" => lang("App.View"), "href" => $hrefView, "class" => "btn-primary ml-1",));
        $btnEdit = $bootstrap->get_Link("btn-edit", array("size" => "sm", "icon" => ICON_EDIT, "title" => lang("App.Edit"), "href" => $hrefEdit, "class" => "btn-warning ml-1",));
        $btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("App.Delete"), "href" => $hrefDelete, "class" => "btn-danger ml-1",));
        $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnView . $btnEdit . $btnDelete));
        //[etc]---------------------------------------------------------------------------------------------------------
        $bgrid->add_Row(
            array(
                array("content" => $count, "class" => "text-center align-middle"),
                array("content" => $row['mstudy'], "class" => "text-left align-middle"),
                array("content" => $row['loinc_code'], "class" => "text-left align-middle"),
                array("content" => $row['short_name'], "class" => "text-left align-middle"),
                //array("content" => $row['long_name'], "class" => "text-left align-middle"),
                //array("content" => $row['common_name'], "class" => "text-left align-middle"),
                //array("content" => $row['coding_system'], "class" => "text-left align-middle"),
                //array("content" => $row['code_version'], "class" => "text-left align-middle"),
                //array("content" => $row['category'], "class" => "text-left align-middle"),
                //array("content" => $row['subcategory'], "class" => "text-left align-middle"),
                //array("content" => $row['procedure_type'], "class" => "text-left align-middle"),
                //array("content" => $row['modality'], "class" => "text-left align-middle"),
                //array("content" => $row['cpt_code'], "class" => "text-left align-middle"),
                //array("content" => $row['snomed_code'], "class" => "text-left align-middle"),
                //array("content" => $row['status'], "class" => "text-left align-middle"),
                //array("content" => $row['replaced_by'], "class" => "text-left align-middle"),
                //array("content" => $row['patient_instructions'], "class" => "text-left align-middle"),
                //array("content" => $row['duration_minutes'], "class" => "text-left align-middle"),
                //array("content" => $row['requires_consent'], "class" => "text-left align-middle"),
                //array("content" => $row['notes'], "class" => "text-left align-middle"),
                //array("content" => $row['created_by'], "class" => "text-left align-middle"),
                //array("content" => $row['updated_by'], "class" => "text-left align-middle"),
                //array("content" => $row['deleted_by'], "class" => "text-left align-middle"),
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
    "header-title" => lang('Iris_Mstudies.list-title'),
    "header-back" => $back,
    "header-add" => "/iris/mstudies/create/" . lpk(),
    "alert" => array("icon" => ICON_INFO, "type" => "info", "title" => lang('Iris_Mstudies.list-title'), "message" => lang('Iris_Mstudies.list-description')),
    "content" => $bgrid,
));
echo($card);
?>