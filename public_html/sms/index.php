<?php
/**
 * Script de prueba para envío de SMS
 *
 * Este script demuestra el uso de la clase SMS para enviar un mensaje de prueba
 * utilizando la API de Háblame.co
 *
 * @author Cascade
 * @version 1.0
 */

// Incluimos la clase SMS
require_once 'Sms.php';

// Variable para mensajes de estado
$mensajeEstado = '';
$tipoAlerta = '';

// Si se envió el formulario de prueba
if (isset($_POST['enviar_prueba'])) {
    // Obtenemos los datos del formulario
    $numeroDestino = isset($_POST['numero']) ? trim($_POST['numero']) : '';
    $mensajePrueba = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';

    // Validamos los datos
    if (empty($numeroDestino) || empty($mensajePrueba)) {
        $mensajeEstado = 'Por favor, complete todos los campos.';
        $tipoAlerta = 'error';
    } else {
        // Configuración para la prueba con los datos del formulario
        $numeroDestino = $numeroDestino; // Número ingresado por el usuario
        $mensajePrueba = $mensajePrueba; // Mensaje ingresado por el usuario
    }
} else {
    // Valores por defecto si no se ha enviado el formulario
    $numeroDestino = '';
    $mensajePrueba = 'Este es un mensaje de prueba enviado desde la aplicación PHP utilizando la API de Háblame.co';
}

// Solo procesamos el envío si se ha enviado el formulario con todos los datos
if (isset($_POST['enviar_prueba']) && !empty($numeroDestino) && !empty($mensajePrueba)) {
    try {
        // Creamos una instancia de la clase SMS
        $sms = new Sms();

        // Intentamos enviar el mensaje
        $resultado = $sms->send($numeroDestino, $mensajePrueba);

        // Preparamos el mensaje de estado según el resultado
        if ($resultado['status'] == 'success') {
            $mensajeEstado = 'Mensaje enviado correctamente. ID: ' .
                    (isset($resultado['smsId']) ? $resultado['smsId'] : 'No disponible');
            $tipoAlerta = 'exito';

            // Registramos la prueba exitosa en un archivo de log
            $logFile = 'prueba_exitosa_' . date('Y-m-d_H-i-s') . '.log';
        } else {
            $mensajeEstado = 'Error al enviar el mensaje: ' . $resultado['message'];
            $tipoAlerta = 'error';

            // Registramos el error en un archivo de log
            $logFile = 'prueba_error_' . date('Y-m-d_H-i-s') . '.log';
        }

        // Contenido del log
        $logContent = "Fecha: " . date('Y-m-d H:i:s') . "\n";
        $logContent .= "Número: " . $numeroDestino . "\n";
        $logContent .= "Mensaje: " . $mensajePrueba . "\n";
        $logContent .= "Resultado: " . json_encode($resultado) . "\n";

        // Guardamos el log
        file_put_contents($logFile, $logContent);

    } catch (Exception $e) {
        // Capturamos cualquier excepción que pueda ocurrir
        $mensajeEstado = 'Error: ' . $e->getMessage();
        $tipoAlerta = 'error';
    }
}

// Mostramos la interfaz web para la prueba
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba de Envío SMS - API Háblame</title>
    <style>
        /* Estilos personalizados sin dependencias externas */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
            color: #333;
        }

        .contenedor {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #0056b3;
            text-align: center;
            margin-bottom: 30px;
        }

        .formulario {
            margin-bottom: 20px;
        }

        .grupo-formulario {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        textarea {
            height: 100px;
            resize: vertical;
        }

        .btn {
            display: inline-block;
            background-color: #0056b3;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #003d7a;
        }

        .alerta {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alerta-exito {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alerta-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .contador {
            margin-top: 5px;
            text-align: right;
            font-size: 12px;
            color: #6c757d;
        }

        .instrucciones {
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .configuracion-link {
            text-align: center;
            margin-top: 20px;
        }

        pre {
            background-color: #f8f9fa;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: auto;
            font-size: 12px;
        }

        .resultado-contenedor {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }

        .volver {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #0056b3;
            text-decoration: none;
        }

        .volver:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="contenedor">
    <h1>Prueba de Envío SMS - API Háblame</h1>

    <div class="instrucciones">
        <p>Esta herramienta te permite probar el envío de mensajes SMS utilizando la API de Háblame.co. Completa el
            formulario con el número de teléfono y el mensaje a enviar para realizar una prueba.</p>
    </div>

    <?php if (!empty($mensajeEstado)): ?>
        <div class="alerta alerta-<?php echo $tipoAlerta; ?>">
            <?php echo $mensajeEstado; ?>
        </div>

        <?php if (isset($resultado) && $tipoAlerta == 'exito'): ?>
            <div class="resultado-contenedor">
                <h3>Detalles del envío:</h3>
                <ul>
                    <li><strong>Estado:</strong> <?php echo $resultado['status']; ?></li>
                    <li><strong>Mensaje:</strong> <?php echo $resultado['message']; ?></li>
                    <?php if (isset($resultado['smsId'])): ?>
                        <li><strong>ID del SMS:</strong> <?php echo $resultado['smsId']; ?></li>
                    <?php endif; ?>
                    <?php if (isset($resultado['campaignId'])): ?>
                        <li><strong>ID de la campaña:</strong> <?php echo $resultado['campaignId']; ?></li>
                    <?php endif; ?>
                </ul>

                <h4>Respuesta completa de la API:</h4>
                <pre><?php print_r($resultado['rawResponse']); ?></pre>

                <p>Se ha guardado un registro de esta prueba en el archivo: <strong><?php echo $logFile; ?></strong></p>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="formulario">
        <form method="POST" action="">
            <div class="grupo-formulario">
                <label for="numero">Número de teléfono:</label>
                <input type="text" id="numero" name="numero" placeholder="Ej: 3001234567"
                       value="<?php echo htmlspecialchars($numeroDestino); ?>">
                <div class="instrucciones">Ingresa un número de teléfono válido de 10 dígitos.</div>
            </div>

            <div class="grupo-formulario">
                <label for="mensaje">Mensaje:</label>
                <textarea id="mensaje" name="mensaje" placeholder="Escribe tu mensaje aquí..."
                          maxlength="160"><?php echo htmlspecialchars($mensajePrueba); ?></textarea>
                <div class="contador"><span id="contador">0</span>/160 caracteres</div>
            </div>

            <button type="submit" name="enviar_prueba" class="btn">Enviar SMS de Prueba</button>
        </form>
    </div>

    <div class="configuracion-link">
        <a href="config.php" class="btn">Configurar API Key</a>
    </div>

    <a href="index.php" class="volver">Volver al Sistema Principal</a>
</div>

<script>
    // Script para contar caracteres del mensaje
    document.addEventListener('DOMContentLoaded', function () {
        var mensajeTextarea = document.getElementById('mensaje');
        var contadorSpan = document.getElementById('contador');

        /**
         * Función para actualizar el contador de caracteres
         */
        function actualizarContador() {
            var longitud = mensajeTextarea.value.length;
            contadorSpan.textContent = longitud;

            // Cambiamos el color cuando se acerca al límite
            if (longitud > 140) {
                contadorSpan.style.color = '#dc3545'; // Rojo
            } else if (longitud > 120) {
                contadorSpan.style.color = '#ffc107'; // Amarillo
            } else {
                contadorSpan.style.color = '#6c757d'; // Gris
            }
        }

        // Actualizamos al cargar la página
        actualizarContador();

        // Actualizamos al escribir
        mensajeTextarea.addEventListener('input', actualizarContador);
    });
</script>
</body>
</html>
?>
