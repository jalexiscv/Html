<?php

class Smarty_Internal_Runtime_TplFunction
{
    public function callTemplateFunction(Smarty_Internal_Template $tpl, $name, $params, $nocache)
    {
        $funcParam = isset($tpl->tplFunctions[$name]) ? $tpl->tplFunctions[$name] : (isset($tpl->smarty->tplFunctions[$name]) ? $tpl->smarty->tplFunctions[$name] : null);
        if (isset($funcParam)) {
            if (!$tpl->caching || ($tpl->caching && $nocache)) {
                $function = $funcParam['call_name'];
            } else {
                if (isset($funcParam['call_name_caching'])) {
                    $function = $funcParam['call_name_caching'];
                } else {
                    $function = $funcParam['call_name'];
                }
            }
            if (function_exists($function)) {
                $this->saveTemplateVariables($tpl, $name);
                $function($tpl, $params);
                $this->restoreTemplateVariables($tpl, $name);
                return;
            }
            if ($this->addTplFuncToCache($tpl, $name, $function)) {
                $this->saveTemplateVariables($tpl, $name);
                $function($tpl, $params);
                $this->restoreTemplateVariables($tpl, $name);
                return;
            }
        }
        throw new SmartyException("Unable to find template function '{$name}'");
    }

    public function saveTemplateVariables(Smarty_Internal_Template $tpl, $name)
    {
        $tpl->_cache['varStack'][] = array('tpl' => $tpl->tpl_vars, 'config' => $tpl->config_vars, 'name' => "_tplFunction_{$name}");
    }

    public function restoreTemplateVariables(Smarty_Internal_Template $tpl, $name)
    {
        if (isset($tpl->_cache['varStack'])) {
            $vars = array_pop($tpl->_cache['varStack']);
            $tpl->tpl_vars = $vars['tpl'];
            $tpl->config_vars = $vars['config'];
        }
    }

    public function addTplFuncToCache(Smarty_Internal_Template $tpl, $_name, $_function)
    {
        $funcParam = $tpl->tplFunctions[$_name];
        if (is_file($funcParam['compiled_filepath'])) {
            $code = file_get_contents($funcParam['compiled_filepath']);
            if (preg_match("/\/\* {$_function} \*\/([\S\s]*?)\/\*\/ {$_function} \*\//", $code, $match)) {
                preg_match("/\s*'{$funcParam['uid']}'([\S\s]*?)\),/", $code, $match1);
                unset($code);
                eval($match[0]);
                if (function_exists($_function)) {
                    $tplPtr = $tpl;
                    while (!isset($tplPtr->cached) && isset($tplPtr->parent)) {
                        $tplPtr = $tplPtr->parent;
                    }
                    if (isset($tplPtr->cached)) {
                        $content = $tplPtr->cached->read($tplPtr);
                        if ($content) {
                            if (!preg_match("/'{$funcParam['uid']}'(.*?)'nocache_hash'/", $content, $match2)) {
                                $content = preg_replace("/('file_dependency'(.*?)\()/", "\\1{$match1[0]}", $content);
                            }
                            $tplPtr->smarty->ext->_updateCache->write($tplPtr, preg_replace('/\s*\?>\s*$/', "\n", $content) . "\n" . preg_replace(array('/^\s*<\?php\s+/', '/\s*\?>\s*$/',), "\n", $match[0]));
                        }
                    }
                    return true;
                }
            }
        }
        return false;
    }

    public function registerTplFunctions(Smarty_Internal_TemplateBase $obj, $tplFunctions, $override = true)
    {
        $obj->tplFunctions = $override ? array_merge($obj->tplFunctions, $tplFunctions) : array_merge($tplFunctions, $obj->tplFunctions);
        if ($obj->_isSubTpl()) {
            $obj->smarty->ext->_tplFunction->registerTplFunctions($obj->parent, $tplFunctions, false);
        } else {
            $obj->smarty->tplFunctions = $override ? array_merge($obj->smarty->tplFunctions, $tplFunctions) : array_merge($tplFunctions, $obj->smarty->tplFunctions);
        }
    }

    public function getTplFunction(Smarty_Internal_Template $tpl, $name = null)
    {
        if (isset($name)) {
            return isset($tpl->tplFunctions[$name]) ? $tpl->tplFunctions[$name] : (isset($tpl->smarty->tplFunctions[$name]) ? $tpl->smarty->tplFunctions[$name] : false);
        } else {
            return empty($tpl->tplFunctions) ? $tpl->smarty->tplFunctions : $tpl->tplFunctions;
        }
    }
}