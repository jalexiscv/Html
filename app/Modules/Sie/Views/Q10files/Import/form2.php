<?php
require_once(APPPATH . 'ThirdParty/Google/autoload.php');

use Google\Cloud\Storage\StorageClient;

//[services]------------------------------------------------------------------------------------------------------------
$authentication = service('authentication');
$request = service('request');
$dates = service('dates');
$server = service('server');
//[request]-------------------------------------------------------------------------------------------------------------
$reference = $request->getVar("consecutive") ?? null;

if (is_null($reference)) {
    exit("El parámetro 'consecutive' es requerido.");
}

$mq10files = model('App\Modules\Sie\Models\Sie_Q10files');


$url = 'https://site2.q10.com/PDFReporte/GestionAcademica/HojaVidaEstudiante?tempId=c1901879-2a30-455d-8158-80875638447a&ins_consecutivoP=' . $reference;

$cookie = '_gcl_au=1.1.1518543921.1722978795; _ga_W6LWGV84B5=GS1.1.1727364776.3.0.1727364783.53.0.1390795588; _ga=GA1.1.2049809486.1722978795; twk_uuid_58cd5967ab48ef44ecdbe068=%7B%22uuid%22%3A%221.1Uisdeb2603j0Ufl6igYStXv9ECJ2PfZ2OLlDJDQ8GKlfIefP1HE0HabKPnyT0XZkrAyCCugEnTAUNwjE3TFf1dtD9HKuxf8diRcEOwgaed3zlD%22%2C%22version%22%3A3%2C%22domain%22%3A%22q10.com%22%2C%22ts%22%3A1727364779151%7D; .ASPXANONYMOUS=-XOeo8RsPGcgTFqYPBDW8eA7kcvE5sSj2UXy9nuf8qqX3twuryW4BzSemiig-WdwrpDU9qTeJkBc4jJCWzb3PKTS3vO9gd-1PfLdzp3uuP9lFnfEmK2_RVX5pJOEMOyzwhNE_A2; _ga_SEF3EVQ100=GS1.1.1728708272.53.1.1728708305.0.0.0; __gads=ID=90520f49638370b6:T=1724335683:RT=1727973288:S=ALNI_MYr4Kv5xV1I7EDUmh35n_XTTfzZUg; __gpi=UID=00000a4d8e4914be:T=1724335683:RT=1727973288:S=ALNI_MYv4kNOZjXdoXBMcy3VRfaNYdu8oA; __eoi=ID=6483f8eb89489c90:T=1724335683:RT=1727973288:S=AA-AfjZI1vxgrQ9RMtNUW_VVkoAe; XperiCode.CacheTempData.SessionId=e082fa1f-7274-4c23-a742-f3eee5af39d7; ARRAffinity=17960822990e452db31875a1c23c7ab085e8b620e299d2514fae807974036518; ARRAffinitySameSite=17960822990e452db31875a1c23c7ab085e8b620e299d2514fae807974036518; .AspNet.ApplicationCookie=aEegAuinpP409zcrplXATYDsqn7gD5Z9FSniljM-fMpLUj-yto0On91KNQB0oO6n7Wi6ILWX0tf8i7aW6qHWJY_WEQ8HkEfPWUFyq_KwU4l_OqUKTQnfsQYmf2jkStXtcEx0yNVQe-OYBqdfkgCbyxLzzu7iDGz_tMaMd6UFlExJeiC30FVwIx87hl0j4DNBq2_5Vz4Cml_2OJsh3GFdEHafqZwa45FzFFbQTED2InU4grAt8PjtteV1Y7WgG9gwe_iR07uWPMOii9TcOpfKpzQ4HCgf6H78QejA93wgNaX4eUPaXAsmd0KFxMS_wM8nS9YIYfvKGjKopfXfyd_ln4HBCyGLJA58-7pkIBjkXhMGhdxWimAcctgZMBut00H4KOPL0TC-gsiGdSafEmVTWDF6tXoU1Nrz-yfu9cIYjnuMVZclN3Cq7LTuI0tIIOYdZVW6Xtm0RVT2tgWV1HJ4wlhjVPVdN_z2M3a5q7rPopn2Slz5cnm5uLJ8cVB0DFJE1N07Zq5Y7SZ0UGqcEcT9j-oEGnO5NGnu60kE-KtN8IB7jfI4';

$directorio = PUBLICPATH . 'descargas/';

if (!is_dir($directorio)) {
    mkdir($directorio, 0755, true);
}

$nombreArchivo = md5($url) . '.pdf';
$rutaCompleta = $directorio . $nombreArchivo;

$headers = [
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:131.0) Gecko/20100101 Firefox/131.0',
        'Accept: */*',
        'Accept-Language: es-MX,es;q=0.8,en-US;q=0.5,en;q=0.3',
        'Accept-Encoding: gzip, deflate, br, zstd',
        'Referer: https://site2.q10.com/Scripts/pdfjs/web/viewer2.html?&amp;exportable=True&tempId=c1901879-2a30-455d-8158-80875638447a&reporte=true&file=%2fPDFReporte%2fGestionAcademica%2fHojaVidaEstudiante%3ftempId%3dc1901879-2a30-455d-8158-80875638447a%26ins_consecutivoP%3d26&urlDescarga=%2fReporte%2fImprimir&maximoRegistros=-1&async=False&r=10',
        'Connection: keep-alive',
        'Cookie: ' . $cookie,
        'Sec-Fetch-Dest: empty',
        'Sec-Fetch-Mode: cors',
        'Sec-Fetch-Site: same-origin',
        'TE: trailers'
];

$opciones = [
        'http' => [
                'method' => 'GET',
                'header' => implode("\r\n", $headers),
                'ignore_errors' => true,
                'timeout' => 30
        ],
        'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
        ],
];

$contexto = stream_context_create($opciones);

$contenido = file_get_contents($url, false, $contexto);

if ($contenido !== false) {
    $http_response_header = $http_response_header ?? [];
    $status_line = $http_response_header[0] ?? '';
    preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
    $status = $match[1] ?? '';

    if ($status == '200') {
        if (file_put_contents($rutaCompleta, $contenido)) {
            echo "Archivo descargado exitosamente a: " . $rutaCompleta;

            $mq10file = array(
                    "file" => pk(),
                    "attachment" => "UNDEFINED",
                    "identification" => "",
                    "reference" => $reference,
                    "type" => "INFORMATION",
                    "description" => "Información del estudiante",
                    "author" => safe_get_user(),
            );

            //[gcs]-----------------------------------------------------------------------------------------------------
            $path = "/storages/" . md5($server::get_FullName()) . "/q10/{$reference}";
            echo("<br>Path: " . $path);
            $rname = $mq10file['file'] . ".pdf";
            $localpath = $rutaCompleta;
            $src = "{$path}/{$rname}";
            //[google-storage]------------------------------------------------------------------------------------------
            $fulllocalpath = "{$localpath}";
            $spath = substr("{$path}/{$rname}", 1);
            $storage = new StorageClient(['keyFilePath' => APPPATH . 'ThirdParty/Google/keys.json']);
            $bucket = $storage->bucket("cloud-engine");
            $bucket->upload(fopen($fulllocalpath, 'r'), ['name' => $spath, 'predefinedAcl' => 'publicRead']);
            //[db]------------------------------------------------------------------------------------------------------
            $attachment = array(
                    "attachment" => strtoupper(uniqid()),
                    "module" => "SIE",
                    "object" => $mq10file['file'],
                    "file" => $src,
                    "type" => "application/pdf",
                    "date" => safe_get_date(),
                    "time" => safe_get_time(),
                    "alt" => $mq10file['description'],
                    "title" => "",
                    "size" => filesize($fulllocalpath),
                    "reference" => "Q10HISTORY",
                    "author" => safe_get_user(),
            );
            $ma = model('App\Modules\Storage\Models\Storage_Attachments', true);
            $createstorage = $ma->insert($attachment);
            $mq10file['attachment'] = $attachment['attachment'];
            $createq10file = $mq10files->insert($mq10file);

        } else {
            echo "Error al guardar el archivo.";
        }
    } else {
        echo "Error en la respuesta del servidor. Código de estado: " . $status;
    }
} else {
    echo "Error al descargar el archivo. Verifica la URL y los headers.";
}

// Imprimir headers de respuesta para diagnóstico
echo "\n\nHeaders de respuesta:\n";
print_r($http_response_header);

?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Obtener el valor actual del parámetro 'consecutive' en la URL
        const urlParams = new URLSearchParams(window.location.search);
        let consecutive = parseInt(urlParams.get('consecutive')) || 0;

        // Incrementar el valor de 'consecutive'
        consecutive++;

        // Construir la nueva URL con el parámetro 'consecutive' incrementado
        const newUrl = new URL(window.location.href);
        newUrl.searchParams.set('consecutive', consecutive);

        // Recargar la página con la nueva URL
        window.location.href = newUrl.toString();
    });
</script>
