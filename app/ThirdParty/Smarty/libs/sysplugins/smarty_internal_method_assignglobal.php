<?php

class Smarty_Internal_Method_AssignGlobal
{
    public $objMap = 7;

    public function assignGlobal(Smarty_Internal_Data $data, $varName, $value = null, $nocache = false)
    {
        if ($varName !== '') {
            Smarty::$global_tpl_vars[$varName] = new Smarty_Variable($value, $nocache);
            $ptr = $data;
            while ($ptr->_isTplObj()) {
                $ptr->tpl_vars[$varName] = clone Smarty::$global_tpl_vars[$varName];
                $ptr = $ptr->parent;
            }
        }
        return $data;
    }
}