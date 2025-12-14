<?php

class Smarty_Internal_Undefined
{
    public $class = null;

    public function __construct($class = null)
    {
        $this->class = $class;
    }

    public function decodeProperties(Smarty_Internal_Template $tpl, $properties, $cache = false)
    {
        if ($cache) {
            $tpl->cached->valid = false;
        } else {
            $tpl->mustCompile = true;
        }
        return false;
    }

    public function __call($name, $args)
    {
        if (isset($this->class)) {
            throw new SmartyException("undefined extension class '{$this->class}'");
        } else {
            throw new SmartyException(get_class($args[0]) . "->{$name}() undefined method");
        }
    }
}