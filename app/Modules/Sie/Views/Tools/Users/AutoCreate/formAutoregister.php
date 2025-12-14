<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-04-24 12:58:29
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Versions\Creator\form.php]
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
$b = service("bootstrap");
$f = service("forms", array("lang" => "Versions."));
//[models]--------------------------------------------------------------------------------------------------------------
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$musers = model("App\Modules\Sie\Models\Sie_Users");
$mfields = model("App\Modules\Sie\Models\Sie_Users_Fields");
//$model = model("App\Modules\Sie\Models\Sie_Versions");
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/sie/students/view/{$oid}";

$offset = !empty($request->getGet("offset")) ? $request->getGet("offset") : 0;

$registrations = $mregistrations
    ->limit(250, $offset)
    ->find();

$code = "Empesando desde: {$offset}<br>";

$count = 0;
foreach ($registrations as $registration) {
    $count++;
    $email = safe_strtolower(@$registration["email_address"]);
    $password = substr(@$registration['registration'], -6);
    //echo("<b>{$count}</b> - <b>Email: </b>: {$email} <b>{$password}</b><br>");
    //$registration=$mregistrations->getRegistration($oid);
    $email = safe_strtolower(@$registration["email_address"]);
    $password = substr(@$registration['registration'], -6);
    $code .= "<br><b>{$count}</b>";
    $code .= "<b>Usuario</b>: {$email} ";
    $code .= "<b>Contraseña</b>: {$password} ";
    $code .= "<b>Usuario Plataforma SIE</b>";
    $user = $mfields->get_UserByEmail($email);

    if (!empty($user)) {
        $code .= "<b>Estado</b>: Existe y es {$user}";
        $code .= "<b>Se actualizó la contraseña</b>";
        $mfields->insert(array("field" => pk(), "user" => $user, "name" => "password", "value" => $password));

    } else {
        $code .= "<b>Estado</b>: No existe y se creará";
        $alias = explode('@', $email)[0];
        $type = "STUDENT";
        $firstname = @$registration["first_name"] . " " . @$registration["second_name"];
        $lastname = @$registration["first_surname"] . " " . @$registration["second_surname"];
        $d = array(
            "user" => pk(),
            "author" => safe_get_user(),
        );
        $create = $musers->insert($d);
        $mfields->insert(array("field" => pk(), "user" => $d["user"], "name" => "email", "value" => $email));
        $mfields->insert(array("field" => pk(), "user" => $d["user"], "name" => "password", "value" => $password));
        $mfields->insert(array("field" => pk(), "user" => $d["user"], "name" => "alias", "value" => $alias));
        $mfields->insert(array("field" => pk(), "user" => $d["user"], "name" => "type", "value" => $type));
        $mfields->insert(array("field" => pk(), "user" => $d["user"], "name" => "firstname", "value" => $firstname));
        $mfields->insert(array("field" => pk(), "user" => $d["user"], "name" => "lastname", "value" => $lastname));
        $mfields->insert(array("field" => pk(), "user" => $d["user"], "name" => "moodle-password", "value" => $password));

    }
}


//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card("create", array(
    "title" => "Creación automatica de usuarios",
    "content" => $code,
    "header-back" => $back
));
echo($card);
?>