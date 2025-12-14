<?php

abstract class Smarty_Internal_TemplateBase extends Smarty_Internal_Data
{
    public $cache_id = null;
    public $compile_id = null;
    public $caching = Smarty::CACHING_OFF;
    public $compile_check = Smarty::COMPILECHECK_ON;
    public $cache_lifetime = 3600;
    public $tplFunctions = array();
    public $_cache = array();

    public function fetch($template = null, $cache_id = null, $compile_id = null, $parent = null)
    {
        $result = $this->_execute($template, $cache_id, $compile_id, $parent, 0);
        return $result === null ? ob_get_clean() : $result;
    }

    private function _execute($template, $cache_id, $compile_id, $parent, $function)
    {
        $smarty = $this->_getSmartyObj();
        $saveVars = true;
        if ($template === null) {
            if (!$this->_isTplObj()) {
                throw new SmartyException($function . '():Missing \'$template\' parameter');
            } else {
                $template = $this;
            }
        } elseif (is_object($template)) {
            if (!isset($template->_objType) || !$template->_isTplObj()) {
                throw new SmartyException($function . '():Template object expected');
            }
        } else {
            $saveVars = false;
            $template = $smarty->createTemplate($template, $cache_id, $compile_id, $parent ? $parent : $this, false);
            if ($this->_objType === 1) {
                $template->caching = $this->caching;
            }
        }
        $template->caching = (int)$template->caching;
        $level = ob_get_level();
        try {
            $_smarty_old_error_level = isset($smarty->error_reporting) ? error_reporting($smarty->error_reporting) : null;
            if ($smarty->isMutingUndefinedOrNullWarnings()) {
                $errorHandler = new Smarty_Internal_ErrorHandler();
                $errorHandler->activate();
            }
            if ($this->_objType === 2) {
                $template->tplFunctions = $this->tplFunctions;
                $template->inheritance = $this->inheritance;
            }
            if (isset($parent->_objType) && ($parent->_objType === 2) && !empty($parent->tplFunctions)) {
                $template->tplFunctions = array_merge($parent->tplFunctions, $template->tplFunctions);
            }
            if ($function === 2) {
                if ($template->caching) {
                    if (!isset($template->cached)) {
                        $template->loadCached();
                    }
                    $result = $template->cached->isCached($template);
                    Smarty_Internal_Template::$isCacheTplObj[$template->_getTemplateId()] = $template;
                } else {
                    return false;
                }
            } else {
                if ($saveVars) {
                    $savedTplVars = $template->tpl_vars;
                    $savedConfigVars = $template->config_vars;
                }
                ob_start();
                $template->_mergeVars();
                if (!empty(Smarty::$global_tpl_vars)) {
                    $template->tpl_vars = array_merge(Smarty::$global_tpl_vars, $template->tpl_vars);
                }
                $result = $template->render(false, $function);
                $template->_cleanUp();
                if ($saveVars) {
                    $template->tpl_vars = $savedTplVars;
                    $template->config_vars = $savedConfigVars;
                } else {
                    if (!$function && !isset(Smarty_Internal_Template::$tplObjCache[$template->templateId])) {
                        $template->parent = null;
                        $template->tpl_vars = $template->config_vars = array();
                        Smarty_Internal_Template::$tplObjCache[$template->templateId] = $template;
                    }
                }
            }
            if (isset($errorHandler)) {
                $errorHandler->deactivate();
            }
            if (isset($_smarty_old_error_level)) {
                error_reporting($_smarty_old_error_level);
            }
            return $result;
        } catch (Throwable $e) {
            while (ob_get_level() > $level) {
                ob_end_clean();
            }
            if (isset($errorHandler)) {
                $errorHandler->deactivate();
            }
            if (isset($_smarty_old_error_level)) {
                error_reporting($_smarty_old_error_level);
            }
            throw $e;
        }
    }

    public function isCached($template = null, $cache_id = null, $compile_id = null, $parent = null)
    {
        return $this->_execute($template, $cache_id, $compile_id, $parent, 2);
    }

    public function display($template = null, $cache_id = null, $compile_id = null, $parent = null)
    {
        $this->_execute($template, $cache_id, $compile_id, $parent, 1);
    }

    public function registerPlugin($type, $name, $callback, $cacheable = true, $cache_attr = null)
    {
        return $this->ext->registerPlugin->registerPlugin($this, $type, $name, $callback, $cacheable, $cache_attr);
    }

    public function loadFilter($type, $name)
    {
        return $this->ext->loadFilter->loadFilter($this, $type, $name);
    }

    public function registerFilter($type, $callback, $name = null)
    {
        return $this->ext->registerFilter->registerFilter($this, $type, $callback, $name);
    }

    public function registerObject($object_name, $object, $allowed_methods_properties = array(), $format = true, $block_methods = array())
    {
        return $this->ext->registerObject->registerObject($this, $object_name, $object, $allowed_methods_properties, $format, $block_methods);
    }

    public function setCompileCheck($compile_check)
    {
        $this->compile_check = (int)$compile_check;
    }

    public function setCaching($caching)
    {
        $this->caching = (int)$caching;
    }

    public function setCacheLifetime($cache_lifetime)
    {
        $this->cache_lifetime = $cache_lifetime;
    }

    public function setCompileId($compile_id)
    {
        $this->compile_id = $compile_id;
    }

    public function setCacheId($cache_id)
    {
        $this->cache_id = $cache_id;
    }
}