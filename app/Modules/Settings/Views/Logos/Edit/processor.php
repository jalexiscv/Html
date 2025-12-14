<?php

require_once(APPPATH . 'ThirdParty/Google/autoload.php');

use Google\Cloud\Storage\StorageClient;

$bootstrap = service('Bootstrap');
$server = service("server");
$f = service("forms", array("lang" => "Social.settings-logotypes-"));
$model = model("App\Modules\Disa\Models\Disa_Characterizations");
$continue = base_url("/settings/logos/view/" . lpk());

$clients = model("App\Models\Application_Clients");
$client = $clients->get_ClientByDomain($server::get_FullName());

$d = array(
    "client" => $f->get_Value("client"),
    "author" => $authentication->get_User(),
);
if (isset($client["client"])) {
    $logo = $request->getFile($f->get_fieldId("logo"));
    $logo_portrait = $request->getFile($f->get_fieldId("logo_portrait"));
    $logo_portrait_light = $request->getFile($f->get_fieldId("logo_portrait_light"));
    $logo_landscape = $request->getFile($f->get_fieldId("logo_landscape"));
    $logo_landscape_light = $request->getFile($f->get_fieldId("logo_landscape_light"));
    /** Si el directorio no existe procedo a crearlo **/
    $path = "/storages/" . md5($server::get_FullName()) . "/images/logos";
    $realpath = ROOTPATH . "public" . $path;
    if (!file_exists($realpath)) {
        mkdir($realpath, 0777, true);
    }
    /** Proceso los archivos cargados **/
    if ($logo->isValid()) {
        //[Local]-------------------------------------------------------------------------------------------------------
        $rname = $logo->getRandomName();
        $logo->move($realpath, $rname);
        $name = $logo->getClientName();
        $type = $logo->getClientMimeType();
        $logo = "{$path}/{$rname}";
        $d['logo'] = $logo;
        $authentication->set("logo", $logo);
        //[Storage]-----------------------------------------------------------------------------------------------------
        $fullpath = "{$realpath}/{$rname}";
        $spath = substr("{$path}/{$rname}", 1);
        $storage = new StorageClient(['keyFilePath' => APPPATH . 'ThirdParty/Google/keys.json']);
        $bucket = $storage->bucket("cloud-engine");
        $bucket->upload(fopen($fullpath, 'r'), ['name' => $spath, 'predefinedAcl' => 'publicRead']);
    }
    if ($logo_portrait->isValid()) {
        $rname = "logo-portrait-dark-" . $logo_portrait->getRandomName();
        $logo_portrait->move($realpath, $rname);
        $name = $logo_portrait->getClientName();
        $type = $logo_portrait->getClientMimeType();
        $portrait = "{$path}/{$rname}";
        $d['logo_portrait'] = $portrait;
        $authentication->set("logo_portrait", $portrait);
        //[Storage]-----------------------------------------------------------------------------------------------------
        $fullpath = "{$realpath}/{$rname}";
        $spath = substr("{$path}/{$rname}", 1);
        $storage = new StorageClient(['keyFilePath' => APPPATH . 'ThirdParty/Google/keys.json']);
        $bucket = $storage->bucket("cloud-engine");
        $bucket->upload(fopen($fullpath, 'r'), ['name' => $spath, 'predefinedAcl' => 'publicRead']);
    }
    if ($logo_portrait_light->isValid()) {
        $rname = "logo-portrait-light-" . $logo_portrait_light->getRandomName();
        $logo_portrait_light->move($realpath, $rname);
        $name = $logo_portrait_light->getClientName();
        $type = $logo_portrait_light->getClientMimeType();
        $portrait_light = "{$path}/{$rname}";
        $d['logo_portrait_light'] = $portrait_light;
        $authentication->set("logo_portrait_light", $portrait_light);
        //[Storage]-----------------------------------------------------------------------------------------------------
        $fullpath = "{$realpath}/{$rname}";
        $spath = substr("{$path}/{$rname}", 1);
        $storage = new StorageClient(['keyFilePath' => APPPATH . 'ThirdParty/Google/keys.json']);
        $bucket = $storage->bucket("cloud-engine");
        $bucket->upload(fopen($fullpath, 'r'), ['name' => $spath, 'predefinedAcl' => 'publicRead']);
    }
    if ($logo_landscape->isValid()) {
        $rname = "logo-landscape-dark-" . $logo_landscape->getRandomName();
        $logo_landscape->move($realpath, $rname);
        $name = $logo_landscape->getClientName();
        $type = $logo_landscape->getClientMimeType();
        $landscape = "{$path}/{$rname}";
        $d['logo_landscape'] = $landscape;
        $authentication->set("logo_landscape", $landscape);
        //[Storage]-----------------------------------------------------------------------------------------------------
        $fullpath = "{$realpath}/{$rname}";
        $spath = substr("{$path}/{$rname}", 1);
        $storage = new StorageClient(['keyFilePath' => APPPATH . 'ThirdParty/Google/keys.json']);
        $bucket = $storage->bucket("cloud-engine");
        $bucket->upload(fopen($fullpath, 'r'), ['name' => $spath, 'predefinedAcl' => 'publicRead']);
    }
    if ($logo_landscape_light->isValid()) {
        $rname = "logo-landscape-light-" . $logo_landscape_light->getRandomName();
        $logo_landscape_light->move($realpath, $rname);
        $name = $logo_landscape_light->getClientName();
        $type = $logo_landscape_light->getClientMimeType();
        $landscape_light = "{$path}/{$rname}";
        $d['logo_landscape_light'] = $landscape_light;
        $authentication->set("logo_landscape_light", $landscape_light);
        //[Storage]-----------------------------------------------------------------------------------------------------
        $fullpath = "{$realpath}/{$rname}";
        $spath = substr("{$path}/{$rname}", 1);
        $storage = new StorageClient(['keyFilePath' => APPPATH . 'ThirdParty/Google/keys.json']);
        $bucket = $storage->bucket("cloud-engine");
        $bucket->upload(fopen($fullpath, 'r'), ['name' => $spath, 'predefinedAcl' => 'publicRead']);
    }
    $clients->update($client['client'], $d);

    $card = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Settings.logotypes-edit-success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Settings.logotypes-edit-success-message"), $d['client']),
        "footer-continue" => $continue,
        "footer-class" => "text-center",
        "voice" => "",
    ));
} else {
    $card = $bootstrap->get_Card("noexist", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Settings.client-noexist-title"),
        "text-class" => "text-center",
        "text" => lang("Settings.client-noexist-message"),
        "footer-continue" => $continue,
        "footer-class" => "text-center",
        "voice" => "",
    ));
}
echo($card);
cache()->clean();
?>