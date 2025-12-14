<?php

class Smarty_Internal_Compile_Shared_Inheritance extends Smarty_Internal_CompileBase
{
    public static function postCompile(Smarty_Internal_TemplateCompilerBase $compiler, $initChildSequence = false)
    {
        $compiler->prefixCompiledCode .= "<?php \$_smarty_tpl->_loadInheritance();\n\$_smarty_tpl->inheritance->init(\$_smarty_tpl, " . var_export($initChildSequence, true) . ");\n?>\n";
    }

    public function registerInit(Smarty_Internal_TemplateCompilerBase $compiler, $initChildSequence = false)
    {
        if ($initChildSequence || !isset($compiler->_cache['inheritanceInit'])) {
            $compiler->registerPostCompileCallback(array('Smarty_Internal_Compile_Shared_Inheritance', 'postCompile'), array($initChildSequence), 'inheritanceInit', $initChildSequence);
            $compiler->_cache['inheritanceInit'] = true;
        }
    }
}