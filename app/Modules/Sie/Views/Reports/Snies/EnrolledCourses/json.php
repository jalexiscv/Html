<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

$dates = service('dates');
//[models]--------------------------------------------------------------------------------------------------------------
$mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');
$mprograms = model('App\Modules\Sie\Models\Sie_Programs');
$mgrids = model('App\Modules\Sie\Models\Sie_Grids');
$mversions = model('App\Modules\Sie\Models\Sie_Versions');
$mpensums = model('App\Modules\Sie\Models\Sie_Pensums');
$menrollments = model('App\Modules\Sie\Models\Sie_Enrollments');
$mprogress = model('App\Modules\Sie\Models\Sie_Progress');
$mexecutions = model('App\Modules\Sie\Models\Sie_Executions');
$mdiscounteds = model('App\Modules\Sie\Models\Sie_Discounteds');
$mdiscounts = model('App\Modules\Sie\Models\Sie_Discounts');
$mstatuses = model('App\Modules\Sie\Models\Sie_Statuses');
$mcosts = model('App\Modules\Sie\Models\Sie_Costs');
$mproducts = model('App\Modules\Sie\Models\Sie_Products');
$mcourses = model("App\Modules\Sie\Models\Sie_Courses");


//[requests]------------------------------------------------------------------------------------------------------------
$registration = isset($_GET['registration']) ? $_GET['registration'] : '';
$program = isset($_GET['program']) ? $_GET['program'] : '';
$period = isset($_GET['period']) ? $_GET['period'] : '';

$enrollment = "";
if (!empty($program)) {
    $enrollment = $menrollments->get_EnrollmentByStudentAndProgram($registration, $program);
    //echo(safe_dump($enrollment));
    $enrollment = @$enrollment["enrollment"];
}

$num_progress = "";//Modulos en la matricula
if (!empty($enrollment)) {
    $progresses = $mprogress->get_ProgressByEnrollment($enrollment);
    $num_progress = count($progresses);
}

$num_materias_inscritas = 0;
$twin = "";
$wincount = 0;
foreach ($progresses as $key => $progress) {
    $exec = $mexecutions->get_ExecutionByProgress($progress["progress"]);
    if (is_array($exec)) {
        $course = $mcourses->get_Course($exec["course"]);
        if (is_array($course) && !empty($course["period"]) && $course["period"] == $period) {
            $num_materias_inscritas++;
            $twin .= "[{$exec["execution"]}] C1=" . $exec["c1"] . " C2=" . $exec["c2"] . " C3=" . $exec["c3"] . " TOTAL=" . $exec["total"] . "</br>";

            // Un curso se considera aprobado SOLO si tiene las TRES calificaciones y todas son >= 80
            // Si falta alguna calificación O si alguna es < 80, el curso está reprobado

            // Verificar que existan las tres calificaciones
            $hasTodas = !empty($exec["c1"]) && !empty($exec["c2"]) && !empty($exec["c3"]);

            // Por defecto, asumimos que está reprobado
            $win = false;

            if ($hasTodas) {
                // Solo si existen las tres calificaciones verificamos si todas son >= 80
                if ($exec["c1"] >= 80 && $exec["c2"] >= 80 && $exec["c3"] >= 80) {
                    $win = true;
                }
            }


            // Si está aprobado, incrementar contador
            if ($win) {
                $wincount++;
            }

        }


    }
}

try {
    $data = array(
        "registration" => $registration,
        "program" => $program,
        "num_materias_inscritas" => $num_materias_inscritas,
        "num_materias_aprobadas" => $wincount,
        "matricula" => "<a href=\"/sie/progress/list/{$enrollment}\" target=\"_blank\">$enrollment</a>",
        "progresos" => $num_progress,
    );
    echo json_encode($data);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error interno del servidor']);
}

?>