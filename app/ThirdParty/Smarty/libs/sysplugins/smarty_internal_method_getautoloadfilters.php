<?php

class Smarty_Internal_Method_GetAutoloadFilters extends Smarty_Internal_Method_SetAutoloadFilters
{
    public function getAutoloadFilters(Smarty_Internal_TemplateBase $obj, $type = null)
    {
        $smarty = $obj->_getSmartyObj();
        if ($type !== null) {
            $this->_checkFilterType($type);
            return isset($smarty->autoload_filters[$type]) ? $smarty->autoload_filters[$type] : array();
        }
        return $smarty->autoload_filters;
    }
}