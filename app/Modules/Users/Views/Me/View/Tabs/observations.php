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
$mfields = model("App\Modules\Sie\Models\Sie_Users_Fields2");
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
        $ldeleter = $b::get_Link('delete', array('href' => $deleter, 'icon' => ICON_DELETE, 'text' => "", 'class' => 'btn-danger', 'onclick' => "confirmDeleteObservation('{$observation['observation']}');"));
        $options = $b::get_BtnGroup('options', array('content' => array($ldeleter)));
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


$code = "<!-- Modal -->\n";
$code .= "<div class=\"modal fade\" id=\"observacionModal\" tabindex=\"-1\" aria-labelledby=\"observacionModalLabel\" aria-hidden=\"true\">\n";
$code .= "\t\t<div class=\"modal-dialog\">\n";
$code .= "\t\t\t\t<div class=\"modal-content\">\n";
$code .= "\t\t\t\t\t\t<div class=\"modal-header\">\n";
$code .= "\t\t\t\t\t\t\t\t<h5 class=\"modal-title\" id=\"observacionModalLabel\">Agregar Observación</h5>\n";
$code .= "\t\t\t\t\t\t\t\t<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>\n";
$code .= "\t\t\t\t\t\t</div>\n";
$code .= "\t\t\t\t\t\t<div class=\"modal-body\">\n";
$code .= "\t\t\t\t\t\t\t\t<form id=\"observacionForm\">\n";
$code .= "\t\t\t\t\t\t\t\t\t\t<div class=\"mb-3\">\n";
$code .= "\t\t\t\t\t\t\t\t\t\t\t\t<label for=\"type\" class=\"form-label\">Tipo de Observación</label>\n";
$code .= "\t\t\t\t\t\t\t\t\t\t\t\t<select class=\"form-select\" id=\"type\" required>\n";

$listTypesObservations = LIST_TYPES_OBSERVATIONS;
$defaultOption = array_filter($listTypesObservations, function ($item) {
    return $item['value'] === '';
});
$sortedOptions = array_filter($listTypesObservations, function ($item) {
    return $item['value'] !== '';
});
usort($sortedOptions, function ($a, $b) {
    return strcmp($a['label'], $b['label']);
});
$listTypesObservations = array_merge($defaultOption, $sortedOptions);
foreach ($listTypesObservations as $type) {
    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t<option value=\"{$type['value']}\">{$type['label']}</option>\n";
}


$code .= "\t\t\t\t\t\t\t\t\t\t\t\t</select>\n";
$code .= "\t\t\t\t\t\t\t\t\t\t</div>\n";
$code .= "\t\t\t\t\t\t\t\t\t\t<div class=\"mb-3\">\n";
$code .= "\t\t\t\t\t\t\t\t\t\t\t\t<label for=\"content\" class=\"form-label\">Observación</label>\n";
$code .= "\t\t\t\t\t\t\t\t\t\t\t\t<textarea class=\"form-control\" id=\"content\" rows=\"3\" required></textarea>\n";
$code .= "\t\t\t\t\t\t\t\t\t\t</div>\n";
$code .= "\t\t\t\t\t\t\t\t</form>\n";
$code .= "\t\t\t\t\t\t</div>\n";
$code .= "\t\t\t\t\t\t<div class=\"modal-footer\">\n";
$code .= "\t\t\t\t\t\t\t\t<button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Cerrar</button>\n";
$code .= "\t\t\t\t\t\t\t\t<button type=\"button\" class=\"btn btn-primary\" onclick=\"guardarObservation()\">Guardar</button>\n";
$code .= "\t\t\t\t\t\t</div>\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t</div>\n";
$code .= "</div>\n";

$code .= "<!-- Modal de Confirmación -->\n";
$code .= "<div class=\"modal fade\" id=\"confirmarEliminacionModal\" tabindex=\"-1\" aria-labelledby=\"confirmarEliminacionModalLabel\" aria-hidden=\"true\">\n";
$code .= "\t\t<div class=\"modal-dialog\">\n";
$code .= "\t\t\t\t<div class=\"modal-content\">\n";
$code .= "\t\t\t\t\t\t<div class=\"modal-header\">\n";
$code .= "\t\t\t\t\t\t\t\t<h5 class=\"modal-title\" id=\"confirmarEliminacionModalLabel\">Confirmar Eliminación</h5>\n";
$code .= "\t\t\t\t\t\t\t\t<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>\n";
$code .= "\t\t\t\t\t\t</div>\n";
$code .= "\t\t\t\t\t\t<div class=\"modal-body\">\n";
$code .= "\t\t\t\t\t\t\t\t¿Está seguro de que desea eliminar esta observación?\n";
$code .= "\t\t\t\t\t\t</div>\n";
$code .= "\t\t\t\t\t\t<div class=\"modal-footer\">\n";
$code .= "\t\t\t\t\t\t\t\t<button type=\"button\" class=\"btn btn-danger\" id=\"btnConfirmarEliminacion\" onclick='deleteObservation()'>Eliminar</button>\n";
$code .= "\t\t\t\t\t\t\t\t<button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\" >Cancelar</button>\n";
$code .= "\t\t\t\t\t\t</div>\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t</div>\n";
$code .= "</div>\n";

echo($code);


?>
<script>

    let observacion_to_delete;

    function guardarObservation() {
        var type = document.getElementById('type').value;
        var content = document.getElementById('content').value;
        //console.log('Tipo:', type, 'Observación:', content);
        send(type, content);
    }

    function confirmDeleteObservation(observation) {
        observacion_to_delete = observation;
        const modal = new bootstrap.Modal(document.getElementById('confirmarEliminacionModal'));
        modal.show();
    }
    function deleteObservation() {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/sie/api/observations/json/delete/<?php echo($oid);?>', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onload = function () {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                //console.log('Observación eliminada exitosamente');
                updateObservations();
                var modal = bootstrap.Modal.getInstance(document.getElementById('confirmarEliminacionModal'));
                modal.hide();
                if (response.status === 403) {
                    alert(response.message);
                }
                //console.log(response);
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


    function send(type, content) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/sie/api/observations/json/create/<?php echo($oid);?>', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onload = function () {
            if (xhr.status === 200) {
                //console.log('Observación guardada exitosamente');
                updateObservations();
                var modal = bootstrap.Modal.getInstance(document.getElementById('observacionModal'));
                modal.hide();
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