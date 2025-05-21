<?php
$token = 'a99cf98a32a7bc899e0e9c45e4f50b8f';
$domain = 'https://campus2025b.utede.edu.co';
$function = 'core_course_get_courses';
$restFormat = 'json';

$url = $domain . '/webservice/rest/server.php'
    . '?wstoken=' . $token
    . '&wsfunction=' . $function
    . '&moodlewsrestformat=' . $restFormat;

// Opcional: filtrar cursos específicos
// $url .= '&options[ids][0]=2';

$curl = curl_init($url);
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => true,
    CURLOPT_USERAGENT => 'MoodlePHPClient/1.0'
]);

$response = curl_exec($curl);
if ($response === false) {
    die('Error cURL: ' . curl_error($curl));
}
curl_close($curl);

$response = curl_exec($curl);

if ($response === false) {
    echo '<div class="alert alert-danger" role="alert">';
    echo 'Error cURL: ' . htmlspecialchars(curl_error($curl));
    echo '</div>';
    curl_close($curl);
} else {
    curl_close($curl);
    $courses = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo '<div class="alert alert-danger" role="alert">';
        echo 'Error al decodificar JSON: ' . htmlspecialchars(json_last_error_msg());
        echo '<br>Respuesta recibida:<br><pre>' . htmlspecialchars($response) . '</pre>';
        echo '</div>';
    } elseif (empty($courses) || !is_array($courses)) {
        echo '<div class="alert alert-info" role="alert">';
        echo 'No se encontraron cursos o la respuesta no es un array válido.';
        if (isset($courses['message'])) { // Moodle a veces devuelve errores como un objeto con 'message'
            echo '<br>Mensaje de Moodle: ' . htmlspecialchars($courses['message']);
        }
        echo '<br>Respuesta decodificada:<br><pre>';
        print_r($courses);
        echo '</pre>';
        echo '</div>';
    } else {
        ?>
        <link href="/themes/assets/libraries/bootstrap/5.3.3/css/bootstrap.css?v=2.5.3" rel="stylesheet">
        <div class="container mt-4">
            <h2>Lista de Cursos de Moodle</h2>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre Corto</th>
                        <th>Nombre Completo</th>
                        <th>Resumen</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Fin</th>
                        <th>Visible</th>
                        <th>Opciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($courses as $course): ?>
                        <?php if (is_array($course)): // Asegurarse de que $course sea un array ?>
                            <tr>
                                <td><?php echo htmlspecialchars(isset($course['id']) ? $course['id'] : 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars(isset($course['shortname']) ? $course['shortname'] : 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars(isset($course['fullname']) ? $course['fullname'] : 'N/A'); ?></td>
                                <td>
                                    <?php
                                    $summary = isset($course['summary']) ? $course['summary'] : '';
                                    if (!empty($summary)) {
                                        // Limitar la longitud del resumen y quitar etiquetas HTML para la visualización en tabla
                                        echo htmlspecialchars(mb_strimwidth(strip_tags($summary), 0, 100, "..."));
                                    } else {
                                        echo 'N/A';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $startDate = isset($course['startdate']) ? $course['startdate'] : 0;
                                    echo $startDate != 0 ? date('Y-m-d', $startDate) : 'N/A';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $endDate = isset($course['enddate']) ? $course['enddate'] : 0;
                                    echo $endDate != 0 ? date('Y-m-d', $endDate) : 'N/A';
                                    ?>
                                </td>
                                <td><?php echo (isset($course['visible']) && $course['visible'] == 1) ? 'Sí' : 'No'; ?></td>
                                <td><a href="/sie/moodle/courses/clone?oid=<?php echo $course['id']; ?>"
                                       class="btn btn-primary">Clonar</a></td>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-danger">Error: Elemento de curso no es un array válido.</td>
                            </tr>
                            <?php
                            // Opcional: Imprimir el elemento problemático para depuración
                            // echo '<tr><td colspan="7"><pre>'; print_r($course); echo '</pre></td></tr>';
                            ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }
}
?>