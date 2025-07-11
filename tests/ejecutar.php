<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Solo permitir método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

// Obtener el código desde el POST
$input = json_decode(file_get_contents('php://input'), true);
$codigo = $input['codigo'] ?? '';

if (empty($codigo)) {
    echo json_encode(['error' => 'No se proporcionó código para ejecutar']);
    exit;
}

// Funciones de seguridad
function esFuncionPeligrosa($codigo) {
    $funcionesPeligrosas = [
        'exec', 'system', 'shell_exec', 'passthru', 'eval',
        'file_get_contents', 'file_put_contents', 'fopen', 'fwrite',
        'include', 'require', 'include_once', 'require_once',
        'unlink', 'rmdir', 'mkdir', 'chmod', 'chown',
        'mysql_connect', 'mysqli_connect', 'pg_connect',
        'curl_exec', 'curl_init', 'fsockopen', 'socket_create',
        'mail', 'header', 'setcookie', 'session_start'
    ];
    
    foreach ($funcionesPeligrosas as $funcion) {
        if (stripos($codigo, $funcion) !== false) {
            return $funcion;
        }
    }
    return false;
}

// Verificar funciones peligrosas
$funcionPeligrosa = esFuncionPeligrosa($codigo);
if ($funcionPeligrosa) {
    echo json_encode([
        'error' => "Función no permitida por seguridad: $funcionPeligrosa",
        'output' => ''
    ]);
    exit;
}

// Configurar límites de tiempo y memoria
ini_set('max_execution_time', 5); // 5 segundos máximo
ini_set('memory_limit', '16M'); // 16MB máximo

// Capturar la salida
ob_start();
$error = '';

try {
    // Configurar manejo de errores
    set_error_handler(function($severity, $message, $file, $line) {
        throw new ErrorException($message, 0, $severity, $file, $line);
    });
    
    // Ejecutar el código de forma segura
    eval('?>' . $codigo);
    
} catch (ParseError $e) {
    $error = "Error de sintaxis: " . $e->getMessage();
} catch (ErrorException $e) {
    $error = "Error: " . $e->getMessage();
} catch (Exception $e) {
    $error = "Excepción: " . $e->getMessage();
} catch (Error $e) {
    $error = "Error fatal: " . $e->getMessage();
} finally {
    restore_error_handler();
}

$output = ob_get_clean();

// Si no hay salida y no hay error, mostrar mensaje
if (empty($output) && empty($error)) {
    $output = "El código se ejecutó correctamente pero no produjo salida visible.";
}

// Respuesta JSON
echo json_encode([
    'success' => empty($error),
    'output' => $output,
    'error' => $error
]);
?>