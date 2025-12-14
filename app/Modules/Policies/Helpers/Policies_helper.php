<?php

use Config\Database;

if (!function_exists("generate_acredit_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_acredit_permissions()
    {
        $permissions = array(
            "acredit-access",
            "acredit-applicants-types-create",
            "acredit-applicants-types-view",
            "acredit-applicants-types-view-all",
            "acredit-applicants-types-edit",
            "acredit-applicants-types-edit-all",
            "acredit-applicants-types-delete",
            "acredit-applicants-types-delete-all",
            /** Credits Types * */
            "acredit-credits-types-create",
            "acredit-credits-types-view",
            "acredit-credits-types-view-all",
            "acredit-credits-types-edit",
            "acredit-credits-types-edit-all",
            "acredit-credits-types-delete",
            "acredit-credits-types-delete-all",
        );
        generate_permissions($permissions, "acredit");
    }

}


if (!function_exists("get_snippet_acredit_activities")) {

    /**
     * Este Snippet se localiza a lado derecho de la visualización cuando se
     * accede a las categorias que hacen parte de un componente. Basicamente
     * consulta los datos del autodiagnostico para generar un arbol o estructura del
     * mismo a manera de esquema.
     * @param type $component
     * @return type
     */
    function get_snippet_acredit_activities($cid)
    {
        $dimensions = model("\App\Modules\Disa\Models\Disa_Dimensions", true);
        $politics = model("\App\Modules\Disa\Models\Disa_Politics", true);
        $diagnostics = model("\App\Modules\Disa\Models\Disa_Diagnostics", true);
        $components = model("\App\Modules\Disa\Models\Disa_Components", true);
        $categories = model("\App\Modules\Disa\Models\Disa_Categories", true);

        $category = $categories->find($cid);
        $component = $components->find($category["component"]);
        $diagnostic = $diagnostics->find($component["diagnostic"]);
        $politic = $d = $politics->find($diagnostic["politic"]);
        $dimension = $dimensions->find($politic["dimension"]);

        $dimension_id = $dimension["dimension"];
        $dimension_name = urldecode($dimension["name"]);
        $politic_id = $politic["politic"];
        $politic_name = urldecode($politic["name"]);
        $diagnostic_id = $diagnostic["diagnostic"];
        $diagnostic_name = $diagnostic["name"];
        $component_id = $component["component"];
        $component_name = $component["name"];
        $category_id = $category["category"];
        $category_name = $category["name"];


        $t = "<ul style=\"margin: 0px;padding: 0px 10px 0px 10px;\">";
        $t .= "<li><b>Dimensión</b>:<a href=\"/acredit/siac/dimension/{$dimension_id}\">{$dimension_name}</a></li>";
        $t .= "<li><b>Política</b>: <a href=\"/acredit/siac/diagnostics/view/{$politic_id}\">{$politic_name}</a></li>";
        $t .= "<li><b>Autodiagnóstico</b>: <a href=\"/acredit/siac/components/view/{$diagnostic_id}\">{$diagnostic_name}</a></li>";
        $t .= "<li><b>Componente</b>: <a href=\"/acredit/siac/categories/view/{$component_id}\">{$component_name}</a></li>";
        $t .= "<li><b>Categoría</b>: <a href=\"/acredit/siac/activities/view/{$category_id}\">{$category_name}</a></li>";
        $t .= "</ul>";

        $c = ""
            . "<div class=\"card mb-1\">"
            . "<div class=\"card-header p-1\"><h5 class=\"card-header-title p-1  m-0 opacity-3\">Esquema</h5></div>"
            . "<div class=\"card-body\">"
            . $t
            . "</div>"
            . "</div>";
        return ($c);
    }

}


if (!function_exists("get_snippet_acredit_categories")) {

    /**
     * Este Snippet se localiza a lado derecho de la visualización cuando se
     * accede a las categorias que hacen parte de un componente. Basicamente
     * consulta los datos del autodiagnostico para generar un arbol o estructura del
     * mismo a manera de esquema.
     * @param type $component
     * @return type
     */
    function get_snippet_acredit_categories($cid)
    {
        $dimensions = model("\App\Modules\Disa\Models\Disa_Dimensions", true);
        $politics = model("\App\Modules\Disa\Models\Disa_Politics", true);
        $diagnostics = model("\App\Modules\Disa\Models\Disa_Diagnostics", true);
        $components = model("\App\Modules\Disa\Models\Disa_Components", true);

        $component = $components->find($cid);
        $diagnostic = $diagnostics->find($component["diagnostic"]);
        $politic = $d = $politics->find($diagnostic["politic"]);
        $dimension = $dimensions->find($politic["dimension"]);

        $dimension_id = $dimension["dimension"];
        $dimension_name = urldecode($dimension["name"]);
        $politic_id = $politic["politic"];
        $politic_name = urldecode($politic["name"]);
        $diagnostic_id = $diagnostic["diagnostic"];
        $diagnostic_name = $diagnostic["name"];
        $component_id = $component["component"];
        $component_name = $component["name"];

        $t = "<ul style=\"margin: 0px;padding: 0px 10px 0px 10px;\">";
        $t .= "<li><b>Dimensión</b>:<a href=\"/acredit/siac/dimension/{$dimension_id}\">{$dimension_name}</a></li>";
        $t .= "<li><b>Política</b>: <a href=\"/acredit/siac/diagnostics/view/{$politic_id}\">{$politic_name}</a></li>";
        $t .= "<li><b>Autodiagnóstico</b>: <a href=\"/acredit/siac/components/view/{$diagnostic_id}\">{$diagnostic_name}</a></li>";
        $t .= "<li><b>Componente</b>: <a href=\"/acredit/siac/categories/view/{$component_id}\">{$component_name}</a></li>";
        $t .= "</ul>";

        $c = ""
            . "<div class=\"card mb-1\">"
            . "<div class=\"card-header p-1\"><h5 class=\"card-header-title p-1  m-0 opacity-3\">Esquema</h5></div>"
            . "<div class=\"card-body\">"
            . $t
            . "</div>"
            . "</div>";
        return ($c);
    }

}


if (!function_exists("get_snippet_acredit_components")) {

    /**
     * Este Snippet se localiza a lado derecho de la visualización cuando se
     * accede a los elementos que conforman un autodiagnostico. Basicamente
     * consulta los datos del autodiagnostico para generar un arbol o estructura del
     * mismo a manera de esquema.
     * @param type $component
     * @return type
     */
    function get_snippet_acredit_components($did)
    {
        $model_dimensions = model("\App\Modules\Disa\Models\Disa_Dimensions", true);
        $md = model("\App\Modules\Disa\Models\Disa_Diagnostics", true);
        $mp = model("\App\Modules\Disa\Models\Disa_Politics", true);
        $diagnostic = $md->find($did);
        $politic = $d = $mp->find($diagnostic["politic"]);
        $dimension = $model_dimensions->find($politic["dimension"]);

        $dimension_id = $dimension["dimension"];
        $dimension_name = urldecode($dimension["name"]);
        $politic_id = $politic["politic"];
        $politic_name = urldecode($politic["name"]);
        $diagnostic_id = $diagnostic["diagnostic"];
        $diagnostic_name = $diagnostic["name"];

        $t = "<ul style=\"margin: 0px;padding: 0px 10px 0px 10px;\">";
        $t .= "<li><b>Dimensión</b>:<a href=\"/acredit/siac/dimension/{$dimension_id}\">{$dimension_name}</a></li>";
        $t .= "<li><b>Política</b>: <a href=\"/acredit/siac/diagnostics/view/{$politic_id}\">{$politic_name}</a></li>";
        $t .= "<li><b>Autodiagnóstico</b>: <a href=\"/acredit/siac/components/view/{$diagnostic_id}\">{$diagnostic_name}</a></li>";
        $t .= "</ul>";


        $c = ""
            . "<div class=\"card mb-1\">"
            . "<div class=\"card-header p-1\"><h5 class=\"card-header-title p-1  m-0 opacity-3\">Esquema</h5></div>"
            . "<div class=\"card-body\">"
            . $t
            . "</div>"
            . "</div>";
        return ($c);
    }

}


if (!function_exists("get_snippet_acredit_furag")) {

    function get_snippet_acredit_furag()
    {
        $f = '<form action="/acredit/siac/furag/view" id="formquey" enctype="multipart/form-data" method="post" accept-charset="utf-8">';
        $f .= '<div class="form-group row">';
        $f .= '<div class="col-12">';
        $f .= '<div class="input-group">';
        $f .= '<div class="input-group-prepend">';
        $f .= '<div class="input-group-text">';
        $f .= '<i class="fas fa-ticket-alt"></i>';
        $f .= '</div>';
        $f .= '</div>';
        $f .= '<input id="sigep" name="sigep" type="text" class="form-control" aria-describedby="tiketHelpBlock" required="required">';
        $f .= '</div>';
        $f .= '<span id="tiketHelpBlock" class="form-text text-muted">Código de 4 caracteres</span>';
        $f .= '</div>';
        $f .= '</div>';
        $f .= '<div class="form-group row">';
        $f .= '<div class="col-12">';
        $f .= '<button name="submit" type="submit" class="btn btn-primary">Consultar</button>';
        $f .= '</div>';
        $f .= '</div>';
        $f .= '</form>';
        $c = ""
            . "<div class=\"card mb-1\">"
            . "<div class=\"card-header p-1\"><h5 class=\"card-header-title p-1  m-0 opacity-3\">Consulta Furag</h5></div>"
            . "<div class=\"card-body\">"
            . $f
            . "</div>"
            . "</div>";
        return ($c);
    }

}

function generate_acredit_dbtables()
{
    $forge = Database::forge("Authentication");
    $forge->addField([
        'macroprocesses' => ['type' => 'VARCHAR', 'constraint' => 13],
        'name' => ['type' => 'VARCHAR', 'constraint' => '254', 'unique' => true],
        'description' => ['type' => 'TEXT', 'null' => true],
        'author' => ['type' => 'VARCHAR', 'constraint' => 13],
        'created_at datetime default current_timestamp',
        'updated_at datetime default current_timestamp on update current_timestamp',
        'deleted_at' => ['type' => 'TIMESTAMP', 'null' => true],
    ]);
    $forge->addKey('macroprocesses', true);
    $forge->createTable('acredit_macroprocesses', true);
}

function get_acredit_sidebar($active_url = false)
{
    $options = array(
        "home" => array("text" => lang("App.Home"), "href" => "/policies/", "icon" => "far fa-home"),
        "applicants_types" => array("text" => "Términos y condiciones", "href" => "/policies/conditions", "icon" => "far fa-shield-check"),
        "types-of-credits" => array("text" => "Políticas de privacidad", "href" => "/policies/privacy", "icon" => "far fa-shield-check"),
        //"institutionality" => array("text" => lang("App.Institutionality"), "href" => "/acredit/institutionality/", "icon" => "far fa-university"),
        //"settings" => array("text" => lang("App.Settings"), "href" => "/acredit/settings/", "icon" => "far fa-cogs"),
        //"history" => array("text" => lang("App.History"), "href" => "/acredit/history/", "icon" => "far fa-history"),
    );
    $return = get_application_custom_sidebar($options, $active_url);
    return ($return);
}

?>