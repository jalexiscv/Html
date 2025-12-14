<?php
/** @var string $oid program */
$mpensums = model('App\Modules\Sie\Models\Sie_Pensums');
$mcourses = model('App\Modules\Sie\Models\Sie_Courses');

$pensum = $mpensums->get_Pensum($oid);

$courses = $mcourses->where('module', $pensum['module'])->findAll();

$json = json_encode(array(
    "data" => $courses
));
echo($json);
?>