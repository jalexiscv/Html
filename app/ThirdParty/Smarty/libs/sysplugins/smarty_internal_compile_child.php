<?php

class Smarty_Internal_Compile_Child extends Smarty_Internal_CompileBase
{
    public $optional_attributes = array('assign');
    public $tag = 'child';
    public $blockType = 'Child';

    public function compile($args, Smarty_Internal_TemplateCompilerBase $compiler, $parameter)
    {
        $_attr = $this->getAttributes($compiler, $args);
        $tag = isset($parameter[0]) ? "'{$parameter[0]}'" : "'{{$this->tag}}'";
        if (!isset($compiler->_cache['blockNesting'])) {
            $compiler->trigger_template_error("{$tag} used outside {block} tags ", $compiler->parser->lex->taglineno);
        }
        $compiler->has_code = true;
        $compiler->suppressNocacheProcessing = true;
        if ($this->blockType === 'Child') {
            $compiler->_cache['blockParams'][$compiler->_cache['blockNesting']]['callsChild'] = 'true';
        }
        $_assign = isset($_attr['assign']) ? $_attr['assign'] : null;
        $output = "<?php \n";
        if (isset($_assign)) {
            $output .= "ob_start();\n";
        }
        $output .= '$_smarty_tpl->inheritance->call' . $this->blockType . '($_smarty_tpl, $this' . ($this->blockType === 'Child' ? '' : ", {$tag}") . ");\n";
        if (isset($_assign)) {
            $output .= "\$_smarty_tpl->assign({$_assign}, ob_get_clean());\n";
        }
        $output .= "?>\n";
        return $output;
    }
}