<?php
/** @var int $page viene de grid.php */
/** @var model $mexecutions */
/** @var model $mprogress */
/** @var model $mstatuses */
/** @var model $mregistrations */
/** @var model $mprograms */
/** @var model $magreements */
/** @var model $minstitutions */
/** @var model $mcities */
/** @var model $mdiscounteds */
/** @var model $mfields */
/** @var string $program */
/** @var string $period */
/** @var string $status */
/** @var int $limit */
/** @var int $offset */

//[models]--------------------------------------------------------------------------------------------------------------
$mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');
$mprograms = model('App\Modules\Sie\Models\Sie_Programs');
$magreements = model('App\Modules\Sie\Models\Sie_Agreements');
$minstitutions = model('App\Modules\Sie\Models\Sie_Institutions');
$mcities = model('App\Modules\Sie\Models\Sie_Cities');
$mdiscounts = model("App\Modules\Sie\Models\Sie_Discounts");
$mdiscounteds = model("App\Modules\Sie\Models\Sie_Discounteds");
$mstatuses = model("App\Modules\Sie\Models\Sie_Statuses");
$mfields = model("App\Modules\Sie\Models\Sie_Users_Fields");
$mexecutions = model("App\Modules\Sie\Models\Sie_Executions");
$mprogress = model("App\Modules\Sie\Models\Sie_Progress");
$morders = model("App\Modules\Sie\Models\Sie_Orders");
$mcountries = model("App\Modules\Sie\Models\Sie_Countries");
$mregions = model("App\Modules\Sie\Models\Sie_Regions");
$mcities = model("App\Modules\Sie\Models\Sie_Cities");

$dates = service('dates');

$period = $_GET['period'];

$limit = 10000;
$offset = 0;

// Define los tres estados posibles
$statusArray = ["ENROLLED", "ENROLLED-OLD", "ENROLLED-EXT"];

if (!empty($program) && $program != "ALL") {
    $statuses = $mstatuses->get_StatusesAndRegistrations($period, $statusArray, $program, $limit, $offset);

} else {
    $statuses = $mstatuses->get_StatusesAndRegistrations($period, $statusArray, "", $limit, $offset);
}

//echo $mstatuses->getLastQuery();

$totalRecords = count($statuses);

$code = "";

$n = array();


$code .= " <table\n";
$code .= "\t\t id=\"grid-table\"\n";
$code .= "\t\t class=\"table table-responsive column-options\" \n ";
$code .= "\t\t border=\"1\">\n";
$code .= "<tdead>";
$code .= "<tr>\n";
$code .= "<td class='text-center text-nowrap '>#</td>\n";
$code .= "<td class='text-center text-nowrap'>PERIODO</td>\n";
$code .= "<td class='text-center text-nowrap'>ESTUDIANTE</td>\n";
$code .= "<td class='text-center text-nowrap'>ESTADO</td>\n";
$code .= "<td class='text-center text-nowrap'>ID_TIPO_DOCUMENTO</td>\n";
$code .= "<td class='text-center text-nowrap'>NUM_DOCUMENTO</td>\n";
$code .= "<td class='text-center text-nowrap'>CONVENIO</td>\n";
$code .= "<td class='text-center text-nowrap'>PAÍS CONVENIO</td>\n";
$code .= "<td class='text-center text-nowrap'>REGIÓN CONVENIO</td>\n";
$code .= "<td class='text-center text-nowrap'>CIUDAD CONVENIO</td>\n";
$code .= "<td class='text-center text-nowrap'>INSTITUCIÓN CONVENIO</td>\n";
$code .= "<td class='text-center text-nowrap'>GRUPO CONVENIO</td>\n";
$code .= "<td class='text-center text-nowrap'>SEDE</td>\n";
$code .= "<td class='text-center text-nowrap'>TURNOS</td>\n";
$code .= "<td class='text-center text-nowrap'>GRUPO</td>\n";
$code .= "<td class='text-center text-nowrap'>PERIODO</td>\n";
$code .= "<td class='text-center text-nowrap'>JORNADA</td>\n";
$code .= "<td class='text-center text-nowrap'>PROGRAMA</td>\n";
$code .= "<td class='text-center text-nowrap'>PRIMER NOMBRE</td>\n";
$code .= "<td class='text-center text-nowrap'>SEGUNDO NOMBRE</td>\n";
$code .= "<td class='text-center text-nowrap'>PRIMER APELLIDO</td>\n";
$code .= "<td class='text-center text-nowrap'>SEGUNDO APELLIDO</td>\n";
$code .= "<td class='text-center text-nowrap'>TIPO DOCUMENTO</td>\n";
$code .= "<td class='text-center text-nowrap'>NÚMERO DOCUMENTO</td>\n";
$code .= "<td class='text-center text-nowrap'>LUGAR EXPEDICIÓN</td>\n";
$code .= "<td class='text-center text-nowrap'>FECHA EXPEDICIÓN</td>\n";

$code .= "<td class='text-center text-nowrap'>PAÍS DOCUMENTO</td>\n";
$code .= "<td class='text-center text-nowrap'>REGIÓN DOCUMENTO</td>\n";
$code .= "<td class='text-center text-nowrap'>CIUDAD DOCUMENTO</td>\n";


$code .= "<td class='text-center text-nowrap'>GÉNERO</td>\n";
$code .= "<td class='text-center text-nowrap'>CORREO PERSONAL</td>\n";
$code .= "<td class='text-center text-nowrap'>CORREO INSTITUCIONAL</td>\n";
$code .= "<td class='text-center text-nowrap'>TELÉFONO</td>\n";
$code .= "<td class='text-center text-nowrap'>CELULAR</td>\n";

$code .= "<td class='text-center text-nowrap'>FECHA NACIMIENTO</td>\n";
$code .= "<td class='text-center text-nowrap'>PAÍS NACIMIENTO</td>\n";
$code .= "<td class='text-center text-nowrap'>REGIÓN NACIMIENTO</td>\n";
$code .= "<td class='text-center text-nowrap'>CIUDAD NACIMIENTO</td>\n";

$code .= "<td class='text-center text-nowrap'>DIRECCIÓN</td>\n";
$code .= "<td class='text-center text-nowrap'>PAÍS RESIDENCIA</td>\n";
$code .= "<td class='text-center text-nowrap'>REGIÓN RESIDENCIA</td>\n";
$code .= "<td class='text-center text-nowrap'>CIUDAD RESIDENCIA</td>\n";
$code .= "<td class='text-center text-nowrap'>BARRIO</td>\n";
$code .= "<td class='text-center text-nowrap'>ÁREA</td>\n";


$code .= "<td class='text-center text-nowrap'>ESTRATO</td>\n";
$code .= "<td class='text-center text-nowrap'>MEDIO TRANSPORTE</td>\n";
$code .= "<td class='text-center text-nowrap'>GRUPO SISBEN</td>\n";
$code .= "<td class='text-center text-nowrap'>SUBGRUPO SISBEN</td>\n";
$code .= "<td class='text-center text-nowrap'>LUGAR EXPEDICIÓN</td>\n";
$code .= "<td class='text-center text-nowrap'>TIPO SANGRE</td>\n";
$code .= "<td class='text-center text-nowrap'>ESTADO CIVIL</td>\n";
$code .= "<td class='text-center text-nowrap'>NÚMERO HIJOS</td>\n";
$code .= "<td class='text-center text-nowrap'>LIBRETA MILITAR</td>\n";
$code .= "<td class='text-center text-nowrap'>ARL</td>\n";
$code .= "<td class='text-center text-nowrap'>ASEGURADORA</td>\n";
$code .= "<td class='text-center text-nowrap'>EPS</td>\n";
$code .= "<td class='text-center text-nowrap'>NIVEL EDUCATIVO</td>\n";
$code .= "<td class='text-center text-nowrap'>OCUPACIÓN</td>\n";
$code .= "<td class='text-center text-nowrap'>RÉGIMEN SALUD</td>\n";
$code .= "<td class='text-center text-nowrap'>FECHA EXPEDICIÓN DOCUMENTO</td>\n";
$code .= "<td class='text-center text-nowrap'>SABER 11</td>\n";
$code .= "<td class='text-center text-nowrap'>VALOR SABER 11</td>\n";
$code .= "<td class='text-center text-nowrap'>FECHA SABER 11</td>\n";
$code .= "<td class='text-center text-nowrap'>CERTIFICADO GRADUACIÓN</td>\n";
$code .= "<td class='text-center text-nowrap'>ID MILITAR</td>\n";
//$code .= "<td class='text-center text-nowrap'>DIPLOMA</td>\n";
//$code .= "<td class='text-center text-nowrap'>CERTIFICADO ICFES</td>\n";
//$code .= "<td class='text-center text-nowrap'>RECIBO SERVICIOS</td>\n";
//$code .= "<td class='text-center text-nowrap'>CERTIFICADO SISBEN</td>\n";
//$code .= "<td class='text-center text-nowrap'>CERTIFICADO DIRECCIÓN</td>\n";
//$code .= "<td class='text-center text-nowrap'>CERTIFICADO ELECTORAL</td>\n";
//$code .= "<td class='text-center text-nowrap'>FOTO CARNÉ</td>\n";
//$code .= "<td class='text-center text-nowrap'>OBSERVACIONES</td>\n";
//$code .= "<td class='text-center text-nowrap'>AUTOR</td>\n";
//$code .= "<td class='text-center text-nowrap'>TICKET</td>\n";
//$code .= "<td class='text-center text-nowrap'>ENTREVISTA</td>\n";
$code .= "<td class='text-center text-nowrap'>TIPO VINCULACIÓN</td>\n";
$code .= "<td class='text-center text-nowrap'>GRUPO ÉTNICO</td>\n";
//$code .= "<td class='text-center text-nowrap'>PUEBLO INDÍGENA</td>\n";
//$code .= "<td class='text-center text-nowrap'>AFRODESCENDIENTE</td>\n";
$code .= "<td class='text-center text-nowrap'>DISCAPACIDAD</td>\n";
$code .= "<td class='text-center text-nowrap'>TIPO DISCAPACIDAD</td>\n";
$code .= "<td class='text-center text-nowrap'>CAPACIDAD EXCEPCIONAL</td>\n";
$code .= "<td class='text-center text-nowrap'>RESPONSABLE</td>\n";
$code .= "<td class='text-center text-nowrap'>RELACIÓN RESPONSABLE</td>\n";
$code .= "<td class='text-center text-nowrap'>GRUPO POBLACIÓN IDENTIFICADA</td>\n";
$code .= "<td class='text-center text-nowrap'>POBLACIÓN DESTACADA</td>\n";
$code .= "<td class='text-center text-nowrap'>TELÉFONO RESPONSABLE</td>\n";
$code .= "<td class='text-center text-nowrap'>POBLACIÓN FRONTERIZA</td>\n";
//$code .= "<td class='text-center text-nowrap'>OBSERVACIONES ACADÉMICAS</td>\n";
//$code .= "<td class='text-center text-nowrap'>IMPORTAR</td>\n";
//$code .= "<td class='text-center text-nowrap'>MOMENTO</td>\n";
//$code .= "<td class='text-center text-nowrap'>ACTUALIZACIÓN SNIES</td>\n";
//$code .= "<td class='text-center text-nowrap'>FOTO</td>\n";
$code .= "<td class='text-center text-nowrap'>COLEGIO</td>\n";
$code .= "<td class='text-center text-nowrap'>AÑO COLEGIO</td>\n";
$code .= "<td class='text-center text-nowrap'>AC</td>\n";
$code .= "<td class='text-center text-nowrap'>PUNTAJE AC</td>\n";
$code .= "<td class='text-center text-nowrap'>FECHA AC</td>\n";
$code .= "<td class='text-center text-nowrap'>TIPO DOCUMENTO AC</td>\n";
$code .= "<td class='text-center text-nowrap'>NÚMERO DOCUMENTO AC</td>\n";
$code .= "<td class='text-center text-nowrap'>EK</td>\n";
$code .= "<td class='text-center text-nowrap'>PUNTAJE EK</td>\n";
$code .= "<td class='text-center text-nowrap'>VALIDACIÓN REQUISITO ID SNIES</td>\n";
//$code .= "<td class='text-center text-nowrap'>CREADO</td>\n";
//$code .= "<td class='text-center text-nowrap'>ACTUALIZADO</td>\n";
//$code .= "<td class='text-center text-nowrap'>ELIMINADO</td>\n";
$code .= "<td class='text-center text-nowrap'>PERSONAS CONVIVIENTES</td>\n";
$code .= "<td class='text-center text-nowrap'>PERSONAS APORTANTES</td>\n";
$code .= "<td class='text-center text-nowrap'>PERSONAS DEPENDIENTES</td>\n";
$code .= "<td class='text-center text-nowrap'>NIVEL EDUCATIVO PADRE</td>\n";
$code .= "<td class='text-center text-nowrap'>NIVEL EDUCATIVO MADRE</td>\n";
$code .= "<td class='text-center text-nowrap'>TIPO VIVIENDA</td>\n";
$code .= "<td class='text-center text-nowrap'>DEPENDENCIA ECONÓMICA</td>\n";
$code .= "<td class='text-center text-nowrap'>TIPO FINANCIACIÓN</td>\n";
$code .= "<td class='text-center text-nowrap'>OCUPACIÓN ACTUAL</td>\n";
$code .= "<td class='text-center text-nowrap'>TIPO TRABAJO</td>\n";
$code .= "<td class='text-center text-nowrap'>HORAS SEMANALES TRABAJADAS</td>\n";
$code .= "<td class='text-center text-nowrap'>INGRESO MENSUAL</td>\n";
$code .= "<td class='text-center text-nowrap'>NOMBRE EMPRESA</td>\n";
$code .= "<td class='text-center text-nowrap'>CARGO EMPRESA</td>\n";
$code .= "<td class='text-center text-nowrap'>SECTOR PRODUCTIVO</td>\n";
$code .= "<td class='text-center text-nowrap'>PRIMERO EN FAMILIA UNIVERSIDAD</td>\n";
//$code .= "<td class='text-center text-nowrap'>ID ESTUDIANTE MOODLE</td>\n";
$code .= "</tr>\n";
$code .= "</thead>";

$count = 0;
$class = "";

foreach ($statuses as $status) {
    $registration = $mregistrations->getRegistration($status['registration']);
    if (!empty($registration)) {
        $count++;
        $class = ($count % 2 == 0) ? "odd" : "even";

        $nupdated = "<span class=\"text-danger\">NO ACTUALIZADO</span>";
        $na = "<span class=\"text-warning\">N/A</span>";

        //[defaults]--------------------------------------------------------------------------------------------------------
        $STATUS_REGISTRATION = @$status['registration'];
        $STATUS_PERIOD = @$status['status_period'];
        $STATUS_STUDENT = "<a href=\"/sie/students/view/{$STATUS_REGISTRATION}\" target=\"_blank\">{$STATUS_REGISTRATION}</a>";
        $STATUS_STATUS = @$status['reference'];
        $STATUS_IDENTIFICATION_TYPE = @$status['identification_type'];
        $STATUS_IDENTIFICATION_NUMBER = @$status['identification_number'];

        $STATUS_AGREEMENT = @$status['agreement'];
        if (!empty($STATUS_AGREEMENT)) {
            $agreement_country = !empty(@$status['agreement_country']) ? $mcountries->getCountry($status['agreement_country']) : null;
            $STATUS_AGREEMENT_COUNTRY = $agreement_country ? safe_strtoupper($agreement_country['name']) : $nupdated;

            $agreement_region = !empty(@$status['agreement_region']) ? $mregions->getRegion($status['agreement_region']) : null;
            $STATUS_AGREEMENT_REGION = $agreement_region ? safe_strtoupper($agreement_region['name']) : $nupdated;

            $agreement_city = !empty(@$status['agreement_city']) ? $mcities->getCity($status['agreement_city']) : null;
            $STATUS_AGREEMENT_CITY = $agreement_city ? safe_strtoupper($agreement_city['name']) : $nupdated;

            $STATUS_AGREEMENT_INSTITUTION = @$status['agreement_institution'];
            $STATUS_AGREEMENT_GROUP = @$status['agreement_group'];
        } else {
            $STATUS_AGREEMENT = "PRINCIPAL";
            $STATUS_AGREEMENT_COUNTRY = "COLOMBIA";
            $STATUS_AGREEMENT_REGION = "VALLE DEL CAUCA";
            $STATUS_AGREEMENT_CITY = "GUADALAJARA DE BUGA";
            $STATUS_AGREEMENT_INSTITUTION = "UTEDE";
            $STATUS_AGREEMENT_GROUP = "GENERAL";
        }
        $STATUS_CAMPUS = !empty(@$status['campus']) ? safe_strtoupper(@$status['campus']) : $nupdated;
        $STATUS_SHIFTS = !empty(@$status['shifts']) ? safe_strtoupper(@$status['shifts']) : $nupdated;
        $STATUS_GROUP = !empty(@$status['group']) ? safe_strtoupper(@$status['group']) : $nupdated;
        $STATUS_JOURNEY = !empty(@$status['journey']) ? safe_strtoupper(@$status['journey']) : $nupdated;
        $STATUS_PROGRAM = !empty(@$status['program']) ? safe_strtoupper(@$status['program']) : $nupdated;
        $STATUS_FIRST_NAME = !empty(@$status['first_name']) ? safe_strtoupper(@$status['first_name']) : $nupdated;
        $STATUS_SECOND_NAME = !empty(@$status['second_name']) ? safe_strtoupper(@$status['second_name']) : $nupdated;
        $STATUS_FIRST_SURNAME = !empty(@$status['first_surname']) ? safe_strtoupper(@$status['first_surname']) : $nupdated;
        $STATUS_SECOND_SURNAME = !empty(@$status['second_surname']) ? safe_strtoupper(@$status['second_surname']) : $nupdated;

        $STATUS_IDENTIFICATION_PLACE = !empty(@$status['identification_place']) ? safe_strtoupper(@$status['identification_place']) : $nupdated;
        $STATUS_IDENTIFICATION_DATE = !empty(@$status['identification_date']) ? safe_strtoupper(@$status['identification_date']) : $nupdated;

        $identification_country = !empty(@$status['identification_country']) ? $mcountries->getCountry($status['identification_country']) : null;
        $STATUS_IDENTIFICATION_COUNTRY = $identification_country ? safe_strtoupper($identification_country['name']) : $nupdated;

        $identification_region = !empty(@$status['identification_region']) ? $mregions->getRegion($status['identification_region']) : null;
        $STATUS_IDENTIFICATION_REGION = $identification_region ? safe_strtoupper($identification_region['name']) : $nupdated;

        $identification_city = !empty(@$status['identification_city']) ? $mcities->getCity($status['identification_city']) : null;
        $STATUS_IDENTIFICATION_CITY = $identification_city ? safe_strtoupper($identification_city['name']) : $nupdated;

        $STATUS_GENDER = !empty(@$status['gender']) ? safe_strtoupper(@$status['gender']) : $nupdated;
        $STATUS_EMAIL_ADDRESS = !empty(@$status['email_address']) ? safe_strtoupper(@$status['email_address']) : $nupdated;
        $STATUS_EMAIL_INSTITUTIONAL = !empty(@$status['email_institutional']) ? safe_strtoupper(@$status['email_institutional']) : $nupdated;
        $STATUS_PHONE = !empty(@$status['phone']) ? safe_strtoupper(@$status['phone']) : $nupdated;
        $STATUS_MOBILE = !empty(@$status['mobile']) ? safe_strtoupper(@$status['mobile']) : $nupdated;
        $STATUS_BIRTH_DATE = !empty(@$status['birth_date']) ? safe_strtoupper(@$status['birth_date']) : $nupdated;

        $birth_country = !empty(@$status['birth_country']) ? $mcountries->getCountry($status['birth_country']) : null;
        $STATUS_BIRTH_COUNTRY = $birth_country ? safe_strtoupper($birth_country['name']) : $nupdated;

        $birth_region = !empty(@$status['birth_region']) ? $mregions->getRegion($status['birth_region']) : null;
        $STATUS_BIRTH_REGION = $birth_region ? safe_strtoupper($birth_region['name']) : $nupdated;

        $birth_city = !empty(@$status['birth_city']) ? $mcities->getCity($status['birth_city']) : null;
        $STATUS_BIRTH_CITY = $birth_city ? safe_strtoupper($birth_city['name']) : $nupdated;

        $STATUS_ADDRESS = !empty(@$status['address']) ? safe_strtoupper(@$status['address']) : $nupdated;

        $residence_country = !empty(@$status['residence_country']) ? $mcountries->getCountry($status['residence_country']) : null;
        $STATUS_RESIDENCE_COUNTRY = $residence_country ? safe_strtoupper($residence_country['name']) : $nupdated;

        $residence_region = !empty(@$status['residence_region']) ? $mregions->getRegion($status['residence_region']) : null;
        $STATUS_RESIDENCE_REGION = $residence_region ? safe_strtoupper($residence_region['name']) : $nupdated;

        $residence_city = !empty(@$status['residence_city']) ? $mcities->getCity($status['residence_city']) : null;
        $STATUS_RESIDENCE_CITY = $residence_city ? safe_strtoupper($residence_city['name']) : $nupdated;

        $STATUS_NEIGHBORHOOD = !empty(@$status['neighborhood']) ? safe_strtoupper(@$status['neighborhood']) : $nupdated;
        $STATUS_AREA = !empty(@$status['area']) ? safe_strtoupper(@$status['area']) : $nupdated;
        $STATUS_STRATUM = !empty(@$status['stratum']) ? safe_strtoupper(@$status['stratum']) : $nupdated;

        $STATUS_TRANSPORT_METHOD = !empty(@$status['transport_method']) ? array_reduce(LIST_TRANSPORTS, function ($carry, $item) use ($status) {
            return ($item['value'] == @$status['transport_method']) ? safe_strtoupper(@$item['label']) : $carry;
        }, safe_strtoupper(@$status['transport_method'])) : $nupdated;

        $STATUS_SISBEN_GROUP = !empty(@$status['sisben_group']) ? safe_strtoupper(@$status['sisben_group']) : $nupdated;
        $STATUS_SISBEN_SUBGROUP = !empty(@$status['sisben_subgroup']) ? safe_strtoupper(@$status['sisben_subgroup']) : $nupdated;
        $STATUS_DOCUMENT_ISSUE_PLACE = !empty(@$status['document_issue_place']) ? safe_strtoupper(@$status['document_issue_place']) : $nupdated;
        $STATUS_BLOOD_TYPE = !empty(@$status['blood_type']) ? safe_strtoupper(@$status['blood_type']) : $nupdated;

        $STATUS_MARITAL_STATUS = !empty(@$status['marital_status']) ? array_reduce(LIST_MARITALS, function ($carry, $item) use ($status) {
            return ($item['value'] == @$status['marital_status']) ? safe_strtoupper(@$item['label']) : $carry;
        }, safe_strtoupper(@$status['marital_status'])) : $nupdated;

        $STATUS_NUMBER_CHILDREN = !empty(@$status['number_children']) ? safe_strtoupper(@$status['number_children']) : "0";
        $STATUS_MILITARY_CARD = !empty(@$status['military_card']) ? safe_strtoupper(@$status['military_card']) : $nupdated;
        $STATUS_ARS = !empty(@$status['ars']) ? safe_strtoupper(@$status['ars']) : $nupdated;

        $STATUS_INSURER = !empty(@$status['insurer']) ? array_reduce(LIST_INSURANCES, function ($carry, $item) use ($status) {
            return ($item['value'] == @$status['insurer']) ? safe_strtoupper(@$item['label']) : $carry;
        }, safe_strtoupper(@$status['insurer'])) : $nupdated;


        $STATUS_EPS = !empty(@$status['eps']) ? array_reduce(LIST_EPS, function ($carry, $item) use ($status) {
            return ($item['value'] == @$status['eps']) ? safe_strtoupper(@$item['label']) : $carry;
        }, safe_strtoupper(@$status['eps'])) : $nupdated;

        $STATUS_EDUCATION_LEVEL = !empty(@$status['education_level']) ? array_reduce(LIST_EDUCATION_LEVELS, function ($carry, $item) use ($status) {
            return ($item['value'] == @$status['education_level']) ? safe_strtoupper(@$item['label']) : $carry;
        }, safe_strtoupper(@$status['education_level'])) : $nupdated;

        $STATUS_OCCUPATION = !empty(@$status['occupation']) ? array_reduce(LIST_OCCUPATIONS, function ($carry, $item) use ($status) {
            return ($item['value'] == @$status['occupation']) ? safe_strtoupper(@$item['label']) : $carry;
        }, safe_strtoupper(@$status['occupation'])) : $nupdated;


        $STATUS_HEALTH_REGIME = !empty(@$status['health_regime']) ? safe_strtoupper(@$status['health_regime']) : $nupdated;
        $STATUS_DOCUMENT_ISSUE_DATE = !empty(@$status['document_issue_date']) ? safe_strtoupper(@$status['document_issue_date']) : $nupdated;
        $STATUS_SABER11 = !empty(@$status['saber11']) ? safe_strtoupper(@$status['saber11']) : $nupdated;
        $STATUS_SABER11_VALUE = !empty(@$status['saber11_value']) ? safe_strtoupper(@$status['saber11_value']) : $nupdated;
        $STATUS_SABER11_DATE = !empty(@$status['saber11_date']) ? safe_strtoupper(@$status['saber11_date']) : $nupdated;
        $STATUS_GRADUATION_CERTIFICATE = !empty(@$status['graduation_certificate']) ? safe_strtoupper(@$status['graduation_certificate']) : $nupdated;
        $STATUS_MILITARY_ID = !empty(@$status['military_id']) ? safe_strtoupper(@$status['military_id']) : $nupdated;
        $STATUS_DIPLOMA = !empty(@$status['diploma']) ? safe_strtoupper(@$status['diploma']) : $nupdated;
        $STATUS_ICFES_CERTIFICATE = !empty(@$status['icfes_certificate']) ? safe_strtoupper(@$status['icfes_certificate']) : $nupdated;
        $STATUS_UTILITY_BILL = !empty(@$status['utility_bill']) ? safe_strtoupper(@$status['utility_bill']) : $nupdated;
        $STATUS_SISBEN_CERTIFICATE = !empty(@$status['sisben_certificate']) ? safe_strtoupper(@$status['sisben_certificate']) : $nupdated;
        $STATUS_ADDRESS_CERTIFICATE = !empty(@$status['address_certificate']) ? safe_strtoupper(@$status['address_certificate']) : $nupdated;
        $STATUS_ELECTORAL_CERTIFICATE = !empty(@$status['electoral_certificate']) ? safe_strtoupper(@$status['electoral_certificate']) : $na;

        //$STATUS_PHOTO_CARD = !empty(@$status['photo_card']) ? safe_strtoupper(@$status['photo_card']) : $nupdated;
        //$STATUS_OBSERVATIONS = !empty(@$status['observations']) ? safe_strtoupper(@$status['observations']) : $nupdated;
        //$STATUS_AUTHOR = !empty(@$status['author']) ? safe_strtoupper(@$status['author']) : $nupdated;
        //$STATUS_TICKET = !empty(@$status['ticket']) ? safe_strtoupper(@$status['ticket']) : $nupdated;
        //$STATUS_INTERVIEW = !empty(@$status['interview']) ? safe_strtoupper(@$status['interview']) : $nupdated;

        $STATUS_LINKAGE_TYPE = !empty(@$status['linkage_type']) ? array_reduce(LIST_LINKAGE_TYPES, function ($carry, $item) use ($status) {
            return ($item['value'] == @$status['linkage_type']) ? safe_strtoupper(@$item['label']) : $carry;
        }, safe_strtoupper(@$status['linkage_type'])) : $nupdated;


        $STATUS_ETHNIC_GROUP = !empty(@$status['ethnic_group']) ? array_reduce(LIST_ETHNIC_GROUPS, function ($carry, $item) use ($status) {
            return ($item['value'] == @$status['ethnic_group']) ? safe_strtoupper(@$item['label']) : $carry;
        }, safe_strtoupper(@$status['ethnic_group'])) : "NO PERTENECE";


        //$STATUS_INDIGENOUS_PEOPLE = !empty(@$status['indigenous_people']) ? safe_strtoupper(@$status['indigenous_people']) : $nupdated;
        //$STATUS_AFRO_DESCENDANT = !empty(@$status['afro_descendant']) ? safe_strtoupper(@$status['afro_descendant']) : $nupdated;

        $STATUS_DISABILITY = !empty(@$status['disability']) ? safe_strtoupper(@$status['disability']) : $nupdated;

        $STATUS_DISABILITY_TYPE = !empty(@$status['disability_type']) ? array_reduce(LIST_TYPES_OF_DISABILITIES, function ($carry, $item) use ($status) {
            return ($item['value'] == @$status['disability_type']) ? safe_strtoupper(@$item['label']) : $carry;
        }, safe_strtoupper(@$status['disability_type'])) : $nupdated;
        $STATUS_EXCEPTIONAL_ABILITY = !empty(@$status['exceptional_ability']) ? safe_strtoupper(@$status['exceptional_ability']) : $nupdated;

        $STATUS_RESPONSIBLE = !empty(@$status['responsible']) ? safe_strtoupper(@$status['responsible']) : $na;

        $STATUS_RESPONSIBLE_RELATIONSHIP = !empty(@$status['responsible_relationship']) ? array_reduce(LIST_RESPONSIBLE_RELATIONSHIP, function ($carry, $item) use ($status) {
            return ($item['value'] == @$status['responsible_relationship']) ? safe_strtoupper(@$item['label']) : $carry;
        }, safe_strtoupper(@$status['responsible_relationship'])) : $na;

        $STATUS_IDENTIFIED_POPULATION_GROUP = !empty(@$status['identified_population_group']) ? array_reduce(LIST_IDENTIFIED_POPULATION_GROUP, function ($carry, $item) use ($status) {
            return ($item['value'] == @$status['identified_population_group']) ? safe_strtoupper(@$item['label']) : $carry;
        }, safe_strtoupper(@$status['identified_population_group'])) : $nupdated;

        $STATUS_HIGHLIGHTED_POPULATION = !empty(@$status['highlighted_population']) ? array_reduce(LIST_HIGHLIGHTED_POPULATION, function ($carry, $item) use ($status) {
            return ($item['value'] == @$status['highlighted_population']) ? safe_strtoupper(@$item['label']) : $carry;
        }, safe_strtoupper(@$status['highlighted_population'])) : $nupdated;

        $STATUS_RESPONSIBLE_PHONE = !empty(@$status['responsible_phone']) ? safe_strtoupper(@$status['responsible_phone']) : $nupdated;
        $STATUS_BORDER_POPULATION = !empty(@$status['border_population']) ? safe_strtoupper(@$status['border_population']) : $nupdated;
        $STATUS_OBSERVATIONS_ACADEMIC = !empty(@$status['observations_academic']) ? safe_strtoupper(@$status['observations_academic']) : $nupdated;
        $STATUS_IMPORT = !empty(@$status['import']) ? safe_strtoupper(@$status['import']) : $nupdated;
        $STATUS_MOMENT = !empty(@$status['moment']) ? safe_strtoupper(@$status['moment']) : $nupdated;
        $STATUS_SNIES_UPDATED_AT = !empty(@$status['snies_updated_at']) ? safe_strtoupper(@$status['snies_updated_at']) : $nupdated;
        $STATUS_PHOTO = !empty(@$status['photo']) ? safe_strtoupper(@$status['photo']) : $nupdated;
        $STATUS_COLLEGE = !empty(@$status['college']) ? safe_strtoupper(@$status['college']) : $nupdated;
        $STATUS_COLLEGE_YEAR = !empty(@$status['college_year']) ? safe_strtoupper(@$status['college_year']) : $nupdated;
        $STATUS_AC = !empty(@$status['ac']) ? safe_strtoupper(@$status['ac']) : $nupdated;
        $STATUS_AC_SCORE = !empty(@$status['ac_score']) ? safe_strtoupper(@$status['ac_score']) : $nupdated;
        $STATUS_AC_DATE = !empty(@$status['ac_date']) ? safe_strtoupper(@$status['ac_date']) : $nupdated;
        $STATUS_AC_DOCUMENT_TYPE = !empty(@$status['ac_document_type']) ? safe_strtoupper(@$status['ac_document_type']) : $nupdated;
        $STATUS_AC_DOCUMENT_NUMBER = !empty(@$status['ac_document_number']) ? safe_strtoupper(@$status['ac_document_number']) : $nupdated;
        $STATUS_EK = !empty(@$status['ek']) ? safe_strtoupper(@$status['ek']) : $nupdated;
        $STATUS_EK_SCORE = !empty(@$status['ek_score']) ? safe_strtoupper(@$status['ek_score']) : $nupdated;
        $STATUS_SNIES_ID_VALIDATION_REQUISITE = !empty(@$status['snies_id_validation_requisite']) ? safe_strtoupper(@$status['snies_id_validation_requisite']) : $nupdated;
        $STATUS_CREATED_AT = !empty(@$status['created_at']) ? safe_strtoupper(@$status['created_at']) : $nupdated;
        $STATUS_UPDATED_AT = !empty(@$status['updated_at']) ? safe_strtoupper(@$status['updated_at']) : $nupdated;
        $STATUS_DELETED_AT = !empty(@$status['deleted_at']) ? safe_strtoupper(@$status['deleted_at']) : $nupdated;
        $STATUS_NUM_PEOPLE_LIVING_WITH_YOU = !empty(@$status['num_people_living_with_you']) ? safe_strtoupper(@$status['num_people_living_with_you']) : $nupdated;
        $STATUS_NUM_PEOPLE_CONTRIBUTING_ECONOMICALLY = !empty(@$status['num_people_contributing_economically']) ? safe_strtoupper(@$status['num_people_contributing_economically']) : $nupdated;
        $STATUS_NUM_PEOPLE_DEPENDING_ON_YOU = !empty(@$status['num_people_depending_on_you']) ? safe_strtoupper(@$status['num_people_depending_on_you']) : $nupdated;

        $STATUS_EDUCATION_LEVEL_FATHER = !empty(@$status['education_level_father']) ? array_reduce(LIST_PARENTS_EDUCATION_LEVELS, function ($carry, $item) use ($status) {
            return ($item['value'] == @$status['education_level_father']) ? safe_strtoupper(@$item['label']) : $carry;
        }, safe_strtoupper(@$status['education_level_father'])) : $nupdated;

        $STATUS_EDUCATION_LEVEL_MOTHER = !empty(@$status['education_level_mother']) ? array_reduce(LIST_PARENTS_EDUCATION_LEVELS, function ($carry, $item) use ($status) {
            return ($item['value'] == @$status['education_level_mother']) ? safe_strtoupper(@$item['label']) : $carry;
        }, safe_strtoupper(@$status['education_level_mother'])) : $nupdated;

        $STATUS_TYPE_OF_HOUSING = !empty(@$status['type_of_housing']) ? array_reduce(LIST_HOUSING_TYPE, function ($carry, $item) use ($status) {
            return ($item['value'] == @$status['type_of_housing']) ? safe_strtoupper(@$item['label']) : $carry;
        }, safe_strtoupper(@$status['type_of_housing'])) : $nupdated;

        $STATUS_ECONOMIC_DEPENDENCY = !empty(@$status['economic_dependency']) ? array_reduce(LIST_DEPENDENCY_ECONOMIC, function ($carry, $item) use ($status) {
            return ($item['value'] == @$status['economic_dependency']) ? safe_strtoupper(@$item['label']) : $carry;
        }, safe_strtoupper(@$status['economic_dependency'])) : $nupdated;

        $STATUS_TYPE_OF_FUNDING = !empty(@$status['type_of_funding']) ? array_reduce(LIST_FUNDING, function ($carry, $item) use ($status) {
            return ($item['value'] == @$status['type_of_funding']) ? safe_strtoupper(@$item['label']) : $carry;
        }, safe_strtoupper(@$status['type_of_funding'])) : $nupdated;

        $STATUS_CURRENT_OCCUPATION = !empty(@$status['current_occupation']) ? array_reduce(LIST_CURRENT_OCCUPATIONS, function ($carry, $item) use ($status) {
            return ($item['value'] == @$status['current_occupation']) ? safe_strtoupper(@$item['label']) : $carry;
        }, safe_strtoupper(@$status['current_occupation'])) : $nupdated;

        $STATUS_TYPE_OF_WORK = !empty(@$status['type_of_work']) ? array_reduce(LIST_WORK_TYPES, function ($carry, $item) use ($status) {
            return ($item['value'] == @$status['type_of_work']) ? safe_strtoupper(@$item['label']) : $carry;
        }, safe_strtoupper(@$status['type_of_work'])) : $nupdated;


        $STATUS_WEEKLY_HOURS_WORKED = !empty(@$status['weekly_hours_worked']) ? array_reduce(LIST_HOURS_WORK, function ($carry, $item) use ($status) {
            return ($item['value'] == @$status['weekly_hours_worked']) ? safe_strtoupper(@$item['label']) : $carry;
        }, safe_strtoupper(@$status['weekly_hours_worked'])) : $nupdated;

        $STATUS_MONTHLY_INCOME = !empty(@$status['monthly_income']) ? array_reduce(LIST_MONTHLY_INCOMES, function ($carry, $item) use ($status) {
            return ($item['value'] == @$status['monthly_income']) ? safe_strtoupper(@$item['label']) : $carry;
        }, safe_strtoupper(@$status['monthly_income'])) : $nupdated;

        $STATUS_COMPANY_NAME = !empty(@$status['company_name']) ? safe_strtoupper(@$status['company_name']) : $nupdated;

        $STATUS_COMPANY_POSITION = !empty(@$status['company_position']) ? array_reduce(LIST_JOB_POSITIONS, function ($carry, $item) use ($status) {
            return ($item['value'] == @$status['company_position']) ? safe_strtoupper(@$item['label']) : $carry;
        }, safe_strtoupper(@$status['company_position'])) : $nupdated;

        $STATUS_PRODUCTIVE_SECTOR = !empty(@$status['productive_sector']) ? array_reduce(LIST_PRODUCTIVE_SECTORS, function ($carry, $item) use ($status) {
            return ($item['value'] == @$status['productive_sector']) ? safe_strtoupper(@$item['label']) : $carry;
        }, safe_strtoupper(@$status['productive_sector'])) : $nupdated;

        $STATUS_FIRST_IN_FAMILY_TO_STUDY_UNIVERSITY = !empty(@$status['first_in_family_to_study_university']) ? array_reduce(LIST_YN, function ($carry, $item) use ($status) {
            return ($item['value'] == @$status['first_in_family_to_study_university']) ? safe_strtoupper(@$item['label']) : $carry;
        }, safe_strtoupper(@$status['first_in_family_to_study_university'])) : $nupdated;

        $STATUS_MOODLE_STUDENT_ID = !empty(@$status['moodle_student_id']) ? safe_strtoupper(@$status['moodle_student_id']) : $nupdated;

        //[build]-----------------------------------------------------------------------------------------------------------
        $code .= "<tr class=\"{$class}\">";
        $code .= "<td><a href=\"/sie/students/view/{$STATUS_REGISTRATION}\" target='\_blank\"'>{$count}</a></td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_PERIOD}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_STUDENT}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_STATUS}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_IDENTIFICATION_TYPE}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_IDENTIFICATION_NUMBER}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_AGREEMENT}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_AGREEMENT_COUNTRY}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_AGREEMENT_REGION}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_AGREEMENT_CITY}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_AGREEMENT_INSTITUTION}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_AGREEMENT_GROUP}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_CAMPUS}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_SHIFTS}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_GROUP}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_PERIOD}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_JOURNEY}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_PROGRAM}</td>";
        $code .= "<td class='text-left text-nowrap'>{$STATUS_FIRST_NAME}</td>";
        $code .= "<td class='text-left text-nowrap'>{$STATUS_SECOND_NAME}</td>";
        $code .= "<td class='text-left text-nowrap'>{$STATUS_FIRST_SURNAME}</td>";
        $code .= "<td class='text-left text-nowrap'>{$STATUS_SECOND_SURNAME}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_IDENTIFICATION_TYPE}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_IDENTIFICATION_NUMBER}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_IDENTIFICATION_PLACE}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_IDENTIFICATION_DATE}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_IDENTIFICATION_COUNTRY}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_IDENTIFICATION_REGION}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_IDENTIFICATION_CITY}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_GENDER}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_EMAIL_ADDRESS}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_EMAIL_INSTITUTIONAL}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_PHONE}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_MOBILE}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_BIRTH_DATE}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_BIRTH_COUNTRY}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_BIRTH_REGION}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_BIRTH_CITY}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_ADDRESS}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_RESIDENCE_COUNTRY}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_RESIDENCE_REGION}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_RESIDENCE_CITY}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_NEIGHBORHOOD}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_AREA}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_STRATUM}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_TRANSPORT_METHOD}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_SISBEN_GROUP}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_SISBEN_SUBGROUP}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_DOCUMENT_ISSUE_PLACE}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_BLOOD_TYPE}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_MARITAL_STATUS}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_NUMBER_CHILDREN}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_MILITARY_CARD}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_ARS}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_INSURER}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_EPS}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_EDUCATION_LEVEL}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_OCCUPATION}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_HEALTH_REGIME}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_DOCUMENT_ISSUE_DATE}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_SABER11}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_SABER11_VALUE}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_SABER11_DATE}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_GRADUATION_CERTIFICATE}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_MILITARY_ID}</td>";
        //$code .= "<td class='text-center text-nowrap'>{$STATUS_DIPLOMA}</td>";
        //$code .= "<td class='text-center text-nowrap'>{$STATUS_ICFES_CERTIFICATE}</td>";
        //$code .= "<td class='text-center text-nowrap'>{$STATUS_UTILITY_BILL}</td>";
        //$code .= "<td class='text-center text-nowrap'>{$STATUS_SISBEN_CERTIFICATE}</td>";
        //$code .= "<td class='text-center text-nowrap'>{$STATUS_ADDRESS_CERTIFICATE}</td>";
        //$code .= "<td class='text-center text-nowrap'>{$STATUS_ELECTORAL_CERTIFICATE}</td>";
        //$code .= "<td class='text-center text-nowrap'>{$STATUS_PHOTO_CARD}</td>";
        //$code .= "<td class='text-center text-nowrap'>{$STATUS_OBSERVATIONS}</td>";
        //$code .= "<td class='text-center text-nowrap'>{$STATUS_AUTHOR}</td>";
        //$code .= "<td class='text-center text-nowrap'>{$STATUS_TICKET}</td>";
        //$code .= "<td class='text-center text-nowrap'>{$STATUS_INTERVIEW}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_LINKAGE_TYPE}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_ETHNIC_GROUP}</td>";
        //$code .= "<td class='text-center text-nowrap'>{$STATUS_INDIGENOUS_PEOPLE}</td>";
        //$code .= "<td class='text-center text-nowrap'>{$STATUS_AFRO_DESCENDANT}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_DISABILITY}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_DISABILITY_TYPE}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_EXCEPTIONAL_ABILITY}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_RESPONSIBLE}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_RESPONSIBLE_RELATIONSHIP}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_IDENTIFIED_POPULATION_GROUP}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_HIGHLIGHTED_POPULATION}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_RESPONSIBLE_PHONE}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_BORDER_POPULATION}</td>";
        //$code .= "<td class='text-center text-nowrap'>{$STATUS_OBSERVATIONS_ACADEMIC}</td>";
        //$code .= "<td class='text-center text-nowrap'>{$STATUS_IMPORT}</td>";
        //$code .= "<td class='text-center text-nowrap'>{$STATUS_MOMENT}</td>";
        //$code .= "<td class='text-center text-nowrap'>{$STATUS_SNIES_UPDATED_AT}</td>";
        //$code .= "<td class='text-center text-nowrap'>{$STATUS_PHOTO}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_COLLEGE}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_COLLEGE_YEAR}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_AC}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_AC_SCORE}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_AC_DATE}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_AC_DOCUMENT_TYPE}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_AC_DOCUMENT_NUMBER}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_EK}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_EK_SCORE}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_SNIES_ID_VALIDATION_REQUISITE}</td>";
        //$code .= "<td class='text-center text-nowrap'>{$STATUS_CREATED_AT}</td>";
        //$code .= "<td class='text-center text-nowrap'>{$STATUS_UPDATED_AT}</td>";
        //$code .= "<td class='text-center text-nowrap'>{$STATUS_DELETED_AT}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_NUM_PEOPLE_LIVING_WITH_YOU}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_NUM_PEOPLE_CONTRIBUTING_ECONOMICALLY}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_NUM_PEOPLE_DEPENDING_ON_YOU}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_EDUCATION_LEVEL_FATHER}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_EDUCATION_LEVEL_MOTHER}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_TYPE_OF_HOUSING}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_ECONOMIC_DEPENDENCY}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_TYPE_OF_FUNDING}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_CURRENT_OCCUPATION}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_TYPE_OF_WORK}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_WEEKLY_HOURS_WORKED}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_MONTHLY_INCOME}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_COMPANY_NAME}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_COMPANY_POSITION}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_PRODUCTIVE_SECTOR}</td>";
        $code .= "<td class='text-center text-nowrap'>{$STATUS_FIRST_IN_FAMILY_TO_STUDY_UNIVERSITY}</td>";
        //$code .= "<td class='text-center text-nowrap'>{$STATUS_MOODLE_STUDENT_ID}</td>";
        $code .= "</tr>";
    }
}
$code .= "</table>";
echo $code;
?>