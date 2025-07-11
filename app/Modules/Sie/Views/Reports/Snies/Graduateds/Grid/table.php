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

$mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');
$mprograms = model('App\Modules\Sie\Models\Sie_Programs');
$menrollments = model('App\Modules\Sie\Models\Sie_Enrollments');

//ENROLLED = Matriculado
//ENROLLED-OLD = Matriculado - Antiguo
//ENROLLED-EXT =Matriculado - Extensión

$references = ["GRADUATED"];

if (!empty($program) && $program != "ALL") {
    $statuses = $mstatuses
        ->where("period", $period)
        ->whereIn('reference', $references)
        ->where("program", $program)
        ->limit($limit, $offset)
        ->find();
} else {
    $statuses = $mstatuses
        ->where("period", $period)
        ->whereIn('reference', $references)
        ->limit($limit, $offset)
        ->find();
}

$totalRecords = count($statuses);
//echo($statuses["sql"]);

//AÑO
//SEMESTRE
//ID_TIPO_DOCUMENTO
//NUM_DOCUMENTO
//PRO_CONSECUTIVO
//ID_MUNICIPIO
//EMAIL_PERSONAL
//TELEFONO_CONTACTO
//SNP_SABER_PRO
//NUM_ACTA_GRADO
//FECHA_GRADO
//NUM_FOLIO


$code = "";
$code .= " <table\n";
$code .= "\t\t id=\"grid-table\"\n";
$code .= "\t\t class=\"table table-striped table-hover\" \n ";
$code .= "\t\t border=\"1\">\n";
$code .= "<thead>";
$code .= "<tr>\n";
$code .= "<th class='text-center ' title=\"\" >#</th>\n";
$code .= "<th class='text-center ' title=\"\" >AÑO</th>\n";
$code .= "<th class='text-center ' title=\"\" >SEMESTRE</th>\n";
$code .= "<th class='text-center ' title=\"\" >ID_TIPO_DOCUMENTO</th>\n";
$code .= "<th class='text-center ' title=\"\" >NUM_DOCUMENTO</th>\n";
$code .= "<th class='text-center ' title=\"\" >PRO_CONSECUTIVO</th>\n";
$code .= "<th class='text-center ' title=\"\" >ID_MUNICIPIO</th>\n";
$code .= "<th class='text-center ' title=\"\" >EMAIL_PERSONAL</th>\n";
$code .= "<th class='text-center ' title=\"\" >TELEFONO_CONTACTO</th>\n";
$code .= "<th class='text-center ' title=\"\" >SNP_SABER_PRO</th>\n";
$code .= "<th class='text-center ' title=\"\" >NUM_ACTA_GRADO</th>\n";
$code .= "<th class='text-center ' title=\"\" >FECHA_GRADO</th>\n";
$code .= "<th class='text-center ' title=\"\" >NUM_FOLIO</th>\n";
$code .= "</tr>\n";
$code .= "</thead>";
$code .= "<tbody>";

$count = ($page - 1) * $limit;
foreach ($statuses as $status) {
    $count++;
    $code .= "<tr>\n";
    // procesos
    $registration = $mregistrations->get_Registration($status['registration']);
    $period = @$status['period'];
    $year = safe_substr($period, 0, 4);
    $period_literal = safe_substr($period, 4, 1);
    $semester = (($period_literal == "A") ? "1" : "2");
    $identification_type = @$registration['identification_type'];
    $identification_number = @$registration['identification_number'];
    $program = $mprograms->getProgram($status['program']);
    $program_name = safe_strtoupper(@$program['name']);
    $program_snies = safe_strtoupper(@$program['snies']);
    $ethnic_group = !empty($registration['ethnic_group']) ? $registration['ethnic_group'] : "0";
    $disability = @$registration['disability'] == "Y" ? "1" : "0";
    $disability_type = @$registration['disability_type'] == "" ? "0" : (int)($registration['disability_type']);
    $ek = @$registration['ek'];
    // Matricula
    $enrollment = $menrollments->get_EnrollmentByStudentAndProgram($status['registration'], $status['program']);
    // Variables de salida
    $ANNO = $year;
    $SEMESTRE = $semester;
    $ID_TIPO_DOCUMENTO = $identification_type;
    $NUM_DOCUMENTO = $identification_number;
    $PRO_CONSECUTIVO = $program_snies;
    $ID_MUNICIPIO = "76111";
    $EMAIL_PERSONAL = @$registration['email_address'];
    $TELEFONO_CONTACTO = @$registration['phone'];
    $SNP_SABER_PRO = @$registration['ek'];
    $NUM_ACTA_GRADO = safe_strtoupper(@$status["degree_certificate"]);
    $FECHA_GRADO = @$status["degree_date"];
    $NUM_FOLIO =  safe_strtoupper(@$status["degree_folio"]);


    // bulding columns
    $program = "";
    $code .= "<td class='text-center'>{$count}</td>\n";
    $code .= "<td class='text-center'>{$ANNO}</td>\n";
    $code .= "<td class='text-center'>{$SEMESTRE}</td>\n";
    $code .= "<td class='text-center'>{$ID_TIPO_DOCUMENTO}</td>\n";
    $code .= "<td class='text-center'><a href=\"/sie/students/view/{$status['registration']}\" target=\"_blank\">{$NUM_DOCUMENTO}</a></td>\n";
    $code .= "<td class='text-center'>{$PRO_CONSECUTIVO}</td>\n";
    $code .= "<td class='text-center'>{$ID_MUNICIPIO}</td>\n";
    $code .= "<td class='text-center'>{$EMAIL_PERSONAL}</td>\n";
    $code .= "<td class='text-center'>{$TELEFONO_CONTACTO}</td>\n";
    $code .= "<td class='text-center'>{$SNP_SABER_PRO}</td>\n";
    $code .= "<td class='text-center'>{$NUM_ACTA_GRADO}</td>\n";
    $code .= "<td class='text-center'>{$FECHA_GRADO}</td>\n";
    $code .= "<td class='text-center'>{$NUM_FOLIO}</td>\n";

    $code .= "</tr>";
}
$code .= "</tbody>";
$code .= "</table>";
echo($code);
?>