<?php
//[vars]----------------------------------------------------------------------------------------------------------------
$data = $parent->get_Array();
$data['model'] = model("App\Modules\Sie\Models\Sie_Courses");
$data['permissions'] = array('singular' => 'sie-courses-view', "plural" => 'sie-courses-view-all');
$singular = $authentication->has_Permission($data['permissions']['singular']);
$plural = $authentication->has_Permission($data['permissions']['plural']);

$mcourses = model("App\Modules\Sie\Models\Sie_Courses");
$course = $mcourses->where('course', $oid)->first();
$author = (@$course['teacher'] == safe_get_user()) ? true : false;

$authority = ($singular && $author) ? true : false;
$submited = $request->getPost("submited");
$breadcrumb = $component . '\breadcrumb';
$validator = $component . '\validator';
$form = $component . '\form';
$deny = $component . '\deny';
$right = $component . '\right';
//[build]---------------------------------------------------------------------------------------------------------------
if ($plural || $authority) {
    if (!empty($submited)) {
        $json = array(
            'breadcrumb' => view($breadcrumb, $data),
            'main' => view($validator, $data),
            'right' => view($right, $data),
        );
    } else {
        $json = array(
            'breadcrumb' => view($breadcrumb, $data),
            'main' => view($form, $data),
            'right' => view($right, $data),
            //'main_template'=>'c12'
        );
    }
} else {
    $json = array(
        'breadcrumb' => view($breadcrumb, $data),
        'main' => view($deny, $data),
        'right' => view($right, $data),
    );
}
echo(json_encode($json));
?>