<?php

class Smarty_Internal_Method_SetDebugTemplate
{
    public $objMap = 3;

    public function setDebugTemplate(Smarty_Internal_TemplateBase $obj, $tpl_name)
    {
        $smarty = $obj->_getSmartyObj();
        if (!is_readable($tpl_name)) {
            throw new SmartyException("Unknown file '{$tpl_name}'");
        }
        $smarty->debug_tpl = $tpl_name;
        return $obj;
    }
}