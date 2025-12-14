# Componente ProgressBar de Bootstrap

La clase `ProgressBar` te permite generar fácilmente barras de progreso de Bootstrap dentro de tu aplicación PHP.

## Uso Básico

Para usar la clase `ProgressBar`, primero necesitas crear una instancia de ella. Puedes pasar un array de atributos al
constructor para personalizar su apariencia y comportamiento.

```php
use App\Libraries\Html\Bootstrap\ProgressBar;

// Crear una barra de progreso básica con valores por defecto (0-100, valor actual 0)
$progressBar = new ProgressBar(['value' => 50]);
echo $progressBar; // o echo $progressBar->render();
```

Esto generará el siguiente HTML:

```html
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
</div>
```

## Atributos del Constructor

El constructor acepta un array asociativo de atributos:

* `value` (int): El valor actual de la barra de progreso. Por defecto es `0`.
* `min` (int): El valor mínimo de la barra de progreso. Por defecto es `0`.
* `max` (int): El valor máximo de la barra de progreso. Por defecto es `100`.
* `label` (string|null): Texto personalizado para mostrar en la barra de progreso. Si es `null`, mostrará el valor
  actual como porcentaje (ej., "50%").
* `class` (string): Clases CSS adicionales para aplicar al div interno `progress-bar`. Esto se puede usar para las
  utilidades de color de fondo de Bootstrap (ej., `bg-success`, `bg-info`, `bg-warning`, `bg-danger`). Por defecto es
  una cadena vacía.
* `striped` (bool): Si es `true`, aplica un efecto de rayas a la barra de progreso. Por defecto es `false`.
* `animated` (bool): Si es `true`, anima las rayas (requiere que `striped` también sea `true`). Por defecto es `false`.

## Ejemplos

### Estableciendo Valores Mínimos y Máximos

```php
use App\Libraries\Html\Bootstrap\ProgressBar;

$progressBar = new ProgressBar([
    'value' => 75,
    'min' => 0,
    'max' => 200
]);
echo $progressBar;
```

Salida:

```html
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: 37.5%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="200">75%</div>
</div>
```

### Etiqueta Personalizada

```php
use App\Libraries\Html\Bootstrap\ProgressBar;

$progressBar = new ProgressBar([
    'value' => 25,
    'label' => 'Cargando...'
]);
echo $progressBar;
```

Salida:

```html
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">Cargando...</div>
</div>
```

### Color de Fondo

Puedes usar las clases de utilidad de fondo de Bootstrap para cambiar el color de la barra de progreso.

```php
use App\Libraries\Html\Bootstrap\ProgressBar;

// Barra de progreso verde
$successBar = new ProgressBar([
    'value' => 70,
    'class' => 'bg-success'
]);
echo $successBar;

// Barra de progreso roja
$dangerBar = new ProgressBar([
    'value' => 30,
    'class' => 'bg-danger',
    'label' => 'Error'
]);
echo $dangerBar;
```

Salida (Success):

```html
<div class="progress">
  <div class="progress-bar bg-success" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">70%</div>
</div>
```

Salida (Danger):

```html
<div class="progress">
  <div class="progress-bar bg-danger" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">Error</div>
</div>
```

### Barra de Progreso con Rayas

```php
use App\Libraries\Html\Bootstrap\ProgressBar;

$stripedBar = new ProgressBar([
    'value' => 60,
    'class' => 'bg-info',
    'striped' => true
]);
echo $stripedBar;
```

Salida:

```html
<div class="progress">
  <div class="progress-bar bg-info progress-bar-striped" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">60%</div>
</div>
```

### Barra de Progreso Animada con Rayas

```php
use App\Libraries\Html\Bootstrap\ProgressBar;

$animatedBar = new ProgressBar([
    'value' => 85,
    'class' => 'bg-warning',
    'striped' => true,
    'animated' => true,
    'label' => 'Procesando...'
]);
echo $animatedBar;
```

Salida:

```html
<div class="progress">
  <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" role="progressbar" style="width: 85%;" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">Procesando...</div>
</div>
```

## Renderización

El objeto `ProgressBar` puede ser impreso directamente con `echo` o puedes llamar a su método `render()` para obtener la
cadena HTML.

```php
$progressBar = new ProgressBar(['value' => 50]);

// Ambos son equivalentes:
echo $progressBar;
// echo $progressBar->render();
```