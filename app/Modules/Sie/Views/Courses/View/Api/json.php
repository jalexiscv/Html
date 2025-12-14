<?php
// API endpoint para obtener estudiantes que pueden tomar el curso
// Recibe el parámetro $oid (course ID) y opcionalmente ?search= para filtrar

// Obtener parámetro de búsqueda si existe
$search = $_GET['search'] ?? '';

/**
 * El dato recibido corresponde con el "ID" del curso y con este dato debemos hacer la consulta a la base de datos
 * para obtener a que modulo pertenece el curso, sabiendo "modulo" debemos hacer la consulta para saber que "progress"
 * el los "pensums" de los diferentes "estudiantes"
 */

try {
    // Cargar el modelo de cursos
    $coursesModel = model('App\Modules\Sie\Models\Sie_Courses');

    // Obtener estudiantes que pueden tomar el curso usando el nuevo método
    $students = $coursesModel->getStudentsCanTake($oid, $search);

    // Si el modelo devuelve false (error), usar array vacío
    if ($students === false) {
        $students = [];
        log_message('error', "Error al obtener estudiantes para el curso: {$oid}");
    }

} catch (\Exception $e) {
    // En caso de error, usar array vacío y registrar el error
    $students = [];
    log_message('error', "Excepción al obtener estudiantes para el curso {$oid}: " . $e->getMessage());
}

// Preparar respuesta JSON
$response = [
    'success' => true,
    'course_id' => $oid,
    'search_term' => $search,
    'total_results' => count($students),
    'students' => $students
];

// Asegurar que no hay salida previa y devolver JSON limpio
ob_clean();
echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit;
?>