<?php
/**
 * helpers.php
 * Conjunto de utilidades propias sin dependencias externas.
 *
 * - esc_html: escapado seguro para texto HTML
 * - esc_attr: escapado seguro para atributos HTML
 * - normalize_whitespace: colapsa espacios y recorta extremos
 * - normalize_url_canonical: normaliza una URL para generar IDs estables
 * - is_md5_id: valida una cadena hexadecimal de 32 caracteres
 */

if (!function_exists('esc_html')) {
    /**
     * Escapa caracteres especiales para mostrarlos como texto en HTML.
     * @param string $s
     * @return string
     */
    function esc_html($s)
    {
        return htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

if (!function_exists('esc_attr')) {
    /**
     * Escapa caracteres para usarlos en atributos HTML (href, title, etc.).
     * @param string $s
     * @return string
     */
    function esc_attr($s)
    {
        return htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

if (!function_exists('normalize_whitespace')) {
    /**
     * Reemplaza secuencias de espacios/tabs/nuevas líneas por un único espacio y recorta.
     * @param string $s
     * @return string
     */
    function normalize_whitespace($s)
    {
        $s = preg_replace('/[\r\n\t]+/', ' ', (string)$s);
        $s = preg_replace('/\s{2,}/', ' ', $s);
        return trim($s);
    }
}

if (!function_exists('normalize_url_canonical')) {
    /**
     * Normaliza una URL para generar un identificador canónico estable:
     * - Baja el host a minúsculas.
     * - Elimina fragmentos (#...)
     * - Ordena parámetros del query y elimina parámetros de tracking comunes.
     * - Quita barra final redundante.
     * @param string $url
     * @return string URL normalizada o cadena vacía si es inválida
     */
    function normalize_url_canonical($url)
    {
        if (!is_string($url)) return '';
        $url = trim($url);
        if ($url === '' || !filter_var($url, FILTER_VALIDATE_URL)) return '';
        $p = parse_url($url);
        $scheme = isset($p['scheme']) ? strtolower($p['scheme']) : 'http';
        $host = isset($p['host']) ? strtolower($p['host']) : '';
        $port = isset($p['port']) ? (int)$p['port'] : null;
        $path = isset($p['path']) ? $p['path'] : '/';
        $query = isset($p['query']) ? $p['query'] : '';
        // quitar fragment
        // reconstruir query ordenado y filtrado
        $track = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'gclid', 'fbclid', 'mc_cid', 'mc_eid'];
        $q = [];
        if ($query !== '') {
            parse_str($query, $q);
            foreach ($track as $k) {
                unset($q[$k]);
            }
            ksort($q);
        }
        $qstr = http_build_query($q, '', '&', PHP_QUERY_RFC3986);
        // normalizar path: múltiples barras y quitar barra final salvo raíz
        $path = preg_replace('#/{2,}#', '/', $path);
        if ($path !== '/' && substr($path, -1) === '/') {
            $path = rtrim($path, '/');
        }
        $out = $scheme . '://' . $host;
        if ($port && !in_array([$scheme, $port], [['http', 80], ['https', 443]], true)) {
            $out .= ':' . $port;
        }
        $out .= $path;
        if ($qstr !== '') $out .= '?' . $qstr;
        return $out;
    }
}

if (!function_exists('is_md5_id')) {
    /**
     * Verifica si $s es un hash MD5 hexadecimal de 32 caracteres.
     * @param string $s
     * @return bool
     */
    function is_md5_id($s)
    {
        return is_string($s) && preg_match('/^[a-f0-9]{32}$/i', $s) === 1;
    }
}
