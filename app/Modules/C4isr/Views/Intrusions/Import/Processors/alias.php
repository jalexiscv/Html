<?php

//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');


//[Models]-----------------------------------------------------------------------------
$mintrusions = model("App\Modules\C4isr\Models\C4isr_Intrusions");
$maliases = model("App\Modules\C4isr\Models\C4isr_Aliases", false);
$mprofiles = model("App\Modules\C4isr\Models\C4isr_Profiles");
$mvulnerabilities = model("App\Modules\C4isr\Models\C4isr_Vulnerabilities");

//$c = ("alias={$alias}:{$password}<br>");

$intrusion = pk();
$author = $authentication->get_User();
$alias = $strings->get_URLEncode(strtolower($alias));

if (!preg_match('/^[a-zA-Z0-9]/', $alias)) {
    //echo("Alias con formato incorrecto!.<br>");
} else {
    $firstChar = substr($alias, 0, 1);
    $maliases->setTable('c4isr_aliases_' . $firstChar);
    $query = $maliases->where('user', $alias)->first();
    if (isset($query["alias"])) {
        //[0] - El alias ya existe!
        //[1] - No necesito un perfil, solo averiguo el id del perfil
        $alias = $query;
        $profile = $mprofiles->find($alias['profile']);
    } else {
        //0) El alias no existe
        //1) Se debe un perfil
        //2) Se debe crear un alias vinculado al perfil
        $profile = array("profile" => pk(), "firstname" => "", "lastname" => "", "author" => $author);
        $alias = array("alias" => pk(), "profile" => $profile['profile'], "user" => $alias, "author" => $author);
        $create_profile = $mprofiles->insert($profile);
        $create_alias = $maliases->insert($alias);
    }
//3) Se debe crear una vulnerabilidad asociada al alias
//4) Se debe crear una intrusion que vincule la vulnerabilidad y la brecha
    $vulnerability = array("vulnerability" => pk(), "partition" => $firstChar, "alias" => $alias['alias'], "mail" => NULL, "password" => $password, "hash" => NULL, "salt" => NULL, "author" => $author);
    $intrusion = array("intrusion" => $intrusion, "vulnerability" => $vulnerability['vulnerability'], "breach" => $breach, "author" => $author);
    $create_vulnerability = $mvulnerabilities->insert($vulnerability);
    $create_intrusion = $mintrusions->insert($intrusion);
}
//echo($c);
?>