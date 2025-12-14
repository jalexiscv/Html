<?php

class Smarty_Internal_Compile_Rdelim extends Smarty_Internal_Compile_Ldelim
{
    public function compile($args, Smarty_Internal_TemplateCompilerBase $compiler)
    {
        parent::compile($args, $compiler);
        return $compiler->smarty->right_delimiter;
    }
}