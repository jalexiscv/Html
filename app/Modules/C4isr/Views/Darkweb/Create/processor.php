<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-07-17 01:40:09
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\C4isr\Views\Darkweb\Creator\processor.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 * █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 * █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 * █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * █ @link https://www.codehiggs.com
 * █ @Version 1.5.0 @since PHP 7, PHP 8
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ Datos recibidos desde el controlador - @ModuleController
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
$server = service('server');
//[Models]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Darkweb."));
$model = model("App\Modules\C4isr\Models\C4isr_Darkweb");


$d = array(
    "file" => $f->get_Value("file"),
    "title" => $f->get_Value("title"),
    "description" => $f->get_Value("description"),
    "url" => $f->get_Value("url"),
    "size" => $f->get_Value("size"),
    "type" => $f->get_Value("type"),
    "date" => $f->get_Value("date"),
    "time" => $f->get_Value("time"),
    "author" => safe_get_user(),
);
$row = $model->find($d["file"]);
$l["back"] = "/c4isr/darkweb/list/" . lpk();
$l["edit"] = "/c4isr/darkweb/edit/{$d["file"]}";
$asuccess = "c4isr/darkweb-create-success-message.mp3";
$aexist = "c4isr/darkweb-create-exist-message.mp3";
if (is_array($row)) {
    $c = $bootstrap->get_Card("duplicate", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Darkweb.create-duplicate-title"),
        "text-class" => "text-center",
        "text" => lang("Darkweb.create-duplicate-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $aexist,
    ));
} else {
    $path = '/storages/' . md5($server->get_FullName()) . 'c4isr/files';
    $file = $request->getFile($f->get_fieldId('url'));
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
            "object" => $d['file'],
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
        $mattachments = model("App\Modules\Storage\Models\Storage_Attachments");
        $create = $mattachments->insert($a);


        //echo($model->getLastQuery()->getQuery());
        //------------------------------------------------------------------------------------------------------------------
        $remote_dir = $d['date']; // Directorio destino predeterminado
        $remote_name = md5(lpk()) . ".onion";
        $archivoParaTransferir = $dir . "/" . $rname;
        $url = 'https://network.c4isr.co/chunks.php';
        $tamanoMaximoChunk = 1048576; // 1 MB
        $archivo = fopen($archivoParaTransferir, 'rb');
        $tamanoTotal = filesize($archivoParaTransferir);
        $numChunks = ceil($tamanoTotal / $tamanoMaximoChunk);
        for ($i = 0; $i < $numChunks; $i++) {
            $chunk = fread($archivo, $tamanoMaximoChunk);
            $chunkData = [
                'chunk' => base64_encode($chunk), // Codificar en base64 para enviar como contenido binario
                'chunkIndex' => $i + 1,
                'esUltimoChunk' => ($i === $numChunks - 1) ? 'true' : 'false', // Indicar si es el último chunk
            ];
            $postData = http_build_query($chunkData) . '&remote_dir=' . urlencode($remote_dir) . '&remote_name=' . urlencode($remote_name);
            $opcionesContexto = [
                'http' => [
                    'method' => 'POST',
                    'header' => 'Content-Type: application/x-www-form-urlencoded',
                    'content' => $postData,
                ]
            ];

            $contexto = stream_context_create($opcionesContexto);
            $response = file_get_contents($url, false, $contexto);
            //echo($response);
        }
        fclose($archivo);
        //------------------------------------------------------------------------------------------------------------------
        $d['url'] = 'https://network.c4isr.co/tor/' . $remote_dir . '/' . $remote_name;
        $d['size'] = $size;
        $d['type'] = $type;
        $create = $model->insert($d);
    }
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Darkweb.create-success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Darkweb.create-success-message"), $d['file']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
}
echo($c);
?>
