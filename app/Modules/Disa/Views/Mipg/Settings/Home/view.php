<?php

$html = "<div class=\"row  row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-1 row-cols-1  text-center shortcuts\">";

$options = array(
    array("href" => "/disa/settings/characterization/view/" . lpk(), "title" => "Caracterización", "icon" => "fa-tasks"),
    array("href" => "/disa/settings/macroprocesses/list/" . lpk(), "title" => "Macroprocesos", "icon" => "fa-th-list"),
    array("href" => "/disa/settings/processes/list/" . lpk(), "title" => "Procesos", "icon" => "fa-ellipsis-v-alt"),
    array("href" => "/disa/settings/subprocesses/list/" . lpk(), "title" => "Subprocesos", "icon" => "fa-chart-network"),
    array("href" => "/disa/settings/positions/list/" . lpk(), "title" => "Cargos", "icon" => "fa-user-hard-hat"),
);

foreach ($options as $option) {
    $html .= "<div class=\"col mb-3\">";
    $card = service("smarty");
    $card->set_Mode("bs5x");
    $card->caching = 0;
    $card->assign("type", "normal");
    $card->assign("class", "mb-3");
    $card->assign("header", $option["title"]);
    $card->assign("header_back", false);
    $card->assign("body", "<i class=\"far {$option["icon"]} fa-4x\"></i>");
    $card->assign("footer", "<a href=\"{$option["href"]}\" class=\"w-100 btn btn-lg btn-orange\">Acceder</a>");
    $html .= $card->view('components/cards/index.tpl');
    $html .= "</div>";
}

$html .= "</div>";


/** Logger **/
history_logger(array(
    "log" => pk(),
    "module" => "DISA",
    "author" => $authentication->get_User(),
    "description" => "El usuario <b>@" . $authentication->get_Alias() . "</b> accedió a la vista principal de la parametrización de la entidad",
    "code" => "",
));

echo($html);
?>