<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\Intrusions\Creator\processor.php]
*  ╩ ╩╝╚╝╚═╝╚═╝╩╚═╝╩═╝╚═╝
* -----------------------------------------------------------------------------
* Copyright 2021 - Higgs Bigdata S.A.S., Inc. <admin@Higgs.com>
* Este archivo es parte de Higgs Bigdata Framework 7.1
* Para obtener información completa sobre derechos de autor y licencia, consulte
* la LICENCIA archivo que se distribuyó con este código fuente.
* -----------------------------------------------------------------------------
* EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
* IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
* APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
* LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
* RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
* AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
* O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
* -----------------------------------------------------------------------------
* @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
* @link https://www.Higgs.com
* @Version 1.5.0
* @since PHP 7, PHP 8
* -----------------------------------------------------------------------------
* Datos recibidos desde el controlador - @ModuleController
* -----------------------------------------------------------------------------
* @Authentication
* @request
* @dates
* @view
* @oid
* @component
* @views
* @prefix
* @parent
* -----------------------------------------------------------------------------
*/
//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[Models]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Intrusions."));
$mintrusions = model("App\Modules\C4isr\Models\C4isr_Intrusions");
$mmails = model("App\Modules\C4isr\Models\C4isr_Mails", false);
$maliases = model("App\Modules\C4isr\Models\C4isr_Aliases", false);
$mprofiles = model("App\Modules\C4isr\Models\C4isr_Profiles");
$mvulnerabilities = model("App\Modules\C4isr\Models\C4isr_Vulnerabilities");

$intrusion = $f->get_Value("intrusion");
$breach = $f->get_Value("breach");
$user = $f->get_Value("user");
$password = $f->get_Value("password");
$author = $authentication->get_User();

$l["back"] = "/c4isr/intrusions/list/" . $breach;
$l["edit"] = "/c4isr/intrusions/edit/{$intrusion}";

$validation = service('validation');
$validation->setRules(['email' => 'required|valid_email']);

if ($validation->run(['email' => $user]) === true) {
    //echo "El correo electrónico es válido";
    $email = strtolower($user);
    $firstChar = substr($email, 0, 1);
    $mmails->setTable('c4isr_mails_' . $firstChar);
    $query = $mmails->where('email', $strings->get_URLEncode($email))->first();

    if (isset($query["mail"])) {
        //[0] - El correo ya existe!
        //[1] - No necesito un perfil, solo averiguo el id del perfil
        $mail = $query;
        $profile = $mprofiles->find($mail['profile']);
        $smarty = service("smarty");
        $smarty->set_Mode("bs5x");
        $smarty->assign("title", lang("Intrusions.create-duplicate-title"));
        $smarty->assign("message", lang("Intrusions.create-duplicate-message"));
        $smarty->assign("continue", $l["back"]);
        $smarty->assign("voice", "c4isr/intrusions-create-duplicate-message.mp3");
        $c = $smarty->view('alerts/card/warning.tpl');
    } else {
        //[0] - El correo no existe
        //[1] - Necesito crear un perfil y tener el id del perfil creado
        $profile = array("profile" => pk(), "firstname" => "", "lastname" => "", "author" => $author);
        $mail = array("mail" => pk(), "profile" => $profile['profile'], "email" => $strings->get_URLEncode($email), "author" => $author);
        $create_profile = $mprofiles->insert($profile);
        $create_email = $mmails->insert($mail);
        $smarty = service("smarty");
        $smarty->set_Mode("bs5x");
        $smarty->assign("title", lang("Intrusions.create-success-title"));
        $smarty->assign("message", sprintf(lang("Intrusions.create-success-message"), $intrusion));
        $smarty->assign("continue", $l["back"]);
        $smarty->assign("voice", "c4isr/intrusions-create-success-message.mp3");
        $c = $smarty->view('alerts/card/success.tpl');
    }
    //3) Se debe crear una vulnerabilidad asociada al mail
    //4) Se debe crear una intrusion que vincule la vulnerabilidad y la brecha
    $vulnerability = array("vulnerability" => pk(), "partition" => $firstChar, "mail" => $mail['mail'], "alias" => NULL, "password" => $password, "hash" => NULL, "salt" => NULL, "author" => $author);
    $intrusion = array("intrusion" => $intrusion, "vulnerability" => $vulnerability['vulnerability'], "breach" => $breach, "author" => $author);
    $create_vulnerability = $mvulnerabilities->insert($vulnerability);
    $create_intrusion = $mintrusions->insert($intrusion);
} else {
    //echo "No es un correo electronico";
    $alias = strtolower($user);
    $firstChar = substr($alias, 0, 1);
    $maliases->setTable('c4isr_aliases_' . $firstChar);
    $query = $maliases->where('user', $strings->get_URLEncode($alias))->first();
    if (isset($query["alias"])) {
        //[0] - El alias ya existe!
        //[1] - No necesito un perfil, solo averiguo el id del perfil
        $alias = $query;
        $smarty = service("smarty");
        $smarty->set_Mode("bs5x");
        $smarty->assign("title", lang("Intrusions.create-duplicate-title"));
        $smarty->assign("message", lang("Intrusions.create-duplicate-message"));
        $smarty->assign("continue", $l["back"]);
        $smarty->assign("voice", "c4isr/intrusions-create-duplicate-message.mp3");
        $c = $smarty->view('alerts/card/warning.tpl');
    } else {
        //0) El alias no existe
        //1) Se debe un perfil
        //2) Se debe crear un alias vinculado al perfil
        $profile = array("profile" => pk(), "firstname" => "", "lastname" => "", "author" => $author);
        $alias = array("alias" => pk(), "profile" => $profile['profile'], "user" => $strings->get_URLEncode($alias), "author" => $author);
        $create_profile = $mprofiles->insert($profile);
        $create_alias = $maliases->insert($alias);
        //cho($model->getLastQuery()->getQuery());
        $smarty = service("smarty");
        $smarty->set_Mode("bs5x");
        $smarty->assign("title", lang("Intrusions.create-success-title"));
        $smarty->assign("message", sprintf(lang("Intrusions.create-success-message"), $intrusion));
        //$smarty->assign("edit", $l["edit"]);
        $smarty->assign("continue", $l["back"]);
        $smarty->assign("voice", "c4isr/intrusions-create-success-message.mp3");
        $c = $smarty->view('alerts/card/success.tpl');
    }
    //3) Se debe crear una vulnerabilidad asociada al alias
    //4) Se debe crear una intrusion que vincule la vulnerabilidad y la brecha
    $vulnerability = array("vulnerability" => pk(), "partition" => $firstChar, "alias" => $alias['alias'], "mail" => NULL, "password" => $password, "hash" => NULL, "salt" => NULL, "author" => $author);
    $intrusion = array("intrusion" => $intrusion, "vulnerability" => $vulnerability['vulnerability'], "breach" => $breach, "author" => $author);
    $create_vulnerability = $mvulnerabilities->insert($vulnerability);
    $create_intrusion = $mintrusions->insert($intrusion);
}
echo($c);
?>