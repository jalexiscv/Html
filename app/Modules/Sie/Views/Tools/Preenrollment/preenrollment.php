<?php

/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2023-12-01 23:19:27
 *  ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 *  ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 *  ** █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 *  ** █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 *  ** █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 *  ** █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 *  ** █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 *  ** █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 *  ** █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 *  ** █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 *  ** █ @link https://www.codehiggs.com
 *  ** █ @Version 1.5.0 @since PHP 7, PHP 8
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ Datos recibidos desde el controlador - @ModuleController
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */
$bootstrap = service("bootstrap");
//[services]------------------------------------------------------------------------------------------------------------
$b = service("bootstrap");
$f = service("forms", array("lang" => "Sie_Registrations."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Sie\Models\Sie_Registrations");
$mprogams = model("App\Modules\Sie\Models\Sie_Programs");
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$mprogress = model("App\Modules\Sie\Models\Sie_Progress");
$mmodules = model("App\Modules\Sie\Models\Sie_Modules");
$menrollments = model("App\Modules\Sie\Models\Sie_Enrollments");
$mpensums = model("App\Modules\Sie\Models\Sie_Pensums");
$mcourses = model('App\Modules\Sie\Models\Sie_Courses');
$musers = model('App\Modules\Sie\Models\Sie_Users');
$mfields = model('App\Modules\Sie\Models\Sie_Users_Fields');
$mversions = model('App\Modules\Sie\Models\Sie_Versions');
$mgrids = model('App\Modules\Sie\Models\Sie_Grids');
$mexecutions = model('App\Modules\Sie\Models\Sie_Executions');
//[vars]----------------------------------------------------------------------------------------------------------------
$identification_number = $f->get_Value("identification_number");//echo($identification_number);
$registration = $mregistrations->getRegistrationByIdentification($identification_number);
$back = "/sie";
$table = "";
if (!empty($registration['registration'])) {
    $enrrollment = $menrollments->get_EnrollmentByStudent($registration['registration']);
    //print_r($enrrollment);
    if (!empty($enrrollment['program'])) {
        $moment_student = $registration['moment'];
        $name = $registration['first_name'] . " " . $registration['second_name'] . " " . $registration['first_surname'] . " " . $registration['second_surname'];
        $program = $mprogams->getProgram($enrrollment['program']);
        $version = $mversions->get_Version($enrrollment['version']);
        $grid = $mgrids->get_Grid(@$version['grid']);
        $grid_name = @$grid['name'];
        $version_reference = @$version['reference'];
        //print_r($enrrollment);
        //exit();
        $progresses = $mprogress->get_ProgressByEnrollment($enrrollment['enrollment']);
        //print_r($progresses);
        $table .= "<b>Estudiante</b>: " . $name . " ({$registration['registration']})<br>";
        $table .= "<b>Programa</b>: " . $program['name'] . " <br><b>Malla</b>:{$grid_name} <b>Versión</b>:{$version_reference} <br>";
        $table .= "<b>Momento Actual</b>: " . $moment_student . "  <b>Jornada</b>: {$registration['journey']}<br>";
        $table .= "<b>Créditos</b>: <span id=\"count-credits\">0</span>/21<br><br>";
        $table .= "<form id=\"preenrrolments\" action=\"\" method=\"post\">";
        $table .= "<table class=\"table table-bordered\">";
        $table .= "<tr>";
        $table .= " <td class=\"text-center align-middle\"><b>Nombre modulo</b></td>";
        //$table .= " <td class=\"text-center align-middle\"><b>ME</b></td>";
        $table .= " <td class=\"text-center align-middle\"><b>MM</b></td>";
        $table .= " <td class=\"text-center align-middle\"><b>Jornada</b></td>";
        //$table .= " <td class=\"text-center align-middle\"><b>Estado</b></td>";
        $table .= "</tr>";
        foreach ($progresses as $progress) {
            $enrollment = $menrollments->get_Enrollment($progress['enrollment']);
            $registration = $mregistrations->getRegistration($enrollment['registration']);

            $module = $mmodules->get_Module($progress['module']);
            $pensum = $mpensums->where("module", $progress['module'])->where("version", $enrollment['version'])->first();
            $moment_module = @$pensum['moment'];//MM

            $credits = @$pensum['credits'];
            $last_calification = "<div class=\"last_calification\"><b>" . $progress['last_calification'] . "</b></div>";
            $module = $mmodules->get_Module($progress['module']);
            $label = "" . $module['name'] . "";
            $content = $label;
            // if($moment_student==$moment_module) {
            $table .= "<tr class=\"\">";
            $table .= "<td class=\"text-center align-middle\">{$content}<br>";
            $table .= "<span class=\"extra-data\">MP-{$progress['progress']} / MB-{$progress['module']}</span></td>";
            //$table .= "<td class=\"text-center align-middle\">{$moment_student}</td>";
            $table .= "<td class=\"text-center align-middle\">{$moment_module}</td>";
            $table .= "<td class=\"text-left align-middle\">";
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
                //$table .= "{$pensum['pensum']} : <br>";
                $table .= "<table class=\"table table-bordered m-0\">";
                //echo("{$pensum['module']}<br>");
                // El curso que busco no corresponde al codigo original del curso si no al codigo que el curso asume dentro de su respectivo pensum
                // por lo tanto el codigo del modulo que busco es el codigo del modulo en el pensum respectivo
                //$table.= "<b>Modulo Buscado {$pensum['pensum']}</b>:";
                $courses = $mcourses->get_ByModule($pensum['pensum']);
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
                        $table .= "{$course['name']}";
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
            $table .= "</td>";
            $table .= "</tr>";
            //}
        }
        $table .= "<tr>";
        $table .= "<td colspan=\"5\" align=\"right\">";
        $table .= "<div class=\"align-right \">";
        $table .= "<a id=\"btn-print\" href=\"#\" class=\"btn btn-danger mx-1\">Imprimir</a>";
        $table .= "<button id=\"btn-continuar\" type=\"button\" class=\"btn btn-primary floa-right\">Continuar</button>";
        $table .= "</div>";
        $table .= "</td>";
        $table .= "</tr>";
        $table .= "</table>";
        $table .= "</form>";
    } else {
        $table .= "Estudiante no matriculado academicamente!";
        $table .= "<div id=\"group_66d251dd6aa5b\" class=\"form-group text-end\">";
        $table .= "<a href=\"/sie/tools/preenrollment/home/update?t=" . lpk() . "\" class=\"btn btn-primary\">Reintentar</a>";
        $table .= "</div>";
    }
} else {
    $table .= "Estudiante no registrado, o error en el documento ingresado!";
    $table .= "<div id=\"group_66d251dd6aa5b\" class=\"form-group text-end\">";
    $table .= "<a href=\"/sie/tools/preenrollment/home/update?t=" . lpk() . "\" class=\"btn btn-primary\">Reintentar</a>";
    $table .= "</div>";

}
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-view-service", array(
        "title" => "Actualización de Prematricula",
        "header-back" => $back,
        "alert" => array(
                "icon" => ICON_INFO,
                "type" => "info",
                "title" => lang('Sie_Preenrollment.info-list-title'),
                "message" => lang('Sie_Preenrollment.info-list-message')
        ),
        "content" => $table,
));
echo($card);
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var radioButtons = document.querySelectorAll('.form-check-input');
        var previousChecked = null;

        document.getElementById('btn-print').addEventListener('click', function () {
            var printContents = document.getElementById('card-view-service').cloneNode(true);
            // Reemplazar inputs radio con elementos visibles
            printContents.querySelectorAll('input[type="radio"]').forEach(function (radio) {
                var span = document.createElement('span');
                span.className = radio.checked ? 'radio-checked' : 'radio-unchecked';
                span.textContent = radio.checked ? 'X ' : ' ';
                span.style.marginRight = '5px';

                var label = radio.nextElementSibling;
                if (label && label.tagName === 'LABEL') {
                    label.parentNode.insertBefore(span, label);
                } else {
                    radio.parentNode.insertBefore(span, radio.nextSibling);
                }
                radio.style.display = 'none';
            });

            var printWindow = window.open('', '_blank');
            if (printWindow) {
                var htmlContent = "<!DOCTYPE html>\r\n"
                    + "<html lang=\"es\">\r\n<head>\r\n    " +
                    "<meta charset=\"UTF-8\">\r\n    " +
                    "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n    " +
                    "<title>Imprimir<\/title>\r\n    " +
                    "<link rel=\"stylesheet\" href=\"https:\/\/intranet.utede.edu.co\/themes\/assets\/libraries\/bootstrap\/5.3.3\/css\/bootstrap.min.css\">\r\n    " +
                    "<style>\r\n        " +
                    "   @media print {\r\n            " +
                    "       .radio-checked, .radio-unchecked {\r\n" +
                    "                -webkit-print-color-adjust: exact;\r\n                " +
                    "               color-adjust: exact;\r\n" +
                    "       }\r\n        }\r\n" +
                    "    <\/style>\r\n" +
                    "    <script>\r\n        " +
                    "       function printAndClose() {\r\n" +
                    "            window.print();\r\n" +
                    "            window.close();\r\n" +
                    "       }\r\n" +
                    "    <\/script>" +
                    "<script>\r\n        " +
                    "   function printAndClose() {\r\n            " +
                    "   window.print();\r\n            " +
                    "   window.close();\r\n        }\r\n    " +
                    "<\/script>\r\n" +
                    "<\/head>\r\n" +
                    "<body onload=\"printAndClose()\">\r\n    " +
                    "   <div id=\"printable-content\">\r\n        " + printContents.innerHTML + "\r\n    <\/div>\r\n" +
                    "<\/body>\r\n" +
                    "<\/html>";
                printWindow.document.write(htmlContent);
                printWindow.document.close();
            } else {
                alert('Por favor, permite las ventanas emergentes para este sitio para poder imprimir.');
            }
        });

        radioButtons.forEach(function (radioButton) {
            radioButton.addEventListener('mousedown', function (event) {
                var name = radioButton.name;
                var value = radioButton.value;
                if (radioButton === previousChecked) {
                    setTimeout(function () {
                        radioButton.checked = false;
                    }, 0);
                    previousChecked = null;
                    event.preventDefault();
                    sendXHR(name, value);
                } else {
                    previousChecked = radioButton;
                }
            });


            radioButton.addEventListener('change', function () {
                var name = radioButton.name;
                var value = radioButton.value;

            });
        });

        function sendXHR(name, value) {
            var timestamp = Math.floor(Date.now() / 1000);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/sie/api/executions/json/change/' + timestamp, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log('Response:', xhr.responseText);
                }
            };
            xhr.send('progress=' + encodeURIComponent(name) + '&course=' + encodeURIComponent(value));
        }

        var btnContinuar = document.getElementById('btn-continuar');
        btnContinuar.addEventListener('click', function () {
            var totalCredits = 0;
            radioButtons.forEach(function (radioButton) {
                if (radioButton.checked) {
                    var credits = parseInt(radioButton.getAttribute('data-credits'), 10);
                    if (!isNaN(credits)) {
                        totalCredits += credits;
                    }
                }
            });
            //alert(totalCredits);
            if (totalCredits <= 21) {
                var timestamp = Math.floor(Date.now() / 1000);
                var form = document.getElementById('preenrrolments');
                var formData = new FormData(form);
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '/sie/api/executions/json/update/' + timestamp, true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        let response = JSON.parse(xhr.responseText);
                        if (response.status === 'success') {
                            alert(response.message);
                            window.location.href = '/sie/tools/preenrollment/home/update?t=' + timestamp;
                        } else {
                            alert(response.message);
                        }
                    }
                };
                xhr.send(formData);
            } else {
                alert("El total de creditos supera el limite permitido");
            }
        });
    });

</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const radioButtons = document.querySelectorAll('input[type="radio"]');
        let ultimaSeleccion = null;

        radioButtons.forEach(radio => {
            radio.addEventListener('click', function (event) {
                if (this === ultimaSeleccion) {
                    this.checked = false;
                    ultimaSeleccion = null;
                } else {
                    ultimaSeleccion = this;
                }
                updateCredits();
            });

        });


        function updateCredits() {
            var totalCredits = 0;
            radioButtons.forEach(function (radioButton) {
                if (radioButton.checked) {
                    totalCredits += parseInt(radioButton.getAttribute('data-credits'), 10);
                }
            });
            document.getElementById('count-credits').textContent = totalCredits;
        }
    });
</script>