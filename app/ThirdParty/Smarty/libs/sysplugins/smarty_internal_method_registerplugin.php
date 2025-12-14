<?php

class Smarty_Internal_Method_RegisterPlugin
{
    public $objMap = 3;

    public function registerPlugin(Smarty_Internal_TemplateBase $obj, $type, $name, $callback, $cacheable = true, $cache_attr = null)
    {
        $smarty = $obj->_getSmartyObj();
        if (isset($smarty->registered_plugins[$type][$name])) {
            throw new SmartyException("Plugin tag '{$name}' already registered");
        } elseif (!is_callable($callback)) {
            throw new SmartyException("Plugin '{$name}' not callable");
        } elseif ($cacheable && $cache_attr) {
            throw new SmartyException("Cannot set caching attributes for plugin '{$name}' when it is cacheable.");
        } else {
            $smarty->registered_plugins[$type][$name] = array($callback, (bool)$cacheable, (array)$cache_attr);
        }
        return $obj;
    }
}