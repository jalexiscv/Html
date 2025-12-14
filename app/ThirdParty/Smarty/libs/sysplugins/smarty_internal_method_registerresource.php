<?php

class Smarty_Internal_Method_RegisterResource
{
    public $objMap = 3;

    public function registerResource(Smarty_Internal_TemplateBase $obj, $name, Smarty_Resource $resource_handler)
    {
        $smarty = $obj->_getSmartyObj();
        $smarty->registered_resources[$name] = $resource_handler;
        return $obj;
    }
}