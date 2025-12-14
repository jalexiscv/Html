<?php

class Smarty_Internal_Compile_Config_Load extends Smarty_Internal_CompileBase
{
    public $required_attributes = array('file');
    public $shorttag_order = array('file', 'section');
    public $optional_attributes = array('section', 'scope');
    public $option_flags = array('nocache', 'noscope');
    public $valid_scopes = array('local' => Smarty::SCOPE_LOCAL, 'parent' => Smarty::SCOPE_PARENT, 'root' => Smarty::SCOPE_ROOT, 'tpl_root' => Smarty::SCOPE_TPL_ROOT, 'smarty' => Smarty::SCOPE_SMARTY, 'global' => Smarty::SCOPE_SMARTY);

    public function compile($args, Smarty_Internal_TemplateCompilerBase $compiler)
    {
        $_attr = $this->getAttributes($compiler, $args);
        if ($_attr['nocache'] === true) {
            $compiler->trigger_template_error('nocache option not allowed', null, true);
        }
        $conf_file = $_attr['file'];
        if (isset($_attr['section'])) {
            $section = $_attr['section'];
        } else {
            $section = 'null';
        }
        if ($_attr['noscope']) {
            $_scope = -1;
        } else {
            $_scope = $compiler->convertScope($_attr, $this->valid_scopes);
        }
        $_output = "<?php\n\$_smarty_tpl->smarty->ext->configLoad->_loadConfigFile(\$_smarty_tpl, {$conf_file}, {$section}, {$_scope});\n?>\n";
        return $_output;
    }
}