<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-04-10 06:52:21
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Iris\Views\Studies\Editor\form.php]
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
 * █ @link https://www.higgs.com.co
 * █ @Version 1.5.1 @since PHP 8,PHP 9
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');

$fileUrl = $request->getVar("file");
$attachment = $request->getVar("attachment");


/** @var TYPE_NAME $oid */
$back = "/iris/studies/view/{$oid}";

//$code = "<b>Archivo recibido</b>: {$fileUrl}<br>";

$code="<div class=\"alert alert-info\">
            <strong>Nota Aclaratoria:</strong><br>
            La información a continuación transcrita son apartes tomados en fiel copia de la historia clínica del paciente para fines netamente administrativos. Para la toma de decisiones clínicas por favor remitirse al texto completo de la historia clínica, de conformidad con lo establecido en la legislación colombiana vigente.
        </div>";


$analisisUrl = 'https://iris.edux.com.co/tests/gpt/analisis-oftalmologico.php';

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $analisisUrl . '?url=' . urlencode($fileUrl),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 60,
]);

$response = curl_exec($curl);


if (curl_errno($curl)) {
    $ria = 'Error en cURL: ' . curl_error($curl);
} else {
    $ria = $response;
}
curl_close($curl);

$json = json_decode($ria, true);

//print_r($json["result"]);

$code .= "<analysis>";

if (isset($json["result"]["response"])) {
    $markdown = new App\Libraries\Markdown();
    $code .= "<img src='{$fileUrl}' class='img-fluid' alt='Imagen de análisis' />";
    $code .= $markdown->parse($json["result"]["response"][0]["text"]);
} else {
    $code .= "<b>Analizando</b>: Por favor espere... <br>";
    $code .= "<script>setTimeout(function() { window.location.reload(); }, 3000);</script>";
}

$code .= "</analysis>";

$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card2("card-view-service", array(
    "header-title" => "Analizando archivo",
    "header-back" => $back,
    "content" => $code,
));
echo($card);

//[almacenamiento]--------------------------------------------------------------
$mdiagnostics = model('App\Modules\Iris\Models\Iris_Diagnostics');
$d = array(
    "diagnostic" => pk(),
    "study" => $oid,
    "attachment" => $attachment,
    "result_ia" => $code,
    "result" => "",
    "created_by" => safe_get_user(),
    "updated_by" => safe_get_user(),
);
$create = $mdiagnostics->insert($d);
cache()->clean();
?>
