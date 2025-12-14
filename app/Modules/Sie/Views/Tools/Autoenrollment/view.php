<?php

$b = service("bootstrap");

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
$mstatuses = model("App\Modules\Sie\Models\Sie_Statuses");
$mexecutions = model("App\Modules\Sie\Models\Sie_Executions");
$mcourses = model('App\Modules\Sie\Models\Sie_Courses');
//[code]----------------------------------------------------------------------------------------------------------------
$limit = $request->getGet("limit") ?? 500;
$offset = (int)($request->getGet("offset") ?? 0);
cache()->clean();
//ENROLLED
//67322CCF14913  TATIANA CUERVO AGUDELO Nuevo desde cero
//66BE8652CA0F0 SIGIFREDO PAZOS SERNA Con materias previas
$student = "67322CCF14913";
$period = "2025A";

$registration = $mreistrations->getRegistration($student);
$last_status = $mstatuses->get_LastStatusEnrolled($student);

//echo(safe_dump($last_status));
$console = array();
if (!empty($last_status)) {
    $console[] = ("> Matricula: " . $student . "");
    $console[] = ("> Periodo: " . $last_status["period"] . " -- del estado");
    $console[] = ("> Estado: " . $last_status["status"] . "-- del estado");
    $console[] = ("> Programa: " . $registration["program"] . " -- del estado");
    $console[] = ("> Malla: " . $last_status["grid"] . " -- del estado");
    $console[] = ("> Versión: " . $last_status["version"] . " -- del estado");
    if ($last_status["period"] == $period) {
        $console[] = "> Acción: Es matriculable!...";
        // Consulto el último programa academico matriculadod el estudiante
        $enrollment = $menrollments->where("registration", $student)->where("period", $period)->first();
        $console[] = "> --- Matricula: " . $enrollment["enrollment"];

        $progresses = $mprogress->get_ProgressByEnrollment($enrollment['enrollment']);

        $console[] = "> --- Progresos (Pensum Estudiante): " . count($progresses);
        $count = 0;
        foreach ($progresses as $progress) {
            $count++;
            $enrollable_program = $registration["program"];
            $enrollable_pensum = $progress["pensum"];
            $module = $mmodules->get_Module($progress["module"]);
            // Consulto el pensum para obteer ciclo y momento
            $pensum = $mpensums->get_Pensum($enrollable_pensum);

            if ($pensum['cycle'] == 1) {
                //$console[] = ("> --------- {$count}.1. Programa Matriculable: " . $enrollable_program . "");
                $console[] = "> --------- {$count}.1. Progreso: " . $progress["progress"] . " - " . $module["name"] . "";
                $console[] = "> --------- {$count}.2. Pensum: " . $enrollable_pensum . " Ciclo: {$pensum['cycle']} Momento: {$pensum['moment']}";


                $status_progress = "PENDING";
                // Se producen dos situaciones
                // 1: Posee notas asiganadas administrativamente
                // 2: Posee notas asignadas por el docente tras cursar la materia
                if ($progress['last_calification'] >= 80) {
                    $status_progress = "QUALIFIED";
                    $status_progress = "CALIFICADO ADMINISTRATIVAMENTE ({$progress['last_calification']})";
                } else {
                    //verifico si tiene notas asignadas por el docente tras cursar la materia
                    $executed = $mexecutions->getLastExecutionbyProgress($progress["progress"]);
                    if (!empty($executed)) {
                        $status_progress = "QUALIFIED";
                        $status_progress = "CALIFICADO POR DOCENTE ({$executed['total']})";
                    }
                }

                if ($status_progress == "PENDING") {
                    // Programa
                    // El ciclo de la persona
                    // Periodo
                    // Jornada

                    $enrollable_cycle = $last_status["cycle"];
                    $enrollable_period = $last_status["period"];
                    $enrollable_journey = $registration["journey"];

                    $console[] = ("> --------- {$count}.3. Ciclo Matriculable: " . $enrollable_cycle . "");
                    $console[] = ("> --------- {$count}.4. Periodo Matriculable: " . $enrollable_period . "");
                    $console[] = ("> --------- {$count}.5. Jornada Matriculable: " . $enrollable_journey . "");
                    // Reviso el listado de cursos disponibles para el módulo en el periodo actual
                    $courses = $mcourses->getCoursesByPensumByJourney($enrollable_pensum, $enrollable_journey);
                    $console[] = ("> --------- {$count}.6. Cursos disponibles: " . count($courses) . "");
                    $courses_count = 0;
                    foreach ($courses as $course) {
                        $courses_count++;
                        $console[] = ("> --------------- {$count}.6.{$courses_count}. Curso: " . $course['course'] . " Jornada: " . $course['journey'] . " Profesor: " . $course['teacher'] . "");
                    }
                }

            }

        }
    } else {
        $console[] = "> Acción: No es matriculable!...";
    }
} else {
    $console[] = "> Matricula: " . $student . "";
    $console[] = "> Acción: No es matriculable no tiene estado de matriculado (normal)!...";
}

$back = "";
$code = "";
$code .= "<div class=\"container p-0\">";
$code .= "<div class=\"terminal\" id=\"terminal\">";
$code .= "<div id=\"output\"></div>";
$code .= "<span class=\"cursor\">▋</span>";
$code .= "</div>";
$code .= "</div>";

$card = $b->get_Card2("create", array(
        "header-title" => "Automatricula",
        "content" => $code,
        "header-back" => $back,
        "footer-class" => "text-end",
        "footer-continue" => $back,
));

echo($card);
?>
<style>
    .terminal {
        background-color: #000;
        color: #ffffff;
        font-family: 'Courier New', Courier, monospace;
        height: 1280px;
        padding: 10px;
        overflow-y: auto;
        border-radius: 5px;
        font-size: 12px;
    }

    .cursor {
        animation: blink 1s infinite;
    }

    @keyframes blink {
        0% {
            opacity: 0;
        }
        50% {
            opacity: 1;
        }
        100% {
            opacity: 0;
        }
    }
</style>


<script>
    // Crear los elementos de audio
    const typeSound = new Audio('/themes/assets/audios/terminal.mp3?v2');
    const completionSound = new Audio('/themes/assets/audios/terminal-student-end.mp3'); // Añade el nuevo sonido

    // Comandos que se mostrarán
    const commands = [
        <?php foreach ($console as $command) : ?>
        '<?php echo $command; ?>',
        <?php endforeach; ?>
    ];

    // Función para escribir texto caracter por caracter
    async function typeText(text) {
        const output = document.getElementById('output');
        for (let char of text) {
            output.innerHTML += char;
            typeSound.play();
            await new Promise(resolve => setTimeout(resolve, 0));
        }
        output.innerHTML += '<br>';
    }

    // Función para ejecutar todos los comandos
    async function executeCommands() {
        for (let command of commands) {
            await typeText(command);
            await new Promise(resolve => setTimeout(resolve, 0));
        }

        // Reproducir sonido de finalización
        completionSound.play();

        // Opcional: Añadir un mensaje de finalización
        const output = document.getElementById('output');
        output.innerHTML += '<span style="color: #00ff00;">Proceso completado ✓</span><br>';
    }

    // Iniciar la simulación cuando se carga la página
    window.onload = executeCommands;
</script>