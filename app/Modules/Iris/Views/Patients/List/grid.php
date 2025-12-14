<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-09-14 22:39:33
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Iris\Views\Patients\List\table.php]
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
$mpatients = model('App\Modules\Iris\Models\Iris_Patients');
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/iris";
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 10;
$fields = array(
    "general" => "General",
);
//[build]--------------------------------------------------------------------------------------------------------------
$conditions = array(
    'patient LIKE' => "%{$search}%",
    'fhir_id LIKE' => "%{$search}%",
    'document_number LIKE' => "%{$search}%",
    'first_name LIKE' => "%{$search}%",
    'middle_name LIKE' => "%{$search}%",
    'first_surname LIKE' => "%{$search}%",
    'second_surname LIKE' => "%{$search}%",
    'full_name LIKE' => "%{$search}%",
);
//$mpatients->clear_AllCache();
$rows = $mpatients->get_List($limit, $offset, $search);
$total = $mpatients->getCountAllResults($conditions);
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
    array("content" => lang("Iris.patient"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.fhir_id"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.active"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.document_type"), "class" => "text-center	align-middle"),
    array("content" => lang("Iris.document_number"), "class" => "text-center	align-middle"),
    array("content" => lang("Iris.fullname"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.document_issued_place"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.first_name"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.middle_name"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.first_surname"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.second_surname"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.full_name"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.gender"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.birth_date"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.birth_place"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.marital_status"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.primary_phone"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.secondary_phone"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.email"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.full_address"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.neighborhood"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.city"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.state"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.postal_code"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.country"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.residence_area"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.socioeconomic_stratum"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.emergency_contact_name"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.emergency_contact_relationship"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.emergency_contact_phone"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.health_insurance"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.health_regime"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.affiliation_type"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.ethnicity"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.special_population"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.has_diabetes"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.has_hypertension"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.family_history_glaucoma"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.family_history_diabetes"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.family_history_retinopathy"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.previous_eye_surgeries"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.blood_type"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.allergies"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.current_medications"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.primary_language"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.data_consent"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.accepts_communications"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.profile_photo"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.observations"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.created_by"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.updated_by"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.deleted_by"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.created_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.updated_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("Iris.deleted_at"), "class" => "text-center	align-middle"),
    array("content" => lang("Iris.Options"), "class" => "text-center	align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$component = '/iris/patients';
$count = $offset;
foreach ($rows as $row) {
    if (!empty($row["patient"])) {
        $count++;
        //[links]-------------------------------------------------------------------------------------------------------
        $hrefView = "$component/view/{$row["patient"]}";
        $hrefEdit = "$component/edit/{$row["patient"]}";
        $hrefDelete = "$component/delete/{$row["patient"]}";
        //[buttons]-----------------------------------------------------------------------------------------------------
        $btnView = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_VIEW, "title" => lang("Iris.View"), "href" => $hrefView, "class" => "btn-primary ml-1",));
        $btnEdit = $bootstrap->get_Link("btn-edit", array("size" => "sm", "icon" => ICON_EDIT, "title" => lang("Iris.Edit"), "href" => $hrefEdit, "class" => "btn-warning ml-1",));
        $btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("Iris.Delete"), "href" => $hrefDelete, "class" => "btn-danger ml-1",));
        $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnView . $btnEdit . $btnDelete));
        //[etc]---------------------------------------------------------------------------------------------------------
        $bgrid->add_Row(
            array(
                array("content" => $count, "class" => "text-center align-middle"),
                array("content" => $row['patient'], "class" => "text-left align-middle"),
                //array("content" => $row['fhir_id'], "class" => "text-left align-middle"),
                //array("content" => $row['active'], "class" => "text-left align-middle"),
                //array("content" => $row['document_type'], "class" => "text-left align-middle"),
                array("content" => $row['document_number'], "class" => "text-left align-middle"),
                //array("content" => $row['document_issued_place'], "class" => "text-left align-middle"),
                //array("content" => $row['first_name'], "class" => "text-left align-middle"),
                //array("content" => $row['middle_name'], "class" => "text-left align-middle"),
                //array("content" => $row['first_surname'], "class" => "text-left align-middle"),
                //array("content" => $row['second_surname'], "class" => "text-left align-middle"),
                array("content" => $row['full_name'], "class" => "text-left align-middle"),
                //array("content" => $row['gender'], "class" => "text-left align-middle"),
                //array("content" => $row['birth_date'], "class" => "text-left align-middle"),
                //array("content" => $row['birth_place'], "class" => "text-left align-middle"),
                //array("content" => $row['marital_status'], "class" => "text-left align-middle"),
                //array("content" => $row['primary_phone'], "class" => "text-left align-middle"),
                //array("content" => $row['secondary_phone'], "class" => "text-left align-middle"),
                //array("content" => $row['email'], "class" => "text-left align-middle"),
                //array("content" => $row['full_address'], "class" => "text-left align-middle"),
                //array("content" => $row['neighborhood'], "class" => "text-left align-middle"),
                //array("content" => $row['city'], "class" => "text-left align-middle"),
                //array("content" => $row['state'], "class" => "text-left align-middle"),
                //array("content" => $row['postal_code'], "class" => "text-left align-middle"),
                //array("content" => $row['country'], "class" => "text-left align-middle"),
                //array("content" => $row['residence_area'], "class" => "text-left align-middle"),
                //array("content" => $row['socioeconomic_stratum'], "class" => "text-left align-middle"),
                //array("content" => $row['emergency_contact_name'], "class" => "text-left align-middle"),
                //array("content" => $row['emergency_contact_relationship'], "class" => "text-left align-middle"),
                //array("content" => $row['emergency_contact_phone'], "class" => "text-left align-middle"),
                //array("content" => $row['health_insurance'], "class" => "text-left align-middle"),
                //array("content" => $row['health_regime'], "class" => "text-left align-middle"),
                //array("content" => $row['affiliation_type'], "class" => "text-left align-middle"),
                //array("content" => $row['ethnicity'], "class" => "text-left align-middle"),
                //array("content" => $row['special_population'], "class" => "text-left align-middle"),
                //array("content" => $row['has_diabetes'], "class" => "text-left align-middle"),
                //array("content" => $row['has_hypertension'], "class" => "text-left align-middle"),
                //array("content" => $row['family_history_glaucoma'], "class" => "text-left align-middle"),
                //array("content" => $row['family_history_diabetes'], "class" => "text-left align-middle"),
                //array("content" => $row['family_history_retinopathy'], "class" => "text-left align-middle"),
                //array("content" => $row['previous_eye_surgeries'], "class" => "text-left align-middle"),
                //array("content" => $row['blood_type'], "class" => "text-left align-middle"),
                //array("content" => $row['allergies'], "class" => "text-left align-middle"),
                //array("content" => $row['current_medications'], "class" => "text-left align-middle"),
                //array("content" => $row['primary_language'], "class" => "text-left align-middle"),
                //array("content" => $row['data_consent'], "class" => "text-left align-middle"),
                //array("content" => $row['accepts_communications'], "class" => "text-left align-middle"),
                //array("content" => $row['profile_photo'], "class" => "text-left align-middle"),
                //array("content" => $row['observations'], "class" => "text-left align-middle"),
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
    "header-title" => lang('Iris_Patients.list-title'),
    "header-back" => $back,
    "header-add" => "/iris/patients/create/" . lpk(),
    "alert" => array("icon" => ICON_INFO, "type" => "info", "title" => lang('Iris_Patients.list-title'), "message" => lang('Iris_Patients.list-description')),
    "content" => $bgrid,
));
echo($card);
?>
