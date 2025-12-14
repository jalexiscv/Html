<?php
//header("Content-Type: application/json; charset=UTF-8");
$data = array(
    "view" => $view,
    "id" => isset($id) ? $id : false
);
switch ($view) {
    //case "acredit-macroprocesses-list": $c=view("App\Modules\Disa\Views\Settings\Macroprocesses\List\ajax", $data);break;
    //case "acredit-processes-list": $c=view("App\Modules\Disa\Views\Settings\Processes\List\ajax", $data);break;
    case "acredit-applicants-types-list":
        $c = view("App\Modules\Policies\Views\Applicants\Types\List\ajax", $data);
        break;
    default:
        $c = view("App\Modules\Security\Views\E404\ajax", $data);
        break;
}
echo($c);
?>