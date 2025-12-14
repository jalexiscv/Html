<?php
// Aumentar el tiempo de ejecución a 20 minutos (1200 segundos)
set_time_limit(1200);

// O usando ini_set
ini_set('max_execution_time', 1200);

require_once(APPPATH . 'ThirdParty/Mongo/autoload.php');


/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-04-02 14:14:04
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Databreaches\Views\Cases\Editor\processor.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
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
 * █ @var object $parent Trasferido desde el controlador
 * █ @var object $authentication Trasferido desde el controlador
 * █ @var object $request Trasferido desde el controlador
 * █ @var object $dates Trasferido desde el controlador
 * █ @var string $component Trasferido desde el controlador
 * █ @var string $view Trasferido desde el controlador
 * █ @var string $oid Trasferido desde el controlador
 * █ @var string $views Trasferido desde el controlador
 * █ @var string $prefix Trasferido desde el controlador
 * █ @var array $data Trasferido desde el controlador
 * █ @var object $model Modelo de datos utilizado en la vista y trasferido desde el index
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[services]------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
$f = service("forms", array("lang" => "Cases."));
//[vars]----------------------------------------------------------------------------------------------------------------
$mdatabreaches = model("App\Modules\Databreaches\Models\Databreaches_Mongo");
$case = $f->get_Value("case");
$search = $f->get_Value("search");
$identifier = $f->get_Value("identifier");
$filter = ['alias' => new MongoDB\BSON\Regex($search, 'i')];
$breaches = $mdatabreaches->findAll(100, 0, $filter);
$code = ("<table class=\"table table-bordered\">");
$code .= ("<tr>");
$code .= ("<th>Filtración</th>");
$code .= ("<th>Dato</th>");
$code .= ("<th>Filtrado</th>");
$code .= "</tr>";
foreach ($breaches as $breach) {
    $code .= ("<tr>");
    $code .= ("<td>" . @$breach->breach . "</td>");
    $code .= ("<td>" . @$breach->alias . "</td>");
    $code .= ("<td>" . @$breach->password . "</td>");
    $code .= "</tr>";
}
$code .= ("</table>");
//[build]---------------------------------------------------------------------------------------------------------------
$back = "/databreaches/cases/view/{$case}";
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => "Resultados",
    "header-back" => $back,
    "content" => $code,
    "content-class" => "px-2",
));
echo $card;
?>