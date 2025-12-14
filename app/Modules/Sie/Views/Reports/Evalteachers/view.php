<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                                                    2024-02-12 10:12:28
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Home\breadcrumb.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2024 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                                                                         consulte la LICENCIA archivo que se distribuyó con este código fuente.
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
 * █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[vars]----------------------------------------------------------------------------------------------------------------
/** @var object $parent */
/** @var string $component */
/** @var string $view */
/** @var object $authentication */
/** @var object $request */
//[Services]-------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
$numbers = service('numbers');
//[Models]--------------------------------------------------------------------------------------------------------------
$musers = model('App\Modules\Sie\Models\Sie_Users');
$mfields = model('App\Modules\Sie\Models\Sie_Users_Fields');
$mqualifications = model("App\Modules\Sie\Models\Sie_Qualifications");
$mevaluations = model("App\Modules\Sie\Models\Sie_Evaluations");
$mpsychometrics = model("App\Modules\Sie\Models\Sie_Psychometrics");
//[Requests]------------------------------------------------------------------------------------------------------------
$search = "";
$limit = 10000;
$offset = 0;
$users = $musers->get_ListByType($limit, $offset, "TEACHER", $search);
$recordsTotal = $musers->get_TotalByType("TEACHER", $search);
$count = 0;
?>

<div class="row">
    <div class="col-12">
        <div class="alert alert-info" role="alert">
            <strong>Nota:</strong> Para copiar los resultados de la tabla, haga clic en el botón "Copiar Resultados".
            <button onclick="copiarTabla()" class="btn btn-primary btn-sm">Copiar Resultados</button>
        </div>
    </div>
</div>

<?php
echo("<table id=\"evaTable\" class=\"table table-striped table-hover table-bordered table-condensed table-responsive\">");
echo("<tr>");
echo("<th>#</th>");
echo("<th>Usuario</th>");
echo("<th>Cédula</th>");
echo("<th>Nombres</th>");
echo("<th>Apellidos</th>");
echo("<th>P1</th>");
echo("<th>P2</th>");
echo("<th>P3</th>");
echo("<th>-T-</th>");
echo("</tr>");
foreach ($users as $user) {
    $qualification = $mqualifications->get_LastQualificationByTeacher($user["user"]);
    $evaluations = $mevaluations->where("teacher", $user["user"])->findAll();
    $psychometric = $mpsychometrics->get_PsychometricByTeacher($user["user"]);


    $p1 = $numbers->convertToFloat(@$qualification["score"], 2);

    if ($p1 > 0) {
        $count++;
        $r2 = 0;
        foreach ($evaluations as $evaluation) {
            $r2 += ($evaluation['q1'] == "Y") ? 1 : 0;
            $r2 += ($evaluation['q2'] == "Y") ? 1 : 0;
            $r2 += ($evaluation['q3'] == "Y") ? 1 : 0;
            $r2 += ($evaluation['q4'] == "Y") ? 1 : 0;
            $r2 += ($evaluation['q5'] == "Y") ? 1 : 0;
            $r2 += ($evaluation['q6'] == "Y") ? 1 : 0;
            $r2 += ($evaluation['q7'] == "Y") ? 1 : 0;
            $r2 += ($evaluation['q8'] == "Y") ? 1 : 0;
            $r2 += ($evaluation['q9'] == "Y") ? 1 : 0;
        }
        $ppe = round((40 / 27), 2);
        $p2 = $numbers->convertToFloat(($r2 * $ppe), 2);
        $p3 = $numbers->convertToFloat((@$psychometric['fulfilled'] == "Y") ? "10" : "0", 2);
        $pt = $numbers->convertToFloat($p1 + $p2 + $p3, 2);
        $citizenshipcard = $mfields->get_Field($user["user"], "citizenshipcard");
        echo("<tr>");
        echo("<td>{$count}</td>");
        echo("<td><a href=\"/sie/teachers/view/{$user["user"]}\" target=\"_blank\">{$user["user"]}</a></td>");
        echo("<td>{$citizenshipcard}</td>");
        echo("<td>{$user["firstname"]}</td>");
        echo("<td>{$user["lastname"]}</td>");
        echo("<td class='text-center'>{$p1}</td>");
        echo("<td class='text-center'>{$p2}</td>");
        echo("<td class='text-center'>{$p3}</td>");
        echo("<td class='text-center'>{$pt}</td>");
        echo("</tr>");
    }
}
echo("</table>");
?>


<script>
    function copiarTabla() {
        var tabla = document.getElementById("evaTable");
        var rango = document.createRange();
        rango.selectNode(tabla);
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(rango);
        try {
            var exitoso = document.execCommand('copy');
            var msg = exitoso ? 'exitoso' : 'fallido';
            console.log('Copiado ' + msg);
        } catch (err) {
            console.log('Error al copiar: ', err);
        }
        window.getSelection().removeAllRanges();
    }
</script>
