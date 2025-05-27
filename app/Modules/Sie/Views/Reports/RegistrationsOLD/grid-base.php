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
$mdiscounts = model("App\Modules\Sie\Models\Sie_Discounts");
$mdiscounteds = model("App\Modules\Sie\Models\Sie_Discounteds");
$mstatuses = model("App\Modules\Sie\Models\Sie_Statuses");
$mfields = model("App\Modules\Sie\Models\Sie_Users_Fields");

$period = $_GET['period'];
$program = $_GET['program'];
$status = "REGISTERED";

if (!empty($program) && $program != "ALL") {
    $statuses = $mstatuses
        ->where("period", $period)
        ->where("reference", $status)
        ->where("program", $program)
        ->findAll();
} else {
    $statuses = $mstatuses
        ->where("period", $period)
        ->where("reference", $status)
        ->findAll();
}

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
$code .= "\t\t id=\"excelTable\"\n";
$code .= "\t\t class=\"table table-responsive column-options\" \n ";
$code .= "\t\t border=\"1\">\n";
$code .= "<tdead>";
$code .= "<tr>\n";
$code .= "<td class='text-center ' title=\"{$n["CONSECUTIVO"]}\" >#</td>\n";
$code .= "<td class='text-center' title=\"{$n["AÑO"]}\">Año</td>\n";
$code .= "<td class='text-center' title=\"{$n["SEMESTRE"]}\">Semestre</td>\n";
$code .= "<td class='text-center' title=\"\">Jornada</td>\n";
$code .= "<td class='text-center' title=\"{$n["ID_TIPO_DOCUMENTO"]}\">Tipo</td>\n";
$code .= "<td class='text-center' title=\"{$n["NUM_DOCUMENTO"]}\">Identificación</td>\n";
$code .= "<td class='text-center' title=\"Nombres\">Nombre</td>\n";
$code .= "<td class='text-center' title=\"Apellidos\">Apellidos</td>\n";
$code .= "<td class='text-center' title=\"Estado\">Regionalización</td>\n";
$code .= "<td class='text-center' title=\"Estado\">Estado</td>\n";
$code .= "<td class='text-center' title=\"Autor\">Autor</td>\n";
$code .= "</tr>\n";


$code .= "</thead>";


$count = 0;
$class = "";
foreach ($statuses as $status) {
    $count++;
    $class = ($count % 2 == 0) ? "odd" : "even";
    $registration = $mregistrations->get_Registration($status['registration']);
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
    $year = safe_substr(@$registration['period'], 0, 4);
    $period = safe_substr(@$registration['period'], 4, 1);

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

    $credit_academ_acumu_sem_ante = 0;
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
    include("cols/valor_neto_derechos_complement.php");

    $causa_no_acceso = 0;

    $registration_registration = @$registration['registration'];
    $registration_identification_type_ = @$registration['identification_type'];
    $registration_identification_number = @$registration['identification_number'];
    $registration_snies_id_validation_requisite = @$registration['snies_id_validation_requisite'];

    $agreement = $magreements->get_Agreement(@$registration['agreement']);
    $agreement_textual = @$agreement['name'];


    $registration_nombres = @$registration['first_name'] . " " . @$registration['second_name'];
    $registration_apellidos = @$registration['first_surname'] . " " . @$registration['second_surname'];


    $registration_textual_journey = get_sie_textual_journey(@$registration['journey']);
    $registration_textual_status = get_sie_textual_status(@$status['reference']);
    $author = $mfields->get_Profile($status['author']);
    $registration_status_author = @$author['name'];
    //[build]-----------------------------------------------------------------------------------------------------------
    $code .= "<tr class=\"{$class}\">";
    $code .= "    <td><a href=\"/sie/students/view/{$registration_registration}\" target='\_blank\"'>{$count}</td>";
    $code .= "    <td class='text-center text-nowrap'>{$year}</td>";
    $code .= "    <td class='text-center text-nowrap'>" . (($period == "A") ? "1" : "2") . "</td>";
    $code .= "    <td class='text-center text-nowrap'>{$registration_textual_journey}</td>";
    $code .= "    <td class='text-center text-nowrap'>{$registration_identification_type_}</td>";
    $code .= "    <td class='text-center text-nowrap'><a href=\"/sie/students/view/{$registration_registration}\" target='\_blank\"'>{$registration_identification_number}</td>";
    $code .= "    <td class='text-left text-nowrap'>{$registration_nombres}</td>";
    $code .= "    <td class='text-left text-nowrap'>{$registration_apellidos}</td>";
    $code .= "    <td class='text-center text-nowrap'>{$agreement_textual}</td>";
    $code .= "    <td class='text-center text-nowrap'>{$registration_textual_status}</td>";
    $code .= "    <td class='text-center text-nowrap'>{$registration_status_author}</td>";
    $code .= "</tr>";
}
$code .= "</table>";
//echo($code);
?>
<style>
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table th, .table td {
        padding: 0.5rem;
        vertical-align: middle;
    }

    .table thead th {
        border-bottom: 2px solid #dee2e6;
    }

    /* Para asegurar que las columnas se ajusten al contenido */
    .table {
        width: auto;
        max-width: none;
    }


    /* column options example */

    .column-options {
        border-collapse: collapse;
        border-bottom: 1px solid #d6d6d6;
        font-size: 13px;
    }

    .column-options th, .column-options td {
        font-family: Helvetica, Arial, sans-serif;
        font-weight: normal;
        color: #434343;
        background-color: #f7f7f7;
        border-left: 1px solid #ffffff;
        border-right: 1px solid #dcdcdc;
    }

    .column-options th {
        font-size: 140%;
        font-weight: normal;
        letter-spacing: 0.12em;
        text-shadow: -1px -1px 1px #999;
        color: #fff;
        background-color: #0cb08b;
        padding: 12px 0px 8px 0px;
        border-bottom: 1px solid #d6d6d6;
    }

    .column-options td {
        text-shadow: 1px 1px 0 #fff;
        padding: 3px 5px 3px 5px;
    }

    .column-options .odd td {
        background-color: #ededed;
    }


    .column-options th:first-child {
        border-top-left-radius: 7px;
        -moz-border-radius-topleft: 7px;
    }

    .column-options th:last-child {
        border-top-right-radius: 7px;
        -moz-border-radius-topright: 7px;
    }

    .column-options th:last-child, .column-options td:last-child {
        border-right: 0px;
    }

    .column-options a.button {
        font-size: 70%;
        text-shadow: none;
        text-decoration: none;
        text-align: center;
        text-shadow: -1px -1px 1px #72aebd;
        text-transform: uppercase;
        letter-spacing: 0.10em;
        color: #fff;
        padding: 7px 10px 4px 10px;
        border-radius: 5px;
        background-color: #00CC99;
        border-top: 1px solid #90f2da;
        border-right: 1px solid #00a97f;
        border-bottom: 1px solid #008765;
        border-left: 1px solid #7dd2bd;
        box-shadow: 2px 1px 2px #ccc;
        margin: 10px 5px 10px 5px;
        display: block;
    }

    .column-options a.button:hover {
        position: relative;
        top: 1px;
        left: 1px;
        background-color: #00CCFF;
        border-top: 1px solid #9aebff;
        border-right: 1px solid #08acd5;
        border-bottom: 1px solid #07a1c8;
        border-left: 1px solid #92def1;
        box-shadow: -1px -1px 2px #ccc;
    }

    .selected {
        background-color: #f0f8ff; /* Color de fondo ligeramente más oscuro */
    }

</style>
<?php echo($code); ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const table = document.getElementById('excelTable');

        // Funcionalidad de selección de celdas
        table.addEventListener('click', (e) => {
            if (e.target.tagName === 'TD') {
                // Remover selección previa
                table.querySelectorAll('td.selected').forEach(cell => {
                    cell.classList.remove('selected');
                });

                // Agregar selección a la celda actual
                e.target.classList.add('selected');
            }
        });

        // Opcional: Navegación con teclas
        table.addEventListener('keydown', (e) => {
            const cell = e.target;
            if (cell.tagName === 'TD') {
                let newCell;
                switch (e.key) {
                    case 'ArrowDown':
                        newCell = cell.closest('tr').nextElementSibling?.children[cell.cellIndex];
                        break;
                    case 'ArrowUp':
                        newCell = cell.closest('tr').previousElementSibling?.children[cell.cellIndex];
                        break;
                    case 'ArrowRight':
                        newCell = cell.nextElementSibling;
                        break;
                    case 'ArrowLeft':
                        newCell = cell.previousElementSibling;
                        break;
                }

                if (newCell) {
                    table.querySelectorAll('td.selected').forEach(c => c.classList.remove('selected'));
                    newCell.classList.add('selected');
                    newCell.focus();
                }
            }
        });


    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>