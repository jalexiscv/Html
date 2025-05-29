<?php
$code = "<!-- Modal de Confirmación -->\n";
$code .= "<div class=\"modal fade\" id=\"confirmarEliminacionModal\" tabindex=\"-1\" aria-labelledby=\"confirmarEliminacionModalLabel\" aria-hidden=\"true\">\n";
$code .= "\t\t<div class=\"modal-dialog\">\n";
$code .= "\t\t\t\t<div class=\"modal-content\">\n";
$code .= "\t\t\t\t\t\t<div class=\"modal-header\">\n";
$code .= "\t\t\t\t\t\t\t\t<h5 class=\"modal-title\" id=\"confirmarEliminacionModalLabel\">Confirmar Eliminación</h5>\n";
$code .= "\t\t\t\t\t\t\t\t<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>\n";
$code .= "\t\t\t\t\t\t</div>\n";
$code .= "\t\t\t\t\t\t<div class=\"modal-body\">\n";
$code .= "\t\t\t\t\t\t\t\t¿Está seguro de que desea eliminar esta observación?\n";
$code .= "\t\t\t\t\t\t</div>\n";
$code .= "\t\t\t\t\t\t<div class=\"modal-footer\">\n";
$code .= "\t\t\t\t\t\t\t\t<button type=\"button\" class=\"btn btn-danger\" id=\"btnConfirmarEliminacion\" onclick='deleteObservation()'>Eliminar</button>\n";
$code .= "\t\t\t\t\t\t\t\t<button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\" >Cancelar</button>\n";
$code .= "\t\t\t\t\t\t</div>\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t</div>\n";
$code .= "</div>\n";
echo($code);
?>