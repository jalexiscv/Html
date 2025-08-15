<?php
// Configuración inicial para la API de Moodle
$token = 'ce890746630ebf2c6b7baf4dde8f41b4';
$domainName = 'https://campus.utede.edu.co';
$restFormat = 'json';
$functionName = 'core_course_duplicate_course';


$originalCourseId = null;
$courseCloned = false;
$errorInfo = null;
$clonedCourseDetails = null;

// Obtener el ID del curso original desde GET o POST si están disponibles
if (isset($_GET['oid'])) {
    $originalCourseId = (int)$_GET['oid'];
} elseif (isset($_POST['original_course_id'])) {
    $originalCourseId = (int)$_POST['original_course_id'];
}

// Procesar el formulario cuando se envía y si tenemos un ID de curso original
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $originalCourseId) {
    $fullname = trim($_POST['fullname'] ?? '');
    $shortname = trim($_POST['shortname'] ?? '');
    $categoryid = (int)($_POST['categoryid'] ?? 1);
    $visible = isset($_POST['visible']) ? 1 : 0;
    $includeUsers = isset($_POST['include_users']) ? 1 : 0;

    if (empty($fullname) || empty($shortname) || empty($categoryid)) {
        $errorInfo = ['message' => 'Nombre completo, nombre corto y ID de categoría son obligatorios para el clon.'];
    } else {
        $params = [
            'courseid' => $originalCourseId,
            'fullname' => $fullname,
            'shortname' => $shortname,
            'categoryid' => $categoryid,
            'visible' => $visible,
            'options' => [
                [
                    'name' => 'users',
                    'value' => $includeUsers
                ]
            ]
        ];

        $serverUrl = $domainName . '/webservice/rest/server.php'
            . '?wstoken=' . $token
            . '&wsfunction=' . $functionName
            . '&moodlewsrestformat=' . $restFormat
            . '&' . http_build_query($params);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $serverUrl);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, []);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($curl);

        if ($response === false) {
            $errorInfo = ['message' => 'Error en cURL: ' . curl_error($curl)];
        } else {
            $result = json_decode($response, true);

            if (isset($result['exception'])) {
                $errorInfo = [
                    'message' => 'Error al clonar el curso: ' . ($result['message'] ?? 'Error desconocido.'),
                    'exception' => $result['exception'] ?? 'N/A',
                    'errorcode' => $result['errorcode'] ?? 'N/A',
                    'debuginfo' => $result['debuginfo'] ?? 'No debug info'
                ];
            } elseif (!empty($result) && isset($result['id']) && isset($result['shortname'])) {
                $courseCloned = true;
                $clonedCourseDetails = $result;
            } else {
                $errorInfo = ['message' => 'Respuesta inesperada de Moodle. No se pudo confirmar la clonación.', 'response' => $result];
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
    <title>Clonar Curso en Moodle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body { padding-top: 20px; }</style>
</head>
<body>
<div class="container">
    <h1>Clonar Curso en Moodle</h1>

    <?php if ($courseCloned): ?>
        <div class="alert alert-success" role="alert">
            ¡Curso clonado con éxito! <br>
            Nuevo ID del curso: <strong><?php echo htmlspecialchars($clonedCourseDetails['id']); ?></strong><br>
            Nuevo Nombre Corto: <strong><?php echo htmlspecialchars($clonedCourseDetails['shortname']); ?></strong>
        </div>
    <?php endif; ?>

    <?php if ($errorInfo && !$courseCloned): ?>
        <div class="alert alert-danger" role="alert">
            <strong>Error:</strong> <?php echo htmlspecialchars($errorInfo['message']); ?>
            <?php if (isset($errorInfo['exception'])): ?>
                <br>Excepción: <?php echo htmlspecialchars($errorInfo['exception']); ?>
                <br>Código de Error: <?php echo htmlspecialchars($errorInfo['errorcode']); ?>
            <?php endif; ?>
            <?php if (isset($errorInfo['debuginfo'])): ?>
                <br>Debug Info: <?php echo htmlspecialchars($errorInfo['debuginfo']); ?>
            <?php endif; ?>
            <?php if (isset($errorInfo['response'])): ?>
                <br>Respuesta Completa:
                <pre><?php print_r($errorInfo['response']); ?></pre>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if (!$courseCloned): ?>
        <form action="/sie/moodle/courses/clone" method="POST">
            <div class="mb-3">
                <label for="original_course_id" class="form-label">ID del Curso Original a Clonar <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="original_course_id" name="original_course_id" required
                       value="<?php echo htmlspecialchars($_POST['original_course_id'] ?? $originalCourseId ?? ''); ?>">
            </div>

            <div class="mb-3">
                <label for="fullname" class="form-label">Nuevo Nombre Completo del Curso <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="fullname" name="fullname" required
                       value="<?php echo htmlspecialchars($_POST['fullname'] ?? 'Copia de '); ?>">
            </div>

            <div class="mb-3">
                <label for="shortname" class="form-label">Nuevo Nombre Corto del Curso <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="shortname" name="shortname" required
                       value="<?php echo htmlspecialchars($_POST['shortname'] ?? 'copia_'); ?>">
                <div class="form-text">Debe ser único.</div>
            </div>

            <div class="mb-3">
                <label for="categoryid" class="form-label">ID de Categoría Destino <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="categoryid" name="categoryid" required
                       value="<?php echo htmlspecialchars($_POST['categoryid'] ?? 1); ?>">
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="visible" name="visible"
                       value="1" <?php echo (isset($_POST['visible']) && $_POST['visible'] == '1') || !$_POST ? 'checked' : ''; ?>>
                <label class="form-check-label" for="visible">Hacer visible el curso clonado</label>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="include_users" name="include_users"
                       value="1" <?php echo isset($_POST['include_users']) && $_POST['include_users'] == '1' ? 'checked' : ''; ?>>
                <label class="form-check-label" for="include_users">Incluir usuarios matriculados</label>
            </div>

            <button type="submit" class="btn btn-primary">Clonar Curso</button>
            <a href="/sie/moodle/courses/list" class="btn btn-secondary">Cancelar y Volver</a>
        </form>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
