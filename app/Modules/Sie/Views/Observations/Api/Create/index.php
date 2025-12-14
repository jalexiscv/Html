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
        "observation" => pk(),
        "object" => $data->object,
        "type" => $data->type,
        "content" => $data->content,
        "date" => safe_get_date(),
        "time" => safe_get_time(),
        "author" => safe_get_user(),
    );
    $create = $mobservations->insert($d);
    echo(json_encode($data));
}


?>