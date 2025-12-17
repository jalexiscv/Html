# Componente Select

Listas desplegables nativas personalizadas.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Form\Select;

$select = new Select([
    'name' => 'pais',
    'label' => 'Selecciona un país',
    'options_list' => [
        'es' => 'España',
        'mx' => 'México',
        'ar' => 'Argentina'
    ],
    'selected' => 'mx'
]);

echo $select->render();
```

## Opciones de Configuración

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `name` | `string` | `''` | Nombre del campo. |
| `options_list` | `array` | `[]` | Lista de opciones. Formato simple `['valor' => 'Texto']` o detallado (ver abajo). |
| `selected` | `mixed` | `null` | Valor de la opción seleccionada. |
| `label` | `string` | `null` | Etiqueta del campo. |
| `floating` | `bool` | `false` | Estilo Floating Label. |
| `attributes` | `array` | `[]` | Atributos adicionales (ej. `multiple`, `size`). |

### Formato Detallado de Opciones

```php
'options_list' => [
    ['value' => '1', 'text' => 'Opción 1'],
    ['value' => '2', 'text' => 'Opción 2']
]
```

## Ejemplo Floating Select

```php
$select = new Select([
    'name' => 'rol',
    'label' => 'Rol de Usuario',
    'floating' => true,
    'options_list' => [
        'admin' => 'Administrador',
        'editor' => 'Editor',
        'user' => 'Usuario'
    ]
]);

echo $select->render();
```

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::select([
    'name' => 'role',
    'options_list' => ['admin' => 'Admin']
]);
```
