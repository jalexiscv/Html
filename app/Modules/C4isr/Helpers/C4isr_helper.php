<?php
/*
 * Copyright (c) 2021-2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

if (!function_exists("generate_C4isr_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_C4isr_permissions()
    {
        $permissions = array(
            "c4isr-access",
            //Breaches
            "c4isr-breaches-create",
            "c4isr-breaches-view",
            "c4isr-breaches-view-all",
            "c4isr-breaches-edit",
            "c4isr-breaches-edit-all",
            "c4isr-breaches-delete",
            "c4isr-breaches-delete-all",
            "c4isr-breaches-import",
            //Cases
            "c4isr-cases-create",
            "c4isr-cases-view",
            "c4isr-cases-view-all",
            "c4isr-cases-edit",
            "c4isr-cases-edit-all",
            "c4isr-cases-delete",
            "c4isr-cases-delete-all",
            //intrusions
            "c4isr-intrusions-create",
            "c4isr-intrusions-view",
            "c4isr-intrusions-view-all",
            "c4isr-intrusions-edit",
            "c4isr-intrusions-edit-all",
            "c4isr-intrusions-delete",
            "c4isr-intrusions-delete-all",
            //Mails
            "c4isr-mails-create",
            "c4isr-mails-view",
            "c4isr-mails-view-all",
            "c4isr-mails-edit",
            "c4isr-mails-edit-all",
            "c4isr-mails-delete",
            "c4isr-mails-delete-all",
            //aliases
            "c4isr-aliases-create",
            "c4isr-aliases-view",
            "c4isr-aliases-view-all",
            "c4isr-aliases-edit",
            "c4isr-aliases-edit-all",
            "c4isr-aliases-delete",
            "c4isr-aliases-delete-all",
            //profiles
            "c4isr-profiles-create",
            "c4isr-profiles-view",
            "c4isr-profiles-view-all",
            "c4isr-profiles-edit",
            "c4isr-profiles-edit-all",
            "c4isr-profiles-delete",
            "c4isr-profiles-delete-all",
            //phones
            "c4isr-phones-create",
            "c4isr-phones-view",
            "c4isr-phones-view-all",
            "c4isr-phones-edit",
            "c4isr-phones-edit-all",
            "c4isr-phones-delete",
            "c4isr-phones-delete-all",
            //addresses
            "c4isr-addresses-create",
            "c4isr-addresses-view",
            "c4isr-addresses-view-all",
            "c4isr-addresses-edit",
            "c4isr-addresses-edit-all",
            "c4isr-addresses-delete",
            "c4isr-addresses-delete-all",
            //socials
            "c4isr-socials-create",
            "c4isr-socials-view",
            "c4isr-socials-view-all",
            "c4isr-socials-edit",
            "c4isr-socials-edit-all",
            "c4isr-socials-delete",
            "c4isr-socials-delete-all",
            //identifications
            "c4isr-identifications-create",
            "c4isr-identifications-view",
            "c4isr-identifications-view-all",
            "c4isr-identifications-edit",
            "c4isr-identifications-edit-all",
            "c4isr-identifications-delete",
            "c4isr-identifications-delete-all",
            //physicals
            "c4isr-physicals-create",
            "c4isr-physicals-view",
            "c4isr-physicals-view-all",
            "c4isr-physicals-edit",
            "c4isr-physicals-edit-all",
            "c4isr-physicals-delete",
            "c4isr-physicals-delete-all",
            //darkweb
            "c4isr-darkweb-create",
            "c4isr-darkweb-view",
            "c4isr-darkweb-view-all",
            "c4isr-darkweb-edit",
            "c4isr-darkweb-edit-all",
            "c4isr-darkweb-delete",
            "c4isr-darkweb-delete-all",
            //settings
            "c4isr-settings-view",
            "c4isr-settings-view-all",
            //Incidents
            "c4isr-incidents-create",
            "c4isr-incidents-view",
            "c4isr-incidents-view-all",
            "c4isr-incidents-edit",
            "c4isr-incidents-edit-all",
            "c4isr-incidents-delete",
            "c4isr-incidents-delete-all",
        );
        generate_permissions($permissions, "c4isr");
    }

}


if (!function_exists("get_c4isr_deepweb")) {

    function get_c4isr_deepweb()
    {
        $b = service("bootstrap");
        $fechaInicio = "2023-07-25 12:31:00";
        $fechaActual = time(); // Hora actual en segundos desde el epoch (1 de enero de 1970)
        $inicioTimestamp = strtotime($fechaInicio);
        $diferenciaMinutos = ($fechaActual - $inicioTimestamp) / 60; // Diferencia en minutos
        $contador = floor($diferenciaMinutos);
        $count = 4716 + $contador;
        $id = "counter-deepweb";
        $r = $b::get_WidgetCounter($id, array(
            "icon" => ICON_DEEPWEB,
            "count" => $count,
            "text" => "DeepWebs/Paginas",
        ));
        return ($r);
    }

}


if (!function_exists("get_c4isr_darkweb")) {

    function get_c4isr_darkweb()
    {
        $b = service("bootstrap");
        $fechaInicio = "2023-07-25 12:31:00";
        $fechaActual = time(); // Hora actual en segundos desde el epoch (1 de enero de 1970)
        $inicioTimestamp = strtotime($fechaInicio);
        $diferenciaMinutos = ($fechaActual - $inicioTimestamp) / 60; // Diferencia en minutos
        $contador = floor($diferenciaMinutos);
        $count = "19216517" + $contador;
        $id = "counter-darkweb";
        $r = $b::get_WidgetCounter($id, array(
            "icon" => ICON_DARKWEB,
            "count" => $count,
            "text" => "DeepWebs/Paginas",
        ));
        return ($r);
    }

}


if (!function_exists("get_c4isr_breaches")) {

    function get_c4isr_breaches()
    {
        $b = service("bootstrap");
        $mbreaches = model('App\Modules\C4isr\Models\C4isr_Breaches');
        $count = $mbreaches->countAllResults();
        $separador_miles = ',';
        $separador_millares = '.';
        $fechaInicio = "2023-07-25 12:31:00";
        $fechaActual = time(); // Hora actual en segundos desde el epoch (1 de enero de 1970)
        $inicioTimestamp = strtotime($fechaInicio);
        $diferenciaMinutos = ($fechaActual - $inicioTimestamp) / 60; // Diferencia en minutos
        $contador = floor($diferenciaMinutos);
        $count = $count + $contador;
        $id = "counter-breaches";
        $r = $b::get_WidgetCounter($id, array(
            "icon" => ICON_BREACHES,
            "count" => $count,
            "text" => lang("App.Breaches"),
        ));
        return ($r);
    }

}


if (!function_exists("get_c4isr_vulnerabilities")) {

    function get_c4isr_vulnerabilities()
    {
        $b = service("bootstrap");
        $fechaInicio = "2023-07-25 12:31:00";
        $fechaActual = time(); // Hora actual en segundos desde el epoch (1 de enero de 1970)
        $inicioTimestamp = strtotime($fechaInicio);
        $diferenciaMinutos = ($fechaActual - $inicioTimestamp) / 60; // Diferencia en minutos
        $contador = floor($diferenciaMinutos);

        $mvulnerabilities = model('App\Modules\C4isr\Models\C4isr_Vulnerabilities');
        $count = $mvulnerabilities->countAllResults() + $contador;
        $id = "counter-vulnerabilities";
        $r = $b::get_WidgetCounter($id, array(
            "icon" => ICON_VULNERABILITIES,
            "count" => $count,
            "text" => lang("App.Vulnerabilities") . " (Detectadas)",
        ));
        return ($r);
    }

}

if (!function_exists("get_c4isr_intrusions")) {
    function get_c4isr_intrusions()
    {
        $b = service("bootstrap");
        $mintrusions = model('App\Modules\C4isr\Models\C4isr_Intrusions');
        $count = $mintrusions->countAllResults();
        $id = "counter-intrusions";
        $r = $b::get_WidgetCounter($id, array(
            "icon" => ICON_INTRUSIONS,
            "count" => $count,
            "text" => lang("App.Intrusions") . " (Detectadas)",
        ));
        return ($r);
    }

}


if (!function_exists("get_c4isr_cases")) {

    function get_c4isr_cases()
    {
        $b = service("bootstrap");
        $mcases = model('App\Modules\C4isr\Models\C4isr_Cases');
        $count = $mcases->countAllResults();
        $id = "counter-cases";
        $r = $b::get_WidgetCounter($id, array(
            "icon" => ICON_CASES,
            "count" => $count,
            "text" => lang("App.Cases") . " ",
        ));
        return ($r);
    }

}


if (!function_exists("get_c4isr_sidebar")) {
    function get_C4isr_sidebar($active_url = false)
    {
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/c4isr", "icon" => "far fa-home"),
            //"cases" => array("text" => lang("App.Cases"), "href" => "/c4isr/cases/home/" . lpk(), "icon" => "fa-regular fa-suitcase", "permission" => "c4isr-access"),
            "databreachs" => array("text" => "Filtraciones", "href" => "/c4isr/cases/home/databreaches/" . lpk(), "svg" => "breachs.svg", "permission" => "c4isr-access"),
            "osints" => array("text" => 'SInt', "href" => "/c4isr/cases/home/osints/" . lpk(), "icon" => "fa-regular fa-eye", "permission" => "c4isr-access"),
            "darkweb" => array("text" => 'Dark Web', "href" => "/c4isr/cases/home/darkweb/" . lpk(), "icon" => "fa-light fa-spider-web", "permission" => "c4isr-access"),
            "cveweb" => array("text" => 'CVE Web', "href" => "/c4isr/cases/home/cveweb/" . lpk(), "icon" => "fa-sharp fa-regular fa-binoculars", "permission" => "c4isr-access"),
            "phishing" => array("text" => 'Propagación', "href" => "/c4isr/cases/home/phishing/" . lpk(), "icon" => "fa-regular fa-thought-bubble", "permission" => "c4isr-access"),
            "geolocation" => array("text" => 'Geolocalización', "href" => "/c4isr/cases/home/geolocation/" . lpk(), "icon" => "fa-sharp fa-regular fa-globe-stand", "permission" => "c4isr-geolocation-access"),
            "perimeter" => array("text" => 'Perimetros', "href" => "/c4isr/cases/home/perimeter/" . lpk(), "icon" => "fa-regular fa-person-falling-burst", "permission" => "c4isr-perimeter-access"),
            "ia" => array("text" => 'I.A.', "href" => "https://chat.cgine.com/es", "icon" => "fa-regular fa-person-falling-burst", "permission" => "c4isr-access", "target" => "_blank"),
            "settings" => array("text" => lang("App.Tools"), "href" => "/c4isr/settings/home/" . lpk(), "svg" => "settings.svg", "permission" => "c4isr-settings-view"),
        );
        $return = get_application_custom_sidebar($options, $active_url);
        return ($return);
    }
}


if (!function_exists("get_c4isr_case")) {

    function get_c4isr_case($cid)
    {
        $s = service('strings');
        $mcases = model('App\Modules\C4isr\Models\C4isr_Cases');
        $case = $mcases->find($cid);
        $title = $s->get_URLDecode($case['title']);
        $description = $s->get_URLDecode($case['description']);
        $c = $description;
        $widget = service("smarty");
        $widget->set_Mode("bs5x");
        $widget->caching = 0;
        $widget->assign("type", "normal");
        $widget->assign("class", "mb-3");
        $widget->assign("header", false);
        $widget->assign("image", false);
        $widget->assign("body", $c);
        $widget->assign("footer", false);
        $widget->assign("case", $case['case']);
        $widget->assign("reference", $case['reference']);
        $widget->assign("title", $title);
        $widget->assign("description", $description);
        return ($widget->view('modules/c4isr/widgets/case.tpl'));
    }

}

if (!function_exists("get_c4isr_onion")) {
    function get_c4isr_onion($cadena, $longitud = 16)
    {
        $valorFijo = crc32($cadena);
        srand($valorFijo);
        $caracteres = 'abcdefghijklmnopqrstuvwxyz234567';
        $direccion = '';
        for ($i = 0; $i < $longitud; $i++) {
            $direccion .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }
        return ("https://" . $direccion . ".onion");
    }
}

?>