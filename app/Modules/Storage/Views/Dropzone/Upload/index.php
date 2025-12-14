<?php

$Authentication = new App\Libraries\Authentication();
$request = service('request');
$dates = new App\Libraries\Dates();
$ma = model('App\Modules\Storage\Models\Storage_Attachments', true);

$option = $request->getVar("option");


if ($option == "lister") {
    $files = $ma->where("object", $id)->findAll();
    echo(json_encode($files));
} elseif ($option == "deleter") {
    $attachment = $request->getVar("attachment");
    $result = $ma->delete($attachment, true);
    echo(json_encode($result));
} else {
    $file = $request->getFile("attachment");
    //print_r($file);
    if ($file->isValid()) {
        $path = "/storages/images/dropzone/{$id}";
        $rname = $file->getRandomName();
        $file->move(ROOTPATH . "public" . $path, $rname);
        $name = $file->getClientName();
        $type = $file->getClientMimeType();
        $src = "{$path}/{$rname}";
    }
    /** Almacenar en la base de datos * */
    $oid = $id; // Objeto al cual se vinculara el archivo cargado
    $reference = $request->getVar("reference"); // Referencia del objeto o su función
    $d = array(
        "attachment" => pk(),
        "object" => $oid,
        "file" => $src,
        "type" => $type,
        "date" => $dates->get_Date(),
        "time" => $dates->get_Time(),
        "alt" => "",
        "title" => "",
        "size" => $file->getSize(),
        "reference" => $reference,
        "author" => $authentication->get_User(),
    );

    $create = $ma->insert($d);

    echo(json_encode($d));
}
?>