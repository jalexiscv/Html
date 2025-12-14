<?php
//[models]--------------------------------------------------------------------------------------------------------------
$mtrainings = model('Sie_Trainings');
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
$search = !empty($request->getGet("search")) ? $request->getGet("search") : "";
$count = $mtrainings->get_Total($search);
//[build]---------------------------------------------------------------------------------------------------------------
$code = "";
$code .= "<div class=\"card flex-row align-items-center align-items-stretch mb-3\">\n";
$code .= "\t\t<div class=\"col-4 d-flex align-items-center bg-gray justify-content-center rounded-left\">\n";
$code .= "\t\t\t\t<i class=\"icon fa-light fa-screen-users fa-3x\"></i>\n";
$code .= "\t\t</div>\n";
$code .= "\t\t<div class=\"col-8 py-3 bg-gray rounded-right\">\n";
$code .= "\t\t\t\t<div class=\"fs-5 lh-5 my-0\">\n";
$code .= "\t\t\t\t\t\t{$count}\t\t\t\t</div>\n";
$code .= "\t\t\t\t<div class=\"\t\tmy-0\">\n";
$code .= "\t\t\t\t\t\t" . lang("App.Students") . "\t\t\t\t</div>\n";
$code .= "\t\t</div>\n";
$code .= "</div>\n";
echo($code);
?>