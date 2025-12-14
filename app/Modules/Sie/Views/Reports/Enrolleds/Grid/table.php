<?php
/** @var int $page viene de grid.php */
/** @var model $mexecutions */
/** @var model $mprogress */

//

//ENROLLED - Matriculado
//ENROLLED-OLD - Matriculado Antiguo
//ENROLLED-EXT - Matriculado Extensión
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
$code .= "\t\t class=\"table table-striped table-hover\" \n ";
$code .= "\t\t border=\"1\">\n";
$code .= "<thead>";
$code .= "<tr>\n";
$code .= "<th class='text-center ' title=\"\">#</th>\n";
$code .= "<th class='text-center' title=\"\">AÑO</th>\n";
$code .= "<th class='text-center' title=\"\">SEMESTRE</th>\n";
$code .= "<th class='text-center' title=\"\">ID_TIPO_DOCUMENTO</th>\n";
$code .= "<th class='text-center' title=\"\">NUM_DOCUMENTO</th>\n";
$code .= "<th class='text-center' title=\"\">CODIGO_ESTUDIANTE</th>\n";
$code .= "<th class='text-center' title=\"\">PRO_CONSECUTIVO</th>\n";
$code .= "<th class='text-center' title=\"\">ID_MUNICIPIO</th>\n";
$code .= "<th class='text-center' title=\"\">FECHA_NACIMIENTO</th>\n";

$code .= "<th class='text-center' title=\"\">ID_PAIS_NACIMIENTO</th>\n";
$code .= "<th class='text-center' title=\"\">ID_MUNICIPIO_NACIMIENTO</th>\n";
$code .= "<th class='text-center' title=\"\">ID_ZONA_RESIDENCIA</th>\n";
$code .= "<th class='text-center' title=\"\">ID_ESTRATO</th>\n";
$code .= "<th class='text-center' title=\"\">ES_REINTEGRO_ESTD_ANTED_DE1998</th>\n";

$code .= "<th class='text-center' title=\"\">AÑO_PRIMER_CURSO</th>\n";
$code .= "<th class='text-center' title=\"\">SEMESTRE_PRIMER_CURSO</th>\n";
$code .= "<th class='text-center' title=\"\">VALOR_NETO_MATRICULA</th>\n";
$code .= "<th class='text-center' title=\"\">TELEFONO_CONTACTO</th>\n";
$code .= "<th class='text-center' title=\"\">EMAIL_PERSONAL</th>\n";

/**
 * $code .= "<th class='text-center' title=\"{$n["ID_VALIDACION_REQUISITO"]}\">ID_VALIDACION_REQUISITO</th>\n";
 * $code .= "<th class='text-center' title=\"{$n["CRED_ACAD_PROGRAMA_RC"]}\">CRED_ACAD_PROGRAMA_RC</th>\n";
 * $code .= "<th class='text-center bg-danger' title=\"{$n["CREDIT_ACADEM_ACUMU_SEM_ANTE"]}\">CREDIT_ACADEM_ACUMU_SEM_ANTE</th>\n";
 * $code .= "<th class='text-center' title=\"{$n["CREDIT_ACAD_A_MATRIC_REGU_SEM"]}\">CREDIT_ACAD_A_MATRIC_REGU_SEM</th>\n";
 * $code .= "<th class='text-center' title=\"{$n["VALOR_BRUTO_DERECHOS_MATRICULA"]}\">VALOR_BRUTO_DERECHOS_MATRICULA</th>\n";
 * $code .= "<th class='text-center' title=\"{$n["APOYO_GOB_NAC_DESCUENTO_VOTAC"]}\">APOYO_GOB_NAC_DESCUENTO_VOTAC</th>\n";
 * $code .= "<th class='text-center' title=\"{$n["APOYO_GOBERNAC_PROGR_PERMANENT"]}\">APOYO_GOBERNAC_PROGR_PERMANENT</th>\n";
 * $code .= "<th class='text-center' title=\"{$n["APOYO_ALCALDIA_PROGR_PERMANENT"]}\">APOYO_ALCALDIA_PROGR_PERMANENT</th>\n";
 * $code .= "<th class='text-center' title=\"{$n["DESCUENT_RECURRENTES_DE_LA_IES"]}\" >DESCUENT_RECURRENTES_DE_LA_IES</th>\n";
 * $code .= "<th class='text-center' title=\"{$n["OTROS_APOYOS_A_LA_MATRICULA"]}\">OTROS_APOYOS_A_LA_MATRICULA</th>\n";
 * $code .= "<th class='text-center' title=\"{$n["VALOR_NETO_DERECHOS_MATRICULA"]}\">VALOR_NETO_DERECHOS_MATRICULA</th>\n";
 * $code .= "<th class='text-center' title=\"{$n["APOYO_ADICIONAL_GOBERNACIONES"]}\">APOYO_ADICIONAL_GOBERNACIONES</th>\n";
 * $code .= "<th class='text-center' title=\"{$n["APOYO_ADICIONAL_ALCALDIAS"]}\">APOYO_ADICIONAL_ALCALDIAS</th>\n";
 * $code .= "<th class='text-center' title=\"{$n["DESCUENTOS_ADICIONALES_IES"]}\">DESCUENTOS_ADICIONALES_IES</th>\n";
 * $code .= "<th class='text-center' title=\"{$n["OTROS_APOYOS_ADICIONALES"]}\">OTROS_APOYOS_ADICIONALES</th>\n";
 * $code .= "<th class='text-center' title=\"{$n["VAL_NETO_DER_MAT_A_CARGO_EST"]}\">VAL_NETO_DER_MAT_A_CARGO_EST</th>\n";
 * $code .= "<th class='text-center' title=\"{$n["VALOR_BRUTO_DERECHOS_COMPLEMEN"]}\">VALOR_BRUTO_DERECHOS_COMPLEMEN</th>\n";
 * $code .= "<th class='text-center' title=\"{$n["VALOR_NETO_DERECHOS_COMPLEMENT"]}\">VALOR_NETO_DERECHOS_COMPLEMENT</th>\n";
 * $code .= "<th class='text-center' title=\"{$n["CAUSA_NO_ACCESO"]}\">CAUSA_NO_ACCESO</th>\n";
 * $code .= "<th class='text-center' title=\"Estado\">Estado</th>\n";
 * $code .= "<th class='text-center' title=\"Autor\">Autor</th>\n";
 * **/
$code .= "</tr>\n";
$code .= "</thead>";
$count = ($page - 1) * $limit;

$class = "";
foreach ($statuses as $status) {
    $count++;
    $class = ($count % 2 == 0) ? "odd" : "even";
    $registration = $mregistrations->getRegistration($status['registration']);
    //[defaults]--------------------------------------------------------------------------------------------------------
    $agreement_name = "REGULAR";
    $agreement_institucion_name = "PRINCIPAL";
    $agreement_city_name = "GUADALAJARA DE BUGA";
    //[evals]-----------------------------------------------------------------------------------------------------------
    if (!empty($registration['agreement'])) {
        $agreement = $magreements->get_Agreement($registration['agreement']);
        $agreement_name = $agreement['name'];
        $agreement_institucion = $minstitutions->getInstitution($registration['agreement_institution']);
        $agreement_institucion_name = !empty($agreement_institucion['name']) ? $agreement_institucion['name'] : $agreement_institucion_name;
        if (!empty($registration['agreement_city'])) {
            $city = $mcities->get_City($registration['agreement_city']);
            $agreement_city_name = !empty($city['name']) ? $city['name'] : $agreement_city_name;
        }
    }
    $program = $mprograms->getProgram($status['program']);
    $age = $dates->get_Age(@$registration['birth_date']);
    $year = safe_substr(@$status['period'], 0, 4);
    $period = safe_substr(@$status['period'], 4, 1);

    $eps = @$registration['eps'];
    foreach (LIST_EPS as $deps) {
        if (@$deps["value"] == @$registration['eps']) {
            $eps = @$deps["label"];
        }
    }

    $residence_city = $mcities->get_City(@$registration['residence_city']);
    $residence_city_name = !empty(@$residence_city['name']) ? $residence_city['name'] : "";

    // Promedio de creditos acumulados semestre anterior
    // Tecnico 17
    // Tecnologo 17
    // Profesional 17

    $discounteds = $mdiscounteds->where('object', @$registration['registration'])->findAll();

    /**
     * Los creditos ganados por un estudiante en un periodo pueden venir solo de dos lugares
     * 1. El progreso resultante de participar de un curso.
     * 2. De la definicion administrativa del valor de progreso segun sea por homologacion u administracion
     * Se deben calcular ambos en el periodo definido como previo y emitir un valor acumulado.
     */
    $credit_academ_acumu_sem_ante = 0;
    $previus_period = "2024A";

    /**
     * $registration_registration= @$registration['registration'];
     * if(!empty($registration_registration)){
     * $previus_credits_earned = $mexecutions->get_EarnCreditsByPeriodByRegistration($previus_period, $registration_registration);
     * $previus_credits_registred = $mprogress->get_RegistredCreditsByPeriodByRegistration($previus_period, $registration_registration);
     * if (!empty($previus_credits_earned)) {
     * foreach ($previus_credits_earned as $previus_credits) {
     * if ($previus_credits['status'] == "APPROVED") {
     * $credit_academ_acumu_sem_ante += $previus_credits['credits'];
     * }
     * }
     * foreach ($previus_credits_registred as $previus_credits) {
     * $credit_academ_acumu_sem_ante += $previus_credits['credits'];
     * }
     * }
     * }
     **/


    $credit_acad_a_matric_regu_sem = 17;
    $valor_bruto_derechos_matricula = 0;
    include("cols/valor_bruto_derechos_matricula.php");
    $apoyo_gob_nac_descuento_votac = 0;
    include("cols/apoyo_gob_nac_descuento_votac.php");
    $apoyo_gobernac_progr_permanent = 0;
    $apoyo_alcaldia_progr_permanent = 0;
    $descuent_recurrentes_de_la_ies = 0;
    include("cols/descuent_recurrentes_de_la_ies.php");
    $otros_apoyos_a_la_matricula = 0;
    $valor_neto_derechos_matricula = 0;
    include("cols/valor_neto_derechos_matricula.php");
    $apoyo_adicional_gobernaciones = 0;
    $apoyo_adicional_alcaldias = 0;
    $descuentos_adicionales_ies = 0;// Todos los descuentos aplicados por la IES
    include("cols/descuentos_adicionales_ies.php");
    $otros_apoyos_adicionales = 0;
    $val_neto_der_mat_a_cargo_est = 0;
    include("cols/val_neto_der_mat_a_cargo_est.php");
    $valor_bruto_derechos_complemen = 123500;

    $valor_neto_derechos_complement = 0;
    //include("cols/valor_neto_derechos_complement.php");

    $causa_no_acceso = 0;

    $registration_registration = @$registration['registration'];
    $registration_identification_type_ = @$registration['identification_type'];
    $registration_identification_number = @$registration['identification_number'];
    $registration_snies_id_validation_requisite = @$registration['snies_id_validation_requisite'];
    if (empty($registration_snies_id_validation_requisite)) {
        $registration_snies_id_validation_requisite = "NA";
    }

    $registration_nombres = @$registration['first_name'] . " " . @$registration['second_name'];
    $registration_apellidos = @$registration['first_surname'] . " " . @$registration['second_surname'];

    $gender = @$registration['gender'];
    $birth_date = @$registration['birth_date'];
    $stratum = @$registration['stratum'];

    $registration_email = @$registration['email_address'];
    $registration_phone = @$registration['phone_number'] . " " . @$registration['mobile'];

    $registration_journey = @$registration['journey'];
    foreach (LIST_JOURNEYS as $ljourney) {
        if (@$ljourney["value"] == @$registration['journey']) {
            $registration_journey = @$ljourney["label"];
        }
    }

    $registration_birth_date = @$registration['birth_date'];

    $ID_PAIS_NACIMIENTO = @$registration['birth_country'];

    if ($ID_PAIS_NACIMIENTO == "CO") {
        $ID_PAIS_NACIMIENTO = "170";
    } elseif ($ID_PAIS_NACIMIENTO == "VE") {
        $ID_PAIS_NACIMIENTO = "862";
    } elseif ($ID_PAIS_NACIMIENTO == "EC") {
        $ID_PAIS_NACIMIENTO = "218";
    }

    $ID_MUNICIPIO_NACIMIENTO = @$registration['birth_city'];
    $ID_ZONA_RESIDENCIA = (@$registration['area'] == "RURAL") ? "2" : "1";
    $ID_ESTRATO = @$registration['stratum'];
    $ES_REINTEGRO_ESTD_ANTED_DE1998 = "N";

    $ANNO_PRIMER_CURSO = "";
    $SEMESTRE_PRIMER_CURSO = "";

    $VALOR_NETO_MATRICULA = !empty(@$program["value"]) ? @$program["value"] : 0;
    $program_value = $VALOR_NETO_MATRICULA;

    $TELEFONO_CONTACTO = @$registration['phone'];
    $EMAIL_PERSONAL = @$registration['email_address'];

    //[build]-----------------------------------------------------------------------------------------------------------
    $code .= "<tr class=\"{$class}\">";
    $code .= "    <td><a href=\"/sie/students/view/{$registration_registration}\" target='\_blank\"'>{$count}</td>";
    $code .= "    <td class='text-center text-nowrap'>{$year}</td>";
    $code .= "    <td class='text-center text-nowrap'>{$period}</td>";
    //$code .= "    <td class='text-center text-nowrap'>{$registration_journey}</td>";
    $code .= "    <td class='text-center text-nowrap'>{$registration_identification_type_}</td>";
    $code .= "    <td class='text-left text-nowrap'><a href=\"/sie/students/view/{$registration_registration}\" target='\_blank\"'>{$registration_identification_number}</td>";
    $code .= "    <td class='text-center text-nowrap'>{$registration_identification_number}</td>";
    $code .= "    <td class='text-center text-nowrap'>" . @$program['snies'] . "</td>";
    $code .= "    <td class='text-center text-nowrap'>76111</td>";
    $code .= "    <td class='text-center text-nowrap'>{$registration_birth_date}</td>";

    $code .= "    <td class='text-center text-nowrap'>{$ID_PAIS_NACIMIENTO}</td>";
    $code .= "    <td class='text-center text-nowrap'>{$ID_MUNICIPIO_NACIMIENTO}</td>";
    $code .= "    <td class='text-center text-nowrap'>{$ID_ZONA_RESIDENCIA}</td>";
    $code .= "    <td class='text-center text-nowrap'>{$ID_ESTRATO}</td>";
    $code .= "    <td class='text-center text-nowrap'>{$ES_REINTEGRO_ESTD_ANTED_DE1998}</td>";

    $code .= "    <td class='text-center text-nowrap'>{$ANNO_PRIMER_CURSO}</td>";
    $code .= "    <td class='text-center text-nowrap'>{$SEMESTRE_PRIMER_CURSO}</td>";
    $code .= "    <td class='text-center text-nowrap'>{$program_value} " . @$registration["value"] . "</td>";
    $code .= "    <td class='text-center text-nowrap'>{$TELEFONO_CONTACTO}</td>";
    $code .= "    <td class='text-left text-nowrap'>{$EMAIL_PERSONAL}</td>";


    /**
     *
     *
     * $code .= "    <td class='text-center text-nowrap'>{$registration_snies_id_validation_requisite}</td>";
     * $code .= "    <td class='text-center text-nowrap'>" . @$program['credits'] . "</td>";
     *
     * if(intval($credit_academ_acumu_sem_ante)!=0){
     * $code .= "    <td class='text-center text-nowrap bg-gradient-gray-200'><a href=\"/sie/students/view/{$registration_registration}\" target='\_blank\"'>{$credit_academ_acumu_sem_ante}</a></td>";
     * }else {
     * $code .= "    <td class='text-center text-nowrap bg-gradient-gray-200'>{$credit_academ_acumu_sem_ante}</td>";
     * }
     * $code .= "    <td class='text-center text-nowrap'>{$credit_acad_a_matric_regu_sem}</td>";
     * if ($valor_bruto_derechos_matricula <= 0) {
     * $code .= "    <td class='text-end bg-danger'>{$valor_bruto_derechos_matricula} " . "</td>";
     * } else {
     * $code .= "    <td class='text-end'>{$valor_bruto_derechos_matricula} " . "</td>";
     * }
     *
     * $code .= "    <td class='text-end'>{$apoyo_gob_nac_descuento_votac}</td>";
     * $code .= "    <td class='text-end'>{$apoyo_gobernac_progr_permanent}</td>";
     * $code .= "    <td class='text-end'>{$apoyo_alcaldia_progr_permanent}</td>";
     * $code .= "    <td class='text-end'>{$descuent_recurrentes_de_la_ies}</td>";
     * $code .= "    <td class='text-end'>{$otros_apoyos_a_la_matricula}</td>";
     * if ($valor_neto_derechos_matricula < 0) {
     * $code .= "    <td class='text-end bg-danger'>{$valor_neto_derechos_matricula}</td>";
     * } else {
     * $code .= "    <td class='text-end'>{$valor_neto_derechos_matricula}</td>";
     * }
     * $code .= "    <td class='text-end'>{$apoyo_adicional_gobernaciones}</td>";
     * $code .= "    <td class='text-end'>{$apoyo_adicional_alcaldias}</td>";
     * $code .= "    <td class='text-end'>{$descuentos_adicionales_ies}</td>";
     * $code .= "    <td class='text-end'>{$otros_apoyos_adicionales}</td>";
     * if ($val_neto_der_mat_a_cargo_est < 0) {
     * $code .= "    <td class='text-end bg-danger'>{$val_neto_der_mat_a_cargo_est}</td>";
     * } else {
     * $code .= "    <td class='text-end'>{$val_neto_der_mat_a_cargo_est}</td>";
     * }
     * $code .= "    <td class='text-end'>{$valor_bruto_derechos_complemen}</td>";
     * $code .= "    <td class='text-end'>{$valor_neto_derechos_complement}</td>";
     * $code .= "    <td class='text-end'>{$causa_no_acceso}</td>";
     * $code .= "    <td class='text-center text-nowrap'>{$status['reference']}</td>";
     *
     * $author = $mfields->get_Profile($status['author']);
     * $code .= "    <td class='text-center text-nowrap'>" . $author['name'] . "</td>";
     * **/
    $code .= "</tr>";
}
$code .= "</table>";
echo($code);
?>