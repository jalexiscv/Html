<?php


/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-01-20 20:43:28
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Crm\Views\Tickets\Creator\form.php]
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
//[services]------------------------------------------------------------------------------------------------------------
$b = service("bootstrap");
$f = service("forms", array("lang" => "Tickets."));
//[models]--------------------------------------------------------------------------------------------------------------
$mtickets = model("App\Modules\Crm\Models\Crm_Tickets");
//[vars]----------------------------------------------------------------------------------------------------------------
$next = $mtickets->get_NextTicketNumber();
$r["ticket"] = $f->get_Value("ticket", pk());
$r["number"] = $f->get_Value("number", $next);
$r["agent"] = $f->get_Value("agent", "");
$r["date"] = $f->get_Value("date", service("dates")::get_Date());
$r["time"] = $f->get_Value("time", service("dates")::get_Time());
$r["status"] = $f->get_Value("status", "WAITING");
$r["author"] = $f->get_Value("author", safe_get_user());
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");
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
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["ticket"] . $f->fields["number"] . $f->fields["agent"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($code)));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["date"] . $f->fields["time"] . $f->fields["status"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card("create", array(
    "title" => lang("Tickets.create-title"),
    "content" => $f,
    "header-back" => $back
));
echo($card);
?>