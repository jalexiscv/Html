<?php
$bootstrap = service('bootstrap');
$info = $bootstrap->get_Alert(array(
    'type' => 'info',
    'title' => lang("App.Note"),
    'message' => sprintf(lang("Cadastre.prints-route-info"), $route, $total, $start, $end),
));
echo($info);
?>