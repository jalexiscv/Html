<?php
//[services]------------------------------------------------------------------------------------------------------------
$b = service("bootstrap");
$f = service("forms", array("lang" => "Versions."));
//[models]--------------------------------------------------------------------------------------------------------------
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$musers = model("App\Modules\Sie\Models\Sie_Users");
$mfields = model("App\Modules\Sie\Models\Sie_Users_Fields");
$mcourses = model('App\Modules\Sie\Models\Sie_Courses');
$mnrolleds = model("App\Modules\Sie\Models\Sie_Enrolleds");
$mexecutions = model('App\Modules\Sie\Models\Sie_Executions');
//$model = model("App\Modules\Sie\Models\Sie_Versions");

//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/sie/students/view/{$oid}";
$registration = $mregistrations->getRegistration($oid);


// Obtener parámetros de paginación desde GET
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 250;
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;

// Validar parámetros
$limit = max(1, min($limit, 1000)); // Entre 1 y 1000
$offset = max(0, $offset); // No negativo

$code = "";

$code .= "<table class='table table-bordered'>";
$code .= "<tr>";
$code .= "<th class=\"text-center text-nowrap\">#</th>";
$code .= "<th class=\"text-center text-nowrap\">Curso</th>";
$code .= "<th class=\"text-center text-nowrap\">MOODLE</th>";
$code .= "<th class=\"text-center text-nowrap\">SIE</th>";
$code .= "<th class=\"text-center text-nowrap\">Curso</th>";
$code .= "<th class=\"text-center text-nowrap\">Estado</th>";
$code .= "</tr>";

$enrolleds = $mcourses->get_EnrolledStudentsByCourses("2025B", $limit, $offset);

// Obtener total para información de paginación
$total = $mcourses->get_TotalEnrolledStudentsByCourses("2025B");

// Función para obtener el userid de Moodle
function getMoodleUserId($username)
{
    $url = "https://campus.utede.edu.co/userid.php?username=" . urlencode($username);

    $curl = curl_init();
    curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_USERAGENT => 'SIE-Moodle-Sync/1.0'
    ]);

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if ($response === false || $httpCode !== 200) {
        return ""; // Retornar vacío si hay error
    }

    // Limpiar la respuesta (remover espacios y saltos de línea)
    $json = json_decode($response, true);

    return (isset($json["userid"]) ? $json["userid"] : "XX");

}

$count = $offset; // Iniciar el conteo desde el offset de la paginación
foreach ($enrolleds as $enrolled) {
    $count++;
    $course_course = $enrolled["course_course"];
    $course_name = $enrolled["course_name"];
    $link_course = "<a href=\"/sie/courses/view/{$course_course}\" target=\"_blank\">{$course_course}</a>";
    $student_name = $enrolled["first_name"] . " " . $enrolled["second_name"] . " " . $enrolled["first_surname"] . " " . $enrolled["second_surname"];
    $identification_number = $enrolled["identification_number"];
    $moodle_course = $enrolled["moodle_course"];

    // Obtener el userid de Moodle para este estudiante
    $moodle_user = getMoodleUserId($identification_number);

    //[build]-----------------------------------------------------------------------------------------------------------
    $code .= "<tr id='td-{$count}' data-course='{$moodle_course}' data-user='{$moodle_user}'>";
    $code .= "<td class=\"text-center text-nowrap\">{$count}</td>";
    $code .= "<td class=\"text-left text-nowrap\">{$link_course}</td>";
    $code .= "<td class=\"text-left text-nowrap\">MOODLE-{$moodle_user}</td>";
    $code .= "<td class=\"text-left text-nowrap\">SIE-{$identification_number}</td>";
    $code .= "<td class=\"text-left text-nowrap\">{$moodle_course}</td>";
    $code .= "<td class=\"text-center text-nowrap\"></td>";
    $code .= "</tr>";
}

$code .= "</table>";

// Agregar paginación
$code .= "<div class='pagination'>";
$code .= "<ul class='pagination'>";
$pages = ceil($total / $limit);
for ($i = 0; $i < $pages; $i++) {
    $page = $i + 1;
    $offset = $i * $limit;
    $code .= "<li class='page-item'><a class='page-link' href='?limit={$limit}&offset={$offset}'>{$page}</a></li>";
}
$code .= "</ul>";
$code .= "</div>";

cache()->clean();
//[build]---------------------------------------------------------------------------------------------------------------

$card = $b->get_Card2("create", array(
        "header-title" => "Sincronización de curso  y estudiantes con Moodle",
        "content" => $code,
        "header-back" => $back,
        "footer-class" => "text-end",
    //"footer-continue" => "/sie/courses/view/{$oid}",
));
echo($card);
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let isPaused = false;
        let isProcessing = false;

        async function processTableRows() {
            if (isProcessing) return; // Evitar múltiples ejecuciones

            isProcessing = true;
            isPaused = false;
            updateButtonStates();

            const rows = document.querySelectorAll('table tr[data-course][data-user]');

            for (let i = 0; i < rows.length; i++) {
                // Verificar si está pausado
                while (isPaused && isProcessing) {
                    await new Promise(resolve => setTimeout(resolve, 100)); // Esperar mientras está pausado
                }

                // Si se detuvo el procesamiento, salir del bucle
                if (!isProcessing) break;

                const row = rows[i];
                const courseId = row.getAttribute('data-course');
                const studentId = row.getAttribute('data-user');
                const statusCell = row.querySelector('td:last-child');
                statusCell.innerHTML = '<span class="badge bg-warning">Procesando...</span>';
                await processEnrollment(courseId, studentId, statusCell);
                await new Promise(resolve => setTimeout(resolve, 200));
            }

            isProcessing = false;
            updateButtonStates();
            console.log('Procesamiento completado para todas las filas');
        }

        function pauseProcessing() {
            isPaused = true;
            updateButtonStates();
        }

        function resumeProcessing() {
            isPaused = false;
            updateButtonStates();
        }

        function stopProcessing() {
            isProcessing = false;
            isPaused = false;
            updateButtonStates();
        }

        function updateButtonStates() {
            const processButton = document.getElementById('processButton');
            const pauseButton = document.getElementById('pauseButton');
            const resumeButton = document.getElementById('resumeButton');
            const stopButton = document.getElementById('stopButton');

            if (isProcessing && !isPaused) {
                // Procesando
                processButton.disabled = true;
                pauseButton.disabled = false;
                resumeButton.disabled = true;
                stopButton.disabled = false;
                pauseButton.style.display = 'inline-block';
                resumeButton.style.display = 'none';
            } else if (isProcessing && isPaused) {
                // Pausado
                processButton.disabled = true;
                pauseButton.disabled = true;
                resumeButton.disabled = false;
                stopButton.disabled = false;
                pauseButton.style.display = 'none';
                resumeButton.style.display = 'inline-block';
            } else {
                // Detenido
                processButton.disabled = false;
                pauseButton.disabled = true;
                resumeButton.disabled = true;
                stopButton.disabled = true;
                pauseButton.style.display = 'inline-block';
                resumeButton.style.display = 'none';
            }
        }

        async function processEnrollment(courseId, studentId, statusCell) {
            try {
                var timestamp = Math.floor(Date.now() / 1000);
                const endpoint = '/sie/api/moodle/json/course-synch/' + timestamp;
                const response = await fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        course: courseId,
                        user: studentId
                    })
                });
                const data = await response.json();
                if (response.ok && data.success) {
                    statusCell.innerHTML = '<span class="badge bg-success">Procesado</span>';
                } else {
                    statusCell.innerHTML = '<span class="badge bg-danger">Error</span>';
                }
            } catch (error) {
                console.error('Error al procesar:', error);
                statusCell.innerHTML = '<span class="badge bg-danger">Error de conexión</span>';
            }
        }

        // Crear contenedor de botones
        const buttonContainer = document.createElement('div');
        buttonContainer.className = 'mb-3';
        buttonContainer.style.display = 'flex';
        buttonContainer.style.gap = '10px';

        // Botón principal de procesamiento
        const processButton = document.createElement('button');
        processButton.id = 'processButton';
        processButton.className = 'btn btn-primary';
        processButton.textContent = 'Procesar Sincronización';
        processButton.onclick = processTableRows;

        // Botón de pausa
        const pauseButton = document.createElement('button');
        pauseButton.id = 'pauseButton';
        pauseButton.className = 'btn btn-warning';
        pauseButton.textContent = 'Pausar';
        pauseButton.onclick = pauseProcessing;
        pauseButton.disabled = true;

        // Botón de reanudar
        const resumeButton = document.createElement('button');
        resumeButton.id = 'resumeButton';
        resumeButton.className = 'btn btn-success';
        resumeButton.textContent = 'Reanudar';
        resumeButton.onclick = resumeProcessing;
        resumeButton.disabled = true;
        resumeButton.style.display = 'none';

        // Botón de detener
        const stopButton = document.createElement('button');
        stopButton.id = 'stopButton';
        stopButton.className = 'btn btn-danger';
        stopButton.textContent = 'Detener';
        stopButton.onclick = stopProcessing;
        stopButton.disabled = true;

        // Agregar botones al contenedor
        buttonContainer.appendChild(processButton);
        buttonContainer.appendChild(pauseButton);
        buttonContainer.appendChild(resumeButton);
        buttonContainer.appendChild(stopButton);

        // Insertar el contenedor antes de la tabla
        const table = document.querySelector('table');
        if (table) {
            table.parentNode.insertBefore(buttonContainer, table);
        }
    });
</script>