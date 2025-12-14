<?php

/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2023-12-01 23:19:27
 *  ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 *  ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 *  ** █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 *  ** █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 *  ** █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 *  ** █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 *  ** █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 *  ** █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 *  ** █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 *  ** █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 *  ** █ @link https://www.codehiggs.com
 *  ** █ @Version 1.5.0 @since PHP 7, PHP 8
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ Datos recibidos desde el controlador - @ModuleController
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */
//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[Models]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Sie_Registrations."));
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$d = array(
    "registration" => $f->get_Value("registration"),
    "agreement" => $f->get_Value("agreement"),
    "period" => $f->get_Value("period"),
    "journey" => $f->get_Value("journey"),
    "program" => $f->get_Value("program"),
    "first_name" => $f->get_Value("first_name"),
    "second_name" => $f->get_Value("second_name"),
    "first_surname" => $f->get_Value("first_surname"),
    "second_surname" => $f->get_Value("second_surname"),
    "identification_type" => $f->get_Value("identification_type"),
    "identification_number" => $f->get_Value("identification_number"),
    "gender" => $f->get_Value("gender"),
    "email_address" => $f->get_Value("email_address"),
    "phone" => $f->get_Value("phone"),
    "mobile" => $f->get_Value("mobile"),
    "birth_date" => $f->get_Value("birth_date"),
    "birth_city" => $f->get_Value("birth_city"),
    "address" => $f->get_Value("address"),
    "residence_city" => $f->get_Value("residence_city"),
    "neighborhood" => $f->get_Value("neighborhood"),
);
$row = $mregistrations->getRegistration($d["registration"]);
$l["back"] = "/sie/agreements/list/" . lpk();
$l["edit"] = "/sie/registrations/edit/{$d["registration"]}";
$asuccess = "sie/registrations-create-success-message.mp3";
$aexist = "sie/registrations-create-exist-message.mp3";
if (is_array($row)) {
    $edit = $mregistrations->update($d['registration'], $d);
    $c = view($component . '\Forms\form2', $parent->get_Array());
} else {
    $create = $mregistrations->insert($d);

    $c = view($component . '\Forms\form2', $parent->get_Array());
}
echo($c);
?>