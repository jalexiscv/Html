<?php

/** @var Strings $oid */
$bootstrap = service('Bootstrap');
$strings = service('strings');
$f = service("forms", array("lang" => "Users."));
//[models]--------------------------------------------------------------------------------------------------------------
$musers = model("App\Modules\Security\Models\Security_Users");
$mfields = model('App\Modules\Sie\Models\Sie_Users_Fields');
//[vars]----------------------------------------------------------------------------------------------------------------
$pkey = $f->get_Value("pkey");
$user = $musers->withDeleted()->find($pkey);

$citizenshipcard = $mfields->get_Field($oid, "citizenshipcard");
$firstname = $strings->get_URLDecode($mfields->get_Field($oid, "firstname"));
$lastname = $strings->get_URLDecode($mfields->get_Field($oid, "lastname"));

/* Vars */
$l["back"] = "/sie/teachers/list/" . lpk();
$l["edit"] = "/sie/teachers/edit/{$pkey}";
$vsuccess = "security/users-delete-success-message.mp3";
$vnoexist = "security/users-delete-noexist-message.mp3";
/* Build */
if (isset($user["user"])) {
    $delete = $musers->delete($pkey);
    // Eliminar profesor de Moodle
    try {
        $moodle = new App\Libraries\Moodle();

        // Obtener datos del profesor para Moodle
        $teacherCitizenshipcard = $mfields->get_Field($pkey, "citizenshipcard");
        $teacherFirstname = $strings->get_URLDecode($mfields->get_Field($pkey, "firstname"));
        $teacherLastname = $strings->get_URLDecode($mfields->get_Field($pkey, "lastname"));

        // Buscar el usuario en Moodle por idnumber (ID del sistema)
        $profileResult = $moodle->getUserProfile($pkey, 'idnumber');

        if ($profileResult['success']) {
            // Si existe en Moodle, eliminarlo usando el método deleteUser
            $moodleUserId = $profileResult['userInfo']['id'];
            $deleteResult = $moodle->deleteUser($moodleUserId);

            if ($deleteResult['success']) {
                //echo("Profesor eliminado exitosamente de Moodle: ID {$moodleUserId}, Usuario: {$teacherFirstname} {$teacherLastname}");
            } else {
                //echo("Error al eliminar profesor de Moodle: " . $deleteResult['error']);
            }
        } else {
            //echo("Profesor no encontrado en Moodle para eliminación: {$teacherFirstname} {$teacherLastname}");
        }

    } catch (Exception $e) {
        echo("Error al procesar eliminación en Moodle: " . $e->getMessage());
    }

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
