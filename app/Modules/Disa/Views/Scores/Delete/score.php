<?php
/*
 * Copyright (c) 2022. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

$mdimensions = model("\App\Modules\Disa\Models\Disa_Dimensions");
$mscores = model("\App\Modules\Disa\Models\Disa_Scores");
$score = $mscores->find($oid);

//$score = $mdimensions->get_ScoreByDimension($oid);


?>
<?php echo(get_snippet_score_activity(@$score["activity"])); ?>
<?php //echo(get_snippet_disa_activities($oid));?>