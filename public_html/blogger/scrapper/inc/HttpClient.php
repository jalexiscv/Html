<?php

/**
 * HttpClient.php
 * Cliente HTTP minimalista basado en cURL sin dependencias externas.
 *
 * Responsabilidades:
 * - Realiza peticiones GET con User-Agent, Referer, timeouts y soporte opcional de redirecciones.
 * - Devuelve cuerpo, código de estado, URL final efectiva y errores normalizados.
 */
class HttpClient
{
    /** @var string */
    private $ua;
    /** @var string */
    private $referer;
    /** @var int */
    private $timeout;
    /** @var int */
    private $connectTimeout;

    /**
     * @param string $userAgent User-Agent a enviar en las peticiones
     * @param string $referer Referer por defecto
     * @param int $timeout Tiempo máximo total (segundos)
     * @param int $connectTimeout Tiempo máximo de conexión (segundos)
     */
    public function __construct($userAgent, $referer, $timeout = 25, $connectTimeout = 10)
    {
        $this->ua = (string)$userAgent;
        $this->referer = (string)$referer;
        $this->timeout = (int)$timeout;
        $this->connectTimeout = (int)$connectTimeout;
    }

    /**
     * Realiza una petición GET.
     *
     * @param string $url URL absoluta a descargar
     * @param array $opts Opciones: ['follow_redirects' => bool, 'max_redirects' => int]
     * @return array{error:bool,error_message:string,status:int,headers:string,body:string,final_url:string}
     */
    public function get($url, array $opts = [])
    {
        $url = (string)$url;
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return [
                'error' => true,
                'error_message' => 'URL inválida',
                'status' => 0,
                'headers' => '',
                'body' => '',
                'final_url' => $url,
            ];
        }

        $follow = !empty($opts['follow_redirects']);
        $maxr = isset($opts['max_redirects']) ? (int)$opts['max_redirects'] : 5;

        $ch = curl_init();
        $headers = [];
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_USERAGENT => $this->ua,
            CURLOPT_REFERER => $this->referer,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_CONNECTTIMEOUT => $this->connectTimeout,
            CURLOPT_FOLLOWLOCATION => $follow,
            CURLOPT_MAXREDIRS => $maxr,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
        ]);

        $raw = curl_exec($ch);
        if ($raw === false) {
            $err = curl_error($ch);
            $info = curl_getinfo($ch);
            $final = isset($info['url']) ? $info['url'] : $url;
            curl_close($ch);
            return [
                'error' => true,
                'error_message' => $err ?: 'cURL error',
                'status' => isset($info['http_code']) ? (int)$info['http_code'] : 0,
                'headers' => '',
                'body' => '',
                'final_url' => (string)$final,
            ];
        }

        $info = curl_getinfo($ch);
        $status = (int)$info['http_code'];
        $headerSize = (int)$info['header_size'];
        $rawHeaders = substr($raw, 0, $headerSize);
        $body = substr($raw, $headerSize);
        $final = isset($info['url']) ? $info['url'] : $url;
        curl_close($ch);

        return [
            'error' => false,
            'error_message' => '',
            'status' => $status,
            'headers' => (string)$rawHeaders,
            'body' => (string)$body,
            'final_url' => (string)$final,
        ];
    }

    /**
     * Envía una petición POST con cuerpo JSON y encabezados personalizados.
     * No usa librerías de terceros.
     *
     * @param string $url URL absoluta del endpoint
     * @param array $data Arreglo PHP que se serializa a JSON
     * @param array $headers Mapa de encabezados extra ['Nombre' => 'Valor']
     * @return array{error:bool,error_message:string,status:int,headers:string,body:string,final_url:string,json:mixed|null}
     */
    public function postJson($url, array $data, array $headers = [])
    {
        $url = (string)$url;
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return [
                'error' => true,
                'error_message' => 'URL inválida',
                'status' => 0,
                'headers' => '',
                'body' => '',
                'final_url' => $url,
                'json' => null,
            ];
        }

        $payload = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        if ($payload === false) {
            return [
                'error' => true,
                'error_message' => 'No se pudo codificar JSON',
                'status' => 0,
                'headers' => '',
                'body' => '',
                'final_url' => $url,
                'json' => null,
            ];
        }

        $hdrs = [
            'Content-Type: application/json',
            'Accept: application/json',
            'User-Agent: ' . $this->ua,
            'Referer: ' . $this->referer,
        ];
        foreach ($headers as $k => $v) {
            if (!is_string($k) || $k === '') continue;
            $hdrs[] = trim($k) . ': ' . (string)$v;
        }

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_CONNECTTIMEOUT => $this->connectTimeout,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => $hdrs,
            CURLOPT_POSTFIELDS => $payload,
        ]);

        $raw = curl_exec($ch);
        if ($raw === false) {
            $err = curl_error($ch);
            $info = curl_getinfo($ch);
            $final = isset($info['url']) ? $info['url'] : $url;
            curl_close($ch);
            return [
                'error' => true,
                'error_message' => $err ?: 'cURL error',
                'status' => isset($info['http_code']) ? (int)$info['http_code'] : 0,
                'headers' => '',
                'body' => '',
                'final_url' => (string)$final,
                'json' => null,
            ];
        }

        $info = curl_getinfo($ch);
        $status = (int)$info['http_code'];
        $headerSize = (int)$info['header_size'];
        $rawHeaders = substr($raw, 0, $headerSize);
        $body = substr($raw, $headerSize);
        $final = isset($info['url']) ? $info['url'] : $url;
        curl_close($ch);

        $json = null;
        if ($body !== '') {
            $dec = json_decode($body, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $json = $dec;
            }
        }

        return [
            'error' => false,
            'error_message' => '',
            'status' => $status,
            'headers' => (string)$rawHeaders,
            'body' => (string)$body,
            'final_url' => (string)$final,
            'json' => $json,
        ];
    }

    /**
     * Envía una petición POST con cuerpo application/x-www-form-urlencoded.
     *
     * @param string $url URL absoluta del endpoint
     * @param array $data Arreglo asociativo de datos a enviar
     * @return array{error:bool,error_message:string,status:int,headers:string,body:string,final_url:string}
     */
    public function post($url, array $data = [])
    {
        $url = (string)$url;
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return [
                'error' => true, 'error_message' => 'URL inválida', 'status' => 0,
                'headers' => '', 'body' => '', 'final_url' => $url,
            ];
        }

        $payload = http_build_query($data);

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_CONNECTTIMEOUT => $this->connectTimeout,
            CURLOPT_USERAGENT => $this->ua,
            CURLOPT_REFERER => $this->referer,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload,
        ]);

        $raw = curl_exec($ch);
        if ($raw === false) {
            $err = curl_error($ch);
            $info = curl_getinfo($ch);
            $final = $info['url'] ?? $url;
            curl_close($ch);
            return [
                'error' => true, 'error_message' => $err ?: 'cURL error',
                'status' => (int)($info['http_code'] ?? 0), 'headers' => '',
                'body' => '', 'final_url' => (string)$final,
            ];
        }

        $info = curl_getinfo($ch);
        $status = (int)$info['http_code'];
        $headerSize = (int)$info['header_size'];
        $rawHeaders = substr($raw, 0, $headerSize);
        $body = substr($raw, $headerSize);
        $final = $info['url'] ?? $url;
        curl_close($ch);

        return [
            'error' => false, 'error_message' => '', 'status' => $status,
            'headers' => (string)$rawHeaders, 'body' => (string)$body,
            'final_url' => (string)$final,
        ];
    }
}
