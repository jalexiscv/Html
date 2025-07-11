<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba Simple - Ejecutor PHP</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        textarea { width: 100%; height: 300px; font-family: monospace; }
        button { padding: 10px 20px; margin: 5px; }
        .output { border: 1px solid #ccc; padding: 15px; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 Ejecutor PHP Simple</h1>
        <p>Versión simplificada para verificar funcionamiento básico</p>
        
        <textarea id="code-editor" placeholder="Escribe tu código PHP aquí..."></textarea>
        <br>
        <button onclick="executeCode()">Ejecutar Código</button>
        <button onclick="clearEditor()">Limpiar</button>
        
        <div id="output" class="output">
            <p><em>Los resultados aparecerán aquí...</em></p>
        </div>
    </div>

    <script>
        // Código PHP predeterminado usando concatenación segura
        const DEFAULT_CODE = "<" + "?php\n// Escribe tu código PHP aquí\necho 'Hola Mundo!';\n?" + ">";
        
        // Inicializar editor
        document.getElementById('code-editor').value = DEFAULT_CODE;
        
        function executeCode() {
            const code = document.getElementById('code-editor').value;
            const output = document.getElementById('output');
            
            if (!code.trim()) {
                output.innerHTML = '<p style="color: orange;">Por favor escribe algo de código.</p>';
                return;
            }
            
            output.innerHTML = '<p>Ejecutando...</p>';
            
            // Crear petición AJAX
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '<?php echo $_SERVER["REQUEST_URI"]; ?>', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        output.innerHTML = xhr.responseText || '<p style="color: gray;">Sin salida</p>';
                    } else {
                        output.innerHTML = '<p style="color: red;">Error en la ejecución</p>';
                    }
                }
            };
            
            xhr.send('code=' + encodeURIComponent(code));
        }
        
        function clearEditor() {
            if (confirm('¿Limpiar el editor?')) {
                document.getElementById('code-editor').value = DEFAULT_CODE;
                document.getElementById('output').innerHTML = '<p><em>Editor limpiado</em></p>';
            }
        }
    </script>
</body>
</html>

<?php
// Procesamiento AJAX del código PHP
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['code'])) {
    $code = $_POST['code'];
    
    if (empty(trim($code))) {
        echo '<p style="color: orange;">Código vacío</p>';
        exit;
    }
    
    ob_start();
    
    try {
        eval('?>' . $code);
    } catch (Exception $e) {
        echo '<p style="color: red;">Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
    }
    
    $output = ob_get_clean();
    echo $output ?: '<p style="color: gray;">Sin salida visible</p>';
    exit;
}
?>
