<?php
/**
 * publish.php
 * Punto de entrada dedicado para publicar en WordPress el contenido de una URL identificada por ?u=...
 * - Carga la misma configuración y helpers que index.php
 * - Reutiliza la función handle_publish() definida en index.php
 * - Soporta parámetros opcionales: r=... (retorno) y debug_ai=1 (diagnóstico IA)
 */

// Incluir index.php para obtener configuración ($CONFIG) y funciones necesarias
require_once __DIR__ . '/index.php';

// Ejecutar la publicación directamente usando la lógica ya implementada
handle_publish($CONFIG);
