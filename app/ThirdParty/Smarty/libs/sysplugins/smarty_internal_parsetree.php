<?php

abstract class Smarty_Internal_ParseTree
{
    public $data;
    public $subtrees = array();

    abstract public function to_smarty_php(Smarty_Internal_Templateparser $parser);

    public function __destruct()
    {
        $this->data = null;
        $this->subtrees = null;
    }
}