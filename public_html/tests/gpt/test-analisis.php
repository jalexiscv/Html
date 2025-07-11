<?php
// test-analisis.php

$analisisUrl = 'https://oftalmologia.xn--cm-fka.co/tests/gpt/analisis.php';
$fileUrl = 'https://storage.googleapis.com/cloud-engine/storages/5c3ed1386e6be5eb09956bc0731e647d/attachments/single/680A06C37F7D4/1745488992_5b0a8e34e732952d98e0.jpg';

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $analisisUrl . '?url=' . urlencode($fileUrl),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 60,
]);

$response = curl_exec($curl);
if (curl_errno($curl)) {
    echo 'Error en cURL: ' . curl_error($curl);
} else {
    echo "Respuesta de analisis.php:\n";
    echo $response;
}
curl_close($curl);
?>