<?php


//[vars]----------------------------------------------------------------------------------------------------------------
/** @var object $parent */
/** @var string $component */
/** @var string $view */
/** @var object $authentication */
/** @var object $request */
//[vars]----------------------------------------------------------------------------------------------------------------
$server = service("server");
$bootstrap = service("bootstrap");
$request = service("request");
$version = '';
//exit();
//[models]--------------------------------------------------------------------------------------------------------------
$mreistrations = model('App\Modules\Sie\Models\Sie_Registrations');
$menrollments = model("App\Modules\Sie\Models\Sie_Enrollments");
$mmodules = model('App\Modules\Sie\Models\Sie_Modules');
$mversions = model('App\Modules\Sie\Models\Sie_Versions');
$mpensums = model('App\Modules\Sie\Models\Sie_Pensums');
$mprogress = model('App\Modules\Sie\Models\Sie_Progress');
$mprograms = model("App\Modules\Sie\Models\Sie_Programs");
$mgrids = model("App\Modules\Sie\Models\Sie_Grids");
//[code]----------------------------------------------------------------------------------------------------------------
$limit = $request->getGet("limit") ?? 500;
$offset = (int)($request->getGet("offset") ?? 0);

$search = "";

$code = "<table class=\"table table-bordered table-striped table-hover\">";
$count = 0;

$admitteds = $mreistrations->get_ListAdmitted($limit, $offset, $search);


foreach ($admitteds as $admitted) {
    $count++;
    $student = $admitted['registration'];
    $program = $mprograms->getProgram($admitted["program"]);
    $grid = $mgrids->get_GridByProgram($program["program"]);
    $version = $mversions->get_Active($grid["grid"]);

    $usregistred = $menrollments->get_EnrollmentByStudent($student);
    if (!$usregistred) {


        $enrollment = pk();


        $create = $menrollments->insert(array(
            "enrollment" => $enrollment,
            "registration" => $student,
            "program" => $program["program"],
            "grid" => $grid["grid"],
            "version" => $version["version"],
            "observation" => "Automatico",
            "date" => safe_get_date(),
            "time" => safe_get_time(),
            "author" => safe_get_user(),
        ));

        $code2 = "<br>Matriculado: {$enrollment}";
        $count2 = 0;
        $pensums = $mpensums->where('version', $version["version"])->findAll();
        if (is_array($pensums)) {
            foreach ($pensums as $pensum) {
                $count2++;
                //$code = $pensum["pensum"];
                $module = $pensum["module"];
                $code2 .= " ({$count2}) {$count2}: {$pensum["module"]}";

                $create = $mprogress->insert(array(
                    "progress" => pk(),
                    "enrollment" => $enrollment,
                    "module" => $pensum["module"],
                    "status" => "PENDING",
                    "last_calification" => NULL,
                    "last_course" => NULL,
                    "last_author" => NULL,
                    "last_date" => NULL,
                    "author" => safe_get_user(),
                ));
            }
        }


        $code .= "<tr>";
        $code .= "<td>{$count}</td>";
        $code .= "<td>{$admitted['registration']}</td>";
        $code .= "<td>{$admitted['first_name']} {$admitted['second_name']} {$admitted['first_surname']} {$admitted['second_surname']} {$code2}</td>";
        $code .= "</tr>";
    }
}
$code .= "</table>";

$next = $offset + $limit;
$code .= "<a href=\"/sie/tools/enroller/exe/" . lpk() . "?limit={$limit}&offset={$next}\" class=\"btn btn-primary\">Siguiente</a>";

$card = $bootstrap->get_Card("card-view-Sie", array(
    "class" => "mb-3",
    "title" => lang("Sie.module") . ": <span class='text-muted'></span>",
    "header-back" => "/",
    "image-class" => "img-fluid p-3",
    "content" => $code,
));
echo($card);
?>