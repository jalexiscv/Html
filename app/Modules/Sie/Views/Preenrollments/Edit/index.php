<?php
/** @var object $parent */
/** @var string $oid */
//[models]--------------------------------------------------------------------------------------------------------------
$mstatuses = model('App\Modules\Sie\Models\Sie_Statuses');
$mregistrations=model("App\Modules\Sie\Models\Sie_Registrations");
$menrollments=model("App\Modules\Sie\Models\Sie_Enrollments");
//[vars]----------------------------------------------------------------------------------------------------------------

$data = $parent->get_Array();
$data['model'] = $mregistrations;
$data['permissions'] = array('singular' => 'sie-registrations-edit', "plural" => 'sie-registrations-edit-all');
$singular = $authentication->has_Permission($data['permissions']['singular']);
$plural = $authentication->has_Permission($data['permissions']['plural']);

$submited = $request->getPost("submited");
$breadcrumb = $component . '\breadcrumb';
$validator = $component . '\validator';
//$identification = $component . '\identification';
$preenrollment = $component . '\preenrollment';
$deny = $component . '\deny';
$notenrolled=$component.'\notenrolled';
//[build]---------------------------------------------------------------------------------------------------------------

if (!empty($submited)) {
    $json = array(
        'breadcrumb' => view($breadcrumb, $data),
        'main' => view($validator, $data),
        'right' => "",
        "main_template" => "c12",
    );
} else {

    $enrrollment = $menrollments->get_Enrollment($oid);
    $statuses=$mstatuses->get_LastStatusEnrolledInCurrentPeriod($enrrollment["registration"]);
    if($statuses){
        $json = array(
            'breadcrumb' => view($breadcrumb, $data),
            'main' => view($preenrollment, $data),
            'right' => "",
            "main_template" => "c12",
        );
    }else{
        $json = array(
            'breadcrumb' => view($breadcrumb, $data),
            'main' => view($notenrolled, $data),
            'right' => "",
            "main_template" => "c8c4",
        );
    }

}
echo(json_encode($json));
?>