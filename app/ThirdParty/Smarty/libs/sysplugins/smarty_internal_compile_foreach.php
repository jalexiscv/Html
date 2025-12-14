<?php

class Smarty_Internal_Compile_Foreach extends Smarty_Internal_Compile_Private_ForeachSection
{
    public $required_attributes = array('from', 'item');
    public $optional_attributes = array('name', 'key', 'properties');
    public $shorttag_order = array('from', 'item', 'key', 'name');
    public $counter = 0;
    public $tagName = 'foreach';
    public $nameProperties = array('first', 'last', 'index', 'iteration', 'show', 'total');
    public $itemProperties = array('first', 'last', 'index', 'iteration', 'show', 'total', 'key');
    public $isNamed = false;

    public function compile($args, Smarty_Internal_TemplateCompilerBase $compiler)
    {
        $compiler->loopNesting++;
        $this->isNamed = false;
        $_attr = $this->getAttributes($compiler, $args);
        $from = $_attr['from'];
        $item = $compiler->getId($_attr['item']);
        if ($item === false) {
            $item = $compiler->getVariableName($_attr['item']);
        }
        $key = $name = null;
        $attributes = array('item' => $item);
        if (isset($_attr['key'])) {
            $key = $compiler->getId($_attr['key']);
            if ($key === false) {
                $key = $compiler->getVariableName($_attr['key']);
            }
            $attributes['key'] = $key;
        }
        if (isset($_attr['name'])) {
            $this->isNamed = true;
            $name = $attributes['name'] = $compiler->getId($_attr['name']);
        }
        foreach ($attributes as $a => $v) {
            if ($v === false) {
                $compiler->trigger_template_error("'{$a}' attribute/variable has illegal value", null, true);
            }
        }
        $fromName = $compiler->getVariableName($_attr['from']);
        if ($fromName) {
            foreach (array('item', 'key') as $a) {
                if (isset($attributes[$a]) && $attributes[$a] === $fromName) {
                    $compiler->trigger_template_error("'{$a}' and 'from' may not have same variable name '{$fromName}'", null, true);
                }
            }
        }
        $itemVar = "\$_smarty_tpl->tpl_vars['{$item}']";
        $local = '$__foreach_' . $attributes['item'] . '_' . $this->counter++ . '_';
        $itemAttr = array();
        $namedAttr = array();
        $this->scanForProperties($attributes, $compiler);
        if (!empty($this->matchResults['item'])) {
            $itemAttr = $this->matchResults['item'];
        }
        if (!empty($this->matchResults['named'])) {
            $namedAttr = $this->matchResults['named'];
        }
        if (isset($_attr['properties']) && preg_match_all('/[\'](.*?)[\']/', $_attr['properties'], $match)) {
            foreach ($match[1] as $prop) {
                if (in_array($prop, $this->itemProperties)) {
                    $itemAttr[$prop] = true;
                } else {
                    $compiler->trigger_template_error("Invalid property '{$prop}'", null, true);
                }
            }
            if ($this->isNamed) {
                foreach ($match[1] as $prop) {
                    if (in_array($prop, $this->nameProperties)) {
                        $nameAttr[$prop] = true;
                    } else {
                        $compiler->trigger_template_error("Invalid property '{$prop}'", null, true);
                    }
                }
            }
        }
        if (isset($itemAttr['first'])) {
            $itemAttr['index'] = true;
        }
        if (isset($namedAttr['first'])) {
            $namedAttr['index'] = true;
        }
        if (isset($namedAttr['last'])) {
            $namedAttr['iteration'] = true;
            $namedAttr['total'] = true;
        }
        if (isset($itemAttr['last'])) {
            $itemAttr['iteration'] = true;
            $itemAttr['total'] = true;
        }
        if (isset($namedAttr['show'])) {
            $namedAttr['total'] = true;
        }
        if (isset($itemAttr['show'])) {
            $itemAttr['total'] = true;
        }
        $keyTerm = '';
        if (isset($attributes['key'])) {
            $keyTerm = "\$_smarty_tpl->tpl_vars['{$key}']->value => ";
        }
        if (isset($itemAttr['key'])) {
            $keyTerm = "{$itemVar}->key => ";
        }
        if ($this->isNamed) {
            $foreachVar = "\$_smarty_tpl->tpl_vars['__smarty_foreach_{$attributes['name']}']";
        }
        $needTotal = isset($itemAttr['total']);
        $this->openTag($compiler, 'foreach', array('foreach', $compiler->nocache, $local, $itemVar, empty($itemAttr) ? 1 : 2));
        $compiler->nocache = $compiler->nocache | $compiler->tag_nocache;
        $output = "<?php\n";
        $output .= "\$_from = \$_smarty_tpl->smarty->ext->_foreach->init(\$_smarty_tpl, $from, " . var_export($item, true);
        if ($name || $needTotal || $key) {
            $output .= ', ' . var_export($needTotal, true);
        }
        if ($name || $key) {
            $output .= ', ' . var_export($key, true);
        }
        if ($name) {
            $output .= ', ' . var_export($name, true) . ', ' . var_export($namedAttr, true);
        }
        $output .= ");\n";
        if (isset($itemAttr['show'])) {
            $output .= "{$itemVar}->show = ({$itemVar}->total > 0);\n";
        }
        if (isset($itemAttr['iteration'])) {
            $output .= "{$itemVar}->iteration = 0;\n";
        }
        if (isset($itemAttr['index'])) {
            $output .= "{$itemVar}->index = -1;\n";
        }
        $output .= "{$itemVar}->do_else = true;\n";
        $output .= "if (\$_from !== null) foreach (\$_from as {$keyTerm}{$itemVar}->value) {\n";
        $output .= "{$itemVar}->do_else = false;\n";
        if (isset($attributes['key']) && isset($itemAttr['key'])) {
            $output .= "\$_smarty_tpl->tpl_vars['{$key}']->value = {$itemVar}->key;\n";
        }
        if (isset($itemAttr['iteration'])) {
            $output .= "{$itemVar}->iteration++;\n";
        }
        if (isset($itemAttr['index'])) {
            $output .= "{$itemVar}->index++;\n";
        }
        if (isset($itemAttr['first'])) {
            $output .= "{$itemVar}->first = !{$itemVar}->index;\n";
        }
        if (isset($itemAttr['last'])) {
            $output .= "{$itemVar}->last = {$itemVar}->iteration === {$itemVar}->total;\n";
        }
        if (isset($foreachVar)) {
            if (isset($namedAttr['iteration'])) {
                $output .= "{$foreachVar}->value['iteration']++;\n";
            }
            if (isset($namedAttr['index'])) {
                $output .= "{$foreachVar}->value['index']++;\n";
            }
            if (isset($namedAttr['first'])) {
                $output .= "{$foreachVar}->value['first'] = !{$foreachVar}->value['index'];\n";
            }
            if (isset($namedAttr['last'])) {
                $output .= "{$foreachVar}->value['last'] = {$foreachVar}->value['iteration'] === {$foreachVar}->value['total'];\n";
            }
        }
        if (!empty($itemAttr)) {
            $output .= "{$local}saved = {$itemVar};\n";
        }
        $output .= '?>';
        return $output;
    }

    public function compileRestore($levels)
    {
        return "\$_smarty_tpl->smarty->ext->_foreach->restore(\$_smarty_tpl, {$levels});";
    }
}

class Smarty_Internal_Compile_Foreachelse extends Smarty_Internal_CompileBase
{
    public function compile($args, Smarty_Internal_TemplateCompilerBase $compiler)
    {
        $_attr = $this->getAttributes($compiler, $args);
        list($openTag, $nocache, $local, $itemVar, $restore) = $this->closeTag($compiler, array('foreach'));
        $this->openTag($compiler, 'foreachelse', array('foreachelse', $nocache, $local, $itemVar, 0));
        $output = "<?php\n";
        if ($restore === 2) {
            $output .= "{$itemVar} = {$local}saved;\n";
        }
        $output .= "}\nif ({$itemVar}->do_else) {\n?>";
        return $output;
    }
}

class Smarty_Internal_Compile_Foreachclose extends Smarty_Internal_CompileBase
{
    public function compile($args, Smarty_Internal_TemplateCompilerBase $compiler)
    {
        $compiler->loopNesting--;
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }
        list($openTag, $compiler->nocache, $local, $itemVar, $restore) = $this->closeTag($compiler, array('foreach', 'foreachelse'));
        $output = "<?php\n";
        if ($restore === 2) {
            $output .= "{$itemVar} = {$local}saved;\n";
        }
        $output .= "}\n";
        $foreachCompiler = $compiler->getTagCompiler('foreach');
        $output .= $foreachCompiler->compileRestore(1);
        $output .= "?>";
        return $output;
    }
}