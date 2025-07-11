<?php

//Herencia
//Polimorfismo

require_once 'Libraries/Products.php';
require_once 'Libraries/Lacteos.php';

$hijo0 = new Products();
$hijo1 = new Products();
$hijo2 = new Products();
$hijo3 = new Products();
$hijo4 = new Products();

$leche = new Lacteos();
$leche->get_Products('Lacteos');
$leche->get_Color('Blanco');
$leche->evolucionado();


?>