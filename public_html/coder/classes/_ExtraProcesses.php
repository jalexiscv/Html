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

use ICEcoder\System;

class ExtraProcesses
{
    private $fileLoc;
    private $fileName;
    private $username;
    private $systemClass;

    /**
     * ExtraProcesses constructor.
     * @param string $fileLoc
     * @param string $fileName
     */
    public function __construct($fileLoc = "", $fileName = "")
    {
        $this->fileLoc = $fileLoc;
        $this->fileName = $fileName;
        $this->username = $_SESSION['username'];
        $this->systemClass = new System;
    }

    /**
     * @param string $doNext
     * @return string
     */
    public function onLoad($doNext = ""): string
    {
        // PHP example:
        // $this->writeLog("LOAD");

        // JS example:
        // $doNext .= "alert('Loaded');";

        return $doNext;
    }

    /**
     *
     */
    public function onFileLoad()
    {
        // PHP example:
        // $this->writeLog("FILE LOAD");
    }

    /**
     * @param string $doNext
     * @return string
     */
    public function onFileSave($doNext = ""): string
    {
        // PHP example:
        // $this->writeLog("SAVE");

        // JS example:
        // $doNext .= "alert('Saved');";

        return $doNext;
    }

    /**
     * @param string $doNext
     * @return string
     */
    public function onGetRemoteFile($doNext = ""): string
    {
        // PHP example:
        // $this->writeLog("GET REMOTE FILE");

        // JS example:
        // $doNext .= "alert('Got remote file');";

        return $doNext;

    }

    /**
     * @param string $doNext
     * @param $uploads
     * @return string
     */
    public function onFileUpload($doNext = "", $uploads = []): string
    {
        // PHP example:
        // foreach ($uploads as $upload) {
        //    $this->writeLog("UPLOAD FILE", $upload->name);
        // }

        // JS example:
        // $doNext .= "alert('Uploaded');";

        return $doNext;

    }

    /**
     * @param string $doNext
     * @param string $file
     * @return string
     */
    public function onFileReplaceText($doNext = "", $file = ""): string
    {
        // PHP example:
        // $this->writeLog("REPLACE TEXT IN FILE", $file);

        // JS example:
        // $doNext .= "alert('Replaced text in file');";

        return $doNext;
    }

    /**
     * @param string $doNext
     * @return string
     */
    public function onDirNew($doNext = ""): string
    {
        // PHP example:
        // $this->writeLog("NEW DIR");

        // JS example:
        // $doNext .= "alert('new dir');";

        return $doNext;

    }

    /**
     * @param string $doNext
     * @return string
     */
    public function onFileDirDelete($doNext = ""): string
    {
        // PHP example:
        // $this->writeLog("DELETE FILE/DIR");

        // JS example:
        // $doNext .= "alert('Deleted file/dir');";

        return $doNext;
    }

    /**
     * @param string $doNext
     * @param string $file
     * @return string
     */
    public function onFileDirPaste($doNext = "", $file = ""): string
    {
        // PHP example:
        // $this->writeLog("PASTE FILE/DIR");

        // JS example:
        // $doNext .= "alert('Pasted file/dir');";

        return $doNext;
    }

    /**
     * @param string $doNext
     * @return string
     */
    public function onFileDirMove($doNext = ""): string
    {
        // PHP example:
        // $this->writeLog("MOVE FILE/DIR");

        // JS example:
        // $doNext .= "alert('Moved');";

        return $doNext;
    }

    /**
     * @param string $doNext
     * @return string
     */
    public function onFileDirRename($doNext = ""): string
    {
        // PHP example:
        // $this->writeLog("RENAME FILE/DIR");

        // JS example:
        // $doNext .= "alert('Renamed file/dir');";

        return $doNext;
    }

    /**
     * @param string $doNext
     * @param string $perms
     * @return string
     */
    public function onFileDirPerms($doNext = "", $perms = "unknown"): string
    {
        // PHP example:
        // $this->writeLog("PERMS", $perms);

        // JS example:
        // $doNext .= "alert('Perms changed to ' + $perms);";

        return $doNext;
    }

    /**
     * @param string $username
     */
    public function onUserNew($username = "")
    {
        // PHP example:
        // $this->writeLog("USER NEW", $username ?? "");
    }

    /**
     * @param string $username
     */
    public function onUserLogin($username = "")
    {
        // PHP example:
        // $this->writeLog("USER LOGIN", $username ?? "");
    }

    /**
     * @param string $username
     */
    public function onUserLogout($username = "")
    {
        // PHP example:
        // $this->writeLog("USER LOGOUT", $username ?? "");
    }

    /**
     * @param string $username
     */
    public function onUserLoginFail($username = "")
    {
        // PHP example:
        // $this->writeLog("USER LOGIN FAIL", $username ?? "");
    }

    /**
     * @param string $result
     * @param string $status
     */
    public function onBugCheckResult($result = "", $status = "")
    {
        // PHP example:
        // $this->writeLog("BUG CHECK", $result . " : ". var_export($status, true));
    }

    /**
     * @param $action
     * @param string $msg
     */
    private function writeLog($action, $msg = "")
    {
        $username = "" !== $this->username ? $this->username : "default-user";

        $this->systemClass->writeLog(
            "{$username}.log",
            "{$action} >>> " . date("D dS M Y h:i:sa") . " : " . ($this->fileLoc) . "/" . ($this->fileName) . ("" !== $msg ? " : " . $msg : "") . "\n"
        );
    }
}
