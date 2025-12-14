<?php


//[services]------------------------------------------------------------------------------------------------------------
use App\Libraries\Moodle;

$request = service('request');
//[models]--------------------------------------------------------------------------------------------------------------
$mexecutions = model("App\Modules\Sie\Models\Sie_Executions");
$mcourses = model("App\Modules\Sie\Models\Sie_Courses");
$mprogress = model('App\Modules\Sie\Models\Sie_Progress');
$menrollments = model('App\Modules\Sie\Models\Sie_Enrollments');
$mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');

//[vars]----------------------------------------------------------------------------------------------------------------
$data = [];
$history = [];
$d = [];

$current_year = date('Y');
$current_month = date('n');
$period = $current_year . ($current_month <= 6 ? 'A' : 'B');

// Verificar si la solicitud es de tipo POST
if ($request->getMethod() === 'post') {
    // Obtener todos los datos enviados vía POST
    $postData = $request->getPost();
    //print_r($postData);
    // Almacenar los datos en el vector
    foreach ($postData as $progress => $course) {
        //Debo serciorarme que la asignacion no exista
        $execution = $mexecutions
            ->where("progress", $progress)
            ->where("course", $course)
            ->first();
        if (is_array($execution) && !empty($execution['execution'])) {
            $history[] = "Ya existia la ejecución para el curso {$course} y el progreso {$progress}";
        } else {
            if (strpos($progress, "form_preenrro") === false && strpos($progress, "submited") === false) {
                $history[] = "No existia la ejecución para el curso {$course} y el progreso {$progress}";
                $mexecutions->where("progress", $progress)->delete();
                $d = array(
                    "execution" => pk(),
                    "progress" => $progress,
                    "course" => $course,
                    "period" => $period,
                    "date_start" => safe_get_date(),
                    "date_end" => safe_get_date(),
                    "total" => "0",
                    "author" => "PREMATRICULA",
                );
                $create = $mexecutions->insert($d);

                $course = $mcourses->getCourse($d["course"]);
                $progress = $mprogress->get_Progress($d["progress"]);
                $enrollments = $menrollments->get_Enrollment($progress["enrollment"]);
                $registration = $mregistrations->getRegistration($enrollments["registration"]);


                $moodle = new Moodle();
                $enrollResult = $moodle->enrollUserInCourse(
                    $course["moodle_course"],
                    $registration["identification_number"]
                );

            }
        }
    }
}
$data = array(
    "status" => "success",
    "message" => "Datos guardados correctamente",
    "history" => $history,
    "data-received" => $postData,
    "data-registered" => $d,
);
echo json_encode($data);
?>