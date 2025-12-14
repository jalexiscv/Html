<?php
/** @var string $limit */
/** @var string $offset */
/** @var string $page */

$bootstrap = service("bootstrap");
$request = service("request");
$numbers = service("numbers");
//[models]--------------------------------------------------------------------------------------------------------------
$mpayments = model("App\Modules\Sie\Models\Sie_Payments");
$morders = model("App\Modules\Sie\Models\Sie_Orders");
$mregistration = model('App\Modules\Sie\Models\Sie_Registrations');
$mcities = model('App\Modules\Sie\Models\Sie_Cities');
$mprograms = model('App\Modules\Sie\Models\Sie_Programs');
//[vars]----------------------------------------------------------------------------------------------------------------
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";

/**
 * array("content" => "#", "class" => "text-center	align-middle"),
 * array("content" => "payment", "class" => "text-center	align-middle"),
 * array("content" => "record_type", "class" => "text-center	align-middle"),
 * array("content" => "agreement", "class" => "text-center	align-middle"),
 * array("content" => "id_number", "class" => "text-center	align-middle"),
 * array("content" => "ticket", "class" => "text-center	align-middle"),
 * array("content" => "value", "class" => "text-center	align-middle"),
 * array("content" => "payment_origin", "class" => "text-center	align-middle"),
 * array("content" => "payment_methods", "class" => "text-center	align-middle"),
 * array("content" => "operation_number", "class" => "text-center	align-middle"),
 * array("content" => "authorization", "class" => "text-center	align-middle"),
 * array("content" => "financial_entity", "class" => "text-center	align-middle"),
 * array("content" => "branch", "class" => "text-center	align-middle"),
 * array("content" => "sequence", "class" => "text-center	align-middle"),
 * * array("content" => "Factura", "class" => "text-center	align-middle"),
 * array("content" => "Tipo Documento", "class" => "text-center	align-middle"),
 * array("content" => "No. de documento", "class" => "text-right	align-middle"),
 * array("content" => "Ciudad de nacimiento", "class" => "text-right	align-middle"),
 * array("content" => "Nombre completo", "class" => "text-right	align-middle"),
 * array("content" => "Dirección", "class" => "text-right	align-middle"),
 * array("content" => "Ciudad residencia", "class" => "text-right	align-middle"),
 * array("content" => "Teléfono", "class" => "text-right	align-middle"),
 * array("content" => "Correo", "class" => "text-right	align-middle"),
 * array("content" => "Programa", "class" => "text-right	align-middle"),
 * array("content" => "Momento", "class" => "text-right	align-middle"),
 * array("content" => "Valor pagado", "class" => "text-right	align-middle"),
 * array("content" => "Descuentos", "class" => "text-right	align-middle"),
 * array("content" => "Entidad Bancaria", "class" => "text-right	align-middle"),
 * array("content" => "Fecha de pago", "class" => "text-right	align-middle"),
 */


$payments = $mpayments->limit($limit, $offset)->find();
$totalRecords = $mpayments->countAll();

$code = "<table id=\"grid-table\" class='stretched-link table table-striped table-hover table-bordered'>";
$code .= "<thead>";
$code .= "<tr>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>#</th>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>Fecha</th>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>Hora</th>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>payment</th>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>record_type</th>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>agreement</th>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>id_number</th>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>ticket</th>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>value</th>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>payment_origin</th>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>payment_methods</th>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>operation_number</th>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>authorization</th>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>financial_entity</th>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>branch</th>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>sequence</th>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>Factura</th>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>Valor transaccionado</th>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>Fecha transacción</th>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>Entidad Bancaria</th>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>Tipo de documento</th>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>Documento identificación</th>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>Ciudad de Nacimiento</th>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>Nombre Completo</th>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>Dirección</th>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>Ciudad de residencia</th>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>Teléfono</th>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>Correo electrónico(Personal)</th>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>Programa académico</th>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>Ciclo</th>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>Momento</th>";
$code .= "<th class='text-center text-nowrap overflow-hidden'>Descuentos</th>";
$code .= "</tr>";
$code .= "</thead>";
$code .= "<tbody>";
$count = 0;

$count = ($page - 1) * $limit;
foreach ($payments as $payment) {
    $count++;
    $order = $morders->get_OrderByTicket($payment["ticket"]);
    $registration = $mregistration->getRegistration(@$order["user"]);
    $registration_registration = @$registration["registration"];
    $client_name = @$registration["first_name"] . " " . @$registration["second_name"] . " " . @$registration["first_surname"] . " " . @$registration["second_surname"];
    $residence_city = $mcities->get_City(@$registration["residence_city"]);
    $residence_city_name = safe_strtoupper(@$residence_city["name"]);
    $birth_city = $mcities->get_City(@$registration["birth_city"]);
    $birth_city_name = safe_strtoupper(@$birth_city["name"]);
    $program = $mprograms->getProgram(@$registration["program"]);
    $program_name = safe_strtoupper(@$program["name"]);
    $value = "<span class='opacity-25'>$</span> " . $numbers->to_Currency(@$payment["value"]);
    $identification_number = @$registration["identification_number"];
    $link = "<a href=\"/sie/students/view/{$registration_registration}#finance\" target='_blank'>{$identification_number}</a>";

    if (empty($program_name)) {
        $program_name = "<a href=\"/sie/students/view/{$registration_registration}#finance\" target=\"_blank\">Revisando</a>";
    }

    $code .= "<tr>";
    $code .= "<td>" . $count . "</td>";
    $code .= "<td>" . date('Y-m-d', strtotime($payment["created_at"])) . "</td>";
    $code .= "<td>" . date('H:i:s', strtotime($payment["created_at"])) . "</td>";
    $code .= "<td>" . $payment["payment"] . "</td>";
    $code .= "<td>" . $payment["record_type"] . "</td>";
    $code .= "<td>" . $payment["agreement"] . "</td>";
    $code .= "<td>" . $payment["id_number"] . "</td>";
    $code .= "<td>" . $payment["ticket"] . "</td>";
    $code .= "<td>" . $payment["value"] . "</td>";
    $code .= "<td>" . $payment["payment_origin"] . "</td>";
    $code .= "<td>" . $payment["payment_methods"] . "</td>";
    $code .= "<td>" . $payment["operation_number"] . "</td>";
    $code .= "<td>" . $payment["authorization"] . "</td>";
    $code .= "<td>" . $payment["financial_entity"] . "</td>";
    $code .= "<td>" . $payment["branch"] . "</td>";
    $code .= "<td>" . $payment["sequence"] . "</td>";
    $code .= "<td>" . @$order["ticket"] . "</td>";
    $code .= "<td class='text-end text-nowrap overflow-hidden'>{$value}</td>";
    $code .= "<td>" . date('Y-m-d', strtotime($payment["created_at"])) . "</td>";
    $code .= "<td class='text-center'>" . @$payment["financial_entity"] . "</td>";
    $code .= "<td class='text-center'>" . @$registration["identification_type"] . "</td>";
    $code .= "<td class='text-center'>{$link}</td>";
    $code .= "<td class='text-nowrap overflow-hidden'>{$birth_city_name}</td>";
    $code .= "<td class='text-nowrap overflow-hidden'>" . $client_name . "</td>";
    $code .= "<td class='text-nowrap overflow-hidden'>" . @$registration["address"] . "</td>";
    $code .= "<td class='text-nowrap overflow-hidden'>{$residence_city_name}</td>";
    $code .= "<td>" . @$registration["phone"] . "</td>";
    $code .= "<td class='text-nowrap overflow-hidden'>" . @$registration["email_address"] . "</td>";
    $code .= "<td class='text-nowrap overflow-hidden'>{$program_name}</td>";
    $code .= "<td>" . @$registration["moment"] . "</td>";
    $code .= "<td>" . @$order["discount"] . "</td>";
    $code .= "</tr>";
}
$code .= "</tbody>";
$code .= "</table>";
echo($code);
?>