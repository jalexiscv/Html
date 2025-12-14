<?php
/**
 * Implementación del método get_BtnGroupVertical para la clase Bootstrap
 *
 * Este método crea un grupo de botones vertical utilizando Bootstrap.
 * Los botones se apilan verticalmente uno encima del otro.
 */

/**
 * Crea un grupo de botones vertical utilizando Bootstrap.
 * Los botones se apilan verticalmente uno encima del otro.
 *
 * @param string $id Identificador único del grupo de botones
 * @param array $attributes Atributos de configuración:
 *   - string 'class': Clases CSS adicionales (por defecto: 'btn-group-vertical')
 *   - string 'content': Contenido HTML de los botones
 *   - string 'aria-label': Etiqueta ARIA para accesibilidad
 *   - array 'buttons': Array de botones a generar automáticamente
 *
 * @return string HTML del grupo de botones vertical
 *
 * @example
 * // Uso básico con contenido manual
 * $btnGroup = Bootstrap::get_BtnGroupVertical('my-group', [
 *     'content' => '<button class="btn btn-primary">Botón 1</button><button class="btn btn-secondary">Botón 2</button>'
 * ]);
 *
 * // Uso con generación automática de botones
 * $btnGroup = Bootstrap::get_BtnGroupVertical('my-group', [
 *     'buttons' => [
 *         ['text' => 'Guardar', 'class' => 'btn-primary', 'onclick' => 'save()', 'icon' => 'fas fa-save'],
 *         ['text' => 'Cancelar', 'class' => 'btn-secondary', 'onclick' => 'cancel()', 'icon' => 'fas fa-times'],
 *         ['text' => 'Eliminar', 'class' => 'btn-danger', 'onclick' => 'delete()', 'icon' => 'fas fa-trash']
 *     ]
 * ]);
 */
function get_BtnGroupVertical($id, $attributes = array())
{
    // Función auxiliar para obtener atributos (simula self::_get_Attribute)
    function _get_Attribute($name, $attributes, $default = false)
    {
        if (is_array($attributes)) {
            if (isset($attributes[$name])) {
                return ($attributes[$name]);
            } else {
                return ($default);
            }
        } else {
            return ($default);
        }
    }

    $class = _get_Attribute("class", $attributes, 'btn-group-vertical');
    $content = _get_Attribute("content", $attributes, '');
    $ariaLabel = _get_Attribute("aria-label", $attributes, 'Grupo de botones vertical');
    $buttons = _get_Attribute("buttons", $attributes, []);

    // Si se proporcionan botones como array, generarlos automáticamente
    if (!empty($buttons) && is_array($buttons)) {
        $buttonElements = [];
        foreach ($buttons as $index => $button) {
            $btnId = $id . '-btn-' . $index;
            $btnText = $button['text'] ?? 'Botón';
            $btnClass = 'btn ' . ($button['class'] ?? 'btn-secondary');
            $btnOnclick = $button['onclick'] ?? '';
            $btnType = $button['type'] ?? 'button';
            $btnDisabled = ($button['disabled'] ?? false) ? ' disabled' : '';
            $btnIcon = $button['icon'] ?? '';

            // Construir contenido del botón con icono opcional
            $btnContent = '';
            if (!empty($btnIcon)) {
                $btnContent .= "<i class=\"{$btnIcon}\"></i> ";
            }
            $btnContent .= $btnText;

            // Crear botón individual
            $buttonHtml = "<button id=\"{$btnId}\" type=\"{$btnType}\" class=\"{$btnClass}\"";
            if (!empty($btnOnclick)) {
                $buttonHtml .= " onclick=\"{$btnOnclick}\"";
            }
            if (!empty($btnDisabled)) {
                $buttonHtml .= $btnDisabled;
            }
            $buttonHtml .= ">{$btnContent}</button>";

            $buttonElements[] = $buttonHtml;
        }
        $content = implode('', $buttonElements);
    }

    // Crear el grupo de botones vertical
    $groupHtml = "<div id=\"{$id}\" class=\"{$class}\" role=\"group\" aria-label=\"{$ariaLabel}\">";
    $groupHtml .= $content;
    $groupHtml .= "</div>";

    return $groupHtml;
}

// Ejemplos de uso:
echo "<h2>Ejemplo 1: Grupo de botones vertical básico</h2>\n";
$example1 = get_BtnGroupVertical('example1', [
        'content' => '<button class="btn btn-primary">Primero</button><button class="btn btn-secondary">Segundo</button><button class="btn btn-success">Tercero</button>'
]);
echo $example1;

echo "\n\n<h2>Ejemplo 2: Grupo de botones vertical con generación automática</h2>\n";
$example2 = get_BtnGroupVertical('example2', [
        'buttons' => [
                ['text' => 'Guardar', 'class' => 'btn-primary', 'onclick' => 'save()', 'icon' => 'fas fa-save'],
                ['text' => 'Editar', 'class' => 'btn-warning', 'onclick' => 'edit()', 'icon' => 'fas fa-edit'],
                ['text' => 'Eliminar', 'class' => 'btn-danger', 'onclick' => 'delete()', 'icon' => 'fas fa-trash'],
                ['text' => 'Cancelar', 'class' => 'btn-secondary', 'onclick' => 'cancel()', 'disabled' => false]
        ]
]);
echo $example2;

echo "\n\n<h2>Ejemplo 3: Grupo de botones vertical con clase personalizada</h2>\n";
$example3 = get_BtnGroupVertical('example3', [
        'class' => 'btn-group-vertical shadow',
        'aria-label' => 'Acciones de usuario',
        'buttons' => [
                ['text' => 'Perfil', 'class' => 'btn-outline-primary', 'icon' => 'fas fa-user'],
                ['text' => 'Configuración', 'class' => 'btn-outline-secondary', 'icon' => 'fas fa-cog'],
                ['text' => 'Cerrar Sesión', 'class' => 'btn-outline-danger', 'icon' => 'fas fa-sign-out-alt']
        ]
]);
echo $example3;

?>

<!-- HTML para visualizar los ejemplos -->
<!DOCTYPE html>
<html>
<head>
    <title>Ejemplo get_BtnGroupVertical</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1>Ejemplos de get_BtnGroupVertical</h1>

    <div class="row">
        <div class="col-md-4">
            <h3>Ejemplo 1: Básico</h3>
            <?= $example1 ?>
        </div>

        <div class="col-md-4">
            <h3>Ejemplo 2: Con iconos</h3>
            <?= $example2 ?>
        </div>

        <div class="col-md-4">
            <h3>Ejemplo 3: Personalizado</h3>
            <?= $example3 ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function save() {
        alert('Guardar clickeado');
    }

    function edit() {
        alert('Editar clickeado');
    }

    function

    delete ()
    {
        alert('Eliminar clickeado');
    }

    function cancel() {
        alert('Cancelar clickeado');
    }
</script>
</body>
</html>
