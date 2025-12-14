<?php
/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2023-12-01 23:19:27
 *  ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 *  ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 *  ** █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 *  ** █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 *  ** █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 *  ** █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 *  ** █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 *  ** █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 *  ** █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 *  ** █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 *  ** █ @link https://www.codehiggs.com
 *  ** █ @Version 1.5.0 @since PHP 7, PHP 8
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ Datos recibidos desde el controlador - @ModuleController
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */

namespace App\Libraries\Html\Bootstrap;

use InvalidArgumentException;

/**
 *
 */
class ListGroupItem
{
    public string $id;
    public string $type;
    public string $checked;
    public string $href;
    public string $image;
    public string $alt;
    public string $title;
    public string $content;
    public string $timestamp;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->id = $this->get_Attribute($attributes, 'id', "lgi-" . lpk(), true);
        $this->type = $this->get_Attribute($attributes, 'type', "standard", true);
        if ($this->type == "switch") {
            $this->checked = $this->get_Attribute($attributes, 'checked', "false", true);
            $this->content = $this->get_Attribute($attributes, 'content', "Some placeholder content in a paragraph.", true);
        }
        $this->href = $this->get_Attribute($attributes, 'href', "#", true);
        $this->image = $this->get_Attribute($attributes, 'image', "/themes/assets/images/icons/line_settings.svg", true);
        $this->alt = $this->get_Attribute($attributes, 'alt', "Bootstrap Gallery", true);
        $this->title = $this->get_Attribute($attributes, 'title', "List group item heading", true);
        $this->timestamp = $this->get_Attribute($attributes, 'timestamp', "now", true);
    }

    /**
     * Este método devuelve el valor del atributo especificado por el parámetro $name.
     * Si el atributo no está presente en el array $this->attributes, devuelve el valor
     * predeterminado proporcionado en el parámetro $default.
     * @param $attributes
     * @param string $key El nombre del atributo cuyo valor se desea obtener.
     * @param mixed $default El valor predeterminado que se devuelve si el atributo no está presente.
     * @param bool $required Si se establece en true, se lanzará una excepción si el atributo no está presente.
     * @return mixed El valor del atributo si está presente, de lo contrario, el valor predeterminado.
     * @note En esta versión del método, hemos utilizado el operador de fusión nula ??, que devuelve el valor del
     * atributo si está presente, y el valor predeterminado si no lo está. Esto simplifica aún más el código y hace
     * que sea más legible. Además, se han agregado tipos de argumento y retorno al método.
     */
    private function get_Attribute($attributes, string $key, mixed $default, bool $required): mixed
    {
        if (isset($attributes[$key])) {
            if (is_string($attributes[$key])) {
                $return = trim($attributes[$key]);
            } elseif (is_array($attributes[$key])) {
                $return = $attributes[$key];
            } else {
                $return = $attributes[$key];
            }
            return ($return);
        } else {
            if ($required) {
                throw new InvalidArgumentException("El atributo '$key' es obligatorio.");
            } else {
                return ($default);
            }
        }
    }

    /**
     * Este método devuelve el código HTML que representa al elemento. El código HTML se genera utilizando
     * la sintaxis HEREDOC, que permite la interpolación de variables y la evaluación de expresiones.
     * @return string El código HTML que representa al elemento.
     * @note En esta versión del método, hemos utilizado la sintaxis HEREDOC para generar el código HTML.
     */
    public function __toString(): string
    {
        $code = "<li class=\"list-group-item list-group-item-action d-flex gap-3 py-3\" aria-current=\"true\">\n";
        $code .= "\t\t\t\t<img src=\"$this->image\" class=\"list-group-item-img rounded-circle flex-shrink-0 img-3x\" alt=\"$this->alt\" />\n";
        $code .= "\t\t\t\t<div class=\"d-flex gap-2 w-100 justify-content-between\">\n";
        $code .= "\t\t\t\t\t\t<div>\n";
        $code .= "\t\t\t\t\t\t\t\t<h6 class=\"mb-0\">$this->title</h6>\n";
        $code .= "\t\t\t\t\t\t\t\t<p class=\"mb-0 opacity-75\">\n";
        if (!empty($this->content)) {
            $code .= "\t\t\t\t\t\t\t\t\t\t$this->content\n";
        }
        $code .= "\t\t\t\t\t\t\t\t</p>\n";
        $code .= "\t\t\t\t\t\t</div>\n";
        //$code .= "\t\t\t\t\t\t<span class=\"badge border border-info text-info\">14</span>\n";
        //$code .= "\t\t\t\t\t\t<small class=\"opacity-50 text-nowrap\">$this->timestamp</small>\n";
        if ($this->type == "switch") {
            $checked = ($this->checked == "true") ? "checked" : "";
            $code .= "\t\t\t\t\t\t<div class=\"form-check form-switch\">\n";
            $code .= "\t\t\t\t\t\t\t<input class=\"form-check-input\" type=\"checkbox\" role=\"switch\" id=\"$this->id\" $checked/>\n";
            $code .= "\t\t\t\t\t\t</div>\n";
        } elseif ($this->type == "button") {
            $code .= "\t\t\t\t\t\t<a href=\"$this->href\" class=\"btn btn-primary\"><i class=\"fa-light fa-eye\"></i></a>\n";

        }
        $code .= "\t\t\t\t</div>\n";
        $code .= "\t\t</li>\n";
        return ($code);
    }
}

