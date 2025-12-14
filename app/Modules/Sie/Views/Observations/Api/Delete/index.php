<?php


$request = service("request");
//[Models]-----------------------------------------------------------------------------
$mobservations = model("App\Modules\Sie\Models\Sie_Observations");

$json = $request->getJSON();
if (!$json) {
    $data = array(
        "message" => "No se recibio el JSON",
        "status" => 200
    );
    echo(json_encode($data));
} else {
    $observation = $json->observation;
    $dobservation = $mobservations->get_Observation($observation);
    $created_at = $dobservation["created_at"];//Format: Y-m-d H:i:s

    // Check if 24 hours have passed
    $created_time = new DateTime($created_at);
    $current_time = new DateTime();
    $interval = $current_time->diff($created_time);

    if ($interval->h < 24 && $interval->days == 0) {
        $data = array(
            "message" => "Observación eliminada correctamente",
            "status" => 200,
            "data" => $mobservations->delete($observation)
        );
        $mobservations->clear_AllCache();
    } else {
        $data = array(
            "message" => "No se puede eliminar la observación después de 24 horas",
            "status" => 403
        );
    }


    echo(json_encode($data));
}
?>