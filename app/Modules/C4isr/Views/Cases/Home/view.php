<?php
$s = service('strings');
$b = service('bootstrap');
//[Models]--------------------------------------------------------------------------------------------------------------
$mcases = model("App\Modules\C4isr\Models\C4isr_Cases");

//[Build]---------------------------------------------------------------------------------------------------------------


$html = "<div class=\"row  row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-1 row-cols-1  text-center \">";


if ($oid == 'cveweb') {
    $html .= "<div class=\"col mb-3\">";
    $cvecard = service("smarty");
    $cvecard->set_Mode("bs5x");
    $cvecard->caching = 0;
    $cvecard->assign("type", "normal");
    $cvecard->assign("class", "mb-3");
    $cvecard->assign("header", "Amenazas Ciber");
    $cvecard->assign("header_back", false);
    $cvecard->assign("body", "<i class=\"fa-solid fa-spider-black-widow fa-4x\"></i><ul class=\"rectangle-list mt-3 mb-0\"><li class=\"text-start\">Avanzado</li></ul>");
    $cvecard->assign("footer", "<a href=\"http://c4isr-ctip.c4isr.co/\" class=\"w-100 btn btn-lg btn-orange\" target=\"_blank\">Ingresar</a>");
    $html .= $cvecard->view('components/cards/index.tpl');
    $html .= "</div>";
}


$html .= "<div class=\"col mb-3\">";


$card = service("smarty");
$card->set_Mode("bs5x");
$card->caching = 0;
$card->assign("type", "normal");
$card->assign("class", "mb-3");
$card->assign("header", lang("App.Create"));
$card->assign("header_back", false);

$lis = array();
if ($oid == 'databreaches') {
    array_push($lis, 'DataBreaches');
} elseif ($oid == 'osint') {
    array_push($lis, 'Osint');
} elseif ($oid == 'darkweb') {
    array_push($lis, 'DarkWeb');
} elseif ($oid == 'cveweb') {
    array_push($lis, 'CVEWeb');
} elseif ($oid == 'phishing') {
    array_push($lis, 'Phishing Domains');
} elseif ($oid == 'geolocation') {
    array_push($lis, 'Geolocations');
} elseif ($oid == 'perimeter') {
    array_push($lis, 'Perimeters');
} else {

}

if ($oid == 'osint') {
    $sinfo = service("smarty");
    $sinfo->set_Mode("bs5x");
    $sinfo->caching = 0;
    $sinfo->assign("title", "Nota");
    $sinfo->assign("message", lang("Cases.sints-info"));
    echo($sinfo->view('alerts/inline/info.tpl'));
} elseif ($oid == 'cveweb') {

}


$stats = $b->get_Ul('stats', array("lis" => $lis, 'class' => 'rectangle-list mt-3 mb-0'));
$card->assign("body", "<i class=\"fa-sharp fa-regular fa-shield-plus fa-4x\"></i>" . $stats);
$card->assign("footer", "<a href=\"/c4isr/cases/create/{$oid}/" . lpk() . "\" class=\"w-100 btn btn-lg btn-orange\">" . lang("App.Create") . "</a>");
$html .= $card->view('components/cards/index.tpl');
$html .= "</div>";


$options = array();
$cases = $mcases->where('type', $oid)->orderBy('case', 'DESC')->findAll();

foreach ($cases as $case) {
    $title = $s->get_URLDecode($case['reference']);
    $href = "/c4isr/cases/view/{$case['case']}";
    $acase = array("href" => $href, "title" => $title, "icon" => "fa-regular fa-suitcase", 'class' => 'btn-primary');
    array_push($options, $acase);
}

foreach ($options as $option) {
    $html .= "<div class=\"col mb-3\">";
    $card = service("smarty");
    $card->set_Mode("bs5x");
    $card->caching = 0;
    $card->assign("type", "normal");
    $card->assign("class", "mb-3");
    $card->assign("header", $option["title"]);
    $card->assign("header_back", false);

    $lis = array();
    if ($oid == 'databreaches') {
        array_push($lis, '<b>DataBreaches</b>: 0');
    } elseif ($oid == 'osint') {
        array_push($lis, '<b>Osint</b>: 0');
    } elseif ($oid == 'darkweb') {
        array_push($lis, '<b>DarkWeb</b>: 0');
    } elseif ($oid == 'cveweb') {
        array_push($lis, '<b>CVEWeb</b>: 0');
    } elseif ($oid == 'phishing') {
        array_push($lis, '<b>Phishing Domains</b>: 0');
    } elseif ($oid == 'geolocation') {
        array_push($lis, '<b>Geolocations</b>: 0');
    } elseif ($oid == 'perimeter') {
        array_push($lis, '<b>Perimeters</b>: 0');
    } else {

    }
    $stats = $b->get_Ul('stats', array("lis" => $lis, 'class' => 'rectangle-list mt-3 mb-0'));

    $card->assign("body", "<i class=\"far {$option["icon"]} fa-4x\"></i>" . $stats);
    $card->assign("footer", "<a href=\"{$option["href"]}\" class=\"w-100 btn btn-lg {$option["class"]}\">Acceder</a>");
    $html .= $card->view('components/cards/index.tpl');
    $html .= "</div>";
}

$html .= "</div>";


/** Logger **/
history_logger(array(
    "log" => pk(),
    "module" => "c4isr",
    "author" => $authentication->get_User(),
    "description" => "El usuario <b>@" . $authentication->get_Alias() . "</b> accedió a la vista inicial de casos",
    "code" => "",
));

echo($html);

if ($oid == 'osints') {
    $info = $b->get_Alert(array(
        'type' => 'info',
        'title' => 'SInt (Sistema de Inteligencia)',
        "message" => lang("Cases.sints-info")
    ));
} elseif ($oid == 'cveweb') {
    $info = $b->get_Alert(array(
        'type' => 'info',
        'title' => 'CVEWeb',
        "message" => lang("Cases.cve-info")
    ));
} elseif ($oid == 'darkweb') {
    $info = $b->get_Alert(array(
        'type' => 'info',
        'title' => 'DarkWeb',
        "message" => lang("Cases.darkweb-info")
    ));
} else {
    $info = "Sin info...{$oid}";
}

echo($info);

?>