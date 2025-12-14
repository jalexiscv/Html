<?php
$msettings = model("App\Modules\Security\Models\Security_Settings");
//[Vars]----------------------------------------------------------------------------------------------------------------
$data = $parent->get_Array();
$submited = $request->getPost("submited");
$breadcrumb = $component . '\breadcrumb';
$validator = $component . '\validator';
$form = $component . '\form';
$disabled = $component . '\disabled';
//[Build]---------------------------------------------------------------------------------------------------------------
$right = "";
$autoregister = $msettings->get_Value("autoregister");
//[build]---------------------------------------------------------------------------------------------------------------
if ($autoregister == "true") {
    if (!empty($submited)) {
        $json = array(
            'main_template' => 'c0',
            'breadcrumb' => view($breadcrumb, $data),
            'main' => view($validator, $data),
            'right' => $right
        );
    } else {
        $json = array(
            'main_template' => 'c0',
            'breadcrumb' => view($breadcrumb, $data),
            'main' => view($form, $data),
            'right' => $right
        );
    }
} else {
    $json = array(
        'main_template' => 'c0',
        'breadcrumb' => view($breadcrumb, $data),
        'main' => view($disabled, $data),
        'right' => $right
    );
}
echo(json_encode($json));
?>