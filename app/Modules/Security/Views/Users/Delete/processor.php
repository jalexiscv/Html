<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-12-19 10:22:05
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Security\Views\Users\Editor\processor.php]
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
$bootstrap = service('Bootstrap');
$f = service("forms", array("lang" => "Users."));
//$model = model("App\Modules\Security\Models\Security_Users");
$pkey = $f->get_Value("pkey");
$row = $model->withDeleted()->find($pkey);
/* Vars */
$l["back"] = "/security/users/list/" . lpk();
$l["edit"] = "/security/users/edit/{$pkey}";
$vsuccess = "security/users-delete-success-message.mp3";
$vnoexist = "security/users-delete-noexist-message.mp3";
/* Build */
if (isset($row["user"])) {
    $delete = $model->delete($pkey);

    $c = $bootstrap->get_Card("duplicate", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Users.delete-success-title"),
        "text-class" => "text-center",
        "text" => lang("Users.delete-success-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $vsuccess,
    ));
} else {
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Users.delete-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Users.delete-noexist-message"), $d['user']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $vnoexist,
    ));
}
echo($c);
?>
