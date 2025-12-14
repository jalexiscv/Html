<?php
require_once(APPPATH . 'ThirdParty/Google/autoload.php');

use Google\Cloud\Storage\StorageClient;

// [services]
$authentication = service('authentication');
$request = service('request');
$dates = service('dates');
$server = service('server');

// [request]
$reference = $request->getVar("consecutive") ?? null;

if (is_null($reference)) {
    exit("El parámetro 'consecutive' es requerido.");
}

$mq10files = model('App\Modules\Sie\Models\Sie_Q10files');

$url = 'https://site2.q10.com/PDFReporte/GestionAcademica/HojaVidaEstudiante?tempId=c1901879-2a30-455d-8158-80875638447a&ins_consecutivoP=' . $reference;

$cookie = '_gcl_au=1.1.1518543921.1722978795; _ga_W6LWGV84B5=GS1.1.1727364776.3.0.1727364783.53.0.1390795588; _ga=GA1.1.2049809486.1722978795; twk_uuid_58cd5967ab48ef44ecdbe068=%7B%22uuid%22%3A%221.1Uisdeb2603j0Ufl6igYStXv9ECJ2PfZ2OLlDJDQ8GKlfIefP1HE0HabKPnyT0XZkrAyCCugEnTAUNwjE3TFf1dtD9HKuxf8diRcEOwgaed3zlD%22%2C%22version%22%3A3%2C%22domain%22%3A%22q10.com%22%2C%22ts%22%3A1727364779151%7D; .ASPXANONYMOUS=-XOeo8RsPGcgTFqYPBDW8eA7kcvE5sSj2UXy9nuf8qqX3twuryW4BzSemiig-WdwrpDU9qTeJkBc4jJCWzb3PKTS3vO9gd-1PfLdzp3uuP9lFnfEmK2_RVX5pJOEMOyzwhNE_A2; _ga_SEF3EVQ100=GS1.1.1728781809.59.1.1728781831.0.0.0; __gads=ID=90520f49638370b6:T=1724335683:RT=1727973288:S=ALNI_MYr4Kv5xV1I7EDUmh35n_XTTfzZUg; __gpi=UID=00000a4d8e4914be:T=1724335683:RT=1727973288:S=ALNI_MYv4kNOZjXdoXBMcy3VRfaNYdu8oA; __eoi=ID=6483f8eb89489c90:T=1724335683:RT=1727973288:S=AA-AfjZI1vxgrQ9RMtNUW_VVkoAe; XperiCode.CacheTempData.SessionId=e082fa1f-7274-4c23-a742-f3eee5af39d7; ARRAffinity=17960822990e452db31875a1c23c7ab085e8b620e299d2514fae807974036518; ARRAffinitySameSite=17960822990e452db31875a1c23c7ab085e8b620e299d2514fae807974036518; .AspNet.ApplicationCookie=lS98T5Ex-5GWoV5O0A8sEbHuq5a0E4_OKvXOc77kmMI6h-NV3btuH0dnZtfsSfke7HnUKZE0Xv7UG5RLHEO3VncyCrJOwdEsqeje4LqEJ4yzdj80Kt9u4e19OfcSWBCY41f7Ql2UyhpjnHSC0tPmGKP2K1VCiwky7xZvriqNeOIOvOin5YBAmj3xbrYLYxAeOTVhZNH33uc96ovOkk6xmbL6_L8QdF5B959S_NKldhBrMLiadtlUW0aLvq38SQeMXReT5Js55g63WWBx-qlkm30HJuxjEEaBVT79cgzvueMgqfy0jXmPeOgpwzzBlK8-c7kmRbzhmxmrRB_HfLNZRwM9FwD8iSyPWYqNA1BbvkHya_MqvSkqIKp1JeJRDLRq2JWj7ldzT1nzSS9Z5Ft2ohd8Mplyav9kQ7ay3UJ-oKf3hqH2cdSiJCRHy2sQH33GwhI3weJxEsSusaTgoWFdRgdm6bYyIfjV0WrbbryD4nRlR7v0NaluOR4NRWk6KQFyDNKEZrYy2kDI5W-sYskzl1uapYlbZkjRmIq-Trw7jhDg9SVpVOfX9Vwr7oQdEqXV8AhTsyJsz-gGxxlABrTyQtjyRmg';

$directorio = PUBLICPATH . 'descargas/';

if (!is_dir($directorio)) {
    mkdir($directorio, 0755, true);
}

$nombreArchivo = md5($url) . '.pdf';
$rutaCompleta = $directorio . $nombreArchivo;

// Inicializar cURL
$ch = curl_init($url);

// Configurar opciones de cURL
curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTPHEADER => [
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:131.0) Gecko/20100101 Firefox/131.0',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
                'Accept-Language: es-MX,es;q=0.8,en-US;q=0.5,en;q=0.3',
                'Accept-Encoding: gzip, deflate, br',
                'Connection: keep-alive',
                'Upgrade-Insecure-Requests: 1',
                'Sec-Fetch-Dest: document',
                'Sec-Fetch-Mode: navigate',
                'Sec-Fetch-Site: none',
                'Sec-Fetch-User: ?1',
        ],
        CURLOPT_COOKIE => $cookie,
        CURLOPT_VERBOSE => true,
        CURLOPT_HEADER => true,
]);

echo "<b>Aurora(AI)</b>: Lo logre me conecte!<br>\n";
echo "<b>Sofia(AI)</b>: Lo volvi archivo!<br>\n";
echo "<b>Camila(AI)</b>: Lo registre y almacene en el SIE!<br>\n";
echo "<hr>\n";

// Capturar la salida detallada
$verbose = fopen('php://temp', 'w+');
curl_setopt($ch, CURLOPT_STDERR, $verbose);

// Ejecutar la solicitud cURL
$response = curl_exec($ch);
$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$header = substr($response, 0, $header_size);
$body = substr($response, $header_size);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Imprimir información de depuración
echo "<b>URL</b>: " . $url . "<br>\n";
echo "<b>Status</b>: " . $status . "<br>\n";
echo "<b>Headers enviados</b>:<br>\n";
//print_r(curl_getinfo($ch, CURLINFO_HEADER_OUT));
echo "<b>Headers recibidos</b>:\n" . $header . "<br>\n";

if ($status != 200) {
    echo "<b>Error en la respuesta del servidor. Código de estado</b>: " . $status . "<br>\n";
    echo "<b>Cuerpo de la respuesta</b>:\n" . $body . "<br>\n";
    rewind($verbose);
    $verboseLog = stream_get_contents($verbose);
    echo "<b>Verbose information</b>:\n", htmlspecialchars($verboseLog), "<br>\n";
} else {
    if (file_put_contents($rutaCompleta, $body)) {
        echo "<b>Archivo descargado exitosamente a</b>: " . $rutaCompleta . "<br>\n";
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
        echo "<b>Error al guardar el archivo.</b><br>\n";
    }
}

// Cerrar la sesión cURL
curl_close($ch);
fclose($verbose);
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