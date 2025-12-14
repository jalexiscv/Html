<?php

use App\Libraries\Intelligence;

//[models]--------------------------------------------------------------------------------------------------------------
$mmessages = model('App\Modules\Intelligence\Models\Intelligence_Messages');
$mias = model('App\Modules\Intelligence\Models\Intelligence_Ias');

$request = service('request');
$json = $request->getJSON(true);
$response = "";


if (!isset($json['message']) || empty($json['message'])) {
    $response = ('No se recibio un mensaje');
} else {
    $ia = $mias->get_IaByUser(safe_get_user());
    $i = new Intelligence($ia);
    $i->setHistory($mmessages->getMessages(safe_get_user()));
    $response = $i->get_Request($json['message']);
}

$d = array(
    "message" => pk(),
    "from" => safe_get_user(),
    "to" => "IA",
    "priority" => "NORMAL",
    "content" => $json['message'],
    "date" => safe_get_date(),
    "time" => safe_get_time(),
    "author" => safe_get_user(),
);
$create = $mmessages->insert($d);

$d = array(
    "message" => pk(),
    "from" => "IA",
    "to" => safe_get_user(),
    "priority" => "NORMAL",
    "content" => $response['message'],
    "date" => safe_get_date(),
    "time" => safe_get_time(),
    "author" => safe_get_user(),
);
$create = $mmessages->insert($d);

$response = array(
    "id" => uniqid(),
    "timestamp" => time(),
    "message" => $response['message'],
    "history" => $response['history'],
    "status" => "success"
);
echo json_encode($response);
?>