<?php

require_once __DIR__ . '/../autoload.php';

use Higgs\Html\Html;

echo Html::h1('Prueba Final: Cobertura HTML5 Completa');

echo Html::section([], [
    Html::h2('1. Estructura de Formularios'),
    Html::form([], [
        Html::fieldset(['style' => 'border: 1px solid #ccc; padding: 10px;'], [
            Html::legend('Información Personal', ['style' => 'font-weight: bold;']),
            Html::label('name', 'Nombre:'),
            Html::text('name'),
            Html::br(),
            Html::label('country', 'País:'),
            Html::select('country', [
                'Norteamérica' => [
                    'US' => 'Estados Unidos',
                    'CA' => 'Canadá'
                ],
                'Sudamérica' => [
                    'CO' => 'Colombia',
                    'BR' => 'Brasil'
                ]
            ], 'CO', ['class' => 'form-select'])
        ]),
    ])
]);

echo Html::hr();

echo Html::section([], [
    Html::h2('2. Figuras con Leyenda'),
    Html::figure(['class' => 'figure'], [
        Html::img('chart.png', 'Un gráfico de pastel', ['class' => 'figure-img']),
        Html::figcaption('Fig 1. Resultados de ventas', ['class' => 'figure-caption'])
    ])
]);

echo Html::hr();

echo Html::section([], [
    Html::h2('3. Elementos Embebidos y Gráficos'),
    Html::h3('Iframe'),
    Html::iframe('https://example.com', ['width' => '300', 'height' => '200']),

    Html::h3('Canvas'),
    Html::canvas(['id' => 'myCanvas', 'width' => '200', 'height' => '100', 'style' => 'border:1px solid #000000;']),

    Html::h3('Indicadores'),
    Html::label('prog', 'Descarga: '),
    Html::progress(70, 100, ['id' => 'prog']),
    Html::br(),
    Html::label('met', 'Uso de disco: '),
    Html::meter(0.6, ['min' => 0, 'max' => 1, 'low' => 0.25, 'high' => 0.75])
]);

echo Html::hr();

echo Html::section([], [
    Html::h2('4. Estilos Inline'),
    Html::style('.custom-class { color: blue; font-weight: bold; }'),
    Html::p(['class' => 'custom-class'], 'Este párrafo debe ser azul y negrita gracias a la etiqueta <style>.')
]);

echo "<br><br>Verificación final completada.";
