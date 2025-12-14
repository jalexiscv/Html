<?php

require_once(APPPATH . 'ThirdParty/Google/autoload.php');

use Google\Cloud\Storage\StorageClient;

$server = service("server");

$f = service('forms', array('lang' => 'Nexus.'));
$mclients = model('App\Modules\Nexus\Models\Nexus_Clients');
/*
 * -----------------------------------------------------------------------------
 * [Fields]
 * -----------------------------------------------------------------------------
*/
$domain = str_replace('www.', '', $f->get_Value('domain'));
$d = array(
    'option' => $f->get_Value('option'),
    'client' => $f->get_Value('client'),
    'name' => $f->get_Value('name', true, true),
    'domain' => $domain,
    'default_url' => $f->get_Value('default_url'),
    'db' => $f->get_Value('db'),
    'db_host' => $f->get_Value('db_host'),
    'db_port' => $f->get_Value('db_port'),
    'db_user' => $f->get_Value('db_user'),
    'db_password' => $f->get_Value('db_password'),
    'theme' => $f->get_Value('theme'),
    'theme_color' => $f->get_Value('theme_color'),
    'fb_app_id' => $f->get_Value('fb_app_id'),
    'fb_app_secret' => $f->get_Value('fb_app_secret'),
    'fb_page' => $f->get_Value('fb_page'),
    'arc_id' => $f->get_Value('arc_id'),
    'matomo' => $f->get_Value('matomo'),
    'author' => $authentication->get_User(),
);
/*
 * -----------------------------------------------------------------------------
 * [Processing]
 * -----------------------------------------------------------------------------
*/
$row = $mclients->find($d['client']);
if (isset($row['client'])) {
    if ($d["option"] == "interface") {
        $du = array(
            'theme' => $f->get_Value('theme'),
            'theme_color' => $f->get_Value('theme_color'),
        );
        $mclients->update($d['client'], $du);
    } else if ($d["option"] == "images") {
        $logo = $request->getFile($f->get_fieldId("logo"));
        $logo_portrait = $request->getFile($f->get_fieldId("logo_portrait"));
        $logo_portrait_light = $request->getFile($f->get_fieldId("logo_portrait_light"));
        $logo_landscape = $request->getFile($f->get_fieldId("logo_landscape"));
        $logo_landscape_light = $request->getFile($f->get_fieldId("logo_landscape_light"));
        /** Si el directorio no existe procedo a crearlo **/
        $path = "/storages/" . md5($server::get_FullName()) . "/application/logos";
        $realpath = ROOTPATH . "public" . $path;
        if (!file_exists($realpath)) {
            mkdir($realpath, 0777, true);
        }
        /** Proceso los archivos cargados **/
        if ($logo->isValid()) {
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
        $du = array(
            'logo' => $d['logo'],
            'logo_portrait' => $d['logo_portrait'],
            'logo_portrait_light' => $d['logo_portrait_light'],
            'logo_landscape' => $d['logo_landscape'],
            'logo_landscape_light' => $d['logo_landscape_light'],
        );
        $mclients->update($d['client'], $du);
    } elseif ($d["option"] == "profile") {
        $du = array(
            'name' => $f->get_Value('name', true, true),
            'domain' => $domain,
            'default_url' => $f->get_Value('default_url'),
            'db' => $f->get_Value('db'),
            'db_host' => $f->get_Value('db_host'),
            'db_port' => $f->get_Value('db_port'),
            'db_user' => $f->get_Value('db_user'),
            'db_password' => $f->get_Value('db_password'),
            'fb_app_id' => $f->get_Value('fb_app_id'),
            'fb_app_secret' => $f->get_Value('fb_app_secret'),
            'fb_page' => $f->get_Value('fb_page'),
            'arc_id' => $f->get_Value('arc_id'),
            'matomo' => $f->get_Value('matomo'),
        );
        $mclients->update($d['client'], $du);
    } elseif ($d["option"] == "database") {
        $du = array(
            'db' => $f->get_Value('db'),
            'db_host' => $f->get_Value('db_host'),
            'db_port' => $f->get_Value('db_port'),
            'db_user' => $f->get_Value('db_user'),
            'db_password' => $f->get_Value('db_password'),
        );
        $mclients->update($d['client'], $du);
    } else {

    }
    /* Build */
    $smarty = service('smarty');
    $smarty->set_Mode('bs5x');
    $smarty->assign('title', lang('Nexus.clients-edit-success-title'));
    $smarty->assign('message', lang('Nexus.clients-edit-success-message'));
    $smarty->assign('continue', base_url('/nexus/clients'));
    $smarty->assign('voice', 'nexus/clients-edit-success-message.mp3');
    $c = $smarty->view('alerts/card/success.tpl');

} else {
    $smarty = service('smarty');
    $smarty->set_Mode('bs5x');
    $smarty->assign('title', lang('Nexus.clients-edit-noexist-title'));
    $smarty->assign('message', sprintf(lang('Nexus.clients-edit-noexist-message'), $d['client']));
    $smarty->assign('continue', base_url('/nexus/clients/'));
    $smarty->assign('voice', 'nexus/clients-edit-noexist-message.mp3');
    $c = $smarty->view('alerts/card/warning.tpl');
}
echo($c);
?>