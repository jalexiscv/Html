<?php
$mdimensions = model("\App\Modules\Disa\Models\Disa_Dimensions");
$score = $mdimensions->get_ScoreByDimension($oid);
?>

<?php echo(get_snippet_disa_scores($oid)); ?>
<?php echo(get_snippet_score_activity($oid)); ?>
