<?php

class Smarty_Internal_Method_ClearAllAssign
{
    public $objMap = 7;

    public function clearAllAssign(Smarty_Internal_Data $data)
    {
        $data->tpl_vars = array();
        return $data;
    }
}