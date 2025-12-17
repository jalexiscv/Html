# Componente Row

Fila del sistema de cuadrícula (Grid System).

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Layout\Row;
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Layout\Col;

$col = new Col(['content' => 'Columna']);
$row = new Row([
    'content' => $col->render()
]);

echo $row->render();
```

## Opciones de Configuración

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `content` | `mixed` | `''` | Contenido (usualmente componentes `Col`). |
| `gutters` | `string` | `null` | Clases para gutters (espaciado), ej. `'g-0'`, `'gx-5'`. |
| `attributes` | `array` | `[]` | Atributos adicionales. |

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::row([
    'content' => 'Col contents...'
]);
```
