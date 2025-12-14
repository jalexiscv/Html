<?php
header("Content-Type: application/json; charset=UTF-8");
$data = array(
    "view" => $view,
    "id" => isset($id) ? $id : false
);
switch ($view) {
    case "storage-images-single":
        $c = view("App\Modules\Storage\Views\Uploads\single", $data);
        break;
    case "storage-images-croppie":
        $c = view("App\Modules\Storage\Views\Croppie\Upload\index", $data);
        break;
    case "storage-images-dropzone":
        $c = view("App\Modules\Storage\Views\Dropzone\Upload\index", $data);
        break;
    //case "storage-processes-list": $c=view("App\Modules\Disa\Views\Settings\Processes\List\ajax", $data);break;
    default:
        $c = view("App\Modules\Security\Views\E404\ajax", $data);
        break;
}
echo($c);
?>