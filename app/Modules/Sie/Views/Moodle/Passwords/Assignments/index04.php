<?php
/**********************
 *  Configuración básica
 **********************/
$token = 'ce890746630ebf2c6b7baf4dde8f41b4';
$domain = 'https://campus.utede.edu.co';
$function = 'core_user_get_users_by_field'; // Función más eficiente para obtener todos los usuarios
$endpoint = "$domain/webservice/rest/server.php";

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
    <title>Listado Completo de Usuarios - Moodle</title>
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
    </style>
</head>
<body>
<div class="container-fluid">
    <h1>Listado Completo de Usuarios - Moodle</h1>

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

                <div class="row">
                    <div class="col-md-8">
                        <p><strong>⚠️ ADVERTENCIA:</strong> Esta acción afectará a <strong><?php echo $totalUsers; ?>
                                usuarios</strong> y no se puede deshacer fácilmente.</p>
                        <ul class="small">
                            <li>Se procesarán uno por uno con pausas de 500ms entre cada usuario</li>
                            <li>La contraseña será igual al username de cada usuario</li>
                            <li>Podrás ver el progreso en tiempo real</li>
                            <li>Se recomienda notificar a los usuarios del cambio</li>
                        </ul>
                        <!-- Selector de posición inicial -->
                        <div class="form-group mt-3">
                            <label for="startPosition" class="form-label"><strong>🔢 Posición inicial:</strong></label>
                            <div class="input-group">
                                <input type="number" id="startPosition" class="form-control" value="0" min="0"
                                       max="<?php echo $totalUsers - 1; ?>">
                                <button type="button" class="btn btn-outline-secondary" onclick="setMaxPosition()"
                                        title="Ir al final de la lista">
                                    <i>Último</i>
                                </button>
                            </div>
                            <div class="form-text">Selecciona desde qué posición (0-<?php echo $totalUsers - 1; ?>)
                                comenzar la actualización.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <button type="button" id="massUpdateBtn" class="btn btn-warning btn-lg"
                                onclick="startMassUpdate()">
                            🔄 Actualizar Todas las Contraseñas
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
                <?php foreach ($users as $user): ?>
                    <tr id="user-row-<?php echo $user['id']; ?>">
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

    // Inicializar lista de usuarios al cargar la página
    document.addEventListener('DOMContentLoaded', function () {
        // Extraer usuarios de la tabla
        const userRows = document.querySelectorAll('#usersTableBody tr');
        usersList = [];

        userRows.forEach(row => {
            const cells = row.cells;
            if (cells.length >= 2) {
                const userId = cells[0].innerText.trim();
                const username = cells[1].innerText.trim();

                if (userId !== 'N/A' && username !== 'N/A') {
                    usersList.push({
                        id: userId,
                        username: username,
                        row: row
                    });
                }
            }
        });

        totalUsersToUpdate = usersList.length;
        console.log(`Lista de usuarios cargada: ${totalUsersToUpdate} usuarios`);
    });

    /**
     * Establece la posición inicial al máximo (último usuario)
     */
    function setMaxPosition() {
        const maxPosition = usersList.length - 1;
        document.getElementById('startPosition').value = maxPosition;
    }

    /**
     * Inicia el proceso de actualización masiva de contraseñas
     */
    async function startMassUpdate() {
        if (usersList.length === 0) {
            alert('❌ No se encontraron usuarios para actualizar');
            return;
        }

        // Obtener posición inicial desde el selector
        const startPositionInput = document.getElementById('startPosition');
        const requestedStartPosition = parseInt(startPositionInput.value) || 0;

        // Validar rango
        if (requestedStartPosition < 0 || requestedStartPosition >= usersList.length) {
            alert(`❌ La posición inicial debe estar entre 0 y ${usersList.length - 1}`);
            return;
        }

        const pendingUpdates = usersList.length - requestedStartPosition;

        const confirmation = confirm(
            `⚠️ CONFIRMACIÓN REQUERIDA ⚠️\n\n` +
            `Estás a punto de actualizar las contraseñas de ${pendingUpdates} usuarios.\n\n` +
            `Comenzarás desde la posición ${requestedStartPosition} (${usersList[requestedStartPosition].username}).\n\n` +
            `Cada usuario tendrá como contraseña su propio username.\n\n` +
            `El proceso se ejecutará uno por uno con una pausa de 500ms entre cada actualización.\n\n` +
            `Esta acción NO se puede deshacer fácilmente.\n\n` +
            `¿Estás seguro de continuar?`
        );

        if (!confirmation) return;

        // Inicializar variables
        massUpdateInProgress = true;
        currentUserIndex = requestedStartPosition;
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
        addToLog(`🚀 Iniciando actualización masiva de ${pendingUpdates} usuarios...`);
        addToLog(`📊 Posición inicial: ${currentUserIndex} de ${totalUsersToUpdate}`);
        addToLog(`🔹 Usuario inicial: ${usersList[currentUserIndex].username} (ID: ${usersList[currentUserIndex].id})`);
        addToLog(`⏱️ Pausa configurada: 500ms entre cada usuario`);
        addToLog(`─────────────────────────────────────────────────────`);

        // Iniciar el proceso
        await processMassUpdate();
    }

    // Procesar actualización masiva
    async function processMassUpdate() {
        while (massUpdateInProgress && currentUserIndex < usersList.length) {
            const user = usersList[currentUserIndex];

            addToLog(`🔄 [${currentUserIndex + 1}/${totalUsersToUpdate}] Actualizando usuario: ${user.username} (ID: ${user.id})`);

            // Actualizar progreso visual
            updateProgress();

            // Resaltar fila actual
            highlightCurrentRow(user.row);

            try {
                // Simular click en el botón individual
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
            const formData = new FormData();
            formData.append('action', 'update_single');
            formData.append('user_id', userId);
            formData.append('new_password', username);

            const response = await fetch('', {
                method: 'POST',
                body: formData
            });

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
            addToLog(`⏹️ Proceso detenido por el usuario en el índice ${currentUserIndex}`);
            addToLog(`📊 Resumen parcial: ${successfulUpdates} exitosos, ${failedUpdates} errores`);
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

        // Log final
        addToLog(`─────────────────────────────────────────────────────`);
        addToLog(`🏁 Proceso finalizado`);
        addToLog(`📊 RESUMEN FINAL:`);
        addToLog(`   • Total procesados: ${currentUserIndex}/${totalUsersToUpdate}`);
        addToLog(`   • Exitosos: ${successfulUpdates}`);
        addToLog(`   • Errores: ${failedUpdates}`);
        addToLog(`   • Tasa de éxito: ${totalUsersToUpdate > 0 ? Math.round((successfulUpdates / currentUserIndex) * 100) : 0}%`);

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
        const percentage = Math.round((currentUserIndex / totalUsersToUpdate) * 100);
        document.getElementById('progressBar').style.width = percentage + '%';
        document.getElementById('progressText').textContent = percentage + '%';
    }

    function updateCounters() {
        document.getElementById('processedCount').textContent = currentUserIndex;
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

        btn.innerHTML = '⏳ Procesando...';
        btn.disabled = true;

        try {
            const formData = new FormData();
            formData.append('action', 'update_single');
            formData.append('user_id', userId);
            formData.append('new_password', username);

            const response = await fetch('', {
                method: 'POST',
                body: formData
            });

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
        const alertClass = type === 'success' ? 'alert-success' : type === 'warning' ? 'alert-warning' : 'alert-danger';
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
</script>
</body>
</html>