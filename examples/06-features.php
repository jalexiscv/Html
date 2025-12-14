<?php

require_once __DIR__ . '/../autoload.php';

use Higgs\Html\Html;

echo Html::h1('Prueba de Características Extendidas');

echo Html::section([], [
    Html::h2('1. Nuevos Inputs HTML5'),
    Html::form(['action' => '#', 'method' => 'post', 'enctype' => 'multipart/form-data'], [
        Html::div(['class' => 'form-group'], [
            Html::label('file', 'Subir Archivo:'),
            Html::file('documento', ['class' => 'form-control', 'accept' => '.pdf'])
        ]),
        Html::div(['class' => 'form-group'], [
            Html::label('date', 'Fecha de Evento:'),
            Html::date('fecha', '2025-12-31', ['class' => 'form-control'])
        ]),
        Html::div(['class' => 'form-group'], [
            Html::label('range', 'Nivel de Volumen (0-100):'),
            Html::range('volumen', 50, ['min' => 0, 'max' => 100])
        ]),
        Html::div(['class' => 'form-group'], [
            Html::label('color', 'Color Favorito:'),
            Html::color('color_fav', '#ff0000')
        ]),
    ])
]);

echo Html::hr();

echo Html::section([], [
    Html::h2('2. Listas de Definición'),
    Html::dl(['class' => 'row'], [
        Html::dt('HTML', ['class' => 'col-sm-3']),
        Html::dd('HyperText Markup Language', ['class' => 'col-sm-9']),

        Html::dt('PHP', ['class' => 'col-sm-3']),
        Html::dd(['Hypertext Preprocessor', 'Lenguaje de script del lado del servidor'], ['class' => 'col-sm-9'])
    ])
]);

echo Html::hr();

echo Html::section([], [
    Html::h2('3. Elementos Interactivos'),
    Html::details(['open' => true], [
        Html::summary('Más información (Click para colapsar)'),
        Html::p([], 'Este contenido es visible por defecto porque el atributo open es true.')
    ]),

    Html::dialog(['id' => 'myDialog', 'open' => true, 'style' => 'border: 1px solid red; padding: 10px;'], [
        Html::p([], 'Soy una ventana de diálogo (modal nativo).'),
        Html::form(['method' => 'dialog'], Html::button('Cerrar'))
    ])
]);

echo Html::hr();

echo Html::section([], [
    Html::h2('4. Meta Helpers (Solo visualización de código)'),
    Html::code(Html::favicon('/favicon.ico')),
    Html::br(),
    Html::code(Html::viewport())
]);

echo "<br><br>Verificación de features extendidas completada.";
