<?php
/**
 * beaver.php
 * Punto de entrada dedicado para visualizar el contenido de una página scrapeada.
 * - Carga la misma configuración y helpers que index.php
 * - Reutiliza la función handle_view() definida en index.php
 * - No implementa ruteo adicional; espera recibir ?u=... [y opcionalmente r=..., debug_ai=1]
 */

// Incluir index.php para obtener configuración ($CONFIG) y funciones (view_header, handle_view, etc.)
require_once __DIR__ . '/index.php';

// Ejecutar la visualización directamente usando la lógica ya implementada
handle_view($CONFIG);
