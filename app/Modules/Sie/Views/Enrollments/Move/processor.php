<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-07-27 09:56:27
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Enrollments\Creator\processor.php]
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
//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[Models]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Sie_Enrollments."));
$menrollments = model("App\Modules\Sie\Models\Sie_Enrollments");
$mprogress = model("App\Modules\Sie\Models\Sie_Progress");
$mgrids = model("App\Modules\Sie\Models\Sie_Grids");
$mpensums = model("App\Modules\Sie\Models\Sie_Pensums");
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$mprograms = model("App\Modules\Sie\Models\Sie_Programs");
$mversions = model("App\Modules\Sie\Models\Sie_Versions");
//[Vars]-----------------------------------------------------------------------------
$back = "/sie/enrollments/academic/" . lpk();
$d = array(
    "enrollment" => $f->get_Value("enrollment"),
    "registration" => $f->get_Value("registration"),
    "program" => $f->get_Value("program"),
    "program_move" => $f->get_Value("program_move"),
    "date" => safe_get_date(),
    "time" => safe_get_time(),
    "author" => safe_get_user(),
);
$row = $menrollments->find($d["enrollment"]);
$l["back"] = "$back";
$l["edit"] = "/sie/enrollments/edit/{$d["enrollment"]}";
$asuccess = "sie/enrollments-create-success-message.mp3";
$aexist = "sie/enrollments-create-exist-message.mp3";
if (is_array($row)) {
    //Debo actualizar el registro de matricula
    // 1. Obtener los datos del nuevo programa
    // 2. Obtener la malla curricular del nuevo programa
    // 3. Obtener la version activa de la malla curricular
    $program = $mprograms->getProgram($d["program_move"]);
    $grid = $mgrids->get_GridByProgram($program["program"]);
    $version = $mversions->get_Active($grid["grid"]);
    // 4. Cambiar el programa actual por el programa nuevo en la matricula, incluida la grid, y la version
    // 5. Cambiar el programa actual por el programa nuevo en el registro
    $edit_enrollments = $menrollments->update($d['enrollment'], array(
        "program" => $program["program"],
        "grid" => $grid["grid"],
        "version" => $version["version"],
    ));
    $edit_registrations = $mregistrations->update($d['registration'], array("program" => $program["program"]));
    // 6. Borrar todos los registros de progreso pertenecientes a esta matricula
    $delete = $mprogress->where("enrollment", $d['enrollment'])->delete();

    // 7. Debo tomar todos los modulos de la malla curricular y crear un registro en la tabla de progreso
    // 8. los codigos de los modulos no seran los codigos de los modulos originales si no los modulos de la malla
    //    programs -> grids -> versions -> pensums
    //    literal un pemsum es un modulo dentro de una version de una malla curricular
    $pensums = $mpensums->get_PensumsByVersion($version["version"]);
    //echo($d["version"]);
    //echo("<pre>");
    //print_r($pensums);
    //echo("</pre>");
    foreach ($pensums as $pensum) {
        if (is_array($pensum)) {
            $progress = array(
                "progress" => pk(),
                "enrollment" => $d["enrollment"],
                "pensum" => @$pensum["pensum"],
                "module" => @$pensum["module"],
                "status" => "0",
                "last_calification" => "0",
                "last_course" => "0",
                "last_author" => safe_get_user(),
                "last_date" => safe_get_date(),
                "author" => safe_get_user(),
            );
            //print_r($progress);
            $mprogress->insert($progress);
        }
    }


    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Enrollments.move-success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Sie_Enrollments.move-success-message"), $program['name']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
} else {
    $c = $bootstrap->get_Card("duplicate", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Enrollments.move-noexist-title"),
        "text-class" => "text-center",
        "text" => lang("Sie_Enrollments.move-noexist-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $aexist,
    ));
}
echo($c);
?>