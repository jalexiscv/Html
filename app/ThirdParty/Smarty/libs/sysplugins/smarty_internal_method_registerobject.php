<?php

class Smarty_Internal_Method_RegisterObject
{
    public $objMap = 3;

    public function registerObject(Smarty_Internal_TemplateBase $obj, $object_name, $object, $allowed_methods_properties = array(), $format = true, $block_methods = array())
    {
        $smarty = $obj->_getSmartyObj();
        if (!empty($allowed_methods_properties)) {
            foreach ((array)$allowed_methods_properties as $method) {
                if (!is_callable(array($object, $method)) && !property_exists($object, $method)) {
                    throw new SmartyException("Undefined method or property '$method' in registered object");
                }
            }
        }
        if (!empty($block_methods)) {
            foreach ((array)$block_methods as $method) {
                if (!is_callable(array($object, $method))) {
                    throw new SmartyException("Undefined method '$method' in registered object");
                }
            }
        }
        $smarty->registered_objects[$object_name] = array($object, (array)$allowed_methods_properties, (boolean)$format, (array)$block_methods);
        return $obj;
    }
}