<?php

namespace App\Modules\C4isr\Controllers;

use Higgs\Controller;
use App\Libraries\Server;

class Prolian extends Controller
{


    /**
     * Objetivo es solucionar el problema de la carga de contenido mixto.
     * @param $oid
     * @return void
     */
    public function stream()
    {
        $request = service('request');
        $query = $request->getVar('query');
        $next = $request->getVar('next');
        header("Content-Type: application/json; charset=UTF-8");
        $url = "http://186.84.174.105/stream.php?next={$next}&query={$query}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error en la solicitud CURL: ' . curl_error($ch);
        }
        curl_close($ch);
        if ($response) {
            echo($response);
        } else {
            echo 'No se recibió ninguna respuesta.';
        }
    }

}

?>