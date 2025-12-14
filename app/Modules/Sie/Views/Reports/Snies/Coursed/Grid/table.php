<?php
/** @var int $page viene de grid.php */
/** @var model $mexecutions */
/** @var model $mprogress */
/** @var model $mstatuses */
/** @var model $mregistrations */
/** @var model $mprograms */
/** @var model $magreements */
/** @var model $minstitutions */
/** @var model $mcities */
/** @var model $mdiscounteds */
/** @var model $mfields */
/** @var string $program */
/** @var string $period */
/** @var string $status */
/** @var int $limit */
/** @var int $offset */
$dates = service('dates');

$program = !empty($program) ? $program : "";
//$statuses=$mstatuses->get_Details($program,$period,$status,$limit, $offset);
//$totalRecords=$statuses["total"];

$executions = $mexecutions->get_ExecutionsByPeriodWithCount($period, $limit, $offset);
$totalRecords = $executions["total"]; // Debes implementar este método

$code = "";
$code .= " <table\n";
$code .= "\t\t id=\"grid-table\"\n";
$code .= "\t\t class=\"table table-striped table-hover\" \n ";
$code .= "\t\t border=\"1\">\n";
$code .= "<thead>";
$code .= "<tr>\n";
$code .= "<th class='text-center'>#</th>\n";
$code .= "<th class='text-center'>Código</th>\n";
$code .= "<th class='text-center'>Periodo</th>\n";

$code .= "<th class='text-center'>Tipo</th>\n";
$code .= "<th class='text-center'>Identificación</th>\n";

$code .= "<th class='text-center text-nowrap'>Nombres del estudiante</th>\n";
$code .= "<th class='text-center text-nowrap'>Apellidos del estudiante</th>\n";

$code .= "<th class='text-center text-nowrap'>Curso</th>\n";
$code .= "<th class='text-center text-nowrap'>Nombre del curso</th>\n";

$code .= "<th class='text-center text-nowrap'>C1</th>\n";
$code .= "<th class='text-center text-nowrap'>C2</th>\n";
$code .= "<th class='text-center text-nowrap'>C3</th>\n";
$code .= "<th class='text-center text-nowrap'>Total</th>\n";
$code .= "<th class='text-center text-nowrap'>Promedio</th>\n";

$code .= "<th class='text-center text-nowrap'>Pensum</th>\n";
$code .= "<th class='text-center text-nowrap'>Módulo</th>\n";
$code .= "<th class='text-center text-nowrap'>Nombre del módulo</th>\n";

$code .= "<th class='text-center text-nowrap'>Profesor</th>\n";
$code .= "<th class='text-center text-nowrap'>Nombre del profesor</th>\n";
$code .= "<th class='text-center text-nowrap'>Apellidos del profesor</th>\n";

$code .= "<th class='text-center'>Programa</th>\n";
$code .= "<th class='text-center text-nowrap'>Nombre del programa</th>\n";
$code .= "<th class='text-center'>Ciclo</th>\n";
$code .= "<th class='text-center'>Momento</th>\n";
$code .= "<th class='text-center'>Jornada</th>\n";
$code .= "<th class='text-center'>Convenio</th>\n";
$code .= "<th class='text-center'>Sede</th>\n";
$code .= "<th class='text-center'>Descripción</th>\n";
$code .= "<th class='text-center'>Email Personal</th>\n";
$code .= "<th class='text-center'>Email Institucional</th>\n";

//$code .= "<th class='text-center'>C1</th>\n";
//$code .= "<th class='text-center'>C2</th>\n";
//$code .= "<th class='text-center'>C3</th>\n";
//$code .= "<th class='text-center'>Total</th>\n";


$code .= "</tr>\n";
$code .= "</thead>";
$code .= "<tbody>";
$count = 0;
// Array para almacenar los totales de cada estudiante
$studentTotals = [];
// Array para registrar si ya mostramos el promedio para este estudiante
$averageShown = [];
// Array para agrupar estudiantes
$students = [];

// Primera pasada: agrupar datos por estudiante
foreach ($executions["results"] as $key => $execution) {
    if (!preg_match('/INGL/i', $execution["course_name"])) {
        $identification_number = $execution["identification_number"];

        if (!isset($students[$identification_number])) {
            $students[$identification_number] = [
                'totals' => [],
                'rows' => []
            ];
        }

        $total = !empty($execution["total"]) ? $execution["total"] : 0;
        $students[$identification_number]['totals'][] = $total;
        $students[$identification_number]['rows'][] = $key;
    }
}

// Segunda pasada: calcular promedios
foreach ($students as $identification => $data) {
    $avg = array_sum($data['totals']) / count($data['totals']);
    $students[$identification]['average'] = number_format($avg, 2);
}

foreach ($executions["results"] as $key => $execution) {
    if (!preg_match('/INGL/i', $execution["course_name"])) {
        $count++;
        //vars--------------------------------------------------------------------------------------------------------------
        $firstname = $execution["first_name"] . " " . $execution["second_name"];
        $lastname = $execution["first_surname"] . " " . $execution["second_surname"];
        $identification_type = $execution["identification_type"];
        $identification_number = $execution["identification_number"];
        $c1 = !empty($execution["c1"]) ? $execution["c1"] : 0;
        $c2 = !empty($execution["c2"]) ? $execution["c2"] : 0;
        $c3 = !empty($execution["c3"]) ? $execution["c3"] : 0;
        $total = !empty($execution["total"]) ? $execution["total"] : 0;

        $course_link = "<a href=\"/sie/courses/view/{$execution["course"]}\" target=\"_blank\">{$execution["course"]}</a>";
        $course_name = safe_strtoupper($execution["course_name"]);

        $course_pensum = safe_strtoupper($execution["course_pensum"]);
        $course_module = safe_strtoupper($execution["module"]);
        $course_module_name = safe_strtoupper($execution["module_name"]);

        $teacher = @$execution["course_teacher"];
        $teacher_profile = $mfields->get_CachedProfile($teacher);

        $teacher_firstname = safe_strtoupper(@$teacher_profile["firstname"]);
        $teacher_lastname = safe_strtoupper(@$teacher_profile["lastname"]);

        $program = @$execution["program"];
        $program_name = safe_strtoupper(@$execution["program_name"]);
        $cycle = @$execution["cycle"];
        $moment = @$execution["moment"];
        $journey = safe_strtoupper(get_sie_textual_journey(@$execution["journey"]));
        $agreement = @$execution["agreement"];
        $agreement_institution = @$execution["agreement_institution"];
        $agreement_name = "PRINCIPAL";
        $institution_name = "PRINCIPAL";
        if (!empty($agreement)) {
            $qagreement = $magreements->get_Agreement($agreement);
            $agreement_name = safe_strtoupper(@$qagreement["name"]);
            if (!empty($agreement_institution)) {
                $qinstitution = $minstitutions->getInstitution($agreement_institution);
                $institution_name = safe_strtoupper(@$qinstitution["name"]);
            }
        }
        $course_description = safe_strtoupper(@$execution["course_description"]);
        $email_address = safe_strtoupper(@$execution["email_address"]);
        $email_institutional = safe_strtoupper(@$execution["email_institutional"]);

        //build-------------------------------------------------------------------------------------------------------------
        $code .= "<tr>\n";
        $code .= "<td class='text-center' title=\"Autor\">{$count}</td>\n";
        $code .= "<td class='text-center' title=\"Autor\">{$execution["progress"]}</td>\n";
        $code .= "<td class='text-center' title=\"Autor\">{$execution["period"]}</td>\n";
        $code .= "<td class='text-start text-nowrap'>{$identification_type}</td>\n";
        $code .= "<td class='text-start text-nowrap'>{$identification_number}</td>\n";
        $code .= "<td class='text-start text-nowrap'>{$firstname}</td>\n";
        $code .= "<td class='text-start text-nowrap'>{$lastname}</td>\n";
        $code .= "<td class='text-center' title=\"Curso\">{$course_link}</td>\n";
        $code .= "<td class='text-start text-nowrap'>{$course_name}</td>\n";

        $code .= "<td class='text-end' title=\"Autor\">{$c1}</td>\n";
        $code .= "<td class='text-end' title=\"Autor\">{$c2}</td>\n";
        $code .= "<td class='text-end' title=\"Autor\">{$c3}</td>\n";
        $code .= "<td class='text-end' title=\"Total\">{$total}</td>\n";

        // Mostrar el promedio solo una vez por estudiante - centralizado en la primera aparición
        if (!isset($averageShown[$identification_number])) {
            $rowspan = count($students[$identification_number]['rows']);
            $studentAverage = $students[$identification_number]['average'];
            $code .= "<td class='text-center align-middle' title=\"Promedio\" rowspan=\"{$rowspan}\">{$studentAverage}</td>\n";
            $averageShown[$identification_number] = true;
        }

        $code .= "<td class='text-start text-nowrap'>{$course_pensum}</td>\n";
        $code .= "<td class='text-start text-nowrap'>{$course_module}</td>\n";
        $code .= "<td class='text-start text-nowrap'>{$course_module_name}</td>\n";

        $code .= "<td class='text-start text-nowrap'>{$teacher}</td>\n";
        $code .= "<td class='text-start text-nowrap'>{$teacher_firstname}</td>\n";
        $code .= "<td class='text-start text-nowrap'>{$teacher_lastname}</td>\n";
        $code .= "<td class='text-start text-nowrap'>{$program}</td>\n";
        $code .= "<td class='text-start text-nowrap'>{$program_name}</td>\n";
        $code .= "<td class='text-start text-nowrap'>{$cycle}</td>\n";
        $code .= "<td class='text-start text-nowrap'>{$moment}</td>\n";
        $code .= "<td class='text-start text-nowrap'>{$journey}</td>\n";
        $code .= "<td class='text-start text-nowrap'>{$agreement_name}</td>\n";
        $code .= "<td class='text-start text-nowrap'>{$institution_name}</td>\n";
        $code .= "<td class='text-start text-nowrap'>{$course_description}</td>\n";
        $code .= "<td class='text-start text-nowrap'>{$email_address}</td>\n";
        $code .= "<td class='text-start text-nowrap'>{$email_institutional}</td>\n";
        $code .= "</tr>\n";
    }
}
$code .= "</tbody>";
$code .= "</table>";
echo($code);
?>