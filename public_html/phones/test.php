<?php


$pythonVersionCommand = escapeshellcmd("python3 --version");
exec($pythonVersionCommand, $versionOutput, $versionReturnVar);

if ($versionReturnVar !== 0) {
    echo 'No se puede acceder al intérprete de Python.<br>';
} else {
    echo 'Versión de Python: ' . $versionOutput[0] . '<br>';
}


$command = escapeshellcmd("python3 test.py");
exec($command, $outputArray, $returnVar);

if ($returnVar !== 0) {
    echo 'Ocurrió un error al ejecutar el script de Python.<br>';
    echo 'Código de error: ' . $returnVar . '<br>';
    echo 'Salida del script de Python:<br>';

    echo("<pre>");
    print_r($outputArray);
    echo("</pre>");

    foreach ($outputArray as $line) {
        echo $line . "<br>";
    }
} else {
    foreach ($outputArray as $line) {
        echo $line . "<br>";
    }
}

?>
