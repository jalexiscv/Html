<?php
//[Vars]----------------------------------------------------------------------------------------------------------------
$data = $parent->get_Array();
$data['permissions'] = array('singular' => 'c4isr-cases-view', "plural" => false);
$singular = $authentication->has_Permission($data['permissions']['singular']);
$submited = $request->getPost("submited");
$deny = $component . '\deny';
$header = view($component . '\breadcrumb', $data);
//[Evaluate]------------------------------------------------------------------------------------------------------------
if ($singular) {
    $c = view($component . '\view', $data);
} else {
    $c = view($deny, $data);
}
//[Build]---------------------------------------------------------------------------------------------------------------
session()->set('page_template', 'page');
session()->set('page_header', $header);
session()->set('main_template', 'c9c3');
session()->set('messenger', true);
session()->set('main', $c);
session()->set('right', get_c4isr_cases());
?>