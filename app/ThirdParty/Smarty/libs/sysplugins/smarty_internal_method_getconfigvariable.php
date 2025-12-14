<?php

class Smarty_Internal_Method_GetConfigVariable
{
    public $objMap = 7;

    public function getConfigVariable(Smarty_Internal_Data $data, $varName = null, $errorEnable = true)
    {
        return $data->ext->configLoad->_getConfigVariable($data, $varName, $errorEnable);
    }
}