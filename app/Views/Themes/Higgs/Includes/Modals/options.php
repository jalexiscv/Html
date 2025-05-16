<?php

$code = "";
$code .= "<div class=\"modal fade\" id=\"higgs-options-modal\" tabindex=\"-1\" aria-labelledby=\"optionsModalLabel\" aria-hidden=\"true\">\n";
$code .= "\t\t<div class=\"modal-dialog modal-dialog-centered\">\n";
$code .= "\t\t\t\t<div class=\"modal-content\">\n";
$code .= "\t\t\t\t\t\t<div class=\"modal-header\">\n";
$code .= "\t\t\t\t\t\t\t\t<h5 class=\"modal-title\" id=\"optionsModalLabel\">Opciones de Usuario</h5>\n";
$code .= "\t\t\t\t\t\t\t\t<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>\n";
$code .= "\t\t\t\t\t\t</div>\n";
$code .= "\t\t\t\t\t\t<div class=\"modal-body\">\n";
$code .= "\t\t\t\t\t\t\t\t<ul class=\"options-list\">\n";
$code .= "\t\t\t\t\t\t\t\t\t\t<li id=\"viewProfile\">\n";
$code .= "\t\t\t\t\t\t\t\t\t\t\t\t<a href=\"/users/me/view/" . lpk() . "\"><i class=\"fa-light fa-user\"></i>Perfil de Usuario \n</a>";
$code .= "\t\t\t\t\t\t\t\t\t\t</li>\n";

$code .= "\t\t\t\t\t\t\t\t\t\t<li id=\"settings\">\n";
$code .= "\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"fa-light fa-gear\"></i> Configuraciones\n";
$code .= "\t\t\t\t\t\t\t\t\t\t</li>\n";

$code .= "\t\t\t\t\t\t\t\t\t\t<li id=\"logout\" class=\"text-danger\">\n";
$code .= "\t\t\t\t\t\t\t\t\t\t\t\t<a class=\"dropdown-item\" href=\"/security/session/logout/" . lpk() . "\"><i class=\"fa-light fa-sign-out-alt\"></i>" . (Lang("App.Logout")) . "</a>";
$code .= "\t\t\t\t\t\t\t\t\t\t</li>\n";
$code .= "\t\t\t\t\t\t\t\t</ul>\n";
$code .= "\t\t\t\t\t\t</div>\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t</div>\n";
$code .= "</div>\n";
echo($code);
?>