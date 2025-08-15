<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                                                    2024-02-12 10:12:28
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Home\breadcrumb.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2024 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                                                                         consulte la LICENCIA archivo que se distribuyó con este código fuente.
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
 * █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[vars]----------------------------------------------------------------------------------------------------------------
/** @var object $parent */
/** @var string $component */
/** @var string $view */
/** @var object $authentication */
/** @var object $request */
//[Services]-------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
//[Models]---------------------------------------------------------------------------------------------------------------
$mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');
$mprograms = model('App\Modules\Sie\Models\Sie_Programs');
$magreements = model('App\Modules\Sie\Models\Sie_Agreements');
$minstitutions = model('App\Modules\Sie\Models\Sie_Institutions');
$mcities = model('App\Modules\Sie\Models\Sie_Cities');
$mcourses = model('App\Modules\Sie\Models\Sie_Courses');
$modules = model('App\Modules\Sie\Models\Sie_Modules');
$versions = model('App\Modules\Sie\Models\Sie_Versions');
$mpensums = model('App\Modules\Sie\Models\Sie_Pensums');
$mexecutions = model('App\Modules\Sie\Models\Sie_Executions');
$mspaces = model('App\Modules\Sie\Models\Sie_Spaces');
$musers = model('App\Modules\Sie\Models\Sie_Users');
$mfields = model('App\Modules\Sie\Models\Sie_Users_Fields');

$period = $_GET['period'];
$option = $_GET['option'] ?? 'VIEW';

$courses = $mcourses->where('period', $period)->findAll();

$code = "";
$code .= " <table\n";
$code .= "\t\t id=\"grid-table\"\n";
$code .= "\t\t class=\"table table-striped table-hover\" \n ";
$code .= "\t\t >\n";
$code .= "<thead>";
$code .= "<tr>\n";
$code .= "<th class=\"text-nowrap\">#</th>\n";
$code .= "<th class=\"text-nowrap\">Curso</th>\n";
$code .= "<th class=\"text-nowrap\">Referencia</th>\n";
$code .= "<th class=\"text-nowrap\">Programa</th>\n";
$code .= "<th class=\"text-nowrap\">Malla</th>\n";
$code .= "<th class=\"text-nowrap\">Versión</th>\n";
$code .= "<th class=\"text-nowrap\">Pensum</th>\n";
$code .= "<th class=\"text-nowrap\">Profesor</th>\n";
$code .= "<th class=\"text-nowrap\">Nombre</th>\n";
$code .= "<th class=\"text-nowrap\">Descripción</th>\n";
$code .= "<th class=\"text-nowrap\">Cupo Máximo</th>\n";
$code .= "<th class=\"text-nowrap\">Inicia</th>\n";
$code .= "<th class=\"text-nowrap\">Termina</th>\n";
$code .= "<th class=\"text-nowrap\">Periodo</th>\n";
$code .= "<th class=\"text-nowrap\">Estado</th>\n";
$code .= "<th class=\"text-nowrap\">Jornada</th>\n";
$code .= "<th class=\"text-nowrap\">Hora Inicio</th>\n";
$code .= "<th class=\"text-nowrap\">Hora Fin</th>\n";
$code .= "<th class=\"text-nowrap\">Precio</th>\n";
$code .= "<th class=\"text-nowrap\">Convenio</th>\n";
$code .= "<th class=\"text-nowrap\">Institución Convenio</th>\n";
$code .= "<th class=\"text-nowrap\">Grupo Convenio</th>\n";
$code .= "<th class=\"text-nowrap\">Curso Moodle</th>\n";
$code .= "<th class=\"text-nowrap\">Ciclo</th>\n";
$code .= "<th class=\"text-nowrap\">Espacio</th>\n";
$code .= "<th class=\"text-nowrap\">Día</th>\n";
$code .= "</tr>\n";
$code .= "</thead>\n";
$code .= "<tbody>\n";
$count = 0;
foreach ($courses as $course) {
    $count++;
    //[defaults]--------------------------------------------------------------------------------------------------------
    $program = $mprograms->getProgram($course['program']);
    $agreement = $magreements->get_Agreement($course['agreement']);
    $institution = $minstitutions->getInstitution($course['agreement_institution']);
    $space = $mspaces->getSpace($course['space']);
    $teacher = $mfields->get_Profile($course['teacher']);

    $agreement_name = mb_strtoupper(@$agreement['name'] ?? '', 'UTF-8');
    $institucion_name = mb_strtoupper(@$institution['name'] ?? '', 'UTF-8');
    $space_name = mb_strtoupper(@$space['name'] ?? '', 'UTF-8');
    $teacher_name = mb_strtoupper(@$teacher['name'] ?? '', 'UTF-8');
    $program_name = mb_strtoupper(@$program['name'] ?? '', 'UTF-8');

    $course_course = mb_strtoupper($course['course'] ?? '', 'UTF-8');
    $course_reference = mb_strtoupper($course['reference'] ?? '', 'UTF-8');
    $course_grid = mb_strtoupper($course['grid'] ?? '', 'UTF-8');
    $course_version = mb_strtoupper($course['version'] ?? '', 'UTF-8');
    $course_pensum = mb_strtoupper($course['pensum'] ?? '', 'UTF-8');
    $course_name = mb_strtoupper($course['name'] ?? '', 'UTF-8');
    $course_description = mb_strtoupper($course['description'] ?? '', 'UTF-8');
    $course_maximum_quota = mb_strtoupper($course['maximum_quota'] ?? '', 'UTF-8');
    $course_start = mb_strtoupper($course['start'] ?? '', 'UTF-8');
    $course_end = mb_strtoupper($course['end'] ?? '', 'UTF-8');
    $course_period = mb_strtoupper($course['period'] ?? '', 'UTF-8');
    $course_status = mb_strtoupper($course['status'] ?? '', 'UTF-8');
    $course_journey = mb_strtoupper($course['journey'] ?? '', 'UTF-8');
    $course_start_time = mb_strtoupper($course['start_time'] ?? '', 'UTF-8');
    $course_end_time = mb_strtoupper($course['end_time'] ?? '', 'UTF-8');
    $course_price = mb_strtoupper($course['price'] ?? '', 'UTF-8');
    $course_agreement_group = mb_strtoupper($course['agreement_group'] ?? '', 'UTF-8');
    $course_moodle_course = mb_strtoupper($course['moodle_course'] ?? '', 'UTF-8');
    $course_cycle = mb_strtoupper($course['cycle'] ?? '', 'UTF-8');
    $course_day = mb_strtoupper($course['day'] ?? '', 'UTF-8');

    $code .= "<tr>";
    $code .= "    <td class=\"text-nowrap\">{$count}</td>";
    $code .= "    <td class=\"text-nowrap\">{$course_course}</td>";
    $code .= "    <td class=\"text-nowrap\">{$course_reference}</td>";
    $code .= "    <td class=\"text-nowrap\">{$program_name}</td>";
    $code .= "    <td class=\"text-nowrap\">{$course_grid}</td>";
    $code .= "    <td class=\"text-nowrap\">{$course_version}</td>";
    $code .= "    <td class=\"text-nowrap\">{$course_pensum}</td>";
    $code .= "    <td class=\"text-nowrap\">{$teacher_name}</td>";
    $code .= "    <td class=\"text-nowrap\">{$course_name}</td>";
    $code .= "    <td class=\"text-nowrap\">{$course_description}</td>";
    $code .= "    <td class=\"text-nowrap\">{$course_maximum_quota}</td>";
    $code .= "    <td class=\"text-nowrap\">{$course_start}</td>";
    $code .= "    <td class=\"text-nowrap\">{$course_end}</td>";
    $code .= "    <td class=\"text-nowrap\">{$course_period}</td>";
    $code .= "    <td class=\"text-nowrap\">{$course_status}</td>";
    $code .= "    <td class=\"text-nowrap\">{$course_journey}</td>";
    $code .= "    <td class=\"text-nowrap\">{$course_start_time}</td>";
    $code .= "    <td class=\"text-nowrap\">{$course_end_time}</td>";
    $code .= "    <td class=\"text-nowrap\">{$course_price}</td>";
    $code .= "    <td class=\"text-nowrap\">{$agreement_name}</td>";
    $code .= "    <td class=\"text-nowrap\">{$institucion_name}</td>";
    $code .= "    <td class=\"text-nowrap\">{$course_agreement_group}</td>";
    $code .= "    <td class=\"text-nowrap\">{$course_moodle_course}</td>";
    $code .= "    <td class=\"text-nowrap\">{$course_cycle}</td>";
    $code .= "    <td class=\"text-nowrap\">{$space_name}</td>";
    $code .= "    <td class=\"text-nowrap\">{$course_day}</td>";
    $code .= "</tr>";
}
$code .= "</table>";

echo($code);
?>