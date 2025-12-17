# Componente Table

Tablas estilizadas y opciones responsivas.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Content\Table;

$table = new Table([
    'headers' => ['#', 'Nombre', 'Apellido'],
    'rows' => [
        ['1', 'Mark', 'Otto'],
        ['2', 'Jacob', 'Thornton']
    ]
]);

echo $table->render();
```

## Opciones de Configuración

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `headers` | `array` | `[]` | Lista de encabezados (`th`). |
| `rows` | `array` | `[]` | Lista de filas (arrays de celdas). |
| `striped` | `bool` | `false` | Añade rayas a las filas (`table-striped`). |
| `hover` | `bool` | `false` | Asalta filas al pasar el mouse (`table-hover`). |
| `bordered` | `bool` | `false` | Añade bordes a la tabla y celdas. |
| `variant` | `string` | `null` | Variante de color (ej. `'dark'`, `'primary'`). |
| `responsive` | `bool` | `false` | Envuelve la tabla en un contenedor scrollable (`table-responsive`). |
| `attributes` | `array` | `[]` | Atributos adicionales para `<table>`. |

## Ejemplo Tabla Compleja

```php
$table = new Table([
    'headers' => ['ID', 'Producto', 'Precio'],
    'rows' => [
        ['101', 'Laptop', '$999'],
        ['102', 'Mouse', '$29']
    ],
    'striped' => true,
    'hover' => true,
    'bordered' => true,
    'variant' => 'dark',
    'responsive' => true
]);

echo $table->render();
```

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::table([
    'headers' => ['Title 1', 'Title 2'],
    'rows' => [['Row 1 Col 1', 'Row 1 Col 2']]
]);
```
