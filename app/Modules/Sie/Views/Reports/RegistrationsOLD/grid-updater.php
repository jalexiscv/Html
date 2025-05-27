<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                                                    2024-02-12 10:12:28
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Home\breadcrumb.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2024 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                                                                         consulte la LICENCIA archivo que se distribuyó con este código fuente.
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
 * █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[vars]----------------------------------------------------------------------------------------------------------------
/** @var object $parent */
/** @var string $component */
/** @var string $view */
/** @var object $authentication */
/** @var object $request */
//[Services]-------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
//[Models]---------------------------------------------------------------------------------------------------------------
$mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');
$mprograms = model('App\Modules\Sie\Models\Sie_Programs');
$magreements = model('App\Modules\Sie\Models\Sie_Agreements');
$minstitutions = model('App\Modules\Sie\Models\Sie_Institutions');
$mcities = model('App\Modules\Sie\Models\Sie_Cities');
$mdiscounts = model("App\Modules\Sie\Models\Sie_Discounts");
$mdiscounteds = model("App\Modules\Sie\Models\Sie_Discounteds");
$mstatuses = model("App\Modules\Sie\Models\Sie_Statuses");
$mfields = model("App\Modules\Sie\Models\Sie_Users_Fields");

$period = $_GET['period'];
$program = $_GET['program'];
$status = "REGISTERED";

$registrations = $mregistrations->where("period", $period)->findAll();

echo("<table class='table-bordered'>");
$count = 0;
foreach ($registrations as $registration) {
    $count++;
    $registration_registration = @$registration['registration'];
    $registration_program = @$registration['program'];
    $registration_identification_type_ = @$registration['identification_type'];
    $registration_identification_number = @$registration['identification_number'];
    $registration_nombres = @$registration['first_name'] . " " . @$registration['second_name'];
    $registration_apellidos = @$registration['first_surname'] . " " . @$registration['second_surname'];
    $author = $mfields->get_Profile(@$registration['author']);
    $registration_date = @$registration['created_at'];


    echo("<tr>");
    echo("<td>$count</td>");
    echo("<td>$registration_registration</td>");
    echo("<td>$registration_identification_type_</td>");
    echo("<td>$registration_identification_number</td>");
    echo("<td>$registration_nombres</td>");
    echo("<td>$registration_apellidos</td>");
    echo("<td>" . @$author['name'] . "</td>");
    echo("<td>$registration_date</td>");
    echo("</tr>");

    if (!empty($registration_registration) && !empty($registration_program)) {
        $registration_date = empty($registration_date) ? "2024-08-05 07:29:36" : $registration_date;
        $date = date('Y-m-d', strtotime($registration_date));
        $time = date('H:i:s', strtotime($registration_date));
        $d = array(
            "status" => pk(),
            "registration" => $registration_registration,
            "program" => $registration_program,
            "cycle" => "1",
            "reference" => "REGISTERED",
            "date" => $date,
            "time" => $time,
            "author" => "SYSTEM",
            "locked_at" => $registration_date,
            "created_at" => $registration['created_at'],
            "import" => "TEST1",
        );
        $create = $mstatuses->insert($d);
    }

}
echo("</table>");