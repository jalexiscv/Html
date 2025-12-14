<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-08-31 13:53:15
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Executions\Editor\form.php]
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
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
$f = service("forms", array("lang" => "Sie_Executions."));
//[models]--------------------------------------------------------------------------------------------------------------
$mexecutions = model("App\Modules\Sie\Models\Sie_Executions");
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$mprogress = model("App\Modules\Sie\Models\Sie_Progress");
$menrollments = model('App\Modules\Sie\Models\Sie_Enrollments');
//[vars]----------------------------------------------------------------------------------------------------------------
$row = $model->get_Execution($oid);
$progress=$mprogress->get_Progress($row["progress"]);
$enrollment=$menrollments->get_Enrollment($progress["enrollment"]);
$registration=$mregistrations->getRegistration($enrollment["registration"]);
$fullname=@$registration["first_name"] . " " . @$registration["second_name"] . " " .@$registration["first_surname"]." ".@$registration["second_surname"];

$r["execution"] = $f->get_Value("execution", $row["execution"]);
$r["fullname"] = $f->get_Value("fullname",$fullname);
$r["progress"] = $f->get_Value("progress", $row["progress"]);
$r["course"] = $f->get_Value("course", $row["course"]);
$r["date_start"] = $f->get_Value("date_start", $row["date_start"]);
$r["date_end"] = $f->get_Value("date_end", $row["date_end"]);
$r["c1"] = $f->get_Value("c1", $row["c1"]);
$r["c2"] = $f->get_Value("c2", $row["c2"]);
$r["c3"] = $f->get_Value("c3", $row["c3"]);
$r["total"] = $f->get_Value("total", $row["total"]);
$r["author"] = $f->get_Value("author", safe_get_user());
$r["created_at"] = $f->get_Value("created_at", $row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", $row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", $row["deleted_at"]);
$back = "/sie/courses/view/{$row["course"]}";
//[fields]----------------------------------------------------------------------------------------------------------------
$f->fields["execution"] = $f->get_FieldText("execution", array("value" => $r["execution"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["fullname"] = $f->get_FieldText("fullname", array("value" => $r["fullname"], "proportion" => "col-12", "readonly" => true));
$f->fields["progress"] = $f->get_FieldText("progress", array("value" => $r["progress"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["course"] = $f->get_FieldText("course", array("value" => $r["course"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["date_start"] = $f->get_FieldText("date_start", array("value" => $r["date_start"], "proportion" => "col-md-6 col-sm-12 col-12", "readonly" => true));
$f->fields["date_end"] = $f->get_FieldText("date_end", array("value" => $r["date_end"], "proportion" => "col-md-6 col-sm-12 col-12", "readonly" => true));
$f->fields["c1"] = $f->get_FieldText("c1", array("value" => $r["c1"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["c2"] = $f->get_FieldText("c2", array("value" => $r["c2"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["c3"] = $f->get_FieldText("c3", array("value" => $r["c3"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["total"] = $f->get_FieldText("total", array("value" => $r["total"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Update"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["execution"] . $f->fields["progress"] . $f->fields["course"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["fullname"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["date_start"] . $f->fields["date_end"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["c1"] . $f->fields["c2"] . $f->fields["c3"] . $f->fields["total"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("create", array(
        "header-title"=>"Formulario",
        "content" => $f,
        "header-back" => $back
));
echo($card);
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        function calculateFinalGrade() {
            var c1 = parseFloat(document.getElementById('<?php echo($f->get_FieldId("c1"));?>').value) || 0;
            var c2 = parseFloat(document.getElementById('<?php echo($f->get_FieldId("c2"));?>').value) || 0;
            var c3 = parseFloat(document.getElementById('<?php echo($f->get_FieldId("c3"));?>').value) || 0;

            var finalGrade = (c1 * 0.3333) + (c2 * 0.3333) + (c3 * 0.3334);
            document.getElementById('<?php echo($f->get_FieldId("total"));?>').value = finalGrade.toFixed(2);
        }

        document.getElementById('<?php echo($f->get_FieldId("c1"));?>').addEventListener('input', calculateFinalGrade);
        document.getElementById('<?php echo($f->get_FieldId("c2"));?>').addEventListener('input', calculateFinalGrade);
        document.getElementById('<?php echo($f->get_FieldId("c3"));?>').addEventListener('input', calculateFinalGrade);
        // Initial calculation
        calculateFinalGrade();
    });
</script>
