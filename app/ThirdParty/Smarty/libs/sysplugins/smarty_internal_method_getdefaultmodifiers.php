<?php

class Smarty_Internal_Method_GetDefaultModifiers
{
    public $objMap = 3;

    public function getDefaultModifiers(Smarty_Internal_TemplateBase $obj)
    {
        $smarty = $obj->_getSmartyObj();
        return $smarty->default_modifiers;
    }
}