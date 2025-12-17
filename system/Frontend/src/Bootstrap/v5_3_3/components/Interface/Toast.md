# Componente Toast

Notificaciones emergentes ligeras y personalizables.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface\Toast;

$toast = new Toast([
    'header_title' => 'Notificación',
    'header_text' => 'Justo ahora',
    'content' => 'Has recibido un nuevo mensaje.'
]);

echo $toast->render();
```

## Opciones de Configuración

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `id` | `string` | `uniqid()` | ID único del toast. |
| `header_title` | `string` | `''` | Título principal en la cabecera (izquierda). |
| `header_text` | `string` | `''` | Texto secundario en la cabecera (derecha, ej. tiempo). |
| `content` | `string` | `''` | Cuerpo del mensaje. |
| `img` | `string` | `null` | URL de icono pequeño en la cabecera. |
| `attributes` | `array` | `[]` | Atributos adicionales (ej. para control de posición en JS). |

## Contenedor de Toasts

Para apilar toasts, generalmente necesitas un contenedor posicionado.

```html
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <?php echo $toast->render(); ?>
</div>
```

## Inicialización

Los toasts requieren inicialización manual mediante JavaScript:

```javascript
const toastElList = document.querySelectorAll('.toast')
const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl))
toastList.forEach(toast => toast.show())
```

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::toast([
    'header_title' => 'Titulo',
    'content' => 'Mensaje'
]);
```
