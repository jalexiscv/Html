# Scores

Clase para crear tarjetas de puntuación/métricas estilo dashboard. Genera componentes visuales para mostrar estadísticas
y métricas importantes con un diseño moderno y profesional.

## Descripción

La clase `Scores` permite crear tarjetas de métricas con un diseño consistente que incluye:

- Título descriptivo
- Valor principal destacado
- Icono opcional
- Subtítulo con información adicional
- Estilos personalizables

## Constructor

```php
public function __construct(array $attributes = [])
```

## Atributos disponibles

### Atributos obligatorios

- **`title`** (string): Texto del título superior
- **`value`** (string): Valor principal a mostrar

### Atributos opcionales

- **`id`** (string): ID único del elemento (por defecto: `score-{uniqid}`)
- **`class`** (string): Clases CSS adicionales para el contenedor
- **`subtitle`** (string): Texto inferior opcional
- **`icon`** (string): Clase del icono (ej: `bi bi-person-fill`)

### Personalización de estilos

- **`col-class`** (string): Clases de la columna (por defecto: `col-12 mb-3`)
- **`card-class`** (string): Clases de la tarjeta (por defecto: `card dashboard-card border-0 shadow-sm h-100`)
- **`card-style`** (string): Estilos CSS de la tarjeta (por defecto: `background: #495057;`)
- **`body-class`** (string): Clases del cuerpo (por defecto: `card-body p-3 text-white`)
- **`title-class`** (string): Clases del título (por defecto: `small opacity-75 mb-1`)
- **`value-class`** (string): Clases del valor (por defecto: `display-4 fw-bold`)
- **`subtitle-class`** (string): Clases del subtítulo (por defecto: `small opacity-75`)
- **`icon-class`** (string): Clases del icono (por defecto: `text-warning ms-1`)

## Métodos

### render()

Renderiza la tarjeta de puntuación y devuelve el HTML como string.

### __toString()

Método mágico que permite usar el objeto directamente como string.

## Ejemplos de uso

### Ejemplo básico

```php
$score = new Scores([
    'title' => 'Días sin accidentes',
    'value' => '960'
]);

echo $score;
```

### Ejemplo con icono y subtítulo

```php
$score = new Scores([
    'title' => 'Estudiantes activos',
    'value' => '1,250',
    'subtitle' => 'Meta: 1,000 (+25%)',
    'icon' => 'bi bi-person-fill'
]);

echo $score;
```

### Ejemplo con estilos personalizados

```php
$score = new Scores([
    'title' => 'Ventas del mes',
    'value' => '$45,230',
    'subtitle' => 'Incremento del 15%',
    'icon' => 'bi bi-currency-dollar',
    'card-style' => 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);',
    'icon-class' => 'text-success ms-1'
]);

echo $score;
```

### Ejemplo con múltiples tarjetas

```php
$metrics = [
    [
        'title' => 'Usuarios registrados',
        'value' => '2,847',
        'subtitle' => '+12% este mes',
        'icon' => 'bi bi-people-fill',
        'card-style' => 'background: #28a745;'
    ],
    [
        'title' => 'Ingresos totales',
        'value' => '$89,432',
        'subtitle' => '+8.5% vs mes anterior',
        'icon' => 'bi bi-graph-up',
        'card-style' => 'background: #007bff;'
    ],
    [
        'title' => 'Tareas completadas',
        'value' => '156',
        'subtitle' => '94% de eficiencia',
        'icon' => 'bi bi-check-circle-fill',
        'card-style' => 'background: #ffc107;',
        'body-class' => 'card-body p-3 text-dark'
    ]
];

foreach ($metrics as $metric) {
    $score = new Scores($metric);
    echo $score;
}
```

### Ejemplo de uso en Bootstrap

```php
// Crear una fila con múltiples métricas
echo '<div class="row">';

$score1 = new Scores([
    'title' => 'Total de cursos',
    'value' => '45',
    'subtitle' => '8 nuevos este mes',
    'icon' => 'bi bi-book-fill',
    'col-class' => 'col-md-4 mb-3'
]);

$score2 = new Scores([
    'title' => 'Estudiantes matriculados',
    'value' => '1,234',
    'subtitle' => 'Capacidad al 87%',
    'icon' => 'bi bi-people-fill',
    'col-class' => 'col-md-4 mb-3',
    'card-style' => 'background: #17a2b8;'
]);

$score3 = new Scores([
    'title' => 'Tasa de aprobación',
    'value' => '92%',
    'subtitle' => '+5% vs semestre anterior',
    'icon' => 'bi bi-trophy-fill',
    'col-class' => 'col-md-4 mb-3',
    'card-style' => 'background: #28a745;'
]);

echo $score1 . $score2 . $score3;
echo '</div>';
```

## HTML generado

La clase genera HTML con la siguiente estructura:

```html
<div class="col-12 mb-3" id="score-unique-id">
    <div class="card dashboard-card border-0 shadow-sm h-100" style="background: #495057;">
        <div class="card-body p-3 text-white">
            <div class="small opacity-75 mb-1">Título</div>
            <div class="display-4 fw-bold">Valor
                <i class="bi bi-icon text-warning ms-1"></i>
            </div>
            <div class="small opacity-75">Subtítulo</div>
        </div>
    </div>
</div>
```

## Casos de uso comunes

### Dashboard administrativo

- Métricas de usuarios
- Estadísticas de ventas
- Indicadores de rendimiento
- Contadores de actividad

### Panel educativo

- Número de estudiantes
- Cursos disponibles
- Tasas de aprobación
- Progreso académico

### Sistema de monitoreo

- Tiempo de actividad
- Errores detectados
- Recursos utilizados
- Alertas activas

## Personalización avanzada

### Colores temáticos

```php
// Tema de éxito (verde)
$successScore = new Scores([
    'title' => 'Objetivos cumplidos',
    'value' => '98%',
    'card-style' => 'background: #28a745;',
    'icon-class' => 'text-light ms-1'
]);

// Tema de advertencia (amarillo)
$warningScore = new Scores([
    'title' => 'Tareas pendientes',
    'value' => '12',
    'card-style' => 'background: #ffc107;',
    'body-class' => 'card-body p-3 text-dark'
]);

// Tema de peligro (rojo)
$dangerScore = new Scores([
    'title' => 'Errores críticos',
    'value' => '3',
    'card-style' => 'background: #dc3545;'
]);
```

### Gradientes personalizados

```php
$gradientScore = new Scores([
    'title' => 'Rendimiento general',
    'value' => '87%',
    'card-style' => 'background: linear-gradient(45deg, #ff6b6b, #4ecdc4);'
]);
```

## Compatibilidad

- **Bootstrap 5.x** (requerido)
- **Bootstrap Icons** (opcional, para iconos)
- **PHP 8.0+** (requerido)
- **HtmlTag class** (dependencia interna)

## Notas importantes

- Los atributos `title` y `value` son **obligatorios**
- El icono es opcional y se renderiza junto al valor principal
- Todos los estilos CSS son completamente personalizables
- La clase utiliza `HtmlTag` para generar HTML válido y seguro
- Compatible con sistemas de grid de Bootstrap
- Responsive por defecto
- Accesible y semánticamente correcto

## Troubleshooting

### Problema: El icono no se muestra

**Solución**: Asegúrate de incluir Bootstrap Icons en tu proyecto:

```html
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
```

### Problema: Los estilos no se aplican correctamente

**Solución**: Verifica que Bootstrap 5 esté incluido y que no haya conflictos CSS.

### Problema: Error de atributo obligatorio

**Solución**: Asegúrate de proporcionar tanto `title` como `value` en el constructor:

```php
// ✗ Incorrecto - faltará error
$score = new Scores(['title' => 'Solo título']);

// ✓ Correcto
$score = new Scores(['title' => 'Título', 'value' => '123']);
```
