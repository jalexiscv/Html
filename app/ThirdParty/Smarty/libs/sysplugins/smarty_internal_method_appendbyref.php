<?php

class Smarty_Internal_Method_AppendByRef
{
    public static function appendByRef(Smarty_Internal_Data $data, $tpl_var, &$value, $merge = false)
    {
        if ($tpl_var !== '' && isset($value)) {
            if (!isset($data->tpl_vars[$tpl_var])) {
                $data->tpl_vars[$tpl_var] = new Smarty_Variable();
            }
            if (!is_array($data->tpl_vars[$tpl_var]->value)) {
                settype($data->tpl_vars[$tpl_var]->value, 'array');
            }
            if ($merge && is_array($value)) {
                foreach ($value as $_key => $_val) {
                    $data->tpl_vars[$tpl_var]->value[$_key] = &$value[$_key];
                }
            } else {
                $data->tpl_vars[$tpl_var]->value[] = &$value;
            }
            if ($data->_isTplObj() && $data->scope) {
                $data->ext->_updateScope->_updateScope($data, $tpl_var);
            }
        }
        return $data;
    }
}