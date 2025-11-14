<?php

/**
 * Script de prueba para el sistema de versionado automático
 *
 * Este archivo demuestra cómo usar el sistema de versionado de assets
 * para evitar problemas de caché del navegador.
 */

// Carga el autoloader del tema
require_once 'php/autoload.php';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba de Versionado - Tema Beta</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS versionado usando función helper -->
    <?php echo asset_css('css/dashboard.css'); ?>

    <style>
        .version-info {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 1rem;
            margin: 1rem 0;
        }

        .hash-display {
            font-family: 'Courier New', monospace;
            background: #e9ecef;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">🔄 Sistema de Versionado Automático</h1>

            <div class="version-info">
                <h3>📊 Información de Versión Actual</h3>
                <?php
                $vm = getVersionManager();
                if ($vm) {
                    $buildVersion = $vm->getBuildVersion();
                    $buildTimestamp = $vm->getBuildTimestamp();
                    $buildDate = date('Y-m-d H:i:s', $buildTimestamp);

                    echo "<p><strong>Hash del Build:</strong> <span class='hash-display'>{$buildVersion}</span></p>";
                    echo "<p><strong>Timestamp:</strong> <span class='hash-display'>{$buildTimestamp}</span></p>";
                    echo "<p><strong>Fecha del Build:</strong> <span class='hash-display'>{$buildDate}</span></p>";
                } else {
                    echo "<p class='text-warning'>⚠️ VersionManager no está disponible</p>";
                }
                ?>
            </div>

            <div class="version-info">
                <h3>🎨 URLs de Assets Versionadas</h3>
                <?php
                if ($vm) {
                    echo "<p><strong>CSS Dashboard:</strong><br>";
                    echo "<code>" . htmlspecialchars($vm->getVersionedAssetUrl('css/dashboard.css')) . "</code></p>";

                    echo "<p><strong>JS Dashboard:</strong><br>";
                    echo "<code>" . htmlspecialchars($vm->getVersionedAssetUrl('js/dashboard.js')) . "</code></p>";

                    echo "<p><strong>Imagen de ejemplo:</strong><br>";
                    echo "<code>" . htmlspecialchars($vm->getVersionedAssetUrl('images/logo.png')) . "</code></p>";
                }
                ?>
            </div>

            <div class="version-info">
                <h3>🏷️ Etiquetas HTML Generadas</h3>
                <?php
                if ($vm) {
                    echo "<p><strong>Etiqueta CSS:</strong></p>";
                    echo "<pre><code>" . htmlspecialchars($vm->getCssTag('css/dashboard.css')) . "</code></pre>";

                    echo "<p><strong>Etiqueta JS:</strong></p>";
                    echo "<pre><code>" . htmlspecialchars($vm->getJsTag('js/dashboard.js')) . "</code></pre>";
                }
                ?>
            </div>

            <div class="alert alert-info">
                <h4>📝 Cómo Funciona</h4>
                <ol>
                    <li>Cada vez que ejecutas <code>python build.py</code>, se genera un hash único para cada archivo
                    </li>
                    <li>Los archivos CSS/JS se cargan con parámetros <code>?v=hash</code></li>
                    <li>Cuando cambias un archivo, su hash cambia automáticamente</li>
                    <li>El navegador detecta el nuevo hash y descarga la versión actualizada</li>
                    <li>¡No más problemas de caché! 🎉</li>
                </ol>
            </div>

            <div class="alert alert-success">
                <h4>🚀 Uso en Plantillas</h4>
                <p>En tus archivos de plantilla HTML, usa estas funciones:</p>
                <ul>
                    <li><code>asset_css('css/archivo.css')</code> - Para archivos CSS</li>
                    <li><code>asset_js('js/archivo.js')</code> - Para archivos JavaScript</li>
                    <li><code>asset_url('ruta/archivo')</code> - Para cualquier asset</li>
                    <li><code>asset_img('images/imagen.png')</code> - Para imágenes</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- JS versionado usando función helper -->
<?php echo asset_js('js/dashboard.js'); ?>
</body>
</html>
