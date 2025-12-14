<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\Mails\Creator\processor.php]
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
$f = service("forms", array("lang" => "Mails."));
$mprofiles = model("App\Modules\C4isr\Models\C4isr_Profiles");
$emails = $f->get_Value("emails");
$emails_array = explode("\n", $emails);

$log = "";
foreach ($emails_array as $email) {
    $mmails = model("App\Modules\C4isr\Models\C4isr_Mails", false);
    $d = array(
        "mail" => pk(),
        "profile" => "",
        "email" => $strings->get_URLEncode($email),
        "author" => $authentication->get_User(),
    );
    $firstChar = substr($d['email'], 0, 1);
    $st = $mmails->setTable('c4isr_mails_' . $firstChar);
    $row = $mmails->where('email', $d["email"])->first();
    if (isset($row["mail"])) {
        $log .= "Email: {$email} ya existe en la base de datos<br>";
    } else {
        $profile = array("profile" => pk(), "firstname" => "", "lastname" => "", "author" => $d["author"]);
        $d["profile"] = $profile["profile"];
        $create_profile = $mprofiles->insert($profile);
        $create = $mmails->insert($d);
        $log .= "Email: {$email} se ha registrado<br>";
    }
}
echo($log);

/*
$l["back"] = "/c4isr/mails/list/" . lpk();
$l["edit"] = "/c4isr/mails/edit/{$d["mail"]}";
if (isset($row["mail"])) {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Mails.create-duplicate-title"));
    $smarty->assign("message", lang("Mails.create-duplicate-message"));
    $smarty->assign("continue", $l["back"]);
    $smarty->assign("voice", "c4isr/mails-create-duplicate-message.mp3");
    $c = $smarty->view('alerts/card/warning.tpl');
} else {
    $profile = array("profile" => pk(), "firstname" => "", "lastname" => "", "author" => $d["author"]);
    $d["profile"] = $profile["profile"];
    $create_profile = $mprofiles->insert($profile);
    $create = $mmails->insert($d);
    //cho($model->getLastQuery()->getQuery());
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Mails.create-success-title"));
    $smarty->assign("message", sprintf(lang("Mails.create-success-message"), $d['mail']));
    //$smarty->assign("edit", $l["edit"]);
    $smarty->assign("continue", $l["back"]);
    $smarty->assign("voice", "c4isr/mails-create-success-message.mp3");
    $c = $smarty->view('alerts/card/success.tpl');
}
echo($c);
*/
?>