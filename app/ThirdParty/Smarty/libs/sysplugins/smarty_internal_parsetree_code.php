<?php

class Smarty_Internal_ParseTree_Code extends Smarty_Internal_ParseTree
{
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function to_smarty_php(Smarty_Internal_Templateparser $parser)
    {
        return sprintf('(%s)', $this->data);
    }
}