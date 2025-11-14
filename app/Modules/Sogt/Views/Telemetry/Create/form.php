<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-08-26 00:44:28
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sogt\Views\Telemetry\Creator\form.php]
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
 * █ @link https://www.higgs.com.co
 * █ @Version 1.5.1 @since PHP 8,PHP 9
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[services]------------------------------------------------------------------------------------------------------------
$b = service("bootstrap");
$f = service("forms", array("lang" => "Sogt_Telemetry."));
$server = service("server");
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Sogt\Models\Sogt_Telemetry");
//[vars]----------------------------------------------------------------------------------------------------------------
/**
 * @var object $authentication Authentication service from the ModuleController.
 * @var object $bootstrap Instance of the Bootstrap class from the ModuleController.
 * @var string $component Complete URI to the requested component.
 * @var object $dates Date service from the ModuleController.
 * @var string $oid String representing the object received, usually an object/data to be viewed, transferred from the ModuleController.
 * @var object $parent Represents the ModuleController.
 * @var object $request Request service from the ModuleController.
 * @var object $strings String service from the ModuleController.
 * @var string $view String passed to the view defined in the viewer for evaluation.
 * @var string $viewer Complete URI to the view responsible for evaluating each requested view.
 * @var string $views Complete URI to the module views.
 **/
$r["telemetry"] = $f->get_Value("telemetry", pk());
$r["device"] = $f->get_Value("device");
$r["user"] = $f->get_Value("user");
$r["latitude"] = $f->get_Value("latitude");
$r["longitude"] = $f->get_Value("longitude");
$r["altitude"] = $f->get_Value("altitude");
$r["speed"] = $f->get_Value("speed");
$r["heading"] = $f->get_Value("heading");
$r["gps_valid"] = $f->get_Value("gps_valid");
$r["satellites"] = $f->get_Value("satellites");
$r["network"] = $f->get_Value("network");
$r["battery"] = $f->get_Value("battery");
$r["ignition"] = $f->get_Value("ignition");
$r["event"] = $f->get_Value("event");
$r["motion"] = $f->get_Value("motion");
$r["timestamp"] = $f->get_Value("timestamp");
$r["author"] = $f->get_Value("author", safe_get_user());
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");
$back = $f->get_Value("back", $server->get_Referer());
//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("back", $back);
$f->fields["telemetry"] = $f->get_FieldText("telemetry", array("value" => $r["telemetry"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["device"] = $f->get_FieldText("device", array("value" => $r["device"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["user"] = $f->get_FieldText("user", array("value" => $r["user"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["latitude"] = $f->get_FieldText("latitude", array("value" => $r["latitude"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["longitude"] = $f->get_FieldText("longitude", array("value" => $r["longitude"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["altitude"] = $f->get_FieldText("altitude", array("value" => $r["altitude"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["speed"] = $f->get_FieldText("speed", array("value" => $r["speed"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["heading"] = $f->get_FieldText("heading", array("value" => $r["heading"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["gps_valid"] = $f->get_FieldText("gps_valid", array("value" => $r["gps_valid"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["satellites"] = $f->get_FieldText("satellites", array("value" => $r["satellites"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["network"] = $f->get_FieldText("network", array("value" => $r["network"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["battery"] = $f->get_FieldText("battery", array("value" => $r["battery"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ignition"] = $f->get_FieldText("ignition", array("value" => $r["ignition"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["event"] = $f->get_FieldText("event", array("value" => $r["event"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["motion"] = $f->get_FieldText("motion", array("value" => $r["motion"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["timestamp"] = $f->get_FieldText("timestamp", array("value" => $r["timestamp"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["fill_test"] = '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3">
    <button type="button" id="fillTestDataBtn" class="btn btn-info btn-sm">
        <i class="fas fa-flask"></i> Llenar con Datos de Prueba
    </button>
</div>';
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["telemetry"] . $f->fields["device"] . $f->fields["user"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["latitude"] . $f->fields["longitude"] . $f->fields["altitude"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["speed"] . $f->fields["heading"] . $f->fields["gps_valid"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["satellites"] . $f->fields["network"] . $f->fields["battery"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["ignition"] . $f->fields["event"] . $f->fields["motion"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["timestamp"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gx"] = $f->get_Group(array("legend" => "", "fields" => $f->fields["fill_test"]));
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card("create", array(
        "title" => lang("Sogt_Telemetry.create-title"),
        "content" => $f,
        "header-back" => $back
));
echo($card);
$fid = $f->get_fid();
?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fillTestDataBtn = document.getElementById('fillTestDataBtn');

        if (fillTestDataBtn) {
            fillTestDataBtn.addEventListener('click', function () {
                // Obtener el Form ID desde PHP
                const formId = '<?php echo $fid; ?>';

                // Datos de prueba realistas para telemetría GPS
                const testData = {
                    'device': 'GPS-TRACKER-001',
                    'user': 'usuario_prueba',
                    'latitude': '4.7110',  // Bogotá, Colombia
                    'longitude': '-74.0721',
                    'altitude': '2640',    // metros sobre el nivel del mar
                    'speed': '45',         // km/h
                    'heading': '180',      // grados (Sur)
                    'gps_valid': '1',      // GPS válido
                    'satellites': '8',     // número de satélites
                    'network': 'GSM',      // tipo de red
                    'battery': '85',       // porcentaje de batería
                    'ignition': '1',       // encendido activo
                    'event': 'NORMAL',     // evento normal
                    'motion': '1',         // en movimiento
                    'timestamp': new Date().toISOString().slice(0, 19).replace('T', ' '), // formato: YYYY-MM-DD HH:MM:SS
                    'created_at': new Date().toISOString().slice(0, 19).replace('T', ' '),
                    'updated_at': new Date().toISOString().slice(0, 19).replace('T', ' '),
                    'deleted_at': ''       // campo vacío para deleted_at
                };

                // Llenar todos los campos del formulario usando el formato {formId}_{fieldName}
                Object.keys(testData).forEach(function (fieldName) {
                    const fieldNameWithId = formId + '_' + fieldName;
                    const field = document.querySelector(`input[name="${fieldNameWithId}"]`);
                    if (field && !field.readOnly) {
                        field.value = testData[fieldName];

                        // Disparar evento change para que el framework detecte el cambio
                        const event = new Event('change', {bubbles: true});
                        field.dispatchEvent(event);
                    }
                });

                // Mostrar mensaje de confirmación
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-success alert-dismissible fade show mt-2';
                alertDiv.innerHTML = `
                <i class="fas fa-check-circle"></i> 
                <strong>¡Datos de prueba cargados!</strong> Todos los campos han sido llenados con información de ejemplo.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;

                // Insertar el mensaje después del botón
                fillTestDataBtn.parentNode.insertBefore(alertDiv, fillTestDataBtn.nextSibling);

                // Auto-remover el mensaje después de 3 segundos
                setTimeout(function () {
                    if (alertDiv.parentNode) {
                        alertDiv.remove();
                    }
                }, 3000);
            });
        }
    });
</script>

