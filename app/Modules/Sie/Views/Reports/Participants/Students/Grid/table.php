<?php
/** @var int $page viene de grid.php */
/** @var model $mexecutions */
/** @var model $mprogress */

//[models]--------------------------------------------------------------------------------------------------------------
$mstatuses = model('App\Modules\Sie\Models\Sie_Statuses');
$mdiscounteds = model('App\Modules\Sie\Models\Sie_Discounteds');
$mdiscounts = model('App\Modules\Sie\Models\Sie_Discounts');
$mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');
$mprograms = model('App\Modules\Sie\Models\Sie_Programs');
$magreements = model('App\Modules\Sie\Models\Sie_Agreements');
//[vars]----------------------------------------------------------------------------------------------------------------

$request = service('request');

$period = $_GET['period'];

$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 1000;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";

$statuses = $mstatuses
    ->where("period", $period)
    ->whereIn("reference", ["ENROLLED", "ENROLLED-OLD"])
    ->whereIn("cycle", [1, 5, 7])
    ->find();

$totalRecords = 1000;

$code = "";
$code .= " <table\n";
$code .= "\t\t id=\"grid-table\"\n";
$code .= "\t\t class=\"table table-striped table-hover\" \n ";
$code .= "\t\t border=\"1\">\n";
$code .= "<thead>";
$code .= "<tr>\n";
$code .= "<th class='text-center text-nowrap ' title=\"\">#</th>\n";
$code .= "<th class='text-center text-nowrap' title=\"\">ID_TIPO_DOCUMENTO</th>\n";
$code .= "<th class='text-center text-nowrap' title=\"\">NUM_DOCUMENTO</th>\n";
$code .= "<th class='text-center text-nowrap' title=\"\">FECHA_EXPEDICION</th>\n";
$code .= "<th class='text-center text-nowrap' title=\"\">PRIMER_NOMBRE</th>\n";
$code .= "<th class='text-center text-nowrap' title=\"\">SEGUNDO_NOMBRE</th>\n";
$code .= "<th class='text-center text-nowrap' title=\"\">PRIMER_APELLIDO</th>\n";
$code .= "<th class='text-center text-nowrap' title=\"\">SEGUNDO_APELLIDO</th>\n";
$code .= "<th class='text-center text-nowrap' title=\"\">ID_SEXO_BIOLOGICO</th>\n";
$code .= "<th class='text-center text-nowrap' title=\"\">ID_ESTADO_CIVIL</th>\n";
$code .= "<th class='text-center text-nowrap' title=\"\">FECHA_NACIMIENTO</th>\n";
$code .= "<th class='text-center text-nowrap' title=\"\">ID_PAIS</th>\n";
$code .= "<th class='text-center text-nowrap' title=\"\">ID_MUNICIPIO</th>\n";
$code .= "<th class='text-center text-nowrap' title=\"\">TELEFONO_CONTACTO</th>\n";
$code .= "<th class='text-center text-nowrap' title=\"\">EMAIL_PERSONAL</th>\n";
$code .= "<th class='text-center text-nowrap' title=\"\">EMAIL_INSTITUCIONAL</th>\n";
$code .= "<th class='text-center text-nowrap' title=\"\">DIRECCION_INSTITUCIONAL</th>\n";
$code .= "<th class='text-center text-nowrap' title=\"\">PERIODO</th>\n";
$code .= "<th class='text-center text-nowrap' title=\"\">ESTADO</th>\n";
$code .= "<th class='text-center text-nowrap' title=\"\">CICLO</th>\n";
$code .= "</tr>\n";
$code .= "</thead>";
$code .= "<tbody>";

$count = 0;
foreach ($statuses as $status) {
    $count++;
    $registration = $mregistrations->get_CachedRegistration($status["registration"]);
    $ID_TIPO_DOCUMENTO = $registration["identification_type"];
    $NUM_DOCUMENTO = $registration["identification_number"];
    $FECHA_EXPEDICION = $registration["identification_date"];
    $PRIMER_NOMBRE = safe_strtoupper(@$registration["first_name"]);
    $SEGUNDO_NOMBRE = safe_strtoupper(@$registration["second_name"]);
    $PRIMER_APELLIDO = safe_strtoupper(@$registration["first_surname"]);
    $SEGUNDO_APELLIDO = safe_strtoupper(@$registration["second_surname"]);
    $ID_SEXO_BIOLOGICO = @$registration["gender"];
    $ID_ESTADO_CIVIL = @$registration["marital_status"];
    $FECHA_NACIMIENTO = @$registration["birth_date"];
    $ID_PAIS = @$registration["birth_country"];
    $ID_REGION = @$registration["birth_region"];
    $ID_MUNICIPIO = @$registration["birth_city"];
    $TELEFONO_CONTACTO = @$registration["phone"];
    $EMAIL_PERSONAL = safe_strtoupper(@$registration["email_address"]);
    $EMAIL_INSTITUCIONAL = safe_strtoupper(@$registration["email_institutional"]);
    $DIRECCION_INSTITUCIONAL = safe_strtoupper(@$registration["institutional_address"]);
    $DIRECCION_INSTITUCIONAL = empty($DIRECCION_INSTITUCIONAL) ? "CARRERA 12 # 26 C 74, BUGA – VALLE DEL CAUCA." : "";

    $code .= "<tr>\n";
    $code .= "<td class='text-center text-nowrap'>{$count}</td>\n";
    $code .= "<td class='text-center text-nowrap'>{$ID_TIPO_DOCUMENTO}</td>\n";
    $code .= "<td class='text-center text-nowrap'>{$NUM_DOCUMENTO}</td>\n";
    $code .= "<td class='text-center text-nowrap'>{$FECHA_EXPEDICION}</td>\n";
    $code .= "<td class='text-center text-nowrap'>{$PRIMER_NOMBRE}</td>\n";
    $code .= "<td class='text-center text-nowrap'>{$SEGUNDO_NOMBRE}</td>\n";
    $code .= "<td class='text-center text-nowrap'>{$PRIMER_APELLIDO}</td>\n";
    $code .= "<td class='text-center text-nowrap'>{$SEGUNDO_APELLIDO}</td>\n";
    $code .= "<td class='text-center text-nowrap'>{$ID_SEXO_BIOLOGICO}</td>\n";
    $code .= "<td class='text-center text-nowrap'>{$ID_ESTADO_CIVIL}</td>\n";
    $code .= "<td class='text-center text-nowrap'>{$FECHA_NACIMIENTO}</td>\n";
    $code .= "<td class='text-center text-nowrap'>{$ID_PAIS}</td>\n";
    $code .= "<td class='text-center text-nowrap'>{$ID_MUNICIPIO}</td>\n";
    $code .= "<td class='text-center text-nowrap'>{$TELEFONO_CONTACTO}</td>\n";
    $code .= "<td class='text-center text-nowrap'>{$EMAIL_PERSONAL}</td>\n";
    $code .= "<td class='text-center text-nowrap'>{$EMAIL_INSTITUCIONAL}</td>\n";
    $code .= "<td class='text-center text-nowrap'>{$DIRECCION_INSTITUCIONAL}</td>\n";
    $code .= "<td class='text-center text-nowrap'>{$status["period"]}</td>\n";
    $code .= "<td class='text-center text-nowrap'>{$status["reference"]}</td>\n";
    $code .= "<td class='text-center text-nowrap'>{$status["cycle"]}</td>\n";

    $code .= "</tr>\n";
}

$code .= "</tbody>";

$count = ($page - 1) * $limit;
$code .= "</table>";
echo($code);
?>