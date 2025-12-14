<?php
/**********************
 *  Configuración básica
 **********************/
$token = service("moodle")::getToken();
$domain = service("moodle")::getDomainName();
$endpoint = "$domain/webservice/rest/server.php";
$function = 'core_user_get_users_by_field'; // Función más eficiente para obtener todos los usuarios


$users = [];
$errorInfo = null;
$debugInfo = '';
$totalUsers = 0;

// MÉTODO 1: Usar core_user_get_users_by_field (más eficiente)
// Este método permite obtener usuarios por diferentes campos
function getAllUsersMethod1($token, $endpoint)
{
    $params = [
            'field' => 'id',
            'values' => [] // Array vacío para obtener todos
    ];

    $url = $endpoint . '?wstoken=' . $token . '&wsfunction=core_user_get_users_by_field&moodlewsrestformat=json';

    return makeRequest($url, $params);
}

// MÉTODO 2: Usar core_user_get_users con criterios amplios
function getAllUsersMethod2($token, $endpoint)
{
    $params = [
            'criteria' => [
                    [
                            'key' => 'firstname',
                            'value' => '%' // Wildcard para buscar cualquier nombre
                    ]
            ]
    ];

    $url = $endpoint . '?wstoken=' . $token . '&wsfunction=core_user_get_users&moodlewsrestformat=json';

    return makeRequest($url, $params);
}

// MÉTODO 3: Usar core_user_get_users con email (más compatible)
function getAllUsersMethod3($token, $endpoint)
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

    return makeRequest($url, $params);
}

// MÉTODO 4: Para instalaciones muy grandes - paginación
function getAllUsersPaginated($token, $endpoint, $limitfrom = 0, $limitnum = 100)
{
    $params = [
            'criteria' => [
                    [
                            'key' => 'email',
                            'value' => '%'
                    ]
            ],
            'limitfrom' => $limitfrom,
            'limitnum' => $limitnum
    ];

    $url = $endpoint . '?wstoken=' . $token . '&wsfunction=core_user_get_users&moodlewsrestformat=json';

    return makeRequest($url, $params);
}

// Función para actualizar contraseña de un usuario
function updateUserPassword($token, $endpoint, $userId, $newPassword)
{
    $params = [
            'users' => [
                    [
                            'id' => $userId,
                            'password' => $newPassword
                    ]
            ]
    ];

    $url = $endpoint . '?wstoken=' . $token . '&wsfunction=core_user_update_users&moodlewsrestformat=json';

    return makeRequest($url, $params);
}

function makeRequest($url, $params)
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

// Manejar actualización individual via AJAX
if (isset($_POST['action']) && $_POST['action'] === 'update_single') {
    $userId = $_POST['user_id'] ?? null;
    $newPassword = $_POST['new_password'] ?? null;
    $username = $_POST['username'] ?? null;

    // Verificar si es el usuario admin
    if ($username === 'admin') {
        http_response_code(403); // Código de prohibido
        echo json_encode([
                'success' => false,
                'message' => 'No se permite actualizar la contraseña del usuario admin por razones de seguridad'
        ]);
        exit;
    }

    if ($userId && $newPassword) {
        $result = updateUserPassword($token, $endpoint, $userId, $newPassword);
        $response = json_decode($result['response'], true);

        if (!isset($response['exception'])) {
            http_response_code(200);
            echo json_encode(['success' => true, 'message' => 'Contraseña actualizada']);
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $response['message'] ?? 'Error desconocido']);
        }
        exit;
    }
}

// Intentar diferentes métodos
$methods = [
        'Método 1 (core_user_get_users_by_field)' => 'getAllUsersMethod1',
        'Método 2 (firstname con %)' => 'getAllUsersMethod2',
        'Método 3 (email con %)' => 'getAllUsersMethod3'
];

$successfulMethod = null;

foreach ($methods as $methodName => $methodFunction) {
    $debugInfo .= "<strong>Probando $methodName:</strong><br>";

    $result = $methodFunction($token, $endpoint);
    $response = $result['response'];
    $httpCode = $result['httpCode'];

    if ($response === false) {
        $debugInfo .= "❌ Error cURL<br><br>";
        continue;
    }

    $debugInfo .= "Código HTTP: $httpCode<br>";

    $data = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        $debugInfo .= "❌ Error JSON: " . json_last_error_msg() . "<br><br>";
        continue;
    }

    if (isset($data['exception'])) {
        $debugInfo .= "❌ Error Moodle: " . htmlspecialchars($data['message'] ?? 'Error desconocido') . "<br><br>";
        continue;
    }

    // Verificar estructura de respuesta
    if (isset($data['users'])) {
        $users = $data['users'];
        $totalUsers = count($users);
        $successfulMethod = $methodName;
        $debugInfo .= "✅ Éxito: $totalUsers usuarios encontrados<br><br>";
        break;
    } elseif (is_array($data) && !isset($data['exception'])) {
        // Para core_user_get_users_by_field, la respuesta puede ser directamente un array
        $users = $data;
        $totalUsers = count($users);
        $successfulMethod = $methodName;
        $debugInfo .= "✅ Éxito: $totalUsers usuarios encontrados<br><br>";
        break;
    } else {
        $debugInfo .= "❌ Estructura de respuesta inesperada<br><br>";
    }
}

// Si ningún método funcionó, intentar paginación
if (empty($users)) {
    $debugInfo .= "<strong>Probando método paginado:</strong><br>";
    $paginatedResult = getAllUsersPaginated($token, $endpoint, 0, 50);
    $response = $paginatedResult['response'];

    if ($response !== false) {
        $data = json_decode($response, true);
        if (isset($data['users'])) {
            $users = $data['users'];
            $totalUsers = count($users);
            $successfulMethod = "Método paginado (primeros 50)";
            $debugInfo .= "✅ Éxito paginado: $totalUsers usuarios encontrados<br>";
        }
    }
}

if (empty($users) && !$successfulMethod) {
    $errorInfo = "No se pudo obtener usuarios con ningún método. Verifica los permisos del token.";
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado Completo de Usuarios - Moodle v2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 20px;
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

        .user-stats {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .table-container {
            max-height: 600px;
            overflow-y: auto;
        }

        .search-box {
            margin-bottom: 15px;
        }

        .start-point-section {
            background: #e8f4fd;
            border: 2px solid #b3d7ff;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .user-preview {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 10px;
            margin-top: 10px;
            font-family: monospace;
            font-size: 12px;
        }

        .range-highlight {
            background-color: #fff3cd !important;
            border: 2px solid #ffc107 !important;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <h1>Listado Completo de Usuarios - Moodle v2</h1>

    <?php if ($successfulMethod): ?>
        <div class="user-stats">
            <h3>📊 Estadísticas</h3>
            <div class="row">
                <div class="col-md-3">
                    <h4><?php echo $totalUsers; ?></h4>
                    <p>Total de Usuarios</p>
                </div>
                <div class="col-md-3">
                    <h4 id="processedCount">0</h4>
                    <p>Procesados</p>
                </div>
                <div class="col-md-3">
                    <h4 id="successCount">0</h4>
                    <p>Exitosos</p>
                </div>
                <div class="col-md-3">
                    <h4 id="errorCount">0</h4>
                    <p>Errores</p>
                </div>
            </div>

            <!-- Barra de progreso -->
            <div class="mt-3" id="progressContainer" style="display: none;">
                <div class="d-flex justify-content-between mb-1">
                    <span>Progreso de actualización</span>
                    <span id="progressText">0%</span>
                </div>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                         id="progressBar" role="progressbar" style="width: 0%"></div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Información de debug (colapsible) -->
    <div class="accordion mb-3">
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

    <?php if ($errorInfo): ?>
        <div class="alert alert-danger">
            <strong>❌ Error:</strong> <?php echo $errorInfo; ?>
            <hr>
            <strong>Posibles soluciones:</strong>
            <ul>
                <li>Verificar que el token tenga permisos para funciones de usuario</li>
                <li>Asegurarse de que los servicios web estén habilitados</li>
                <li>Revisar los logs de Moodle para más detalles</li>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (!empty($users)): ?>
        <!-- Panel de control para actualización masiva -->
        <div class="card mb-4 border-warning">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">🔐 Actualización Masiva de Contraseñas</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <strong>ℹ️ Acción:</strong> Establecer la contraseña de cada usuario igual a su
                    <code>username</code>
                </div>

                <!-- Nueva sección para seleccionar punto de inicio -->
                <div class="start-point-section">
                    <h6 class="text-primary mb-3">🎯 Configurar Punto de Inicio</h6>

                    <div class="row">
                        <div class="col-md-4">
                            <label for="startPointSelect" class="form-label">Seleccionar método:</label>
                            <select class="form-select" id="startPointSelect" onchange="updateStartPointOptions()">
                                <option value="beginning">📍 Desde el inicio (registro #1)</option>
                                <option value="position">📍 Desde posición específica</option>
                                <option value="user_id">👤 Desde ID de usuario específico</option>
                                <option value="username">🔤 Desde username específico</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <div id="positionInput" style="display: none;">
                                <label for="startPosition" class="form-label">Posición en la lista:</label>
                                <input type="number" class="form-control" id="startPosition"
                                       min="1" max="<?php echo $totalUsers; ?>" value="1"
                                       placeholder="Ej: 1, 50, 100..." onchange="previewStartPoint()">
                                <small class="text-muted">Entre 1 y <?php echo $totalUsers; ?></small>
                            </div>

                            <div id="userIdInput" style="display: none;">
                                <label for="startUserId" class="form-label">ID del usuario:</label>
                                <input type="number" class="form-control" id="startUserId"
                                       placeholder="Ej: 123, 456..." onchange="previewStartPoint()">
                                <small class="text-muted">ID numérico del usuario en Moodle</small>
                            </div>

                            <div id="usernameInput" style="display: none;">
                                <label for="startUsername" class="form-label">Username:</label>
                                <input type="text" class="form-control" id="startUsername"
                                       placeholder="Ej: juan.perez, admin..." onchange="previewStartPoint()">
                                <small class="text-muted">Username exacto (sensible a mayúsculas)</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Vista previa:</label>
                            <div id="startPointPreview" class="user-preview">
                                <strong>📍 Punto de inicio:</strong><br>
                                Posición: 1<br>
                                Usuario: <?php echo htmlspecialchars($users[0]['username'] ?? 'N/A'); ?>
                                (ID: <?php echo $users[0]['id'] ?? 'N/A'; ?>)<br>
                                <small class="text-success">✅ Se procesarán todos los <?php echo $totalUsers; ?>
                                    usuarios</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-outline-info btn-sm" onclick="highlightRange()">
                                👁️ Resaltar rango en la tabla
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="clearHighlight()">
                                🧹 Limpiar resaltado
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <p><strong>⚠️ ADVERTENCIA:</strong> Esta acción afectará a <span
                                    id="usersToProcessCount"><?php echo $totalUsers; ?></span> usuarios y no se puede
                            deshacer fácilmente.</p>
                        <ul class="small">
                            <li>Se procesarán uno por uno con pausas de 500ms entre cada usuario</li>
                            <li>La contraseña será igual al username de cada usuario</li>
                            <li>Podrás ver el progreso en tiempo real</li>
                            <li>Se recomienda notificar a los usuarios del cambio</li>
                        </ul>
                    </div>
                    <div class="col-md-4 text-end">
                        <button type="button" id="massUpdateBtn" class="btn btn-warning btn-lg"
                                onclick="startMassUpdate()">
                            🔄 Actualizar Contraseñas
                        </button>
                        <button type="button" id="stopUpdateBtn" class="btn btn-danger btn-lg"
                                style="display: none;" onclick="stopMassUpdate()">
                            ⏹️ Detener Proceso
                        </button>
                    </div>
                </div>

                <!-- Log de actividad -->
                <div id="activityLog" class="mt-3" style="display: none;">
                    <h6>📋 Log de Actividad:</h6>
                    <div id="logContent" class="bg-light p-3 rounded"
                         style="height: 200px; overflow-y: auto; font-family: monospace; font-size: 12px;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Buscador -->
        <div class="search-box">
            <input type="text" id="userSearch" class="form-control"
                   placeholder="🔍 Buscar por nombre, email o username...">
        </div>

        <!-- Tabla de usuarios -->
        <div class="table-container">
            <table class="table table-striped table-bordered" id="usersTable">
                <thead class="table-dark sticky-top">
                <tr>
                    <th style="width: 60px;">#</th>
                    <th style="width: 60px;">ID</th>
                    <th style="width: 120px;">Username</th>
                    <th>Nombre Completo</th>
                    <th>Email</th>
                    <th style="width: 100px;">Estado</th>
                    <th style="width: 120px;">Último Acceso</th>
                    <th style="width: 120px;">Acción Individual</th>
                </tr>
                </thead>
                <tbody id="usersTableBody">
                <?php foreach ($users as $index => $user): ?>
                    <tr id="user-row-<?php echo $user['id']; ?>" data-position="<?php echo $index + 1; ?>"
                        data-user-id="<?php echo $user['id']; ?>"
                        data-username="<?php echo htmlspecialchars($user['username']); ?>">
                        <td><strong><?php echo $index + 1; ?></strong></td>
                        <td><?php echo htmlspecialchars($user['id'] ?? 'N/A'); ?></td>
                        <td><strong><?php echo htmlspecialchars($user['username'] ?? 'N/A'); ?></strong></td>
                        <td><?php echo htmlspecialchars($user['fullname'] ?? ($user['firstname'] . ' ' . $user['lastname']) ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($user['email'] ?? 'N/A'); ?></td>
                        <td>
                            <?php
                            $suspended = $user['suspended'] ?? false;
                            echo $suspended ?
                                    '<span class="badge bg-danger">Suspendido</span>' :
                                    '<span class="badge bg-success">Activo</span>';
                            ?>
                        </td>
                        <td>
                            <?php
                            if (isset($user['lastaccess']) && $user['lastaccess'] > 0) {
                                echo date('d/m/Y', $user['lastaccess']);
                            } else {
                                echo '<span class="text-muted">Nunca</span>';
                            }
                            ?>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary"
                                    onclick="updateSingleUser(<?php echo $user['id']; ?>, '<?php echo htmlspecialchars($user['username']); ?>')"
                                    id="btn-<?php echo $user['id']; ?>">
                                🔑 Actualizar
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Información adicional -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="alert alert-info">
                    <h5>💡 Consejos para sitios grandes:</h5>
                    <ul class="mb-0">
                        <li>Usa paginación si tienes más de 1000 usuarios</li>
                        <li>Filtra por criterios específicos cuando sea posible</li>
                        <li>Considera usar caché para consultas frecuentes</li>
                        <li><strong>Nuevo:</strong> Usa puntos de inicio para procesar usuarios por lotes</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="alert alert-warning">
                    <h5>⚠️ Consideraciones de rendimiento:</h5>
                    <ul class="mb-0">
                        <li>Esta consulta puede ser lenta en sitios grandes</li>
                        <li>Aumenta el timeout si es necesario</li>
                        <li>Monitorea el uso de memoria del servidor</li>
                        <li><strong>Nuevo:</strong> Reinicia desde cualquier punto si hay interrupciones</li>
                    </ul>
                </div>
            </div>
        </div>

    <?php elseif (!$errorInfo): ?>
        <div class="alert alert-info">
            <h5>ℹ️ No se encontraron usuarios</h5>
            <p>Esto puede deberse a:</p>
            <ul>
                <li>Restricciones de permisos en el token</li>
                <li>Configuración específica de Moodle</li>
                <li>Criterios de búsqueda muy restrictivos</li>
            </ul>
        </div>
    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Variables globales para el proceso masivo
    let massUpdateInProgress = false;
    let currentUserIndex = 0;
    let totalUsersToUpdate = 0;
    let successfulUpdates = 0;
    let failedUpdates = 0;
    let usersList = [];
    let startFromIndex = 0; // Nueva variable para el punto de inicio

    // Inicializar lista de usuarios al cargar la página
    document.addEventListener('DOMContentLoaded', function () {
        // Extraer usuarios de la tabla
        const userRows = document.querySelectorAll('#usersTableBody tr');
        usersList = [];

        userRows.forEach((row, index) => {
            const cells = row.cells;
            if (cells.length >= 3) {
                const position = index + 1;
                const userId = cells[1].innerText.trim();
                const username = cells[2].innerText.trim();

                if (userId !== 'N/A' && username !== 'N/A') {
                    usersList.push({
                        position: position,
                        id: userId,
                        username: username,
                        row: row
                    });
                }
            }
        });

        totalUsersToUpdate = usersList.length;
        console.log(`Lista de usuarios cargada: ${totalUsersToUpdate} usuarios`);

        // Inicializar vista previa
        previewStartPoint();
    });

    // Actualizar opciones de punto de inicio
    function updateStartPointOptions() {
        const selectValue = document.getElementById('startPointSelect').value;

        // Ocultar todos los inputs
        document.getElementById('positionInput').style.display = 'none';
        document.getElementById('userIdInput').style.display = 'none';
        document.getElementById('usernameInput').style.display = 'none';

        // Mostrar el input correspondiente
        switch (selectValue) {
            case 'position':
                document.getElementById('positionInput').style.display = 'block';
                break;
            case 'user_id':
                document.getElementById('userIdInput').style.display = 'block';
                break;
            case 'username':
                document.getElementById('usernameInput').style.display = 'block';
                break;
        }

        previewStartPoint();
    }

    // Vista previa del punto de inicio
    function previewStartPoint() {
        const selectValue = document.getElementById('startPointSelect').value;
        let startIndex = 0;
        let previewHtml = '';
        let usersToProcess = 0;

        switch (selectValue) {
            case 'beginning':
                startIndex = 0;
                break;

            case 'position':
                const position = parseInt(document.getElementById('startPosition').value) || 1;
                startIndex = Math.max(0, position - 1);
                break;

            case 'user_id':
                const userId = document.getElementById('startUserId').value;
                startIndex = usersList.findIndex(user => user.id == userId);
                if (startIndex === -1) startIndex = 0;
                break;

            case 'username':
                const username = document.getElementById('startUsername').value;
                startIndex = usersList.findIndex(user => user.username === username);
                if (startIndex === -1) startIndex = 0;
                break;
        }

        // Asegurar que el índice esté dentro del rango
        startIndex = Math.max(0, Math.min(startIndex, usersList.length - 1));
        usersToProcess = usersList.length - startIndex;

        if (usersList.length > 0 && startIndex < usersList.length) {
            const startUser = usersList[startIndex];
            previewHtml = `
                <strong>📍 Punto de inicio seleccionado:</strong><br>
                Posición: ${startUser.position}<br>
                Usuario: ${startUser.username} (ID: ${startUser.id})<br>
                <small class="text-info">✅ Se procesarán ${usersToProcess} usuarios (desde esta posición hasta el final)</small>
            `;

            // Validar si el punto de inicio es válido
            if (selectValue === 'user_id' && document.getElementById('startUserId').value &&
                usersList.findIndex(user => user.id == document.getElementById('startUserId').value) === -1) {
                previewHtml += '<br><small class="text-danger">⚠️ ID de usuario no encontrado</small>';
            }

            if (selectValue === 'username' && document.getElementById('startUsername').value &&
                usersList.findIndex(user => user.username === document.getElementById('startUsername').value) === -1) {
                previewHtml += '<br><small class="text-danger">⚠️ Username no encontrado</small>';
            }
        } else {
            previewHtml = '<small class="text-danger">❌ No se pudo determinar el punto de inicio</small>';
        }

        document.getElementById('startPointPreview').innerHTML = previewHtml;
        document.getElementById('usersToProcessCount').textContent = usersToProcess;

        // Guardar el índice de inicio calculado
        startFromIndex = startIndex;
    }

    // Resaltar rango en la tabla
    function highlightRange() {
        clearHighlight();

        if (usersList.length === 0) return;

        // Resaltar desde el punto de inicio hasta el final
        for (let i = startFromIndex; i < usersList.length; i++) {
            const user = usersList[i];
            user.row.classList.add('range-highlight');
        }

        // Scroll al primer elemento resaltado
        if (startFromIndex < usersList.length) {
            usersList[startFromIndex].row.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }

        // Mostrar notificación
        const usersInRange = usersList.length - startFromIndex;
        showNotification(`🎯 Resaltado aplicado: ${usersInRange} usuarios serán procesados`, 'info');
    }

    // Limpiar resaltado
    function clearHighlight() {
        document.querySelectorAll('#usersTableBody tr').forEach(row => {
            row.classList.remove('range-highlight');
        });
    }

    // Iniciar actualización masiva
    async function startMassUpdate() {
        if (usersList.length === 0) {
            alert('❌ No se encontraron usuarios para actualizar');
            return;
        }

        // Validar punto de inicio
        if (startFromIndex >= usersList.length) {
            alert('❌ El punto de inicio seleccionado está fuera del rango de usuarios disponibles');
            return;
        }

        const usersToProcess = usersList.length - startFromIndex;
        const startUser = usersList[startFromIndex];

        const confirmation = confirm(
            `⚠️ CONFIRMACIÓN REQUERIDA ⚠️\n\n` +
            `Punto de inicio seleccionado:\n` +
            `• Posición: ${startUser.position}\n` +
            `• Usuario: ${startUser.username} (ID: ${startUser.id})\n\n` +
            `Se actualizarán las contraseñas de ${usersToProcess} usuarios (desde esta posición hasta el final).\n\n` +
            `Cada usuario tendrá como contraseña su propio username.\n\n` +
            `El proceso se ejecutará uno por uno con una pausa de 500ms entre cada actualización.\n\n` +
            `Esta acción NO se puede deshacer fácilmente.\n\n` +
            `¿Estás seguro de continuar?`
        );

        if (!confirmation) return;

        // Inicializar variables
        massUpdateInProgress = true;
        currentUserIndex = startFromIndex; // Comenzar desde el punto seleccionado
        successfulUpdates = 0;
        failedUpdates = 0;

        // Mostrar controles de progreso
        document.getElementById('progressContainer').style.display = 'block';
        document.getElementById('activityLog').style.display = 'block';
        document.getElementById('massUpdateBtn').style.display = 'none';
        document.getElementById('stopUpdateBtn').style.display = 'inline-block';

        // Limpiar log
        document.getElementById('logContent').innerHTML = '';

        // Iniciar log
        addToLog(`🚀 Iniciando actualización masiva desde la posición ${startUser.position}`);
        addToLog(`👤 Usuario de inicio: ${startUser.username} (ID: ${startUser.id})`);
        addToLog(`📊 Total a procesar: ${usersToProcess} usuarios`);
        addToLog(`⏱️ Pausa configurada: 500ms entre cada usuario`);
        addToLog(`─────────────────────────────────────────────────────`);

        // Iniciar el proceso
        await processMassUpdate();
    }

    // Procesar actualización masiva
    async function processMassUpdate() {
        const totalToProcess = usersList.length - startFromIndex;

        while (massUpdateInProgress && currentUserIndex < usersList.length) {
            const user = usersList[currentUserIndex];
            const currentProcessed = currentUserIndex - startFromIndex + 1;

            addToLog(`🔄 [${currentProcessed}/${totalToProcess}] Actualizando usuario: ${user.username} (ID: ${user.id}) - Posición: ${user.position}`);

            // Actualizar progreso visual
            updateProgress();

            // Resaltar fila actual
            highlightCurrentRow(user.row);

            try {
                // Actualizar usuario
                const success = await updateSingleUserForMass(user.id, user.username);

                if (success) {
                    successfulUpdates++;
                    addToLog(`✅ Usuario ${user.username} actualizado correctamente`);

                    // Actualizar botón de la fila
                    const btn = document.getElementById(`btn-${user.id}`);
                    if (btn) {
                        btn.innerHTML = '✅ Actualizado';
                        btn.className = 'btn btn-sm btn-success';
                    }
                } else {
                    failedUpdates++;
                    addToLog(`❌ Error al actualizar usuario ${user.username}`);

                    // Actualizar botón de la fila
                    const btn = document.getElementById(`btn-${user.id}`);
                    if (btn) {
                        btn.innerHTML = '❌ Error';
                        btn.className = 'btn btn-sm btn-danger';
                    }
                }
            } catch (error) {
                failedUpdates++;
                addToLog(`❌ Error inesperado con usuario ${user.username}: ${error.message}`);
            }

            // Actualizar contadores
            updateCounters();

            currentUserIndex++;

            // Pausa de 500ms entre usuarios
            if (massUpdateInProgress && currentUserIndex < usersList.length) {
                await sleep(500);
            }
        }

        // Finalizar proceso
        finalizeMassUpdate();
    }

    // Actualizar usuario individual (versión para proceso masivo)
    async function updateSingleUserForMass(userId, username) {
        try {
            // Verificar si es el usuario admin
            if (username === 'admin') {
                addToLog(`⚠️ PROTECCIÓN DE SEGURIDAD: El usuario 'admin' no puede ser actualizado`);
                return false;
            }

            const formData = new FormData();
            formData.append('action', 'update_single');
            formData.append('user_id', userId);
            formData.append('new_password', username);
            formData.append('username', username); // Enviamos el username para validación en el servidor

            const response = await fetch('', {
                method: 'POST',
                body: formData
            });

            // Si el servidor responde con 403, es porque se intentó actualizar al admin
            if (response.status === 403) {
                const data = await response.json();
                addToLog(`⚠️ ${data.message}`);
                return false;
            }

            return response.ok;
        } catch (error) {
            console.error('Error en updateSingleUserForMass:', error);
            return false;
        }
    }

    // Detener actualización masiva
    function stopMassUpdate() {
        if (confirm('¿Estás seguro de que quieres detener el proceso de actualización?')) {
            massUpdateInProgress = false;
            const processedSoFar = currentUserIndex - startFromIndex;
            addToLog(`⏹️ Proceso detenido por el usuario en la posición ${currentUserIndex + 1}`);
            addToLog(`📊 Resumen parcial: ${processedSoFar} procesados, ${successfulUpdates} exitosos, ${failedUpdates} errores`);
            finalizeMassUpdate();
        }
    }

    // Finalizar proceso masivo
    function finalizeMassUpdate() {
        massUpdateInProgress = false;

        // Ocultar controles de proceso
        document.getElementById('massUpdateBtn').style.display = 'inline-block';
        document.getElementById('stopUpdateBtn').style.display = 'none';

        // Remover resaltado de filas
        document.querySelectorAll('#usersTableBody tr').forEach(row => {
            row.classList.remove('table-warning');
        });

        // Calcular estadísticas finales
        const totalProcessed = currentUserIndex - startFromIndex;
        const startUser = usersList[startFromIndex];

        // Log final
        addToLog(`─────────────────────────────────────────────────────`);
        addToLog(`🏁 Proceso finalizado`);
        addToLog(`📊 RESUMEN FINAL:`);
        addToLog(`   • Punto de inicio: Posición ${startUser.position} - ${startUser.username} (ID: ${startUser.id})`);
        addToLog(`   • Total procesados: ${totalProcessed}`);
        addToLog(`   • Exitosos: ${successfulUpdates}`);
        addToLog(`   • Errores: ${failedUpdates}`);
        addToLog(`   • Tasa de éxito: ${totalProcessed > 0 ? Math.round((successfulUpdates / totalProcessed) * 100) : 0}%`);

        // Mostrar notificación final
        showNotification(
            `🏁 Proceso completado: ${successfulUpdates} exitosos, ${failedUpdates} errores`,
            successfulUpdates > failedUpdates ? 'success' : 'warning'
        );
    }

    // Funciones auxiliares
    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    function updateProgress() {
        const totalToProcess = usersList.length - startFromIndex;
        const processed = currentUserIndex - startFromIndex + 1;
        const percentage = Math.round((processed / totalToProcess) * 100);

        document.getElementById('progressBar').style.width = percentage + '%';
        document.getElementById('progressText').textContent = percentage + '%';
    }

    function updateCounters() {
        const totalProcessed = currentUserIndex - startFromIndex + 1;
        document.getElementById('processedCount').textContent = totalProcessed;
        document.getElementById('successCount').textContent = successfulUpdates;
        document.getElementById('errorCount').textContent = failedUpdates;
    }

    function highlightCurrentRow(row) {
        // Remover resaltado previo
        document.querySelectorAll('#usersTableBody tr').forEach(r => {
            r.classList.remove('table-warning');
        });

        // Resaltar fila actual
        row.classList.add('table-warning');

        // Scroll hacia la fila actual
        row.scrollIntoView({behavior: 'smooth', block: 'center'});
    }

    function addToLog(message) {
        const timestamp = new Date().toLocaleTimeString();
        const logContent = document.getElementById('logContent');
        logContent.innerHTML += `[${timestamp}] ${message}\n`;
        logContent.scrollTop = logContent.scrollHeight;
    }

    // Actualización individual de usuario (función original mantenida)
    async function updateSingleUser(userId, username) {
        const btn = document.getElementById(`btn-${userId}`);
        const originalText = btn.innerHTML;

        // Verificar si es el usuario admin
        if (username === 'admin') {
            btn.innerHTML = '🔒 Protegido';
            btn.className = 'btn btn-sm btn-warning';
            showNotification(`⚠️ No se permite actualizar la contraseña del usuario admin por razones de seguridad`, 'warning');

            // Restaurar botón después de 3 segundos
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.className = 'btn btn-sm btn-outline-primary';
                btn.disabled = false;
            }, 3000);

            return; // Detener la ejecución
        }

        btn.innerHTML = '⏳ Procesando...';
        btn.disabled = true;

        try {
            const formData = new FormData();
            formData.append('action', 'update_single');
            formData.append('user_id', userId);
            formData.append('new_password', username);
            formData.append('username', username); // Añadir username para validación en el servidor

            const response = await fetch('', {
                method: 'POST',
                body: formData
            });

            // Manejar respuesta 403 específicamente
            if (response.status === 403) {
                const data = await response.json();
                btn.innerHTML = '🔒 Protegido';
                btn.className = 'btn btn-sm btn-warning';
                showNotification(data.message || '⚠️ No permitido', 'warning');

                // Restaurar botón después de 3 segundos
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.className = 'btn btn-sm btn-outline-primary';
                    btn.disabled = false;
                }, 3000);
                return;
            }

            if (response.ok) {
                btn.innerHTML = '✅ Actualizado';
                btn.className = 'btn btn-sm btn-success';

                // Mostrar notificación
                showNotification(`✅ Contraseña actualizada para usuario: ${username}`, 'success');
            } else {
                throw new Error('Error en la respuesta del servidor');
            }
        } catch (error) {
            btn.innerHTML = '❌ Error';
            btn.className = 'btn btn-sm btn-danger';
            showNotification(`❌ Error al actualizar usuario: ${username}`, 'error');

            // Restaurar botón después de 3 segundos
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.className = 'btn btn-sm btn-outline-primary';
                btn.disabled = false;
            }, 3000);
        }
    }

    // Mostrar notificaciones
    function showNotification(message, type) {
        const alertClass = type === 'success' ? 'alert-success' :
            type === 'warning' ? 'alert-warning' :
                type === 'info' ? 'alert-info' : 'alert-danger';
        const notification = document.createElement('div');
        notification.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

        document.body.appendChild(notification);

        // Auto-remover después de 5 segundos
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }

    // Funcionalidad de búsqueda en tiempo real
    document.getElementById('userSearch')?.addEventListener('keyup', function () {
        const searchTerm = this.value.toLowerCase();
        const tableBody = document.getElementById('usersTableBody');
        const rows = tableBody.getElementsByTagName('tr');

        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const text = row.textContent.toLowerCase();

            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });

    // Función para ir a una posición específica en la tabla
    function goToPosition(position) {
        const targetRow = document.querySelector(`tr[data-position="${position}"]`);
        if (targetRow) {
            targetRow.scrollIntoView({behavior: 'smooth', block: 'center'});
            targetRow.style.backgroundColor = '#fff3cd';
            setTimeout(() => {
                targetRow.style.backgroundColor = '';
            }, 2000);
        }
    }

    // Función para ir a un usuario específico
    function goToUser(identifier, type = 'username') {
        let targetRow;
        if (type === 'username') {
            targetRow = document.querySelector(`tr[data-username="${identifier}"]`);
        } else if (type === 'id') {
            targetRow = document.querySelector(`tr[data-user-id="${identifier}"]`);
        }

        if (targetRow) {
            targetRow.scrollIntoView({behavior: 'smooth', block: 'center'});
            targetRow.style.backgroundColor = '#fff3cd';
            setTimeout(() => {
                targetRow.style.backgroundColor = '';
            }, 2000);
        }
    }

    // Event listeners para los inputs de punto de inicio
    document.getElementById('startPosition')?.addEventListener('input', function () {
        const position = parseInt(this.value);
        if (position && position >= 1 && position <= usersList.length) {
            setTimeout(() => goToPosition(position), 500);
        }
    });

    document.getElementById('startUserId')?.addEventListener('input', function () {
        const userId = this.value.trim();
        if (userId) {
            setTimeout(() => goToUser(userId, 'id'), 500);
        }
    });

    document.getElementById('startUsername')?.addEventListener('input', function () {
        const username = this.value.trim();
        if (username) {
            setTimeout(() => goToUser(username, 'username'), 500);
        }
    });

    // Función para resetear el formulario de punto de inicio
    function resetStartPoint() {
        document.getElementById('startPointSelect').value = 'beginning';
        document.getElementById('startPosition').value = '1';
        document.getElementById('startUserId').value = '';
        document.getElementById('startUsername').value = '';
        updateStartPointOptions();
        clearHighlight();
    }

    // Agregar atajos de teclado
    document.addEventListener('keydown', function (e) {
        // Ctrl + R para resetear punto de inicio
        if (e.ctrlKey && e.key === 'r' && !massUpdateInProgress) {
            e.preventDefault();
            resetStartPoint();
            showNotification('🔄 Punto de inicio reseteado', 'info');
        }

        // Escape para limpiar resaltado
        if (e.key === 'Escape') {
            clearHighlight();
        }

        // Ctrl + H para resaltar rango
        if (e.ctrlKey && e.key === 'h' && !massUpdateInProgress) {
            e.preventDefault();
            highlightRange();
        }
    });

    // Mostrar ayuda con atajos de teclado
    function showKeyboardShortcuts() {
        const shortcuts = `
            <strong>⌨️ Atajos de teclado disponibles:</strong><br><br>
            • <kbd>Ctrl + R</kbd> - Resetear punto de inicio<br>
            • <kbd>Ctrl + H</kbd> - Resaltar rango seleccionado<br>
            • <kbd>Escape</kbd> - Limpiar resaltado<br>
            • <kbd>Ctrl + F</kbd> - Buscar en la página (nativo del navegador)<br>
        `;

        const modal = document.createElement('div');
        modal.className = 'modal fade show';
        modal.style.display = 'block';
        modal.innerHTML = `
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">💡 Ayuda - Atajos de Teclado</h5>
                        <button type="button" class="btn-close" onclick="this.closest('.modal').remove()"></button>
                    </div>
                    <div class="modal-body">
                        ${shortcuts}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="this.closest('.modal').remove()">Cerrar</button>
                    </div>
                </div>
            </div>
        `;

        document.body.appendChild(modal);

        // Auto-remover después de 10 segundos
        setTimeout(() => {
            if (modal.parentNode) {
                modal.remove();
            }
        }, 10000);
    }

    // Agregar botón de ayuda (se puede llamar desde la interfaz)
    function addHelpButton() {
        const helpButton = document.createElement('button');
        helpButton.className = 'btn btn-outline-info btn-sm position-fixed';
        helpButton.style.cssText = 'bottom: 20px; right: 20px; z-index: 1000; border-radius: 50%; width: 50px; height: 50px;';
        helpButton.innerHTML = '❓';
        helpButton.title = 'Mostrar atajos de teclado';
        helpButton.onclick = showKeyboardShortcuts;

        document.body.appendChild(helpButton);
    }

    // Inicializar botón de ayuda cuando la página esté lista
    document.addEventListener('DOMContentLoaded', function () {
        addHelpButton();
    });
</script>
</body>
</html>