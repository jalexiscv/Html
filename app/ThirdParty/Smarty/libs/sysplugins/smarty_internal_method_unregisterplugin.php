<?php

class Smarty_Internal_Method_UnregisterPlugin
{
    public $objMap = 3;

    public function unregisterPlugin(Smarty_Internal_TemplateBase $obj, $type, $name)
    {
        $smarty = $obj->_getSmartyObj();
        if (isset($smarty->registered_plugins[$type][$name])) {
            unset($smarty->registered_plugins[$type][$name]);
        }
        return $obj;
    }
}