<?php
/** @var string $oid */

$strings = service("strings");
$dates = service("dates");
//[models]--------------------------------------------------------------------------------------------------------------
$magents = model('App\Modules\Crm\Models\Crm_Agents');
$mtickets = model('App\Modules\Crm\Models\Crm_Tickets');
//[vars]----------------------------------------------------------------------------------------------------------------
//[services]------------------------------------------------------------------------------------------------------------
$b = service("bootstrap");
$f = service("forms", array("lang" => "Reports."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Crm\Models\Crm_Agents");
//[vars]----------------------------------------------------------------------------------------------------------------
$r["start"] = $f->get_Value("start", "2024-01-01");
$r["end"] = $f->get_Value("end", date("Y-m-d"));


$tickets = $mtickets->get_TicketsByRange($r["start"], $r["end"]);
$back = "/crm/agents/list/" . lpk();

$code = "<table class='table table-striped table-bordered table-hover'>";
$code .= "<thead>";
$code .= "<tr>";
$code .= "<th class=\"text-center\">" . lang("App.Ticket") . "</th>";
$code .= "<th class=\"text-center\">" . lang("App.Number") . "</th>";
$code .= "<th class=\"text-center\">F/H de llegada</th>";
$code .= "<th class=\"text-center\">Tiempo de espera</th>";
$code .= "<th class=\"text-center\">Hora de Atención</th>";
$code .= "<th class=\"text-center\">Duración</th>";
$code .= "<th class=\"text-center\">" . lang("App.Status") . "</th>";
$code .= "</tr>";
$code .= "</thead>";
$code .= "<tbody>";
$sprevioustime = "";
foreach ($tickets as $ticket) {
    $created = strtotime($ticket['created_at']);
    $time = date("H:i:s", $created);
    $awaiting = $dates->get_ElapsedTime($time, $ticket['time']);
    $waiting = $awaiting['hours'] . ":" . $awaiting['minutes'] . ":" . $awaiting['seconds'];
    $number = $strings->get_ZeroFill($ticket['number'], 4);
    $status = "<i class=\"fa-sharp fa-solid fa-hexagon-check color-green fs-4\"></i>";
    $code .= "<tr>";
    $code .= "<td class=\"text-center align-middle\"><a href='/crm/tickets/view/" . $ticket['ticket'] . "'>" . $ticket['ticket'] . "</a></td>";
    $code .= "<td class=\"text-center align-middle\">$number</td>";
    $code .= "<td class=\"text-center align-middle\">{$ticket['created_at'] }</td>";

    $waitingTime = $waiting;
    list($hours, $minutes, $seconds) = explode(':', $waitingTime);
    $waitingTimeInSeconds = $hours * 3600 + $minutes * 60 + $seconds;


    $thresholdTime = "03:00:00";
    list($hours, $minutes, $seconds) = explode(':', $thresholdTime);
    $thresholdTimeInSeconds = $hours * 3600 + $minutes * 60 + $seconds;


    if ($waitingTimeInSeconds > $thresholdTimeInSeconds) {
        $code .= "<td class=\"text-center align-middle\"><a href=\"/crm/tickets/delete/{$ticket['ticket']}\" target=\"_blank\">{$waiting}</a></td>";
    } else {
        if ($waiting == "00:00:00") {
            $code .= "<td class=\"text-center align-middle\"><a href=\"/crm/tickets/edit/{$ticket['ticket']}\" target=\"_blank\">{$waiting}</a></td>";
        } else {
            $code .= "<td class=\"text-center align-middle\">{$waiting}</td>";
        }

    }


    $code .= "<td class=\"text-center align-middle\">{$ticket['time']}</td>";
    $code .= "<td class=\"text-center align-middle\">{$ticket['elapsed']}</td>";
    $code .= "<td class=\"text-center align-middle\">{$status}</td>";
    $code .= "</tr>";
    $sprevioustime = $ticket['time'];
}
$code .= "</tbody>";
$code .= "</table>";


/**
 * Para calcular el promedio de la columna "elapsed", primero necesitamos convertir cada tiempo de
 * formato HH:MM:SS a segundos, sumar todos los tiempos y luego dividir por el número total de tickets.
 * Finalmente, convertimos el promedio de segundos de vuelta a formato HH:MM:SS
 */
$totalSeconds = 0;
$totalTickets = count($tickets);
foreach ($tickets as $ticket) {
    if (!is_null($ticket['elapsed']) && (preg_match("/^([01][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/", $ticket['elapsed']))) {
        // $ticket['elapsed'] está en formato HH:MM:SS
        list($hours, $minutes, $seconds) = explode(':', $ticket['elapsed']);
        $totalSeconds += $hours * 3600 + $minutes * 60 + $seconds;
    } else {
        // $ticket['elapsed'] no está en formato HH:MM:SS
        $totalSeconds += 0;
    }
}
$averageSeconds = $totalSeconds / $totalTickets;// Calculamos las horas en enteros.
$hours = (int)floor($averageSeconds / 3600);
$secondsAfterHours = $averageSeconds - ($hours * 3600);// Restamos las horas (ya convertidas a segundos) del total de segundos.
$minutes = (int)floor($secondsAfterHours / 60);// Calculamos los minutos en enteros.
$seconds = (int)round($secondsAfterHours - ($minutes * 60));// Restamos los minutos (ya convertidos a segundos) de los segundos que quedan después de las horas.
$averageElapsed = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);

/**  Tiempo de espera  $stats **/
$totalSeconds = 0;
$totalTickets = count($tickets);
foreach ($tickets as $ticket) {
    $created_time_at = date("H:i:s", strtotime($ticket['created_at']));
    $awaiting = $dates->get_ElapsedTime($created_time_at, $ticket['time']);
    $waiting = $awaiting['hours'] . ":" . $awaiting['minutes'] . ":" . $awaiting['seconds'];
    if (!is_null($waiting) && (preg_match("/^([01][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/", $waiting))) {
        // $ticket['elapsed'] está en formato HH:MM:SS
        list($hours, $minutes, $seconds) = explode(':', $waiting);
        $totalSeconds += $hours * 3600 + $minutes * 60 + $seconds;
    } else {
        // $ticket['elapsed'] no está en formato HH:MM:SS
        $totalSeconds += 0;
    }
}
$averageSeconds = $totalSeconds / $totalTickets;// Calculamos las horas en enteros.
$hours = (int)floor($averageSeconds / 3600);
$secondsAfterHours = $averageSeconds - ($hours * 3600);// Restamos las horas (ya convertidas a segundos) del total de segundos.
$minutes = (int)floor($secondsAfterHours / 60);// Calculamos los minutos en enteros.
$seconds = (int)round($secondsAfterHours - ($minutes * 60));// Restamos los minutos (ya convertidos a segundos) de los segundos que quedan después de las horas.
$averageTime = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);


$stats = "<table class='table table-striped table-bordered table-hover p-0 m-0'>";
$stats .= "<thead>";
$stats .= "<tr>";
$stats .= "<th class=\"text-center w-50\">Datos</th>";
$stats .= "<th class=\"text-center w-50\">Resultados</th>";
$stats .= "</tr>";
$stats .= "</thead>";
$stats .= "<tbody>";
$stats .= "<tr>";
$stats .= "<td class=\"text-right\">Total de Turnos Atendidos</td>";
$stats .= "<td class=\"text-right\">" . count($tickets) . "</td>";
$stats .= "</tr>";
$stats .= "<tr>";
$stats .= "<td class=\"text-right\">Tiempo promedio de atención</td>";
$stats .= "<td class=\"text-right\">" . $averageElapsed . "</td>";
$stats .= "</tr>";
$stats .= "<tr>";
$stats .= "<td class=\"text-right\">Tiempo promedio de espera</td>";
$stats .= "<td class=\"text-right\">" . $averageTime . "</td>";
$stats .= "</tr>";
$stats .= "</tbody>";
$stats .= "</table>";


$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => "Estadisticas de Turnos Atendidos entre {$r["start"]} y {$r["end"]}",
    "header-back" => $back,
    "content" => $stats,
));
echo($card);


//[build]---------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => "Turnos Atendidos entre {$r["start"]} y {$r["end"]} ",
    "header-back" => $back,
    "content" => $code,
));
echo($card);
?>