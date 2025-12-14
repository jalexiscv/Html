<?php
require_once(APPPATH . 'ThirdParty/Google/autoload.php');

use Google\Cloud\Storage\StorageClient;


//[Services]-----------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication =service('authentication');
//[services]------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Sie\Models\Sie_Directs");
//[Process]-----------------------------------------------------------------------------
$f = service("forms",array("lang" => "Sie_Directs."));
$d = array(
    "direct" => $f->get_Value("direct"),
    "title" => $f->get_Value("title"),
    "content" => $f->get_Value("content"),
    "href" => $f->get_Value("href"),
    "target" => $f->get_Value("target"),
    "author" => safe_get_user(),
);
//print_r($d);
//[Elements]-----------------------------------------------------------------------------
$row = $model->find($d["direct"]);
$l["back"]=$f->get_Value("back");
$l["edit"]="/sie/directs/edit/{$d["direct"]}";
$asuccess = "sie/directs-edit-success-message.mp3";
$anoexist = "sie/directs-edit-noexist-message.mp3";
//[build]---------------------------------------------------------------------------------------------------------------
if (is_array($row)) {
   $edit = $model->update($d['direct'],$d);
    include("file.php");
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Directs.edit-success-title"),
        "text-class" => "text-center",
        "text" => lang("Sie_Directs.edit-success-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
} else {
    $create = $model->insert($d);
    //echo($model->getLastQuery()->getQuery());
    include("file.php");
    $c = $bootstrap->get_Card("warning", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Directs.edit-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Sie_Directs.edit-noexist-message"),$d['direct']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $anoexist,
    ));
}
echo($c);
cache()->clean();
?>
