<?php

class Smarty_Internal_Method_RegisterDefaultPluginHandler
{
    public $objMap = 3;

    public function registerDefaultPluginHandler(Smarty_Internal_TemplateBase $obj, $callback)
    {
        $smarty = $obj->_getSmartyObj();
        if (is_callable($callback)) {
            $smarty->default_plugin_handler_func = $callback;
        } else {
            throw new SmartyException("Default plugin handler '$callback' not callable");
        }
        return $obj;
    }
}