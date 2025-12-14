<?php

class Smarty_Internal_Method_AddAutoloadFilters extends Smarty_Internal_Method_SetAutoloadFilters
{
    public function addAutoloadFilters(Smarty_Internal_TemplateBase $obj, $filters, $type = null)
    {
        $smarty = $obj->_getSmartyObj();
        if ($type !== null) {
            $this->_checkFilterType($type);
            if (!empty($smarty->autoload_filters[$type])) {
                $smarty->autoload_filters[$type] = array_merge($smarty->autoload_filters[$type], (array)$filters);
            } else {
                $smarty->autoload_filters[$type] = (array)$filters;
            }
        } else {
            foreach ((array)$filters as $type => $value) {
                $this->_checkFilterType($type);
                if (!empty($smarty->autoload_filters[$type])) {
                    $smarty->autoload_filters[$type] = array_merge($smarty->autoload_filters[$type], (array)$value);
                } else {
                    $smarty->autoload_filters[$type] = (array)$value;
                }
            }
        }
        return $obj;
    }
}