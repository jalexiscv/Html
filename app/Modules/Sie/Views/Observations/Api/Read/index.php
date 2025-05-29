<?php


$request = service("request");
//[Models]-----------------------------------------------------------------------------
$mobservations = model("App\Modules\Sie\Models\Sie_Observations");

$observation = $request->getVar("observation");

$data = array(
    "message" => "No el id de la observación",
    "status" => 200
);


if (!empty($observation)) {
    $dobservation = $mobservations->get_Observation($observation);
    if (is_array($dobservation) && isset($dobservation['observation'])) {
        $data = array(
            "message" => "Se obtuvo la observación correctamente",
            "status" => 200,
            "data" => $dobservation
        );
    } else {
        $data = array(
            "message" => "No se encontró la observación",
            "status" => 404
        );
    }

}
echo(json_encode($data));
?>