<?php
$bootstrap = service('bootstrap');
$request = service('request');


$limit = 3;
$offset = $request->getVar('offset');
$offset = $offset ? intval($offset) : 0;
$total = count($customers);

$table = "<table class='table table-striped table-hover table-sm'>";
$table .= "<thead>";
$table .= "<tr>";
$table .= "<th scope='col'>#</th>";
$table .= "<th scope='col'>Cliente</th>";
$table .= "<th scope='col'>Matricula</th>";
$table .= "<th scope='col'>Detalles</th>";
$table .= "<th scope='col'>Opciones</th>";
$table .= "</tr>";
$table .= "</thead>";
$table .= "<tbody>";

for ($i = $offset; $i < $offset + $limit; $i++) {
    if (isset($customers[$i])) {
        $customer = $customers[$i];
        $details = "{$customer['registration']}<br>{$customer['address']}";
        $table .= "<tr>";
        $table .= "<th scope='row'>" . ($i + 1) . "</th>";
        $table .= "<td>{$customer['customer']}</td>";
        $table .= "<td>{$details}</td>";
        $table .= "<td>{$customer['names']}</td>";
        $table .= "<td>";
        //$table .= "<a href='#' class='btn btn-sm btn-primary'><i class='fas fa-edit'></i></a>";
        //$table .= "<a href='#' class='btn btn-sm btn-danger'><i class='fas fa-trash'></i></a>";
        $table .= "</td>";
        $table .= "</tr>";
    }
}

$table .= "</tbody>";
$table .= "</table>";


// Calcula el número total de páginas
$total_paginas = ceil($total / $limit);
// Calcula la posición inicial y final del rango visible
$rango_paginas = 10;
$pagina_inicial = max(1, $offset - floor($rango_paginas / 2));
$pagina_final = min($total_paginas, $pagina_inicial + $rango_paginas - 1);
// Asegúrate de que el rango sea válido
$pagina_inicial = max(1, $pagina_final - $rango_paginas + 1);
// Imprime el paginador usando Bootstrap 5
$table .= '<nav aria-label="Page navigation"><ul class="pagination">';
// Botón para la primera página
$table .= '<li class="page-item';
$table .= ($offset <= 0) ? ' disabled' : '';
$table .= '"><a class="page-link" href="?route=' . $route . '&offset=0" aria-label="First"><span aria-hidden="true">&laquo;&laquo;</span></a></li>';
// Botón para la página anterior
$table .= '<li class="page-item';
$table .= ($offset <= 0) ? ' disabled' : '';
$table .= '"><a class="page-link" href="?route=' . $route . '&offset=' . max(0, $offset - $limit) . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
// Enlaces para las páginas
for ($i = $pagina_inicial; $i <= $pagina_final; $i++) {
    $table .= '<li class="page-item';
    $table .= ($offset == ($i - 1) * $limit) ? ' active' : '';
    $table .= '"><a class="page-link" href="?route=' . $route . '&offset=' . (($i - 1) * $limit) . '">' . $i . '</a></li>';
}
// Botón para la página siguiente
$table .= '<li class="page-item';
$table .= ($offset >= ($total_paginas - 1) * $limit) ? ' disabled' : '';
$table .= '"><a class="page-link" href="?route=' . $route . '&offset=' . min(($total_paginas - 1) * $limit, $offset + $limit) . '" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
// Botón para la última página
$table .= '<li class="page-item';
$table .= ($offset >= ($total_paginas - 1) * $limit) ? ' disabled' : '';
$table .= '"><a class="page-link" href="?route=' . $route . '&offset=' . (($total_paginas - 1) * $limit) . '" aria-label="Last"><span aria-hidden="true">&raquo;&raquo;</span></a></li>';
$table .= '</ul></nav>';


//[build]-----------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("option-" . lpk(), array(
    "class" => "mb-3",
    "title" => "Clientes en la ruta #{$route}",
    "header-back" => "/cadastre/maps/home/" . lpk(),
    "text-class" => "text-center",
    "content" => $table,
));
echo($card);

use setasign\Fpdi\Fpdi;

require_once(APPPATH . 'ThirdParty/FPDF/fpdf.php');
require_once(APPPATH . 'ThirdParty/FPDI/autoload.php');

$pdf = new Fpdi();
$pdf->AddPage();
$pdf->setSourceFile(PUBLICPATH . "/pdfs/formato-aguas.pdf");
$tplId = $pdf->importPage(1);
$pdf->useTemplate($tplId, 10, 10, 190);

if (isset($customers[$offset])) {
    $linea1 = 40;
    $customer = $customers[$offset];
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetXY(20, $linea1);
    $pdf->Cell(0, 1, substr($customer['registration'], -10), 0, 1, 'L');
    $pdf->SetXY(50, $linea1);
    $pdf->Cell(0, 1, substr($customer['names'], 0, 23), 0, 1, 'L');
    $pdf->SetXY(120, $linea1);
    $pdf->Cell(0, 1, $customer['address'], 0, 1, 'L');
    $linea2 = $linea1 + 12.5;
    $pdf->SetXY(144, $linea2);
    $pdf->Cell(0, 1, "R" . $customer['reading_route'] . "P" . intval($customer['registration']), 0, 1, 'L');
}
if (isset($customers[$offset + 1])) {
    $linea1 = 122;
    $customer = $customers[$offset + 1];
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetXY(20, $linea1);
    $pdf->Cell(0, 1, substr($customer['registration'], -10), 0, 1, 'L');
    $pdf->SetXY(50, $linea1);
    $pdf->Cell(0, 1, substr($customer['names'], 0, 23), 0, 1, 'L');
    $pdf->SetXY(120, $linea1);
    $pdf->Cell(0, 1, $customer['address'], 0, 1, 'L');
    $linea2 = $linea1 + 12.5;
    $pdf->SetXY(144, $linea2);
    $pdf->Cell(0, 1, "R" . $customer['reading_route'] . "P" . intval($customer['registration']), 0, 1, 'L');
}
if (isset($customers[$offset + 2])) {
    $linea1 = 203;
    $customer = $customers[$offset + 2];
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetXY(20, $linea1);
    $pdf->Cell(0, 1, substr($customer['registration'], -10), 0, 1, 'L');
    $pdf->SetXY(50, $linea1);
    $pdf->Cell(0, 1, substr($customer['names'], 0, 23), 0, 1, 'L');
    $pdf->SetXY(120, $linea1);
    $pdf->Cell(0, 1, $customer['address'], 0, 1, 'L');
    $linea2 = $linea1 + 12.5;
    $pdf->SetXY(144, $linea2);
    $pdf->Cell(0, 1, "R" . $customer['reading_route'] . "P" . intval($customer['registration']), 0, 1, 'L');
}

$buffer = $pdf->Output('', 'S');
$pdf_base64 = base64_encode($buffer);


$html = '<iframe width="100%" height="1200" src="data:application/pdf;base64,' . $pdf_base64 . '"></iframe>';

echo($html);
?>