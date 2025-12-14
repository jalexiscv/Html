<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-05-01 08:14:06
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
 * █ @var object $mregistrations Modelo de datos utilizado en la vista y trasferido desde el index
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
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
    "area" => $f->get_Value("area"),
    "stratum" => $f->get_Value("stratum"),
    "transport_method" => $f->get_Value("transport_method"),
    "sisben_group" => $f->get_Value("sisben_group"),
    "sisben_subgroup" => $f->get_Value("sisben_subgroup"),
    "document_issue_place" => $f->get_Value("document_issue_place"),
    "blood_type" => $f->get_Value("blood_type"),
    "marital_status" => $f->get_Value("marital_status"),
    "number_children" => $f->get_Value("number_children"),
    "military_card" => $f->get_Value("military_card"),
    "ars" => $f->get_Value("ars"),
    "insurer" => $f->get_Value("insurer"),
    "eps" => $f->get_Value("eps"),
    "education_level" => $f->get_Value("education_level"),
    "occupation" => $f->get_Value("occupation"),
    "health_regime" => $f->get_Value("health_regime"),
    "document_issue_date" => $f->get_Value("document_issue_date"),
    "saber11" => $f->get_Value("saber11"),
);
$row = $mregistrations->getRegistration($d["registration"]);
$l["back"] = "/sie/agreements/list/" . lpk();
$l["edit"] = "/sie/registrations/edit/{$d["registration"]}";
$asuccess = "sie/registrations-create-success-message.mp3";
$aexist = "sie/registrations-create-exist-message.mp3";

//$edit = $mregistrations->update($d['registration'], $d);

$c = view($component . '\Forms\form3', $parent->get_Array());


echo($c);
?>