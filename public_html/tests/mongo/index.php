<?php
if (!extension_loaded('mongodb')) {
    echo "Advertencia: La extensión MongoDB no está instalada.";
} else {
    echo('Mongo instalado');
    $host = "127.0.0.1";
    $puerto = "27017";
    $usuario = rawurlencode("parzibyte");
    $pass = rawurlencode("hunter2");
    $nombreBD = "agenda";
    $cadenaConexion = sprintf("mongodb://%s:%s@%s:%s/%s", $usuario, $pass, $host, $puerto, $nombreBD);
    $cliente = new MongoDB\Client($cadenaConexion);
    $database = $cliente->selectDatabase($nombreBD);
}


?>