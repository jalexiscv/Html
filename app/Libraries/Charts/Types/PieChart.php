<?php

namespace App\Libraries\Charts\Types;

/**
 * Clase PieChart (Gráfico Circular o de Torta)
 *
 * Extiende AbstractChart para implementar la lógica de renderizado específica
 * para gráficos circulares (pie charts) utilizando ApexCharts.
 */
class PieChart extends AbstractChart
{
    /**
     * Renderiza un gráfico circular.
     *
     * Genera el código HTML y JavaScript necesario para mostrar un gráfico circular
     * de ApexCharts. El ID del contenedor del gráfico se genera automáticamente.
     *
     * @return string El código HTML y JavaScript para el gráfico circular.
     */
    public function render(): string
    {
        $chartId = 'piechart-' . uniqid(); // ID único para el contenedor del gráfico
        // Asegura que las opciones base del gráfico estén presentes
        $defaultOptions = [
            'chart' => [
                'type' => 'pie',
                'height' => 350 // Altura por defecto
            ],
            'series' => [], // Los datos para un gráfico de pie son una serie de números
            'labels' => []  // Las etiquetas para cada sección del gráfico de pie
        ];

        // Fusiona las opciones por defecto con las proporcionadas por el usuario
        $finalOptions = array_replace_recursive($defaultOptions, $this->options);
        $optionsJson = json_encode($finalOptions);

        // Script para inicializar ApexCharts
        // Nota: Para gráficos de pie, 'series' es un array de valores y 'labels' son las etiquetas.
        return "<div id='{$chartId}'></div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var options = {$optionsJson};
                        var chart = new ApexCharts(document.querySelector('#{$chartId}'), options);
                        chart.render();
                    });
                </script>";
    }
}
