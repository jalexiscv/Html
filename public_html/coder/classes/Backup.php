<?php declare(strict_types=1);
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

namespace ICEcoder;

use ICEcoder\File;

class Backup
{
    private $fileClass;

    public function __construct()
    {
        $this->fileClass = new File();
    }

    public function makeBackup($fileLoc, $fileName, $contents)
    {
        global $t, $ICEcoder;

        $backupDirFormat = "Y-m-d";

        // Establish the base, host and date dir parts...
        $backupDirBase = str_replace("\\", "/", dirname(__FILE__)) . "/../data/backups/";
        $backupDirHost = "localhost";
        $backupDirDate = date($backupDirFormat);

        // Establish an array of dirs from base to our file location
        $subDirsArray = explode("/", ltrim($fileLoc, "/"));
        array_unshift($subDirsArray, $backupDirHost, $backupDirDate);
        // Make any dirs that don't exist if full path isn't there
        if (!is_dir($backupDirBase . implode("/", $subDirsArray))) {
            $pathIncr = "";
            for ($i = 0; $i < count($subDirsArray); $i++) {
                $pathIncr .= $subDirsArray[$i] . "/";
                // If this subdir isn't there, make it
                if (!is_dir($backupDirBase . $pathIncr)) {
                    mkdir($backupDirBase . $pathIncr);
                }
            }
        }
        // We should have our dir path now so set that
        $backupDir = $backupDirBase . implode("/", $subDirsArray);
        // Work out an available filename (we postfix a number in parens)
        for ($i = 1; $i < 1000000000; $i++) {
            if (!file_exists($backupDir . '/' . $fileName . " (" . $i . ")")) {
                $backupFileName = $fileName . " (" . $i . ")";
                $backupFileNum = $i;
                $i = 1000000000;
            }
        }

        // Now save within that backup dir and clear the statcache
        $fh = fopen($backupDir . "/" . $backupFileName, "w") or die($t['Sorry, cannot save...']);
        fwrite($fh, $contents);
        fclose($fh);
        clearstatcache();

        // Log the version count in an index file, which contains saved version counts
        $backupIndex = $backupDirBase . $backupDirHost . "/" . $backupDirDate . "/.versions-index";
        // Have a version index already? Update contents
        if (file_exists($backupIndex)) {
            $versionsInfo = "";
            $versionsInfoOrig = getData($backupIndex);
            $versionsInfoOrig = explode("\n", $versionsInfoOrig);
            $replacedLine = false;
            // For each line, either re-set number or simply include the line
            for ($i = 0; $i < count($versionsInfoOrig); $i++) {
                if (0 === strpos($versionsInfoOrig[$i], $fileLoc . "/" . $fileName . " = ")) {
                    $versionsInfo .= $fileLoc . "/" . $fileName . " = " . $backupFileNum . PHP_EOL;
                    $replacedLine = true;
                } else {
                    $versionsInfo .= $versionsInfoOrig[$i] . PHP_EOL;
                }
            }
            // Didn't find our line in the file? Add it to the end
            if (!$replacedLine) {
                $versionsInfo .= $fileLoc . "/" . $fileName . " = " . $backupFileNum . PHP_EOL;
            }
            // No version file yet, set the first line
        } else {
            $versionsInfo = $fileLoc . "/" . $fileName . " = " . $backupFileNum . PHP_EOL;
        }
        $versionsInfo = rtrim($versionsInfo, PHP_EOL);
        $fh = fopen($backupIndex, 'w') or die($t['Sorry, cannot save...']);
        fwrite($fh, $versionsInfo);
        fclose($fh);
        clearstatcache();

        // Finally, clear any old backup dirs than user set X days (inclusive)
        $backupDirsList = scandir($backupDirBase . $backupDirHost);
        $backupDirsKeep = array();
        for ($i = 0; $i <= $ICEcoder["backupsDays"]; $i++) {
            $backupDirsKeep[] = date($backupDirFormat, strtotime('-' . $i . ' day', strtotime($backupDirDate)));
        }
        for ($i = 0; $i < count($backupDirsList); $i++) {
            if ("." !== $backupDirsList[$i] && ".." !== $backupDirsList[$i] && !in_array($backupDirsList[$i], $backupDirsKeep)) {
                $this->fileClass->rrmdir($backupDirBase . $backupDirHost . "/" . $backupDirsList[$i]);
            }
        }
    }
}
