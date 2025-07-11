<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

$dates = service('dates');
//[models]--------------------------------------------------------------------------------------------------------------
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
$mstatuses = model('App\Modules\Sie\Models\Sie_Statuses');
$mcosts = model('App\Modules\Sie\Models\Sie_Costs');
$mproducts = model('App\Modules\Sie\Models\Sie_Products');
//[requests]------------------------------------------------------------------------------------------------------------
$status = isset($_GET['status']) ? $_GET['status'] : '';
$status = htmlspecialchars(trim($status), ENT_QUOTES, 'UTF-8');

if (empty($status)) {
    http_response_code(400);
    echo json_encode(['error' => 'Registro requerido']);
    exit;
}

//[querys]--------------------------------------------------------------------------------------------------------------
$status = $mstatuses->get_Status($status);
$program = $mprograms->getProgram($status['program']);
$registration = $mregistrations->get_Registration($status['registration']);
$discounteds = $mdiscounteds->where('object', @$status['registration'])->findAll();
$period = $status['period'];


//[vars]----------------------------------------------------------------------------------------------------------------
$credAcadPrograma = $program['credits'];
$enrollment = $menrollments->get_EnrollmentByStudentAndProgram($status['registration'], $status['program']);
$progresses = $mprogress->get_ProgressByEnrollment($enrollment['enrollment']);
$credits = 0;
$creditsearned = 0;
foreach ($progresses as $progress) {
    // Averiguo si la gano
    // si la gano averiguo cuantos creditos representa y los sumo
    $pensum = $mpensums->get_Pensum($progress['pensum']);
    $execution = $mexecutions->get_LastByProgress($progress['progress']);
    $credits = @$pensum['credits'];
    $uc1 = @$execution['c1'];
    $uc2 = @$execution['c2'];
    $uc3 = @$execution['c3'];
    if (($uc1 >= 80) && ($uc2 >= 80) && ($uc3 >= 80)) {
        $creditsearned += $credits;
    }
}

$version = $mversions->get_Version($enrollment['version']);
$total_cycles = $mpensums->getTotalCyclesByVersion($version['version']);
$creditAcadMatric = round(@$program['credits'] / $total_cycles);
$valorBrutoMatricula = $mcosts->getValueForCostByProgramByPeriod($program['program'], $period);
if (!$valorBrutoMatricula) {
    $valorBrutoMatricula = "NO DEFINIDO";
} else {

}
// Descuento por votaciones
$apoyoGobNac = 0;
if ($registration["identification_type"] == "CC") {
    foreach ($discounteds as $discounted) {
        if ($discounted['discount'] == "66578F3AC7987") {
            if (is_numeric($valorBrutoMatricula)) {
                $apoyoGobNac = $valorBrutoMatricula * 0.1;
            } else {
                $apoyoGobNac = "NO CALCULABLE";
            }
        }
    }
}
// $descuentRecurrentes Obligatario, numérico (15).
// Descuentos recurrentes de las IES (valor en pesos).
// Corresponde a descuentos recurrentes de las IES registrado en pesos, al valor de la matrícula que asume la Institución
// de Educación Superior Pública a través de descuentos (becas, auxilios, entre otros). Los valores deben incluir descuentos
// totales o parciales de matrícula, siempre y cuando provengan de acuerdos internos vigentes en la IES, estén destinados
// a matrícula y no correspondan a medidas temporales con el fin de complementar la política de gratuidad mediante esfuerzos
// adicionales previstos para un solo periodo académico.
// Si tiene descuento por el Decreto 2271 de 2023 queda en 0
$descuentRecurrentes = 0;
foreach ($discounteds as $discounted) {
    if ($discounted['discount'] == "6630C3352C3BD"||$discounted['discount'] == "6725536CAD062") {
        break;
    }else{
        // Procesar otros descuentos
        $discount = $mdiscounts->getDiscount($discounted['discount']);
        if ($discount && is_numeric($valorBrutoMatricula)) {
            if ($discount['type'] == 'ENROLLMENT'&&$discounted['discount'] != "66578F3AC7987") {
                $descuentRecurrentes += $valorBrutoMatricula * ($discount['value'] / 100);
            }
        }else{
            $descuentRecurrentes = "NO CALCULABLE";
        }
    }
}
// $otrosApoyos Obligatario, numérico (15).
// Otros apoyos por programas permanentes no incluidos en ítems anteriores (valor en pesos).
// Corresponde a Otros apoyos por programas permanentes no incluidos en ítems anteriores registrado en pesos, al valor de
// la matrícula que se asume desde fuentes de financiación distintas a las enunciadas anteriormente. Los valores deben
// incluir apoyos totales o parciales de matrícula, siempre y cuando no correspondan a medidas temporales con el fin de
// complementar la política de gratuidad mediante recursos adicionales previstos para un solo periodo académico.
$otrosApoyos = 0;
// $valorNetoMatricula: Obligatario, numérico (15).
// Valor neto de derechos de matrícula de pregrado (valor en pesos).
// Corresponde al valor neto de derechos de matrícula de pregrado registrado en pesos, es la diferencia entre el valor bruto
// de los derechos de matrícula de pregrado y los descuentos permanentes o recurrentes diligenciados anteriormente.
$valorNetoMatricula=0;
if (is_numeric($valorBrutoMatricula)) {
    $valorNetoMatricula = $valorBrutoMatricula - $apoyoGobNac-$descuentRecurrentes - $otrosApoyos;
}else{
    $valorNetoMatricula = "NO CALCULABLE";
}


// $valNetoCargoEst: Obligatario, numérico (15).
// Valor neto de los derechos de matrícula a cargo del estudiante (valor en pesos).
// Corresponde al valor neto de derechos de matrícula de pregrado que debe pagar el estudiante registrado en pesos, es la
// diferencia entre el valor neto de los derechos de matrícula de pregrado y los descuentos adicionales diligenciados anteriormente,
// determinando el monto de la matrícula neta no cubierta por apoyos permanentes y/o adicionales.
$valNetoCargoEst=0;
if (is_numeric($valorNetoMatricula)) {
    $valNetoCargoEst = $valorNetoMatricula;
}else{
    $valNetoCargoEst = "NO CALCULABLE";
}

// $valorBrutoComplemen: Obligatario, numérico (15).
// Valor bruto de los derechos complementarios a la matrícula de pregrado (valor en pesos).
// Corresponde al valor registrado en pesos liquidado a cargo del estudiante de un programa de pregrado por derechos pecuniarios
// diferentes al de matrícula, sin aplicar descuentos asociados a estos. Los datos registrados son de carácter informativo
// y no hacen parte de la caracterización de la matrícula ordinaria neta a financiar con la política de gratuidad.
$valorBrutoComplemen = 0;
if (is_numeric($valorNetoMatricula)) {
    $aporteBienestarEstudiantil=$mproducts->getProductByReference("P-BIENESTAR");
    $carneEstudiantil=$mproducts->getProductByReference("P-CARNE");;
    $derechosRegistro=$mproducts->getProductByReference("P-DERECHOS");;
    $seguroEstudiantil=$mproducts->getProductByReference("P-SEGURO");;
    $valorBrutoComplemen = $aporteBienestarEstudiantil["value"]+$carneEstudiantil["value"]+$derechosRegistro["value"]+$seguroEstudiantil["value"];
}else{
    $valorBrutoComplemen = "NO CALCULABLE";
}

// $valorNetoComplement: Obligatario, numérico (15).
// Valor neto de los derechos complementarios a la matrícula de pregrado (valor en pesos).
// Corresponde al valor registrado en pesos a cargo del estudiante de un programa de pregrado por derechos pecuniarios
// diferentes al de matrícula, una vez aplicados los descuentos asociados a estos. Los datos registrados son de carácter
// informativo y no hacen parte de la caracterización de la matrícula ordinaria neta a financiar con la política de
// gratuidad.
$valorNetoComplement=0;
if (is_numeric($valorBrutoComplemen)) {
    $descuentosAdicionales=0;
    foreach ($discounteds as $discounted) {
        if ($discounted['discount'] != "6630C3352C3BD"||$discounted['discount'] != "6725536CAD062") {
            $descuentosAdicionales+=0;// Falta se debe calcular uno por uno
        }
    }
    $valorNetoComplement=$valorBrutoComplemen-$descuentosAdicionales;
}else{
    $valorNetoComplement = "NO CALCULABLE";
}

try {
    $data = [
        'credAcadPrograma' => $credAcadPrograma,
        'creditAcademAcumu' => $creditsearned,
        'creditAcadMatric' => $creditAcadMatric,
        'valorBrutoMatricula' => $valorBrutoMatricula,
        'apoyoGobNac' => $apoyoGobNac,
        'apoyoGobernac' => '0',
        'apoyoAlcaldia' => '0',
        'descuentRecurrentes' => $descuentRecurrentes,
        'otrosApoyos' => $otrosApoyos,
        'valorNetoMatricula' => $valorNetoMatricula,
        'apoyoAdicionalGob' => '0',
        'apoyoAdicionalAlc' => '0',
        'descuentosAdicionales' => '0',
        'otrosApoyosAdicionales' => '0',
        'valNetoCargoEst' => $valNetoCargoEst,
        'valorBrutoComplemen' => $valorBrutoComplemen,
        'valorNetoComplement' => $valorNetoComplement,
        'causaNoAcceso' => '0'
    ];

    echo json_encode($data, JSON_NUMERIC_CHECK);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error interno del servidor']);
}
?>