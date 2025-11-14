<?php

/**
 * Visor de Logs - Interfaz para ver error logs desde la UI
 *
 * Este archivo proporciona una interfaz web para visualizar los logs de debug
 * del sistema de sidebar dinámico en tiempo real.
 */

// Procesar solicitudes AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');

    switch ($_POST['action']) {
        case 'get_logs':
            $logFile = __DIR__ . '/debug.log';
            $phpErrorLog = ini_get('error_log');

            $response = array(
                    'debug_log' => '',
                    'php_error_log' => '',
                    'debug_log_exists' => false,
                    'php_error_log_exists' => false
            );

            // Leer debug.log local
            if (file_exists($logFile)) {
                $response['debug_log_exists'] = true;
                $content = file_get_contents($logFile);
                // Obtener las últimas 50 líneas
                $lines = explode("\n", $content);
                $response['debug_log'] = implode("\n", array_slice($lines, -50));
            }

            // Leer error log de PHP si existe
            if ($phpErrorLog && file_exists($phpErrorLog)) {
                $response['php_error_log_exists'] = true;
                $content = file_get_contents($phpErrorLog);
                $lines = explode("\n", $content);
                $response['php_error_log'] = implode("\n", array_slice($lines, -50));
            }

            echo json_encode($response);
            exit;

        case 'clear_logs':
            $logFile = __DIR__ . '/debug.log';
            if (file_exists($logFile)) {
                file_put_contents($logFile, '');
            }
            echo json_encode(['success' => true]);
            exit;
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visor de Logs - Beta Theme</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .log-container {
            background: #1e1e1e;
            color: #d4d4d4;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.4;
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #444;
            border-radius: 4px;
            padding: 15px;
            white-space: pre-wrap;
        }

        .log-container::-webkit-scrollbar {
            width: 8px;
        }

        .log-container::-webkit-scrollbar-track {
            background: #2d2d2d;
        }

        .log-container::-webkit-scrollbar-thumb {
            background: #555;
            border-radius: 4px;
        }

        .log-container::-webkit-scrollbar-thumb:hover {
            background: #777;
        }

        .error-line {
            color: #f48771;
        }

        .debug-line {
            color: #569cd6;
        }

        .warning-line {
            color: #dcdcaa;
        }

        .timestamp {
            color: #808080;
        }

        .modal-lg {
            max-width: 90%;
        }

        .btn-floating {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .refresh-indicator {
            display: none;
            color: #28a745;
        }
    </style>
</head>
<body>
<!-- Botón flotante para abrir el visor -->
<button type="button" class="btn btn-primary btn-floating" data-bs-toggle="modal" data-bs-target="#logModal"
        title="Ver Logs de Debug">
    <i class="fas fa-file-alt fa-lg"></i>
</button>

<!-- Modal del visor de logs -->
<div class="modal fade" id="logModal" tabindex="-1" aria-labelledby="logModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="logModalLabel">
                    <i class="fas fa-terminal me-2"></i>Visor de Logs de Debug
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <!-- Controles -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <button class="btn btn-success btn-sm" onclick="refreshLogs()">
                            <i class="fas fa-sync-alt me-1"></i>Actualizar
                            <span class="refresh-indicator">
                                    <i class="fas fa-spinner fa-spin ms-1"></i>
                                </span>
                        </button>
                        <button class="btn btn-warning btn-sm ms-2" onclick="clearLogs()">
                            <i class="fas fa-trash me-1"></i>Limpiar
                        </button>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="form-check form-switch d-inline-block">
                            <input class="form-check-input" type="checkbox" id="autoRefresh">
                            <label class="form-check-label" for="autoRefresh">Auto-actualizar</label>
                        </div>
                    </div>
                </div>

                <!-- Pestañas -->
                <ul class="nav nav-tabs" id="logTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="debug-tab" data-bs-toggle="tab" data-bs-target="#debug-log"
                                type="button" role="tab">
                            <i class="fas fa-bug me-1"></i>Debug Log
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="error-tab" data-bs-toggle="tab" data-bs-target="#error-log"
                                type="button" role="tab">
                            <i class="fas fa-exclamation-triangle me-1"></i>PHP Error Log
                        </button>
                    </li>
                </ul>

                <!-- Contenido de las pestañas -->
                <div class="tab-content mt-3" id="logTabsContent">
                    <div class="tab-pane fade show active" id="debug-log" role="tabpanel">
                        <div class="log-container" id="debugLogContent">
                            Cargando logs de debug...
                        </div>
                    </div>
                    <div class="tab-pane fade" id="error-log" role="tabpanel">
                        <div class="log-container" id="errorLogContent">
                            Cargando error log de PHP...
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <small class="text-muted me-auto">
                    <i class="fas fa-info-circle me-1"></i>
                    Mostrando las últimas 50 líneas de cada log
                </small>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let autoRefreshInterval;

    // Función para actualizar los logs
    function refreshLogs() {
        const indicator = document.querySelector('.refresh-indicator');
        indicator.style.display = 'inline';

        fetch('log_viewer.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=get_logs'
        })
            .then(response => response.json())
            .then(data => {
                // Actualizar debug log
                const debugContent = document.getElementById('debugLogContent');
                if (data.debug_log_exists) {
                    debugContent.innerHTML = formatLogContent(data.debug_log);
                } else {
                    debugContent.innerHTML = '<span class="text-muted">No se encontró debug.log</span>';
                }

                // Actualizar error log
                const errorContent = document.getElementById('errorLogContent');
                if (data.php_error_log_exists) {
                    errorContent.innerHTML = formatLogContent(data.php_error_log);
                } else {
                    errorContent.innerHTML = '<span class="text-muted">No se encontró error log de PHP</span>';
                }

                // Scroll al final
                debugContent.scrollTop = debugContent.scrollHeight;
                errorContent.scrollTop = errorContent.scrollHeight;

                indicator.style.display = 'none';
            })
            .catch(error => {
                console.error('Error al cargar logs:', error);
                indicator.style.display = 'none';
            });
    }

    // Función para formatear el contenido del log
    function formatLogContent(content) {
        if (!content.trim()) {
            return '<span class="text-muted">Log vacío</span>';
        }

        return content
            .replace(/\[([^\]]+)\]/g, '<span class="timestamp">[$1]</span>')
            .replace(/(ERROR|Fatal error|Parse error)/gi, '<span class="error-line">$1</span>')
            .replace(/(DEBUG)/gi, '<span class="debug-line">$1</span>')
            .replace(/(WARNING|Notice)/gi, '<span class="warning-line">$1</span>');
    }

    // Función para limpiar logs
    function clearLogs() {
        if (confirm('¿Estás seguro de que quieres limpiar el debug log?')) {
            fetch('log_viewer.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=clear_logs'
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        refreshLogs();
                    }
                });
        }
    }

    // Auto-refresh
    document.getElementById('autoRefresh').addEventListener('change', function () {
        if (this.checked) {
            autoRefreshInterval = setInterval(refreshLogs, 3000);
        } else {
            clearInterval(autoRefreshInterval);
        }
    });

    // Cargar logs cuando se abre el modal
    document.getElementById('logModal').addEventListener('shown.bs.modal', function () {
        refreshLogs();
    });

    // Limpiar interval cuando se cierra el modal
    document.getElementById('logModal').addEventListener('hidden.bs.modal', function () {
        clearInterval(autoRefreshInterval);
        document.getElementById('autoRefresh').checked = false;
    });

    // Atajos de teclado
    document.addEventListener('keydown', function (e) {
        // Ctrl + L para abrir logs
        if (e.ctrlKey && e.key === 'l') {
            e.preventDefault();
            const modal = new bootstrap.Modal(document.getElementById('logModal'));
            modal.show();
        }

        // F5 para actualizar logs (solo si el modal está abierto)
        if (e.key === 'F5' && document.getElementById('logModal').classList.contains('show')) {
            e.preventDefault();
            refreshLogs();
        }
    });
</script>
</body>
</html>
