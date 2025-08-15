<?php

$musers = model("App\Modules\Sie\Models\Sie_Users");
$mfields = model("App\Modules\Sie\Models\Sie_Users_Fields");

$limit = 1000;
$offset = 0;
$search = "";
$users = $musers->get_ListByType($limit, $offset, "TEACHER", $search);
$total = $musers->get_TotalByType("TEACHER", $search);

?>

<!-- Controles de procesamiento -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Sincronización de Profesores con Moodle</h5>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-primary" id="btn-process" onclick="startProcessing()">
                        <i class="fas fa-play"></i> Procesar
                    </button>
                    <button type="button" class="btn btn-warning" id="btn-pause" onclick="pauseProcessing()" disabled>
                        <i class="fas fa-pause"></i> Pausar
                    </button>
                    <button type="button" class="btn btn-success" id="btn-resume" onclick="resumeProcessing()" disabled>
                        <i class="fas fa-play"></i> Reanudar
                    </button>
                    <button type="button" class="btn btn-danger" id="btn-stop" onclick="stopProcessing()" disabled>
                        <i class="fas fa-stop"></i> Detener
                    </button>
                </div>
                <div class="mt-2">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 0%" id="progress-bar">0%</div>
                    </div>
                    <small class="text-muted" id="progress-text">Listo para procesar <?= count($users) ?>
                        profesores</small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$code = "";
$code .= " <table\n";
$code .= "\t\t id=\"grid-table\"\n";
$code .= "\t\t class=\"table table-striped table-hover\" \n ";
$code .= "\t\t border=\"1\">\n";
$code .= "\t\t <thead>";
$code .= "\t\t\t\t  <tr>\n";
$code .= "\t\t\t\t\t\t <th class='text-center' title=\"\">#</th>\n";
$code .= "\t\t\t\t\t\t <th class='text-center' title=\"\">Usuario</th>\n";
$code .= "\t\t\t\t\t\t <th class='text-center' title=\"\">Cédula</th>\n";
$code .= "\t\t\t\t\t\t <th class='text-center' title=\"\">Nombre</th>\n";
$code .= "\t\t\t\t\t\t <th class='text-center' title=\"\">Correo</th>\n";
$code .= "\t\t\t\t\t\t <th class='text-center' title=\"\">Estado</th>\n";
$code .= "\t\t\t\t  </tr>\n";
$code .= "\t\t </thead>";
$code .= "\t\t <tbody>";

$count = 0;
if ($users) {
    foreach ($users as $user) {
        //$profile = $mfields->get_Profile($user["user"]);
        $count++;
        $ruser = @$user["user"];
        $trid = @$user["user"];
        $citizenshipcard = @$user['citizenshipcard'];
        $fullname = strtoupper(@$user['firstname']) . " " . strtoupper(@$user['lastname']);
        $firstname = strtoupper(@$user['firstname']);
        $lastname = strtoupper(@$user['lastname']);
        $email = strtoupper(@$user['email']);
        // Fila
        $code .= "\t\t\t\t  <tr id=\"trid-{$trid}\" ";
        $code .= "data-registration=\"{$trid}\" ";
        $code .= "data-user=\"{$ruser}\" ";
        $code .= "data-citizenshipcard=\"{$citizenshipcard}\" ";
        $code .= "data-firstname=\"{$firstname}\" ";
        $code .= "data-lastname=\"{$lastname}\" ";
        $code .= "data-email=\"{$email}\" ";
        $code .= "data-registration=\"{$trid}\" ";
        $code .= "data-status=\"PENDING\" >\n";
        $code .= "\t\t\t\t\t <td class='text-center ' title=\"\" >{$count}</td>\n";
        $code .= "\t\t\t\t\t <td class='text-center ' title=\"\" >{$ruser}</td>\n";
        $code .= "\t\t\t\t\t <td class='text-center ' title=\"\" >{$citizenshipcard}</td>\n";
        $code .= "\t\t\t\t\t <td class='text-center ' title=\"\" >{$fullname}</td>\n";
        $code .= "\t\t\t\t\t <td class='text-center ' title=\"\" >{$email}</td>\n";
        $code .= "\t\t\t\t\t <td class='text-center status-cell' id=\"status-{$trid}\" title=\"\">\n";
        $code .= "\t\t\t\t\t\t <span class=\"badge badge-secondary\">PENDIENTE</span>\n";
        $code .= "\t\t\t\t\t </td>\n";
        $code .= "\t\t\t\t  </tr>\n";
    }
}

$code .= "\t\t </tbody>";
$code .= "</table>";

// Área de resumen final
$code .= "<div class=\"row mt-4\">";
$code .= "<div class=\"col-12\">";
$code .= "<div class=\"card\">";
$code .= "<div class=\"card-body\">";
$code .= "<h5 class=\"card-title\">Resumen de Procesamiento</h5>";
$code .= "<div class=\"row\">";
$code .= "<div class=\"col-md-3\">";
$code .= "<div class=\"text-center\">";
$code .= "<h4 class=\"text-primary\" id=\"total-count\">" . count($users) . "</h4>";
$code .= "<small class=\"text-muted\">Total</small>";
$code .= "</div>";
$code .= "</div>";
$code .= "<div class=\"col-md-3\">";
$code .= "<div class=\"text-center\">";
$code .= "<h4 class=\"text-success\" id=\"success-count\">0</h4>";
$code .= "<small class=\"text-muted\">Exitosos</small>";
$code .= "</div>";
$code .= "</div>";
$code .= "<div class=\"col-md-3\">";
$code .= "<div class=\"text-center\">";
$code .= "<h4 class=\"text-danger\" id=\"error-count\">0</h4>";
$code .= "<small class=\"text-muted\">Errores</small>";
$code .= "</div>";
$code .= "</div>";
$code .= "<div class=\"col-md-3\">";
$code .= "<div class=\"text-center\">";
$code .= "<h4 class=\"text-warning\" id=\"pending-count\">" . count($users) . "</h4>";
$code .= "<small class=\"text-muted\">Pendientes</small>";
$code .= "</div>";
$code .= "</div>";
$code .= "</div>";
$code .= "<div class=\"mt-3\">";
$code .= "<div id=\"final-status\" class=\"alert alert-info\">";
$code .= "<strong>Estado:</strong> Listo para iniciar procesamiento";
$code .= "</div>";
$code .= "</div>";
$code .= "</div>";
$code .= "</div>";
$code .= "</div>";
$code .= "</div>";

echo($code);
?>

<script>
    // Variables de control del procesamiento
    let isProcessing = false;
    let isPaused = false;
    let currentIndex = 0;
    let totalRows = 0;
    let successCount = 0;
    let errorCount = 0;
    let pendingCount = 0;

    // Inicializar contadores
    document.addEventListener('DOMContentLoaded', function () {
        const rows = document.querySelectorAll('#grid-table tbody tr');
        totalRows = rows.length;
        pendingCount = totalRows;
        updateCounters();
    });

    // Función para iniciar el procesamiento
    async function startProcessing() {
        if (isProcessing) return;

        isProcessing = true;
        isPaused = false;
        currentIndex = 0;
        successCount = 0;
        errorCount = 0;
        pendingCount = totalRows;

        updateButtons();
        updateFinalStatus('Iniciando procesamiento...');

        const rows = document.querySelectorAll('#grid-table tbody tr');

        for (let i = 0; i < rows.length; i++) {
            if (!isProcessing) break;

            // Esperar si está pausado
            while (isPaused && isProcessing) {
                await sleep(100);
            }

            if (!isProcessing) break;

            currentIndex = i;
            const row = rows[i];
            const trid = row.getAttribute('data-registration');

            // Actualizar progreso
            updateProgress(i + 1, rows.length);

            // Marcar como procesando
            updateRowStatus(trid, 'PROCESSING', 'PROCESANDO', 'badge-warning');

            try {
                // Realizar llamada XHR a UNAPI
                const result = await processTeacher(trid);

                if (result.success) {
                    updateRowStatus(trid, 'SUCCESS', 'EXITOSO', 'badge-success');
                    successCount++;
                    pendingCount--;
                } else {
                    updateRowStatus(trid, 'ERROR', result.message || 'ERROR', 'badge-danger');
                    errorCount++;
                    pendingCount--;
                }
            } catch (error) {
                updateRowStatus(trid, 'ERROR', 'ERROR DE CONEXIÓN', 'badge-danger');
                errorCount++;
                pendingCount--;
            }

            updateCounters();

            // Pausa entre procesamiento (200ms)
            if (i < rows.length - 1) {
                await sleep(200);
            }
        }

        // Finalizar procesamiento
        isProcessing = false;
        updateButtons();
        updateFinalStatus(`Procesamiento completado. Exitosos: ${successCount}, Errores: ${errorCount}`);
    }

    // Función para procesar un profesor individual
    async function processTeacher(trid) {
        return new Promise((resolve, reject) => {
            // Obtener la fila y extraer todos los datos
            const row = document.getElementById(`trid-${trid}`);
            if (!row) {
                resolve({success: false, message: 'Fila no encontrada'});
                return;
            }

            // Extraer todos los atributos de datos de la fila
            const teacherData = {
                user: row.getAttribute('data-user'),
                citizenshipcard: row.getAttribute('data-citizenshipcard'),
                firstname: row.getAttribute('data-firstname'),
                lastname: row.getAttribute('data-lastname'),
                email: row.getAttribute('data-email'),
                registration: row.getAttribute('data-registration'),
                timestamp: Date.now()
            };

            const xhr = new XMLHttpRequest();
            const url = '/sie/api/moodle/json/teachers-update/' + trid; // Endpoint para verificación de profesores

            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.timeout = 30000; // 30 segundos timeout

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            resolve(response);
                        } catch (e) {
                            resolve({success: false, message: 'Respuesta inválida'});
                        }
                    } else {
                        resolve({success: false, message: `Error HTTP: ${xhr.status}`});
                    }
                }
            };

            xhr.ontimeout = function () {
                // Considerar timeout como éxito (similar a la lógica de estudiantes)
                resolve({success: true, message: 'Procesado (timeout considerado como éxito)'});
            };

            xhr.onerror = function () {
                resolve({success: false, message: 'Error de conexión'});
            };

            // Enviar todos los datos del profesor
            xhr.send(JSON.stringify(teacherData));
        });
    }

    // Funciones de control
    function pauseProcessing() {
        isPaused = true;
        updateButtons();
        updateFinalStatus('Procesamiento pausado...');
    }

    function resumeProcessing() {
        isPaused = false;
        updateButtons();
        updateFinalStatus('Procesamiento reanudado...');
    }

    function stopProcessing() {
        isProcessing = false;
        isPaused = false;
        updateButtons();
        updateFinalStatus('Procesamiento detenido por el usuario');
    }

    // Funciones auxiliares
    function updateRowStatus(trid, status, text, badgeClass) {
        const statusCell = document.getElementById(`status-${trid}`);
        if (statusCell) {
            statusCell.innerHTML = `<span class="badge ${badgeClass}">${text}</span>`;
            const row = document.getElementById(`trid-${trid}`);
            if (row) {
                row.setAttribute('data-status', status);
            }
        }
    }

    function updateProgress(current, total) {
        const percentage = Math.round((current / total) * 100);
        const progressBar = document.getElementById('progress-bar');
        const progressText = document.getElementById('progress-text');

        if (progressBar) {
            progressBar.style.width = percentage + '%';
            progressBar.textContent = percentage + '%';
        }

        if (progressText) {
            progressText.textContent = `Procesando ${current} de ${total} profesores`;
        }
    }

    function updateCounters() {
        const totalElement = document.getElementById('total-count');
        const successElement = document.getElementById('success-count');
        const errorElement = document.getElementById('error-count');
        const pendingElement = document.getElementById('pending-count');

        if (totalElement) totalElement.textContent = totalRows;
        if (successElement) successElement.textContent = successCount;
        if (errorElement) errorElement.textContent = errorCount;
        if (pendingElement) pendingElement.textContent = pendingCount;
    }

    function updateButtons() {
        const btnProcess = document.getElementById('btn-process');
        const btnPause = document.getElementById('btn-pause');
        const btnResume = document.getElementById('btn-resume');
        const btnStop = document.getElementById('btn-stop');

        if (isProcessing && !isPaused) {
            btnProcess.disabled = true;
            btnPause.disabled = false;
            btnResume.disabled = true;
            btnStop.disabled = false;
        } else if (isProcessing && isPaused) {
            btnProcess.disabled = true;
            btnPause.disabled = true;
            btnResume.disabled = false;
            btnStop.disabled = false;
        } else {
            btnProcess.disabled = false;
            btnPause.disabled = true;
            btnResume.disabled = true;
            btnStop.disabled = true;
        }
    }

    function updateFinalStatus(message) {
        const finalStatus = document.getElementById('final-status');
        if (finalStatus) {
            finalStatus.innerHTML = `<strong>Estado:</strong> ${message}`;
        }
    }

    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }
</script>