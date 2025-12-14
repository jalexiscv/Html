<?php

//[vars]----------------------------------------------------------------------------------------------------------------
/** @var string $module URI a la raiz del modulo */
/** @var string $views URI a las views del modulo desde el controlador */
/** @var string $component URI a este componente desde el controlador */
/** @var string $parent el controlador mismo desde el ModuleController */
/** @var string $oid valor de objeto recibido generalmente objeto / dato a visualizar */
/** @var string $authentication el servicio de autenticación desde el ModuleController */
/** @var string $dates el servicio de fechas desde el ModuleController */
/** @var string $strings el servicio de cadenas desde el ModuleController */
/** @var string $request el servicio de solicitud desde el ModuleController */
$data = $parent->get_Array();
$data['permissions'] = array('singular' => false, "plural" => 'sie-students-view-all');
$plural = $authentication->has_Permission($data['permissions']['plural']);
$submited = $request->getPost("submited");
$breadcrumb = $component . '\breadcrumb';
$validator = $component . '\validator';
$table = $component . '\table';
$deny = $component . '\deny';
$right = view($views . '\Trainings\right', $data);
//[build]---------------------------------------------------------------------------------------------------------------
if ($plural) {
    if (!empty($submited)) {
        $json = array(
            'breadcrumb' => view($breadcrumb, $data),
            'main' => view($validator, $data),
            'right' => ""
        );
    } else {
        $json = array(
            'breadcrumb' => view($breadcrumb, $data),
            'main' => view($table, $data),
            'right' => $right
        );
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