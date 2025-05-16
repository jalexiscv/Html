# Biblioteca de Gráficos PHP con ApexCharts

Esta biblioteca PHP facilita la generación de gráficos interactivos y dinámicos utilizando la popular biblioteca de
JavaScript [ApexCharts](https://apexcharts.com/). Proporciona una estructura orientada a objetos para definir y
renderizar varios tipos de gráficos como barras, líneas y circulares (torta/dona).

## Estructura de la Biblioteca

La biblioteca se organiza de la siguiente manera:

- `Charts.php`: Clase principal que actúa como una fábrica para crear instancias de gráficos específicos.
- `Types/` (Directorio):
    - `AbstractChart.php`: Clase base abstracta que define la interfaz común para todos los tipos de gráficos.
    - `BarChart.php`: Implementación para gráficos de barras.
    - `LineChart.php`: Implementación para gráficos de líneas.
    - `PieChart.php`: Implementación para gráficos circulares (incluyendo gráficos de dona).

## Requisitos

- PHP 7.4 o superior.
- La biblioteca JavaScript ApexCharts debe estar incluida en la página HTML donde se renderizarán los gráficos.
  ```html
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  ```

## Instalación y Configuración

1. **Incluir la biblioteca:**
   Asegúrate de que las clases de la biblioteca sean accesibles en tu proyecto. Puedes usar un autoloader de Composer o
   incluir los archivos manualmente:

   ```php
   // Si usas Composer (recomendado):
   // require_once 'vendor/autoload.php';

   // Inclusión manual (ajusta las rutas según tu estructura):
   require_once 'ruta/a/app/Libraries/Charts/Charts.php';
   require_once 'ruta/a/app/Libraries/Charts/Types/AbstractChart.php';
   require_once 'ruta/a/app/Libraries/Charts/Types/BarChart.php';
   require_once 'ruta/a/app/Libraries/Charts/Types/LineChart.php';
   require_once 'ruta/a/app/Libraries/Charts/Types/PieChart.php';
   ```

2. **Namespace:**
   Las clases de esta biblioteca se encuentran bajo el namespace `App\Libraries\Charts`.

   ```php
   use App\Libraries\Charts\Charts;
   use App\Libraries\Charts\Types\AbstractChart; // Opcional, si necesitas referenciarla directamente
   ```

## Uso Básico

La clase `Charts` proporciona un método estático `create()` para generar instancias de gráficos.

```php
use App\Libraries\Charts\Charts;

// Opciones del gráfico (específicas de ApexCharts)
$opciones = [
    'series' => [[
        'name' => 'Mi Serie de Datos',
        'data' => [10, 20, 30, 40, 50]
    ]],
    'xaxis' => [
        'categories' => ['A', 'B', 'C', 'D', 'E"]
    ]
    // ... más opciones de ApexCharts
];

// Crear un gráfico de barras
$graficoDeBarras = Charts::create('bar', $opciones);

// Renderizar el gráfico (esto generará el HTML y JavaScript)
// echo $graficoDeBarras->render();
```

### Clase `Charts`

#### `public static function create(string $type, array $options): AbstractChart`

Crea una instancia de un tipo de gráfico específico.

- **`$type` (string):** El tipo de gráfico a crear. Valores admitidos actualmente:
    - `'bar'` (para gráficos de barras)
    - `'line'` (para gráficos de líneas)
    - `'pie'` (para gráficos circulares y de dona)
- **`$options` (array):** Un array asociativo con las opciones de configuración para el gráfico. Estas opciones se
  corresponden directamente con la [documentación de opciones de ApexCharts](https://apexcharts.com/docs/options/).
- **Retorna:** Una instancia de una clase que hereda de `AbstractChart` (por ejemplo, `BarChart`, `LineChart`,
  `PieChart`).
- **Lanza:** `InvalidArgumentException` si el tipo de gráfico no es válido.

### Clase `AbstractChart`

Clase base abstracta para todos los tipos de gráficos.

#### `public function __construct(array $options)`

Constructor que recibe las opciones del gráfico.

#### `abstract public function render(): string`

Método abstracto que debe ser implementado por las clases hijas para generar el HTML y JavaScript necesarios para
renderizar el gráfico.

## Ejemplos Completos

A continuación, se muestra un archivo PHP completo que demuestra cómo usar cada tipo de gráfico. Recuerda que este
archivo debe ser accesible a través de un servidor web y la biblioteca ApexCharts JS debe estar incluida en la página.

```php
<?php

// Asegúrate de que el autoloading de Composer o un cargador de clases similar esté configurado
// require_once 'vendor/autoload.php'; // Si usas Composer

// O incluye manualmente los archivos si no usas un autoloader (ajusta las rutas según sea necesario)
// Comenta/descomenta según tu configuración. Para este ejemplo, asumimos que están en la misma estructura relativa.
require_once '../Charts.php';
require_once '../Types/AbstractChart.php';
require_once '../Types/BarChart.php';
require_once '../Types/LineChart.php';
require_once '../Types/PieChart.php';

use App\Libraries\Charts\Charts;
use InvalidArgumentException;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplos de Gráficos ApexCharts con PHP</title>
    <!-- Incluir ApexCharts JS -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
        body { font-family: sans-serif; padding: 20px; background-color: #f9f9f9; color: #333; }
        .chart-container { 
            margin-bottom: 40px; 
            padding: 20px; 
            border: 1px solid #ddd; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            background-color: #fff;
            border-radius: 8px;
        }
        h1 { text-align: center; color: #2c3e50; margin-bottom: 30px;}
        h2 { border-bottom: 2px solid #7f8c8d; padding-bottom: 10px; color: #34495e; }
    </style>
</head>
<body>

    <h1>Demostración de la Biblioteca de Gráficos PHP con ApexCharts</h1>

    <!-- Ejemplo de Gráfico de Barras -->
    <div class="chart-container">
        <h2>Gráfico de Barras: Ventas Mensuales</h2>
        <?php
        try {
            $barChartOptions = [
                'series' => [[ // Cada array interno es una serie
                    'name' => 'Ventas Totales (USD)',
                    'data' => [400, 430, 448, 470, 540, 580, 690, 1100, 1200, 1380]
                ]],
                'chart' => [
                    'type' => 'bar',
                    'height' => 350,
                    'toolbar' => ['show' => true]
                ],
                'plotOptions' => [
                    'bar' => [
                        'horizontal' => false,
                        'columnWidth' => '55%',
                        'endingShape' => 'rounded',
                        'dataLabels' => [
                            'position' => 'top', // Muestra etiquetas de datos en la parte superior
                        ],
                    ],
                ],
                'dataLabels' => [
                    'enabled' => true,
                    'offsetY' => -20,
                    'style' => [
                        'fontSize' => '12px',
                        'colors' => ["#304758"]
                    ]
                ],
                'stroke' => [
                    'show' => true,
                    'width' => 2,
                    'colors' => ['transparent']
                ],
                'xaxis' => [
                    'categories' => ['Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov'],
                    'title' => ['text' => 'Meses']
                ],
                'yaxis' => [
                    'title' => [
                        'text' => '$ (miles)'
                    ]
                ],
                'fill' => [
                    'opacity' => 1
                ],
                'tooltip' => [
                    'y' => [
                        'formatter' => "function (val) { return "$ " + val + " miles" }"
                    ]
                ],
                'title' => [
                    'text' => 'Rendimiento de Ventas Mensuales Detallado',
                    'align' => 'center',
                    'style' => ['fontSize' => '16px']
                ],
                'colors' => ['#2980b9'] // Color de las barras
            ];
            $barChart = Charts::create('bar', $barChartOptions);
            echo $barChart->render();
        } catch (InvalidArgumentException $e) {
            echo "<p style='color:red;'>Error al crear gráfico de barras: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        ?>
    </div>

    <!-- Ejemplo de Gráfico de Líneas -->
    <div class="chart-container">
        <h2>Gráfico de Líneas: Evolución de Usuarios</h2>
        <?php
        try {
            $lineChartOptions = [
                'series' => [
                    [
                        'name' => 'Usuarios Activos',
                        'data' => [31, 40, 28, 51, 42, 109, 100]
                    ],
                    [
                        'name' => 'Nuevos Registros',
                        'data' => [11, 32, 45, 32, 34, 52, 41]
                    ]
                ],
                'chart' => [
                    'height' => 350,
                    'type' => 'line',
                    'zoom' => ['enabled' => true],
                    'animations' => ['enabled' => true, 'easing' => 'easeinout', 'speed' => 800]
                ],
                'dataLabels' => ['enabled' => false],
                'stroke' => ['curve' => 'smooth', 'width' => 2.5],
                'title' => [
                    'text' => 'Evolución de Usuarios por Semana',
                    'align' => 'left',
                    'style' => ['fontSize' => '16px']
                ],
                'grid' => [
                    'borderColor' => '#e7e7e7',
                    'row' => ['colors' => ['#f3f3f3', 'transparent'], 'opacity' => 0.5],
                ],
                'xaxis' => [
                    'categories' => ['Sem1', 'Sem2', 'Sem3', 'Sem4', 'Sem5', 'Sem6', 'Sem7'],
                    'title' => ['text' => 'Semanas del Año']
                ],
                'yaxis' => [
                    'title' => ['text' => 'Número de Usuarios'],
                    'min' => 0
                ],
                'legend' => [
                    'position' => 'top',
                    'horizontalAlign' => 'right',
                    'floating' => true,
                    'offsetY' => -25,
                    'offsetX' => -5
                ],
                'colors' => ['#3498db', '#e74c3c'] // Colores para cada línea
            ];
            $lineChart = Charts::create('line', $lineChartOptions);
            echo $lineChart->render();
        } catch (InvalidArgumentException $e) {
            echo "<p style='color:red;'>Error al crear gráfico de líneas: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        ?>
    </div>

    <!-- Ejemplo de Gráfico Circular (Pie Chart) -->
    <div class="chart-container">
        <h2>Gráfico Circular: Distribución de Dispositivos</h2>
        <?php
        try {
            $pieChartOptions = [
                'series' => [44, 55, 13, 43, 22], // Datos para el gráfico (array de números)
                'chart' => [
                    'height' => 380,
                    'type' => 'pie',
                ],
                'labels' => ['Escritorio', 'Móvil', 'Tableta', 'Smart TV', 'Consola'], // Etiquetas para cada sección
                'colors' => ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0'],
                'responsive' => [[ // Opciones responsivas
                    'breakpoint' => 480, // Si la pantalla es menor a 480px
                    'options' => [
                        'chart' => ['width' => 280],
                        'legend' => ['position' => 'bottom']
                    ]
                ]],
                'title' => [
                    'text' => 'Acceso por Tipo de Dispositivo (%)',
                    'align' => 'center',
                    'style' => ['fontSize' => '16px']
                ],
                'legend' => ['position' => 'right']
            ];
            $pieChart = Charts::create('pie', $pieChartOptions);
            echo $pieChart->render();
        } catch (InvalidArgumentException $e) {
            echo "<p style='color:red;'>Error al crear gráfico circular: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        ?>
    </div>

    <!-- Ejemplo de Gráfico de Dona (Donut Chart) -->
    <div class="chart-container">
        <h2>Gráfico de Dona: Preferencias de Sabor</h2>
        <?php
        try {
            $donutChartOptions = [
                'series' => [70, 15, 10, 5], // Datos
                'chart' => [
                    'height' => 380,
                    'type' => 'donut', // Tipo específico para ApexCharts
                ],
                'labels' => ['Chocolate', 'Vainilla', 'Fresa', 'Otros'],
                'colors' => ['#A569BD', '#F1C40F', '#E74C3C', '#3498DB'],
                'plotOptions' => [
                    'pie' => [
                        'donut' => [
                            'size' => '65%', // Tamaño del agujero central
                            'labels' => [
                                'show' => true,
                                'total' => [
                                    'showAlways' => true,
                                    'show' => true,
                                    'label' => 'Total Encuestados',
                                    'fontSize' => '18px',
                                    'fontWeight' => 'bold',
                                    'color' => '#373d3f',
                                    'formatter' => "function (w) {
                                        return w.globals.seriesTotals.reduce((a, b) => { return a + b }, 0)
                                    }"
                                ],
                                'name' => ['show' => true],
                                'value' => ['show' => true, 'fontSize' => '22px']
                            ]
                        ]
                    ]
                ],
                'title' => [
                    'text' => 'Preferencia de Sabores de Postres',
                    'align' => 'center',
                    'style' => ['fontSize' => '16px']
                ],
                'legend' => ['position' => 'bottom']
            ];
            // Se usa 'pie' para nuestra fábrica, la opción 'type': 'donut' en las opciones se encarga del resto
            $donutChart = Charts::create('pie', $donutChartOptions); 
            echo $donutChart->render();
        } catch (InvalidArgumentException $e) {
            echo "<p style='color:red;'>Error al crear gráfico de dona: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        ?>
    </div>

</body>
</html>
```

### Notas sobre el Ejemplo Completo:

1. **Rutas de Inclusión:** Las rutas `require_once` en el ejemplo (`../Charts.php`, etc.) asumen que el archivo de
   ejemplo está en un subdirectorio (por ejemplo, `docs/ejemplo.php`) y las clases de la biblioteca están en el
   directorio padre. Ajusta estas rutas según la ubicación real de tus archivos.
2. **Servidor Web:** Para ejecutar este archivo PHP, colócalo en el directorio raíz de tu servidor web (o un
   subdirectorio accesible) y navega a él usando tu navegador (por ejemplo, `http://localhost/ruta/a/tu/ejemplo.php`).
3. **Personalización:** Explora la [documentación de opciones de ApexCharts](https://apexcharts.com/docs/options/) para
   ver todas las formas en que puedes personalizar tus gráficos. La estructura del array `$options` en PHP debe reflejar
   la estructura del objeto de opciones en JavaScript que espera ApexCharts.

## Contribuir

Si deseas contribuir, por favor considera:

- Añadir nuevos tipos de gráficos.
- Mejorar la documentación.
- Añadir más ejemplos.
- Optimizar el código existente.

## Licencia

(Especifica aquí la licencia de tu biblioteca, por ejemplo, MIT, Apache 2.0, etc.)

---

Este archivo `README.md` proporciona una visión general, instrucciones de instalación, una referencia de la API y
ejemplos completos para ayudar a los usuarios a empezar a usar tu biblioteca de gráficos PHP.
