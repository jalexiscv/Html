<?php

namespace Scrapper;

use WP_Error;

/**
 * MediaService
 * Descarga/decodifica una imagen desde URL o cadena base64 y la adjunta
 * a una publicación como imagen destacada usando funciones nativas de WP.
 * No usa librerías de terceros.
 */
class MediaService
{
    /**
     * Adjunta una imagen destacada a un post desde URL o base64.
     * @param int $post_id ID del post
     * @param string $source URL o data URI base64 (data:image/..;base64,...)
     * @param string $title Título para el adjunto
     * @return int|WP_Error ID del attachment o error
     */
    public function attach_featured_image($post_id, $source, $title = '')
    {
        if (!function_exists('wp_upload_dir')) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';
            require_once ABSPATH . 'wp-admin/includes/image.php';
        }

        $bits = null;      // contenido binario
        $filename = null;  // nombre sugerido
        $mime = null;      // mime detectado

        if (is_string($source) && strpos($source, 'data:image/') === 0) {
            // data URI: data:image/png;base64,AAA...
            $parts = explode(',', $source, 2);
            if (count($parts) !== 2) {
                return new WP_Error('scrapper_bad_data_uri', 'Formato base64 inválido.', ['status' => 400]);
            }
            $meta = $parts[0];
            $data = $parts[1];
            if (preg_match('#data:(image/[^;]+);base64#i', $meta, $m)) {
                $mime = strtolower($m[1]);
            }
            $bits = base64_decode(strtr($data, ' ', '+'));
            if ($bits === false) {
                return new WP_Error('scrapper_base64_decode', 'No se pudo decodificar la imagen base64.', ['status' => 400]);
            }
            $ext = $this->ext_from_mime($mime ?: 'image/jpeg');
            $filename = 'featured-' . wp_generate_password(8, false, false) . '.' . $ext;
        } elseif (filter_var($source, FILTER_VALIDATE_URL)) {
            // Descargar desde URL (HTTP/HTTPS)
            $resp = wp_remote_get($source, [
                'timeout' => 20,
                'redirection' => 5,
                'headers' => [
                    'User-Agent' => 'ScrapperPlugin/1.0'
                ],
            ]);
            if (is_wp_error($resp)) return $resp;
            $code = wp_remote_retrieve_response_code($resp);
            if ($code < 200 || $code >= 300) {
                return new WP_Error('scrapper_http', 'Fallo al descargar imagen (' . $code . ').', ['status' => 400]);
            }
            $bits = wp_remote_retrieve_body($resp);
            $ctype = wp_remote_retrieve_header($resp, 'content-type');
            if (is_string($ctype)) $mime = strtolower(trim(explode(';', $ctype)[0]));
            // Derivar nombre desde URL
            $path = parse_url($source, PHP_URL_PATH);
            $base = $path ? basename($path) : '';
            if (!$base || strpos($base, '.') === false) {
                $ext = $this->ext_from_mime($mime ?: 'image/jpeg');
                $base = 'featured-' . wp_generate_password(8, false, false) . '.' . $ext;
            }
            $filename = sanitize_file_name($base);
        } else {
            return new WP_Error('scrapper_img_source', 'La fuente de imagen no es URL ni base64.', ['status' => 400]);
        }

        // Guardar el archivo en la carpeta de uploads
        $upload = wp_upload_bits($filename, null, $bits);
        if (!empty($upload['error'])) {
            return new WP_Error('scrapper_upload', $upload['error'], ['status' => 500]);
        }

        // Crear attachment
        $filetype = wp_check_filetype($upload['file'], null);
        $attachment = [
            'post_mime_type' => $filetype['type'] ?: ($mime ?: 'image/jpeg'),
            'post_title' => $title ?: preg_replace('/\.[^.]+$/', '', $filename),
            'post_content' => '',
            'post_status' => 'inherit',
        ];
        $attach_id = wp_insert_attachment($attachment, $upload['file'], $post_id, true);
        if (is_wp_error($attach_id)) return $attach_id;

        // Generar metadatos y establecer como destacada
        $attach_data = wp_generate_attachment_metadata($attach_id, $upload['file']);
        wp_update_attachment_metadata($attach_id, $attach_data);
        set_post_thumbnail($post_id, $attach_id);
        return (int)$attach_id;
    }

    /**
     * Devuelve extensión habitual desde un mime.
     * @param string $mime
     * @return string
     */
    private function ext_from_mime($mime)
    {
        $map = [
            'image/jpeg' => 'jpg',
            'image/jpg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
        ];
        return isset($map[$mime]) ? $map[$mime] : 'jpg';
    }
}
