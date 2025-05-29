<?php


$request = service("request");
//[Models]-----------------------------------------------------------------------------
$mobservations = model("App\Modules\Sie\Models\Sie_Observations");


if (!$request->getJSON()) {
    $data = array(
        "message" => "No se recibio el JSON",
        "status" => 200
    );
    echo(json_encode($data));
} else {
    $data = $request->getJSON();
    $d = array(
        "observation" => $data->observation,
        "type" => $data->type,
        "content" => $data->content,
        "date" => safe_get_date(),
        "time" => safe_get_time(),
        "author" => safe_get_user(),
    );
    $update = $mobservations->update($d["observation"], $d);
    echo(json_encode($data));
}
?>