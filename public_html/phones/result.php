<?php

if (isset($_REQUEST['keyword'])) {
    $keyword = $_REQUEST['keyword'];
    $command = escapeshellcmd("python3 search.py \"{$keyword}\" ");
    exec($command, $outputArray, $returnVar);

    $response = array();
    if ($returnVar !== 0) {

    } else {
        foreach ($outputArray as $line) {
            $vline = explode(",", $line);
            array_push($response, $vline);
        }
        echo(json_encode($response));
    }
} else {
    echo(json_encode(['error' => 'No se especificó una palabra clave']));
}
?>