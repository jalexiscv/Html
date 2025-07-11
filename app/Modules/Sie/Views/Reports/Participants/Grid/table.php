<?php
/** @var int $page viene de grid.php */
/** @var model $mexecutions */
/** @var model $mprogress */


/**
ID_TIPO_DOCUMENTO
NUM_DOCUMENTO
FECHA_EXPEDICION
PRIMER_NOMBRE
SEGUNDO_NOMBRE
PRIMER_APELLIDO
SEGUNDO_APELLIDO
ID_SEXO_BIOLOGICO
ID_ESTADO_CIVIL
FECHA_NACIMIENTO
ID_PAIS
ID_MUNICIPIO
TELEFONO_CONTACTO
EMAIL_PERSONAL
EMAIL_INSTITUCIONAL
DIRECCION_INSTITUCIONAL
 **/
$request = service('request');

$option=$request->getVar("option");


$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 1000;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";

$musers = model('App\Modules\Sie\Models\Sie_Users');
$rows = $musers->get_ListByType($limit, $offset, "TEACHER", $search);
$totalRecords = $musers->get_TotalByType("TEACHER", $search);

$code = "";
$code .= " <table\n";
$code .= "\t\t id=\"grid-table\"\n";
$code .= "\t\t class=\"table table-striped table-hover\" \n ";
$code .= "\t\t border=\"1\">\n";
$code .= "<thead>";
$code .= "<tr>\n";
$code .= "<th class='text-center ' title=\"\">#</th>\n";
$code .= "<th class='text-center' title=\"\">ID_TIPO_DOCUMENTO</th>\n";
$code .= "<th class='text-center' title=\"\">NUM_DOCUMENTO</th>\n";
$code .= "<th class='text-center' title=\"\">FECHA_EXPEDICION</th>\n";
$code .= "<th class='text-center' title=\"\">PRIMER_NOMBRE</th>\n";
$code .= "<th class='text-center' title=\"\">SEGUNDO_NOMBRE</th>\n";
$code .= "<th class='text-center' title=\"\">PRIMER_APELLIDO</th>\n";
$code .= "<th class='text-center' title=\"\">SEGUNDO_APELLIDO</th>\n";
$code .= "<th class='text-center' title=\"\">ID_SEXO_BIOLOGICO</th>\n";
$code .= "<th class='text-center' title=\"\">ID_ESTADO_CIVIL</th>\n";
$code .= "<th class='text-center' title=\"\">FECHA_NACIMIENTO</th>\n";
$code .= "<th class='text-center' title=\"\">ID_PAIS</th>\n";
$code .= "<th class='text-center' title=\"\">ID_MUNICIPIO</th>\n";
$code .= "<th class='text-center' title=\"\">TELEFONO_CONTACTO</th>\n";
$code .= "<th class='text-center' title=\"\">EMAIL_PERSONAL</th>\n";
$code .= "<th class='text-center' title=\"\">EMAIL_INSTITUCIONAL</th>\n";
$code .= "<th class='text-center' title=\"\">DIRECCION_INSTITUCIONAL</th>\n";

//$code .= "<th class='text-center' title=\"\">SHOW</th>\n";
//$code .= "<th class='text-center' title=\"\">TEACHER</th>\n";
//$code .= "<th class='text-center' title=\"\">EXECUTIVE</th>\n";
//$code .= "<th class='text-center' title=\"\">AUTHORITY</th>\n";

$code .= "</tr>\n";
$code .= "</thead>";

$count=0;
foreach ($rows as $row) {
    $count++;
    $show="N";

    if(!empty($option)) {
        if ($option == "teachers") {
            $show = $row["participant_teacher"];
        } elseif ($option == "executives") {
            $show = $row["participant_executive"];
        }elseif ($option == "authorities") {
            $show =$row["participant_authority"];
        }
    }

    if($show=="Y") {
        $names = explode(" ", @$row["firstname"]);
        $surnames = explode(" ", @$row["lastname"]);

        $ID_TIPO_DOCUMENTO = "CC";
        $NUM_DOCUMENTO = @$row["citizenshipcard"];
        $FECHA_EXPEDICION = @$row["expedition_date"];
        $PRIMER_NOMBRE = safe_strtoupper(@$names[0]);
        $SEGUNDO_NOMBRE = safe_strtoupper(@$names[1]);
        $PRIMER_APELLIDO = safe_strtoupper(@$surnames[0]);
        $SEGUNDO_APELLIDO = safe_strtoupper(@$surnames[1]);
        $ID_SEXO_BIOLOGICO = @$row["gender"];
        $ID_ESTADO_CIVIL = @$row["marital_status"];
        $FECHA_NACIMIENTO = @$row["birthday"];
        $ID_PAIS = @$row["birth_country"];
        $ID_REGION = @$row["birth_region"];
        $ID_MUNICIPIO = @$row["birth_city"];
        $TELEFONO_CONTACTO = @$row["phone"];

        $EMAIL_PERSONAL =safe_strtoupper( @$row["email_personal"]);
        $EMAIL_INSTITUCIONAL = safe_strtoupper(@$row["email"]);

        $DIRECCION_INSTITUCIONAL = safe_strtoupper(@$row["institutional_address"]);

        $link = "<a href=\"/sie/teachers/edit/{$row["user"]}\" target=\"_blank\">{$NUM_DOCUMENTO}</a>";

        $code .= "<tr>\n";
        $code .= "<td class='text-center'>{$count}</td>\n";
        $code .= "<td class='text-center'>{$ID_TIPO_DOCUMENTO}</td>\n";
        $code .= "<td class='text-start'>{$link}</td>\n";
        $code .= "<td class='text-center'>{$FECHA_EXPEDICION}</td>\n";
        $code .= "<td class='text-start'>{$PRIMER_NOMBRE}</td>\n";
        $code .= "<td class='text-start'>{$SEGUNDO_NOMBRE}</td>\n";
        $code .= "<td class='text-start'>{$PRIMER_APELLIDO}</td>\n";
        $code .= "<td class='text-start'>{$SEGUNDO_APELLIDO}</td>\n";
        $code .= "<td class='text-left'>{$ID_SEXO_BIOLOGICO}</td>\n";
        $code .= "<td class='text-left'>{$ID_ESTADO_CIVIL}</td>\n";
        $code .= "<td class='text-left'>{$FECHA_NACIMIENTO}</td>\n";
        $code .= "<td class='text-left'>{$ID_PAIS}</td>\n";
        $code .= "<td class='text-left'>{$ID_MUNICIPIO}</td>\n";
        $code .= "<td class='text-left'>{$TELEFONO_CONTACTO}</td>\n";
        $code .= "<td class='text-left'>{$EMAIL_PERSONAL}</td>\n";
        $code .= "<td class='text-left'>{$EMAIL_INSTITUCIONAL}</td>\n";
        $code .= "<td class='text-left'>{$DIRECCION_INSTITUCIONAL}</td>\n";

        //$code .= "<td class='text-center'>{$show}</td>\n";
        //$code .= "<td class='text-center'>{$row["participant_teacher"]}</td>\n";
        //$code .= "<td class='text-center'>{$row["participant_executive"]}</td>\n";
        //$code .= "<td class='text-center'>{$row["participant_authority"]}</td>\n";
        $code .= "</tr>\n";
    }
}

$count = ($page - 1) * $limit;
$code .= "</table>";
echo($code);
?>