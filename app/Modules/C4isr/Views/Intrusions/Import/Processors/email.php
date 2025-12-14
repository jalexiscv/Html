<?php

//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[Models]-----------------------------------------------------------------------------
$mintrusions = model("App\Modules\C4isr\Models\C4isr_Intrusions");
$mmails = model("App\Modules\C4isr\Models\C4isr_Mails", false);
$maliases = model("App\Modules\C4isr\Models\C4isr_Aliases", false);
$mprofiles = model("App\Modules\C4isr\Models\C4isr_Profiles");
$mvulnerabilities = model("App\Modules\C4isr\Models\C4isr_Vulnerabilities");

//$c = ("email: {$email}:{$password}<br>");

$intrusion = pk();
$author = $authentication->get_User();
$email = $strings->get_URLEncode($email);

if (!preg_match('/^[a-zA-Z0-9]/', $email)) {
    //echo("Alias con formato incorrecto!.<br>");
} else {
    $firstChar = substr($email, 0, 1);
    $st = $mmails->setTable('c4isr_mails_' . $firstChar);
    //echo("email: {$email}:{$password} c4isr_mails_{$firstChar}<br>");
    $query = $mmails->where('email', $email)->first();

    if (isset($query["mail"])) {
        //[0] - El correo ya existe!
        //[1] - No necesito un perfil, solo averiguo el id del perfil
        $mail = $query;
        $profile = $mprofiles->find($mail['profile']);
    } else {
        //[0] - El correo no existe
        //[1] - Necesito crear un perfil y tener el id del perfil creado
        $profile = array("profile" => pk(), "firstname" => "", "lastname" => "", "author" => $author);
        $mail = array("mail" => pk(), "profile" => $profile['profile'], "email" => $email, "author" => $author);
        $create_profile = $mprofiles->insert($profile);
        $create_email = $mmails->insert($mail);
    }
//3) Se debe crear una vulnerabilidad asociada al mail
//4) Se debe crear una intrusion que vincule la vulnerabilidad y la brecha
    $vulnerability = array("vulnerability" => pk(), "partition" => $firstChar, "mail" => $mail['mail'], "alias" => NULL, "password" => $password, "hash" => NULL, "salt" => NULL, "author" => $author);
    $intrusion = array("intrusion" => $intrusion, "vulnerability" => $vulnerability['vulnerability'], "breach" => $breach, "author" => $author);
    $create_vulnerability = $mvulnerabilities->insert($vulnerability);
    $create_intrusion = $mintrusions->insert($intrusion);
}
//echo($c);
?>