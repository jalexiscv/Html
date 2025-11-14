<?php
// Test rápido para verificar que las variantes funcionan
use App\Libraries\Html\Bootstrap\Scores;

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Simular el autoload básico
spl_autoload_register(function ($class) {
    $file = str_replace(['App\\', '\\'], ['app/', '/'], $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Definir constantes necesarias
if (!defined('ICON_STUDENTS')) {
    define('ICON_STUDENTS', 'fas fa-users');
}

try {
    echo "<h2>Test de Variantes de Scores</h2>\n";

    // Test variante DEFAULT
    echo "<h3>Variante DEFAULT:</h3>\n";
    $scoreDefault = new Scores([
        'title' => 'Test Default',
        'value' => '100',
        'variant' => 'default'
    ]);
    echo "<pre>" . htmlspecialchars($scoreDefault->render()) . "</pre>\n";

    // Test variante PRIMARY
    echo "<h3>Variante PRIMARY:</h3>\n";
    $scorePrimary = new Scores([
        'title' => 'Test Primary',
        'value' => '200',
        'variant' => 'primary'
    ]);
    echo "<pre>" . htmlspecialchars($scorePrimary->render()) . "</pre>\n";

    // Test variante SUCCESS
    echo "<h3>Variante SUCCESS:</h3>\n";
    $scoreSuccess = new Scores([
        'title' => 'Test Success',
        'value' => '300',
        'variant' => 'success'
    ]);
    echo "<pre>" . htmlspecialchars($scoreSuccess->render()) . "</pre>\n";

    // Mostrar variantes disponibles
    echo "<h3>Variantes disponibles:</h3>\n";
    echo "<pre>" . implode(', ', Scores::getAvailableVariants()) . "</pre>\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
?>
