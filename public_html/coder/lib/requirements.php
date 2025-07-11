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

if (false === isset($reqsFailures)) {
    // Start off assuming all is fine with requirements
    $reqsFailures = [];
}

// Check PHP version meets minimum requirements
if (version_compare(phpversion(), '7.0.0', '<')) {
    array_push($reqsFailures, "phpVersion");
}

// Check we have allow_url_fopen enabled
if (false === ini_get('allow_url_fopen')) {
    array_push($reqsFailures, "phpAllowURLFOpen");
}

// Check we have a working session
if (false === isset($_SESSION) || "" === session_id()) {
    array_push($reqsFailures, "phpSession");
}

// If any of these failed, show requirements problem info screen
if (false === empty($reqsFailures)) {
    ?>
    <html>
    <head>
        <title>ICEcoder <?php echo $settingsClass->versionNo; ?> : Requirements problem!</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="../assets/css/resets.css?microtime=<?php echo microtime(true); ?>">
        <link rel="stylesheet" type="text/css"
              href="../assets/css/icecoder.css?microtime=<?php echo microtime(true); ?>">
        <link rel="icon" type="image/png" href="../assets/images/favicon.png">
    </head>

    <body style="background-color: #181817"
          onLoad="setTimeout(function(){document.getElementById('screenContainer').style.opacity = '1'}, 50)">

    <div class="screenContainer" id="screenContainer"
         style="background-color: #181817; opacity: 0; transition: opacity 0.1s ease-out">
        <div class="screenVCenter">
            <div class="screenCenter">
                <img src="../assets/images/icecoder.png" alt="ICEcoder">
                <div class="version" style="margin-bottom: 22px"><?php echo $settingsClass->versionNo; ?></div>

                <span style="display: inline-block; color: #fff">
		        	<b style="padding: 5px; background: #b00; color: #fff">Requirements problem!</b><br><br><br><br>
				Sorry, but ICEcoder has a problem<br>running on your server:<br><br><hr
                            style="height: 1px; border: 0; background: #888"><br>
				<?php
                if (true === in_array("phpVersion", $reqsFailures)) {
                    echo "Your PHP version is " . phpversion() . "<br>and needs 7.0 or above<br><br>";
                }
                if (true === in_array("phpAllowURLFOpen", $reqsFailures)) {
                    echo "You don't seem to have<br>allow_url_fopen enabled<br><br>";
                }
                if (true === in_array("phpDataDirDoesntExist", $reqsFailures)) {
                    echo "You don't seem to have a:<br>data dir<br>Please check and possibly<br>reinstall ICEcoder<br><br>";
                }
                if (true === in_array("phpDataDirNotReadable", $reqsFailures)) {
                    echo "You don't seem to be able<br>to read the data dir<br><br>";
                }
                if (true === in_array("phpDataDirNotWritable", $reqsFailures)) {
                    echo "You don't seem to be able<br>to write to the data dir<br><br>";
                }
                if (true === in_array("phpSession", $reqsFailures)) {
                    echo "You don't appear to have a<br>working PHP session<br><br>";
                }
                if (true === in_array("phpGlobalConfigFileCreate", $reqsFailures)) {
                    echo "Cannot create config or read file:<br>data/" . $settingsClass->getConfigGlobalFileDetails()['fileName'] . "<br>Please check write permissions<br>on data dir and reload page<br><br>";
                }
                if (true === in_array("phpGlobalConfigFileExists", $reqsFailures)) {
                    echo "You don't seem to have<br>the global config file:<br>data/" . $settingsClass->getConfigGlobalFileDetails()['fileName'] . "<br><br>";
                }
                if (true === in_array("phpGlobalConfigReadFile", $reqsFailures)) {
                    echo "You don't seem to be able<br>to read the global config file:<br>data/" . $settingsClass->getConfigGlobalFileDetails()['fileName'] . "<br><br>";
                }
                if (true === in_array("phpGlobalConfigWriteFile", $reqsFailures)) {
                    echo "You don't seem to be able<br>to write to the global config file:<br>data/" . $settingsClass->getConfigGlobalFileDetails()['fileName'] . "<br><br>";
                }
                if (true === in_array("phpUsersConfigCreateConfig", $reqsFailures)) {
                    echo "Cannot create config or read file:<br>data/" . $settingsClass->getConfigUsersFileDetails($settingsFile)['fileName'] . "<br>Please check write permissions<br>on data dir and reload page<br><br>";
                }
                if (true === in_array("phpUsersConfigFileExists", $reqsFailures)) {
                    echo "You don't seem to have<br>the users config file:<br>data/" . $settingsClass->getConfigUsersFileDetails($settingsFile)['fileName'] . "<br><br>";
                }
                if (true === in_array("phpUsersConfigReadFile", $reqsFailures)) {
                    echo "You don't seem to be able<br>to read the users config file:<br>data/" . $settingsClass->getConfigUsersFileDetails($settingsFile)['fileName'] . "<br><br>";
                }
                if (true === in_array("phpUsersConfigWriteFile", $reqsFailures)) {
                    echo "You don't seem to be able<br>to write to the users config file:<br>data/" . $settingsClass->getConfigUsersFileDetails($settingsFile)['fileName'] . "<br><br>";
                }
                if (true === in_array("phpUsersConfigVersionMismatch", $reqsFailures)) {
                    echo "The version number in your<br>users config file has a mismatch<br>to the global settings<br><br>";
                }
                if (true === in_array("phpCreateSettingsFileAddr", $reqsFailures)) {
                    echo "Couldn't create:<br>data/$settingsFileAddr<br>Maybe you need write<br>permissions on the data dir?<br><br>";
                }
                if (true === in_array("systemIPRestriction", $reqsFailures)) {
                    echo "Not in permitted IPs list<br><br>";
                }
                ?>
			</span>

            </div>
        </div>
    </div>

    </body>

    </html>

    <?php
    exit;
}
?>
