<?php

$html = "<div class=\"row  row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-1 row-cols-1  text-center shortcuts\">";

$options = array(
    array("href" => "/c4isr/breaches/list/" . lpk(), "title" => lang('App.Breaches'), "icon" => "fa-tasks"),
    array("href" => "/c4isr/mails/list/" . lpk(), "title" => lang('App.Mails'), "icon" => "fa-tasks"),
    array("href" => "/c4isr/services/osint/" . lpk(), "title" => "OsinT", "icon" => "fa-tasks"),
    array("href" => "/c4isr/profiles/list/" . lpk(), "title" => lang("App.Profiles"), "icon" => "fa-tasks"),
    array("href" => "/c4isr/phones/list/" . lpk(), "title" => lang("App.Phones"), "icon" => "fa-tasks"),
    array("href" => "/c4isr/darkweb/list/" . lpk(), "title" => "DarkWeb", "icon" => "fa-tasks"),
    //array("href" => "/c4isr/mongo/processor/" . lpk(), "title" => "Mongo Procesador", "icon" => "fa-light fa-bolt-lightning"),
    //array("href" => "/c4isr/mongo/duplicates/" . lpk(), "title" => "Duplicates", "icon" => "fa-light fa-bolt-lightning"),
    //array("href" => "#", "title" => "Procesos", "icon" => "fa-ellipsis-v-alt"),
    //array("href" => "#", "title" => "Subprocesos", "icon" => "fa-chart-network"),
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