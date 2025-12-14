<?php

use App\Libraries\Html\HtmlTag;

//$search
//$case
$strings = service('strings');
$bootstrap = service('bootstrap');
$validation = service('validation');
$validation->setRules(['email' => 'required|valid_email']);
$bootstrap = service('bootstrap');
$f = service("forms", array("lang" => "Cases."));
//[Models]--------------------------------------------------------------------------------------------------------------
$mmails = model("App\Modules\C4isr\Models\C4isr_Mails", false);
$mvulnerabilities = model('App\Modules\C4isr\Models\C4isr_Vulnerabilities');
$mintrusions = model('App\Modules\C4isr\Models\C4isr_Intrusions');
$maliases = model('App\Modules\C4isr\Models\C4isr_Aliases');
$c = "";

$identifier = $f->get_Value('identifier');

$correoElectronicoRegex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
$aliasRegex = "/^[a-zA-Z0-9][a-zA-Z0-9._%+-]*$/";
$dominioRegex = "/^(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z0-9][a-zA-Z0-9-]{0,61}[a-zA-Z0-9]|[a-zA-Z0-9]{1,63}\.xn--\w{1,63})$/";

if ($identifier == "EMAIL") {
    $c = view("App\Modules\C4isr\Views\Cases\View\Processors\Breaches\mails", array('oid' => $oid, 'search' => $search));
} elseif ($identifier == "ALIAS") {
    $c = view("App\Modules\C4isr\Views\Cases\View\Processors\Breaches\aliases", array('oid' => $oid, 'search' => $search));
} else {
    $c = view("App\Modules\C4isr\Views\Cases\View\Processors\Breaches\others", array('oid' => $oid, 'search' => $search));
}
echo($c);
?>