<?php

//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
$validation = service('validation');
//[Models]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Intrusions."));
$mintrusions = model("App\Modules\C4isr\Models\C4isr_Intrusions");
$mmails = model("App\Modules\C4isr\Models\C4isr_Mails", false);
$maliases = model("App\Modules\C4isr\Models\C4isr_Aliases", false);
$mprofiles = model("App\Modules\C4isr\Models\C4isr_Profiles");
$mvulnerabilities = model("App\Modules\C4isr\Models\C4isr_Vulnerabilities");
//[Data]----------------------------------------------------------------------------------------------------------------
$intrusion = $f->get_Value("intrusion");
$breach = $f->get_Value("breach");
$prefix = $f->get_Value("prefix");
$author = $authentication->get_User();
$l["back"] = "/c4isr/intrusions/list/" . $breach;
$l["edit"] = "/c4isr/intrusions/edit/{$intrusion}";
//[Files]----------------------------------------------------------------------------------------------------------------
$path = ROOTPATH . "public/{$prefix}";
$dir = opendir($path);
$files = array();
while ($current = readdir($dir)) {
    if ($current != "." && $current != "..") {
        if (is_dir($path . $current)) {
            showFiles($path . $current . '/');
        } else {
            $files[] = $current;
            //echo $current . "<br>";
        }
    }
}
//[File]----------------------------------------------------------------------------------------------------------------
if (isset($files[0]) && !empty($files[0])) {
    $uri = ROOTPATH . "public{$prefix}/{$files[0]}";
    $c = "";
    if ($file = fopen($uri, "r")) {
        $lote = array();
        while (!feof($file)) {
            $line = fgets($file);
            //echo($line . "<br>");
            $data = explode(':', $line);
            if (isset($data[0]) && isset($data[1])) {
                $user = $strings->get_Strtolower($data[0]);
                $password = $strings->get_URLEncode($data[1]);
                //[process]-------------------------------------------------------------------------------------------------
                $processors = 'App\Modules\C4isr\Views\Intrusions\Import\Processors';
                if (filter_var($user, FILTER_VALIDATE_EMAIL)) {
                    $c = view($processors . '\email', array('email' => $user, 'password' => $password, 'breach' => $breach, 'intrusion' => $intrusion));
                } else {
                    $c = view($processors . '\alias', array('alias' => $user, 'password' => $password, 'breach' => $breach, 'intrusion' => $intrusion));
                }
                echo($c);
                //[/process]------------------------------------------------------------------------------------------------
            }
        }
        fclose($file);
        if (file_exists($uri)) {
            if (unlink($uri)) {
                $response = array(
                    "status" => "success",
                    "message" => "ELIMINADO: {$uri}",
                );
            } else {
                $response = array(
                    "status" => "error",
                    "message" => "NO-ELIMINABLE:: {$uri}",
                );
            }
        } else {
            $response = array(
                "status" => "error",
                "message" => "NO-EXISTE: {$uri}",
            );
        }
    } else {
        $response = array(
            "status" => "error",
            "message" => "NO-OPEN: {$uri}",
        );
    }
} else {
    $response = array(
        "status" => "error",
        "message" => "sin archivos a importar...",
    );
}
echo(json_encode($response));
?>