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

$statuses = $mstatuses->get_Details($program, $period, $status, $limit, $offset);
$totalRecords = $statuses["total"];

//echo($statuses["sql"]);

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
$code .= "<th class='text-center ' title=\"{$n["CONSECUTIVO"]}\" >#</th>\n";
$code .= "<th class='text-center' title=\"{$n["AÑO"]}\">AÑO</th>\n";
$code .= "<th class='text-center' title=\"{$n["SEMESTRE"]}\">SEMESTRE</th>\n";
$code .= "<th class='text-center' title=\"\">Jornada</th>\n";
$code .= "<th class='text-center' title=\"{$n["ID_TIPO_DOCUMENTO"]}\">ID_TIPO_DOCUMENTO</th>\n";
$code .= "<th class='text-center' title=\"{$n["NUM_DOCUMENTO"]}\">NUM_DOCUMENTO</th>\n";
$code .= "<th class='text-center' title=\"Nombres\">Nombre</th>\n";
$code .= "<th class='text-center' title=\"Apellidos\">Apellidos</th>\n";
$code .= "<th class='text-center' title=\"Sexo\">Sexo</th>\n";
$code .= "<th class='text-center' title=\"Nacimiento\">Nacimiento</th>\n";
$code .= "<th class='text-center' title=\"Edad\">Edad</th>\n";
$code .= "<th class='text-center' title=\"Estrato\">Estrato</th>\n";
$code .= "<th class='text-center' title=\"Email\">Correo Electrónico Personal</th>\n";
$code .= "<th class='text-center' title=\"Email Institucional\">Correo Electrónico Institucional</th>\n";
$code .= "<th class='text-center' title=\"Teléfono\">Teléfono</th>\n";
$code .= "<th class='text-center' title=\"Programa\">Programa</th>\n";

$code .= "<th class='text-center' title=\"Estado\">Estado</th>\n";
$code .= "<th class='text-center' title=\"Ciclo\">Ciclo</th>\n";
$code .= "<th class='text-center' title=\"Momento\">Momento</th>\n";

$code .= "<th class='text-center' title=\"Convenio\">Convenio</th>\n";
$code .= "<th class='text-center' title=\"{$n["PRO_CONSECUTIVO"]}\">PRO_CONSECUTIVO</th>\n";
$code .= "<th class='text-center' title=\"{$n["ID_MUNICIPIO"]}\">ID_MUNICIPIO</th>\n";
$code .= "<th class='text-center' title=\"{$n["ID_VALIDACION_REQUISITO"]}\">ID_VALIDACION_REQUISITO</th>\n";
$code .= "<th class='text-center' title=\"{$n["CRED_ACAD_PROGRAMA_RC"]}\">CRED_ACAD_PROGRAMA_RC</th>\n";
$code .= "<th class='text-center bg-danger' title=\"{$n["CREDIT_ACADEM_ACUMU_SEM_ANTE"]}\">CREDIT_ACADEM_ACUMU_SEM_ANTE</th>\n";
$code .= "<th class='text-center' title=\"{$n["CREDIT_ACAD_A_MATRIC_REGU_SEM"]}\">CREDIT_ACAD_A_MATRIC_REGU_SEM</th>\n";
$code .= "<th class='text-center' title=\"{$n["VALOR_BRUTO_DERECHOS_MATRICULA"]}\">VALOR_BRUTO_DERECHOS_MATRICULA</th>\n";
$code .= "<th class='text-center' title=\"{$n["APOYO_GOB_NAC_DESCUENTO_VOTAC"]}\">APOYO_GOB_NAC_DESCUENTO_VOTAC</th>\n";
$code .= "<th class='text-center' title=\"{$n["APOYO_GOBERNAC_PROGR_PERMANENT"]}\">APOYO_GOBERNAC_PROGR_PERMANENT</th>\n";
$code .= "<th class='text-center' title=\"{$n["APOYO_ALCALDIA_PROGR_PERMANENT"]}\">APOYO_ALCALDIA_PROGR_PERMANENT</th>\n";
$code .= "<th class='text-center' title=\"{$n["DESCUENT_RECURRENTES_DE_LA_IES"]}\" >DESCUENT_RECURRENTES_DE_LA_IES</th>\n";
$code .= "<th class='text-center' title=\"{$n["OTROS_APOYOS_A_LA_MATRICULA"]}\">OTROS_APOYOS_A_LA_MATRICULA</th>\n";
$code .= "<th class='text-center' title=\"{$n["VALOR_NETO_DERECHOS_MATRICULA"]}\">VALOR_NETO_DERECHOS_MATRICULA</th>\n";
$code .= "<th class='text-center' title=\"{$n["APOYO_ADICIONAL_GOBERNACIONES"]}\">APOYO_ADICIONAL_GOBERNACIONES</th>\n";
$code .= "<th class='text-center' title=\"{$n["APOYO_ADICIONAL_ALCALDIAS"]}\">APOYO_ADICIONAL_ALCALDIAS</th>\n";
$code .= "<th class='text-center' title=\"{$n["DESCUENTOS_ADICIONALES_IES"]}\">DESCUENTOS_ADICIONALES_IES</th>\n";
$code .= "<th class='text-center' title=\"{$n["OTROS_APOYOS_ADICIONALES"]}\">OTROS_APOYOS_ADICIONALES</th>\n";
$code .= "<th class='text-center' title=\"{$n["VAL_NETO_DER_MAT_A_CARGO_EST"]}\">VAL_NETO_DER_MAT_A_CARGO_EST</th>\n";
$code .= "<th class='text-center' title=\"{$n["VALOR_BRUTO_DERECHOS_COMPLEMEN"]}\">VALOR_BRUTO_DERECHOS_COMPLEMEN</th>\n";
$code .= "<th class='text-center' title=\"{$n["VALOR_NETO_DERECHOS_COMPLEMENT"]}\">VALOR_NETO_DERECHOS_COMPLEMENT</th>\n";
$code .= "<th class='text-center' title=\"{$n["CAUSA_NO_ACCESO"]}\">CAUSA_NO_ACCESO</th>\n";
$code .= "<th class='text-center' title=\"Estado\">Estado</th>\n";
$code .= "<th class='text-center' title=\"Autor\">Autor</th>\n";
$code .= "</tr>\n";
$code .= "</thead>";
$code .= "<tbody>";

$count = ($page - 1) * $limit;
foreach ($statuses["data"] as $status) {
    $count++;
    $code .= "<tr>\n";

    // columnas
    $registration_registration = @$status['registration_registration'];
    $period = @$status['status_period'];
    $year = safe_substr($period, 0, 4);
    $period_literal = safe_substr($period, 4, 1);
    $semester = (($period_literal == "A") ? "1" : "2");
    $journey = get_sie_textual_journey(@$status['registration_journey']);
    $identification_type = @$status['identification_type'];
    $identification_number = @$status['identification_number'];
    $registration_name = @$status['first_name'] . " " . @$status['second_name'];
    $registration_lastname = @$status['first_surname'] . " " . @$status['second_surname'];
    $sex = @$status['gender'];
    $birth_date = @$status['birth_date'];
    $age = $dates->get_Age($birth_date);
    $stratum = @$status['stratum'];
    $email_address = safe_strtoupper(@$status['email_address']);
    $email_institutional = safe_strtoupper(@$status['email_institutional']);
    $phone = !empty(@$status['phone']) ? @$status['phone'] : @$status['mobile'];
    $program_name = safe_strtoupper(@$status['program_name']);

    $status_details = "<a href=\"/sie/students/view/{$registration_registration}\" target='_blank'><i class=\"fa-regular fa-user\"></i></a> | ";
    $status_details .= "<a href=\"/sie/statuses/edit/{$status['status']}\" target='_blank'><i class=\"fa-regular fa-bolt-lightning\"></i></a>";

    $cycle = @$status['cycle'];
    $moment = @$status['moment'];


    $agreement = !empty(@$status['agreement_name']) ? safe_strtoupper(@$status['agreement_name']) : "PRINCIPAL";
    $snies = @$status['program_snies'];
    $municipio = "76111";
    $registration_snies_id_validation_requisite = !empty(@$status['snies_id_validation_requisite']) ? @$status['snies_id_validation_requisite'] : "NA";
    $cred_acad_programa_rc = @$status['program_credits'];
    $credit_academ_acumu_sem_ante = 0;
    $credit_acad_a_matric_regu_sem = 0;
    $credit_acad_a_matric_regu_sem = 17;
    $discounteds = $mdiscounteds->where('object', @$status['registration_registration'])->findAll();// necesario para apoyo_gob_nac_descuento_votac.php y descuent_recurrentes_de_la_ies.php
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
    $descuentos_adicionales_ies = 0;
    include("cols/descuentos_adicionales_ies.php");
    $otros_apoyos_adicionales = 0;
    $val_neto_der_mat_a_cargo_est = 0;
    include("cols/val_neto_der_mat_a_cargo_est.php");
    $valor_bruto_derechos_complemen = 123500;
    $valor_neto_derechos_complement = 0;
    include("cols/valor_neto_derechos_complement.php");
    $causa_no_acceso = 0;
    $status_reference = @$status['reference'];
    $status_autor = @$status['statuses_author'];
    // bulding columns
    $code .= "<td class='text-end'>{$count}</td>\n";
    $code .= "<td class='text-center'>{$year}</td>\n";
    $code .= "<td class='text-center text-nowrap'>{$semester}</td>";
    $code .= "<td class='text-center text-nowrap'>{$journey}</td>";
    $code .= "<td class='text-center text-nowrap'>{$identification_type}</td>";
    $code .= "<td class='text-left text-nowrap'><a href=\"/sie/students/view/{$registration_registration}\" target='\_blank\"'>{$identification_number}</a></td>";
    $code .= "<td class='text-star text-nowrap'>{$registration_name}</td>";
    $code .= "<td class='text-start text-nowrap'>{$registration_lastname}</td>";
    $code .= "<td class='text-center text-nowrap'>{$sex}</td>";
    $code .= "<td class='text-center text-nowrap'>{$birth_date}</td>";
    $code .= "<td class='text-center text-nowrap'>{$age}</td>";
    $code .= "<td class='text-center text-nowrap'>{$stratum}</td>";
    $code .= "<td class='text-left text-nowrap'>{$email_address}</td>";
    $code .= "<td class='text-left text-nowrap'>{$email_institutional}</td>";
    $code .= "<td class='text-center text-nowrap'>{$phone}</td>";
    $code .= "<td class='text-left text-nowrap'>{$program_name}</td>";
    $code .= "<td class='text-center text-nowrap'>{$status_details}</td>";
    $code .= "<td class='text-center text-nowrap'>{$cycle}</td>";
    $code .= "<td class='text-center text-nowrap'>{$moment}</td>";
    $code .= "<td class='text-left text-nowrap'>{$agreement}</td>";
    $code .= "<td class='text-center text-nowrap'>{$snies}</td>";
    $code .= "<td class='text-center text-nowrap'>{$municipio}</td>";
    $code .= "<td class='text-center text-nowrap'>{$registration_snies_id_validation_requisite}</td>";
    $code .= "<td class='text-center text-nowrap'>{$cred_acad_programa_rc}</td>";
    $code .= "<td class='text-center text-nowrap'>{$credit_academ_acumu_sem_ante}</td>";
    $code .= "<td class='text-center text-nowrap'>{$credit_acad_a_matric_regu_sem}</td>";
    $code .= "<td class='text-end text-nowrap'>{$valor_bruto_derechos_matricula}</td>";
    $code .= "<td class='text-end text-nowrap'>{$apoyo_gob_nac_descuento_votac}</td>";
    $code .= "<td class='text-end text-nowrap'>{$apoyo_gobernac_progr_permanent}</td>";
    $code .= "<td class='text-end text-nowrap'>{$apoyo_alcaldia_progr_permanent}</td>";
    $code .= "<td class='text-end text-nowrap'>{$descuent_recurrentes_de_la_ies}</td>";
    $code .= "<td class='text-end text-nowrap'>{$otros_apoyos_a_la_matricula}</td>";
    $code .= "<td class='text-end text-nowrap'>{$valor_neto_derechos_matricula}</td>";
    $code .= "<td class='text-end text-nowrap'>{$apoyo_adicional_gobernaciones}</td>";
    $code .= "<td class='text-end text-nowrap'>{$apoyo_adicional_alcaldias}</td>";
    $code .= "<td class='text-end text-nowrap'>{$descuentos_adicionales_ies}</td>";
    $code .= "<td class='text-end text-nowrap'>{$otros_apoyos_adicionales}</td>";
    $code .= "<td class='text-end text-nowrap'>{$val_neto_der_mat_a_cargo_est}</td>";
    $code .= "<td class='text-end text-nowrap'>{$valor_bruto_derechos_complemen}</td>";
    $code .= "<td class='text-end text-nowrap'>{$valor_neto_derechos_complement}</td>";
    $code .= "<td class='text-center text-nowrap'>{$causa_no_acceso}</td>";
    $code .= "<td class='text-center text-nowrap'>{$status_reference}</td>";
    $code .= "<td class='text-center text-nowrap'>{$status_autor}</td>";
    //---
    $code .= "</tr>";
}
$code .= "</tbody>";
$code .= "</table>";
echo($code);
?>