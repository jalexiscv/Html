<?php
$mattachments = model("App\Modules\Disa\Models\Disa_Attachments");
$mscores = model("App\Modules\Disa\Models\Disa_Scores.php");
$attachment = $mattachments->where('attachment', $oid)->withDeleted(true)->first();
$score = $mscores->find($attachment["object"]);
?>
<?php echo(get_snippet_score_activity($score["activity"])); ?>
<?php echo(get_snippet_disa_scores($score['activity'])); ?>