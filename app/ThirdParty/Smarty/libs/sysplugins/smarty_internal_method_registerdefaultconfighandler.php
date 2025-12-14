<?php

class Smarty_Internal_Method_RegisterDefaultConfigHandler
{
    public $objMap = 3;

    public function registerDefaultConfigHandler(Smarty_Internal_TemplateBase $obj, $callback)
    {
        $smarty = $obj->_getSmartyObj();
        if (is_callable($callback)) {
            $smarty->default_config_handler_func = $callback;
        } else {
            throw new SmartyException('Default config handler not callable');
        }
        return $obj;
    }
}