# Instruction Manager Component - Documentación

## 📋 Descripción

Componente PHP reutilizable que genera un gestor de instrucciones completo (HTML + CSS + JavaScript) para administrar
variables con coordenadas en formato JSON. Ideal para sistemas que necesitan posicionar campos en documentos,
formularios o plantillas.

## 🚀 Características

✅ **Componente PHP autónomo** - Todo el código (HTML, CSS, JS) en una sola función
✅ **Reutilizable** - Úsalo en cualquier formulario con un simple `echo`
✅ **Múltiples instancias** - Puedes tener varios componentes en el mismo formulario
✅ **Variables personalizables** - Define tu propio conjunto de variables
✅ **Datos iniciales** - Carga datos existentes para edición
✅ **Salida JSON** - Formato estándar para almacenamiento en base de datos
✅ **Validaciones incluidas** - Evita duplicados y campos vacíos
✅ **Responsive** - Compatible con Bootstrap 5
✅ **Sin dependencias externas** - Solo requiere Bootstrap 5 y Bootstrap Icons

## 📦 Instalación

1. Descarga el archivo `InstructionManagerComponent.php`
2. Colócalo en tu proyecto PHP
3. Incluye Bootstrap 5 y Bootstrap Icons en tu HTML

```html

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
```

## 🎯 Uso Básico

### 1. Incluir el componente

```php
<?php
require_once 'InstructionManagerComponent.php';
?>
```

### 2. Usar en el formulario

```php
<form method="POST" action="procesar.php">
    <div class="mb-3">
        <label class="form-label">Instrucciones:</label>
        <?php echo instructionManagerComponent('instructions'); ?>
    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
</form>
```

### 3. Recibir los datos

```php
<?php
// En procesar.php
$instructionsJSON = $_POST['instructions'];
$instructions = json_decode($instructionsJSON, true);

// Ahora tienes un array con las instrucciones
foreach ($instructions as $inst) {
    echo "Variable: {$inst['variable']}, X: {$inst['x']}, Y: {$inst['y']}\n";
}
?>
```

## 📘 Sintaxis de la Función

```php
instructionManagerComponent($fieldName, $variables, $initialData)
```

### Parámetros

| Parámetro      | Tipo   | Requerido | Default                                              | Descripción                                      |
|----------------|--------|-----------|------------------------------------------------------|--------------------------------------------------|
| `$fieldName`   | string | No        | 'instructions'                                       | Nombre del campo que se enviará en el formulario |
| `$variables`   | array  | No        | ['FULLNAME', 'IDTYPE', 'IDNUMBER', 'DATE', 'SERIAL'] | Array de variables disponibles                   |
| `$initialData` | array  | No        | null                                                 | Datos iniciales para edición                     |

### Retorno

Retorna una cadena (string) con todo el HTML, CSS y JavaScript del componente.

## 💡 Ejemplos de Uso

### Ejemplo 1: Uso más simple

```php
<?php echo instructionManagerComponent('instructions'); ?>
```

### Ejemplo 2: Con nombre de campo personalizado

```php
<?php echo instructionManagerComponent('positions_data'); ?>
```

### Ejemplo 3: Con variables personalizadas

```php
<?php
$customVars = ['NAME', 'ADDRESS', 'PHONE', 'EMAIL', 'SIGNATURE'];
echo instructionManagerComponent('contact_positions', $customVars);
?>
```

### Ejemplo 4: Con datos iniciales (para edición)

```php
<?php
// Datos recuperados de la base de datos
$existingData = [
    ['variable' => 'FULLNAME', 'x' => 100, 'y' => 200],
    ['variable' => 'DATE', 'x' => 150, 'y' => 250],
    ['variable' => 'SERIAL', 'x' => 200, 'y' => 300]
];

echo instructionManagerComponent('instructions', null, $existingData);
?>
```

### Ejemplo 5: Personalización completa

```php
<?php
$variables = ['TITLE', 'AUTHOR', 'ISBN', 'PUBLISHER', 'DATE'];
$data = [
    ['variable' => 'TITLE', 'x' => 50, 'y' => 100],
    ['variable' => 'ISBN', 'x' => 75, 'y' => 150]
];

echo instructionManagerComponent('book_positions', $variables, $data);
?>
```

### Ejemplo 6: Múltiples componentes en un formulario

```php
<form method="POST">
    <h5>Posiciones del Anverso</h5>
    <?php echo instructionManagerComponent('front_positions'); ?>

    <h5>Posiciones del Reverso</h5>
    <?php echo instructionManagerComponent('back_positions'); ?>

    <h5>Posiciones de Firma</h5>
    <?php
    $signatureVars = ['SIGNATURE', 'DATE', 'STAMP'];
    echo instructionManagerComponent('signature_positions', $signatureVars);
    ?>

    <button type="submit">Guardar Todo</button>
</form>
```

## 💾 Integración con Base de Datos

### Opción 1: Guardar como JSON (Recomendado)

```php
<?php
// Guardar
$sql = "INSERT INTO formatos (nombre, instructions) VALUES (?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$nombre, $_POST['instructions']]);

// Recuperar para editar
$sql = "SELECT * FROM formatos WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$formato = $stmt->fetch();

$instructionsData = json_decode($formato['instructions'], true);
echo instructionManagerComponent('instructions', null, $instructionsData);
?>
```

### Opción 2: Usar columna JSON nativa (MySQL 5.7+)

```sql
CREATE TABLE formatos
(
    id           INT PRIMARY KEY AUTO_INCREMENT,
    nombre       VARCHAR(255),
    instructions JSON
);
```

```php
<?php
// Insertar
$sql = "INSERT INTO formatos (nombre, instructions) VALUES (?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$nombre, $_POST['instructions']]);

// Consultar con JSON
$sql = "SELECT * FROM formatos 
        WHERE JSON_EXTRACT(instructions, '$[*].variable') LIKE '%FULLNAME%'";
?>
```

### Opción 3: Tabla relacionada

```sql
CREATE TABLE formato_instrucciones
(
    id         INT PRIMARY KEY AUTO_INCREMENT,
    formato_id INT,
    variable   VARCHAR(50),
    x          INT,
    y          INT,
    FOREIGN KEY (formato_id) REFERENCES formatos (id)
);
```

```php
<?php
$instructions = json_decode($_POST['instructions'], true);

foreach ($instructions as $inst) {
    $sql = "INSERT INTO formato_instrucciones (formato_id, variable, x, y) 
            VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$formato_id, $inst['variable'], $inst['x'], $inst['y']]);
}
?>
```

## 🎨 Formato del JSON de Salida

```json
[
  {
    "variable": "FULLNAME",
    "x": 100,
    "y": 200
  },
  {
    "variable": "IDNUMBER",
    "x": 150,
    "y": 250
  },
  {
    "variable": "DATE",
    "x": 200,
    "y": 300
  }
]
```

## 🔧 Personalización Avanzada

### Cambiar estilos

El componente genera CSS con clases únicas por instancia. Puedes agregar CSS adicional:

```html

<style>
    .instruction-manager- * .add-instruction-form {
        background-color: #e3f2fd;
    }
</style>
```

### Validaciones personalizadas

Modifica la función `agregarVariable()` dentro del código generado para agregar validaciones personalizadas.

### Eventos personalizados

Puedes acceder a la instancia del componente globalmente:

```javascript
// Cada componente está disponible como window.instructionManager_[ID]
// Ejemplo de uso:
document.getElementById('miBoton').addEventListener('click', function () {
    let manager = window.instructionManager_inst_manager_xxxxx;
    let jsonData = manager.obtenerJSON();
    console.log(jsonData);
});
```

## 🐛 Solución de Problemas

### El componente no aparece

- Verifica que Bootstrap 5 esté cargado
- Asegúrate de incluir el archivo PHP correctamente

### Los datos no se envían

- Verifica que el formulario tenga `method="POST"`
- Revisa el atributo `name` del campo oculto generado

### Estilos rotos

- Asegúrate de cargar Bootstrap Icons
- Verifica que no haya conflictos de CSS

### JavaScript no funciona

- Verifica que Bootstrap JS esté cargado
- Abre la consola del navegador para ver errores

## 📋 Requisitos

- PHP 7.0 o superior
- Bootstrap 5.x
- Bootstrap Icons 1.10+
- Navegador moderno (Chrome, Firefox, Safari, Edge)

## 🤝 Casos de Uso

1. **Sistemas de generación de documentos** - Posicionar campos en plantillas PDF/DOCX
2. **Editores de formularios** - Definir ubicación de campos en formularios visuales
3. **Sistemas de impresión** - Coordenadas para impresión de carnets, certificados
4. **Mapeo de datos** - Asociar variables con posiciones en imágenes/documentos
5. **Sistemas de automatización** - Definir posiciones para bots de llenado de formularios

## 📄 Licencia

Este componente es de código abierto y puede ser utilizado libremente en proyectos personales y comerciales.

## ✨ Créditos

Desarrollado con ❤️ para facilitar la gestión de posiciones de variables en documentos y formularios.

---

**Versión:** 1.0.0
**Última actualización:** Octubre 2025
