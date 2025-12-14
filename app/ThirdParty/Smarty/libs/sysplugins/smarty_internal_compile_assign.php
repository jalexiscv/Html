<?php

class Smarty_Internal_Compile_Assign extends Smarty_Internal_CompileBase
{
    public $option_flags = array('nocache', 'noscope');
    public $valid_scopes = array('local' => Smarty::SCOPE_LOCAL, 'parent' => Smarty::SCOPE_PARENT, 'root' => Smarty::SCOPE_ROOT, 'global' => Smarty::SCOPE_GLOBAL, 'tpl_root' => Smarty::SCOPE_TPL_ROOT, 'smarty' => Smarty::SCOPE_SMARTY);

    public function compile($args, Smarty_Internal_TemplateCompilerBase $compiler, $parameter)
    {
        $this->required_attributes = array('var', 'value');
        $this->shorttag_order = array('var', 'value');
        $this->optional_attributes = array('scope');
        $this->mapCache = array();
        $_nocache = false;
        $_attr = $this->getAttributes($compiler, $args);
        if ($_var = $compiler->getId($_attr['var'])) {
            $_var = "'{$_var}'";
        } else {
            $_var = $_attr['var'];
        }
        if ($compiler->tag_nocache || $compiler->nocache) {
            $_nocache = true;
            $compiler->setNocacheInVariable($_attr['var']);
        }
        if ($_attr['noscope']) {
            $_scope = -1;
        } else {
            $_scope = $compiler->convertScope($_attr, $this->valid_scopes);
        }
        $_params = '';
        if ($_nocache || $_scope) {
            $_params .= ' ,' . var_export($_nocache, true);
        }
        if ($_scope) {
            $_params .= ' ,' . $_scope;
        }
        if (isset($parameter['smarty_internal_index'])) {
            $output = "<?php \$_tmp_array = isset(\$_smarty_tpl->tpl_vars[{$_var}]) ? \$_smarty_tpl->tpl_vars[{$_var}]->value : array();\n";
            $output .= "if (!(is_array(\$_tmp_array) || \$_tmp_array instanceof ArrayAccess)) {\n";
            $output .= "settype(\$_tmp_array, 'array');\n";
            $output .= "}\n";
            $output .= "\$_tmp_array{$parameter['smarty_internal_index']} = {$_attr['value']};\n";
            $output .= "\$_smarty_tpl->_assignInScope({$_var}, \$_tmp_array{$_params});?>";
        } else {
            $output = "<?php \$_smarty_tpl->_assignInScope({$_var}, {$_attr['value']}{$_params});?>";
        }
        return $output;
    }
}