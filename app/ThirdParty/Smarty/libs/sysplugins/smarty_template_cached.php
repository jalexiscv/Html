<?php

class Smarty_Template_Cached extends Smarty_Template_Resource_Base
{
    public $valid = null;
    public $handler = null;
    public $cache_id = null;
    public $cache_lifetime = 0;
    public $lock_id = null;
    public $is_locked = false;
    public $source = null;
    public $hashes = array();
    public $isCache = true;

    public function __construct(Smarty_Internal_Template $_template)
    {
        $this->compile_id = $_template->compile_id;
        $this->cache_id = $_template->cache_id;
        $this->source = $_template->source;
        if (!class_exists('Smarty_CacheResource', false)) {
            include SMARTY_SYSPLUGINS_DIR . 'smarty_cacheresource.php';
        }
        $this->handler = Smarty_CacheResource::load($_template->smarty);
    }

    public static function load(Smarty_Internal_Template $_template)
    {
        $_template->cached = new Smarty_Template_Cached($_template);
        $_template->cached->handler->populate($_template->cached, $_template);
        if (!$_template->caching || $_template->source->handler->recompiled) {
            $_template->cached->valid = false;
        }
        return $_template->cached;
    }

    public function render(Smarty_Internal_Template $_template, $no_output_filter = true)
    {
        if ($this->isCached($_template)) {
            if ($_template->smarty->debugging) {
                if (!isset($_template->smarty->_debug)) {
                    $_template->smarty->_debug = new Smarty_Internal_Debug();
                }
                $_template->smarty->_debug->start_cache($_template);
            }
            if (!$this->processed) {
                $this->process($_template);
            }
            $this->getRenderedTemplateCode($_template);
            if ($_template->smarty->debugging) {
                $_template->smarty->_debug->end_cache($_template);
            }
            return;
        } else {
            $_template->smarty->ext->_updateCache->updateCache($this, $_template, $no_output_filter);
        }
    }

    public function isCached(Smarty_Internal_Template $_template)
    {
        if ($this->valid !== null) {
            return $this->valid;
        }
        while (true) {
            while (true) {
                if ($this->exists === false || $_template->smarty->force_compile || $_template->smarty->force_cache) {
                    $this->valid = false;
                } else {
                    $this->valid = true;
                }
                if ($this->valid && $_template->caching === Smarty::CACHING_LIFETIME_CURRENT && $_template->cache_lifetime >= 0 && time() > ($this->timestamp + $_template->cache_lifetime)) {
                    $this->valid = false;
                }
                if ($this->valid && $_template->compile_check === Smarty::COMPILECHECK_ON && $_template->source->getTimeStamp() > $this->timestamp) {
                    $this->valid = false;
                }
                if ($this->valid || !$_template->smarty->cache_locking) {
                    break;
                }
                if (!$this->handler->locked($_template->smarty, $this)) {
                    $this->handler->acquireLock($_template->smarty, $this);
                    break 2;
                }
                $this->handler->populate($this, $_template);
            }
            if ($this->valid) {
                if (!$_template->smarty->cache_locking || $this->handler->locked($_template->smarty, $this) === null) {
                    if ($_template->smarty->debugging) {
                        $_template->smarty->_debug->start_cache($_template);
                    }
                    if ($this->handler->process($_template, $this) === false) {
                        $this->valid = false;
                    } else {
                        $this->processed = true;
                    }
                    if ($_template->smarty->debugging) {
                        $_template->smarty->_debug->end_cache($_template);
                    }
                } else {
                    $this->is_locked = true;
                    continue;
                }
            } else {
                return $this->valid;
            }
            if ($this->valid && $_template->caching === Smarty::CACHING_LIFETIME_SAVED && $_template->cached->cache_lifetime >= 0 && (time() > ($_template->cached->timestamp + $_template->cached->cache_lifetime))) {
                $this->valid = false;
            }
            if ($_template->smarty->cache_locking) {
                if (!$this->valid) {
                    $this->handler->acquireLock($_template->smarty, $this);
                } elseif ($this->is_locked) {
                    $this->handler->releaseLock($_template->smarty, $this);
                }
            }
            return $this->valid;
        }
        return $this->valid;
    }

    public function process(Smarty_Internal_Template $_template, $update = false)
    {
        if ($this->handler->process($_template, $this, $update) === false) {
            $this->valid = false;
        }
        if ($this->valid) {
            $this->processed = true;
        } else {
            $this->processed = false;
        }
    }

    public function read(Smarty_Internal_Template $_template)
    {
        if (!$_template->source->handler->recompiled) {
            return $this->handler->readCachedContent($_template);
        }
        return false;
    }
}