<?php
/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2023-12-01 23:19:27
 *  ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 *  ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 *  ** █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 *  ** █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 *  ** █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 *  ** █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 *  ** █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 *  ** █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 *  ** █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 *  ** █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 *  ** █ @link https://www.codehiggs.com
 *  ** █ @Version 1.5.0 @since PHP 7, PHP 8
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ Datos recibidos desde el controlador - @ModuleController
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */

include dirname(__FILE__) . "/headers.php";
include dirname(__FILE__) . "/settings.php";

// Set some common aliases
$aliases = array(
    'la' => 'ls -la',
    'll' => 'ls -lvhF',
);

// If we have no cwd set in session, set it now
if (false === isset($_SESSION['cwd'])) {
    $_SESSION['cwd'] = $docRoot . $iceRoot;
}

// Change to cwd
chdir($_SESSION['cwd']);

// Get current user and cwd
if (true === $systemClass->functionEnabled("shell_exec")) {
    $user = str_replace("\n", "", shell_exec("whoami"));
    $cwd = str_replace("\n", "", shell_exec("pwd"));
} else {
    $user = "";
    $cwd = "";
}

// Check if we have proc_open_enabled
// (Used later to handle commands)
function proc_open_enabled()
{
    $disabled = explode(',', ini_get('disable_functions'));
    return false === in_array('proc_open', $disabled);
}

// Return HTML prompt plus the command the user provided last
function returnHTMLPromptCommand($cmd)
{
    global $user, $cwd;
    // Begin output with prompt and user command
    return '<div class="commandLine"><div class="user">&nbsp;&nbsp;' . $user . '&nbsp;</div>' .
        '<div class="cwd">&nbsp;' . $cwd . '&nbsp;</div> : ' . date("H:m:s") .
        '<br>' .
        '<div class="promptVLine"></div><div class="promptHLine">─<div class="promptArrow">▶</div></div> ' . $cmd . '</div></div><br>';
}

// If proc_open isn't enabled, display prompt, command and a message re needing this enabled
if (false === proc_open_enabled()) {
    echo json_encode([
        "output" => returnHTMLPromptCommand($_REQUEST['command'] . "<br><br>Sorry but you can't use this terminal if your proc_open is disabled"),
        "user" => $user,
        "cwd" => $cwd
    ]);
    exit;
}

// If in demo mode, display message and go no further
if (true === $demoMode) {
    echo json_encode([
        "output" => returnHTMLPromptCommand($_REQUEST['command'] . "<br><br>Sorry, shell usage not enabled in demo mode"),
        "user" => $user,
        "cwd" => $cwd
    ]);
    exit;
}

// If no command, display message and go no further
if (false === isset($_REQUEST['command'])) {
    echo json_encode([
        "output" => returnHTMLPromptCommand($_REQUEST['command'] . "<br><br>Sorry, no command received"),
        "user" => $user,
        "cwd" => $cwd
    ]);
    exit;
}

// Strip any slashes from command
$_REQUEST['command'] = stripslashes($_REQUEST['command']);

// Start output with the prompt and command they provided last
$output = returnHTMLPromptCommand($_REQUEST['command']);

// If command contains cd but no dir
if (preg_match('/^[[:blank:]]*cd[[:blank:]]*$/', $_REQUEST['command'])) {
    $_SESSION['cwd'] = $cwd;
// Else cd to a dir
} elseif (preg_match('/^[[:blank:]]*cd[[:blank:]]+([^;]+)$/', $_REQUEST['command'], $regs)) {
    // The current command is 'cd', which we have to handle as an internal shell command
    $newDir = "/" === $regs[1][0] ? $regs[1] : $_SESSION['cwd'] . "/" . $regs[1];

    // Tidy up appearance on /./
    while (false !== strpos($newDir, '/./')) {
        $newDir = str_replace('/./', '/', $newDir);
    }
    // Tidy up appearance on //
    while (false !== strpos($newDir, '//')) {
        $newDir = str_replace('//', '/', $newDir);
    }
    // Tidy up appearance on other variations
    while (preg_match('/\/\.\.(?!\.)/', $newDir)) {
        $newDir = preg_replace('/\/?[^\/]+\/\.\.(?!\.)/', '', $newDir);
    }

    // Empty dir
    if (empty($newDir)) {
        $newDir = "/";
    }

    // Test if we could change to that dir, else display error
    (@chdir($newDir)) ? $_SESSION['cwd'] = $newDir : $output .= "Could not change to: $newDir\n\n";
} else {
    // The command is not a 'cd' command

    // Alias expansion
    $length = strcspn($_REQUEST['command'], " \t");
    $token = substr($_REQUEST['command'], 0, $length);
    if (true === isset($aliases[$token])) {
        $_REQUEST['command'] = $aliases[$token] . substr($_REQUEST['command'], $length);
    }

    // Open a proc with array and $io return
    $p = proc_open(
        $_REQUEST['command'],
        array(
            1 => array('pipe', 'w'),
            2 => array('pipe', 'w')
        ),
        $io
    );

    // Read output sent to stdout
    while (false === feof($io[1])) {
        // this will return always false ... and will loop forever until "fork: retry: no child processes" will show if proc_open is disabled;
        $output .= htmlspecialchars(fgets($io[1]), ENT_COMPAT, 'UTF-8');
    }
    // Read output sent to stderr
    while (false === feof($io[2])) {
        $output .= htmlspecialchars(fgets($io[2]), ENT_COMPAT, 'UTF-8');
    }
    $output .= "\n";

    // Close everything off
    fclose($io[1]);
    fclose($io[2]);
    proc_close($p);
}

// Change to the cwd in session
chdir($_SESSION['cwd']);

// and again ask for current user and working dir
if (true === $systemClass->functionEnabled("shell_exec")) {
    $user = str_replace("\n", "", shell_exec("whoami"));
    $cwd = str_replace("\n", "", shell_exec("pwd"));
} else {
    $user = "";
    $cwd = "";
}

// Finally, output our JSON data
echo json_encode([
    "output" => $output,
    "user" => $user,
    "cwd" => $cwd
]);

