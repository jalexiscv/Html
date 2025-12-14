<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-08-31 13:53:11
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Executions\Creator\index.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 * █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 * █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 * █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * █ @link https://www.codehiggs.com
 * █ @Version 1.5.0 @since PHP 7, PHP 8
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ Datos recibidos desde el controlador - @ModuleController
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @var object $parent Trasferido desde el controlador
 * █ @var object $authentication Trasferido desde el controlador
 * █ @var object $request Trasferido desde el controlador
 * █ @var object $dates Trasferido desde el controlador
 * █ @var string $component Trasferido desde el controlador
 * █ @var string $view Trasferido desde el controlador
 * █ @var string $oid Trasferido desde el controlador
 * █ @var string $views Trasferido desde el controlador
 * █ @var string $prefix Trasferido desde el controlador
 * █ @var array $data Trasferido desde el controlador
 * █ @var object $model Modelo de datos utilizado en la vista y trasferido desde el index
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[services]------------------------------------------------------------------------------------------------------------
$request = service("request");
//[models]--------------------------------------------------------------------------------------------------------------
$mexecutions = model('App\Modules\Sie\Models\Sie_Executions');
$mprogress = model('App\Modules\Sie\Models\Sie_Progress');
/**
 * Determina el período académico dinámicamente basado en la fecha actual
 * @return string Período en formato YYYYX (ej: 2025A, 2025B)
 */


//[vars]----------------------------------------------------------------------------------------------------------------
$data = $parent->get_Array();
$data['permissions'] = array('singular' => 'sie-executions-create', "plural" => false);
$singular = $authentication->has_Permission($data['permissions']['singular']);
$submited = $request->getPost("submited");
$validator = $component . '\validator';
$breadcrumb = $component . '\breadcrumb';
$confirm = $component . '\confirm';
$inexecution = $component . '\inexecution';
$approved = $component . '\approved';
$deny = $component . '\deny';
$course = $oid;
$progress = $request->getVar("progress");
$period = sie_get_current_academic_period();
//[query]---------------------------------------------------------------------------------------------------------------
$executionsInCurrentPeriod = $mexecutions->getExecutionByProgressByPeriod($progress, $period);
$isaproved = $mprogress->isApproved($progress);
$data["progress"] = $progress;
$data['executionsInCurrentPeriod'] = $executionsInCurrentPeriod;
$data['isaproved'] = $isaproved;
//[build]---------------------------------------------------------------------------------------------------------------
if ($singular) {
    if (!empty($submited)) {
        $json = array(
            'breadcrumb' => view($breadcrumb, $data),
            'main' => view($validator, $data),
            'right' => "",
            'main_template' => 'c8c4',//'c12',
        );
    } else {
        if ($executionsInCurrentPeriod && count($executionsInCurrentPeriod) > 0) {
            $json = array(
                'breadcrumb' => view($breadcrumb, $data),
                'main' => view($inexecution, $data),
                'right' => "",
                'main_template' => 'c8c4',//'c12',
            );
        } elseif ($isaproved) {
            $json = array(
                'breadcrumb' => view($breadcrumb, $data),
                'main' => view($approved, $data),
                'right' => "",
                'main_template' => 'c8c4',//'c12',
            );
        } else {
            $json = array(
                'breadcrumb' => view($breadcrumb, $data),
                'main' => view($confirm, $data),
                'right' => "",
                'main_template' => 'c8c4',//'c12',
            );
        }
    }
} else {
    $json = array(
        'breadcrumb' => view($breadcrumb, $data),
        'main' => view($deny, $data),
        'right' => "",
        'main_template' => 'c8c4',//'c12',
    );
}
echo(json_encode($json));
?>
