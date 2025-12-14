<?php

/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2023-12-01 23:19:27
 *  ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 *  ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 *  ** █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 *  ** █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 *  ** █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 *  ** █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 *  ** █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 *  ** █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 *  ** █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 *  ** █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 *  ** █ @link https://www.codehiggs.com
 *  ** █ @Version 1.5.0 @since PHP 7, PHP 8
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ Datos recibidos desde el controlador - @ModuleController
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */

//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$strings = service("strings");
$mdiagnostics = model('App\Modules\Mipg\Models\Mipg_Diagnostics');
$diagnostics = $mdiagnostics->where("politic", $oid)->findAll();
//[vars]----------------------------------------------------------------------------------------------------------------
//Recibe el category $oid
$mdiagnostics = model('App\Modules\Mipg\Models\Mipg_Diagnostics');
$mcomponents = model('App\Modules\Mipg\Models\Mipg_Components');
$mcategories = model('App\Modules\Mipg\Models\Mipg_Categories');
$mactivities = model('App\Modules\Mipg\Models\Mipg_Activities');
$mplans = model('App\Modules\Mipg\Models\Mipg_Plans');
$mscores = model('App\Modules\Mipg\Models\Mipg_Scores');

$category = $mcategories->where("category", $oid)->first();
$activities = $mactivities->where("category", $oid)->findAll();
$back = "/mipg/categories/home/{$category["component"]}";

$code = "<div class=\"row\">\n";
$count = 0;
$code .= "\t<div class=\"col\">\n";
$code .= "\t\t <table class=\"table table-bordered table-hover w-100 m-0 \">\n";
$code .= "\t\t\t <thead class=\"\">\n";
$code .= "\t\t\t\t <tr>\n";
$code .= "\t\t\t\t\t <th class=\"th text-center\">#</th>\n";
$code .= "\t\t\t\t\t <th class=\"th text-center\">Actividad</th>\n";
$code .= "\t\t\t\t\t <th class=\"th text-center\">Riesgo</th>\n";
$code .= "\t\t\t\t\t <th class=\"th text-center\">Planes</th>\n";
$code .= "\t\t\t\t\t <th class=\"th text-center\">Puntaje</th>\n";
$code .= "\t\t\t\t </tr>\n";
$code .= "\t\t\t </thead>\n";
$code .= "\t\t\t <tbody>\n";
foreach ($activities as $activity) {
    $count++;
    $lastplan = $mplans->get_LastPlan($activity["activity"]);
    $status = @$lastplan["status"];
    $period = $activity["period"];

    $description = $strings->get_Striptags($activity["description"]);

    $linklastplan = "<a href=\"/mipg/plans/create/{$activity['activity']}\">Crear plan</a>";
    if (is_array($lastplan)) {
        $plan = $strings->get_ZeroFill($lastplan['order'], 4);
        $linklastplan = "<a href=\"/mipg/plans/view/{$lastplan['plan']}\">{$plan}</a>";
    }


    $content = "{$description}</br>";
    $content .= "<b>Periodo</b>:{$period}</br>";

    if (!empty($status)) {
        $content .= "<b>Plan actual</b>:{$linklastplan} | ";
        if ($status == "APPROVAL") {
            $content .= "<b>Estado</b>: Solicitando aprobación";
        } elseif ($status == "REJECTED") {
            $content .= "<b>Estado</b>: Rechazado ";
        } elseif ($status == "APPROVED") {
            $content .= "<b>Estado</b>: Aprobado ";
        } elseif ($status == "EVALUATE") {
            $content .= "<b>Estado</b>: Solicitando evaluación ";
        } elseif ($status == "NOTCOMPLETED") {
            $content .= "<b>Estado</b>: No completado";
        } elseif ($status == "COMPLETED") {
            $content .= "<b>Estado</b>: Completo";
        } else {
            $content .= "<b>Estado</b>:{$status}";
        }
    } else {
        $content .= "<b>Plan actual</b>:{$linklastplan}";
    }


    $score = $mactivities->get_Score($activity["activity"]);

    $options = "<i class=\"fa-light fa-table-list\"></i>";
    $code .= "\t\t\t\t <tr>\n";
    $code .= "\t\t\t\t\t <td class=\"text-center align-middle\">$count</td>\n";
    $code .= "\t\t\t\t\t <td class=\"text-start align-middle\">$content</td>\n";
    $code .= "\t\t\t\t\t <td class=\"text-center align-middle\">";
    $code .= "\t\t\t\t\t\t <a href=\"#\"></a>";
    $code .= "\t\t\t\t\t </td>\n";
    $code .= "\t\t\t\t\t <td class=\"text-center align-middle\">";
    $code .= "\t\t\t\t\t\t <a href=\"/mipg/plans/home/{$activity['activity']}\">P</a>";
    $code .= "\t\t\t\t\t </td>\n";
    $code .= "\t\t\t\t\t <td class=\"text-center align-middle\">";
    $code .= "\t\t\t\t\t\t <a href=\"/mipg/scores/home/{$activity['activity']}\">$score</a>";
    $code .= "\t\t\t\t\t </td>\n";
    $code .= "\t\t\t\t </tr>\n";
}
$code .= "\t\t\t</tbody>\n";
$code .= "\t\t</table>\n";
$code .= "\t</div>\n";
$code .= "</div>\n";

$title = $strings->get_Clear($category["name"]);
$message = $strings->get_Clear($category["description"]);
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => sprintf(lang('Mipg_Activities.home-title'), ""),
    "header-back" => $back,
    "header-list" => '/mipg/activities/list/' . $oid,
    "alert" => array(
        'type' => 'info',
        'title' => $title,
        'message' => $message
    ),
    "content" => $code,
));
echo($card);
//[info]----------------------------------------------------------------------------------------------------------------
$info = $bootstrap->get_Card("card-view-service", array(
    "alert" => array('type' => 'secondary', 'title' => lang("Mipg_Activities.definition-info-title"), 'message' => lang("Mipg_Activities.definition-info-message"), 'class' => 'mb-0'),
));
//echo($info);
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.title = "<?php echo("Categoría: " . $category["name"]);?>";
    });
</script>
