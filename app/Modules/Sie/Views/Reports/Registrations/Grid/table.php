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

//[models]--------------------------------------------------------------------------------------------------------------
$mprograms = model('App\Modules\Sie\Models\Sie_Programs');


$dates = service('dates');

$period = $_GET['period'];
$program = $_GET['program'];
$status = "REGISTERED";

if (!empty($program) && $program != "ALL") {
    $statuses = $mstatuses
        ->select('sie_statuses.*,sie_statuses.period AS status_period, sie_registrations.*, sie_registrations.created_at AS created')
        ->join('sie_registrations', 'sie_statuses.registration = sie_registrations.registration')
        ->where('sie_statuses.period', $period)
        ->where('sie_statuses.reference', $status)
        ->where('sie_statuses.program', $program)
        ->where('sie_registrations.deleted_at', null)
        ->orderBy('sie_registrations.created_at', 'ASC')
        ->findAll();
} else {
    $statuses = $mstatuses
        ->select('sie_statuses.*,,sie_statuses.period AS status_period, sie_registrations.*, sie_registrations.created_at AS created')
        ->join('sie_registrations', 'sie_statuses.registration = sie_registrations.registration')
        ->where('sie_statuses.period', $period)
        ->where('sie_statuses.reference', $status)
        ->where('sie_registrations.deleted_at', null)
        ->orderBy('sie_registrations.created_at', 'ASC')
        ->findAll();
}

// Imprimir el ultimo codigo sql ejecutado
//echo $mstatuses->getLastQuery();

$totalRecords = count($statuses);

$code = "";

$n = array();
$n["CONSECUTIVO"] = "Obligatario, numérico (15). Consecutivo de la información.";
$n["AÑO"] = "Obligatario, numérico (4). Año del reporte de información";
$n["SEMESTRE"] = "Obligatario, numérico (1). Semestre del reporte de información";
$n["ID_TIPO_DOCUMENTO"] = "Obligatario, alfabético (2). Tipo de Documento. Los valores válidos son: (CC) Cédula de ciudadanía, (DE) Documento de Identidad Extranjera, (CE) Cédula de Extranjería TI  Tarjeta de Identidad PS  Pasaporte CA  Certificado cabildo PT  PPT-Permiso por Protección Temporal";
$n["NUM_DOCUMENTO"] = "Obligatario, alfanumérico (30). Número del documento del estudiante.";
$n["PRO_CONSECUTIVO"] = "Obligatario, numérico (6). Código Snies del programa del estudiante.";
$n["ID_MUNICIPIO"] = "Obligatario, numérico (5). Código Divipola del municipio del programa";
$n["ID_VALIDACION_REQUISITO"] = "Opcional, alfabético (2). Validación requisito. Los valores válidos son: PI  Población indigena: certificado Min interior PR  Pueblo Rrom: certificado Min interior CN  Comunidades negras afrocolombianas, raizales y palenqueras: certificado Min Interior CC  Comunidad campesina: diploma colegio rural PL  Privado libertad: certificado INPEC DI  Discapacitado: certificado Minsalud";
$n["CRED_ACAD_PROGRAMA_RC"] = "Obligatorio, númerico (3). Créditos académicos del programa según el registro calificado (cantidad). Registre la cantidad de créditos académicos del programa según el registro calificado";
$n["CREDIT_ACADEM_ACUMU_SEM_ANTE"] = "Obligatorio, númerico (3). Créditos académicos aprobados por el estudiante hasta el semestre anterior (cantidad). Registre la cantidad de créditos académicos aprobados por el estudiante al final del semestre anterior al que está realizando el reporte. Si el estudiante no se matriculó en el semestre anterior, calcular los créditos académicos aprobados por el estudiante de acuerdo con el último periodo en el que se matriculó.";
$n["CREDIT_ACAD_A_MATRIC_REGU_SEM"] = "Obligatorio, númerico (3). Promedio semestral de créditos académicos (cantidad). Registre el promedio semestral de créditos académicos que deben matricular y aprobar regularmente los estudiantes de acuerdo con el plan de estudios del programa académico. Nota: tome como referencia la totalidad de créditos académicos del programa según el registro calificado y divídalo por el número total de semestres que debe cursar el estudiante según el plan de estudios (considerando las particularidades en cada caso: modalidad, cohortes, entre otros), de esta manera puede tener una referencia del promedio de créditos. Ejemplo: el programa según registro calificado tiene 160 créditos en total con 10 periodos académicos, entonces el promedio de créditos que regularmente deben inscribir los estudiantes es 160/10= 16, si la operación aritmética arroja un número decimal deberá aproximarse al número entero más cercano.";
$n["VALOR_BRUTO_DERECHOS_MATRICULA"] = "Obligatario, numérico (15). Valor bruto de los derechos de matrícula (valor en pesos). Corresponde al valor bruto de los derechos de matrícula en pesos liquidado al estudiante matriculado en un programa de pregrado antes de aplicar los descuentos a los que eventualmente tenga derecho. (solo concepto de matrícula).";
$n["APOYO_GOB_NAC_DESCUENTO_VOTAC"] = "Obligatario, numérico (15). Apoyo del Gobierno Nacional por descuento de votaciones (valor en pesos). Corresponde a los apoyos del gobierno nacional registrado en pesos, al valor del descuento asignado al estudiante de pregrado que presenten su certificado electoral, equivalente al 10% de la matrícula bruta. La IES tiene la responsabilidad de aplicar el descuento a la totalidad de los estudiantes que cumplan con el requisito de acuerdo con lo dispuesto en la Ley 2019 de 2020 como un estímulo a la participación electoral de los jóvenes que presenten certificado electoral.";
$n["APOYO_GOBERNAC_PROGR_PERMANENT"] = "Obligatario, numérico (15). Apoyo de las gobernaciones por programas permanentes (valor en pesos). Corresponde al apoyo de las gobernaciones por programa permanentes registrado en pesos, al valor de descuentos en la matrícula que provienen de las gobernaciones por programas o convenios recurrentes con aplicación continua en más de un periodo académico. No incluya valores por medidas temporales acordadas con las gobernaciones con el fin de complementar la política de gratuidad mediante recursos adicionales previstos para un solo periodo académico.";
$n["APOYO_ALCALDIA_PROGR_PERMANENT"] = "Obligatario, numérico (15). Apoyo de las alcaldías por programas permanentes (valor en pesos). Corresponde al apoyo de las alcaldías por programas permanentes registrado en pesos, al valor de descuentos en la matricula que provienen de las alcaldías por programas o convenios recurrentes con aplicación continua en más de un periodo académico. No incluya valores por medidas temporales acordadas con las alcaldías con el fin de complementar la política de gratuidad mediante recursos adicionales previstos para un solo periodo académico.";
$n["DESCUENT_RECURRENTES_DE_LA_IES"] = "Obligatario, numérico (15). Descuentos recurrentes de las IES (valor en pesos). Corresponde a descuentos recurrentes de las IES registrado en pesos, al valor de la matrícula que asume la Institución de Educación Superior Pública a través de descuentos (becas, auxilios, entre otros). Los valores deben incluir descuentos totales o parciales de matrícula, siempre y cuando provengan de acuerdos internos vigentes en la IES, estén destinados a matrícula y no correspondan a medidas temporales con el fin de complementar la política de gratuidad mediante esfuerzos adicionales previstos para un solo periodo académico.";
$n["OTROS_APOYOS_A_LA_MATRICULA"] = "Obligatario, numérico (15). Otros apoyos por programas permanentes no incluidos en ítems anteriores (valor en pesos). Corresponde a Otros apoyos por programas permanentes no incluidos en ítems anteriores registrado en pesos, al valor de la matrícula que se asume desde fuentes de financiación distintas a las enunciadas anteriormente. Los valores deben incluir apoyos totales o parciales de matrícula, siempre y cuando no correspondan a medidas temporales con el fin de complementar la política de gratuidad mediante recursos adicionales previstos para un solo periodo académico.";
$n["VALOR_NETO_DERECHOS_MATRICULA"] = "Obligatario, numérico (15). Valor neto de derechos de matrícula de pregrado (valor en pesos). Corresponde al valor neto de derechos de matrícula de pregrado registrado en pesos, es la diferencia entre el valor bruto de los derechos de matrícula de pregrado y los descuentos permanentes o recurrentes diligenciados anteriormente.";
$n["APOYO_ADICIONAL_GOBERNACIONES"] = "Obligatario, numérico (15). Apoyos adicionales y no recurrentes de las gobernaciones complementarios de la política de gratuidad (valor en pesos). Corresponde al valor registrado en pesos de apoyos adicionales y no recurrentes, es decir de descuentos en la matrícula por programas o convenios temporales acordados con las gobernaciones para complementar la política de gratuidad mediante recursos adicionales previstos para un solo periodo académico.";
$n["APOYO_ADICIONAL_ALCALDIAS"] = "Obligatario, numérico (15). Apoyos adicionales y no recurrentes de las alcaldías complementarios de la política de gratuidad (valor en pesos). Corresponde al valor registrado en pesos de descuentos en la matrícula por programas o convenios temporales acordados con las alcaldías para complementar la política de gratuidad mediante recursos adicionales previstos para un solo periodo académico.";
$n["DESCUENTOS_ADICIONALES_IES"] = "Obligatario, numérico (15). Descuentos adicionales y no recurrentes de las IES complementarios de la política de gratuidad (valor en pesos). Corresponde al valor registrado en pesos de descuentos en la matrícula que provienen de medidas temporales reglamentadas por las Instituciones de Educación Superior Públicas, siempre y cuando estén destinados a disminuir el valor de la matrícula a cargo del estudiante con el fin de complementar la política de gratuidad, mediante esfuerzos adicionales previstos y no recurrentes de las IES para un solo periodo académico.";
$n["OTROS_APOYOS_ADICIONALES"] = "Obligatario, numérico (15). Otros apoyos adicionales y no recurrentes complementarios de la de la política de gratuidad no incluidos en ítems anteriores (valor en pesos). Corresponde al valor registrado en pesos de descuentos en la matrícula por programas o convenios temporales acordados con otras entidades para complementar la política de gratuidad mediante recursos adicionales previstos y no recurrentes de las IES no incluidos en periodos anteriores para un solo periodo académico.";
$n["VAL_NETO_DER_MAT_A_CARGO_EST"] = "Obligatario, numérico (15). Valor neto de los derechos de matrícula a cargo del estudiante (valor en pesos). Corresponde al valor neto de derechos de matrícula de pregrado que debe pagar el estudiante registrado en pesos, es la diferencia entre el valor neto de los derechos de matrícula de pregrado y los descuentos adicionales diligenciados anteriormente, determinando el monto de la matrícula neta no cubierta  por apoyos permanentes y/o adicionales. ";
$n["VALOR_BRUTO_DERECHOS_COMPLEMEN"] = "Obligatario, numérico (15). Valor bruto de los derechos complementarios a la matrícula de pregrado (valor en pesos). Corresponde al valor registrado en pesos liquidado a cargo del estudiante de un programa de pregrado por derechos pecuniarios diferentes al de matrícula, sin aplicar descuentos asociados a estos. Los datos registrados son de carácter informativo y no hacen parte de la caracterización de la matrícula ordinaria neta a financiar con la política de gratuidad.";
$n["VALOR_NETO_DERECHOS_COMPLEMENT"] = "Obligatario, numérico (15). Valor neto de los derechos complementarios a la matrícula de pregrado (valor en pesos). Corresponde al valor registrado en pesos a cargo del estudiante de un programa de pregrado por derechos pecuniarios diferentes al de matrícula, una vez aplicados los descuentos asociados a estos. Los datos registrados son de carácter informativo y no hacen parte de la caracterización de la matrícula ordinaria neta a financiar con la política de gratuidad.";
$n["CAUSA_NO_ACCESO"] = "Obligatario, numérico (1). Causal de no acceso a la política de gratuidad. 1. Pérdida del beneficio por información falsa 0. Ninguna Causal";

$code .= " <table\n";
$code .= "\t\t id=\"grid-table\"\n";
$code .= "\t\t class=\"table table-responsive column-options\" \n ";
$code .= "\t\t border=\"1\">\n";
$code .= "<tdead>";
$code .= "<tr>\n";
$code .= "<td class='text-center ' title=\"{$n["CONSECUTIVO"]}\" >#</td>\n";
$code .= "<td class='text-center' title=\"{$n["AÑO"]}\">Año</td>\n";
$code .= "<td class='text-center' title=\"{$n["SEMESTRE"]}\">Semestre</td>\n";
$code .= "<td class='text-center' title=\"\">Jornada</td>\n";
//$code .= "<td class='text-center' title=\"\">Programa</td>\n";
$code .= "<td class='text-center' title=\"\">Nombre del Programa</td>\n";
$code .= "<td class='text-center' title=\"\">Regionalización / Convenio</td>\n";

$code .= "<td class='text-center' title=\"{$n["ID_TIPO_DOCUMENTO"]}\">Tipo</td>\n";
$code .= "<td class='text-center' title=\"{$n["NUM_DOCUMENTO"]}\">Identificación</td>\n";
$code .= "<td class='text-center' title=\"Nombres\">Nombre</td>\n";
$code .= "<td class='text-center' title=\"Apellidos\">Apellidos</td>\n";
$code .= "<td class='text-center' title=\"Apellidos\">Sexo</td>\n";
$code .= "<td class='text-center' title=\"Apellidos\">Nacimiento</td>\n";
$code .= "<td class='text-center' title=\"Apellidos\">Estrato</td>\n";
$code .= "<td class='text-center' title=\"Estado\">Correo Electrónico</td>\n";
$code .= "<td class='text-center' title=\"Estado\">Teléfono</td>\n";
$code .= "<td class='text-center' title=\"Estado\">WhatsApp</td>\n";
$code .= "<td class='text-center' title=\"Estado\">Estado</td>\n";
$code .= "<td class='text-start' title=\"Autor\">Autor</td>\n";
$code .= "<td class='text-start' title=\"Autor\">Fecha de Registro</td>\n";
$code .= "</tr>\n";
$code .= "</thead>";

$count = 0;
$class = "";
foreach ($statuses as $status) {
    $count++;
    $class = ($count % 2 == 0) ? "odd" : "even";
    //[defaults]--------------------------------------------------------------------------------------------------------
    $agreement_name = "REGULAR";
    $agreement_institucion_name = "PRINCIPAL";
    $agreement_city_name = "GUADALAJARA DE BUGA";
    //[evals]-----------------------------------------------------------------------------------------------------------
    if (!empty($status['agreement'])) {
        $agreement = $magreements->get_Agreement($status['agreement']);
        $agreement_name = $agreement['name'];
        $agreement_institucion = $minstitutions->getInstitution($status['agreement_institution']);
        $agreement_institucion_name = !empty($agreement_institucion['name']) ? $agreement_institucion['name'] : $agreement_institucion_name;
        if (!empty($status['agreement_city'])) {
            $city = $mcities->get_City($status['agreement_city']);
            $agreement_city_name = !empty($city['name']) ? $city['name'] : $agreement_city_name;
        }
    }
    $program = $mprograms->getProgram($status['program']);
    $age = $dates->get_Age(@$status['birth_date']);
    $year = safe_substr(@$status['status_period'], 0, 4);
    $period = safe_substr(@$status['period'], 4, 1);

    $eps = @$status['eps'];
    foreach (LIST_EPS as $deps) {
        if (@$deps["value"] == @$status['eps']) {
            $eps = @$deps["label"];
        }
    }

    $residence_city = $mcities->get_City(@$status['residence_city']);
    $residence_city_name = !empty(@$residence_city['name']) ? $residence_city['name'] : "";

    $causa_no_acceso = 0;

    $status_registration = @$status['registration'];
    $status_identification_type_ = @$status['identification_type'];
    $status_identification_number = @$status['identification_number'];
    $status_snies_id_validation_requisite = @$status['snies_id_validation_requisite'];
    $agreement = $magreements->get_Agreement(@$status['agreement']);
    $agreement_textual = @$agreement['name'];
    $status_nombres = @$status['first_name'] . " " . @$status['second_name'];
    $status_apellidos = @$status['first_surname'] . " " . @$status['second_surname'];

    $gender = @$status['gender'];
    $birth_date = @$status['birth_date'];
    $stratum = @$status['stratum'];

    $status_email = @$status['email_address'];

    $status_phone = @$status['phone'];
    $status_mobile = @$status['mobile'];

    $status_textual_journey = safe_strtoupper(get_sie_textual_journey(@$status['journey']));
    $status_textual_status = safe_strtoupper(get_sie_textual_status(@$status['reference']));
    $author = $mfields->get_Profile($status['author']);
    $status_status_author = safe_strtoupper(@$author['name']);
    $status_program = safe_strtoupper($status['program']);

    $program = $mprograms->getProgram($status['program']);
    $status_program_name = safe_strtoupper($program['name']);


    //[build]-----------------------------------------------------------------------------------------------------------
    $code .= "<tr class=\"{$class}\">";
    $code .= "    <td><a href=\"/sie/students/view/{$status_registration}\" target='\_blank\"'>{$count}</td>";
    $code .= "    <td class='text-center text-nowrap'>{$year}</td>";
    $code .= "    <td class='text-center text-nowrap'>" . (($period == "A") ? "1" : "2") . "</td>";
    $code .= "    <td class='text-start text-nowrap'>{$status_textual_journey}</td>";
    //$code .= "    <td class='text-start text-nowrap'>{$status_program}</td>";
    $code .= "    <td class='text-start text-nowrap'>{$status_program_name}</td>";
    $code .= "    <td class='text-start text-nowrap'>{$agreement_name}</td>";

    $code .= "    <td class='text-center text-nowrap'>{$status_identification_type_}</td>";
    $code .= "    <td class='text-center text-nowrap'><a href=\"/sie/students/view/{$status_registration}\" target='\_blank\"'>{$status_identification_number}</td>";
    $code .= "    <td class='text-left text-nowrap'>{$status_nombres}</td>";
    $code .= "    <td class='text-left text-nowrap'>{$status_apellidos}</td>";
    $code .= "    <td class='text-center text-nowrap'>{$gender}</td>";
    $code .= "    <td class='text-center text-nowrap'>{$birth_date}</td>";
    $code .= "    <td class='text-center text-nowrap'>{$stratum}</td>";
    $code .= "    <td class='text-left text-nowrap'>{$status_email}</td>";
    $code .= "    <td class='text-left text-nowrap'>{$status_phone}</td>";
    $code .= "    <td class='text-left text-nowrap'>{$status_mobile}</td>";
    $code .= "    <td class='text-center text-nowrap'>{$status_textual_status}</td>";
    $code .= "    <td class='text-start text-nowrap'>{$status_status_author}</td>";
    $code .= "    <td class='text-start text-nowrap'>{$status['created']}</td>";
    $code .= "</tr>";
}
$code .= "</table>";
echo $code;
?>