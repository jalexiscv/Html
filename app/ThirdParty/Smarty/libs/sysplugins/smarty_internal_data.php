<?php

abstract class Smarty_Internal_Data
{
    public $_objType = 4;
    public $template_class = 'Smarty_Internal_Template';
    public $tpl_vars = array();
    public $parent = null;
    public $config_vars = array();
    public $ext = null;

    public function __construct()
    {
        $this->ext = new Smarty_Internal_Extension_Handler();
        $this->ext->objType = $this->_objType;
    }

    public function assign($tpl_var, $value = null, $nocache = false)
    {
        if (is_array($tpl_var)) {
            foreach ($tpl_var as $_key => $_val) {
                $this->assign($_key, $_val, $nocache);
            }
        } else {
            if ($tpl_var !== '') {
                if ($this->_objType === 2) {
                    $this->_assignInScope($tpl_var, $value, $nocache);
                } else {
                    $this->tpl_vars[$tpl_var] = new Smarty_Variable($value, $nocache);
                }
            }
        }
        return $this;
    }

    public function append($tpl_var, $value = null, $merge = false, $nocache = false)
    {
        return $this->ext->append->append($this, $tpl_var, $value, $merge, $nocache);
    }

    public function assignGlobal($varName, $value = null, $nocache = false)
    {
        return $this->ext->assignGlobal->assignGlobal($this, $varName, $value, $nocache);
    }

    public function appendByRef($tpl_var, &$value, $merge = false)
    {
        return $this->ext->appendByRef->appendByRef($this, $tpl_var, $value, $merge);
    }

    public function assignByRef($tpl_var, &$value, $nocache = false)
    {
        return $this->ext->assignByRef->assignByRef($this, $tpl_var, $value, $nocache);
    }

    public function getTemplateVars($varName = null, Smarty_Internal_Data $_ptr = null, $searchParents = true)
    {
        return $this->ext->getTemplateVars->getTemplateVars($this, $varName, $_ptr, $searchParents);
    }

    public function _mergeVars(Smarty_Internal_Data $data = null)
    {
        if (isset($data)) {
            if (!empty($this->tpl_vars)) {
                $data->tpl_vars = array_merge($this->tpl_vars, $data->tpl_vars);
            }
            if (!empty($this->config_vars)) {
                $data->config_vars = array_merge($this->config_vars, $data->config_vars);
            }
        } else {
            $data = $this;
        }
        if (isset($this->parent)) {
            $this->parent->_mergeVars($data);
        }
    }

    public function _isDataObj()
    {
        return $this->_objType === 4;
    }

    public function _isTplObj()
    {
        return $this->_objType === 2;
    }

    public function _isSmartyObj()
    {
        return $this->_objType === 1;
    }

    public function _getSmartyObj()
    {
        return $this->smarty;
    }

    public function __call($name, $args)
    {
        return $this->ext->_callExternalMethod($this, $name, $args);
    }
}