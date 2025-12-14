<?php

class Smarty_Internal_Method_LoadFilter
{
    public $objMap = 3;
    private $filterTypes = array('pre' => true, 'post' => true, 'output' => true, 'variable' => true);

    public function loadFilter(Smarty_Internal_TemplateBase $obj, $type, $name)
    {
        $smarty = $obj->_getSmartyObj();
        $this->_checkFilterType($type);
        $_plugin = "smarty_{$type}filter_{$name}";
        $_filter_name = $_plugin;
        if (is_callable($_plugin)) {
            $smarty->registered_filters[$type][$_filter_name] = $_plugin;
            return true;
        }
        if ($smarty->loadPlugin($_plugin)) {
            if (class_exists($_plugin, false)) {
                $_plugin = array($_plugin, 'execute');
            }
            if (is_callable($_plugin)) {
                $smarty->registered_filters[$type][$_filter_name] = $_plugin;
                return true;
            }
        }
        throw new SmartyException("{$type}filter '{$name}' not found or callable");
    }

    public function _checkFilterType($type)
    {
        if (!isset($this->filterTypes[$type])) {
            throw new SmartyException("Illegal filter type '{$type}'");
        }
    }
}