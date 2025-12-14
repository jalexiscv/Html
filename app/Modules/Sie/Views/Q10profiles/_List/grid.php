<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-10-17 01:00:27
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Q10profiles\List\table.php]
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
$mq10profiles = model('App\Modules\Sie\Models\Sie_Q10profiles');
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/sie";
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 10;
$fields = array(
    //"profile" => lang("App.profile"),
    //"reference" => lang("App.reference"),
    //"first_name" => lang("App.first_name"),
    //"last_name" => lang("App.last_name"),
    //"id_number" => lang("App.id_number"),
    //"phone" => lang("App.phone"),
    //"mobile_phone" => lang("App.mobile_phone"),
    //"email" => lang("App.email"),
    //"residence_location" => lang("App.residence_location"),
    //"birth_date" => lang("App.birth_date"),
    //"blood_type" => lang("App.blood_type"),
    //"campus_shift" => lang("App.campus_shift"),
    //"address" => lang("App.address"),
    //"neighborhood" => lang("App.neighborhood"),
    //"birth_place" => lang("App.birth_place"),
    //"registration_date" => lang("App.registration_date"),
    //"program" => lang("App.program"),
    //"health_provider" => lang("App.health_provider"),
    //"ars_provider" => lang("App.ars_provider"),
    //"insurance_provider" => lang("App.insurance_provider"),
    //"civil_status" => lang("App.civil_status"),
    //"education_level" => lang("App.education_level"),
    //"institution" => lang("App.institution"),
    //"municipality" => lang("App.municipality"),
    //"academic_level" => lang("App.academic_level"),
    //"graduated" => lang("App.graduated"),
    //"degree_earned" => lang("App.degree_earned"),
    //"graduation_date" => lang("App.graduation_date"),
    //"family_member_full_name" => lang("App.family_member_full_name"),
    //"family_member_id_number" => lang("App.family_member_id_number"),
    //"family_member_phone" => lang("App.family_member_phone"),
    //"family_member_mobile_phone" => lang("App.family_member_mobile_phone"),
    //"family_member_email" => lang("App.family_member_email"),
    //"family_relationship" => lang("App.family_relationship"),
    //"company" => lang("App.company"),
    //"company_municipality" => lang("App.company_municipality"),
    //"job_position" => lang("App.job_position"),
    //"company_phone" => lang("App.company_phone"),
    //"company_address" => lang("App.company_address"),
    //"job_start_date" => lang("App.job_start_date"),
    //"job_end_date" => lang("App.job_end_date"),
    //"source" => lang("App.source"),
    //"print_date" => lang("App.print_date"),
    //"author" => lang("App.author"),
    //"created_at" => lang("App.created_at"),
    //"updated_at" => lang("App.updated_at"),
    //"deleted_at" => lang("App.deleted_at"),
);
//[build]--------------------------------------------------------------------------------------------------------------
$conditions = array();
//$mq10profiles->clear_AllCache();
$rows = $mq10profiles->get_CachedSearch($conditions, $limit, $offset, "file DESC");
$total = $mq10profiles->get_CountAllResults($conditions);
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
    //array("profile" => lang("App.profile"), "class" => "text-center	align-middle"),
    //array("reference" => lang("App.reference"), "class" => "text-center	align-middle"),
    //array("first_name" => lang("App.first_name"), "class" => "text-center	align-middle"),
    //array("last_name" => lang("App.last_name"), "class" => "text-center	align-middle"),
    //array("id_number" => lang("App.id_number"), "class" => "text-center	align-middle"),
    //array("phone" => lang("App.phone"), "class" => "text-center	align-middle"),
    //array("mobile_phone" => lang("App.mobile_phone"), "class" => "text-center	align-middle"),
    //array("email" => lang("App.email"), "class" => "text-center	align-middle"),
    //array("residence_location" => lang("App.residence_location"), "class" => "text-center	align-middle"),
    //array("birth_date" => lang("App.birth_date"), "class" => "text-center	align-middle"),
    //array("blood_type" => lang("App.blood_type"), "class" => "text-center	align-middle"),
    //array("campus_shift" => lang("App.campus_shift"), "class" => "text-center	align-middle"),
    //array("address" => lang("App.address"), "class" => "text-center	align-middle"),
    //array("neighborhood" => lang("App.neighborhood"), "class" => "text-center	align-middle"),
    //array("birth_place" => lang("App.birth_place"), "class" => "text-center	align-middle"),
    //array("registration_date" => lang("App.registration_date"), "class" => "text-center	align-middle"),
    //array("program" => lang("App.program"), "class" => "text-center	align-middle"),
    //array("health_provider" => lang("App.health_provider"), "class" => "text-center	align-middle"),
    //array("ars_provider" => lang("App.ars_provider"), "class" => "text-center	align-middle"),
    //array("insurance_provider" => lang("App.insurance_provider"), "class" => "text-center	align-middle"),
    //array("civil_status" => lang("App.civil_status"), "class" => "text-center	align-middle"),
    //array("education_level" => lang("App.education_level"), "class" => "text-center	align-middle"),
    //array("institution" => lang("App.institution"), "class" => "text-center	align-middle"),
    //array("municipality" => lang("App.municipality"), "class" => "text-center	align-middle"),
    //array("academic_level" => lang("App.academic_level"), "class" => "text-center	align-middle"),
    //array("graduated" => lang("App.graduated"), "class" => "text-center	align-middle"),
    //array("degree_earned" => lang("App.degree_earned"), "class" => "text-center	align-middle"),
    //array("graduation_date" => lang("App.graduation_date"), "class" => "text-center	align-middle"),
    //array("family_member_full_name" => lang("App.family_member_full_name"), "class" => "text-center	align-middle"),
    //array("family_member_id_number" => lang("App.family_member_id_number"), "class" => "text-center	align-middle"),
    //array("family_member_phone" => lang("App.family_member_phone"), "class" => "text-center	align-middle"),
    //array("family_member_mobile_phone" => lang("App.family_member_mobile_phone"), "class" => "text-center	align-middle"),
    //array("family_member_email" => lang("App.family_member_email"), "class" => "text-center	align-middle"),
    //array("family_relationship" => lang("App.family_relationship"), "class" => "text-center	align-middle"),
    //array("company" => lang("App.company"), "class" => "text-center	align-middle"),
    //array("company_municipality" => lang("App.company_municipality"), "class" => "text-center	align-middle"),
    //array("job_position" => lang("App.job_position"), "class" => "text-center	align-middle"),
    //array("company_phone" => lang("App.company_phone"), "class" => "text-center	align-middle"),
    //array("company_address" => lang("App.company_address"), "class" => "text-center	align-middle"),
    //array("job_start_date" => lang("App.job_start_date"), "class" => "text-center	align-middle"),
    //array("job_end_date" => lang("App.job_end_date"), "class" => "text-center	align-middle"),
    //array("source" => lang("App.source"), "class" => "text-center	align-middle"),
    //array("print_date" => lang("App.print_date"), "class" => "text-center	align-middle"),
    //array("author" => lang("App.author"), "class" => "text-center	align-middle"),
    //array("created_at" => lang("App.created_at"), "class" => "text-center	align-middle"),
    //array("updated_at" => lang("App.updated_at"), "class" => "text-center	align-middle"),
    //array("deleted_at" => lang("App.deleted_at"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center	align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$component = '/sie/q10profiles';
$count = $offset;
foreach ($rows["data"] as $row) {
    if (!empty($row['file'])) {
        $count++;
        //[links]-------------------------------------------------------------------------------------------------------
        $hrefView = "/$component/view/{$row["profile"]}";
        $hrefEdit = "/$component/edit/{$row["profile"]}";
        $hrefDelete = "/$component/delete/{$row["profile"]}";
        //[buttons]-----------------------------------------------------------------------------------------------------
        $btnView = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_VIEW, "title" => lang("App.View"), "href" => $hrefView, "class" => "btn-sm btn-primary ml-1",));
        $btnEdit = $bootstrap->get_Link("btn-edit", array("size" => "sm", "icon" => ICON_EDIT, "title" => lang("App.Edit"), "href" => $hrefEdit, "class" => "btn-sm btn-warning ml-1",));
        $btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("App.Delete"), "href" => $hrefDelete, "class" => "btn-sm btn-danger ml-1",));
        $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnView . $btnEdit . $btnDelete));
        //[etc]---------------------------------------------------------------------------------------------------------
        $bgrid->add_Row(
            array(
                array("count" => $count, "class" => "text-center align-middle"),
                //array("profile" => $row['profile'], "class" => "text-left align-middle"),
                //array("reference" => $row['reference'], "class" => "text-left align-middle"),
                //array("first_name" => $row['first_name'], "class" => "text-left align-middle"),
                //array("last_name" => $row['last_name'], "class" => "text-left align-middle"),
                //array("id_number" => $row['id_number'], "class" => "text-left align-middle"),
                //array("phone" => $row['phone'], "class" => "text-left align-middle"),
                //array("mobile_phone" => $row['mobile_phone'], "class" => "text-left align-middle"),
                //array("email" => $row['email'], "class" => "text-left align-middle"),
                //array("residence_location" => $row['residence_location'], "class" => "text-left align-middle"),
                //array("birth_date" => $row['birth_date'], "class" => "text-left align-middle"),
                //array("blood_type" => $row['blood_type'], "class" => "text-left align-middle"),
                //array("campus_shift" => $row['campus_shift'], "class" => "text-left align-middle"),
                //array("address" => $row['address'], "class" => "text-left align-middle"),
                //array("neighborhood" => $row['neighborhood'], "class" => "text-left align-middle"),
                //array("birth_place" => $row['birth_place'], "class" => "text-left align-middle"),
                //array("registration_date" => $row['registration_date'], "class" => "text-left align-middle"),
                //array("program" => $row['program'], "class" => "text-left align-middle"),
                //array("health_provider" => $row['health_provider'], "class" => "text-left align-middle"),
                //array("ars_provider" => $row['ars_provider'], "class" => "text-left align-middle"),
                //array("insurance_provider" => $row['insurance_provider'], "class" => "text-left align-middle"),
                //array("civil_status" => $row['civil_status'], "class" => "text-left align-middle"),
                //array("education_level" => $row['education_level'], "class" => "text-left align-middle"),
                //array("institution" => $row['institution'], "class" => "text-left align-middle"),
                //array("municipality" => $row['municipality'], "class" => "text-left align-middle"),
                //array("academic_level" => $row['academic_level'], "class" => "text-left align-middle"),
                //array("graduated" => $row['graduated'], "class" => "text-left align-middle"),
                //array("degree_earned" => $row['degree_earned'], "class" => "text-left align-middle"),
                //array("graduation_date" => $row['graduation_date'], "class" => "text-left align-middle"),
                //array("family_member_full_name" => $row['family_member_full_name'], "class" => "text-left align-middle"),
                //array("family_member_id_number" => $row['family_member_id_number'], "class" => "text-left align-middle"),
                //array("family_member_phone" => $row['family_member_phone'], "class" => "text-left align-middle"),
                //array("family_member_mobile_phone" => $row['family_member_mobile_phone'], "class" => "text-left align-middle"),
                //array("family_member_email" => $row['family_member_email'], "class" => "text-left align-middle"),
                //array("family_relationship" => $row['family_relationship'], "class" => "text-left align-middle"),
                //array("company" => $row['company'], "class" => "text-left align-middle"),
                //array("company_municipality" => $row['company_municipality'], "class" => "text-left align-middle"),
                //array("job_position" => $row['job_position'], "class" => "text-left align-middle"),
                //array("company_phone" => $row['company_phone'], "class" => "text-left align-middle"),
                //array("company_address" => $row['company_address'], "class" => "text-left align-middle"),
                //array("job_start_date" => $row['job_start_date'], "class" => "text-left align-middle"),
                //array("job_end_date" => $row['job_end_date'], "class" => "text-left align-middle"),
                //array("source" => $row['source'], "class" => "text-left align-middle"),
                //array("print_date" => $row['print_date'], "class" => "text-left align-middle"),
                //array("author" => $row['author'], "class" => "text-left align-middle"),
                //array("created_at" => $row['created_at'], "class" => "text-left align-middle"),
                //array("updated_at" => $row['updated_at'], "class" => "text-left align-middle"),
                //array("deleted_at" => $row['deleted_at'], "class" => "text-left align-middle"),
                array("options" => $options, "class" => "text-center align-middle"),
            )
        );
    }
}
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-grid", array(
    "title" => lang('Q10profiles.list-title'),
    "header-back" => $back,
    "header-add" => "/sie/q10files/import/" . lpk(),
    "alert" => array("icon" => ICON_INFO, "type" => "info", "title" => lang('Q10profiles.list-title'), "message" => lang('Q10profiles.list-description')),
    "content" => $bgrid,
));
echo($card);
?>
