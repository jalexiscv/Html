<?php

namespace App\Libraries;

class Croppie
{

    private $id;
    private $oid; //identidad de referencia que usara para ligar al archivo adjuntado a algun objeto de la base de datos por ejemplo una publicación (post)
    private $reference; // Es una referencia al tipo de archivo cargado segun su finción por ejemplo COVER, PROFILE_PHOTO
    private $html = array();
    private $type = "rectangle"; //hace referencia a la forma del recorte de la imagen si ser circle o rectangle
    private $image = false;

    /** Viewport= Area a recortar * */
    private $viewport_width = 720;
    private $viewport_height = 480;

    /** Boundary= Area de recortador * */
    private $boundary_width = 740;
    private $boundary_height = 500;
    private $default_image = "/themes/assets/images/empty-720x480.png";
    private $fieldName = "attachment";

    private $url = "/storage/images/croppie/1538146213";//Ruta destino de la traferencia de datos

    /**
     * Constructor de la clase
     * @param array $attributes
     */
    function __construct(array $attributes = array())
    {
        $this->id = $attributes['id'];
        $this->oid = $attributes['oid'];
        if (isset($attributes['viewport'])) {
            $this->viewport_width = $attributes['viewport']['width'];
            $this->viewport_height = $attributes['viewport']['height'];
            $this->type = $attributes['viewport']['type'];
        }
        if (isset($attributes['boundary'])) {
            $this->boundary_width = $attributes['boundary']['width'];
            $this->boundary_height = $attributes['boundary']['height'];
        }

        $this->url = "/storage/images/croppie/{$this->oid}";
        $this->reference = "DEFAULT";
        $js = base_url("/themes/assets/libraries/croppie/croppie.js?" . time());
        $css = base_url("/themes/assets/libraries/croppie/croppie.css");
        $this->add_Html("<link rel=\"stylesheet\" href=\"{$css}\" type=\"text/css\">");
        $this->add_Html("<script type=\"text/javascript\" charset=\"utf-8\" src=\"{$js}\"></script>");
    }

    private function add_Html($html)
    {
        array_push($this->html, $html);
    }

    /**
     * Permite establecer o modificar la ruta de almacenamiento de la imagen a cargar
     * @param type $path
     */
    public function set_Image($src)
    {
        if (!empty($src)) {
            $this->default_image = $src;
        }
    }

    /**
     * Permite establecer o modificar la ruta de almacenamiento de la imagen a cargar
     * @param type $path
     */
    public function set_Reference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * Permite establecer o modificar la ruta de almacenamiento de la imagen a cargar
     * @param type $path
     */
    public function set_Ajax($path)
    {
        $this->ajax = $path;
    }

    function __toString()
    {
        $this->add_Html($this->get_Field());
        $this->add_Html($this->get_Modal($this->id));
        $this->add_Html($this->get_JS());
        return (implode("\n", $this->html));
    }

    /**
     * Genera el codigo correspondiente al campo donde se visualizara el croppie y el
     * campo file para cargar el archivo.
     * @return string
     */

    private function get_Field(): string
    {
        $image = $this->image;
        $id = $this->id;
        if (!$image) {
            $image = $this->default_image;
        }
        $code = "<img src=\"{$image}\" id=\"profile-pic-{$id}\" class=\"croppie-img-fluid\" alt=\"\">\n";
        $code .= "<div class=\"croppie-input-group input-group\">\n";
        $code .= "\t <input type=\"hidden\" id=\"$id\" name=\"$id\">\n";
        $code .= "\t<input type=\"file\" class=\"croppie-file-input file-input\" id=\"$id-cropper\" name=\"$id-cropper\" hidden />\n";
        $code .= "\t<button type=\"button\" class=\"btn croppie-btn-file btn-file-$id\">\n";
        $code .= "\t\t<i class=\"bi " . ICON_ATTACH_FILE . "\"></i>\n";
        $code .= "\t</button>\n";
        $code .= "</div>\n";
        $code .= "<script>\n";
        $code .= "document.querySelector('.btn-file-$id').addEventListener('click', function() {\n";
        $code .= "\t\tdocument.getElementById('$id-cropper').click();\n";
        $code .= "});\n";
        $code .= "</script>\n";
        return ($code);
    }

    private function get_Modal($id, $mtype = "modal-620")
    {
        $c = "<div class=\"modal fade bg-light\" id=\"croppie-modal-{$id}\" tabindex=\"-1\" role=\"dialog\" aria-hidden=\"true\">\n";
        $c .= "    <div class=\"modal-dialog modal-lg\" role=\"document\">\n";
        $c .= "        <div class=\"modal-content\">\n";
        $c .= "            <input type=\"hidden\" name=\"\" value=\"\">\n";
        $c .= "            <div class=\"modal-header\">\n";
        $c .= "                <h5 class=\"modal-title\">" . lang("App.crop-image-and-upload") . "</h5>\n";
        $c .= "                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>\n";
        $c .= "            </div>\n";
        $c .= "            <div class=\"modal-body m-0 bgc-blue-l4\">\n";
        $c .= "                <div id=\"resizer\"></div>\n\n";
        $c .= "            </div>\n";
        $c .= "            <div class=\"modal-footer justify-content-center\">\n";
        $c .= "                <a class=\"btn btn-secondary rotate float-lef\" data-deg=\"90\" ><i class=\"fas fa-undo\"></i></a>\n";
        $c .= "                <a class=\"btn btn-secondary rotate float-right\" data-deg=\"-90\" ><i class=\"fas fa-redo\"></i></i></a>\n";
        $c .= "                <a id=\"croppie-upload-{$id}\" class=\"btn btn-danger \">" . lang("App.crop-and-upload") . "</a>\n";
        $c .= "            </div>\n";
        $c .= "        </div>\n";
        $c .= "    </div>\n";
        $c .= "</div>";
        return ($c);
    }

    /**
     * @return string
     */
    private function get_JS(): string
    {
        $js = "<script>\n";
        $js .= "\t document.addEventListener('DOMContentLoaded', function() {\n";
        $js .= "\t\t var croppie = null;\n";
        $js .= "\t\t var el = document.getElementById('resizer');\n";
        $js .= $this->_get_JSCropperRotate();
        $js .= $this->_get_JSCropperBase64ImageToBlob();
        $js .= $this->_get_JSCropperGetImage();
        $js .= $this->_get_JSCropperOnChange();
        $js .= $this->_get_JSCropperImageUpload();
        $js .= "\t });\n";
        $js .= "</script>";
        return ($js);
    }

    private function _get_JSCropperRotate()
    {
        //_updateCenterPoint.call(self, true);
        //_updateZoomLimits.call(self);
        //croppie.refresh();
        $code = "document.querySelectorAll(\".rotate\").forEach(function(element) {\n";
        $code .= "\t\telement.addEventListener(\"click\", function(event) {\n";
        $code .= "\t\t\t\tvar degrees = parseInt(this.dataset.deg);\n";
        $code .= "\t\t\t\tif (croppie && degrees) {\n";
        $code .= "\t\t\t\t\t\tcroppie.rotate(degrees);\n";
        $code .= "\t\t\t\t}\n";
        $code .= "\t\t});\n";
        $code .= "});\n";
        return ($code);
    }

    private function _get_JSCropperBase64ImageToBlob()
    {
        $js = "";
        $js .= "function base64ImageToBlob(str) {\n";
        $js .= "    // extract content type and base64 payload from original string\n";
        $js .= "    var pos = str.indexOf(';base64,');\n";
        $js .= "    var type = str.substring(5, pos);\n";
        $js .= "    var b64 = str.substr(pos + 8);\n";
        $js .= "    // decode base64\n";
        $js .= "    var imageContent = atob(b64);\n";
        $js .= "    // create an ArrayBuffer and a view (as unsigned 8-bit)\n";
        $js .= "    var buffer = new ArrayBuffer(imageContent.length);\n";
        $js .= "    var view = new Uint8Array(buffer);\n";
        $js .= "    // fill the view, using the decoded base64\n";
        $js .= "    for (var n = 0; n < imageContent.length; n++) {\n";
        $js .= "        view[n] = imageContent.charCodeAt(n);\n";
        $js .= "    }\n";
        $js .= "    // convert ArrayBuffer to Blob\n";
        $js .= "    var blob = new Blob([buffer],{type:type});\n";
        $js .= "    return(blob);\n";
        $js .= "}\n";
        return ($js);
    }

    private function _get_JSCropperGetImage()
    {
        $js = "";
        $js .= "function getImage(input, croppie) {\n";
        $js .= "    if (input.files && input.files[0]) {\n";
        $js .= "        var reader = new FileReader();\n";
        $js .= "        reader.onload = function(e) {\n";
        $js .= "            croppie.bind({\n";
        $js .= "                url: e.target.result,\n";
        $js .= "            });\n";
        $js .= "        }\n";
        $js .= "        reader.readAsDataURL(input.files[0]);\n";
        $js .= "            croppie.refresh();\n";
        $js .= "    }\n";
        $js .= "}\n";
        return ($js);
    }

    /**
     * @return string
     */
    private function _get_JSCropperOnChange(): string
    {
        $code = "var cropperInput = document.getElementById('$this->id-cropper');\n";
        $code .= "cropperInput.addEventListener(\"change\", function(event) {\n";
        $code .= "\t\tvar croppieModal = new bootstrap.Modal(document.getElementById('croppie-modal-$this->id'));\n";
        $code .= "\t\tcroppieModal.show();\n";
        $code .= "\n";
        $code .= "\t\t croppie = new Croppie(el, {\n";
        $code .= "        'viewport': {\n";
        $code .= "            'width':{$this->viewport_width},\n";
        $code .= "            'height':{$this->viewport_height},\n";
        $code .= "            'type':'{$this->type}'\n";
        $code .= "        },\n";
        $code .= "        'boundary': {\n";
        $code .= "            'width':{$this->boundary_width},\n";
        $code .= "            'height':{$this->boundary_height},\n";
        $code .= "        },\n";
        $code .= "        'enableZoom': true,\n";
        $code .= "        'mouseWheelZoom': 'ctrl',\n";
        $code .= "        'showZoomer': true,\n";
        $code .= "        'zoom': 0.1,\n";
        $code .= "        'enableOrientation': true,\n";
        $code .= "        'enableExif': true,\n";
        $code .= "        'enforceBoundary': true,\n";
        $code .= "\t\t});\n";
        $code .= "\t\tgetImage(event.target, croppie);\n";
        $code .= "});\n";
        return ($code);
    }

    /**
     * @return string
     */
    private function _get_JSCropperImageUpload(): string
    {
        $csrfName = $this->get_csrf_token_name();
        $csrfHash = $this->get_csrf_hash();
        $id = $this->id;
        $oid = $this->oid;
        $fid = $this->fieldName;
        $reference = $this->reference;

        $code = "var uploadButton = document.getElementById('croppie-upload-$id');\n";
        $code .= "uploadButton.addEventListener('click', function() {\n";
        $code .= "\t\tcroppie.result('base64').then(function(base64) {\n";
        $code .= "\t\t\t\t// Ocultar el modal de Bootstrap 5 de forma manual\n";
        $code .= "\t\t\t\tvar croppieModalElement = document.getElementById('croppie-modal-$id');\n";
        $code .= "\t\t\t\tvar croppieModal = bootstrap.Modal.getInstance(croppieModalElement);\n";
        $code .= "\t\t\t\tcroppieModal.hide();\n";
        $code .= "\n";
        $code .= "\t\t\t\t// Establecer el src de la imagen de perfil a la imagen de carga\n";
        $code .= "\t\t\t\tvar profilePic = document.getElementById(\"profile-pic-$id\");\n";
        $code .= "\t\t\t\tprofilePic.src = \"/themes/assets/images/preloader.gif\";\n";
        $code .= "\n";
        $code .= "\t\t\t\t// Crear instancia de FormData y agregar los datos necesarios\n";
        $code .= "\t\t\t\tvar url = \"$this->url\";\n";
        $code .= "\t\t\t\tvar data = new FormData();\n";
        $code .= "\t\t\t\tdata.append(\"$csrfName\", \"$csrfHash\");\n";
        $code .= "\t\t\t\tdata.append(\"field\", \"attachment\");\n";
        $code .= "\t\t\t\tdata.append(\"object\", \"$oid\");\n";
        $code .= "\t\t\t\tdata.append(\"reference\", \"$reference\");\n";
        $code .= "\t\t\t\tdata.append(\"$fid\", base64ImageToBlob(base64)); // Asumiendo que 'base64ImageToBlob' es una función definida\n";
        $code .= "\n";
        $code .= "\t\t\t\t// Hacer la solicitud fetch\n";
        $code .= "\t\t\t\tfetch(url, {\n";
        $code .= "\t\t\t\t\t\tmethod: 'POST',\n";
        $code .= "\t\t\t\t\t\tbody: data\n";
        $code .= "\t\t\t\t})\n";
        $code .= "\t\t\t\t.then(function(response) {\n";
        $code .= "\t\t\t\t\t\treturn response.text();\t// o response.json() si el servidor responde con JSON\n";
        $code .= "\t\t\t\t})\n";
        $code .= "\t\t\t\t.then(function(responseData) {\n";
        $code .= "\t\t\t\t\t\tif (responseData == \"error\") {\n";
        $code .= "\t\t\t\t\t\t\t\tprofilePic.src = \"/themes/assets/images/empty-720x480.png\";\n";
        $code .= "\t\t\t\t\t\t} else {\n";
        $code .= "\t\t\t\t\t\t\t\tprofilePic.src = base64;\n";
        $code .= "\t\t\t\t\t\t\t\tvar croppieInput = document.getElementById(\"$id\");\n";
        $code .= "\t\t\t\t\t\t\t\tcroppieInput.value = responseData;\n";
        $code .= "\t\t\t\t\t\t}\n";
        $code .= "\t\t\t\t})\n";
        $code .= "\t\t\t\t.catch(function(error) {\n";
        $code .= "\t\t\t\t\t\tconsole.error(error);\n";
        $code .= "\t\t\t\t\t\tprofilePic.src = \"/themes/assets/images/empty-720x480.png\";\n";
        $code .= "\t\t\t\t});\n";
        $code .= "\t\t});\n";
        $code .= "});\n";
        $code .= "\n";
        $code .= "// Agregar un listener al modal para destruir la instancia de Croppie cuando se oculta\n";
        $code .= "var croppieModalElement = document.getElementById('croppie-modal-$id');\n";
        $code .= "croppieModalElement.addEventListener('hidden.bs.modal', function(e) {\n";
        $code .= "\t\tsetTimeout(function() {\n";
        $code .= "\t\t\t\tcroppie.destroy();\n";
        $code .= "\t\t}, 100);\n";
        $code .= "});\n";
        return ($code);
    }

    private function get_csrf_token_name()
    {
        return (csrf_token());
    }

    private function get_csrf_hash()
    {
        return (csrf_hash());
    }

    private function get_FieldOLD()
    {
        $image = $this->image;
        $id = $this->id;
        if (!$image) {
            $image = $this->default_image;
        }
        $c = "";
        $c .= "<img src=\"{$image}\" id=\"profile-pic-{$id}\" class=\"croppie-img-fluid\">\n";
        $c .= "<div class=\"croppie-custom-file\">";
        $c .= "     <input type=\"hidden\" id=\"{$id}\" name=\"{$id}\">\n";
        $c .= "     <input type=\"file\" class=\"croppie-custom-file-input\" id=\"{$id}-cropper\" name=\"{$id}-cropper\" text=\"" . lang("App.browse") . "\">";
        $c .= "     <label class=\"croppie-custom-file-label custom-file-control form-control-file form-control control-light\" for=\"customFile\">" . lang("App.choose-file") . "</label>";
        $c .= "</div>";
        return ($c);
    }


}

?>