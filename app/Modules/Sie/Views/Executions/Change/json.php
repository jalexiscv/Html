<?php


//[services]------------------------------------------------------------------------------------------------------------
$request = service('request');
//[models]--------------------------------------------------------------------------------------------------------------
$mexecutions = model("App\Modules\Sie\Models\Sie_Executions");

//[vars]----------------------------------------------------------------------------------------------------------------
$progress = $request->getVar("progress");
$course = $request->getVar("course");
$period = $request->getVar("period");

$query = $mexecutions->where(['course' => $course, 'progress' => $progress, 'period' => $period])->delete();
$data = array(
    "status" => "success",
    "message" => "Datos guardados correctamente",
    "data" => $query
);
echo json_encode($data);
?>