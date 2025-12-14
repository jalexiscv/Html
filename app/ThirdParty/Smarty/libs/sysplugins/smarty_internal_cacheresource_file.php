<?php

class Smarty_Internal_CacheResource_File extends Smarty_CacheResource
{
    public function populate(Smarty_Template_Cached $cached, Smarty_Internal_Template $_template)
    {
        $source = &$_template->source;
        $smarty = &$_template->smarty;
        $_compile_dir_sep = $smarty->use_sub_dirs ? DIRECTORY_SEPARATOR : '^';
        $_filepath = sha1($source->uid . $smarty->_joined_template_dir);
        $cached->filepath = $smarty->getCacheDir();
        if (isset($_template->cache_id)) {
            $cached->filepath .= preg_replace(array('![^\w|]+!', '![|]+!'), array('_', $_compile_dir_sep), $_template->cache_id) . $_compile_dir_sep;
        }
        if (isset($_template->compile_id)) {
            $cached->filepath .= preg_replace('![^\w]+!', '_', $_template->compile_id) . $_compile_dir_sep;
        }
        if ($smarty->use_sub_dirs) {
            $cached->filepath .= $_filepath[0] . $_filepath[1] . DIRECTORY_SEPARATOR . $_filepath[2] . $_filepath[3] . DIRECTORY_SEPARATOR . $_filepath[4] . $_filepath[5] . DIRECTORY_SEPARATOR;
        }
        $cached->filepath .= $_filepath;
        $basename = $source->handler->getBasename($source);
        if (!empty($basename)) {
            $cached->filepath .= '.' . $basename;
        }
        if ($smarty->cache_locking) {
            $cached->lock_id = $cached->filepath . '.lock';
        }
        $cached->filepath .= '.php';
        $cached->timestamp = $cached->exists = is_file($cached->filepath);
        if ($cached->exists) {
            $cached->timestamp = filemtime($cached->filepath);
        }
    }

    public function populateTimestamp(Smarty_Template_Cached $cached)
    {
        $cached->timestamp = $cached->exists = is_file($cached->filepath);
        if ($cached->exists) {
            $cached->timestamp = filemtime($cached->filepath);
        }
    }

    public function process(Smarty_Internal_Template $_smarty_tpl, Smarty_Template_Cached $cached = null, $update = false)
    {
        $_smarty_tpl->cached->valid = false;
        if ($update && defined('HHVM_VERSION')) {
            eval('?>' . file_get_contents($_smarty_tpl->cached->filepath));
            return true;
        } else {
            return @include $_smarty_tpl->cached->filepath;
        }
    }

    public function writeCachedContent(Smarty_Internal_Template $_template, $content)
    {
        if ($_template->smarty->ext->_writeFile->writeFile($_template->cached->filepath, $content, $_template->smarty) === true) {
            if (function_exists('opcache_invalidate') && (!function_exists('ini_get') || strlen(ini_get('opcache.restrict_api'))) < 1) {
                opcache_invalidate($_template->cached->filepath, true);
            } elseif (function_exists('apc_compile_file')) {
                apc_compile_file($_template->cached->filepath);
            }
            $cached = $_template->cached;
            $cached->timestamp = $cached->exists = is_file($cached->filepath);
            if ($cached->exists) {
                $cached->timestamp = filemtime($cached->filepath);
                return true;
            }
        }
        return false;
    }

    public function readCachedContent(Smarty_Internal_Template $_template)
    {
        if (is_file($_template->cached->filepath)) {
            return file_get_contents($_template->cached->filepath);
        }
        return false;
    }

    public function clearAll(Smarty $smarty, $exp_time = null)
    {
        return $smarty->ext->_cacheResourceFile->clear($smarty, null, null, null, $exp_time);
    }

    public function clear(Smarty $smarty, $resource_name, $cache_id, $compile_id, $exp_time)
    {
        return $smarty->ext->_cacheResourceFile->clear($smarty, $resource_name, $cache_id, $compile_id, $exp_time);
    }

    public function hasLock(Smarty $smarty, Smarty_Template_Cached $cached)
    {
        clearstatcache(true, $cached->lock_id ?? '');
        if (null !== $cached->lock_id && is_file($cached->lock_id)) {
            $t = filemtime($cached->lock_id);
            return $t && (time() - $t < $smarty->locking_timeout);
        } else {
            return false;
        }
    }

    public function acquireLock(Smarty $smarty, Smarty_Template_Cached $cached)
    {
        $cached->is_locked = true;
        touch($cached->lock_id);
    }

    public function releaseLock(Smarty $smarty, Smarty_Template_Cached $cached)
    {
        $cached->is_locked = false;
        @unlink($cached->lock_id);
    }
}