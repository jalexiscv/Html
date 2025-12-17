# Componente Col

Columna del sistema de cuadrícula.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Layout\Col;

$col = new Col([
    'content' => 'Columna automática'
]);

echo $col->render();
```

## Opciones de Configuración

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `content` | `mixed` | `''` | Contenido interno. |
| `size` | `string/int` | `null` | Número de columnas (1-12) o `'auto'`. |
| `breakpoint` | `string` | `null` | Breakpoint (`sm`, `md`, `lg`, `xl`). |
| `attributes` | `array` | `[]` | Atributos adicionales. |

## Ejemplo Columna Responsiva

```php
// col-md-6 (mitad de ancho en md y superior)
$col = new Col([
    'content' => 'Mitad',
    'size' => 6,
    'breakpoint' => 'md'
]);

echo $col->render();
```

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::col([
    'content' => 'Content',
    'size' => 6
]);
```
