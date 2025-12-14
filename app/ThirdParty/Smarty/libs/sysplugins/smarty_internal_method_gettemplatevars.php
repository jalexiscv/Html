<?php

class Smarty_Internal_Method_GetTemplateVars
{
    public $objMap = 7;

    public function getTemplateVars(Smarty_Internal_Data $data, $varName = null, Smarty_Internal_Data $_ptr = null, $searchParents = true)
    {
        if (isset($varName)) {
            $_var = $this->_getVariable($data, $varName, $_ptr, $searchParents, false);
            if (is_object($_var)) {
                return $_var->value;
            } else {
                return null;
            }
        } else {
            $_result = array();
            if ($_ptr === null) {
                $_ptr = $data;
            }
            while ($_ptr !== null) {
                foreach ($_ptr->tpl_vars as $key => $var) {
                    if (!array_key_exists($key, $_result)) {
                        $_result[$key] = $var->value;
                    }
                }
                if ($searchParents && isset($_ptr->parent)) {
                    $_ptr = $_ptr->parent;
                } else {
                    $_ptr = null;
                }
            }
            if ($searchParents && isset(Smarty::$global_tpl_vars)) {
                foreach (Smarty::$global_tpl_vars as $key => $var) {
                    if (!array_key_exists($key, $_result)) {
                        $_result[$key] = $var->value;
                    }
                }
            }
            return $_result;
        }
    }

    public function _getVariable(Smarty_Internal_Data $data, $varName, Smarty_Internal_Data $_ptr = null, $searchParents = true, $errorEnable = true)
    {
        if ($_ptr === null) {
            $_ptr = $data;
        }
        while ($_ptr !== null) {
            if (isset($_ptr->tpl_vars[$varName])) {
                return $_ptr->tpl_vars[$varName];
            }
            if ($searchParents && isset($_ptr->parent)) {
                $_ptr = $_ptr->parent;
            } else {
                $_ptr = null;
            }
        }
        if (isset(Smarty::$global_tpl_vars[$varName])) {
            return Smarty::$global_tpl_vars[$varName];
        }
        if ($errorEnable && $data->_getSmartyObj()->error_unassigned) {
            $x = $$varName;
        }
        return new Smarty_Undefined_Variable;
    }
}