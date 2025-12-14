<?php

class Smarty_Internal_Method_UnregisterObject
{
    public $objMap = 3;

    public function unregisterObject(Smarty_Internal_TemplateBase $obj, $object_name)
    {
        $smarty = $obj->_getSmartyObj();
        if (isset($smarty->registered_objects[$object_name])) {
            unset($smarty->registered_objects[$object_name]);
        }
        return $obj;
    }
}