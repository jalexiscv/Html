<?php

class Smarty_Internal_Method_CreateData
{
    public $objMap = 3;

    public function createData(Smarty_Internal_TemplateBase $obj, Smarty_Internal_Data $parent = null, $name = null)
    {
        $smarty = $obj->_getSmartyObj();
        $dataObj = new Smarty_Data($parent, $smarty, $name);
        if ($smarty->debugging) {
            Smarty_Internal_Debug::register_data($dataObj);
        }
        return $dataObj;
    }
}