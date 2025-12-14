<?php
$bootstrap = service("bootstrap");
//Este procesador se utiliza cuando no se recibe un archivo, actualiza solamente datos.
//[vars]----------------------------------------------------------------------------------------------------------
$continue = "/library/resources/list/{$resource["title"]}/";
$edit = "/library/resources/edit/{$resource["resource"]}/";
$asuccess = "library/resources-edit-success-message.mp3";
unset($resource['type']);
unset($resource['file']);
//[Update]--------------------------------------------------------------------------------------------------------------
$edit = $model->update($resource['resource'], $resource);

//[Build]---------------------------------------------------------------------------------------------------------------
$c = $bootstrap->get_Card("success", array(
    "class" => "card-success",
    "icon" => "fa-duotone fa-triangle-exclamation",
    "title" => lang("Resources.edit-success-title"),
    "text-class" => "text-center",
    "text" => lang("Resources.edit-success-message"),
    "footer-continue" => $continue,
    "footer-class" => "text-center",
    "voice" => $asuccess,
));
echo($c);
?>