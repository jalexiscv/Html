<?php

namespace App\Modules\C4isr\Controllers;

use App\Controllers\ModuleController;

class Shodan extends ModuleController
{

    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'c4isr-cases';
        $this->module = 'App\Modules\C4isr';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\C4isr');
    }

    public function index()
    {
        $url = base_url('c4isr/cases/home/' . lpk());
        return (redirect()->to($url));
    }


    public function home(string $type, string $rnd)
    {
        $this->oid = $type;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Cases\Home';
        return (view($this->viewer, $this->get_Array()));
    }

    public function query(string $query)
    {
        header('Content-type: application/json');
        $API_KEY = SHODAN_API_KEY;
        $API_URL = SHODAN_API_URL;
        //echo("QUERY: {$query}");
        $url = "{$API_URL}?key={$API_KEY}&query={$query}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);  // La URL a la que quieres hacer la solicitud
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // Devuelve la respuesta como un string en lugar de imprimirla
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  // Sigue las redirecciones si las hay
        $response = curl_exec($ch);
        curl_close($ch);
        //print_r($response);

        // Decodificar los datos de la respuesta en formato JSON
        $data = json_decode($response, true);

// Variables para almacenar los datos
        $seen_ips = array();
        $json_data = array();

// Iterar a través de cada resultado
        foreach ($data["matches"] as $result) {
            $ip_str = $result["ip_str"];

            // Verificar si se ha visto la dirección IP antes
            if (in_array($ip_str, $seen_ips)) {
                continue;
            }

            // Almacenar la dirección IP si no se ha visto antes
            array_push($seen_ips, $ip_str);

            // Inicializar la lista de vulnerabilidades
            $vulnerabilities = array();

            // Verificar si hay vulnerabilidades en los resultados
            if (isset($result["vulns"])) {
                // Iterar a través de cada vulnerabilidad
                foreach ($result["vulns"] as $vuln_key => $vuln) {
                    // Añadir la vulnerabilidad a la lista de vulnerabilidades
                    array_push($vulnerabilities, array(
                        "vuln" => $vuln_key,
                        "cvss" => $vuln["cvss"]
                    ));
                }
            }

            // Añadir los datos al array de datos JSON
            array_push($json_data, array(
                "ip_address" => $ip_str,
                "hostname" => isset($result["hostnames"][0]) ? $result["hostnames"][0] : "N/A",
                "organization" => isset($result["org"]) ? $result["org"] : "N/A",
                "vulnerabilities" => $vulnerabilities ? $vulnerabilities : "No se identificaron vulnerabilidades públicas",
                "isp" => isset($result["isp"]) ? $result["isp"] : "N/A",
                "city" => isset($result["location"]["city"]) ? $result["location"]["city"] : "N/A",
                "domains" => $result["domains"] ? $result["domains"] : "No se encontraron dominios asociados"
            ));
        }

// Convertir los datos a JSON y mostrarlos
        echo json_encode($json_data);
    }


}

?>