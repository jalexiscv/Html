<?php

require_once __DIR__ . '/../autoload.php';

use Higgs\Html\Html;

echo Html::h1('Prueba de Etiquetas Semánticas');

echo Html::header([
    'class' => 'site-header',
    'style' => 'background: #f0f0f0; padding: 20px;'
], Html::h2('Encabezado del Sitio') . Html::nav([], Html::a('#', 'Inicio') . ' | ' . Html::a('#', 'Acerca')));

echo Html::main(['class' => 'container'], [
    Html::section(['id' => 'intro'], [
        Html::h3('Introducción'),
        Html::p([], 'Este es un párrafo dentro de una sección.'),
        Html::p(['class' => 'lead'], Html::strong('Texto en negrita') . ' y ' . Html::em('texto enfatizado') . '.')
    ]),
    Html::hr(),
    Html::article(['class' => 'post'], [
        Html::header([], Html::h4('Título del Artículo')),
        Html::p([], 'Contenido del artículo...'),
        Html::blockquote('Cita importante.', ['class' => 'blockquote']),
        Html::footer([], Html::small('Publicado por Admin'))
    ]),
    Html::aside(['class' => 'sidebar'], [
        Html::h5('Barra Lateral'),
        Html::p([], 'Enlaces relacionados...')
    ])
]);

echo Html::footer(
    ['class' => 'site-footer', 'style' => 'margin-top: 20px; border-top: 1px solid #ccc;'],
    Html::p([], '&copy; 2025 Higgs HTML. ' . Html::code('v1.2.0'))
);

echo "<br><br>Verificación completada.";
