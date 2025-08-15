<?php
//[services]------------------------------------------------------------------------------------------------------------
$b = service("bootstrap");
$f = service("forms", array("lang" => "Versions."));
//[models]--------------------------------------------------------------------------------------------------------------
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$musers = model("App\Modules\Sie\Models\Sie_Users");
$mfields = model("App\Modules\Sie\Models\Sie_Users_Fields");
$mcourses = model("App\Modules\Sie\Models\Sie_Courses");
//$model = model("App\Modules\Sie\Models\Sie_Versions");
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/sie/students/view/{$oid}";
$registration = $mregistrations->get_Registration($oid);

$console = array();
$console[] = "> Tyrell Sycamore QS";
$console[] = "> Aurora(AI) 5.0";
$console[] = "> Sincronización de curso.";
$console[] = "> Iniciando...";
$console[] = "> 001: Identificando el cursos a sincronizar ... {$oid}";

//--- Paso 1: Establecer preexistencia del curso -----------------------------------------------------------------------
$course = $mcourses->get_Course($oid);
$course_name = $course["name"];
$course_code = $course["course"];
$course_description = $course["description"];
$course_moodle_id = $course["moodle_course"];
$console[] = "> 002: Estableciendo preexistencia del curso...";
$console[] = "> 003: El curso en el Sistema Integral Educacativo (SIE) se llama {$course_name} y su codigo es {$course_code}...";
$console[] = "> 004: El curso se describe como {$course_description}...";
//--- Paso 2: Establecer preexistencia del curso -----------------------------------------------------------------------
$console[] = "> 005: Verificando existencia en el Moodle...";
if (!empty($course_moodle_id)) {
    $console[] = "> 006: Se supone que el código del curso en el Moodle es {$course_moodle_id}...";
    $console[] = "> 007: Verificando preexistencia del curso en el Moodle...";
    include("moodle-course-exist.php");
} else {
    $console[] = "> 006: No se pudo identificar el código del curso en el Moodle...";
    $console[] = "> 007: No se puede continuar...";
}

$console[] = "> 008: Consultando estudiantes matriculados en el curso...";
//--- Paso 3: Establecer preexistencia del curso -----------------------------------------------------------------------
include("query-students.php");


/**
 * $user=$mfields->get_UserByEmail($email);
 *
 * if(!empty($user)){
 * $console[]="> 005: El usuario existe... {$user}";
 * $console[]="> 006: Se actualizará la contraseña... {$password}";
 * $console[]="> 007: Se enlazó el usuario con el perfil academico... {$oid}";
 * $console[]="> 008: Operación completada con exito...";
 * $console[]="> 009: Nuevos datos de acceso: ";
 * $console[]="> 010: Correo electrónico: {$email}";
 * $console[]="> 011: Contraseña: {$password}";
 * $mfields->insert(array("field" => pk(), "user" => $user, "name" => "password", "value" => $password));
 * $mfields->insert(array("field" => pk(), "user" => $user, "name" => "sie-registration", "value" => $oid));
 * }else{
 * $console[]="> 005: El usuario no existe...";
 * $console[]="> 006: Se creará un nuevo usuario...";
 * $console[]="> 007: Se enlazó el nuevo usuario con el perfil academico... {$oid}";
 * $console[]="> 008: Nuevos datos de acceso: ";
 * $console[]="> 009: Correo electrónico: {$email}";
 * $console[]="> 010: Contraseña: {$password}";
 * $alias = explode('@', $email)[0];
 * $type="STUDENT";
 * $firstname=@$registration["first_name"]." ".@$registration["second_name"];
 * $lastname=@$registration["first_surname"]." ".@$registration["second_surname"];
 * $d = array("user" => pk(),"author" => safe_get_user());
 * $create = $musers->insert($d);
 * $mfields->insert(array("field" => pk(), "user" => $d["user"], "name" => "email", "value" => $email));
 * $mfields->insert(array("field" => pk(), "user" => $d["user"], "name" => "password", "value" => $password));
 * $mfields->insert(array("field" => pk(), "user" => $d["user"], "name" => "alias", "value" => $alias));
 * $mfields->insert(array("field" => pk(), "user" => $d["user"], "name" => "type", "value" => $type));
 * $mfields->insert(array("field" => pk(), "user" => $d["user"], "name" => "firstname", "value" => $firstname));
 * $mfields->insert(array("field" => pk(), "user" => $d["user"], "name" => "lastname", "value" => $lastname));
 * $mfields->insert(array("field" => pk(), "user" => $d["user"], "name" => "moodle-password", "value" => $password));
 * $mfields->insert(array("field" => pk(), "user" => $d["user"], "name" => "sie-registration", "value" => $oid));
 * }
 **/

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

    // Comandos que se mostrarán
    const commands = [
        <?php foreach ($console as $command) : ?>
        '<?php echo $command; ?>',
        <?php endforeach; ?>
    ];

    // Función para escribir texto caracter por caracter
    async function typeText(text) {
        const output = document.getElementById('output');
        for (let char of text) {
            output.innerHTML += char;
            typeSound.play();
            await new Promise(resolve => setTimeout(resolve, 0));
        }
        output.innerHTML += '<br>';
    }

    // Función para ejecutar todos los comandos
    async function executeCommands() {
        for (let command of commands) {
            await typeText(command);
            await new Promise(resolve => setTimeout(resolve, 3));
        }

        // Reproducir sonido de finalización
        completionSound.play();

        // Opcional: Añadir un mensaje de finalización
        const output = document.getElementById('output');
        output.innerHTML += '<span style="color: #00ff00;">Proceso completado ✓</span><br>';
    }

    // Iniciar la simulación cuando se carga la página
    window.onload = executeCommands;
</script>