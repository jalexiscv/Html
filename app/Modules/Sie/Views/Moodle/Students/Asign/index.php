<?php
/**********************
 *  Configuración
 **********************/
$token = 'ce890746630ebf2c6b7baf4dde8f41b4';
$domain = 'https://campus.utede.edu.co';
$endpoint = "$domain/webservice/rest/server.php";

$functionGetUser = 'core_user_get_users';
$functionEnroll  = 'enrol_manual_enrol_users';

$errorInfo = null;
$successMsg = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = strtolower(trim($_POST['username'] ?? ''));
    $username = preg_replace('/[^a-z0-9._-]/', '', $username);
    $courseid = (int)($_POST['courseid'] ?? 0);
    $role     = $_POST['role'] ?? 'student';

    $roleidMap = [
        'student' => 5,  // ID por defecto en Moodle para estudiante
        'teacher' => 3   // ID por defecto para profesor
    ];

    if (!$username || !$courseid || !isset($roleidMap[$role])) {
        $errorInfo = 'Debes completar todos los campos correctamente.';
    } else {
        // 1. Obtener ID del usuario
        $searchParams = http_build_query([
            'criteria' => [['key' => 'username', 'value' => $username]]
        ]);

        $urlGet = "$endpoint?wstoken=$token&wsfunction=$functionGetUser&moodlewsrestformat=json&$searchParams";

        $curl = curl_init($urlGet);
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        $result = json_decode($response, true);

        if (!empty($result['users'][0]['id'])) {
            $userid = $result['users'][0]['id'];
            $roleid = $roleidMap[$role];

            // 2. Enrolar usuario en curso
            $enrolParams = http_build_query([
                'enrolments' => [[
                    'roleid'    => $roleid,
                    'userid'    => $userid,
                    'courseid'  => $courseid
                ]]
            ]);

            $urlEnroll = "$endpoint?wstoken=$token&wsfunction=$functionEnroll&moodlewsrestformat=json";

            $curl = curl_init($urlEnroll);
            curl_setopt_array($curl, [
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS => $enrolParams,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
            ]);

            $enrolResponse = curl_exec($curl);
            curl_close($curl);

            $enrolResult = json_decode($enrolResponse, true);

            if (empty($enrolResult)) {
                $successMsg = "Usuario '$username' inscrito en el curso con rol de '$role'.";
            } elseif (isset($enrolResult['exception'])) {
                $errorInfo = $enrolResult['message'] ?? 'Error al enrolar al usuario.';
            } else {
                $errorInfo = 'Respuesta inesperada al intentar enrolar al usuario.';
            }
        } else {
            $errorInfo = 'No se encontró un usuario con ese alias.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Usuario a Curso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body { padding-top: 20px; }</style>
</head>
<body>
<div class="container">
    <h1>Asignar Usuario a Curso</h1>

    <?php if ($successMsg): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($successMsg); ?></div>
    <?php elseif ($errorInfo): ?>
        <div class="alert alert-danger"><strong>Error:</strong> <?php echo htmlspecialchars($errorInfo); ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Alias del Usuario (username) *</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="courseid" class="form-label">ID del Curso *</label>
            <input type="number" name="courseid" id="courseid" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Rol a Asignar *</label>
            <select name="role" id="role" class="form-select" required>
                <option value="student">Estudiante</option>
                <option value="teacher">Profesor</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Asignar Usuario</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
