<?php
$token = 'ce890746630ebf2c6b7baf4dde8f41b4';
$domain = 'https://campus.utede.edu.co';
$function = 'core_course_get_courses_by_field';
$restFormat = 'json';

// Función para verificar si existe un curso en Moodle
function moodleCourseExists($courseId, $token, $domain)
{
    $serverurl = $domain . '/webservice/rest/server.php';

    $params = array(
        'wstoken' => $token,
        'wsfunction' => 'core_course_get_courses_by_field',
        'moodlewsrestformat' => 'json',
        'field' => 'id',
        'value' => $courseId
    );

    // Construir la URL con parámetros
    $url = $serverurl . '?' . http_build_query($params);

    // Inicializar cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    // Ejecutar la petición
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    // Verificar errores de cURL
    if ($error) {
        $console[] = "> ERROR: Error de conexión cURL: {$error}";
        return false;
    }

    // Verificar código HTTP
    if ($httpCode !== 200) {
        $console[] = "> ERROR: Código HTTP: {$httpCode}";
        return false;
    }

    // Decodificar respuesta JSON
    $data = json_decode($response, true);

    // Verificar si hay errores en la respuesta de Moodle
    if (isset($data['exception'])) {
        $console[] = "> ERROR: {$data['message']}";
        return false;
    }

    // Verificar si se encontraron cursos
    if (isset($data['courses']) && !empty($data['courses'])) {
        $course = $data['courses'][0];
        $console[] = "> --- ✓ El curso existe en Moodle";
        $console[] = "> --- : Nombre del curso: {$course['fullname']}";
        $console[] = "> --- : Nombre corto: {$course['shortname']}";
        $console[] = "> --- : ID del curso: {$course['id']}";
        $console[] = "> ---: Categoría: {$course['categoryname']}";
        return $course;
    } else {
        $console[] = "> ---: ✗ El curso NO existe en Moodle con el ID: {$courseId}";
        return false;
    }
}

// Verificar existencia del curso
if (!empty($course_moodle_id)) {
    $moodleCourse = moodleCourseExists($course_moodle_id, $token, $domain);

    if ($moodleCourse) {
        $console[] = "> --- : El curso está sincronizado correctamente";
    } else {
        $console[] = "> --- : Se requiere crear o actualizar el curso en Moodle";
    }
} else {
    $console[] = "> ERROR: No se proporcionó un ID de curso de Moodle";
}

?>