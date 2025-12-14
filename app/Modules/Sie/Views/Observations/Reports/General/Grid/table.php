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
$request = service('Request');
$dates = service('dates');

//--- [1. Models] ------------------------------------------------------------------------------------------------------
$mobservations = model('App\Modules\Sie\Models\Sie_Observations');
$mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');
$mprograms = model('App\Modules\Sie\Models\Sie_Programs'); // Asegúrate de que este modelo exista

$period = $request->getVar("period");
$option = $request->getVar("option");

//--- [2. Lógica de Fechas (Corregida)] ---------------------------------------------------------------------------------
$start = null;
$end = null;
if (!empty($period)) {
    //echo(safe_dump($period));
    $year = substr($period, 0, 4);
    $period_identifier = strtoupper(substr($period, -1));
    if ($period_identifier === 'A') {
        $start = $year . "-01-01";
        $end = $year . "-06-30";
    } elseif ($period_identifier === 'B') {
        $start = $year . "-07-01";
        $end = $year . "-12-31";
    }
} else {
    echo("Option esta vacia!");
    exit();
}

//--- [3. Consulta Principal (Corregida y Eficiente)] ------------------------------------------------------------------

// Solo aplicar el filtro de fecha si $start y $end son válidos
if ($start && $end) {
    if (!empty($option)) {
        if ($option == "ALL") {
            //echo("Period:".$period."<br>");
            //echo("Option:".$option."<br>");
            //echo("Start:".$start."<br>");
            //echo("End:".$end."<br>");
            $observations = $mobservations->where("date >=", $start)->where("date <=", $end)->find();
        } else {
            //echo($option);
            $observations = $mobservations->where("type=", $option)->where("date>=", $start)->where("date<=", $end)->find();
        }
    } else {
        $observations = $mobservations->where("date >=", $start)->where("date <=", $end)->find();
    }
} else {
    //echo("Period:".$period."<br>");
    //echo("Option:".$option."<br>");
    //echo("Start:".$start."<br>");
    //echo("End:".$end."<br>");
}

$totalRecords = 0;

//--- [4. Optimización N+1: Obtener datos relacionados en bloque] ------------------------------------------------------
$registrations_map = [];
$programs_map = [];

if (!empty($observations)) {
    // Obtener todos los IDs de estudiantes (object) de las observaciones
    $registration_ids = array_unique(array_column($observations, 'object'));

    // Obtener todos los datos de matrículas en UNA SOLA consulta
    $registrations_data = $mregistrations->whereIn('registration', $registration_ids)->findAll();

    // Obtener todos los IDs de programas de las matrículas
    $program_ids = array_unique(array_column($registrations_data, 'program'));

    // Obtener todos los datos de programas en UNA SOLA consulta
    $programs_data = $mprograms->whereIn('program', $program_ids)->findAll();

    // Crear mapas (arrays asociativos) para búsqueda rápida en memoria
    foreach ($registrations_data as $reg) {
        $registrations_map[$reg['registration']] = $reg;
    }
    foreach ($programs_data as $prog) {
        $programs_map[$prog['program']] = $prog;
    }
}

//--- [5. Construcción de la Tabla HTML] -------------------------------------------------------------------------------
$code = "<table id=\"grid-table\" class=\"table table-striped table-hover\" border=\"1\">\n";
$code .= "<thead><tr>
<th class='text-center align-middle'>#</th>
<th class='text-center align-middle'>Estudiante</th>
<th class='text-center align-middle'>Tipo de Documento</th>
<th class='text-center align-middle'>Identificación</th>
<th class='text-center align-middle'>Nombres</th>
<th class='text-center align-middle'>Apellidos</th>
<th class='text-center align-middle'>Programa</th>
<th class='text-center align-middle'>Nombre del programa</th>
<th class='text-center align-middle'>Observación</th>
<th class='text-center align-middle'>Fecha Observación</th>
<th class='text-center align-middle'>Tipo de Observación</th>
<th class='text-center align-middle'>Detalle</th>
</tr></thead>\n";
$code .= "<tbody>\n";

$count = 0;
foreach ($observations as $observation) {
    $count++;

    // Lógica para obtener la etiqueta del tipo (sin cambios)
    $types = LIST_TYPES_OBSERVATIONS;
    $type_value = $observation["type"] ?? null;
    $type_label = "";
    foreach ($types as $type_option) {
        if ($type_option['value'] == $type_value) {
            $type_label = $type_option['label'];
            break;
        }
    }
    $observation_date = $observation["date"];
    // --- [6. Búsqueda en memoria (NO en base de datos)] ---
    $registration_id = $observation["object"];
    $registration = $registrations_map[$registration_id] ?? null;

    $identification_type = $registration['identification_type'] ?? '';
    $identification_number = $registration['identification_number'] ?? '';
    $registration_names = ($registration['first_name'] ?? '') . " " . ($registration['second_name'] ?? '');
    $registration_surnames = ($registration['first_surname'] ?? '') . " " . ($registration['second_surname'] ?? '');

    $program_id = $registration['program'] ?? null;
    $program = $programs_map[$program_id] ?? null;

    $program_program = $program['program'] ?? '';
    $program_name = $program['name'] ?? '';

    $observation_observation = $observation["observation"] ?? '';
    $content = $observation["content"] ?? '';

    $code .= "<tr>
    <td class='text-center align-middle'>{$count}</td>
    <td class='text-center align-middle'>{$registration_id}</td>
    <td class='text-center align-middle'>{$identification_type}</td>
    <td class='text-center align-middle'>{$identification_number}</td>
    <td class='text-center align-middle'>{$registration_names}</td>
    <td class='text-center align-middle'>{$registration_surnames}</td>
    <td class='text-center align-middle'>{$program_program}</td>
    <td class='text-center align-middle'>{$program_name}</td>
    <td class='text-center align-middle'>{$observation_observation}</td>
    <td class='text-center align-middle'>{$observation_date}</td>
    <td class='text-center align-middle'>{$type_label}</td>
    <td class='text-left align-middle'>{$content}</td>
    </tr>\n";
}

$code .= "</tbody></table>";
echo $code;
?>