<?php

class Smarty_Internal_Runtime_WriteFile
{
    public function writeFile($_filepath, $_contents, Smarty $smarty)
    {
        $_error_reporting = error_reporting();
        error_reporting($_error_reporting & ~E_NOTICE & ~E_WARNING);
        $_dirpath = dirname($_filepath);
        if ($_dirpath !== '.') {
            $i = 0;
            while (!is_dir($_dirpath)) {
                if (@mkdir($_dirpath, 0777, true)) {
                    break;
                }
                clearstatcache();
                if (++$i === 3) {
                    error_reporting($_error_reporting);
                    throw new SmartyException("unable to create directory {$_dirpath}");
                }
                sleep(1);
            }
        }
        $_tmp_file = $_dirpath . DIRECTORY_SEPARATOR . str_replace(array('.', ','), '_', uniqid('wrt', true));
        if (!file_put_contents($_tmp_file, $_contents)) {
            error_reporting($_error_reporting);
            throw new SmartyException("unable to write file {$_tmp_file}");
        }
        if (Smarty::$_IS_WINDOWS) {
            if (is_file($_filepath)) {
                @unlink($_filepath);
            }
            $success = @rename($_tmp_file, $_filepath);
        } else {
            $success = @rename($_tmp_file, $_filepath);
            if (!$success) {
                if (is_file($_filepath)) {
                    @unlink($_filepath);
                }
                $success = @rename($_tmp_file, $_filepath);
            }
        }
        if (!$success) {
            error_reporting($_error_reporting);
            throw new SmartyException("unable to write file {$_filepath}");
        }
        @chmod($_filepath, 0666 & ~umask());
        error_reporting($_error_reporting);
        return true;
    }
}