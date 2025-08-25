<?php
/** @var String $oid */
//[models]--------------------------------------------------------------------------------------------------------------
$musers = model("App\Modules\Security\Models\Security_Users");
$mfields = model('App\Modules\Sie\Models\Sie_Users_Fields');
$bootstrap = service('bootstrap');
$strings = model('App\Libraries\Strings');
//[vars]----------------------------------------------------------------------------------------------------------------

$row = $musers->where('user', $oid)->first();

$r["user"] = $oid;
$r["alias"] = $mfields->get_Field($oid, "alias");
$r["birthday"] = $mfields->get_Field($oid, "birthday");
$r["citizenshipcard"] = $mfields->get_Field($oid, "citizenshipcard");
$r["email"] = $mfields->get_Field($oid, "email");
$r["email_personal"] = $mfields->get_Field($oid, "email_personal");
$r["firstname"] = $strings->get_URLDecode($mfields->get_Field($oid, "firstname"));
$r["lastname"] = $strings->get_URLDecode($mfields->get_Field($oid, "lastname"));

$citizenshipcard = $r["citizenshipcard"];
$firstname = safe_strtoupper($r["firstname"]);
$lastname = safe_strtoupper($r["lastname"]);
$email = safe_strtolower($r["email"]);
$user = $r["user"];

// Verificar si el profesor existe en Moodle
$moodle = new App\Libraries\Moodle();
$profileResult = $moodle->getUserProfile($user, 'idnumber');

// Detectar discrepancias si el usuario existe
$discrepancies = [];
$hasDiscrepancies = false;
if ($profileResult['success']) {
    $moodleData = $profileResult['userInfo'];

    // Comparar firstname
    if (trim(strtoupper($moodleData['firstname'])) !== trim(strtoupper($firstname))) {
        $discrepancies['firstname'] = [
                'local' => $firstname,
                'moodle' => $moodleData['firstname']
        ];
    }

    // Comparar lastname
    if (trim(strtoupper($moodleData['lastname'])) !== trim(strtoupper($lastname))) {
        $discrepancies['lastname'] = [
                'local' => $lastname,
                'moodle' => $moodleData['lastname']
        ];
    }

    // Comparar email
    if (trim(strtolower($moodleData['email'])) !== trim(strtolower($email))) {
        $discrepancies['email'] = [
                'local' => $email,
                'moodle' => $moodleData['email']
        ];
    }

    // Comparar idnumber
    if (trim($moodleData['idnumber']) !== trim($user)) {
        $discrepancies['idnumber'] = [
                'local' => $user,
                'moodle' => $moodleData['idnumber']
        ];
    }

    $hasDiscrepancies = !empty($discrepancies);
}

// Procesar acciones AJAX
if (isset($_POST['action'])) {
    if ($_POST['action'] === 'register_moodle_user') {
        $userData = [
                'username' => $citizenshipcard,
                'password' => $citizenshipcard,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'idnumber' => $user
        ];

        $result = $moodle->createUser($userData);

        if ($result['success']) {
            echo json_encode([
                    'success' => true,
                    'message' => 'Usuario registrado exitosamente',
                    'userId' => $result['userId']
            ]);
        } else {
            echo json_encode([
                    'success' => false,
                    'message' => $result['error']
            ]);
        }
        exit;
    }

    if ($_POST['action'] === 'sync_moodle_user' && $profileResult['success']) {
        $updateData = [
                'id' => $profileResult['userInfo']['id'],
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'idnumber' => $user
        ];

        $result = $moodle->updateUser($updateData);

        if ($result['success']) {
            echo json_encode([
                    'success' => true,
                    'message' => 'Usuario sincronizado exitosamente'
            ]);
        } else {
            echo json_encode([
                    'success' => false,
                    'message' => $result['error']
            ]);
        }
        exit;
    }
}

?>

<div class="container-fluid p-0 m-0">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-graduation-cap me-2"></i>
                        Estado en Moodle
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Información del Profesor</h6>
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
                                    <td><strong>ID Usuario:</strong></td>
                                    <td><?php echo $user; ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Estado en Moodle</h6>
                            <div id="moodle-status">
                                <?php if ($profileResult['success']): ?>
                                    <?php if ($hasDiscrepancies): ?>
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <strong>Usuario Registrado - Discrepancias Detectadas</strong>
                                            <hr>
                                            <small>
                                                <strong>ID
                                                    Moodle:</strong> <?php echo $profileResult['userInfo']['id']; ?><br>
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

                                        <!-- Tabla de discrepancias -->
                                        <div class="table-responsive mb-3">
                                            <table class="table table-sm table-bordered">
                                                <thead class="table-warning">
                                                <tr>
                                                    <th>Campo</th>
                                                    <th>Sistema Local</th>
                                                    <th>Moodle</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($discrepancies as $field => $values): ?>
                                                    <tr>
                                                        <td><strong><?php echo ucfirst($field); ?></strong></td>
                                                        <td class="text-success"><?php echo htmlspecialchars($values['local']); ?></td>
                                                        <td class="text-danger"><?php echo htmlspecialchars($values['moodle']); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="d-grid">
                                            <button type="button" class="btn btn-warning" id="btn-sync-moodle">
                                                <i class="fas fa-sync me-2"></i>
                                                Sincronizar con Sistema Local
                                            </button>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-success">
                                            <i class="fas fa-check-circle me-2"></i>
                                            <strong>Usuario Registrado y Sincronizado</strong>
                                            <hr>
                                            <small>
                                                <strong>ID
                                                    Moodle:</strong> <?php echo $profileResult['userInfo']['id']; ?><br>
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
                                    <?php endif; ?>
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
            <div id="loading-text">Procesando...</div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnRegister = document.getElementById('btn-register-moodle');
        const btnSync = document.getElementById('btn-sync-moodle');
        const loadingOverlay = document.getElementById('loading-overlay');
        const loadingText = document.getElementById('loading-text');
        const statusDiv = document.getElementById('moodle-status');

        // Función para registrar usuario
        if (btnRegister) {
            btnRegister.addEventListener('click', function () {
                loadingOverlay.style.display = 'block';
                loadingText.textContent = 'Registrando usuario en Moodle...';
                btnRegister.disabled = true;

                setTimeout(() => {
                    fetch(window.location.href, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'action=register_moodle_user'
                    })
                        .then(response => response.text())
                        .then(data => {
                            loadingOverlay.style.display = 'none';
                            window.location.reload();
                        })
                        .catch(error => {
                            loadingOverlay.style.display = 'none';
                            console.error('Error:', error);
                            showError('Error al registrar usuario. Intente nuevamente.');
                        });
                }, 1000);
            });
        }

        // Función para sincronizar usuario
        if (btnSync) {
            btnSync.addEventListener('click', function () {
                loadingOverlay.style.display = 'block';
                loadingText.textContent = 'Sincronizando datos con Moodle...';
                btnSync.disabled = true;

                setTimeout(() => {
                    fetch(window.location.href, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'action=sync_moodle_user'
                    })
                        .then(response => response.text())
                        .then(data => {
                            loadingOverlay.style.display = 'none';
                            window.location.reload();
                        })
                        .catch(error => {
                            loadingOverlay.style.display = 'none';
                            console.error('Error:', error);
                            showError('Error al sincronizar usuario. Intente nuevamente.');
                        });
                }, 1000);
            });
        }

        function showError(message) {
            statusDiv.innerHTML = `
            <div class="alert alert-danger">
                <i class="fas fa-times-circle me-2"></i>
                <strong>Error</strong>
                <hr>
                <small>${message}</small>
            </div>
            <div class="d-grid">
                <button type="button" class="btn btn-primary" onclick="window.location.reload()">
                    <i class="fas fa-redo me-2"></i>
                    Intentar Nuevamente
                </button>
            </div>
        `;
        }
    });
</script>
