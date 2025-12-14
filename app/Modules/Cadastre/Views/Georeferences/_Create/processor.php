<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-11-10 06:42:31
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Cadastre\Views\Georeferences\Creator\processor.php]
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
//[Models]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Cadastre.georeferences-"));
$model = model("App\Modules\Cadastre\Models\Cadastre_Georeferences");
$d = array(
    "georeference" => $f->get_Value("georeference"),
    "profile" => $f->get_Value("profile"),
    "latitud" => $f->get_Value("latitud"),
    "latitude_degrees" => $f->get_Value("latitude_degrees"),
    "latitude_minutes" => $f->get_Value("latitude_minutes"),
    "latitude_seconds" => $f->get_Value("latitude_seconds"),
    "latitude_decimal" => $f->get_Value("latitude_decimal"),
    "longitude" => $f->get_Value("longitude"),
    "longitude_degrees" => $f->get_Value("longitude_degrees"),
    "longitude_minutes" => $f->get_Value("longitude_minutes"),
    "longitude_seconds" => $f->get_Value("longitude_seconds"),
    "longitude_decimal" => $f->get_Value("longitude_decimal"),
    "date" => safe_get_date(),
    "time" => safe_get_time(),
    "author" => safe_get_user(),
);
$row = $model->find($d["georeference"]);
$l["back"] = "/cadastre/georeferences/list/" . lpk();
$l["edit"] = "/cadastre/georeferences/edit/{$d["georeference"]}";
$asuccess = "cadastre/georeferences-create-success-message.mp3";
$aexist = "cadastre/georeferences-create-exist-message.mp3";
if (is_array($row)) {
    $c = $bootstrap->get_Card("duplicate", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Cadastre.georeferences-create-duplicate-title"),
        "text-class" => "text-center",
        "text" => lang("Cadastre.georeferences-create-duplicate-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $aexist,
    ));
} else {
    $create = $model->insert($d);
    //echo($model->getLastQuery()->getQuery());
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Cadastre.georeferences-create-success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Cadastre.georeferences-create-success-message"), $d['georeference']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
}
echo($c);
?>
