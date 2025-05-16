<?php

$bootstrap = service("bootstrap");

$project = $model->getProject($oid);

$menu = array(
    array("href" => "/project/", "text" => "PROJECT", "class" => false),
    array("href" => "/project/projects/list/" . lpk(), "text" => lang("Project.Projects"), "class" => "active"),
    array("href" => "/project/projects/view/{$oid}", "text" => "{$project['name']}", "class" => "active"),
);
echo($bootstrap->get_Breadcrumb($menu));
?>