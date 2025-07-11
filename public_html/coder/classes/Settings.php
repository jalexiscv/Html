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

class Settings
{
    public $versionNo;
    public $docRoot;

    public function __construct()
    {
        // Set version number and document root as core settings
        $this->versionNo = "8.3";
        $this->docRoot = $_SERVER['DOCUMENT_ROOT'];
    }

    public function getDataDirDetails()
    {
        clearstatcache();

        // Return details about the data dir
        $fullPath = dirname(__FILE__) . "/../data/";
        $exists = file_exists($fullPath);
        $readable = is_readable($fullPath);
        $writable = is_writable($fullPath);
        return [
            "fullPath" => $fullPath,
            "exists" => $exists,
            "readable" => $readable,
            "writable" => $writable,
        ];
    }

    // ========
    // DATA DIR
    // ========

    public function getConfigGlobalTemplate($asArray)
    {
        // Return the serialized global config template
        $fileName = 'template-config-global.php';
        $fullPath = dirname(__FILE__) . "/../lib/" . $fileName;
        if (function_exists('opcache_invalidate')) {
            opcache_invalidate($fullPath, true);
        }
        $settings = file_get_contents($fullPath);
        if ($asArray) {
            $settings = $this->serializedFileData("get", $fullPath);
        }
        return $settings;
    }

    // =============
    // GLOBAL CONFIG
    // =============

    public function serializedFileData($do, $fullPath, $output = null)
    {
        if ("get" === $do) {
            if (function_exists('opcache_invalidate')) {
                opcache_invalidate($fullPath, true);
            }
            $data = file_get_contents($fullPath);
            $data = str_replace("<" . "?php\n/*\n\n", "", $data);
            $data = str_replace("\n\n*/\n?" . ">", "", $data);
            $data = unserialize($data);
            return $data;
        }
        if ("set" === $do) {
            if (true === is_array($output)) {
                $output = serialize($output);
            }
            return false !== file_put_contents($fullPath, "<" . "?php\n/*\n\n" . $output . "\n\n*/\n?" . ">");
        }
    }

    public function updateConfigGlobalSettings($array): bool
    {
        // Update global config settings file
        $settingsFromFile = $this->getConfigGlobalSettings();
        $settings = array_merge($settingsFromFile, $array);
        return $this->setConfigGlobalSettings($settings);
    }

    public function getConfigGlobalSettings()
    {
        // Start an array with version number and document root
        $settings = $this->getCoreDetails();
        // Get global config file details
        $fullPath = $this->getConfigGlobalFileDetails()['fullPath'];
        $settingsFromFile = $this->serializedFileData("get", $fullPath);
        // Merge that with the array we started with and return
        $settings = array_merge($settings, $settingsFromFile);
        return $settings;
    }

    public function getCoreDetails()
    {
        return [
            "versionNo" => $this->versionNo,
            "docRoot" => $this->docRoot,
        ];
    }

    public function getConfigGlobalFileDetails()
    {
        clearstatcache();

        // Return details about the global config file
        $fileName = 'config-global.php';
        $fullPath = dirname(__FILE__) . "/../data/" . $fileName;
        $exists = file_exists($fullPath);
        $readable = is_readable($fullPath);
        $writable = is_writable($fullPath);
        $filemtime = filemtime($fullPath);
        return [
            "fileName" => $fileName,
            "fullPath" => $fullPath,
            "exists" => $exists,
            "readable" => $readable,
            "writable" => $writable,
            "filemtime" => $filemtime
        ];
    }

    // ============
    // USERS CONFIG
    // ============

    public function setConfigGlobalSettings($settings): bool
    {
        // Get the global config file details
        $fullPath = $this->getConfigGlobalFileDetails()['fullPath'];
        if ($fConfigSettings = fopen($fullPath, 'w')) {
            // If the settings we've received aren't in serialized format yet, do that now
            // As $settings could be a serialized string or array
            if (is_array($settings)) {
                unset($settings['versionNo']);
                unset($settings['docRoot']);
            }
            return $this->serializedFileData("set", $fullPath, $settings);
        } else {
            return false;
        }
    }

    public function getConfigUsersTemplate($asArray)
    {
        // Return the serialized users config template
        $fileName = 'template-config-users.php';
        $fullPath = dirname(__FILE__) . "/../lib/" . $fileName;
        if (function_exists('opcache_invalidate')) {
            opcache_invalidate($fullPath, true);
        }
        $settings = file_get_contents($fullPath);
        if ($asArray) {
            $settings = $this->serializedFileData("get", $fullPath);
        }
        return $settings;
    }

    public function updateConfigUsersSettings($fileName, $array): bool
    {
        // Update users config settings file
        $settingsFromFile = $this->getConfigUsersSettings($fileName);
        $settings = array_merge($settingsFromFile, $array);
        return $this->setConfigUsersSettings($fileName, $settings);
    }

    public function getConfigUsersSettings($fileName)
    {
        // Get users config file details
        $fullPath = $this->getConfigUsersFileDetails($fileName)['fullPath'];
        $settingsFromFile = $this->serializedFileData("get", $fullPath);
        // Now return
        return $settingsFromFile;
    }

    public function getConfigUsersFileDetails($fileName)
    {
        // Return details about the users config file
        $fullPath = dirname(__FILE__) . "/../data/" . $fileName;
        $exists = file_exists($fullPath);
        $readable = is_readable($fullPath);
        $writable = is_writable($fullPath);
        $filemtime = filemtime($fullPath);
        return [
            "fileName" => $fileName,
            "fullPath" => $fullPath,
            "exists" => $exists,
            "readable" => $readable,
            "writable" => $writable,
            "filemtime" => $filemtime,
        ];
    }

    public function setConfigUsersSettings($fileName, $settings): bool
    {
        // Get the users config file details
        $fullPath = $this->getConfigUsersFileDetails($fileName)['fullPath'];
        if ($fConfigSettings = fopen($fullPath, 'w')) {
            return $this->serializedFileData("set", $fullPath, $settings);
        } else {
            return false;
        }
    }

    public function updateConfigUsersCreateDate($fileName)
    {
        global $ICEcoderUserSettings;

        // Get users config file details
        $filemtime = $this->getConfigUsersFileDetails($fileName)['filemtime'];
        // Make it a number (avoids null, undefined etc)
        $filemtime = intval($filemtime);
        // Set it to the epoch time now if we don't have a real value
        if (0 === $filemtime) {
            $filemtime = time();
        }
        // Update users config settings file
        $ICEcoderSettingsFromFile = $this->getConfigUsersSettings($fileName);
        $ICEcoderSettingsFromFile['configCreateDate'] = $filemtime;
        $this->setConfigUsersSettings($fileName, $ICEcoderSettingsFromFile);
        // Set the new value in array
        $ICEcoderUserSettings['configCreateDate'] = $filemtime;
    }

    public function createIPSettingsFileIfNotExist()
    {
        global $username, $settingsFile, $settingsFileAddr;

        // Create a duplicate version for the IP address of the domain if it doesn't exist yet
        $serverAddr = $_SERVER['SERVER_ADDR'] ?? "1";
        if ($serverAddr == "1" || $serverAddr == "::1") {
            $serverAddr = "127.0.0.1";
        }
        $settingsFileAddr = 'config-' . $username . str_replace(".", "_", $serverAddr) . '.php';
        if (false === file_exists(dirname(__FILE__) . "/../data/" . $settingsFileAddr)) {
            if (false === copy(dirname(__FILE__) . "/../data/" . $settingsFile, dirname(__FILE__) . "/../data/" . $settingsFileAddr)) {
                $reqsFailures = ["phpCreateSettingsFileAddr"];
                include dirname(__FILE__) . "/../lib/requirements.php";
            }
        }
    }
}
