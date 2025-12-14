<?php
// Recibe una politica para consultar los dignosticos
$mdimensions = model("\App\Modules\Disa\Models\Disa_Dimensions");
$score = $mdimensions->get_ScoreByDimension($oid);


?>
<?php echo(get_snippet_disa_diagnostic($oid)); ?>
<?php echo(get_snippet_score_politic($oid)); ?>