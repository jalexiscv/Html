<?php
// Archivo de depuración para verificar problemas específicos
header('Content-Type: text/html; charset=UTF-8');

// Capturar todos los errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<!DOCTYPE html>";
echo "<html lang='es'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<title>Debug PHP</title>";
echo "</head>";
echo "<body>";
echo "<h1>Estado del Servidor</h1>";

// Verificar versión de PHP
echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";

// Verificar si hay errores de sintaxis en el código JavaScript
echo "<h2>Prueba de Cadenas JavaScript</h2>";
$testCode = "<?php\n// Escribe tu código PHP aquí\n\n?>";
echo "<p><strong>Código de prueba:</strong> " . htmlspecialchars($testCode) . "</p>";

// Verificar configuración de PHP
echo "<h2>Configuración PHP</h2>";
echo "<p><strong>Error Reporting:</strong> " . error_reporting() . "</p>";
echo "<p><strong>Display Errors:</strong> " . ini_get('display_errors') . "</p>";

// Verificar permisos del servidor
echo "<h2>Información del Servidor</h2>";
echo "<p><strong>Servidor:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p><strong>Método:</strong> " . $_SERVER['REQUEST_METHOD'] . "</p>";

// Verificar que la ejecución de eval funciona
echo "<h2>Prueba de Evaluación</h2>";
$testPhp = 'echo "¡Hola Mundo!";';
echo "<p><strong>Código a evaluar:</strong> " . htmlspecialchars($testPhp) . "</p>";
echo "<p><strong>Resultado:</strong> ";
ob_start();
eval($testPhp);
$output = ob_get_clean();
echo htmlspecialchars($output) . "</p>";

echo "</body>";
echo "</html>";
?>
