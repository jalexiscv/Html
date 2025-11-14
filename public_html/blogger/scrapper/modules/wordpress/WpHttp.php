<?php

/**
 * WpHttp
 * Cliente HTTP mínimo basado en cURL para interactuar con la REST API de WordPress.
 * - Autenticación via Application Passwords (Basic Auth) -> usuario:app_password
 * - Soporta GET/POST/PUT/DELETE, JSON y multipart para subida de media.
 * - Sin librerías de terceros.
 */
class WpHttp
{
    /** @var string Base URL del sitio WordPress, p.ej. https://ejemplo.com */
    private $baseUrl;
    /** @var string Cabecera Authorization: Basic ... */
    private $authHeader;
    /** @var bool Verificar certificado SSL (true en prod) */
    private $verifySsl;
    /** @var string usuario (login) para Basic Auth */
    private $username;
    /** @var string contraseña de aplicación para Basic Auth */
    private $applicationPassword;

    /**
     * @param string $baseUrl URL base del WP (sin barra final), ej: https://ejemplo.com
     * @param string $username Usuario de WP con permisos para publicar
     * @param string $applicationPassword Password de Aplicación generado en el perfil del usuario
     * @param bool $verifySsl Verificar SSL
     */
    public function __construct($baseUrl, $username, $applicationPassword, $verifySsl = true)
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->username = (string)$username;
        $this->applicationPassword = (string)$applicationPassword;
        $token = base64_encode($username . ':' . $applicationPassword);
        $this->authHeader = 'Authorization: Basic ' . $token;
        $this->verifySsl = (bool)$verifySsl;
    }

    /**
     * Realiza una petición JSON con cURL.
     * @param string $method GET|POST|PUT|DELETE
     * @param string $path relativo a wp/v2
     * @param array|null $data Datos a enviar como JSON
     * @param array $headers Cabeceras adicionales
     * @return array [status, headers, body, json, error]
     */
    public function requestJson($method, $path, $data = null, array $headers = [])
    {
        $url = $this->api($path);
        $ch = curl_init();
        // Cabeceras: siempre Accept JSON; Content-Type solo si enviamos cuerpo JSON
        $hBase = ['Accept: application/json', $this->authHeader];
        if ($data !== null) {
            $hBase[] = 'Content-Type: application/json; charset=utf-8';
        }
        $h = array_merge($hBase, $headers);

        $opts = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_CUSTOMREQUEST => strtoupper($method),
            CURLOPT_HTTPHEADER => $h,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 5,
            CURLOPT_SSL_VERIFYPEER => $this->verifySsl,
            CURLOPT_SSL_VERIFYHOST => $this->verifySsl ? 2 : 0,
            // Autenticación básica nativa de cURL (además de la cabecera), mejora compatibilidad en algunos hosts
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_USERPWD => $this->username . ':' . $this->applicationPassword,
        ];
        if ($data !== null) {
            $opts[CURLOPT_POSTFIELDS] = json_encode($data);
        }
        curl_setopt_array($ch, $opts);
        $raw = curl_exec($ch);
        $curlErr = ($raw === false) ? curl_error($ch) : '';
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        curl_close($ch);

        $respHeaders = [];
        $respBody = '';
        if ($raw !== false) {
            $respHeadersStr = substr($raw, 0, $headerSize);
            $respBody = substr($raw, $headerSize);
            $respHeaders = $this->parseHeaders($respHeadersStr);
        }
        $json = null;
        if ($respBody !== '') {
            $j = json_decode($respBody, true);
            if (json_last_error() === JSON_ERROR_NONE) $json = $j;
        }
        return [
            'status' => $status,
            'headers' => $respHeaders,
            'body' => $respBody,
            'json' => $json,
            'error' => $curlErr,
        ];
    }

    /**
     * Construye una URL absoluta hacia la REST API v2.
     * @param string $path Camino relativo, ej: '/posts' o 'posts?per_page=1'
     * @return string
     */
    private function api($path)
    {
        $path = ltrim($path, '/');
        return $this->baseUrl . '/wp-json/wp/v2/' . $path;
    }

    /**
     * Parsea cabeceras HTTP en formato texto.
     * @param string $rawHeaders
     * @return array
     */
    private function parseHeaders($rawHeaders)
    {
        $headers = [];
        foreach (preg_split('/\r\n|\n|\r/', $rawHeaders) as $line) {
            $p = strpos($line, ':');
            if ($p !== false) {
                $k = trim(substr($line, 0, $p));
                $v = trim(substr($line, $p + 1));
                if ($k !== '') $headers[$k] = $v;
            }
        }
        return $headers;
    }

    /**
     * Sube un archivo binario como media (imagen), usando multipart/form-data.
     * @param string $filename nombre de archivo destino en WP
     * @param string $binary contenido binario
     * @param string $mimeType mime ej: image/jpeg
     * @param array $fields campos extra (title, alt_text, caption, description)
     * @return array respuesta como en requestJson
     */
    public function uploadMedia($filename, $binary, $mimeType = 'application/octet-stream', array $fields = [])
    {
        $url = $this->api('media');
        $ch = curl_init();
        $boundary = '----WP' . md5(uniqid('', true));

        $body = '';
        foreach ($fields as $k => $v) {
            $body .= "--{$boundary}\r\n";
            $body .= "Content-Disposition: form-data; name=\"{$k}\"\r\n\r\n{$v}\r\n";
        }
        $body .= "--{$boundary}\r\n";
        $body .= "Content-Disposition: form-data; name=\"file\"; filename=\"{$filename}\"\r\n";
        $body .= "Content-Type: {$mimeType}\r\n\r\n";
        $body .= $binary . "\r\n";
        $body .= "--{$boundary}--\r\n";

        $h = [
            'Content-Type: multipart/form-data; boundary=' . $boundary,
            'Content-Length: ' . strlen($body),
            $this->authHeader,
            'Accept: application/json',
        ];

        $opts = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => $h,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 5,
            CURLOPT_SSL_VERIFYPEER => $this->verifySsl,
            CURLOPT_SSL_VERIFYHOST => $this->verifySsl ? 2 : 0,
        ];
        curl_setopt_array($ch, $opts);
        $raw = curl_exec($ch);
        $curlErr = ($raw === false) ? curl_error($ch) : '';
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        curl_close($ch);

        $respHeaders = [];
        $respBody = '';
        if ($raw !== false) {
            $respHeadersStr = substr($raw, 0, $headerSize);
            $respBody = substr($raw, $headerSize);
            $respHeaders = $this->parseHeaders($respHeadersStr);
        }
        $json = null;
        if ($respBody !== '') {
            $j = json_decode($respBody, true);
            if (json_last_error() === JSON_ERROR_NONE) $json = $j;
        }
        return [
            'status' => $status,
            'headers' => $respHeaders,
            'body' => $respBody,
            'json' => $json,
            'error' => $curlErr,
        ];
    }
}
