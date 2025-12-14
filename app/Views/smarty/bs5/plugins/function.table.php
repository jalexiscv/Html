<?php

/*
 * Copyright (c) 2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.table.php
 * Type:     function
 * Name:     table
 * Purpose:  Generar una tabla dinamica en formato de bs5
 * -------------------------------------------------------------
 * Notes: <i class=\"fas fa-plus text-100\"></i> Plus
 */

//use App\Libraries\Params;

function smarty_function_table($params, &$smarty)
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

?>