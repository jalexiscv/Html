<?php

abstract class Smarty_Resource_Recompiled extends Smarty_Resource
{
    public $recompiled = true;
    public $hasCompiledHandler = true;

    public function process(Smarty_Internal_Template $_smarty_tpl)
    {
        $compiled = &$_smarty_tpl->compiled;
        $compiled->file_dependency = array();
        $compiled->includes = array();
        $compiled->nocache_hash = null;
        $compiled->unifunc = null;
        $level = ob_get_level();
        ob_start();
        $_smarty_tpl->loadCompiler();
        try {
            eval('?>' . $_smarty_tpl->compiler->compileTemplate($_smarty_tpl));
        } catch (Exception $e) {
            unset($_smarty_tpl->compiler);
            while (ob_get_level() > $level) {
                ob_end_clean();
            }
            throw $e;
        }
        unset($_smarty_tpl->compiler);
        ob_get_clean();
        $compiled->timestamp = time();
        $compiled->exists = true;
    }

    public function populateCompiledFilepath(Smarty_Template_Compiled $compiled, Smarty_Internal_Template $_template)
    {
        $compiled->filepath = false;
        $compiled->timestamp = false;
        $compiled->exists = false;
    }

    public function checkTimestamps()
    {
        return false;
    }
}