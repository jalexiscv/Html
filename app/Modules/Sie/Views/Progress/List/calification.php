<?php
$credits = !empty($credits) ? $credits : 0;
$last_calification = "";
$module = 0;

$reference = "";
$uc1 = 0;
$uc2 = 0;
$uc3 = 0;
$ct = 0;



if (!empty($execution['execution'])) {
    $reference = "E-{$execution['execution']}";
    $creditsearned = 0;

    $uc1 = (float) @$execution['c1'];
    $uc2 = (float) @$execution['c2'];
    $uc3 = (float) @$execution['c3'];

    // Créditos ganados
    if ($uc1 >= 80 && $uc2 >= 80 && $uc3 >= 80) {
        $creditsearned = $credits;
    }

    // Promedio
    $ct = round(($uc1 + $uc2 + $uc3) / 3, 2);
    $module = 1;

    // Tabla
    $last_calification = "<table class=\"table table-bordered \">";
    $last_calification .= "<tr>";
    $last_calification .= "<td colspan='4'>E-{$execution['execution']}</td>";
    $last_calification .= "</tr>";
    $last_calification .= "<tr>";
    $last_calification .= "<td>UC1</td>";
    $last_calification .= "<td>UC2</td>";
    $last_calification .= "<td>UC3</td>";
    $last_calification .= "<td>T</td>";
    $last_calification .= "</tr>";
    $last_calification .= "<tr>";

    $cuc1 = ($uc1 < 80) ? 'execution-text-bg-primary' : '';
    $cuc2 = ($uc2 < 80) ? 'execution-text-bg-primary' : '';
    $cuc3 = ($uc3 < 80) ? 'execution-text-bg-primary' : '';
    $cct  = ($ct  < 80) ? 'execution-text-bg-primary' : '';

    $last_calification .= "<td class=\"{$cuc1}\">{$uc1}</td>";
    $last_calification .= "<td class=\"{$cuc2}\">{$uc2}</td>";
    $last_calification .= "<td class=\"{$cuc3}\">{$uc3}</td>";
    $last_calification .= "<td class=\"{$cct}\">{$ct}</td>";
    $last_calification .= "</tr>";

    // Estado
    list($estadoTexto, $estadoClass) = sie_calcStatusInExecution($uc1, $uc2, $uc3);
    $last_calification .= "<tr>";
    $last_calification .= "<td colspan=\"4\" class='{$estadoClass}'>{$estadoTexto}</td>";
    $last_calification .= "</tr>";
    $last_calification .= "</table>";

} elseif (!empty($progress['c1']) && !empty($progress['c2']) && !empty($progress['c3'])) {

    $reference = "P-{$progress['progress']}";
    $creditsearned = 0;

    $uc1 = (float) @$progress['c1'];
    $uc2 = (float) @$progress['c2'];
    $uc3 = (float) @$progress['c3'];

    // Créditos ganados
    if ($uc1 >= 80 && $uc2 >= 80 && $uc3 >= 80) {
        $creditsearned = $credits;
    }

    // Promedio
    $ct = round(($uc1 + $uc2 + $uc3) / 3, 2);
    $module = 1;

    // Tabla
    $last_calification = "<table class=\"table table-bordered \">";
    $last_calification .= "<tr>";
    $last_calification .= "<td colspan='4'>P-{$progress['progress']}</td>";
    $last_calification .= "</tr>";
    $last_calification .= "<tr>";
    $last_calification .= "<th>UC1</th>";
    $last_calification .= "<th>UC2</th>";
    $last_calification .= "<th>UC3</th>";
    $last_calification .= "<th>T</th>";
    $last_calification .= "</tr>";
    $last_calification .= "<tr>";

    $cuc1 = ($uc1 < 80) ? 'execution-text-bg-danger' : '';
    $cuc2 = ($uc2 < 80) ? 'execution-text-bg-danger' : '';
    $cuc3 = ($uc3 < 80) ? 'execution-text-bg-danger' : '';
    $cct  = ($ct  < 80) ? 'execution-text-bg-danger' : '';

    $last_calification .= "<td class=\"{$cuc1}\">{$uc1}</td>";
    $last_calification .= "<td class=\"{$cuc2}\">{$uc2}</td>";
    $last_calification .= "<td class=\"{$cuc3}\">{$uc3}</td>";
    $last_calification .= "<td class=\"{$cct}\">{$ct}</td>";
    $last_calification .= "</tr>";

    // Estado
    list($estadoTexto, $estadoClass) = sie_calcStatusInExecution($uc1, $uc2, $uc3);
    $last_calification .= "<tr>";
    $last_calification .= "<td colspan=\"4\" class='{$estadoClass}'>{$estadoTexto}</td>";
    $last_calification .= "</tr>";
    $last_calification .= "</table>";
} else {
    $creditsearned = 0;
    $ct = 0;
    $module = 0;
}

echo(json_encode(
    array(
        'reference'      => $reference,
        'uc1'            => @$uc1,
        'uc2'            => @$uc2,
        'uc3'            => @$uc3,
        'ct'             => @$ct,
        'creditsearned'  => $creditsearned,
        'render'         => $last_calification,
        'average'        => $ct,
        'module'         => $module,
    )
));
?>
