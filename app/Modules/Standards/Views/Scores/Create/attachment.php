<?php
require_once(APPPATH . 'ThirdParty/Google/autoload.php');

use Google\Cloud\Storage\StorageClient;

/** @var object $request viene del processor.php */
/** @var object $server viene del processor.php */
/** @var object $dates viene del processor.php */
/** @var object $f viene del processor.php */

$path = '/storages/' . md5($server->get_FullName()) . 'sie/files';
$file = $request->getFile($f->get_fieldId('file'));
if (!is_null($file) && $file->isValid()) {
    $rname = $file->getRandomName();
    $dir = ROOTPATH . 'public' . $path;
    $file->move($dir, $rname);
    $name = $file->getClientName();
    $type = $file->getClientMimeType();
    $size = $file->getSize();
    $url = $path . "/" . $rname;
    $a = array(
        "attachment" => pk(),
        "object" => $d['score'],
        "file" => $url,
        "type" => $type,
        "date" => $dates->get_Date(),
        "time" => $dates->get_Time(),
        "alt" => "",
        "title" => "",
        "size" => $size,
        "reference" => "EVIDENCES",
        "author" => safe_get_user(),
    );
    //[storage]-----------------------------------------------------------------------------------------------------
    $fullpath = "{$dir}/{$rname}";
    $spath = substr("{$path}/{$rname}", 1);
    $storage = new StorageClient(['keyFilePath' => APPPATH . 'ThirdParty/Google/keys.json']);
    $bucket = $storage->bucket("cloud-engine");
    $bucket->upload(fopen($fullpath, 'r'), ['name' => $spath, 'predefinedAcl' => 'publicRead']);
    //[/storage]----------------------------------------------------------------------------------------------------

    $mattachments = model("App\Modules\Storage\Models\Storage_Attachments");
    $create = $mattachments->insert($a);
    //------------------------------------------------------------------------------------------------------------------
}
?>