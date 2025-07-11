<?php
require_once('../../../app/ThirdParty/Google/autoload.php');

use Google\Cloud\Storage\StorageClient;

echo("PRUEBA DE UPLOAD!");

$storage = new StorageClient(['keyFilePath' => '../../../app/ThirdParty/Google/keys.json']);
$bucket = $storage->bucket("cloud-engine");
$bucket->upload(fopen("test.jpg", 'r'), ['name' => "", 'predefinedAcl' => 'publicRead']);

?>