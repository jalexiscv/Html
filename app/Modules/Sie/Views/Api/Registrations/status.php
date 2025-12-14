<?php
$request = service("request");
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$mstatuses = model("App\Modules\Sie\Models\Sie_Statuses");
$menrollments = model('App\Modules\Sie\Models\Sie_Enrollments');

$data = $request->getJSON(true);
$type = $data['status_type'] ?? null;
$enrollment_id = $data['status_enrollment'] ?? null;
$program = $data['status_program'] ?? null;
$grid = $data['status_grid'] ?? null;
$version = $data['status_version'] ?? null;
$period = $data['status_period'] ?? null;
$moment = $data['status_moment'] ?? null;
$cycle = $data['status_cycle'] ?? null;
$journey = $data['status_journey'] ?? null;
$degree_certificate = $data['status_degree_certificate'] ?? null;
$degree_folio = $data['status_degree_folio'] ?? null;
$degree_date = $data['status_degree_date'] ?? null;
$degree_diploma = $data['status_degree_diploma'] ?? null;
$degree_book = $data['status_degree_book'] ?? null;
$degree_resolution = $data['status_degree_resolution'] ?? null;
$observation = $data['status_observation'] ?? null;

// Initialize variables to null
$enrollment_value = null;
$enrollment_date_value = null;

if ($type == "GRADUATED" && !empty($enrollment_id)) {
    $enrollment_data = $menrollments->get_Enrollment($enrollment_id);
    if (is_array($enrollment_data)) {
        $program = $enrollment_data['program'] ?? $program;
        $grid = $enrollment_data['grid'] ?? $grid;
        $version = $enrollment_data['version'] ?? $version;
        $journey = $enrollment_data['journey'] ?? $journey;
        
        // Assign values from the fetched data
        $enrollment_value = $enrollment_data['enrollment'] ?? null;
        $enrollment_date_value = $enrollment_data['date'] ?? null;
    }
}

// Validate the degree_date
$validated_degree_date = null;
if (!empty($degree_date)) {
    $d_check = \DateTime::createFromFormat('Y-m-d', $degree_date);
    if ($d_check && $d_check->format('Y-m-d') === $degree_date) {
        $validated_degree_date = $degree_date;
    }
}

$d = array(
    "status" => pk(),
    "registration" => $oid,
    "program" => $program,
    "grid" => $grid,
    "version" => $version,
    "period" => $period,
    "moment" => $moment,
    "cycle" => $cycle,
    "reference" => $type,
    "journey" => $journey,
    "enrollment" => $enrollment_value,
    "enrollment_date" => $enrollment_date_value,
    "degree_certificate" => $degree_certificate,
    "degree_folio" => $degree_folio,
    "degree_date" => $validated_degree_date,
    "degree_diploma" => $degree_diploma,
    "degree_book" => $degree_book,
    "degree_resolution" => $degree_resolution,
    "observation" => $observation,
    "date" => safe_get_date(),
    "time" => safe_get_time(),
    "author" => safe_get_user(),
);

$update = $mstatuses->insert($d);
$sql=$mstatuses->getLastQuery()->getQuery();

if (!empty($d['program'])) {
    $registration = array(
        "registration" => $oid,
        "program" => $d['program'],
    );
    if (!empty($d['journey'])) {
        $registration['journey'] = $d['journey'];
    }
    $mregistrations->update($registration['registration'], $registration);
}

echo(json_encode(array(
    "status" => 200,
    "sql-message" => $update,
    "sql-code"=>$sql,
    "message" => "Estado creado correctamente"
)));
cache()->clean();
?>