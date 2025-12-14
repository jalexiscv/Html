<?php
$mdimensions = model("\App\Modules\Disa\Models\Disa_Dimensions");
$mpolitics = model("\App\Modules\Disa\Models\Disa_Politics");
$mdiagnostics = model("\App\Modules\Disa\Models\Disa_Diagnostics");
$mcomponents = model("\App\Modules\Disa\Models\Disa_Components");
$mcategories = model("\App\Modules\Disa\Models\Disa_Categories");
$mactivities = model("\App\Modules\Disa\Models\Disa_Activities");
$mscores = model("\App\Modules\Disa\Models\Disa_Scores");
$msplans = model("\App\Modules\Disa\Models\Disa_Plans");

?>





<?php

use App\Libraries\Dates;
use App\Libraries\Strings;

$string = new Strings();
$dates = service('dates');
/** Models * */
$dimensions = model("\App\Modules\Disa\Models\Disa_Dimensions");
$politics = model("\App\Modules\Disa\Models\Disa_Politics");
$diagnostics = model("\App\Modules\Disa\Models\Disa_Diagnostics");
$components = model("\App\Modules\Disa\Models\Disa_Components");
$categories = model("\App\Modules\Disa\Models\Disa_Categories");
$activities = model("\App\Modules\Disa\Models\Disa_Activities");
$scores = model("\App\Modules\Disa\Models\Disa_Scores");
$mactions = model("\App\Modules\Disa\Models\Disa_Actions");
$mstatuses = model("\App\Modules\Disa\Models\Disa_Statuses");
$mprocesses = model("\App\Modules\Disa\Models\Disa_Processes");

$plans = model("\App\Modules\Disa\Models\Disa_Plans", true);
/** Queries * */
$plan = $plans->find($oid);
$proccess = $mprocesses->find($plan["manager"]);

$activity = $activities->find($plan["activity"]);
$category = $categories->find($activity["category"]);
$component = $components->find($category["component"]);
$diagnostic = $diagnostics->find($component["diagnostic"]);
$politic = $d = $politics->find($diagnostic["politic"]);
$dimension = $dimensions->find($politic["dimension"]);

/** Vars * */
$dimension_id = $dimension["dimension"];
$dimension_name = urldecode($dimension["name"]);
$politic_id = $politic["politic"];
$politic_name = urldecode($politic["name"]);
$diagnostic_id = $diagnostic["diagnostic"];
$diagnostic_name = $diagnostic["name"];
$component_id = $component["component"];
$component_name = $component["name"];
$category_id = $category["category"];
$category_name = $category["name"];
$activity_name = strip_tags(urldecode($activity["description"]));
$plan_name = $string->get_ZeroFill($plan["order"], 4);
$description = urldecode($plan["description"]);

$score = $scores->where("activity", $activity["activity"])->orderBy("created_at", "DESC")->first();


$start = round(@$score["value"], 2);


$calification = round($plan["value"], 2);

//$t = "<ul style=\"margin: 0px;padding: 0px 10px 0px 10px;line-height:1.1rem;\">";
//$t .= "<li><b>Dimensión</b>:<a href=\"/disa/mipg/dimensions/view/{$dimension_id}\">{$dimension_name}</a></li>";
//$t .= "<li><b>Política</b>: <a href=\"/disa/mipg/diagnostics/view/{$politic_id}\">{$politic_name}</a></li>";
//$t .= "<li><b>Autodiagnóstico</b>: <a href=\"/disa/mipg/components/view/{$diagnostic_id}\">{$diagnostic_name}</a></li>";
//$t .= "<li><b>Componente</b>: <a href=\"/disa/mipg/categories/view/{$component_id}\">{$component_name}</a></li>";
//$t .= "<li><b>Categoría</b>: <a href=\"/disa/mipg/activities/view/{$category_id}\">{$category_name}</a></li>";
//$t .= "<li><b>Actividad</b>: <a href=\"/disa/mipg/activities/view/{$category_id}\">{$activity_name}</a></li>";
//$t .= "</ul>";

$actions_p = $mactions->where("plan", $oid)->countAllResults();
$actions = $mactions->where("plan", $oid)->find();

$count = 0;
foreach ($actions as $action) {
    $status = $mstatuses
        ->where("object", $action["action"])
        ->orderBy("created_at", "DESC")
        ->first();
    if ((isset($status["value"])) && ($status["value"] == "COMPLETED")) {
        $count += 1;
    }
}

if ($actions_p > 0) {
    $percentage = round((($count * 100) / $actions_p), 2);
} else {
    $percentage = 0;
}


$dtotal = $dates::get_ElapsedDays($plan["start"], $plan["end"]);
$dhoy = $dates::get_ElapsedDays($plan["start"], $dates->get_Date());
$time = $dates->get_Time();

$date["start"] = $plan["start"];
$date["end"] = $plan["end"];
$date["elapsed"] = $dtotal - $dhoy;


if ($date["elapsed"] == 0) {
    $date["elapsed"] = round((strtotime("{$plan["end"]} 24:00:00") - strtotime("{$plan["end"]} {$time}")) / (60 * 60), 0) . " Horas";
} else if ($date["elapsed"] < 0) {
    $date["elapsed"] = 0;
}
?>

<link href="/themes/assets/javascripts/gauge/style.css?v2" rel="stylesheet" type="text/css"/>
<script src="/themes/assets/javascripts/gauge/raphael-min.js?v2" type="text/javascript"></script>
<script src="/themes/assets/javascripts/gauge/gauge.js?v4" type="text/javascript"></script>

<div class="card mb-3">
    <div class="card-header p-1"><h5 class="card-header-title p-1  m-0 opacity-3">Calificaciones</h5></div>
    <div class="card-body">
        <center>
            <div class="js-gauge gauge-start"></div>
            <div class="js-gauge gauge"></div>
        </center>
    </div>
</div>

<script>

    $('.gauge-start').kumaGauge({
        value: '<?php echo($start); ?>',
        fill: '0-#990000:20-#ff0000:40-#ff6600:60-#ffff00:80-#009900',
        gaugeBackground: '#1E4147',
        background: '#ffffff',
        gaugeWidth: 20,
        showNeedle: false,
        animationSpeed: 3500,
        paddingX: 40,
        paddingY: 40,
        min: 0,
        max: 100,
        title: {
            display: true,
            value: 'Calificación Inicial',
            fontFamily: 'Arial',
            fontColor: '#000',
            fontSize: 14,
            fontWeight: 'normal'
        },
        label: {
            display: true,
            left: 'Min',
            right: 'Max',
            fontFamily: 'Helvetica',
            fontColor: '#1E4147',
            fontSize: '14',
            fontWeight: 'normal'
        }
    });


    $('.gauge').kumaGauge({
        value: '<?php echo($calification); ?>',
        fill: '0-#990000:20-#ff0000:40-#ff6600:60-#ffff00:80-#009900',
        gaugeBackground: '#1E4147',
        background: '#ffffff',
        gaugeWidth: 20,
        showNeedle: false,
        animationSpeed: 3500,
        paddingX: 40,
        paddingY: 40,
        min: 0,
        max: 100,
        title: {
            display: true,
            value: 'Calificación Propuesta',
            fontFamily: 'Arial',
            fontColor: '#000',
            fontSize: 14,
            fontWeight: 'normal'
        },
        label: {
            display: true,
            left: 'Min',
            right: 'Max',
            fontFamily: 'Helvetica',
            fontColor: '#1E4147',
            fontSize: '14',
            fontWeight: 'normal'
        }
    });

</script>


<?php echo(get_snippet_disa_plans($oid)); ?>
<?php //echo(get_snippet_score_activity($oid));?>
