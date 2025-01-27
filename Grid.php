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

namespace App\Libraries\Html;

use InvalidArgumentException;

/**
 * Class HtmlTag.
 */
class Grid
{
    private $attributes;

    private $headers;
    private $rows;
    private $id;
    private $class;

    private $total;

    private $limit;

    private $offset;

    private $search;

    private $fields;

    private $field;

    private $limits = [10, 25, 50, 100, 200, 400, 800, 1600];

    private $buttons = [];

    /**
     * Constructor de la clase.
     * @param array $attributes Un array de atributos para la tabla.
     */

    public function __construct($attributes = [])
    {
        $this->id = $this->get_Attribute('id', "grid-default-" . uniqid());
        $this->class = $this->get_Attribute('class', "table table-striped table-bordered table-res table-hover");
        $this->headers = $attributes;
        $this->rows = [];
        $this->total = 0;
        $this->limit = 0;
        $this->offset = 0;
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
    public function get_Attribute($name, $default): string
    {
        return $this->attributes[$name] ?? $default;
    }

    /**
     * Establece el valor del atributo especificado por el parámetro $name.
     * @param $class
     * @return void
     */
    public function set_Class($class, $add = true): void
    {
        if ($add) {
            $this->class .= $class;
        } else {
            $this->class = $class;
        }
    }

    /**
     * Establece el valor de la propiedad id.
     * Si el valor proporcionado es null o vacío, se lanza una excepción.
     * @param int|string $value El valor que se asignará a la propiedad id.
     * @throws InvalidArgumentException Si el valor proporcionado es null o vacío.
     */
    public function set_Id($value)
    {
        if ($value === null || $value === '') {
            throw new InvalidArgumentException('El valor no puede ser null o vacío.');
        }

        $this->id = $value;
    }

    /**
     * Establece los encabezados de la tabla a partir de un array de atributos.
     * @param array $attributes Un array de encabezados para la tabla.
     * @throws InvalidArgumentException Si el array proporcionado está vacío.
     */
    public function set_Headers(array $attributes): void
    {
        if (empty($attributes)) {
            throw new InvalidArgumentException('El array de encabezados no puede estar vacío.');
        }
        $this->headers = $attributes;
    }

    /**
     * Este metodo establece el valor de la propiedad limits a partir de un array de límites.
     * @param array $limits
     * @return void
     */
    public function set_Limits(array $limits): void
    {
        if (empty($limits)) {
            throw new InvalidArgumentException('El array de límites no puede estar vacío.');
        }
        $this->limits = $limits;
    }


    /**
     * Agrega una fila de datos a la tabla.
     * @param array $row Un array de celdas que representan una fila en la tabla.
     * @throws InvalidArgumentException Si el array proporcionado está vacío.
     */
    public function add_Row(array $row): void
    {
        if (empty($row)) {
            throw new InvalidArgumentException('La fila no puede estar vacía.');
        }
        $this->rows[] = $row;
    }


    /**
     * Establece el valor de la propiedad total.
     * @param $total
     * @return void
     */
    public function set_Total($total): void
    {
        $this->total = $total;
    }

    /**
     * Establece el valor de la propiedad limit.
     * @param $limit
     * @return void
     */
    public function set_Limit($limit): void
    {
        $this->limit = $limit;
    }

    /**
     * Establece el valor de la propiedad offset.
     * @param $offset
     * @return void
     */
    public function set_Offset($offset): void
    {
        $this->offset = $offset;
    }

    public function set_Search($attributes = []): void
    {
        $this->search = $attributes['search'] ?? '';
        $this->fields = $attributes['fields'] ?? [];
        $this->field = $attributes['field'] ?? '';
    }


    public function set_Buttons($buttons = []): void
    {
        $this->buttons = $buttons;
    }


    private function get_Buttons()
    {
        $code = "<!-- [buttons] //-->\n";
        $buttons = $this->buttons;
        if (is_array($buttons) && count($buttons) > 0) {
            $code .= "\t\t\t <div class=\"input-group mb-3\">\n";
            foreach ($buttons as $button) {
                $code .= "\t\t\t\t {$button}\n";
            }
            $code .= "\t\t\t </div>\n";
        }
        $code .= "<!-- [/buttons] //-->\n";
        return ($code);
    }


    private function get_Search()
    {
        $code = "<!-- [search] //-->\n";
        $fields = $this->fields;
        if (is_array($fields) && count($fields) > 0) {
            $search_name = "{$this->id}-search";
            $field_name = "{$this->id}-field";
            $field_options = $this->fields ?? [];
            $search = $this->search;
            $field = $this->field;
            $code .= "\t\t\t <div class=\"input-group mb-3\">\n";
            $code .= "\t\t\t\t <select id=\"{$field_name}\" class=\"form-select\">\n";
            foreach ($field_options as $value => $label) {
                $selected = ($value == $field) ? 'selected' : '';
                $code .= "\t\t\t\t\t <option value=\"{$value}\" {$selected}>{$label}</option>\n";
            }
            $code .= "\t\t\t\t </select>\n";
            $code .= "\t\t\t\t <input type=\"text\" id=\"{$search_name}\" class=\"form-control\" placeholder=\"Buscar...\" aria-label=\"Buscar...\" aria-describedby=\"button-addon2\" value=\"{$search}\">\n";
            $code .= "\t\t\t\t <button class=\"btn btn-outline-secondary\" type=\"button\" id=\"button-addon2\">Buscar</button>\n";
            $code .= "\t\t\t </div>\n";
            $code .= "\t\t\t <script>\n";
            $code .= "document.getElementById('button-addon2').addEventListener('click', function() {\n";
            $code .= "\t\t\t var field = document.getElementById('{$field_name}').value;\n";
            $code .= "\t\t\t var search = document.getElementById('{$search_name}').value;\n";
            $code .= "\t\t\t var url = new URL(window.location.href);\n";
            $code .= "\t\t\t url.searchParams.set('field', field);\n";
            $code .= "\t\t\t url.searchParams.set('search', search);\n";
            $code .= "\t\t\t window.location.href = url.toString();\n";
            $code .= "\t\t });\n";
            $code .= "document.getElementById('{$search_name}').addEventListener('keydown', function(event) {\n";
            $code .= "    if (event.key === 'Enter') {\n";
            $code .= "        var field = document.getElementById('{$field_name}').value;\n";
            $code .= "        var search = document.getElementById('{$search_name}').value;\n";
            $code .= "        var url = new URL(window.location.href);\n";
            $code .= "        url.searchParams.set('field', field);\n";
            $code .= "        url.searchParams.set('search', search);\n";
            $code .= "        window.location.href = url.toString();\n";
            $code .= "    }\n";
            $code .= "});\n";
            $code .= "\t\t </script>\n";
        }
        $code .= "<!-- [/search] //-->\n";
        return ($code);
    }

    public function get_Tools()
    {
        $search_name = "{$this->id}-search";
        $code = "<!-- [search] //-->\n";
        $code .= "\t <div class=\"row\">\n";
        $code .= "\t\t <div class=\"col-6\">\n";
        $code .= $this->get_Buttons();
        $code .= "\t\t </div>\n";
        $code .= "\t\t <div class=\"col-6\">\n";
        $code .= $this->get_Search();
        $code .= "\t\t </div>\n";
        $code .= "\t </div>\n";
        $code .= "<!-- [/search] //-->\n";
        return ($code);
    }


    public function get_PageSize()
    {
        $search_name = "{$this->id}-search";
        $select_name = "{$this->id}-select";
        $limit = $this->limit;
        $limits = $this->limits;
        $code = "<!-- [page-size] //-->\n";
        $code .= "\t <select id=\"{$select_name}\" class=\"form-select form-select-sm\" aria-label=\"\" aria-controls=\"{$this->id}\" style=\"width: auto;display: inline-block;\">\n";
        foreach ($limits as $value) {
            $selected = ($value == $limit) ? 'selected' : '';
            $code .= "\t\t <option value=\"{$value}\" {$selected}>{$value}</option>\n";
        }
        $code .= "\t </select>\n";
        $code .= "\t <script>\n";
        $code .= "document.addEventListener('DOMContentLoaded', function() {\n";
        $code .= "\t\tdocument.getElementById('{$select_name}').addEventListener('change', function() {\n";
        $code .= "\t\t\t\tvar limit = this.value;\n";
        $code .= "\t\t\t\tvar offset = 0;\n";
        $code .= "\t\t\t\tvar search = document.getElementById('{$search_name}').value;\n";
        $code .= "\t\t\t\tvar draw = 1;\n";
        $code .= "\t\t\t\tvar url = window.location.href.split('?')[0];\n";
        $code .= "\t\t\t\tvar params = new URLSearchParams({ limit: limit, offset: offset, search: search, draw: draw });\n";
        $code .= "\t\t\t\twindow.location.href = url + '?' + params.toString();\n";
        $code .= "\t\t});\n";
        $code .= "});\n";
        $code .= "\t </script>\n";
        $code .= "<!-- [/page-size] //-->\n";
        return ($code);
    }

    public function get_Pagination_Info()
    {
        $offset = $this->offset + 1;
        $total = $this->total;
        $select = $this->get_PageSize();
        $to = $this->offset + $this->limit;
        $info = "Mostrando desde {$offset} hasta {$to} - En total {$total} resultados,  {$select} resultados por página";
        $code = "<!-- [pagination-info] //-->\n";
        $code .= "\t <div class=\"row\">\n";
        $code .= "\t\t <div class=\"col-12\">\n";
        $code .= "\t\t\t <div class=\"text-left py-2\" id=\"{$this->id}_info\" role=\"status\" aria-live=\"polite\">{$info}</div>\n";
        $code .= "\t\t </div>\n";
        $code .= "\t </div>\n";
        $code .= "<!-- [/pagination-info] //-->\n";
        return ($code);
    }

    public function get_Pagination()
    {
        $code = "<!-- [pagination] //-->\n";
        $offset = $this->offset;
        $limit = $this->limit;
        $search = $this->search;
        $total = $this->total;
        $current_page = 1;
        $total_pages = 1;
        if ($limit > 0) {
            $current_page = ($offset / $limit) + 1;
            $total_pages = ceil($total / $limit);
        }

        $code .= "\t <div class=\"row\">\n";
        $code .= "\t\t <div class=\"col-12\">\n";
        $code .= "\t\t\t <nav aria-label=\"Page navigation example\" class=\"float-right\">\n";
        $code .= "\t\t\t\t\t <ul class=\"pagination\">\n";
        $prev_offset = max(0, $offset - $limit);
        $code .= "\t\t\t\t\t\t<li class=\"page-item " . ($current_page == 1 ? 'disabled' : '') . "\">\n";
        $code .= "\t\t\t\t\t\t\t<a class=\"page-link\" href=\"?limit={$limit}&offset={$prev_offset}&search={$search}\" aria-label=\"Previous\">\n";
        $code .= "\t\t\t\t\t\t\t\t<span aria-hidden=\"true\">«</span>\n";
        $code .= "\t\t\t\t\t\t\t</a>\n";
        $code .= "\t\t\t\t\t\t</li>\n";

        // Show first three pages
        for ($i = 1; $i <= min(3, $total_pages); $i++) {
            $page_offset = ($i - 1) * $limit;
            $code .= "\t\t\t\t\t\t<li class=\"page-item " . ($i == $current_page ? 'active' : '') . "\">";
            $code .= "\t\t\t\t\t\t\t<a class=\"page-link\" href=\"?limit={$limit}&offset={$page_offset}&search={$search}\">{$i}</a>";
            $code .= "\t\t\t\t\t\t</li>\n";
        }

        // Show ellipsis if there are more than 6 pages
        if ($total_pages > 6) {
            $code .= "\t\t\t\t\t\t<li class=\"page-item disabled\"><span class=\"page-link\">...</span></li>\n";
        }

        // Show last three pages
        for ($i = max(4, $total_pages - 2); $i <= $total_pages; $i++) {
            $page_offset = ($i - 1) * $limit;
            $code .= "\t\t\t\t\t\t<li class=\"page-item " . ($i == $current_page ? 'active' : '') . "\">";
            $code .= "\t\t\t\t\t\t\t<a class=\"page-link\" href=\"?limit={$limit}&offset={$page_offset}&search={$search}\">{$i}</a>";
            $code .= "\t\t\t\t\t\t</li>\n";
        }

        $next_offset = min($total - $limit, $offset + $limit);
        $code .= "\t\t\t\t\t\t<li class=\"page-item " . ($current_page == $total_pages ? 'disabled' : '') . "\">\n";
        $code .= "\t\t\t\t\t\t\t<a class=\"page-link\" href=\"?limit={$limit}&offset={$next_offset}&search={$search}\" aria-label=\"Next\">\n";
        $code .= "\t\t\t\t\t\t\t\t<span aria-hidden=\"true\">»</span>\n";
        $code .= "\t\t\t\t\t\t\t</a>\n";
        $code .= "\t\t\t\t\t </li>\n";
        $code .= "\t\t\t\t </ul>\n";
        $code .= "\t\t\t </nav>\n";
        $code .= "\t\t </div>\n";
        $code .= "\t </div>\n";
        $code .= "<!-- [/pagination] //-->\n";
        return ($code);
    }


    /**
     * Renderiza una celda de la tabla. Si la celda es un array, se renderiza con las propiedades 'content' y 'class'.
     * @param $cell
     * @return string
     */
    private function render_Cell($cell): string
    {
        if (is_array($cell)) {
            $content = $cell['content'] ?? '';
            $class = $cell['class'] ?? '';
            $colspan=$cell['colspan'] ?? '';
            $code = "<td class=\"{$class}\" colspan=\"{$colspan}\" >{$content}</td>";
        } else {
            $code = "<td>{$cell}</td>";
        }
        return($code);
    }

    /**
     * Generado a amno con posibles errores
     * @param $currentPage
     * @param $totalPages
     * @param $baseUrl
     * @return string
     */
    function render_Pagination($currentPage, $totalPages, $baseUrl)
    {
        $links = '';

        // Botón Previous
        $prevClass = ($currentPage <= 1) ? ' disabled' : '';
        $links .= '
        <li class="page-item' . $prevClass . '">
            <a class="page-link" href="' . $baseUrl . '&page=' . ($currentPage - 1) . '" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>';

        // Páginas numeradas
        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = ($currentPage == $i) ? ' active' : '';
            $links .= '
            <li class="page-item' . $activeClass . '">
                <a class="page-link" href="' . $baseUrl . '&page=' . $i . '">' . $i . '</a>
            </li>';
        }

        // Botón Next
        $nextClass = ($currentPage >= $totalPages) ? ' disabled' : '';
        $links .= '
        <li class="page-item' . $nextClass . '">
            <a class="page-link" href="' . $baseUrl . '&page=' . ($currentPage + 1) . '" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>';

        return $links;
    }

    /**
     * Renderiza una fila de la tabla. Cada celda de la fila se renderiza con el método render_Cell.
     * @param $row
     * @return string
     */
    private function render_Row($row): string
    {
        $code = "<tr>\n";
        foreach ($row as $cell) {
            $code .= $this->render_Cell($cell);
        }
        $code .= "</tr>\n";
        return ($code);
    }

    public function __toString()
    {
        $table = "<!-- [table] //-->";
        $table .= "<div class=\"container p-0\">";
        $table .= "<div class=\"row\">";
        $table .= "<div class=\"col-12\">";
        $table .= $this->get_Tools();
        $table .= "<div id=\"container-{$this->id}\" class=\"table-responsive\">";
        $table .= "<table id=\"{$this->id}\" class=\"{$this->class}\">";
        if (!empty($this->headers)) {
            $table .= "<thead>\n<tr>\n";
            foreach ($this->headers as $header) {
                if (is_array($header)) {
                    $header_content = $header['content'] ?? '';
                    $header_class = $header['class'] ?? '';
                    $table .= "<th class=\"{$header_class}\">{$header_content}</th>";
                } else {
                    $table .= "<th>{$header}</th>";
                }
            }
            $table .= "\n</tr>\n</thead>\n";
        }
        if (!empty($this->rows)) {
            $table .= "<tbody>\n";
            foreach ($this->rows as $row) {
                $table .= $this->render_Row($row);
            }
            $table .= "</tbody>\n";
        }
        $table .= "</table></div>\n";
        $table .= $this->get_Pagination_Info();
        $table .= $this->get_Pagination();
        $table .= "</div>";
        $table .= "</div>";
        $table .= "</div>";
        return $table;
    }

}
