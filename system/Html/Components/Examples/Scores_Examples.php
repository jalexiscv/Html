<?php
/**
 * Ejemplos de uso de la clase Scores con diferentes variantes de colores
 *
 * Este archivo demuestra cómo usar las diferentes variantes de colores
 * disponibles en la clase Scores.
 */

use Higgs\Html\Bootstrap\Scores;

// Ejemplo 1: Variante DEFAULT (colores originales)
$scoreDefault = new Scores([
        'title' => 'Estudiantes Activos',
        'value' => '1,250',
        'subtitle' => 'Periodo: 2025B',
        'icon' => ICON_STUDENTS,
        'variant' => 'default' // O simplemente omitir para usar default
]);

// Ejemplo 2: Variante SUCCESS (verde)
$scoreSuccess = new Scores([
        'title' => 'Cursos Completados',
        'value' => '89%',
        'subtitle' => '+12% este mes',
        'icon' => ICON_SUCCESS,
        'variant' => 'success'
]);

// Ejemplo 3: Variante PRIMARY (azul)
$scorePrimary = new Scores([
        'title' => 'Nuevos Registros',
        'value' => '342',
        'subtitle' => 'Esta semana',
        'icon' => ICON_USERS,
        'variant' => 'primary'
]);

// Ejemplo 4: Variante WARNING (amarillo)
$scoreWarning = new Scores([
        'title' => 'Pendientes',
        'value' => '24',
        'subtitle' => 'Requieren atención',
        'icon' => ICON_WARNING,
        'variant' => 'warning'
]);

// Ejemplo 5: Variante DANGER (rojo)
$scoreDanger = new Scores([
        'title' => 'Errores Críticos',
        'value' => '3',
        'subtitle' => 'Resolver urgente',
        'icon' => ICON_DANGER,
        'variant' => 'danger'
]);

// Ejemplo 6: Variante INFO (cyan)
$scoreInfo = new Scores([
        'title' => 'Información',
        'value' => '156',
        'subtitle' => 'Actualizaciones',
        'icon' => ICON_INFO,
        'variant' => 'info'
]);

// Ejemplo 7: Variante LIGHT (claro)
$scoreLight = new Scores([
        'title' => 'Total General',
        'value' => '2,847',
        'subtitle' => 'Todos los registros',
        'icon' => ICON_STATUSES,
        'variant' => 'light'
]);

// Ejemplo 8: Variante DARK (oscuro)
$scoreDark = new Scores([
        'title' => 'Modo Nocturno',
        'value' => '98%',
        'subtitle' => 'Rendimiento',
        'icon' => ICON_STAR,
        'variant' => 'dark'
]);

// Ejemplo 9: Variante GRADIENT PRIMARY (degradado azul-morado)
$scoreGradientPrimary = new Scores([
        'title' => 'Ventas Premium',
        'value' => '$45,230',
        'subtitle' => 'Este trimestre',
        'icon' => ICON_FINANCIAL,
        'variant' => 'gradient-primary'
]);

// Ejemplo 10: Variante GRADIENT SUCCESS (degradado azul-cyan)
$scoreGradientSuccess = new Scores([
        'title' => 'Crecimiento',
        'value' => '+127%',
        'subtitle' => 'Año anterior',
        'icon' => ICON_SUCCESS,
        'variant' => 'gradient-success'
]);

// Ejemplo 11: Variante GRADIENT WARNING (degradado rosa-rojo)
$scoreGradientWarning = new Scores([
        'title' => 'Tendencia',
        'value' => '↗ 23%',
        'subtitle' => 'Últimos 30 días',
        'icon' => ICON_BOLT,
        'variant' => 'gradient-warning'
]);

// Ejemplo de uso con Bootstrap service
function exampleWithBootstrapService()
{
    $bootstrap = service('Bootstrap');

    // Usando diferentes variantes
    $scores = [
            $bootstrap->getScore('score-success', [
                    'title' => 'Éxito',
                    'value' => '100%',
                    'variant' => 'success'
            ]),

            $bootstrap->getScore('score-primary', [
                    'title' => 'Principal',
                    'value' => '456',
                    'variant' => 'primary'
            ]),

            $bootstrap->getScore('score-gradient', [
                    'title' => 'Especial',
                    'value' => '★ 5.0',
                    'variant' => 'gradient-primary'
            ])
    ];

    return $scores;
}

// Ejemplo de personalización avanzada (sobrescribir colores de variante)
$scoreCustom = new Scores([
        'title' => 'Personalizado',
        'value' => '999',
        'subtitle' => 'Colores custom',
        'icon' => ICON_STAR,
        'variant' => 'primary', // Base primary
        'card-style' => 'background: linear-gradient(45deg, #ff6b6b, #4ecdc4);', // Sobrescribir
        'body-class' => 'card-body p-3 text-white' // Sobrescribir
]);

// Mostrar variantes disponibles
echo "<!-- Variantes disponibles: -->\n";
echo "<!-- " . implode(', ', Scores::getAvailableVariants()) . " -->\n";

// Obtener colores de una variante específica
$primaryColors = Scores::getVariantColors('primary');
echo "<!-- Colores de 'primary': " . json_encode($primaryColors) . " -->\n";

?>

<!-- Ejemplo de HTML generado -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?= $scoreSuccess ?>
        </div>
        <div class="col-md-3">
            <?= $scorePrimary ?>
        </div>
        <div class="col-md-3">
            <?= $scoreWarning ?>
        </div>
        <div class="col-md-3">
            <?= $scoreGradientPrimary ?>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-4">
            <?= $scoreDanger ?>
        </div>
        <div class="col-md-4">
            <?= $scoreInfo ?>
        </div>
        <div class="col-md-4">
            <?= $scoreLight ?>
        </div>
    </div>
</div>
