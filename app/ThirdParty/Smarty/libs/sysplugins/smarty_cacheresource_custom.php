<?php

abstract class Smarty_CacheResource_Custom extends Smarty_CacheResource
{
    abstract protected function fetch($id, $name, $cache_id, $compile_id, &$content, &$mtime);

    protected function fetchTimestamp($id, $name, $cache_id, $compile_id)
    {
        return false;
    }

    abstract protected function save($id, $name, $cache_id, $compile_id, $exp_time, $content);

    abstract protected function delete($name, $cache_id, $compile_id, $exp_time);

    public function populate(Smarty_Template_Cached $cached, Smarty_Internal_Template $_template)
    {
        $_cache_id = isset($cached->cache_id) ? preg_replace('![^\w\|]+!', '_', $cached->cache_id) : null;
        $_compile_id = isset($cached->compile_id) ? preg_replace('![^\w]+!', '_', $cached->compile_id) : null;
        $path = $cached->source->uid . $_cache_id . $_compile_id;
        $cached->filepath = sha1($path);
        if ($_template->smarty->cache_locking) {
            $cached->lock_id = sha1('lock.' . $path);
        }
        $this->populateTimestamp($cached);
    }

    public function populateTimestamp(Smarty_Template_Cached $cached)
    {
        $mtime = $this->fetchTimestamp($cached->filepath, $cached->source->name, $cached->cache_id, $cached->compile_id);
        if ($mtime !== null) {
            $cached->timestamp = $mtime;
            $cached->exists = !!$cached->timestamp;
            return;
        }
        $timestamp = null;
        $this->fetch($cached->filepath, $cached->source->name, $cached->cache_id, $cached->compile_id, $cached->content, $timestamp);
        $cached->timestamp = isset($timestamp) ? $timestamp : false;
        $cached->exists = !!$cached->timestamp;
    }

    public function process(Smarty_Internal_Template $_smarty_tpl, Smarty_Template_Cached $cached = null, $update = false)
    {
        if (!$cached) {
            $cached = $_smarty_tpl->cached;
        }
        $content = $cached->content ? $cached->content : null;
        $timestamp = $cached->timestamp ? $cached->timestamp : null;
        if ($content === null || !$timestamp) {
            $this->fetch($_smarty_tpl->cached->filepath, $_smarty_tpl->source->name, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, $content, $timestamp);
        }
        if (isset($content)) {
            eval('?>' . $content);
            $cached->content = null;
            return true;
        }
        return false;
    }

    public function writeCachedContent(Smarty_Internal_Template $_template, $content)
    {
        return $this->save($_template->cached->filepath, $_template->source->name, $_template->cache_id, $_template->compile_id, $_template->cache_lifetime, $content);
    }

    public function readCachedContent(Smarty_Internal_Template $_template)
    {
        $content = $_template->cached->content ? $_template->cached->content : null;
        $timestamp = null;
        if ($content === null) {
            $timestamp = null;
            $this->fetch($_template->cached->filepath, $_template->source->name, $_template->cache_id, $_template->compile_id, $content, $timestamp);
        }
        if (isset($content)) {
            return $content;
        }
        return false;
    }

    public function clearAll(Smarty $smarty, $exp_time = null)
    {
        return $this->delete(null, null, null, $exp_time);
    }

    public function clear(Smarty $smarty, $resource_name, $cache_id, $compile_id, $exp_time)
    {
        $cache_name = null;
        if (isset($resource_name)) {
            $source = Smarty_Template_Source::load(null, $smarty, $resource_name);
            if ($source->exists) {
                $cache_name = $source->name;
            } else {
                return 0;
            }
        }
        return $this->delete($cache_name, $cache_id, $compile_id, $exp_time);
    }

    public function hasLock(Smarty $smarty, Smarty_Template_Cached $cached)
    {
        $id = $cached->lock_id;
        $name = $cached->source->name . '.lock';
        $mtime = $this->fetchTimestamp($id, $name, $cached->cache_id, $cached->compile_id);
        if ($mtime === null) {
            $this->fetch($id, $name, $cached->cache_id, $cached->compile_id, $content, $mtime);
        }
        return $mtime && ($t = time()) - $mtime < $smarty->locking_timeout;
    }

    public function acquireLock(Smarty $smarty, Smarty_Template_Cached $cached)
    {
        $cached->is_locked = true;
        $id = $cached->lock_id;
        $name = $cached->source->name . '.lock';
        $this->save($id, $name, $cached->cache_id, $cached->compile_id, $smarty->locking_timeout, '');
    }

    public function releaseLock(Smarty $smarty, Smarty_Template_Cached $cached)
    {
        $cached->is_locked = false;
        $name = $cached->source->name . '.lock';
        $this->delete($name, $cached->cache_id, $cached->compile_id, null);
    }
}