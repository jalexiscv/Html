<?php

//https://bugavision.com/storage/image/60BE231B87CA3
//https://bugavision.com/storage/image/single/6412547999D29/image.jpg
use App\Libraries\Server;

use Config\Services;

helper("Application");
$authentication = service('authentication');
$server = service('server');
$mattachments = model('App\Modules\Storage\Models\Storage_Attachments', true);
$file = $mattachments->find($id);
$url = 'https://' . $server->get_Name() . "" . $file["file"];
$gs_url =cdn_url($file["file"]);
//print_r($gs_url);
readfile($gs_url);
/**
 *
 * $uri = ROOTPATH . "public" . "{$file["file"]}";
 * $urit = ROOTPATH . "public" . "/storages/images/singles/{$id}.jpg";
 *
 * if (url_exists($url)) {
 * if (!file_exists($urit)) {
 * $image = Services::image()
 * ->withFile($uri)
 * ->fit(800, 600, 'center')
 * ->text(DOMAIN, [
 * 'color' => '#fff',
 * 'opacity' => 0.5,
 * 'withShadow' => true,
 * 'hAlign' => 'right',
 * 'vAlign' => 'bottom',
 * 'fontSize' => 204
 * ])
 * ->save($urit);
 * }
 * $mime_type = image_type_to_mime_type(exif_imagetype($urit));
 * readfile($urit);
 * } else {
 * http_response_code(404);
 * die();
 * }
 * **/
?>