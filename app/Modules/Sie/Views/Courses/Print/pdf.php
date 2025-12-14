<?php

use setasign\Fpdi\Fpdi;

require_once(APPPATH . 'ThirdParty/FPDF/fpdf.php');
require_once(APPPATH . 'ThirdParty/FPDI/autoload.php');
require_once(APPPATH . 'ThirdParty/Barcode/autoload.php');
require_once(APPPATH . 'ThirdParty/GS1/autoload.php');
require_once(APPPATH . 'ThirdParty/Bacon/autoload.php');

class CursoPDF extends Fpdi
{
    // Encabezado
    function Header()
    {
        // Establecer márgenes
        $this->SetMargins(10, 10, 10);

        // Ancho de página utilizable
        $page_width = $this->GetPageWidth() - 20; // 20 = margen izquierdo + margen derecho

        // Ancho de columnas
        $logo_width = 40; // Ancho para el logo
        $info_width = $page_width - $logo_width; // Resto para la información

        // Altura de filas
        $row1_height = 10; // Primera fila - Título institución
        $row2_height = 10; // Segunda fila - Título documento
        $row3_height = 8;  // Tercera fila - Información adicional
        $total_height = $row1_height + $row2_height + $row3_height;

        // Posición inicial
        $x_start = 10;
        $y_start = 10;

        // ----- PRIMERA PARTE: LOGO (ocupa 3 filas de altura) -----

        // Crear caja para el logo (a la izquierda, ocupa las 3 filas)
        $this->Rect($x_start, $y_start, $logo_width, $total_height);

        // Insertar logo
        $logo_url = get_logo("logo_landscape");
        if (!empty($logo_url)) {
            // Crear directorio temporal si no existe
            $temp_dir = WRITEPATH . 'temp/';
            if (!is_dir($temp_dir)) {
                mkdir($temp_dir, 0777, true);
            }

            // Nombre de archivo temporal para la imagen
            $temp_file = $temp_dir . 'temp_logo_' . md5($logo_url) . '.png';

            // Intentar descargar la imagen si el archivo no existe
            if (!file_exists($temp_file)) {
                $image_data = @file_get_contents($logo_url);
                if ($image_data !== false) {
                    file_put_contents($temp_file, $image_data);
                }
            }

            // Insertar la imagen si se pudo descargar
            if (file_exists($temp_file)) {
                // Calcular posición centrada para el logo
                $this->Image($temp_file, $x_start + 2, $y_start + 9, $logo_width - 4, 0);
            }
        }

        // ----- SEGUNDA PARTE: INFORMACIÓN (en 3 filas) -----

        // Fila 1: Nombre institución
        $this->Rect($x_start + $logo_width, $y_start, $info_width, $row1_height);
        $this->SetFont('Arial', 'B', 12);
        $this->SetXY($x_start + $logo_width, $y_start);
        $institucion = mb_convert_encoding('Utedé - Unidad Técnica para el Desarrollo Profesional', 'ISO-8859-1', 'UTF-8');
        $this->Cell($info_width, $row1_height, $institucion, 0, 1, 'C');

        // Fila 2: Título del documento
        $this->Rect($x_start + $logo_width, $y_start + $row1_height, $info_width, $row2_height);
        $this->SetFont('Arial', 'B', 11);
        $this->SetXY($x_start + $logo_width, $y_start + $row1_height);
        $titulo_doc = mb_convert_encoding('INFORMACIÓN DEL CURSO', 'ISO-8859-1', 'UTF-8');
        $this->Cell($info_width, $row2_height, $titulo_doc, 0, 1, 'C');

        // Fila 3: Información adicional (dividida en 3 columnas)
        $info_col_width = $info_width / 3;

        // Columna 1 de info: Código
        $this->Rect($x_start + $logo_width, $y_start + $row1_height + $row2_height, $info_col_width, $row3_height);
        $this->SetFont('Arial', '', 8);
        $this->SetXY($x_start + $logo_width, $y_start + $row1_height + $row2_height);
        $codigo = mb_convert_encoding('Código: DO-FO-060', 'ISO-8859-1', 'UTF-8');
        $this->Cell($info_col_width, $row3_height, $codigo, 0, 0, 'C');

        // Columna 2 de info: Versión
        $this->Rect($x_start + $logo_width + $info_col_width, $y_start + $row1_height + $row2_height, $info_col_width, $row3_height);
        $this->SetXY($x_start + $logo_width + $info_col_width, $y_start + $row1_height + $row2_height);
        $version = mb_convert_encoding('Versión: 0.2', 'ISO-8859-1', 'UTF-8');
        $this->Cell($info_col_width, $row3_height, $version, 0, 0, 'C');

        // Columna 3 de info: Fecha y página
        $this->Rect($x_start + $logo_width + ($info_col_width * 2), $y_start + $row1_height + $row2_height, $info_col_width, $row3_height);
        $this->SetXY($x_start + $logo_width + ($info_col_width * 2), $y_start + $row1_height + $row2_height);
        $fecha_pagina = mb_convert_encoding('Página ' . $this->PageNo() . ' de {nb}', 'ISO-8859-1', 'UTF-8');
        $this->Cell($info_col_width, $row3_height, $fecha_pagina, 0, 0, 'C');

        // Establecer posición Y para el contenido que sigue
        $this->SetY($y_start + $total_height + 10);
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
        $mcourses = model('App\Modules\Sie\Models\Sie_Courses');
        $mprograms = model("App\Modules\Sie\Models\Sie_Programs");
        $mmodules = model("App\Modules\Sie\Models\Sie_Modules");
        $mgrids = model("App\Modules\Sie\Models\Sie_Grids");
        $mpensums = model("App\Modules\Sie\Models\Sie_Pensums");
        $mfields = model("App\Modules\Sie\Models\Sie_Users_Fields");
        $magreements = model("App\Modules\Sie\Models\Sie_Agreements");
        $minstitutions = model("App\Modules\Sie\Models\Sie_Institutions");
        $mgroups = model("App\Modules\Sie\Models\Sie_Groups");

        $row = $mcourses->getCourse($oid);
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

        // Fecha y hora de generación del reporte
        $this->SetFont('Arial', 'I', 9);
        $fecha_hora_generacion = mb_convert_encoding('Fecha y hora de generación: ' . date('d/m/Y H:i:s'), 'ISO-8859-1', 'UTF-8');
        $this->Cell(0, 8, $fecha_hora_generacion, 0, 1, 'R');

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

        $row = $mcourses->getCourse($oid);

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
                    $registration = $mregistrations->where('registration', $enrollment['registration'])->first();

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
                            'identificacion' => $identification_number,
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
        $this->Cell(8, 5, '#', 1, 0, 'C', true);
        $this->Cell(29, 5, mb_convert_encoding('Progreso', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
        $this->Cell(29, 5, mb_convert_encoding('Identificación', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
        $this->Cell(65, 5, 'Nombre', 1, 0, 'C', true);
        $this->Cell($anchoCelda, 5, 'C1', 1, 0, 'C', true);
        $this->Cell($anchoCelda, 5, 'C2', 1, 0, 'C', true);
        $this->Cell($anchoCelda, 5, 'C3', 1, 0, 'C', true);
        $this->Cell($anchoCelda, 5, 'T', 1, 1, 'C', true);

        // Datos de estudiantes
        $this->SetFont('Arial', '', 8);
        $this->SetFillColor(245, 245, 245);
        $fill = false;

        $contador = 1;
        foreach ($estudiantes as $estudiante) {
            $this->Cell(8, 5, $contador, 1, 0, 'C', $fill);
            $this->Cell(29, 5, $estudiante['progress'], 1, 0, 'C', $fill);
            $this->Cell(29, 5, $estudiante['identificacion'], 1, 0, 'C', $fill);
            $this->Cell(65, 5, mb_convert_encoding($estudiante['nombre'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'L', $fill);
            $this->Cell($anchoCelda, 5, $estudiante['c1'], 1, 0, 'C', $fill);
            $this->Cell($anchoCelda, 5, $estudiante['c2'], 1, 0, 'C', $fill);
            $this->Cell($anchoCelda, 5, $estudiante['c3'], 1, 0, 'C', $fill);
            $this->Cell($anchoCelda, 5, $estudiante['total'], 1, 1, 'C', $fill);

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
        $this->Ln(10);
    }

    // Función para agregar sección de firmas
    function firmas()
    {
        // Calcular posición para la tabla de firmas
        $page_width = $this->GetPageWidth() - 20; // 20 = margen izquierdo + margen derecho
        $firma_width = $page_width / 3; // Tres columnas de igual ancho

        // Altura de las filas
        $espacio_firma = 25; // Espacio para la firma
        $espacio_texto = 8;  // Espacio para el texto

        // Posición inicial
        $x_start = 10;
        $this->Ln(10); // Espacio antes de la sección de firmas

        // Línea separadora antes de la sección de firmas
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->Ln(10);

        // Título de la sección
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 8, mb_convert_encoding('VALIDACIÓN DEL REPORTE', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        $this->Ln(5);

        // Celdas para firma
        $y_firma = $this->GetY();

        // Columna 1: Firma del docente
        $this->Rect($x_start, $y_firma, $firma_width, $espacio_firma);

        // Columna 2: Firma del coordinador
        $this->Rect($x_start + $firma_width, $y_firma, $firma_width, $espacio_firma);

        // Columna 3: Firma del registro académico
        $this->Rect($x_start + ($firma_width * 2), $y_firma, $firma_width, $espacio_firma);

        // Avanzar después del espacio para firma
        $this->SetY($y_firma + $espacio_firma);

        // Textos debajo de las firmas
        $this->SetFont('Arial', 'B', 9);

        // Texto para firma del docente
        $this->Rect($x_start, $this->GetY(), $firma_width, $espacio_texto);
        $this->SetXY($x_start, $this->GetY());
        $texto_docente = mb_convert_encoding('FIRMA DEL DOCENTE', 'ISO-8859-1', 'UTF-8');
        $this->Cell($firma_width, $espacio_texto, $texto_docente, 0, 0, 'C');

        // Texto para firma del coordinador
        $this->Rect($x_start + $firma_width, $this->GetY(), $firma_width, $espacio_texto);
        $this->SetXY($x_start + $firma_width, $this->GetY());
        $texto_coordinador = mb_convert_encoding('FIRMA DEL COORDINADOR', 'ISO-8859-1', 'UTF-8');
        $this->Cell($firma_width, $espacio_texto, $texto_coordinador, 0, 0, 'C');

        // Texto para firma del registro académico
        $this->Rect($x_start + ($firma_width * 2), $this->GetY(), $firma_width, $espacio_texto);
        $this->SetXY($x_start + ($firma_width * 2), $this->GetY());
        $texto_registro = mb_convert_encoding('FIRMA REGISTRO ACADÉMICO', 'ISO-8859-1', 'UTF-8');
        $this->Cell($firma_width, $espacio_texto, $texto_registro, 0, 1, 'C');

        // Espacios para nombres
        $this->SetFont('Arial', '', 9);

        // Espacio para nombre del docente
        $this->Rect($x_start, $this->GetY(), $firma_width, $espacio_texto);
        $this->SetXY($x_start, $this->GetY());
        $nombre_docente = mb_convert_encoding('Nombre: ___________________________', 'ISO-8859-1', 'UTF-8');
        $this->Cell($firma_width, $espacio_texto, $nombre_docente, 0, 0, 'C');

        // Espacio para nombre del coordinador
        $this->Rect($x_start + $firma_width, $this->GetY(), $firma_width, $espacio_texto);
        $this->SetXY($x_start + $firma_width, $this->GetY());
        $nombre_coordinador = mb_convert_encoding('Nombre: ___________________________', 'ISO-8859-1', 'UTF-8');
        $this->Cell($firma_width, $espacio_texto, $nombre_coordinador, 0, 0, 'C');

        // Espacio para nombre del responsable de registro
        $this->Rect($x_start + ($firma_width * 2), $this->GetY(), $firma_width, $espacio_texto);
        $this->SetXY($x_start + ($firma_width * 2), $this->GetY());
        $nombre_registro = mb_convert_encoding('Nombre: ___________________________', 'ISO-8859-1', 'UTF-8');
        $this->Cell($firma_width, $espacio_texto, $nombre_registro, 0, 1, 'C');

        $this->Ln(5);
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
// Agregar sección de firmas
$pdf->firmas();

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