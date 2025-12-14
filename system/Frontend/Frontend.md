# Frontend Framework Documentation

## Índice
1. [Introducción](#introducción)
2. [Instalación](#instalación)
3. [Uso Básico](#uso-básico)
4. [Componentes](#componentes)
5. [Ejemplos](#ejemplos)

## Introducción

Frontend Framework es una biblioteca PHP que proporciona una interfaz orientada a objetos para crear interfaces de usuario con Bootstrap 5.3.3. Permite generar HTML semántico y accesible de manera programática.

## Instalación

El framework viene incluido en el sistema Higgs. No requiere instalación adicional.

## Uso Básico

### Inicialización

```php
// Obtener la instancia del Frontend
$frontend = new \Higgs\Frontend\Frontend();

// Obtener el builder de Bootstrap
$bootstrap = $frontend->get_Builder();
```

### Sintaxis Básica

Todos los métodos siguen un patrón similar:
- Primer argumento: contenido principal
- Argumentos opcionales: configuración específica del componente
- Último argumento: array de atributos HTML adicionales

## Componentes

### Alertas

```php
// Alerta básica
$bootstrap->alert('Este es un mensaje importante');

// Alerta con tipo
$bootstrap->alert('Operación exitosa', 'success');

// Alerta descartable
$bootstrap->alert('Puedes cerrar este mensaje', 'info', true);

// Alerta con atributos personalizados
$bootstrap->alert('Mensaje personalizado', 'warning', false, ['id' => 'mi-alerta']);
```

### Tarjetas

```php
// Tarjeta básica
$bootstrap->card('Título', 'Contenido');

// Tarjeta completa
$bootstrap->card(
    'Título de la Tarjeta',
    'Contenido de la tarjeta',
    'Pie de la tarjeta',
    'ruta/imagen.jpg'
);

// Tarjeta horizontal
$bootstrap->horizontalCard(
    'ruta/imagen.jpg',
    'Título',
    'Contenido'
);
```

### Botones

```php
// Botón básico
$bootstrap->button('Clic Aquí');

// Botón con variante
$bootstrap->button('Guardar', 'success');

// Botón con atributos
$bootstrap->button('Enviar', 'primary', ['type' => 'submit']);

// Grupo de botones
$bootstrap->buttonGroup([
    $bootstrap->button('Izquierda'),
    $bootstrap->button('Centro'),
    $bootstrap->button('Derecha')
]);
```

### Sistema de Grid

```php
// Contenedor
$bootstrap->container(
    $bootstrap->row(
        $bootstrap->col('Columna 1', 'col-md-6') .
        $bootstrap->col('Columna 2', 'col-md-6')
    )
);

// Contenedor fluido
$bootstrap->container('Contenido', true);
```

### Navegación

```php
// Barra de navegación básica
$bootstrap->navbar(
    'Mi Sitio',
    [
        ['texto' => 'Inicio', 'url' => '/'],
        ['texto' => 'Acerca', 'url' => '/acerca'],
        ['texto' => 'Contacto', 'url' => '/contacto']
    ]
);

// Migas de pan
$bootstrap->breadcrumb([
    ['texto' => 'Inicio', 'url' => '/'],
    ['texto' => 'Categoría', 'url' => '/categoria'],
    ['texto' => 'Página Actual']
]);
```

### Formularios

```php
// Campo de texto
$bootstrap->formControl('texto', [
    'label' => 'Nombre',
    'placeholder' => 'Ingrese su nombre'
]);

// Grupo de entrada
$bootstrap->inputGroup(
    $bootstrap->formControl('texto'),
    '@',
    'after'
);

// Checkbox
$bootstrap->check('Acepto los términos', 'terminos', true);
```

## Ejemplos

### Página de Login

```php
echo $bootstrap->container(
    $bootstrap->row(
        $bootstrap->col(
            $bootstrap->card(
                'Iniciar Sesión',
                $bootstrap->formControl('email', [
                    'label' => 'Correo Electrónico',
                    'required' => true
                ]) .
                $bootstrap->formControl('password', [
                    'label' => 'Contraseña',
                    'required' => true
                ]) .
                $bootstrap->button('Ingresar', 'primary', ['type' => 'submit']),
                null,
                null,
                ['class' => 'mt-5']
            ),
            'col-md-6 offset-md-3'
        )
    )
);
```

### Panel de Administración

```php
echo $bootstrap->container(
    $bootstrap->row(
        // Barra lateral
        $bootstrap->col(
            $bootstrap->listGroup([
                ['texto' => 'Dashboard', 'url' => '/admin'],
                ['texto' => 'Usuarios', 'url' => '/admin/usuarios'],
                ['texto' => 'Configuración', 'url' => '/admin/config']
            ]),
            'col-md-3'
        ) .
        // Contenido principal
        $bootstrap->col(
            $bootstrap->card(
                'Dashboard',
                $bootstrap->alert('¡Bienvenido al panel de administración!', 'info')
            ),
            'col-md-9'
        )
    )
);
```

### Modal de Factura Expirada

```php
// Crear el modal con mensaje de factura expirada
$modal = $bootstrap->modal(
    // Título del modal
    'Estado de Factura',
    // Contenido del modal
    $bootstrap->alert(
        'Esta factura ya ha expirado. Se está a la espera de su pago.',
        'warning',
        false
    ),
    // Pie del modal con botones
    $bootstrap->buttonGroup([
        $bootstrap->button('Cerrar', 'secondary', ['data-bs-dismiss' => 'modal']),
        $bootstrap->button('Ir a Pagar', 'primary')
    ]),
    // Opciones adicionales
    [
        'id' => 'facturaExpiradaModal',
        'centered' => true,
        'size' => 'md'
    ]
);

// Botón para abrir el modal
echo $bootstrap->button(
    'Ver Estado de Factura', 
    'danger',
    [
        'data-bs-toggle' => 'modal',
        'data-bs-target' => '#facturaExpiradaModal'
    ]
);

// Renderizar el modal
echo $modal;
```

El código anterior generará:
1. Un botón "Ver Estado de Factura" que al hacer clic abrirá el modal
2. Una ventana modal centrada con:
   - Título "Estado de Factura"
   - Mensaje de alerta en formato warning
   - Dos botones: uno para cerrar y otro para proceder al pago

## Notas Importantes

1. **Encadenamiento**: Todos los métodos retornan objetos que implementan `TagInterface`, permitiendo concatenarlos con el operador `.`.

2. **Atributos HTML**: Puedes pasar atributos HTML adicionales como último argumento en forma de array:
```php
['class' => 'mi-clase', 'id' => 'mi-id', 'data-bs-toggle' => 'tooltip']
```

3. **Validación**: El framework valida automáticamente:
   - Variantes de color (primary, secondary, success, etc.)
   - Tamaños (sm, lg, xl)
   - Posiciones (top, bottom, left, right)
   - Breakpoints (sm, md, lg, xl, xxl)

4. **Accesibilidad**: El framework agrega automáticamente:
   - Roles ARIA apropiados
   - Atributos aria-label cuando son necesarios
   - Atributos de navegación por teclado