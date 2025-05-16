<?php

namespace App\Libraries\Charts;

use App\Libraries\Charts\Types\AbstractChart;
use InvalidArgumentException;

/**
 * Clase Charts (Gráficos)
 *
 * Proporciona una interfaz para la creación de diferentes tipos de gráficos
 * utilizando la biblioteca ApexCharts.
 * Funciona como una fábrica para instanciar objetos de gráfico específicos.
 */
class Charts
{
    /**
     * Crea una instancia de un tipo de gráfico específico.
     *
     * Este método actúa como una fábrica para generar objetos de gráfico basados en el tipo especificado.
     * Las opciones proporcionadas se pasarán al constructor del gráfico específico.
     *
     * @param string $type El tipo de gráfico a crear (por ejemplo, 'bar', 'line', 'pie').
     * @param array $options Un array asociativo con las opciones de configuración para el gráfico.
     *                       Estas opciones son específicas de ApexCharts.
     * @return AbstractChart Una instancia de la clase de gráfico solicitada.
     * @throws InvalidArgumentException Si el tipo de gráfico especificado no existe.
     *
     * @example
     * ```php
     * // Ejemplo de uso básico:
     * $barChart = \App\Libraries\Charts\Charts::create('bar', [
     *     'series' => [[
     *         'name' => 'Ventas',
     *         'data' => [10, 41, 35, 51, 49, 62, 69, 91, 148]
     *     ]],
     *     'xaxis' => [
     *         'categories' => ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep"]
     *     ]
     * ]);
     * // echo $barChart->render();
     * ```
     */
    public static function create(string $type, array $options): AbstractChart
    {
        $className = __NAMESPACE__ . '\\Types\\' . ucfirst(strtolower($type)) . 'Chart';
        if (class_exists($className)) {
            return new $className($options);
        }
        throw new InvalidArgumentException("El tipo de gráfico [{$type}] no fue encontrado.");
    }
}
