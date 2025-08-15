<?php
define('DOCUMENT_TITLE', 'Certificado Académico');
define('INSTITUTION_NAME', 'Unidad Técnica para el Desarrollo Profesional');

//Headers para documento Word
header("Content-Type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=certificado_academico.doc");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Pragma: public");

function getStyles()
{
    return '<style>
        body { font-family: Arial, sans-serif; font-size: 12pt; line-height: 1.4; margin: 0; text-align: justify; }
        .consecutivo { text-align: right; font-size: 10pt; margin-bottom: 20px; }
        .certificacion { font-weight: bold; font-size: 12pt; margin-bottom: 20px; text-align: center }
        .contenido { text-align: justify; margin-bottom: 20px; }

        .info-contacto { font-size: 10pt; margin-top: 20px; }
        .fecha-expedicion { font-size: 10pt; text-align: right; margin-top: 20px; }
        
        .header { position: relative; margin-bottom: 20px; min-height: 100px; padding: 10px; }
        .header-logo { 
            position: absolute; 
            left: 0; 
            top: 50%; 
            transform: translateY(-50%);
            width: auto; 
            height: 100px; 
            display: flex; 
            align-items: center; 
        }
        .header-logo img { 
            height: 100px !important; /* Fuerza la altura exacta */
            width: auto; /* Mantiene la proporción */
            display: block; /* Elimina espacio extra debajo de la imagen */
        }
        .header-text { 
            text-align: center; 
            margin-left: 220px; 
            padding-top: 10px; 
        }
        
        .header h1{font-weight: bold;font-size: 10pt;margin: 0px;}        
        .header p{font-size: 10pt;margin: 0px;}
                
        .codigo-info { text-align: right; font-size: 10pt; margin-bottom: 40px; }
        .codigo-info p{ font-size: 10pt;margin: 0px;}  

 
         .firma { margin-top: 120px; text-align: center; margin-bottom: 0px;}
         .firma p{margin: 0px;} 

        
    </style>';
}

function obtenerFechaEspanol()
{
    $meses = array(
        "enero", "febrero", "marzo", "abril", "mayo", "junio",
        "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"
    );

    $dia = date('j');
    $mes = $meses[date('n') - 1];
    $anio = date('Y');

    return "$dia de $mes de $anio";
}

function obtenerPeriodoAcademico()
{
    $anio = date('Y');
    $mes = (int)date('n');
    $semestre = ($mes >= 7) ? 'B' : 'A';
    return $anio . '-' . $semestre;
}

$mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');
$menrollments = model("App\Modules\Sie\Models\Sie_Enrollments");
$mprogram = model("App\Modules\Sie\Models\Sie_Programs");
$mstatuses = model('App\Modules\Sie\Models\Sie_Statuses');

$enrollment = $menrollments->get_Enrollment($oid);
$registration = $mregistrations->get_Registration($enrollment["student"]);
$status = $mstatuses->get_LastStatusByRegistrationByProgram($registration["registration"], $enrollment["program"]);

$program = $mprogram->getProgram($enrollment["program"]);


//echo($oid);
//print_r($enrollment);

$journey_map = array_column(LIST_JOURNEYS, 'label', 'value');
$journey_label = $journey_map[$status["journey"]] ?? $status["journey"];

$datos = [
    'nit' => '800124023-4',
    'consecutivo' => '0000',
    'financiero' => '0000000',
    'nombre_estudiante' => @$registration['first_name'] . " " . @$registration['second_name'] . " " . @$registration['first_surname'] . " " . @$registration['second_surname'],
    'documento' => @$registration["identification_number"],
    'ciclo' => $status["cycle"],
    'programa' => $program["name"],
    'resolucion' => '19873',
    'fecha_resolucion' => "18 de octubre de 2016",
    'metodologia' => 'presencial',
    'horas_semanales' => '40',
    'periodo' => $status["period"],
    'jornada' => $journey_label,
    'fecha_certificacion' => obtenerFechaEspanol(),
    'funcionario' => 'Leydi Jhoanna Jojoa Benavides',
    'cargo' => 'Profesional Especializado',
    'oficina' => 'Oficina Control y Registro Académico',
    'email' => 'registro_academico@utede.edu.co',
    'telefono' => '3896023'
];

$code = '<!DOCTYPE html><html><head><meta charset="UTF-8">';
$code .= '<title>' . DOCUMENT_TITLE . '</title>';
$code .= getStyles();
$code .= '</head>';
$code .= "<body>\n";

$code .= '<table class="header">';
$code .= '    <tr>';
$code .= '        <td>';
$code .= '            <img src="https://intranet.utede.edu.co/themes/assets/images/logo-utede-160x50.png" alt="Logo">';
$code .= '        </td>';
$code .= '        <td>';
$code .= "            <p>NIT {$datos['nit']}</p>";
$code .= '            <h1>Unidad Técnica para el Desarrollo Profesional</h1>';
$code .= '            <p>Institución de Educación Superior</p>';
$code .= '            <p>Reconocida por la Ley 30 de 1992 con Código SNIES 4107</p>';
$code .= '        </td>';
$code .= '    </tr>';
$code .= '</table>';

$code .= "\t\t\t\t<div class=\"codigo-info\">";
$code .= "\t\t\t\t\t\t<p><strong>CERTIFICACIONES REGISTRO ACADEMICO</strong></p>";
$code .= "\t\t\t\t\t\t<p>Código: FOR-RYC-012 Versión: 1</p>";
$code .= "\t\t\t\t\t\t<p>Fecha Versión: 04/07/2019</p>";
$code .= "\t\t\t\t\t\t<p>Consecutivo No. {$datos['consecutivo']}  Financiero No.{$datos['financiero']}</p>\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t\t\t\n";
$code .= "\t\t\t\t\n";
$code .= "\t\t\t\t<div class=\"certificacion\">\n";
$code .= "\t\t\t\t\t\t <p>&nbsp;</p>\n";
$code .= "\t\t\t\t\t\t <p><strong>C E R T I F I C A &nbsp;&nbsp; Q U E</strong></p>\n";

$code .= "\t\t\t\t</div>";
$code .= "\t\t\t\t\n";
$code .= "\t\t\t\t\n";
$code .= "\t\t\t\t<div class=\"contenido\">\n";
$code .= "\t\t\t\t\t\t<p>El (la) estudiante <strong>{$datos['nombre_estudiante']}</strong> identificado con documento";
$code .= "<strong> C.C {$datos['documento'] }</strong> se encuentra matriculada y cursando el <strong>{$datos['ciclo']} ";
$code .= "Ciclo (semestre)</strong> del programa <strong>{$datos['programa']}</strong>, Registro Calificado según ";
$code .= "Resolución No. <strong>{$datos['resolucion']}</strong> del <strong>{$datos['fecha_resolucion']}</strong> del ";
$code .= "Ministerio de Educación Nacional, en la metodología <strong>{$datos['metodologia']}</strong>, con intensidad ";
$code .= "de <strong>{$datos['horas_semanales']} horas semanales</strong>, en el periodo académico ";
$code .= "<strong>{$datos['periodo']}</strong> en la Jornada <strong>{$datos['jornada']}</strong>.</p>\n";
$code .= "\t\t\t\t\t\t\n";
$code .= "\t\t\t\t\t\t<p>La formación en Utedé se ofrece por ciclos propedéuticos: Técnico profesional (04) semestres, ";
$code .= "ciclo tecnológico (02) semestres, ciclo profesional universitario (04) semestres.</p>\n";
$code .= "\t\t\t\t\t\t\n";
$code .= "\t\t\t\t\t\t<p>La presente certificación se firma en <strong>Guadalajara de Buga - Valle del Cauca</strong>, ";
$code .= "el <strong>{$datos['fecha_certificacion']}</strong> y se expide por solicitud del interesado.</p>\n";
$code .= "\t\t\t\t\t\t\n";
$code .= "\t\t\t\t\t\t<p class=\"info-contacto\">Para verificar información escribir al E-Mail: ";
$code .= "<strong>{$datos['email']}</strong> PBX: <strong>{$datos['telefono']}</strong>.</p>\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t\t\t\n";
$code .= "\t\t\t\t<div class=\"firma\">\n";
$code .= "\t\t\t\t\t\t<p>------------------------------------------------</p>\n";
$code .= "\t\t\t\t\t\t<p><strong>{$datos['funcionario']}</strong></p>\n";
$code .= "\t\t\t\t\t\t<p>{$datos['cargo']}</p>\n";
$code .= "\t\t\t\t\t\t<p>{$datos['oficina']}</p>\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t\t\t\n";
$code .= "\t\t\t\t<div class=\"fecha-expedicion\">\n";
$code .= "\t\t\t\t\t\t<p>" . date('d/m/y, H:i') . "</p>\n";
$code .= "\t\t\t\t</div>\n";
$code .= '</body></html>';

echo($code);
?>