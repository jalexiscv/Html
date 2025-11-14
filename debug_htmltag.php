<?php
// Test simple para entender el problema con HtmlTag
use App\Libraries\Html\HtmlTag;

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Simular el autoload básico
spl_autoload_register(function ($class) {
    $file = str_replace(['App\\', '\\'], ['app/', '/'], $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

try {
    // Test 1: String simple
    echo "<h3>Test 1: String simple</h3>\n";
    $tag1 = HtmlTag::tag('div', ['class' => 'test'], 'Contenido simple');
    echo "Resultado: " . htmlspecialchars($tag1->render()) . "\n\n";

    // Test 2: Array de strings
    echo "<h3>Test 2: Array de strings</h3>\n";
    $tag2 = HtmlTag::tag('div', ['class' => 'test'], ['Texto1', ' ', 'Texto2']);
    echo "Resultado: " . htmlspecialchars($tag2->render()) . "\n\n";

    // Test 3: String + objeto (problema actual)
    echo "<h3>Test 3: String + objeto</h3>\n";
    $icon = HtmlTag::tag('i', ['class' => 'fas fa-user']);
    $tag3 = HtmlTag::tag('div', ['class' => 'test'], ['1,250', ' ', $icon]);
    echo "Resultado: " . htmlspecialchars($tag3->render()) . "\n\n";

    // Test 4: Solo objeto
    echo "<h3>Test 4: Solo objeto</h3>\n";
    $icon4 = HtmlTag::tag('i', ['class' => 'fas fa-user']);
    $tag4 = HtmlTag::tag('div', ['class' => 'test'], $icon4);
    echo "Resultado: " . htmlspecialchars($tag4->render()) . "\n\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
?>
