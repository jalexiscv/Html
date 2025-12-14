<?php

class Smarty_Internal_Method_GetStreamVariable
{
    public $objMap = 7;

    public function getStreamVariable(Smarty_Internal_Data $data, $variable)
    {
        $_result = '';
        $fp = fopen($variable, 'r+');
        if ($fp) {
            while (!feof($fp) && ($current_line = fgets($fp)) !== false) {
                $_result .= $current_line;
            }
            fclose($fp);
            return $_result;
        }
        $smarty = isset($data->smarty) ? $data->smarty : $data;
        if ($smarty->error_unassigned) {
            throw new SmartyException('Undefined stream variable "' . $variable . '"');
        } else {
            return null;
        }
    }
}