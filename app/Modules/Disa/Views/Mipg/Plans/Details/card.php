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


<style>
    .label {
        font-size: 1rem;
        line-height: 0.75rem;
        color: #000;
        width: 100%;
        background-color: #ffd270;
        padding: 5px;
        border-top: none;
        border-bottom: 1px solid #ffd270;
        font-weight: normal;
    }

    .value {
        font-size: 14px;
        line-height: 14px;
        color: #000000;
        width: 100%;
        padding: 5px;
    }

    .field {
        font-size: 1rem;
        padding: 0;
        color: #000000;
        line-height: 1rem;
        margin-bottom: 5px;
        border: 1px solid #ffd270;
        background-color: #ffffff;
    }

</style>

<div class="row">
    <div class="col-12">

        <div class="row pr-3 pl-3">
            <div class="col-3 field">
                <div class="label text-center">Dimensión</div>
                <div class="value text-center"><?php echo($dimension_name); ?></div>
            </div>

            <div class="col-3 field">
                <div class="label text-center">Política</div>
                <div class="value text-center"><?php echo($politic_name); ?></div>
            </div>

            <div class="col-3 field text-center">
                <div class="label">Componente</div>
                <div class="value text-center"><?php echo($component_name); ?></div>
            </div>

            <div class="col-3 field">
                <div class="label text-center">Categoría</div>
                <div class="value "><?php echo($category_name); ?></div>
            </div>
        </div>

        <div class="row pr-3 pl-3">
            <div class="col-12 field">
                <div class="label text-center">Actividad</div>
                <div class="value"><?php echo($activity_name); ?></div>
            </div>
        </div>

        <div class="row pr-3 pl-3">
            <div class="col-12 field">
                <div class="label text-center">Descripción del plan #<?php echo($plan_name); ?></div>
                <div class="value"><?php echo($description); ?></div>
            </div>
        </div>

        <div class="row pr-3 pl-3">
            <div class="col-4 field">
                <div class="label text-center">Acciones Propuestas</div>
                <div class="value text-center"><?php echo($actions_p); ?></div>
            </div>

            <div class="col-4 field">
                <div class="label text-center">Acciones Cumplidas</div>
                <div class="value text-center"><?php echo($count); ?></div>
            </div>

            <div class="col-4 field">
                <div class="label text-center">Porcentaje de avance</div>
                <div class="value text-center"><?php echo($percentage); ?>%</div>
            </div>
        </div>

        <div class="row pr-3 pl-3">
            <div class="col-4 field">
                <div class="label text-center">Fecha de Inicio</div>
                <div class="value text-center"><?php echo($date["start"]); ?></div>
            </div>

            <div class="col-4 field">
                <div class="label text-center">Fecha Finalización</div>
                <div class="value text-center"><?php echo($date["end"]); ?></div>
            </div>

            <div class="col-4 field">
                <div class="label text-center">Tiempo Restante</div>
                <div class="value text-center"><?php echo($date["elapsed"]); ?></div>
            </div>
        </div>

        <div class="row pr-3 pl-3">
            <div class="col-12 field text-center"
                 style="font-size: 1rem;background:#ff4500;border: 1px solid #c9dce8;padding: 0.5rem;color: #0d0e0f;font-weight: bold;">
                Responsable del Plan de Acción
            </div>
        </div>

        <div class="row pr-3 pl-3">
            <div class="col-6 field">
                <div class="label text-center">Nombre</div>
                <div class="value text-center"><?php echo(@$proccess["responsible"]); ?></div>
            </div>
            <div class="col-6 field">
                <div class="label text-center">Cargo</div>
                <div class="value text-center"><?php echo(@$proccess["position"]); ?></div>
            </div>

        </div>

    </div>
</div>