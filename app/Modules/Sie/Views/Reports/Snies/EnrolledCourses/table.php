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
$mgrids = model('App\Modules\Sie\Models\Sie_Grids');
$mversions = model('App\Modules\Sie\Models\Sie_Versions');
$mpensums = model('App\Modules\Sie\Models\Sie_Pensums');
$menrollments = model('App\Modules\Sie\Models\Sie_Enrollments');
$mprogress = model('App\Modules\Sie\Models\Sie_Progress');
$mexecutions = model('App\Modules\Sie\Models\Sie_Executions');
$mdiscounteds = model('App\Modules\Sie\Models\Sie_Discounteds');
$mdiscounts = model('App\Modules\Sie\Models\Sie_Discounts');

//ENROLLED = Matriculado
//ENROLLED-OLD = Matriculado - Antiguo
//ENROLLED-EXT =Matriculado - Extensión

$references = ["ENROLLED", "ENROLLED-OLD"];

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

// AÑO
// SEMESTRE
// ID_TIPO_DOCUMENTO
// NUM_DOCUMENTO
// PRO_CONSECUTIVO
// ID_MUNICIPIO_PROGRAMA
// ID_MUNICIPIO_ESTUDIO
// EN_LA_NOCHE_ESTUDIO
// CICLOS_BASICOS


$code = "";
$code .= " <table\n";
$code .= "\t\t id=\"grid-table\"\n";
$code .= "\t\t class=\"table table-striped table-hover\" \n ";
$code .= "\t\t border=\"1\">\n";
$code .= "<thead>";
$code .= "<tr>\n";
$code .= "<th class='text-center ' title=\"\" >#</th>\n";
//$code .= "<th class='text-center ' title=\"\" >JORNADA</th>\n";
$code .= "<th class='text-center ' title=\"\" >AÑO</th>\n";
$code .= "<th class='text-center ' title=\"\" >SEMESTRE</th>\n";
$code .= "<th class='text-center ' title=\"\" >ID_TIPO_DOCUMENTO</th>\n";
$code .= "<th class='text-center ' title=\"\" >NUM_DOCUMENTO</th>\n";
$code .= "<th class='text-center ' title=\"\" >PRO_CONSECUTIVO</th>\n";
$code .= "<th class='text-center ' title=\"\" >ID_MUNICIPIO</th>\n";
$code .= "<th class='text-center ' title=\"\" >NUM_MATERIAS_INSCRITAS</th>\n";
$code .= "<th class='text-start ' title=\"\" >NUM_MATERIAS_APROBADAS</th>\n";
$code .= "<th class='text-center ' title=\"\" >MATRICULA</th>\n";
$code .= "<th class='text-center ' title=\"\" >PROGRESOS(PENSUM)</th>\n";
$code .= "</tr>\n";
$code .= "</thead>";
$code .= "<tbody>";

$count = ($page - 1) * $limit;
foreach ($statuses as $status) {
    $count++;
    $registration = $mregistrations->getRegistration($status['registration']);
    $program = $mprograms->getProgram($status['program']);
    // Vars
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
    // vars
    $JOURNEY = $status["journey"];
    $ANNO = $year;
    $SEMESTRE = $semester;
    $ID_TIPO_DOCUMENTO = $identification_type;
    $NUM_DOCUMENTO = $identification_number;
    $PRO_CONSECUTIVO = $program_snies;
    $ID_MUNICIPIO = "76111";
    $ID_MUNICIPIO_ESTUDIO = "76111";
    $EN_LA_NOCHE_ESTUDIO = "S";
    $CICLOS_BASICOS = "N";
    $NUM_MATERIAS_INSCRITAS = "";
    $NUM_MATERIAS_APROBADAS = "";

    $registration_registration = @$registration["registration"];
    $link = "<a href=\"/sie/students/view/{$registration_registration}\" target=\"_blank\" >$NUM_DOCUMENTO</a>\n";
    // build
    $code .= "<tr id=\"trid-" . @$registration["registration"] . "\" data-registration=\"" . @$status["registration"] . "\" data-program=\"" . @$status["program"] . "\" data-period=\"" . $period . "\" data-status=\"STARTED\">\n";
    $code .= "<td class='text-center ' title=\"\" >$count</td>\n";
    //$code .= "<td class='text-center ' title=\"\" >{$JOURNEY}</td>\n";
    $code .= "<td class='text-center ' title=\"\" >{$ANNO}</td>\n";
    $code .= "<td class='text-center ' title=\"\" >{$SEMESTRE}</td>\n";
    $code .= "<td class='text-center ' title=\"\" >{$ID_TIPO_DOCUMENTO}</td>\n";
    $code .= "<td class='text-center ' title=\"\" >{$link}</td>\n";
    $code .= "<td class='text-center ' title=\"\" >{$PRO_CONSECUTIVO}</td>\n";
    $code .= "<td class='text-center ' title=\"\" >{$ID_MUNICIPIO}</td>\n";
    $code .= "</tr>\n";
}

$code .= "</tbody>";
$code .= "</table>";
echo($code);
?>
<?php include("asynchronous.php"); ?>