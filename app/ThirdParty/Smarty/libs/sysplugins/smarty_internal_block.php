<?php

class Smarty_Internal_Block
{
    public $name = '';
    public $hide = false;
    public $append = false;
    public $prepend = false;
    public $callsChild = false;
    public $child = null;
    public $parent = null;
    public $tplIndex = 0;

    public function __construct($name, $tplIndex)
    {
        $this->name = $name;
        $this->tplIndex = $tplIndex;
    }

    public function callBlock(Smarty_Internal_Template $tpl)
    {
    }
}