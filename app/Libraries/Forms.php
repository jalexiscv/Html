<?php

namespace App\Libraries;

use App\Libraries\Html\HtmlTag;
use Config\Services;
use Exception;

/**
 * Form v2.0
 */
class Forms
{

    public $fields = array();
    public $groups = array();
    public $validation;
    public $request;
    private $id;
    private $html = array();
    private $script = array();
    private $helps = array();
    private $lang = null;
    private $bootstrap;

    private $send;

    public function __construct($a = array())
    {
        helper("form");
        $this->bootstrap = service("bootstrap");
        $this->request = Services::request();
        $post = ($this->request->fetchGlobal("post"));
        /**
         * El atributo submited sirve para saber si se estan recibiendo datos
         * y para aplicarlas validaciones de los campos envidos por un formulario
         * ya que en esencia el subited es la identidad del formulario que envia
         * y con dicha identidad se reconstruyen procesos como la validación
         * o recepción trasparente de datos.
         */
        if (isset($post["submited"])) {
            $this->id = $post["submited"];
        } else {
            $this->id = $this->_get_Attribute("id", $a, "form_" . uniqid());
        }
        $this->lang = $this->_get_Attribute("lang", $a, "App.");
        $this->send = $this->_get_Attribute("send", $a, true);
        $action = $this->_get_Attribute("action", $a, current_url() . "?session=" . session_id() . "&time=" . time());
        $form_attributes = array("id" => $this->id);
        $form_hiddens = array("submited" => $this->id);
        array_push($this->html, form_open_multipart($action, $form_attributes, $form_hiddens));
        $this->validation = Services::validation();
    }

    /**
     * Lee valores de un vector a manera de atributos asignando un valor por
     * defecto en caso de que el atributo seleccionado no exista o este vacio.
     * @param type $name
     * @param type $list
     * @param type $default
     * @return type
     */
    private function _get_Attribute(string $name, array $list, string $default)
    {
        if (!empty($list[$name])) {
            return ($list[$name]);
        } else {
            return ($default);
        }
    }

    /**
     * Emulación de campo usada para solamente visualizar
     * @param type $id
     * @param type $attributes
     * @param type $extra
     * @return string
     */
    public function get_FieldViewDESCARTED($id, $attributes = array(), $extra = "")
    {
        if (is_array($attributes)) {
            $label = $this->_get_AttrLabel($attributes, $id);
            $value = $this->_get_AttrValue($attributes, $id);
            $proportion = $this->_get_AttrProportion($attributes);
            $code = "<div class=\"field border p-2 {$proportion}\">";
            $code .= "<small class=\"text-muted\">$label</small>: </br>";
            $code .= "$value";
            $code .= "</div>";
            return ($code);
        } else {
            return ("Un vector es requerido!");
        }
    }

    private function _get_AttrLabel($attributes, $id)
    {
        return ($this->__get_Attr("label", $attributes, $id));
    }

    /**
     * El placeholder debe ubicarse antes de que el ide se torne no nativo.
     * Retorn el PlaceHolder de un campo.
     * @param type $attributes
     * @return type
     */
    private function __get_Attr($name, $attributes, $id)
    {
        $default = lang("{$this->lang}{$name}_{$id}");
        $placeholder = $this->_get_Attribute($name, $attributes, $default);
        return ($placeholder);
    }

    private function _get_AttrValue($attributes, $id)
    {
        $id = $this->id . "_" . $id;
        $value = isset($attributes["value"]) ? $attributes["value"] : $this->get_Value($id);
        return ($value);
    }

    public function get_Value($field, $default = "", $urlencoded = false)
    {
        $s = service('strings');
        $get = $this->request->getPost($this->id . "_" . $field);
        $value = !empty($get) ? $get : $default;
        if ($urlencoded) {
            return (urlencode($value));
        } else {
            return (!is_array($value) ? $s->get_Trim($value) : $value);
        }
    }

    /**
     * Se usa para definir la proporsión de los contenedores de los diferentes campos, basicamente
     * proporsiona porsentualmente el tamaño del contenedor de un campo.
     * @param type $attributes
     * @return type
     */
    private function _get_AttrProportion($attributes)
    {
        $proportion = isset($attributes["proportion"]) ? "{$attributes["proportion"]} col " : "col ";
        return ($proportion);
    }


    public function get_FieldCitySearch($id, $attributes = array(), $extra = "")
    {
        if (is_array($attributes)) {
            $crf = $this->_get_AttrCRF($attributes);
            $fid = $this->_get_AttrId($id, $crf);
            $formid = $this->id;
            $proportion = $this->_get_AttrProportion($attributes);
            $text_label = $this->_get_AttrLabel($attributes, $id) . ":";
            $text_help = $this->_get_AttrHelp($attributes, $id);
            $value = $this->_get_AttrValue($attributes, $id);
            $placeholder = $this->_get_AttrPlaceHolder($attributes, $id);
            $readonly = $this->_get_AttrReadOnly($attributes);

            $cityDetails = HtmlTag::tag('p');
            $cityDetails->attr('id', $fid . '_cityDetails');
            $cityDetails->attr('class', 'mb-0');
            $selectedCityDetails = HtmlTag::tag('div');
            $selectedCityDetails->attr('id', $fid . '_selectedCityDetails');
            $selectedCityDetails->attr('class', 'mt-3 d-none');
            $selectedCityDetails->content($cityDetails);

            $input = HtmlTag::tag('input');
            $input->attr('id', $fid);
            $input->attr('name', $fid);
            $input->attr('type', "text");
            $input->attr('placeholder', lang($placeholder));
            $input->attr('value', $value);
            if ($readonly) {
                $input->attr('readonly', "true");
                $input->attr('class', 'form-control control-light readonly');
            } else {
                $input->attr('class', 'form-control control-light');
            }

            $input_group = HtmlTag::tag('div');
            $input_group->attr('class', 'input-group');
            $input_group->content(array($input));
            $label = HtmlTag::tag('label');
            $label->attr('id', "{$fid}_label");
            $label->attr('for', $fid);
            $label->content(lang($text_label));
            $help = HtmlTag::tag('div');
            $help->attr('class', 'help-block');
            $help->content(lang($text_help));
            $col = HtmlTag::tag('div');
            $col->attr('class', "field " . $proportion);
            $col->content(array($label, $input_group, $help));


            $code = "<script>";
            $code .= "\t\t\t\tfunction initGooglePlaces() {\n";
            $code .= "\t\t\t\t\t\t// Obtener el elemento input\n";
            $code .= "\t\t\t\t\t\tconst input = document.getElementById('{$fid}');\n";
            $code .= "\t\t\t\t\t\tconst detailsDiv = document.getElementById('{$fid}_selectedCityDetails');\n";
            $code .= "\t\t\t\t\t\tconst cityDetailsText = document.getElementById('{$fid}_cityDetails');\n";
            $code .= "\t\t\t\t\t\tconst hiddenCity = document.getElementById('{$formid}_selected_city');\n";
            $code .= "\t\t\t\t\t\tconst hiddenCountry = document.getElementById('{$formid}_selected_country');\n";


            $code .= "\n";
            $code .= "\t\t\t\t\t\t// Configurar las opciones del autocompletado\n";
            $code .= "\t\t\t\t\t\tconst options = {\n";
            $code .= "\t\t\t\t\t\t\t\ttypes: ['(cities)'], // Restringir la búsqueda solo a ciudades\n";
            $code .= "\t\t\t\t\t\t\t\tfields: ['address_components', 'geometry', 'formatted_address']\n";
            $code .= "\t\t\t\t\t\t};\n";
            $code .= "\n";
            $code .= "\t\t\t\t\t\t// Crear el objeto de autocompletado\n";
            $code .= "\t\t\t\t\t\tconst autocomplete = new google.maps.places.Autocomplete(input, options);\n";
            $code .= "\n";
            $code .= "\t\t\t\t\t\t// Manejar el evento cuando se selecciona una ciudad\n";
            $code .= "\t\t\t\t\t\tautocomplete.addListener('place_changed', function() {\n";
            $code .= "\t\t\t\t\t\t\t\tconst place = autocomplete.getPlace();\n";
            $code .= "\t\t\t\t\t\t\t\t\n";
            $code .= "\t\t\t\t\t\t\t\tif (!place.geometry) {\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t// Si el usuario presiona enter sin seleccionar un lugar\n";
            $code .= "\t\t\t\t\t\t\t\t\t\tinput.value = '';\n";
            $code .= "\t\t\t\t\t\t\t\t\t\treturn;\n";
            $code .= "\t\t\t\t\t\t\t\t}\n";
            $code .= "\n";
            $code .= "\t\t\t\t\t\t\t\t// Obtener los componentes de la dirección\n";
            $code .= "\t\t\t\t\t\t\t\tconst cityComponent = place.address_components.find(\n";
            $code .= "\t\t\t\t\t\t\t\t\t\tcomponent => component.types.includes('locality')\n";
            $code .= "\t\t\t\t\t\t\t\t);\n";
            $code .= "\t\t\t\t\t\t\t\tconst countryComponent = place.address_components.find(\n";
            $code .= "\t\t\t\t\t\t\t\t\t\tcomponent => component.types.includes('country')\n";
            $code .= "\t\t\t\t\t\t\t\t);\n";
            $code .= "\n";
            $code .= "\t\t\t\t\t\t\t\t// Crear el texto con los detalles\n";
            $code .= "\t\t\t\t\t\t\t\tconst cityName = cityComponent ? cityComponent.long_name : '';\n";
            $code .= "\t\t\t\t\t\t\t\tconst country = countryComponent ? countryComponent.long_name : '';\n";
            $code .= "\t\t\t\t\t\t\t\tconst lat = place.geometry.location.lat();\n";
            $code .= "\t\t\t\t\t\t\t\tconst lng = place.geometry.location.lng();\n";
            // Asignar valores a los campos ocultos
            $code .= "\t\t\t\t\t\t\t\tif (hiddenCity) hiddenCity.value = cityName;\n";
            $code .= "\t\t\t\t\t\t\t\tif (hiddenCountry) hiddenCountry.value = country;\n";
            // Mostrar los detalles";
            //$code.="\t\t\t\t\t\t\t\tcityDetailsText.innerHTML = `\n";
            //$code.="\t\t\t\t\t\t\t\t\t\tCiudad: \${cityName}<br>\n";
            //$code.="\t\t\t\t\t\t\t\t\t\tPaís: \${country}<br>\n";
            //$code.="\t\t\t\t\t\t\t\t\t\tCoordenadas: \${lat.toFixed(6)}, \${lng.toFixed(6)}\n";
            $code .= "\t\t\t\t\t\t\t\t// Mostrar el div de detalles\n";
            $code .= "\t\t\t\t\t\t\t\tdetailsDiv.classList.remove('d-none');\n";
            $code .= "\n";
            $code .= "\t\t\t\t\t\t\t\t// Aquí puedes agregar código para enviar estos datos a tu backend\n";
            $code .= "\t\t\t\t\t\t\t\tconst cityData = {\n";
            $code .= "\t\t\t\t\t\t\t\t\t\tname: cityName,\n";
            $code .= "\t\t\t\t\t\t\t\t\t\tcountry: country,\n";
            $code .= "\t\t\t\t\t\t\t\t\t\tcoordinates: {\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\tlat: lat,\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\tlng: lng\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t},\n";
            $code .= "\t\t\t\t\t\t\t\t\t\tfullAddress: place.formatted_address\n";
            $code .= "\t\t\t\t\t\t\t\t};\n";
            $code .= "\t\t\t\t\t\t\t\tconsole.log('Datos de la ciudad:', cityData);\n";
            $code .= "\t\t\t\t\t\t});\n";
            $code .= "\t\t\t\t}\n";
            $code .= "</script>";
            $this->add_Html($code);
            return ($col->render());
        } else {
            return ("Un vector es requerido!");
        }
    }


    public function get_FieldView($id, $attributes = array(), $extra = "")
    {
        if (is_array($attributes)) {
            $input = $this->_get_View(array(
                    "id" => $this->_get_AttrId($id),
                    "name" => $this->_get_AttrId($id),
                    "type" => "text",
                    "class" => "control-view " . $this->_get_AttrClass($attributes),
                    "placeholder" => $this->_get_AttrPlaceHolder($attributes, $id),
                    "value" => $this->_get_AttrValue($attributes, $id),
                    "readonly" => $this->_get_AttrReadOnly($attributes),
                    "autocomplete" => $this->_get_AttrAutoComplete($attributes),
                    "required" => $this->_get_AttrRequired($attributes))
            );
            $field = "\n\t\t <!-- field-text-{$id} //-->";
            $field .= $this->_get_InputField(array(
                    "label" => $this->get_Label($id, array("text" => $this->_get_AttrLabel($attributes, $id))),
                    "group" => $this->_get_InputGroup($input),
                    "help" => $this->get_Help($this->_get_AttrHelp($attributes, $id)),
                    "proportion" => $this->_get_AttrProportion($attributes)
                )
            );
            return ($field);
        } else {
            return ("Un vector es requerido!");
        }
    }

    private function _get_View($data = '', $value = '', $extra = '')
    {
        $defaults = array(
            'type' => 'text',
            'name' => is_array($data) ? '' : $data,
            'value' => $value
        );
        return '<div style="height: auto;" ' . $this->_parse_form_attributes($data, $defaults) . $this->_attributes_to_string($extra) . ">{$data["value"]}&nbsp; </div>";
    }

    /**
     * Parse the form attributes
     *
     * Helper function used by some of the form helpers
     *
     * @param array $attributes List of attributes
     * @param array $default Default values
     * @return    string
     */
    private function _parse_form_attributes($attributes, $default)
    {
        if (is_array($attributes)) {
            foreach ($default as $key => $val) {
                if (isset($attributes[$key])) {
                    $default[$key] = $attributes[$key];
                    unset($attributes[$key]);
                }
            }
            if (count($attributes) > 0) {
                $default = array_merge($default, $attributes);
            }
        }

        $att = '';

        foreach ($default as $key => $val) {
            if ($key === 'value') {
                $val = html_escape($val);
            } elseif ($key === 'name' && !strlen($default['name'])) {
                continue;
            }
            if (!empty(trim($val)) || $key === 'value') {
                $att .= $key . '="' . $val . '" ';
            }
        }

        return $att;
    }

    /**
     * Attributes To String
     *
     * Helper function used by some of the form helpers
     *
     * @param mixed
     * @return    string
     */
    private function _attributes_to_string($attributes)
    {
        if (empty($attributes)) {
            return '';
        }

        if (is_object($attributes)) {
            $attributes = (array)$attributes;
        }

        if (is_array($attributes)) {
            $atts = '';

            foreach ($attributes as $key => $val) {
                $atts .= ' ' . $key . '="' . $val . '"';
            }

            return $atts;
        }

        if (is_string($attributes)) {
            return ' ' . $attributes;
        }

        return FALSE;
    }

    private function _get_AttrId($id, $crf = true)
    {
        if (!$crf) {
            $id = $id;
        } else {
            $id = $this->id . "_" . $id;
        }
        return ($id);
    }

    private function _get_AttrClass($attributes, $default = "form-control control-light")
    {
        return ($this->_get_Attribute("class", $attributes, $default));
    }

    private function _get_AttrHref($attributes, $default = "")
    {
        return ($this->_get_Attribute("href", $attributes, $default));
    }

    private function _get_AttrIcon($attributes, $default = "")
    {
        return ($this->_get_Attribute("icon", $attributes, $default));
    }


    private function _get_AttrPlaceHolder($attributes, $id)
    {
        return ($this->__get_Attr("placeholder", $attributes, $id));
    }

    private function _get_AttrReadOnly($attributes)
    {
        $readonly = isset($attributes["readonly"]) ? true : false;
        return ($readonly);
    }

    private function _get_AttrHidden($attributes)
    {
        $hidden = isset($attributes["hidden"]) ? true : false;
        return ($hidden);
    }

    private function _get_AttrAutoComplete($attributes)
    {
        $readonly = isset($attributes["autocomplete"]) ? $attributes["autocomplete"] : "off";
        return ($readonly);
    }

    private function _get_AttrRequired($attributes)
    {
        if (isset($attributes["required"])) {
            return ($attributes["required"]);
        } else {
            return (false);
        }
    }

    private function _get_InputField($a = array())
    {
        $id = isset($a["id"]) ? $a["id"] : "";
        $label = isset($a["label"]) ? $a["label"] : "";
        $group = isset($a["group"]) ? $a["group"] : "";
        $help = isset($a["help"]) ? $a["help"] : "";
        $proportion = isset($a["proportion"]) ? $a["proportion"] : "";
        $elements = $label . $group . $help;
        $return = "<div id=\"{$id}\" class=\"{$proportion}\">{$elements}</div>";
        return ($return);
    }

    /**
     * Este metodo permite generar una etiqueta Html tipo Label, De forma similar a otras funciones,
     * puede  enviar una matriz asociativa en el tercer parámetro si prefiere establecer atributos adicionales.
     * @param $text (string ) - Texto para poner en la etiqueta label
     * @param $id (string ) - ID del elemento de formulario para el que estamos haciendo una etiqueta
     * @param $attributes ( mixed ) - Atributos de HTML
     * @return type (string ) - Una etiqueta de etiqueta de campo HTML
     */
    public function get_Label($id, $attr = array())
    {
        $text = isset($attr["text"]) ? $attr["text"] : "";
        if (strlen($text) > 0) {
            $label = "<label for=\"{$id}\">{$text}</label>: ";
        } elseif ($text === false) {
            $label = "";
        } else {
            $label = "<label for=\"{$id}\"> </label>";
        }
        return ($label);
    }

    private function _get_InputGroup($content, $align = "left")
    {
        if (is_array($content)) {
            $class = isset($content["class"]) ? $content["class"] : "";
            $content = isset($content["content"]) ? $content["content"] : "";
            $c = "<div class=\"input-group {$class}\">{$content}</div>";
        } else {
            $c = "<div class=\"input-group\">{$content}</div>";
        }
        return ($c);
    }

    public function get_Help($msg)
    {
        if (!empty($msg)) {
            $html = "<div class=\"help-block\">";
            $html .= $msg;
            $html .= "</div>";
            return ($html);
        } else {
            return ("");
        }
    }

    private function _get_AttrHelp($attributes, $id)
    {
        return ($this->__get_Attr("help", $attributes, $id));
    }

    public function get_FieldViewImage($id, $attributes = array(), $extra = "")
    {
        if (is_array($attributes)) {
            $crf = $this->_get_AttrCRF($attributes);
            $fid = $this->_get_AttrId($id, $crf);
            $proportion = $this->_get_AttrProportion($attributes);
            $text_label = $this->_get_AttrLabel($attributes, $id) . ":";
            $text_help = $this->_get_AttrHelp($attributes, $id);
            $placeholder = $this->_get_AttrPlaceHolder($attributes, $id);
            $value = $this->_get_AttrValue($attributes, $id);
            $img = HtmlTag::tag('img');
            $img->attr('class', 'w-100');
            $img->attr('src', $value);
            $img->content('');
            $input_group = HtmlTag::tag('div');
            $input_group->attr('class', 'input-group');
            $input_group->content(array($img));
            $label = HtmlTag::tag('label');
            $label->attr('for', $fid);
            $label->content(lang($text_label));
            $help = HtmlTag::tag('div');
            $help->attr('class', 'help-block');
            $help->content(lang($text_help));
            $col = HtmlTag::tag('div');
            $col->attr('class', $proportion);
            $col->content(array($label, $input_group, $help));
            //$this->add_Script("");
            return ($col->render());
        } else {
            return ("Un vector es requerido!");
        }
    }

    private function _get_AttrCRF($attributes)
    {
        return (!isset($attributes["crf"]) ? true : $attributes["crf"]);
    }


    public function get_FieldViewFile($id, $attributes = array(), $extra = "")
    {
        if (is_array($attributes)) {
            $crf = $this->_get_AttrCRF($attributes);
            $fid = $this->_get_AttrId($id, $crf);
            $proportion = $this->_get_AttrProportion($attributes);
            $text_label = $this->_get_AttrLabel($attributes, $id) . ":";
            $text_help = $this->_get_AttrHelp($attributes, $id);
            $placeholder = $this->_get_AttrPlaceHolder($attributes, $id);
            $value = $this->_get_AttrValue($attributes, $id);
            $licon = HtmlTag::tag('i');
            $licon->attr('class', 'fas fa-link');
            $licon->content('');
            $ricon = HtmlTag::tag('i');
            $ricon->attr('class', 'far fa-eye');
            $ricon->attr('id', $fid . 'ricon');
            $ricon->attr('style', 'cursor: pointer');
            $ricon->content('');
            $left = HtmlTag::tag('span');
            $left->attr('class', 'input-group-text bg-secondary text-white');
            $left->content(array($licon));
            $input = HtmlTag::tag('input');
            $input->attr('class', 'form-control control-light');
            $input->attr('id', $fid);
            $input->attr('name', $fid);
            $input->attr('type', "text");
            $input->attr('placeholder', lang($placeholder));
            $input->attr('value', $value);
            $right = HtmlTag::tag('span');
            $right->attr('class', 'input-group-text bg-secondary text-white js-toggle-file');
            $right->attr('id', $fid . 'toggleFile');
            $right->attr('data-url', ($value));
            $right->attr('onclick', "window.ui.openModalViewer('".($value)."');");
            $right->content(array($ricon));
            $input_group = HtmlTag::tag('div');
            $input_group->attr('class', 'input-group');
            $input_group->content(array($left, $input, $right));
            $label = HtmlTag::tag('label');
            $label->attr('for', $fid);
            $label->content(lang($text_label));
            $help = HtmlTag::tag('div');
            $help->attr('class', 'help-block');
            $help->content(lang($text_help));
            $col = HtmlTag::tag('div');
            $col->attr('class', $proportion);
            $col->content(array($label, $input_group, $help));
            //$this->add_Script("");
            return ($col->render());
        } else {
            return ("Un vector es requerido!");
        }
    }


    private function _js_modal_file_viewer($url)
    {

    }






    /**
     * Emulación de campo usada para solamente visualizar
     * @param type $id
     * @param type $attributes
     * @param type $extra
     * @return type
     */
    public function get_FieldViewArea($id, $attributes = array(), $extra = "")
    {
        if (is_array($attributes)) {
            $value = $this->_get_AttrValue($attributes, $id);
            $input = "<div class=\"form-control control-light-area w-100\">{$value}</div>";
            $field = "\n\t\t <!-- field-text-{$id} //-->";
            $field .= $this->_get_InputField(array(
                    "label" => $this->get_Label($id, array("text" => $this->_get_AttrLabel($attributes, $id))),
                    "group" => $this->_get_InputGroup($input),
                    "help" => $this->get_Help($this->_get_AttrHelp($attributes, $id)),
                    "proportion" => $this->_get_AttrProportion($attributes)
                )
            );
            return ($field);
        } else {
            return ("Un vector es requerido!");
        }
    }

    /**
     * Permite capturar un numero.
     * @param type $id
     * @param type $attributes
     * @return type
     */
    public function get_FieldPercentage($id, $attributes = array())
    {
        $crf = $this->_get_AttrCRF($attributes);
        $input = $this->_get_Input(array(
                "id" => $this->_get_AttrId($id, $crf),
                "name" => $this->_get_AttrId($id, $crf),
                "type" => "text",
                "class" => $this->_get_AttrClass($attributes),
                "placeholder" => $this->_get_AttrPlaceHolder($attributes, $id),
                "value" => $this->_get_AttrValue($attributes, $id),
                "readonly" => $this->_get_AttrReadOnly($attributes),
                "autocomplete" => $this->_get_AttrAutoComplete($attributes),
                "required" => $this->_get_AttrRequired($attributes))
        );
        $icon = $this->_get_Icon(Icons::get_Phone());
        $field = "\n\t\t <!-- field-text-{$id} //-->";
        $field .= $this->_get_InputField(array(
                "label" => $this->get_Label($id, array("text" => $this->_get_AttrLabel($attributes, $id))),
                "group" => $this->_get_InputGroup($input),
                "help" => $this->get_Help($this->_get_AttrHelp($attributes, $id)),
                "proportion" => $this->_get_AttrProportion($attributes)
            )
        );
        $script = "<script type=\"text/javascript\" src=\"/themes/assets/javascripts/touchspin/jquery.bootstrap-touchspin.js\"></script>";
        $js = "<script>";
        $js .= "  $(\"#{$this->_get_AttrId($id, $crf)}\").TouchSpin({\n";
        $js .= "    min: 0,\n";
        $js .= "    max: 100,\n";
        $js .= "    step: 0.1,\n";
        $js .= "    decimals: 2,\n";
        $js .= "    boostat: 5,\n";
        $js .= "    maxboostedstep: 10,\n";
        $js .= "    postfix: '%',\n";
        $js .= "    buttondown_class: 'btn btn-danger',\n";
        $js .= "    buttonup_class: 'btn btn-success',";
        $js .= "    buttondown_txt: '<i class=\"fa fa-minus\"></i>',";
        $js .= "    buttonup_txt: '<i class=\"fa fa-plus\"></i>',";
        $js .= "  });";
        $js .= "</script>";
        return ($script . $field . $js);
    }

    /**
     * Text Input Field
     * @param mixed
     * @param string
     * @param mixed
     * @return    string
     */
    private function _get_Input($data = '', $value = '', $extra = '')
    {
        $defaults = array(
            'type' => 'text',
            'name' => is_array($data) ? '' : $data,
            'value' => $value
        );

        return '<input ' . $this->_parse_form_attributes($data, $defaults) . $this->_attributes_to_string($extra) . " />";
    }

    /**
     *  Retorna el codigo para la visualización de un icono.
     * @param type $icon
     * @return type
     */
    private function _get_Icon($icon, $align = "left")
    {
        $c = "<span class=\"input-group-text-{$align}\">$icon</span>";
        return ($c);
    }

    /**
     * Permite capturar un numero.
     * @param type $id
     * @param type $attributes
     * @return string
     */


    function get_FieldNumber2($id, $attributes = array())
    {
        //string $label, string $name, ?int $currentValue
        $crf = $this->_get_AttrCRF($attributes);
        $currentValue = $this->_get_AttrValue($attributes, $id);
        $label = $this->_get_AttrLabel($attributes, $id);
        $name = $this->_get_AttrId($id, $crf);

        // Iniciar marcado HTML
        $html = '<div class="input-group mb-3">';

        // Agregar label
        $html .= '<label for="' . htmlspecialchars($name) . '" class="input-group-text">' . htmlspecialchars($label) . ':</label>';

        // Agregar input
        $html .= '<input type="number" class="form-control" name="' . htmlspecialchars($name) . '" id="' . htmlspecialchars($name) . '"';

        // Agregar valor actual si está presente
        if ($currentValue !== null) {
            $html .= ' value="' . htmlspecialchars((string)$currentValue) . '"';
        }

        // Finalizar el input y su contenedor
        $html .= ' min="0" step="1" oninput="validity.valid||(value=\'\');" required>';
        $html .= '</div>';

        // Retornar el marcado HTML
        return $html;
    }


    public function get_FieldCheckBoxes($id, $attributes = array())
    {
        $code = "\n\t\t <!-- field-checkbox-{$id} //-->";
        $options = $attributes["options"];
        foreach ($options as $option) {
            $value = $option["value"];
            $label = $option["label"];
            $code .= "\t\t<div class=\"form-check form-check-inline\">\n";
            $code .= "\t\t\t\t<input class=\"form-check-input\" type=\"checkbox\" value=\"{$value}\" id=\"jornada{$label}\">\n";
            $code .= "\t\t\t\t<label class=\"form-check-label\" for=\"jornada{$label}\">{$label}</label>\n";
            $code .= "\t\t</div>\n";
        }
        $field = "\n\t\t <!-- field-text-{$id} //-->";
        $field .= $this->_get_InputField(array(
                "label" => $this->get_Label($id, array("text" => $this->_get_AttrLabel($attributes, $id))),
                "group" => $this->_get_InputGroup(array("class" => "control-view", "content" => $code)),
                "help" => $this->get_Help($this->_get_AttrHelp($attributes, $id)),
                "proportion" => $this->_get_AttrProportion($attributes)
            )
        );
        return ($field);
    }


    public function get_FieldNumber($id, $attributes = array())
    {
        $crf = $this->_get_AttrCRF($attributes);
        $value = $this->_get_AttrValue($attributes, $id);
        $min = (isset($attributes["min"])) ? $attributes["min"] : "0.0";
        $max = (isset($attributes["max"])) ? $attributes["max"] : "1000000000.0";
        $decimals = (isset($attributes["decimals"])) ? $attributes["decimals"] : "0";
        $step = (isset($attributes["step"])) ? $attributes["step"] : "1.0";
        $oninput = (isset($attributes["oninput"])) ? $attributes["oninput"] : "validity.valid||(value='');";

        $input = $this->get_Input(array(
                "id" => $this->_get_AttrId($id, $crf),
                "name" => $this->_get_AttrId($id, $crf),
                "type" => "number",
                "class" => $this->_get_AttrClass($attributes),
                "placeholder" => $this->_get_AttrPlaceHolder($attributes, $id),
                "value" => $value,
                "min" => $min,
                "max" => $max,
                "step" => $step,
                "oninput" => $oninput,
                "readonly" => $this->_get_AttrReadOnly($attributes),
                "autocomplete" => $this->_get_AttrAutoComplete($attributes),
                "required" => $this->_get_AttrRequired($attributes))
        );
        $icon = $this->_get_Icon(Icons::get_Number());
        $field = "\n\t\t <!-- field-text-{$id} //-->";
        $field .= $this->_get_InputField(array(
                "label" => $this->get_Label($id, array("text" => $this->_get_AttrLabel($attributes, $id))),
                "group" => $this->_get_InputGroup($input),
                "help" => $this->get_Help($this->_get_AttrHelp($attributes, $id)),
                "proportion" => $this->_get_AttrProportion($attributes)
            )
        );
        return ($field);
    }

    private function get_Input($attributes)
    {
        $defaults = array(
            'type' => 'text',
            'name' => $attributes['id'] ?? "",
            'value' => $attributes['value'] ?? "",
        );
        return '<input ' . $this->_parse_form_attributes($attributes, $defaults) . " />";
    }

    /**
     * Permite capturar un numero.
     * @param type $id
     * @param type $attributes
     * @return type
     */
    public function get_FieldMoney($id, $attributes = array())
    {
        $crf = $this->_get_AttrCRF($attributes);
        $value = $this->_get_AttrValue($attributes, $id);
        $min = (isset($attributes["min"])) ? $attributes["min"] : "0.0";
        $max = (isset($attributes["max"])) ? $attributes["max"] : "1000000.0";
        $decimals = (isset($attributes["decimals"])) ? $attributes["decimals"] : "2";
        $step = (isset($attributes["step"])) ? $attributes["step"] : "500.0";

        $input = $this->_get_Input(array(
                "id" => $this->_get_AttrId($id, $crf),
                "name" => $this->_get_AttrId($id, $crf),
                "type" => "text",
                "class" => $this->_get_AttrClass($attributes),
                "placeholder" => $this->_get_AttrPlaceHolder($attributes, $id),
                "value" => $value,
                "readonly" => $this->_get_AttrReadOnly($attributes),
                "autocomplete" => $this->_get_AttrAutoComplete($attributes),
                "required" => $this->_get_AttrRequired($attributes))
        );
        $icon = $this->_get_Icon(Icons::get_Money());
        $field = "\n\t\t <!-- field-text-{$id} //-->";
        $field .= $this->_get_InputField(array(
                "label" => $this->get_Label($id, array("text" => $this->_get_AttrLabel($attributes, $id))),
                "group" => $this->_get_InputGroup($input),
                "help" => $this->get_Help($this->_get_AttrHelp($attributes, $id)),
                "proportion" => $this->_get_AttrProportion($attributes)
            )
        );
        $script = "<script type=\"text/javascript\" src=\"/themes/assets/javascripts/touchspin/jquery.bootstrap-touchspin.js\"></script>";
        $js = "<script>";
        $js .= "  $(\"#{$this->_get_AttrId($id, $crf)}\").TouchSpin({\n";
        $js .= "    min: {$min},\n";
        $js .= "    max: {$max},\n";
        $js .= "    step: {$step},\n";
        $js .= "    decimals:{$decimals},\n";
        $js .= "    boostat: 5,\n";
        $js .= "    maxboostedstep: 10,\n";
        $js .= "    postfix:'$',\n";
        $js .= "    buttondown_class: 'btn btn-danger',\n";
        $js .= "    buttonup_class: 'btn btn-success',";
        $js .= "    buttondown_txt: '<i class=\"fa fa-minus\"></i>',";
        $js .= "    buttonup_txt: '<i class=\"fa fa-plus\"></i>',";
        $js .= "  });";
        $js .= "</script>";
        return ($script . $field . $js);
    }

    /**
     * Retorna un campo tipo numero telefonico.
     * @param string $id
     * @param type $attributes
     * @return type
     */


    public function get_FieldPhone($id, $attributes = array(), $extra = "")
    {
        $crf = $this->_get_AttrCRF($attributes);
        $fid = $this->_get_AttrId($id, $crf);
        $proportion = $this->_get_AttrProportion($attributes);
        $text_label = $this->_get_AttrLabel($attributes, $id) . ":";
        $text_help = $this->_get_AttrHelp($attributes, $id);
        $value = $this->_get_AttrValue($attributes, $id);
        $placeholder = $this->_get_AttrPlaceHolder($attributes, $id);
        $licon = HtmlTag::tag('i');
        $licon->attr('class', 'far fa-phone-alt');
        $licon->content('');
        $left = HtmlTag::tag('span');
        $left->attr('class', 'input-group-text');
        $left->content(array($licon));
        $input = HtmlTag::tag('input');
        $input->attr('class', 'form-control control-light js-Higgs-input-mask');
        $input->attr('input-mask', '+(99)-999-9999999');
        $input->attr('id', $fid);
        $input->attr('name', $fid);
        $input->attr('type', "phone");
        $input->attr('placeholder', lang($placeholder));
        $input->attr('value', $value);
        $input_group = HtmlTag::tag('div');
        $input_group->attr('class', 'input-group');
        $input_group->content(array($left, $input));
        $label = HtmlTag::tag('label');
        $label->attr('for', $fid);
        $label->content(lang($text_label));
        $help = HtmlTag::tag('div');
        $help->attr('class', 'help-block');
        $help->content(lang($text_help));
        $col = HtmlTag::tag('div');
        $col->attr('class', $proportion);
        $col->content(array($label, $input_group, $help));
        return ($col->render());
    }


    public function get_FieldTime($id, $attributes = array(), $extra = "")
    {
        $crf = $this->_get_AttrCRF($attributes);
        $fid = $this->_get_AttrId($id, $crf);
        $proportion = $this->_get_AttrProportion($attributes);
        $text_label = $this->_get_AttrLabel($attributes, $id) . ":";
        $text_help = $this->_get_AttrHelp($attributes, $id);
        $value = $this->_get_AttrValue($attributes, $id);
        $placeholder = $this->_get_AttrPlaceHolder($attributes, $id);
        $licon = HtmlTag::tag('i');
        $licon->attr('class', ICON_CLOCK);
        $licon->content('');
        $left = HtmlTag::tag('span');
        $left->attr('class', 'input-group-text');
        $left->content(array($licon));
        $input = HtmlTag::tag('input');
        $input->attr('class', 'form-control timePicker');
        $input->attr('id', $fid);
        $input->attr('name', $fid);
        $input->attr('type', "time");
        $input->attr('placeholder', lang($placeholder));
        $input->attr('value', $value);
        $input_group = HtmlTag::tag('div');
        $input_group->attr('class', 'input-group');
        $input_group->content(array($left, $input));
        $label = HtmlTag::tag('label');
        $label->attr('for', $fid);
        $label->content(lang($text_label));
        $help = HtmlTag::tag('div');
        $help->attr('class', 'help-block');
        $help->content(lang($text_help));
        $col = HtmlTag::tag('div');
        $col->attr('class', $proportion);
        $col->content(array($label, $input_group, $help));
        return ($col->render());
    }


    public function get_FieldURL($id, $attributes = array(), $extra = "")
    {
        $crf = $this->_get_AttrCRF($attributes);
        $fid = $this->_get_AttrId($id, $crf);
        $proportion = $this->_get_AttrProportion($attributes);
        $text_label = $this->_get_AttrLabel($attributes, $id) . ":";
        $text_help = $this->_get_AttrHelp($attributes, $id);
        $value = $this->_get_AttrValue($attributes, $id);
        $placeholder = $this->_get_AttrPlaceHolder($attributes, $id);
        $licon = HtmlTag::tag('i');
        $licon->attr('class', 'fas fa-link');
        $licon->content('');
        $left = HtmlTag::tag('span');
        $left->attr('class', 'input-group-text');
        $left->content(array($licon));
        $input = HtmlTag::tag('input');
        $input->attr('class', 'form-control control-light');
        $input->attr('id', $fid);
        $input->attr('name', $fid);
        $input->attr('type', "text");
        $input->attr('placeholder', lang($placeholder));
        $input->attr('value', $value);
        $input_group = HtmlTag::tag('div');
        $input_group->attr('class', 'input-group');
        $input_group->content(array($left, $input));
        $label = HtmlTag::tag('label');
        $label->attr('for', $fid);
        $label->content(lang($text_label));
        $help = HtmlTag::tag('div');
        $help->attr('class', 'help-block');
        $help->content(lang($text_help));
        $col = HtmlTag::tag('div');
        $col->attr('class', $proportion);
        $col->content(array($label, $input_group, $help));
        return ($col->render());
    }

    /**
     * Permite obtener un dato tipo Alias de Usuario, es decir un valor alfanumerico utilizado para identificarse en el sistema.
     * @param $id
     * @param array $attributes
     * @param string $extra
     * @return string
     */
    public function get_FieldAlias($id, $attributes = array(), $extra = "")
    {
        $crf = $this->_get_AttrCRF($attributes);
        $fid = $this->_get_AttrId($id, $crf);
        $proportion = $this->_get_AttrProportion($attributes);
        $text_label = $this->_get_AttrLabel($attributes, $id) . ":";
        $text_help = $this->_get_AttrHelp($attributes, $id);
        $value = $this->_get_AttrValue($attributes, $id);
        $placeholder = $this->_get_AttrPlaceHolder($attributes, $id);
        $readonly = $this->_get_AttrReadOnly($attributes);
        $licon = HtmlTag::tag('i');
        $licon->attr('class', 'fas fa-at');
        $licon->content('');
        $left = HtmlTag::tag('span');
        $left->attr('class', 'input-group-text');
        $left->content(array($licon));
        $input = HtmlTag::tag('input');
        if ($readonly) {
            $input->attr('readonly', "true");
            $input->attr('class', 'form-control control-light readonly');
        } else {
            $input->attr('class', 'form-control control-light');
        }
        $input->attr('class', 'form-control control-light js-Higgs-input-mask');
        $input->attr('input-mask', '[*]{1,64}');
        $input->attr('id', $fid);
        $input->attr('name', $fid);
        $input->attr('type', "phone");
        $input->attr('placeholder', lang($placeholder));
        $input->attr('value', $value);
        $input_group = HtmlTag::tag('div');
        $input_group->attr('class', 'input-group');
        $input_group->content(array($left, $input));
        $label = HtmlTag::tag('label');
        $label->attr('for', $fid);
        $label->content(lang($text_label));
        $help = HtmlTag::tag('div');
        $help->attr('class', 'help-block');
        $help->content(lang($text_help));
        $col = HtmlTag::tag('div');
        $col->attr('class', $proportion);
        $col->content(array($label, $input_group, $help));
        return ($col->render());
    }

    /**
     * Retorna un campo de texto tipo email.
     * @param type $id
     * @param type $attributes
     * @param type $extra
     * @return type
     */


    public function get_FieldEmail($id, $attributes = array(), $extra = "")
    {
        $crf = $this->_get_AttrCRF($attributes);
        $fid = $this->_get_AttrId($id, $crf);
        $proportion = $this->_get_AttrProportion($attributes);
        $text_label = $this->_get_AttrLabel($attributes, $id) . ":";
        $text_help = $this->_get_AttrHelp($attributes, $id);
        $value = $this->_get_AttrValue($attributes, $id);
        $placeholder = $this->_get_AttrPlaceHolder($attributes, $id);
        $licon = HtmlTag::tag('i');
        $licon->attr('class', 'fa-regular fa-envelope');
        $licon->content('');
        $left = HtmlTag::tag('span');
        $left->attr('class', 'input-group-text');
        $left->content(array($licon));
        $input = HtmlTag::tag('input');
        $input->attr('class', 'form-control control-light');
        $input->attr('id', $fid);
        $input->attr('name', $fid);
        $input->attr('type', "email");
        $input->attr('placeholder', lang($placeholder));
        $input->attr('value', $value);
        $input_group = HtmlTag::tag('div');
        $input_group->attr('class', 'input-group');
        $input_group->content(array($left, $input));
        $label = HtmlTag::tag('label');
        $label->attr('for', $fid);
        $label->content(lang($text_label));
        $help = HtmlTag::tag('div');
        $help->attr('class', 'help-block');
        $help->content(lang($text_help));
        $col = HtmlTag::tag('div');
        $col->attr('class', $proportion);
        $col->content(array($label, $input_group, $help));
        return ($col->render());
    }

    /**
     * Retorna un campo tipo contraseña
     * @param type $id
     * @param type $attributes
     * @param type $extra
     * @return type
     */
    public function get_FieldPassword($id, $attributes = array(), $extra = "")
    {
        $crf = $this->_get_AttrCRF($attributes);
        $fid = $this->_get_AttrId($id, $crf);
        $proportion = $this->_get_AttrProportion($attributes);
        $text_label = $this->_get_AttrLabel($attributes, $id) . ":";
        $text_help = $this->_get_AttrHelp($attributes, $id);
        $placeholder = $this->_get_AttrPlaceHolder($attributes, $id);
        $value = $this->_get_AttrValue($attributes, $id);
        $licon = HtmlTag::tag('i');
        $licon->attr('class', 'fas fa-lock');
        $licon->content('');
        $ricon = HtmlTag::tag('i');
        $ricon->attr('class', 'far fa-eye');
        $ricon->attr('id', $fid . 'ricon');
        $ricon->attr('style', 'cursor: pointer');
        $ricon->content('');
        $left = HtmlTag::tag('span');
        $left->attr('class', 'input-group-text');
        $left->content(array($licon));
        $input = HtmlTag::tag('input');
        $input->attr('class', 'form-control control-light');
        $input->attr('id', $fid);
        $input->attr('name', $fid);
        $input->attr('type', "password");
        $input->attr('placeholder', lang($placeholder));
        $input->attr('value', $value);
        $right = HtmlTag::tag('span');
        $right->attr('class', 'input-group-text js-toggle-password');
        $right->attr('id', $fid . 'togglePassword');
        $right->attr('data-field', $fid);
        $right->content(array($ricon));
        $input_group = HtmlTag::tag('div');
        $input_group->attr('class', 'input-group');
        $input_group->content(array($left, $input, $right));
        $label = HtmlTag::tag('label');
        $label->attr('for', $fid);
        $label->content(lang($text_label));
        $help = HtmlTag::tag('div');
        $help->attr('class', 'help-block');
        $help->content(lang($text_help));
        $col = HtmlTag::tag('div');
        $col->attr('class', $proportion);
        $col->content(array($label, $input_group, $help));
        return ($col->render());
    }

    /**
     * Genera un campo tipo numero de identificacion o cedula.
     * @param type $id
     * @param type $attributes
     * @return type
     */

    public function get_FieldCitizenShipcard($id, $attributes = array(), $extra = "")
    {
        $crf = $this->_get_AttrCRF($attributes);
        $fid = $this->_get_AttrId($id, $crf);
        $proportion = $this->_get_AttrProportion($attributes);
        $text_label = $this->_get_AttrLabel($attributes, $id) . ":";
        $text_help = $this->_get_AttrHelp($attributes, $id);
        $value = $this->_get_AttrValue($attributes, $id);
        $placeholder = $this->_get_AttrPlaceHolder($attributes, $id);
        $licon = HtmlTag::tag('i');
        $licon->attr('class', 'far fa-id-card-alt');
        $licon->content('');
        $left = HtmlTag::tag('span');
        $left->attr('class', 'input-group-text');
        $left->content(array($licon));
        $input = HtmlTag::tag('input');
        $input->attr('class', 'form-control control-light js-Higgs-input-mask required');
        $input->attr('input-mask-regular', '[0-9]{7,10}');
        $input->attr('id', $fid);
        $input->attr('name', $fid);
        $input->attr('type', "text");
        $input->attr('placeholder', lang($placeholder));
        $input->attr('value', $value);
        $input_group = HtmlTag::tag('div');
        $input_group->attr('class', 'input-group');
        $input_group->content(array($left, $input));
        $label = HtmlTag::tag('label');
        $label->attr('for', $fid);
        $label->content(lang($text_label));
        $help = HtmlTag::tag('div');
        $help->attr('class', 'help-block');
        $help->content(lang($text_help));
        $col = HtmlTag::tag('div');
        $col->attr('class', $proportion);
        $col->content(array($label, $input_group, $help));
        return ($col->render());
    }

    /**
     * Retorna un campo tipo fecha, preforteado con una mascara de entrada.
     * @param string $id
     * @param type $attributes
     * @param type $extra
     * @return type
     */


    public function get_FieldDate($id, $attributes = array(), $extra = "")
    {
        $crf = $this->_get_AttrCRF($attributes);
        $fid = $this->_get_AttrId($id, $crf);
        $proportion = $this->_get_AttrProportion($attributes);
        $text_label = $this->_get_AttrLabel($attributes, $id) . ":";
        $text_help = $this->_get_AttrHelp($attributes, $id);
        $value = $this->_get_AttrValue($attributes, $id);
        $placeholder = $this->_get_AttrPlaceHolder($attributes, $id);
        $required = $this->_get_AttrRequired($attributes);
        $licon = HtmlTag::tag('i');
        $licon->attr('class', 'far fa-calendar-alt');
        $licon->content('');
        $left = HtmlTag::tag('span');
        $left->attr('class', 'input-group-text');
        $left->content(array($licon));
        $input = HtmlTag::tag('input');
        $input->attr('class', 'form-control control-light js-Higgs-input-mask');
        $input->attr('input-mask', '9999-99-99');
        $input->attr('id', $fid);
        $input->attr('name', $fid);
        $input->attr('type', "date");
        $input->attr('placeholder', lang($placeholder));
        $input->attr('value', $value);
        if ($required) {
            $input->attr('required', "required");
        }
        $input_group = HtmlTag::tag('div');
        $input_group->attr('class', 'input-group');
        $input_group->content(array($left, $input));
        $label = HtmlTag::tag('label');
        $label->attr('for', $fid);
        $label->content(lang($text_label));
        $help = HtmlTag::tag('div');
        $help->attr('class', 'help-block');
        $help->content(lang($text_help));
        $col = HtmlTag::tag('div');
        $col->attr('class', $proportion);
        $col->content(array($label, $input_group, $help));
        return ($col->render());
    }


    /**
     * Retorna dos campos simultaneamente fecha de inicio y fecha de finalización
     * es decir un rango de fechas
     * Ejemplo:
     * $f->fields["daterange"] = $f->get_FieldDateRange(
     *              "start", "end",
     *              array(
     *                  "start" => $plan["start"],
     *                  "end" => $plan["end"],
     *                  "minDate"=>$plan["start"],
     *                  "maxDate"=>$plan["end"],
     *                  "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"
     *              ));
     * @param type $id
     * @param type $attributes
     * @return type
     */

    public function get_FieldDateRange($start, $end, $attributes = array())
    {
        $id = "range";
        $crf = $this->_get_AttrCRF($attributes);
        $fid = $this->_get_AttrId($id, $crf);
        $idstart = $this->_get_AttrId("start", $crf);
        $idend = $this->_get_AttrId("end", $crf);

        $input_start = $this->_get_Input(array(
                "id" => $idstart,
                "name" => $idstart,
                "type" => "text",
                "class" => $this->_get_AttrClass($attributes, "form-control control-light text-center"),
                "placeholder" => "aaaa-mm-dd",
                "value" => $this->_get_Attr($attributes, "start"),
                "readonly" => $this->_get_AttrReadOnly($attributes),
                "autocomplete" => $this->_get_AttrAutoComplete($attributes),
                "required" => $this->_get_AttrRequired($attributes)
            )
        );
        $idend = $this->_get_AttrId($end, $crf);
        $input_end = $this->_get_Input(array(
                "id" => $idend,
                "name" => $idend,
                "type" => "text",
                "class" => $this->_get_AttrClass($attributes, "form-control control-light text-center"),
                "placeholder" => "aaaa-mm-dd",
                "value" => $this->_get_Attr($attributes, "end"),
                "readonly" => $this->_get_AttrReadOnly($attributes),
                "autocomplete" => $this->_get_AttrAutoComplete($attributes),
                "required" => $this->_get_AttrRequired($attributes)
            )
        );
        $field = "\n\t\t <!-- field-daterange-{$start}-{$end} //-->";
        $field .= $this->_get_InputField(array(
                "id" => $fid,
                "label" => $this->get_Label($start, array("text" => $this->_get_AttrLabel($attributes, $id))),
                "group" => $this->_get_InputGroup($input_start . $input_end),
                "help" => $this->get_Help($this->_get_AttrHelp($attributes, $id)),
                "proportion" => $this->_get_AttrProportion($attributes)
            )
        );
        $html = "";
        $html .= "<link rel=\"stylesheet\" href=\"/themes/assets/javascripts/datepicker/dist/css/datepicker.css\">\n";
        $html .= "<link rel=\"stylesheet\" href=\"/themes/assets/javascripts/datepicker/dist/css/datepicker-bs5.css\">\n";
        $html .= "<script src=\"/themes/assets/javascripts/datepicker/dist/js/datepicker-full.js\"></script>\n";
        $html .= $field;
        $html .= "<script>\n";
        $html .= "    const elem = document.getElementById('{$fid}');\n";
        $html .= "    const dateRangePicker = new DateRangePicker(elem, {\n";
        $html .= "        allowOneSidedRange: false,\n";
        $html .= "        autohide: false,\n";
        $html .= "        beforeShowDay: null,\n";
        $html .= "        beforeShowDecade: null,\n";
        $html .= "        beforeShowMonth: null,\n";
        $html .= "        beforeShowYear: null,\n";
        $html .= "        calendarWeeks: false,\n";
        $html .= "        clearBtn: false,\n";
        $html .= "        dateDelimiter: ',',\n";
        $html .= "        datesDisabled: [],\n";
        $html .= "        daysOfWeekDisabled: [],\n";
        $html .= "        daysOfWeekHighlighted: [],\n";
        $html .= "        defaultViewDate: new Date().setHours(0, 0, 0, 0),\n";
        $html .= "        format: 'yyyy-mm-dd',\n";
        $html .= "        language: 'en',\n";
        $html .= "        maxDate: '{$this->_get_Attr($attributes,"maxDate")}',\n";
        $html .= "        maxNumberOfDates: 1,\n";
        $html .= "        maxView: 3,\n";
        $html .= "        minDate: '{$this->_get_Attr($attributes,"minDate")}',\n";
        $html .= "        nextArrow: '»',\n";
        $html .= "        orientation: 'auto',\n";
        $html .= "        pickLevel: 0,\n";
        $html .= "        prevArrow: '«',\n";
        $html .= "        showDaysOfWeek: true,\n";
        $html .= "        showOnClick: true,\n";
        $html .= "        showOnFocus: true,\n";
        $html .= "        startView: 0,\n";
        $html .= "        title: '',\n";
        $html .= "        todayBtn: false,\n";
        $html .= "        todayHighlight: false,\n";
        $html .= "        updateOnBlur: true,\n";
        $html .= "        weekStart: 0,\n";
        $html .= "    });\n";
        $html .= "</script>";
        return ($html);
    }

    private function _get_Attr($attributes, $name)
    {
        $value = isset($attributes[$name]) ? $attributes[$name] : "";
        return ($value);
    }

    /**
     * Este metodo permite generar campos de casillas de verificación (checkbox)
     * El tercer parámetro contiene un booleano TRUE/FALSE para determinar si la casilla debe estar
     * marcada o no. Similarmente a las otras funciones en este asistente, también puede pasar un
     * arreglo de atributos a la función:
     * Ejemplo #1:
     *      $frm->getFieldCheckBox('newsletter', 'aceptar', TRUE);
     * Produce #1: <input type="checkbox" name="newsletter" value="aceptar" checked="checked" />
     * Ejemplo #2:
     *      $datos = array('name'=> 'newsletter','id'=> 'newsletter','value'=> 'aceptar','checked'  => TRUE,'style' => 'margin:10px');
     *      $frm->getFieldCheckBox($datos);
     * Produce #2: <input type="checkbox" name="newsletter" id="newsletter" value="aceptar" checked="checked" style="margin:10px" />
     *
     * @param mixed
     * @param string
     * @param bool
     * @param mixed
     * @return    string
     */
    public function get_CheckBox($id, $attributes = array())
    {
        $crf = $this->_get_AttrCRF($attributes);
        $proportion = $this->_get_AttrProportion($attributes);
        $input = "";
        $input .= $this->_get_Input(array(
                "id" => $this->_get_AttrId($id, $crf),
                "name" => $this->_get_AttrId($id, $crf),
                "type" => "checkbox",
                "class" => "",
                "value" => $this->_get_AttrValue($attributes, $id),
                "readonly" => $this->_get_AttrReadOnly($attributes),
                "required" => $this->_get_AttrRequired($attributes),
                "checked" => $this->_get_AttrChecked($attributes))
        );
        $field = $this->_get_InputField(array(
                "label" => null,
                "group" => $input,
                "help" => null,
                "proportion" => $proportion
            )
        );
        return ($field);
    }

    private function _get_AttrChecked($attributes, $default = "")
    {
        $checked = isset($attributes["checked"]) ? "checked" : "";
        return ($checked);
    }

    /**
     * Permite adjuntar multiples archivos para ser cargado en el envio del
     * formulario en esencia es un campo para el envio de multiples archivos.
     * @param type $id
     * @param type $attributes
     * @return type
     */
    public function get_FieldAttachments($id, $attributes = array())
    {
        $fid = $this->_get_AttrId($id);
        $value = $this->_get_AttrValue($attributes, $id);
        $label = $this->get_Label($id, array("text" => $this->_get_AttrLabel($attributes, $id)));
        $help = $this->get_Help($this->_get_AttrHelp($attributes, $id));
        $proportion = $this->_get_AttrProportion($attributes);

        $code = "";
        $code .= "      <div class=\"controls w-100\">\n";
        $code .= "         <div class=\"entry input-group upload-input-group mb-1\">\n";
        $code .= "             <input class=\"form-control control-light \" name=\"{$fid}[]\" type=\"file\">\n";
        $code .= "             <button class=\"btn btn-upload btn-success btn-add ml-1\" type=\"button\">\n";
        $code .= "               <i class=\"fa fa-plus\"></i>\n";
        $code .= "             </button>\n";
        $code .= "         </div>\n";
        $code .= "      </div>\n";
        $code .= "<script>\n";
        $code .= "document.addEventListener('DOMContentLoaded', function () {\n";
        $code .= "\t\tdocument.addEventListener('click', function (e) {\n";
        $code .= "\t\t\t\t// Handle click on '.btn-add'\n";
        $code .= "\t\t\t\tif (e.target && e.target.classList.contains('btn-add')) {\n";
        $code .= "\t\t\t\t\t\te.preventDefault();\n";
        $code .= "\t\t\t\t\t\tvar controlForm = document.querySelector('.controls');\n";
        $code .= "\t\t\t\t\t\tvar currentEntry = e.target.closest('.entry');\n";
        $code .= "\t\t\t\t\t\tvar newEntry = currentEntry.cloneNode(true);\n";
        $code .= "\n";
        $code .= "\t\t\t\t\t\t// Limpiar el valor del nuevo campo de entrada de archivo\n";
        $code .= "\t\t\t\t\t\tnewEntry.querySelector('input').value = '';\n";
        $code .= "\n";
        $code .= "\t\t\t\t\t\t// Cambiar el botón de agregar al botón de eliminar en la nueva entrada\n";
        $code .= "\t\t\t\t\t\tvar addButtons = newEntry.querySelectorAll('.btn-add');\n";
        $code .= "\t\t\t\t\t\taddButtons.forEach(function (button) {\n";
        $code .= "\t\t\t\t\t\t\t\tbutton.classList.remove('btn-add');\n";
        $code .= "\t\t\t\t\t\t\t\tbutton.classList.add('btn-remove');\n";
        $code .= "\t\t\t\t\t\t});\n";
        $code .= "\n";
        $code .= "\t\t\t\t\t\t// Cambiar la clase y el contenido del botón de éxito al botón de peligro\n";
        $code .= "\t\t\t\t\t\tvar successButtons = newEntry.querySelectorAll('.btn-success');\n";
        $code .= "\t\t\t\t\t\tsuccessButtons.forEach(function (button) {\n";
        $code .= "\t\t\t\t\t\t\t\tbutton.classList.remove('btn-success');\n";
        $code .= "\t\t\t\t\t\t\t\tbutton.classList.add('btn-danger');\n";
        $code .= "\t\t\t\t\t\t\t\tbutton.innerHTML = '<span class=\"fa fa-trash\"></span>';\n";
        $code .= "\t\t\t\t\t\t});\n";
        $code .= "\n";
        $code .= "\t\t\t\t\t\tcontrolForm.appendChild(newEntry);\n";
        $code .= "\t\t\t\t}\n";
        $code .= "\n";
        $code .= "\t\t\t\t// Handle click on '.btn-remove'\n";
        $code .= "\t\t\t\tif (e.target && e.target.classList.contains('btn-remove')) {\n";
        $code .= "\t\t\t\t\t\te.preventDefault();\n";
        $code .= "\t\t\t\t\t\tvar entryToRemove = e.target.closest('.entry');\n";
        $code .= "\t\t\t\t\t\tentryToRemove.remove();\n";
        $code .= "\t\t\t\t}\n";
        $code .= "\t\t});\n";
        $code .= "});\n";
        $code .= "</script>\n";
        $field = "\n\t\t <!-- field-files-{$id} //-->";
        $field .= $this->_get_InputField(array(
                "label" => $label,
                "group" => $this->_get_InputGroup($code),
                "help" => $help,
                "proportion" => $proportion
            )
        );
        return ($field);
    }

    /**
     * Este funciono y los archivos son subido a medida que se agregan.
     * @param string $id
     * @param array $attributes ["uploaded"] ruta url de donde se obtiene el listado de archivos cargado previamente.
     * @return type
     */
    public function get_DropZone($id, $attributes = array())
    {
        $fid = $this->id;
        $ref = $attributes["ref"];
        $lister = $attributes["lister"];
        $uploader = $attributes["uploader"];
        $deleter = $attributes["deleter"];
        $csrfName = $attributes["csrfName"];
        $csrfHash = $attributes["csrfHash"];
        $input = "";
        $input .= "<div id=\"{$fid}_dropzone_{$id}\" class=\"Higgs-dropzone\">";
        $input .= " <div class=\"dz-default dz-message\">";
        $input .= "  <h3 class=\"sbold\">Arrastre las imagenes a cargar 34</h3>";
        $input .= "  <span>Haga click para abrir el seleccionados</span>";
        $input .= " </div>";
        $input .= "</div>";
        $js = "";
        $js .= "\n   Dropzone.autoDiscover = false;";
        $js .= "\n    $(\"#{$fid}_dropzone_{$id}\").dropzone({\n";
        $js .= "\n        'url': \"{$uploader}\",";
        $js .= "\n        'paramName':'attachment',";
        $js .= "\n        'params':{'{$csrfName}':'{$csrfHash}'},";
        $js .= "\n        'addRemoveLinks': true,";
        $js .= "\n        'dictRemoveFile':'<i class=\"far fa-trash-alt float-right\"></i>',";
        $js .= "\n        'removedfile': function(file) {";
        $js .= "\n               console.log(file);";
        $js .= "\n               $.ajax({";
        $js .= "\n                  'url':'{$deleter}',";
        $js .= "\n                  'type':'post',";
        $js .= "\n                  'data':{'{$csrfName}':'{$csrfHash}','attachment':file.name},";
        $js .= "\n                  'dataType':'json',";
        $js .= "\n                  'success': function(response){";
        $js .= "\n                  },";
        $js .= "\n               });";
        $js .= "\n               var _ref;";
        $js .= "\n               return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;";
        $js .= "\n        },";
        $js .= "\n        'init': function(){";
        $js .= "\n              var tdropzone=this;";
        $js .= "\n              $.ajax({";
        $js .= "\n                  'url':'{$lister}',";
        $js .= "\n                  'type':'post',";
        $js .= "\n                  'data':{'{$csrfName}':'{$csrfHash}','id':'{$ref}'},";
        $js .= "\n                  'dataType':'json',";
        $js .= "\n                  'success': function(response){";
        $js .= "\n                      $.each(response, function(key,value) {";
        $js .= "\n                          var mockFile = { name: value.attachment, size: value.size };";
        $js .= "\n                          tdropzone.emit('addedfile', mockFile);";
        $js .= "\n                          tdropzone.emit('thumbnail', mockFile, value.file);";
        $js .= "\n                          tdropzone.emit('complete', mockFile);";
        $js .= "\n                      });";
        $js .= "\n                  },";
        $js .= "\n              });";
        $js .= "\n         },";
        $js .= "\n        'uploadMultiple':false,";
        $js .= "\n        'acceptedFiles': 'image/*',";
        $js .= "\n        'success': function (file, response) {\n";
        $js .= "\n            var json = $.parseJSON(response);";
        $js .= "\n            console.log(response);\n";
        $js .= "\n            console.log(json.attachment);\n";
        //$js .= "\n            console.log(file);\n";
        //$js .= "\n          //file.previewTemplate.appendChild(document.createTextNode(response.attachment));";
        $js .= "\n          //file.previewTemplate.innerText=response.attachment;";
        $js .= "\n          //file.previewElement.querySelector('.dz-filename').setAttribute('disabled','disabled');";
        $js .= "\n            file.previewElement.querySelector('.dz-filename').innerText=json.attachment;";
        $js .= "\n            file.previewElement.classList.add(\"dz-success\");\n";
        $js .= "\n        },\n";
        $js .= "\n        'error': function (file, response) {\n";
        $js .= "\n            file.previewElement.classList.add(\"dz-error\");\n";
        $js .= "\n        }\n";
        $js .= "\n    });\n";
        $this->_add_Script($js);
        $field = "\n\t\t <!-- field-dropzone-{$id} //-->";
        $field .= $this->_get_InputField(array(
                "label" => $this->get_Label($id, array("text" => $this->_get_AttrLabel($attributes, $id))),
                "group" => $this->_get_InputGroup($input),
                "help" => $this->get_Help($this->_get_AttrHelp($attributes, $id)),
                "proportion" => $this->_get_AttrProportion($attributes)
            )
        );
        return ($field);
    }

    public function _add_Script($script)
    {
        if (!empty($script)) {
            array_push($this->script, $script);
        }
    }

    /**
     * Agrega html directamente a la estructura del formulario.
     * @param type $html
     */
    public function add_Html($html)
    {
        array_push($this->html, $html);
    }

    /**
     * Este metodo retorna un panel que contiene información complementaria para visualizar en un formulario.
     * @param type $p
     */
    public function get_InfoPanel($p = array())
    {
        $html = "\n<div class=\"form-field\"> ";
        $html .= "<div class=\"col\"> ";
        if (!empty($p["title"])) {
            $html .= "<h3>{$p["title"]}</h3>";
        }
        $html .= "{$p["text"]}";
        $html .= "</div> ";
        $html .= "</div> ";
        return ($html);
    }

    /**
     * Ejecuta la validacion con todo los datos recibidos en la request
     * @return type
     */
    public function run_Validation()
    {
        $post = ($this->request->fetchGlobal("post"));
        return ($this->validation->run($post));
    }

    /**
     * Este metodo  toma tres parámetros como entrada:
     * El nombre del campo: el nombre exacto que le ha asignado al campo de formulario.
     * Un nombre "humano" para este campo, que se insertará en el mensaje de error.
     * Por ejemplo, si su campo se llama "usuario", puede darle un nombre humano de "Nombre de usuario".
     * Nota: Si desea que el nombre del campo se almacene en un archivo de idioma, consulte la traducción
     * de nombres de campo.  Las reglas de validación para este campo de formulario.
     */
    public function set_ValidationRule($field, $rules, $params = null)
    {
        $fid = $this->_get_AttrId($field);
        $name = lang("{$this->lang}label_{$field}");
        if ($rules == 'always_fail') {
            $this->validation->setRule($fid, $rules, ['params' => $params]);
        }
        $this->validation->setRule($fid, $name, $rules);
    }

    /**
     * Retorna el nombre definitivo de un campo renderizado
     * @param $id
     * @return string
     */
    public function get_FieldId($id)
    {
        $formid = $this->get_fid();
        return ("{$formid}_{$id}");
    }

    /**
     * Retorna el id del formulario
     * @return type
     */
    public function get_fid()
    {
        return ($this->id);
    }

    public function get_FieldVideo($id, $attributes = array(), $help = "")
    {
//        $class = isset($attributes["class"]) ? "form-control control-light " . $attributes["class"] : "form-control control-light";
//        $proportion = isset($attributes["proportion"]) ? $attributes["proportion"] : "";
//        $placeholder = $this->_get_AttrPlaceHolder($attributes, $id);
//        $help = $this->_get_AttrHelp($attributes, $id);
//        $readonly = $this->_get_AttrReadOnly($attributes);
//        $height = isset($attributes["height"]) ? $attributes["height"] : "400";
//        $type = isset($attributes["type"]) ? $attributes["type"] : "";
//        $value = isset($attributes["value"]) ? $attributes["value"] : null;
//        $preview = isset($attributes["preview"]) ? $attributes["preview"] : false;
        $fid = $this->_get_AttrId($id);
        $value = $this->_get_AttrValue($attributes, $id);
        $dataurl = isset($attributes["data-url"]) ? "data-url=\"{$attributes["data-url"]}\" " : "";
        $name = isset($attributes["name"]) ? "name=\"{$attributes["name"]}\" " : "name=\"{$fid}\"";
        $progress = "<div id=\"progress\" class=\"progress\"><div class=\"bar\" style=\"width: 0%;\"></div></div>";
        $c = "\n<div class=\"input-group\">";
        $c .= "\n  <div class=\"input-group-prepend\">";
        $c .= "\n    <span class=\"input-group-text\" id=\"inputGroupFileAddon-{$fid}\"><i class=\"far fa-cloud-upload-alt\"></i></span>";
        $c .= "\n  </div>";
        $c .= "\n  <div class=\"custom-file\">";
        $c .= "\n    <input type=\"file\" class=\"custom-file-input\" id=\"{$fid}\" {$name}  aria-describedby=\"inputGroupFileAddon-{$fid}\" {$dataurl}>";
        if (!empty($value)) {
            $c .= "\n    <label class=\"custom-file-label\" for=\"{$fid}\">" . $value . "</label>";
        } else {
            $c .= "\n    <label class=\"custom-file-label\" for=\"{$fid}\">" . lang("App.Choose-file") . "</label>";
        }
        $c .= "\n  </div>";
        $c .= "\n</div>";
        $field = "\n\t\t <!-- field-file-{$id} //-->";
        $field .= $this->_get_InputField(array(
                "label" => $this->get_Label($id, array("text" => $this->_get_AttrLabel($attributes, $id))),
                "group" => $this->_get_InputGroup($c),
                "help" => $this->get_Help($this->_get_AttrHelp($attributes, $id)) . $progress,
                "proportion" => $this->_get_AttrProportion($attributes)
            )
        );
        return ($field);
    }

    /**
     * Permite adjuntar un archivo
     * Validacion:
     *
     *              - $file = $f->get_FieldId('attachment');
     *              - $f->set_ValidationRule("attachment", "uploaded[{$file}]");
     * ext_in[field_name,png,jpg,gif]
     * @param type $id
     * @param type $attributes
     * @param type $help
     * @return type
     */
    public function get_FieldFile($id, $attributes = array())
    {
        $crf = $this->_get_AttrCRF($attributes);
        $fid = $this->_get_AttrId($id, $crf);
        $value = $this->_get_AttrValue($attributes, $id);
        $placeholder = $this->_get_AttrPlaceHolder($attributes, $id);
        $readonly = $this->_get_AttrReadOnly($attributes);
        $text_label = $this->_get_AttrLabel($attributes, $id) . ":";
        $text_help = $this->_get_AttrHelp($attributes, $id);
        $proportion = $this->_get_AttrProportion($attributes);
        $input = HtmlTag::tag('input');
        $input->attr('id', $fid);
        $input->attr('name', $fid);
        $input->attr('type', "file");
        $input->attr('placeholder', lang($placeholder));
        $input->attr('value', $value);
        $input->attr('class', 'form-control control-light');
        if ($readonly) {
            $input->attr('readonly', "true");
            $input->attr('class', 'form-control control-light readonly');
        }
        $input_group = HtmlTag::tag('div');
        $input_group->attr('class', 'input-group');
        $input_group->content(array($input));
        $label = HtmlTag::tag('label');
        $label->attr('for', $fid);
        $label->content(lang($text_label));
        $link = HtmlTag::tag('a');
        $link->attr('href', cdn_url($value));
        $link->attr('target', '_blank');
        $link->content($value);
        $help = HtmlTag::tag('div');
        $help->attr('class', 'help-block');
        $help->content(lang($text_help) . " " . $link);
        $col = HtmlTag::tag('div');
        $col->attr('id', "col_{$fid}");
        $col->attr('class', $proportion);
        $col->content(array($label, $input_group, $help));
        return ($col->render());
    }


    public function get_FieldResettableURL($id, $attributes = array(), $extra = "")
    {
        $crf = $this->_get_AttrCRF($attributes);
        $fid = $this->_get_AttrId($id, $crf);
        $proportion = $this->_get_AttrProportion($attributes);
        $text_label = $this->_get_AttrLabel($attributes, $id) . ":";
        $text_help = $this->_get_AttrHelp($attributes, $id);
        $placeholder = $this->_get_AttrPlaceHolder($attributes, $id);
        $value = $this->_get_AttrValue($attributes, $id);
        $readonly = $this->_get_AttrReadOnly($attributes);
        $hidden = $this->_get_AttrHidden($attributes);
        $licon = HtmlTag::tag('i');
        $licon->attr('class', 'fas fa-link');
        $licon->content('');
        $ricon = HtmlTag::tag('i');
        $ricon->attr('class', 'far fa-trash-alt');
        $ricon->attr('id', $fid . 'ricon');
        $ricon->attr('style', 'cursor: pointer');
        $ricon->content('');
        $left = HtmlTag::tag('span');
        $left->attr('class', 'input-group-text');
        $left->content(array($licon));
        $input = HtmlTag::tag('input');
        $input->attr('class', 'form-control control-light');
        $input->attr('id', $fid);
        $input->attr('name', $fid);
        $input->attr('type', "text");
        $input->attr('placeholder', lang($placeholder));
        $input->attr('value', $value);
        if ($readonly) {
            $input->attr('readonly', "true");
            $input->attr('class', 'form-control control-light readonly');
        } else {
            $input->attr('class', 'form-control control-light');
        }
        $right = HtmlTag::tag('span');
        $right->attr('id', "reset_{$fid}");
        $right->attr('class', 'input-group-text js-toggle-password');
        $right->attr('data-field', $fid);
        $right->content(array($ricon));
        $input_group = HtmlTag::tag('div');
        $input_group->attr('class', 'input-group');
        $input_group->content(array($left, $input, $right));
        $label = HtmlTag::tag('label');
        $label->attr('for', $fid);
        $label->content(lang($text_label));
        $help = HtmlTag::tag('div');
        $help->attr('class', 'help-block');
        $help->content(lang($text_help));
        $col = HtmlTag::tag('div');
        $col->attr('id', "col_{$fid}");
        if ($hidden) {
            $col->attr('class', "d-none " . $proportion);
        } else {
            $col->attr('class', "field " . $proportion);
        }
        $col->content(array($label, $input_group, $help));
        // JavaScript para borrar el campo (se añadirá al final del formulario)
        $js = "\n";
        $js .= "document.getElementById('reset_{$fid}').addEventListener('click', function() {\n";
        $js .= "\t\t\t\t\t\t\t\tvar textInput_{$id}=document.getElementById('{$fid}');\n";
        $js .= "\t\t\t\t\t\t\t\ttextInput_{$id}.value = '';\n";
        $js .= "\t\t\t\t\t\t\t\tvar event = new Event('input', { bubbles: true });\n";
        $js .= "\t\t\t\t\t\t\t\ttextInput_{$id}.dispatchEvent(event);\n";
        $js .= "\t\t\t\t\t\t});\n";
        $this->add_Script($js);
        return ($col->render());
    }

    /**
     * Permite adjuntar un archivo realizando la carga y retornando solo el id del adjunto en la plataforma
     * Se crean tres campos para este procedimiento:
     * 1) Un campo typo "File" para la carga del archivo que se oculta tras la carga.
     * 2) Un campo URL que tras la carga se hace visible y consultable
     * 3) Un campo oculto que porta verdadera id del campo pero solo porta el ID del archivo cargado
     * Validacion:
     *              - $file = $f->get_FieldId('attachment');
     *              - $f->set_ValidationRule("attachment", "uploaded[{$file}]");
     * ext_in[field_name,png,jpg,gif]
     * @param type $id
     * @param type $attributes
     * @param type $help
     * @return type
     */
    public function get_FieldUploader($id, $attributes = array())
    {
        $value = $this->_get_AttrValue($attributes, $id);
        $attributes_ftext = array_merge(array("hidden" => true), $attributes);
        $object = $this->_get_Attr($attributes, "object");
        $ffile = $this->get_FieldFile("{$id}_file", $attributes);
        $attributes_ftext['class'] = ($attributes_ftext['class'] ?? '') . ' file-uploader-text'; // Agrega una clase para la selección
        $ftext = $this->get_FieldResettableURL("{$id}_text", $attributes_ftext); // El ID ya lo genera la función
        $fhidden = $this->add_HiddenField($id, $value);
        $this->add_Script($this->get_FileUploaderScript($id, $object));
        return $ffile . $ftext . $fhidden;
    }

    private function get_FileUploaderScript(string $id, string $object): string
    {
        $file_id = $this->get_FieldId("{$id}_file");
        $text_id = $this->get_FieldId("{$id}_text");
        $hidden_id = $this->get_FieldId($id);
        $colfile_id = "col_{$file_id}";
        $coltext_id = "col_{$text_id}";
        $js = <<<JS
                    const fileInput_{$file_id} = document.getElementById('{$file_id}');
                    const textInput_{$text_id} = document.getElementById('{$text_id}');
                    const hiddenInput_{$id} = document.getElementById('{$hidden_id}');
                    const fileCol_{$colfile_id} = document.getElementById('$colfile_id');
                    const textCol_{$coltext_id} = document.getElementById('$coltext_id');
                    if (fileInput_{$file_id} && textInput_{$text_id} && fileCol_{$colfile_id}  && textCol_{$coltext_id}) {
                        fileInput_{$file_id}.addEventListener('change', function() {
                            if (this.files.length > 0) { 
                                let file = this.files[0];
                                let formData = new FormData();
                                formData.append('attachment0', file); // Añade el archivo al FormData
                                let xhr = new XMLHttpRequest();
                                xhr.open('POST',  "/storage/uploader/single/sie/{$object}?time=" + new Date().getTime(), true); // Abre la petición XHR
                                xhr.onload = function() {
                                    if (xhr.status >= 200 && xhr.status < 300) {
                                        try {
                                            let response = JSON.parse(xhr.responseText);
                                            if (response.status === 'success') {
                                                let data = response.data;
                                                let attachment = data.attachment;
                                                console.log(attachment);
                                                textInput_{$text_id}.value = attachment; // Update the input field with the file URL
                                                hiddenInput_{$id}.value = attachment; // Update the hidden field with the file ID
                                                textCol_{$coltext_id}.classList.remove('d-none');
                                                fileCol_{$colfile_id}.classList.add('d-none');
                                                var event = new Event('input', { bubbles: true });
                                                textInput_{$text_id}.dispatchEvent(event); // Dispatch the input event
                                            } else {
                                                console.error('Error in response:', response);
                                                alert('Error uploading file: ' + response.message);
                                            }
                                        } catch (e) {
                                            console.error('Error parsing JSON response:', e);
                                            alert('Error parsing server response.');
                                        }
                                    } else {
                                        console.error('Error al subir el archivo:', xhr.status, xhr.statusText);
                                        // Maneja el error de la subida, por ejemplo, mostrando un mensaje al usuario.
                                        alert("Se ha producido un error al subir el archivo.");
                                        fileInput_{$file_id}.value = "";
                                    }
                                };
                                xhr.onerror = function() {
                                    console.error('Error de red al subir el archivo.');
                                   // Manejar el error, mostrar mensaje
                                   alert("Se ha producido un error de red al subir el archivo.");
                                   fileInput_{$file_id}.value = "";
            
                                };
                               xhr.send(formData); // Envía la petición XHR
                           } else {
                                textCol_{$coltext_id}.classList.add('d-none');
                                fileCol_{$colfile_id} .classList.remove('d-none');
                                textInput_{$text_id}.value = "";
                            }
                        });
                    }
            JS;
        return $js;
    }

    /**
     * Genera dropdown con entrada de texto de consulta y lista seleccionable es
     * necesario que el vector de parametros contenga el json, ruta de referencia
     * a un json que recibe una cadena de consulta para la visualización de los datos
     * vector de atributos que contenga los demas parametros adicionales.
     * @param type $id
     * @param type $attributes
     *      [json] type string: Ruta al json que recibe la cadena de consulta.
     * @param type $extra
     * @return type
     */
    public function get_FieldDropdown($id, $a)
    {
        if (is_array($a)) {
            $fid = $this->_get_AttrId($id);
            $json = $a["json"];
            $selected = isset($a["value"]) ? $a["value"] : null;
            $input = "<select id=\"{$fid}\" name=\"{$fid}\" class =\"fstdropdown-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1\">";
            $input .= "<option value =\"\" selected>Seleccione uno</option>";
            $input .= '</select>';
            $field = "\n\t\t <!-- field-text-{$id} //-->";
            if (!isset($a["label"])) {
                $label = $this->get_Label($id, array("text" => $this->_get_AttrLabel($a, $id)));
            } else if ($a["label"] === false) {
                $label = "";
            }
            if (!isset($a["help"])) {
                $help = $this->get_Help($this->_get_AttrHelp($a, $id));
            } else if ($a["help"] === false) {
                $help = "";
            }

            $field .= $this->_get_InputField(array(
                    "label" => $label,
                    "group" => $this->_get_InputGroup($input),
                    "help" => $help,
                    "proportion" => $this->_get_AttrProportion($a)
                )
            );
            $js = ""
                . "\n function refresh_{$fid}(input){"
                . "\n     \$.getJSON('{$json}/'+input,function(data){"
                . "\n         $.each(data, function(id,value){;"
                . "\n               var select = document.getElementById('{$fid}');"
                . "\n               var opt = document.createElement('option');"
                . "\n               opt.text=value.label;"
                . "\n               opt.value=value.value;"
                . "\n               select.add(opt);"
                . "\n               select.fstdropdown.rebind();"
                . "\n         });\n"
                . "\n     });\n"
                . "}"
                . ""
                . "\n\$('.fstsearchinput').on('input',function(){"
                . "\n     var input=$(this).val();"
                . "\n     $('#{$fid}').empty();"
                . "\n     refresh_{$fid}(input);"
                . "});"
                . ""
                . "refresh_{$fid}('{$selected}');";
            $this->add_Script($js);
            return ($field);
        } else {
            return ("Un vector es requerido!");
        }
    }

    public function add_Script($script)
    {
        if (!empty($script)) {
            array_push($this->script, $script);
        }
    }

    /**
     * Genera un campo de texto, requiere un parametro que define su ID y un
     * vector de atributos que contenga los demas parametros adicionales.
     * Un select se puede alimentar de un conjunto de opciones estaticas asociadas aun vector de vectores en formato key value
     * donde la key de la etiqueta se denominara label, y la del valor value tantos comos e requieran. El valor del vector se
     * adjuntara a este metodo mediante un arametro denominado data, el comportamiento del campo esta parametricidado como
     * tradicionalmente se hace con los demas.
     * Tambien es posible alimentar esta clase de campo desde un modelo llamando al metodo get_SelectData();
     * este nos retornara un vector con una composicion igual a la del ejemplo pero con datos almacenados provenientes de
     * la conexion de un modelo de datos.
     *
     * Ejemplo: $types = array(
     *           array("label" => "Noticia", "value" => "NEWS"),
     *           array("label" => "Articulo", "value" => "ARTICLE"),
     *    );
     * Ejemplo:
     *      $f->fields["type"] = $f->get_FieldSelect("type",
     *          array(
     *              "value" => $r["type"],
     *              "data" => $types,
     *              "proportion" => "col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"
     *          )
     *      );
     * @param type $id
     * @param type $attributes
     * @param type $extra
     * @return type
     */
    public function get_FieldSelect($id, $a)
    {
        if (is_array($a)) {
            $fid = $this->_get_AttrId($id);
            $text_label = $this->_get_AttrLabel($a, $id) . ":";

            $input = $this->bootstrap->get_Select($fid, $a);
            if (isset($a['label']) && ($a['label'] === false)) {
                $label = "";
            } else {
                $label = $this->bootstrap->get_Label("{$fid}-label", array("for" => $fid, 'content' => lang($text_label)));
            }

            if (isset($a['help']) && ($a['help'] === false)) {
                $help = "";
            } else {
                $help = $this->bootstrap->get_Help($this->_get_AttrHelp($a, $id));
            }

            $field = $this->bootstrap->get_Field(array(
                "id" => $id,
                "label" => $label,
                "group" => $input,
                "help" => $help,
                "proportion" => $this->_get_AttrProportion($a)
            ));
            return ($field);
        } else {
            return ("Un vector es requerido!");
        }
    }

    /**
     * Genera un campo de texto, requiere un parametro que define su ID y un
     * vector de atributos que contenga los demas parametros adicionales.
     * @param type $id
     * @param type $attributes
     * @param type $extra
     * @return type
     */


    public function get_FieldSubmit($id, $attributes = array(), $extra = "")
    {
        $crf = $this->_get_AttrCRF($attributes);
        $fid = $this->_get_AttrId($id, $crf);
        $proportion = $this->_get_AttrProportion($attributes);
        $text_label = $this->_get_AttrLabel($attributes, $id) . "";
        $text_help = $this->_get_AttrHelp($attributes, $id);
        $value = $this->_get_AttrValue($attributes, $id);
        $placeholder = $this->_get_AttrPlaceHolder($attributes, $id);
        $input = HtmlTag::tag('input');
        $input->attr('id', $fid);
        $input->attr('name', $fid);
        $input->attr('type', "submit");
        $input->attr('value', $value);
        $input->attr('class', 'w-100 btn btn-lg btn-primary');
        $input_group = HtmlTag::tag('div');
        $input_group->attr('class', 'input-group');
        $input_group->content(array($input));
        $label = HtmlTag::tag('label');
        $label->attr('for', $fid);
        $label->content(lang($text_label));
        $help = HtmlTag::tag('div');
        $help->attr('class', 'help-block');
        $help->content(lang($text_help));
        $col = HtmlTag::tag('div');
        $col->attr('class', $proportion);
        $col->content(array($label, $input_group, $help));
        return ($col->render());
    }

    public function get_FieldText($id, $attributes = array(), $extra = "")
    {
        $crf = $this->_get_AttrCRF($attributes);
        $fid = $this->_get_AttrId($id, $crf);
        $proportion = $this->_get_AttrProportion($attributes);
        $text_label = $this->_get_AttrLabel($attributes, $id) . ":";
        $text_help = $this->_get_AttrHelp($attributes, $id);
        $value = $this->_get_AttrValue($attributes, $id);
        $placeholder = $this->_get_AttrPlaceHolder($attributes, $id);
        $readonly = $this->_get_AttrReadOnly($attributes);
        $hidden = $this->_get_AttrHidden($attributes);

        $input = HtmlTag::tag('input');
        $input->attr('id', $fid);
        $input->attr('name', $fid);
        $input->attr('type', "text");
        $input->attr('placeholder', lang($placeholder));
        $input->attr('value', $value);
        if ($readonly) {
            $input->attr('readonly', "true");
            $input->attr('class', 'form-control control-light readonly');
        } else {
            $input->attr('class', 'form-control control-light');
        }
        $input_group = HtmlTag::tag('div');
        $input_group->attr('class', 'input-group');
        $input_group->content(array($input));
        $label = HtmlTag::tag('label');
        $label->attr('id', "{$fid}_label");
        $label->attr('for', $fid);
        $label->content(lang($text_label));
        $help = HtmlTag::tag('div');
        $help->attr('class', 'help-block');
        $help->content(lang($text_help));
        $col = HtmlTag::tag('div');
        $col->attr('id', "col_{$fid}");
        if ($hidden) {
            $col->attr('class', "d-none " . $proportion);
        } else {
            $col->attr('class', "field " . $proportion);
        }
        $col->content(array($label, $input_group, $help));
        return ($col->render());
    }

    /**
     *
     * @param string $id
     * @param type $attributes
     * @param type $format text / rtrf / code / php
     * @return type
     */
    public function get_FieldCKEditor($id, $attributes)
    {
        if (is_array($attributes)) {
            $crf = $this->_get_AttrCRF($attributes);
            $fid = $this->_get_AttrId($id, $crf);
            $value = $this->_get_AttrValue($attributes, $id);
            $c = "<script src=\"/themes/assets/javascripts/ckeditor5/ckeditor.js\"></script>";
            $c .= "<table width=\"100%\"><tr><td>";
            $c .= "<textarea id=\"{$fid}\" name=\"{$fid}\" class=\"form-control control-light\">{$value}</textarea>";
            $c .= "</td></tr></table>";
            $c .= "<script>";
            $c .= "ClassicEditor.create( document.querySelector( '#{$fid}' ), {";
            $c .= "	toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]";
            $c .= "}).then({$fid}=>{window.{$fid} = {$fid};}).catch( err => {";
            $c .= "	console.error( err.stack );";
            $c .= "});";

            $c .= "</script>";
            $field = "\n\t\t <!-- field-text-{$id} //-->";
            $field .= $this->_get_InputField(array(
                    "label" => $this->get_Label($id, array("text" => $this->_get_AttrLabel($attributes, $id))),
                    "group" => $this->_get_InputGroup($c),
                    "help" => $this->get_Help($this->_get_AttrHelp($attributes, $id)),
                    "proportion" => $this->_get_AttrProportion($attributes)
                )
            );
            return ($field);
        } else {
            return ("Un vector es requerido!");
        }
    }

    /**
     *
     * @param string $id
     * @param type $attributes
     * @param type $format text / rtrf / code / php
     * @return type
     */
    public function get_FieldTextArea($id, $attributes)
    {
        $crf = $this->_get_AttrCRF($attributes);
        $fid = $this->_get_AttrId($id, $crf);
        $proportion = $this->_get_AttrProportion($attributes);
        $text_label = $this->_get_AttrLabel($attributes, $id) . ":";
        $text_help = $this->_get_AttrHelp($attributes, $id);
        $value = $this->_get_AttrValue($attributes, $id);
        $placeholder = $this->_get_AttrPlaceHolder($attributes, $id);
        $readonly = $this->_get_AttrReadOnly($attributes);
        $input = HtmlTag::tag('textarea');
        $input->attr('id', $fid);
        $input->attr('name', $fid);
        $input->attr('type', "text");
        $input->attr('cols', "30");
        $input->attr('rows', "4");
        $input->attr('placeholder', lang($placeholder));
        if ($readonly) {
            $input->attr('readonly', "true");
            $input->attr('class', 'form-control control-textarea control-light readonly');
        } else {
            $input->attr('class', 'form-control control-textarea control-light');
        }
        $input->content($value);
        $input_group = HtmlTag::tag('div');
        $input_group->attr('class', 'input-group');
        $input_group->content(array($input));
        $label = HtmlTag::tag('label');
        $label->attr('for', $fid);
        $label->content(lang($text_label));
        $help = HtmlTag::tag('div');
        $help->attr('class', 'help-block');
        $help->content(lang($text_help));
        $col = HtmlTag::tag('div');
        $col->attr('class', $proportion);
        $col->content(array($label, $input_group, $help));
        return ($col->render());
    }

    /**
     * Este metodo crea un google map y adiciona dos campos a la carga de datos
     * trasferida por el formulario, latitude/longitude. Sin importar el procedimiento
     * lo que se espera de la existencia de este elemento a nivel grafico sera
     * la trasferencia de estos dos datos.
     * @param type $id
     * @param type $attributes
     * @param type $extra
     * @return type
     */

    public function get_Map($id, $attributes = array(), $extra = "")
    {
        $apikey = "";
        $feid = $this->id . "_" . $id;
        $crf = $this->_get_AttrCRF($attributes);
        $latitude = (isset($attributes["latitude"]) && !empty($attributes["latitude"])) ? $attributes["latitude"] : 4.2839974;
        $longitude = (isset($attributes["longitude"]) && !empty($attributes["longitude"])) ? $attributes["longitude"] : -71.7272187;
        $this->add_HiddenField("latitude", "");
        $this->add_HiddenField("longitude", "");
        $c = "<!-- map-{$feid} //-->";
        $c .= "<div class=\"floating-panel\">";
        $c .= "     <input id=\"{$feid}-address\" type=\"textbox\" value=\"\">";
        $c .= "     <input id=\"{$feid}-geocode\" type=\"button\" value=\"Localizar\">";
        $c .= "</div>";
        $c .= "<div id=\"{$feid}\" style=\"position: relative; overflow: hidden;height: 340px;width: 100%;\"></div>";
        $c .= "<script>\n";
        $c .= "function initMap() {\n";
        $c .= "    var position={lat:{$latitude},lng:{$longitude}};\n";
        $c .= "    var map = new google.maps.Map(document.getElementById('{$feid}'),{'zoom':14,'center':position});\n";
        $c .= "    var marker1=new google.maps.Marker({'map':map,'position':position});\n";
        $c .= "    var geocoder=new google.maps.Geocoder();\n";
        $c .= "    document.getElementById('{$feid}-geocode').addEventListener('click', function() {\n";
        $c .= "        geocodeAddress(geocoder, map);\n";
        $c .= "    });\n";
        $c .= "}\n";
        $c .= "\n";
        $c .= "function geocodeAddress(geocoder, resultsMap) {\n";
        $c .= "     var address = document.getElementById('{$feid}-address').value;\n";
        $c .= "     if($('#{$this->id}_city').length){";
        $c .= "         var city=$('select[name=\"{$this->id}_city\"] option:selected').text();";
        $c .= "         address+=', '+city;";
        $c .= "     }";
        $c .= "     if($('#{$this->id}_region').length){";
        $c .= "         var region=$('select[name=\"{$this->id}_region\"] option:selected').text();";
        $c .= "         address+=', '+region;";
        $c .= "     }";
        $c .= "     if($('#{$this->id}_country').length){";
        $c .= "         var country=$('select[name=\"{$this->id}_country\"] option:selected').text();";
        $c .= "         address+=', '+country;";
        $c .= "     }";
        $c .= "     console.log('Dirección: '+address);";
        $c .= "     geocoder.geocode({'address':address},function(results,status){\n";
        $c .= "        if (status === 'OK'){\n";
        $c .= "            resultsMap.setCenter(results[0].geometry.location);\n";
        $c .= "            var location = results[0].geometry.location;\n";
        $c .= "            var latitude=results[0].geometry.location.lat();";
        $c .= "            var longitude=results[0].geometry.location.lng();";
        $c .= "            $('#{$this->id}_latitude').val(latitude);";
        $c .= "            $('#{$this->id}_longitude').val(longitude);";
        $c .= "            console.log('location: '+longitude+' | '+latitude);\n";
        $c .= "            var marker = new google.maps.Marker({map:resultsMap,position:location});";
        $c .= "        } else {\n";
        $c .= "            alert('Geocode was not successful for the following reason: ' + status);";
        $c .= "        }\n";
        $c .= "    });\n";
        $c .= "}\n";
        $c .= "</script>\n";
        $input = $c;
        $field = "\n\t\t <!-- field-text-{$id} //-->";
        $field .= $this->_get_InputField(array(
                "label" => $this->get_Label($id, array("text" => $this->_get_AttrLabel($attributes, $id))),
                "group" => $this->_get_InputGroup($input),
                "help" => $this->get_Help($this->_get_AttrHelp($attributes, $id)),
                "proportion" => $this->_get_AttrProportion($attributes)
            )
        );
        return ($field);
    }

    /**
     * Genera y adiciona un campo oculto al formulario, cada campo esta asegurado al
     * formulario que lo genera mediante el prefijo de su respesctiva id, a menos
     * que se utilice $native en este caso el id del campo es natio es decir sin
     * prefijo.
     * @param string $id
     * @param type $value
     */
    public function add_HiddenField($id, $value, $native = true)
    {
        $fid = $this->_get_id_native($id, $native);
        $field = "\n\t\t<!-- field-hidden-{$fid} //-->";
        $field .= $this->_get_Hidden($fid, $value);
        $this->_add_Field($field);
    }

    /**
     * Convierte un codigo de id a nativo
     * @param type $id
     * @param type $native
     * @return type
     */
    public function _get_id_native($id, $native)
    {
        if ($native) {
            return ($this->id . "_" . $id);
        } else {
            return ($id);
        }
    }

    /**
     * Hidden Input Field
     *
     * Generates hidden fields. You can pass a simple key/value string or
     * an associative array with multiple values.
     *
     * @param mixed $name Field name
     * @param string $value Field value
     * @param bool $recursing
     * @return    string
     */
    private function _get_Hidden($name, $value = '', $recursing = FALSE)
    {
        $field = "";
        $field .= "<input type=\"hidden\" id=\"{$name}\" name=\"{$name}\" value=\"{$value}\" />";
        return ($field);
    }

    /**
     * Adiciona el codigo fuente de un campo al html general del formulario.
     * @param type $html
     */
    private function _add_Field($html)
    {
        array_push($this->html, $html);
    }

    /**
     * $frm->groups["submit"] = $frm->addGroup($frm->fields["submit"],"","padding-10px text-right");
     * @param type $html
     * @param type $help
     * @param type $class
     * @return type
     */
    public function get_Group($attr = array())
    {
        $id = isset($attr["id"]) ? $attr["id"] : "group_" . uniqid();
        $class = $this->_get_Attribute("class", $attr, "row");
        $fields = $this->_get_Attribute("fields", $attr, "");
        $help = $this->_get_Attribute("help", $attr, "");
        if (!empty($fields)) {
            $legend = isset($attr["legend"]) ? $attr["legend"] : "";
            $code = "";
            $code .= "<div id=\"{$id}\" class=\"{$class} \">";
            $code .= !empty($legend) ? "<div class=\"row title m-0 p-0\"><div class=\"col-12 \"><h2 class=\"mx-0 my-3 form-header\">{$legend}</h2></div></div>" : "";
            $code .= $fields;
            $code .= $this->get_Help($help);
            $code .= "</div>";
            return ($code);
        } else {
            throw new Excepts('FORMS-001');
        }
    }

    public function get_GroupSeparator($attr = array())
    {
        return ("<div class=\"row separator\"><hr class=\"colorgraph\"></div>");
    }

    public function get_Buttons($attr = array())
    {
        $id = isset($attr["id"]) ? $attr["id"] : "group_" . uniqid();
        $class = isset($attr["class"]) ? $attr["class"] : "form-group text-end";
        $fields = isset($attr["fields"]) ? $attr["fields"] : "";
        $help = isset($attr["help"]) ? $attr["help"] : "";
        if (!empty($fields)) {
            $legend = isset($attr["legend"]) ? $attr["legend"] : "";
            $code = "";
            $code .= !empty($legend) ? "<div class=\"row title\"><div class=\"col-12 \">{$legend}</div></div>" : "";
            $code .= "<div id=\"{$id}\" class=\"{$class}\">";
            $code .= $fields;
            $code .= $this->get_Help($help);
            $code .= "</div>";
            return ($code);
        } else {
            throw new Exception();
        }
    }


    public function get_Cancel($id, $attributes = array())
    {
        $text = $this->_get_Attribute("text", $attributes, lang("App.Cancel"));
        $class = $this->_get_AttrClass($attributes, "btn btn-link-primary");
        $href = $this->_get_AttrHref($attributes, "#");
        $icon = $this->_get_AttrIcon($attributes, "fa-regular fa-ban");
        $input = $this->bootstrap->get_Link($id, array("text" => $text, "href" => $href, "class" => $class, "icon" => $icon,));
        $field = "\n\t\t <!-- field-link-$id //-->$input";
        return ($field);
    }

    public function get_Submit($id, $attributes = array())
    {
        $id = $this->_get_AttrId($id);
        $value = $this->_get_AttrValue($attributes, $id);
        $class = $this->_get_AttrClass($attributes, "btn btn-danger");
        $icon = $this->_get_AttrIcon($attributes, "fa-regular fa-floppy-disk");
        $input = $this->bootstrap->get_Button($id, array("class" => $class, "icon" => $icon, "content" => $value, "type" => "submit"));
        $field = "\n\t\t <!-- field-submit-$id //-->$input";
        return ($field);
    }

    public function getSearch($id, $attributes = array())
    {
        $id = $this->_get_AttrId($id);
        $value = $this->_get_AttrValue($attributes, $id);
        $class = $this->_get_AttrClass($attributes, "btn btn-primary");
        $icon = $this->_get_AttrIcon($attributes, "fa-regular fa-search");
        $input = $this->bootstrap->get_Button($id, array("class" => $class, "icon" => $icon, "content" => $value, "type" => "submit"));
        $field = "\n\t\t <!-- field-submit-$id //-->$input";
        return ($field);
    }

    public function get_Button($id, $attributes = array())
    {
        $id = $this->_get_AttrId($id);
        $text = $this->_get_AttrText($attributes, $id);
        $class = $this->_get_AttrClass($attributes, "btn btn-secondary");
        $href = $this->_get_AttrHref($attributes, "#");
        $icon = $this->_get_AttrIcon($attributes, "");
        $input = $this->bootstrap->get_Link($id, array("text" => $text, "href" => $href, "class" => $class, "icon" => $icon,));
        $field = "\n\t\t <!-- field-link-$id //-->$input";
        return ($field);
    }

    /**
     * <p>Retorna un campo tipo código fuente editable. La siguiente es una descripción y lista de los atributos
     * disponibles para los diferentes parámetros.</p>
     *
     * @param type $id
     * @param array | $attributes mode[tex|php|html|css|json|js]
     * @param type $extra
     * @return type
     */
    public function get_FieldCode($id, $attributes = array(), $extra = "")
    {
        $label = $this->get_Label($id, array("text" => $this->_get_AttrLabel($attributes, $id)));
        $help = $this->get_Help($this->_get_AttrHelp($attributes, $id));
        $value = $this->_get_AttrValue($attributes, $id);
        $id = $this->_get_AttrId($id);
        $mode = (isset($attributes["mode"])) ? $attributes["mode"] : "tex";
        $input = "   <textarea id=\"{$id}_editor\">{$value}</textarea>";
        $field = "\n\t\t <!-- field-code-{$id} //-->";
        $field .= $this->_get_InputField(array(
                "label" => $label,
                "group" => $this->_get_InputGroup($input),
                "help" => $help,
                "proportion" => $this->_get_AttrProportion($attributes)
            )
        );

        $field .= "\n\t\t<script type=\"text/javascript\" src=\"/themes/assets/libraries/ace/src-noconflict/ace.js\" ></script>";
        $script = "\n\t";
        $script .= "\n\t var editor{$id}=ace.edit(\"{$id}_editor\");";
        $script .= "\n\t var modeColor = '" . get_theme_mode() . "';";
        $script .= "\n\t if(modeColor=='theme-light'){";
        $script .= "\n\t    editor{$id}.setTheme(\"ace/theme/github\");";
        $script .= "\n\t }else{";
        $script .= "\n\t    editor{$id}.setTheme(\"ace/theme/twilight\");";
        $script .= "\n\t }";
        $script .= "\n\t editor{$id}.session.setUseWrapMode(true);";
        $script .= "\n\t editor{$id}.session.setMode(\"ace/mode/{$mode}\");";
        $script .= "\n\t editor{$id}.setAutoScrollEditorIntoView(true);";
        $script .= "\n\t editor{$id}.setOption(\"minLines\", 25);";
        $script .= "\n\t editor{$id}.setOption(\"maxLines\", 1000);";
        $script .= "\n\t var input{$id}=document.querySelector(\"#{$id}\");";
        $script .= "\n\t\t input{$id}.value=editor{$id}.getSession().getValue();";
        $script .= "\n\t editor{$id}.getSession().on(\"change\",function(){";
        $script .= "\n\t\t console.log(\"cambio en le codigo\");";
        $script .= "\n\t\t input{$id}.value=editor{$id}.getSession().getValue();";
        $script .= "\n\t });";
        $this->add_HiddenField($id, "", false);
        $this->_add_Script($script);
        return ($field);
    }

    /**
     * Contenedor de campos adaptado a la interface grafica.
     * @param type $code
     * @return type
     */
    public function get_FieldContainer($code, $proportion = null)
    {
        $field = "";
        if (!empty($proportion)) {
            $field .= "<div class=\"form-field form-field-width-{$proportion}p form-field-float-left \">";
            $field .= "{$code}";
            $field .= "</div>";
        } else {
            $field .= "<div class=\"form-field\">";
            $field .= "{$code}";
            $field .= "</div>";
        }
        return ($field);
    }

    public function __toString()
    {
        $js = implode("\n\t\t\t ", $this->script);
        $c = "";
        $c .= implode($this->html);
        $c .= implode($this->groups);
        $c .= "\n\t\t <!-- form-script //--> ";
        $c .= "\n\t <script type=\"text/javascript\">\n";
        $c .= "\n\t\t	document.addEventListener('DOMContentLoaded', function() {\n";
        $c .= "\n\t\t {$js}";
        $c .= "\n\t\t });\n";
        $c .= "\n\t </script>\n";
        $c .= form_close();
        return ($c);
    }

    private function _get_AttrOptions($attributes, $id)
    {
        return (!isset($attributes["options"]) ? null : $attributes["options"]);
    }

    private function _get_AttrSelected($attributes, $id)
    {
        $value = isset($attributes["selected"]) ? $attributes["selected"] : null;
        return ($value);
    }

    private function _get_AttrText($attributes, $id)
    {
        return ($this->__get_Attr("text", $attributes, $id));
    }

    private function _get_AttrExtra($attributes, $id)
    {
        $value = isset($attributes["extra"]) ? $attributes["extra"] : null;
        return ($value);
    }


    /*
     * El método __toString () permite a una clase decidir cómo comportarse cuando se trata como una cadena. Si Forms
     * es tratado como una cadena retornara una cadena HTML correspondiente a la totalidad del código HTML generado.
     */

    private function _get_AttrMaxlength($attributes)
    {
        $required = isset($attributes["maxlength"]) ? $attributes["maxlength"] : "";
        return ($required);
    }

}

?>