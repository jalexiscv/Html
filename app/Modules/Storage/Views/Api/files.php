<?php
$bootstrap = service('bootstrap');
$mattachments = model('App\Modules\Storage\Models\Storage_Attachments');
//[grid]----------------------------------------------------------------------------------------------------------------
$bgrid = $bootstrap->get_Grid();
$bgrid->set_Class("P-0 m-0");
$bgrid->set_Headers(array(
    array("content" => "#", "class" => "text-center text-nowrap align-middle"),
    array("content" => "Tipo", "class" => "text-center align-middle"),
    array("content" => "Archivo", "class" => "text-center align-middle"),
    array("content" => "Opciones", "class" => "text-center text-nowrap align-middle"),
));
$count = 0;
$files = $mattachments->where('object', $oid)->orderBy("created_at", "DESC")->findAll();

$efiles = array_map(function ($file) {
    $file['file'] = cdn_url($file['file']);
    return $file;
}, $files);
$count = count($efiles);

$data = array(
    "files" => $efiles,
    "count"=>$count,
);
echo(json_encode($data));
?>