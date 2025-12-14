<?php

abstract class Smarty_CacheResource_KeyValueStore extends Smarty_CacheResource
{
    protected $contents = array();
    protected $timestamps = array();

    public function populate(Smarty_Template_Cached $cached, Smarty_Internal_Template $_template)
    {
        $cached->filepath = $_template->source->uid . '#' . $this->sanitize($cached->source->resource) . '#' . $this->sanitize($cached->cache_id) . '#' . $this->sanitize($cached->compile_id);
        $this->populateTimestamp($cached);
    }

    public function populateTimestamp(Smarty_Template_Cached $cached)
    {
        if (!$this->fetch($cached->filepath, $cached->source->name, $cached->cache_id, $cached->compile_id, $content, $timestamp, $cached->source->uid)) {
            return;
        }
        $cached->content = $content;
        $cached->timestamp = (int)$timestamp;
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
            if (!$this->fetch($_smarty_tpl->cached->filepath, $_smarty_tpl->source->name, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, $content, $timestamp, $_smarty_tpl->source->uid)) {
                return false;
            }
        }
        if (isset($content)) {
            eval('?>' . $content);
            return true;
        }
        return false;
    }

    public function writeCachedContent(Smarty_Internal_Template $_template, $content)
    {
        $this->addMetaTimestamp($content);
        return $this->write(array($_template->cached->filepath => $content), $_template->cache_lifetime);
    }

    public function readCachedContent(Smarty_Internal_Template $_template)
    {
        $content = $_template->cached->content ? $_template->cached->content : null;
        $timestamp = null;
        if ($content === null) {
            if (!$this->fetch($_template->cached->filepath, $_template->source->name, $_template->cache_id, $_template->compile_id, $content, $timestamp, $_template->source->uid)) {
                return false;
            }
        }
        if (isset($content)) {
            return $content;
        }
        return false;
    }

    public function clearAll(Smarty $smarty, $exp_time = null)
    {
        if (!$this->purge()) {
            $this->invalidate(null);
        }
        return -1;
    }

    public function clear(Smarty $smarty, $resource_name, $cache_id, $compile_id, $exp_time)
    {
        $uid = $this->getTemplateUid($smarty, $resource_name);
        $cid = $uid . '#' . $this->sanitize($resource_name) . '#' . $this->sanitize($cache_id) . '#' . $this->sanitize($compile_id);
        $this->delete(array($cid));
        $this->invalidate($cid, $resource_name, $cache_id, $compile_id, $uid);
        return -1;
    }

    protected function getTemplateUid(Smarty $smarty, $resource_name)
    {
        if (isset($resource_name)) {
            $source = Smarty_Template_Source::load(null, $smarty, $resource_name);
            if ($source->exists) {
                return $source->uid;
            }
        }
        return '';
    }

    protected function sanitize($string)
    {
        $string = trim((string)$string, '|');
        if (!$string) {
            return '';
        }
        return preg_replace('#[^\w\|]+#S', '_', $string);
    }

    protected function fetch($cid, $resource_name = null, $cache_id = null, $compile_id = null, &$content = null, &$timestamp = null, $resource_uid = null)
    {
        $t = $this->read(array($cid));
        $content = !empty($t[$cid]) ? $t[$cid] : null;
        $timestamp = null;
        if ($content && ($timestamp = $this->getMetaTimestamp($content))) {
            $invalidated = $this->getLatestInvalidationTimestamp($cid, $resource_name, $cache_id, $compile_id, $resource_uid);
            if ($invalidated > $timestamp) {
                $timestamp = null;
                $content = null;
            }
        }
        return !!$content;
    }

    protected function addMetaTimestamp(&$content)
    {
        $mt = explode(' ', microtime());
        $ts = pack('NN', $mt[1], (int)($mt[0] * 100000000));
        $content = $ts . $content;
    }

    protected function getMetaTimestamp(&$content)
    {
        extract(unpack('N1s/N1m/a*content', $content));
        return $s + ($m / 100000000);
    }

    protected function invalidate($cid = null, $resource_name = null, $cache_id = null, $compile_id = null, $resource_uid = null)
    {
        $now = microtime(true);
        $key = null;
        if (!$resource_name && !$cache_id && !$compile_id) {
            $key = 'IVK#ALL';
        } else {
            if ($resource_name && !$cache_id && !$compile_id) {
                $key = 'IVK#TEMPLATE#' . $resource_uid . '#' . $this->sanitize($resource_name);
            } else {
                if (!$resource_name && $cache_id && !$compile_id) {
                    $key = 'IVK#CACHE#' . $this->sanitize($cache_id);
                } else {
                    if (!$resource_name && !$cache_id && $compile_id) {
                        $key = 'IVK#COMPILE#' . $this->sanitize($compile_id);
                    } else {
                        $key = 'IVK#CID#' . $cid;
                    }
                }
            }
        }
        $this->write(array($key => $now));
    }

    protected function getLatestInvalidationTimestamp($cid, $resource_name = null, $cache_id = null, $compile_id = null, $resource_uid = null)
    {
        if (false && !$cid) {
            return 0;
        }
        if (!($_cid = $this->listInvalidationKeys($cid, $resource_name, $cache_id, $compile_id, $resource_uid))) {
            return 0;
        }
        if (!($values = $this->read($_cid))) {
            return 0;
        }
        $values = array_map('floatval', $values);
        return max($values);
    }

    protected function listInvalidationKeys($cid, $resource_name = null, $cache_id = null, $compile_id = null, $resource_uid = null)
    {
        $t = array('IVK#ALL');
        $_name = $_compile = '#';
        if ($resource_name) {
            $_name .= $resource_uid . '#' . $this->sanitize($resource_name);
            $t[] = 'IVK#TEMPLATE' . $_name;
        }
        if ($compile_id) {
            $_compile .= $this->sanitize($compile_id);
            $t[] = 'IVK#COMPILE' . $_compile;
        }
        $_name .= '#';
        $cid = trim((string)$cache_id, '|');
        if (!$cid) {
            return $t;
        }
        $i = 0;
        while (true) {
            $i = strpos($cid, '|', $i);
            if ($i === false) {
                $t[] = 'IVK#CACHE#' . $cid;
                $t[] = 'IVK#CID' . $_name . $cid . $_compile;
                $t[] = 'IVK#CID' . $_name . $_compile;
                break;
            }
            $part = substr($cid, 0, $i);
            $t[] = 'IVK#CACHE#' . $part;
            $t[] = 'IVK#CID' . $_name . $part . $_compile;
            $i++;
        }
        return $t;
    }

    public function hasLock(Smarty $smarty, Smarty_Template_Cached $cached)
    {
        $key = 'LOCK#' . $cached->filepath;
        $data = $this->read(array($key));
        return $data && time() - $data[$key] < $smarty->locking_timeout;
    }

    public function acquireLock(Smarty $smarty, Smarty_Template_Cached $cached)
    {
        $cached->is_locked = true;
        $key = 'LOCK#' . $cached->filepath;
        $this->write(array($key => time()), $smarty->locking_timeout);
    }

    public function releaseLock(Smarty $smarty, Smarty_Template_Cached $cached)
    {
        $cached->is_locked = false;
        $key = 'LOCK#' . $cached->filepath;
        $this->delete(array($key));
    }

    abstract protected function read(array $keys);

    abstract protected function write(array $keys, $expire = null);

    abstract protected function delete(array $keys);

    protected function purge()
    {
        return false;
    }
}