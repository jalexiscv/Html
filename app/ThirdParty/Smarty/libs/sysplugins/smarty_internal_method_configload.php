<?php

class Smarty_Internal_Method_ConfigLoad
{
    public $objMap = 7;

    public function configLoad(Smarty_Internal_Data $data, $config_file, $sections = null)
    {
        $this->_loadConfigFile($data, $config_file, $sections, null);
        return $data;
    }

    public function _loadConfigFile(Smarty_Internal_Data $data, $config_file, $sections = null, $scope = 0)
    {
        $smarty = $data->_getSmartyObj();
        $confObj = new Smarty_Internal_Template($config_file, $smarty, $data, null, null, null, null, true);
        $confObj->caching = Smarty::CACHING_OFF;
        $confObj->source->config_sections = $sections;
        $confObj->source->scope = $scope;
        $confObj->compiled = Smarty_Template_Compiled::load($confObj);
        $confObj->compiled->render($confObj);
        if ($data->_isTplObj()) {
            $data->compiled->file_dependency[$confObj->source->uid] = array($confObj->source->filepath, $confObj->source->getTimeStamp(), $confObj->source->type);
        }
    }

    public function _loadConfigVars(Smarty_Internal_Template $tpl, $new_config_vars)
    {
        $this->_assignConfigVars($tpl->parent->config_vars, $tpl, $new_config_vars);
        $tagScope = $tpl->source->scope;
        if ($tagScope >= 0) {
            if ($tagScope === Smarty::SCOPE_LOCAL) {
                $this->_updateVarStack($tpl, $new_config_vars);
                $tagScope = 0;
                if (!$tpl->scope) {
                    return;
                }
            }
            if ($tpl->parent->_isTplObj() && ($tagScope || $tpl->parent->scope)) {
                $mergedScope = $tagScope | $tpl->scope;
                if ($mergedScope) {
                    foreach ($tpl->smarty->ext->_updateScope->_getAffectedScopes($tpl->parent, $mergedScope) as $ptr) {
                        $this->_assignConfigVars($ptr->config_vars, $tpl, $new_config_vars);
                        if ($tagScope && $ptr->_isTplObj() && isset($tpl->_cache['varStack'])) {
                            $this->_updateVarStack($tpl, $new_config_vars);
                        }
                    }
                }
            }
        }
    }

    public function _assignConfigVars(&$config_vars, Smarty_Internal_Template $tpl, $new_config_vars)
    {
        foreach ($new_config_vars['vars'] as $variable => $value) {
            if ($tpl->smarty->config_overwrite || !isset($config_vars[$variable])) {
                $config_vars[$variable] = $value;
            } else {
                $config_vars[$variable] = array_merge((array)$config_vars[$variable], (array)$value);
            }
        }
        $sections = $tpl->source->config_sections;
        if (!empty($sections)) {
            foreach ((array)$sections as $tpl_section) {
                if (isset($new_config_vars['sections'][$tpl_section])) {
                    foreach ($new_config_vars['sections'][$tpl_section]['vars'] as $variable => $value) {
                        if ($tpl->smarty->config_overwrite || !isset($config_vars[$variable])) {
                            $config_vars[$variable] = $value;
                        } else {
                            $config_vars[$variable] = array_merge((array)$config_vars[$variable], (array)$value);
                        }
                    }
                }
            }
        }
    }

    public function _updateVarStack(Smarty_Internal_Template $tpl, $config_vars)
    {
        $i = 0;
        while (isset($tpl->_cache['varStack'][$i])) {
            $this->_assignConfigVars($tpl->_cache['varStack'][$i]['config'], $tpl, $config_vars);
            $i++;
        }
    }

    public function _getConfigVariable(Smarty_Internal_Data $data, $varName, $errorEnable = true)
    {
        $_ptr = $data;
        while ($_ptr !== null) {
            if (isset($_ptr->config_vars[$varName])) {
                return $_ptr->config_vars[$varName];
            }
            $_ptr = $_ptr->parent;
        }
        if ($data->smarty->error_unassigned && $errorEnable) {
            $x = $$varName;
        }
        return null;
    }
}