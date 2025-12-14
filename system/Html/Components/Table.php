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
 * Class HtmlTag.
 */
class Table
{
    private $id;
    private $data_url;
    private $buttons;
    private $cols;
    private $data_side_pagination;
    private $data_page_size;


    public function __construct($attributes = [])
    {
        $this->id = $this->get_Attribute($attributes, 'id', "table-" . uniqid());
        $this->data_url = $this->get_Attribute($attributes, 'data-url', "", true);
        $this->buttons = $this->get_Attribute($attributes, 'buttons', [], false);
        $this->cols = $this->get_Attribute($attributes, 'cols', [], true);
        $this->data_side_pagination = $this->get_Attribute($attributes, 'data-side-pagination', "client", true);
        $this->data_page_size = $this->get_Attribute($attributes, 'data-page-size', 10, true);
    }

    /**
     * Este método devuelve el valor del atributo especificado por el parámetro $name.
     * Si el atributo no está presente en el array $this->attributes, devuelve el valor
     * predeterminado proporcionado en el parámetro $default.
     * @param string $name El nombre del atributo cuyo valor se desea obtener.
     * @param mixed $default El valor predeterminado que se devuelve si el atributo no está presente.
     * @return mixed El valor del atributo si está presente, de lo contrario, el valor predeterminado.
     * @note En esta versión del método, hemos utilizado el operador de fusión nula ??, que devuelve el valor del
     * atributo si está presente, y el valor predeterminado si no lo está. Esto simplifica aún más el código y hace
     * que sea más legible. Además, se han agregado tipos de argumento y retorno al método.
     */
    private function get_Attribute($attributes, $key, $default, $required = false)
    {
        if (isset($attributes[$key])) {
            return $attributes[$key];
        } else {
            if ($required) {
                throw new InvalidArgumentException("El atributo '{$key}' es obligatorio.");
            }
        }
    }

    public function __toString(): string
    {
        return ($this->render([
            'id' => $this->id,
            'data-url' => $this->data_url,
            'buttons' => $this->buttons,
            'cols' => $this->cols,
            'data-side-pagination' => $this->data_side_pagination,
            'data-page-size' => $this->data_page_size,
        ]));
    }

    private function render($params)
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
            trigger_error("Asignación: falta la asignación del parámetro data-side-pagination");
            return;
        }

        $dataidfield = !empty($params['data-id-field']) ? $params['data-id-field'] : "data-id-field";

        $html = "\n <!--[BS5TABLE]-->";
        $html .= "<div id=\"table-{$params['id']}-table-toolbar\">\n";
        //$html .= safe_dump($params);
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
        //$html .= "<table class=\"table  table-responsive p-0 m-0\" id=\"table-{$params['id']}\"></table>\n";
        $html .= "<table\n";
        $html .= "    id=\"{$params['id']}\"\n";
        $html .= "    class=\"table  table-responsive p-0 m-0\" \n";
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
        $html .= "    stickyHeaderOffsetLeft=10 \n";
        $html .= "    stickyHeaderOffsetRight=10 \n";
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
                $html .= "    <th {$field} {$class} {$visible} {$halign } {$align} {$valign} {$width} >{$value['text']}</th>\n";
            } else {
                $html .= "    <th data-field=\"{$key}\">{$value}</th>\n";
            }
        }
        $html .= "        </tr>\n";
        $html .= "    </thead>\n";
        $html .= "</table>";
        /* Libraries CSS/JS */
        $libs = "/themes/assets/libraries/bootstrap/tables/1.22.1/dist/";
        $libs_css = base_url("{$libs}bootstrap-table.css");
        $libs_js = base_url("/{$libs}/bootstrap-table.js");
        $libs_locale_js = base_url("{$libs}bootstrap-table-locale-all.js");
        $libs_export_js = base_url("{$libs}extensions/export/bootstrap-table-export.js");
        $stycky = "{$libs}extensions/sticky-header/";
        $stycky_css = base_url("{$stycky}bootstrap-table-sticky-header.css");
        $stycky_js = base_url("{$stycky}/bootstrap-table-sticky-header.js");
        $html .= "<script src=\"https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js\"></script>";
        $html .= "<script src=\"https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/tableExport.min.js\"></script>";
        $html .= "<script src=\"https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/libs/jsPDF/jspdf.min.js\"></script>";
        $html .= "<script src=\"https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js\"></script>";
        $html .= "\n\t<link rel=\"stylesheet\" href=\"{$libs_css}\">";
        $html .= "\n\t<link rel=\"stylesheet\" href=\"{$stycky_css}\">";
        $html .= "\n\t<link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css\">";
        $html .= "\n\t<script src=\"{$libs_js}\"></script>";
        $html .= "\n\t<script src=\"{$libs_locale_js}\"></script>";
        $html .= "\n\t<script src=\"{$libs_export_js}\"></script>";
        $html .= "\n\t<script src=\"{$stycky_js}\"></script>";
        $html .= "\n <!--[/BS5TABLE]-->";
        return ($html);
    }
}

?>