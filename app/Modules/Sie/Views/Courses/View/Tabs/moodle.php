<?php
/** @var String $oid */
//[models]--------------------------------------------------------------------------------------------------------------
$mcourses = model('App\Modules\Sie\Models\Sie_Courses');
$mprograms = model("App\Modules\Sie\Models\Sie_Programs");
$mmodules = model("App\Modules\Sie\Models\Sie_Modules");
$mpensums = model('App\Modules\Sie\Models\Sie_Pensums');
$msubsectors = model('App\Modules\Sie\Models\Sie_Subsectors');
$mnetworks = model('App\Modules\Sie\Models\Sie_Networks');

$bootstrap = service('bootstrap');
$strings = model('App\Libraries\Strings');
//[models]--------------------------------------------------------------------------------------------------------------
$msettings = model("App\Modules\Sie\Models\Sie_Settings");
//[vars]----------------------------------------------------------------------------------------------------------------

$course = $mcourses->getCourse($oid);
$pensum = $mpensums->get_Pensum(@$course["pensum"]);
$module = $mmodules->getModule(@$pensum["module"]);
$subsector = $msubsectors->getSubsector(@$module["subsector"]);
$network = $mnetworks->getNetwork(@$subsector["network"]);


//echo(safe_dump($course));

if (!$course) {
    echo '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i>Curso no encontrado</div>';
    return;
}

$pensum_pensum = @$pensum["pensum"];
$pensum_name = @$module["name"];
$pensum_module = @$pensum["module"];

$course_code = $course["course"];
$course_name = $strings->get_URLDecode(@$course["name"]);
$course_reference = $course["reference"];
$course_program = $course["program"];
$course_period = $course["period"];
$course_teacher = $course["teacher"];
$course_pensum = $pensum_name . " - " . @$course["pensum"];
$course_network = @$network["name"] . " - " . @$subsector["network"];
$course_subsector = @$subsector["name"] . " - " . @$subsector["subsector"];
$course_moodle_course_id = @$subsector["moodle_course_base"];
$moodle_course_id = $course["moodle_course"];

// Obtener información adicional del programa si existe
$program_info = null;
if ($course_program) {
    $program_info = $mprograms->where('program', $course_program)->first();
}

// Verificar si el curso existe en Moodle
$moodle = new App\Libraries\Moodle();
$courseResult = $moodle->getCourse($course_code);


$moodle_url = $msettings->getSetting("MOODLE-URL");
?>


    <div class="row">
        <div class="col-12">
            <h2 class="mx-0 my-3 form-header">2. Estado del Curso en Moodle</h2>
            <div class="row">
                <div class="col-md-6">
                    <h2 class="mx-0 my-3 form-header">2.1. Información del Curso</h2>
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Código:</strong></td>
                            <td><?php echo $course_code; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Nombre:</strong></td>
                            <td><?php echo $course_name; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Referencia:</strong></td>
                            <td><?php echo $course_reference; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Programa:</strong></td>
                            <td><?php echo $program_info ? $strings->get_URLDecode($program_info['name']) : $course_program; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Período:</strong></td>
                            <td><?php echo $course_period; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Profesor:</strong></td>
                            <td><?php echo $course_teacher; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Pensum:</strong></td>
                            <td><?php echo $course_pensum; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Red Académica:</strong></td>
                            <td><?php echo $course_network; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Subsector Académico:</strong></td>
                            <td><?php echo $course_subsector; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Curso Base:</strong></td>
                            <td><?php echo $course_moodle_course_id; ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h2 class="mx-0 my-3 form-header">2.2. Estado en Moodle</h2>
                    <div id="moodle-status">
                        <?php if ($courseResult !== false && $courseResult > 0): ?>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>
                                <strong>Curso Registrado</strong>
                                <hr>
                                <small>
                                    <strong>ID Moodle:</strong>
                                    <a href="#"
                                       onclick="confirmMoodleAccess(<?php echo $courseResult; ?>); return false;"
                                       class="text-primary fw-bold">
                                        <?php echo $courseResult; ?>
                                        <i class="fas fa-external-link-alt ms-1"></i>
                                    </a><br>
                                    <strong>Código:</strong> <?php echo $course_code; ?><br>
                                    <strong>Estado:</strong> Activo en Moodle
                                </small>
                            </div>
                            <?php if ($moodle_course_id != $courseResult): ?>
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Discrepancia Detectada</strong>
                                    <hr>
                                    <small>El ID local (<?php echo $moodle_course_id; ?>) no coincide con el
                                        ID de Moodle
                                        (<a href="#"
                                            onclick="confirmMoodleAccess(<?php echo $courseResult; ?>); return false;"
                                            class="text-primary fw-bold">
                                            <?php echo $courseResult; ?>
                                            <i class="fas fa-external-link-alt ms-1"></i>
                                        </a>)</small>
                                </div>
                                <div class="d-grid mb-2">
                                    <button type="button" class="btn btn-warning" id="btn-sync-moodle">
                                        <i class="fas fa-sync me-2"></i>
                                        Sincronizar ID con Moodle
                                    </button>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Curso No Registrado</strong>
                                <hr>
                                <small>Este curso no existe en Moodle</small>
                            </div>
                            <div class="d-grid">
                                <button type="button" class="btn btn-primary" id="btn-create-moodle">
                                    <i class="fas fa-plus me-2"></i>
                                    Crear Curso en Moodle
                                </button>
                            </div>
                        <?php endif; ?>
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
                <div id="loading-message">Procesando...</div>
            </div>
        </div>
    </div>

    <!-- Modal de advertencia para acceso a Moodle -->
    <div class="modal fade" id="moodleAccessModal" tabindex="-1" aria-labelledby="moodleAccessModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="moodleAccessModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Advertencia - Acceso a Moodle
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Importante:</strong> Estás a punto de acceder al curso en Moodle.
                    </div>
                    <p class="mb-3">
                        Para poder ver y administrar el curso correctamente, necesitas:
                    </p>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Tener Moodle abierto en otra pestaña
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Estar logueado como <strong>administrador</strong>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Tener permisos de administración activos
                        </li>
                    </ul>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Si no cumples estos requisitos, <strong>cancela</strong> e inicia sesión como administrador
                        antes de continuar.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>
                        Cancelar
                    </button>
                    <button type="button" class="btn btn-primary" id="confirmMoodleAccessBtn">
                        <i class="fas fa-external-link-alt me-2"></i>
                        Continuar a Moodle
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btnCreate = document.getElementById('btn-create-moodle');
            const btnSync = document.getElementById('btn-sync-moodle');
            const loadingOverlay = document.getElementById('loading-overlay');
            const loadingMessage = document.getElementById('loading-message');
            const statusDiv = document.getElementById('moodle-status');

            // Variables para el modal de acceso a Moodle
            const moodleAccessModal = new bootstrap.Modal(document.getElementById('moodleAccessModal'));
            const confirmMoodleAccessBtn = document.getElementById('confirmMoodleAccessBtn');
            let currentMoodleCourseId = null;

            if (btnCreate) {
                btnCreate.addEventListener('click', function () {
                    loadingMessage.textContent = 'Creando curso en Moodle...';
                    loadingOverlay.style.display = 'block';
                    btnCreate.disabled = true;

                    const courseData = {
                        shortname: '<?php echo $course_code; ?>',
                        fullname: '<?php echo addslashes($course_name); ?>',
                        idnumber: '<?php echo $course_reference; ?>',
                        summary: 'Curso creado automáticamente desde SIE',
                        categoryid: 1,
                        format: 'topics',
                        visible: 1
                    };

                    fetch(window.location.href, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'action=create_moodle_course&course_data=' + encodeURIComponent(JSON.stringify(courseData))
                    })
                        .then(response => response.json())
                        .then(data => {
                            loadingOverlay.style.display = 'none';
                            console.log('Respuesta completa del servidor:', data);

                            if (data.success) {
                                window.location.reload();
                            } else {
                                // Mostrar error detallado
                                let errorMessage = data.message || 'Error desconocido';
                                let debugInfo = '';

                                if (data.debug_info) {
                                    debugInfo = '<br><br><strong>Información de Debug:</strong><br>';
                                    debugInfo += '<pre style="background: #f8f9fa; padding: 10px; border-radius: 4px; font-size: 12px; max-height: 300px; overflow-y: auto;">';
                                    debugInfo += JSON.stringify(data.debug_info, null, 2);
                                    debugInfo += '</pre>';
                                }

                                if (data.error_type) {
                                    errorMessage += '<br><strong>Tipo de Error:</strong> ' + data.error_type;
                                }

                                if (data.error_message) {
                                    errorMessage += '<br><strong>Mensaje Técnico:</strong> ' + data.error_message;
                                }

                                showError(errorMessage + debugInfo);
                            }
                        })
                        .catch(error => {
                            loadingOverlay.style.display = 'none';
                            console.error('Error de red o parsing:', error);
                            showError('Error de conexión o respuesta inválida: ' + error.message + '<br><br>Revisa la consola del navegador para más detalles.');
                        });
                });
            }

            if (btnSync) {
                btnSync.addEventListener('click', function () {
                    loadingMessage.textContent = 'Sincronizando ID con Moodle...';
                    loadingOverlay.style.display = 'block';
                    btnSync.disabled = true;

                    fetch(window.location.href, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'action=sync_moodle_course&course_id=<?php echo $course_code; ?>'
                    })
                        .then(response => response.json())
                        .then(data => {
                            loadingOverlay.style.display = 'none';
                            console.log('Respuesta completa del servidor (sync):', data);

                            if (data.success) {
                                window.location.reload();
                            } else {
                                // Mostrar error detallado
                                let errorMessage = data.message || 'Error desconocido';
                                let debugInfo = '';

                                if (data.debug_info) {
                                    debugInfo = '<br><br><strong>Información de Debug:</strong><br>';
                                    debugInfo += '<pre style="background: #f8f9fa; padding: 10px; border-radius: 4px; font-size: 12px; max-height: 300px; overflow-y: auto;">';
                                    debugInfo += JSON.stringify(data.debug_info, null, 2);
                                    debugInfo += '</pre>';
                                }

                                if (data.error_type) {
                                    errorMessage += '<br><strong>Tipo de Error:</strong> ' + data.error_type;
                                }

                                if (data.error_message) {
                                    errorMessage += '<br><strong>Mensaje Técnico:</strong> ' + data.error_message;
                                }

                                showError(errorMessage + debugInfo);
                            }
                        })
                        .catch(error => {
                            loadingOverlay.style.display = 'none';
                            console.error('Error de red o parsing (sync):', error);
                            showError('Error de conexión o respuesta inválida: ' + error.message + '<br><br>Revisa la consola del navegador para más detalles.');
                        });
                });
            }

            function showError(message) {
                statusDiv.innerHTML = `
            <div class="alert alert-danger">
                <i class="fas fa-times-circle me-2"></i>
                <strong>Error Detallado</strong>
                <hr>
                <div style="max-height: 400px; overflow-y: auto;">
                    ${message}
                </div>
                <hr>
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    Los logs detallados del servidor se encuentran en el error_log de PHP.
                    <br>También puedes revisar la consola del navegador (F12) para más información.
                </small>
            </div>
            <div class="d-grid gap-2">
                <button type="button" class="btn btn-primary" onclick="window.location.reload()">
                    <i class="fas fa-redo me-2"></i>
                    Intentar Nuevamente
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="copyErrorToClipboard()">
                    <i class="fas fa-copy me-2"></i>
                    Copiar Error al Portapapeles
                </button>
            </div>
        `;
            }

            function copyErrorToClipboard() {
                const errorContent = statusDiv.innerText;
                navigator.clipboard.writeText(errorContent).then(function () {
                    // Mostrar feedback temporal
                    const copyBtn = document.querySelector('button[onclick="copyErrorToClipboard()"]');
                    const originalText = copyBtn.innerHTML;
                    copyBtn.innerHTML = '<i class="fas fa-check me-2"></i>Copiado!';
                    copyBtn.classList.remove('btn-outline-secondary');
                    copyBtn.classList.add('btn-success');

                    setTimeout(() => {
                        copyBtn.innerHTML = originalText;
                        copyBtn.classList.remove('btn-success');
                        copyBtn.classList.add('btn-outline-secondary');
                    }, 2000);
                }).catch(function (err) {
                    console.error('Error al copiar al portapapeles:', err);
                    alert('No se pudo copiar al portapapeles. Selecciona manualmente el texto del error.');
                });
            }

            // Función para confirmar acceso a Moodle
            window.confirmMoodleAccess = function (courseId) {
                currentMoodleCourseId = courseId;

                // Reproducir audio de advertencia
                try {
                    const audio = new Audio('/themes/assets/audios/sie/es-courses-view-moodle-link.mp3');
                    audio.play().catch(function (error) {
                        console.log('No se pudo reproducir el audio de advertencia:', error);
                    });
                } catch (error) {
                    console.log('Error al crear el objeto de audio:', error);
                }

                moodleAccessModal.show();
            };

            // Event listener para el botón de confirmación del modal
            confirmMoodleAccessBtn.addEventListener('click', function () {
                if (currentMoodleCourseId) {
                    const moodleUrl = `<?php echo($moodle_url["value"]); ?>/course/view.php?id=${currentMoodleCourseId}`;
                    window.open(moodleUrl, '_blank');
                    moodleAccessModal.hide();
                    currentMoodleCourseId = null;
                }
            });
        });
    </script>

<?php
// Procesar creación de curso si se envía la acción
if (isset($_POST['action']) && $_POST['action'] === 'create_moodle_course') {
    header('Content-Type: application/json');

    $courseDataJson = $_POST['course_data'] ?? '';
    $courseData = json_decode($courseDataJson, true);

    // Log detallado para debugging
    error_log("=== DEBUGGING CREACIÓN DE CURSO ===");
    error_log("Datos recibidos: " . print_r($_POST, true));
    error_log("Course Data JSON: " . $courseDataJson);
    error_log("Course Data Array: " . print_r($courseData, true));

    if (!$courseData) {
        $error_detail = [
                'success' => false,
                'message' => 'Datos del curso inválidos',
                'debug_info' => [
                        'received_json' => $courseDataJson,
                        'json_decode_error' => json_last_error_msg(),
                        'post_data' => $_POST
                ]
        ];
        error_log("Error JSON decode: " . json_encode($error_detail));
        echo json_encode($error_detail);
        exit;
    }

    try {
        // Log datos que se van a enviar a Moodle
        error_log("Enviando a Moodle - Course Data: " . json_encode($courseData));

        $result = $moodle->createCourse($courseData);

        error_log("Resultado de createCourse: " . print_r($result, true));

        if ($result !== false && $result > 0) {
            // Actualizar el campo moodle_course en la base de datos local
            $updateResult = $mcourses->update($oid, ['moodle_course' => $result]);

            error_log("Update result en BD local: " . ($updateResult ? 'SUCCESS' : 'FAILED'));

            echo json_encode([
                    'success' => true,
                    'message' => 'Curso creado exitosamente',
                    'courseId' => $result,
                    'debug_info' => [
                            'moodle_course_id' => $result,
                            'local_update' => $updateResult ? 'success' : 'failed',
                            'course_data_sent' => $courseData
                    ]
            ]);
        } else {
            $error_detail = [
                    'success' => false,
                    'message' => 'Error al crear el curso en Moodle - Respuesta inválida',
                    'debug_info' => [
                            'moodle_result' => $result,
                            'result_type' => gettype($result),
                            'course_data_sent' => $courseData,
                            'expected' => 'Número entero mayor a 0'
                    ]
            ];
            error_log("Error resultado inválido: " . json_encode($error_detail));
            echo json_encode($error_detail);
        }
    } catch (Exception $e) {
        $error_detail = [
                'success' => false,
                'message' => 'Error durante la creación del curso',
                'error_type' => get_class($e),
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'debug_info' => [
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'trace' => $e->getTraceAsString(),
                        'course_data_sent' => $courseData,
                        'oid' => $oid
                ]
        ];

        error_log("Exception en creación de curso: " . json_encode($error_detail));
        echo json_encode($error_detail);
    }
    exit;
}

// Procesar sincronización de ID si se envía la acción
if (isset($_POST['action']) && $_POST['action'] === 'sync_moodle_course') {
    header('Content-Type: application/json');

    $courseId = $_POST['course_id'] ?? '';

    // Log detallado para debugging
    error_log("=== DEBUGGING SINCRONIZACIÓN DE CURSO ===");
    error_log("Datos recibidos: " . print_r($_POST, true));
    error_log("Course ID: " . $courseId);
    error_log("OID: " . $oid);

    if (!$courseId) {
        $error_detail = [
                'success' => false,
                'message' => 'ID del curso inválido',
                'debug_info' => [
                        'received_course_id' => $courseId,
                        'post_data' => $_POST,
                        'oid' => $oid
                ]
        ];
        error_log("Error ID inválido: " . json_encode($error_detail));
        echo json_encode($error_detail);
        exit;
    }

    try {
        // Log antes de consultar Moodle
        error_log("Consultando curso en Moodle con ID: " . $courseId);

        // Obtener el ID real del curso en Moodle
        $moodleCourseId = $moodle->getCourse($courseId);

        error_log("Resultado de getCourse: " . print_r($moodleCourseId, true));

        if ($moodleCourseId !== false && $moodleCourseId > 0) {
            // Actualizar el campo moodle_course en la base de datos local
            $updateResult = $mcourses->update($oid, ['moodle_course' => $moodleCourseId]);

            error_log("Update result en BD local: " . ($updateResult ? 'SUCCESS' : 'FAILED'));

            echo json_encode([
                    'success' => true,
                    'message' => 'ID sincronizado exitosamente',
                    'courseId' => $moodleCourseId,
                    'debug_info' => [
                            'searched_course_id' => $courseId,
                            'found_moodle_id' => $moodleCourseId,
                            'local_update' => $updateResult ? 'success' : 'failed',
                            'oid' => $oid
                    ]
            ]);
        } else {
            $error_detail = [
                    'success' => false,
                    'message' => 'No se pudo obtener el ID del curso en Moodle',
                    'debug_info' => [
                            'searched_course_id' => $courseId,
                            'moodle_result' => $moodleCourseId,
                            'result_type' => gettype($moodleCourseId),
                            'expected' => 'Número entero mayor a 0',
                            'oid' => $oid
                    ]
            ];
            error_log("Error curso no encontrado: " . json_encode($error_detail));
            echo json_encode($error_detail);
        }
    } catch (Exception $e) {
        $error_detail = [
                'success' => false,
                'message' => 'Error durante la sincronización',
                'error_type' => get_class($e),
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'debug_info' => [
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'trace' => $e->getTraceAsString(),
                        'searched_course_id' => $courseId,
                        'oid' => $oid
                ]
        ];

        error_log("Exception en sincronización: " . json_encode($error_detail));
        echo json_encode($error_detail);
    }
    exit;
}


?>