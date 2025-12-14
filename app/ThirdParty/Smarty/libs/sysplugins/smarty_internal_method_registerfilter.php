<?php

class Smarty_Internal_Method_RegisterFilter
{
    public $objMap = 3;
    private $filterTypes = array('pre' => true, 'post' => true, 'output' => true, 'variable' => true);

    public function registerFilter(Smarty_Internal_TemplateBase $obj, $type, $callback, $name = null)
    {
        $smarty = $obj->_getSmartyObj();
        $this->_checkFilterType($type);
        $name = isset($name) ? $name : $this->_getFilterName($callback);
        if (!is_callable($callback)) {
            throw new SmartyException("{$type}filter '{$name}' not callable");
        }
        $smarty->registered_filters[$type][$name] = $callback;
        return $obj;
    }

    public function _checkFilterType($type)
    {
        if (!isset($this->filterTypes[$type])) {
            throw new SmartyException("Illegal filter type '{$type}'");
        }
    }

    public function _getFilterName($function_name)
    {
        if (is_array($function_name)) {
            $_class_name = (is_object($function_name[0]) ? get_class($function_name[0]) : $function_name[0]);
            return $_class_name . '_' . $function_name[1];
        } elseif (is_string($function_name)) {
            return $function_name;
        } else {
            return 'closure';
        }
    }
}