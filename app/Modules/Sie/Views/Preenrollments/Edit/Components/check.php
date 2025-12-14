<?php

// Busca el profesor o profesores asignados al modulo
// $progress['module'] es el modulo real desde "sie_modules" 6629B4787E2B2
// Debo buscar el curso en los pensums para obtener los pensums que dan el curso actualmente
// y ver que pensums estan activos con cursos ahora

$pensums = $mpensums->where("module", $progress['module'])->findAll();
//echo("<pre>");
//print_r($pensums);
//echo("</pre>");
// $table .=$progress['module'];
// $table .= implode(",", $pensums);
foreach ($pensums as $pensum) {
    //echo("<pre>");
    //print_r($pensum);
    //echo("</pre>");
    //$table .= "{$pensum['pensum']} : <br>";
    $table .= "<table class=\"table table-bordered m-0\">";
    //echo("{$pensum['module']}<br>");
    // El curso que busco no corresponde al codigo original del curso si no al codigo que el curso asume dentro de su respectivo pensum
    // por lo tanto el codigo del modulo que busco es el codigo del modulo en el pensum respectivo
    //$table.= "<b>Modulo Buscado {$pensum['pensum']}</b>:";
    $courses = $mcourses->get_ByPensum($pensum['pensum']);
    if (!empty($courses)) {
        //echo("<pre>");
        //print_r($courses);
        //echo("</pre>");
        foreach ($courses as $course) {
            // El curso no necesariamente debe ser dado dentro de la misma malla, el error estaba en buscaba el curso solo si se daba dentro de la misma malla
            //if ($course['grid'] == $grid['grid']) {
            $teacher = $mfields->get_Profile($course["teacher"]);
            $program = $mprogams->getProgram($course['program']);
            //$credits = @$course['credits'];
            $table .= "<tr>";
            $table .= "<td>";
            $table .= "{$course['name']} - {$course['period']} <i class=\"opacity-2\">{$course['course']}</i> ";
            $table .= "<br><b>Profesor</b>: {$teacher['name']} <b>Créditos</b>: {$credits}";
            $journey = $course['journey'];
            if ($journey == "JM") {
                $journey = "Mañana";
            } elseif ($journey == "JT") {
                $journey = "Tarde";
            } elseif ($journey == "JN") {
                $journey = "Noche";
            } elseif ($journey == "JS") {
                $journey = "Sabado";
            }
            $table .= "</br><b>Jornada</b>: {$journey} <b>Inicio</b>: {$course['start']} <b>Finalización</b>: {$course['end']}";
            $table .= "</br><b>Descripción</b>: {$course['description']}";
            $table .= "</br><b>Hora de inicio</b>: {$course['start_time']} - <b>Hora de finalización</b>: {$course['end_time']}";
            $table .= "</br><b>Programa</b>: {$program['name']} - <i class=\"opacity-2\">{$course['program']}</i>";
            $table .= "</td>";
            $execution = $mexecutions->where("progress", $progress['progress'])->where("course", $course['course'])->first();
            if (!empty($execution)) {
                $table .= "<td class=\"text-center align-middle\"><input class=\"form-check-input\" type=\"radio\" name=\"{$progress['progress']}\" value=\"" . $course['course'] . "\" data-credits=\"" . $credits . "\" checked></td>";
            } else {
                $table .= "<td class=\"text-center align-middle\"><input class=\"form-check-input\" type=\"radio\" name=\"{$progress['progress']}\" value=\"" . $course['course'] . "\" data-credits=\"" . $credits . "\"></td>";
            }
            $table .= "</tr>";
            //}
        }
    }
    $table .= "</table>";
}
?>