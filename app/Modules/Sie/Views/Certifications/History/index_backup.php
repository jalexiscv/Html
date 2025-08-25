<?php

require_once(APPPATH . 'ThirdParty/PHPOffice/autoload.php');

$request = service("request");
$enrollment = $request->getVar("enrollment");

// Validar parámetros requeridos
if (empty($enrollment)) {
    die("Error: Faltan parámetros requeridos (enrollment)");
}

//[models]--------------------------------------------------------------------------------------------------------------
$menrollments = model('App\Modules\Sie\Models\Sie_Enrollments');
$mprograms = model('App\Modules\Sie\Models\Sie_Programs');
$mprogress = model('App\Modules\Sie\Models\Sie_Progress');
$mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');
$mexecutions = model('App\Modules\Sie\Models\Sie_Executions');
//[vars]----------------------------------------------------------------------------------------------------------------
$periods = $mexecutions->getPeriodsByEnrollment($enrollment);

//echo(safe_dump($periods));

foreach ($periods as $period) {
    $period = $period["period_curso"];


}


?>