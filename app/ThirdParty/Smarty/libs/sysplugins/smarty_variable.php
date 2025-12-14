<?php

#[\AllowDynamicProperties] class Smarty_Variable
{
    public $value = null;
    public $nocache = false;

    public function __construct($value = null, $nocache = false)
    {
        $this->value = $value;
        $this->nocache = $nocache;
    }

    public function __toString()
    {
        return (string)$this->value;
    }
}