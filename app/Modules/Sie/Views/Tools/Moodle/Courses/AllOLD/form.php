<?php
//[services]------------------------------------------------------------------------------------------------------------
$b = service("bootstrap");
$f = service("forms", array("lang" => "Versions."));
//[models]--------------------------------------------------------------------------------------------------------------
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$musers = model("App\Modules\Sie\Models\Sie_Users");
$mfields = model("App\Modules\Sie\Models\Sie_Users_Fields");
$mcourses = model('App\Modules\Sie\Models\Sie_Courses');
//$model = model("App\Modules\Sie\Models\Sie_Versions");
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/sie/students/view/{$oid}";
$registration = $mregistrations->getRegistration($oid);

$console = array();
$console[] = "> Tyrell Sycamore QS";
$console[] = "> Aurora(AI) 5.0";
$console[] = "> Sincronización de curso.";
$console[] = "> Iniciando...";
$console[] = "> 001: Identificando los cursos a sincronizar ... {$oid}";


$courses = $mcourses
        ->where('period', "2025B")
        ->find();
$count = 0;
$course_ids = array(); // Array para almacenar los IDs de los cursos
foreach ($courses as $course) {
    $count++;
    $course_ids[] = $course["course"]; // Agregar ID del curso al array
}

$console[] = "> 002: Se procesarán {$count} cursos en total...";
$console[] = "> 003: Iniciando procesamiento individual...";

cache()->clean();
//[build]---------------------------------------------------------------------------------------------------------------
$code = "";
$code .= "<div class=\"container p-0\">";
$code .= "<div class=\"terminal\" id=\"terminal\">";
$code .= "<div id=\"output\"></div>";
$code .= "<span class=\"cursor\">▋</span>";
$code .= "</div>";
$code .= "</div>";
$card = $b->get_Card2("create", array(
        "header-title" => "Sincronización de curso  y estudiantes con Moodle",
        "content" => $code,
        "header-back" => $back,
        "footer-class" => "text-end",
        "footer-continue" => "/sie/courses/view/{$oid}",
));
echo($card);
?>
<style>
    .terminal {
        background-color: #000;
        color: #ffffff;
        font-family: 'Courier New', Courier, monospace;
        height: 400px;
        padding: 10px;
        overflow-y: auto;
        border-radius: 5px;
        font-size: 12px;
    }

    .cursor {
        animation: blink 1s infinite;
    }

    @keyframes blink {
        0% {
            opacity: 0;
        }
        50% {
            opacity: 1;
        }
        100% {
            opacity: 0;
        }
    }
</style>


<script>
    // Crear los elementos de audio
    const typeSound = new Audio('/themes/assets/audios/terminal.mp3?v2');
    const completionSound = new Audio(''); // Añade el nuevo sonido

    // Vector con los IDs de los cursos desde PHP
    const courseIds = [
        <?php foreach ($course_ids as $index => $course_id) : ?>
        '<?php echo $course_id; ?>'<?php echo ($index < count($course_ids) - 1) ? ',' : ''; ?>
        <?php endforeach; ?>
    ];

    // Comandos iniciales que se mostrarán
    const initialCommands = [
        <?php foreach ($console as $command) : ?>
        '<?php echo $command; ?>',
        <?php endforeach; ?>
    ];

    let output = null;

    // Función para hacer scroll automático al final de la terminal
    function scrollToBottom() {
        const terminal = document.getElementById('terminal');
        if (terminal) {
            terminal.scrollTop = terminal.scrollHeight;
        }
    }

    // Función para escribir texto caracter por caracter
    async function typeText(text, useSound = true) {
        if (!output) output = document.getElementById('output');
        for (let char of text) {
            output.innerHTML += char;
            if (useSound) typeSound.play();
            await new Promise(resolve => setTimeout(resolve, 0));
        }
        output.innerHTML += '<br>';

        // Hacer scroll automático después de agregar texto
        scrollToBottom();
    }

    // Función para realizar llamada XHR para un curso específico
    async function processCourse(courseId) {
        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/sie/api/moodle/json/course-synch/' + courseId, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        try {
                            const response = JSON.parse(xhr.responseText);

                            // Verificar si hay error en la respuesta
                            if (response.error === false || response.success === true) {
                                resolve({
                                    courseId: courseId,
                                    success: true,
                                    error: false,
                                    data: response
                                });
                            } else {
                                resolve({
                                    courseId: courseId,
                                    success: false,
                                    error: true,
                                    message: response.message || 'Error en el procesamiento',
                                    data: response
                                });
                            }
                        } catch (e) {
                            resolve({
                                courseId: courseId,
                                success: false,
                                error: true,
                                message: 'Error al procesar respuesta JSON: ' + e.message
                            });
                        }
                    } else {
                        resolve({
                            courseId: courseId,
                            success: false,
                            error: true,
                            message: `Error HTTP: ${xhr.status}`
                        });
                    }
                }
            };

            xhr.onerror = function () {
                resolve({
                    courseId: courseId,
                    success: false,
                    error: true,
                    message: 'Error de conexión'
                });
            };

            // Enviar datos del curso
            xhr.send('course_id=' + encodeURIComponent(courseId) + '&action=synchronize');
        });
    }

    // Función para procesar todos los cursos secuencialmente
    async function processAllCourses() {
        let processedCount = 0;
        let successCount = 0;
        let errorCount = 0;
        let shouldContinue = true;

        for (let courseId of courseIds) {
            if (!shouldContinue) {
                await typeText(`> PROCESO DETENIDO: Se encontró un error crítico`, false);
                break;
            }

            processedCount++;

            // Mostrar que se está procesando el curso
            await typeText(`> 004.${processedCount}: Procesando curso ${courseId}...`, false);

            try {
                const result = await processCourse(courseId);

                if (result.success && result.error === false) {
                    successCount++;
                    await typeText(`> 004.${processedCount}.1: ✓ Curso ${courseId} procesado exitosamente`, false);

                    if (result.data && result.data.message) {
                        await typeText(`> 004.${processedCount}.2: ${result.data.message}`, false);
                    }

                    // Mostrar detalles adicionales si están disponibles
                    if (result.data && result.data.details && result.data.details.moodle_status) {
                        await typeText(`> 004.${processedCount}.3: Estado Moodle: ${result.data.details.moodle_status}`, false);
                    }

                } else {
                    errorCount++;
                    await typeText(`> 004.${processedCount}.1: ✗ Error procesando curso ${courseId}`, false);
                    await typeText(`> 004.${processedCount}.2: ${result.message}`, false);

                    // Opcional: detener el procesamiento si hay errores críticos
                    // shouldContinue = false; // Descomenta esta línea si quieres detener en el primer error
                }
            } catch (error) {
                errorCount++;
                await typeText(`> 004.${processedCount}.1: ✗ Excepción procesando curso ${courseId}: ${error.message}`, false);
                // shouldContinue = false; // Descomenta si quieres detener en excepciones
            }

            // Pausa entre cursos para no sobrecargar el servidor
            await new Promise(resolve => setTimeout(resolve, 200));
        }

        // Mostrar resumen final
        await typeText(`> 005: Procesamiento completado`, false);
        await typeText(`> 006: Total procesados: ${processedCount}`, false);
        await typeText(`> 007: Exitosos: ${successCount}`, false);
        await typeText(`> 008: Errores: ${errorCount}`, false);

        if (errorCount === 0) {
            await typeText(`> 009: ✓ Todos los cursos se procesaron sin errores`, false);
        } else {
            await typeText(`> 009: ⚠ Se encontraron ${errorCount} errores durante el procesamiento`, false);
        }

        // Reproducir sonido de finalización
        completionSound.play();

        // Mensaje final con color según el resultado
        const finalColor = errorCount === 0 ? '#00ff00' : '#ffaa00';
        output.innerHTML += `<span style="color: ${finalColor};">Sincronización masiva completada ✓</span><br>`;
    }

    // Función para ejecutar comandos iniciales y luego procesar cursos
    async function executeCommands() {
        output = document.getElementById('output');

        // Mostrar comandos iniciales
        for (let command of initialCommands) {
            await typeText(command);
            await new Promise(resolve => setTimeout(resolve, 0));
        }

        // Procesar todos los cursos
        await processAllCourses();
    }

    // Iniciar la simulación cuando se carga la página
    window.onload = executeCommands;
</script>