<?php

require_once __DIR__ . '/../autoload.php';

use Higgs\Html\Html;

echo "<h2>1. Clases Condicionales Inteligentes</h2>";

$isActive = true;
$hasError = false;

// Antes: 'class' => 'btn ' . ($isActive ? 'btn-active' : '') . ($hasError ? ' btn-danger' : '')
// Ahora:
$btn = Html::button('Smart Button', 'button', [
    'class' => [
        'btn',
        'btn-primary',
        'active' => $isActive,     // Se agrega porque es true
        'disabled' => $hasError,   // No se agrega porque es false
        'shadow-sm' => true
    ]
]);

echo $btn;
echo "<hr>";

echo "<h2>2. Multimedia (Audio/Video)</h2>";

echo "<h3>Audio</h3>";
echo Html::audio('song.mp3', ['controls' => true]);

echo "<h3>Video con Sources</h3>";
echo Html::video([
    ['src' => 'video.mp4', 'type' => 'video/mp4'],
    ['src' => 'video.webm', 'type' => 'video/webm']
], 'poster.jpg', ['controls' => true, 'width' => 640]);

echo "<hr>";

echo "<h2>3. Tablas Dinámicas</h2>";

$headers = ['ID', 'Nombre', 'Email'];
$rows = [
    ['1', 'Juan Perez', 'juan@example.com'],
    ['2', 'Maria Lopez', 'maria@example.com'],
];

echo Html::table($headers, $rows, ['class' => 'table table-striped', 'border' => '1']);

echo "<hr>";

echo "<h2>4. Macros Personalizados</h2>";

Html::macro('alert', function ($message, $type = 'info') {
    return Html::div(['class' => "alert alert-{$type}", 'role' => 'alert'], $message);
});

echo Html::alert('Este es un mensaje de alerta personalizado!', 'success');
echo "<br><br>";
echo Html::alert('¡Algo salió mal!', 'danger');
