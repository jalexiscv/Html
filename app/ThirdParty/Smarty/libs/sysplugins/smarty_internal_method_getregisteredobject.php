<?php

class Smarty_Internal_Method_GetRegisteredObject
{
    public $objMap = 3;

    public function getRegisteredObject(Smarty_Internal_TemplateBase $obj, $object_name)
    {
        $smarty = $obj->_getSmartyObj();
        if (!isset($smarty->registered_objects[$object_name])) {
            throw new SmartyException("'$object_name' is not a registered object");
        }
        if (!is_object($smarty->registered_objects[$object_name][0])) {
            throw new SmartyException("registered '$object_name' is not an object");
        }
        return $smarty->registered_objects[$object_name][0];
    }
}