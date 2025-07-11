<?php
// Configuración inicial para la API de Moodle
$token = 'd9551c4aa62771d4a38d74b1e885b13d'; // Deberías gestionar esto de forma más segura
$domainName = 'https://campus2025b.utede.edu.co';
$functionName = 'core_course_create_courses';
$restformat = 'json';

$courseCreated = false;
$errorInfo = null;
$createdCourseId = null;

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $fullname = trim($_POST['fullname'] ?? '');
    $shortname = trim($_POST['shortname'] ?? '');
    $categoryid = (int)($_POST['categoryid'] ?? 1); // Default a categoría 1 si no se especifica
    $summary = trim($_POST['summary'] ?? '');
    $idnumber = trim($_POST['idnumber'] ?? ''); // IDNumber es opcional
    $format = trim($_POST['format'] ?? 'topics');
    $numsections = (int)($_POST['numsections'] ?? 10);
    $startdate = !empty($_POST['startdate']) ? strtotime($_POST['startdate']) : time(); // Default a hoy si no se especifica
    $visible = isset($_POST['visible']) ? 1 : 0;

    // Validación simple (puedes expandirla)
    if (empty($fullname) || empty($shortname) || empty($categoryid)) {
        $errorInfo = ['message' => 'Nombre completo, nombre corto y ID de categoría son obligatorios.'];
    } else {
        // Preparar los parámetros para la creación del curso
        $params = [
            'courses' => [
                [
                    'fullname' => $fullname,
                    'shortname' => $shortname,
                    'categoryid' => $categoryid,
                    'summary' => $summary,
                    'summaryformat' => 1, // 1 para FORMAT_HTML
                    'format' => $format,
                    'startdate' => $startdate,
                    'numsections' => $numsections,
                    'visible' => $visible,
                ]
            ]
        ];
        // Añadir idnumber si se proporcionó
        if (!empty($idnumber)) {
            $params['courses'][0]['idnumber'] = $idnumber;
        }

        // Montar la URL de llamada REST
        $serverUrl = $domainName . '/webservice/rest/server.php'
            . '?wstoken=' . $token
            . '&wsfunction=' . $functionName
            . '&moodlewsrestformat=' . $restformat;

        // Inicializar cURL y configurar la petición
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $serverUrl);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params)); // Moodle espera los parámetros como campos POST estilo form-data
        // http_build_query es más robusto para arrays anidados.

        // Deberías configurar esto adecuadamente para producción
        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true); 
        // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        // Por ahora, para desarrollo local (XAMPP) se puede desactivar si hay problemas de SSL:
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);


        // Ejecutar la petición y recoger la respuesta
        $response = curl_exec($curl);

        if ($response === false) {
            $errorInfo = ['message' => 'Error en cURL: ' . curl_error($curl)];
        } else {
            $result = json_decode($response, true);

            if (isset($result['exception'])) {
                $errorInfo = [
                    'message' => 'Error al crear el curso: ' . $result['message'],
                    'exception' => $result['exception'],
                    'debuginfo' => $result['debuginfo'] ?? 'No debug info'
                ];
            } elseif (!empty($result) && isset($result[0]['id'])) {
                $courseCreated = true;
                $createdCourseId = $result[0]['id'];
            } else {
                $errorInfo = ['message' => 'Respuesta inesperada de Moodle. No se pudo confirmar la creación.', 'response' => $result];
            }
        }
        curl_close($curl);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Curso en Moodle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 20px;
        }

        /* Un poco de padding superior */
    </style>
</head>
<body>
<div class="container">
    <h1>Crear Nuevo Curso en Moodle</h1>

    <?php if ($courseCreated): ?>
        <div class="alert alert-success" role="alert">
            ¡Curso creado con éxito! ID del curso: <strong><?php echo htmlspecialchars($createdCourseId); ?></strong>
        </div>
    <?php endif; ?>

    <?php if ($errorInfo): ?>
        <div class="alert alert-danger" role="alert">
            <strong>Error:</strong> <?php echo htmlspecialchars($errorInfo['message']); ?>
            <?php if (isset($errorInfo['exception'])): ?>
                <br>Excepción: <?php echo htmlspecialchars($errorInfo['exception']); ?>
            <?php endif; ?>
            <?php if (isset($errorInfo['debuginfo'])): ?>
                <br>Debug Info: <?php echo htmlspecialchars($errorInfo['debuginfo']); ?>
            <?php endif; ?>
            <?php if (isset($errorInfo['response'])): ?>
                <br>
                <pre><?php print_r($errorInfo['response']); ?></pre>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <form action="/sie/moodle/courses/create" method="POST">
        <div class="mb-3">
            <label for="fullname" class="form-label">Nombre Completo del Curso <span
                        class="text-danger">*</span></label>
            <input type="text" class="form-control" id="fullname" name="fullname" required
                   value="<?php echo htmlspecialchars($_POST['fullname'] ?? ''); ?>">
        </div>

        <div class="mb-3">
            <label for="shortname" class="form-label">Nombre Corto del Curso <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="shortname" name="shortname" required
                   value="<?php echo htmlspecialchars($_POST['shortname'] ?? ''); ?>">
            <div class="form-text">Debe ser único. Por ejemplo, "INTROPROG2025S1".</div>
        </div>

        <div class="mb-3">
            <label for="categoryid" class="form-label">ID de Categoría <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="categoryid" name="categoryid" required
                   value="<?php echo htmlspecialchars($_POST['categoryid'] ?? 1); ?>">
            <div class="form-text">El ID de la categoría de Moodle donde se creará el curso.</div>
        </div>

        <div class="mb-3">
            <label for="idnumber" class="form-label">ID Number (Opcional)</label>
            <input type="text" class="form-control" id="idnumber" name="idnumber"
                   value="<?php echo htmlspecialchars($_POST['idnumber'] ?? ''); ?>">
            <div class="form-text">Un identificador único opcional para el curso.</div>
        </div>

        <div class="mb-3">
            <label for="summary" class="form-label">Resumen</label>
            <textarea class="form-control" id="summary" name="summary"
                      rows="3"><?php echo htmlspecialchars($_POST['summary'] ?? ''); ?></textarea>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="format" class="form-label">Formato del Curso</label>
                <select class="form-select" id="format" name="format">
                    <option value="topics" <?php echo (($_POST['format'] ?? 'topics') == 'topics') ? 'selected' : ''; ?>>
                        Temas
                    </option>
                    <option value="weeks" <?php echo (($_POST['format'] ?? '') == 'weeks') ? 'selected' : ''; ?>>
                        Semanas
                    </option>
                    <option value="social" <?php echo (($_POST['format'] ?? '') == 'social') ? 'selected' : ''; ?>>
                        Social
                    </option>
                    <option value="singleactivity" <?php echo (($_POST['format'] ?? '') == 'singleactivity') ? 'selected' : ''; ?>>
                        Actividad Única
                    </option>
                    <!-- Agrega más formatos si es necesario -->
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="numsections" class="form-label">Número de Secciones</label>
                <input type="number" class="form-control" id="numsections" name="numsections"
                       value="<?php echo htmlspecialchars($_POST['numsections'] ?? 10); ?>" min="0">
            </div>
        </div>

        <div class="mb-3">
            <label for="startdate" class="form-label">Fecha de Inicio</label>
            <input type="date" class="form-control" id="startdate" name="startdate"
                   value="<?php echo htmlspecialchars($_POST['startdate'] ?? date('Y-m-d')); ?>">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="visible" name="visible"
                   value="1" <?php echo isset($_POST['visible']) || !$_POST ? 'checked' : ''; ?>>
            <label class="form-check-label" for="visible">Visible para los estudiantes</label>
        </div>

        <button type="submit" class="btn btn-primary">Crear Curso</button>
        <a href="/sie/moodle/courses/list" class="btn btn-secondary">Volver a la Lista</a> <!-- Ajusta esta URL -->
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
