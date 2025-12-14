<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\Intrusions\Creator\processor.php]
*  ╩ ╩╝╚╝╚═╝╚═╝╩╚═╝╩═╝╚═╝
* -----------------------------------------------------------------------------
* Copyright 2021 - Higgs Bigdata S.A.S., Inc. <admin@Higgs.com>
* Este archivo es parte de Higgs Bigdata Framework 7.1
* Para obtener información completa sobre derechos de autor y licencia, consulte
* la LICENCIA archivo que se distribuyó con este código fuente.
* -----------------------------------------------------------------------------
* EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
* IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
* APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
* LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
* RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
* AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
* O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
* -----------------------------------------------------------------------------
* @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
* @link https://www.Higgs.com
* @Version 1.5.0
* @since PHP 7, PHP 8
* -----------------------------------------------------------------------------
* Datos recibidos desde el controlador - @ModuleController
* -----------------------------------------------------------------------------
* @Authentication
* @request
* @dates
* @view
* @oid
* @component
* @views
* @prefix
* @parent
* -----------------------------------------------------------------------------
*/
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
    //echo($uri);
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

                echo("user: {$user}:{$password}<br>");
                if (filter_var($user, FILTER_VALIDATE_EMAIL)) {
                    //$c = view($processors . '\email', array('email' => $user, 'password' => $password, 'breach' => $breach, 'intrusion' => $intrusion));
                } else {
                    //$c = view($processors . '\alias', array('alias' => $user, 'password' => $password, 'breach' => $breach, 'intrusion' => $intrusion));
                }
                echo($c);
                //[/process]------------------------------------------------------------------------------------------------
            }
        }
        fclose($file);
        if (file_exists($uri)) {
            /*
            if (unlink($uri)) {
                $smarty = service("smarty");
                $smarty->set_Mode("bs5x");
                $smarty->assign("title", lang("Intrusions.import-deletefile-title"));
                $smarty->assign("message", sprintf(lang("Intrusions.import-deletefile-message"), $uri));
                $smarty->assign("continue", $l["back"]);
                $smarty->assign("voice", "c4isr/intrusions/import-deletefile-message.mp3");
                $c = $smarty->view('alerts/card/warning.tpl');
                echo($c);
            } else {
                echo("No se ha podido eliminar el archivo.");
            }
            */
        } else {
            echo("El archivo no existe en la ruta especificada.");
        }
    } else {
        echo("No se pudo abrir");
    }
} else {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Intrusions.import-nofiles-title"));
    $smarty->assign("message", lang("Intrusions.import-nofiles-message"));
    $smarty->assign("continue", $l["back"]);
    $smarty->assign("voice", "c4isr/intrusions/import-nofiles-message.mp3");
    $c = $smarty->view('alerts/card/warning.tpl');
    echo($c);
}

?>