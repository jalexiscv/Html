<?php
// Test para verificar la clase Scores
require_once 'app/Config/Autoload.php';

use App\Libraries\Html\Bootstrap\Scores;

// Test básico
echo "<h2>Test 1: Score básico</h2>\n";
try {
    $score1 = new Scores([
        'title' => 'Test Básico',
        'value' => '123'
    ]);
    echo "<pre>" . htmlspecialchars($score1->render()) . "</pre>\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Test con icono (simulando ICON_STUDENTS)
echo "<h2>Test 2: Score con icono</h2>\n";
try {
    $score2 = new Scores([
        'title' => 'Estudiantes activos',
        'value' => '1,250',
        'subtitle' => 'Periodo: 2025B',
        'icon' => 'fas fa-users' // Simulando ICON_STUDENTS
    ]);
    echo "<pre>" . htmlspecialchars($score2->render()) . "</pre>\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Test con icono vacío/undefined
echo "<h2>Test 3: Score con icono undefined</h2>\n";
try {
    $score3 = new Scores([
        'title' => 'Estudiantes activos',
        'value' => '1,250',
        'subtitle' => 'Periodo: 2025B',
        'icon' => null // Simulando ICON_STUDENTS undefined
    ]);
    echo "<pre>" . htmlspecialchars($score3->render()) . "</pre>\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
