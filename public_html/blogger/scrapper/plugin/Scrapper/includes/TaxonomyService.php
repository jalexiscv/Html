<?php

namespace Scrapper;

use WP_Error;

/**
 * TaxonomyService
 * Resuelve y/o crea categorías y devuelve sus IDs para asignarlas a publicaciones.
 * Acepta una mezcla de IDs (int/string numérica) y nombres (string).
 * No usa librerías de terceros.
 */
class TaxonomyService
{
    /**
     * Recibe una lista de categorías como IDs o nombres y devuelve IDs de términos.
     * Si un nombre no existe, se crea.
     * @param array<int, mixed> $categories
     * @return array<int,int>|WP_Error
     */
    public function resolve_categories(array $categories)
    {
        $term_ids = [];
        foreach ($categories as $cat) {
            // Si es numérico, asumimos ID existente
            if (is_int($cat) || (is_string($cat) && ctype_digit($cat))) {
                $term_ids[] = (int)$cat;
                continue;
            }
            // Si es string no vacío, lo tratamos como nombre
            if (is_string($cat)) {
                $name = trim($cat);
                if ($name === '') continue;
                $term = get_term_by('name', $name, 'category');
                if ($term && !is_wp_error($term)) {
                    $term_ids[] = (int)$term->term_id;
                    continue;
                }
                $created = wp_insert_term($name, 'category');
                if (is_wp_error($created)) {
                    // Si ya existe por slug, intentar obtenerlo
                    if ($created->get_error_code() === 'term_exists') {
                        $term_ids[] = (int)$created->get_error_data('term_exists');
                    } else {
                        return $created;
                    }
                } else {
                    $term_ids[] = (int)$created['term_id'];
                }
            }
        }
        // Eliminar duplicados y normalizar
        $term_ids = array_values(array_unique(array_map('intval', $term_ids)));
        return $term_ids;
    }
}
