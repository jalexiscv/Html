<?php


require_once(APPPATH . 'Libraries/Charts/Charts.php');
require_once(APPPATH . 'Libraries/Charts/Types/AbstractChart.php');
require_once(APPPATH . 'Libraries/Charts/Types/BarChart.php');
require_once(APPPATH . 'Libraries/Charts/Types/LineChart.php');
require_once(APPPATH . 'Libraries/Charts/Types/PieChart.php');

use App\Libraries\Charts\Charts;
use App\Libraries\Charts\Types\AbstractChart;

// Opciones del gráfico (específicas de ApexCharts)
$opciones = [
    'series' => [[
        'name' => 'Mi Serie de Datos',
        'data' => [10, 20, 30, 40, 50]
    ]],
    'xaxis' => [
        'categories' => ['A', 'B', 'C', 'D', 'E']
    ]

];

// Crear un gráfico de barras
$graficoDeBarras = Charts::create('bar', $opciones);
echo $graficoDeBarras->render();

?>