<?php

$mdimensions = model("\App\Modules\Disa\Models\Disa_Dimensions");
$dimensions = $mdimensions->findAll();
$score = 0;
$count = 0;
foreach ($dimensions as $dimension) {
    $count++;
    $score += $mdimensions->get_ScoreByDimension($dimension["dimension"]);
}
$average = round(($score / $count), 2);


?>
<div class="card mb-3">
    <div class="card-header ">
        <h2>Dimensiónes</h2>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h1 class="card-score-value mt-0 mb-0"><?php echo($average); ?></h1>
            </div>
            <div class="col-4 text-center">
                <i class="fad fa-signal-4 fa-4x text-orange"></i>
            </div>
        </div>

        <div class="mb-0">
            <!-- <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -3.65% </span> //-->
            <span class="text-muted">Valoración promedio</span>
        </div>
    </div>
</div>


