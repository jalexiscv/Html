<?php

if (!function_exists("generate_iris_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_iris_permissions(): void
    {
        $permissions = array(
            "iris-access",
            //[patients]----------------------------------------------------------------------------------------
            "iris-patients-access",
            "iris-patients-view",
            "iris-patients-view-all",
            "iris-patients-create",
            "iris-patients-edit",
            "iris-patients-edit-all",
            "iris-patients-delete",
            "iris-patients-delete-all",
            //[Episode]----------------------------------------------------------------------------------------
            "iris-episodes-access",
            "iris-episodes-view",
            "iris-episodes-view-all",
            "iris-episodes-create",
            "iris-episodes-edit",
            "iris-episodes-edit-all",
            "iris-episodes-delete",
            "iris-episodes-delete-all",
            //[studies]----------------------------------------------------------------------------------------
            "iris-studies-access",
            "iris-studies-view",
            "iris-studies-view-all",
            "iris-studies-create",
            "iris-studies-edit",
            "iris-studies-edit-all",
            "iris-studies-delete",
            "iris-studies-delete-all",
            //[Image]----------------------------------------------------------------------------------------
            "iris-images-access",
            "iris-images-view",
            "iris-images-view-all",
            "iris-images-create",
            "iris-images-edit",
            "iris-images-edit-all",
            "iris-images-delete",
            "iris-images-delete-all",
            //[Diagnostics]----------------------------------------------------------------------------------------
            "iris-diagnostics-access",
            "iris-diagnostics-view",
            "iris-diagnostics-view-all",
            "iris-diagnostics-create",
            "iris-diagnostics-edit",
            "iris-diagnostics-edit-all",
            "iris-diagnostics-delete",
            "iris-diagnostics-delete-all",
            //[Settings]----------------------------------------------------------------------------------------
            "iris-settings-access",
            "iris-settings-view",
            "iris-settings-view-all",
            "iris-settings-create",
            "iris-settings-edit",
            "iris-settings-edit-all",
            "iris-settings-delete",
            "iris-settings-delete-all",
            //[Modalities]----------------------------------------------------------------------------------------
            "iris-modalities-access",
            "iris-modalities-view",
            "iris-modalities-view-all",
            "iris-modalities-create",
            "iris-modalities-edit",
            "iris-modalities-edit-all",
            "iris-modalities-delete",
            "iris-modalities-delete-all",
            //[Procedures]----------------------------------------------------------------------------------------
            "iris-procedures-access",
            "iris-procedures-view",
            "iris-procedures-view-all",
            "iris-procedures-create",
            "iris-procedures-edit",
            "iris-procedures-edit-all",
            "iris-procedures-delete",
            "iris-procedures-delete-all",
            //[Categories]----------------------------------------------------------------------------------------
            "iris-categories-access",
            "iris-categories-view",
            "iris-categories-view-all",
            "iris-categories-create",
            "iris-categories-edit",
            "iris-categories-edit-all",
            "iris-categories-delete",
            "iris-categories-delete-all",
            //[Mstudies]----------------------------------------------------------------------------------------
            "iris-mstudies-access",
            "iris-mstudies-view",
            "iris-mstudies-view-all",
            "iris-mstudies-create",
            "iris-mstudies-edit",
            "iris-mstudies-edit-all",
            "iris-mstudies-delete",
            "iris-mstudies-delete-all",
            //[Groups]----------------------------------------------------------------------------------------
            "iris-groups-access",
            "iris-groups-view",
            "iris-groups-view-all",
            "iris-groups-create",
            "iris-groups-edit",
            "iris-groups-edit-all",
            "iris-groups-delete",
            "iris-groups-delete-all",
            //[Specialties]----------------------------------------------------------------------------------------
			"iris-specialties-access",
			"iris-specialties-view",
			"iris-specialties-view-all",
			"iris-specialties-create",
			"iris-specialties-edit",
			"iris-specialties-edit-all",
			"iris-specialties-delete",
			"iris-specialties-delete-all",
        );
        generate_permissions($permissions, "iris");
    }

}

if (!function_exists("get_iris_sidebar2")) {
    function get_iris_sidebar2($active_url = false)
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = [
            "home" => [
                "text" => lang("App.Home"),
                "href" => "/iris/",
                "svg" => "home.svg"
            ],
            "episodes" => [
                "text" => "Episodios Clínicos",
                "href" => "/iris/episodes/list/{$lpk}",
                "icon" => ICON_TOOLS,
                "permission" => "iris-episodes-access"
            ],
            "patients" => [
                "text" => "Pacientes",
                "href" => "/iris/patients/list/{$lpk}",
                "icon" => ICON_TOOLS,
                "permission" => "iris-patients-access"
            ],
            "studies" => [
                "text" => "Estudios Diagnósticos",
                "href" => "#",
                "icon" => ICON_TOOLS,
                "permission" => "iris-studies-access"
            ],
            "settings" => [
                "text" => lang("App.Settings"),
                "href" => "/iris/settings/home/{$lpk}",
                "icon" => ICON_TOOLS,
                "permission" => "iris-access"
            ],
        ];
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPillsGamma($o, $active_url);
        return ($return);
    }
}


if (!function_exists("get_iris_sidebar")) {
    function get_iris_sidebar($active_url = false): array
    {
        $lpk = safe_strtolower(pk());
        $items = [
            "home" => [
                "text" => lang("App.Home"),
                "href" => "/iris/",
                "svg" => "home.svg"
            ],
            "episodes" => [
                "text" => "Episodios Clínicos",
                "href" => "/iris/episodes/list/{$lpk}",
                "icon" => ICON_TOOLS,
                "permission" => "iris-episodes-access"
            ],
            "patients" => [
                "text" => "Pacientes",
                "href" => "/iris/patients/list/{$lpk}",
                "icon" => ICON_TOOLS,
                "permission" => "iris-patients-access"
            ],
            "studies" => [
                "text" => "Estudios Diagnósticos",
                "href" => "#",
                "icon" => ICON_TOOLS,
                "permission" => "iris-studies-access"
            ],
            "settings" => [
                "text" => lang("App.Settings"),
                "href" => "/iris/settings/home/{$lpk}",
                "icon" => ICON_TOOLS,
                "permission" => "iris-access"
            ],
        ];

        $final_items = [];
        foreach ($items as $key => $item) {
            if (isset($item['permission'])) {
                if (safe_has_permission($item['permission'])) {
                    $final_items[$key] = $item;
                }
            } else {
                $final_items[$key] = $item;
            }
        }
        $left = ['sidebar_title' => 'Componentes', 'sidebar_menu_items' => $final_items];
        return ($left);
    }
}

?>
