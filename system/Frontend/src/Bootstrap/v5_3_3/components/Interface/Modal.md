# Componente Modal

Cuadros de diálogo tradicionales y modales para notificar usuarios o contener formularios personalizados.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface\Modal;
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface\Button;

// Botón disparador
$btn = new Button([
    'content' => 'Abrir Modal',
    'attributes' => [
        'data-bs-toggle' => 'modal',
        'data-bs-target' => '#exampleModal'
    ]
]);

// Modal
$modal = new Modal([
    'id' => 'exampleModal',
    'title' => 'Título del Modal',
    'content' => 'Este es el cuerpo del modal.',
    'footer' => '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>'
]);

echo $btn->render() . $modal->render();
```

## Opciones de Configuración

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `id` | `string` | `uniqid()` | ID único del modal (necesario para el disparador). |
| `title` | `string` | `''` | Título en la cabecera. |
| `content` | `mixed` | `''` | Contenido del cuerpo del modal. |
| `footer` | `mixed` | `null` | Contenido del pie del modal (ej. botones de acción). |
| `size` | `string` | `null` | Tamaño: `'sm'`, `'lg'`, `'xl'`, `'fullscreen'`. |
| `backdrop` | `bool/string` | `true` | `'static'` evita cerrar al clicar fuera. `false` (via atributo) no es estándar directo aquí, usar js options si es necesario. |
| `centered` | `bool` | `false` | Centra el modal verticalmente en la pantalla. |
| `scrollable` | `bool` | `false` | Permite scroll dentro del cuerpo del modal. |
| `fade` | `bool` | `true` | Activa la animación de desvanecimiento. |
| `attributes` | `array` | `[]` | Atributos adicionales para el div `.modal`. |

## Ejemplo Modal Estático y Centrado

```php
$modal = new Modal([
    'id' => 'staticBackdrop',
    'title' => 'Modal Estático',
    'content' => 'No puedes cerrar este modal haciendo clic fuera.',
    'backdrop' => 'static',
    'centered' => true,
    'size' => 'lg'
]);

echo $modal->render();
```

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::modal([
    'title' => 'Titulo',
    'content' => 'Lorem ipsum'
]);
```
