<?php

/*
 * @var object $parent Objeto padre, transferido desde el controlador.
 * @var \App\Libraries\Authentication $authentication Servicio de autenticación, transferido desde el controlador.
 * @var \Higgs\HTTP\IncomingRequest $request Objeto de la solicitud HTTP, transferido desde el controlador.
 * @var \App\Libraries\Dates $dates Objeto de fechas, transferido desde el controlador.
 * @var string $component Componente actual, transferido desde el controlador.
 * @var string $view Vista actual, transferida desde el controlador.
 * @var string $oid Identificador del objeto (Object ID), transferido desde el controlador.
 * @var string $views Ruta a las vistas, transferida desde el controlador.
 * @var string $prefix Prefijo utilizado, transferido desde el controlador.
 * @var array $data Datos adicionales para la vista, transferidos desde el controlador.
 * @var object $model Modelo de datos, transferido desde el controlador.
 */

//[Services]------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
$f = service("forms", array("lang" => "Observations."));
//[Request]-------------------------------------------------------------------------------------------------------------

$code = "";
$code .= "\t\t\t\t\t\t\t\t<h5 class=\"card-title text-success\">\n";
$code .= "\t\t\t\t\t\t\t\t\t\t<i class=\"fa-solid fa-file-check me-2\"></i>\n";
$code .= "\t\t\t\t\t\t\t\t\t\t¡Su reporte se generó exitosamente!\n";
$code .= "\t\t\t\t\t\t\t\t</h5>\n";
$code .= "\t\t\t\t\t\t\t\t<p class=\"card-text\">\n";
$code .= "\t\t\t\t\t\t\t\t\t\tSi la descarga automática no se inicio, presione el botón de descarga manual para concretar el proceso.\n";
$code .= "\t\t\t\t\t\t\t\t</p>\n";
$code .= "\t\t\t\t\t\t\t\t<div class=\"d-grid gap-2\">\n";
$code .= "\t\t\t\t\t\t\t\t\t\t<a href=\"/sie/documents/observations/individual/{$oid}\" class=\"btn btn-success\">\n";
$code .= "\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"fa-solid fa-download me-2\"></i>\n";
$code .= "\t\t\t\t\t\t\t\t\t\t\t\tDescarga Manual\n";
$code .= "\t\t\t\t\t\t\t\t\t\t</a>\n";
$code .= "\t\t\t\t\t\t\t\t</div>\n";


$back = "/sie/students/view/{$oid}#observations";
//[build]---------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card2("card-view-service", array(
    "header-title" => lang("Sie_Observations.reports-individual-view-title"),
    "header-class" => "bg-success text-white",
    "header-back" => $back,
    "content" => $code,
));
echo($card);
?>