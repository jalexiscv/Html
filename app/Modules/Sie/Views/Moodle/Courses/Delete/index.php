<?php
// Configuración inicial para la API de Moodle
$token = service("moodle")::getToken();
$domainName = service("moodle")::getDomainName();
$functionName = 'core_course_delete_courses';
$restFormat = 'json';

$courseDeleted = false;
$errorInfo = null;
$courseIdToDelete = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $courseIdToDelete = isset($_POST['course_id']) ? (int)$_POST['course_id'] : null;

    if ($courseIdToDelete) {
        $params = [
                'courseids' => [$courseIdToDelete]
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
                        'message' => 'Error al eliminar el curso: ' . ($result['message'] ?? 'Error desconocido.'),
                        'exception' => $result['exception'] ?? 'N/A',
                        'errorcode' => $result['errorcode'] ?? 'N/A',
                        'debuginfo' => $result['debuginfo'] ?? 'No debug info'
                ];
            } else {
                $courseDeleted = true;
            }
        }
        curl_close($curl);
    } else {
        $errorInfo = ['message' => 'Debe ingresar un ID de curso válido.'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Curso en Moodle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body {
            padding-top: 20px;
        }</style>
</head>
<body>
<div class="container">
    <h1>Eliminar Curso en Moodle</h1>

    <?php if ($courseDeleted): ?>
        <div class="alert alert-success" role="alert">
            Curso eliminado con éxito. ID: <strong><?php echo htmlspecialchars($courseIdToDelete); ?></strong>
        </div>
    <?php endif; ?>

    <?php if ($errorInfo): ?>
        <div class="alert alert-danger" role="alert">
            <strong>Error:</strong> <?php echo htmlspecialchars($errorInfo['message']); ?>
            <?php if (isset($errorInfo['exception'])): ?>
                <br>Excepción: <?php echo htmlspecialchars($errorInfo['exception']); ?>
                <br>Código de Error: <?php echo htmlspecialchars($errorInfo['errorcode']); ?>
            <?php endif; ?>
            <?php if (isset($errorInfo['debuginfo'])): ?>
                <br>Debug Info: <?php echo htmlspecialchars($errorInfo['debuginfo']); ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="mb-3">
            <label for="course_id" class="form-label">ID del Curso a Eliminar <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="course_id" name="course_id" required
                   value="<?php echo htmlspecialchars($_POST['course_id'] ?? ''); ?>">
        </div>

        <button type="submit" class="btn btn-danger">Eliminar Curso</button>
        <a href="/sie/moodle/courses/list" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
