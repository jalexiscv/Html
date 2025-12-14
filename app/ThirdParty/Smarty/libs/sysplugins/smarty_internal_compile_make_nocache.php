<?php

class Smarty_Internal_Compile_Make_Nocache extends Smarty_Internal_CompileBase
{
    public $option_flags = array();
    public $required_attributes = array('var');
    public $shorttag_order = array('var');

    public function compile($args, Smarty_Internal_TemplateCompilerBase $compiler)
    {
        $_attr = $this->getAttributes($compiler, $args);
        if ($compiler->template->caching) {
            $output = "<?php \$_smarty_tpl->smarty->ext->_make_nocache->save(\$_smarty_tpl, {$_attr[ 'var' ]});\n?>\n";
            $compiler->template->compiled->has_nocache_code = true;
            $compiler->suppressNocacheProcessing = true;
            return $output;
        } else {
            return true;
        }
    }
}