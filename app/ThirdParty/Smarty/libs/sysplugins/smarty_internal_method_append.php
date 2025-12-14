<?php

class Smarty_Internal_Method_Append
{
    public $objMap = 7;

    public function append(Smarty_Internal_Data $data, $tpl_var, $value = null, $merge = false, $nocache = false)
    {
        if (is_array($tpl_var)) {
            foreach ($tpl_var as $_key => $_val) {
                if ($_key !== '') {
                    $this->append($data, $_key, $_val, $merge, $nocache);
                }
            }
        } else {
            if ($tpl_var !== '' && isset($value)) {
                if (!isset($data->tpl_vars[$tpl_var])) {
                    $tpl_var_inst = $data->ext->getTemplateVars->_getVariable($data, $tpl_var, null, true, false);
                    if ($tpl_var_inst instanceof Smarty_Undefined_Variable) {
                        $data->tpl_vars[$tpl_var] = new Smarty_Variable(null, $nocache);
                    } else {
                        $data->tpl_vars[$tpl_var] = clone $tpl_var_inst;
                    }
                }
                if (!(is_array($data->tpl_vars[$tpl_var]->value) || $data->tpl_vars[$tpl_var]->value instanceof ArrayAccess)) {
                    settype($data->tpl_vars[$tpl_var]->value, 'array');
                }
                if ($merge && is_array($value)) {
                    foreach ($value as $_mkey => $_mval) {
                        $data->tpl_vars[$tpl_var]->value[$_mkey] = $_mval;
                    }
                } else {
                    $data->tpl_vars[$tpl_var]->value[] = $value;
                }
            }
            if ($data->_isTplObj() && $data->scope) {
                $data->ext->_updateScope->_updateScope($data, $tpl_var);
            }
        }
        return $data;
    }
}