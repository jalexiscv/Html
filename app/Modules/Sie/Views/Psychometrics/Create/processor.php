<?php
require_once(APPPATH . 'ThirdParty/Google/autoload.php');

use Google\Cloud\Storage\StorageClient;

/**
 * █ -------------------------------------------------------------------------------------------------------------------
 * █ Datos recibidos desde el controlador - @ModuleController
 * █ -------------------------------------------------------------------------------------------------------------------
 * █ @var object $parent Trasferido desde el controlador
 * █ @var object $authentication Trasferido desde el controlador
 * █ @var object $request Trasferido desde el controlador
 * █ @var object $dates Trasferido desde el controlador
 * █ @var string $component Trasferido desde el controlador
 * █ @var string $view Trasferido desde el controlador
 * █ @var string $oid Trasferido desde el controlador
 * █ @var string $views Trasferido desde el controlador
 * █ @var string $prefix Trasferido desde el controlador
 * █ @var array $data Trasferido desde el controlador
 * █ @var object $model Modelo de datos utilizado en la vista y trasferido desde el index
 * █ -------------------------------------------------------------------------------------------------------------------
 **/
//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
$server = service('server');
//[Models]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Psychometrics."));
$model = model("App\Modules\Sie\Models\Sie_Psychometrics");
//[Vars]-----------------------------------------------------------------------------
$back = "/sie/teachers/view/{$oid}";
$d = array(
    "psychometric" => $f->get_Value("psychometric"),
    "teacher" => $f->get_Value("teacher"),
    "file" => $f->get_Value("file"),
    "fulfilled" => $f->get_Value("fulfilled"),
    "comments" => $f->get_Value("comments"),
    "author" => safe_get_user(),
);
$row = $model->find($d["psychometric"]);
$l["back"] = "$back";
$l["edit"] = "/sie/psychometrics/edit/{$d["psychometric"]}";
$asuccess = "sie/psychometrics-create-success-message.mp3";
$aexist = "sie/psychometrics-create-exist-message.mp3";
if (is_array($row)) {
    $c = $bootstrap->get_Card("duplicate", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Psychometrics.create-duplicate-title"),
        "text-class" => "text-center",
        "text" => lang("Psychometrics.create-duplicate-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $aexist,
    ));
} else {
    $path = '/storages/' . md5($server->get_FullName()) . '/sie/files';
    $file = $request->getFile($f->get_fieldId('file'));
    if (!is_null($file) && $file->isValid()) {
        $rname = $file->getRandomName();
        $realpath = ROOTPATH . 'public' . $path;
        $file->move($realpath, $rname);
        $name = $file->getClientName();
        $type = $file->getClientMimeType();
        $size = $file->getSize();
        $url = $path . "/" . $rname;
        $a = array(
            "attachment" => pk(),
            "object" => $d['psychometric'],
            "file" => $url,
            "type" => $type,
            "date" => $dates->get_Date(),
            "time" => $dates->get_Time(),
            "alt" => "",
            "title" => "",
            "size" => $size,
            "reference" => "PHOTO",
            "author" => safe_get_user(),
        );
        //[storage]-----------------------------------------------------------------------------------------------------
        $fullpath = "{$realpath}/{$rname}";
        $spath = substr("{$path}/{$rname}", 1);
        $storage = new StorageClient(['keyFilePath' => APPPATH . 'ThirdParty/Google/keys.json']);
        $bucket = $storage->bucket("cloud-engine");
        $bucket->upload(fopen($fullpath, 'r'), ['name' => $spath, 'predefinedAcl' => 'publicRead']);
        //[/storage]----------------------------------------------------------------------------------------------------
        $mattachments = model("App\Modules\Storage\Models\Storage_Attachments");
        $create = $mattachments->insert($a);
    }
    $create = $model->insert($d);
    //echo($model->getLastQuery()->getQuery());
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Psychometrics.create-success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Psychometrics.create-success-message"), $d['psychometric']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
}
echo($c);
?>