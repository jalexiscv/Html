<?php

//https://bugavision.com/storage/image/60BE231B87CA3
use App\Libraries\Server;

use Config\Services;

helper("Application");
$authentication = service('authentication');
$server = service('Server');
$mattachments = model('App\Modules\Storage\Models\Storage_Attachments', true);
$file = $mattachments
    ->where('object', $id)
    ->where('reference', 'AVATAR')
    ->orderBy('created_at', 'DESC')
    ->first();
$url = 'https://' . $server->get_Name() . "" . $file["file"];
$uri = PUBLICPATH . ltrim($file["file"], "/");
$urit = PUBLICPATH . "storages/images/avatar/{$id}.jpg";

if (url_exists($url)) {
    if (!file_exists($urit)) {
        $image = Services::image()
            ->withFile($uri)
            ->fit(128, 128, 'center')
            ->text(DOMAIN, [
                'color' => '#fff',
                'opacity' => 0.5,
                'withShadow' => true,
                'hAlign' => 'right',
                'vAlign' => 'bottom',
                'fontSize' => 204
            ])->save($urit);
    } else {
        $last_modified = filemtime($urit);
        $age = time() - $last_modified;
        if ($age > 600) {
            unlink($urit);
            $image = Services::image()
                ->withFile($uri)
                ->fit(128, 128, 'center')
                ->text(DOMAIN, [
                    'color' => '#fff',
                    'opacity' => 0.5,
                    'withShadow' => true,
                    'hAlign' => 'right',
                    'vAlign' => 'bottom',
                    'fontSize' => 204
                ])->save($urit);
        }
    }
    $mime_type = image_type_to_mime_type(exif_imagetype($urit));
    readfile($urit);
} else {
    http_response_code(404);
    die();
}

?>