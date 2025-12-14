<?php
/**
 * Listar Usuarios de Moodle
 *
 * Este script obtiene y muestra todos los usuarios registrados en Moodle
 * utilizando la API REST de Moodle y presenta los resultados en una tabla
 * con formato Bootstrap 5.
 *
 * @author Cascade
 * @version 1.0
 */

/***********************
 *  Configuración básica
 ***********************/
$token = service("moodle")::getToken();
$domain = service("moodle")::getDomainName();
$endpoint = "$domain/webservice/rest/server.php";

// Variables para controlar el resultado
$users = [];
$errorInfo = null;
$debugInfo = '';
$totalUsers = 0;
$successfulMethod = null;

/**
 * Obtiene todos los usuarios utilizando el método field=id
 *
 * @param string $token Token de autenticación de Moodle
 * @param string $endpoint URL del endpoint de la API REST de Moodle
 * @return array Array con la respuesta y código HTTP
 */
function obtenerTodosLosUsuarios($token, $endpoint)
{
    // Parámetros para obtener todos los usuarios
    $params = [
            'field' => 'id',
            'values' => [] // Array vacío para obtener todos los usuarios
    ];

    // URL completa con token y formato
    $url = $endpoint . '?wstoken=' . $token . '&wsfunction=core_user_get_users_by_field&moodlewsrestformat=json';

    return realizarPeticion($url, $params);
}

/**
 * Método alternativo para obtener usuarios mediante el campo email
 *
 * @param string $token Token de autenticación de Moodle
 * @param string $endpoint URL del endpoint de la API REST de Moodle
 * @return array Array con la respuesta y código HTTP
 */
function obtenerUsuariosPorEmail($token, $endpoint)
{
    $params = [
            'criteria' => [
                    [
                            'key' => 'email',
                            'value' => '%' // Buscar emails que contengan cualquier carácter
                    ]
            ]
    ];

    $url = $endpoint . '?wstoken=' . $token . '&wsfunction=core_user_get_users&moodlewsrestformat=json';

    return realizarPeticion($url, $params);
}

/**
 * Realiza una petición HTTP a la API de Moodle
 *
 * @param string $url URL completa para la petición
 * @param array $params Parámetros a enviar en la petición
 * @return array Array con la respuesta y código HTTP
 */
function realizarPeticion($url, $params)
{
    $curl = curl_init();
    curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 60, // Mayor timeout para listas grandes
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTPHEADER => [
                    'Content-Type: application/x-www-form-urlencoded',
                    'Accept: application/json'
            ]
    ]);

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    return [
            'response' => $response,
            'httpCode' => $httpCode
    ];
}

/**
 * Intenta obtener los usuarios mediante diferentes métodos
 */

// Método 1: Obtener por ID (principal)
$debugInfo .= "<strong>Intentando obtener usuarios por ID:</strong><br>";
$result = obtenerTodosLosUsuarios($token, $endpoint);
$response = $result['response'];
$httpCode = $result['httpCode'];

if ($response === false) {
    $debugInfo .= "❌ Error cURL<br><br>";
} else {
    $debugInfo .= "Código HTTP: $httpCode<br>";
    $data = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        $debugInfo .= "❌ Error JSON: " . json_last_error_msg() . "<br><br>";
    } elseif (isset($data['exception'])) {
        $debugInfo .= "❌ Error Moodle: " . htmlspecialchars($data['message'] ?? 'Error desconocido') . "<br><br>";
    } elseif (is_array($data) && !isset($data['exception'])) {
        // Para core_user_get_users_by_field, la respuesta puede ser directamente un array
        $users = $data;
        $totalUsers = count($users);
        $successfulMethod = "Método ID";
        $debugInfo .= "✅ Éxito: $totalUsers usuarios encontrados<br><br>";
    } else {
        $debugInfo .= "❌ Estructura de respuesta inesperada<br><br>";
    }
}

// Si el primer método falló, intentar con email
if (empty($users)) {
    $debugInfo .= "<strong>Intentando obtener usuarios por Email:</strong><br>";
    $result = obtenerUsuariosPorEmail($token, $endpoint);
    $response = $result['response'];

    if ($response !== false) {
        $data = json_decode($response, true);
        if (isset($data['users'])) {
            $users = $data['users'];
            $totalUsers = count($users);
            $successfulMethod = "Método Email";
            $debugInfo .= "✅ Éxito con email: $totalUsers usuarios encontrados<br>";
        }
    }
}

if (empty($users) && !$successfulMethod) {
    $errorInfo = "No se pudo obtener usuarios. Verifica los permisos del token.";
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Usuarios de Moodle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            padding: 20px;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 1200px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            padding: 20px;
        }

        .header-section {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .table-container {
            max-height: 600px;
            overflow-y: auto;
        }

        .table thead th {
            position: sticky;
            top: 0;
            background-color: #f8f9fa;
            z-index: 1;
        }

        .debug-info {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            font-family: monospace;
            font-size: 12px;
            max-height: 300px;
            overflow-y: auto;
        }

        .search-box {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header-section">
        <h1><i class="fas fa-users"></i> Listado de Usuarios de Moodle</h1>
        <p>Sistema de visualización de usuarios registrados en la plataforma Moodle</p>
    </div>

    <?php if ($successfulMethod): ?>
        <!-- Estadísticas y recuento -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card bg-light">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col">
                                <h3 class="text-primary"><?php echo $totalUsers; ?></h3>
                                <p class="text-muted mb-0">Total de Usuarios</p>
                            </div>
                            <div class="col">
                                <h3 class="text-success"><?php echo $successfulMethod; ?></h3>
                                <p class="text-muted mb-0">Método de Obtención</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Buscador -->
        <div class="search-box">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" id="userSearch" class="form-control"
                       placeholder="Buscar por nombre, apellido, email o username...">
            </div>
        </div>

        <!-- Tabla de usuarios -->
        <div class="table-container">
            <table class="table table-striped table-hover">
                <thead class="table-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">Avatar</th>
                    <th scope="col">Username</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellidos</th>
                    <th scope="col">Email</th>
                    <th scope="col">Último Acceso</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $index => $user): ?>
                        <tr class="user-row">
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($user['id'] ?? 'N/A'); ?></td>
                            <td>
                                <?php if (!empty($user['profileimageurl'])): ?>
                                    <img src="<?php echo htmlspecialchars($user['profileimageurl']); ?>"
                                         alt="Avatar" class="rounded-circle" width="40" height="40">
                                <?php else: ?>
                                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                                         style="width: 40px; height: 40px;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($user['username'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($user['firstname'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($user['lastname'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($user['email'] ?? 'N/A'); ?></td>
                            <td>
                                <?php
                                if (!empty($user['lastaccess'])) {
                                    echo date('d/m/Y H:i', $user['lastaccess']);
                                } else {
                                    echo 'Nunca';
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">No se encontraron usuarios</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

    <?php elseif ($errorInfo): ?>
        <!-- Mensaje de error -->
        <div class="alert alert-danger">
            <h4 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> Error</h4>
            <p><?php echo $errorInfo; ?></p>
            <hr>
            <p class="mb-0">Posibles soluciones:</p>
            <ul>
                <li>Verificar que el token tenga permisos para funciones de usuario</li>
                <li>Asegurarse de que los servicios web estén habilitados</li>
                <li>Revisar la configuración del dominio y endpoint</li>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Información de debug (colapsible) -->
    <div class="accordion mt-4">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#debugCollapse">
                    🔍 Información de Debug
                </button>
            </h2>
            <div id="debugCollapse" class="accordion-collapse collapse">
                <div class="accordion-body">
                    <div class="debug-info">
                        <?php echo $debugInfo; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    /**
     * Inicializa el buscador de usuarios
     * Permite filtrar la tabla por cualquier campo visible
     */
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('userSearch');

        if (searchInput) {
            searchInput.addEventListener('keyup', function () {
                const searchText = this.value.toLowerCase();
                const rows = document.querySelectorAll('tbody .user-row');

                rows.forEach(function (row) {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchText) ? '' : 'none';
                });

                // Mostrar mensaje si no hay resultados
                const visibleRows = document.querySelectorAll('tbody .user-row:not([style="display: none;"])');
                const noResults = document.querySelector('.no-results');

                if (visibleRows.length === 0 && searchText !== '') {
                    if (!noResults) {
                        const tbody = document.querySelector('tbody');
                        const tr = document.createElement('tr');
                        tr.className = 'no-results';
                        tr.innerHTML = '<td colspan="8" class="text-center">No se encontraron resultados para "' + searchText + '"</td>';
                        tbody.appendChild(tr);
                    }
                } else if (noResults) {
                    noResults.remove();
                }
            });
        }
    });
</script>
</body>
</html>