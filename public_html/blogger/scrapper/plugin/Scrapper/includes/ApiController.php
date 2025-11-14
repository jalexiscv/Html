<?php

namespace Scrapper;

use WP_Error;
use WP_REST_Request;
use WP_REST_Response;
use const SCRAPPER_REST_NAMESPACE;

/**
 * ApiController
 * Controlador REST que registra las rutas del namespace "scrapper/v1".
 * Provee un endpoint POST /scrapper/v1/posts para crear publicaciones
 * con título, contenido, imagen destacada (opcional) y categorías.
 *
 * Autenticación: Header "X-Scrapper-Token" debe coincidir con la opción
 * de WordPress "scrapper_api_token" generada al activar el plugin.
 *
 * No usa librerías de terceros.
 */
class ApiController
{
    /**
     * Registra todas las rutas REST del plugin.
     * @return void
     */
    public static function register_routes()
    {
        register_rest_route(SCRAPPER_REST_NAMESPACE, '/posts', [
            'methods' => 'POST',
            'callback' => [self::class, 'handle_create_post'],
            'permission_callback' => [self::class, 'check_token'],
            'args' => [
                'title' => [
                    'required' => true,
                    'type' => 'string',
                ],
                'content' => [
                    'required' => true,
                    'type' => 'string',
                ],
                'featured_image' => [
                    'required' => false,
                    'type' => 'string',
                    'description' => 'URL de imagen o datos base64 (data:image/..;base64,...)',
                ],
                'categories' => [
                    'required' => false,
                    'type' => 'array',
                    'items' => ['type' => 'string'],
                    'description' => 'Lista de nombres de categorías (se crean si no existen) o IDs (números).',
                ],
                'status' => [
                    'required' => false,
                    'type' => 'string',
                    'enum' => ['draft', 'publish', 'pending', 'private', 'future'],
                    'default' => 'publish',
                ],
            ],
        ]);

        register_rest_route(SCRAPPER_REST_NAMESPACE, '/settings/token', [
            'methods' => 'GET',
            'callback' => [self::class, 'handle_get_token'],
            'permission_callback' => function () {
                // Requiere estar logueado como admin para obtener el token
                return current_user_can('manage_options');
            },
        ]);

        register_rest_route(SCRAPPER_REST_NAMESPACE, '/settings/rotate-token', [
            'methods' => 'POST',
            'callback' => [self::class, 'handle_rotate_token'],
            'permission_callback' => function () {
                return current_user_can('manage_options');
            },
        ]);
    }

    /**
     * Valida el header de autenticación X-Scrapper-Token.
     * @return bool|WP_Error
     */
    public static function check_token($request)
    {
        // WP envía el request a esta función: podemos leer el header directamente
        $provided = is_object($request) && method_exists($request, 'get_header')
            ? (string)$request->get_header('x-scrapper-token')
            : '';
        $expected = get_option('scrapper_api_token');
        if (!is_string($expected) || $expected === '') {
            return new WP_Error('scrapper_no_token', 'Token no configurado.', ['status' => 401]);
        }
        if (!is_string($provided) || !hash_equals($expected, $provided)) {
            return new WP_Error('scrapper_bad_token', 'Token inválido.', ['status' => 403]);
        }
        return true;
    }

    /**
     * Crea una publicación a partir de los datos del cuerpo.
     * @param WP_REST_Request $request
     * @return WP_REST_Response|WP_Error
     */
    public static function handle_create_post($request)
    {
        $title = (string)$request->get_param('title');
        $content = (string)$request->get_param('content');
        $status = (string)$request->get_param('status') ?: 'publish';
        $feat = $request->get_param('featured_image');
        $catsIn = $request->get_param('categories');

        // Crear post
        $postService = new PostService();
        $post_id = $postService->create_post([
            'post_title' => $title,
            'post_content' => $content,
            'post_status' => $status,
            'post_type' => 'post',
        ]);
        if (is_wp_error($post_id)) {
            return $post_id;
        }

        // Asignar categorías si se enviaron
        if (is_array($catsIn) && !empty($catsIn)) {
            $catService = new TaxonomyService();
            $term_ids = $catService->resolve_categories($catsIn);
            if (is_wp_error($term_ids)) {
                return $term_ids;
            }
            wp_set_post_terms($post_id, $term_ids, 'category', false);
        }

        // Imagen destacada si aplica
        if (is_string($feat) && $feat !== '') {
            $mediaService = new MediaService();
            $thumb_id = $mediaService->attach_featured_image($post_id, $feat, $title);
            if (is_wp_error($thumb_id)) {
                // No abortamos por imagen; devolvemos warning
                $warning = $thumb_id->get_error_message();
            }
        }

        $resp = [
            'id' => (int)$post_id,
            'link' => get_permalink($post_id),
        ];
        if (isset($warning)) {
            $resp['warning'] = $warning;
        }
        return new WP_REST_Response($resp, 201);
    }

    /**
     * Devuelve el token actual (solo admins).
     * @return WP_REST_Response
     */
    public static function handle_get_token()
    {
        $token = (string)get_option('scrapper_api_token');
        return new WP_REST_Response(['token' => $token], 200);
    }

    /**
     * Rota el token (solo admins).
     * @return WP_REST_Response
     */
    public static function handle_rotate_token()
    {
        $new = wp_generate_password(32, false, false);
        update_option('scrapper_api_token', $new, false);
        return new WP_REST_Response(['token' => $new], 200);
    }
}
