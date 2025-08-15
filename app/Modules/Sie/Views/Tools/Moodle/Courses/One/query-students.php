<?php
$mcourses = model('App\Modules\Sie\Models\Sie_Courses');
$mmodules = model('App\Modules\Sie\Models\Sie_Modules');
$mversions = model('App\Modules\Sie\Models\Sie_Versions');
$mpensums = model('App\Modules\Sie\Models\Sie_Pensums');
$mgrids = model('App\Modules\Sie\Models\Sie_Grids');
$mprograms = model('App\Modules\Sie\Models\Sie_Programs');
$musers = model('App\Modules\Sie\Models\Sie_Users');
$mfields = model('App\Modules\Sie\Models\Sie_Users_Fields');
$mexecutions = model('App\Modules\Sie\Models\Sie_Executions');
$mprogress = model('App\Modules\Sie\Models\Sie_Progress');
$menrollments = model('App\Modules\Sie\Models\Sie_Enrollments');
$mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');
$mstatuses = model('App\Modules\Sie\Models\Sie_Statuses');

$executions = $mexecutions
    ->select('MAX(execution) as execution, progress,c1,c2,c3')
    ->where('course', $oid)
    ->groupBy(['course', 'progress'])
    ->find();

foreach ($executions as $execution) {
    $execution_execution = @$execution["execution"];

    $progress = $mprogress->where('progress', $execution['progress'])->first();
    $enrollment = $menrollments->where('enrollment', $progress['enrollment'])->first();
    $registration = $mregistrations->where('registration', $enrollment['student'])->first();
    $fullname = @$registration['first_name'] . " " . @$registration['second_name'] . " " . @$registration['first_surname'] . " " . @$registration['second_surname'];
    $identification_number = @$registration['identification_number'];
    $console[] = "> --- : {$execution_execution}: {$fullname}...";
    $console[] = "> --- : Moodle UserID: {$identification_number}...";
    include("moodle-course-asign.php");


}

?>