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
            <div>Registrando usuario en Moodle...</div>
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

                // Datos del usuario para registrar
                const userData = {
                    username: '<?php echo $citizenshipcard; ?>',
                    password: '<?php echo $citizenshipcard; ?>',
                    firstname: '<?php echo addslashes($firstname); ?>',
                    lastname: '<?php echo addslashes($lastname); ?>',
                    email: '<?php echo $email; ?>',
                    idnumber: '<?php echo $user; ?>'
                };

                // Simular llamada para crear usuario (aquí deberías hacer la llamada real)
                setTimeout(() => {
                    // Crear instancia de Moodle y registrar usuario
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

                            // Recargar la página para mostrar el nuevo estado
                            window.location.reload();
                        })
                        .catch(error => {
                            loadingOverlay.style.display = 'none';
                            console.error('Error:', error);

                            statusDiv.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="fas fa-times-circle me-2"></i>
                            <strong>Error al Registrar Usuario</strong>
                            <hr>
                            <small>Ocurrió un error durante el registro. Intente nuevamente.</small>
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
                }, 2000);
            });
        }
    });
</script>

<?php
// Procesar registro si se envía la acción
if (isset($_POST['action']) && $_POST['action'] === 'register_moodle_user') {
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
?>
