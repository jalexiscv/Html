<?php

//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$strings = service("strings");
$mdiagnostics = model('App\Modules\Iso9001\Models\Iso9001_Diagnostics');



$diagnostics = $mdiagnostics->where("requirement", $oid)->findAll();
//[vars]----------------------------------------------------------------------------------------------------------------
//Recibe el category $oid
$mdiagnostics = model('App\Modules\Iso9001\Models\Iso9001_Diagnostics');
$mcomponents = model('App\Modules\Iso9001\Models\Iso9001_Components');
$mcategories = model('App\Modules\Iso9001\Models\Iso9001_Categories');
$mactivities = model('App\Modules\Iso9001\Models\Iso9001_Activities');
$mplans= model('App\Modules\Plans\Models\Plans_Plans');

$category = $mcategories->where("category", $oid)->first();
$activities = $mactivities->where("category", $oid)->findAll();
$back = "/iso9001/categories/home/{$category["component"]}";

$code = "<div class=\"row\">\n";
$count = 0;
$code .= "\t<div class=\"col\">\n";
$code .= "\t\t <table class=\"table table-bordered table-hover w-100 m-0 \">\n";
$code .= "\t\t\t <thead class=\"\">\n";
$code .= "\t\t\t\t <tr>\n";
$code .= "\t\t\t\t\t <th class=\"th text-center\">#</th>\n";
$code .= "\t\t\t\t\t <th class=\"th text-center\">Actividad</th>\n";
$code .= "\t\t\t\t\t <th class=\"th text-center\">Puntaje</th>\n";
//$code .= "\t\t\t\t\t <th class=\"th text-center\">Opciones</th>\n";
$code .= "\t\t\t\t </tr>\n";
$code .= "\t\t\t </thead>\n";
$code .= "\t\t\t <tbody>\n";
foreach ($activities as $activity) {
    $count++;
    $status = "Estado";
    $period = $activity["period"];
    $description = $strings->get_Striptags($activity["description"]);
    $content = "{$description}</br>";



    $link_plan = "<a href=\"/plans/plans/create/{$activity["activity"]}?module=iso9001&activity={$activity["activity"]}\">Crear plan</a>";
    $plan = $mplans->where("activity", $activity["activity"])->first();
    if(is_array($plan)){
        $rplan = @$plan["plan"];
        $order = $strings->get_ZeroFill($plan["order"], 4);
        $rstatus =@ $plan["status"];
        $link_plan = "<a href=\"/plans/plans/view/{$plan["plan"]}\">{$order}</a> | {$link_plan}";
    }

    //$content .= "<b>Periodo</b>:{$period}</br>";
    $content .= "<b>Plan actual</b>: {$link_plan} | <b>Estado</b>: {$status}";
    $score = "<a href=\"/iso9001/scores/home/{$activity["activity"]}\">{$activity["score"]}</a>";
    $options = "<i class=\"fa-light fa-table-list\"></i>";
    $code .= "\t\t\t\t <tr>\n";
    $code .= "\t\t\t\t\t <td class=\"text-center align-middle\">$count</td>\n";
    $code .= "\t\t\t\t\t <td class=\"text-start align-middle\">$content</td>\n";
    $code .= "\t\t\t\t\t <td class=\"text-center align-middle\">$score</td>\n";
    //$code .= "\t\t\t\t\t <td class=\"text-center align-middle\">$options</td>\n";
    $code .= "\t\t\t\t </tr>\n";
}
$code .= "\t\t\t</tbody>\n";
$code .= "\t\t</table>\n";
$code .= "\t</div>\n";
$code .= "</div>\n";

$title = $strings->get_Clear($category["name"]);
$message = $strings->get_Clear($category["description"]);
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("card-view-service", array(
    "header-title" => sprintf(lang('Iso9001_Activities.home-title'), ""),
    "header-back" => $back,
    "header-list" => '/iso9001/activities/list/' . $oid,
    "alert" => array(
        'type' => 'info',
        'title' => $title,
        'message' => $message
    ),
    "content" => $code,
));
echo($card);
?>