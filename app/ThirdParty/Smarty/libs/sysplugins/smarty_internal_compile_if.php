<?php

class Smarty_Internal_Compile_If extends Smarty_Internal_CompileBase
{
    public function compile($args, Smarty_Internal_TemplateCompilerBase $compiler, $parameter)
    {
        $_attr = $this->getAttributes($compiler, $args);
        $this->openTag($compiler, 'if', array(1, $compiler->nocache));
        $compiler->nocache = $compiler->nocache | $compiler->tag_nocache;
        if (!isset($parameter['if condition'])) {
            $compiler->trigger_template_error('missing if condition', null, true);
        }
        if (is_array($parameter['if condition'])) {
            if (is_array($parameter['if condition']['var'])) {
                $var = $parameter['if condition']['var']['var'];
            } else {
                $var = $parameter['if condition']['var'];
            }
            if ($compiler->nocache) {
                $compiler->setNocacheInVariable($var);
            }
            $prefixVar = $compiler->getNewPrefixVariable();
            $_output = "<?php {$prefixVar} = {$parameter[ 'if condition' ][ 'value' ]};?>\n";
            $assignAttr = array();
            $assignAttr[]['value'] = $prefixVar;
            $assignCompiler = new Smarty_Internal_Compile_Assign();
            if (is_array($parameter['if condition']['var'])) {
                $assignAttr[]['var'] = $parameter['if condition']['var']['var'];
                $_output .= $assignCompiler->compile($assignAttr, $compiler, array('smarty_internal_index' => $parameter['if condition']['var']['smarty_internal_index']));
            } else {
                $assignAttr[]['var'] = $parameter['if condition']['var'];
                $_output .= $assignCompiler->compile($assignAttr, $compiler, array());
            }
            $_output .= "<?php if ({$prefixVar}) {?>";
            return $_output;
        } else {
            return "<?php if ({$parameter['if condition']}) {?>";
        }
    }
}

class Smarty_Internal_Compile_Else extends Smarty_Internal_CompileBase
{
    public function compile($args, Smarty_Internal_TemplateCompilerBase $compiler)
    {
        list($nesting, $compiler->tag_nocache) = $this->closeTag($compiler, array('if', 'elseif'));
        $this->openTag($compiler, 'else', array($nesting, $compiler->tag_nocache));
        return '<?php } else { ?>';
    }
}

class Smarty_Internal_Compile_Elseif extends Smarty_Internal_CompileBase
{
    public function compile($args, Smarty_Internal_TemplateCompilerBase $compiler, $parameter)
    {
        $_attr = $this->getAttributes($compiler, $args);
        list($nesting, $compiler->tag_nocache) = $this->closeTag($compiler, array('if', 'elseif'));
        if (!isset($parameter['if condition'])) {
            $compiler->trigger_template_error('missing elseif condition', null, true);
        }
        $assignCode = '';
        $var = '';
        if (is_array($parameter['if condition'])) {
            $condition_by_assign = true;
            if (is_array($parameter['if condition']['var'])) {
                $var = $parameter['if condition']['var']['var'];
            } else {
                $var = $parameter['if condition']['var'];
            }
            if ($compiler->nocache) {
                $compiler->setNocacheInVariable($var);
            }
            $prefixVar = $compiler->getNewPrefixVariable();
            $assignCode = "<?php {$prefixVar} = {$parameter[ 'if condition' ][ 'value' ]};?>\n";
            $assignCompiler = new Smarty_Internal_Compile_Assign();
            $assignAttr = array();
            $assignAttr[]['value'] = $prefixVar;
            if (is_array($parameter['if condition']['var'])) {
                $assignAttr[]['var'] = $parameter['if condition']['var']['var'];
                $assignCode .= $assignCompiler->compile($assignAttr, $compiler, array('smarty_internal_index' => $parameter['if condition']['var']['smarty_internal_index']));
            } else {
                $assignAttr[]['var'] = $parameter['if condition']['var'];
                $assignCode .= $assignCompiler->compile($assignAttr, $compiler, array());
            }
        } else {
            $condition_by_assign = false;
        }
        $prefixCode = $compiler->getPrefixCode();
        if (empty($prefixCode)) {
            if ($condition_by_assign) {
                $this->openTag($compiler, 'elseif', array($nesting + 1, $compiler->tag_nocache));
                $_output = $compiler->appendCode("<?php } else {\n?>", $assignCode);
                return $compiler->appendCode($_output, "<?php if ({$prefixVar}) {?>");
            } else {
                $this->openTag($compiler, 'elseif', array($nesting, $compiler->tag_nocache));
                return "<?php } elseif ({$parameter['if condition']}) {?>";
            }
        } else {
            $_output = $compiler->appendCode("<?php } else {\n?>", $prefixCode);
            $this->openTag($compiler, 'elseif', array($nesting + 1, $compiler->tag_nocache));
            if ($condition_by_assign) {
                $_output = $compiler->appendCode($_output, $assignCode);
                return $compiler->appendCode($_output, "<?php if ({$prefixVar}) {?>");
            } else {
                return $compiler->appendCode($_output, "<?php if ({$parameter['if condition']}) {?>");
            }
        }
    }
}

class Smarty_Internal_Compile_Ifclose extends Smarty_Internal_CompileBase
{
    public function compile($args, Smarty_Internal_TemplateCompilerBase $compiler)
    {
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }
        list($nesting, $compiler->nocache) = $this->closeTag($compiler, array('if', 'else', 'elseif'));
        $tmp = '';
        for ($i = 0; $i < $nesting; $i++) {
            $tmp .= '}';
        }
        return "<?php {$tmp}?>";
    }
}