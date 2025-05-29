<?php
$code = "<!-- Modal -->\n";
$code .= "<div class=\"modal fade\" id=\"observacionModal\" tabindex=\"-1\" aria-labelledby=\"observacionModalLabel\" aria-hidden=\"true\">\n";
$code .= "\t\t<div class=\"modal-dialog\">\n";
$code .= "\t\t\t\t<div class=\"modal-content\">\n";
$code .= "\t\t\t\t\t\t<div class=\"modal-header\">\n";
$code .= "\t\t\t\t\t\t\t\t<h5 class=\"modal-title\" id=\"observacionModalLabel\">Agregar Observación</h5>\n";
$code .= "\t\t\t\t\t\t\t\t<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>\n";
$code .= "\t\t\t\t\t\t</div>\n";
$code .= "\t\t\t\t\t\t<div class=\"modal-body\">\n";
$code .= "\t\t\t\t\t\t\t\t<form id=\"observacionForm\">\n";
$code .= "\t\t\t\t\t\t\t\t\t\t<div class=\"mb-3\">\n";
$code .= "\t\t\t\t\t\t\t\t\t\t\t\t<label for=\"type\" class=\"form-label\">Tipo de Observación</label>\n";
$code .= "\t\t\t\t\t\t\t\t\t\t\t\t<select class=\"form-select\" id=\"type\" required>\n";

$listTypesObservations = LIST_TYPES_OBSERVATIONS;
$defaultOption = array_filter($listTypesObservations, function ($item) {
    return $item['value'] === '';
});
$sortedOptions = array_filter($listTypesObservations, function ($item) {
    return $item['value'] !== '';
});
usort($sortedOptions, function ($a, $b) {
    return strcmp($a['label'], $b['label']);
});
$listTypesObservations = array_merge($defaultOption, $sortedOptions);
foreach ($listTypesObservations as $type) {
    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t<option value=\"{$type['value']}\">{$type['label']}</option>\n";
}
$code .= "\t\t\t\t\t\t\t\t\t\t\t\t</select>\n";
$code .= "\t\t\t\t\t\t\t\t\t\t</div>\n";
$code .= "\t\t\t\t\t\t\t\t\t\t<div class=\"mb-3\">\n";
$code .= "\t\t\t\t\t\t\t\t\t\t\t\t<label for=\"content\" class=\"form-label\">Observación</label>\n";
$code .= "\t\t\t\t\t\t\t\t\t\t\t\t<textarea class=\"form-control\" id=\"content\" rows=\"3\" required></textarea>\n";
$code .= "\t\t\t\t\t\t\t\t\t\t</div>\n";
$code .= "\t\t\t\t\t\t\t\t</form>\n";
$code .= "\t\t\t\t\t\t</div>\n";
$code .= "\t\t\t\t\t\t<div class=\"modal-footer\">\n";
$code .= "\t\t\t\t\t\t\t\t<button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Cerrar</button>\n";
$code .= "\t\t\t\t\t\t\t\t<button type=\"button\" class=\"btn btn-primary\" onclick=\"guardarObservation()\">Guardar</button>\n";
$code .= "\t\t\t\t\t\t</div>\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t</div>\n";
$code .= "</div>\n";

echo($code);

?>