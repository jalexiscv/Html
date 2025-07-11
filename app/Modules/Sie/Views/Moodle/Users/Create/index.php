<?php
/**********************
 *  Configuración básica
 **********************/
$token    = 'd9551c4aa62771d4a38d74b1e885b13d';
$domain   = 'https://campus2025b.utede.edu.co';
$function = 'core_user_create_users';
$endpoint = "$domain/webservice/rest/server.php";

$createdUserId = null;
$errorInfo = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username   = trim($_POST['username'] ?? '');
    $password   = $_POST['password'] ?? '';
    $firstname  = trim($_POST['firstname'] ?? '');
    $lastname   = trim($_POST['lastname'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $auth       = $_POST['auth'] ?? 'manual';
    $lang       = $_POST['lang'] ?? 'es';
    $city       = $_POST['city'] ?? '';
    $country    = $_POST['country'] ?? '';
    $idnumber   = $_POST['idnumber'] ?? '';

    // Sanitizar username
    $username = strtolower(preg_replace('/[^a-z0-9._-]/', '', $username));

    // Validar username
    if (!preg_match('/^[a-z0-9._-]+$/', $username)) {
        $errorInfo = 'El nombre de usuario solo puede contener letras minúsculas, números, puntos, guiones y guiones bajos, sin espacios.';
    } elseif (!$username || !$password || !$firstname || !$lastname || !$email) {
        $errorInfo = 'Todos los campos obligatorios deben ser completados.';
    } else {
        $nuevoUsuario = [
            'username'  => $username,
            'password'  => $password,
            'firstname' => $firstname,
            'lastname'  => $lastname,
            'email'     => $email,
            'auth'      => $auth,
            'lang'      => $lang,
            'city'      => $city,
            'country'   => $country,
            'idnumber'  => $idnumber
        ];

        $params = http_build_query(['users' => [$nuevoUsuario]]);
        $url = $endpoint . '?wstoken=' . $token . '&wsfunction=' . $function . '&moodlewsrestformat=json';

        $curl = curl_init($url);
        curl_setopt_array($curl, [
            CURLOPT_POST           => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS     => $params,
        ]);

        $response = curl_exec($curl);
        if ($response === false) {
            $errorInfo = 'Error cURL: ' . curl_error($curl);
        }
        curl_close($curl);

        $result = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $errorInfo = "Respuesta no es JSON válido: $response";
        } elseif (isset($result[0]['id'])) {
            $createdUserId = $result[0]['id'];
        } elseif (isset($result['exception'])) {
            $errorInfo = $result['message'] ?? 'Error desconocido al crear el usuario.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario en Moodle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body { padding-top: 20px; }</style>
</head>
<body>
<div class="container">
    <h1>Crear Usuario en Moodle</h1>

    <?php if ($createdUserId): ?>
        <div class="alert alert-success">Usuario creado con éxito. ID: <strong><?php echo $createdUserId; ?></strong></div>
    <?php elseif ($errorInfo): ?>
        <div class="alert alert-danger"><strong>Error:</strong> <?php echo htmlspecialchars($errorInfo); ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="mb-3">
            <label class="form-label">Nombre de usuario *</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Contraseña *</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nombre *</label>
            <input type="text" name="firstname" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Apellido *</label>
            <input type="text" name="lastname" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Correo Electrónico *</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Autenticación</label>
            <input type="text" name="auth" class="form-control" value="manual">
        </div>
        <div class="mb-3">
            <label class="form-label">Idioma</label>
            <input type="text" name="lang" class="form-control" value="es">
        </div>
        <div class="mb-3">
            <label class="form-label">Ciudad</label>
            <input type="text" name="city" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">País</label>
            <input type="text" name="country" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">ID Number</label>
            <input type="text" name="idnumber" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Crear Usuario</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
