<?php

abstract class Smarty_Template_Resource_Base
{
    public $filepath = null;
    public $timestamp = false;
    public $exists = false;
    public $compile_id = null;
    public $processed = false;
    public $unifunc = '';
    public $has_nocache_code = false;
    public $file_dependency = array();
    public $content = null;
    public $includes = array();
    public $isCache = false;

    abstract public function process(Smarty_Internal_Template $_template);

    public function getRenderedTemplateCode(Smarty_Internal_Template $_template, $unifunc = null)
    {
        $smarty = &$_template->smarty;
        $_template->isRenderingCache = $this->isCache;
        $level = ob_get_level();
        try {
            if (!isset($unifunc)) {
                $unifunc = $this->unifunc;
            }
            if (empty($unifunc) || !function_exists($unifunc)) {
                throw new SmartyException("Invalid compiled template for '{$_template->template_resource}'");
            }
            if ($_template->startRenderCallbacks) {
                foreach ($_template->startRenderCallbacks as $callback) {
                    call_user_func($callback, $_template);
                }
            }
            $unifunc($_template);
            foreach ($_template->endRenderCallbacks as $callback) {
                call_user_func($callback, $_template);
            }
            $_template->isRenderingCache = false;
        } catch (Exception $e) {
            $_template->isRenderingCache = false;
            while (ob_get_level() > $level) {
                ob_end_clean();
            }
            if (isset($smarty->security_policy)) {
                $smarty->security_policy->endTemplate();
            }
            throw $e;
        }
    }

    public function getTimeStamp()
    {
        if ($this->exists && !$this->timestamp) {
            $this->timestamp = filemtime($this->filepath);
        }
        return $this->timestamp;
    }
}