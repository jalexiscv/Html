<?php
/*
 * Copyright (c) 2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

if (!function_exists("generate_disa_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_disa_permissions()
    {
        $permissions = array(
            "disa-access",
            "disa-furag-create",
            "disa-furag-view",
            "disa-furag-view-all",
            "disa-furag-edit",
            "disa-furag-edit-all",
            "disa-furag-delete",
            "disa-furag-delete-all",
            "disa-characterizations-create",
            "disa-diagnostics-create",
            "disa-components-view",
            "disa-components-view-all",
            "disa-components-create",
            "disa-components-edit",
            "disa-components-delete",
            /** Macroprocesses * */
            "disa-macroprocesses-view",
            "disa-macroprocesses-view-all",
            "disa-macroprocesses-create",
            "disa-macroprocesses-edit",
            "disa-macroprocesses-edit-all",
            "disa-macroprocesses-delete",
            "disa-macroprocesses-delete-all",
            /** Processes * */
            "disa-processes-view",
            "disa-processes-view-all",
            "disa-processes-create",
            "disa-processes-edit",
            "disa-processes-edit-all",
            "disa-processes-delete",
            "disa-processes-delete-all",
            /** Subprocesses * */
            "disa-subprocesses-view",
            "disa-subprocesses-view-all",
            "disa-subprocesses-create",
            "disa-subprocesses-edit",
            "disa-subprocesses-edit-all",
            "disa-subprocesses-delete",
            "disa-subprocesses-delete-all",
            /** Positions * */
            "disa-positions-view",
            "disa-positions-view-all",
            "disa-positions-create",
            "disa-positions-edit",
            "disa-positions-edit-all",
            "disa-positions-delete",
            "disa-positions-delete-all",
            /** Politics * */
            "disa-dimensions-view",
            "disa-dimensions-view-all",
            "disa-dimensions-create",
            "disa-dimensions-edit",
            "disa-dimensions-edit-all",
            "disa-dimensions-delete",
            "disa-dimensions-delete-all",
            /** Politics * */
            "disa-politics-view",
            "disa-politics-view-all",
            "disa-politics-create",
            "disa-politics-edit",
            "disa-politics-edit-all",
            "disa-politics-delete",
            "disa-politics-delete-all",
            /** Diagnostics * */
            "disa-diagnostics-view",
            "disa-diagnostics-view-all",
            "disa-diagnostics-create",
            "disa-diagnostics-edit",
            "disa-diagnostics-edit-all",
            "disa-diagnostics-delete",
            "disa-diagnostics-delete-all",
            /** Components * */
            "disa-components-view",
            "disa-components-view-all",
            "disa-components-create",
            "disa-components-edit",
            "disa-components-edit-all",
            "disa-components-delete",
            "disa-components-delete-all",
            /** Categories * */
            "disa-categories-view",
            "disa-categories-view-all",
            "disa-categories-create",
            "disa-categories-edit",
            "disa-categories-edit-all",
            "disa-categories-delete",
            "disa-categories-delete-all",
            /** Activities * */
            "disa-activities-view",
            "disa-activities-view-all",
            "disa-activities-create",
            "disa-activities-edit",
            "disa-activities-edit-all",
            "disa-activities-delete",
            "disa-activities-delete-all",
            /** Scores * */
            "disa-scores-view",
            "disa-scores-view-all",
            "disa-scores-create",
            "disa-scores-edit",
            "disa-scores-edit-all",
            "disa-scores-delete",
            "disa-scores-delete-all",
            /** Plans * */
            "disa-plans-view",
            "disa-plans-view-all",
            "disa-plans-create",
            "disa-plans-edit",
            "disa-plans-edit-all",
            "disa-plans-delete",
            "disa-plans-delete-all",
            "disa-plans-statuses-approve",
            "disa-plans-statuses-request-approve",
            "disa-plans-statuses-evaluate",
            "disa-plans-statuses-request-evaluate",
            "disa-plans-manager-causes-edit",
            "disa-plans-manager-causes-edit-all",
            "disa-plans-manager-actions-edit",
            "disa-plans-manager-actions-edit-all",
            /** Actions * */
            "disa-actions-view",
            "disa-actions-view-all",
            "disa-actions-create",
            "disa-actions-edit",
            "disa-actions-edit-all",
            "disa-actions-delete",
            "disa-actions-delete-all",
            /** Statuses * */
            "disa-statuses-view",
            "disa-statuses-view-all",
            "disa-statuses-create",
            "disa-statuses-edit",
            "disa-statuses-edit-all",
            "disa-statuses-delete",
            "disa-statuses-delete-all",
            /** Institutional Plans * */
            "disa-institutional-plans-view",
            "disa-institutional-plans-view-all",
            "disa-institutional-plans-create",
            "disa-institutional-plans-edit",
            "disa-institutional-plans-edit-all",
            "disa-institutional-plans-delete",
            "disa-institutional-plans-delete-all",
            "disa-institucionality-attachments-delete",
            "disa-institucionality-attachments-delete-all",
            /** Causes * */
            "disa-causes-view",
            "disa-causes-view-all",
            "disa-causes-create",
            "disa-causes-edit",
            "disa-causes-edit-all",
            "disa-causes-delete",
            "disa-causes-delete-all",
            "disa-causes-evaluate",
            /** Whys * */
            "disa-whys-view",
            "disa-whys-view-all",
            "disa-whys-create",
            "disa-whys-edit",
            "disa-whys-edit-all",
            "disa-whys-delete",
            "disa-whys-delete-all",
            /** Recommendations **/
            "disa-recommendations-view",
            "disa-recommendations-view-all",
            "disa-recommendations-create",
            "disa-recommendations-edit",
            "disa-recommendations-edit-all",
            "disa-recommendations-delete",
            "disa-recommendations-delete-all",
            /** Characterization **/
            "disa-characterizations-view",
            "disa-characterizations-create",
            /** Logs **/
            "history-logs-view",
            "history-logs-view-all",
            /** Programs **/
            "disa-programs-view",
            "disa-programs-view-all",
            "disa-programs-create",
            "disa-programs-edit",
            "disa-programs-edit-all",
            "disa-programs-delete",
            "disa-programs-delete-all",
        );
        generate_permissions($permissions, "disa");
        //generate_disa_dbtables();
    }

}

if (!function_exists("get_disa_sidebar")) {
    function get_disa_sidebar($active_url = false)
    {
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/disa/", "icon" => "far fa-home"),
            "settings" => array("text" => lang("App.Entitie"), "href" => "/disa/settings/home/" . lpk(), "icon" => "far fa-landmark", "permission" => "DISA-ACCESS"),
            "institutionality" => array("text" => "Adecuación", "href" => "/disa/mipg/institutionality/home/" . lpk(), "icon" => "far fa-archive", "permission" => "DISA-ACCESS"),
            //"mipg" => array("text" => lang("App.MIPG"), "href" => "/disa/mipg/", "icon" => "fal fa-bullseye-pointer", "permission" => "DISA-ACCESS"),
            "institutional" => array("text" => "Institucionales", "href" => "/disa/institutional/home/" . lpk(), "icon" => "far fa-books", "permission" => "DISA-ACCESS"),
            "dimensions" => array("text" => lang("App.Dimensions"), "href" => "/disa/mipg/dimensions/home/" . lpk(), "icon" => "far fa-layer-group", "permission" => "DISA-ACCESS"),
            "control" => array("text" => "Control", "href" => "/disa/mipg/control/" . lpk(), "icon" => "fas fa-tasks", "permission" => "DISA-ACCESS"),
            "recommendations" => array("text" => lang("App.Recommendations"), "href" => "/disa/mipg/recommendations/home/" . lpk(), "icon" => "far fa-pennant", "permission" => "DISA-ACCESS"),
        );
        $return = get_application_custom_sidebar($options, $active_url);
        return ($return);
    }
}


if (!function_exists("get_disa_messenger_users")) {
    /**
     * Retorna el listado inicial de usuarios que se graficaran en el listado del messenger
     * @user string còdigo del usuario que realiza la consulta.
     */
    function get_disa_messenger_users($user)
    {
        $musers = model('App\Modules\Disa\Models\fleet_Users');
        $mfields = model('App\Modules\Disa\Models\fleet_Users_Fields');
        $users = $musers->select('user')->findAll();
        $list = array();
        foreach ($users as $user) {
            $profile = $mfields->get_Profile($user['user']);
            $user["name"] = $profile["name"];
            array_push($list, $user);
        }
        return ($list);
    }

}


if (!function_exists("get_snippet_disa_actions")) {

    /**
     * Este Snippet se localiza a lado derecho de la visualización cuando se
     * @param type $component
     * @return type
     */
    function get_snippet_disa_actions($pid)
    {
        $strings = service("strings");
        $dimensions = model("\App\Modules\Disa\Models\Disa_Dimensions", true);
        $politics = model("\App\Modules\Disa\Models\Disa_Politics", true);
        $diagnostics = model("\App\Modules\Disa\Models\Disa_Diagnostics", true);
        $components = model("\App\Modules\Disa\Models\Disa_Components", true);
        $categories = model("\App\Modules\Disa\Models\Disa_Categories", true);
        $activities = model("\App\Modules\Disa\Models\Disa_Activities", true);
        $plans = model("\App\Modules\Disa\Models\Disa_Plans", true);
        $actions = model("\App\Modules\Disa\Models\Disa_Actions", true);

        $action = $actions->withDeleted()->find($pid);
        $plan = $plans->find($action["plan"]);
        $activity = $activities->find($plan["activity"]);
        $category = $categories->find($activity["category"]);
        $component = $components->find($category["component"]);
        $diagnostic = $diagnostics->find($component["diagnostic"]);
        $politic = $d = $politics->find($diagnostic["politic"]);
        $dimension = $dimensions->find($politic["dimension"]);

        $dimension_name = urldecode($dimension["name"]);
        $politic_name = urldecode($politic["name"]);
        $diagnostic_name = urldecode($diagnostic["name"]);
        $component_name = urldecode($component["name"]);
        $category_name = $strings->get_Striptags(urldecode($category["name"]));
        $activity_name = $strings->get_Striptags(urldecode($activity["description"]));

        $t = "<ul style=\"margin: 0px;padding: 0px 10px 0px 10px;\">";
        $t .= "<li><b>Dimensión</b>:<a href=\"/disa/mipg/politics/list/{$dimension["dimension"]}\">{$dimension_name}</a></li>";
        $t .= "<li><b>Política</b>: <a href=\"/disa/mipg/diagnostics/list/{$politic["politic"]}\">{$politic_name}</a></li>";
        $t .= "<li><b>Autodiagnóstico</b>: <a href=\"/disa/mipg/components/list/{$diagnostic["diagnostic"]}\">{$diagnostic_name}</a></li>";
        $t .= "<li><b>Componente</b>: <a href=\"/disa/mipg/categories/list/{$component["component"]}\">{$component_name}</a></li>";
        $t .= "<li><b>Categoría</b>:  <a href=\"/disa/mipg/activities/list/{$category["category"]}\">{$category_name}</a></li>";
        $t .= "<li><b>Actividad</b>:  <a href=\"/disa/mipg/plans/list/{$activity["activity"]}\">{$activity_name}</a></li>";
        $t .= "<li><b>Plan</b>:  <a href=\"/disa/mipg/plans/view/{$plan["plan"]}\">{$plan["order"]}</a></li>";
        $t .= "</ul>";

        $c = ""
            . "<div class=\"card mb-1\">"
            . "<div class=\"card-header p-1\"><h5 class=\"card-header-title p-1  m-0 opacity-3\">Ruta</h5></div>"
            . "<div class=\"card-body\">"
            . $t
            . "</div>"
            . "</div>";
        return ($c);
    }

}

if (!function_exists("get_snippet_disa_activities")) {

    /**
     * Este Snippet se localiza a lado derecho de la visualización cuando se
     * accede a las categorias que hacen parte de un componente. Basicamente
     * consulta los datos del autodiagnostico para generar un arbol o estructura del
     * mismo a manera de esquema.
     * @param type $component
     * @return type
     */
    function get_snippet_disa_activities($cid)
    {
        $dimensions = model("\App\Modules\Disa\Models\Disa_Dimensions", true);
        $politics = model("\App\Modules\Disa\Models\Disa_Politics", true);
        $diagnostics = model("\App\Modules\Disa\Models\Disa_Diagnostics", true);
        $components = model("\App\Modules\Disa\Models\Disa_Components", true);
        $categories = model("\App\Modules\Disa\Models\Disa_Categories", true);

        $category = $categories->withDeleted()->find($cid);
        $component = $components->find($category["component"]);
        $diagnostic = $diagnostics->find($component["diagnostic"]);
        $politic = $d = $politics->find($diagnostic["politic"]);
        $dimension = $dimensions->find($politic["dimension"]);

        $dimension_id = $dimension["dimension"];
        $dimension_name = urldecode($dimension["name"]);
        $politic_id = $politic["politic"];
        $politic_name = urldecode($politic["name"]);
        $diagnostic_id = $diagnostic["diagnostic"];
        $diagnostic_name = urldecode($diagnostic["name"]);
        $component_id = $component["component"];
        $component_name = urldecode($component["name"]);
        $category_id = $category["category"];
        $category_name = $category["name"];


        $t = "<ul style=\"margin: 0px;padding: 0px 10px 0px 10px;\">";
        $t .= "<li><b>Dimensión</b>:<a href=\"/disa/mipg/politics/list/{$dimension_id}\">{$dimension_name}</a></li>";
        $t .= "<li><b>Política</b>: <a href=\"/disa/mipg/diagnostics/list/{$politic_id}\">{$politic_name}</a></li>";
        $t .= "<li><b>Autodiagnóstico</b>: <a href=\"/disa/mipg/components/list/{$diagnostic_id}\">{$diagnostic_name}</a></li>";
        $t .= "<li><b>Componente</b>: <a href=\"/disa/mipg/categories/list/{$component_id}\">{$component_name}</a></li>";
        $t .= "<li><b>Categoría</b>:  <a href=\"/disa/mipg/activities/list/{$category_id}\">{$category_name}</a></li>";
        $t .= "</ul>";

        $c = ""
            . "<div class=\"card mb-1\">"
            . "<div class=\"card-header p-1\"><h5 class=\"card-header-title p-1  m-0 opacity-3\">Ruta</h5></div>"
            . "<div class=\"card-body\">"
            . $t
            . "</div>"
            . "</div>";
        return ($c);
    }


    function get_snippet_disa_plans($pid)
    {
        $strings = service("strings");
        $dimensions = model("\App\Modules\Disa\Models\Disa_Dimensions", true);
        $politics = model("\App\Modules\Disa\Models\Disa_Politics", true);
        $diagnostics = model("\App\Modules\Disa\Models\Disa_Diagnostics", true);
        $components = model("\App\Modules\Disa\Models\Disa_Components", true);
        $categories = model("\App\Modules\Disa\Models\Disa_Categories", true);
        $activities = model("\App\Modules\Disa\Models\Disa_Activities", true);
        $plans = model("\App\Modules\Disa\Models\Disa_Plans", true);

        $plan = $plans->withDeleted()->find($pid);
        $activity = $activities->find($plan["activity"]);
        $category = $categories->find($activity["category"]);
        $component = $components->find($category["component"]);
        $diagnostic = $diagnostics->find($component["diagnostic"]);
        $politic = $d = $politics->find($diagnostic["politic"]);
        $dimension = $dimensions->find($politic["dimension"]);

        $dimension_name = urldecode($dimension["name"]);
        $politic_name = urldecode($politic["name"]);
        $diagnostic_name = urldecode($diagnostic["name"]);
        $component_name = urldecode($component["name"]);
        $category_name = $strings->get_Striptags(urldecode($category["name"]));
        $activity_name = $strings->get_Striptags(urldecode($activity["description"]));

        $t = "<ul style=\"margin: 0px;padding: 0px 10px 0px 10px;\">";
        $t .= "<li><b>Dimensión</b>:<a href=\"/disa/mipg/politics/list/{$dimension["dimension"]}\">{$dimension_name}</a></li>";
        $t .= "<li><b>Política</b>: <a href=\"/disa/mipg/diagnostics/list/{$politic["politic"]}\">{$politic_name}</a></li>";
        $t .= "<li><b>Autodiagnóstico</b>: <a href=\"/disa/mipg/components/list/{$diagnostic["diagnostic"]}\">{$diagnostic_name}</a></li>";
        $t .= "<li><b>Componente</b>: <a href=\"/disa/mipg/categories/list/{$component["component"]}\">{$component_name}</a></li>";
        $t .= "<li><b>Categoría</b>:  <a href=\"/disa/mipg/activities/list/{$category["category"]}\">{$category_name}</a></li>";
        $t .= "<li><b>Actividad</b>:  <a href=\"/disa/mipg/plans/list/{$activity["activity"]}\">{$activity_name}</a></li>";
        $t .= "<li><b>Plan</b>:  <a href=\"/disa/mipg/plans/view/{$plan["plan"]}\">{$plan["order"]}</a></li>";
        $t .= "</ul>";

        $c = ""
            . "<div class=\"card mb-1\">"
            . "<div class=\"card-header p-1\"><h5 class=\"card-header-title p-1  m-0 opacity-3\">Ruta</h5></div>"
            . "<div class=\"card-body\">"
            . $t
            . "</div>"
            . "</div>";
        return ($c);
    }


    function get_snippet_disa_causes($cid)
    {
        $strings = service("strings");
        $dimensions = model("\App\Modules\Disa\Models\Disa_Dimensions", true);
        $politics = model("\App\Modules\Disa\Models\Disa_Politics", true);
        $diagnostics = model("\App\Modules\Disa\Models\Disa_Diagnostics", true);
        $components = model("\App\Modules\Disa\Models\Disa_Components", true);
        $categories = model("\App\Modules\Disa\Models\Disa_Categories", true);
        $activities = model("\App\Modules\Disa\Models\Disa_Activities", true);
        $plans = model("\App\Modules\Disa\Models\Disa_Plans", true);
        $causes = model("\App\Modules\Disa\Models\Disa_Causes", true);

        $cause = $causes->withDeleted()->find($cid);
        $plan = $plans->find($cause["plan"]);
        $activity = $activities->find($plan["activity"]);
        $category = $categories->find($activity["category"]);
        $component = $components->find($category["component"]);
        $diagnostic = $diagnostics->find($component["diagnostic"]);
        $politic = $d = $politics->find($diagnostic["politic"]);
        $dimension = $dimensions->find($politic["dimension"]);

        $dimension_name = urldecode($dimension["name"]);
        $politic_name = urldecode($politic["name"]);
        $diagnostic_name = urldecode($diagnostic["name"]);
        $component_name = urldecode($component["name"]);
        $category_name = $strings->get_Striptags(urldecode($category["name"]));
        $activity_name = $strings->get_Striptags(urldecode($activity["description"]));
        $cause_name = $strings->get_Striptags(urldecode($cause["description"]));

        $t = "<ul style=\"margin: 0px;padding: 0px 10px 0px 10px;\">";
        $t .= "<li><b>Dimensión</b>:<a href=\"/disa/mipg/politics/list/{$dimension["dimension"]}\">{$dimension_name}</a></li>";
        $t .= "<li><b>Política</b>: <a href=\"/disa/mipg/diagnostics/list/{$politic["politic"]}\">{$politic_name}</a></li>";
        $t .= "<li><b>Autodiagnóstico</b>: <a href=\"/disa/mipg/components/list/{$diagnostic["diagnostic"]}\">{$diagnostic_name}</a></li>";
        $t .= "<li><b>Componente</b>: <a href=\"/disa/mipg/categories/list/{$component["component"]}\">{$component_name}</a></li>";
        $t .= "<li><b>Categoría</b>:  <a href=\"/disa/mipg/activities/list/{$category["category"]}\">{$category_name}</a></li>";
        $t .= "<li><b>Actividad</b>:  <a href=\"/disa/mipg/plans/list/{$activity["activity"]}\">{$activity_name}</a></li>";
        $t .= "<li><b>Plan</b>:  <a href=\"/disa/mipg/plans/view/{$plan["plan"]}\">{$plan["order"]}</a></li>";
        $t .= "<li><b>Causa</b>:  <a href=\"/disa/mipg/plans/causes/list/{$plan["plan"]}\">Causas probables</a></li>";
        $t .= "</ul>";

        $c = ""
            . "<div class=\"card mb-1\">"
            . "<div class=\"card-header p-1\"><h5 class=\"card-header-title p-1  m-0 opacity-3\">Ruta</h5></div>"
            . "<div class=\"card-body\">"
            . $t
            . "</div>"
            . "</div>";
        return ($c);
    }


    function get_snippet_disa_whys($wid)
    {
        $strings = service("strings");
        $dimensions = model("\App\Modules\Disa\Models\Disa_Dimensions", true);
        $politics = model("\App\Modules\Disa\Models\Disa_Politics", true);
        $diagnostics = model("\App\Modules\Disa\Models\Disa_Diagnostics", true);
        $components = model("\App\Modules\Disa\Models\Disa_Components", true);
        $categories = model("\App\Modules\Disa\Models\Disa_Categories", true);
        $activities = model("\App\Modules\Disa\Models\Disa_Activities", true);
        $plans = model("\App\Modules\Disa\Models\Disa_Plans", true);
        $causes = model("\App\Modules\Disa\Models\Disa_Causes", true);
        $whys = model("\App\Modules\Disa\Models\Disa_Whys", true);

        $why = $whys->withDeleted()->find($wid);
        $cause = $causes->withDeleted()->find($why["cause"]);
        $plan = $plans->find($cause["plan"]);
        $activity = $activities->find($plan["activity"]);
        $category = $categories->find($activity["category"]);
        $component = $components->find($category["component"]);
        $diagnostic = $diagnostics->find($component["diagnostic"]);
        $politic = $d = $politics->find($diagnostic["politic"]);
        $dimension = $dimensions->find($politic["dimension"]);

        $dimension_id = $dimension["dimension"];
        $dimension_name = urldecode($dimension["name"]);
        $politic_id = $politic["politic"];
        $politic_name = urldecode($politic["name"]);
        $diagnostic_id = $diagnostic["diagnostic"];
        $diagnostic_name = urldecode($diagnostic["name"]);
        $component_id = $component["component"];
        $component_name = urldecode($component["name"]);
        $category_id = $category["category"];
        $category_name = $category["name"];
        $activity_name = urldecode($activity["description"]);

        $dimension_name = urldecode($dimension["name"]);
        $politic_name = urldecode($politic["name"]);
        $diagnostic_name = urldecode($diagnostic["name"]);
        $component_name = urldecode($component["name"]);
        $category_name = $strings->get_Striptags(urldecode($category["name"]));
        $activity_name = $strings->get_Striptags(urldecode($activity["description"]));

        $t = "<ul style=\"margin: 0px;padding: 0px 10px 0px 10px;\">";
        $t .= "<li><b>Dimensión</b>:<a href=\"/disa/mipg/politics/list/{$dimension["dimension"]}\">{$dimension_name}</a></li>";
        $t .= "<li><b>Política</b>: <a href=\"/disa/mipg/diagnostics/list/{$politic["politic"]}\">{$politic_name}</a></li>";
        $t .= "<li><b>Autodiagnóstico</b>: <a href=\"/disa/mipg/components/list/{$diagnostic["diagnostic"]}\">{$diagnostic_name}</a></li>";
        $t .= "<li><b>Componente</b>: <a href=\"/disa/mipg/categories/list/{$component["component"]}\">{$component_name}</a></li>";
        $t .= "<li><b>Categoría</b>:  <a href=\"/disa/mipg/activities/list/{$category["category"]}\">{$category_name}</a></li>";
        $t .= "<li><b>Actividad</b>:  <a href=\"/disa/mipg/plans/list/{$activity["activity"]}\">{$activity_name}</a></li>";
        $t .= "<li><b>Plan</b>:  <a href=\"/disa/mipg/plans/view/{$plan["plan"]}\">{$plan["order"]}</a></li>";
        $t .= "<li><b>Causa</b>:  <a href=\"/disa/mipg/plans/whys/list/{$wid}\">{$plan["order"]}</a></li>";
        $t .= "</ul>";

        $c = ""
            . "<div class=\"card mb-1\">"
            . "<div class=\"card-header p-1\"><h5 class=\"card-header-title p-1  m-0 opacity-3\">Ruta</h5></div>"
            . "<div class=\"card-body\">"
            . $t
            . "</div>"
            . "</div>";
        return ($c);
    }


    /**
     * Este Snippet se localiza a lado derecho de la visualización cuando se
     * accede a las categorias que hacen parte de un componente. Basicamente
     * consulta los datos del autodiagnostico para generar un arbol o estructura del
     * mismo a manera de esquema.
     * @param type $component
     * @return type
     */
    function get_snippet_disa_scores($activity)
    {
        $dimensions = model("\App\Modules\Disa\Models\Disa_Dimensions", true);
        $politics = model("\App\Modules\Disa\Models\Disa_Politics", true);
        $diagnostics = model("\App\Modules\Disa\Models\Disa_Diagnostics", true);
        $components = model("\App\Modules\Disa\Models\Disa_Components", true);
        $categories = model("\App\Modules\Disa\Models\Disa_Categories", true);
        $activities = model('App\Modules\Disa\Models\Disa_Activities', true);

        $activity = $activities->withDeleted()->find($activity);
        $category = $categories->find($activity["category"]);
        $component = $components->find($category["component"]);
        $diagnostic = $diagnostics->find($component["diagnostic"]);
        $politic = $d = $politics->find($diagnostic["politic"]);
        $dimension = $dimensions->find($politic["dimension"]);

        $dimension_id = $dimension["dimension"];
        $dimension_name = urldecode($dimension["name"]);
        $politic_id = $politic["politic"];
        $politic_name = urldecode($politic["name"]);
        $diagnostic_id = $diagnostic["diagnostic"];
        $diagnostic_name = urldecode($diagnostic["name"]);
        $component_id = $component["component"];
        $component_name = urldecode($component["name"]);
        $category_id = $category["category"];
        $category_name = urldecode($category["name"]);
        $activity_name = urldecode($activity["description"]);
        $t = "<ul class=\"snippet-list\">";
        $t .= "<li><b>Dimensión</b>:<a href=\"/disa/mipg/politics/list/{$dimension_id}\">{$dimension_name}</a></li>";
        $t .= "<li><b>Política</b>: <a href=\"/disa/mipg/diagnostics/view/{$politic_id}\">{$politic_name}</a></li>";
        $t .= "<li><b>Autodiagnóstico</b>: <a href=\"/disa/mipg/components/list/{$diagnostic_id}\">{$diagnostic_name}</a></li>";
        $t .= "<li><b>Componente</b>: <a href=\"/disa/mipg/categories/list/{$component_id}\">{$component_name}</a></li>";
        $t .= "<li><b>Categoría</b>: <a href=\"/disa/mipg/activities/list/{$category_id}\">{$category_name}</a></li>";
        $t .= "<li><b>Actividad</b>: {$activity_name}</li>";
        $t .= "</ul>";
        $card = service("smarty");
        $card->set_Mode("bs5x");
        $card->caching = 0;
        $card->assign("type", "normal");
        $card->assign("class", "mb-3");
        $card->assign("header", "Ruta");
        $card->assign("header_menu", false);
        $card->assign("header_add", false);
        $card->assign("header_help", false);
        $card->assign("text", false);
        $card->assign("body", $t);
        $card->assign("footer", false);
        return ($card->view('components/cards/index.tpl'));
    }

}


if (!function_exists("get_snippet_disa_categories")) {

    /**
     * Este Snippet se localiza a lado derecho de la visualización cuando se
     * accede a las categorias que hacen parte de un componente. Basicamente
     * consulta los datos del autodiagnostico para generar un arbol o estructura del
     * mismo a manera de esquema.
     * @param type $component
     * @return type
     */
    function get_snippet_disa_categories($cid)
    {
        $dimensions = model("\App\Modules\Disa\Models\Disa_Dimensions", true);
        $politics = model("\App\Modules\Disa\Models\Disa_Politics", true);
        $diagnostics = model("\App\Modules\Disa\Models\Disa_Diagnostics", true);
        $components = model("\App\Modules\Disa\Models\Disa_Components", true);

        $component = $components->withDeleted()->find($cid);
        $diagnostic = $diagnostics->find($component["diagnostic"]);
        $politic = $d = $politics->find($diagnostic["politic"]);
        $dimension = $dimensions->find($politic["dimension"]);

        $dimension_id = $dimension["dimension"];
        $dimension_name = urldecode($dimension["name"]);
        $politic_id = $politic["politic"];
        $politic_name = urldecode($politic["name"]);
        $diagnostic_id = $diagnostic["diagnostic"];
        $diagnostic_name = urldecode($diagnostic["name"]);
        $component_id = $component["component"];
        $component_name = urldecode($component["name"]);

        $t = "<ul style=\"margin: 0px;padding: 0px 10px 0px 10px;\">";
        $t .= "<li><b>Dimensión</b>:<a href=\"/disa/mipg/politics/list/{$dimension_id}\">{$dimension_name}</a></li>";
        $t .= "<li><b>Política</b>: <a href=\"/disa/mipg/diagnostics/list/{$politic_id}\">{$politic_name}</a></li>";
        $t .= "<li><b>Autodiagnóstico</b>: <a href=\"/disa/mipg/components/list/{$diagnostic_id}\">{$diagnostic_name}</a></li>";
        $t .= "<li><b>Componente</b>: {$component_name} <a href=\"/disa/mipg/categories/list/{$component_id}\"><i class=\"fas fa-sync-alt\"></i></a></a></li>";
        $t .= "</ul>";

        $c = ""
            . "<div class=\"card mb-1\">"
            . "<div class=\"card-header p-1\"><h5 class=\"card-header-title p-1  m-0 opacity-3\">Ruta</h5></div>"
            . "<div class=\"card-body\">"
            . $t
            . "</div>"
            . "</div>";
        return ($c);
    }

}


if (!function_exists("get_snippet_score_category")) {

    /**
     * Se debe recordar que en teoria una politica podria tener activos varios
     * diagnosticos
     * @param type $politic
     * @return type
     */
    function get_snippet_score_category($category)
    {
        $mcategories = model("\App\Modules\Disa\Models\Disa_Categories", true);
        $score = $mcategories->get_ScoreByCategory($category);
        $smarty = service("smarty");
        $smarty->set_Mode("bs5x");
        $smarty->assign("title", "Categoría");
        $smarty->assign("score", $score);
        $c = ($smarty->view('modules/disa/score.tpl'));
        return ($c);
    }

}


if (!function_exists("get_snippet_score_component")) {

    /**
     * Se debe recordar que en teoria una politica podria tener activos varios
     * diagnosticos
     * @param type $politic
     * @return type
     */
    function get_snippet_score_component($cid)
    {
        $components = model("\App\Modules\Disa\Models\Disa_Components", true);
        $score = $components->get_ScoreByComponent($cid);
        $smarty = service("smarty");
        $smarty->set_Mode("bs5x");
        $smarty->assign("title", "Componente");
        $smarty->assign("score", $score);
        $c = ($smarty->view('modules/disa/score.tpl'));
        return ($c);
    }

}


if (!function_exists("get_snippet_score_diagnostic")) {

    /**
     * Se debe recordar que en teoria una politica podria tener activos varios
     * diagnosticos
     * @param type $politic
     * @return type
     */
    function get_snippet_score_diagnostic($did)
    {
        $mdiagnostics = model("\App\Modules\Disa\Models\Disa_Diagnostics", true);
        $score = $mdiagnostics->get_ScoreByDiagnostic($did);
        $smarty = service("smarty");
        $smarty->set_Mode("bs5x");
        $smarty->assign("title", "Autodiagnóstico");
        $smarty->assign("score", $score);
        $c = ($smarty->view('modules/disa/score.tpl'));
        return ($c);
    }

}


if (!function_exists("get_snippet_score_politic")) {

    /**
     * Se debe recordar que en teoria una politica podria tener activos varios
     * diagnosticos
     * @param type $politic
     * @return type
     */
    function get_snippet_score_politic($politic)
    {
        $politics = model("\App\Modules\Disa\Models\Disa_Politics", true);
        $score = $politics->get_ScoreByPolitic($politic);
        $smarty = service("smarty");
        $smarty->set_Mode("bs5x");
        $smarty->assign("title", "Política");
        $smarty->assign("score", $score);
        $c = ($smarty->view('modules/disa/score.tpl'));
        return ($c);
    }

}


if (!function_exists("get_snippet_score_activity")) {

    /**
     * Se debe recordar que en teoria una politica podria tener activos varios
     * diagnosticos
     * @param type $politic
     * @return type
     */
    function get_snippet_score_activity($activity)
    {
        $activities = model("\App\Modules\Disa\Models\Disa_Activities");
        $score = $activities->get_Score($activity);
        $card = service("smarty");
        $card->set_Mode("bs5x");
        $card->caching = 0;
        $card->assign("title", "Actividad");
        $card->assign("score", $score);
        $card->assign("description", "Valoración actual");
        $c = ($card->view('modules/disa/score.tpl'));
        return ($c);
    }

}


if (!function_exists("get_snippet_disa_dimension")) {

    /**
     * Este Snippet se localiza a lado derecho de la visualización cuando se
     * accede a los elementos que conforman un autodiagnostico. Basicamente
     * consulta los datos del autodiagnostico para generar un arbol o estructura del
     * mismo a manera de esquema.
     * @param type $component
     * @return type
     */
    function get_snippet_disa_dimension($idd)
    {
        $mdimensions = model("\App\Modules\Disa\Models\Disa_Dimensions", true);
        $dimension = $mdimensions->find($idd);
        $dimension_id = $dimension["dimension"];
        $dimension_name = urldecode($dimension["name"]);
        $t = "<ul style=\"margin: 0px;padding: 0px 10px 0px 10px;\">";
        $t .= "<li><b>Dimensión</b>: {$dimension_name} <a href=\"/disa/mipg/politics/list/{$dimension_id}\"><i class=\"fas fa-sync-alt\"></i></a></li>";
        $t .= "</ul>";
        $card = service("smarty");
        $card->set_Mode("bs5x");
        $card->caching = 0;
        $card->assign("type", "normal");
        $card->assign("class", "mb-3");
        $card->assign("header", "Ruta");
        $card->assign("header_menu", false);
        $card->assign("text", false);
        $card->assign("body", $t);
        $card->assign("footer", false);
        return ($card->view('components/cards/index.tpl'));
    }

}

if (!function_exists("get_snippet_disa_politics")) {

    /**
     * Este Snippet se localiza a lado derecho de la visualización cuando se
     * accede a los elementos que conforman un autodiagnostico. Basicamente
     * consulta los datos del autodiagnostico para generar un arbol o estructura del
     * mismo a manera de esquema.
     * @param type $component
     * @return type
     */
    function get_snippet_disa_politics($idp)
    {
        $model_dimensions = model("\App\Modules\Disa\Models\Disa_Dimensions", true);
        $mp = model("\App\Modules\Disa\Models\Disa_Politics", true);
        $politic = $mp->find($idp);
        $dimension = $model_dimensions->find($politic["dimension"]);
        $dimension_id = $dimension["dimension"];
        $dimension_name = urldecode($dimension["name"]);
        $politic_id = $politic["politic"];
        $politic_name = urldecode($politic["name"]);
        $t = "<ul style=\"margin: 0px;padding: 0px 10px 0px 10px;\">";
        $t .= "<li><b>Dimensión</b>:<a href=\"/disa/mipg/dimensions/view/{$dimension_id}\">{$dimension_name}</a></li>";
        $t .= "<li><b>Política</b>: {$politic_name} <a href=\"/disa/mipg/diagnostics/view/{$politic_id}\"><i class=\"fas fa-sync-alt\"></i></a></li>";
        $t .= "</ul>";
        $card = service("smarty");
        $card->set_Mode("bs5x");
        $card->caching = 0;
        $card->assign("type", "normal");
        $card->assign("class", "mb-3");
        $card->assign("header", "Ruta");
        $card->assign("header_menu", false);
        $card->assign("text", false);
        $card->assign("body", $t);
        $card->assign("footer", false);
        return ($card->view('components/cards/index.tpl'));
    }

}


if (!function_exists("get_snippet_disa_diagnostic")) {

    /**
     * Este Snippet se localiza a lado derecho de la visualización cuando se
     * accede a los elementos que conforman un autodiagnostico. Basicamente
     * consulta los datos del autodiagnostico para generar un arbol o estructura del
     * mismo a manera de esquema.
     * @param type $component
     * @return type
     */
    function get_snippet_disa_diagnostic($idp)
    {
        $model_dimensions = model("\App\Modules\Disa\Models\Disa_Dimensions", true);
        $mp = model("\App\Modules\Disa\Models\Disa_Politics", true);
        $politic = $mp->find($idp);
        $dimension = $model_dimensions->find($politic["dimension"]);
        $dimension_id = $dimension["dimension"];
        $dimension_name = urldecode($dimension["name"]);
        $politic_id = $politic["politic"];
        $politic_name = urldecode($politic["name"]);
        $t = "<ul style=\"margin: 0px;padding: 0px 10px 0px 10px;\">";
        $t .= "<li><b>Dimensión</b>:<a href=\"/disa/mipg/politics/list/{$dimension_id}\">{$dimension_name}</a></li>";
        $t .= "<li><b>Política</b>: {$politic_name} <a href=\"/disa/mipg/diagnostics/list/{$politic_id}\"><i class=\"fas fa-sync-alt\"></i></a></li>";
        $t .= "</ul>";
        $card = service("smarty");
        $card->set_Mode("bs5x");
        $card->caching = 0;
        $card->assign("type", "normal");
        $card->assign("class", "mb-3");
        $card->assign("header", "Ruta");
        $card->assign("header_menu", false);
        $card->assign("text", false);
        $card->assign("body", $t);
        $card->assign("footer", false);
        return ($card->view('components/cards/index.tpl'));
    }

}

if (!function_exists("get_snippet_disa_diagnostic_by_program")) {

    /**
     * Este Snippet se localiza a lado derecho de la visualización cuando se
     * accede a los elementos que conforman un autodiagnostico. Basicamente
     * consulta los datos del autodiagnostico para generar un arbol o estructura del
     * mismo a manera de esquema.
     * @param type $component
     * @return type
     */
    function get_snippet_disa_diagnostic_by_program($idp)
    {
        $model_dimensions = model("\App\Modules\Disa\Models\Disa_Dimensions", true);
        $mp = model("\App\Modules\Disa\Models\Disa_Politics", true);
        $mprograms = model("\App\Modules\Disa\Models\Disa_Programs", true);
        $program = $mprograms->find($idp);
        $politic = $mp->find($program["politic"]);
        $dimension = $model_dimensions->find($politic["dimension"]);
        $dimension_id = $dimension["dimension"];
        $dimension_name = urldecode($dimension["name"]);
        $politic_id = $politic["politic"];
        $politic_name = urldecode($politic["name"]);
        $t = "<ul style=\"margin: 0px;padding: 0px 10px 0px 10px;\">";
        $t .= "<li><b>Dimensión</b>:<a href=\"/disa/mipg/politics/list/{$dimension_id}\">{$dimension_name}</a></li>";
        $t .= "<li><b>Política</b>: {$politic_name} <a href=\"/disa/mipg/diagnostics/list/{$politic_id}\"><i class=\"fas fa-sync-alt\"></i></a></li>";
        $t .= "</ul>";
        $card = service("smarty");
        $card->set_Mode("bs5x");
        $card->caching = 0;
        $card->assign("type", "normal");
        $card->assign("class", "mb-3");
        $card->assign("header", "Ruta");
        $card->assign("header_menu", false);
        $card->assign("text", false);
        $card->assign("body", $t);
        $card->assign("footer", false);
        return ($card->view('components/cards/index.tpl'));
    }

}


if (!function_exists("get_snippet_disa_components")) {

    /**
     * Este Snippet se localiza a lado derecho de la visualización cuando se
     * accede a los elementos que conforman un autodiagnostico. Basicamente
     * consulta los datos del autodiagnostico para generar un arbol o estructura del
     * mismo a manera de esquema.
     * @param type $component
     * @return type
     */
    function get_snippet_disa_components($did)
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
        $diagnostic_name = urldecode($diagnostic["name"]);
        $t = "<ul style=\"margin: 0px;padding: 0px 10px 0px 10px;\">";
        $t .= "<li><b>Dimensión</b>:<a href=\"/disa/mipg/dimensions/list/{$dimension_id}\">{$dimension_name}</a></li>";
        $t .= "<li><b>Política</b>: <a href=\"/disa/mipg/diagnostics/list/{$politic_id}\">{$politic_name}</a></li>";
        $t .= "<li><b>Autodiagnóstico</b>: {$diagnostic_name} <a href=\"/disa/mipg/components/list/{$diagnostic_id}\"><i class=\"fas fa-sync-alt\"></i></a></li>";
        $t .= "</ul>";
        $card = service("smarty");
        $card->set_Mode("bs5x");
        $card->caching = 0;
        $card->assign("type", "normal");
        $card->assign("class", "mb-3");
        $card->assign("header", "Ruta");
        $card->assign("header_menu", false);
        $card->assign("text", false);
        $card->assign("body", $t);
        $card->assign("footer", false);
        return ($card->view('components/cards/index.tpl'));
    }

}


if (!function_exists("get_snippet_disa_furag")) {

    function get_snippet_disa_furag()
    {
        $authentication = service('authentication');
        if ($authentication->get_LoggedIn()) {
            $f = form_open('/disa/mipg/furag/view', array("class" => ""));
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
            $f .= '<span id="tiketHelpBlock" class="form-text text-muted">Código SIGEP de 4 caracteres</span>';
            $f .= '</div>';
            $f .= '</div>';
            $f .= '<div class="form-group row">';
            $f .= '<div class="col-12">';
            $f .= '<button name="submit" type="submit" class="btn btn-primary">Consultar</button>';
            $f .= '</div>';
            $f .= '</div>';
            $f .= form_close();
            $c = ""
                . "<div class=\"card mb-1\">"
                . "<div class=\"card-header p-1\"><h5 class=\"card-header-title p-1  m-0 opacity-3\">Consulta Furag</h5></div>"
                . "<div class=\"card-body\">"
                . $f
                . "</div>"
                . "</div>";
            return ($c);
        } else {
            return ("");
        }
    }

}


if (!function_exists("get_disa_copyright")) {

    function get_disa_copyright()
    {
        $gridter = "";
        $gridter .= "<div id=\"gridter\">";
        $gridter .= "  <div class=\"xl\">XL</div>";
        $gridter .= "  <div class=\"lg\">LG</div>";
        $gridter .= "  <div class=\"md\">MD</div>";
        $gridter .= "  <div class=\"sm\">SM</div>";
        $gridter .= "  <div class=\"xs\">XS</div>";
        $gridter .= "</div>";
        $c = "";
        $c .= ""
            . "<div class=\"card\">"
            . "<div class=\"card-body\">"
            . "<p style=\"font-size: 1rem;line-height: 1rem;\"><b>Copyright © 2021 - 2031 </b> Todos los derechos reservados, se prohíbe su reproducción total o "
            . "parcial, así como su traducción a cualquier idioma sin la autorización escrita de su titular. "
            . "<a href=\"/policies/conditions\" class=\"link\">Términos y condiciones</a> | "
            . "<a href=\"/policies/privacy\" class=\"link\">Políticas de privacidad</a> | "
            . "<a href=\"/policies/advertising\" class=\"link\">Publicidad</a> | "
            . "<a href=\"/policies/cookies\" class=\"link\">Cookies</a> | "
            . "<a href=\"/policies/more\" class=\"link\">Más</a> | "
            . $gridter
            . "</p></div>"
            . "</div>";
        return ($c);
    }

}


?>