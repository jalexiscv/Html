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
$mpensums= model('App\Modules\Sie\Models\Sie_Pensums');
$menrollments = model('App\Modules\Sie\Models\Sie_Enrollments');
$mprogress = model('App\Modules\Sie\Models\Sie_Progress');
$mexecutions= model('App\Modules\Sie\Models\Sie_Executions');
$mdiscounteds= model('App\Modules\Sie\Models\Sie_Discounteds');
$mdiscounts= model('App\Modules\Sie\Models\Sie_Discounts');


//ENROLLED = Matriculado
//ENROLLED-OLD = Matriculado - Antiguo
//ENROLLED-EXT =Matriculado - Extensión

$references = ["ENROLLED","ENROLLED-OLD"];

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
//ID_VALIDACION_REQUISITO
//CRED_ACAD_PROGRAMA_RC
//CREDIT_ACADEM_ACUMU_SEM_ANTE
//CREDIT_ACAD_A_MATRIC_REGU_SEM
//VALOR_BRUTO_DERECHOS_MATRICULA
//APOYO_GOB_NAC_DESCUENTO_VOTAC
//APOYO_GOBERNAC_PROGR_PERMANENT
//APOYO_ALCALDIA_PROGR_PERMANENT
//DESCUENT_RECURRENTES_DE_LA_IES
//OTROS_APOYOS_A_LA_MATRICULA
//VALOR_NETO_DERECHOS_MATRICULA
//APOYO_ADICIONAL_GOBERNACIONES
//APOYO_ADICIONAL_ALCALDIAS
//DESCUENTOS_ADICIONALES_IES
//OTROS_APOYOS_ADICIONALES
//VAL_NETO_DER_MAT_A_CARGO_EST
//VALOR_BRUTO_DERECHOS_COMPLEMEN
//VALOR_NETO_DERECHOS_COMPLEMENT
//CAUSA_NO_ACCESO


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
$code .= "<th class='text-center ' title=\"\" >ID_VALIDACION_REQUISITO</th>\n";
$code .= "<th class='text-center ' title=\"\" >CRED_ACAD_PROGRAMA_RC</th>\n";
$code .= "<th class='text-center ' title=\"\" >CREDIT_ACADEM_ACUMU_SEM_ANTE</th>\n";
$code .= "<th class='text-center ' title=\"\" >CREDIT_ACAD_A_MATRIC_REGU_SEM</th>\n";
$code .= "<th class='text-center ' title=\"\" >VALOR_BRUTO_DERECHOS_MATRICULA</th>\n";
$code .= "<th class='text-center ' title=\"\" >APOYO_GOB_NAC_DESCUENTO_VOTAC</th>\n";
$code .= "<th class='text-center ' title=\"\" >APOYO_GOBERNAC_PROGR_PERMANENT</th>\n";
$code .= "<th class='text-center ' title=\"\" >APOYO_ALCALDIA_PROGR_PERMANENT</th>\n";
$code .= "<th class='text-center ' title=\"\" >DESCUENT_RECURRENTES_DE_LA_IES</th>\n";
$code .= "<th class='text-center ' title=\"\" >OTROS_APOYOS_A_LA_MATRICULA</th>\n";
$code .= "<th class='text-center ' title=\"\" >VALOR_NETO_DERECHOS_MATRICULA</th>\n";
$code .= "<th class='text-center ' title=\"\" >APOYO_ADICIONAL_GOBERNACIONES</th>\n";
$code .= "<th class='text-center ' title=\"\" >APOYO_ADICIONAL_ALCALDIAS</th>\n";
$code .= "<th class='text-center ' title=\"\" >DESCUENTOS_ADICIONALES_IES</th>\n";
$code .= "<th class='text-center ' title=\"\" >OTROS_APOYOS_ADICIONALES</th>\n";
$code .= "<th class='text-center ' title=\"\" >VAL_NETO_DER_MAT_A_CARGO_EST</th>\n";
$code .= "<th class='text-center ' title=\"\" >VALOR_BRUTO_DERECHOS_COMPLEMEN</th>\n";
$code .= "<th class='text-center ' title=\"\" >VALOR_NETO_DERECHOS_COMPLEMENT</th>\n";
$code .= "<th class='text-center ' title=\"\" >CAUSA_NO_ACCESO</th>\n";

$code .= "</tr>\n";
$code .= "</thead>";
$code .= "<tbody>";

$count = ($page - 1) * $limit;
foreach ($statuses as $status) {
    $count++;
    $code .= "<tr>\n";
    // procesos
    $registration = $mregistrations->get_Registration($status['registration']);
    $program = $mprograms->getProgram($status['program']);


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
    $grid = $mgrids->get_Grid($enrollment['grid']);
    $version= $mversions->get_Version($enrollment['version']);
    $total_cycles = $mpensums->getTotalCyclesByVersion($version['version']);
    // Modulos (Progresos)
    $progresses = $mprogress->get_ProgressByEnrollment($enrollment['enrollment']);
    //echo("<pre>");
    //print_r($progresses);
    //echo("</pre>");
    $credits=0;
    $creditsearned = 0;
    foreach ($progresses as $progress){
        // Averiguo si la gano
        // si la gano averiguo cuantos creditos representa y los sumo
        $pensum = $mpensums->get_Pensum($progress['pensum']);
        $execution=$mexecutions->get_LastByProgress($progress['progress']);
        $credits=@$pensum['credits'];
        $uc1 = @$execution['c1'];
        $uc2 = @$execution['c2'];
        $uc3 = @$execution['c3'];
        if (($uc1 >= 80) && ($uc2 >= 80) && ($uc3 >= 80)) {
            $creditsearned+= $credits;
        }
    }


    $electoral_discount = $mdiscounteds->exist_DiscountedByRegistrationByDiscount($status['registration'],"66578F3AC7987");
    //Valor bruto de los derechos de matricula
    $value_bruto = @$program['value'];
    //Obligatario, numérico (15). Apoyo del Gobierno Nacional por descuento de votaciones (valor en pesos).
    $apoyo_gob_nac_descuento_votac=($electoral_discount)?($value_bruto*0.1):0;
    // Descuentos recurrentes de la IES (numérico (15)).
    $descuent_recurrentes_de_la_ies = 0;
    $discounteds=$mdiscounteds->get_DiscountedsByRegistration($status['registration']);
    foreach ($discounteds as $discounted) {
        $discount = $mdiscounts->getDiscount($discounted['discount']);
        if (@$discount['type'] == "FIXED" && @$discount['character'] == "PERCENTAGE") {
            $descuent_recurrentes_de_la_ies += $value_bruto * $discount['value'] / 100;
        }
    }

    // Variables
    $ANNO = $year;
    $SEMESTRE = $semester;
    $ID_TIPO_DOCUMENTO = $identification_type;
    $NUM_DOCUMENTO = $identification_number;
    $PRO_CONSECUTIVO = $program_snies;
    $ID_MUNICIPIO = "76111";
    $ID_VALIDACION_REQUISITO=@$registration['snies_id_validation_requisite'];
    $CRED_ACAD_PROGRAMA_RC = @$program['credits'];
    $CREDIT_ACADEM_ACUMU_SEM_ANTE = $creditsearned;
    $CREDIT_ACAD_A_MATRIC_REGU_SEM = round(@$program['credits']/$total_cycles);
    $VALOR_BRUTO_DERECHOS_MATRICULA = $value_bruto;
    $APOYO_GOB_NAC_DESCUENTO_VOTAC = $apoyo_gob_nac_descuento_votac;
    $APOYO_GOBERNAC_PROGR_PERMANENT = 0;
    $APOYO_ALCALDIA_PROGR_PERMANENT = 0;
    $DESCUENT_RECURRENTES_DE_LA_IES = $descuent_recurrentes_de_la_ies;
    $OTROS_APOYOS_A_LA_MATRICULA = 0;
    $VALOR_NETO_DERECHOS_MATRICULA = "";
    $APOYO_ADICIONAL_GOBERNACIONES = "";
    $APOYO_ADICIONAL_ALCALDIAS = "";
    $DESCUENTOS_ADICIONALES_IES = "";
    $OTROS_APOYOS_ADICIONALES = "";
    $VAL_NETO_DER_MAT_A_CARGO_EST = "";
    $VALOR_BRUTO_DERECHOS_COMPLEMEN = "";
    $VALOR_NETO_DERECHOS_COMPLEMENT = "";
    $CAUSA_NO_ACCESO = "";
    // Bulding
    $program = "";
    $code .= "<td class='text-center'>{$count}</td>\n";
    $code .= "<td class='text-center'>{$ANNO}</td>\n";
    $code .= "<td class='text-center'>{$SEMESTRE}</td>\n";
    $code .= "<td class='text-center'>{$ID_TIPO_DOCUMENTO}</td>\n";
    $code .= "<td class='text-center'><a href=\"/sie/students/view/{$status['registration']}\" target=\"_blank\">{$NUM_DOCUMENTO}</a></td>\n";
    $code .= "<td class='text-center'>{$PRO_CONSECUTIVO}</td>\n";
    $code .= "<td class='text-center'>{$ID_MUNICIPIO}</td>\n";
    $code .= "<td class='text-center'>{$ID_VALIDACION_REQUISITO}</td>\n";
    $code .= "<td class='text-center'>{$CRED_ACAD_PROGRAMA_RC}</td>\n";
    $code .= "<td class='text-center'>{$CREDIT_ACADEM_ACUMU_SEM_ANTE}</td>\n";
    $code .= "<td class='text-center'>{$CREDIT_ACAD_A_MATRIC_REGU_SEM}</td>\n";
    $code .= "<td class='text-center'>{$VALOR_BRUTO_DERECHOS_MATRICULA}</td>\n";
    $code .= "<td class='text-center'>{$APOYO_GOB_NAC_DESCUENTO_VOTAC}</td>\n";
    $code .= "<td class='text-center'>{$APOYO_GOBERNAC_PROGR_PERMANENT}</td>\n";
    $code .= "<td class='text-center'>{$APOYO_ALCALDIA_PROGR_PERMANENT}</td>\n";
    $code .= "<td class='text-center'>{$DESCUENT_RECURRENTES_DE_LA_IES}</td>\n";
    $code .= "<td class='text-center'>{$OTROS_APOYOS_A_LA_MATRICULA}</td>\n";
    $code .= "<td class='text-center'>{$VALOR_NETO_DERECHOS_MATRICULA}</td>\n";
    $code .= "<td class='text-center'>{$APOYO_ADICIONAL_GOBERNACIONES}</td>\n";
    $code .= "<td class='text-center'>{$APOYO_ADICIONAL_ALCALDIAS}</td>\n";
    $code .= "<td class='text-center'>{$DESCUENTOS_ADICIONALES_IES}</td>\n";
    $code .= "<td class='text-center'>{$OTROS_APOYOS_ADICIONALES}</td>\n";
    $code .= "<td class='text-center'>{$VAL_NETO_DER_MAT_A_CARGO_EST}</td>\n";
    $code .= "<td class='text-center'>{$VALOR_BRUTO_DERECHOS_COMPLEMEN}</td>\n";
    $code .= "<td class='text-center'>{$VALOR_NETO_DERECHOS_COMPLEMENT}</td>\n";
    $code .= "<td class='text-center'>{$CAUSA_NO_ACCESO}</td>\n";
    $code .= "</tr>";
}
$code .= "</tbody>";
$code .= "</table>";
echo($code);
?>