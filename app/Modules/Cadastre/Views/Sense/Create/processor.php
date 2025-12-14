<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-06-21 20:03:04
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Cadastre\Views\Customers\Editor\processor.php]
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
//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
$server = service('Server');
//[Models]-----------------------------------------------------------------------------
$mcustomers = model("App\Modules\Cadastre\Models\Cadastre_Customers");
$mprofiles = model("App\Modules\Cadastre\Models\Cadastre_Profiles");
$mgeoreferences = model("App\Modules\Cadastre\Models\Cadastre_Georeferences");
$mattachments = model("App\Modules\Cadastre\Models\Cadastre_Attachments");
//[Process]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Customers."));
$d = array(
    "customer" => $f->get_Value("customer"),
    "registration" => $f->get_Value("registration"),
    "date" => $f->get_Value("date"),
    "time" => $f->get_Value("time"),
    "author" => safe_get_user(),
);

$profile = $mprofiles->where("customer", $d["customer"])->first();
$profile["profile"] = pk();
$profile["customer"] = $f->get_Value("customer");
$profile["citizenship_card"] = $f->get_Value("citizenship_card");
$profile["firstname"] = safe_trim($f->get_Value("firstname"));
$profile["lastname"] = safe_trim($f->get_Value("lastname"));
$profile["phone"] = $f->get_Value("phone");
$profile["email"] = $f->get_Value("email");
$profile["realestate_registration"] = $f->get_Value("realestate_registration");
$profile["pin"] = $f->get_Value("pin");
$profile["anotation"] = "CENSUS";
unset($profile["created_at"]);
unset($profile["updated_at"]);
unset($profile["deleted_at"]);
//print_r($profile);
//[Elements]------------------------------------------------------------------------------------------------------------
$row = $model->find($d["customer"]);
$l["back"] = "/cadastre/sense/home/{$d["customer"]}";
$l["edit"] = "/cadastre/customers/edit/{$d["customer"]}";
$asuccess = "cadastre/customers-edit-success-message.mp3";
$anoexist = "cadastre/customers-edit-noexist-message.mp3";
//[Build]---------------------------------------------------------------------------------------------------------------
if (is_array($row)) {
    //print_r($profile);
    $create = $mprofiles->insert($profile);
    //[attachments]-----------------------------------------------------------------------------------------------------
    $attachment = $request->getFile($f->get_fieldId("attachment"));
    $path = "/storages/" . md5($server::get_FullName()) . "/helpdesk/attachments";
    $realpath = ROOTPATH . "public" . $path;
    if (!file_exists($realpath)) {
        mkdir($realpath, 0777, true);
    }
    if ($attachment->isValid()) {
        $rname = $attachment->getRandomName();
        $attachment->move($realpath, $rname);
        $name = $attachment->getClientName();
        $type = $attachment->getClientMimeType();
        $size = $attachment->getSize();
        $uri = "{$path}/{$rname}";
        $attach = array(
            "attachment" => pk(),
            "object" => $profile["profile"],
            "file" => $uri,
            "type" => $type,
            "date" => $dates->get_Date(),
            "time" => $dates->get_Time(),
            "alt" => "",
            "title" => "",
            "size" => $size,
            "reference" => "ATTACHMENT",
            "author" => safe_get_user(),
        );
        $acreate = $mattachments->insert($attach);
    }

    $c = $bootstrap->get_Card("duplicate", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Customers.edit-census-success-title"),
        "text-class" => "text-center",
        "text" => lang("Customers.edit-census-success-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
} else {
    $create = $model->insert($d);
    //echo($model->getLastQuery()->getQuery());
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Customers.edit-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Customers.edit-noexist-message"), $d['customer']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $anoexist,
    ));
}
echo($c);
?>