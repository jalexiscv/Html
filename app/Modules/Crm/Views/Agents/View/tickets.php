<?php
/** @var string $oid */

$strings = service("strings");
$dates = service("dates");
//[models]--------------------------------------------------------------------------------------------------------------
$magents = model('App\Modules\Crm\Models\Crm_Agents');
$mtickets = model('App\Modules\Crm\Models\Crm_Tickets');
//[vars]----------------------------------------------------------------------------------------------------------------
$tickets = $mtickets->get_TicketsByAgent($oid, 100, 0); //$dates->get_Date());
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
    $code .= "<td class=\"text-center align-middle\">{$waiting}</td>";
    $code .= "<td class=\"text-center align-middle\">{$ticket['time']}</td>";
    $code .= "<td class=\"text-center align-middle\">{$ticket['elapsed']}</td>";
    $code .= "<td class=\"text-center align-middle\">{$status}</td>";
    $code .= "</tr>";
    $sprevioustime = $ticket['time'];
}
$code .= "</tbody>";
$code .= "</table>";


//[build]---------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => "Labor Realizada",
    "header-back" => $back,
    "content" => $code,
));
echo($card);
?>