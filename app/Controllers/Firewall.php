<?php

namespace App\Controllers;


use App\Libraries\Browser;

/**
 *
 */
class Firewall extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * @return bool
     */
    public function intercept(): bool
    {
        // Excepción para API de telemetría - permitir tráfico sin evaluaciones
        $request_uri = $_SERVER['REQUEST_URI'] ?? '';
        if (strpos($request_uri, '/sogt/api/telemetry/json/') !== false) {
            return false; // Permitir acceso sin restricciones
        }

        $ip = ($_SERVER['REMOTE_ADDR'] == "::1") ? "127.0.0.1" : addslashes(htmlentities($_SERVER['REMOTE_ADDR']));
        // Lo primero que debeo de hacer es verificar si la IP pertenece a la lista de IPs permitidas
        $mwhitelist = model('App\Modules\Firewall\Models\Firewall_Whitelist');
        $wlip = $mwhitelist->where('ip', $ip)->first();
        if (is_array($wlip)) {
            if (!empty($wlip['ip'])) {
                //echo("IP permitida");
                return (false);
            }
        }
        //Busco en la lista de IPS bloqueadas si la IP actual está bloqueada y si lo está, redirijo a la página de bloqueo
        //y si lo esta finalizo sin realizar la carga de la aplicación
        $mbans = model('App\Modules\Firewall\Models\Firewall_Bans');
        // Primero verificamos coincidencias exactas
        $ban = $mbans->where('ip', $ip)->first();
        if (is_array($ban) && !empty($ban['ban'])) {
            return(true);
        }

        //Analizando navegador y otros datos
        $useragent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        $browser = new Browser($useragent);
        $request_uri = str_replace("'", '', $_SERVER['REQUEST_URI']);
        $referer = isset($_SERVER['HTTP_REFERER"']) ? $_SERVER['HTTP_REFERER"'] : '';
        $domain = trim($_SERVER['SERVER_NAME'], "www.");
        $bot = preg_match('/bot|crawl|slurp|rambler|lycos|facebookexternalhit|mediapartners|google|yahoo|yandex|bing|microsoft|facebook|robot|baidu|curl|spider/i', strtolower($useragent)) ? 1 : 0;
        $mlivetraffic = model('App\Modules\Firewall\Models\Firewall_Livetraffic');
        $mlivetraffic->insert(array(
            "traffic" => uniqid(),
            "ip" => $ip,
            "useragent" => $useragent,
            "browser" => $browser->get_Name(),
            "browser_code" => $browser->get_Code(),
            //"os" => $f->get_Value("os"),
            //"os_code" => $f->get_Value("os_code"),
            //"device_type" => $f->get_Value("device_type"),
            //"country" => $f->get_Value("country"),
            //"country_code" => $f->get_Value("country_code"),
            "request_uri" => $request_uri,
            "domain" => $domain,
            "referer" => $referer,
            "bot" => $bot,
            "date" => date('Y-m-d', time()),
            "time" => date('H:i:s', time()),
            //"uniquev" => $f->get_Value("uniquev"),
        ));
        //Analizando si el navegador es un bot malicioso
        $mbadbots = model('App\Modules\Firewall\Models\Firewall_Badbots');
        $badbots = $mbadbots->findall();
        if (is_array($badbots)) {
            foreach ($badbots as $bot) {
                $reference = strtolower($bot['reference']);
                if (!empty($reference)) {
                    // Escapamos los caracteres especiales en $reference para usarlo en la expresión regular
                    $escapedReference = preg_quote($reference, '/');
                    if (preg_match("/$escapedReference/i", strtolower($useragent))) {
                        $mbans = model('App\Modules\Firewall\Models\Firewall_Bans');
                        $mbans->insert(array(
                            "ban" => uniqid(),
                            "ip" => $ip,
                            "date" => date('Y-m-d', time()),
                            "time" => date('H:i:s', time()),
                            "reason" => $escapedReference,
                            "redirect" => "",
                            "url" => "",
                            "autoban" => "Y",
                        ));
                        //echo($escapedReference);
                        //echo("<br>");
                        //echo($useragent);
                        return (true);
                    }
                }
            }
        }
        //Analisis de filtros
        $mfilters = model('App\Modules\Firewall\Models\Firewall_Filters');
        $filters = $mfilters->findall();
        if (is_array($filters)) {
            foreach ($filters as $filter) {
                $expression = strtolower($filter['expression']);
                //echo($expression);
                if (!empty($expression)) {
                    $escaped = preg_quote($expression, '/');
                    $uri = strtolower(urldecode($request_uri));
                    //echo($expression . "  -------------  " . $uri);
                    if (preg_match("/$escaped/i", $uri)) {
                        //echo("match");
                        $mbans = model('App\Modules\Firewall\Models\Firewall_Bans');
                        $mbans->insert(array(
                            "ban" => uniqid(),
                            "ip" => $ip,
                            "date" => date('Y-m-d', time()),
                            "time" => date('H:i:s', time()),
                            "reason" => $filter['name'],
                            "redirect" => "",
                            "url" => "",
                            "autoban" => "Y",
                        ));
                        return (true);
                    }
                }
            }
        }
        return (false);
    }
}

?>