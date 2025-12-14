# Alert

## Descripción
La clase `Alert` se utiliza para gestionar alertas en la aplicación. Proporciona métodos para crear, mostrar y ocultar alertas de diferentes tipos.

## Propiedades
- `type`: (string) El tipo de alerta (ej. 'success', 'error', 'warning').
- `message`: (string) El mensaje que se mostrará en la alerta.
- `isVisible`: (boolean) Indica si la alerta está visible.

## Métodos
### `__construct($type, $message)`
Constructor de la clase. Inicializa el tipo y el mensaje de la alerta.

### `show()`
Muestra la alerta en la interfaz de usuario.

### `hide()`
Oculta la alerta.

## Ejemplo de uso
```php
$alert = new Alert('success', 'Operación completada con éxito.');
$alert->show(); 