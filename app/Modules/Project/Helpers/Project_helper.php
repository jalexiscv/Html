<?php

if (!function_exists("generate_project_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_project_permissions(): void
    {
        $permissions = array(
            "project-access",
            //[Tasks]----------------------------------------------------------------------------------------
            "project-tasks-access",
            "project-tasks-view",
            "project-tasks-view-all",
            "project-tasks-create",
            "project-tasks-edit",
            "project-tasks-edit-all",
            "project-tasks-delete",
            "project-tasks-delete-all",
            //[Projects]----------------------------------------------------------------------------------------
            "project-projects-access",
            "project-projects-view",
            "project-projects-view-all",
            "project-projects-create",
            "project-projects-edit",
            "project-projects-edit-all",
            "project-projects-delete",
            "project-projects-delete-all",
            "project-access",
            //[Statuses]----------------------------------------------------------------------------------------
            "project-statuses-access",
            "project-statuses-view",
            "project-statuses-view-all",
            "project-statuses-create",
            "project-statuses-edit",
            "project-statuses-edit-all",
            "project-statuses-delete",
            "project-statuses-delete-all",
        );
        generate_permissions($permissions, "project");
    }

}

if (!function_exists("get_project_sidebar")) {
    function get_project_sidebar($active_url = false): string
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("Project.Home"), "href" => "/project/", "svg" => "home.svg"),
            "proyects" => array("text" => lang("Project.Projects"), "href" => "/project/projects/list/" . lpk(), "icon" => ICON_TOOLS, "permission" => "project-access"),
            "settings" => array("text" => lang("Project.Settings"), "href" => "/project/settings/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "project-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPills($o, $active_url);
        return ($return);
    }
}


if (!function_exists("get_list_tasks_statuses")) {
    function get_list_tasks_statuses(): array
    {
        $LIST_TASKS_STATUSES = array(
            array("label" => lang("Project.Task-Pending"), "value" => "PENDING"),
            array("label" => lang("Project.Task-Completed"), "value" => "COMPLETED"),
            array("label" => lang("Project.Task-Overdue"), "value" => "OVERDUE"),
            array("label" => lang("Project.Task-Not-Started"), "value" => "NOT STARTED"),
            array("label" => lang("Project.Task-In-Progress"), "value" => "IN PROGRESS"),
            array("label" => lang("Project.Task-On-Hold"), "value" => "ON HOLD"),
        );
        return ($LIST_TASKS_STATUSES);
    }
}

if (!function_exists("get_list_tasks_priorities")) {
    function get_list_tasks_priorities(): array
    {
        $LIST_TASKS_PRIORITY = array(
            array("label" => lang("Project.Task-Low"), "value" => "LOW"),
            array("label" => lang("Project.Task-Medium"), "value" => "MEDIUM"),
            array("label" => lang("Project.Task-High"), "value" => "HIGH"),
            array("label" => lang("Project.Task-Critical"), "value" => "CRITICAL"),
        );
        return ($LIST_TASKS_PRIORITY);
    }
}


?>
