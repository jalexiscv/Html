<?php

$mdimensions = model("\App\Modules\Disa\Models\Disa_Dimensions");
$score = $mdimensions->get_ScoreByDimension($oid);
?>

<?php echo(get_snippet_disa_components($oid)); ?>
<?php echo(get_snippet_score_diagnostic($oid)); ?>

