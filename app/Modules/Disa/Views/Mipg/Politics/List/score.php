<?php

$mdimensions = model("\App\Modules\Disa\Models\Disa_Dimensions");
$score = $mdimensions->get_ScoreByDimension($oid);


?>



<?php echo(get_snippet_disa_dimension($oid)); ?>


<div class="card mb-3">
    <div class="card-header ">
        <h2>Dimensión</h2>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h1 class="card-score-value mt-0 mb-0"><?php echo($score); ?></h1>
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


