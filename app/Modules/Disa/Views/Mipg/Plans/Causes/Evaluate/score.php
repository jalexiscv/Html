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

<?php echo(get_snippet_disa_plans($oid)); ?>
<?php //echo(get_snippet_score_activity($oid));?>
