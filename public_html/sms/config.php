<?php
/**
 * Archivo de configuración
 *
 * Este archivo contiene las configuraciones necesarias para el funcionamiento
 * del sistema de envío de SMS, incluyendo las credenciales de la API de Háblame.
 *
 * @author Cascade
 * @version 1.0
 */

// Si se ha enviado el formulario de configuración
if (isset($_POST['guardar_config']) && isset($_POST['api_key'])) {
    // Guardamos la API key en un archivo seguro
    $configContent = "<?php\n// Archivo generado automáticamente - No editar manualmente\n";
    $configContent .= "\$config = [\n";
    $configContent .= "    'apiKey' => '" . trim($_POST['api_key']) . "',\n";
    $configContent .= "    'from' => " . (empty($_POST['from']) ? 'null' : "'" . trim($_POST['from']) . "'") . ",\n";
    $configContent .= "    'apiUrl' => '" . (isset($_POST['api_url']) ? trim($_POST['api_url']) : 'https://api.hablame.co/sms/envio/') . "'\n";
    $configContent .= "];\n?>";

    // Guardamos el archivo
    file_put_contents('config_secret.php', $configContent);

    // Redirigimos para evitar reenvío del formulario
    header('Location: ' . $_SERVER['PHP_SELF'] . '?config_saved=1');
    exit;
}

// Verificamos si existe el archivo de configuración secreto
if (file_exists('config_secret.php')) {
    // Cargamos la configuración desde el archivo secreto
    require_once 'config_secret.php';
} else {
    // Configuración por defecto si no hay archivo guardado
    $config = [
        // Clave de API para autenticación con Háblame
        'apiKey' => '', // Debe ser reemplazada con una API key real

        // Número remitente (opcional)
        'from' => null,

        // URL de la API
        'apiUrl' => 'https://api.hablame.co/sms/envio/'
    ];

    // Si estamos en un contexto web y no se ha guardado la configuración, mostramos el formulario
    if (php_sapi_name() !== 'cli' && (!isset($_GET['config_saved']) || $_GET['config_saved'] != 1)) {
        echo "<!DOCTYPE html>\n<html lang='es'>\n<head>\n";
        echo "<meta charset='UTF-8'>\n";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>\n";
        echo "<title>Configuración API Háblame</title>\n";
        echo "<style>\n";
        echo "body { font-family: Arial, sans-serif; margin: 20px; }\n";
        echo ".container { max-width: 600px; margin: 0 auto; background-color: #f8f9fa; padding: 20px; border-radius: 5px; }\n";
        echo "h1 { color: #0056b3; }\n";
        echo ".form-group { margin-bottom: 15px; }\n";
        echo "label { display: block; margin-bottom: 5px; font-weight: bold; }\n";
        echo "input[type='text'] { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ddd; border-radius: 4px; }\n";
        echo "button { background-color: #0056b3; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; }\n";
        echo "button:hover { background-color: #003d7a; }\n";
        echo "</style>\n";
        echo "</head>\n<body>\n";
        echo "<div class='container'>\n";
        echo "<h1>Configuración de API Háblame</h1>\n";
        echo "<p>Debes configurar tu API Key de Háblame para poder enviar mensajes SMS.</p>\n";
        echo "<form method='post'>\n";
        echo "<div class='form-group'>\n";
        echo "<label for='api_key'>API Key (requerida):</label>\n";
        echo "<input type='text' id='api_key' name='api_key' placeholder='Ingresa tu API Key de Háblame' required>\n";
        echo "</div>\n";
        echo "<div class='form-group'>\n";
        echo "<label for='from'>Número remitente (opcional):</label>\n";
        echo "<input type='text' id='from' name='from' placeholder='Número remitente (opcional)'>\n";
        echo "</div>\n";
        echo "<button type='submit' name='guardar_config'>Guardar Configuración</button>\n";
        echo "</form>\n";
        echo "</div>\n";
        echo "</body>\n</html>\n";
        exit;
    }
}
?>
