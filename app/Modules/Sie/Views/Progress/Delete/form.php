<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-08-13 07:26:02
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Progress\Delete\form.php]
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
 * █ @var object $model Modelo de datos utilizado en la vista y trasferido desde el index
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
//[models]--------------------------------------------------------------------------------------------------------------
$mprogress = model("App\Modules\Sie\Models\Sie_Progress");
$mexecutions = model("App\Modules\Sie\Models\Sie_Executions");
//[vars]----------------------------------------------------------------------------------------------------------------
$f = service("forms", array("lang" => "Sie_Progress."));
$r = $model->get_Progress($oid);
$name = safe_urldecode(@$r["progress"]);
$message = sprintf(lang("Sie_Progress.delete-message"), $name);
$back = "/sie/progress/list/" . @$r["enrollment"];
//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("pkey", $oid);
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Delete"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[evaluate]---------------------------------------------------------------------------------------------------------------

// Debo evaluar si este progreso esta calificado ya sea por ejecion de curos o por
// calificacion administrativa, si esta calificado no se puede eliminar
$deletable = true;
$executions = $mexecutions->getLastExecutionbyProgress($oid);
if (!empty($executions)) {
    $deletable = false;
} else {
    if (!empty($r["last_calification"])) {
        $deletable = false;
    }
}
//[build]---------------------------------------------------------------------------------------------------------------
if ($deletable) {
    $card = $bootstrap->get_Card("delete-{$oid}", array(
        "class" => "card-info",
        "icon" => ICON_WARNING,
        "title" => sprintf(lang("Sie_Progress.delete-title"), $name),
        "text-class" => "text-center",
        "text" => sprintf(lang("Sie_Progress.delete-message"), $name),
        "content" => $f,
        "header-back" => $back
    ));
} else {
    $card = $bootstrap->get_Card("access-denied", array(
        "class" => "card-danger",
        "title" => lang("Sie_Progress.delete-denied-title"),
        "icon" => "fa-duotone fa-triangle-exclamation",
        "text-class" => "text-center",
        "text" => lang("Sie_Progress.delete-denied-message"),
        "footer-class" => "text-center",
        "footer-login" => true,
        "footer-continue" => $back,
        "voice" => "sie/progress-delete-denied-message.mp3",
    ));
}
echo($card);
?>