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

$period = $_GET['period'];
$program = $_GET['program'];

$total_inproccess = $mregistrations->get_TotalWithoutAgreements("");
$total_following = "";
$total_admitted = $mregistrations->get_TotalAdmitted("");

if ($program != "ALL") {
    $registrations = $mregistrations->where("period", $period)->where("program", $program)->findAll();
} else {
    $registrations = $mregistrations->where("period", $period)->findAll();
}

$code = "";

//$code .= "<table id='table' class='table table-striped table-bordered table-hover mb-3' >";
//$code .= "<tr><td colspan='2'>Reporte de Admisiones</td></tr>";
//$code .= "<tr><td class='w-50 align-content-end'><b>Aspirantes en proceso</b></td><td>{$total_inproccess} </td></tr>";
//$code .= "<tr><td class='w-50 align-content-end'><b>Aspirantes para seguimiento</b></td><td> {$total_following} </td></tr>";
//$code .= "<tr><td class='w-50 align-content-end'><b>Aspirantes admitidos</b></td><td>{$total_admitted}</td></tr>";
//$code .= "<tr><td class='w-50 align-content-end'><b>Aspirantes Admitidos Homologación</b></td><td> </td></tr>";
//$code .= "<tr><td class='w-50 align-content-end'><b>Aspirantes Admitidos Reingreso</b></td><td> </td></tr>";
//$code .= "<tr><td class='w-50 align-content-end'><b>Aspirante desiste del proceso</b></td><td> </td></tr>";
//$code .= "<tr><td class='w-50 align-right'><b>Aspirantes para seguimiento</b></td><td> </td></tr>";
//$code .= "</table>";


$code .= " <table\n";
$code .= "\t\t id=\"excelTable\"\n";
$code .= "\t\t class=\"table table-bordered table-striped table-hover table-excel\" \n ";
$code .= "\t\t >\n";
$code .= "<thead>";
$code .= "<tr>\n";
$code .= "<th>#</th>\n";
$code .= "<th>Convenio</th>\n";
$code .= "<th>Institución de Convenio</th>\n";
$code .= "<th>Municipio de Convenio</th>\n";
$code .= "<th>Departamento de Convenio</th>\n";
$code .= "<th>Año</th>\n";
$code .= "<th>Semestre Año</th>\n";
$code .= "<th>Tipo ID.</th>\n";
$code .= "<th>Numero de Identificación</th>\n";
$code .= "<th>Primer Nombre</th>\n";
$code .= "<th>Segundo Nombre</th>\n";
$code .= "<th>Primer Apellido</th>\n";
$code .= "<th>Segundo Apellido</th>\n";
$code .= "<th>Edad</th>\n";
$code .= "<th>Fecha de Nacimiento</th>\n";
$code .= "<th>Municipio de Nacimiento</th>\n";
$code .= "<th>Departamento de Nacimiento</th>\n";
$code .= "<th>País de Nacimiento</th>\n";
$code .= "<th>Sexo</th>\n";
$code .= "<th>G.S. RH.</th>\n";
$code .= "<th>EPS</th>\n";
$code .= "<th>Fecha de Expedición del Documento</th>\n";
$code .= "<th>Lugar de Expedición del Documento</th>\n";
$code .= "<th>Dirección de Residencia</th>\n";
$code .= "<th>Barrio de Residencia</th>\n";
$code .= "<th>Código Municipio Residencia</th>\n";
$code .= "<th>Municipio de Residencia</th>\n";
$code .= "<th>Zona de Residencia</th>\n";
$code .= "<th>Estrato Socioeconómico</th>\n";
$code .= "<th>TelÃ©fono De Contacto</th>\n";
$code .= "<th>Número de TelÃ©fono Alterno</th>\n";
$code .= "<th>Correo Personal</th>\n";
$code .= "<th>Código SNIES Programa</th>\n";
$code .= "<th>Programa</th>\n";
$code .= "<th>Momento</th>\n";
$code .= "<th>ID Municipio del Programa</th>\n";
$code .= "<th>ID_Tipo de Vinculación</th>\n";
$code .= "<th>Tipo de Vinculación</th>\n";
$code .= "<th>ID_Grupo Etnico</th>\n";
$code .= "<th>Grupo Etnico</th>\n";
$code .= "<th>ID_Pueblo Indigena</th>\n";
$code .= "<th>Pueblo Indigena</th>\n";
$code .= "<th>ID_Comunidad Negra</th>\n";
$code .= "<th>Comunidad Negra</th>\n";
$code .= "<th>Ultimo Grado Cursado</th>\n";
$code .= "<th>Tiene Acta de Grado</th>\n";
$code .= "<th>Número Acta de Grado</th>\n";
$code .= "<th>Fecha de Acta de Grado</th>\n";
$code .= "<th>Tiene Diploma</th>\n";
$code .= "<th>Institución Del Diploma y acta de Grado</th>\n";
$code .= "<th>SisbÃ©n</th>\n";
$code .= "<th>Tiene ICFES</th>\n";
$code .= "<th>Código AC</th>\n";
$code .= "<th>Tiene Formato de Autorización</th>\n";
$code .= "<th>Nombre Acudiente</th>\n";
$code .= "<th>Identificación Acudiente</th>\n";
$code .= "</tr>\n";
$code .= "</thead>";
$count = 0;
foreach ($registrations as $registration) {
    $count++;
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
    $program = $mprograms->getProgram($registration['program']);
    $age = $dates->get_Age($registration['birth_date']);
    $year = substr($registration['period'], 0, 4);
    $period = substr($registration['period'], 4, 1);

    $eps = $registration['eps'];
    foreach (LIST_EPS as $deps) {
        if (@$deps["value"] == @$registration['eps']) {
            $eps = @$deps["label"];
        }
    }

    $residence_city = $mcities->get_City($registration['residence_city']);
    $residence_city_name = !empty($residence_city['name']) ? $residence_city['name'] : "";


    //[build]-----------------------------------------------------------------------------------------------------------
    $code .= "<tr>";
    $code .= "    <td><a href=\"/sie/students/view/{$registration['registration']}\" target='\_blank\"'>{$count}</td>";
    $code .= "    <td>{$agreement_name}</td>";
    $code .= "    <td>{$agreement_institucion_name}</td>";
    $code .= "    <td>{$agreement_city_name}</td>";
    $code .= "    <td>{$registration['agreement_region']}</td>";
    $code .= "    <td class='text-center'>{$year}</td>";
    $code .= "    <td class='text-center'>{$period}</td>";
    $code .= "    <td>{$registration['identification_type']}</td>";
    $code .= "    <td>{$registration['identification_number']}</td>";
    $code .= "    <td>{$registration['first_name']}</td>";
    $code .= "    <td>{$registration['second_name']}</td>";
    $code .= "    <td>{$registration['first_surname']}</td>";
    $code .= "    <td>{$registration['second_surname']}</td>";
    $code .= "    <td class='text-center'>{$age}</td>";
    $code .= "    <td class='text-center'>{$registration['birth_date']}</td>";
    $code .= "    <td>{$registration['birth_city']}</td>";
    $code .= "    <td>{$registration['birth_region']}</td>";
    $code .= "    <td>{$registration['birth_country']}</td>";
    $code .= "    <td class='text-center'>{$registration['gender']}</td>";
    $code .= "    <td class='text-center'>{$registration['blood_type']}</td>";
    $code .= "    <td>{$eps}</td>";
    $code .= "    <td class='text-center'>{$registration['identification_date']}</td>";
    $code .= "    <td>{$registration['identification_place']}</td>";
    $code .= "    <td>{$registration['address']}</td>";
    $code .= "    <td>{$registration['neighborhood']}</td>";
    $code .= "    <td class='text-center'>{$registration['residence_city']}</td>";
    $code .= "    <td>{$residence_city_name}</td>";
    $code .= "    <td class='text-center'>{$registration['neighborhood']}</td>";
    $code .= "</tr>";
}
$code .= "</table>";
//echo($code);
?>
<style>
    /* Estilos adicionales para simular Excel */
    .table-excel {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .table-excel thead {
        background-color: #f1f3f5;
        font-weight: bold;
        position: sticky;
        top: 0;
        z-index: 1;
    }

    .table-excel th {
        vertical-align: middle;
        border-bottom: 2px solid #dee2e6;
        text-wrap: nowrap;
        box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
    }

    .table-excel td {
        vertical-align: middle;
        text-wrap: nowrap;
    }

    .table-excel tbody tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.3s ease;
    }

    /* Efecto de selección similar a Excel */
    .table-excel .selected {
        background-color: #b3d7ff !important;
    }


    .table-excel th,
    .table-excel td {
        min-width: 100px; /* Ancho mÃ­nimo para cada columna */
        padding: 8px;
        text-align: left;
        border: 1px solid #ddd;
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

