<?php
$main = view("App\Modules\Policies\Views\Privacy\Home\intro");
$right = "";

session()->set('page_template', 'page');
session()->set('main_template', 'c8c4');
session()->set('main', $main);
session()->set('right', $right);

?>