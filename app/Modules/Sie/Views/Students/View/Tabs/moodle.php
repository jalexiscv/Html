<?php
/** @var Strings $oid */
//[services]------------------------------------------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
//[models]--------------------------------------------------------------------------------------------------------------
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$mprograms = model("App\Modules\Sie\Models\Sie_Programs");
$mcountries = model("App\Modules\Sie\Models\Sie_Countries");
$mregions = model("App\Modules\Sie\Models\Sie_Regions");
$mcities = model("App\Modules\Sie\Models\Sie_Cities");
$mstatuses = model("App\Modules\Sie\Models\Sie_Statuses");
//[vars]----------------------------------------------------------------------------------------------------------------
$registration = $mregistrations->getRegistration($oid);

$citizenshipcard = @$registration["identification_number"];
$username = @$registration["identification_number"];
$password = @$registration["identification_number"];
$firstname = safe_strtoupper(@$registration["firstname"]);
$lastname = safe_strtoupper(@$registration["lastname"]);
$email = safe_strtolower(@$registration["email"]);
$idnumber = safe_strtoupper(@$registration["identification_number"]);
$registration_number = @$registration["registration"];

// Sanitizar username para verificación
$sanitizedUsername = strtolower(preg_replace('/[^a-z0-9._-]/', '', $citizenshipcard));

// Verificar si el estudiante existe en Moodle
$moodle = new App\Libraries\Moodle();
$profileResult = $moodle->getUserProfile($sanitizedUsername, 'username');

?>
<div class="container-fluid p-0 m-0">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-graduate me-2"></i>
                        Estado en Moodle
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Información del Estudiante</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Nombre:</strong></td>
                                    <td><?php echo $firstname . ' ' . $lastname; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Cédula:</strong></td>
                                    <td><?php echo $citizenshipcard; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td><?php echo $email; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Registro:</strong></td>
                                    <td><?php echo $registration_number; ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Estado en Moodle</h6>
                            <div id="moodle-status">
                                <?php if ($profileResult['success']): ?>
                                    <div class="alert alert-success">
                                        <i class="fas fa-check-circle me-2"></i>
                                        <strong>Usuario Registrado</strong>
                                        <hr>
                                        <small>
                                            <strong>ID Moodle:</strong> <?php echo $profileResult['userInfo']['id']; ?>
                                            <br>
                                            <strong>Username:</strong> <?php echo $profileResult['userInfo']['username']; ?>
                                            <br>
                                            <strong>Email:</strong> <?php echo $profileResult['userInfo']['email']; ?>
                                            <br>
                                            <strong>Último acceso:</strong>
                                            <?php
                                            if ($profileResult['userInfo']['lastaccess']) {
                                                echo date('Y-m-d H:i:s', $profileResult['userInfo']['lastaccess']);
                                            } else {
                                                echo 'Nunca';
                                            }
                                            ?>
                                        </small>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        <strong>Usuario No Registrado</strong>
                                        <hr>
                                        <small><?php echo $profileResult['error']; ?></small>
                                    </div>
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-primary" id="btn-register-moodle">
                                            <i class="fas fa-user-plus me-2"></i>
                                            Registrar en Moodle
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="loading-overlay"
     style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999;">
    <div class="d-flex justify-content-center align-items-center h-100">
        <div class="text-center text-white">
            <div class="spinner-border mb-3" role="status"></div>
            <div>Registrando estudiante en Moodle...</div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnRegister = document.getElementById('btn-register-moodle');
        const loadingOverlay = document.getElementById('loading-overlay');
        const statusDiv = document.getElementById('moodle-status');

        if (btnRegister) {
            btnRegister.addEventListener('click', function () {
                // Mostrar loading
                loadingOverlay.style.display = 'block';
                btnRegister.disabled = true;

                // Datos del estudiante para registrar
                const userData = {
                    username: '<?php echo strtolower(preg_replace('/[^a-z0-9._-]/', '', $citizenshipcard)); ?>',
                    password: '<?php echo $citizenshipcard; ?>',
                    firstname: '<?php echo addslashes($firstname); ?>',
                    lastname: '<?php echo addslashes($lastname); ?>',
                    email: '<?php echo $email; ?>',
                    idnumber: '<?php echo $citizenshipcard; ?>',
                    auth: 'manual',
                    lang: 'es',
                    city: 'Bogotá',
                    country: 'CO'
                };

                // Llamada para crear usuario estudiante
                fetch(window.location.href, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'action=register_moodle_user'
                })
                    .then(response => {
                        console.log('Response status:', response.status);
                        console.log('Response headers:', response.headers);
                        return response.text();
                    })
                    .then(data => {
                        console.log('Response data:', data);
                        console.log('Response length:', data.length);
                        console.log('Response type:', typeof data);

                        loadingOverlay.style.display = 'none';

                        try {
                            // Limpiar posible contenido extra antes/después del JSON
                            const cleanData = data.trim();

                            // Buscar el inicio del JSON si hay contenido extra
                            let jsonStart = cleanData.indexOf('{');
                            let jsonEnd = cleanData.lastIndexOf('}');

                            if (jsonStart !== -1 && jsonEnd !== -1 && jsonEnd > jsonStart) {
                                const jsonString = cleanData.substring(jsonStart, jsonEnd + 1);
                                console.log('Extracted JSON:', jsonString);

                                const jsonData = JSON.parse(jsonString);
                                console.log('Parsed JSON:', jsonData);

                                if (jsonData.success) {
                                    // Éxito: recargar la página
                                    window.location.reload();
                                } else {
                                    // Error de Moodle: mostrar mensaje detallado
                                    let errorMessage = jsonData.message || 'Error desconocido';

                                    // Si hay información de debug, incluirla
                                    if (jsonData.debug && jsonData.debug.originalData) {
                                        errorMessage += '\n\nDetalles técnicos:\n' + JSON.stringify(jsonData.debug.originalData, null, 2);
                                    }

                                    // Si hay datos de usuario, incluirlos
                                    if (jsonData.userData) {
                                        errorMessage += '\n\nDatos enviados:\n' + JSON.stringify(jsonData.userData, null, 2);
                                    }

                                    throw new Error(errorMessage);
                                }
                            } else {
                                throw new Error(`Respuesta no contiene JSON válido. Respuesta completa: ${cleanData}`);
                            }
                        } catch (parseError) {
                            console.error('Error parsing JSON:', parseError);
                            console.log('Raw response:', data);

                            // Si el error es de parsing, mostrar la respuesta completa
                            if (parseError instanceof SyntaxError) {
                                throw new Error(`Error de sintaxis JSON: ${parseError.message}\n\nRespuesta completa:\n${data}`);
                            } else {
                                // Re-lanzar otros errores (como los de Moodle)
                                throw parseError;
                            }
                        }
                    })
                    .catch(error => {
                        loadingOverlay.style.display = 'none';
                        btnRegister.disabled = false;
                        console.error('Error:', error);

                        // Guardar el mensaje de error para la función de copiar
                        window.currentErrorMessage = error.message;

                        statusDiv.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-times-circle me-2"></i>
                        <strong>Error al Registrar Usuario</strong>
                        <hr>
                        <div class="mb-3">
                            <strong>Error:</strong>
                            <div class="mt-2 p-2 bg-light border rounded" style="max-height: 300px; overflow-y: auto; font-family: monospace; font-size: 12px; white-space: pre-wrap;">${error.message}</div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Revisa la consola del navegador (F12 → Console) para logs detallados
                            </small>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="copyErrorToClipboard()">
                                <i class="fas fa-copy me-1"></i>Copiar Error
                            </button>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="button" class="btn btn-primary" id="btn-register-moodle">
                            <i class="fas fa-user-plus me-2"></i>
                            Intentar Nuevamente
                        </button>
                    </div>
                `;

                        // Re-agregar event listener al nuevo botón
                        const newBtn = document.getElementById('btn-register-moodle');
                        if (newBtn) {
                            newBtn.addEventListener('click', arguments.callee);
                        }
                    });
            });
        }

        // Función global para copiar error al portapapeles
        window.copyErrorToClipboard = function () {
            if (window.currentErrorMessage) {
                navigator.clipboard.writeText(window.currentErrorMessage).then(() => {
                    alert('Error copiado al portapapeles');
                }).catch(err => {
                    console.error('Error al copiar al portapapeles:', err);
                    // Fallback para navegadores que no soportan clipboard API
                    const textArea = document.createElement('textarea');
                    textArea.value = window.currentErrorMessage;
                    document.body.appendChild(textArea);
                    textArea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textArea);
                    alert('Error copiado al portapapeles (método alternativo)');
                });
            } else {
                alert('No hay mensaje de error para copiar');
            }
        };
    });
</script>

<?php
// Procesar registro si se envía la acción
if (isset($_POST['action']) && $_POST['action'] === 'register_moodle_user') {
    // Limpiar cualquier output previo
    ob_clean();

    // Headers para JSON
    header('Content-Type: application/json');

    try {
        // Recargar datos del estudiante en el contexto POST
        $registration = $mregistrations->getRegistration($oid);
        $citizenshipcard = @$registration["identification_number"];
        $firstname = safe_strtoupper(@$registration["first_name"] . " " . @$registration["second_name"]);
        $lastname = safe_strtoupper(@$registration["first_surname"] . " " . @$registration["second_surname"]);
        $email = safe_strtolower(@$registration["email_institutional"]);

        // Sanitizar username como en tu código funcional
        $sanitizedUsername = strtolower(preg_replace('/[^a-z0-9._-]/', '', $citizenshipcard));

        // Validar que tenemos los datos necesarios
        if (empty($citizenshipcard) || empty($firstname) || empty($lastname) || empty($email)) {
            throw new Exception('Datos del estudiante incompletos. Cédula: ' . $citizenshipcard . ', Nombre: ' . $firstname . ', Apellido: ' . $lastname . ', Email: ' . $email);
        }

        // Validar username
        if (!preg_match('/^[a-z0-9._-]+$/', $sanitizedUsername)) {
            throw new Exception('El nombre de usuario solo puede contener letras minúsculas, números, puntos, guiones y guiones bajos.');
        }

        $userData = [
                'username' => $sanitizedUsername,
                'password' => $citizenshipcard,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'idnumber' => $citizenshipcard,
                'auth' => 'manual',
                'lang' => 'es',
                'city' => 'Bogotá',
                'country' => 'CO'
        ];

        // Debug: Log los datos que se van a enviar
        error_log('=== REGISTRO ESTUDIANTE MOODLE ===');
        error_log('Datos del estudiante para Moodle: ' . json_encode($userData));
        error_log('Citizenship card original: ' . $citizenshipcard);
        error_log('Username sanitizado: ' . $sanitizedUsername);

        $result = $moodle->createUser($userData);

        // Debug: Log la respuesta de Moodle
        error_log('Respuesta de Moodle: ' . json_encode($result));
        error_log('=== FIN REGISTRO ESTUDIANTE ===');

        if ($result['success']) {
            $response = [
                    'success' => true,
                    'message' => 'Estudiante registrado exitosamente',
                    'userId' => $result['userId'],
                    'debug' => [
                            'username' => $sanitizedUsername,
                            'idnumber' => $citizenshipcard
                    ]
            ];
        } else {
            $response = [
                    'success' => false,
                    'message' => $result['error'],
                    'debug' => $result,
                    'userData' => $userData
            ];
        }

        error_log('Respuesta final: ' . json_encode($response));
        echo json_encode($response);
    } catch (Exception $e) {
        error_log('EXCEPCIÓN en registro de estudiante: ' . $e->getMessage());
        error_log('Stack trace: ' . $e->getTraceAsString());

        $errorResponse = [
                'success' => false,
                'message' => 'Error interno: ' . $e->getMessage(),
                'error_type' => 'exception',
                'file' => $e->getFile(),
                'line' => $e->getLine()
        ];

        echo json_encode($errorResponse);
    } catch (Error $e) {
        error_log('ERROR FATAL en registro de estudiante: ' . $e->getMessage());

        echo json_encode([
                'success' => false,
                'message' => 'Error fatal: ' . $e->getMessage(),
                'error_type' => 'fatal_error'
        ]);
    }

    // Asegurar que no hay output adicional
    exit();
}
?>
