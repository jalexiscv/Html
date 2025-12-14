<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-05-01 08:14:05
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Registrations\List\json.php]
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
 * █ @var object $mregistrations Modelo de datos utilizado en la vista y trasferido desde el index
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/

//[Uses]----------------------------------------------------------------------------------------------------------------

//[Services]-------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[Models]---------------------------------------------------------------------------------------------------------------
$mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');
$menrollments = model("App\Modules\Sie\Models\Sie_Enrollments");
$mprograms = model("App\Modules\Sie\Models\Sie_Programs");
//[Requests]------------------------------------------------------------------------------------------------------------
$columns = $request->getGet("columns");
$offset = $request->getGet("offset");
$search = $request->getGet("search");
$draw = empty($request->getGet("draw")) ? 1 : $request->getGet("draw");
$limit = empty($request->getGet("limit")) ? 10 : $request->getGet("limit");
//[Query]---------------------------------------------------------------------------------------------------------------
$list = $mregistrations->get_ListAdmitted($limit, $offset, $search);
$recordsTotal = $mregistrations->get_TotalAdmitted($search);
//$sql=$mregistrations->getLastQuery()->getQuery();
//[Asignations]---------------------------------------------------------------------------------------------------------
$data = array();
$component = '/sie/enrollments';
foreach ($list as $item) {
    //[Query]-----------------------------------------------------------------------------------------------------------
    $enrrollment = $menrollments->get_EnrollmentByStudent($item["registration"]);
    //[Buttons]---------------------------------------------------------------------------------------------------------
    $viewer = "{$component}/view/{$item["registration"]}";
    $editor = "/sie/registrations/edit/{$item["registration"]}";
    $deleter = "{$component}/delete/{$item["registration"]}";
    $billing = "{$component}/billing/{$item["registration"]}";
    $notifier = "{$component}/notify/{$item["registration"]}";
    $scheduler = "{$component}/schedule/{$item["registration"]}";
    $enroll = "{$component}/create/{$item["registration"]}";
    $lviewer = $bootstrap::get_Link('view', array('href' => $viewer, 'icon' => ICON_VIEW, 'text' => lang("App.View"), 'class' => 'btn-primary'));
    $leditor = $bootstrap::get_Link('edit', array('href' => $editor, 'icon' => ICON_EDIT, 'text' => lang("App.Edit"), 'class' => 'btn-secondary', 'target' => '_blank'));
    $ldeleter = $bootstrap::get_Link('delete', array('href' => $deleter, 'icon' => ICON_DELETE, 'text' => lang("App.Delete"), 'class' => 'btn-danger'));
    $lbilling = $bootstrap::get_Link('billing', array('href' => $billing, 'icon' => ICON_BILLING, 'text' => lang("App.Billing"), 'class' => 'btn-info'));
    $lnotifier = $bootstrap::get_Link('notify', array('href' => $notifier, 'icon' => ICON_NOTIFY, 'text' => lang("App.Notify"), 'class' => 'btn-warning'));
    $lscheduler = $bootstrap::get_Link('schedule', array('href' => $scheduler, 'icon' => ICON_SCHEDULE, 'text' => lang("App.Schedule"), 'class' => 'btn-success'));
    if (!$enrrollment) {
        $lenroll = $bootstrap::get_Link('enroll', array('href' => $enroll, 'icon' => ICON_ENROLL, 'text' => lang("App.Enroll"), 'class' => 'btn-success'));
    } else {
        $lenroll = $bootstrap::get_Link('enroll', array('href' => $enroll, 'icon' => ICON_ENROLL, 'text' => lang("App.Enroll"), 'class' => 'btn-success disabled'));
    }
    $options = $bootstrap::get_BtnGroup('options', array('content' => array($lbilling, $lnotifier, $leditor, $lenroll)));

    $statuses = array(
        array("label" => "En proceso", "value" => "PROCESS"),
        array("label" => "Admitido", "value" => "ADMITTED"),
        array("label" => "No admitido", "value" => "UNADMITTED"),
        array("label" => "Admitido proceso homologación", "value" => "HOMOLOGATION"),
        array("label" => "Desiste del proceso", "value" => "DESISTEMENT"),
        array("label" => "Admitido por reingreso", "value" => "RE-ENTRY"),
    );
    $status = $item["status"];
    if ($item["status"] == "PROCESS") {
        $status = "<span class='badge bg-primary'>En proceso</span>";
    } elseif ($item["status"] == "ADMITTED") {
        $status = "<span class='badge bg-success'>Admitido</span>";
    } elseif ($item["status"] == "UNADMITTED") {
        $status = "<span class='badge bg-danger'>No admitido</span>";
    } elseif ($item["status"] == "HOMOLOGATION") {
        $status = "<span class='badge bg-success'>Homologación</span>";
    } elseif ($item["status"] == "DESISTEMENT") {
        $status = "<span class='badge bg-secondary'>Desiste del proceso</span>";
    } elseif ($item["status"] == "RE-ENTRY") {
        $status = "<span class='badge bg-success'>Admitido por reingreso</span>";
    }


    if ($enrrollment) {
        $status .= "<span class='badge bg-warning text-dark'>Matriculado</span>";
    }
    $program = $mprograms->getProgram($item["program"]);
    $fullname = "<b>Estudiante</b>: " . $item["first_name"] . " " . $item["second_name"] . " " . $item["first_surname"] . " " . $item["second_surname"] . "<br>";
    $identity = "<b>Identificación</b>: " . $item["identification_type"] . " " . $item["identification_number"] . "<br>";
    $program_name = "<b>Programa</b>: " . $program["name"] . "<br>";
    $details = $fullname . $identity . $program_name . $status;
    //[Fields]----------------------------------------------------------------------------------------------------------
    $row["registration"] = $item["registration"];
    $row['details'] = $details;
    $row["first_name"] = $item["first_name"];
    $row["second_name"] = $item["second_name"];
    $row["first_surname"] = $item["first_surname"];
    $row["second_surname"] = $item["second_surname"];
    $row["full_name"] = $fullname;
    $row["identification_type"] = $item["identification_type"];
    $row["identification_number"] = $item["identification_number"];
    $row["gender"] = $item["gender"];
    $row["email_address"] = $item["email_address"];
    $row["phone"] = $item["phone"];
    $row["mobile"] = $item["mobile"];
    $row["birth_date"] = $item["birth_date"];
    $row["address"] = $item["address"];
    $row["residence_city"] = $item["residence_city"];
    $row["neighborhood"] = $item["neighborhood"];
    $row["area"] = $item["area"];
    $row["stratum"] = $item["stratum"];
    $row["transport_method"] = $item["transport_method"];
    $row["sisben_group"] = $item["sisben_group"];
    $row["sisben_subgroup"] = $item["sisben_subgroup"];
    $row["document_issue_place"] = $item["document_issue_place"];
    $row["birth_city"] = $item["birth_city"];
    $row["blood_type"] = $item["blood_type"];
    $row["marital_status"] = $item["marital_status"];
    $row["number_children"] = $item["number_children"];
    $row["military_card"] = $item["military_card"];
    $row["ars"] = $item["ars"];
    $row["insurer"] = $item["insurer"];
    $row["eps"] = $item["eps"];
    $row["education_level"] = $item["education_level"];
    $row["occupation"] = $item["occupation"];
    $row["health_regime"] = $item["health_regime"];
    $row["document_issue_date"] = $item["document_issue_date"];
    $row["saber11"] = $item["saber11"];
    $row["status"] = $status;
    $row["created_at"] = $item["created_at"];
    $row["options"] = $options;
    //[Push]------------------------------------------------------------------------------------------------------------
    array_push($data, $row);
}
//[Build]---------------------------------------------------------------------------------------------------------------
$json["draw"] = $draw;
$json["columns"] = $columns;
$json["offset"] = $offset;
$json["search"] = $search;
$json["limit"] = $limit;
//$json["sql"] = $sql;
$json["total"] = $recordsTotal;
$json["data"] = $data;
echo(json_encode($json));
?>