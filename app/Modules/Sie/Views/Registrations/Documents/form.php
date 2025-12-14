<?php
$bootstrap = service('bootstrap');
$mattachments = model('App\Modules\Storage\Models\Storage_Attachments');

$f = service("forms", array("lang" => "Sie_Registrations."));
$registration = $f->get_Value("registration");

$back = "/sie/registrations/updates/" . lpk();
//[grid]----------------------------------------------------------------------------------------------------------------
//$oid = $registration;

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
        $type = "";
        foreach (LIST_FILE_TYPES as $lfile) {
            if ($file["reference"] == $lfile["value"]) {
                $type = $lfile["label"];
            }
        }
        $url = cdn_url($file["file"]);
        $url_delete = "#";
        $options = "<div class=\"btn-group w-auto\">";
        //$options .= "<a href=\"" . $url . "\" class=\"btn btn-sm btn-primary\" target=\"_blank\"><i class=\"fa-light fa-eye\"></i></a>";
        $options .= "<a href=\"#\" class=\"btn btn-sm btn-primary disabled\" target=\"_blank\"><i class=\"fa-light fa-eye\"></i></a>";
        //$options .= "<a href=\"" . $url_delete . "\" data-attachment=\"" . $file["attachment"] . "\" class=\"btn btn-sm btn-danger  btn-delete\"><i class=\"fa-light fa-trash\"></i></a>";
        $options .= "</div>";
        $cell_count = array("content" => $count, "class" => "text-center  align-middle",);
        $cell_type = array("content" => $type, "class" => "text-left  align-middle",);
        //$cell_url = array("content" => "<a href=\"" . $url . "\" target=\"_blank\">" . $file["attachment"] . "</a>", "class" => "text-center  align-middle",);
        $cell_url = array("content" => $file["attachment"], "class" => "text-center  align-middle",);
        $cell_options = array("content" => $options, "class" => "text-center  align-middle",);
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
$code .= "\t\t\t\t\t\t\t\t<option value=\"SIE-DT-01\">Documento de identidad</option>\n";
$code .= "\t\t\t\t\t\t\t\t<option value=\"SIE-DT-02\">Acta de grado bachiller</option>\n";
$code .= "\t\t\t\t\t\t\t\t<option value=\"SIE-DT-03\">Diploma bachiller o certificado de noveno grado concluido</option>\n";
$code .= "\t\t\t\t\t\t\t\t<option value=\"SIE-DT-04\">Certificado prueba de SABER11</option>\n";
$code .= "\t\t\t\t\t\t\t\t<option value=\"SIE-DT-05\">Un recibo de servicios públicos (lugar residencia)</option>\n";
$code .= "\t\t\t\t\t\t\t\t<option value=\"SIE-DT-06\">Certificado SISBEN</option>\n";
$code .= "\t\t\t\t\t\t\t\t<option value=\"SIE-DT-07\">Soporte de pago de inscripción</option>\n";
$code .= "\t\t\t\t\t\t\t\t<option value=\"SIE-DT-08\">Certificado electoral (Vigente)</option>\n";
$code .= "\t\t\t\t\t\t\t\t<option value=\"SIE-DT-09\">Foto digital en formato PNG o JPG tipo documento fondo blanco</option>\n";
$code .= "\t\t\t\t\t\t\t\t<option value=\"SIE-DT-10\">Documentos de homologación</option>\n";
$code .= "\t\t\t\t\t\t\t\t<option value=\"SIE-DT-16\">Certificado de EPS</option>\n";
$code .= "\t\t\t\t\t\t\t\t<option value=\"SIE-DT-17\">Certificado de Población Especial</option>\n";
$code .= "\t\t\t\t\t\t\t\t<option value=\"SIE-DT-18\">Pruebas TyT</option>\n";
$code .= "\t\t\t\t\t\t\t\t<option value=\"SIE-DT-99\">Otro (Fuera del listado)</option>\n";
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
$code .= "\t\t\t\t\t\</div>\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t</div>\n";
$code .= "</div>\n";
$code .= "<!-- [/files] //-->\n";
//[build]---------------------------------------------------------------------------------------------------------------
$politica = lang("Sie.snies_update_policy");
$message = "Selecciona cada elemento de la lista desplegable que encontrarás a continuación y carga el documento correspondiente. Es necesario cargar todos los documentos para completar el proceso.";
$message .= "<ul>";
$message .= "<li>Si usted no cuenta con el soporte de Acta de grado o diploma de Bachiller, ni Certificado de Prueba Saber 11 (ICFES) por favor diligenciar el siguiente documento (Acta de Compromiso) descargarlo, diligenciar, firmar y anexar en el campo solicitado del soporte del documento. (<a href='https://intranet.utede.edu.co/downloads/utede-acta-compromiso.pdf' target='_blank'>Anexo Formato</a>).</li>";
$message .= "<li>Recuerde que todos los documentos debe subirlos en formato PDF, no se tendrá en cuenta otro tipo de formato.</li>";
$message .= "<li>La foto debe ser digital, de buena calidad, en fondo blanco, tipo documento 3x4, en formato PNG o JPG, no se tendrá en cuenta otro tipo de formato.</li>";
$message .= "<li>Recuerde que nuestro medio de contacto será vía correo electrónico, le recomendamos revisar su bandeja de spam o correos no deseados.</li>";
$message .= "<li>Si solicita proceso de homologación, por favor anexar los siguientes documentos en el campo de homologación: (1)Títulos Académicos a Homologar Acta de Grado y Diploma (2)Reporte de Notas y Módulos Aprobados.</li>";
$message .= "</ul>";

$card = $bootstrap->get_Card("create", array(
        "title" => "Datos complementarios",
        "alert" => array(
                "type" => "info",
                "title" => "Recuerda",
                "message" => $politica . $message,
        ),
        "content" => $code,
        "header-back" => $back
));


echo($card);
include_once("policy.php");
?>
<script>

    function uploadFiles() {
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

    function getLabelByReference(referenceValue, referenceList) {
        for (let i = 0; i < referenceList.length; i++) {
            if (referenceList[i].value === referenceValue) {
                return referenceList[i].label;
            }
        }
        return "Referencia no encontrada";
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
                    //options += '<a href="#" onclick="deleteAttachment(\'' + files[i].attachment + '\')" class="btn btn-sm btn-danger btn-delete" data-attachment="' + files[i].attachment + '"><i class="fa-light fa-trash"></i></a>';
                    options += "</div>";
                    // Aqui necesito que el vector de php "LIST_FILE_TYPES" se convierta en un array de js
                    // para poder comparar el valor de "reference" con el valor de "value" y mostrar el "label"
                    let reference =<?php echo json_encode(LIST_FILE_TYPES); ?>;
                    let referenceLabel = getLabelByReference(files[i].reference, reference);
                    table += '<tr>';
                    table += '<td>' + (i + 1) + '</td>';
                    table += '<td>' + referenceLabel + '</td>';
                    table += '<td class="text-center"><a href="' + files[i].file + '" target="_blank">' + files[i].attachment + '</a></td>';
                    table += '<td class="text-center">' + options + '</td>';
                    table += '</tr>';
                }
                table += '</table>';
                gridfiles.innerHTML = table;
            }
        };
        xhr.send(formData);
    }
</script>
<!-- Asegúrate de que el código HTML de la tabla se mantenga como está, pero asegúrate de que los botones de borrar tengan la clase "btn-delete" -->
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
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
</script>