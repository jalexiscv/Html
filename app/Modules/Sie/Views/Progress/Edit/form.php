<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-08-13 07:26:00
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Progress\Editor\form.php]
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
$f = service("forms", array("lang" => "Sie_Progress."));
//[models]--------------------------------------------------------------------------------------------------------------
$mprogress = model("App\Modules\Sie\Models\Sie_Progress");
$mmodules = model("App\Modules\Sie\Models\Sie_Modules");
$mpensums = model("App\Modules\Sie\Models\Sie_Pensums");
//[vars]----------------------------------------------------------------------------------------------------------------
$row = $model->get_Progress($oid);


$r["progress"] = $f->get_Value("progress", $row["progress"]);
$r["enrollment"] = $f->get_Value("enrollment", $row["enrollment"]);
$r["module"] = $f->get_Value("module", $row["module"]);
$r["pensum"] = $f->get_Value("pensum", $row["pensum"]);
$r["status"] = $f->get_Value("status", $row["status"]);
$r["period"] = $f->get_Value("period", $row["period"]);
$r["c1"] = $f->get_Value("c1", $row["c1"]);
$r["c2"] = $f->get_Value("c2", $row["c2"]);
$r["c3"] = $f->get_Value("c3", $row["c3"]);
$r["last_calification"] = $f->get_Value("last_calification", $row["last_calification"]);
$r["last_course"] = $f->get_Value("last_course", $row["last_course"]);

$r["last_date"] = $f->get_Value("last_date", safe_get_date());

//$r["author"] = $f->get_Value("author", $row["author"]);
$r["author"] = $f->get_Value("author", safe_get_user());
$r["last_author"] = $f->get_Value("last_author", safe_get_user());
//$r["last_author"] = $f->get_Value("last_author",  $row["author"]);

$r["created_at"] = $f->get_Value("created_at", $row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", $row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", $row["deleted_at"]);

$module = $mmodules->get_Module($r["module"]);
$module_name = @$module["name"];
$pensum = $mpensums->get_Pensum(@$r["pensum"]);

$back = "/sie/progress/list/{$r["enrollment"]}";
//[fields]----------------------------------------------------------------------------------------------------------------
$f->fields["progress"] = $f->get_FieldText("progress", array("value" => $r["progress"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["enrollment"] = $f->get_FieldText("enrollment", array("value" => $r["enrollment"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));

$f->fields["pensum"] = $f->get_FieldText("pensum", array("value" => $r["pensum"], "proportion" => "col-md-3 col-sm-12 col-12", "readonly" => true));

$f->fields["module"] = $f->get_FieldText("module", array("value" => $r["module"], "proportion" => "col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["module_name"] = $f->get_FieldText("module_name", array("value" => $module_name, "proportion" => "col-md-9 col-sm-12 col-12", "readonly" => true));


$f->fields["period"] = $f->get_FieldSelect("period", array("selected" => $r["period"], "data" => LIST_PERIODS, "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));

$f->fields["c1"] = $f->get_FieldText("c1", array("value" => $r["c1"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["c2"] = $f->get_FieldText("c2", array("value" => $r["c2"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["c3"] = $f->get_FieldText("c3", array("value" => $r["c3"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["last_calification"] = $f->get_FieldText("last_calification", array("value" => $r["last_calification"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));

$f->fields["last_course"] = $f->get_FieldText("last_course", array("value" => $r["last_course"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["last_author"] = $f->get_FieldText("last_author", array("value" => $r["last_author"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["last_date"] = $f->get_FieldText("last_date", array("value" => $r["last_date"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));

$f->fields["status"] = $f->get_FieldSelect("status", array("selected" => $r["status"], "data" => LIST_STATUSES_PROGRESS, "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));

$f->add_HiddenField("author", $r["author"]);

$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["progress"] . $f->fields["enrollment"] . $f->fields["pensum"] . $f->fields["period"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["module"] . $f->fields["module_name"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["c1"] . $f->fields["c2"] . $f->fields["c3"] . $f->fields["last_calification"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["status"] . $f->fields["last_date"] . $f->fields["last_course"] . $f->fields["last_author"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("create", array(
        "header-title" => lang("Sie_Progress.edit-title"),
        "content" => $f,
        "header-back" => $back
));
echo($card);


$card = $bootstrap->get_Card2("create", array(
        "header-title" => "Cursos Realizados (Ejecuciones)",
        "content" => view("App\Modules\Sie\Views\Progress\Edit\grid", array("progress" => $oid)),
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
            document.getElementById('<?php echo($f->get_FieldId("last_calification"));?>').value = finalGrade.toFixed(2);
        }

        document.getElementById('<?php echo($f->get_FieldId("c1"));?>').addEventListener('input', calculateFinalGrade);
        document.getElementById('<?php echo($f->get_FieldId("c2"));?>').addEventListener('input', calculateFinalGrade);
        document.getElementById('<?php echo($f->get_FieldId("c3"));?>').addEventListener('input', calculateFinalGrade);
        // Initial calculation
        calculateFinalGrade();
    });
</script>