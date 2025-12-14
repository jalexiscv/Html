<?php


$authentication = service('authentication');
$request = service('request');
$authentication = service('authentication');


/* Config */
$d["action"] = null;
$d['permissions'] = array('singular' => false, "plural" => 'nexus-clients-view-all');
$d["module"] = "Nexus";
$d["component"] = "Clients";
$d["namespaced"] = 'App\Modules\Nexus\Views\Clients\List';
$plural = $authentication->has_Permission($d['permissions']['plural']);
$submited = $request->getPost("submited");

if ($plural) {
    $c = view($d["namespaced"] . '\table', $d);
} else {
    $c = view($d["namespaced"] . '\deny', $d);
}

/* Build */
session()->set('page_template', 'page');
session()->set('plugin_tables', true);
session()->set('main_template', 'c9c3');
session()->set('main', $c);
session()->set('right', '');

?>