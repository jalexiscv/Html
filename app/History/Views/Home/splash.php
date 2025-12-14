<?php
$c = "La solución de un software <b>ERP</b> en la nube, ideal para que los organismos y entidades de los órdenes nacional y
                territorial de la Rama Ejecutiva del Poder Público y Entidades descentralizadas con capital público en que el Estado posea más del 90%
                de capital social,
                obtengan una rápida implementación que integre sus procesos y se adapte a los requerimientos de <b>mipg</b>.";
$card = service("smarty");
$card->set_Mode("bs5x");
$card->caching = 0;
$card->assign("type", "normal");
$card->assign("class", "mb-3");
$card->assign("header", "Bienvenid@");
$card->assign("image", "/themes/assets/images/logos/modulo-history.png");
$card->assign("body", false);
$card->assign("text", $c);
$card->assign("footer", false);
echo($card->view('components/cards/index.tpl'));
?>