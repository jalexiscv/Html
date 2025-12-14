<?php
/*
 * Copyright (c) 2023. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

function run_python_script($args)
{
    $python_script = "search.py";
    $command = "python3 " . escapeshellarg($python_script) . " " . $args;
    $output = shell_exec($command);
    if ($output === null) {
        throw new Exception("Error al ejecutar el script de Python.");
    }
    return ($output);
}

function display_results($results)
{
    //$results = json_decode($results, true);
    echo($results);
}

if (isset($_GET['iso']) || isset($_GET['ip']) || isset($_GET['query'])) {
    $args = "";

    if (isset($_GET['iso'])) {
        $iso = $_GET['iso'];
        $args .= "-iso " . escapeshellarg($iso);
    }

    if (isset($_GET['ip'])) {
        $ip = $_GET['ip'];
        $args .= " -ip " . escapeshellarg($ip);
    }

    if (isset($_GET['query'])) {
        $query = $_GET['query'];
        $args = escapeshellarg($query);
    }


    if (isset($_GET['V'])) {
        $args .= " -V " . escapeshellarg($_GET['V']);
    }

    if (isset($_GET['no_auth'])) {
        $args .= " --no-auth " . escapeshellarg($_GET['no_auth']);
    }

    if (isset($_GET['sa'])) {
        $args .= " -sa " . escapeshellarg($_GET['sa']);
    }

    if (isset($_GET['D'])) {
        $args .= " -D " . escapeshellarg($_GET['D']);
    }

    if (isset($_GET['limit'])) {
        $args .= " -limit " . escapeshellarg($_GET['limit']);
    }

    if (isset($_GET['O'])) {
        $args .= " -O " . escapeshellarg($_GET['O']);
    }

    try {
        $output = run_python_script($args);
        display_results($output);
    } catch (Exception $e) {
        echo "<p class='error-message'>Error: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p class='error-message'>Error: Debes proporcionar al menos uno de los parámetros 'iso' o 'ip'.</p>";
}
?>