<?php

#[\AllowDynamicProperties] class Smarty_Internal_Template extends Smarty_Internal_TemplateBase
{
    public static $tplObjCache = array();
    public static $isCacheTplObj = array();
    public static $subTplInfo = array();
    public $_objType = 2;
    public $smarty = null;
    public $source = null;
    public $inheritance = null;
    public $template_resource = null;
    public $mustCompile = null;
    public $templateId = null;
    public $scope = 0;
    public $isRenderingCache = false;
    public $startRenderCallbacks = array();
    public $endRenderCallbacks = array();

    public function __construct($template_resource, Smarty $smarty, Smarty_Internal_Data $_parent = null, $_cache_id = null, $_compile_id = null, $_caching = null, $_cache_lifetime = null, $_isConfig = false)
    {
        $this->smarty = $smarty;
        $this->cache_id = $_cache_id === null ? $this->smarty->cache_id : $_cache_id;
        $this->compile_id = $_compile_id === null ? $this->smarty->compile_id : $_compile_id;
        $this->caching = (int)($_caching === null ? $this->smarty->caching : $_caching);
        $this->cache_lifetime = $_cache_lifetime === null ? $this->smarty->cache_lifetime : $_cache_lifetime;
        $this->compile_check = (int)$smarty->compile_check;
        $this->parent = $_parent;
        $this->template_resource = $template_resource;
        $this->source = $_isConfig ? Smarty_Template_Config::load($this) : Smarty_Template_Source::load($this);
        parent::__construct();
        if ($smarty->security_policy && method_exists($smarty->security_policy, 'registerCallBacks')) {
            $smarty->security_policy->registerCallBacks($this);
        }
    }

    public function _subTemplateRender($template, $cache_id, $compile_id, $caching, $cache_lifetime, $data, $scope, $forceTplCache, $uid = null, $content_func = null)
    {
        $tpl = clone $this;
        $tpl->parent = $this;
        $smarty = &$this->smarty;
        $_templateId = $smarty->_getTemplateId($template, $cache_id, $compile_id, $caching, $tpl);
        if ((isset($tpl->templateId) ? $tpl->templateId : $tpl->_getTemplateId()) !== $_templateId) {
            if (isset(self::$tplObjCache[$_templateId])) {
                $cachedTpl = &self::$tplObjCache[$_templateId];
                $tpl->templateId = $cachedTpl->templateId;
                $tpl->template_resource = $cachedTpl->template_resource;
                $tpl->cache_id = $cachedTpl->cache_id;
                $tpl->compile_id = $cachedTpl->compile_id;
                $tpl->source = $cachedTpl->source;
                if (isset($cachedTpl->compiled)) {
                    $tpl->compiled = $cachedTpl->compiled;
                } else {
                    unset($tpl->compiled);
                }
                if ($caching !== 9999 && isset($cachedTpl->cached)) {
                    $tpl->cached = $cachedTpl->cached;
                } else {
                    unset($tpl->cached);
                }
            } else {
                $tpl->templateId = $_templateId;
                $tpl->template_resource = $template;
                $tpl->cache_id = $cache_id;
                $tpl->compile_id = $compile_id;
                if (isset($uid)) {
                    list($filepath, $timestamp, $type) = $tpl->compiled->file_dependency[$uid];
                    $tpl->source = new Smarty_Template_Source($smarty, $filepath, $type, $filepath);
                    $tpl->source->filepath = $filepath;
                    $tpl->source->timestamp = $timestamp;
                    $tpl->source->exists = true;
                    $tpl->source->uid = $uid;
                } else {
                    $tpl->source = Smarty_Template_Source::load($tpl);
                    unset($tpl->compiled);
                }
                if ($caching !== 9999) {
                    unset($tpl->cached);
                }
            }
        } else {
            $forceTplCache = true;
        }
        $tpl->caching = $caching;
        $tpl->cache_lifetime = $cache_lifetime;
        $tpl->scope = $scope;
        if (!isset(self::$tplObjCache[$tpl->templateId]) && !$tpl->source->handler->recompiled) {
            if ($forceTplCache || (isset(self::$subTplInfo[$tpl->template_resource]) && self::$subTplInfo[$tpl->template_resource] > 1) || ($tpl->_isSubTpl() && isset(self::$tplObjCache[$tpl->parent->templateId]))) {
                self::$tplObjCache[$tpl->templateId] = $tpl;
            }
        }
        if (!empty($data)) {
            foreach ($data as $_key => $_val) {
                $tpl->tpl_vars[$_key] = new Smarty_Variable($_val, $this->isRenderingCache);
            }
        }
        if ($tpl->caching === 9999) {
            if (!isset($tpl->compiled)) {
                $tpl->loadCompiled(true);
            }
            if ($tpl->compiled->has_nocache_code) {
                $this->cached->hashes[$tpl->compiled->nocache_hash] = true;
            }
        }
        $tpl->_cache = array();
        if (isset($uid)) {
            if ($smarty->debugging) {
                if (!isset($smarty->_debug)) {
                    $smarty->_debug = new Smarty_Internal_Debug();
                }
                $smarty->_debug->start_template($tpl);
                $smarty->_debug->start_render($tpl);
            }
            $tpl->compiled->getRenderedTemplateCode($tpl, $content_func);
            if ($smarty->debugging) {
                $smarty->_debug->end_template($tpl);
                $smarty->_debug->end_render($tpl);
            }
        } else {
            if (isset($tpl->compiled)) {
                $tpl->compiled->render($tpl);
            } else {
                $tpl->render();
            }
        }
    }

    public function _getTemplateId()
    {
        return isset($this->templateId) ? $this->templateId : $this->templateId = $this->smarty->_getTemplateId($this->template_resource, $this->cache_id, $this->compile_id);
    }

    public function _isSubTpl()
    {
        return isset($this->parent) && $this->parent->_isTplObj();
    }

    public function loadCompiled($force = false)
    {
        if ($force || !isset($this->compiled)) {
            $this->compiled = Smarty_Template_Compiled::load($this);
        }
    }

    public function render($no_output_filter = true, $display = null)
    {
        if ($this->smarty->debugging) {
            if (!isset($this->smarty->_debug)) {
                $this->smarty->_debug = new Smarty_Internal_Debug();
            }
            $this->smarty->_debug->start_template($this, $display);
        }
        if (!$this->source->exists) {
            throw new SmartyException("Unable to load template '{$this->source->type}:{$this->source->name}'" . ($this->_isSubTpl() ? " in '{$this->parent->template_resource}'" : ''));
        }
        if ($this->source->handler->recompiled) {
            $this->caching = Smarty::CACHING_OFF;
        }
        if ($this->caching === Smarty::CACHING_LIFETIME_CURRENT || $this->caching === Smarty::CACHING_LIFETIME_SAVED) {
            if (!isset($this->cached) || $this->cached->cache_id !== $this->cache_id || $this->cached->compile_id !== $this->compile_id) {
                $this->loadCached(true);
            }
            $this->cached->render($this, $no_output_filter);
        } else {
            if (!isset($this->compiled) || $this->compiled->compile_id !== $this->compile_id) {
                $this->loadCompiled(true);
            }
            $this->compiled->render($this);
        }
        if ($display) {
            if ($this->caching && $this->smarty->cache_modified_check) {
                $this->smarty->ext->_cacheModify->cacheModifiedCheck($this->cached, $this, isset($content) ? $content : ob_get_clean());
            } else {
                if ((!$this->caching || $this->cached->has_nocache_code || $this->source->handler->recompiled) && !$no_output_filter && (isset($this->smarty->autoload_filters['output']) || isset($this->smarty->registered_filters['output']))) {
                    echo $this->smarty->ext->_filterHandler->runFilter('output', ob_get_clean(), $this);
                } else {
                    echo ob_get_clean();
                }
            }
            if ($this->smarty->debugging) {
                $this->smarty->_debug->end_template($this);
                $this->smarty->_debug->display_debug($this, true);
            }
            return '';
        } else {
            if ($this->smarty->debugging) {
                $this->smarty->_debug->end_template($this);
                if ($this->smarty->debugging === 2 && $display === false) {
                    $this->smarty->_debug->display_debug($this, true);
                }
            }
            if (!$no_output_filter && (!$this->caching || $this->cached->has_nocache_code || $this->source->handler->recompiled) && (isset($this->smarty->autoload_filters['output']) || isset($this->smarty->registered_filters['output']))) {
                return $this->smarty->ext->_filterHandler->runFilter('output', ob_get_clean(), $this);
            }
            return null;
        }
    }

    public function loadCached($force = false)
    {
        if ($force || !isset($this->cached)) {
            $this->cached = Smarty_Template_Cached::load($this);
        }
    }

    public function _subTemplateRegister()
    {
        foreach ($this->compiled->includes as $name => $count) {
            if (isset(self::$subTplInfo[$name])) {
                self::$subTplInfo[$name] += $count;
            } else {
                self::$subTplInfo[$name] = $count;
            }
        }
    }

    public function _assignInScope($varName, $value, $nocache = false, $scope = 0)
    {
        if (isset($this->tpl_vars[$varName])) {
            $this->tpl_vars[$varName] = clone $this->tpl_vars[$varName];
            $this->tpl_vars[$varName]->value = $value;
            if ($nocache || $this->isRenderingCache) {
                $this->tpl_vars[$varName]->nocache = true;
            }
        } else {
            $this->tpl_vars[$varName] = new Smarty_Variable($value, $nocache || $this->isRenderingCache);
        }
        if ($scope >= 0) {
            if ($scope > 0 || $this->scope > 0) {
                $this->smarty->ext->_updateScope->_updateScope($this, $varName, $scope);
            }
        }
    }

    public function _checkPlugins($plugins)
    {
        static $checked = array();
        foreach ($plugins as $plugin) {
            $name = join('::', (array)$plugin['function']);
            if (!isset($checked[$name])) {
                if (!is_callable($plugin['function'])) {
                    if (is_file($plugin['file'])) {
                        include_once $plugin['file'];
                        if (is_callable($plugin['function'])) {
                            $checked[$name] = true;
                        }
                    }
                } else {
                    $checked[$name] = true;
                }
            }
            if (!isset($checked[$name])) {
                if (false !== $this->smarty->loadPlugin($name)) {
                    $checked[$name] = true;
                } else {
                    throw new SmartyException("Plugin '{$name}' not callable");
                }
            }
        }
    }

    public function _decodeProperties(Smarty_Internal_Template $tpl, $properties, $cache = false)
    {
        if (!isset($properties['version']) || Smarty::SMARTY_VERSION !== $properties['version']) {
            if ($cache) {
                $tpl->smarty->clearAllCache();
            } else {
                $tpl->smarty->clearCompiledTemplate();
            }
            return false;
        }
        $is_valid = true;
        if (!empty($properties['file_dependency']) && ((!$cache && $tpl->compile_check) || $tpl->compile_check === Smarty::COMPILECHECK_ON)) {
            foreach ($properties['file_dependency'] as $_file_to_check) {
                if ($_file_to_check[2] === 'file' || $_file_to_check[2] === 'php') {
                    if ($tpl->source->filepath === $_file_to_check[0]) {
                        continue;
                    } else {
                        $mtime = is_file($_file_to_check[0]) ? filemtime($_file_to_check[0]) : false;
                    }
                } else {
                    $handler = Smarty_Resource::load($tpl->smarty, $_file_to_check[2]);
                    if ($handler->checkTimestamps()) {
                        $source = Smarty_Template_Source::load($tpl, $tpl->smarty, $_file_to_check[0]);
                        $mtime = $source->getTimeStamp();
                    } else {
                        continue;
                    }
                }
                if ($mtime === false || $mtime > $_file_to_check[1]) {
                    $is_valid = false;
                    break;
                }
            }
        }
        if ($cache) {
            if ($tpl->caching === Smarty::CACHING_LIFETIME_SAVED && $properties['cache_lifetime'] >= 0 && (time() > ($tpl->cached->timestamp + $properties['cache_lifetime']))) {
                $is_valid = false;
            }
            $tpl->cached->cache_lifetime = $properties['cache_lifetime'];
            $tpl->cached->valid = $is_valid;
            $resource = $tpl->cached;
        } else {
            $tpl->mustCompile = !$is_valid;
            $resource = $tpl->compiled;
            $resource->includes = isset($properties['includes']) ? $properties['includes'] : array();
        }
        if ($is_valid) {
            $resource->unifunc = $properties['unifunc'];
            $resource->has_nocache_code = $properties['has_nocache_code'];
            $resource->file_dependency = $properties['file_dependency'];
        }
        return $is_valid && !function_exists($properties['unifunc']);
    }

    public function compileTemplateSource()
    {
        return $this->compiled->compileTemplateSource($this);
    }

    public function writeCachedContent($content)
    {
        return $this->smarty->ext->_updateCache->writeCachedContent($this, $content);
    }

    public function capture_error()
    {
        throw new SmartyException("Not matching {capture} open/close in '{$this->template_resource}'");
    }

    public function _loadInheritance()
    {
        if (!isset($this->inheritance)) {
            $this->inheritance = new Smarty_Internal_Runtime_Inheritance();
        }
    }

    public function _cleanUp()
    {
        $this->startRenderCallbacks = array();
        $this->endRenderCallbacks = array();
        $this->inheritance = null;
    }

    public function __call($name, $args)
    {
        if (method_exists($this->smarty, $name)) {
            return call_user_func_array(array($this->smarty, $name), $args);
        }
        return parent::__call($name, $args);
    }

    public function __get($property_name)
    {
        switch ($property_name) {
            case 'compiled':
                $this->loadCompiled();
                return $this->compiled;
            case 'cached':
                $this->loadCached();
                return $this->cached;
            case 'compiler':
                $this->loadCompiler();
                return $this->compiler;
            default:
                if (property_exists($this->smarty, $property_name)) {
                    return $this->smarty->$property_name;
                }
        }
        throw new SmartyException("template property '$property_name' does not exist.");
    }

    public function __set($property_name, $value)
    {
        switch ($property_name) {
            case 'compiled':
            case 'cached':
            case 'compiler':
                $this->$property_name = $value;
                return;
            default:
                if (property_exists($this->smarty, $property_name)) {
                    $this->smarty->$property_name = $value;
                    return;
                }
        }
        throw new SmartyException("invalid template property '$property_name'.");
    }

    public function loadCompiler()
    {
        if (!class_exists($this->source->compiler_class)) {
            $this->smarty->loadPlugin($this->source->compiler_class);
        }
        $this->compiler = new $this->source->compiler_class($this->source->template_lexer_class, $this->source->template_parser_class, $this->smarty);
    }

    public function __destruct()
    {
        if ($this->smarty->cache_locking && isset($this->cached) && $this->cached->is_locked) {
            $this->cached->handler->releaseLock($this->smarty, $this->cached);
        }
    }
}