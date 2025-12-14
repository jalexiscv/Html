<?php

class Smarty_Internal_Method_GetGlobal
{
    public $objMap = 7;

    public function getGlobal(Smarty_Internal_Data $data, $varName = null)
    {
        if (isset($varName)) {
            if (isset(Smarty::$global_tpl_vars[$varName])) {
                return Smarty::$global_tpl_vars[$varName]->value;
            } else {
                return '';
            }
        } else {
            $_result = array();
            foreach (Smarty::$global_tpl_vars as $key => $var) {
                $_result[$key] = $var->value;
            }
            return $_result;
        }
    }
}