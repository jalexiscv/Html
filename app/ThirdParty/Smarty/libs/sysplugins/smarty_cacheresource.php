<?php

abstract class Smarty_CacheResource
{
    protected static $sysplugins = array('file' => 'smarty_internal_cacheresource_file.php',);

    abstract public function populate(\Smarty_Template_Cached $cached, Smarty_Internal_Template $_template);

    abstract public function populateTimestamp(Smarty_Template_Cached $cached);

    abstract public function process(Smarty_Internal_Template $_template, Smarty_Template_Cached $cached = null, $update = false);

    abstract public function writeCachedContent(Smarty_Internal_Template $_template, $content);

    abstract public function readCachedContent(Smarty_Internal_Template $_template);

    public function getCachedContent(Smarty_Internal_Template $_template)
    {
        if ($_template->cached->handler->process($_template)) {
            ob_start();
            $unifunc = $_template->cached->unifunc;
            $unifunc($_template);
            return ob_get_clean();
        }
        return null;
    }

    abstract public function clearAll(Smarty $smarty, $exp_time = null);

    abstract public function clear(Smarty $smarty, $resource_name, $cache_id, $compile_id, $exp_time);

    public function locked(Smarty $smarty, Smarty_Template_Cached $cached)
    {
        $start = microtime(true);
        $hadLock = null;
        while ($this->hasLock($smarty, $cached)) {
            $hadLock = true;
            if (microtime(true) - $start > $smarty->locking_timeout) {
                return false;
            }
            sleep(1);
        }
        return $hadLock;
    }

    public function hasLock(Smarty $smarty, Smarty_Template_Cached $cached)
    {
        return false;
    }

    public function acquireLock(Smarty $smarty, Smarty_Template_Cached $cached)
    {
        return true;
    }

    public function releaseLock(Smarty $smarty, Smarty_Template_Cached $cached)
    {
        return true;
    }

    public static function load(Smarty $smarty, $type = null)
    {
        if (!isset($type)) {
            $type = $smarty->caching_type;
        }
        if (isset($smarty->_cache['cacheresource_handlers'][$type])) {
            return $smarty->_cache['cacheresource_handlers'][$type];
        }
        if (isset($smarty->registered_cache_resources[$type])) {
            return $smarty->_cache['cacheresource_handlers'][$type] = $smarty->registered_cache_resources[$type];
        }
        if (isset(self::$sysplugins[$type])) {
            $cache_resource_class = 'Smarty_Internal_CacheResource_' . smarty_ucfirst_ascii($type);
            return $smarty->_cache['cacheresource_handlers'][$type] = new $cache_resource_class();
        }
        $cache_resource_class = 'Smarty_CacheResource_' . smarty_ucfirst_ascii($type);
        if ($smarty->loadPlugin($cache_resource_class)) {
            return $smarty->_cache['cacheresource_handlers'][$type] = new $cache_resource_class();
        }
        throw new SmartyException("Unable to load cache resource '{$type}'");
    }
}