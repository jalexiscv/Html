<?php

class Smarty_Internal_Method_ClearAllCache
{
    public $objMap = 1;

    public function clearAllCache(Smarty $smarty, $exp_time = null, $type = null)
    {
        $smarty->_clearTemplateCache();
        $_cache_resource = Smarty_CacheResource::load($smarty, $type);
        return $_cache_resource->clearAll($smarty, $exp_time);
    }
}