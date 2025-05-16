<?php

$mcourses = model("App\Modules\Sie\Models\Sie_Courses");
$count = $mcourses->get_CountStudentsByCourse($oid);
$card = get_sie_count_students($count);
echo($card);

?>