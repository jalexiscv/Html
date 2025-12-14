<?php

class Smarty_Internal_Compile_Nocache extends Smarty_Internal_CompileBase
{
    public $option_flags = array();

    public function compile($args, Smarty_Internal_TemplateCompilerBase $compiler)
    {
        $_attr = $this->getAttributes($compiler, $args);
        $this->openTag($compiler, 'nocache', array($compiler->nocache));
        $compiler->nocache = true;
        $compiler->has_code = false;
        return true;
    }
}

class Smarty_Internal_Compile_Nocacheclose extends Smarty_Internal_CompileBase
{
    public function compile($args, Smarty_Internal_TemplateCompilerBase $compiler)
    {
        $_attr = $this->getAttributes($compiler, $args);
        list($compiler->nocache) = $this->closeTag($compiler, array('nocache'));
        $compiler->has_code = false;
        return true;
    }
}