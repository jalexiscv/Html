<?php

$string = service('strings');
$dates = service('dates');
/** Models * */
$dimensions = model("\App\Modules\Plans\Models\Plans_Dimensions");
$politics = model("\App\Modules\Plans\Models\Plans_Politics");
$diagnostics = model("\App\Modules\Plans\Models\Plans_Diagnostics");
$components = model("\App\Modules\Plans\Models\Plans_Components");
$categories = model("\App\Modules\Plans\Models\Plans_Categories");
$activities = model("\App\Modules\Plans\Models\Plans_Activities");
$scores = model("\App\Modules\Plans\Models\Plans_Scores");
$mactions = model("\App\Modules\Plans\Models\Plans_Actions");

$plans = model("\App\Modules\Plans\Models\Plans_Plans", true);
/** Queries * */

$plan = $plans->getPlan($oid);


$start = @$plan["score"];
$calification = round($plan["value"], 2);


?>
<div class="card mb-3">
    <div class="card-header p-1"><h5 class="card-header-title p-1">Calificación Actual</h5></div>
    <div class="card-body">
        <center>
            <canvas id="gaugeCanvas" style="width:100%;height: 150px;"></canvas>
        </center>
    </div>
</div>
<div class="card mb-3">
    <div class="card-header p-1"><h5 class="card-header-title p-1  m-0">Calificación Propuesta</h5></div>
    <div class="card-body">
        <center>
            <canvas id="gaugeCanvas2" style="width:100%;height: 150px;"></canvas>
        </center>
    </div>
</div>

<script>

    document.addEventListener("DOMContentLoaded", function () {
        drawGauge('gaugeCanvas',<?php echo($start);?>, 300, 150, "Actual");
        drawGauge('gaugeCanvas2',<?php echo($calification);?>, 300, 150, "Propuesta");

        function drawGauge(canvasId, percentage, width, height, text) {
            const canvas = document.getElementById(canvasId);
            const ctx = canvas.getContext('2d');

            // Ajustar tamaño del canvas
            canvas.width = width;
            canvas.height = height;

            const centerX = width / 2;
            const centerY = height * 0.9;
            const radius = height * 0.8;

            // Configuración del Gauge
            const startAngle = Math.PI; // 180 grados
            const endAngle = 2 * Math.PI; // 360 grados
            const minValue = 0;
            const maxValue = 100;
            const currentValue = Math.min(Math.max(percentage, 0), 100); // Limitar a 0-100%

            // Dibujar arco de fondo
            ctx.beginPath();
            ctx.arc(centerX, centerY, radius, startAngle, endAngle, false);
            ctx.lineWidth = width * 0.05; // Ancho del arco proporcional al ancho del canvas
            ctx.strokeStyle = '#e6e6e6';
            ctx.stroke();

            // Dibujar arco del valor actual
            const valueAngle = startAngle + (currentValue / maxValue) * (endAngle - startAngle);
            ctx.beginPath();
            ctx.arc(centerX, centerY, radius, startAngle, valueAngle, false);
            ctx.lineWidth = width * 0.05; // Ancho del arco proporcional al ancho del canvas
            ctx.strokeStyle = '#007bff';
            ctx.stroke();

            // Dibujar texto del porcentaje
            ctx.font = `${width * 0.06}px Arial`; // Tamaño de la fuente proporcional al ancho del canvas
            ctx.fillStyle = '#000';
            ctx.textAlign = 'center';
            ctx.fillText(`${currentValue}%`, centerX, centerY - radius - width * 0.05);

            // Dibujar numeración de 0 a 100%
            ctx.font = `${width * 0.04}px Arial`; // Tamaño de la fuente proporcional al ancho del canvas
            ctx.fillStyle = '#000';
            ctx.textAlign = 'center';
            ctx.fillText('0', centerX - radius, centerY + width * 0.05);
            ctx.font = `${width * 0.23}px Arial`;
            ctx.fillText(percentage, centerX, centerY + width * 0.01 - 25);
            ctx.font = `${width * 0.08}px Arial`;
            ctx.fillText(text, centerX, centerY + width * 0.03);
            ctx.font = `${width * 0.04}px Arial`;
            ctx.fillText('100', centerX + radius, centerY + width * 0.05);
        }

    });


</script>