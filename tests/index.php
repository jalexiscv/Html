<?php
/**
 * Procesamiento del código PHP enviado via AJAX
 * Ejecuta el código de forma segura y devuelve el resultado
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['code'])) {
    $code = $_POST['code'];
    
    // Validar que el código no esté vacío
    if (empty(trim($code))) {
        echo '<div class="alert alert-warning"><i class="fas fa-exclamation-triangle me-2"></i>No se ha proporcionado código para ejecutar.</div>';
        exit;
    }
    
    // Configurar buffer de salida para capturar la ejecución
    ob_start();
    
    // Configurar manejo de errores personalizado
    set_error_handler(function($severity, $message, $file, $line) {
        throw new ErrorException($message, 0, $severity, $file, $line);
    });
    
    try {
        // Evaluar el código PHP
        eval('?>' . $code);
        
    } catch (ParseError $e) {
        echo '<div class="alert alert-danger fade-in">';
        echo '<h5><i class="fas fa-exclamation-triangle me-2"></i>Error de Sintaxis</h5>';
        echo '<p class="mb-2"><strong>Mensaje:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
        echo '<small class="text-muted">Línea: ' . $e->getLine() . '</small>';
        echo '</div>';
        
    } catch (ErrorException $e) {
        echo '<div class="alert alert-warning fade-in">';
        echo '<h5><i class="fas fa-exclamation-circle me-2"></i>Advertencia PHP</h5>';
        echo '<p class="mb-2"><strong>Mensaje:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
        echo '<small class="text-muted">Línea: ' . $e->getLine() . '</small>';
        echo '</div>';
        
    } catch (Error $e) {
        echo '<div class="alert alert-danger fade-in">';
        echo '<h5><i class="fas fa-times-circle me-2"></i>Error Fatal</h5>';
        echo '<p class="mb-2"><strong>Mensaje:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
        echo '<small class="text-muted">Línea: ' . $e->getLine() . '</small>';
        echo '</div>';
        
    } catch (Exception $e) {
        echo '<div class="alert alert-danger fade-in">';
        echo '<h5><i class="fas fa-bug me-2"></i>Excepción</h5>';
        echo '<p class="mb-2"><strong>Mensaje:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
        echo '<small class="text-muted">Línea: ' . $e->getLine() . '</small>';
        echo '</div>';
    }
    
    // Restaurar manejo de errores por defecto
    restore_error_handler();
    
    // Obtener y limpiar la salida
    $output = ob_get_clean();
    
    // Si no hay salida visible, mostrar mensaje
    if (empty(trim(strip_tags($output)))) {
        echo '<div class="alert alert-info fade-in">';
        echo '<h5><i class="fas fa-info-circle me-2"></i>Ejecución Completa</h5>';
        echo '<p class="mb-0">El código se ejecutó correctamente pero no produjo salida visible.</p>';
        echo '</div>';
    } else {
        echo '<div class="execution-output">' . $output . '</div>';
    }
    
    exit; // Terminar ejecución para AJAX - CRÍTICO para evitar duplicación
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejecutor PHP - Entorno de Aprendizaje</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- CodeMirror CSS para el editor avanzado -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/theme/monokai.min.css">
    
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Estilos base y configuración del viewport */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            overflow: hidden;
        }

        .container-fluid {
            height: 100vh;
            padding: 0;
        }

        .main-container {
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Workspace ocupa todo el espacio disponible */
        .workspace {
            flex: 1;
            display: flex;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
        }
        
        /* Header mejorado */
        .header-gradient {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            padding: 15px 25px;
            border-bottom: 3px solid rgba(255,255,255,0.1);
            position: relative;
            overflow: hidden;
        }
        
        .header-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            animation: shimmer 3s infinite;
        }
        
        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }
        
        .header-content {
            position: relative;
            z-index: 2;
        }
        
        .header-title {
            font-size: 2.2rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            margin-bottom: 5px;
        }
        
        .header-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            font-weight: 300;
        }
        
        /* Paneles del editor y salida */
        .editor-panel, .output-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            height: 100%;
        }

        .editor-panel {
            border-right: none;
        }

        .panel-header {
            background: linear-gradient(135deg, #2d3748, #4a5568);
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
            flex-shrink: 0;
        }

        .panel-title h4 {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .editor-area, .output-area {
            flex: 1;
            position: relative;
            overflow: hidden;
        }

        .editor-area {
            background: #272822;
        }

        .output-area {
            background: #f8f9fa;
            overflow-y: auto;
        }
        
        /* Panel del editor */
        .editor-panel {
            flex: 1;
            background: #1e1e1e;
            display: flex;
            flex-direction: column;
            border-right: 3px solid #2d2d2d;
            position: relative;
        }
        
        .editor-panel::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 3px;
            height: 100%;
            background: linear-gradient(to bottom, #4f46e5, #7c3aed);
            z-index: 1;
        }
        
        /* Panel de salida */
        .output-panel {
            flex: 1;
            background: #f8fafc;
            display: flex;
            flex-direction: column;
            position: relative;
        }
        
        /* Headers de paneles */
        .panel-header {
            padding: 15px 20px;
            border-bottom: 2px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            backdrop-filter: blur(10px);
        }
        
        .editor-panel .panel-header {
            background: rgba(30, 30, 30, 0.95);
            color: #fff;
        }
        
        .output-panel .panel-header {
            background: rgba(248, 250, 252, 0.95);
            color: #374151;
            border-bottom-color: rgba(0,0,0,0.1);
        }
        
        .panel-title {
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .panel-controls {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        
        .control-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10b981;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        /* Área del editor */
        .editor-area {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .CodeMirror {
            flex: 1;
            height: auto !important;
            font-size: 14px;
            border-radius: 8px;
            border: 2px solid #2d2d2d;
            transition: border-color 0.3s ease;
        }
        
        .CodeMirror:hover {
            border-color: #4f46e5;
        }
        
        .CodeMirror-focused {
            border-color: #7c3aed !important;
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
        }
        
        /* Barra de herramientas del editor */
        .editor-toolbar {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .btn-group {
            display: flex;
            gap: 8px;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.3s ease, height 0.3s ease;
        }
        
        .btn:hover::before {
            width: 100%;
            height: 100%;
        }
        
        .btn-execute {
            background: linear-gradient(135deg, #10b981, #059669);
            border: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-execute:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }
        
        .btn-clear {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }
        
        .btn-clear:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #6b7280, #4b5563);
            color: white;
            box-shadow: 0 4px 15px rgba(107, 114, 128, 0.3);
        }
        
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(107, 114, 128, 0.4);
        }
        
        /* Área de salida */
        .output-area {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }
        
        #output {
            flex: 1;
            background: #ffffff;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            overflow-y: auto;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            line-height: 1.6;
            box-shadow: inset 0 2px 10px rgba(0,0,0,0.05);
            transition: border-color 0.3s ease;
        }
        
        #output:hover {
            border-color: #7c3aed;
        }
        
        /* Barra de estado */
        .status-bar {
            background: linear-gradient(135deg, #1a202c, #2d3748);
            color: white;
            padding: 0.5rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            flex-shrink: 0;
        }

        .status-info {
            display: flex;
            gap: 1.5rem;
        }

        .status-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .status-item i {
            font-size: 0.8rem;
        }
        
        /* Spinner de carga mejorado */
        .loading-spinner {
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Animaciones de entrada */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Scrollbar personalizada */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #3f37d9, #6d28d9);
        }
        
        /* Responsivo */
        @media (max-width: 768px) {
            .workspace {
                flex-direction: column;
            }
            
            .editor-panel, .output-panel {
                flex: none;
                height: 50vh;
            }
            
            .header-title {
                font-size: 1.8rem;
            }
            
            .btn {
                padding: 8px 16px;
                font-size: 0.8rem;
            }
        }
        
        /* Mejoras adicionales para elementos específicos */
        .alert {
            border-radius: 8px;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .alert-success {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
        }
        
        .alert-warning {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
        }
        
        .alert-info {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #1e40af;
        }
    </style>
</head>
<body>
    <!-- Modal de Bienvenida -->
    <div class="modal fade" id="welcomeModal" tabindex="-1" aria-labelledby="welcomeModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg" style="border: none; border-radius: 15px; overflow: hidden;">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); border: none;">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-rocket fa-2x me-3"></i>
                        <div>
                            <h4 class="modal-title mb-0" id="welcomeModalLabel">¡Bienvenido al Ejecutor PHP!</h4>
                            <small class="opacity-75">Ambiente de práctica y aprendizaje</small>
                        </div>
                    </div>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <i class="fas fa-code fa-4x text-primary mb-3"></i>
                        <h5 class="text-dark mb-3">Sistema Interactivo de Práctica PHP</h5>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-8 mx-auto">
                            <div class="alert alert-info d-flex align-items-start">
                                <i class="fas fa-info-circle fa-lg me-3 mt-1"></i>
                                <div>
                                    <h6 class="mb-2">Propósito de esta interfaz:</h6>
                                    <p class="mb-0">Esta herramienta fue diseñada para facilitar el <strong>aprendizaje y práctica de programación PHP</strong> de manera interactiva. Permite escribir, ejecutar y ver resultados de código PHP en tiempo real, ideal para estudiantes y desarrolladores que desean experimentar y aprender.</p>
                                </div>
                            </div>
                            
                            <div class="alert alert-success d-flex align-items-start">
                                <i class="fas fa-lightbulb fa-lg me-3 mt-1"></i>
                                <div>
                                    <h6 class="mb-2">Características principales:</h6>
                                    <ul class="mb-0 ps-3">
                                        <li>Editor de código con resaltado de sintaxis</li>
                                        <li>Ejecución segura de código PHP</li>
                                        <li>Interfaz moderna y amigable</li>
                                        <li>Atajos de teclado para mayor eficiencia</li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="alert alert-warning d-flex align-items-start">
                                <i class="fas fa-keyboard fa-lg me-3 mt-1"></i>
                                <div>
                                    <h6 class="mb-2">Atajos útiles:</h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <small><strong>Ctrl + Enter:</strong> Ejecutar código</small>
                                        </div>
                                        <div class="col-6">
                                            <small><strong>Ctrl + L:</strong> Limpiar editor</small>
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-6">
                                            <small><strong>F11:</strong> Pantalla completa</small>
                                        </div>
                                        <div class="col-6">
                                            <small><strong>Esc:</strong> Salir pantalla completa</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between align-items-center" style="background: #f8f9fa; border: none;">
                    <div class="text-muted">
                        <small>
                            <i class="fas fa-user-tie me-2"></i>
                            Creado por: <strong>Ing. Jose Alexis Correa Valencia</strong>
                        </small>
                    </div>
                    <button type="button" class="btn btn-primary px-4" data-bs-dismiss="modal" style="background: linear-gradient(135deg, #4f46e5, #7c3aed); border: none;">
                        <i class="fas fa-play me-2"></i>¡Comenzar a Programar!
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid p-0">
        <div class="main-container">
          
            <!-- Contenido principal con Grid de Bootstrap -->
            <div class="workspace">
                <!-- Panel del Editor -->
                <div class="editor-panel">
                    <div class="panel-header">
                        <div class="panel-title">
                            <i class="fas fa-code text-white me-2"></i>
                            <h4 class="mb-0">Editor de Código PHP</h4>
                        </div>
                        <div class="panel-controls">
                            <button id="execute-btn" class="btn btn-execute text-white px-4 py-2">
                                <i class="fas fa-play me-2"></i>
                                <span class="btn-text">Ejecutar Código</span>
                            </button>
                            <button id="clear-btn" class="btn btn-clear text-white px-4 py-2">
                                <i class="fas fa-trash me-2"></i>Limpiar Editor
                            </button>
                            <button id="diagnostic-btn" class="btn btn-secondary text-white px-4 py-2">
                                <i class="fas fa-bug me-2"></i>Diagnóstico
                            </button>
                        </div>
                    </div>
                    
                    <!-- Área del editor (será reemplazada por CodeMirror) -->
                    <div class="editor-area">
                        <textarea id="code-editor" class="form-control">
<?php
// Escribe tu código PHP aquí

?>
                        </textarea>
                    </div>
                </div>
                
                <!-- Panel de Salida -->
                <div class="output-panel">
                    <div class="panel-header">
                        <div class="panel-title">
                            <i class="fas fa-terminal me-2"></i>
                            <h4 class="mb-0">Resultado de la Ejecución</h4>
                        </div>
                    </div>
                    
                    <div class="output-area">
                        <div id="output" class="p-3">
                            <div class="text-muted text-center py-5">
                                <i class="fas fa-code-branch fa-3x mb-3 opacity-25"></i>
                                <p>Ejecuta tu código PHP para ver los resultados aquí</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Barra de estado -->
                    <div class="status-bar">
                        <div class="status-info">
                            <div class="status-item">
                                <i class="fas fa-circle text-success"></i>
                                <span>PHP Activo</span>
                            </div>
                            <div class="status-item">
                                <i class="fas fa-code"></i>
                                <span id="line-count">0 líneas</span>
                            </div>
                            <div class="status-item">
                                <i class="fas fa-clock"></i>
                                <span id="last-run">No ejecutado</span>
                            </div>
                        </div>
                        <div class="status-item">
                            <span>Ctrl+Enter: Ejecutar | Ctrl+L: Limpiar</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- CodeMirror JS para el editor avanzado -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/php/php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/xml/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/javascript/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/css/css.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/clike/clike.min.js"></script>

    <script>
        /**
         * Inicialización del Editor de Código CodeMirror
         * Configura un editor avanzado con resaltado de sintaxis PHP
         */
        let codeEditor;
        let executionCount = 0;
        
        // Código PHP predeterminado (usando concatenación para evitar interpretación del servidor)
        const DEFAULT_PHP_CODE = "<" + "?php\n// Escribe tu código PHP aquí\n\n?" + ">";
        
        // Función para inicializar el editor CodeMirror
        function initializeCodeEditor() {
            const textArea = document.getElementById('code-editor');
            codeEditor = CodeMirror.fromTextArea(textArea, {
                mode: 'application/x-httpd-php',
                theme: 'monokai',
                lineNumbers: true,
                indentUnit: 4,
                indentWithTabs: false,
                lineWrapping: true,
                matchBrackets: true,
                autoCloseBrackets: true,
                foldGutter: true,
                gutters: ['CodeMirror-linenumbers', 'CodeMirror-foldgutter'],
                extraKeys: {
                    'Ctrl-Space': 'autocomplete',
                    'F11': function(cm) {
                        cm.setOption('fullScreen', !cm.getOption('fullScreen'));
                    },
                    'Esc': function(cm) {
                        if (cm.getOption('fullScreen')) cm.setOption('fullScreen', false);
                    }
                }
            });
            
            // Añadir eventos al editor
            codeEditor.on('change', function() {
                updateLineCount();
                // Opcional: Auto-guardar o validación en tiempo real
            });
            
            // Actualizar contador de líneas inicial
            updateLineCount();
        }
        
        /**
         * Actualiza el contador de líneas en la barra de estado
         */
        function updateLineCount() {
            if (codeEditor) {
                const lineCount = codeEditor.lineCount();
                document.getElementById('line-count').textContent = lineCount + ' líneas';
            }
        }
        
        /**
         * Actualiza la información de última ejecución
         */
        function updateLastRun() {
            const now = new Date();
            const timeString = now.toLocaleTimeString();
            document.getElementById('last-run').textContent = `Ejecutado: ${timeString}`;
        }
        
        /**
         * Función para ejecutar el código PHP
         * Envía el código al servidor mediante AJAX vanilla
         */
        function executeCode() {
            const executeBtn = document.getElementById('execute-btn');
            const btnText = executeBtn.querySelector('.btn-text');
            const output = document.getElementById('output');
            
            // Obtener el código del editor
            const code = codeEditor.getValue();
            
            if (!code.trim()) {
                showMessage('Por favor, escribe algo de código PHP para ejecutar.', 'warning');
                return;
            }
            
            // Mostrar estado de carga
            executeBtn.disabled = true;
            btnText.textContent = 'Ejecutando...';
            executeBtn.insertAdjacentHTML('afterbegin', '<div class="loading-spinner me-2"></div>');
            
            // Mostrar mensaje de carga en output
            output.innerHTML = `
                <div class="text-center py-5">
                    <div class="loading-spinner mx-auto mb-3" style="width: 40px; height: 40px; border-width: 3px;"></div>
                    <h5 class="text-muted mb-2">Ejecutando código PHP...</h5>
                    <p class="text-muted small">Procesando tu código de manera segura</p>
                </div>
            `;
            
            // Crear y enviar petición AJAX
            const xhr = new XMLHttpRequest();
            xhr.open('POST', window.location.href, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    // Restaurar botón
                    executeBtn.disabled = false;
                    const spinner = executeBtn.querySelector('.loading-spinner');
                    if (spinner) spinner.remove();
                    btnText.textContent = 'Ejecutar Código';
                    
                    if (xhr.status === 200) {
                        // Mostrar resultado exitoso
                        output.innerHTML = '<div class="fade-in">' + xhr.responseText + '</div>';
                        showMessage('Código ejecutado exitosamente', 'success');
                        
                        // Actualizar estadísticas
                        executionCount++;
                        updateLastRun();
                        
                        // Scroll al resultado si es necesario
                        output.scrollTop = 0;
                        
                    } else {
                        // Mostrar error
                        output.innerHTML = `
                            <div class="alert alert-danger fade-in">
                                <h5><i class="fas fa-exclamation-triangle me-2"></i>Error de conexión</h5>
                                <p class="mb-2">No se pudo ejecutar el código. Verifica tu conexión y el servidor.</p>
                                <small class="text-muted">Código de estado: ${xhr.status}</small>
                            </div>
                        `;
                        showMessage('Error al ejecutar el código', 'error');
                    }
                }
            };
            
            xhr.onerror = function() {
                executeBtn.disabled = false;
                const spinner = executeBtn.querySelector('.loading-spinner');
                if (spinner) spinner.remove();
                btnText.textContent = 'Ejecutar Código';
                
                output.innerHTML = `
                    <div class="alert alert-danger fade-in">
                        <h5><i class="fas fa-times-circle me-2"></i>Error de red</h5>
                        <p class="mb-0">No se pudo conectar con el servidor. Verifica tu conexión a internet.</p>
                    </div>
                `;
                showMessage('Error de conexión', 'error');
            };
            
            // Enviar el código
            xhr.send('code=' + encodeURIComponent(code));
        }
        
        /**
         * Función para limpiar el editor
         * Borra todo el contenido del editor con confirmación
         */
        function clearEditor() {
            if (confirm('¿Estás seguro de que quieres limpiar el editor? Se perderá todo el código actual.')) {
                codeEditor.setValue(DEFAULT_PHP_CODE);
                document.getElementById('output').innerHTML = `
                    <div class="text-muted text-center py-5">
                        <i class="fas fa-code-branch fa-3x mb-3 opacity-25"></i>
                        <p>Ejecuta tu código PHP para ver los resultados aquí</p>
                        <small>Usa Ctrl+Enter para ejecutar rápidamente</small>
                    </div>
                `;
                showMessage('Editor limpiado', 'info');
                updateLineCount();
                document.getElementById('last-run').textContent = 'No ejecutado';
            }
        }
        
        /**
         * Función para mostrar mensajes toast mejorados
         * @param {string} message - Mensaje a mostrar
         * @param {string} type - Tipo de mensaje (success, error, warning, info)
         */
        function showMessage(message, type) {
            // Verificar si Bootstrap está disponible
            if (typeof bootstrap !== 'undefined') {
                // Usar toast de Bootstrap
                showBootstrapToast(message, type);
            } else {
                // Fallback: usar alert simple o crear elemento básico
                showBasicMessage(message, type);
            }
        }
        
        /**
         * Mostrar toast usando Bootstrap
         */
        function showBootstrapToast(message, type) {
            // Crear elemento toast
            const toast = document.createElement('div');
            toast.className = `alert alert-${getBootstrapClass(type)} alert-dismissible fade show position-fixed`;
            toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 320px; max-width: 400px; box-shadow: 0 10px 30px rgba(0,0,0,0.3);';
            
            toast.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="fas ${getIcon(type)} me-3" style="font-size: 1.2rem;"></i>
                    <div class="flex-grow-1">
                        <strong>${getTitle(type)}</strong><br>
                        <small>${message}</small>
                    </div>
                    <button type="button" class="btn-close ms-2" data-bs-dismiss="alert"></button>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            // Auto-eliminar después de 4 segundos
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.classList.add('fade');
                    setTimeout(() => toast.remove(), 300);
                }
            }, 4000);
        }
        
        /**
         * Mostrar mensaje básico sin Bootstrap
         */
        function showBasicMessage(message, type) {
            // Crear elemento simple
            const messageDiv = document.createElement('div');
            messageDiv.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                padding: 15px 20px;
                border-radius: 5px;
                color: white;
                font-family: Arial, sans-serif;
                font-size: 14px;
                max-width: 400px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                background: ${getBasicColor(type)};
                border-left: 4px solid ${getBasicBorderColor(type)};
            `;
            
            messageDiv.innerHTML = `
                <strong>${getTitle(type)}:</strong> ${message}
                <span style="float: right; cursor: pointer; margin-left: 15px;" onclick="this.parentNode.remove()">×</span>
            `;
            
            document.body.appendChild(messageDiv);
            
            // Auto-eliminar después de 4 segundos
            setTimeout(() => {
                if (messageDiv.parentNode) {
                    messageDiv.remove();
                }
            }, 4000);
        }
        
        /**
         * Obtener colores básicos para mensajes sin Bootstrap
         */
        function getBasicColor(type) {
            const colors = {
                success: '#10b981',
                error: '#ef4444',
                warning: '#f59e0b',
                info: '#3b82f6'
            };
            return colors[type] || '#3b82f6';
        }
        
        /**
         * Obtener colores de borde para mensajes sin Bootstrap
         */
        function getBasicBorderColor(type) {
            const colors = {
                success: '#059669',
                error: '#dc2626',
                warning: '#d97706',
                info: '#2563eb'
            };
            return colors[type] || '#2563eb';
        }
        
        /**
         * Helper: Obtener clase de Bootstrap según el tipo
         */
        function getBootstrapClass(type) {
            const classes = {
                success: 'success',
                error: 'danger',
                warning: 'warning',
                info: 'info'
            };
            return classes[type] || 'info';
        }
        
        /**
         * Helper: Obtener icono según el tipo
         */
        function getIcon(type) {
            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                warning: 'fa-exclamation-triangle',
                info: 'fa-info-circle'
            };
            return icons[type] || 'fa-info-circle';
        }
        
        /**
         * Helper: Obtener título según el tipo
         */
        function getTitle(type) {
            const titles = {
                success: 'Éxito',
                error: 'Error',
                warning: 'Advertencia',
                info: 'Información'
            };
            return titles[type] || 'Información';
        }
        
        /**
         * Función para manejar atajos de teclado
         */
        function handleKeyboardShortcuts(event) {
            // Ctrl+Enter para ejecutar código
            if (event.ctrlKey && event.key === 'Enter') {
                event.preventDefault();
                executeCode();
            }
            
            // Ctrl+L para limpiar editor
            if (event.ctrlKey && event.key === 'l') {
                event.preventDefault();
                clearEditor();
            }
            
            // F11 para pantalla completa del editor
            if (event.key === 'F11') {
                event.preventDefault();
                if (codeEditor) {
                    codeEditor.setOption('fullScreen', !codeEditor.getOption('fullScreen'));
                }
            }
        }
        
        /**
         * Función para actualizar el estado de la aplicación
         */
        function updateAppStatus() {
            // Actualizar indicadores de estado
            const statusIndicators = document.querySelectorAll('.control-indicator');
            statusIndicators.forEach(indicator => {
                indicator.style.background = '#10b981';
            });
        }
        
        /**
         * Función de diagnóstico para verificar el estado del sistema
         */
        function runDiagnostics() {
            console.log('=== DIAGNÓSTICO DEL SISTEMA ===');
            
            // Verificar Bootstrap
            if (typeof bootstrap !== 'undefined') {
                console.log('✓ Bootstrap 5 cargado correctamente');
            } else {
                console.warn('✗ Bootstrap 5 no está disponible');
            }
            
            // Verificar CodeMirror
            if (typeof CodeMirror !== 'undefined') {
                console.log('✓ CodeMirror cargado correctamente');
            } else {
                console.warn('✗ CodeMirror no está disponible');
            }
            
            // Verificar Font Awesome
            const fontAwesome = document.querySelector('link[href*="font-awesome"]');
            if (fontAwesome) {
                console.log('✓ Font Awesome referenciado');
            } else {
                console.warn('✗ Font Awesome no encontrado');
            }
            
            // Verificar elementos DOM críticos
            const criticalElements = [
                'execute-btn',
                'clear-btn', 
                'code-editor',
                'output'
            ];
            
            criticalElements.forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    console.log(`✓ Elemento ${id} encontrado`);
                } else {
                    console.error(`✗ Elemento ${id} NO encontrado`);
                }
            });
            
            // Información del navegador
            console.log('Navegador:', navigator.userAgent);
            console.log('Versión PHP detectada en servidor:', '<?php echo PHP_VERSION; ?>');
            
            console.log('=== FIN DIAGNÓSTICO ===');
        }
        
        /**
         * Inicialización cuando el DOM está listo
         */
        document.addEventListener('DOMContentLoaded', function() {
            // Verificar si Bootstrap está disponible
            const bootstrapAvailable = typeof bootstrap !== 'undefined';
            
            // Mostrar modal de bienvenida si Bootstrap está disponible
            if (bootstrapAvailable) {
                try {
                    const welcomeModal = new bootstrap.Modal(document.getElementById('welcomeModal'));
                    setTimeout(() => {
                        welcomeModal.show();
                    }, 500);
                } catch (error) {
                    console.warn('Error al mostrar modal de Bootstrap:', error);
                    // Fallback: mostrar mensaje de bienvenida simple
                    showWelcomeFallback();
                }
            } else {
                console.warn('Bootstrap no está disponible, usando fallback');
                showWelcomeFallback();
            }
            
            // Verificar si CodeMirror está disponible
            if (typeof CodeMirror !== 'undefined') {
                // Inicializar el editor CodeMirror
                initializeCodeEditor();
            } else {
                console.warn('CodeMirror no está disponible, usando textarea simple');
                // Fallback: usar textarea simple
                initializeFallbackEditor();
            }
            
            // Configurar event listeners con JavaScript vanilla
            const executeBtn = document.getElementById('execute-btn');
            const clearBtn = document.getElementById('clear-btn');
            const diagnosticBtn = document.getElementById('diagnostic-btn');
            
            if (executeBtn) {
                executeBtn.addEventListener('click', executeCode);
            }
            
            if (clearBtn) {
                clearBtn.addEventListener('click', clearEditor);
            }
            
            if (diagnosticBtn) {
                diagnosticBtn.addEventListener('click', runDiagnostics);
            }
            
            // Configurar atajos de teclado
            document.addEventListener('keydown', handleKeyboardShortcuts);
            
            // Actualizar estado de la aplicación
            updateAppStatus();
            
            // Configurar redimensionamiento automático
            window.addEventListener('resize', function() {
                if (codeEditor && typeof codeEditor.refresh === 'function') {
                    codeEditor.refresh();
                }
            });
        });
        
        /**
         * Función fallback para mostrar bienvenida sin Bootstrap
         */
        function showWelcomeFallback() {
            setTimeout(() => {
                showMessage('¡Bienvenido al Ejecutor PHP! Creado por Ing. Jose Alexis Correa Valencia. Sistema para practicar y aprender programación PHP.', 'info');
            }, 1000);
        }
        
        /**
         * Función fallback para editor sin CodeMirror
         */
        function initializeFallbackEditor() {
            const textArea = document.getElementById('code-editor');
            if (textArea) {
                // Configurar el textarea con estilos básicos
                textArea.style.fontFamily = 'Consolas, Monaco, "Courier New", monospace';
                textArea.style.fontSize = '14px';
                textArea.style.lineHeight = '1.5';
                textArea.style.tabSize = '4';
                
                // Establecer contenido inicial
                const initialCode = DEFAULT_PHP_CODE;
                textArea.value = initialCode;
                
                // Simular objeto editor para compatibilidad
                codeEditor = {
                    getValue: function() {
                        return textArea.value;
                    },
                    setValue: function(value) {
                        textArea.value = value;
                    },
                    lineCount: function() {
                        return textArea.value.split('\n').length;
                    },
                    refresh: function() {
                        // No hacer nada en fallback
                    }
                };
                
                // Actualizar contador de líneas inicial
                updateLineCount();
                
                // Agregar listener para actualizar contador
                textArea.addEventListener('input', updateLineCount);
            }
        }
        
        // Prevenir pérdida de datos al cerrar la página
        window.addEventListener('beforeunload', function(event) {
            const code = codeEditor ? codeEditor.getValue() : '';
            const defaultCode = DEFAULT_PHP_CODE;
            
            if (code.trim() && code !== defaultCode) {
                event.preventDefault();
                event.returnValue = 'Tienes código sin guardar. ¿Estás seguro de que quieres salir?';
            }
        });
    </script>
</body>
</html>