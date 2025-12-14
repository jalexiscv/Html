<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-12-18 11:03:17
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
//[Services]-----------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
//[services]------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Security\Models\Security_Users");
$mfields = model('App\Modules\Sie\Models\Sie_Users_Fields');
//[Process]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Users."));
$d = array(
    "user" => $f->get_Value("user"),
    "author" => safe_get_user(),
);
//[Elements]-----------------------------------------------------------------------------
$row = $model->find($d["user"]);
$l["back"] = "/sie/teachers/list/" . lpk();
$l["edit"] = "/sie/teachers/edit/{$d["user"]}";
$asuccess = "security/users-edit-success-message.mp3";
$anoexist = "security/users-edit-noexist-message.mp3";
//[build]---------------------------------------------------------------------------------------------------------------
if (is_array($row)) {
    //$edit = $model->update($d['user'], $d);
    $user = $d["user"];
    $firstname = $f->get_Value("firstname");
    $lastname = $f->get_Value("lastname");
    $alias = strtoupper($f->get_Value("alias"));
    $type = $f->get_Value("type");
    $password = strtoupper($f->get_Value("password"));
    $phone = $f->get_Value("phone");
    $whatsapp = $f->get_Value("whatsapp");
    $email = $f->get_Value("email");
    $email_personal = $f->get_Value("email_personal");
    $birthday = $f->get_Value("birthday");
    $birth_country = $f->get_Value("birth_country");
    $birth_region = $f->get_Value("birth_region");
    $birth_city = $f->get_Value("birth_city");
    $reference = $f->get_Value("reference");
    $notes = $f->get_Value("notes");
    $citizenshipcard = $f->get_Value("citizenshipcard");
    $token_email = md5(uniqid(rand(), true));
    $address = $f->get_Value("address");
    $expedition_date = $f->get_Value("expedition_date");
    $expedition_place = $f->get_Value("expedition_place");
    $moodle_username = $f->get_Value("moodle-username");
    $moodle_password = $f->get_Value("moodle-password");
    $gender = $f->get_Value("gender");
    $marital_status = $f->get_Value("marital_status");
    $institutional_address = $f->get_Value("institutional_address");

    $participant_teacher = $f->get_Value("participant_teacher");
    $participant_executive = $f->get_Value("participant_executive");
    $participant_authority = $f->get_Value("participant_authority");

    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "alias", "value" => $alias));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "type", "value" => $type));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "password", "value" => $password));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "firstname", "value" => $firstname));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "lastname", "value" => $lastname));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "email", "value" => $email));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "email_personal", "value" => $email_personal));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "phone", "value" => $phone));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "whatsapp", "value" => $whatsapp));

    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "birthday", "value" => $birthday));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "birth_country", "value" => $birth_country));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "birth_region", "value" => $birth_region));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "birth_city", "value" => $birth_city));

    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "citizenshipcard", "value" => $citizenshipcard));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "token-email", "value" => $token_email));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "address", "value" => $address));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "expedition_date", "value" => $expedition_date));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "expedition_place", "value" => $expedition_place));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "reference", "value" => $reference));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "notes", "value" => $notes));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "moodle-username", "value" => $moodle_username));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "moodle-password", "value" => $moodle_password));

    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "gender", "value" => $gender));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "marital_status", "value" => $marital_status));

    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "institutional_address", "value" => $institutional_address));

    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "participant_teacher", "value" => $participant_teacher));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "participant_executive", "value" => $participant_executive));
    $mfields->insert(array("field" => pk(), "user" => $user, "name" => "participant_authority", "value" => $participant_authority));


    cache()->clean();

    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Users.edit-success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Users.edit-success-message"), $alias),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
} else {
    $create = $model->insert($d);
    //echo($model->getLastQuery()->getQuery());
    $c = $bootstrap->get_Card("warning", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Users.edit-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Users.edit-noexist-message"), $d['user']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $anoexist,
    ));
}
echo($c);
?>