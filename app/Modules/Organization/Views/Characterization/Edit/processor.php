<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-02-05 03:52:50
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Organization\Views\Plans\Editor\processor.php]
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
 * █ @var object $parent
 * █ @var object $authentication
 * █ @var object $request
 * █ @var object $dates
 * █ @var string $component
 * █ @var string $view
 * █ @var string $oid
 * █ @var string $views
 * █ @var string $prefix
 * █ @var array $data
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[Services]-----------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
//[services]------------------------------------------------------------------------------------------------------------
$mcharacterizations = model("App\Modules\Organization\Models\Organization_Characterizations");
//[Process]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Organization.plans-"));


$d = array(
    "characterization" => $f->get_Value("characterization"),
    "sigep" => $f->get_Value("sigep"),
    "name" => $f->get_Value("name"),
    "vision" => $f->get_Value("vision"),
    "mision" => $f->get_Value("mision"),
    "values" => $f->get_Value("values"),
    "representative" => $f->get_Value("representative"),
    "representative_position" => $f->get_Value("representative_position"),
    "leader" => $f->get_Value("leader"),
    "leader_position" => $f->get_Value("leader_position"),
    "internalcontrol" => $f->get_Value("internalcontrol"),
    "internalcontrol_position" => $f->get_Value("internalcontrol_position"),
    "support" => $f->get_Value("support"),
    "support_position" => $f->get_Value("support_position"),
);


//print_r($d);

//[Elements]-----------------------------------------------------------------------------
$row = $mcharacterizations->find($d["characterization"]);
$l["back"] = "/organization/characterization/view/" . $d["characterization"];
$l["edit"] = "/organization/plans/edit/{$d["characterization"]}";
$asuccess = "organization/plans-edit-success-message.mp3";
$anoexist = "organization/plans-edit-noexist-message.mp3";
//[build]---------------------------------------------------------------------------------------------------------------
if (is_array($row)) {
    $edit = $mcharacterizations->update($d['characterization'], $d);
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Organization.plans-edit-success-title"),
        "text-class" => "text-center",
        "text" => lang("Organization.plans-edit-success-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
} else {
    $edit = $mcharacterizations->update($d['sigep'], $d);
    //echo($model->getLastQuery()->getQuery());
    $c = $bootstrap->get_Card("warning", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Organization.plans-edit-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Organization.plans-edit-noexist-message"), $d['characterization']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $anoexist,
    ));
}
echo($c);
?>
