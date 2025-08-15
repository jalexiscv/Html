<?php
/**********************
 *  Configuración para eliminar usuario por username (alias)
 **********************/
$token = 'ce890746630ebf2c6b7baf4dde8f41b4';
$domain = 'https://campus.utede.edu.co';
$endpoint = "$domain/webservice/rest/server.php";

$functionGet = 'core_user_get_users';
$functionDelete = 'core_user_delete_users';

$errorInfo = null;
$deletedUserId = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = strtolower(trim($_POST['username'] ?? ''));
    $username = preg_replace('/[^a-z0-9._-]/', '', $username);

    if (!$username) {
        $errorInfo = 'Debe ingresar un alias (username) válido.';
    } else {
        // 1. Buscar usuario por username
        $searchParams = http_build_query([
                'criteria' => [['key' => 'username', 'value' => $username]]
        ]);

        $urlGet = "$endpoint?wstoken=$token&wsfunction=$functionGet&moodlewsrestformat=json&$searchParams";

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
            $userId = $result['users'][0]['id'];

            // 2. Eliminar usuario por ID
            $deleteParams = http_build_query(['userids' => [$userId]]);
            $urlDelete = "$endpoint?wstoken=$token&wsfunction=$functionDelete&moodlewsrestformat=json";

            $curl = curl_init($urlDelete);
            curl_setopt_array($curl, [
                    CURLOPT_POST => true,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POSTFIELDS => $deleteParams,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
            ]);

            $deleteResponse = curl_exec($curl);
            curl_close($curl);

            $deletedUserId = $userId;
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
    <title>Eliminar Usuario por Alias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body {
            padding-top: 20px;
        }</style>
</head>
<body>
<div class="container">
    <h1>Eliminar Usuario en Moodle</h1>

    <?php if ($deletedUserId): ?>
        <div class="alert alert-success">
            Usuario con ID <strong><?php echo htmlspecialchars($deletedUserId); ?></strong> eliminado con éxito.
        </div>
    <?php elseif ($errorInfo): ?>
        <div class="alert alert-danger">
            <strong>Error:</strong> <?php echo htmlspecialchars($errorInfo); ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Alias del Usuario (username) <span
                        class="text-danger">*</span></label>
            <input type="text" class="form-control" name="username" id="username" required>
        </div>
        <button type="submit" class="btn btn-danger">Eliminar Usuario</button>
        <a href="/sie/moodle/users/list" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>