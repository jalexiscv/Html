<?php
/**
 * WpPublisher
 * Librería para publicar entradas en WordPress a través de la REST API v2.
 *
 * Características principales:
 * - Autenticación por Application Passwords (Basic Auth en la REST API).
 * - Creación/obtención de categorías y tags por nombre.
 * - Subida de imagen destacada (featured_media) al endpoint /media.
 * - Creación de posts con título, contenido HTML, categorías, tags e imagen destacada.
 * - Sin librerías de terceros.
 *
 * Requisitos en el WordPress de destino:
 * - Permitir REST API (por defecto en WP moderno).
 * - Activar Application Passwords para el usuario con permisos de publicar.
 */
require_once __DIR__ . '/WpHttp.php';

class WpPublisher
{
    /** @var WpHttp */
    private $http;

    /**
     * @param string $baseUrl Base del sitio WordPress, ej: https://tu-sitio.com
     * @param string $username Usuario de WP con permisos
     * @param string $appPassword Application Password generado en el perfil
     * @param bool $verifySsl Verificar SSL
     */
    public function __construct($baseUrl, $username, $appPassword, $verifySsl = true)
    {
        $this->http = new WpHttp($baseUrl, $username, $appPassword, $verifySsl);
    }

    /**
     * getMe
     * Verifica las credenciales consultando el endpoint autenticado `/wp/v2/users/me`.
     * Devuelve el JSON del usuario autenticado cuando las credenciales son válidas.
     * @return array Respuesta: ['status'=>int, 'json'=>mixed, 'error'=>string|null, 'headers'=>array, 'body'=>string]
     */
    public function getMe()
    {
        return $this->http->requestJson('GET', 'users/me');
    }

    /**
     * Publica una entrada completa en WordPress.
     * - Crea categorías y tags si no existen.
     * - Sube la imagen destacada si se proporciona.
     * - Crea el post con los IDs correspondientes.
     *
     * @param string $title Título de la entrada
     * @param string $htmlContent Contenido HTML de la entrada
     * @param array $categoriesNames Lista de nombres de categorías
     * @param array $tagsNames Lista de nombres de tags/etiquetas
     * @param string|null $featuredUrl URL pública de la imagen de portada (opcional)
     * @param string $status Estado del post: 'draft'|'publish'|'pending'|'private'
     * @return array                      Respuesta de la REST API (json, status, error)
     */
    public function publishPost($title, $htmlContent, array $categoriesNames = [], array $tagsNames = [], $featuredUrl = null, $status = 'publish')
    {
        // 1) Asegurar categorías
        $catIds = [];
        foreach ($categoriesNames as $name) {
            $id = $this->ensureTerm('categories', (string)$name);
            if ($id) $catIds[] = $id;
        }
        // 2) Asegurar tags
        $tagIds = [];
        foreach ($tagsNames as $name) {
            $id = $this->ensureTerm('tags', (string)$name);
            if ($id) $tagIds[] = $id;
        }

        // 3) Subir imagen destacada si aplica
        $featuredId = null;
        if (is_string($featuredUrl) && $featuredUrl !== '') {
            $upload = $this->uploadFeaturedFromUrl($featuredUrl, $title);
            if (($upload['status'] >= 200 && $upload['status'] < 300) && isset($upload['json']['id'])) {
                $featuredId = (int)$upload['json']['id'];
            }
        }

        // 4) Crear post
        $payload = [
            'title' => $title,
            'content' => $htmlContent,
            'status' => $status,
        ];
        if (!empty($catIds)) $payload['categories'] = $catIds;
        if (!empty($tagIds)) $payload['tags'] = $tagIds;
        if ($featuredId) $payload['featured_media'] = $featuredId;

        $resp = $this->http->requestJson('POST', 'posts', $payload);
        return $resp;
    }

    /**
     * Asegura un término (categoría o tag). Si existe por nombre, devuelve su ID; si no, lo crea.
     * @param string $taxonomy 'categories' o 'tags'
     * @param string $name Nombre del término
     * @return int|null ID del término o null en error
     */
    public function ensureTerm($taxonomy, $name)
    {
        $taxonomy = ($taxonomy === 'tags') ? 'tags' : 'categories';
        $name = trim($name);
        if ($name === '') return null;

        // Buscar por nombre (primera página)
        $query = http_build_query(['search' => $name, 'per_page' => 100, 'hide_empty' => false]);
        $r = $this->http->requestJson('GET', $taxonomy . '?' . $query);
        if ($r['error']) return null;
        if (is_array($r['json'])) {
            foreach ($r['json'] as $term) {
                if (isset($term['name']) && strcasecmp($term['name'], $name) === 0) {
                    return (int)$term['id'];
                }
            }
        }
        // Crear si no existe
        $slug = $this->slugify($name);
        $c = $this->http->requestJson('POST', $taxonomy, ['name' => $name, 'slug' => $slug]);
        if ($c['error']) return null;
        if (isset($c['json']['id'])) return (int)$c['json']['id'];
        return null;
    }

    /**
     * Genera un slug simple a partir de un nombre.
     * @param string $text
     * @return string
     */
    private function slugify($text)
    {
        $text = strtolower(trim($text));
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        $text = trim($text, '-');
        if ($text === '') $text = 'term-' . substr(md5($text . microtime(true)), 0, 6);
        return $text;
    }

    /**
     * Sube una imagen destacada desde una URL pública.
     * Descarga el binario y lo envía al endpoint /media.
     * @param string $url URL de la imagen
     * @param string $title Título/alt de la imagen
     * @return array Respuesta del upload
     */
    public function uploadFeaturedFromUrl($url, $title = '')
    {
        $bin = $this->downloadBinary($url);
        if ($bin === null) {
            return ['status' => 0, 'error' => 'No se pudo descargar la imagen', 'json' => null, 'body' => ''];
        }
        $filename = basename(parse_url($url, PHP_URL_PATH)) ?: ('imagen_' . date('Ymd_His') . '.jpg');
        $mime = $this->guessMimeFromFilename($filename);
        $fields = [];
        if ($title !== '') {
            $fields['title'] = $title;
            $fields['alt_text'] = $title;
        }
        return $this->http->uploadMedia($filename, $bin, $mime, $fields);
    }

    /**
     * Descarga un recurso binario vía cURL simple.
     * @param string $url
     * @return string|null
     */
    private function downloadBinary($url)
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 5,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; WpPublisher/1.0)'
        ]);
        $data = curl_exec($ch);
        $ok = $data !== false && curl_getinfo($ch, CURLINFO_HTTP_CODE) >= 200 && curl_getinfo($ch, CURLINFO_HTTP_CODE) < 300;
        curl_close($ch);
        if (!$ok) return null;
        return $data;
    }

    /**
     * Intenta deducir el mime-type desde la extensión del archivo.
     * @param string $filename
     * @return string
     */
    private function guessMimeFromFilename($filename)
    {
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        switch ($ext) {
            case 'jpg':
            case 'jpeg':
                return 'image/jpeg';
            case 'png':
                return 'image/png';
            case 'gif':
                return 'image/gif';
            case 'webp':
                return 'image/webp';
            case 'svg':
                return 'image/svg+xml';
            default:
                return 'application/octet-stream';
        }
    }
}
