<?php
$mmodules = model('App\Modules\Sie\Models\Sie_Modules');


$bootstrap = service('Bootstrap');
$period = sie_get_current_academic_period();
$count = $mmodules->getCount();

$score = $bootstrap->getScore('courses-all', [
    'title' => 'Histórico de Módulos Total',
    'value' => $count,
    'subtitle' => "2024A - " . $period . "",
    'icon' => ICON_MODULES,
    'variant' => 'default'
]);
echo($score);
?>