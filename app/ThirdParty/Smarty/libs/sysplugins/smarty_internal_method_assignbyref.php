<?php

class Smarty_Internal_Method_AssignByRef
{
    public function assignByRef(Smarty_Internal_Data $data, $tpl_var, &$value, $nocache)
    {
        if ($tpl_var !== '') {
            $data->tpl_vars[$tpl_var] = new Smarty_Variable(null, $nocache);
            $data->tpl_vars[$tpl_var]->value = &$value;
            if ($data->_isTplObj() && $data->scope) {
                $data->ext->_updateScope->_updateScope($data, $tpl_var);
            }
        }
        return $data;
    }
}