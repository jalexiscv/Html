<?php

use App\Libraries\Server;

use Config\Services;

helper("Application");
$authentication = service('authentication');
$server = service('server');
$mattachments = model('App\Modules\Storage\Models\Storage_Attachments', true);
$file = $mattachments->find($id);
$url = 'https://' . $server->get_Name() . "" . $file["file"];
$uri = "public{$file["file"]}";
$urit = "public/storages/images/thumbnails/{$id}.jpg";

if (url_exists($url)) {
    echo("Existe! " . $url);
//    $mime_type = image_type_to_mime_type(exif_imagetype($url));
//    header('Content-Type: ' . $mime_type);
//    readfile($url);
    echo("<br>" . $uri);
    echo("<br>" . $urit);
    $image = Services::image()->withFile($uri)->fit(100, 100, 'center')->save($urit);

} else {
    //echo("No existe! " . $url);
    http_response_code(404);
    die();
}
?>