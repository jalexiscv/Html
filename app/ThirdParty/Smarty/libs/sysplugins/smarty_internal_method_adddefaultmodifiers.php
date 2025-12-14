<?php

class Smarty_Internal_Method_AddDefaultModifiers
{
    public $objMap = 3;

    public function addDefaultModifiers(Smarty_Internal_TemplateBase $obj, $modifiers)
    {
        $smarty = $obj->_getSmartyObj();
        if (is_array($modifiers)) {
            $smarty->default_modifiers = array_merge($smarty->default_modifiers, $modifiers);
        } else {
            $smarty->default_modifiers[] = $modifiers;
        }
        return $obj;
    }
}