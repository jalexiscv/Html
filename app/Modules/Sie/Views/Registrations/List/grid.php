<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-11-19 06:52:59
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Registrations\List\table.php]
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
$mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');
$mprograms = model('App\Modules\Sie\Models\Sie_Programs');
$mfields = model('App\Modules\Sie\Models\Sie_Users_Fields');
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/sie";
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 10;
$fields = array(
    "identification_type" => "Documento de identidad",
);
//[build]--------------------------------------------------------------------------------------------------------------
$conditions = array(
    "period" => "2025A"
);
//$mregistrations->clear_AllCache();
$rows = $mregistrations->get_GridPeriod($limit, $offset, $field, $search);
$total = $mregistrations->get_CountAllResults($conditions);
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
    array("content" => lang("App.Registration"), "class" => "text-center align-middle"),
    //array("content" => lang("App.country"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.region"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.city"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.agreement"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.agreement_country"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.agreement_region"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.agreement_city"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.agreement_institution"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.campus"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.shifts"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.group"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Period"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.journey"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.program"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.first_name"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.second_name"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.first_surname"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.second_surname"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.identification_type"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.identification_number"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.gender"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.email_address"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.phone"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.mobile"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.birth_date"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.birth_country"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.birth_region"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.birth_city"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.address"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.residence_country"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.residence_region"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.residence_city"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.neighborhood"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.area"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.stratum"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.transport_method"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.sisben_group"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.sisben_subgroup"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.document_issue_place"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.blood_type"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.marital_status"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.number_children"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.military_card"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.ars"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.insurer"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.eps"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.education_level"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.occupation"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.health_regime"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.document_issue_date"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.saber11"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.graduation_certificate"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.military_id"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.diploma"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.icfes_certificate"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.utility_bill"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.sisben_certificate"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.address_certificate"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.electoral_certificate"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.photo_card"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.observations"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.status"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.author"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.ticket"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.interview"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.linkage_type"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.ethnic_group"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.indigenous_people"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.afro_descendant"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.disability"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.disability_type"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.exceptional_ability"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.responsible"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.responsible_relationship"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.identified_population_group"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.highlighted_population"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.num_people_depending_on_you"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.num_people_living_with_you"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.responsible_phone"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.num_people_contributing_economically"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.first_in_family_to_study_university"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.border_population"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.observations_academic"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.import"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.moment"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.snies_updated_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.photo"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.created_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.updated_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.deleted_at"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Details"), "class" => "text-left	align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center	align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$component = '/sie/registrations';
$count = $offset;
foreach ($rows as $row) {
    if (!empty($row['registration'])) {
        $count++;
        //[links]-------------------------------------------------------------------------------------------------------
        $viewer = "/sie/students/view/{$row["registration"]}";
        $editor = "{$component}/edit/{$row["registration"]}";
        $deleter = "{$component}/delete/{$row["registration"]}";
        $billing = "{$component}/billing/{$row["registration"]}";
        $notifier = "{$component}/notify/{$row["registration"]}";
        $scheduler = "{$component}/schedule/{$row["registration"]}";
        $lviewer = $bootstrap::get_Link('view', array('href' => $viewer, 'icon' => ICON_VIEW, 'class' => 'btn-primary', "target" => "_blank"));
        $leditor = $bootstrap::get_Link('edit', array('href' => $editor, 'icon' => ICON_EDIT, 'class' => 'btn-secondary'));
        $ldeleter = $bootstrap::get_Link('delete', array('href' => $deleter, 'icon' => ICON_DELETE, 'class' => 'btn-danger'));
        $lbilling = $bootstrap::get_Link('billing', array('href' => $billing, 'icon' => ICON_BILLING, 'class' => 'btn-info'));
        $lnotifier = $bootstrap::get_Link('notify', array('href' => $notifier, 'icon' => ICON_NOTIFY, 'class' => 'btn-warning'));
        $lscheduler = $bootstrap::get_Link('schedule', array('href' => $scheduler, 'icon' => ICON_SCHEDULE, 'class' => 'btn-success'));
        $options = $bootstrap::get_BtnGroup('options', array('content' => array($lviewer, $ldeleter, $lnotifier)));
        //[etc]---------------------------------------------------------------------------------------------------------
        $status = $row["status"];
        if ($row["status"] == "PROCESS") {
            $status = "<span class='badge bg-primary'>En proceso</span>";
        } elseif ($row["status"] == "ADMITTED") {
            $status = "<span class='badge bg-success'>Admitido</span>";
        } elseif ($row["status"] == "UNADMITTED") {
            $status = "<span class='badge bg-danger'>No admitido</span>";
        } elseif ($row["status"] == "HOMOLOGATION") {
            $status = "<span class='badge bg-success'>Homologación</span>";
        } elseif ($row["status"] == "DESISTEMENT") {
            $status = "<span class='badge bg-secondary'>Desiste del proceso</span>";
        } elseif ($row["status"] == "RE-ENTRY") {
            $status = "<span class='badge bg-info'>Admitido por reingreso</span>";
        }
        $program = $mprograms->getProgram($row["program"]);
        $fullname = $row["first_name"] . " " . @$row["second_name"] . " " . $row["first_surname"] . " " . @$row["second_surname"];
        $agreement_name = !empty($row["agreement"]) ? @$row["name"] : "";
        $program_name = @$program['name'];
        $author = $mfields->get_Profile($row["author"]);
        $details = "<b>Nombre</b>: {$fullname}</br>";
        $details .= "<b>Identificación</b>: {$row["identification_type"]} {$row["identification_number"]}</br>";
        $details .= "<b>Programa</b>:{$program_name} - <span class='opacity-25'>{$row["program"]}</span></br>";
        $details .= "<b>Convenio</b>: {$agreement_name}</br>";
        $details .= "<b>Responsable</b>: {$author['name']} - <span class='opacity-25'>{$row["author"]}</span></br>";
        //$details .= $status;

        $bgrid->add_Row(
            array(
                array("content" => $count, "class" => "text-center align-middle"),
                array("content" => $row['registration'], "class" => "text-left align-middle"),
                //array("content" => $row['country'], "class" => "text-left align-middle"),
                //array("content" => $row['region'], "class" => "text-left align-middle"),
                //array("content" => $row['city'], "class" => "text-left align-middle"),
                //array("content" => $row['agreement'], "class" => "text-left align-middle"),
                //array("content" => $row['agreement_country'], "class" => "text-left align-middle"),
                //array("content" => $row['agreement_region'], "class" => "text-left align-middle"),
                //array("content" => $row['agreement_city'], "class" => "text-left align-middle"),
                //array("content" => $row['agreement_institution'], "class" => "text-left align-middle"),
                //array("content" => $row['campus'], "class" => "text-left align-middle"),
                //array("content" => $row['shifts'], "class" => "text-left align-middle"),
                //array("content" => $row['group'], "class" => "text-left align-middle"),
                array("content" => $row['period'], "class" => "text-left align-middle"),
                //array("content" => $row['journey'], "class" => "text-left align-middle"),
                //array("content" => $row['program'], "class" => "text-left align-middle"),
                //array("content" => $row['first_name'], "class" => "text-left align-middle"),
                //array("content" => $row['second_name'], "class" => "text-left align-middle"),
                //array("content" => $row['first_surname'], "class" => "text-left align-middle"),
                //array("content" => $row['second_surname'], "class" => "text-left align-middle"),
                //array("content" => $row['identification_type'], "class" => "text-left align-middle"),
                //array("content" => $row['identification_number'], "class" => "text-left align-middle"),
                //array("content" => $row['gender'], "class" => "text-left align-middle"),
                //array("content" => $row['email_address'], "class" => "text-left align-middle"),
                //array("content" => $row['phone'], "class" => "text-left align-middle"),
                //array("content" => $row['mobile'], "class" => "text-left align-middle"),
                //array("content" => $row['birth_date'], "class" => "text-left align-middle"),
                //array("content" => $row['birth_country'], "class" => "text-left align-middle"),
                //array("content" => $row['birth_region'], "class" => "text-left align-middle"),
                //array("content" => $row['birth_city'], "class" => "text-left align-middle"),
                //array("content" => $row['address'], "class" => "text-left align-middle"),
                //array("content" => $row['residence_country'], "class" => "text-left align-middle"),
                //array("content" => $row['residence_region'], "class" => "text-left align-middle"),
                //array("content" => $row['residence_city'], "class" => "text-left align-middle"),
                //array("content" => $row['neighborhood'], "class" => "text-left align-middle"),
                //array("content" => $row['area'], "class" => "text-left align-middle"),
                //array("content" => $row['stratum'], "class" => "text-left align-middle"),
                //array("content" => $row['transport_method'], "class" => "text-left align-middle"),
                //array("content" => $row['sisben_group'], "class" => "text-left align-middle"),
                //array("content" => $row['sisben_subgroup'], "class" => "text-left align-middle"),
                //array("content" => $row['document_issue_place'], "class" => "text-left align-middle"),
                //array("content" => $row['blood_type'], "class" => "text-left align-middle"),
                //array("content" => $row['marital_status'], "class" => "text-left align-middle"),
                //array("content" => $row['number_children'], "class" => "text-left align-middle"),
                //array("content" => $row['military_card'], "class" => "text-left align-middle"),
                //array("content" => $row['ars'], "class" => "text-left align-middle"),
                //array("content" => $row['insurer'], "class" => "text-left align-middle"),
                //array("content" => $row['eps'], "class" => "text-left align-middle"),
                //array("content" => $row['education_level'], "class" => "text-left align-middle"),
                //array("content" => $row['occupation'], "class" => "text-left align-middle"),
                //array("content" => $row['health_regime'], "class" => "text-left align-middle"),
                //array("content" => $row['document_issue_date'], "class" => "text-left align-middle"),
                //array("content" => $row['saber11'], "class" => "text-left align-middle"),
                //array("content" => $row['graduation_certificate'], "class" => "text-left align-middle"),
                //array("content" => $row['military_id'], "class" => "text-left align-middle"),
                //array("content" => $row['diploma'], "class" => "text-left align-middle"),
                //array("content" => $row['icfes_certificate'], "class" => "text-left align-middle"),
                //array("content" => $row['utility_bill'], "class" => "text-left align-middle"),
                //array("content" => $row['sisben_certificate'], "class" => "text-left align-middle"),
                //array("content" => $row['address_certificate'], "class" => "text-left align-middle"),
                //array("content" => $row['electoral_certificate'], "class" => "text-left align-middle"),
                //array("content" => $row['photo_card'], "class" => "text-left align-middle"),
                //array("content" => $row['observations'], "class" => "text-left align-middle"),
                //array("content" => $row['status'], "class" => "text-left align-middle"),
                //array("content" => $row['author'], "class" => "text-left align-middle"),
                //array("content" => $row['ticket'], "class" => "text-left align-middle"),
                //array("content" => $row['interview'], "class" => "text-left align-middle"),
                //array("content" => $row['linkage_type'], "class" => "text-left align-middle"),
                //array("content" => $row['ethnic_group'], "class" => "text-left align-middle"),
                //array("content" => $row['indigenous_people'], "class" => "text-left align-middle"),
                //array("content" => $row['afro_descendant'], "class" => "text-left align-middle"),
                //array("content" => $row['disability'], "class" => "text-left align-middle"),
                //array("content" => $row['disability_type'], "class" => "text-left align-middle"),
                //array("content" => $row['exceptional_ability'], "class" => "text-left align-middle"),
                //array("content" => $row['responsible'], "class" => "text-left align-middle"),
                //array("content" => $row['responsible_relationship'], "class" => "text-left align-middle"),
                //array("content" => $row['identified_population_group'], "class" => "text-left align-middle"),
                //array("content" => $row['highlighted_population'], "class" => "text-left align-middle"),
                //array("content" => $row['num_people_depending_on_you'], "class" => "text-left align-middle"),
                //array("content" => $row['num_people_living_with_you'], "class" => "text-left align-middle"),
                //array("content" => $row['responsible_phone'], "class" => "text-left align-middle"),
                //array("content" => $row['num_people_contributing_economically'], "class" => "text-left align-middle"),
                //array("content" => $row['first_in_family_to_study_university'], "class" => "text-left align-middle"),
                //array("content" => $row['border_population'], "class" => "text-left align-middle"),
                //array("content" => $row['observations_academic'], "class" => "text-left align-middle"),
                //array("content" => $row['import'], "class" => "text-left align-middle"),
                //array("content" => $row['moment'], "class" => "text-left align-middle"),
                //array("content" => $row['snies_updated_at'], "class" => "text-left align-middle"),
                //array("content" => $row['photo'], "class" => "text-left align-middle"),
                //array("content" => $row['created_at'], "class" => "text-left align-middle"),
                //array("content" => $row['updated_at'], "class" => "text-left align-middle"),
                //array("content" => $row['deleted_at'], "class" => "text-left align-middle"),
                array("content" => $details, "class" => "text-left align-middle"),
                array("content" => $options, "class" => "text-center align-middle"),
            )
        );
    }
}
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-grid", array(
    "title" => lang('Sie_Registrations.list-title'),
    "header-back" => $back,
    "header-add" => "/sie/registrations/create/" . lpk(),
    "alert" => array("icon" => ICON_INFO, "type" => "info", "title" => lang('Sie_Registrations.list-title'), "message" => lang('Sie_Registrations.message-list-description')),
    "content" => $bgrid,
));
echo($card);
?>
