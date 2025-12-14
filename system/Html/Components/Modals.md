# Clase Modals - Documentación

La clase `Modals` permite crear y gestionar ventanas modales de Bootstrap 5 de manera sencilla y flexible. Esta clase forma parte de la biblioteca de componentes HTML y sigue los estándares de Bootstrap 5 para la creación de modales.

## Índice
1. [Instalación](#instalación)
2. [Uso Básico](#uso-básico)
3. [Propiedades](#propiedades)
4. [Métodos](#métodos)
5. [Ejemplos](#ejemplos)

## Instalación

La clase `Modals` está disponible en el namespace `App\Libraries\Html`. Para utilizarla, simplemente importa la clase:

```php
use App\Libraries\Html\Modals;
```

## Uso Básico

Para crear una modal básica:

```php
$modal = new Modals([
    'title' => 'Mi Modal',
    'body' => 'Contenido de la modal'
]);

echo $modal;
```

## Propiedades

La clase `Modals` acepta las siguientes propiedades en su constructor:

| Propiedad   | Tipo    | Valor por defecto | Descripción                                    |
|-------------|---------|-------------------|------------------------------------------------|
| id          | string  | modal-[uniqid]    | Identificador único de la modal                |
| title       | string  | ''                | Título que aparece en el encabezado            |
| body        | string  | ''                | Contenido principal de la modal                |
| footer      | string  | ''                | Contenido del pie de la modal                  |
| size        | string  | ''                | Tamaño de la modal (lg, sm, xl)               |
| class       | string  | 'modal fade'      | Clases CSS adicionales                        |
| centered    | boolean | false             | Si la modal debe estar centrada verticalmente  |
| scrollable  | boolean | false             | Si la modal debe tener scroll                  |
| static      | boolean | false             | Si la modal no se cierra al clic fuera        |

## Métodos

### Métodos de Configuración

#### `set_Title($title)`
Establece el título de la modal.
```php
$modal->set_Title('Nuevo Título');
```

#### `set_Body($body)`
Establece el contenido principal de la modal.
```php
$modal->set_Body('Nuevo contenido de la modal');
```

#### `set_Footer($footer)`
Establece el contenido del pie de la modal.
```php
$modal->set_Footer('Contenido del pie');
```

#### `set_Size($size)`
Establece el tamaño de la modal (lg, sm, xl).
```php
$modal->set_Size('lg'); // Modal grande
```

#### `set_Centered($centered)`
Configura si la modal debe estar centrada verticalmente.
```php
$modal->set_Centered(true);
```

#### `set_Scrollable($scrollable)`
Configura si la modal debe tener scroll.
```php
$modal->set_Scrollable(true);
```

#### `set_Static($static)`
Configura si la modal debe ser estática (no se cierra al hacer clic fuera).
```php
$modal->set_Static(true);
```

#### `add_Button($label, $attributes = [])`
Agrega un botón al pie de la modal.
```php
$modal->add_Button('Guardar', [
    'class' => 'btn btn-primary',
    'onclick' => 'saveData()'
]);
```

## Ejemplos

### 1. Modal Básica
```php
$modal = new Modals([
    'title' => 'Modal Básica',
    'body' => '<p>Esta es una modal básica</p>'
]);

echo $modal;
```

### 2. Modal con Botones
```php
$modal = new Modals([
    'title' => 'Confirmar Acción',
    'body' => '¿Está seguro de que desea eliminar este elemento?',
    'size' => 'sm',
    'centered' => true
]);

$modal->add_Button('Cancelar', [
    'class' => 'btn btn-secondary',
    'data-bs-dismiss' => 'modal'
]);

$modal->add_Button('Eliminar', [
    'class' => 'btn btn-danger',
    'onclick' => 'deleteItem()'
]);

echo $modal;
```

### 3. Modal Grande con Scroll
```php
$modal = new Modals([
    'title' => 'Términos y Condiciones',
    'body' => file_get_contents('terms.html'),
    'size' => 'lg',
    'scrollable' => true,
    'static' => true
]);

$modal->add_Button('No Acepto', [
    'class' => 'btn btn-secondary',
    'data-bs-dismiss' => 'modal'
]);

$modal->add_Button('Acepto', [
    'class' => 'btn btn-primary',
    'onclick' => 'acceptTerms()'
]);

echo $modal;
```

### 4. Modal con Formulario
```php
$modal = new Modals([
    'title' => 'Nuevo Usuario',
    'size' => 'lg'
]);

$form = '
<form id="userForm">
    <div class="mb-3">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="name" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" required>
    </div>
</form>';

$modal->set_Body($form);
$modal->add_Button('Cerrar', [
    'class' => 'btn btn-secondary',
    'data-bs-dismiss' => 'modal'
]);
$modal->add_Button('Guardar Usuario', [
    'class' => 'btn btn-primary',
    'onclick' => 'saveUser()'
]);

echo $modal;
```

### 5. Modal con Contenido Dinámico
```php
$modal = new Modals([
    'id' => 'dynamicModal',
    'title' => 'Cargando...',
    'body' => '<div class="text-center"><div class="spinner-border"></div></div>',
    'size' => 'lg',
    'centered' => true
]);

// JavaScript para cargar contenido dinámicamente
$script = '
<script>
function loadModalContent(id) {
    fetch(`/api/items/${id}`)
        .then(response => response.json())
        .then(data => {
            document.querySelector("#dynamicModal .modal-title").textContent = data.title;
            document.querySelector("#dynamicModal .modal-body").innerHTML = data.content;
        });
}
</script>';

echo $modal;
echo $script;
```

## Notas Importantes

1. La clase genera automáticamente un ID único para cada modal si no se especifica uno.
2. Los botones agregados con `add_Button()` se mostrarán en el pie de la modal.
3. Si se especifica tanto `footer` como botones, los botones tendrán prioridad.
4. La modal incluye por defecto un botón de cierre en el encabezado.
5. Para que las modales funcionen correctamente, asegúrate de incluir los archivos CSS y JS de Bootstrap 5.

## Integración con Bootstrap 5

Para usar las modales, asegúrate de incluir Bootstrap 5 en tu proyecto:

```html
<!-- CSS de Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- JS de Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
```

## Activación de la Modal

Para mostrar la modal mediante JavaScript:

```javascript
// Usando el ID de la modal
var myModal = new bootstrap.Modal(document.getElementById('modalId'));
myModal.show();

// O usando jQuery
$('#modalId').modal('show');