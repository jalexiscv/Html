<?php

require_once __DIR__ . '/../autoload.php';

use Higgs\Html\Html;

// 1. Prueba de Macros
Html::macro('alertBox', function(string $message, string $type = 'info') {
    return Html::div(['class' => "alert alert-$type", 'role' => 'alert'], $message);
});

echo "<h2>1. Macros</h2>";
echo Html::alertBox("¡Hola Mundo desde una Macro!", "success");
echo "<hr>";

// 2. Form Helpers Avanzados
echo "<h2>2. Formularios Avanzados</h2>";
echo Html::form(['action' => '/save', 'method' => 'POST'])
    ->addChild(Html::label('email', 'Correo Electrónico'))
    ->addChild(Html::email('user_email', 'juan@example.com', ['class' => 'form-control']))
    
    ->addChild(Html::label('country', 'País'))
    ->addChild(Html::select('country', [
        'CO' => 'Colombia',
        'MX' => 'México',
        'US' => 'Estados Unidos'
    ], 'CO', ['class' => 'form-select']))
    
    ->addChild(Html::div(['class' => 'form-check'], [
        Html::checkbox('subscribe', 1, true, ['class' => 'form-check-input']),
        Html::label('subscribe', 'Suscribirse al boletín')
    ]))
    
    ->addChild(Html::button('Guardar', 'submit', ['class' => 'btn btn-primary']));
echo "<hr>";

// 3. Tablas
echo "<h2>3. Tablas Rápidas</h2>";
$headers = ['ID', 'Nombre', 'Rol'];
$rows = [
    ['1', 'Ana', 'Admin'],
    ['2', 'Carlos', 'Editor'],
    ['3', 'Beatriz', 'User'],
];

echo Html::table($headers, $rows, ['class' => 'table table-striped']);
