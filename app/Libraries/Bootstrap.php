<?php

namespace App\Libraries;

use App\Libraries\Html\Bootstrap\Alert;
use App\Libraries\Html\Bootstrap\Cards;
use App\Libraries\Html\Bootstrap\Evolution;
use App\Libraries\Html\Bootstrap\ListGroup;
use App\Libraries\Html\Bootstrap\ListGroupItem;
use App\Libraries\Html\Bootstrap\Post;
use App\Libraries\Html\Bootstrap\Posts;
use App\Libraries\Html\Bootstrap\ProgressBar;
use App\Libraries\Html\Bootstrap\Scores;
use App\Libraries\Html\Bootstrap\Shortcut;
use App\Libraries\Html\Bootstrap\Shortcuts;
use App\Libraries\Html\Bootstrap\Table;
use App\Libraries\Html\Bootstrap\Tree;
use App\Libraries\Html\Bootstrap\TreeNode;
use Exception;
use Higgs\Html\HtmlTag;
use Higgs\Html\Tag\Tag;

class Bootstrap
{

    public function __construct()
    {

    }


    /**
     * Genera y devuelve un componente gráfico de evolución de ventas con Bootstrap.
     *
     * Este método crea y renderiza un componente visual que muestra información sobre la evolución
     * de ventas u otras métricas, utilizando una configuración personalizada.
     *
     * @param string $id Identificador único para el componente de evolución.
     * @param array $args Argumentos opcionales para personalizar el componente:
     *   - string 'chartId': ID para el gráfico (por defecto se usa un ID generado internamente).
     *   - string 'salesValue': Valor numérico de las ventas o métrica a mostrar.
     *   - string 'salesLabel': Etiqueta descriptiva para el valor mostrado.
     *   - string 'percentageChange': Cambio porcentual (ej: '+15%').
     *   - string 'periodLabel': Descripción del período de tiempo (ej: 'última semana').
     *   - string 'viewAllLink': Enlace para ver todos los datos.
     *   - string 'cardClass': Clases CSS adicionales para la tarjeta.
     *   - string 'chartContainerClass': Clases CSS para el contenedor del gráfico.
     *
     * @return string Código HTML del componente de evolución personalizado.
     */
    public static function get_Evolution($id, $args = array()): string
    {

    }


    /**
     * Genera y devuelve un elemento de botón utilizando los estilos de botones personalizados de Bootstrap. Este método
     * facilita la creación de botones con soporte para múltiples tamaños, estados y más.
     *
     * @param string $id Identificador único del botón.
     * @param array $args Argumentos opcionales para personalizar el botón.
     *   - string 'class': Clases CSS adicionales para el botón.
     *   - string 'content': Contenido del botón, puede incluir texto e iconos.
     *   - string 'data-bs-toggle': Valor para el atributo 'data-bs-toggle', utilizado para activar elementos de Bootstrap.
     *   - string 'data-bs-target': Valor para el atributo 'data-bs-target', utilizado para especificar el destino de un toggle.
     *   - string 'onclick': Valor para el atributo 'onclick', especifica el código JavaScript a ejecutar cuando se hace clic.
     *   - string 'icon': Clase del icono a incluir en el botón.
     *   - string 'type': Tipo del botón (por defecto es 'button').
     *
     * @return string Retorna el elemento de botón como una cadena HTML.
     */
    public static function get_Button(string $id, array $args = array()): string
    {
        $class = self::_get_Attribute("class", $args, "");
        $content = self::_get_Attribute("content", $args, "");
        $data_bs_toggle = self::_get_Attribute("data-bs-toggle", $args, "");
        $data_bs_target = self::_get_Attribute("data-bs-target", $args, "");
        $onclick = self::_get_Attribute("onclick", $args, "");
        $icon = self::_get_Attribute("icon", $args, "");
        $type = self::_get_Attribute("type", $args, "button");
        if (!empty($icon)) {
            $content = "<i class='{$icon}'></i> {$content}";
        }
        $ht = HtmlTag::tag('button');
        $ht->attr('id', $id);
        $ht->attr('type', $type);
        $ht->attr('class', "btn {$class}");
        if (!empty($data_bs_toggle)) {
            $ht->attr('data-bs-toggle', $data_bs_toggle);
        }
        if (!empty($data_bs_target)) {
            $ht->attr('data-bs-target', $data_bs_target);
        }
        if (!empty($onclick)) {
            $ht->attr('onclick', $onclick);
        }
        $ht->content($content);
        return ($ht);
    }

    /**
     * Retorna el valor de un atributo especifico desde el listado de atributos proporsionado
     * se debe proporsionar el vector que contiene el listado de atributos el
     * nombre del atributo especifico a localizar y el valor por defecto de este
     * en caso de no estar definido
     */
    private static function _get_Attribute($name, $attributes, $default = false)
    {
        if (is_array($attributes)) {
            if (isset($attributes[$name])) {
                return ($attributes[$name]);
            } else {
                return ($default);
            }
        } else {
            throw new Exception('Attributes debe ser un vector.');
        }
    }

    /**
     * Permite adjuntar un archivo
     * @param type $id
     * @param type $attributes
     * @param type $help
     * @return type
     */
    public static function get_File($id, $attributes = array())
    {
        $args['type'] = 'file';
        $input = self::get_Input($id, $args);
        return ($input);
    }

    public static function get_Input($id, $args = array())
    {
        $type = self::_get_Attribute("type", $args, "text");
        $class = self::_get_Attribute("class", $args, "form-control");
        $text = self::_get_Attribute("text", $args, "");
        $value = self::_get_Attribute("value", $args, "");
        $checked = self::_get_Attribute("checked", $args, "");
        $placeholder = self::_get_Attribute("placeholder", $args, "");
        $onclick = self::_get_Attribute("onclick", $args, "");
        $onchange = self::_get_Attribute("onchange", $args, "");
        $inputmask = self::_get_Attribute("input-mask", $args, "");

        $ht = HtmlTag::tag('input');
        $ht->attr('name', $id);
        $ht->attr('id', $id);
        $ht->attr('type', $type);
        $ht->attr('class', " {$class}");
        $ht->attr('value', $value);
        if (!empty($inputmask)) {
            $ht->attr('input-mask', $inputmask);
        }
        if ($checked == "true") {
            $ht->attr('checked', $checked);
        }
        if (!empty($placeholder)) {
            $ht->attr('placeholder', $placeholder);
        }
        if (!empty($onclick)) {
            $ht->attr('onclick', $onclick);
        }
        if (!empty($onchange)) {
            $ht->attr('onchange', $onchange);
        }
        $ht->content($text);
        return ($ht->render());
    }

    public static function get_Date($id, $args = array())
    {
        $args['type'] = 'date';
        $args['input-mask'] = '9999-99-99';
        $input = self::get_Input($id, $args);
        return ($input);
    }

    public static function get_Double($id, $args = array())
    {
        $args['type'] = 'text';
        $args['class'] = 'form-control js-input-doubles';
        $input = self::get_Input($id, $args);
        return ($input);
    }

    public static function get_Number($id, $args = array())
    {
        $args['type'] = 'text';
        $args['input-mask'] = 'numeric';
        $args['class'] = 'form-control js-Higgs-input-mask';
        $input = self::get_Input($id, $args);
        return ($input);
    }

    public static function get_Text($id, $args = array())
    {
        $args['type'] = 'text';
        $input = self::get_Input($id, $args);
        return ($input);
    }

    public static function get_Group($id, $args = array())
    {
        if (is_array($args)) {
            $class = self::_get_Attribute("class", $args, "");
            $content = self::_get_Attribute("content", $args, "");
            $ht = HtmlTag::tag('div');
            $ht->attr('class', $class);
            $ht->content($content);
            return ($ht->render());
        } else {
            throw new Exception('Args debe ser un vector.');
        }

    }

    public static function get_A($id, $args = array()): string
    {
        $class = self::_get_Attribute("class", $args, "");
        $content = self::_get_Attribute("content", $args, "");
        $href = self::_get_Attribute("href", $args, "");
        $target = self::_get_Attribute("target", $args, "");
        $a = HtmlTag::tag('a');
        $a->attr('class', $class);
        $a->attr('href', $href);
        $a->attr('target', $target);
        $a->content($content);
        return ($a);
    }

    public static function get_Tr($id, $args = array()): string
    {
        $class = self::_get_Attribute("class", $args, "");
        $content = self::_get_Attribute("content", $args, "");
        $rowspan = self::_get_Attribute("rowspan", $args, "");
        $tr = HtmlTag::tag('tr');
        $tr->attr('class', $class);
        $tr->attr('rowspan', $rowspan);
        $tr->content($content);
        return ($tr);
    }

    public static function get_Row($id, $args = array()): string
    {
        $class = self::_get_Attribute("class", $args, "");
        $content = self::_get_Attribute("content", $args, "");
        $div = HtmlTag::tag('div');
        $div->attr('class', "row {$class}");
        $div->content($content);
        return ($div);
    }

    public static function get_Col($id, $args = array()): string
    {
        $class = self::_get_Attribute("class", $args, "");
        $content = self::_get_Attribute("content", $args, "");
        $div = HtmlTag::tag('div');
        $div->attr('class', "col {$class}");
        $div->content($content);
        return ($div);
    }

    public static function get_Table($id, $args = array()): string
    {
        $class = self::_get_Attribute("class", $args, "");
        $content = self::_get_Attribute("content", $args, "");
        $table = HtmlTag::tag('table');
        $table->attr('class', $class);
        $table->content($content);
        return ($table);
    }


    public static function get_DynamicTable($attributes = array()): string
    {
        $table = new Table($attributes);
        return ($table);
    }

    /**
     * Retorna un elemento de tipo <div> con el contenido especificado.,true
     * @param array $attributes
     * @return ListGroup
     */
    public static function get_ListGroup(array $attributes = array()): ListGroup
    {
        $listgroup = new ListGroup($attributes);
        return ($listgroup);
    }

    /**
     * @param $attributes
     * @return ListGroupItem
     */
    public static function get_ListGroupItem($attributes = array()): ListGroupItem
    {
        $listgroupitem = new ListGroupItem($attributes);
        return ($listgroupitem);
    }


    public static function get_Th($id, $args = array()): string
    {
        $class = self::_get_Attribute("class", $args, "");
        $content = self::_get_Attribute("content", $args, "");
        $colspan = self::_get_Attribute("colspan", $args, "");
        $th = HtmlTag::tag('th');
        $th->attr('class', $class);
        $th->attr('colspan', $colspan);
        $th->content($content);
        return ($th);
    }

    public static function get_Td($id, $args = array()): string
    {
        $class = self::_get_Attribute("class", $args, "form-label");
        $content = self::_get_Attribute("content", $args, "");
        $colspan = self::_get_Attribute("colspan", $args, "");
        $td = HtmlTag::tag('td');
        $td->attr('class', $class);
        $td->attr('colspan', $colspan);
        $td->content($content);
        return ($td);
    }

    /**
     * @param $id
     * @param $args
     * @return string
     */
    public static function get_checkbox($id, $args = array())
    {
        $class = self::_get_Attribute("class", $args, "form-check-input");
        $value = self::_get_Attribute("value", $args, "");
        $checked = self::_get_Attribute("checked", $args, "");
        $label = self::_get_Attribute("label", $args, "");
        $onchange = self::_get_Attribute("onchange", $args, "");
        $cb = self::get_Input($id, $args = array("type" => "checkbox", "value" => $value, "checked" => $checked, "class" => $class, "onchange" => $onchange));
        $fc = HtmlTag::tag('div');
        if (empty($label)) {
            $fc->attr('class', "form-group");
            $fc->content(array($cb));
        } else {
            $fc->attr('class', "form-check");
            $label = self::get_label('label_' . $id, $args = array("for" => $id, "class" => "form-check-label", "content" => $label));
            $fc->content(array($label, $cb));
        }
        return ($fc->render());
    }

    public static function get_Label($id, $args = array()): string
    {
        $class = self::_get_Attribute("class", $args, "form-label mb-0");
        $content = self::_get_Attribute("content", $args, "");
        $for = self::_get_Attribute("for", $args, "");
        $ht = HtmlTag::tag('label');
        $ht->attr('class', $class);
        $ht->attr('for', $for);
        $ht->content($content);
        return ($ht->render());
    }

    public static function get_Script($attributes = array())
    {
        if (is_array($attributes)) {
            $src = self::_get_Attribute('src', $attributes);
            $async = self::_get_Attribute('async', $attributes);
            $defer = self::_get_Attribute('defer', $attributes);
            $content = self::_get_Attribute('content', $attributes);
            $script = HtmlTag::tag('script');
            if (!empty($src)) {
                $script->attr('src', $src);
            }
            if ($async == true) {
                $script->attr('async');
            }
            if ($defer == true) {
                $script->attr('defer');
            }
            $script->content($content);
            return ($script->render());
        } else {
            throw new Exception('Attributes debe ser un vector.');
        }
    }

    /**
     * Ejemplo de uso: $data = array(
     *              array("label" => "Igual", "value" => '='),
     *              array("label" => "Mayor que", "value" => '>'),
     *              array("label" => "Menor que", "value" => '<'),
     *           );
     * @param $id
     * @param $a
     * @return string
     */
    public static function get_Select($id, $attributes = array())
    {
        if (is_array($attributes)) {
            if (!empty($id)) {
                $data = self::_get_Attribute('data', $attributes);
                if (is_array($data)) {
                    $disabled = "";
                    $selected = self::_get_Attribute('selected', $attributes);
                    $required = (isset($attributes['required']) && ($attributes['required'] == true)) ? 'value-required="true"' : 'value-required="false"';
                    $class = isset($attributes["class"]) ? "form-select {$attributes["class"]}" : "form-select";
                    if (str_contains($class, 'disabled')) {
                        $disabled = 'disabled';
                    } elseif (isset($attributes['disabled']) && ($attributes['disabled'] == true)) {
                        $disabled = 'disabled';
                    }
                    $input = "<select id = \"{$id}\" name=\"{$id}\" class =\"{$class}\" {$disabled} {$required}>";
                    foreach ($data as $d) {
                        $label = urldecode($d["label"]);
                        if ($d["value"] == $selected) {
                            $input .= "<option value =\"{$d["value"]}\" selected>{$label}</option>";
                        } else {
                            $input .= "<option value =\"{$d["value"]}\">{$label}</option>";
                        }
                    }
                    $input .= '</select>';
                    return ($input);
                } else {
                    throw new Exception('Data debe ser un vector.');
                }
            } else {
                throw new Exception('El ID del Switch no puede estar vacio.');
            }
        } else {
            throw new Exception('Attributes debe ser un vector.');
        }
    }

    public static function get_Signature($id, $attributes = array())
    {
        if (is_array($attributes)) {
            if (!empty($id)) {
                $spid = "signaturepad" . lpk();
                $html = "<div  class=\"signature-pad\">";
                $html .= "<div class=\"ans-signature-pad--body\">";
                $html .= "<canvas id=\"{$id}\" style=\"touch-action: none; user-select: none;\" width=\"480\" height=\"320\"></canvas>";
                $html .= "</div>";
                $html .= "<div class=\"ans-signature-pad--footer\">";
                $html .= "<div class=\"ans-description\">Firme encima</div>";
                $html .= "<div class=\"ans-signature-pad--actions\">";
                $html .= "<div>";
                $html .= "<button id=\"clear\" type=\"button\" class=\"button clear\" data-action=\"clear\">Limpiar</button>";
                //$html .= "<button type=\"button\" class=\"button\" data-action=\"change-color\">Change color</button>";
                //$html .= "<button type=\"button\" class=\"button\" data-action=\"change-width\">Change width</button>";
                //$html .= "<button type=\"button\" class=\"button\" data-action=\"undo\">Undo</button>";
                $html .= "</div>";
                $html .= "<div>";
                //$html .= "<button type=\"button\" class=\"button save\" data-action=\"save-png\">Save as PNG</button>";
                //$html .= "<button type=\"button\" class=\"button save\" data-action=\"save-jpg\">Save as JPG</button>";
                //$html .= "<button type=\"button\" class=\"button save\" data-action=\"save-svg\">Save as SVG</button>";
                $html .= "</div>";
                $html .= "</div>";
                $html .= "</div>";
                $html .= "</div>";
                $js = "<script>";
                $js .= "var {$spid} = new SignaturePad(document.getElementById('{$id}'), {";
                $js .= "backgroundColor: 'rgba(255, 255, 255, 0)',";
                $js .= "penColor: 'rgb(0, 0, 0)'";
                $js .= "});";
                //$js .= "var saveButton = document.getElementById('save');";
                //$js .= "saveButton.addEventListener('click', function (event) {";
                //$js .= "var data = {$spid}.toDataURL('image/png');";
                //$js .= "window.open(data);";
                //$js .= "});";
                $js .= "var cancelButton = document.getElementById('clear');";
                $js .= "cancelButton.addEventListener('click', function (event) {";
                $js .= "{$spid}.clear();";
                $js .= "});";
                $js .= "</script>";
                return ($html . $js);
            } else {
                throw new Exception('El ID de la firma no puede estar vacio.');
            }
        } else {
            throw new Exception('Attributes debe ser un vector.');
        }
    }

    public static function get_RangeDouble($id, $attributes = array())
    {
        $unit = self::_get_Attribute('unit', $attributes);
        $min = self::_get_Attribute('min', $attributes);
        $max = self::_get_Attribute('max', $attributes);
        $step = self::_get_Attribute('step', $attributes);
        $value = self::_get_Attribute('value', $attributes);//15,90
        $html = "";
        $html .= "<input";
        $html .= "type=\"text\"";
        $html .= "id=\"{$id}\"";
        $html .= "name=\"{$id}\"";
        $html .= "data-provide=\"rangeslider\"";
        //$html .= "data-slider-ticks=\"[1, 2, 3]\"";
        $html .= "data-slider-ticks-labels='[\"short\", \"medium\", \"long\"]'";
        $html .= "data-slider-min=\"{$min}\"";
        $html .= "data-slider-max=\"{$max}\"";
        $html .= "data-slider-step=\"{$step}\"";
        $html .= "data-slider-value=\"{$value}\"";
        $html .= "data-slider-tooltip=\"shoe\"";
        $html .= ">";
        $html .= "<span id=\"{$id}-display\"></span>";
        $html .= "<script>";
        $html .= "</script>";
        return ($html);
    }

    /**
     * onchange="check_hierarchie($(this).prop('checked'),'62F3A3320A001')"
     * @param $id
     * @param $a
     * @return string
     */
    public static function get_Switch($id, $attributes = array())
    {
        if (is_array($attributes)) {
            if (!empty($id)) {
                $value = self::_get_Attribute('value', $attributes);
                $onchange = self::_get_Attribute('onchange', $attributes);
                $checked = self::_get_Attribute('checked', $attributes);
                $span = HtmlTag::tag('span');
                $span->attr('class', 'slider round');
                $span->content(array());
                $input = HtmlTag::tag('input');
                $input->attr('name', $id);
                $input->attr('id', $id);
                $input->attr('class', 'checkbox success');
                $input->attr('type', 'checkbox');
                $input->attr('data-value', $value);
                if ($checked == 'true') {
                    $input->attr('checked', 'true');
                }
                $input->attr('onchange', $onchange);
                $status = HtmlTag::tag('label');
                $status->attr('class', 'switch');
                $status->content(array($input, $span));
                return ($status->render());
            } else {
                throw new Exception('El ID del Switch no puede estar vacio.');
            }
        } else {
            throw new Exception('Attributes debe ser un vector.');
        }
    }


    public static function get_Score($attributes = array())
    {
        $title = self::_get_Attribute("title", $attributes);
        $value = self::_get_Attribute("value", $attributes);
        $description = self::_get_Attribute("description", $attributes);
        $code = "<div class=\"row\">\n";
        $code .= "\t<div class=\"col-8\">\n";
        $code .= "\t\t<h1 class=\"card-score-value mt-0 mb-0\">$value</h1>\n";
        $code .= "\t\t<p class=\"card-score-description mb-0\">$description</p>\n";
        $code .= "\t</div>\n";
        $code .= "\t<div class=\"col-4 text-center\">\n";
        $code .= "\t\t<i class=\"fad fa-signal-4 fa-4x text-orange\"></i>\n";
        $code .= "\t</div>\n";
        $code .= "</div>\n";
        $card = self::get_Card("card-view-service", array(
            "title" => $title,
            "content" => $code,
        ));
        return ($card);
    }

    /**
     *  Una Card(tarjeta) es un contenedor de contenido flexible y extensible. Incluye opciones para
     *  encabezados y pies de página, una amplia variedad de contenido, colores de fondo contextuales
     *  y potentes opciones de visualización. Si está familiarizado con Bootstrap 3, las tarjetas
     *  reemplazan nuestros paneles, pocillos y miniaturas anteriores. Funcionalidad similar a esos
     *  componentes está disponible como clases modificadoras para tarjetas. Las tarjetas se crean
     *  con el menor marcado y los mejores estilos posibles, pero aún así logran ofrecer una gran
     *  cantidad de control y personalización. Construidos con flexbox, ofrecen una alineación fácil y
     *  se combinan bien con otros componentes de Bootstrap. No tienen margin por defecto, así
     *  que use las utilidades de espaciado según sea necesario.
     * @param type $args [header-class]:
     *                          justify-content-center
     * @param type $args
     * @return type
     */


    /**
     *
     * @param $args
     * @return string
     */
    function get_Card2($id, $args = array())
    {
        // Crear instancia de Cards
        $card = new Cards([
            'id' => $id,
            'class' => isset($args["class"]) ? "card {$args["class"]} mb-2" : "card mb-2"
        ]);
        $headerContent = !empty($args["header-icon"]) ? "<i class=\"icon {$args["header-icon"]} opacity-50\"></i>" : "";
        $card->set_HeaderTitle(@$args["header-title"], ['class' => 'card-header-title p-1 m-0 opacity-7']);
        $card->set_HeaderSubtitle(@$args["header-subtitle"], ['class' => 'card-header-subtitle']);
        $card->set_Header($headerContent, ['class' => isset($args["header-class"]) ? "card-header {$args["header-class"]}" : "card-header x"]);
        // Botones del header
        $card->add_HeaderButtonPrint($args);
        $card->add_HeaderButtonAdd($args);
        $card->add_HeaderButtonSynchronize($args);
        $card->add_HeaderButtonEdit($args);
        $card->add_HeaderButtonDelete($args);
        $card->add_HeaderButtonList($args);
        $card->add_HeaderButtonSearch($args);
        $card->add_HeaderButtonEvaluate($args);
        $card->add_HeaderButtonRefresh($args);
        $card->add_HeaderButtonHelp($args);
        $card->add_HeaderButtonBack($args);
        $card->add_HeaderButtons($args);
        $card->add_ContentImage($args);
        $card->add_ContentAlert($args);
        $card->add_ContentBody($args);
        $card->add_FooterButtonContinue($args);
        $card->add_Voice($args);
        return (string)$card;
    }


    public static function get_Card($id, $args = array())
    {
        $class = isset($args["class"]) ? $args["class"] : null;
        $icon = isset($args["icon"]) ? $args["icon"] : false;
        $title = isset($args["title"]) ? $args["title"] : "";
        $subtitle = isset($args["subtitle"]) ? $args["subtitle"] : false;
        $header_add = isset($args["header-add"]) ? $args["header-add"] : false;
        $header_edit = isset($args["header-edit"]) ? $args["header-edit"] : false;
        $header_delete = isset($args["header-delete"]) ? $args["header-delete"] : false;
        $header_back = isset($args["header-back"]) ? $args["header-back"] : false;
        $header_list = isset($args["header-list"]) ? $args["header-list"] : false;
        $header_search = isset($args["header-search"]) ? $args["header-search"] : false;
        $header_evaluate = isset($args["header-evaluate"]) ? $args["header-evaluate"] : false;
        $header_class = isset($args["header-class"]) ? $args["header-class"] : "";
        $header_icon = isset($args["header-icon"]) ? $args["header-icon"] : false;
        $content = isset($args["content"]) ? $args["content"] : "";
        $content_class = isset($args["content-class"]) ? $args["content-class"] : "";
        $post_title = isset($args["post-title"]) ? $args["post-title"] : "";
        $text = isset($args["text"]) ? $args["text"] : "";
        $alert = isset($args["alert"]) ? $args["alert"] : "";
        $text_class = isset($args["text-class"]) ? $args["text-class"] : "";
        $body_class = isset($args["body-class"]) ? $args["body-class"] : "";
        $background = isset($args["background"]) ? $args["background"] : "bg-primary";
        $textcolor = isset($args["textcolor"]) ? $args["textcolor"] : "tx-white";
        $options = isset($args["options"]) ? $args["options"] : "";
        $footer = isset($args["footer"]) ? $args["footer"] : null;
        $footer_class = isset($args["footer-class"]) ? $args["footer-class"] : "";
        $footer_login = isset($args["footer-login"]) ? $args["footer-login"] : false;
        $footer_register = isset($args["footer-register"]) ? $args["footer-register"] : false;
        $footer_logout = isset($args["footer-logout"]) ? $args["footer-logout"] : false;
        $footer_continue = isset($args["footer-continue"]) ? $args["footer-continue"] : false;
        $footer_cancel = isset($args["footer-cancel"]) ? $args["footer-cancel"] : false;
        $footer_help = isset($args["footer-help"]) ? $args["footer-help"] : false;
        $footer_attachment = isset($args["footer-attachment"]) ? $args["footer-attachment"] : false;
        $image_class = isset($args["image-class"]) ? $args["image-class"] : "";
        $image = isset($args["image"]) ? $args["image"] : "";
        $voice = isset($args["voice"]) ? $args["voice"] : "";
        $permissions = isset($args["permissions"]) ? $args["permissions"] : false;
        $errors = isset($args["errors"]) ? $args["errors"] : false;
        $table = isset($args["table"]) ? $args["table"] : false;
        $c = "<!-- card //-->";
        $c .= "<div id=\"{$id}\" class=\"card {$class} mb-2\">\n";
        if (!empty($title) || is_array($options)) {
            $c .= "<div class=\"card-header {$header_class}\">";
            $c .= "<div class=\"d-flex justify-content-between align-items-center\">";
            if (!empty($title)) {
                $c .= "<h2 class=\"card-header-title p-1  m-0 opacity-7\">";
                if ($header_icon) {
                    $c .= "<i class=\"icon {$header_icon} opacity-50\"></i> ";
                }
                $c .= "{$title}";
                $c .= "</h2>";
                if ($subtitle) {
                    $c .= "<br><span class=\"card-header-subtitle\">{$subtitle}</span>";
                }
            }

            $c .= "<div class=\"card-toolbar float-right align-middle\">";
            if ($header_add) {
                if (is_array($header_add)) {
                    $href = $header_add["href"];
                    $class = isset($header_add["class"]) ? "btn card-toolbar-btn bg-secondary border-secondary {$header_add["class"]} custom" : "btn card-toolbar-btn bg-secondary border-secondary normal";
                    $c .= "<a href=\"{$href}\" class=\"{$class}\"><i class=\"fas fa-plus\"></i></a>";
                } else {
                    $c .= "<a href=\"{$header_add}\" class=\"btn card-toolbar-btn border-secondary border-secondary\"><i class=\"fas fa-plus\"></i></a>";
                }
            }


            if ($header_edit) {
                if (is_array($header_edit)) {
                    $href = $header_edit["href"];
                    $class = isset($header_edit["class"]) ? "btn card-toolbar-btn bg-secondary border-secondary {$header_edit["class"]}" : "btn card-toolbar-btn bg-secondary border-secondary";
                    $c .= "<a href=\"{$href}\" class=\"{$class}\"><i class=\"" . ICON_EDIT . "\"></i></a>";
                } else {
                    $c .= "<a href=\"{$header_edit}\" class=\"btn card-toolbar-btn bg-secondary border-secondary\"><i class=\"" . ICON_EDIT . "\"></i></a>";
                }
            }

            if ($header_delete) {
                if (is_array($header_delete)) {
                    $href = $header_delete["href"];
                    $class = isset($header_delete["class"]) ? "btn card-toolbar-btn bg-secondary border-secondary {$header_delete["class"]}" : "btn card-toolbar-btn bg-secondary border-secondary";
                    $c .= "<a href=\"{$href}\" class=\"{$class}\"><i class=\"fas fa-trash\"></i></a>";
                } else {
                    $c .= "<a href=\"{$header_delete}\" class=\"btn card-toolbar-btn bg-secondary border-secondary\"><i class=\"fa-regular fa-trash\"></i></a>";
                }
            }


            if ($header_list) {
                $c .= "<a href=\"{$header_list}\" class=\"card-toolbar-btn bg-secondary border-secondary\"><i class=\"fa-regular fa-list-dots\"></i></a>";
            }

            if ($header_search) {
                $c .= "<a href=\"{$header_search}\" class=\"card-toolbar-btn bg-secondary border-secondary\"><i class=\"fa-regular fa-search\"></i></a>";
            }

            if ($header_evaluate) {
                if (is_array($header_evaluate)) {
                    $href = $header_evaluate["href"];
                    $class = isset($header_evaluate["class"]) ? "btn card-toolbar-btn bg-secondary border-secondary {$header_evaluate["class"]}" : "card-toolbar-btn bg-secondary border-secondary";
                    $c .= "<a href=\"{$href}\" class=\"{$class}\"><i class=\"fas fa-check\"></i></a>";
                } else {
                    $c .= "<a href=\"{$header_evaluate}\" class=\"btn card-toolbar-btn bg-secondary border-secondary\"><i class=\"fas fa-check\"></i></a>";
                }
            }

            if ($header_back) {
                $c .= "<a href=\"{$header_back}\" class=\"btn card-toolbar-btn bg-primary border-primary\"><i class=\"fas fa-chevron-left\"></i></a>";
            }

            if (is_array($options) && count($options) > 0) {
                $c .= self::get_card_options($options);
            }
            $c .= "</div>";
            $c .= "</div>";
            $c .= "</div>";
        }
        if (!empty($image)) {
            $c .= "<img class=\"card-img-top lazyload $image_class\" src=\"{$image}\" alt=\"\">";
        }
        $c .= "<div class=\"card-body {$body_class}\">";

        $c .= is_array($alert) ? self::get_Alert($alert) : "";

        if ($icon) {
            $c .= "<div class=\"text-center\">";
            $c .= "<i class=\"icon {$icon} fa-5x mb-3 animated rotateIn\"></i>";
            $c .= "</div>";
        }
        if (!empty($post_title)) {
            $c .= "<h5 class=\"card-title\">{$post_title}</h5>\n";
        }

        if (!empty($text)) {
            $c .= "<p class=\"card-text   {$text_class}\">{$text}</p>\n";
        }
        if (!empty($content)) {
            $c .= "<div class=\"card-content {$content_class}\">";
            $c .= "{$content}";
            $c .= "</div>\n";
        }
        if (isset($permissions) && is_array($permissions)) {
            $c .= '<ul class="permissions">';
            foreach ($permissions as $k => $v) {
                if (!empty($v)) {
                    $c .= '<li class="permission"><b>' . $k . '</b>: ' . $v . '</li>';
                }
            }
            $c .= '</ul>';
        } elseif (isset($permissions) && !empty($permissions)) {
            $c .= '<br><b>' . lang("App.Permissions") . '</b>: ' . $permissions;
        }
        if ($errors) {
            $c .= $errors;
        }
        if (isset($voice) && !empty($voice)) {
            $c .= "<audio class=\¨card-audio\¨ src=\"/themes/assets/audios/{$voice}?lpk=" . lpk() . "\" type=\"audio/mp3\" autoplay></audio>";
        }

        if (!empty($table)) {
            $c .= "<div class=\"card-table\">";
            $c .= self::_get_Table($table);
            $c .= "</div>\n";
        }


        $c .= "</div>\n";
        if (!is_null($footer) || !empty($footer) || $footer_login || $footer_continue || $footer_help || $footer_cancel) {
            $c .= "<div class=\"card-footer {$footer_class} text-muted\">";
            $c .= $footer;
            if ($footer_login && !get_LoggedIn()) {
                $c .= "<a href=\"/security/session/signin/" . lpk() . "\" class=\"btn btn-primary mx-2\">" . lang("App.Sign-in") . "</a>";
            }
            if ($footer_register && !get_LoggedIn()) {
                $c .= "<a href=\"/security/session/signup/" . lpk() . "\" class=\"btn btn-primary mx-2\">" . lang("App.Sign-up") . "</a>";
            }
            if ($footer_logout && get_LoggedIn()) {
                $c .= self::get_Link("btn-logout", array(
                    "class" => "btn btn-primary mx-2",
                    "text-class" => "btn-text-inline",
                    "icon" => "fas fa-sign-out-alt",
                    "text" => lang("App.Sign-off"),
                    "href" => "/security/session/disconnect/" . lpk()
                ));
            }
            if ($footer_continue) {
                if (is_array($footer_continue)) {
                    $icon = $footer_continue["icon"] ?? ICON_CONTINUE;
                    $class = $footer_continue["class"] ?? "";
                    $target = $footer_continue["target"] ?? "";
                    $c .= self::get_Link("btn-continue", array(
                        "class" => "btn btn-primary mx-1 $class",
                        "text-class" => "btn-text-inline",
                        "icon" => $icon,
                        "text" => $footer_continue["text"],
                        "href" => $footer_continue["href"],
                        "target" => $target,
                    ));
                } else {
                    $c .= self::get_Link("btn-continue", array(
                        "class" => "btn btn-primary mx-1",
                        "text-class" => "btn-text-inline",
                        "icon" => ICON_CONTINUE,
                        "text" => lang("App.Continue"),
                        "href" => $footer_continue
                    ));
                }
            }

            if ($footer_cancel) {
                $c .= self::get_Link("btn-logout", array(
                    "class" => "btn btn-secondary mx-1",
                    "text-class" => "btn-text-inline",
                    "icon" => ICON_CANCEL,
                    "text" => lang("App.Cancel"),
                    "href" => $footer_cancel
                ));
            }

            if ($footer_attachment) {
                if (is_array($footer_attachment)) {
                    $icon = $footer_attachment["icon"] ?? ICON_ATTACHMENTS;
                    $class = $footer_attachment["class"] ?? "";
                    $target = $footer_attachment["target"] ?? "";
                    $c .= self::get_Link("btn-attachment", array(
                        "class" => "btn btn-primary mx-1 $class",
                        "text-class" => "btn-text-inline",
                        "icon" => $icon,
                        "text" => $footer_attachment["text"],
                        "href" => $footer_attachment["href"],
                        "target" => $target,
                    ));
                } else {
                    $c .= self::get_Link("btn-attachment", array(
                        "class" => "btn btn-primary mx-1",
                        "text-class" => "btn-text-inline",
                        "icon" => ICON_ATTACHMENTS,
                        "text" => lang("App.Attachments"),
                        "href" => $footer_attachment
                    ));
                }
            }


            if ($footer_help) {
                $c .= "<a href=\"{$footer_help}\" class=\"btn btn-secondary mx-1\" >" . lang("App.Help") . "</a>";
            }
            $c .= "</div>";
        }
        $c .= "</div>\n";
        return ($c);
    }

    public static function get_card_options($options = array())
    {
        $c = "\n\t\t <!-- cardoptions //-->";
        $c .= "            <div class=\"dropdown\">\n";
        $c .= "                <a href=\"#\" id=\"gedf-drop1\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" class=\"btn btn-link dropdown-toggle\">\n";
        $c .= "                    <i class=\"fa fa-bars\"></i>\n";
        $c .= "                </a>\n";
        $c .= "                <div class=\"dropdown-menu dropdown-menu-right\" aria-labelledby=\"gedf-drop1\" style=\"\">\n";
        $c .= "                    <div class=\"h6 dropdown-header\">Opciones</div>\n";
        foreach ($options as $option) {
            $c .= "                   <a class=\"dropdown-item\" href=\"{$option["link"]}\">{$option["icon"]} {$option["text"]}</a>\n";
        }
        $c .= "                </div>\n";
        $c .= "            </div>\n";
        return ($c);
    }

    /**
     * Método que genera un mensaje de alerta personalizado utilizando atributos.
     * @see https://getbootstrap.com/docs/5.0/components/alerts/
     * @see https://github.com/jalexiscv/Snipes/blob/master/Libraries/Bootstrap/Alerts/Info.php
     * @param array $attributes Un conjunto de atributos para personalizar la alerta.
     * @return string una cadena de texto correspondiente al mensaje de alerta personalizado.
     * @throws InvalidArgumentException Si el tipo de alerta no es uno de los tipos válidos.
     */
    public static function get_Alert($attributes = array()): string
    {
        return (new Alert($attributes));

    }

    private static function _get_Table($params)
    {
        if (empty($params['id'])) {
            trigger_error("Asignación: falta la asignación del parámetro id.");
            return;
        }
        if (empty($params['data-url'])) {
            trigger_error("Asignación: falta la asignación del parámetro data-url");
            return;
        }
        if (empty($params['cols'])) {
            trigger_error("Asignación: falta la asignación del parámetro cols");
            return;
        }
        if (empty($params['data-side-pagination'])) {
            // client|server
            trigger_error("Asignación: falta la asignación del parámetro data-side-pagination");
            return;
        }

        $dataidfield = !empty($params['data-id-field']) ? $params['data-id-field'] : "data-id-field";

        $html = "\n <!--[BS5TABLE]-->";
        $html .= "<div id=\"table-{$params['id']}-table-toolbar\">\n";
        if (isset($params['buttons']) && is_array($params['buttons']) && count($params['buttons']) > 0) {
            foreach ($params['buttons'] as $key => $value) {
                $html .= "    <a href=\"{$value['href']}\"  autocomplete=\"off\" id=\"btn-{$key}\" class=\"btn {$value['class']} mr-2\">\n";
                if (isset($value['icon'])) {
                    $html .= "<i class=\"{$value['icon']}\"></i>\n";
                }
                if (isset($value['text'])) {
                    $html .= "        {$value['text']}\n";
                }
                $html .= "    </a>\n";
            }
        }
        $html .= "</div>\n";
        $html .= "<table class=\"table  text-95 p-0 m-0\" id=\"table-{$params['id']}\"></table>\n";
        $html .= "<table\n";
        $html .= "    id=\"{$params['id']}\"\n";
        //$html .= "    class=\"table-light\"\n";
        $html .= "    data-locale=\"es-ES\"\n";
        $html .= "    data-toolbar=\"#table-{$params['id']}-table-toolbar\"\n";
        $html .= "    data-show-button-icons=\"true\"\n";
        $html .= "    data-show-export=\"true\"\n";
        $html .= "    data-search=\"true\"\n";
        $html .= "    data-search-align=\"right\"\n";
        $html .= "    data-pagination=\"true\"\n";
        $html .= "    data-side-pagination=\"{$params['data-side-pagination']}\"\n";
        $html .= "    data-url=\"{$params['data-url']}\"\n";
        $html .= "    data-total-field=\"total\"\n";
        $html .= "    data-data-field=\"data\"\n";
        $html .= "    data-show-pagination-switch=\"true\"\n";
        $html .= "    data-page-size=\"{$params['data-page-size']}\"\n";
        $html .= "    data-show-extended-pagination=\"true\"\n";
        $html .= "    data-toggle=\"table\" \n";
        $html .= "    data-show-columns=\"true\" \n";
        $html .= "    data-show-columns-toggle-all=\"true\" \n";
        $html .= "    data-show-refresh=\"true\" \n";
        $html .= "    data-show-fullscreen=\"true\"\n";
        $html .= "    data-id-field=\"{$dataidfield}\"\n";
        $html .= "    data-select-item-name=\"{$dataidfield}\"\n";
        //$html .= "    stickyHeader=\"true\" \n";
        //$html .= "    stickyHeaderOffsetLeft=10 \n";
        //$html .= "    stickyHeaderOffsetRight=10 \n";
        //$html .= "    theadClasses=\"classes\" \n";
        $html .= "    >\n";
        $html .= "    <thead>\n";
        $html .= "        <tr>\n";
        foreach ($params['cols'] as $key => $value) {
            if (is_array($value)) {
                $class = !isset($value['class']) ? " " : "class=\"  {$value['class']}\" ";
                $visible = !isset($value['visible']) ? "" : "data-visible=\"false\" ";
                $halign = isset($value["halign"]) ? "data-halign=\"{$value["halign"]}\"" : "";
                $align = isset($value["align"]) ? "data-align=\"{$value["align"]}\"" : "";
                $valign = isset($value["valign"]) ? "data-valign=\"{$value["valign"]}\"" : "";
                $width = isset($value["width"]) ? "data-width=\"{$value["width"]}\"" : "";
                $field = "data-field=\"{$key}\" ";
                $html .= "    <th {$class} =\"{$key}\" {$field} {$visible} {$halign } {$align} {$valign} {$width} >{$value['text']}</th>\n";
            } else {
                $html .= "    <th data-field=\"{$key}\">{$value}</th>\n";
            }
        }
        $html .= "        </tr>\n";
        $html .= "    </thead>\n";
        $html .= "</table>";
        /* Libraries CSS/JS */
        $libs = "/themes/assets/libraries/bootstrap/tables/1.18.3/dist/";
        $libs_css = base_url("{$libs}bootstrap-table.css");
        $libs_js = base_url("/{$libs}/bootstrap-table.js");
        $libs_locale_js = base_url("{$libs}bootstrap-table-locale-all.js");
        $libs_export_js = base_url("{$libs}extensions/export/bootstrap-table-export.js");
        $stycky = "{$libs}extensions/sticky-header/";
        $stycky_css = base_url("{$stycky}bootstrap-table-sticky-header.css");
        $stycky_js = base_url("{$stycky}/bootstrap-table-sticky-header.js");
        $html .= "<script src=\"https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/tableExport.min.js\"></script>";
        $html .= "<script src=\"https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/libs/jsPDF/jspdf.min.js\"></script>";
        $html .= "<script src=\"https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js\"></script>";
        $html .= "\n\t<link rel=\"stylesheet\" href=\"{$libs_css}\">";
        $html .= "\n\t<link rel=\"stylesheet\" href=\"{$stycky_css}\">";
        $html .= "\n\t<script src=\"{$libs_js}\"></script>";
        $html .= "\n\t<script src=\"{$libs_locale_js}\"></script>";
        $html .= "\n\t<script src=\"{$libs_export_js}\"></script>";
        $html .= "\n\t<script src=\"{$stycky_js}\"></script>";
        $html .= "\n <!--[/BS5TABLE]-->";
        return ($html);
    }

    /**
     *
     * @param string $id
     * @param array $attributes
     * @return string
     */
    public static function get_Link(string $id, array $attributes): string
    {
        $text = self::_get_Attribute("text", $attributes);
        $icon = self::_get_Attribute("icon", $attributes);
        $class = self::_get_Attribute("class", $attributes, 'btn-secondary');
        $href = self::_get_Attribute("href", $attributes, '#');
        $target = self::_get_Attribute("target", $attributes, '_self');
        $bstoggle = self::_get_Attribute("data-bs-toggle", $attributes, '');
        $bstarget = self::_get_Attribute("data-bs-target", $attributes, '');
        $text_class = self::_get_Attribute("text-class", $attributes, 'btn-text-inline');
        $onclick = self::_get_Attribute("onclick", $attributes, '');
        $div = "";
        if (!empty($text)) {
            $div = HtmlTag::tag('div');
            $div->attr('class', $text_class);
            $div->content($text);
        }
        $icon = self::get_Icon("icon-{$id}", array("class" => "icon {$icon}"));
        $a = HtmlTag::tag('a');
        $a->attr('id', $id);
        $a->attr('class', "btn {$class}");
        $a->attr('href', $href);
        $a->attr('target', $target);
        $a->attr('data-bs-toggle', $bstoggle);
        $a->attr('data-bs-target', $bstarget);
        $a->attr('onclick', $onclick);
        $a->content(array($icon, $div));
        return ($a->render());
    }

    public static function get_Icon($id, $args = array()): string
    {
        $class = self::_get_Attribute("class", $args, "icon ");
        $content = self::_get_Attribute("content", $args, "");
        $i = HtmlTag::tag('i');
        $i->attr('class', $class);
        $i->content($content);
        return ($i);
    }

    public static function get_Modal($id, $attributes = array())
    {
        $class = self::_get_Attribute("class", $attributes, 'btn-secondary');
        $title = self::_get_Attribute("title", $attributes);
        $body = self::_get_Attribute("body", $attributes);
        $close = self::_get_Attribute("close", $attributes, "Continuar");
        $c = "\n<!-- Modal //--> ";
        $c .= "<div class=\"modal fade\" id=\"{$id}\" tabindex=\"-1\" aria-labelledby=\"{$id}\" aria-hidden=\"true\">";
        $c .= "    <div class=\"modal-dialog modal-dialog-centered modal-dialog-scrollable\">";
        $c .= "        <div class=\"modal-content\">";
        $c .= "            <div class=\"modal-header\">";
        $c .= "                <h5 class=\"modal-title\" id=\"exampleModalLabel\">{$title}</h5>";
        $c .= "                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>";
        $c .= "            </div>";
        $c .= "            <div class=\"modal-body\">";
        $c .= "                {$body}";
        $c .= "            </div>";
        $c .= "            <div class=\"modal-footer\">";
        $c .= "                <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">{$close}</button>";
        $c .= "            </div>";
        $c .= "        </div>";
        $c .= "    </div>";
        $c .= "</div>";
        return ($c);
    }


    /**
     * Crea una instancia de la clase Scores para generar tarjetas de métricas/puntuación
     * Example:
     * $bootstrap = new Bootstrap();
     *
     * // Uso básico
     * $score = $bootstrap->getScore('score-1', [
     * 'title' => 'Estudiantes activos',
     * 'value' => '1,250'
     * ]);
     *
     * // Uso con más atributos
     * $score = $bootstrap->getScore('score-2', [
     * 'title' => 'Cursos completados',
     * 'value' => '89%',
     * 'subtitle' => '+12% este mes',
     * 'icon' => 'bi bi-trophy-fill',
     * 'card-style' => 'background: #28a745;'
     * ]);
     * @param string $id ID único para la tarjeta de puntuación
     * @param array $attributes Atributos de configuración para la tarjeta
     * @return Scores Instancia de la clase Scores
     */
    public function getScore($id, $attributes = array()): Scores
    {
        if (!empty($id)) {
            $attributes['id'] = $id;
        }
        $score = new Scores($attributes);
        return $score;
    }

    /**
     *
     * $attributes=array("prefix"=>"Prefijo","data"=>array("value"=>"valor","label"=>"Etiqueta"));
     * @param $attributes
     * @return string
     */
    public static function getTags($attributes = array())
    {
        $prefix = isset($attributes["prefix"]) ? $attributes["prefix"] : null;
        $data = isset($attributes["data"]) ? $attributes["data"] : [];
        $c = "";
        if(empty($data)){return "";}
        // Handle case where a single item is passed in 'data' instead of an array of items
        if (isset($data["value"]) && isset($data["label"])) {$data = [$data];}
        foreach ($data as $tag) {
            if (!is_array($tag) || !isset($tag["label"])) {
                continue;
            }
            $label = $tag["label"];
            $value = isset($tag["value"]) ? $tag["value"] : null;
            $id_attribute = ($prefix && $value) ? "id=\"{$prefix}_{$value}\"" : "";
            // Using Bootstrap 5 badge classes. 'me-1' for margin between tags.
            $c .= "<span {$id_attribute} class=\"badge text-bg-secondary me-1\">{$label}</span>\n";
        }
        return ($c);
    }

    public static function get_WidgetCounter($id, $attributes = array())
    {
        $icon = self::_get_Attribute("icon", $attributes);
        $count = self::_get_Attribute("count", $attributes);
        $text = self::_get_Attribute("text", $attributes);
        $icon = self::get_Icon("icon-{$id}", array("class" => "icon {$icon} fa-3x"));
        $script = self::_get_Attribute("script", $attributes);
        $c = "";
        $c .= "<div class=\"card flex-row align-items-center align-items-stretch border-0 mb-3\">";
        $c .= "    <div class=\"col-4 d-flex align-items-center bg-gray justify-content-center rounded-left\">";
        $c .= "        {$icon}";
        $c .= "    </div>";
        $c .= "    <div class=\"col-8 py-3 bg-gray rounded-right\">";
        $c .= "        <div id=\"{$id}-count\" class=\"odometer odometer-theme-minimal fs-5 lh-5 my-0\">0</div>";
        $c .= "        <div class=\"    my-0\">{$text}</div>";
        $c .= "    </div>";
        $c .= "</div>";
        $c .= "<script type=\"text/javascript\">";
        $c .= "setTimeout(function () {\$('#{$id}-count').html({$count});},100);";
        $c .= "</script>";
        return ($c);
    }

    public static function get_BtnGroup($id, $attributes = array())
    {
        $class = self::_get_Attribute("class", $attributes, 'btn-group');
        $content = self::_get_Attribute("content", $attributes, '');
        $group = HtmlTag::tag('div');
        $group->attr('class', "{$class}");
        $group->attr('role', 'group');
        $group->content($content);
        return ($group->render());
    }

    /**
     * Crea un grupo de botones vertical utilizando Bootstrap.
     * Los botones se apilan verticalmente uno encima del otro.
     *
     * @param string $id Identificador único del grupo de botones
     * @param array $attributes Atributos de configuración:
     *   - string 'class': Clases CSS adicionales (por defecto: 'btn-group-vertical')
     *   - string 'content': Contenido HTML de los botones
     *   - string 'aria-label': Etiqueta ARIA para accesibilidad
     *   - array 'buttons': Array de botones a generar automáticamente
     *
     * @return string HTML del grupo de botones vertical
     *
     * @example
     * // Uso básico con contenido manual
     * $btnGroup = Bootstrap::get_BtnGroupVertical('my-group', [
     *     'content' => '<button class="btn btn-primary">Botón 1</button><button class="btn btn-secondary">Botón 2</button>'
     * ]);
     *
     * // Uso con generación automática de botones
     * $btnGroup = Bootstrap::get_BtnGroupVertical('my-group', [
     *     'buttons' => [
     *         ['text' => 'Guardar', 'class' => 'btn-primary', 'onclick' => 'save()', 'icon' => 'fas fa-save'],
     *         ['text' => 'Cancelar', 'class' => 'btn-secondary', 'onclick' => 'cancel()', 'icon' => 'fas fa-times'],
     *         ['text' => 'Eliminar', 'class' => 'btn-danger', 'onclick' => 'delete()', 'icon' => 'fas fa-trash']
     *     ]
     * ]);
     */
    function get_BtnGroupVertical($id, $attributes = array())
    {

        $class = $this->_get_Attribute("class", $attributes, 'btn-group-vertical');
        $content = $this->_get_Attribute("content", $attributes, '');
        $ariaLabel = $this->_get_Attribute("aria-label", $attributes, 'Grupo de botones vertical');
        $buttons = $this->_get_Attribute("buttons", $attributes, []);

        // Si se proporcionan botones como array, generarlos automáticamente
        if (!empty($buttons) && is_array($buttons)) {
            $buttonElements = [];
            foreach ($buttons as $index => $button) {
                $btnId = $id . '-btn-' . $index;
                $btnText = $button['text'] ?? 'Botón';
                $btnClass = 'btn ' . ($button['class'] ?? 'btn-secondary');
                $btnOnclick = $button['onclick'] ?? '';
                $btnType = $button['type'] ?? 'button';
                $btnDisabled = ($button['disabled'] ?? false) ? ' disabled' : '';
                $btnIcon = $button['icon'] ?? '';

                // Construir contenido del botón con icono opcional
                $btnContent = '';
                if (!empty($btnIcon)) {
                    $btnContent .= "<i class=\"{$btnIcon}\"></i> ";
                }
                $btnContent .= $btnText;

                // Crear botón individual
                $buttonHtml = "<button id=\"{$btnId}\" type=\"{$btnType}\" class=\"{$btnClass}\"";
                if (!empty($btnOnclick)) {
                    $buttonHtml .= " onclick=\"{$btnOnclick}\"";
                }
                if (!empty($btnDisabled)) {
                    $buttonHtml .= $btnDisabled;
                }
                $buttonHtml .= ">{$btnContent}</button>";

                $buttonElements[] = $buttonHtml;
            }
            $content = implode('', $buttonElements);
        }

        // Crear el grupo de botones vertical
        $groupHtml = "<div id=\"{$id}\" class=\"{$class}\" role=\"group\" aria-label=\"{$ariaLabel}\">";
        $groupHtml .= $content;
        $groupHtml .= "</div>";

        return $groupHtml;
    }

    /**
     *  Nuestras etiquetas ya sean utilizadas para palabras claves (keywords),
     * etiquetas (tags) o insignias (badges), se adaptan al contexto a casi
     * cualquier contenido mediante la utilización del componente badges
     * existente en bootstrap y gracias al cual la insignia (badge) tiene
     * seis posibles variaciones en el class todas ellas añadiendo la
     * class badge. Aqui esta lista.
     *  - badge-default
     *  - badge-primary
     *  - badge-success
     *  - badge-info
     *  - badge-warning
     *  - badge-warning
     *  - badge-danger
     *  Ejemplo: Html::get_Badge($id,array("text"=>"","href"=>"#","class"=>"light"));
     * @param type $id
     * @param type $attributes
     * @return type
     */
    public static function get_Badge($id, $a = array())
    {
        $text = isset($a["text"]) ? $a["text"] : null;
        if (!empty($text)) {
            $href = isset($a["href"]) ? $a["href"] : null;
            $class = isset($a["class"]) ? $a["class"] : "light";
            if (!empty($href)) {
                $target = isset($a["target"]) ? $a["target"] : "_self";
                $c = "<a "
                    . "id=\"{$id}\" "
                    . "href=\"{$href}\" "
                    . "class=\"badge badge-{$class}\" "
                    . "target=\"{$target}\""
                    . ">{$text}</a>";
            } else {
                $c = "<span "
                    . "id=\"{$id}\" "
                    . "class=\"badge badge badge-{$class}\""
                    . ">{$text}</span>";
            }
        } else {
            $c = "";
        }
        return ($c);
    }


    /**
     * Crea una barra de progreso personalizada utilizando atributos.
     * @param $id
     * @param $attributes
     * @return ProgressBar
     * @throws Exception
     */
    public static function get_Progress($id, $attributes = array())
    {
        $min = self::_get_Attribute("min", $attributes, '0');
        $max = self::_get_Attribute("max", $attributes, '100');
        $value = self::_get_Attribute("value", $attributes, '0');
        $class = self::_get_Attribute("class", $attributes, '');
        $progressBar = new ProgressBar(array(
                'value' => $value,
                'min' => $min,
                'max' => $max,
                'class' => $class,
            )
        );
        return ($progressBar);
    }


    /**
     * Retorna Tabs Horizontales
     * @param type $id
     * @param type $attributes
     * @return type
     */
    public static function get_Tabs($id, $attributes = array())
    {
        $items = $attributes["items"];
        $c = "\n\t\t<!-- tabs -->";
        $c .= "\n\t\t<div class=\"col-12 col-md-12 tabs-above p-0\">";
        $c .= "\n\t\t<ul class=\"nav nav-tabs nav-justified\" role=\"tablist\">";
        foreach ($items as $item) {
            $id = $item["id"];
            $href = $item["id"];
            $text = $item["text"];
            $icon = $item["icon"];
            $selected = (isset($item["selected"]) && ($item["selected"])) ? "true" : "false";
            $active = (isset($item["selected"]) && ($item["selected"])) ? "active" : "";
            $c .= "\n\t\t\t<li class=\"nav-item\">";
            $c .= "<a class=\"nav-link text-left radius-0 {$active}\" id=\"tab-{$id}\" data-toggle=\"tab\" href=\"#{$href}\" role=\"tab\" aria-controls=\"{$id}\" aria-selected=\"{$selected}\">";
            $c .= '<i class="' . $icon . ' text-secondary-m2 mr-3px"></i>';
            $c .= '' . $text . '';
            $c .= '</a>';
            $c .= '</li>';
        }
        $c .= "\n\t\t</ul>";
        $c .= "\n\t<div class=\"tab-content rounded-bottom\">";
        foreach ($items as $item) {
            $id = $item["id"];
            $content = $item["content"];
            $active = (isset($item["selected"]) && ($item["selected"])) ? "active" : "";
            $c .= "\n\t\t<div class=\"tab-pane fade show text-95 {$active}\" id=\"{$id}\" role=\"tabpanel\" aria-labelledby=\"{$id}\">";
            $c .= $content;
            $c .= '</div>';
        }
        $c .= "\n\t\t</div>";
        $c .= "\n\t</div>";
        $c .= "<script>";
        $c .= "jQuery(document).ready(function (\$) {";
        $c .= "let selectedTab = window.location.hash;";
        $c .= "\$('.nav-link[href=\"' + selectedTab + '\"]' ).trigger('click');";
        $c .= "})";
        $c .= "</script>";
        return ($c);
    }

    public static function get_Img($id, $attributes = array())
    {
        $alt = self::_get_Attribute("alt", $attributes, "");
        $src = self::_get_Attribute("src", $attributes, "");
        $class = self::_get_Attribute("class", $attributes, "");
        $height = self::_get_Attribute("height", $attributes, "");
        $width = self::_get_Attribute("width", $attributes, "");
        $c = "";
        $c .= "<img src=\"{$src}\" alt=\"{$alt}\" class=\"{$class}\" height=\"{$height}\" width=\"{$width}\">";
        return ($c);
    }

    /**
     * Crea una lista no ordenada con elementos específicos.
     * @param $id
     * @param $attributes
     *      - $lis (array) Los elementos a incluir en la lista no ordenada.
     * @return Html\Tag\TagInterface
     */
    public static function get_Ul($id, $attributes = array())
    {
        $alt = self::_get_Attribute("alt", $attributes, "");
        $src = self::_get_Attribute("src", $attributes, "");
        $class = self::_get_Attribute("class", $attributes, "");
        $height = self::_get_Attribute("height", $attributes, "");
        $width = self::_get_Attribute("width", $attributes, "");
        $lis = self::_get_Attribute("lis", $attributes, "");

        $items = array();
        foreach ($lis as $key => $value) {
            if (!is_array($value)) {
                $li = HtmlTag::tag('li');
                $li->attr('class', 'text-left');
                $li->content($value);
                array_push($items, $li);
            } else {
                $li = HtmlTag::tag('li');
                $li->attr('class', $value['class']);
                $li->content($value['content']);
                array_push($items, $li);
            }
        }
        $ul = HtmlTag::tag('ul');
        $ul->attr('class', $class);
        $ul->content(array($items));
        return ($ul);
    }

    public static function get_Ol($id, $attributes = array())
    {
        $alt = self::_get_Attribute("alt", $attributes, "");
        $src = self::_get_Attribute("src", $attributes, "");
        $class = self::_get_Attribute("class", $attributes, "");
        $height = self::_get_Attribute("height", $attributes, "");
        $width = self::_get_Attribute("width", $attributes, "");
        $lis = self::_get_Attribute("lis", $attributes, "");

        $items = array();
        foreach ($lis as $key => $value) {
            $li = HtmlTag::tag('li');
            $li->attr('class', 'text-left');
            $li->content($value);
            array_push($items, $li);
        }
        $ul = HtmlTag::tag('ol');
        $ul->attr('class', $class);
        $ul->content(array($items));
        return ($ul);
    }

    /**
     * Debe prporsionarse un vector que contenga pares de datos field - label, con el nombre de los campos
     * se genera la matriz imprible y con las etiquetas se deneraran los encabezados.
     * Ejemplo:
     *          $headers=array("surveyable" =>"Encuestable","firstname" =>"Nombres","lastname" =>"Apellidos","rol" =>"Parentesco");
     *          $rows=$msurveyables->where('family', $oid)->findAll();
     *          $table = $b::get_Table('srveyables', array("headers" => $headers, "rows" => $rows));
     */
    public static function Table($id, $attributes = array())
    {
        $class = self::_get_Attribute("class", $attributes, "table table-bordered table-hover");
        $headers = self::_get_Attribute("headers", $attributes, "");
        $rows = self::_get_Attribute("rows", $attributes, "");

        $ths = array();
        foreach ($headers as $key => $value) {
            $th = HtmlTag::tag('th');
            $th->attr('class', 'text-center');
            $th->content($value);
            array_push($ths, $th);
        }
        $trh = HtmlTag::tag('tr');
        $trh->content($ths);

        $trs = array();
        foreach ($rows as $row) {
            $tds = array();
            foreach ($row as $column) {
                $td = HtmlTag::tag('td');
                $td->attr('class', 'px-2');
                $td->content(urldecode($column));
                array_push($tds, $td);
            }
            $tr = HtmlTag::tag('tr');
            $tr->content($tds);
            array_push($trs, $tr);
        }

        $table = HtmlTag::tag('table');
        $table->attr('class', $class);
        $table->content(array($trh, $trs));
        return ($table);
    }

    /**
     * Crea una instancia de la clase HtmlTag representando una etiqueta HTML 'b' con el contenido especificado.
     * @param string $content El contenido que se mostrará dentro de la etiqueta 'b'.
     * @return HtmlTag La instancia de HtmlTag representando una etiqueta HTML 'b' con el contenido especificado.
     */
    public static function get_B($content): Tag
    {
        $b = HtmlTag::tag('b');
        $b->content($content);
        return ($b);
    }

    /**
     * Una etiqueta div es una etiqueta que define las divisiones lógicas existentes en el contenido de una página web.
     * Puede utilizar etiquetas div para centrar bloques de contenido, crear efectos de columna y crear diferentes áreas
     * de color, entre otras posibilidades.
     * @param $id
     * @param $args
     * @return string
     */
    public static function get_Div($id, $args = array())
    {
        $class = self::_get_Attribute("class", $args, "");
        $content = self::_get_Attribute("content", $args, "");
        $c = HtmlTag::tag('div');
        $c->attr('id', $id);
        $c->attr('class', $class);
        $c->content($content);
        return ($c->render());
    }

    /**
     * Toma una lista de atributos y los retorna como una cadena formateada
     * @param type $attributes
     */
    private static function _attributesToString($attributes)
    {
        if (is_array($attributes)) {
            $attr = "";
            foreach ($attributes as $key => $value) {
                $attr .= " {$key}=\"{$value}\"";
            }
            return ($attr);
        } else {
            show_error("No se recibieron los atributos necesarios", 500, "Error al usar la clase HTML");
        }
    }


    /**
     * Crea una instancia de la clase HtmlTag representando una etiqueta HTML 'i' con el contenido especificado.
     * @param $node
     * @return string
     */
    public function get_Tree($node): Tree
    {
        $tree = new Tree($node);
        return ($tree);
    }


    /**
     * @param $text
     * @return TreeNode
     */
    public function get_TreeNode($text, $title = ""): TreeNode
    {
        $node = new TreeNode($text, $title);
        return ($node);
    }

    public function get_Grid($attributes = [])
    {
        $grid = new Html\Grid($attributes);
        return ($grid);
    }

    /**
     * Proporciona comentarios valiosos y procesables a sus usuarios con la validación de formularios HTML5,
     * a través de comportamientos predeterminados del navegador o estilos personalizados y JavaScript.
     * @param $content msg
     * @return string
     */
    public function get_Help($content)
    {
        $div = HtmlTag::tag('div');
        $div->attr('class', 'help-block');
        $div->content($content);
        return ($div->render());
    }

    public function get_Field($attributes = array()): string
    {
        $id = $this->_get_Attribute("id", $attributes);
        $label = $this->_get_Attribute("label", $attributes);
        $group = $this->_get_Attribute("group", $attributes);
        $help = $this->_get_Attribute("help", $attributes);
        $proportion = $this->_get_Attribute("proportion", $attributes);
        $div = HtmlTag::tag('div');
        $div->attr('class', "field-{$id} {$proportion}");
        $div->content(array($label, $group, $help));
        return ($div->render());
    }


    // Eliminar cuando todo use Gamma Theme
    public function get_NavPills($options, $active_url)
    {
        $code = "";
        $code .= "<ul class=\"nav nav-pills flex-column mb-auto mx-0\">\n";
        $code .= "\t\t<li class=\"nav-item align-items-center text-center p-3\">\n";
        $code .= "\t\t\t\t\t\t<i class=\"fa-solid fa-wave-square\"></i>\n";
        $code .= "\t\t\t\t\t\t" . lang("App.Components") . "\n";
        $code .= "\t\t</li>\n";
        foreach ($options as $item) {
            $code .= "\t\t<li class=\"nav-item\">\n";
            $code .= "\t\t\t\t<a href=\"{$item["href"]}\" class=\"nav-link \" target=\"{$item["target"]}\">\n";
            if (isset($item["icon"])) {
                $code .= "\t\t\t\t\t\t<i class=\"{$item["icon"]} align-middle\"></i>\n";
            } elseif (isset($item["svg"])) {
                $code .= "\t\t\t\t\t\t<img class=\"sidebar-svg\" src=\"/themes/assets/icons/{$item["svg"]}\" width=\"24px\"/>\n";
            }
            $code .= "\t\t\t\t\t\t{$item["text"]}\n";
            //$code .= "\t\t\t\t\t\t<span class=\"notification-badge\">5</span>\n";
            $code .= "\t\t\t\t</a>\n";
            $code .= "\t\t</li>\n";
        }
        $code .= "</ul>\n";
        return ($code);
    }


    public function get_NavPillsGamma($options, $active_url)
    {
        $code = "";
        //$code .= "<ul class=\"nav nav-pills flex-column mb-auto mx-0\">\n";
        //$code .= "\t\t<li class=\"nav-item align-items-center text-center p-3\">\n";
        //$code .= "\t\t\t\t\t\t<i class=\"fa-solid fa-wave-square\"></i>\n";
        //$code .= "\t\t\t\t\t\t" . lang("App.Components") . "\n";
        //$code .= "\t\t</li>\n";
        foreach ($options as $item) {
            //$code .= "\t\t<li class=\"nav-item sidebar-item\">\n";
            $code .= "\t\t\t\t<a href=\"{$item["href"]}\" class=\"sidebar-item \" target=\"{$item["target"]}\">\n";
            if (isset($item["icon"])) {
                $code .= "\t\t\t\t\t\t<i class=\"{$item["icon"]} align-middle\"></i>\n";
            } elseif (isset($item["svg"])) {
                $code .= "\t\t\t\t\t\t<img class=\"sidebar-svg\" src=\"/themes/assets/icons/{$item["svg"]}\" width=\"24px\"/>\n";
            }
            $code .= "\t\t\t\t\t<span class=\"sidebar-text\">{$item["text"]}</span>";
            //$code .= "\t\t\t\t\t\t{$item["text"]}\n";
            //$code .= "\t\t\t\t\t\t<span class=\"notification-badge\">5</span>\n";
            $code .= "\t\t\t\t</a>\n";
            //$code .= "\t\t</li>\n";
        }
        //$code .= "</ul>\n";
        return ($code);
    }

    /**
     * El metodo get_Breadcrumb($menu) recibe como argumento una matriz $menu que representa un menú de navegación,
     * y devuelve una cadena de texto que representa un código HTML para generar un panel de navegación o
     * "breadcrumb". Este panel de navegación está estructurado utilizando la sintaxis del framework Bootstrap,
     * y se compone de un elemento nav que contiene una serie de elementos ul y li que representan los elementos
     * del menú. La función itera sobre los elementos de la matriz $menu, y genera el código HTML correspondiente
     * para cada uno de ellos. Este código HTML incluye enlaces o "links" a otros elementos o páginas web externas,
     * y algunos elementos pueden ser desplegables o contener subcategorías. El metodo en general se utiliza para
     * generar un panel de navegación o breadcrumb que se puede utilizar en cualquier sitio web o aplicación
     * que use el framework Bootstrap. Cabe resaltar que la función utiliza la clase actual para llamar a otros
     * métodos en su estructura, por lo que puede necesitar adaptación para ser utilizada fuera del contexto
     * donde es implementada.
     * @see https://getbootstrap.com/docs/5.0/components/breadcrumb/
     * @see https://github.com/jalexiscv/Snipes/blob/master/Libraries/Bootstrap/Breadcrumb.php
     * @param $menu
     * @return string
     */
    public function get_Breadcrumb($menu)
    {
        $code = "";
        $code .= "<nav id=\"breadcrumb\" aria-label=\"breadcrumb\" style=\"--bs-breadcrumb-divider:'>';\">\n";
        $code .= "\t\t<ol class=\"breadcrumb border rounded fs-6\">\n";
        $code .= "\t\t\t\t<li class=\"breadcrumb-item\"><i class=\"fa-solid fa-house\"></i></li>\n";

        if (isset($menu)) {
            foreach ($menu as $item) {
                if (!isset($item["levels"])) {
                    $code .= "<li class=\"breadcrumb-item\">";
                    $code .= "<a class=\"breadcrumb-item-a\" aria-current=\"page\" href=\"{$item["href"]}\">{$item["text"]}</a>";
                    $code .= "</li>";
                } else {
                    $code .= "<li class=\"breadcrumb-item dropdown\">";
                    $code .= "<a class=\"breadcrumb-item-a dropdown-toggle\" href=\"#\" id=\"navbarDropdown\" role=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">";
                    $code .= "{$item["text"]}</a>";
                    $code .= "<ul class=\"dropdown-menu\" aria-labelledby=\"navbarDropdown\">";

                    foreach ($item["levels"] as $subitem) {
                        if (!isset($subitem["separator"])) {
                            if (isset($subitem["active"])) {
                                $code .= '<li class=\"breadcrumb-item\"><a class="dropdown-item active" href="' . $subitem["href"] . '">' . $subitem["text"] . '</a></li>';
                            } else {
                                $code .= '<li class=\"breadcrumb-item\"><a class="dropdown-item" href="' . $subitem["href"] . '">' . $subitem["text"] . '</a></li>';
                            }
                        }
                    }
                    $code .= "</ul>";
                    $code .= "</li>";
                }
            }
        }
        $code .= "\t\t</ol>\n";
        $code .= "</nav>\n";
        return ($code);
    }

    function get_BreadcrumbOLD($menu)
    {
        $navitemdivider = $this->get_Li("divider", array('class' => 'nav-item-divider', 'content' => ''));
        $dropdowndivider = $this->get_Li("divider", array('class' => 'dropdown-divider', 'content' => ''));
        $html = "<div class=\"row\">";
        $html .= "<div class=\"col-12\">";
        $html .= "<nav class=\"navbar navbar-expand-lg py-1 mb-3 breadcrumb w-100\" aria-label=\"breadcrumb\">";
        $html .= "<div class=\"container-fluid p-0\">";
        $html .= "<a class=\"navbar-brand p-0\" href=\"/\"><i class=\"far fa-home-alt\"></i></a>";
        $html .= "<button class=\"navbar-toggler\" type=\"button\" data-bs-toggle=\"collapse\"";
        $html .= "data-bs-target=\"#navbarSupportedContent\"";
        $html .= "aria-controls=\"navbarSupportedContent\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">";
        $html .= "<span class=\"navbar-toggler-icon\"></span>";
        $html .= "</button>";
        $html .= "<div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">";
        $html .= "<ul class=\"navbar-nav me-auto\">";
        if (isset($menu)) {
            foreach ($menu as $item) {
                if (!isset($item["levels"])) {
                    $html .= $navitemdivider;
                    $html .= "<li class=\"nav-item\">";
                    $html .= "<a class=\"nav-link\" aria-current=\"page\" href=\"{$item["href"]}\">{$item["text"]}</a>";
                    $html .= "</li>";
                } else {
                    $html .= $navitemdivider;
                    $html .= "<li class=\"nav-item dropdown\">";
                    $html .= "<a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdown\" role=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">";
                    $html .= "{$item["text"]}</a>";
                    $html .= "<ul class=\"dropdown-menu\" aria-labelledby=\"navbarDropdown\">";

                    foreach ($item["levels"] as $subitem) {
                        if (!isset($subitem["separator"])) {
                            if (isset($subitem["active"])) {
                                $html .= '<li><a class="dropdown-item active" href="' . $subitem["href"] . '">' . $subitem["text"] . '</a></li>';
                            } else {
                                $html .= '<li><a class="dropdown-item" href="' . $subitem["href"] . '">' . $subitem["text"] . '</a></li>';
                            }
                        } else {
                            $html .= $dropdowndivider;
                        }
                    }
                    $html .= "</ul>";
                    $html .= "</li>";
                    $html .= $navitemdivider;
                }
            }
        }
        $html .= "</ul>";
        $html .= "<div class=\"d-flex\"></div>";
        $html .= "</div>";
        $html .= "</nav>";
        $html .= "</div>";
        $html .= "</div>";
        return $html;
    }

    public static function get_Li($id, $args = array()): string
    {
        $class = self::_get_Attribute("class", $args, "");
        $content = self::_get_Attribute("content", $args, "");
        $li = HtmlTag::tag('li');
        $li->attr('class', $class);
        $li->content($content);
        return ($li);
    }

    /**
     * El método get_Icon($id, $args) recibe como argumento una cadena $id que representa el identificador único
     * del icono, y una matriz $args que representa un conjunto de atributos para personalizar el icono. El método
     * devuelve una cadena de texto que representa un código HTML para generar un icono. Este código HTML incluye
     * una etiqueta i con una clase que representa el icono, y otros atributos que se pueden personalizar. El método
     * en general se utiliza para generar un icono que se puede utilizar en cualquier sitio web o aplicación que
     * use el framework Bootstrap. Cabe resaltar que la función utiliza la clase actual para llamar a otros métodos
     * en su estructura, por lo que puede necesitar adaptación para ser utilizada fuera del contexto donde es
     * implementada.
     * @see https://getbootstrap.com/docs/5.0/components/breadcrumb/
     * @param $args array
     */
    public function get_Shortcuts(array $args): Shortcuts
    {
        $shortcuts = new Shortcuts($args);
        return ($shortcuts);
    }

    /**
     * Permite cargar articulos
     * @param array $args
     * @return Posts
     */
    public function get_Posts(array $args): Posts
    {
        $posts = new Posts($args);
        return ($posts);
    }


    /**
     *
     * @return Shortcut
     */
    public function get_Shortcut(array $args): Shortcut
    {
        $shortcut = new Shortcut($args);
        return ($shortcut);
    }

    /**
     * Carga un articulo especifico
     * @param array $args
     * @return Shortcut
     */
    public function get_Post(array $args): Post
    {
        $post = new Post($args);
        return ($post);
    }


}

?>