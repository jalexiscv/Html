<?php

class Smarty_Internal_Compile_Capture extends Smarty_Internal_CompileBase
{
    public $shorttag_order = array('name');
    public $optional_attributes = array('name', 'assign', 'append');

    public static function compileSpecialVariable($args, Smarty_Internal_TemplateCompilerBase $compiler, $parameter = null)
    {
        return '$_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl' . (isset($parameter[1]) ? ", {$parameter[ 1 ]})" : ')');
    }

    public function compile($args, Smarty_Internal_TemplateCompilerBase $compiler, $parameter = null)
    {
        $_attr = $this->getAttributes($compiler, $args, $parameter, 'capture');
        $buffer = isset($_attr['name']) ? $_attr['name'] : "'default'";
        $assign = isset($_attr['assign']) ? $_attr['assign'] : 'null';
        $append = isset($_attr['append']) ? $_attr['append'] : 'null';
        $compiler->_cache['capture_stack'][] = array($compiler->nocache);
        $compiler->nocache = $compiler->nocache | $compiler->tag_nocache;
        $_output = "<?php \$_smarty_tpl->smarty->ext->_capture->open(\$_smarty_tpl, $buffer, $assign, $append);?>";
        return $_output;
    }
}

class Smarty_Internal_Compile_CaptureClose extends Smarty_Internal_CompileBase
{
    public function compile($args, Smarty_Internal_TemplateCompilerBase $compiler, $parameter)
    {
        $_attr = $this->getAttributes($compiler, $args, $parameter, '/capture');
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }
        list($compiler->nocache) = array_pop($compiler->_cache['capture_stack']);
        return "<?php \$_smarty_tpl->smarty->ext->_capture->close(\$_smarty_tpl);?>";
    }
}