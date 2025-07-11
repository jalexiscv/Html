<?php
// Archivo de prueba simple para verificar el funcionamiento básico del servidor
echo "<!DOCTYPE html>";
echo "<html lang='es'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>Prueba de Servidor PHP</title>";
echo "</head>";
echo "<body>";
echo "<h1>✅ Servidor PHP Funcionando Correctamente</h1>";
echo "<p><strong>Versión de PHP:</strong> " . PHP_VERSION . "</p>";
echo "<p><strong>Fecha y hora del servidor:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "<p><strong>Sistema operativo:</strong> " . PHP_OS . "</p>";

// Verificar si las extensiones necesarias están disponibles
echo "<h2>Extensiones PHP:</h2>";
echo "<ul>";
echo "<li>JSON: " . (extension_loaded('json') ? '✅ Disponible' : '❌ No disponible') . "</li>";
echo "<li>cURL: " . (extension_loaded('curl') ? '✅ Disponible' : '❌ No disponible') . "</li>";
echo "<li>OpenSSL: " . (extension_loaded('openssl') ? '✅ Disponible' : '❌ No disponible') . "</li>";
echo "</ul>";

// Probar ejecución de código básico
echo "<h2>Prueba de Ejecución de Código:</h2>";
$test_code = 'echo "¡Hola desde PHP!";';
echo "<p><strong>Código:</strong> <code>" . htmlspecialchars($test_code) . "</code></p>";
echo "<p><strong>Resultado:</strong> ";
ob_start();
eval($test_code);
$output = ob_get_clean();
echo htmlspecialchars($output) . "</p>";

echo "</body>";
echo "</html>";
?>
