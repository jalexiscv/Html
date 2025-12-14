<?php

use App\Libraries\Html\HtmlTag;


function sie_get_textual_status_courses($status, $count, $icon, $value): string
{
    $value = strtolower($value);
    $status = safe_strtoupper($status);
    $code = "";
    $code .= "<div class=\"col-auto\">\n";
    $code .= "\t\t\t\t\t\t\t\t<div class=\"card-status {$value} d-flex\" style=\"opacity: 1; transform: scale(1); transition: 0.5s;\">\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t<div class=\"status-sidebar {$value}\">\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t{$status}\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t</div>\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t<div class=\"status-content\">\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"user-icon\">\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"{$icon}\"></i>\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t</div>\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"status-number\">{$count}</div>\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"status-label\">Estudiantes</div>\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t</div>\n";
    $code .= "\t\t\t\t\t\t\t\t</div>\n";
    $code .= "\t\t\t\t\t\t</div>\n";
    return ($code);
}

if (!function_exists("sie_get_setting")) {
    function sie_get_setting($reference)
    {
        $msettings = model('App\Modules\Sie\Models\Sie_Settings');
        $result = $msettings->getSetting($reference);
        return (@$result["value"]);
    }
}


if (!function_exists("sie_widget_academic_periods")) {
    /**
     * Función para renderizar la card de períodos académicos usando HtmlTag
     * @param array $periodsData Array con los datos de los períodos
     * @param object $bootstrap Instancia del servicio Bootstrap
     * @return string HTML de la card de períodos
     */
    function sie_widget_academic_periods($periodsData, $bootstrap)
    {
        // Crear contenedor principal de períodos
        $periodsList = HtmlTag::tag('div');
        $periodsList->attr('class', 'periods-list');
        $periodItems = [];
        foreach ($periodsData as $period) {
            // Determinar clases e iconos basados en el cambio
            $iconClass = $period['change'] > 0 ? 'bi-caret-up-fill' : ($period['change'] < 0 ? 'bi-caret-down-fill' : 'bi-dash');
            $changeClass = $period['change'] > 0 ? 'change-positive' : ($period['change'] < 0 ? 'change-negative' : 'change-neutral');
            $changeSymbol = $period['change'] > 0 ? '+' : '';
            // Crear icono del período
            $periodIcon = HtmlTag::tag('div');
            $periodIcon->attr('class', 'period-icon');
            $periodIcon->content($period['short_code']);
            // Crear nombre del período
            $periodName = HtmlTag::tag('div');
            $periodName->attr('class', 'period-name');
            $periodName->content($period['name']);
            // Crear contenedor de información del período
            $periodInfo = HtmlTag::tag('div');
            $periodInfo->attr('class', 'period-info');
            $periodInfo->content([$periodIcon, $periodName]);
            // Crear valor del período
            $periodValue = HtmlTag::tag('div');
            $periodValue->attr('class', 'period-value');
            $periodValue->content('(' . number_format($period['courses_count']) . ')');
            // Crear icono de tendencia
            $trendIcon = HtmlTag::tag('i');
            $trendIcon->attr('class', $iconClass . ' trend-icon');
            $trendIcon->content(''); // Asegurar que tenga contenido vacío explícito
            // Crear texto del cambio
            $changeText = ' ' . $changeSymbol . $period['change'] . '%';
            // Crear cambio del período
            $periodChange = HtmlTag::tag('div');
            $periodChange->attr('class', 'period-change ' . $changeClass);
            $periodChange->content($trendIcon->render() . $changeText);
            // Crear contenedor de resultados
            $periodResults = HtmlTag::tag('div');
            $periodResults->attr('class', 'period-results');
            $periodResults->content([$periodValue, $periodChange]);
            // Crear item completo del período
            $periodItem = HtmlTag::tag('div');
            $periodItem->attr('class', 'period-item period-' . strtolower($period['code']));
            $periodItem->attr('style', 'opacity: 1; transform: translateX(0px); transition: 0.5s;');
            $periodItem->content([$periodInfo, $periodResults]);
            $periodItems[] = $periodItem;
        }
        // Agregar todos los items al contenedor principal
        $periodsList->content($periodItems);
        // Crear la card usando Bootstrap
        $periodsCard = $bootstrap->get_Card('periods-card', [
            'title' => 'Historial de Períodos',
            'header-icon' => 'bi bi-calendar-range',
            'content' => $periodsList->render(),
            'class' => 'periods-card-container'
        ]);
        return $periodsCard;
    }

}


if (!function_exists("get_sie_status_type_name")) {
    function get_sie_status_type_name($status)
    {
        foreach (LIST_STATUSES as $lstatus) {
            if ($lstatus['value'] == $status) {
                return $lstatus['label'];
            }
        }
    }
}
if (!function_exists("sie_get_current_academic_period")) {
    function sie_get_current_academic_period(): string
    {
        return date('Y') . ((int)date('n') <= 6 ? 'A' : 'B');
    }
}


if (!function_exists("sie_get_textual_journey")) {

    function sie_get_textual_journey($value): string
    {
        $journeys = LIST_JOURNEYS;
        foreach ($journeys as $journey) {
            if ($journey['value'] === $value) {
                return $journey['label'];
            }
        }
        return "No definido";
    }

}

if (!function_exists("sie_get_textual_country")) {

    function sie_get_textual_country($value): string
    {
        $mcountries = model("App\Modules\Sie\Models\Sie_Countries");
        $country = $mcountries->get_Country($value);
        if (!empty($country) && isset($country['name'])) {
            return $country['name'];
        } else {
            return "No definido";
        }
    }

}

if (!function_exists("sie_get_textual_region")) {

    function sie_get_textual_region($value): string
    {
        $mregions = model("App\Modules\Sie\Models\Sie_Regions");
        $region = $mregions->get_Region($value);
        if (!empty($region) && isset($region['name'])) {
            return ($region['name']);
        } else {
            return "No definido";
        }
    }

}

if (!function_exists("sie_get_textual_city")) {

    function sie_get_textual_city($value): string
    {
        $mcities = model("App\Modules\Sie\Models\Sie_Cities");
        $city = $mcities->get_City($value);
        if (!empty($city) && isset($city['name'])) {
            return $city['name'];
        } else {
            return "No definido";
        }
    }

}

if (!function_exists("sie_get_textual_program")) {

    function sie_get_textual_program($value): string
    {
        $mprograms = model("App\Modules\Sie\Models\Sie_Programs");
        $program = $mprograms->getProgram($value);
        if (!empty($program) && isset($program['name'])) {
            return $program['name'];
        } else {
            return "NO DEFINIDO";
        }
    }

}

if (!function_exists("sie_get_textual_status")) {
    /**
     * Convierte un valor de estado en una representación textual.
     * @param mixed $status Puede ser un array o un booleano. Si es un array, se espera que contenga una clave 'value' que corresponde al valor del estado.
     * @return string Devuelve una cadena de texto que representa el estado. Si no se encuentra un estado coincidente, devuelve "Sin estado (Solo existente en el sistema)".
     */
    function sie_get_textual_status(mixed $status): string
    {
        //print_r($status);
        $textual = "Sin estado (Solo existente en el sistema)";
        if (is_array($status) && isset($status['reference'])) {
            $reference = $status['reference'];
            foreach (LIST_STATUSES as $lstatus) {
                if ($lstatus['value'] == $reference) {
                    return $lstatus['label'];
                }
            }
        }
        return $textual . " - " . @$status['value'];
    }
}

if (!function_exists("sie_get_textual_author")) {

    function sie_get_textual_author($author): string
    {
        $name = "Sistema (Automático)";
        if (!empty($author)) {
            $mfields = model("App\Modules\Sie\Models\Sie_Users_Fields");
            $author = $mfields->get_profile($author);
            if (!empty($author['name'])) {
                $name = "{$author['name']} - <span class=\"opacity-25\">{$author['user']}</span>";
            }
        }
        return ($name);
    }

}


if (!function_exists("generate_sie_permissions")) {

    /**
     * Permite registrar los permisos asociados al modulo, tecnicamente su
     * ejecucion regenera los permisos asignables definidos por el modulo DISA
     */
    function generate_sie_permissions(): void
    {
        $permissions = array(
            "sie-access",
            //[students]------------------------------------------------------------------------------------------------
            "sie-students-access",
            "sie-students-view",
            "sie-students-view-all",
            "sie-students-create",
            "sie-students-edit",
            "sie-students-edit-all",
            "sie-students-delete",
            "sie-students-delete-all",
            //[teachers]------------------------------------------------------------------------------------------------
            "sie-teachers-access",
            "sie-teachers-view",
            "sie-teachers-view-all",
            "sie-teachers-create",
            "sie-teachers-edit",
            "sie-teachers-edit-all",
            "sie-teachers-delete",
            "sie-teachers-delete-all",
            //[programs]------------------------------------------------------------------------------------------------
            "sie-programs-access",
            "sie-programs-view",
            "sie-programs-view-all",
            "sie-programs-create",
            "sie-programs-edit",
            "sie-programs-edit-all",
            "sie-programs-delete",
            "sie-programs-delete-all",
            //[Models]----------------------------------------------------------------------------------------
            "sie-models-access",
            "sie-models-view",
            "sie-models-view-all",
            "sie-models-create",
            "sie-models-edit",
            "sie-models-edit-all",
            "sie-models-delete",
            "sie-models-delete-all",
            //[Grids]----------------------------------------------------------------------------------------
            "sie-grids-access",
            "sie-grids-view",
            "sie-grids-view-all",
            "sie-grids-create",
            "sie-grids-edit",
            "sie-grids-edit-all",
            "sie-grids-delete",
            "sie-grids-delete-all",
            //[modules]------------------------------------------------------------------------------------------------
            "sie-modules-access",
            "sie-modules-view",
            "sie-modules-view-all",
            "sie-modules-create",
            "sie-modules-edit",
            "sie-modules-edit-all",
            "sie-modules-delete",
            "sie-modules-delete-all",
            //[pensums]--------------------------------------------------------------------------------------------------
            "sie-pensums-access",
            "sie-pensums-view",
            "sie-pensums-view-all",
            "sie-pensums-create",
            "sie-pensums-edit",
            "sie-pensums-edit-all",
            "sie-pensums-delete",
            "sie-pensums-delete-all",
            //[courses]-------------------------------------------------------------------------------------------------
            "sie-courses-access",
            "sie-courses-view",
            "sie-courses-view-all",
            "sie-courses-create",
            "sie-courses-edit",
            "sie-courses-edit-all",
            "sie-courses-delete",
            "sie-courses-delete-all",
            //[enrrolleds]-------------------------------------------------------------------------------------------------
            "sie-enrolleds-access",
            "sie-enrolleds-view",
            "sie-enrolleds-view-all",
            "sie-enrolleds-create",
            "sie-enrolleds-edit",
            "sie-enrolleds-edit-all",
            "sie-enrolleds-delete",
            "sie-enrolleds-delete-all",
            //[Products]----------------------------------------------------------------------------------------
            "sie-products-access",
            "sie-products-view",
            "sie-products-view-all",
            "sie-products-create",
            "sie-products-edit",
            "sie-products-edit-all",
            "sie-products-delete",
            "sie-products-delete-all",
            //[Discounts]----------------------------------------------------------------------------------------
            "sie-discounts-access",
            "sie-discounts-view",
            "sie-discounts-view-all",
            "sie-discounts-create",
            "sie-discounts-edit",
            "sie-discounts-edit-all",
            "sie-discounts-delete",
            "sie-discounts-delete-all",
            //[Registrations]----------------------------------------------------------------------------------------
            "sie-registrations-access",
            "sie-registrations-view",
            "sie-registrations-view-all",
            "sie-registrations-create",
            "sie-registrations-edit",
            "sie-registrations-edit-all",
            "sie-registrations-delete",
            "sie-registrations-delete-all",
            //[Payments]----------------------------------------------------------------------------------------
            "sie-payments-access",
            "sie-payments-view",
            "sie-payments-view-all",
            "sie-payments-create",
            "sie-payments-edit",
            "sie-payments-edit-all",
            "sie-payments-delete",
            "sie-payments-delete-all",
            //[Orders]----------------------------------------------------------------------------------------
            "sie-orders-access",
            "sie-orders-view",
            "sie-orders-view-all",
            "sie-orders-create",
            "sie-orders-edit",
            "sie-orders-edit-all",
            "sie-orders-delete",
            "sie-orders-delete-all",
            //[Institutions]----------------------------------------------------------------------------------------
            "sie-institutions-access",
            "sie-institutions-view",
            "sie-institutions-view-all",
            "sie-institutions-create",
            "sie-institutions-edit",
            "sie-institutions-edit-all",
            "sie-institutions-delete",
            "sie-institutions-delete-all",
            //[Groups]----------------------------------------------------------------------------------------
            "sie-groups-access",
            "sie-groups-view",
            "sie-groups-view-all",
            "sie-groups-create",
            "sie-groups-edit",
            "sie-groups-edit-all",
            "sie-groups-delete",
            "sie-groups-delete-all",
            //[Agreements]----------------------------------------------------------------------------------------
            "sie-agreements-access",
            "sie-agreements-view",
            "sie-agreements-view-all",
            "sie-agreements-create",
            "sie-agreements-edit",
            "sie-agreements-edit-all",
            "sie-agreements-delete",
            "sie-agreements-delete-all",
            //[Spaces]----------------------------------------------------------------------------------------
            "sie-spaces-access",
            "sie-spaces-view",
            "sie-spaces-view-all",
            "sie-spaces-create",
            "sie-spaces-edit",
            "sie-spaces-edit-all",
            "sie-spaces-delete",
            "sie-spaces-delete-all",
            //[Headquarters]----------------------------------------------------------------------------------------
            "sie-headquarters-access",
            "sie-headquarters-view",
            "sie-headquarters-view-all",
            "sie-headquarters-create",
            "sie-headquarters-edit",
            "sie-headquarters-edit-all",
            "sie-headquarters-delete",
            "sie-headquarters-delete-all",
            //[Enrollments]----------------------------------------------------------------------------------------
            "sie-enrollments-access",
            "sie-enrollments-view",
            "sie-enrollments-view-all",
            "sie-enrollments-create",
            "sie-enrollments-edit",
            "sie-enrollments-edit-all",
            "sie-enrollments-delete",
            "sie-enrollments-delete-all",
            //[Qualifications]----------------------------------------------------------------------------------------
            "sie-qualifications-access",
            "sie-qualifications-view",
            "sie-qualifications-view-all",
            "sie-qualifications-create",
            "sie-qualifications-edit",
            "sie-qualifications-edit-all",
            "sie-qualifications-delete",
            "sie-qualifications-delete-all",
            //[Evaluations]----------------------------------------------------------------------------------------
            "sie-evaluations-access",
            "sie-evaluations-view",
            "sie-evaluations-view-all",
            "sie-evaluations-create",
            "sie-evaluations-edit",
            "sie-evaluations-edit-all",
            "sie-evaluations-delete",
            "sie-evaluations-delete-all",
            //[Psychometrics]----------------------------------------------------------------------------------------
            "sie-psychometrics-access",
            "sie-psychometrics-view",
            "sie-psychometrics-view-all",
            "sie-psychometrics-create",
            "sie-psychometrics-edit",
            "sie-psychometrics-edit-all",
            "sie-psychometrics-delete",
            "sie-psychometrics-delete-all",
            //[Executions]----------------------------------------------------------------------------------------
            "sie-executions-access",
            "sie-executions-view",
            "sie-executions-view-all",
            "sie-executions-create",
            "sie-executions-edit",
            "sie-executions-edit-all",
            "sie-executions-delete",
            "sie-executions-delete-all",
            //[Q10files]------------------------------------------------------------------------------------------------
            "sie-q10files-access",
            "sie-q10files-view",
            "sie-q10files-view-all",
            "sie-q10files-create",
            "sie-q10files-edit",
            "sie-q10files-edit-all",
            "sie-q10files-delete",
            "sie-q10files-delete-all",
            //[Q10profiles]---------------------------------------------------------------------------------------------
            "sie-q10profiles-access",
            "sie-q10profiles-view",
            "sie-q10profiles-view-all",
            "sie-q10profiles-create",
            "sie-q10profiles-edit",
            "sie-q10profiles-edit-all",
            "sie-q10profiles-delete",
            "sie-q10profiles-delete-all",
            //[Graduations]---------------------------------------------------------------------------------------------
            "sie-graduations-access",
            "sie-graduations-view",
            "sie-graduations-view-all",
            "sie-graduations-create",
            "sie-graduations-edit",
            "sie-graduations-edit-all",
            "sie-graduations-delete",
            "sie-graduations-delete-all",
            //[executions]----------------------------------------------------------------------------------------------
            "sie-executions-access",
            "sie-executions-view",
            "sie-executions-view-all",
            "sie-executions-create",
            "sie-executions-edit",
            "sie-executions-edit-all",
            "sie-executions-delete",
            "sie-executions-delete-all",
            //[observations]--------------------------------------------------------------------------------------------
            "sie-observations-access",
            "sie-observations-view",
            "sie-observations-view-all",
            "sie-observations-create",
            "sie-observations-edit",
            "sie-observations-edit-all",
            "sie-observations-delete",
            "sie-observations-delete-all",
            //[Statuses]----------------------------------------------------------------------------------------
            "sie-statuses-access",
            "sie-statuses-view",
            "sie-statuses-view-all",
            "sie-statuses-create",
            "sie-statuses-edit",
            "sie-statuses-edit-all",
            "sie-statuses-delete",
            "sie-statuses-delete-all",
            //[Settings]----------------------------------------------------------------------------------------
            "sie-settings-access",
            "sie-settings-view",
            "sie-settings-view-all",
            "sie-settings-create",
            "sie-settings-edit",
            "sie-settings-edit-all",
            "sie-settings-delete",
            "sie-settings-delete-all",
            //[cost]----------------------------------------------------------------------------------------------------
            "sie-costs-view",
            "sie-costs-view-all",
            "sie-costs-create",
            "sie-costs-edit",
            "sie-costs-edit-all",
            "sie-costs-delete",
            "sie-costs-delete-all",
            //[Networks]----------------------------------------------------------------------------------------
            "sie-networks-access",
            "sie-networks-view",
            "sie-networks-view-all",
            "sie-networks-create",
            "sie-networks-edit",
            "sie-networks-edit-all",
            "sie-networks-delete",
            "sie-networks-delete-all",
            //[Subsectors]----------------------------------------------------------------------------------------
            "sie-subsectors-access",
            "sie-subsectors-view",
            "sie-subsectors-view-all",
            "sie-subsectors-create",
            "sie-subsectors-edit",
            "sie-subsectors-edit-all",
            "sie-subsectors-delete",
            "sie-subsectors-delete-all",
            //[Formats]----------------------------------------------------------------------------------------
            "sie-formats-access",
            "sie-formats-view",
            "sie-formats-view-all",
            "sie-formats-create",
            "sie-formats-edit",
            "sie-formats-edit-all",
            "sie-formats-delete",
            "sie-formats-delete-all",
            //[Certificates]----------------------------------------------------------------------------------------
            "sie-certificates-access",
            "sie-certificates-view",
            "sie-certificates-view-all",
            "sie-certificates-create",
            "sie-certificates-edit",
            "sie-certificates-edit-all",
            "sie-certificates-delete",
            "sie-certificates-delete-all",
            //[reports]-------------------------------------------------------------------------------------------------
            "sie-reports-access",
            //[moodle]-------------------------------------------------------------------------------------------------
            "sie-moodle-access",
            //[Directs]----------------------------------------------------------------------------------------
            "sie-directs-access",
            "sie-directs-view",
            "sie-directs-view-all",
            "sie-directs-create",
            "sie-directs-edit",
            "sie-directs-edit-all",
            "sie-directs-delete",
            "sie-directs-delete-all",
        );
        generate_permissions($permissions, "sie");
    }

}

if (!function_exists("get_sie_sidebar")) {
    function get_sie_sidebar2($active_url = false)
    {
        $bootstrap = service("bootstrap");
        $lpk = safe_strtolower(pk());
        $options = array(
            "home" => array("text" => lang("App.Home"), "href" => "/sie/", "svg" => "home.svg"),
            "enrollments" => array("text" => "Matriculas", "href" => "https://intranet.utede.edu.co/sie/enrollments/home/" . lpk(), "icon" => ICON_ENROLL, "permission" => "sie-access"),
            "students" => array("text" => "Estudiantes", "href" => "/sie/students/list/" . lpk(), "icon" => ICON_STUDENTS, "permission" => "sie-access"),
            "preenroolments" => array("text" => "Preinscripciones", "href" => "/sie/registrations/list/" . lpk(), "icon" => ICON_STUDENTS, "permission" => "sie-access"),
            "teachers" => array("text" => lang("App.Teachers"), "href" => "/sie/teachers/list/" . lpk(), "icon" => ICON_TEACHERS, "permission" => "sie-access"),
            "programs" => array("text" => lang("App.Programs"), "href" => "/sie/programs/list/" . lpk(), "icon" => ICON_ACADEMIC_PROGRAMS, "permission" => "sie-access"),
            "modules" => array("text" => lang("App.Modules"), "href" => "/sie/modules/list/" . lpk(), "icon" => ICON_MODULES, "permission" => "sie-access"),
            "courses" => array("text" => lang("App.Courses"), "href" => "/sie/courses/list/" . lpk(), "icon" => ICON_COURSES, "permission" => "sie-access"),
            "financial" => array("text" => "Financiero", "href" => "/sie/financial/home/" . lpk(), "icon" => ICON_FINANCIAL, "permission" => "sie-access"),
            "tools" => array("text" => "Actualización", "href" => "/sie/tools/snies/" . lpk(), "icon" => ICON_TOOLS, "permission" => "sie-access"),
            "reports" => array("text" => lang("App.Reports"), "href" => "/sie/reports/home/" . lpk(), "icon" => ICON_REPORTS, "permission" => "sie-access"),
            "graduations" => array("text" => "Postulaciones", "href" => "/sie/graduations/list/" . lpk(), "icon" => ICON_GRADUATIONS, "permission" => "sie-access"),
            //"registrations" => array("text" => "Preinscripciones", "href" => "/sie/registrations/list/" . lpk(), "icon" => ICON_STUDENTS, "permission" => "sie-access"),
            "training" => array("text" => "Formación Continua", "href" => "/sie/trainings/home/" . lpk(), "icon" => ICON_TRAINING, "permission" => "sie-access"),
            "tools" => array("text" => lang("App.Tools"), "href" => "/sie/tools/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "sie-access"),
            "campus" => array("text" => "Campus", "href" => "/", "icon" => ICON_SETTINGS, "permission" => "sie-access"),
            "furag" => array("text" => "Furag", "href" => "/furag", "icon" => ICON_SETTINGS, "permission" => "sie-access"),
            "certifications" => array("text" => "Certificados", "href" => "/sie/certificates/list/" . lpk(), "icon" => ICON_CERTIFICATIONS, "permission" => "sie-access"),
            "history" => array("text" => lang("App.History"), "href" => "/history", "icon" => ICON_HISTORY, "target" => "_blank", "permission" => "sie-access"),
            "settings" => array("text" => lang("App.Settings"), "href" => "/sie/settings/home/" . lpk(), "icon" => ICON_SETTINGS, "permission" => "sie-access"),
        );
        $o = get_application_custom_sidebar($options, $active_url);
        $return = $bootstrap->get_NavPillsGamma($o, $active_url);
        return ($return);
    }
}

if (!function_exists("get_sie_count_users")) {
    function get_sie_count_users()
    {
        $mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');
        $count = $mregistrations->getCountAllResults();
        $code = "";
        $code .= "<div class=\"card flex-row align-items-center align-items-stretch mb-3\">\n";
        $code .= "\t\t<div class=\"col-4 d-flex align-items-center bg-gray justify-content-center rounded-left\">\n";
        $code .= "\t\t\t\t<i class=\"icon fa-light fa-screen-users fa-3x\"></i>\n";
        $code .= "\t\t</div>\n";
        $code .= "\t\t<div class=\"col-8 py-3 bg-gray rounded-right\">\n";
        $code .= "\t\t\t\t<div class=\"fs-5 lh-5 my-0\">\n";
        $code .= "\t\t\t\t\t\t{$count}\t\t\t\t</div>\n";
        $code .= "\t\t\t\t<div class=\"\t\tmy-0\">\n";
        $code .= "\t\t\t\t\t\t" . lang("App.Records") . "\t\t\t\t</div>\n";
        $code .= "\t\t</div>\n";
        $code .= "</div>\n";
        return ($code);
    }
}

if (!function_exists("get_sie_count_students")) {

    function get_sie_count_students($value)
    {
        $mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');
        $code = "";
        $code .= "<div class=\"card flex-row align-items-center align-items-stretch mb-3\">\n";
        $code .= "\t\t<div class=\"col-4 d-flex align-items-center bg-gray justify-content-center rounded-left\">\n";
        $code .= "\t\t\t\t<i class=\"icon fa-light fa-screen-users fa-3x\"></i>\n";
        $code .= "\t\t</div>\n";
        $code .= "\t\t<div class=\"col-8 py-3 bg-gray rounded-right\">\n";
        $code .= "\t\t\t\t<div class=\"fs-5 lh-5 my-0\">\n";
        $code .= "\t\t\t\t\t\t{$value}\t\t\t\t</div>\n";
        $code .= "\t\t\t\t<div class=\"\t\tmy-0\">\n";
        $code .= "\t\t\t\t\t\t" . lang("App.Students") . "\t\t\t\t</div>\n";
        $code .= "\t\t</div>\n";
        $code .= "</div>\n";
        return ($code);
    }

}

if (!function_exists("get_sie_course_schedule")) {

    function get_sie_course_schedule($course)
    {
        $start = $course["start"];
        $end = $course["end"];
        $period = $course["period"];
        $code = "";
        $code .= "<div class=\"card flex-row align-items-center align-items-stretch mb-3\">\n";
        $code .= "\t <div id=\"\" class=\"col-12 col p-3 \">\n";

        //[field]-------------------------------------------------------------------------------------------------------
        $code .= "\t\t <label for=\"start\">Periodo Académico</label>:\n";
        $code .= "\t\t <div class=\"input-group\">\n";
        $code .= "\t\t\t <div style=\"height: auto;\" class=\"control-view form-control control-light\">";
        $code .= "\t\t\t\t {$period}";
        $code .= "\t\t\t </div>\n";
        $code .= "\t\t </div>\n";
        //[field]-------------------------------------------------------------------------------------------------------
        $code .= "\t\t <label for=\"start\">Fecha de inicio</label>:\n";
        $code .= "\t\t <div class=\"input-group\">\n";
        $code .= "\t\t\t <div style=\"height: auto;\" class=\"control-view form-control control-light\">";
        $code .= "\t\t\t\t {$start}";
        $code .= "\t\t\t </div>\n";
        $code .= "\t\t </div>\n";
        //[field]-------------------------------------------------------------------------------------------------------
        $code .= "\t\t <label for=\"start\">Fecha de finalización</label>:\n";
        $code .= "\t\t <div class=\"input-group\">\n";
        $code .= "\t\t\t <div style=\"height: auto;\" class=\"control-view form-control control-light\">";
        $code .= "\t\t\t\t {$end}";
        $code .= "\t\t\t </div>\n";
        $code .= "\t\t </div>\n";

        $code .= "\t </div>\n";
        $code .= "</div>\n";
        return ($code);
    }

}


if (!function_exists("get_sie_help_registrations")) {

    function get_sie_help_registrations()
    {
        $code = "<div class=\"card mb-3\">\n";
        $code .= "<div class=\"card-header\">";
        $code .= "<h2 class=\"card-header-title p-1  m-0 opacity-7\">";
        $code .= "Filtros Avanzados";
        $code .= "</h2>";
        $code .= "</div>";
        $code .= "<div class=\"card-body \">\n";
        $code .= "<p>Para consultar  los resultados según el estado del proceso de preinscripción puede utilizar los siguientes filtros digitándolos en la casilla de búsqueda:</p>";
        $code .= "<ul class=\"m-0 \">";
        $code .= "<li><b>PROCESS</b>: En proceso</b></li>";
        $code .= "<li><b>ADMITTED</b>: Admitidos</b></li>";
        $code .= "<li><b>UNADMITTED</b>: No admitidos</b></li>";
        $code .= "<li><b>PROCESS</b>: En proceso</b></li>";
        $code .= "<li><b>HOMOLOGATION</b>: Admitidos proceso homologación</b></li>";
        $code .= "<li><b>DESISTEMENT</b>: Desiste del proceso</b></li>";
        $code .= "<li><b>RE-ENTRY</b>: Admitido por reingreso</b></li>";
        $code .= "</ul>";
        $code .= "</div>\n";
        $code .= "</div>\n";
        return ($code);
    }

}

if (!function_exists("get_sie_count_teachers")) {

    function get_sie_count_teachers()
    {
        $musers = model('App\Modules\Sie\Models\Sie_Users');
        $count = $musers->getCachedTotalByType("TEACHER");
        $code = "";
        $code .= "<div class=\"card flex-row align-items-center align-items-stretch mb-3\">\n";
        $code .= "\t\t<div class=\"col-4 d-flex align-items-center bg-gray justify-content-center rounded-left\">\n";
        $code .= "\t\t\t\t<i class=\"fa-light fa-person-chalkboard fa-3x\"></i>\n";
        $code .= "\t\t</div>\n";
        $code .= "\t\t<div class=\"col-8 py-3 bg-gray rounded-right\">\n";
        $code .= "\t\t\t\t<div class=\"fs-5 lh-5 my-0\">\n";
        $code .= "\t\t\t\t\t\t{$count}\t\t\t\t</div>\n";
        $code .= "\t\t\t\t<div class=\"\t\tmy-0\">\n";
        $code .= "\t\t\t\t\t\t" . lang("App.Teachers") . "\t\t\t\t</div>\n";
        $code .= "\t\t</div>\n";
        $code .= "</div>\n";
        return ($code);
    }

}

if (!function_exists("get_sie_textual_status")) {
    /**
     * Convierte un valor de estado en una representación textual.
     * @param $status
     * @return string
     */
    function get_sie_textual_status($status): string
    {
        $textual = "N/A";
        if (!empty($status) && is_string($status)) {
            foreach (LIST_STATUSES as $lstatus) {
                if ($lstatus['value'] == $status) {
                    $textual = $lstatus['label'];
                }
            }
        } else {
            $textual = "No es una cadena";
        }
        return ($textual);
    }

}

if (!function_exists("get_sie_textual_journey")) {
    /**
     * Convierte un valor de estado en una representación textual.
     * @param $status
     * @return string
     */
    function get_sie_textual_journey(mixed $journey): string
    {
        $textual = "N/A";
        if (!empty($journey) && is_string($journey)) {
            foreach (LIST_JOURNEYS as $ljourney) {
                if ($ljourney['value'] == $journey) {
                    $textual = $ljourney['label'];
                }
            }
        } else {
            $textual = "No es una cadena";
        }
        return ($textual);
    }

}


if (!function_exists("get_sie_counter_box")) {
    function get_sie_counter_box($value, $icon): string
    {
        $code = "<div class=\"four col-12\">\n";
        $code .= "<div class=\"counter-box\">\n";
        $code .= "<i class=\"{$icon}\"></i>\n";
        $code .= "<span class=\"counter\">{$value}</span>\n";
        $code .= "</div>\n";
        $code .= "</div>\n";
        return ($code);
    }
}

if (!function_exists("get_sie_textual_journey")) {
    function get_sie_textual_journey($value): string
    {
        $return = "No definido";
        foreach (LIST_JOURNEYS as $ljourney) {
            if (@$ljourney["value"] == $value) {
                $return = @$ljourney["label"];
            }
        }
        return ($return);
    }
}


if (!function_exists("sie_calcStatusInExecution")) {
    function sie_calcStatusInExecution($uc1, $uc2, $uc3)
    {
        // Normalizamos
        $uc1 = (float)$uc1;
        $uc2 = (float)$uc2;
        $uc3 = (float)$uc3;

        // ¿Hay nota registrada?
        $p1 = ($uc1 > 0) ? 1 : 0;
        $p2 = ($uc2 > 0) ? 1 : 0;
        $p3 = ($uc3 > 0) ? 1 : 0;
        $pt = $p1 + $p2 + $p3;

        // Cursando: ninguna UC tiene nota todavía
        if ($pt === 0) {
            return ['Cursando', 'execution-text-bg-primary'];
        }

        // Aprobado: las tres UCs en nivel competente
        if ($uc1 >= 80 && $uc2 >= 80 && $uc3 >= 80) {
            return ['Aprobado', 'execution-text-bg-success'];
        }

        // En cualquier otro caso: Plan de mejora
        return ['Plan de mejora', 'execution-text-bg-warning'];
    }


}

if (!function_exists("sie_getStatusExecution")) {
    function sie_getStatusExecution($uc1, $uc2, $uc3)
    {
        // Normalizamos a float
        $uc1 = (float)$uc1;
        $uc2 = (float)$uc2;
        $uc3 = (float)$uc3;

        // ¿Hay nota registrada (> 0)?
        $p1 = ($uc1 > 0) ? 1 : 0;
        $p2 = ($uc2 > 0) ? 1 : 0;
        $p3 = ($uc3 > 0) ? 1 : 0;
        $pt = $p1 + $p2 + $p3;

        // 1) Ninguna UC tiene nota → PENDING
        if ($pt === 0) {
            return "PENDING";
        }

        // 2) Regla especial: si alguna UC es exactamente 1 → IMPROVEMENT
        if ($uc1 == 1 || $uc2 == 1 || $uc3 == 1) {
            return "IMPROVEMENT";
        }

        // 3) Todas las UCs con nota y en nivel competente → APPROVED
        if ($uc1 >= 80 && $uc2 >= 80 && $uc3 >= 80) {
            return "APPROVED";
        }

        // 4) Si alguna calificación > 0 es menor a 80 → IMPROVEMENT
        if (($uc1 > 0 && $uc1 < 80) || ($uc2 > 0 && $uc2 < 80) || ($uc3 > 0 && $uc3 < 80)) {
            return "IMPROVEMENT";
        }

        // 5) Cualquier otro caso raro, pero con notas, lo tratamos como IMPROVEMENT
        return "PENDING";
    }
}


?>