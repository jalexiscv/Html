<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-10-21 21:56:09
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Registrations\Creator\processor.php]
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
 * █ @link https://www.higgs.com.co
 * █ @Version 1.5.1 @since PHP 8,PHP 9
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
$server = service("server");
//[Models]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Sie_Registrations."));
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$morders = model('App\Modules\Sie\Models\Sie_Orders');
$mitems = model('App\Modules\Sie\Models\Sie_Orders_Items');
$mstatuses = model("App\Modules\Sie\Models\Sie_Statuses");
//[Vars]-----------------------------------------------------------------------------
$maxTicket = $morders->selectMax('ticket')->first();
$newTicket = $maxTicket['ticket'] + 1;

$back = "https://" . $server->get_Name();

$option = $f->get_Value("option");

$d = array(
    "registration" => $f->get_Value("registration"),
    "period" => $f->get_Value("period"),
    "journey" => $f->get_Value("journey"),
    "program" => $f->get_Value("program"),
    "first_name" => safe_strtoupper($f->get_Value("first_name")),
    "second_name" => safe_strtoupper($f->get_Value("second_name")),
    "first_surname" => safe_strtoupper($f->get_Value("first_surname")),
    "second_surname" => safe_strtoupper($f->get_Value("second_surname")),
    "identification_type" => $f->get_Value("identification_type"),
    "identification_number" => $f->get_Value("identification_number"),
    "email_address" => safe_strtoupper($f->get_Value("email_address")),
    "phone" => $f->get_Value("phone"),
    "mobile" => $f->get_Value("mobile"),
    "gender" => $f->get_Value("gender"),
    "residence_country" => $f->get_Value("residence_country"),
    "residence_region" => $f->get_Value("residence_region"),
    "residence_city" => $f->get_Value("residence_city"),
    "author" => safe_get_user(),
);


if ($option == "agreements") {
    $d["agreement"] = $f->get_Value("agreement");
    $d["agreement_country"] = $f->get_Value("agreement_country");
    $d["agreement_region"] = $f->get_Value("agreement_region");
    $d["agreement_city"] = $f->get_Value("agreement_city");
    $d["agreement_institution"] = safe_strtoupper($f->get_Value("agreement_institution"));
}


$row = $mregistrations->getRegistrationByIdentification($d['identification_number']);

$l["back"] = "$back";
$l["edit"] = "/sie/registrations/edit/{$d["registration"]}";
$asuccess = "sie/registrations-create-success-message.mp3";
$aexist = "sie/registrations-create-exist-message.mp3";

$md = array(
    "facture" => pk(),
    "registration" => $d["registration"],
    "period" => $d["period"],
    "program" => $d["program"],
    "email" => $d["email_address"],
    "oid" => $d["registration"],
    "name" => $d["first_name"] . " " . $d["first_surname"],
);

if ($option == "agreements") {
    $send = view('App\Modules\Sie\Views\Registrations\Create\facturezero.php', $md);
    //$send = view('App\Modules\Sie\Views\Registrations\Create\mailer.php', $md);
} else {
    $send = view('App\Modules\Sie\Views\Registrations\Create\facture.php', $md);
    //$send = view('App\Modules\Sie\Views\Registrations\Create\mailer.php', $md);
}

if (!empty($row['registration'])) {
    include("existe.php");
} else {
    include("noexiste.php");
}

echo($c);
?>