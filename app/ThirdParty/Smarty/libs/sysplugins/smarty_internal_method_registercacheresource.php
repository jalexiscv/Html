<?php

class Smarty_Internal_Method_RegisterCacheResource
{
    public $objMap = 3;

    public function registerCacheResource(Smarty_Internal_TemplateBase $obj, $name, Smarty_CacheResource $resource_handler)
    {
        $smarty = $obj->_getSmartyObj();
        $smarty->registered_cache_resources[$name] = $resource_handler;
        return $obj;
    }
}