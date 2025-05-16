<?php

namespace App\Libraries\Charts\Types;

/**
 * Clase AbstractChart (Gráfico Abstracto)
 *
 * Define la estructura base para todos los tipos de gráficos.
 * Cada gráfico específico debe extender esta clase e implementar el método render().
 * Las opciones del gráfico, basadas en la configuración de ApexCharts, se almacenan
 * y se utilizan para generar el código JavaScript necesario para la visualización.
 */
abstract class AbstractChart
{
    /**
     * @var array Las opciones de configuración del gráfico.
     *            Estas opciones se corresponden directamente con la configuración de ApexCharts.
     *            Ejemplo: ['series' => [...], 'xaxis' => [...], ...]
     */
    protected array $options;

    /**
     * Constructor de la clase AbstractChart.
     *
     * @param array $options Un array asociativo con las opciones de configuración para el gráfico.
     *                       Estas opciones se utilizarán para renderizar el gráfico con ApexCharts.
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * Renderiza el gráfico como una cadena HTML/JavaScript.
     *
     * Este método debe ser implementado por cada clase de gráfico concreta.
     * La implementación generará el código HTML y JavaScript necesario
     * para mostrar el gráfico ApexCharts en una página web.
     *
     * @return string El código HTML y JavaScript para renderizar el gráfico.
     */
    abstract public function render(): string;
}
