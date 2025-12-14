<?php

$b = service("bootstrap");
$info = $b->get_Alert(array(
    'type' => 'warning',
    'title' => lang('App.Warning'),
    "message" => "El presente componente está siendo actualizado estará disponible a partir de las <b>2:00 p.m. del 24/09/2024</b>. Gracias por su paciencia.  ",
));
echo($info);

?>