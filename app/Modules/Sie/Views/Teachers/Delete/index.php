<?php
//[models]--------------------------------------------------------------------------------------------------------------
$mcourses = model('App\Modules\Sie\Models\Sie_Courses');
//[vars]----------------------------------------------------------------------------------------------------------------
$data = $parent->get_Array();
$data['model'] = model("App\Modules\Security\Models\Security_Users");
$data['permissions'] = array('singular' => 'security-users-delete', "plural" => 'security-users-delete-all');
$singular = $authentication->has_Permission($data['permissions']['singular']);
$plural = $authentication->has_Permission($data['permissions']['plural']);
$author = $data['model']->get_Authority($oid, safe_get_user());
$authority = ($singular && $author) ? true : false;
$submited = $request->getPost("submited");
$breadcrumb = $component . '\breadcrumb';
$validator = $component . '\validator';
$form = $component . '\form';
$deny = $component . '\deny';
$courses = $component . '\courses';

$count_courses = $mcourses->get_TotalByTeacher($oid);

//[build]---------------------------------------------------------------------------------------------------------------
if ($plural || $authority) {
    if (!empty($submited)) {
        $json = array(
            'breadcrumb' => view($breadcrumb, $data),
            'main' => view($validator, $data),
            'right' => ""
        );
    } else {
        if ($count_courses > 0) {
            $json = array(
                'breadcrumb' => view($breadcrumb, $data),
                'main' => view($courses, $data),
                'right' => ""
            );
        } else {
            $json = array(
                'breadcrumb' => view($breadcrumb, $data),
                'main' => view($form, $data),
                'right' => ""
            );
        }
    }
} else {
    $json = array(
        'breadcrumb' => view($breadcrumb, $data),
        'main' => view($deny, $data),
        'right' => ""
    );
}
echo(json_encode($json));
?>