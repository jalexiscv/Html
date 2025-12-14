<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-01-20 20:54:15
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Crm\Views\Tickets\Editor\form.php]
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
 * █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
/** @var  $oid  es el numero del agente que atendera */
//[services]------------------------------------------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
$f = service("forms", array("lang" => "Tickets."));
//[models]--------------------------------------------------------------------------------------------------------------
$mtickets = model("App\Modules\Crm\Models\Crm_Tickets");
$magents = model("App\Modules\Crm\Models\Crm_Agents");
$agent = $oid;
//[vars]----------------------------------------------------------------------------------------------------------------
// El procedimiento es el siguiente:
// 1. Busca el ticket más antiguo con estado "WAITING"
// 2. Si encuentra un ticket, lo actualiza a "ATTENDED" y actualiza el tiempo de espera
// 3. Si no encuentra un ticket, muestra un mensaje de error y recarga la página
// 4. Si encuentra un ticket, muestra el ticket y el código de barras
$previous = $request->getGet("previous");
$row = $mtickets->get_LowestNumberTicketWithStatus('WAITING');
if (isset($row['ticket']) && !empty($row['ticket'])) {
    if (isset($previous) && !empty($previous)) {
        $previous = $mtickets->where('ticket', $previous)->first();
        $elapsed_array = $dates->get_ElapsedTime($previous['time'], $dates->get_Time());
        $elapsed = $elapsed_array['hours'] . ':' . $elapsed_array['minutes'] . ':' . $elapsed_array['seconds'];
        $mtickets->update($previous['ticket'], array('elapsed' => $elapsed, 'status' => 'ATTENDED', 'agent' => $agent));
    }
    $mtickets->update($row['ticket'], array('status' => 'ATTENDED', 'time' => $dates->get_Time(), 'agent' => $agent));

    $r["ticket"] = $f->get_Value("ticket", $row["ticket"]);
    $r["number"] = $f->get_Value("number", $row["number"]);
    $r["agent"] = $f->get_Value("agent", $agent);
    $r["date"] = $f->get_Value("date", service("dates")::get_Date());
    $r["time"] = $f->get_Value("time", service("dates")::get_Time());
    $r["status"] = $f->get_Value("status", $row["status"]);
    $r["author"] = $f->get_Value("author", safe_get_user());
    $r["created_at"] = $f->get_Value("created_at", $row["created_at"]);
    $r["updated_at"] = $f->get_Value("updated_at", $row["updated_at"]);
    $r["deleted_at"] = $f->get_Value("deleted_at", $row["deleted_at"]);
    $back = "/crm/tickets/list/" . lpk();

    $direccion = 'Cra 14 6-32 L 102, Buga - Valle del Cauca';
    $telefonos = '2395000';
    $email = 'info@aguasdebuga.com.co';
    $number = str_pad($r["number"], 3, "0", STR_PAD_LEFT);
    $generator = new \App\Libraries\Barcode\BarcodeGeneratorHTML();
    $codigo_barras = $generator->getBarcode($r["ticket"], $generator::TYPE_CODE_128);

    $code = "<link rel=\"stylesheet\" href=\"/themes/assets/css/tickets.css?v=" . lpk() . "\" type=\"text/css\">\n";
    $code .= "<div class=\"d-flex justify-content-center align-items-center\">\n";
    $code .= "\t<widget>\n";
    $code .= "\t\t<div class=\"row\">\n";
    $code .= "\t\t\t<div class=\"col text-center mt-4\">\n";
    $code .= "\t\t\t\t<h2>AGUAS DE BUGA S.A. E.S.P.</h2>\n";
    $code .= "\t\t\t\t<p><b>Código de registro</b>: {$r["ticket"]}</p>\n"; // Agrega código de registro
    $code .= "\t\t\t\t<p><b>Fecha</b>: {$r["date"]} <b>Hora</b>: {$r["time"]} </p>\n"; // Agrega fecha
    $code .= "\t\t\t\t<p></p>\n"; // Agrega hora
    $code .= "\t\t\t</div>\n";
    $code .= "\t\t</div>\n";
    $code .= "\t\t<div class=\"row mt-3\">\n"; // Agrega espacio en la parte superior para separar
    $code .= "\t\t\t<div class=\"col text-center\">\n";
    $code .= "\t\t\t\t<div class=\"number\">{$number}</div>\n"; // Número generado
    $code .= "\t\t\t</div>\n";
    $code .= "\t\t</div>\n";
    $code .= "\t\t<div class=\"row mt-3\">\n"; // Agrega espacio en la parte superior para separar
    $code .= "\t\t\t<div class=\"col text-center\">\n";
    $code .= "\t\t\t\t<p><b>Centro Experiencia al Usuario</b></p>\n"; // Agrega dirección
    $code .= "\t\t\t\t<p><b>Dirección</b>: $direccion</p>\n"; // Agrega dirección
    $code .= "\t\t\t\t<p><b>Números telefónicos</b>: $telefonos</p>\n"; // Agrega teléfonos
    $code .= "\t\t\t\t<p><b>Correo electrónico</b>: $email</p>\n"; // Agrega email
    $code .= "\t\t\t</div>\n";
    $code .= "\t\t</div>\n";
    $code .= "\t\t<div class=\"row mt-3 mb-3\">\n"; // Agrega espacio en la parte superior para separar
    $code .= "\t\t<div class=\"d-flex justify-content-center align-items-center\">\n";
    $code .= "\t\t\t\t<div class=\"barcode\">$codigo_barras</div>\n"; // Nuevo - código de barras
    $code .= "\t\t\t</div>\n";
    $code .= "\t\t</div>\n";
    $code .= "\t</widget>\n";
    $code .= "</div>\n";

//[fields]----------------------------------------------------------------------------------------------------------------
    $f->fields["ticket"] = $f->get_FieldText("ticket", array("value" => $r["ticket"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
    $f->fields["number"] = $f->get_FieldText("number", array("value" => $r["number"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
    $f->fields["agent"] = $f->get_FieldText("agent", array("value" => $r["agent"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
    $f->fields["date"] = $f->get_FieldText("date", array("value" => $r["date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
    $f->fields["time"] = $f->get_FieldText("time", array("value" => $r["time"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
    $f->fields["status"] = $f->get_FieldText("status", array("value" => $r["status"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
    $f->add_HiddenField("author", $r["author"]);
    $f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
    $f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
    $f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
    $f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
    $f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
    $f->fields["attend"] = $f->get_Button("attend", array("href" => "/crm/tickets/attend/{$r['agent']}?previous={$row["ticket"]}", "text" => "Atender Otro", "class" => "btn btn-danger", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
//[groups]----------------------------------------------------------------------------------------------------------------
    $f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["ticket"] . $f->fields["number"] . $f->fields["agent"])));
    $f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($code)));
    $f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["date"] . $f->fields["time"] . $f->fields["status"])));
///[buttons]-------------------------------------------------------------------------------------------------------------
    $f->groups["gy"] = $f->get_GroupSeparator();
    $f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["attend"]));
//[build]---------------------------------------------------------------------------------------------------------------
    $card = $bootstrap->get_Card("create", array(
        "title" => lang("Tickets.attend-title"),
        "content" => $f,
        "header-back" => $back
    ));
} else {
    if (isset($previous) && !empty($previous)) {
        $previous = $mtickets->where('ticket', $previous)->first();
        $elapsed_array = $dates->get_ElapsedTime($previous['time'], $dates->get_Time());
        $elapsed = $elapsed_array['hours'] . ':' . $elapsed_array['minutes'] . ':' . $elapsed_array['seconds'];
        $mtickets->update($previous['ticket'], array('elapsed' => $elapsed, 'status' => 'ATTENDED', 'agent' => $agent));
    }
    $card = $bootstrap->get_Card("create", array(
        "title" => lang("Tickets.attend-title"),
        "content" => "<div class='alert alert-danger'>No hay tickets pendientes por atender</div>",
    ));
    $code = "<script>\n";
    $code .= "\t\t// Establece un temporizador para recargar la página cada 3 segundos\n";
    $code .= "\t\tsetInterval(function () {\n";
    $code .= "\t\t\t\t// Recarga la página\n";
    $code .= "\t\t\t\tlocation.reload(true);\n";
    $code .= "\t\t}, 3000);\n";
    $code .= "</script>\n";
    echo($code);
}
echo($card);
?>
