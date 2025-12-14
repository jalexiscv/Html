<?php

class Smarty_Internal_Runtime_Inheritance
{
    public $state = 0;
    public $childRoot = array();
    public $inheritanceLevel = 0;
    public $tplIndex = -1;
    public $sources = array();
    public $sourceStack = array();

    public function init(Smarty_Internal_Template $tpl, $initChild, $blockNames = array())
    {
        if ($initChild && $this->state === 3 && (strpos($tpl->template_resource, 'extendsall') === false)) {
            $tpl->inheritance = new Smarty_Internal_Runtime_Inheritance();
            $tpl->inheritance->init($tpl, $initChild, $blockNames);
            return;
        }
        ++$this->tplIndex;
        $this->sources[$this->tplIndex] = $tpl->source;
        if ($initChild) {
            $this->state = 1;
            if (!$this->inheritanceLevel) {
                ob_start();
            }
            ++$this->inheritanceLevel;
        }
        if ($this->state === 2) {
            $this->state = 3;
        }
    }

    public function endChild(Smarty_Internal_Template $tpl, $template = null, $uid = null, $func = null)
    {
        --$this->inheritanceLevel;
        if (!$this->inheritanceLevel) {
            ob_end_clean();
            $this->state = 2;
        }
        if (isset($template) && (($tpl->parent->_isTplObj() && $tpl->parent->source->type !== 'extends') || $tpl->smarty->extends_recursion)) {
            $tpl->_subTemplateRender($template, $tpl->cache_id, $tpl->compile_id, $tpl->caching ? 9999 : 0, $tpl->cache_lifetime, array(), 2, false, $uid, $func);
        }
    }

    public function instanceBlock(Smarty_Internal_Template $tpl, $className, $name, $tplIndex = null)
    {
        $block = new $className($name, isset($tplIndex) ? $tplIndex : $this->tplIndex);
        if (isset($this->childRoot[$name])) {
            $block->child = $this->childRoot[$name];
        }
        if ($this->state === 1) {
            $this->childRoot[$name] = $block;
            return;
        }
        while ($block->child && $block->child->child && $block->tplIndex <= $block->child->tplIndex) {
            $block->child = $block->child->child;
        }
        $this->process($tpl, $block);
    }

    public function process(Smarty_Internal_Template $tpl, Smarty_Internal_Block $block, Smarty_Internal_Block $parent = null)
    {
        if ($block->hide && !isset($block->child)) {
            return;
        }
        if (isset($block->child) && $block->child->hide && !isset($block->child->child)) {
            $block->child = null;
        }
        $block->parent = $parent;
        if ($block->append && !$block->prepend && isset($parent)) {
            $this->callParent($tpl, $block, '\'{block append}\'');
        }
        if ($block->callsChild || !isset($block->child) || ($block->child->hide && !isset($block->child->child))) {
            $this->callBlock($block, $tpl);
        } else {
            $this->process($tpl, $block->child, $block);
        }
        if ($block->prepend && isset($parent)) {
            $this->callParent($tpl, $block, '{block prepend}');
            if ($block->append) {
                if ($block->callsChild || !isset($block->child) || ($block->child->hide && !isset($block->child->child))) {
                    $this->callBlock($block, $tpl);
                } else {
                    $this->process($tpl, $block->child, $block);
                }
            }
        }
        $block->parent = null;
    }

    public function callParent(Smarty_Internal_Template $tpl, Smarty_Internal_Block $block, $tag)
    {
        if (isset($block->parent)) {
            $this->callBlock($block->parent, $tpl);
        } else {
            throw new SmartyException("inheritance: illegal '{$tag}' used in child template '{$tpl->inheritance->sources[$block->tplIndex]->filepath}' block '{$block->name}'");
        }
    }

    public function callBlock(Smarty_Internal_Block $block, Smarty_Internal_Template $tpl)
    {
        $this->sourceStack[] = $tpl->source;
        $tpl->source = $this->sources[$block->tplIndex];
        $block->callBlock($tpl);
        $tpl->source = array_pop($this->sourceStack);
    }

    public function callChild(Smarty_Internal_Template $tpl, Smarty_Internal_Block $block)
    {
        if (isset($block->child)) {
            $this->process($tpl, $block->child, $block);
        }
    }
}