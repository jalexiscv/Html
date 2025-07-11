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

require_once dirname(__FILE__) . "/../classes/Settings.php";

$settingsClass = new \ICEcoder\Settings();

include_once("settings-common.php");
$text = $_SESSION['text'];
$t = $text['settings-save-current-files'];

// Save the currently opened files for next time
if (true === $_SESSION['loggedIn'] && true === isset($_GET["saveFiles"])) {
    if (!$demoMode) {
        $saveFilesArray = [];
        if ("CLEAR" !== $_GET['saveFiles']) {
            $saveFilesArray = explode(",", $_GET['saveFiles']);
            for ($i = 0; $i < count($saveFilesArray); $i++) {
                $saveFilesArray[$i] = str_replace("/", "|", $docRoot) . $saveFilesArray[$i];
            }
        }
        // Now update the config file
        if (false === $settingsClass->updateConfigUsersSettings($settingsFile, ["previousFiles" => $saveFilesArray])) {
            echo "<script>parent.parent.ICEcoder.message('" . $t['Cannot update config...'] . " data/" . $settingsFile . " " . $t['and try again'] . "');</script>";
        }
        // Update our last10Files var?
        for ($i = 0; $i < count($saveFilesArray); $i++) {
            $inLast10Files = in_array($saveFilesArray[$i], $ICEcoder["last10Files"]);
            if (false === $inLast10Files && "" !== $saveFilesArray[$i]) {
                $ICEcoder["last10Files"][] = $saveFilesArray[$i];
                if (10 <= count($ICEcoder["last10Files"])) {
                    $ICEcoder["last10Files"] = array_slice($ICEcoder["last10Files"], -10, 10);
                };
                // Now update the config file
                if (false === $settingsClass->updateConfigUsersSettings($settingsFile, ['last10Files' => $ICEcoder["last10Files"]])) {
                    echo "<script>parent.parent.ICEcoder.message('" . $t['Cannot update config...'] . " data/" . $settingsFile . " " . $t['and try again'] . "');</script>";
                }
            }
        }
    }
    echo '<script>parent.parent.ICEcoder.serverMessage(); parent.parent.ICEcoder.serverQueue("del");</script>';
}
