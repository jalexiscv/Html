# Componente Alert

El componente `Alert` proporciona mensajes de retroalimentación contextual para acciones típicas del usuario con un puñado de mensajes de alerta disponibles y flexibles.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface\Alert;

$alert = new Alert([
    'content' => '¡Una alerta simple!',
    'type' => 'primary'
]);

echo $alert->render();
```

## Opciones de Configuración

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `content` | `string` | `''` | El contenido o mensaje de la alerta. |
| `type` | `string` | `'primary'` | Define el color/estilo de la alerta. Valores comunes: `primary`, `secondary`, `success`, `danger`, `warning`, `info`, `light`, `dark`. |
| `dismissible` | `bool` | `false` | Si es `true`, añade un botón "X" para cerrar la alerta. |
| `attributes` | `array` | `[]` | Atributos HTML adicionales para el contenedor de la alerta. |

## Ejemplo de Alerta Cerrable (Dismissible)

```php
$alert = new Alert([
    'content' => '<strong>¡Atención!</strong> Debes revisar este campo.',
    'type' => 'warning',
    'dismissible' => true
]);

echo $alert->render();
```

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::alert([
    'content' => 'Alerta desde fachada',
    'type' => 'danger'
]);
```
