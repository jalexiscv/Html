<?php

class Smarty_Internal_Method_SetAutoloadFilters
{
    public $objMap = 3;
    private $filterTypes = array('pre' => true, 'post' => true, 'output' => true, 'variable' => true);

    public function setAutoloadFilters(Smarty_Internal_TemplateBase $obj, $filters, $type = null)
    {
        $smarty = $obj->_getSmartyObj();
        if ($type !== null) {
            $this->_checkFilterType($type);
            $smarty->autoload_filters[$type] = (array)$filters;
        } else {
            foreach ((array)$filters as $type => $value) {
                $this->_checkFilterType($type);
            }
            $smarty->autoload_filters = (array)$filters;
        }
        return $obj;
    }

    public function _checkFilterType($type)
    {
        if (!isset($this->filterTypes[$type])) {
            throw new SmartyException("Illegal filter type '{$type}'");
        }
    }
}