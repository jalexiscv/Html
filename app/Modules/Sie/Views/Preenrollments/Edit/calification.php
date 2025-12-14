<?php
$credits = !empty($credits) ? $credits : 0;
$last_calification = "";
$module = 0;

if (!empty($execution['execution'])) {
    $origen = "execution";
    $creditsearned = 0;
    $uc1 = @$execution['c1'];
    $uc2 = @$execution['c2'];
    $uc3 = @$execution['c3'];
    if (($uc1 >= 80) && ($uc2 >= 80) && ($uc3 >= 80)) {
        $creditsearned = $credits;
    }
    $ct = round(($uc1 + $uc2 + $uc3) / 3, 2);
    $module = 1;
    $last_calification = "<table class=\"table table-bordered mb-0\">";
    $last_calification .= "<tr>";
    $last_calification .= "<td colspan='4'>E-{$execution['execution']}</td>";
    $last_calification .= "</tr>";
    $last_calification .= "<tr>";
    $last_calification .= "<tr>";
    $last_calification .= "<td>UC1</td>";
    $last_calification .= "<td>UC2</td>";
    $last_calification .= "<td>UC3</td>";
    $last_calification .= "<td>T</td>";
    $last_calification .= "</tr>";
    $last_calification .= "<tr>";
    $cuc1 = ($execution['c1'] < 80) ? 'text-bg-danger' : '';
    $cuc2 = ($execution['c2'] < 80) ? 'text-bg-danger' : '';
    $cuc3 = ($execution['c3'] < 80) ? 'text-bg-danger' : '';
    $cct = ($ct < 80) ? 'text-bg-danger' : '';
    $last_calification .= "<td class=\"{$cuc1}\">{$uc1}</td>";
    $last_calification .= "<td class=\"{$cuc2}\">{$uc2}</td>";
    $last_calification .= "<td class=\"{$cuc3}\">{$uc3}</td>";
    $last_calification .= "<td class=\"{$cct}\">{$ct}</td>";
    $last_calification .= "</tr>";
    $last_calification .= "<tr>";
    // Statuses
    $p1 = ($execution['c1'] < 80) ? 1 : 0;
    $p2 = ($execution['c2'] < 80) ? 1 : 0;
    $p3 = ($execution['c3'] < 80) ? 1 : 0;
    $pt = $p1 + $p2 + $p3;
    if ($ct < 80) {
        $last_calification .= "<td colspan=\"4\" class='text-bg-danger'>Aplazado</td>";
    } elseif ($pt > 1 && $ct >= 80) {
        $last_calification .= "<td colspan=\"4\" class='text-bg-warning'>Plan de mejora</td>";
    } elseif ($pt == 0 && $ct >= 80) {
        $last_calification .= "<td colspan=\"4\" class='text-bg-success'>Aprobado</td>";
    } else {
        $last_calification .= "<td colspan=\"4\" class='text-bg-warning'>Plan de mejora</td>";
    }
    $last_calification .= "</tr>";
    $last_calification .= "</table>";
} elseif (!empty($progress['c1']) && !empty($progress['c2']) && !empty($progress['c3'])) {
    $origen = "progress";
    $creditsearned = 0;
    $uc1 = @$progress['c1'];
    $uc2 = @$progress['c2'];
    $uc3 = @$progress['c3'];
    if (($uc1 >= 80) && ($uc2 >= 80) && ($uc3 >= 80)) {
        $creditsearned = $credits;
    }
    $ct = round(($uc1 + $uc2 + $uc3) / 3, 2);
    $module = 1;
    $last_calification = "<table class=\"table table-bordered mb-0 \">";
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
    $cuc1 = ($uc1 < 80) ? 'text-bg-danger' : '';
    $cuc2 = ($uc2 < 80) ? 'text-bg-danger' : '';
    $cuc3 = ($uc3 < 80) ? 'text-bg-danger' : '';
    $cct = ($ct < 80) ? 'text-bg-danger' : '';
    $last_calification .= "<td class=\"{$cuc1}\">{$uc1}</td>";
    $last_calification .= "<td class=\"{$cuc2}\">{$uc2}</td>";
    $last_calification .= "<td class=\"{$cuc3}\">{$uc3}</td>";
    $last_calification .= "<td class=\"{$cct}\">{$ct}</td>";
    $last_calification .= "</tr>";
    $last_calification .= "<tr>";
    // Statuses
    $p1 = ($progress['c1'] < 80) ? 1 : 0;
    $p2 = ($progress['c2'] < 80) ? 1 : 0;
    $p3 = ($progress['c3'] < 80) ? 1 : 0;
    $pt = $p1 + $p2 + $p3;
    if ($ct < 80) {
        $last_calification .= "<td colspan=\"4\" class='text-bg-danger'>Aplazado</td>";
    } elseif ($pt > 1 && $ct >= 80) {
        $last_calification .= "<td colspan=\"4\" class='text-bg-warning'>Plan de mejora</td>";
    } elseif ($pt == 0 && $ct >= 80) {
        $last_calification .= "<td colspan=\"4\" class='text-bg-success'>Aprobado</td>";
    } else {
        $last_calification .= "<td colspan=\"4\" class='text-bg-warning'>Plan de mejora</td>";
    }
    $last_calification .= "</tr>";
    $last_calification .= "</table>";
} else {
    $origen = "else";
    $creditsearned = 0;
    $ct = 0;
    $module = 0;
}

echo(json_encode(
    array(
        'origen' => $origen,
        'creditsearned' => $creditsearned,
        'render' => $last_calification,
        'average' => $ct,
        'module' => $module,
    )
));
?>