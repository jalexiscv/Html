<?php

namespace App\Libraries\Charts\Types;

/**
 * Clase BarChart (Gráfico de Barras)
 *
 * Extiende AbstractChart para implementar la lógica de renderizado específica
 * para gráficos de barras utilizando ApexCharts.
 */
class BarChart extends AbstractChart
{
    /**
     * Renderiza un gráfico de barras.
     *
     * Genera el código HTML y JavaScript necesario para mostrar un gráfico de barras
     * de ApexCharts. El ID del contenedor del gráfico se genera automáticamente
     * para asegurar que sea único.
     *
     * @return string El código HTML y JavaScript para el gráfico de barras.
     */
    public function render(): string
    {
        $chartId = 'barchart-' . uniqid(); // ID único para el contenedor del gráfico
        // Asegura que las opciones base del gráfico estén presentes
        $defaultOptions = [
            'chart' => [
                'type' => 'bar',
                'height' => 350 // Altura por defecto
            ],
            'series' => [],
            'xaxis' => [
                'categories' => []
            ]
        ];

        // Fusiona las opciones por defecto con las proporcionadas por el usuario
        // Las opciones del usuario tienen precedencia
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
