<?php

/** @var string $oid */
//[services]------------------------------------------------------------------------------------------------------------
$b = service("bootstrap");
$f = service("forms", array("lang" => "Sie_Registrations."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Sie\Models\Sie_Registrations");
$mprogams = model("App\Modules\Sie\Models\Sie_Programs");
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$mobservations = model("App\Modules\Sie\Models\Sie_Observations");
$mfields = model("App\Modules\Sie\Models\Sie_Users_Fields");
//[vars]----------------------------------------------------------------------------------------------------------------


// Existen dos permisos para observaciones, uno con accesso a observaciones propias "sie-observations-view" y otro
// con acceso a todas las observaciones "sie-observations-view-all"
$authentication = service("authentication");
$singular = $authentication->has_Permission("SIE-OBSERVATIONS-VIEW");
$plural = $authentication->has_Permission("SIE-OBSERVATIONS-VIEW-ALL");
//echo("<br>SINGULAR $singular PLURAL $plural");

if ($plural) {
    $observations = $mobservations->get_Observations(1000, 0, array("object" => $oid));
} else {
    $observations = $mobservations->get_Observations(1000, 0, array("object" => $oid, "author" => safe_get_user()));
}

$info = $b->get_Alert(array(
        'type' => 'info',
        'title' => lang('App.Remember'),
        "message" => lang("Sie_Observations.message-info"),
));
echo($info);


$bgrid = $b->get_Grid();
$bgrid->set_Id("sie-student-observations-list");
$bgrid->set_Headers(array(
        array("content" => "#", "class" => "text-center  align-middle"),
    //array("content" => "Código", "class" => "text-center align-middle"),
    //array("content" => "Author", "class" => "text-center align-middle"),
    //array("content" => "Contenido", "class" => "text-center align-middle"),
        array("content" => "Detalle", "class" => "text-center align-middle"),
        array("content" => "Fecha", "class" => "text-center align-middle"),
    //array("content" => "Hora", "class" => "text-center align-middle"),
        array("content" => "Opciones", "class" => "text-center  align-middle"),
));

$count = 0;
if (is_array($observations)) {
    foreach ($observations as $observation) {
        $count++;
        $types = LIST_TYPES_OBSERVATIONS;
        $code = $observation["observation"];
        $author = $observation["author"];
        $author_name = safe_get_user_fullname($author);
        $type = $observation["type"];
        $puser = $mfields->get_Profile($author);
        $author_name = $puser["name"] . " - <span class='fst-italic opacity-1'>{$observation["author"]}</span>";
        foreach ($types as $t) {
            if ($t['value'] == $type) {
                $type = $t['label'];
            }
        }
        $content = $observation["content"];
        //[buttons]-----------------------------------------------------------------------------------------------------
        $deleter = "#";
        $ledit = $b::get_Link('edit', array('href' => "#", 'icon' => ICON_EDIT, 'text' => "", 'class' => 'btn-secondary', 'onclick' => "confirmEditObservation('{$observation['observation']}');"));
        $ldeleter = $b::get_Link('delete', array('href' => $deleter, 'icon' => ICON_DELETE, 'text' => "", 'class' => 'btn-danger', 'onclick' => "confirmDeleteObservation('{$observation['observation']}');"));
        $options = $b::get_BtnGroup('options', array('content' => array($ledit, $ldeleter)));
        //[details]-----------------------------------------------------------------------------------------------------
        $details = "<b>Radicada por</b>: $author_name </br>";
        $details .= "<b>Tipo</b>: $type </br>";
        $details .= "<b>Observación</b>: $content </br>";
        //[cells]-------------------------------------------------------------------------------------------------------
        $cell_count = array("content" => $count, "class" => "text-center  align-middle ",);
        //$cell_code = array("content" => $code, "class" => "text-center  align-middle text-nowrap",);
        //$cell_author = array("content" => $author, "class" => "text-center  align-middle text-nowrap",);
        //$cell_content = array("content" => $content, "class" => "text-center  align-middle text-nowrap",);
        $cell_details = array("content" => $details, "class" => "text-left  align-middle ",);
        $cell_date = array("content" => $observation["date"] . "</br>" . $observation["time"], "class" => "text-center  align-middle text-nowrap",);
        //$cell_time = array("content" => $observation["time"], "class" => "text-center  align-middle text-nowrap",);
        $cell_options = array("content" => $options, "class" => "text-center align-middle",);
        $bgrid->add_Row(array($cell_count, $cell_details, $cell_date, $cell_options));
    }
} else {
    echo("Sin observaciones!...");
}


$buttonsObservations = "";
$buttonsObservations .= "<div class=\"row\">\n";
$buttonsObservations .= "<div class=\"col-12\">\n";
$buttonsObservations .= "\t\t<div class=\"input-group mb-3\">\n";
$buttonsObservations .= "\t\t\t\t<a id=\"btn-bill\" class=\"btn btn-primary\" href=\"#\" data-bs-toggle=\"modal\" data-bs-target=\"#observacionModal\">\n";
$buttonsObservations .= "\t\t\t\t\t\t<i class=\"icon fa-light fa-plus\"></i>\n";
$buttonsObservations .= "\t\t\t\t\t\t<div class=\"btn-text-inline\">Crear Observación</div>\n";
$buttonsObservations .= "\t\t\t\t</a>\n";
$buttonsObservations .= "\t\t\t\t<a id=\"btn-download\" class=\"btn btn-success \" href=\"/sie/observations/reports/{$oid}\">\n";
$buttonsObservations .= "\t\t\t\t\t\t<i class=\"icon fa-light fa-download\"></i>\n";
$buttonsObservations .= "\t\t\t\t\t\t<div class=\"btn-text-inline\">Descargar Informe</div>\n";
$buttonsObservations .= "\t\t\t\t</a>\n";
$buttonsObservations .= "\t\t</div>\n";
$buttonsObservations .= "</div>\n";
$buttonsObservations .= "</div>\n";
echo($buttonsObservations);


echo("<div id=\"container-grid-observations\" class=\"row\">\n");
echo($bgrid);
echo("</div>\n");


$registration = $mregistrations->getRegistration($oid);
$r["observations_academic"] = $f->get_Value("observations_academic", $registration['observations_academic']);
$back = (($oid == "fullscreen") ? "/sie/registrations/cancel/fullscreen" : "/sie/registrations/list/" . lpk());
//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("tab", "observations_academic");
$f->add_HiddenField("registration", $oid);
$f->fields["observations_academic"] = $f->get_FieldCKEditor("observations_academic", array("value" => $r["observations_academic"], "proportion" => "col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Update"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g01"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["observations_academic"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card("create", array(
        "content" => $f,
));
//echo($card);


include("observations-create.php");
include("observations-delete.php");
include("observations-edit.php");

?>
<script>

    let observacion_to_delete;

    function guardarObservation() {
        var type = document.getElementById('type').value;
        var content = document.getElementById('content').value;
        //console.log('Tipo:', type, 'Observación:', content);
        xhrCreateObservation(type, content);
    }


    function confirmDeleteObservation(observation) {
        observacion_to_delete = observation;
        const modal = new bootstrap.Modal(document.getElementById('confirmarEliminacionModal'));
        modal.show();
    }


    function confirmEditObservation(observation) {
        const modal = new bootstrap.Modal(document.getElementById('observation-modal-edit'));
        document.getElementById('update-observation-id').value = observation;
        modal.show();
        xhrReadObservation(observation);
    }

    function deleteObservation() {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/sie/api/observations/json/delete/<?php echo($oid);?>', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onload = function () {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                var modalEl = document.getElementById('confirmarEliminacionModal');
                var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modalEl.addEventListener('hidden.bs.modal', function (event) {
                    updateObservations();
                    if (response.status === 403) {
                        alert(response.message);
                    }
                }, {once: true});
                modal.hide();
            } else {
                alert('Error al eliminar la observación');
            }
        };
        xhr.onerror = function () {
            //console.error('Error de red al intentar eliminar la observación');
        };
        var data = JSON.stringify({
            object: '<?php echo($oid);?>',
            observation: observacion_to_delete
        });
        xhr.send(data);
    }

    /**
     * Función para leer una observación específica.
     * Desde la URI "/sie/api/observations/json/read/{observation}"
     * @param string observation - El objeto de observación a leer.
     */
    function xhrReadObservation(observation) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/sie/api/observations/json/read/' + observation + '?observation=' + observation, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Formato ejemplo: {"message":"Se obtuvo la observaci\u00f3n correctamente","status":200,"data":{"observation":"6836206BA3333","object":"66ABD712770F1","type":"22","content":"Revisi\u00f3n por comite","date":"2025-05-27","time":"15:28:27","author":"1538146213","created_at":"2025-05-27 15:28:27","updated_at":"2025-05-27 15:28:27","deleted_at":null}}
                var response = JSON.parse(xhr.responseText);
                console.log('Observación leida exitosamente');
                console.log(response);
                if (response.status === 200) {
                    //document.getElementById('update-observation-id').value = response.data.observation;
                    document.getElementById('update-observation-type').value = response.data.type;
                    document.getElementById('update-observation-content').value = response.data.content;
                } else {
                    console.error(response.message);
                }
            } else {
                console.error('Error al leer la observación');
            }
        };
        xhr.onerror = function () {
            console.error('Error de red al intentar leer la observación');
        };
        xhr.send();
    }



    function xhrCreateObservation(type, content) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/sie/api/observations/json/create/<?php echo($oid);?>', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onload = function () {
            if (xhr.status === 200) {
                closeModalProperly('observacionModal', function () {
                    updateObservations();
                    // Limpiar formulario
                    document.getElementById('type').value = '';
                    document.getElementById('content').value = '';
                });
            } else {
                console.error('Error al guardar la observación');
            }
        };
        xhr.onerror = function () {
            console.error('Error de red al intentar guardar la observación');
        };
        var data = JSON.stringify({
            object: '<?php echo($oid);?>',
            type: type,
            content: content
        });
        xhr.send(data);
    }


    // Función helper para cerrar modales correctamente
    function closeModalProperly(modalId, callback) {
        var modalEl = document.getElementById(modalId);
        var modal = bootstrap.Modal.getInstance(modalEl);

        if (modal) {
            // Agregar listener para cuando el modal esté completamente cerrado
            modalEl.addEventListener('hidden.bs.modal', function handler(event) {
                // Forzar limpieza del backdrop y clases
                var backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';

                // Ejecutar callback
                if (callback && typeof callback === 'function') {
                    callback();
                }

                // Remover este listener
                modalEl.removeEventListener('hidden.bs.modal', handler);
            });

            modal.hide();
        }
    }




    function xhrUpdateObservation() {
        var observation = document.getElementById('update-observation-id').value;
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/sie/api/observations/json/edit/' + observation, true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onload = function () {
            if (xhr.status === 200) {
                var modalEl = document.getElementById('observation-modal-edit');
                var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modalEl.addEventListener('hidden.bs.modal', function (event) {
                    updateObservations();
                }, {once: true});
                modal.hide();
            } else {
                console.error('Error al actualizar la observación');
            }
        };
        xhr.onerror = function () {
            console.error('Error de red al intentar actualizar la observación');
        };
        var type = document.getElementById('update-observation-type').value;
        var content = document.getElementById('update-observation-content').value;
        var data = JSON.stringify({
            observation: observation,
            type: type,
            content: content
        });
        xhr.send(data);
    }

    function updateObservations() {
        var grid = document.getElementById('container-grid-observations');
        grid.innerHTML = '';

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/sie/api/observations/json/grid/<?php echo($oid);?>', true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log('Observaciones actualizadas');
                var response = JSON.parse(xhr.responseText);
                console.log(response);
                grid.innerHTML = response.grid;
            } else {
                console.error('Error al actualizar las observaciones');
            }
        };
        xhr.onerror = function () {
            console.error('Error de red al intentar actualizar las observaciones');
        };
        var data = JSON.stringify({
            object: '<?php echo($oid);?>',
        });
        xhr.send(data);
    }
</script>