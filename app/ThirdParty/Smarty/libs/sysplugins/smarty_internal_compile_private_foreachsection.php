<?php

class Smarty_Internal_Compile_Private_ForeachSection extends Smarty_Internal_CompileBase
{
    public $tagName = '';
    public $nameProperties = array();
    public $itemProperties = null;
    public $isNamed = true;
    public $matchResults = array();
    private $propertyPreg = '';
    private $resultOffsets = array();
    private $startOffset = 0;

    public function scanForProperties($attributes, Smarty_Internal_TemplateCompilerBase $compiler)
    {
        $this->propertyPreg = '~(';
        $this->startOffset = 1;
        $this->resultOffsets = array();
        $this->matchResults = array('named' => array(), 'item' => array());
        if (isset($attributes['name'])) {
            $this->buildPropertyPreg(true, $attributes);
        }
        if (isset($this->itemProperties)) {
            if ($this->isNamed) {
                $this->propertyPreg .= '|';
            }
            $this->buildPropertyPreg(false, $attributes);
        }
        $this->propertyPreg .= ')\W~i';
        $this->matchTemplateSource($compiler);
        $this->matchParentTemplateSource($compiler);
        $this->matchBlockSource($compiler);
    }

    public function buildPropertyPreg($named, $attributes)
    {
        if ($named) {
            $this->resultOffsets['named'] = $this->startOffset = $this->startOffset + 3;
            $this->propertyPreg .= "(([\$]smarty[.]{$this->tagName}[.]" . ($this->tagName === 'section' ? "|[\[]\s*" : '') . "){$attributes['name']}[.](";
            $properties = $this->nameProperties;
        } else {
            $this->resultOffsets['item'] = $this->startOffset = $this->startOffset + 2;
            $this->propertyPreg .= "([\$]{$attributes['item']}[@](";
            $properties = $this->itemProperties;
        }
        $propName = reset($properties);
        while ($propName) {
            $this->propertyPreg .= "{$propName}";
            $propName = next($properties);
            if ($propName) {
                $this->propertyPreg .= '|';
            }
        }
        $this->propertyPreg .= '))';
    }

    public function matchProperty($source)
    {
        preg_match_all($this->propertyPreg, $source, $match);
        foreach ($this->resultOffsets as $key => $offset) {
            foreach ($match[$offset] as $m) {
                if (!empty($m)) {
                    $this->matchResults[$key][smarty_strtolower_ascii($m)] = true;
                }
            }
        }
    }

    public function matchTemplateSource(Smarty_Internal_TemplateCompilerBase $compiler)
    {
        $this->matchProperty($compiler->parser->lex->data);
    }

    public function matchParentTemplateSource(Smarty_Internal_TemplateCompilerBase $compiler)
    {
        $nextCompiler = $compiler;
        while ($nextCompiler !== $nextCompiler->parent_compiler) {
            $nextCompiler = $nextCompiler->parent_compiler;
            if ($compiler !== $nextCompiler) {
                $_content = $nextCompiler->template->source->getContent();
                if ($_content !== '') {
                    if ((isset($nextCompiler->smarty->autoload_filters['pre']) || isset($nextCompiler->smarty->registered_filters['pre']))) {
                        $_content = $nextCompiler->smarty->ext->_filterHandler->runFilter('pre', $_content, $nextCompiler->template);
                    }
                    $this->matchProperty($_content);
                }
            }
        }
    }

    public function matchBlockSource(Smarty_Internal_TemplateCompilerBase $compiler)
    {
    }

    public function compileSpecialVariable($args, Smarty_Internal_TemplateCompilerBase $compiler, $parameter)
    {
        $tag = smarty_strtolower_ascii(trim($parameter[0], '"\''));
        $name = isset($parameter[1]) ? $compiler->getId($parameter[1]) : false;
        if (!$name) {
            $compiler->trigger_template_error("missing or illegal \$smarty.{$tag} name attribute", null, true);
        }
        $property = isset($parameter[2]) ? smarty_strtolower_ascii($compiler->getId($parameter[2])) : false;
        if (!$property || !in_array($property, $this->nameProperties)) {
            $compiler->trigger_template_error("missing or illegal \$smarty.{$tag} property attribute", null, true);
        }
        $tagVar = "'__smarty_{$tag}_{$name}'";
        return "(isset(\$_smarty_tpl->tpl_vars[{$tagVar}]->value['{$property}']) ? \$_smarty_tpl->tpl_vars[{$tagVar}]->value['{$property}'] : null)";
    }
}