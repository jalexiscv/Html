<?php

require __DIR__ . '/../vendor/autoload.php';

use Higgs\Html\Html;

// Configuración básica (opcional)
// Html::enableXssProtection();

echo "<h1>Ejemplo 01: Uso Básico</h1>";

// 1. Crear un div simple
echo "<h2>Div Simple</h2>";
echo Html::div(['class' => 'container'], 'Hola Mundo desde Higgs HTML');
echo "<hr>";

// 2. Encadenamiento (Fluent Interface)
echo "<h2>Botón Fluido</h2>";
echo Html::button('Haz Clic')
    ->id('btn-principal')
    ->addClass('btn btn-primary')
    ->attr('onclick', 'alert("Click!")');
echo "<hr>";

// 3. Imágenes
echo "<h2>Imagen</h2>";
echo Html::img('https://via.placeholder.com/150', 'Placeholder Image')
    ->addClass('img-fluid thumbnail');
