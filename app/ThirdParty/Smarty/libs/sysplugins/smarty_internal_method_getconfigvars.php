<?php

class Smarty_Internal_Method_GetConfigVars
{
    public $objMap = 7;

    public function getConfigVars(Smarty_Internal_Data $data, $varname = null, $search_parents = true)
    {
        $_ptr = $data;
        $var_array = array();
        while ($_ptr !== null) {
            if (isset($varname)) {
                if (isset($_ptr->config_vars[$varname])) {
                    return $_ptr->config_vars[$varname];
                }
            } else {
                $var_array = array_merge($_ptr->config_vars, $var_array);
            }
            if ($search_parents) {
                $_ptr = $_ptr->parent;
            } else {
                $_ptr = null;
            }
        }
        if (isset($varname)) {
            return '';
        } else {
            return $var_array;
        }
    }
}