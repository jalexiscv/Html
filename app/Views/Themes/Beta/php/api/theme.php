<?php
/**
 * API endpoint para cambiar el tema desde JavaScript
 * Permite cambiar el tema via AJAX sin recargar la página
 */

// Incluir el gestor de temas
require_once '../ThemeManager.php';

// Configurar headers para API JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Manejar preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

/**
 * Respuesta de error
 */
function sendError($message, $code = 400)
{
    http_response_code($code);
    echo json_encode([
        'success' => false,
        'error' => $message
    ]);
    exit();
}

/**
 * Respuesta de éxito
 */
function sendSuccess($data = [])
{
    echo json_encode([
        'success' => true,
        'data' => $data
    ]);
    exit();
}

// Manejar diferentes métodos HTTP
switch ($_SERVER['REQUEST_METHOD']) {

    case 'GET':
        // Obtener información del tema actual
        try {
            $themeInfo = ThemeManager::getThemeInfo();
            sendSuccess($themeInfo);
        } catch (Exception $e) {
            sendError('Error al obtener información del tema: ' . $e->getMessage(), 500);
        }
        break;

    case 'POST':
        // Cambiar tema
        try {
            // Obtener datos del POST
            $input = json_decode(file_get_contents('php://input'), true);

            if (!$input || !isset($input['theme'])) {
                sendError('Tema no especificado');
            }

            $newTheme = $input['theme'];

            // Validar y establecer tema
            if (ThemeManager::setTheme($newTheme)) {
                $themeInfo = ThemeManager::getThemeInfo();
                sendSuccess([
                    'message' => 'Tema cambiado exitosamente',
                    'theme' => $themeInfo
                ]);
            } else {
                sendError('Tema inválido: ' . $newTheme);
            }

        } catch (Exception $e) {
            sendError('Error al cambiar tema: ' . $e->getMessage(), 500);
        }
        break;

    default:
        sendError('Método no permitido', 405);
        break;
}
?>
