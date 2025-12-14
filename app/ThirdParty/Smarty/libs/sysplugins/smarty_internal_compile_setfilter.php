<?php

class Smarty_Internal_Compile_Setfilter extends Smarty_Internal_CompileBase
{
    public function compile($args, Smarty_Internal_TemplateCompilerBase $compiler, $parameter)
    {
        $compiler->variable_filter_stack[] = $compiler->variable_filters;
        $compiler->variable_filters = $parameter['modifier_list'];
        $compiler->has_code = false;
        return true;
    }
}

class Smarty_Internal_Compile_Setfilterclose extends Smarty_Internal_CompileBase
{
    public function compile($args, Smarty_Internal_TemplateCompilerBase $compiler)
    {
        $_attr = $this->getAttributes($compiler, $args);
        if (count($compiler->variable_filter_stack)) {
            $compiler->variable_filters = array_pop($compiler->variable_filter_stack);
        } else {
            $compiler->variable_filters = array();
        }
        $compiler->has_code = false;
        return true;
    }
}