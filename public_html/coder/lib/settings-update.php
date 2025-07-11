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

include_once "settings-common.php";
$text = $_SESSION['text'];
$t = $text['settings-update'];

// Update this config file?
if (false === $demoMode && true === isset($_SESSION['loggedIn']) && true === $_SESSION['loggedIn'] &&
    (true === isset($_POST["theme"]) || true === isset($_GET['action']) && "turnOffTutorialOnLogin" === $_GET['action'])
) {
    // Just updating tutorialOnLogin setting
    if (true === isset($_GET['action']) && "turnOffTutorialOnLogin" === $_GET['action']) {
        if (true === $settingsClass->updateConfigUsersSettings($settingsFile, ['tutorialOnLogin' => false])) {
            $ICEcoder['tutorialOnLogin'] = false;
        } else {
            echo "<script>parent.ICEcoder.message('" . $t['Cannot update config'] . " data/" . $settingsFile . " " . $t['and try again'] . "');</script>";
        }
        exit;
    }

    $currentSettings = $settingsClass->getConfigUsersSettings($settingsFile);

    // Has there been a language change?
    $languageUserChanged = $ICEcoder['languageUser'] !== $_POST['languageUser'];

    // Prepare all our vars
    $updatedSettings = [
        "versionNo" => $currentSettings['versionNo'],
        "configCreateDate" => $currentSettings['configCreateDate'],
        "root" => xssClean($_POST['root'], "html"),
        "checkUpdates" => isset($_POST['checkUpdates']),
        "openLastFiles" => isset($_POST['openLastFiles']),
        "updateDiffOnSave" => isset($_POST['updateDiffOnSave']),
        "languageUser" => $_POST['languageUser'],
        "backupsKept" => isset($_POST['backupsKept']),
        "backupsDays" => intval($_POST['backupsDays']),
        "deleteToTmp" => isset($_POST['deleteToTmp']),
        "findFilesExclude" => explode(",", str_replace(" ", "", $_POST['findFilesExclude'])),
        "codeAssist" => isset($_POST['codeAssist']),
        "visibleTabs" => isset($_POST['visibleTabs']),
        "lockedNav" => isset($_POST['lockedNav']),
        "tagWrapperCommand" => $_POST['tagWrapperCommand'],
        "autoComplete" => $_POST['autoComplete'],
        "password" => $currentSettings['password'],
        "bannedFiles" => explode(",", str_replace(" ", "", $_POST['bannedFiles'])),
        "bannedPaths" => explode(",", str_replace(" ", "", $_POST['bannedPaths'])),
        "allowedIPs" => explode(",", str_replace(" ", "", $_POST['allowedIPs'])),
        "autoLogoutMins" => intval($_POST['autoLogoutMins']),
        "theme" => $_POST['theme'],
        "fontSize" => $_POST['fontSize'],
        "lineWrapping" => isset($_POST['lineWrapping']),
        "lineNumbers" => isset($_POST['lineNumbers']),
        "showTrailingSpace" => isset($_POST['showTrailingSpace']),
        "matchBrackets" => isset($_POST['matchBrackets']),
        "autoCloseTags" => isset($_POST['autoCloseTags']),
        "autoCloseBrackets" => isset($_POST['autoCloseBrackets']),
        "indentType" => $_POST['indentType'],
        "indentAuto" => isset($_POST['indentAuto']),
        "indentSize" => intval($_POST['indentSize']),
        "pluginPanelAligned" => $_POST['pluginPanelAligned'],
        "scrollbarStyle" => $_POST['scrollbarStyle'],
        "selectNextOnFindInput" => isset($_POST['selectNextOnFindInput']),
        "goToLineScrollSpeed" => intval($_POST['goToLineScrollSpeed']),
        "bugFilePaths" => explode(",", str_replace(" ", "", $_POST['bugFilePaths'])),
        "bugFileCheckTimer" => intval($_POST['bugFileCheckTimer']) >= 0 ? intval($_POST['bugFileCheckTimer']) : 0,
        "bugFileMaxLines" => intval($_POST['bugFileMaxLines']),
        "plugins" => $currentSettings['plugins'],
        "tutorialOnLogin" => isset($_POST['tutorialOnLogin']),
        "previousFiles" => $currentSettings['previousFiles'],
        "last10Files" => $currentSettings['last10Files'],
        "favoritePaths" => $currentSettings['favoritePaths'],
    ];

    if ("" !== $_POST['password']) {
        $updatedSettings["password"] = generateHash($_POST['password']);
    };

    $ICEcoder = array_merge($ICEcoder, $updatedSettings);

    // Now update the config file
    if (true === $settingsClass->getConfigUsersFileDetails($settingsFile)['writable']) {
        $settingsClass->setConfigUsersSettings($settingsFile, $updatedSettings);
    } else {
        echo "<script>parent.ICEcoder.message('" . $t['Cannot update config'] . " data/" . $settingsFile . " " . $t['and try again'] . "');</script>";
    }

    // OK, now the config file has been updated, update our current session with new arrays
    $settingsArray = array("findFilesExclude", "bannedFiles", "allowedIPs");
    for ($i = 0; $i < count($settingsArray); $i++) {
        $_SESSION[$settingsArray[$i]] = $ICEcoder[$settingsArray[$i]] = explode(",", str_replace(" ", "", $_POST[$settingsArray[$i]]));
    }

    // Work out the theme to use now
    $themeURL =
        "assets/css/theme/" .
        ("default" === $ICEcoder["theme"] ? 'icecoder.css' : $ICEcoder["theme"] . '.css') .
        "?microtime=" . microtime(true);

    // Do we need a file manager refresh?
    $refreshFM = $_POST['changedFileSettings'] == "true" ? "true" : "false";

    // Update global config settings file
    $ICEcoderGlobalFileName = $settingsClass->getConfigGlobalFileDetails()['fileName'];
    $ICEcoderSettingsFromFile = $settingsClass->getConfigGlobalSettings();
    $ICEcoderSettingsFromFile['multiUser'] = isset($_POST['multiUser']);
    $ICEcoderSettingsFromFile['enableRegistration'] = isset($_POST['enableRegistration']);
    if (false === $settingsClass->setConfigGlobalSettings($ICEcoderSettingsFromFile)) {
        echo "<script>parent.ICEcoder.message('" . $t['Cannot update config'] . " data/" . $ICEcoderGlobalFileName . " " . $t['and try again'] . "');</script>";
    }

    // If we've changed language, reload ICEcoder now
    if (true === $languageUserChanged) {
        echo '<script>parent.window.location = "../";</script>';
        die('Reloading ICEcoder after language change');
    }

    // With all that worked out, we can now hide the settings screen and apply the new settings
    $jsBugFilePaths = "['" . str_replace(",", "','", str_replace(" ", "", $_POST['bugFilePaths'])) . "']";
    echo "<script>parent.ICEcoder.settingsScreen(true); parent.ICEcoder.useNewSettings({" .
        "iceRoot: '" . $ICEcoder["root"] . "', " .
        "themeURL: '" . $themeURL . "', " .
        "codeAssist: " . (true === $ICEcoder["codeAssist"] ? "true" : "false") . ", " .
        "lockedNav: " . (true === $ICEcoder["lockedNav"] ? "true" : "false") . ", " .
        "tagWrapperCommand: '" . $ICEcoder["tagWrapperCommand"] . "', " .
        "autoComplete: " . (true === $ICEcoder["autoComplete"] ? "true" : "false") . ", " .
        "visibleTabs: " . (true === $ICEcoder["visibleTabs"] ? "true" : "false") . ", " .
        "fontSize: '" . $ICEcoder["fontSize"] . "', " .
        "lineWrapping: " . (true === $ICEcoder["lineWrapping"] ? "true" : "false") . ", " .
        "lineNumbers: " . (true === $ICEcoder["lineNumbers"] ? "true" : "false") . ", " .
        "showTrailingSpace: " . (true === $ICEcoder["showTrailingSpace"] ? "true" : "false") . ", " .
        "matchBrackets: " . (true === $ICEcoder["matchBrackets"] ? "true" : "false") . ", " .
        "autoCloseTags: " . (true === $ICEcoder["autoCloseTags"] ? "true" : "false") . ", " .
        "autoCloseBrackets: " . (true === $ICEcoder["autoCloseBrackets"] ? "true" : "false") . ", " .
        "indentType: '" . $ICEcoder["indentType"] . "', " .
        "indentAuto: " . (true === $ICEcoder["indentAuto"] ? "true" : "false") . ", " .
        "indentSize: " . $ICEcoder["indentSize"] . ", " .
        "pluginPanelAligned: '" . $ICEcoder["pluginPanelAligned"] . "', " .
        "scrollbarStyle: '" . $ICEcoder["scrollbarStyle"] . "', " .
        "selectNextOnFindInput: " . (true === $ICEcoder["selectNextOnFindInput"] ? "true" : "false") . ", " .
        "goToLineScrollSpeed: " . $ICEcoder["goToLineScrollSpeed"] . ", " .
        "bugFilePaths: " . $jsBugFilePaths . ", " .
        "bugFileCheckTimer: " . $ICEcoder["bugFileCheckTimer"] . ", " .
        "bugFileMaxLines: " . $ICEcoder["bugFileMaxLines"] . ", " .
        "updateDiffOnSave: " . (true === $ICEcoder["updateDiffOnSave"] ? "true" : "false") . ", " .
        "autoLogoutMins: " . $ICEcoder["autoLogoutMins"] . ", " .
        "refreshFM: " . $refreshFM .
        "});</script>";
}
