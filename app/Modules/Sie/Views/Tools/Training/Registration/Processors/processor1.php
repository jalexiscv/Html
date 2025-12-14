<?php
/** @var string $component * */
/** @var string $parent */
//[Services]------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[Models]--------------------------------------------------------------------------------------------------------------
$f = service("forms", array("lang" => "Sie_Registrations."));
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$menrollments = model("App\Modules\Sie\Models\Sie_Enrollments");
$mprogress = model("App\Modules\Sie\Models\Sie_Progress");
$mpensums = model("App\Modules\Sie\Models\Sie_Pensums");
$mexecutions = model("App\Modules\Sie\Models\Sie_Executions");
//[vars]----------------------------------------------------------------------------------------------------------------

$d = array(
    "registration" => $f->get_Value("registration"),
    "country" => $f->get_Value("country"),
    "region" => $f->get_Value("region"),
    "city" => $f->get_Value("city"),
    "period" => $f->get_Value("period"),
    "journey" => $f->get_Value("journey"),
    "first_name" => $f->get_Value("first_name"),
    "second_name" => $f->get_Value("second_name"),
    "first_surname" => $f->get_Value("first_surname"),
    "second_surname" => $f->get_Value("second_surname"),
    "identification_type" => $f->get_Value("identification_type"),
    "identification_number" => $f->get_Value("identification_number"),
    "gender" => $f->get_Value("gender"),
    "email_address" => $f->get_Value("email_address"),
    "phone" => $f->get_Value("phone"),
    "mobile" => $f->get_Value("mobile"),
    "birth_date" => $f->get_Value("birth_date"),
    "birth_city" => $f->get_Value("birth_city"),
    "address" => $f->get_Value("address"),
    "residence_city" => $f->get_Value("residence_city"),
    "neighborhood" => $f->get_Value("neighborhood"),
    "linkage_type" => $f->get_Value("linkage_type"),
);
$row = $mregistrations->getRegistration($d["registration"]);

$l["back"] = "/sie/registrations/list/" . lpk();
$l["edit"] = "/sie/registrations/edit/{$d["registration"]}";

$asuccess = "sie/registrations-create-success-message.mp3";
$aexist = "sie/registrations-create-exist-message.mp3";

if (is_array($row)) {
    $registration = $row["registration"];
    $edit = $mregistrations->update($d['registration'], $d);
    $c = view($component . '\Forms\form2', $parent->get_Array());
} else {
    $create = $mregistrations->insert($d);
    $registration = $d["registration"];
    $c = view($component . '\Forms\form2', $parent->get_Array());
}


$student = $registration;
$program = "66E21333AB555";
$grid = "66F329E3A147F";
$version = "66F32A4BE55F5";

$qenrollment = $menrollments->withDeleted()->where("registration", $student)->where("program", $program)->where("grid", $grid)->where("version", $version)->first();
if (!is_array($qenrollment) || !isset($qenrollment['enrollment']) || empty($qenrollment['enrollment'])) {
    $denrollment = array(
        "enrollment" => pk(),
        "registration" => $student,
        "program" => $program,
        "grid" => $grid,
        "version" => $version,
        "linkage_type" => $d["linkage_type"],
        "cycle" => "2024B",
        "moment" => "1",
        "headquarter" => "669909839DB4D",
        "journey" => $d["journey"],
        "date" => safe_get_date(),
        "renewal" => $f->get_Value("renewal"),
        "period" => $f->get_Value("period"),
        "observation" => "Auto registro desde el formato de inscripción formacion continua",
        "author" => "SYSTEM",
    );
    $create = $menrollments->insert($denrollment);
    $enrrolment = $denrollment["enrollment"];
} else {
    $enrrolment = $qenrollment["enrollment"];
    $update = $menrollments->update($qenrollment["enrollment"], array("deleted_at" => null));
}

$pensum = $mpensums->get_Pensum($f->get_Value("pensum"));
$dprogress = array(
    "progress" => pk(),
    "enrollment" => $enrrolment,
    "pensum" => $pensum["pensum"],
    "module" => $pensum["module"],
    "status" => "",
    "last_calification" => "0",
    "c1" => "0",
    "c2" => "0",
    "c3" => "0",
    "last_course" => "0",
    "last_author" => "0",
    "last_date" => safe_get_date(),
    "author" => "SYSTEM",
);

$create = $mprogress->insert($dprogress);

$dexecution = array(
    "execution" => pk(),
    "progress" => $dprogress["progress"],
    "course" => $f->get_Value("course"),
    "date_start" => safe_get_date(),
    "date_end" => safe_get_date(),
    "calification_total" => "0",
    "author" => safe_get_user(),
);

$execution = $mexecutions->insert($dexecution);

//print_r($dexecution);

echo($c);
?>