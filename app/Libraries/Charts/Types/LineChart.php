<?php

namespace App\Libraries\Charts\Types;

/**
 * Clase LineChart (Gráfico de Líneas)
 *
 * Extiende AbstractChart para implementar la lógica de renderizado específica
 * para gráficos de líneas utilizando ApexCharts.
 */
class LineChart extends AbstractChart
{
    /**
     * Renderiza un gráfico de líneas.
     *
     * Genera el código HTML y JavaScript necesario para mostrar un gráfico de líneas
     * de ApexCharts. El ID del contenedor del gráfico se genera automáticamente.
     *
     * @return string El código HTML y JavaScript para el gráfico de líneas.
     */
    public function render(): string
    {
        $chartId = 'linechart-' . uniqid(); // ID único para el contenedor del gráfico
        // Asegura que las opciones base del gráfico estén presentes
        $defaultOptions = [
            'chart' => [
                'type' => 'line',
                'height' => 350 // Altura por defecto
            ],
            'series' => [],
            'xaxis' => [
                'categories' => []
            ]
        ];

        // Fusiona las opciones por defecto con las proporcionadas por el usuario
        $finalOptions = array_replace_recursive($defaultOptions, $this->options);
        $optionsJson = json_encode($finalOptions);

        // Script para inicializar ApexCharts
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
