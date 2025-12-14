<?php

class Smarty_Template_Compiled extends Smarty_Template_Resource_Base
{
    public $nocache_hash = null;

    public static function load($_template)
    {
        $compiled = new Smarty_Template_Compiled();
        if ($_template->source->handler->hasCompiledHandler) {
            $_template->source->handler->populateCompiledFilepath($compiled, $_template);
        } else {
            $compiled->populateCompiledFilepath($_template);
        }
        return $compiled;
    }

    public function populateCompiledFilepath(Smarty_Internal_Template $_template)
    {
        $source = &$_template->source;
        $smarty = &$_template->smarty;
        $this->filepath = $smarty->getCompileDir();
        if (isset($_template->compile_id)) {
            $this->filepath .= preg_replace('![^\w]+!', '_', $_template->compile_id) . ($smarty->use_sub_dirs ? DIRECTORY_SEPARATOR : '^');
        }
        if ($smarty->use_sub_dirs) {
            $this->filepath .= $source->uid[0] . $source->uid[1] . DIRECTORY_SEPARATOR . $source->uid[2] . $source->uid[3] . DIRECTORY_SEPARATOR . $source->uid[4] . $source->uid[5] . DIRECTORY_SEPARATOR;
        }
        $this->filepath .= $source->uid . '_';
        if ($source->isConfig) {
            $this->filepath .= (int)$smarty->config_read_hidden + (int)$smarty->config_booleanize * 2 + (int)$smarty->config_overwrite * 4;
        } else {
            $this->filepath .= (int)$smarty->merge_compiled_includes + (int)$smarty->escape_html * 2 + (($smarty->merge_compiled_includes && $source->type === 'extends') ? (int)$smarty->extends_recursion * 4 : 0);
        }
        $this->filepath .= '.' . $source->type;
        $basename = $source->handler->getBasename($source);
        if (!empty($basename)) {
            $this->filepath .= '.' . $basename;
        }
        if ($_template->caching) {
            $this->filepath .= '.cache';
        }
        $this->filepath .= '.php';
        $this->timestamp = $this->exists = is_file($this->filepath);
        if ($this->exists) {
            $this->timestamp = filemtime($this->filepath);
        }
    }

    public function render(Smarty_Internal_Template $_template)
    {
        if (!$_template->source->exists) {
            $type = $_template->source->isConfig ? 'config' : 'template';
            throw new SmartyException("Unable to load {$type} '{$_template->source->type}:{$_template->source->name}'");
        }
        if ($_template->smarty->debugging) {
            if (!isset($_template->smarty->_debug)) {
                $_template->smarty->_debug = new Smarty_Internal_Debug();
            }
            $_template->smarty->_debug->start_render($_template);
        }
        if (!$this->processed) {
            $this->process($_template);
        }
        if (isset($_template->cached)) {
            $_template->cached->file_dependency = array_merge($_template->cached->file_dependency, $this->file_dependency);
        }
        if ($_template->source->handler->uncompiled) {
            $_template->source->handler->renderUncompiled($_template->source, $_template);
        } else {
            $this->getRenderedTemplateCode($_template);
        }
        if ($_template->caching && $this->has_nocache_code) {
            $_template->cached->hashes[$this->nocache_hash] = true;
        }
        if ($_template->smarty->debugging) {
            $_template->smarty->_debug->end_render($_template);
        }
    }

    public function process(Smarty_Internal_Template $_smarty_tpl)
    {
        $source = &$_smarty_tpl->source;
        $smarty = &$_smarty_tpl->smarty;
        if ($source->handler->recompiled) {
            $source->handler->process($_smarty_tpl);
        } elseif (!$source->handler->uncompiled) {
            if (!$this->exists || $smarty->force_compile || ($_smarty_tpl->compile_check && $source->getTimeStamp() > $this->getTimeStamp())) {
                $this->compileTemplateSource($_smarty_tpl);
                $compileCheck = $_smarty_tpl->compile_check;
                $_smarty_tpl->compile_check = Smarty::COMPILECHECK_OFF;
                $this->loadCompiledTemplate($_smarty_tpl);
                $_smarty_tpl->compile_check = $compileCheck;
            } else {
                $_smarty_tpl->mustCompile = true;
                @include $this->filepath;
                if ($_smarty_tpl->mustCompile) {
                    $this->compileTemplateSource($_smarty_tpl);
                    $compileCheck = $_smarty_tpl->compile_check;
                    $_smarty_tpl->compile_check = Smarty::COMPILECHECK_OFF;
                    $this->loadCompiledTemplate($_smarty_tpl);
                    $_smarty_tpl->compile_check = $compileCheck;
                }
            }
            $_smarty_tpl->_subTemplateRegister();
            $this->processed = true;
        }
    }

    public function compileTemplateSource(Smarty_Internal_Template $_template)
    {
        $this->file_dependency = array();
        $this->includes = array();
        $this->nocache_hash = null;
        $this->unifunc = null;
        if ($saved_timestamp = (!$_template->source->handler->recompiled && is_file($this->filepath))) {
            $saved_timestamp = $this->getTimeStamp();
            touch($this->filepath);
        }
        try {
            $_template->loadCompiler();
            $this->write($_template, $_template->compiler->compileTemplate($_template));
        } catch (Exception $e) {
            if ($saved_timestamp && is_file($this->filepath)) {
                touch($this->filepath, $saved_timestamp);
            }
            unset($_template->compiler);
            throw $e;
        }
        unset($_template->compiler);
    }

    public function write(Smarty_Internal_Template $_template, $code)
    {
        if (!$_template->source->handler->recompiled) {
            if ($_template->smarty->ext->_writeFile->writeFile($this->filepath, $code, $_template->smarty) === true) {
                $this->timestamp = $this->exists = is_file($this->filepath);
                if ($this->exists) {
                    $this->timestamp = filemtime($this->filepath);
                    return true;
                }
            }
            return false;
        }
        return true;
    }

    private function loadCompiledTemplate(Smarty_Internal_Template $_smarty_tpl)
    {
        if (function_exists('opcache_invalidate') && (!function_exists('ini_get') || strlen(ini_get("opcache.restrict_api")) < 1)) {
            opcache_invalidate($this->filepath, true);
        } elseif (function_exists('apc_compile_file')) {
            apc_compile_file($this->filepath);
        }
        if (defined('HHVM_VERSION')) {
            eval('?>' . file_get_contents($this->filepath));
        } else {
            include $this->filepath;
        }
    }

    public function read(Smarty_Internal_Template $_template)
    {
        if (!$_template->source->handler->recompiled) {
            return file_get_contents($this->filepath);
        }
        return isset($this->content) ? $this->content : false;
    }
}