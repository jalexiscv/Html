<?php
/** @var string $version */
$server = service("server");
$bootstrap = service("bootstrap");
$strings = service("strings");
//[models]--------------------------------------------------------------------------------------------------------------
$mdiagnostics = model('App\Modules\Mipg\Models\Mipg_Diagnostics');
$mcomponents = model('App\Modules\Mipg\Models\Mipg_Components');
$mcategories = model('App\Modules\Mipg\Models\Mipg_Categories');
$mactivities = model('App\Modules\Mipg\Models\Mipg_Activities');
$mplans = model('App\Modules\Mipg\Models\Mipg_Plans');
$mscores = model('App\Modules\Mipg\Models\Mipg_Scores');
$mfields = model('App\Modules\Mipg\Models\Mipg_Users_Fields');
//[vars]----------------------------------------------------------------------------------------------------------------
$activity = $mactivities->get_Activity($oid);
$back = "/mipg/activities/home/{$activity["category"]}";

$plans = $mplans->get_List(100000, 0, $oid);


$code = "<div class=\"row\">\n";
$count = 0;
$code .= "\t<div class=\"col\">\n";
$code .= "\t\t <table class=\"table table-bordered table-hover w-100 m-0 \">\n";
$code .= "\t\t\t <thead class=\"\">\n";
$code .= "\t\t\t\t <tr>\n";
$code .= "\t\t\t\t\t <th class=\"th text-center\">#</th>\n";
$code .= "\t\t\t\t\t <th class=\"th text-center\">Plan</th>\n";
$code .= "\t\t\t\t\t <th class=\"th text-center\">Recalificación</th>\n";
$code .= "\t\t\t\t\t <th class=\"th text-center\">Descripción</th>\n";
$code .= "\t\t\t\t\t <th class=\"th text-center\">Opciones</th>\n";
$code .= "\t\t\t\t </tr>\n";
$code .= "\t\t\t </thead>\n";
$code .= "\t\t\t <tbody>\n";
$count = 0;
foreach ($plans as $p) {
    $count++;
    $profile = $mfields->get_Profile($p["author"]);
    $description = $strings->get_Clear(urldecode($p["description"]));
    $description .= "<br><b>Proyectado</b>: {$profile['name']} Responsable:";
    $description .= "<br><b>Inicio</b>: {$p["start"]} - <b>Finalización</b>: {$p["end"]}";
    $value = round($p["value"], 0);
    $options = "";
    $code .= "\t\t\t\t <tr>\n";
    $code .= "\t\t\t\t\t <td class=\"text-center align-middle\">" . $strings->get_ZeroFill($p["order"], 4) . "</td>\n";
    $code .= "\t\t\t\t\t <td class=\"text-center align-middle\">{$p['plan']}</td>\n";
    $code .= "\t\t\t\t\t <td class=\"text-center align-middle\">{$value}</td>\n";
    $code .= "\t\t\t\t\t <td class=\"text-start align-middle\">$description</td>\n";
    $code .= "\t\t\t\t\t <td class=\"text-center align-middle\">";
    $code .= "\t\t\t\t\t\t <a class=\"btn btn-primary\" href=\"/mipg/plans/view/{$p["plan"]}\">Ver</a>";
    $code .= "\t\t\t\t\t\t <a class=\"btn btn-secondary\" href=\"/mipg/plans/delete/{$p["plan"]}\">Eliminar</a>";
    $code .= "\t\t\t\t\t </td>\n";
    $code .= "\t\t\t\t </tr>\n"; 
}
$code .= "\t\t\t</tbody>\n";
$code .= "\t\t</table>\n";
$code .= "\t</div>\n";
$code .= "</div>\n";


//print_r($plans);
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => "Listado de planes de la actividad",
    "header-back" => $back,
    "alert" => array(
        'type' => 'info',
        'title' => "Actividad",
        'message' => $activity["description"],
    ),
    "header-list" => '/mipg/plans/list/' . $oid,
    "content" => $code,
));
echo($card);

//[info]----------------------------------------------------------------------------------------------------------------
$info = $bootstrap->get_Card("card-view-service", array(
    "alert" => array(
        'type' => 'secondary',
        'title' => lang("Mipg_Plans.list-alert-title"),
        'message' => lang("Mipg_Plans.list-alert-message"),
        'class' => 'mb-0'
    ),
));
echo($info);
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.title = "<?php echo("Planes");?>";
    });
</script>
