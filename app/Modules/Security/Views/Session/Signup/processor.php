<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-12-20 13:01:35
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Security\Views\Users\Creator\processor.php]
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
$f = service("forms", array("lang" => "Users."));
$musers = model("App\Modules\Security\Models\Security_Users");
$mfields = model("App\Modules\Security\Models\Security_Users_Fields");
$d = array(
    "user" => $f->get_Value("user"),
    "author" => safe_get_user(),
);
$row = $musers->where('user', $d["user"])->first();
$l["back"] = "/";
$l["edit"] = "/security/users/edit/{$d["user"]}";
$asuccess = "security/signup/success-message.mp3";
$aexist = "security/users-create-exist-message.mp3";
if (is_array($row)) {
    $c = $bootstrap->get_Card("duplicate", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Signup.duplicate-title"),
        "text-class" => "text-center",
        "text" => lang("Signup.duplicate-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $aexist,
    ));
} else {
    $create = $musers->insert($d);
    //echo($musers->getLastQuery()->getQuery());
    $user = $d["user"];
    $firstname = $f->get_Value("firstname");
    $lastname = $f->get_Value("lastname");
    $alias = strtoupper($f->get_Value("alias"));
    $password = strtoupper($f->get_Value("password"));
    $phone = $f->get_Value("phone");
    $email = $f->get_Value("email");
    $birthday = $f->get_Value("birthday");
    $reference = $f->get_Value("reference");
    $notes = $f->get_Value("notes");
    $citizenshipcard = $f->get_Value("citizenshipcard");
    $token_email = md5(uniqid(rand(), true));
    $address = $f->get_Value("address");
    $expedition_date = $f->get_Value("expedition_date");
    $expedition_place = $f->get_Value("expedition_place");
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "alias", "value" => $alias));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "password", "value" => $password));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "firstname", "value" => $firstname));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "lastname", "value" => $lastname));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "email", "value" => $email));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "phone", "value" => $phone));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "birthday", "value" => $birthday));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "citizenshipcard", "value" => $citizenshipcard));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "token-email", "value" => $token_email));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "address", "value" => $address));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "expedition_date", "value" => $expedition_date));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "expedition_place", "value" => $expedition_place));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "reference", "value" => $reference));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "notes", "value" => $notes));

    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Signup.success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Signup.success-message"), $d['user']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
}
?>
<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 mx-auto d-table h-100">
    <div class="d-table-cell align-middle">
        <?php echo($c); ?>
    </div>
</div>