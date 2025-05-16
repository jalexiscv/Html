<?php
require_once(APPPATH . 'ThirdParty/FPDF/fpdf.php');
require_once(APPPATH . 'ThirdParty/FPDI/autoload.php');
require_once(APPPATH . 'ThirdParty/Barcode/autoload.php');
require_once(APPPATH . 'ThirdParty/GS1/autoload.php');
require_once(APPPATH . 'ThirdParty/Bacon/autoload.php');

class CursoPDF extends \setasign\Fpdi\Fpdi
{
    // Encabezado
    function Header()
    {
        // Logo (si existe)
        if (file_exists('logo.png')) {
            $this->Image('logo.png', 10, 8, 30);
            $this->SetX(45); // Mover a la derecha del logo
        } else {
            $this->SetX(10); // Sin logo, empezar desde el borde
        }

        // Título del documento
        $titulo = mb_convert_encoding('INFORMACIÓN DEL CURSO', 'ISO-8859-1', 'UTF-8');
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 10, $titulo, 0, 1, 'C');
        $this->Ln(5); // Espacio después del título
    }

    // Pie de página
    function Footer()
    {
        // Ir a 1.5 cm desde el final de página
        $this->SetY(-15);
        // Seleccionar fuente Arial itálica 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, mb_convert_encoding('Página ', 'ISO-8859-1', 'UTF-8') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    // Función para crear la sección de información del curso
    function infoCurso($oid)
    {
        $mcourses = model("App\Modules\Sie\Models\Sie_Courses");
        $mprograms = model("App\Modules\Sie\Models\Sie_Programs");
        $mmodules = model("App\Modules\Sie\Models\Sie_Modules");
        $mgrids = model("App\Modules\Sie\Models\Sie_Grids");
        $mpensums = model("App\Modules\Sie\Models\Sie_Pensums");
        $mfields = model("App\Modules\Sie\Models\Sie_Users_Fields");
        $magreements = model("App\Modules\Sie\Models\Sie_Agreements");
        $minstitutions = model("App\Modules\Sie\Models\Sie_Institutions");
        $mgroups = model("App\Modules\Sie\Models\Sie_Groups");

        $row = $mcourses->get_Course($oid);
        $program = $mprograms->getProgram(@$row["program"]);
        $grid = $mgrids->get_Grid(@$row["grid"]);
        $pensum = $mpensums->get_Pensum(@$row["pensum"]);
        $module = $mmodules->get_Module(@$pensum["module"]);
        $r["course"] = @$row["course"];
        $r["reference"] = @$row["reference"];
        $r["program"] = @$row["program"] . " - " . @$program['name'];
        $r["pensum"] = @$row["pensum"] . "-" . @$module['name'];// Es el codigo del curso pero dentro de la malla es decir codigo del pensum
        $r["teacher"] = @$row["teacher"];
        $r["teacher_name"] = $mfields->get_FullName(@$r["teacher"]);
        $r["name"] = @$row["name"];
        $r["course-name"] = @$row["course"] . " - " . @$row["name"];
        $r["description"] = @$row["description"];
        $r["maximum_quota"] = @$row["maximum_quota"];
        $r["start"] = @$row["start"];
        $r["end"] = @$row["end"];
        $r["period"] = @$row["period"];
        $r["space"] = @$row["space"];
        $r["author"] = @$row["author"];
        $r["created_at"] = @$row["created_at"];
        $r["updated_at"] = @$row["updated_at"];
        $r["deleted_at"] = @$row["deleted_at"];
        $r["agreement"] = "";
        $r["agreement_institution"] = "";
        $r["agreement_group"] = "";


        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Datos del Curso', 0, 1, 'L');
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->Ln(5);

        $this->SetFont('Arial', '', 10);

        // Values
        $codigo_value = mb_convert_encoding($r["course"], 'ISO-8859-1', 'UTF-8');
        $referencia_value = mb_convert_encoding($r["reference"], 'ISO-8859-1', 'UTF-8');
        $inicio_value = mb_convert_encoding($r["start"], 'ISO-8859-1', 'UTF-8');
        $fin_value = mb_convert_encoding($r["end"], 'ISO-8859-1', 'UTF-8');
        $programa_value = mb_convert_encoding(safe_strtoupper($r["program"]), 'ISO-8859-1', 'UTF-8');
        $periodo_value = mb_convert_encoding($r["period"], 'ISO-8859-1', 'UTF-8');
        $pensum_value = mb_convert_encoding(safe_strtoupper($r["pensum"]), 'ISO-8859-1', 'UTF-8');
        $curso_nombre_value = mb_convert_encoding(safe_strtoupper($r["course-name"]), 'ISO-8859-1', 'UTF-8');
        $profesor_value = mb_convert_encoding(safe_strtoupper($r["teacher"] . " - " . $r["teacher_name"]), 'ISO-8859-1', 'UTF-8');
        // Primera fila
        $codigo_label = mb_convert_encoding('Código del curso:', 'ISO-8859-1', 'UTF-8');
        $referencia_label = mb_convert_encoding('Referencia:', 'ISO-8859-1', 'UTF-8');
        $inicio_label = mb_convert_encoding('Fecha de inicio:', 'ISO-8859-1', 'UTF-8');
        $fin_label = mb_convert_encoding('Fecha de finalización:', 'ISO-8859-1', 'UTF-8');
        $programa_label = mb_convert_encoding('Programa:', 'ISO-8859-1', 'UTF-8');
        $periodo_label = mb_convert_encoding('Periodo académico:', 'ISO-8859-1', 'UTF-8');
        $pensum_label = mb_convert_encoding('Código del Pensum:', 'ISO-8859-1', 'UTF-8');
        $curso_nombre_label = mb_convert_encoding('Nombre del curso:', 'ISO-8859-1', 'UTF-8');
        $profesor_label = mb_convert_encoding('Profesor:', 'ISO-8859-1', 'UTF-8');

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(50, 7, $codigo_label, 0, 0);
        $this->SetFont('Arial', '', 10);
        $this->Cell(50, 7, $codigo_value, 0, 0);

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(50, 7, $referencia_label, 0, 0);
        $this->SetFont('Arial', '', 10);
        $this->Cell(50, 7, $referencia_value, 0, 1);

        // Segunda fila
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(50, 7, $inicio_label, 0, 0);
        $this->SetFont('Arial', '', 10);
        $this->Cell(50, 7, $inicio_value, 0, 0);

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(50, 7, $fin_label, 0, 0);
        $this->SetFont('Arial', '', 10);
        $this->Cell(50, 7, $fin_value, 0, 1);

        // Tercera fila
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(50, 7, $programa_label, 0, 0);
        $this->SetFont('Arial', '', 10);
        $this->Cell(150, 7, $programa_value, 0, 1);

        // Cuarta fila
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(50, 7, $periodo_label, 0, 0);
        $this->SetFont('Arial', '', 10);
        $this->Cell(150, 7, $periodo_value, 0, 1);

        // Quinta fila
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(50, 7, $pensum_label, 0, 0);
        $this->SetFont('Arial', '', 10);
        $this->Cell(150, 7, $pensum_value, 0, 1);

        // Sexta fila
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(50, 7, $curso_nombre_label, 0, 0);
        $this->SetFont('Arial', '', 10);
        $this->Cell(150, 7, $curso_nombre_value, 0, 1);

        // Séptima fila
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(50, 7, $profesor_label, 0, 0);
        $this->SetFont('Arial', '', 10);
        $this->Cell(150, 7, $profesor_value, 0, 1);

        $this->Ln(10); // Espacio después de la información del curso
    }

    // Función para crear la tabla de estudiantes
    function tablaEstudiantes($oid)
    {
        $mcourses = model('App\Modules\Sie\Models\Sie_Courses');
        $mmodules = model('App\Modules\Sie\Models\Sie_Modules');
        $mversions = model('App\Modules\Sie\Models\Sie_Versions');
        $mpensums = model('App\Modules\Sie\Models\Sie_Pensums');
        $mgrids = model('App\Modules\Sie\Models\Sie_Grids');
        $mprograms = model('App\Modules\Sie\Models\Sie_Programs');
        $musers = model('App\Modules\Sie\Models\Sie_Users');
        $mfields = model('App\Modules\Sie\Models\Sie_Users_Fields');
        $mexecutions = model('App\Modules\Sie\Models\Sie_Executions');
        $mprogress = model('App\Modules\Sie\Models\Sie_Progress');
        $menrollments = model('App\Modules\Sie\Models\Sie_Enrollments');
        $mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');
        $mstatuses = model('App\Modules\Sie\Models\Sie_Statuses');

        $row = $mcourses->get_Course($oid);

        $executions = $mexecutions
            ->select('MAX(execution) as execution, progress')
            ->where('course', $oid)
            ->groupBy(['course', 'progress'])
            ->find();
        $status = $row["status"];
        $count = 0;
        $estudiantes = array();
        foreach ($executions as $execution) {
            if (is_array($execution)) {
                //echo(safe_dump($execution));
                $count++;
                $progress = $mprogress->where('progress', $execution['progress'])->first();
                if (!empty($progress['enrollment'])) {
                    $enrollment = $menrollments->where('enrollment', $progress['enrollment'])->first();
                    $registration = $mregistrations->where('registration', $enrollment['student'])->first();

                    $linkView = "/sie/executions/edit/{$execution['execution']}?t=" . pk();


                    $class_course_status = "";

                    if ($status == "CANCELED" || $status == "CLOSED") {
                        $class_course_status = "disabled";
                    }


                    $fullname = @$registration['first_name'] . " " . @$registration['second_name'] . " " . @$registration['first_surname'] . " " . @$registration['second_surname'];

                    $real_execution = $mexecutions->where('execution', $execution['execution'])->first();
                    $c1 = empty($real_execution['c1']) ? "0,0" : $real_execution['c1'];
                    $c2 = empty($real_execution['c2']) ? "0,0" : $real_execution['c2'];
                    $c3 = empty($real_execution['c3']) ? "0,0" : $real_execution['c3'];
                    $total = empty($real_execution['total']) ? "0,0" : $real_execution['total'];


                    $identification_number = @$registration['identification_number'];
                    $rn = @$registration['registration'];
                    $rnlink = "<a href=\"/sie/students/view/{$rn}\" target=\"_blank\">{$identification_number}</a>";

                    $scanceledorpostponed = $mstatuses->get_LastStatusCanceledOrPostponed(@$registration['registration']);

                    $status = "";
                    if (@$scanceledorpostponed['reference'] == "CANCELED") {
                        $status = "<span class=\"badge rounded-pill bg-danger\">Cancelado</span>";
                    } elseif (@$scanceledorpostponed['reference'] == "POSTPONED") {
                        $status = "<span class=\"badge rounded-pill bg-warning text-dark\">Aplazado</span>";
                    }

                    $estudiantes[] =
                        [
                            'identificacion' => $execution['execution'],
                            'progress' => @$progress['progress'],
                            'nombre' => $fullname,
                            'c1' => $c1,
                            'c2' => $c2,
                            'c3' => $c3,
                            'total' => $total
                        ];


                    /**
                     * $grid->add_Row(
                     * array(
                     * array("content" => $count, "class" => "text-center align-middle"),
                     * //array("content" => $execution['execution'], "class" => "text-center align-middle"),
                     * array("content" => @$progress['progress'], "class" => "text-center align-middle"),
                     * array("content" => @$enrollment['enrollment'], "class" => "text-center align-middle"),
                     * //array("content" => @$registration['registration'], "class" => "text-center align-middle"),
                     * array("content" => $rnlink, "class" => "text-center align-middle"),
                     * array("content" => $fullname, "class" => "text-left align-middle"),
                     * array("content" => $status, "class" => "text-center align-middle"),
                     * array("content" => $c1, "class" => "text-center align-middle"),
                     * array("content" => $c2, "class" => "text-center align-middle"),
                     * array("content" => $c3, "class" => "text-center align-middle"),
                     * array("content" => $total, "class" => "text-center align-middle"),
                     * array("content" => $options, "class" => "text-center align-middle"),
                     * ),
                     * );
                     * **/
                }
            }
        }


        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Estudiantes Matriculados', 0, 1, 'L');
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->Ln(5);

        // Cabecera de la tabla
        $this->SetFillColor(220, 220, 220);
        $this->SetFont('Arial', 'B', 8);
        $anchoCelda = 15; // Ancho estándar para celdas numéricas

        // Fila de encabezados
        $this->Cell(8, 10, '#', 1, 0, 'C', true);
        $this->Cell(29, 10, mb_convert_encoding('Progreso', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
        $this->Cell(29, 10, mb_convert_encoding('Identificación', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
        $this->Cell(65, 10, 'Nombre', 1, 0, 'C', true);
        $this->Cell($anchoCelda, 10, 'C1', 1, 0, 'C', true);
        $this->Cell($anchoCelda, 10, 'C2', 1, 0, 'C', true);
        $this->Cell($anchoCelda, 10, 'C3', 1, 0, 'C', true);
        $this->Cell($anchoCelda, 10, 'T', 1, 1, 'C', true);

        // Datos de estudiantes
        $this->SetFont('Arial', '', 8);
        $this->SetFillColor(245, 245, 245);
        $fill = false;

        $contador = 1;
        foreach ($estudiantes as $estudiante) {
            $this->Cell(8, 7, $contador, 1, 0, 'C', $fill);
            $this->Cell(29, 7, $estudiante['progress'], 1, 0, 'C', $fill);
            $this->Cell(29, 7, $estudiante['identificacion'], 1, 0, 'C', $fill);
            $this->Cell(65, 7, mb_convert_encoding($estudiante['nombre'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'L', $fill);
            $this->Cell($anchoCelda, 7, $estudiante['c1'], 1, 0, 'C', $fill);
            $this->Cell($anchoCelda, 7, $estudiante['c2'], 1, 0, 'C', $fill);
            $this->Cell($anchoCelda, 7, $estudiante['c3'], 1, 0, 'C', $fill);
            $this->Cell($anchoCelda, 7, $estudiante['total'], 1, 1, 'C', $fill);

            $contador++;
            $fill = !$fill; // Alternar el color de fondo
        }

        $this->Ln(10);
    }

    // Función para agregar una sección de observaciones
    function observaciones($texto)
    {
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 7, 'Observaciones:', 0, 1, 'L');
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 7, mb_convert_encoding($texto, 'ISO-8859-1', 'UTF-8'), 0, 'L');
    }
}


// Datos de los estudiantes (estos podrían venir de una base de datos)


// Crear el PDF
$pdf = new CursoPDF();
$pdf->AliasNbPages(); // Para mostrar el total de páginas en el pie
$pdf->AddPage();
// Agregar la información del curso
/** @var TYPE_NAME $oid */
$pdf->infoCurso($oid);
// Agregar la tabla de estudiantes
$pdf->tablaEstudiantes($oid);
// Agregar observaciones
$pdf->observaciones('Este curso ha sido evaluado de acuerdo con los criterios establecidos en el programa académico. Las notas C1, C2 y C3 corresponden a los cortes evaluativos del semestre, y T es la nota total calculada según los porcentajes asignados.');

// Verificar si es una solicitud de visualización o descarga
if (isset($_GET['descargar']) && $_GET['descargar'] == 1) {
    // Descargar el PDF
    //$pdf->Output('D', 'Curso_' . $datosCurso['codigo'] . '.pdf');
} else {
    // Mostrar el PDF en el navegador
    $buffer = $pdf->Output('', 'S');
    $pdf_base64 = base64_encode($buffer);
    $code = '<iframe width="100%" height="1200" src="data:application/pdf;base64,' . $pdf_base64 . '"></iframe>';
    echo($code);
}

?>