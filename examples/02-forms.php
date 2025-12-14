<?php

require __DIR__ . '/../vendor/autoload.php';

use Higgs\Html\Html;

echo "<h1>Ejemplo 02: Formularios</h1>";

// Inicio del formulario
$form = Html::tag('form')
    ->attr('method', 'POST')
    ->attr('action', '/submit')
    ->addClass('needs-validation');

// Campo Nombre
$group1 = Html::div(['class' => 'mb-3'])
    ->child(Html::tag('label', ['for' => 'name', 'class' => 'form-label'], 'Nombre Completo'))
    ->child(Html::input('text', 'name', '')->id('name')->addClass('form-control')->required());

// Campo Email
$group2 = Html::div(['class' => 'mb-3'])
    ->child(Html::tag('label', ['for' => 'email', 'class' => 'form-label'], 'Correo Electrónico'))
    ->child(Html::input('email', 'email', '')->id('email')->addClass('form-control'));

// Botón Submit
$submit = Html::button('Enviar Formulario')
    ->attr('type', 'submit')
    ->addClass('btn btn-success');

// Ensamblar formulario
$form->child($group1)
     ->child($group2)
     ->child($submit);

echo $form;
