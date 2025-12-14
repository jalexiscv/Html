<?php

class Smarty_Internal_Method_ClearAssign
{
    public $objMap = 7;

    public function clearAssign(Smarty_Internal_Data $data, $tpl_var)
    {
        if (is_array($tpl_var)) {
            foreach ($tpl_var as $curr_var) {
                unset($data->tpl_vars[$curr_var]);
            }
        } else {
            unset($data->tpl_vars[$tpl_var]);
        }
        return $data;
    }
}