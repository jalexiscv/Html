<?php
//header("Content-Type: application/json; charset=UTF-8");
$data = array(
    "view" => $view,
    "id" => isset($id) ? $id : false
);
switch ($view) {
    case "facebook-tickets-list":
        $c = view("App\Modules\Concerts\Views\Tickets\List\ajax", $data);
        break;
    case "disa-processes-list":
        $c = view("App\Modules\Disa\Views\Settings\Processes\List\ajax", $data);
        break;
    default:
        $c = view("App\Modules\Security\Views\E404\ajax", $data);
        break;
}
echo($c);
?>