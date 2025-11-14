<?php

namespace Scrapper;

use WP_Error;

/**
 * PostService
 * Servicio responsable de crear publicaciones usando funciones nativas de WordPress.
 * No utiliza librerías de terceros.
 */
class PostService
{
    /**
     * Crea una publicación con los argumentos dados.
     * @param array $args Arreglo compatible con wp_insert_post
     * @return int|WP_Error ID del post o error de WP
     */
    public function create_post(array $args)
    {
        // Saneamos argumentos mínimos
        $defaults = [
            'post_status' => 'publish',
            'post_type' => 'post',
            'post_title' => '',
            'post_content' => '',
        ];
        $postarr = wp_parse_args($args, $defaults);

        // Validaciones básicas
        if (!is_string($postarr['post_title']) || $postarr['post_title'] === '') {
            return new WP_Error('scrapper_post_title_required', 'El título es obligatorio.', ['status' => 400]);
        }
        if (!is_string($postarr['post_content'])) {
            $postarr['post_content'] = '';
        }

        // Crear post
        $post_id = wp_insert_post($postarr, true);
        if (is_wp_error($post_id)) {
            return $post_id;
        }
        return (int)$post_id;
    }
}
