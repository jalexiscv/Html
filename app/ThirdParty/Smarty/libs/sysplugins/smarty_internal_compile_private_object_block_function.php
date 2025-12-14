<?php

class Smarty_Internal_Compile_Private_Object_Block_Function extends Smarty_Internal_Compile_Private_Block_Plugin
{
    public function setup(Smarty_Internal_TemplateCompilerBase $compiler, $_attr, $tag, $method)
    {
        $_paramsArray = array();
        foreach ($_attr as $_key => $_value) {
            if (is_int($_key)) {
                $_paramsArray[] = "$_key=>$_value";
            } else {
                $_paramsArray[] = "'$_key'=>$_value";
            }
        }
        $callback = array("\$_smarty_tpl->smarty->registered_objects['{$tag}'][0]", "->{$method}");
        return array($callback, $_paramsArray, "array(\$_block_plugin{$this->nesting}, '{$method}')");
    }
}