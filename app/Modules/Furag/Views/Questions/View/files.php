<?php
$bootstrap = service('bootstrap');
$mattachments = model('App\Modules\Storage\Models\Storage_Attachments');

//[grid]----------------------------------------------------------------------------------------------------------------
$bgrid = $bootstrap->get_Grid();
$bgrid->set_Class("P-0 m-0");
$bgrid->set_Headers(array(
    array("content" => "#", "class" => "text-center text-nowrap align-middle"),
    array("content" => "Tipo", "class" => "text-center align-middle"),
    array("content" => "Archivo", "class" => "text-center align-middle"),
    array("content" => "Opciones", "class" => "text-center text-nowrap align-middle"),
));
$count = 0;
$files = $mattachments->where('object', $oid)->orderBy("created_at", "DESC")->findAll();
if (is_array($files)) {
    foreach ($files as $file) {
        $count++;

        $type = "Otro"; // Valor por defecto
        foreach (LIST_FILE_TYPES_GENERAL as $fileType) {
            if ($file["reference"] == $fileType["value"]) {
                $type = $fileType["label"];
                break;
            }
        }

        $url = $url=cdn_url($file["file"]);
        $url_delete = "#";
        $options = "";
        $cell_count = array("content" => $count, "class" => "text-center  align-middle",);
        $cell_type = array("content" => $type, "class" => "text-center  align-middle",);
        $cell_url = array("content" => "<a href=\"" . $url . "\" target=\"_blank\">" . $file["attachment"] . "</a>", "class" => "text-center  align-middle",);
        //$cell_url = array("content" => "{$file["attachment"]}", "class" => "text-center  align-middle",);


        if (get_LoggedIn()) {
            $cell_options = "<div class=\"btn-group w-auto\">";
            $cell_options .= "<a href=\"" . $url . "\" class=\"btn btn-sm btn-primary\" target=\"_blank\"><i class=\"fa-light fa-eye\"></i></a>";
            $cell_options .= "<a href=\"" . $url_delete . "\" data-attachment=\"" . $file["attachment"] . "\" class=\"btn btn-sm btn-danger  btn-delete\"><i class=\"fa-light fa-trash\"></i></a>";
            $cell_options .= "</div>";
        } else {
            $cell_options = "<div class=\"btn-group w-auto\">";
            $cell_options .= "<a href=\"" . $url . "\" class=\"btn btn-sm btn-primary\" target=\"_blank\"><i class=\"fa-light fa-eye\"></i></a>";
            $cell_options .= "</div>";
        }


        $bgrid->add_Row(array($cell_count, $cell_type, $cell_url, $cell_options));


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
foreach (LIST_FILE_TYPES_GENERAL as $type) {
    $value = $type["value"];
    $label = $type["label"];
    $code .= "\t\t\t\t\t\t\t\t<option value=\"{$value}\">{$label}</option>\n";
}
$code .= "\t\t\t\t\t\t</select>\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t\t\t<div class=\"col-md-7 p-2\">\n";
if (get_LoggedIn()) {
    $code .= "\t\t\t\t\t\t<input type=\"file\" class=\"form-control\" id=\"attachment\" multiple=\"multiple\">\n";
}
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t\t\t<div class=\"col-md-2 p-2\">\n";
if (get_LoggedIn()) {
    $code .= "\t\t\t\t\t\t<button type=\"button\" onclick=\"uploadFiles()\" class=\"btn btn-primary w-100\">Cargar</button>\n";
}
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
<!-- Upload Progress Modal -->
<div class="modal fade" id="uploadProgressModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="uploadProgressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadProgressModalLabel">Cargando archivo(s)</h5>
            </div>
            <div class="modal-body">
                <p>Por favor espere mientras se cargan los archivos...</p>
                <div class="progress">
                    <div id="uploadProgressBar" class="progress-bar progress-bar-striped progress-bar-animated"
                         role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Asegúrate de que el código HTML de la tabla se mantenga como está, pero asegúrate de que los botones de borrar tengan la clase "btn-delete" -->
<script>

    function uploadFiles() {
        const object = "<?php echo($oid);?>";
        const input = document.getElementById('attachment');
        const fileType = document.getElementById('fileType').value;
        const grid = document.getElementById('grid-files');
        const url = "/storage/uploader/single/sie/" + object + "?time=" + new Date().getTime();
        const files = input.files;

        if (files.length === 0) {
            alert('Por favor seleccione al menos un archivo');
            return;
        }

        const formData = new FormData();
        for (let i = 0; i < files.length; i++) {
            formData.append('attachment' + i, files[i]);
        }
        formData.append('reference', fileType);

        // Show the progress modal
        const uploadModal = new bootstrap.Modal(document.getElementById('uploadProgressModal'));
        uploadModal.show();

        const progressBar = document.getElementById('uploadProgressBar');

        const xhr = new XMLHttpRequest();
        xhr.open('POST', url, true);

        // Set up progress event
        xhr.upload.onprogress = function (e) {
            if (e.lengthComputable) {
                const percentComplete = Math.round((e.loaded / e.total) * 100);
                progressBar.style.width = percentComplete + '%';
                progressBar.textContent = percentComplete + '%';
                progressBar.setAttribute('aria-valuenow', percentComplete);
            }
        };

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                // Hide the modal when complete
                setTimeout(() => {
                    uploadModal.hide();
                    // Reset the form
                    document.getElementById('attachment').value = '';
                }, 500);

                if (xhr.status == 200) {
                    const response = JSON.parse(xhr.responseText);
                    refreshGridFiles();
                } else {
                    alert('Error al cargar los archivos');
                }
            }
        };

        xhr.send(formData);
    }


    function uploadFilesOLD() {
        const object = "<?php echo($oid);?>";
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
        const object = "<?php echo($oid);?>";
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
                table += '<th>Opciones</th>';
                table += '</tr>';
                for (let i = 0; i < files.length; i++) {
                    let url = "#";
                    let options = "";
                    options = "<div class=\"btn-group w-auto\">";
                    options += '<a href="' + url + '" class="btn btn-sm btn-primary" target="_blank"><i class="fa-light fa-eye"></i></a>';
                    options += '<a href="#" onclick="deleteAttachment(\'' + files[i].attachment + '\')" class="btn btn-sm btn-danger btn-delete" data-attachment="' + files[i].attachment + '"><i class="fa-light fa-trash"></i></a>';
                    options += "</div>";
                    const LIST_FILE_TYPES_GENERAL = {
                        <?php foreach (LIST_FILE_TYPES_GENERAL as $type) {?>
                        <?php echo("\"{$type['value']}\":\"{$type['label']}\",");?>
                        <?php }?>
                    };
                    let reference = LIST_FILE_TYPES_GENERAL[files[i].reference] || "Otro";
                    table += '<tr>';
                    table += '<td>' + (i + 1) + '</td>';
                    table += '<td>' + reference + '</td>';
                    table += '<td class="text-center"><a href="' + files[i].file + '" target="_blank">' + files[i].attachment + '</a></td>';
                    table += '<td>' + options + '</td>';
                    table += '</tr>';
                }
                table += '</table>';
                gridfiles.innerHTML = table;
            }
        };
        xhr.send(formData);
    }

</script>