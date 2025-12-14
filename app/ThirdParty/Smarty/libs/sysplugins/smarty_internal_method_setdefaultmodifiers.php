<?php

class Smarty_Internal_Method_SetDefaultModifiers
{
    public $objMap = 3;

    public function setDefaultModifiers(Smarty_Internal_TemplateBase $obj, $modifiers)
    {
        $smarty = $obj->_getSmartyObj();
        $smarty->default_modifiers = (array)$modifiers;
        return $obj;
    }
}