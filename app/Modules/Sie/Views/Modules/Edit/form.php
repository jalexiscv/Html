<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-03-14 15:43:04
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Modules\Editor\form.php]
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
$f = service("forms", array("lang" => "Sie_Modules."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Sie\Models\Sie_Modules");
$mnetworks = model('App\Modules\Sie\Models\Sie_Networks');
$msubsectors = model('App\Modules\Sie\Models\Sie_Subsectors');
//[vars]----------------------------------------------------------------------------------------------------------------
$row = $model->where('module', $oid)->first();
$r["module"] = $f->get_Value("module", $row["module"]);
$r["reference"] = $f->get_Value("reference", $row["reference"]);
$r["acronym"] = $f->get_Value("acronym", $row["acronym"]);
$r["name"] = $f->get_Value("name", $row["name"]);
$r["status"] = $f->get_Value("status", $row["status"]);
$r["author"] = $f->get_Value("author", safe_get_user());
$r["red"] = $f->get_Value("red", @$row["red"]);
$r["subsector"] = $f->get_Value("subsector", @$row["subsector"]);
$r["created_at"] = $f->get_Value("created_at", @$row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", @$row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", @$row["deleted_at"]);
$back = "/sie/modules/list/" . lpk();

$yn = array(array("label" => "Activo", "value" => "ACTIVE"), array("label" => "Inactivo", "value" => "INACTIVE"));
$redes = array(array("value" => "", "label" => "Seleccione un subsector"));
$sectores = array(array("value" => "", "label" => "Seleccione un subsector"));
$redes = array_merge($redes, $mnetworks->get_SelectData());
$sectores = array_merge($sectores, $msubsectors->get_SelectData($r["red"]));

//[fields]----------------------------------------------------------------------------------------------------------------
$f->fields["module"] = $f->get_FieldText("module", array("value" => $r["module"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["reference"] = $f->get_FieldText("reference", array("value" => $r["reference"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["acronym"] = $f->get_FieldText("acronym", array("value" => $r["acronym"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["name"] = $f->get_FieldText("name", array("value" => $r["name"], "proportion" => "col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12"));
$f->fields["status"] = $f->get_FieldSelect("status", array("selected" => $r["status"], "data" => $yn, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["red"] = $f->get_FieldSelect("red", array("selected" => $r["red"], "data" => $redes, "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["subsector"] = $f->get_FieldSelect("subsector", array("selected" => $r["subsector"], "data" => $sectores, "proportion" => "col-md-6 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["module"] . $f->fields["reference"] . $f->fields["acronym"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["name"] . $f->fields["status"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["red"] . $f->fields["subsector"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("create", array(
        "header-title" => lang("Sie_Modules.edit-title"),
        "content" => $f,
        "alert" => array(
                "type" => "info",
                "title" => lang("Sie_Modules.create-module-alert-title"),
                "message" => lang("Sie_Modules.create-module-alert-message")),
        "header-back" => $back
));
echo($card);
$fid = $f->get_fid();
//echo("SUBSECTOR:{$r["subsector"]}");
?>
<!--[sincronizacion selects]//-->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const redSelect = document.querySelector('select[name="<?php echo($fid);?>_red"]');
        const sectorSelect = document.querySelector('select[name="<?php echo($fid);?>_subsector"]');
        const sectores = {
            '': [
                {value: '', label: 'Seleccione un subsector'}
            ],
            <?php
            $networks = $mnetworks->findAll();
            foreach ($networks as $network) {
                echo("'{$network["network"]}':[");
                $subsectors = $msubsectors->where("network", $network["network"])->findAll();
                echo("{value: '', label: 'Seleccione un subsector'},");
                foreach ($subsectors as $subsector) {
                    echo("{value: '{$subsector["subsector"]}', label: '{$subsector["name"]}'},");
                }
                echo("],");
            }
            ?>
        };

        function actualizarSectores(red) {
            sectorSelect.innerHTML = '';
            const opciones = sectores[red] || sectores[''];

            opciones.forEach(opcion => {
                const option = document.createElement('option');
                option.value = opcion.value;
                option.textContent = opcion.label;
                sectorSelect.appendChild(option);
            });
        }

        redSelect.addEventListener('change', function () {
            actualizarSectores(this.value);
        });
        // Inicializar con el valor actual
        //actualizarSectores(redSelect.value);
    });
</script>