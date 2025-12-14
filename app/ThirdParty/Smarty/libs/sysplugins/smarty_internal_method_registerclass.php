<?php

class Smarty_Internal_Method_RegisterClass
{
    public $objMap = 3;

    public function registerClass(Smarty_Internal_TemplateBase $obj, $class_name, $class_impl)
    {
        $smarty = $obj->_getSmartyObj();
        if (!class_exists($class_impl)) {
            throw new SmartyException("Undefined class '$class_impl' in register template class");
        }
        $smarty->registered_classes[$class_name] = $class_impl;
        return $obj;
    }
}