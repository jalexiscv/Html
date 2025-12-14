<?php
$bootstrap = service('bootstrap');
$mattachments = model('App\Modules\Storage\Models\Storage_Attachments');

//[grid]----------------------------------------------------------------------------------------------------------------
$bgrid = $bootstrap->get_Grid();
$bgrid->set_Class("P-0 m-0");
$bgrid->set_Headers(array(
    array("content" => "#", "class" => "text-center text-nowrap align-middle"),
    array("content" => "Tipo", "class" => "text-left align-middle"),
    array("content" => "Archivo", "class" => "text-center align-middle"),
));
$count = 0;
/** @var TYPE_NAME $registration */
$files = $mattachments->where('object', $registration)->orderBy("created_at", "DESC")->findAll();
if (is_array($files)) {
    foreach ($files as $file) {
        $count++;

        $type = "Otro"; // Valor por defecto
        foreach (LIST_FILE_TYPES as $fileType) {
            if ($file["reference"] == $fileType["value"]) {
                $type = $fileType["label"];
                break;
            }
        }

        $url=cdn_url($file["file"]);
        $url_delete = "#";
        $options = "";
        $cell_count = array("content" => $count, "class" => "text-center  align-middle",);
        $cell_type = array("content" => $type, "class" => "text-left  align-middle",);
        $cell_url = array("content" => "<a href=\"" . $url . "\" target=\"_blank\">" . $file["attachment"] . "</a>", "class" => "text-center  align-middle",);
        $cell_options = "<div class=\"btn-group w-auto\">";
        $cell_options .= "<a href=\"" . $url . "\" class=\"btn btn-sm btn-primary\" target=\"_blank\"><i class=\"fa-light fa-eye\"></i></a>";
        $cell_options .= "<a href=\"" . $url_delete . "\" data-attachment=\"" . $file["attachment"] . "\" class=\"btn btn-sm btn-danger  btn-delete\"><i class=\"fa-light fa-trash\"></i></a>";
        $cell_options .= "</div>";
        $bgrid->add_Row(array($cell_count, $cell_type, $cell_url));
    }
} else {
    //mensaje no hay mallas
}
//[/grid]---------------------------------------------------------------------------------------------------------------
$code = "<!-- [files] //-->\n";
$code .= "<div class=\"container m-0 p-0\">\n";
$code .= "\t\t<form id=\"uploadForm\" class=\"row w-100 p-0 m-0\">\n";
$code .= "\t\t\t\t<div class=\"col-md-3 p-2\">\n";
$code .= "\t\t\t\t\t\t<select class=\"form-select\" id=\"fileType\">\n";
foreach (LIST_FILE_TYPES as $type) {
    $value = $type["value"];
    $label = $type["label"];
    $code .= "\t\t\t\t\t\t\t\t<option value=\"{$value}\">{$label}</option>\n";
}
$code .= "\t\t\t\t\t\t</select>\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t\t\t<div class=\"col-md-7 p-2\">\n";
$code .= "\t\t\t\t\t\t<input type=\"file\" class=\"form-control\" id=\"attachment\" multiple=\"multiple\">\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t\t\t<div class=\"col-md-2 p-2\">\n";
$code .= "\t\t\t\t\t\t<button type=\"button\" onclick=\"uploadFiles()\" class=\"btn btn-primary w-100\">Cargar</button>\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t</form>\n";
$code .= "\t\t<div class=\"row w-100 p-0 m-0\">\n";
$code .= "\t\t\t\t<div class=\"col-12 p-2\">\n";
$code .= "\t\t\t\t\t\t<div id=\"grid-files\">\n";
$code .= "\t\t\t\t\t\t{$bgrid}\n";
$code .= "\t\t\t\t\t</div>\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t</div>\n";
$code .= "</div>\n";
$code .= "<!-- [/files] //-->\n";
echo($code);
?>
<!-- Asegúrate de que el código HTML de la tabla se mantenga como está, pero asegúrate de que los botones de borrar tengan la clase "btn-delete" -->
<script>

    function uploadFiles() {
        const object = "<?php echo($registration);?>";
        const input = document.getElementById('attachment');
        const fileType = document.getElementById('fileType').value;
        const grid = document.getElementById('grid-files').value;
        const url = "/storage/uploader/single/sie/" + object + "?time=" + new Date().getTime();
        const files = input.files;
        const formData = new FormData();
        for (let i = 0; i < files.length; i++) {
            formData.append('attachment' + i, files[i]);
        }
        formData.append('reference', fileType);
        const xhr = new XMLHttpRequest();
        xhr.open('POST', url, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                const response = JSON.parse(xhr.responseText);
                refreshGridFiles();
                //console.log(response);
                //alert('Archivos cargados: ' + response.status)
            }
        };
        xhr.send(formData);
    }


    // Selecciona todos los botones con la clase "btn-delete"
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault(); // Previene la acción por defecto para permitir mostrar el diálogo de confirmación
            // Muestra el diálogo de confirmación
            const attachment = button.getAttribute('data-attachment');
            deleteAttachment(attachment);
        });
    });

    function deleteAttachment(attachment) {
        const confirmation = confirm("¿Estás seguro de que deseas eliminar este archivo?");
        if (confirmation) {
            let url = "/storage/api/files/delete/" + attachment + "?time=" + new Date().getTime();
            const formData = new FormData();
            formData.append('attachment', attachment)
            const xhr = new XMLHttpRequest();
            xhr.open('POST', url, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log("Archivo eliminado"); // Mensaje de prueba, remplázalo por tu lógica de eliminación
                    refreshGridFiles();
                }
            }
            xhr.send(formData);
        }
    }

    function refreshGridFiles() {
        const object = "<?php echo($registration);?>";
        const gridfiles = document.getElementById('grid-files');
        gridfiles.innerHTML = "";
        let url = "/storage/api/files/json/" + object + "?time=" + new Date().getTime();
        const formData = new FormData();
        const xhr = new XMLHttpRequest();
        xhr.open('POST', url, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                const json = JSON.parse(xhr.responseText);
                let files = json.files;
                let table = '<table class="table table-striped table-bordered table-hoverP-0 m-0">';
                table += '<tr>';
                table += '<th>#</th>';
                table += '<th>Tipo</th>';
                table += '<th>Archivo</th>';
                table += '</tr>';
                for (let i = 0; i < files.length; i++) {
                    let url = "#";
                    let options = "";
                    options = "<div class=\"btn-group w-auto\">";
                    options += "</div>";
                    const LIST_FILE_TYPES = {
                        <?php foreach (LIST_FILE_TYPES as $type) {?>
                        <?php echo("\"{$type['value']}\":\"{$type['label']}\",");?>
                        <?php }?>
                    };
                    let reference = LIST_FILE_TYPES[files[i].reference] || "Otro";
                    table += '<tr>';
                    table += '<td class="text-center">' + (i + 1) + '</td>';
                    table += '<td class="text-left">' + reference + '</td>';
                    table += '<td class="text-center"><a href="' + files[i].file + '" target="_blank">' + files[i].attachment + '</a></td>';
                    table += '</tr>';
                }
                table += '</table>';
                gridfiles.innerHTML = table;
            }
        };
        xhr.send(formData);
    }

</script>