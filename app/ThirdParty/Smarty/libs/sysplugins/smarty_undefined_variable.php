<?php

class Smarty_Undefined_Variable extends Smarty_Variable
{
    public function __get($name)
    {
        return null;
    }

    public function __toString()
    {
        return '';
    }
}