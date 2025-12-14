<?php

class Smarty_Internal_Method_ClearCache
{
    public $objMap = 1;

    public function clearCache(Smarty $smarty, $template_name, $cache_id = null, $compile_id = null, $exp_time = null, $type = null)
    {
        $smarty->_clearTemplateCache();
        $_cache_resource = Smarty_CacheResource::load($smarty, $type);
        return $_cache_resource->clear($smarty, $template_name, $cache_id, $compile_id, $exp_time);
    }
}