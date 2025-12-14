<?php
$mdimensions = model("\App\Modules\Disa\Models\Disa_Dimensions");
$mscores = model("\App\Modules\Disa\Models\Disa_Scores");
$score = $mscores->find($oid);

//$score = $mdimensions->get_ScoreByDimension($oid);

// el $oid es la acividad

?>
<?php echo(get_snippet_score_activity($score["activity"])); ?>
<?php echo(get_snippet_disa_scores($score['activity'])); ?>