<?php
// AccountOverview
// Account Level 	Small Business
// API Key 	ApWJ249AiARJ8PrEIPm6ZuGLrEV0wqdg
// Display Name 	SHODANADMIN
// Email 	shodan.mil@gmail.com
// Member 	Yes
$b = service("bootstrap");
$s = service('strings');
$f = service("forms", array("lang" => "Cases."));

$explore = $f->get_Value("explore", "");
$html = "";

if ($explore == "vulnerability") {
    $html = view('App\Modules\C4isr\Views\Cases\View\Processors\Cveweb\vulnerability.php');
    //$url = "https://cve.cgine.com/cves/wsx.php?iso={$country}&V={$variant}&D={$domain}&limit={$limit}&O={$offset}";
} elseif ($explore == "authentication") {
    $html = view('App\Modules\C4isr\Views\Cases\View\Processors\Cveweb\authentication.php');
    //$url = "https://cve.cgine.com/cves/wsx.php?iso={$country}&no_auth={$variant}&D={$domain}&limit={$limit}&O={$offset}";
} elseif ($explore == "service") {
    $html = view('App\Modules\C4isr\Views\Cases\View\Processors\Cveweb\service.php');
    //$url = "https://cve.cgine.com/cves/wsx.php?iso={$country}&sa={$variant}&D={$domain}&limit={$limit}&O={$offset}";
} elseif ($explore == "domain") {
    $html = view('App\Modules\C4isr\Views\Cases\View\Processors\Cveweb\domain.php');
    //$url = "https://cve.cgine.com/cves/wsx.php?iso={$country}&D={$domain}&limit={$limit}&O={$offset}";
} elseif ($explore == "ip") {
    $html = view('App\Modules\C4isr\Views\Cases\View\Processors\Cveweb\ip.php');
    //$url = "https://cve.cgine.com/cves/wsx.php?ip={$domain}";
} elseif ($explore == "query") {
    $html = view("App\Modules\C4isr\Views\Cases\View\Processors\Cveweb\query.php");
    //$url = "https://cve.cgine.com/cves/wsx.php?query={$query}";
}
echo($html);
?>