<?php
// Configuración inicial para la API de Moodle
$token = 'a99cf98a32a7bc899e0e9c45e4f50b8f'; // Deberías gestionar esto de forma más segura
$domainName = 'https://campus2025b.utede.edu.co';
$functionName = 'core_course_duplicate_course';
$restFormat = 'json';

$originalCourseId = null;
$courseCloned = false;
$errorInfo = null;
$clonedCourseDetails = null;

// 1. Obtener el ID del curso original desde el parámetro GET
if (isset($_GET['oid'])) {
    $originalCourseId = (int)$_GET['oid'];
} else {
    $errorInfo = ['message' => 'No se especificó el ID del curso a clonar (parámetro oid).'];
}

// Procesar el formulario cuando se envía y si tenemos un ID de curso original
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $originalCourseId) {
    // Recoger los datos del formulario
    $fullname = trim($_POST['fullname'] ?? '');
    $shortname = trim($_POST['shortname'] ?? '');
    $categoryid = (int)($_POST['categoryid'] ?? 1);
    $visible = isset($_POST['visible']) ? 1 : 0;
    $includeUsers = isset($_POST['include_users']) ? 1 : 0;


    // Validación simple
    if (empty($fullname) || empty($shortname) || empty($categoryid)) {
        $errorInfo = ['message' => 'Nombre completo, nombre corto y ID de categoría son obligatorios para el clon.'];
    } else {
        // Preparar los parámetros para la duplicación del curso
        $params = [
            'courseid' => $originalCourseId,
            'fullname' => $fullname,
            'shortname' => $shortname,
            'categoryid' => $categoryid,
            'visible' => $visible, // Controla la visibilidad del nuevo curso
            'options' => [
                [
                    'name' => 'users', // No incluir usuarios matriculados
                    'value' => $includeUsers
                ]
                // Puedes añadir más opciones aquí si es necesario, por ejemplo:
                // ['name' => 'activities', 'value' => 1], // incluir actividades
                // ['name' => 'blocks', 'value' => 1],     // incluir bloques
                // ['name' => 'filters', 'value' => 1],    // incluir filtros
            ]
        ];

        // Montar la URL de llamada REST
        // La API core_course_duplicate_course espera todos los parámetros en la URL, incluso con POST.
        $serverUrl = $domainName . '/webservice/rest/server.php'
            . '?wstoken=' . $token
            . '&wsfunction=' . $functionName
            . '&moodlewsrestformat=' . $restFormat
            . '&' . http_build_query($params);


        // Inicializar cURL y configurar la petición
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $serverUrl);
        curl_setopt($curl, CURLOPT_POST, true); // Aunque los parámetros van en URL, la API espera POST.
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, []); // Cuerpo POST vacío, ya que todo está en la URL.


        // SSL Settings - ¡IMPORTANTE PARA DESARROLLO VS PRODUCCIÓN!
        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        // Para desarrollo local (XAMPP) si hay problemas de SSL:
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
    <style>
        body {
            padding-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Clonar Curso en Moodle</h1>

    <?php if (!$originalCourseId && !isset($_POST['original_course_id'])): // Solo mostrar si no hay oid y no es un reintento de POST ?>
        <div class="alert alert-danger" role="alert">
            <strong>Error:</strong> No se ha especificado un curso para clonar. Por favor, accede a esta página desde un
            enlace válido en la lista de cursos.
            <?php if ($errorInfo && $errorInfo['message'] === 'No se especificó el ID del curso a clonar (parámetro oid).') echo htmlspecialchars($errorInfo['message']); ?>
        </div>
    <?php else: ?>

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

        <?php if (!$courseCloned): // Mostrar formulario solo si no se ha clonado o si hubo un error para reintentar ?>
            <p>Estás a punto de clonar el curso con ID:
                <strong><?php echo htmlspecialchars($originalCourseId); ?></strong>.</p>
            <p>Por favor, proporciona los detalles para el nuevo curso clonado.</p>

            <form action="/sie/moodle/courses/clone?oid=<?php echo(htmlspecialchars($originalCourseId)); ?>"
                  method="POST">
                <!-- Campo oculto para mantener el ID original en caso de re-envío si GET se pierde -->
                <input type="hidden" name="original_course_id"
                       value="<?php echo htmlspecialchars($originalCourseId); ?>">


                <div class="mb-3">
                    <label for="fullname" class="form-label">Nuevo Nombre Completo del Curso <span
                                class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="fullname" name="fullname" required
                           value="<?php echo htmlspecialchars($_POST['fullname'] ?? 'Copia de '); ?>">
                </div>

                <div class="mb-3">
                    <label for="shortname" class="form-label">Nuevo Nombre Corto del Curso <span
                                class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="shortname" name="shortname" required
                           value="<?php echo htmlspecialchars($_POST['shortname'] ?? 'copia_'); ?>">
                    <div class="form-text">Debe ser único.</div>
                </div>

                <div class="mb-3">
                    <label for="categoryid" class="form-label">ID de Categoría Destino <span
                                class="text-danger">*</span></label>
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
                    <label class="form-check-label" for="include_users">Incluir usuarios matriculados (¡No recomendado
                        para un clon típico!)</label>
                </div>

                <button type="submit" class="btn btn-primary">Clonar Curso</button>
                <a href="/sie/moodle/courses/list" class="btn btn-secondary">Cancelar y Volver</a>
                <!-- Ajusta esta URL -->
            </form>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
