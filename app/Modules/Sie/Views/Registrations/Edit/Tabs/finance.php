<?php
/** @var $oid string Es el código de la matricula o estudiante */
$dates = service("dates");
$bootstrap = service("bootstrap");
//[models]--------------------------------------------------------------------------------------------------------------
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$mprograms = model("App\Modules\Sie\Models\Sie_Programs");
$morders = model("App\Modules\Sie\Models\Sie_Orders");
//[vars]----------------------------------------------------------------------------------------------------------------
$registration = view('App\Modules\Sie\Views\Registrations\Edit\Tabs\Finance\registration', array("oid" => $oid));
$enrollment = view('App\Modules\Sie\Views\Registrations\Edit\Tabs\Finance\enrollment', array("oid" => $oid));
$table = view('App\Modules\Sie\Views\Registrations\Edit\Tabs\Finance\table', array("oid" => $oid));
echo($registration);
echo($enrollment);
echo($table);
?>