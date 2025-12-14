<?php

class Smarty_Internal_Method_GetDebugTemplate
{
    public $objMap = 3;

    public function getDebugTemplate(Smarty_Internal_TemplateBase $obj)
    {
        $smarty = $obj->_getSmartyObj();
        return $smarty->debug_tpl;
    }
}