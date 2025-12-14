<?php

class Smarty_Internal_Method_UnregisterResource
{
    public $objMap = 3;

    public function unregisterResource(Smarty_Internal_TemplateBase $obj, $type)
    {
        $smarty = $obj->_getSmartyObj();
        if (isset($smarty->registered_resources[$type])) {
            unset($smarty->registered_resources[$type]);
        }
        return $obj;
    }
}