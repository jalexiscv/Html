<?php

class Smarty_Internal_Method_UnregisterCacheResource
{
    public $objMap = 3;

    public function unregisterCacheResource(Smarty_Internal_TemplateBase $obj, $name)
    {
        $smarty = $obj->_getSmartyObj();
        if (isset($smarty->registered_cache_resources[$name])) {
            unset($smarty->registered_cache_resources[$name]);
        }
        return $obj;
    }
}